<?php

/**
 *  Ajax Infinite Scroll Single Posts
 *  --------
 * @package GJ
 * @since GJ 5.0
 */
if (!defined('ABSPATH')) {
    exit;
}

function membership_loadmore()
{
    $page = $_POST['page'];
    $paged = ($page ? $page : 2);

    $args['post_type'] = ['gentleman'];
    $args['post_status'] = 'publish';
    $args['numberposts'] = 16;
    $args['paged'] = $paged;
    //$args['post__not_in']= [94967, 94962];

    // Get the Posts
    $posts = Timber::get_posts($args);


    // Set the Context for Timber File
    $context = Timber::get_context();
    $context['posts'] = $posts;
    $context['Ajax'] = true;


    // Output

    // If there are no more posts
    if (count($posts) === 0) {
        echo 'no-posts';
    } else {
        Timber::render('components/membership/membership__feed.twig', $context);
    }

    wp_die();
}

add_action('wp_ajax_membership_loadmore', 'membership_loadmore');
add_action('wp_ajax_nopriv_membership_loadmore', 'membership_loadmore');
