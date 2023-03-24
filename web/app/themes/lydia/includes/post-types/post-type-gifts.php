<?php

add_action('init', function() {
    register_post_type('gift', [
        'label'                 => __( 'Gifts', 'lydia' ),
        'description'           => __( 'Gifts for Gift Guide', 'lydia' ),
        'labels' => [
            'name'                => _x( 'Gift', 'Post Type General Name', 'lydia' ),
            'singular_name'       => _x( 'Gift', 'Post Type Singular Name', 'lydia' ),
            'menu_name'           => __( 'Gift', 'lydia' ),
            'name_admin_bar'      => __( 'Gift', 'lydia' ),
            'parent_item_colon'   => __( 'Parent Gift:', 'lydia' ),
            'all_items'           => __( 'All Gift', 'lydia' ),
            'add_new_item'        => __( 'Add New Gift', 'lydia' ),
            'add_new'             => __( 'Add New', 'lydia' ),
            'new_item'            => __( 'New Gift', 'lydia' ),
            'edit_item'           => __( 'Edit Gift', 'lydia' ),
            'update_item'         => __( 'Update Gift', 'lydia' ),
            'view_item'           => __( 'View Gift', 'lydia' ),
            'search_items'        => __( 'Search Gift', 'lydia' ),
            'not_found'           => __( 'No Gift found', 'lydia' ),
            'not_found_in_trash'  => __( 'No Gifts found in Trash', 'lydia' )
        ],
        'supports'              => ['title', 'editor', 'author', 'thumbnail', 'custom-fields', 'page-attributes'],
        'hierarchical'          => false,
        'public'                => false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 10,
        'menu_icon'             => 'dashicons-products',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
        'show_in_graphql'       => true,
        'graphql_single_name' => 'gift',
        'graphql_plural_name' => 'gifts',
        'rest_base'             => 'gifts',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
        'rewrite'               => ['slug' => 'gift', 'with_front' => false]
    ]);
});
