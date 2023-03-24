<?php
/**
 * Clubhouse Partners -Categories
 * --------
 * @category Post-Types
 * @version 1.0
 * @package Lydia
 */
defined( 'ABSPATH' ) || exit;

add_action( 'init', function () {
    register_taxonomy( 'partner-category', ['clubhouse-partners'], [
        'hierarchical'      => false,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud'     => false,
        'rewrite'           => ['with_front' => false],
        'labels'            => [
            'name'                       => _x( 'Partner Categories', 'Taxonomy General Name', 'lydia' ),
            'singular_name'              => _x( 'Partner Category', 'Taxonomy Singular Name', 'lydia' ),
            'menu_name'                  => __( 'Partner Categories', 'lydia' ),
            'all_items'                  => __( 'All Partner Categories', 'lydia' ),
            'parent_item'                => __( 'Parent Partner Category', 'lydia' ),
            'parent_item_colon'          => __( 'Parent Partner Category:', 'lydia' ),
            'new_item_name'              => __( 'New Partner Category', 'lydia' ),
            'add_new_item'               => __( 'Add New Partner Category', 'lydia' ),
            'edit_item'                  => __( 'Edit Partner Category', 'lydia' ),
            'update_item'                => __( 'Update Partner Category', 'lydia' ),
            'view_item'                  => __( 'View Partner Category', 'lydia' ),
            'separate_items_with_commas' => __( 'Separate Partner Categories with commas', 'lydia' ),
            'add_or_remove_items'        => __( 'Add or remove Partner Categories', 'lydia' ),
            'choose_from_most_used'      => __( 'Choose from the most used Partner Category', 'lydia' ),
            'popular_items'              => __( 'Popular Partner Categories', 'lydia' ),
            'search_items'               => __( 'Search Partner Categories', 'lydia' ),
            'not_found'                  => __( 'Partner Category Not Found', 'lydia' )
        ]
    ] );
} );
