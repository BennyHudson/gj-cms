<?php
/**
 * Page
 * --------
 * @category Controllers
 * @package Lydia/Controllers
 * @version 1.0
 */
defined( 'ABSPATH' ) || exit;

$context = new \BMAS\Timber\Context( ['page-club.twig'] );

$club = get_field( 'club' );

if ( array_key_exists( 'buy', (array) $club ) && array_key_exists( 'product', $club['buy'] ) ) {
    // Get the Subscription Products
    // $group = wc_get_product( $club['buy']['product'] );
    // Get the individual group products
    // $subs = $group->get_children();
    // $subs = [367143, 193031];
    $subs = [193031];
    // Convert them to Timber Post
    foreach ( $subs as $sub ) {
        $products[] = new \Timber\Post( $sub );
    }
    // Add the info that we want
    foreach ( $products as $product ) {
        $prod                    = wc_get_product( $product );
        if ($prod) {
            $product->perks      = get_field( 'subscription_perks', $prod->get_id() );
            $product->price_html = $prod->get_price_html();
            $product->featured   = true === $prod->get_featured();
            $product->gallery    = $prod->get_gallery_image_ids();
        }
    }
    // Replace orginal context
    $club['buy']['product'] = $products;
}

$club['brands'] = \Timber\Timber::get_posts( [
    'post_type'   => 'clubhouse-partners',
    'post_status' => 'publish',
    'meta_query'  => [
        [
            'key'     => 'partner_information_featured',
            'compare' => '=',
            'value'   => '1'
        ]
    ]
] );

$context->add('club', $club );


$context->render();
