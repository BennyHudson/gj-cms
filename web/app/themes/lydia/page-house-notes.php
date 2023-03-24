<?php

defined('ABSPATH') || exit();

$context = new \BMAS\Timber\Context(['page-house-notes.twig']);

$posts = Timber::get_posts([
    'post_type' => 'house-note',
    'posts_per_page' => -1,
]);

$latestPosts = Timber::get_posts([
    'post_type' => 'house-note',
    'posts_per_page' => 3,
]);

$categories = get_categories([
    'taxonomy' => 'house-note-category',
]);

$categoryPosts = [];

foreach ($categories as $category) {
    $post = Timber::get_post([
        'post_type' => 'house-note',
        'tax_query' => [
            [
                'taxonomy' => 'house-note-category',
                'terms' => $category->term_id,
            ],
        ],
    ]);
    $categoryPosts[] = $post;
}

$context->add([
    'posts' => $posts,
    'latestPosts' => $latestPosts,
    'categories' => $categories,
    'categoryPosts' => $categoryPosts,
]);
$context->render();
