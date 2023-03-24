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

add_filter( 'woocommerce_breadcrumb_defaults', 'woocommerce_breadcrumbs' );
function woocommerce_breadcrumbs() {
    return array(
            'delimiter'   => '<span class="c-crumbs c-crumbs__separator"><span class="fa fa-angle-right"></span></span>',
            'wrap_before' => '<nav id="breadcrumbs" class="c-crumbs c-crumbs--woocommerce" itemprop="breadcrumb">',
            'wrap_after'  => '</nav>',
            'before'      => '',
            'after'       => '',
            'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
        );
}

add_action( 'init', 'woo_remove_wc_breadcrumbs' );
function woo_remove_wc_breadcrumbs() {
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}
