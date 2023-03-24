<?php
/**
 * Woocommerce
 * --------
 * @category Controllers
 * @package Lydia/Controllers
 * @version 1.0
 */
defined( 'ABSPATH' ) || exit;

if ( is_singular( 'product' ) ) {

    $context = new \BMAS\Timber\Context( ['woocommerce/single-product.twig'] );

    $context->add( 'post', Timber\Timber::get_post() );
    $product          = wc_get_product( $post->ID );
    $product->ID      = $product->get_id();
    $product->gallery = $product->get_gallery_image_ids();
    $terms            = get_the_terms( $product->ID, 'product_cat' );
    if ( ! empty( $terms ) ) {
        $term = array_shift( $terms );
    }
    $product->terms = $term->slug;
    $context->add( 'product', $product );

    $context->add( 'archive', Timber\Timber::get_posts( [
        'post_type'    => 'product',
        'post_status'  => 'publish',
        'numberposts'  => -1,
        'product_cat'  => 'magazine',
        'post__not_in' => [$post->ID]
    ] ) );

} else {

    $context = new \BMAS\Timber\Context( ['woocommerce/archive.twig'] );

    $posts = Timber\Timber::get_posts();
    $context->add( 'title', 'Shop' );
    $context->add( 'products', $posts );

    if ( is_product_category() ) {
        $queried_object = get_queried_object();
        $term_id        = $queried_object->term_id;
        $context->add( 'category', get_term( $term_id, 'product_cat' ) );
        $context->add( 'title', single_term_title( '', false ) );
    }
}

$context->render();
