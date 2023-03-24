<?php
/**
 * Scripts
 * --------
 *
 * @category Assets
 * @version 1.0
 * @package BMAS
 */
namespace BMAS\Assets;

defined( 'ABSPATH' ) || exit;

class Scripts
{
    public function __construct()
    {
        $this->add_actions();
        $this->add_filters();
    }

    /**
     * Add Actions Hooks
     *
     * @return void
     */
    public static function add_actions() {
        add_action( 'wp_enqueue_scripts', [__CLASS__, 'lydia_jquery'], 10);
        add_action( 'wp_enqueue_scripts', [__CLASS__, 'lydia_js'], 10 );
    }

    /**
     * Add Filters Hooks
     *
     * @return void
     */
    public static function add_filters() {
        add_filter( 'script_loader_tag', [__CLASS__, 'defer_and_async_scripts'], 10, 3 );
    }


 /**
     * Add Lydia JS to Frontend
     *
     * @return void
     */
    public static function lydia_js()
    {

        wp_enqueue_script(
            'lydia-legacy-js',
            get_template_directory_uri() . '/main-legacy.min.js',
            ['jquery'],
            filemtime( get_stylesheet_directory() . '/main-legacy.min.js' ),
            true
        );

        wp_enqueue_script(
            'lydia-js',
            get_template_directory_uri() . '/main.min.js',
            ['jquery', 'google-admanager'],
            filemtime( get_stylesheet_directory() . '/main.min.js' ),
            true
        );

        global $wp_query;

        if ( isset($wp_query->get_queried_object()->term_id) ) {
            $termID = $wp_query->get_queried_object()->term_id;
        } else {
            $termID = '';
        }

        // Localise Scripts
        wp_localize_script( 'lydia-legacy-js', 'site', [
            'ajax' => \BMAS\Util\AjaxPost::get_ajax_data(),
            'url'  => get_bloginfo( 'url' ),
            'path' => get_bloginfo( 'template_directory' ),
            'termID' => $termID,
            'query'   => [
                'current' => json_encode( $wp_query->query ),
                'main'    => json_encode( array_filter( $wp_query->query_vars ) )
            ],
            'archive' => [
                'current_page' => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
                'max_page'     => $wp_query->max_num_pages
            ]
        ] );
    }

   /**
     * Replace Worpdress JQuery
     *
     * @return void
     */
    public static function lydia_jquery()
    {
        wp_deregister_script( 'jquery' );
        wp_deregister_script( 'jquery-core' );
        wp_register_script( 'jquery', false, ['jquery-core'], null, false );

        wp_register_script( 'jquery-core', '//ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js', [], false, false );
        wp_enqueue_script( 'jquery-core' );
    }


        /**
     * @param $tag
     * @param $handle
     * @param $src
     * @return mixed
     */
    public static function defer_and_async_scripts(
        $tag,
        $handle,
        $src
    ) {

        if ($handle == 'google-admanager') {
            # code...
            if ( false === stripos( $tag, 'async' ) ) {
                $tag = str_replace( ' src', ' async="async" src', $tag );
            }
            if ( false === stripos( $tag, 'defer' ) ) {
                $tag = str_replace( '<script ', '<script defer ', $tag );
            }
        }

        return $tag;
    }
}
