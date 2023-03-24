<?php
/**
 * Archive
 * --------
 * @category Controllers
 * @package Lydia/Controllers
 * @version 1.0
 */
defined('ABSPATH') || exit();

$context = new \BMAS\Timber\Context([
    'archive-' . $post->post_type . '.twig',
    'archive-' . get_query_var('cat') . '.twig',
    'archive.twig',
]);

/*
 * Dynamic Archive Title
 * --------
 * @version 1.0
 */
if (is_day()) {
    $title = 'Archive: ' . get_the_date('D M Y');
} elseif (is_month()) {
    $title = 'Archive: ' . get_the_date('M Y');
} elseif (is_year()) {
    $title = 'Archive: ' . get_the_date('Y');
} elseif (is_tag()) {
    $title = single_tag_title('', false);
} elseif (is_category()) {
    $title = single_cat_title('', false);
} elseif (is_post_type_archive()) {
    $title = post_type_archive_title('', false);
} else {
    $title = 'Archive';
}

/*
 * Build the context
 * --------
 * @version 1.0
 */
$context->add([
    'title' => $title,
    'archive' => new \Timber\Term(),
]);

/*
 * Podcasts
 * --------
 * @version 1.0
 */
if (get_post_type() == 'podcasts') {
    $podcast_options = get_fields('podcast-options');
    $host = $podcast_options['podcast_global']['host'];
    $podcast_options['podcast_global']['host'] = new Timber\User($host);
    $context->add('podcastGlobal', $podcast_options['podcast_global']);
}

/*
 * Membership
 * --------
 * @version 1.0
 */
if (get_post_type() == 'gentleman') {
    $args_gentleman = [
        'post_type' => 'gentleman',
        'posts_per_page' => 16,
    ];
    $context->add('posts', \Timber\Timber::get_posts($args_gentleman));
}

/*
 * Clubhouse Partners
 * --------
 * @version 1.0
 */
if (get_post_type() == 'clubhouse-partners') {
    if (get_fields('clubhouse-partners-options')) {
        $clubhouseOptions = get_fields('clubhouse-partners-options');

        $context->add([
            'clubhousePartners' =>
                $clubhouseOptions['clubhouse_partner_archive'],
            'archive' => Timber\Timber::get_terms([
                'taxonomy' => 'partner-category',
                'hide_empty' => true,
            ]),
        ]);
    }
}

if (is_category('video')) {
    $args_videoPlaylist = [
        'post_type' => $post_type,
        'post_status' => 'publish',
        'numberposts' => 10,
        'category_name' => 'video',
    ];
    $posts_videoPlaylist = \Timber\Timber::get_posts($args_videoPlaylist);
    $context->add('videoPlaylist', $posts_videoPlaylist);
}

if (get_post_type() == 'clubhouse-partners') {
    $args_clubhouse = [
        'post_type' => 'clubhouse-partners',
        'post_status' => 'publish',
        'numberposts' => -1,
        'orderby' => 'publish_date',
        'order' => 'DESC'
    ];
    $context->add('posts', \Timber\Timber::get_posts($args_clubhouse));
}

if (get_post_type() == 'events') {
    $today = date('Y-m-d H:i:s');

    $latestPostArg = [
        'post_type' => 'events',
        'numberposts' => 1,
        'meta_key' => 'events_event_date',
        'orderby' => 'meta_value',
        'fields' => 'ids',
        'meta_query' => [
            [
                'key' => 'events_event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'DATETIME',
            ],
        ],
        'order' => 'ASC',
    ];

    $allPostsArgs = [
        'post_type' => 'events',
        'posts_per_page' => 20,
        'meta_key' => 'events_event_date',
        'orderby' => 'meta_value',
        'fields' => 'ids',
        'meta_query' => [
            [
                'key' => 'events_event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'DATETIME',
            ],
        ],
        'order' => 'ASC',
        'offset' => 1,
    ];

    $context->add(
        'latestPost',
        \Timber\Timber::get_posts($latestPostArg)[0]
    );
    $context->add('offsetPosts', \Timber\Timber::get_posts($allPostsArgs));

    $context->add('events_options', get_field('events_options', 'event-options'));
}

$context->render();
