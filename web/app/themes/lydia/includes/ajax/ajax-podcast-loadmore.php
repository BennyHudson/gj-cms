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

function podcast_loadmore()
{
    $page  = $_POST['page'];
    $paged = ( $page ? $page : 2 );

    $args['post_type']   = ['podcasts'];
    $args['post_status'] = 'publish';
    $args['numberposts'] = 12;
    $args['paged']       = $paged;

    // Get the Posts
    $posts = Timber::get_posts( $args );

    // Set the Context for Timber File
    $context            = Timber::get_context();
    $context['posts']   = $posts;
    $context['Ajax']    = true;

    // Output

    // If there are no more posts
    if ( count( $posts ) === 0 ) {
        echo 'no-posts';
    } else {
        Timber::render( 'components/podcast/podcast__archive__feed.twig', $context );
    }

    wp_die();
}

add_action( 'wp_ajax_podcast_loadmore', 'podcast_loadmore' );
add_action( 'wp_ajax_nopriv_podcast_loadmore', 'podcast_loadmore' );
