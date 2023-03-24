<?php

defined('ABSPATH') || exit();

use Timber\Timber;

$context = new \BMAS\Timber\Context(['page-gj-sessions.twig']);

$context->add([
    'playlist' => Timber::get_posts([
        'post_type' => 'article',
        'posts_per_page' => 9,
        'tax_query' => [
            [
                'taxonomy' => 'category',
                'field' => 'term_id',
                'terms' => '9682', // Artist Interviews
            ],
        ],
    ]),
    'posts' => Timber::get_posts([
        'post_type' => 'article',
        'posts_per_page' => 5, //TODO Revert to 15
        'tax_query' => [
            [
                'taxonomy' => 'category',
                'field' => 'term_id',
                'terms' => '9682', // Artist Interviews
            ],
        ],
    ]),
]);


$context->render();
