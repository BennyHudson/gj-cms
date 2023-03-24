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

// Add Taxonomy term to body_class
function woo_custom_taxonomy_in_body_class( $classes ){
    if( is_singular( 'product' ) ) {
        $custom_terms = get_the_terms(0, 'product_cat');
            if ($custom_terms) {
                foreach ($custom_terms as $custom_term) {
                    $classes[] = 'product_cat_' . $custom_term->slug;
                }
            }
        }
    return $classes;
}
add_filter( 'body_class', 'woo_custom_taxonomy_in_body_class' );

// Activate Woo Slider
// add_action( 'after_setup_theme', 'woo_gallery_activate' );
// function woo_gallery_activate() {
//     add_theme_support( 'wc-product-gallery-slider' );
//     add_theme_support( 'wc-product-gallery-zoom' );
//     add_theme_support( 'wc-product-gallery-lightbox' );
// }

// Move Sale Icon Above Product Title
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_show_product_sale_flash', 2 );

// Remove Product Tabs
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

// Remove SKU
function woo_remove_product_page_skus( $enabled ) {
    if ( ! is_admin() && is_product() ) {
        return false;
    }
    return $enabled;
}
add_filter( 'wc_product_sku_enabled', 'woo_remove_product_page_skus' );

// Remove Product Page Meta
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

// Remove Related product__summary
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

// Remove Pice Trailing zero
add_filter( 'woocommerce_price_trim_zeros', '__return_true' );

// Hide Price for Magazines

add_filter( 'woocommerce_get_price_html', function( $price, $product ) {
	if ( is_admin() ) return $price;
	// Hide for these category slugs / IDs
	$hide_for_categories = array( 'magazine' );
	// Don't show price when its in one of the categories
	if ( has_term( $hide_for_categories, 'product_cat', $product->get_id() ) ) {
		return '';
	}
	return $price; // Return original price
}, 10, 2 );
