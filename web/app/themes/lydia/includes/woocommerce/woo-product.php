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

global $post;

// Change Product Loop HTML
function woocommerce_product_loop_start() { echo '<section class="o-product-thumbs">'; }
function woocommerce_product_loop_end() { echo '</section>'; }


// Change Image Place Holder Image - Upload In Lydia Options Page 450x450
function filter_woocommerce_placeholder_img_src( $img_src ) {
    $img_src = get_field('product_image_place_holder', 'options');

    if ( !empty( $img_src ) ) {
        $img_src = $img_src;
    } else {
        $img_src = WC()->plugin_url() . '/assets/images/placeholder.png';
    }
    return $img_src;
};
add_filter( 'woocommerce_placeholder_img_src', 'filter_woocommerce_placeholder_img_src', 10, 1 );

// Change the Sale Text
add_filter( 'woocommerce_sale_flash', 'woo_replace_sale_text' );
function woo_replace_sale_text( $html ) {
    return str_replace( __( 'Sale!', 'woocommerce' ), __( 'On Sale', 'woocommerce' ), $html );
}
