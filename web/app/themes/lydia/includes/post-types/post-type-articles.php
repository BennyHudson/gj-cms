<?php

add_action( 'init', function () {
    register_post_type( 'article', [
        'labels'                => [
            'name'          => 'Articles',
            'singular_name' => 'Article',
            'all_items'     => 'All Articles',
            'add_new'       => __( 'Add New', 'tgj' ), /* The add new menu item */
            'add_new_item' => __( 'Add New Article', 'tgj' ), /* Add New Display Title */
            'edit' => __( 'Edit', 'tgj' ), /* Edit Dialogue */
            'edit_item' => __( 'Edit Article', 'tgj' ), /* Edit Display Title */
            'new_item' => __( 'New Article', 'tgj' ), /* New Display Title */
            'view_item' => __( 'View Article', 'tgj' ), /* View Display Title */
            'search_items' => __( 'Search Articles', 'tgj' ), /* Search Custom Type Title */
            'parent_item_colon' => ''
        ],
        'capability_type'       => 'post',
        'description'           => __( 'Custom Post for Articles', 'tgj' ),
        'rewrite'               => ['slug' => 'article'],
        'public'                => true,
        'has_archive'           => true,
        'hierarchical'          => false,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-welcome-write-blog',
        'show_in_rest'          => true,
        'rest_base'             => 'articles',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
        'supports'              => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields', 'revisions', 'page-attributes', 'amp', 'post-formats'],
        'taxonomies'            => ['category'],
        'show_in_graphql'       => true,
        'graphql_single_name' => 'article',
        'graphql_plural_name' => 'articles',
    ] );
} );
