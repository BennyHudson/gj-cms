<?php

add_action('init', function() {
	register_post_type('podcasts', [
		'labels' => [
            'name'              => 'Podcasts',
            'singular_name'     => 'Podcast',
            'all_items'         => 'All Podcasts',
            'add_new'           => __( 'Add New', 'tgj' ), /* The add new menu item */
            'add_new_item'      => __( 'Add New Podcast', 'tgj' ), /* Add New Display Title */
            'edit'              => __( 'Edit', 'tgj' ), /* Edit Dialogue */
            'edit_item'         => __( 'Edit Podcast', 'tgj' ), /* Edit Display Title */
            'new_item'          => __( 'New Podcast', 'tgj' ), /* New Display Title */
            'view_item'         => __( 'View Podcast', 'tgj' ), /* View Display Title */
            'search_items'      => __( 'Search Podcasts', 'tgj' ), /* Search Custom Type Title */
            'parent_item_colon' => ''
        ],
        'capability_type'       => 'post',
        'description'           => __( 'Custom Post for Podcasts', 'tgj' ),
        'has_archive'           => true,
        'hierarchical'          => false,
        'menu_icon'             => 'dashicons-format-audio',
        'public'                => true,
        'publicly_queryable'    => true,
        'rest_base'             => 'podcasts',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
        'rewrite'               => ['slug' => 'podcasts'],
        'show_in_rest'          => true,
        'supports'              => ['title','editor','author','thumbnail','excerpt','custom-fields','revisions','page-attributes'],
        'menu_position'         => 10,
        'show_in_graphql'       => true,
        'graphql_single_name' => 'podcast',
        'graphql_plural_name' => 'podcasts',
	]);
});

function podcast_options_page() {
    if (function_exists('acf_add_options_sub_page')) {
        $page = acf_add_options_sub_page(array(
		'page_title' => 'Podcast Options',
		'menu_title' => 'Podcast Options',
		'menu_slug'  => 'podcast-options',
		'capability' => 'edit_posts',
        'parent'     => 'edit.php?post_type=podcasts',
		'position'   => 50,
		'redirect'   => true,
		'post_id'    => 'podcast-options',
        'show_in_graphql' => true
        ));
    }
}
add_action('init', 'podcast_options_page');
