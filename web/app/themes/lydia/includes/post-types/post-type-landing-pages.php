<?php

add_action( 'init', function () {
    register_post_type( 'landing-page', [
        'labels'                => [
            'name'          => 'Landing Pages',
            'singular_name' => 'Landing Page',
            'all_items'     => 'All Landing Pages',
            'add_new'       => __( 'Add New', 'tgj' ), /* The add new menu item */
            'add_new_item' => __( 'Add New Landing Page', 'tgj' ), /* Add New Display Title */
            'edit' => __( 'Edit', 'tgj' ), /* Edit Dialogue */
            'edit_item' => __( 'Edit Landing Page', 'tgj' ), /* Edit Display Title */
            'new_item' => __( 'New Landing Page', 'tgj' ), /* New Display Title */
            'view_item' => __( 'View Landing Page', 'tgj' ), /* View Display Title */
            'search_items' => __( 'Search Landing Pages', 'tgj' ), /* Search Custom Type Title */
            'parent_item_colon' => ''
        ],
        'capability_type'       => 'post',
        'description'           => __( 'Custom Post for Landing Pages', 'tgj' ),
        // 'rewrite'               => ['slug' => ''],
        'public'                => true,
        'has_archive'           => true,
        'hierarchical'          => false,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-welcome-view-site',
        'show_in_rest'          => true,
        'rest_base'             => 'landing-pages',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
        'supports'              => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields', 'revisions', 'page-attributes', 'amp', 'post-formats'],
        'show_in_graphql'       => true,
        'graphql_single_name' => 'landingPage',
        'graphql_plural_name' => 'landingPages',
    ] );
} );
