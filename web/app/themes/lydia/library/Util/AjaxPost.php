<?php
/**
 * Ajax Post
 * --------
 * @category Util
 * @version 1.0
 * @package Lydia
 */
namespace BMAS\Util;

defined( 'ABSPATH' ) || exit;

use Timber;
use BMAS\Util\CommonHelpers;

class AjaxPost
{

    /**
     * Action hook used by the AJAX class.
     *
     * @var string
     */
    protected const ACTION = 'ajax_post';

    /**
     * Action argument used by the nonce validating the AJAX request.
     *
     * @var string
     */
    protected const NONCE = 'ajax-post';

    /**
     * Register the AJAX handler class with all the appropriate WordPress hooks.
     */
    public static function register()
    {
        $handler = new self();

        add_action( 'wp_ajax_' . self::ACTION, [$handler, 'handle'] );
        add_action( 'wp_ajax_nopriv_' . self::ACTION, [$handler, 'handle'] );
    }

    /**
     * Handles the AJAX request
     */
    public static function handle()
    {

        // Make sure we are getting a valid AJAX request
        check_ajax_referer( self::NONCE, 'security' );

        self::get_posts();

        wp_die();
    }

    /**
     * @return mixed
     */
    private static function get_posts()
    {

        $arguments = self::get_arguments();
        $order     = self::get_order();
        $args      = array_merge( $arguments, $order );

        // Get and send the posts back
        $posts = new Timber\PostQuery( $args );

        if ( ! empty( $posts ) ) {
            $posts = self::get_template( $posts );
        }

        wp_send_json( self::check_if_empty_and_return( $posts ) );
    }

    /**
     * @param $posts
     */
    private static function get_template( $posts )
    {

        $name     = $_POST['args']['template'];
        $template = $name ? $name : 'post';

        $context['posts']    = $posts;
        $context['template'] = $template;

        $output = Timber::compile( 'components/post/post-ajax.twig', $context );

        return CommonHelpers::minify( $output );
    }

    /**
     * @return mixed
     */
    private static function get_arguments()
    {
        // Get the options that are passed by the button
        $options = $_POST['args'];

        // Set the arguments
        $args = [
            'post_type'   => 'post',
            'post_status' => 'publish'
        ];

        if ( isset( $options['numberposts'] ) ) {
            $args['numberposts'] = intval( $options['numberposts'] );
        }

        if ( isset( $options['offset'] ) ) {
            $args['offset'] = intval( $options['offset'] );
        }

        if ( isset( $options['cat'] ) ) {
            $args['cat'] = intval( $options['cat'] );
        }

        if ( isset( $options['search'] ) ) {
            $args['s'] = strval( $options['search'] );
        }

        if ( isset( $options['paged'] ) ) {
            $args['paged'] = intval( $options['paged'] ) + 1;
        }

        return $args;
    }

    /**
     * @return mixed
     */
    private static function get_order()
    {

        $args = json_decode( stripslashes( $_POST['query'] ), true );

        switch ( $args['orderby'] ) {

            case 'price':
                $args['orderby']  = 'meta_value_num';
                $args['meta_key'] = '_price';
                $args['order']    = 'asc';
                break;

            case 'price-desc':
                $args['orderby']  = 'meta_value_num';
                $args['meta_key'] = '_price';
                $args['order']    = 'desc';
                break;

            case 'rating':
                $args['orderby']  = 'meta_value_num';
                $args['meta_key'] = '_wc_average_rating';
                $args['order']    = 'desc';
                break;

            case 'popularity':
                $args['orderby']  = 'meta_value_num';
                $args['meta_key'] = 'total_sales';
                $args['order']    = 'desc';
                break;

            case 'menu_order':
                $args['orderby']  = 'meta_value_num';
                $args['meta_key'] = 'total_sales';
                $args['order']    = 'desc';
                break;

            default:
                $args['orderby'] = 'menu_order title';
                $args['order']   = 'asc';
        }

        return $args;

    }

    /**
     * Get the post ID sent by the AJAX request.
     *
     * @return int
     */
    private static function get_post_id()
    {
        $post_id = 0;

        if ( isset( $_POST['post_id'] ) ) {
            $post_id = absint( filter_var( $_POST['post_id'], FILTER_SANITIZE_NUMBER_INT ) );
        }

        return $post_id;
    }

    /**
     * @param $data
     * @return mixed
     */
    private static function check_if_empty_and_return( $data )
    {

        if ( ! empty( $data ) ) {
            return $data;
        } else {
            return;
        }
    }

    /**
     * Get the AJAX data that WordPress needs to output.
     * Can be used for localzation when enqueuing js.
     *
     * @return array
     */
    public static function get_ajax_data()
    {
        global $wp_query;

        return [
            'action'  => self::ACTION,
            'nonce'   => wp_create_nonce( self::NONCE ),
            'url'     => admin_url( 'admin-ajax.php' ),
            'query'   => json_encode( $wp_query->query ),
            'archive' => [
                'current_page' => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
                'max_page'     => $wp_query->max_num_pages
            ]
        ];
    }

    /**
     * Sends a JSON response with the details of the given error.
     *
     * @param WP_Error $error
     */
    private static function send_error( \WP_Error $error )
    {
        wp_send_json( [
            'code'    => $error->get_error_code(),
            'message' => $error->get_error_message()
        ] );
    }

}
