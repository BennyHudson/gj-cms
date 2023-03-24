<?php

function ajax_load_more()
{
    $args = [
        'post_status' => 'publish',
        'post_type' => $_POST['postType'],
        'posts_per_page' => $_POST['postsPerPage'],
        'offset' => $_POST['offset'],
        'tax_query' => [
            [
                'taxonomy' => $_POST['taxonomy'],
                'field' => 'term_id',
                'terms' => $_POST['category'],
            ],
        ],
    ];

    $posts = Timber::get_posts($args);

    $allPosts = new WP_Query($args);
    $postCount = $allPosts->found_posts;

    $response = [
        'template' => Timber::compile($_POST['template'], ['posts' => $posts]),
        'postCount' => $postCount,
    ];

    echo json_encode($response);

    wp_die();
}

add_action('wp_ajax_ajax_load_more', 'ajax_load_more');
add_action('wp_ajax_nopriv_ajax_load_more', 'ajax_load_more');
