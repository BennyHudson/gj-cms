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

function archive_loadmore()
{
    $page  = $_POST['page'];
    $paged = ( $page ? $page : 2 );

    $args['post_type']   = ['post', 'article'];
    $args['post_status'] = 'publish';
    $args['posts_per_page'] = 14;
    $args['paged']       = $paged;

    if ($paged == 2) {
        $args['posts_per_page'] = 14;
    }

    if ( $_POST['search'] ) {
        $args['s'] = $_POST['search'];
    } else {
        $args['cat'] = $_POST['termID'];
    }

    // Get the Posts
    $posts = Timber::get_posts( $args );

    // Set the Context for Timber File
    $context            = Timber::get_context();
    $context['posts']   = $posts;
    $context['archive'] = new TimberTerm( $_POST['termID'] );
    $context['Ajax']    = true;

    // Output

    // If there are no more posts
    if ( count( $posts ) === 0 ) {
        echo 'no-posts';
    } else {
        Timber::render( 'components/feed--archive-ajax.twig', $context );
    }

    wp_die();
}

add_action( 'wp_ajax_archive_loadmore', 'archive_loadmore' );
add_action( 'wp_ajax_nopriv_archive_loadmore', 'archive_loadmore' );
