<?php
/**
 * Page
 * --------
 * @category Controllers
 * @package Lydia/Controllers
 * @version 1.0
 */
defined( 'ABSPATH' ) || exit;

$context = new \BMAS\Timber\Context( [
    'page-' . $post->ID . '.twig',
    'page-' . $post->post_name . '.twig',
    'page.twig'
] );

$context->add([
    'officeMap' => get_field( 'office_map' ),
    'standardProduct' => 137089,
    'vipProduct'      => 137073,
    'digitalProduct'  => 105945,
    'products' => Timber\Timber::get_posts( [
        'post_type'   => 'product',
        'product_cat' => 'subscription',
        'post_status' => 'publish',
        'post__in'    => [137089, 137073, 105945],
    ]),
]);

function get_variation_data_from_variation_id( $product_id )
{
    $product    = new WC_Product_Variable( $product_id );
    $variations = $product->get_available_variations();

    return $variations;
}


$context->render();
