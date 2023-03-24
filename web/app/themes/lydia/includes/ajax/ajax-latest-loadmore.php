<?php
/**
 *  Ajax Infinite Scroll Single Posts
 *  --------
 *  @package GJ
 *  @since GJ 5.0
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function latest_loadmore()
{

    $latest_ids = $_POST['latestIDs'];
    $home_featured = get_field( 'home_featured_post', 74174 );
    array_push($latest_ids, $home_featured);

    $args['post_type']   = ['post', 'article'];
    $args['post_status'] = 'publish';
    $args['numberposts'] = 12;
    $args['post__not_in']  = $latest_ids;

    // Get the Posts
    $posts = Timber::get_posts( $args );

    // Set the Context for Timber File
    $context          = Timber::get_context();
    $context['posts'] = $posts;
    $context['Ajax']  = true;

    // Output

    // If there are no more posts
    if ( count( $posts ) === 0 ) {
        echo 'no-posts';
    } else {
        Timber::render( 'components/feed--latest-ajax.twig', $context );
    }

    wp_die();
}

add_action( 'wp_ajax_latest_loadmore', 'latest_loadmore' );
add_action( 'wp_ajax_nopriv_latest_loadmore', 'latest_loadmore' );
