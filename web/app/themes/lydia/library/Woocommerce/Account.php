<?php
/**
 * Yoast Breadcrumbs adjustments
 * --------
 * @category Vendor
 * @version 1.0
 * @package Lydia
 */

namespace BMAS\Woocommerce;

defined('ABSPATH') || exit;

use Timber as Timber;


class Account
{

    /**
     * The Constructor.
     */
    public function __construct()
    {

        $this->remove_actions();
        $this->add_actions();
        $this->add_filters();

    }

    /**
     * Remove Woo actions
     */
    public static function remove_actions()
    {

        // remove_action( 'woocommerce_account_navigation', 'woocommerce_account_navigation', 10 );

    }

    /**
     * Add Woo actions
     */
    public static function add_actions()
    {

        add_action( 'wp_print_scripts', [__CLASS__, 'remove_password_strength'], 10 );
        add_action( 'woocommerce_customer_reset_password', [__CLASS__, 'reset_password_redirect'], 10 );

        add_action( 'user_register', [__CLASS__, 'set_default_display_name'], 30 );

        add_action( 'init', [__CLASS__, 'add_account_endpoints'], 10 );

        add_action( 'template_redirect', [__CLASS__, 'members_endpoint_hooks'], 10 );

    }

    /**
     * Add filters
     */
    public static function add_filters()
    {

        add_filter( 'body_class', [__CLASS__, 'body_class'], 10 );
        add_filter( 'woocommerce_account_menu_items', [__CLASS__, 'woo_acount_menu_items'], 10, 1 );
        add_filter( 'woocommerce_login_redirect', [__CLASS__, 'woo_redirect_login'], 10, 2 );
    }

    /**
     * Add body class
     */
    public static function body_class( $classes )
    {

        if ( is_account_page() && ! is_wc_endpoint_url() && ! self::is_endpoint() ) {
            $classes[] = 'woocommerce-account-dashboard';
        }

        return $classes;

    }

    public static function woo_redirect_login( $redirect, $user) {

        $redirect_page_id = url_to_postid( $redirect );
        $checkout_page_id = wc_get_page_id( 'checkout' );

        if( $redirect_page_id == $checkout_page_id ) {
            return $redirect;
        }

        return wc_get_endpoint_url( 'members-only', '',  wc_get_page_permalink( 'myaccount' ));
    }



    public static function woo_acount_menu_items( $items ) {

        $items = [
            'members-only'      => __( 'Members Content', 'woocommerce' ),
            'subscriptions'     => __( 'Subscriptions', 'woocommerce' ),
            'orders'            => __( 'Orders', 'woocommerce' ),
            'edit-address'      => __( 'Addresses', 'woocommerce' ),
            'payment-methods'   => __( 'Payment Methods', 'woocommerce' ),
            'edit-account'      => __( 'Edit Acccount', 'woocommerce' ),
            'customer-logout'   => __( 'Logout', 'woocommerce' ),
        ];

        return $items;

    }

    /**
     * Set default display name to first name
     */
    public static function set_default_display_name( $user_id )
    {
        $user = get_userdata( $user_id );
        $name = sprintf( '%s', $user->first_name );
        $args = [
            'ID'           => $user_id,
            'display_name' => $name,
            'nickname'     => $name
        ];
        wp_update_user( $args );
    }

    /**
     * Add custom endpoints
     */
    public static function add_account_endpoints()
    {

        foreach ( self::get_endpoints() as $endpoint ) {
            add_rewrite_endpoint( $endpoint, EP_PAGES );
        }

    }

    /**
     * Get endpoints
     */
    public static function get_endpoints()
    {

        return [
            'members-only',
        ];

    }

    /**
     * Helper: is endpoint
     */
    public static function is_endpoint( $endpoint = false )
    {

        global $wp_query;

        if ( ! $wp_query ) {
            return false;
        }

        if ( ! $endpoint ) {

            foreach ( self::get_endpoints() as $endpoint ) {
                if ( isset( $wp_query->query[$endpoint] ) ) {
                    return true;
                }

            }

            return false;

        }

        return isset( $wp_query->query[$endpoint] );

    }

    /* $. Endpoint Content
    \*----------------------------------------------------------------*/

    /**
     * Download Documents
     */
    public static function members_endpoint_hooks()
    {

        if ( ! self::is_endpoint( 'members-only' ) ) {
            return;
        }

        remove_action( 'woocommerce_account_content', 'woocommerce_account_content' );
        add_action( 'woocommerce_account_content', [__CLASS__, 'members_endpoint_content'], 30 );

    }

    public static function members_endpoint_content()
    {

        $context= Timber::context();
        
        $context['editorsPicks'] = new Timber\PostQuery([
            'post_type' => ['article', 'post'],
            'post_status' => 'publish',
            'numberposts' => 6,
            'tax_query' => [
                'relation' => 'AND',
                [
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => ['members'],
                ],
                [
                    'relation' => 'AND',
                    [
                        'taxonomy' => 'category',
                        'field' => 'slug',
                        'terms' => ['editors-picks'],
                    ],
                ],
            ],
        ]);

        $context['featuredPost'] = new Timber\PostQuery ([
            'post_type'     => ['article', 'post'],
            'post_status'   => 'publish',
            'numberposts'   => 1,
            'category_name' => 'members',
        ]);
        $context['firstRow'] = new Timber\PostQuery ([
            'post_type'     => ['article', 'post'],
            'post_status'   => 'publish',
            'numberposts'   => 2,
            'category_name' => 'members',
            'offset'        => 1
        ]);
        $context['secondRow'] = new Timber\PostQuery ([
            'post_type'     => ['article', 'post'],
            'post_status'   => 'publish',
            'numberposts'   => 2,
            'category_name' => 'members',
            'offset'        => 3
        ]);
        $context['posts'] = new Timber\PostQuery ([
            'post_type'     => ['article', 'post'],
            'post_status'   => 'publish',
            'numberposts'   => 9999999,
            'category_name' => 'members',
            'offset'        => 5
        ]);
        

        Timber::render('components/page/clubhouse/clubhouse-content.twig', $context);

    }

    /**
     * Get account links
     */
    public static function get_account_links()
    {

        return [
            [
                'path'   => 'members',
                'label'  => __( 'Members Content', 'six' ),
                'active' => self::is_endpoint( 'clubhouse' ),
                'roles'  => false
            ],
        ];

    }

    /**
     * Get link
     */
    public static function get_link( $endpoint = false )
    {

        $account_url = trailingslashit( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) );

        if ( $endpoint ) {
            $account_url .= $endpoint;
        }

        return $account_url;

    }

    /**
     * Remove password strength check.
     */
    public static function remove_password_strength()
    {
        wp_dequeue_script( 'wc-password-strength-meter' );
    }

    /**
     * Reset password redirect.
     *
     * @param WP_User $user
     */
    public static function reset_password_redirect( $user )
    {
        wc_add_notice( __( 'Your password has been reset successfully.', 'woocommerce' ) );
        wp_safe_redirect( wc_get_page_permalink( 'clubhouse' ) );
        exit;
    }

}
