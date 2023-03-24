<?php
/*
Template Name: Sponsored
Template Post Type: article
 */
/**
 * Page
 * --------
 * @category Controllers
 * @package Lydia/Controllers
 * @version 1.0
 */
defined( 'ABSPATH' ) || exit;

$context = new \BMAS\Timber\Context( [
    'single--sponsored.twig'
] );

/**
 * Update Post Views and Check if Subscriber
 * --------
 * @since GJ 3.0
 * @version 1.0
 */
if ( TGJ\Users()->isSubscriber() || TGJ\Users()->isAdminUser() ) {
    $context->add( 'subscriber', true );
} else {
    $context->add( 'subscriber', false );
}

if ( ! TGJ\Users()->isAdminUser() ) {
    TGJ\PostViews::update( $post->ID );
}

/**
 * Content Builder
 * --------
 * @since GJ 3.0
 * @version 1.0
 */
$contentBuilder = get_field( 'content_builder' );
$context->add( 'contentBuilder', $contentBuilder );
if ( get_field( 'content_builder' ) ) {

    $layouts = ['image_gallery', 'masonry_gallery', 'recommended_products', 'affiliate_products', 'standard--full'];
    $lookup  = array_values( array_column( (array) $contentBuilder, 'acf_fc_layout', 'acf_fc_layout' ) );
    $context->add( 'extended', in_array_any( $layouts, $lookup ) );

    $imageLookup = array_values( array_column( (array) $contentBuilder, 'image_size', 'image_size' ) );
    $context->add( 'extendedImage', in_array_any( $layouts, $imageLookup ) );

}

/**
 * Related Posts
 * --------
 * @since GJ 3.0
 * @version 1.0
 */
$relatedtime = '1 year ago';

$context->add( 'relatedArgs', [
    'post_type'   => $post_type,
    'post_status' => 'publish',
    'numberposts' => 2,
    'orderby'     => 'rand',
] );

$context->render();
