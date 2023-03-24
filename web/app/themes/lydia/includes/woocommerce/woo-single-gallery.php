<?php
/**
*  WOOCOMMERCE - Single Gallery
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

// Remove Wordpress Gallery
function remove_gallery_and_product_images() {
if ( is_product() ) {
    remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
    }
}
add_action('template_redirect', 'remove_gallery_and_product_images');
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail' );
