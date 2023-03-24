<?php

add_action( 'init', function () {
    register_post_type( 'events', [
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'has_archive'         => true,
        'menu_position'       => 25,
        'menu_icon'           => 'dashicons-tickets-alt',
        'public'              => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'query_var'           => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'can_export'          => true,
        'show_in_rest'        => true,
        'rest_base'           => 'events',
        'rewrite'             => ['slug' => 'events', 'with_front' => false],
        'supports'            => ['editor', 'title', 'thumbnail', 'custom-fields', 'page-attributes'],
        'label'               => __( 'Events', 'lydia' ),
        'description'         => __( 'Event Posts', 'lydia' ),
        'labels'              => [
            'name'               => _x( 'Events', 'Post Type General Name', 'lydia' ),
            'singular_name'      => _x( 'Event', 'Post Type Singular Name', 'lydia' ),
            'menu_name'          => __( 'Events', 'lydia' ),
            'name_admin_bar'     => __( 'Events', 'lydia' ),
            'parent_item_colon'  => __( 'Parent Event:', 'lydia' ),
            'all_items'          => __( 'All Events', 'lydia' ),
            'add_new_item'       => __( 'Add New Event', 'lydia' ),
            'add_new'            => __( 'Add New', 'lydia' ),
            'new_item'           => __( 'New Event', 'lydia' ),
            'edit_item'          => __( 'Edit Event', 'lydia' ),
            'update_item'        => __( 'Update Event', 'lydia' ),
            'view_item'          => __( 'View Event', 'lydia' ),
            'search_items'       => __( 'Search Events', 'lydia' ),
            'not_found'          => __( 'No events found', 'lydia' ),
            'not_found_in_trash' => __( 'No events found in Trash', 'lydia' )
        ]
    ] );
} );

function events_options_page()
{
    if ( function_exists( 'acf_add_options_sub_page' ) ) {
        $page = acf_add_options_sub_page( [
            'page_title' => 'Event Options',
            'menu_title' => 'Event Options',
            'menu_slug'  => 'event-options',
            'capability' => 'edit_posts',
            'parent'     => 'edit.php?post_type=events',
            'position'   => 50,
            'redirect'   => true,
            'post_id'    => 'event-options',
            'show_in_graphql'       => true
        ] );
    }
}

add_action( 'init', 'events_options_page' );
