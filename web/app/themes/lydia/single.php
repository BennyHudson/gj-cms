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
    'single-' . $post->ID . '.twig',
    'single-' . $post->post_type . '.twig',
    'single.twig'
] );

$cats = wp_get_post_terms( $post->ID, 'category' );

$context->add( 'category', $cats );
$category = get_the_category();
$categoryID = '';
if ( !empty($category) &&  (get_post_type() == 'article' || get_post_type() == 'post' )) {
    if ( $category[0]->parent == 0 ) {
        $context->add( 'mainCat', $category[0]->term_id );
        $categoryID = $category[0]->term_id;
    } else {
        $context->add( 'mainCat', $category[0]->parent );
        $categoryID = $category[0]->parent;
    }
}

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
 * Members only
 * --------
 * @since GJ 3.0
 * @version 1.0
 */
if ( $post->print_article == true ) {
    $context->add( 'members', true );
    $context->add( 'paywallProduct', new Timber\Post( get_field( 'package_selection', 'options' ) ) );
} else {
    $context->add( 'members', false );
}

/**
 * Premium Content
 * --------
 * @since GJ 3.0
 * @version 1.0
 */
$compare_date = strtotime( '2018-02-01' );
$post_date    = strtotime( $post->post_date );

if ( $compare_date < $post_date ) {
    $context->add( 'premium', true );
} else {
    $context->add( 'premium', false );
}

/**
 * Check for Post Formats
 * --------
 * @since GJ 3.0
 * @version 1.0
 */
$context->add( 'format', get_post_format() );

/**
 * Content Builder
 * --------
 * @since GJ 3.0
 * @version 1.0
 */
$contentBuilder = get_field( 'content_builder' );
$context->add( 'contentBuilder', $contentBuilder );
$context->add( 'contentBuilderLegacy', get_field( 'article_content_areas' ) );
if ( get_field( 'content_builder' ) ) {

    $layouts = ['image_slider', 'image_gallery', 'masonry_gallery', 'recommended_products', 'affiliate_products', 'standard--full'];
    $lookup  = array_values(array_column( (array) $contentBuilder, 'acf_fc_layout', 'acf_fc_layout' ));
    $context->add( 'extended', in_array_any( $layouts, $lookup ) );

    $imageLookup = array_values(array_column( (array) $contentBuilder, 'image_size', 'image_size' ));
    $context->add( 'extendedImage', in_array_any( $layouts, $imageLookup ) );

}

// Podcast Info
if ( get_post_type() == 'podcasts' ) {
    $podcast_options                           = get_fields( 'podcast-options' );
    $host                                      = $podcast_options['podcast_global']['host'];
    $podcast_options['podcast_global']['host'] = new \Timber\User( $host );
    $context->add( 'podcastGlobal', $podcast_options['podcast_global'] );
}

/**
 * Don't Miss Feed
 * --------
 * This is the most popular posts this week
 * --------
 * @since GJ 3.0
 * @version 1.0
 */
if ( get_post_type() == 'article' || get_post_type() == 'post' ) {
    if ( \BMAS\Util\Development::is_localhost() ) {
        $time = '1 year ago';
    } else {
        $time = '6 month ago';
    }
    $args_dontMiss = [
        'post_type'    => $post_type,
        'post_status'  => 'publish',
        'numberposts'  => 12,
        'orderby'      => 'rand',
        'category__in' => $categoryID,
        'date_query'   => [
            [
                'after' => $time
            ],
            'inclusive' => true
        ]
    ];
    $posts_dontMiss = \Timber\Timber::get_posts( $args_dontMiss );
    $context->add( 'dontMiss', $posts_dontMiss );
}

if ( get_post_type() == 'landing-page') {
    
    $args_partners = [
        'post_type'    => 'clubhouse-partners',
        'post_status'  => 'publish',
        'numberposts'  => 9,
        'orderby'      => 'rand',
    ];
    $clubhousePartners = \Timber\Timber::get_posts( $args_partners );
    $context->add( 'partners', $clubhousePartners );

    $argsPerks = array(
        'post_type' => 'page',
        'post__in' => array(74300)
    );
    $clubhouse = \Timber\Timber::get_post( 74300 );
    $context->add( 'clubhouse', $clubhouse );
    // $context->add( 'perks', get_field('club_subscription_perks', 74300));
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
    'numberposts' => 3,
    'orderby'     => 'rand',
    'date_query'  => [
        [
            'after' => $relatedtime
        ],
        'inclusive' => true
    ]
] );

if ( get_post_type() == 'podcasts' ) {
    $args_relPodcasts = [
        'post_type'    => 'podcasts',
        'post_status'  => 'publish',
        'numberposts'  => 12,
        'orderby'      => 'rand',
        'post__not_in' => [$post->ID]
    ];
    $posts_relPodcasts = \Timber\Timber::get_posts( $args_relPodcasts );
    $context->add( 'relatedPodcasts', $posts_relPodcasts );
}

if ( get_post_format() == 'video' ) {
    $args_videoPlaylist = [
        'post_type'     => $post_type,
        'post_status'   => 'publish',
        'numberposts'   => 10,
        'post__not_in'  => [$post->ID],
        'category_name' => 'video'
    ];
    $posts_videoPlaylist = Timber\Timber::get_posts( $args_videoPlaylist );
    $context->add( 'videoPlaylist', $posts_videoPlaylist );
}

/**
 * Most Popular Widget
 * --------
 * This is the most popular posts
 * --------
 * @since GJ 3.0
 * @version 1.0
 */
if ( \BMAS\Util\Development::is_localhost() ) {
    $time = '1 year ago';
} else {
    $time = '1 week ago';
}
$args_mostPopular = [
    'post_type'   => $post_type,
    'post_status' => 'publish',
    'numberposts' => 5,
    'meta_key'    => 'post_views_count',
    'orderby'     => 'meta_value_num',
    'order'       => 'DESC',
    'date_query'  => [
        [
            'after' => $time
        ],
        'inclusive' => true
    ]
];
$posts_mostPopular = Timber\Timber::get_posts( $args_mostPopular );
$context->add( 'mostPopular', $posts_mostPopular );

/**
 * Read and Watch Next
 * --------
 * @since GJ 3.0
 * @version 1.0
 */
$readNext = get_next_post();
if ( ! empty( $readNext ) ) {
    $context->add( 'readNext', new Timber\Post( $readNext->ID ) );
}
$args_watchNext = [
    'post_type'   => $post_type,
    'post_status' => 'publish',
    'numberposts' => 1,
    'cat'         => 9179, // Videos
    'orderby'     => 'rand'
];
$context->add( 'watchNext', Timber\Timber::get_posts( $args_watchNext ) );

/**
 * Read Previous
 * --------
 * @since GJ 3.0
 * @version 1.0
 */
$readPrev = get_previous_post();
if ( ! empty( $readPrev ) ) {
    $context->add( 'readPrev', new Timber\Post( $readPrev->ID ) );
}

/**
 * Ajax
 * --------
 * @since GJ 3.0
 * @version 1.0
 */
$context->add( 'Ajax', false );

/**
 * Parent Link
 * --------
 * @since GJ 3.0
 * @version 1.0
 */
$context->add( 'parentLink', get_post_type_archive_link( $post->post_type  ) );


$latestHouseNotes = Timber::get_posts([
    'post_type' => 'house-note',
    'posts_per_page' => 4,
  ]);

$context->add('latestHouseNotes', $latestHouseNotes );

$context->render();
