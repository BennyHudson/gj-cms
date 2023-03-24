<?php
/**
* Woocommmerce Theme Support
* ------
* @package Lydia
* @since Lydia 1.0
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
