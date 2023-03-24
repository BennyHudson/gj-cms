<?php
/**
 * Woocommerce Base
 * --------
 * @category Woocommerce
 * @version 1.0
 * @package Lydia
 */
namespace BMAS\Woocommerce;

defined( 'ABSPATH' ) || exit;


class Base
{

    public function __construct()
    {
        $this->add_actions();
        $this->add_filters();
    }

    public function add_actions()
    {
        add_action( 'after_setup_theme', [__CLASS__, 'add_support'] );
    }

    public function add_filters()
    {
        self::remove_features();
        self::remove_styles();
        self::remove_sidebar();
        add_filter( 'woocommerce_allow_marketplace_suggestions', '__return_false' );
        add_filter( 'woocommerce_price_trim_zeros', '__return_true' );
        add_filter( 'woocommerce_marketing_menu_items', function ( $pages ) {return [];} );

    }

    public static function add_support()
    {
        add_theme_support( 'woocommerce' );
    }

    public static function remove_features()
    {
        remove_theme_support( 'wc-product-gallery-zoom' );
        remove_theme_support( 'wc-product-gallery-lightbox' );
        remove_theme_support( 'wc-product-gallery-slider' );
    }

    public static function remove_styles()
    {
        add_filter( 'woocommerce_enqueue_styles', '__return_false' );
    }

    public static function remove_sidebar()
    {
        remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
    }
}
