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

// Declare Woocommerce Wrappers
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action( 'woocommerce_before_main_content', 'gj_wrapper_start', 10);
function gj_wrapper_start() {
  echo '<div id="has-woo-wrapper-hook">';
}

add_action( 'woocommerce_after_main_content', 'gj_wrapper_end', 10);
function gj_wrapper_end() {
  echo '</div>';
}

// Fire wp auto p after short codes removes p from the content area
remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop' , 12);

// Woocommerce and Timber
function timber_set_product( $post ) {
    global $product;
    if ( is_woocommerce() ) {
        $product = wc_get_product($post->ID);
    }
}


// Remove the sorting dropdown from Woocommerce
remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_catalog_ordering', 30 );
// Remove the result count from WooCommerce
remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_result_count', 20 );
