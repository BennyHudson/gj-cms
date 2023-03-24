<?php
/**
* Alter Woocommerce Checkout Fields
* ------
* @package Lydia
* @since Lydia 1.0
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Change order notes placeholder
function gj_woocommerce_checkout_fields( $fields ) {
    $fields['order']['order_comments']['placeholder'] = 'Already have the current issue? Let us know here and we\'ll start your subscription with the next one.';
    return $fields;
}
add_filter( 'woocommerce_checkout_fields', 'gj_woocommerce_checkout_fields' );
