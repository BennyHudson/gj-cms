<?php
/**
*  WOOCOMMERCE
*  ------
*  Modifies and Refines Woocommerce to be inline with desired output
*  and functionality. Additional Woocommerce extension modifications are also defined here.
*  ------
*  @package Lydia
*  @since Lydia 1.0
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// // Rename the coupon field on the cart page
// function woocommerce_rename_coupon_field_on_cart( $translated_text, $text, $text_domain ) {
//     // bail if not modifying frontend woocommerce text
//     if ( is_admin() || 'woocommerce' !== $text_domain ) {
//         return $translated_text;
//     }
//     if ( 'Apply coupon' === $text ) {
//         $translated_text = 'Apply Code';
//     }
//     return $translated_text;
// }
// add_filter( 'gettext', 'woocommerce_rename_coupon_field_on_cart', 10, 3 );

// // rename the "Have a Coupon?" message on the checkout page
// function woocommerce_rename_coupon_message_on_checkout() {
//     return 'Have an Offer Code?' . ' <a href="#" class="showcoupon">' . __( 'Click here to enter your code', 'woocommerce' ) . '</a>';
// }
// add_filter( 'woocommerce_checkout_coupon_message', 'woocommerce_rename_coupon_message_on_checkout' );

// // rename the coupon field on the checkout page
// function woocommerce_rename_coupon_field_on_checkout( $translated_text, $text, $text_domain ) {
//     // bail if not modifying frontend woocommerce text
//     if ( is_admin() || 'woocommerce' !== $text_domain ) {
//         return $translated_text;
//     }
//     if ( 'Coupon code' === $text ) {
//         $translated_text = 'Offer Code';

//     } elseif ( 'Apply Coupon' === $text ) {
//         $translated_text = 'Apply Offer Code';
//     }
//     return $translated_text;
// }
// add_filter( 'gettext', 'woocommerce_rename_coupon_field_on_checkout', 10, 3 );
