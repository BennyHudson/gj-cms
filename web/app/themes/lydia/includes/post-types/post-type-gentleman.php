<?php

add_action('init', function() {
    register_post_type('gentleman', [
        'label'                 => __( 'Gentlemen', 'lydia' ),
        'description'           => __( 'Gentlemen\'s Club Profiles', 'lydia' ),
        'labels' => [
            'name'                => _x( 'Gentlemen', 'Post Type General Name', 'lydia' ),
            'singular_name'       => _x( 'Gentleman', 'Post Type Singular Name', 'lydia' ),
            'menu_name'           => __( 'Gentlemen', 'lydia' ),
            'name_admin_bar'      => __( 'Gentlemen', 'lydia' ),
            'parent_item_colon'   => __( 'Parent Gentlemen:', 'lydia' ),
            'all_items'           => __( 'All Gentlemen', 'lydia' ),
            'add_new_item'        => __( 'Add New Gentleman', 'lydia' ),
            'add_new'             => __( 'Add New', 'lydia' ),
            'new_item'            => __( 'New Gentleman', 'lydia' ),
            'edit_item'           => __( 'Edit Gentleman', 'lydia' ),
            'update_item'         => __( 'Update Gentleman', 'lydia' ),
            'view_item'           => __( 'View Gentleman', 'lydia' ),
            'search_items'        => __( 'Search Gentlemen', 'lydia' ),
            'not_found'           => __( 'No Gentlemen found', 'lydia' ),
            'not_found_in_trash'  => __( 'No Gentlemen found in Trash', 'lydia' )
        ],
        'supports'              => ['title', 'editor', 'author', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes'],
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 10,
        'menu_icon'             => 'dashicons-businessman',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
        'show_in_graphql'       => true,
        'graphql_single_name' => 'gentleman',
        'graphql_plural_name' => 'gentlemans',
        'rest_base'             => 'gentlemen',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
        'rewrite'               => ['slug' => 'gentlemans-club', 'with_front' => false]
    ]);
});
