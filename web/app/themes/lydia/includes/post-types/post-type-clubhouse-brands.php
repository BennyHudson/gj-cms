<?php
/**
 * Custom Post Type : NAME
 * --------
 * @category Post-Types
 * @version 1.0
 * @package Lydia
 */
defined( 'ABSPATH' ) || exit;

add_action( 'init', function () {
    register_post_type( 'clubhouse-partners', [
        'label'                 => __( 'Clubhouse Partners', 'lydia' ),
        'description'           => __( 'Custom Post for Clubhouse Partners', 'lydia' ),
        'capability_type'       => 'post',
        'rewrite'               => ['slug' => 'clubhouse-partners', 'with_front' => false],
        'public'                => true,
        'has_archive'           => true,
        'hierarchical'          => false,
        'menu_position'         => 25,
        'menu_icon'             => 'dashicons-groups',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'exclude_from_search'   => true,
        'publicly_queryable'    => true,
        'show_in_rest'          => true,
        'show_in_graphql'       => true,
        'graphql_single_name'   => 'partner',
        'graphql_plural_name'   => 'partners',
        'rest_base'             => 'clubhouse-partners',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
        'supports'              => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'taxonomies'            => [],
        'labels'                => [
            'name'               => _x( 'Clubhouse Partners', 'Post Type General Name', 'lydia' ),
            'singular_name'      => _x( 'Clubhouse Partner', 'Post Type Singular Name', 'lydia' ),
            'menu_name'          => __( 'Club Partners', 'lydia' ),
            'name_admin_bar'     => __( 'Clubhouse Partners', 'lydia' ),
            'parent_item_colon'  => __( 'Parent Clubhouse Partner:', 'lydia' ),
            'all_items'          => __( 'All Clubhouse Partners', 'lydia' ),
            'add_new_item'       => __( 'Add New Clubhouse Partner', 'lydia' ),
            'add_new'            => __( 'Add New', 'lydia' ),
            'new_item'           => __( 'New Clubhouse Partner', 'lydia' ),
            'edit_item'          => __( 'Edit Clubhouse Partner', 'lydia' ),
            'update_item'        => __( 'Update Clubhouse Partner', 'lydia' ),
            'view_item'          => __( 'View Clubhouse Partner', 'lydia' ),
            'search_items'       => __( 'Search Clubhouse Partner', 'lydia' ),
            'not_found'          => __( 'No Clubhouse Partner found', 'lydia' ),
            'not_found_in_trash' => __( 'No Clubhouse Partner found in Trash', 'lydia' )
        ]
    ] );
} );

function clubhouse_options_page()
{
    if ( function_exists( 'acf_add_options_sub_page' ) ) {
        $page = acf_add_options_sub_page( [
            'page_title' => 'Clubhouse Partners Options',
            'menu_title' => 'Clubhouse Partners Options',
            'menu_slug'  => 'clubhouse-partners-options',
            'capability' => 'edit_posts',
            'parent'     => 'edit.php?post_type=clubhouse-partners',
            'position'   => 50,
            'redirect'   => true,
            'post_id'    => 'clubhouse-partners-options',
            'show_in_graphql'       => true
        ] );
    }
}

add_action( 'init', 'clubhouse_options_page' );
