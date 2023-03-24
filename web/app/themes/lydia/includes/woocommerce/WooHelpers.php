<?php
/**
 * Woocommerce Helpers
 * --------
 * @category Woocommerce
 * @version 1.0
 * @package Lydia
 */
namespace BMAS;

defined( 'ABSPATH' ) || exit;

class WooHelpers
{
    public static function getCartCount()
    {
        return WC()->cart->get_cart_contents_count();
    }

    /**
     * @param string $page
     */
    public static function getLink( string $page )
    {
        return get_permalink( wc_get_page_id( $page ) );
    }

    public static function isWooShortcodePage()
    {
        return class_exists( 'WooCommerce' ) &&
            ( is_cart() || is_checkout() || is_account_page() );
    }
}
