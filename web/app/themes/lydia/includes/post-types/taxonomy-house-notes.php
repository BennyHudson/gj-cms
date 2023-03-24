<?php
/**
 * Clubhouse House Notes -Categories
 * --------
 * @category Post-Types
 * @version 1.0
 * @package Lydia
 */
defined( 'ABSPATH' ) || exit;

add_action( 'init', function () {
    register_taxonomy( 'house-note-category', ['house-note'], [
        'hierarchical'      => false,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud'     => false,
        'rewrite'           => ['with_front' => false],
        'labels'            => [
            'name'                       => _x( 'Categories', 'Taxonomy General Name', 'lydia' ),
            'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'lydia' ),
            'menu_name'                  => __( 'Categories', 'lydia' ),
            'all_items'                  => __( 'All Categories', 'lydia' ),
            'parent_item'                => __( 'Parent Category', 'lydia' ),
            'parent_item_colon'          => __( 'Parent Category:', 'lydia' ),
            'new_item_name'              => __( 'New Category', 'lydia' ),
            'add_new_item'               => __( 'Add New Category', 'lydia' ),
            'edit_item'                  => __( 'Edit Category', 'lydia' ),
            'update_item'                => __( 'Update Category', 'lydia' ),
            'view_item'                  => __( 'View Category', 'lydia' ),
            'separate_items_with_commas' => __( 'Separate Categories with commas', 'lydia' ),
            'add_or_remove_items'        => __( 'Add or remove Categories', 'lydia' ),
            'choose_from_most_used'      => __( 'Choose from the most used Category', 'lydia' ),
            'popular_items'              => __( 'Popular Categories', 'lydia' ),
            'search_items'               => __( 'Search Categories', 'lydia' ),
            'not_found'                  => __( 'Category Not Found', 'lydia' )
        ]
    ] );
} );
