<?php
/**
 * Front Page
 * --------
 * @category Controllers
 * @package Lydia/Controllers
 * @version 1.0
 */
defined( 'ABSPATH' ) || exit;

$context = new \BMAS\Timber\Context( ['front-page.twig'] );

$post_type = ['post', 'article'];

/*
 * Show local content
 * --------
 * @version 1.0
 */
if ( \BMAS\Util\Development::is_localhost() ) {
    $time = '1 year ago';
} else {
    $time = '2 week ago';
}

/*
 * Build the context
 * --------
 * @version 1.0
 */
$home_featured = get_field( 'home_featured_post' );

$context->add( [
    // Featured Homepage
    'centerFeatured'    => get_field( 'home_featured_alignment' ),
    'featuredPost'      => new \Timber\Post( $home_featured ),
    'weeklyHighlight'   => get_field( 'home_weekly_highlight' ) ? new Timber\Post( get_field( 'home_weekly_highlight' ) ) : '',
    // Latest Reads
    'latest'            => new Timber\PostQuery( [
        'post_type'        => $post_type,
        'post_status'      => 'publish',
        'numberposts'      => 6,
        'category__not_in' => ['9629'],
        'post__not_in'     => [$home_featured]
    ] ),
    // Dont Miss
    'dontMiss'          => new Timber\PostQuery( [
        'post_type'        => $post_type,
        'post_status'      => 'publish',
        'numberposts'      => 12,
        'orderby'          => 'rand',
        'date_query'       => [
            [
                'after' => $time
            ],
            'inclusive' => true
        ],
        'category__not_in' => ['9629']
    ] ),
    'popular' => new Timber\PostQuery( [
        'post_type'        => $post_type,
        'post_status'      => 'publish',
        'numberposts'      => 5,
        'meta_key'         => 'post_views_count',
        'order'            => 'DESC',
        'orderby'          => 'meta_value_num',
        'date_query'       => [
            [
                'after' => '1 week ago'
            ],
            'inclusive' => true
        ],
        'category__not_in' => ['9629']
    ] ),
    'sessions' => [
        'global' => [
            'meta' => get_field('sessions', '388179' ),
            'link' => get_permalink( '388179' )
        ],
        'latest' => Timber\Timber::get_post( [
            'post_type'      => 'article',
            'numberposts' => 1,
            'tax_query'      => [
                [
                    'taxonomy' => 'category',
                    'field'    => 'term_id',
                    'terms'    => '9682' // Artist Interviews
                ]
            ]
        ] )
    ],
    'editorsPick'       => get_field( 'home_editors_pick' ) ? new Timber\PostQuery( get_field( 'home_editors_pick' ) ) : '',
    'podcasts'          => new Timber\PostQuery( [
        'post_type'   => 'podcasts',
        'post_status' => 'publish',
        'numberposts' => 5
    ] ),
    'videos'            => new Timber\PostQuery( [
        'post_type'     => 'article',
        'post_status'   => 'publish',
        'numberposts'   => 4,
        'category_name' => 'video'
    ] ),
    'membersCatID'      => 9415,
    'shop'              => get_field( 'store', 'clubhouse-partners-options' ),
    'sectionNewsletter' => get_field( 'section_newsletter', 'options' )
] );

$context->render();
