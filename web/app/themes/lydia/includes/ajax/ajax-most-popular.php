<?php
/**
 *  Ajax Most Popular
 *  --------
 *  @package GJ
 *  @since GJ 5.0
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function ajax_most_popular()
{

    $period = $_POST['period'];

    if ( $period == 'Week' ) {
        $time = '1 week ago';
    } elseif ( $period == 'Month' ) {
        $time = '1 month ago';
    } elseif ( $period == 'Year' ) {
        $time = '1 year ago';
    } else {
        $time = '3 year ago';
    }
    ;

    $args = [
        'post_type'        => ['post', 'article'],
        'post_status'      => 'publish',
        'numberposts'      => 5,
        'meta_key'         => 'post_views_count',
        'order'            => 'DESC',
        'orderby'          => 'meta_value_num',
        'date_query'       => [
            [
                'after' => $time
            ],
            'inclusive' => true
        ],
        'category__not_in' => ['9629']
    ];

    // Get the Posts
    $posts = new Timber\PostQuery( $args );

    // Set the Context for Timber File
    $context['popular'] = $posts;

    // Output

    // If there are no more posts
    if ( count( $posts ) === 0 ) {
        echo 'no-posts';
    } else {
        Timber::render( 'components/widgets/widget-popular-posts__posts.twig', $context );
    }

    wp_die();
}

add_action( 'wp_ajax_ajax_most_popular', 'ajax_most_popular' );
add_action( 'wp_ajax_nopriv_ajax_most_popular', 'ajax_most_popular' );
