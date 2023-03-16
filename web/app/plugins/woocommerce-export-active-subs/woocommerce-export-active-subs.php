<?php
/*
Plugin Name: Woocommerce Export Active Subscriptions
Description: Lets you export all active and pending cancel subscriptions at the click of a button
Version: 0.3
Author: Will from BMAS
License: GPL2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( ! is_admin() ) {
    return;
}

/**
 * Main class
 */
class WEAS
{
    /**
     * @var mixed
     */
    private static $instance;

    public static function instance()
    {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function __construct()
    {
        $this->hooks();
    }

    public function hooks()
    {
        add_action( 'woocommerce_init', [$this, 'generate'] );
        add_action( 'admin_menu', [$this, 'registerAdminPage'] );
    }

    /**
     * @return mixed
     */
    public function getSubs()
    {

        //specifying the post status in the query would not filter out the cancelled or on hold posts, so using array filter to remove them after the query.
        $subs = get_posts( [
            'post_type'   => 'shop_subscription',
            'post_status' => ['wc-active', 'wc-pending-cancel'],
            'numberposts' => -1,
        ] );

        // $subs = array_values( array_filter( $current_subs, function ( $p ) {
        //     return in_array( $p->post_status, ['wc-active', 'wc-pending-cancel'] );
        // } ) );

        //populate each subscription post object with the correct meta data
        foreach ( $subs as &$post ) {
            $meta                            = get_post_meta( $post->ID );
            $order                           = wc_get_order( $post->ID );
            $order_data                      = $order->get_data();
            $products                        = array_values( $order->get_items() );
            $post->product                   = $products[0];
            $post->customer                  = get_user_meta( $order->get_user_id() );
            $post->customer['customer_note'] = [$order_data['customer_note']];
            $post->customer['billing_email'] = [$order_data['billing']['email']];
        }

        return $subs;
    }

    /**
     * @return mixed
     */
    public function getOrders()
    {

        $args = [
            'post_type'      => 'shop_order',
            'post_status'    => 'any',
            'posts_per_page' => -1
        ];

        $orders = get_posts( $args );

        return $orders;
    }

    public function generate()
    {
        //only fire the function if the request has been made
        if ( isset( $_GET['generate_csv'] ) ) {

            add_action( 'init', function () {
                require ( __DIR__ . '/weas-generate.php' );
            } );

        }

        if ( isset( $_GET['generate_csv_order'] ) ) {

            add_action( 'init', function () {
                require ( __DIR__ . '/weas-generate-orders.php' );
            } );

        }
    }

    public function registerAdminPage()
    {
        require 'weas-admin.php';
    }

}

//Main class instance
function weas()
{
    return WEAS::instance();
}

$GLOBALS['weas'] = weas();
