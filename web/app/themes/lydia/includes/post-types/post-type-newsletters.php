<?php

// add_action( 'init', function () {
//     register_post_type( 'newsletters', [
//         'capability_type'     => 'post',
//         'hierarchical'        => false,
//         'has_archive'         => false,
//         'menu_position'       => 25,
//         'menu_icon'           => 'dashicons-email',
//         'public'              => true,
//         'exclude_from_search' => true,
//         'publicly_queryable'  => true,
//         'query_var'           => true,
//         'show_in_nav_menus'   => true,
//         'show_in_admin_bar'   => true,
//         'can_export'          => true,
//         'show_in_rest'        => true,
//         'rest_base'           => 'newsletters',
//         'rewrite'             => ['slug' => 'newsletters', 'with_front' => false],
//         'supports'            => ['title', 'thumbnail', 'custom-fields', 'page-attributes'],
//         'label'               => __( 'Newsletters', 'lydia' ),
//         'description'         => __( 'Newsletter Posts', 'lydia' ),
//         'labels'              => [
//             'name'               => _x( 'Newsletters', 'Post Type General Name', 'lydia' ),
//             'singular_name'      => _x( 'Newsletter', 'Post Type Singular Name', 'lydia' ),
//             'menu_name'          => __( 'Newsletters', 'lydia' ),
//             'name_admin_bar'     => __( 'Newsletters', 'lydia' ),
//             'parent_item_colon'  => __( 'Parent Newsletter:', 'lydia' ),
//             'all_items'          => __( 'All Newsletters', 'lydia' ),
//             'add_new_item'       => __( 'Add New Newsletter', 'lydia' ),
//             'add_new'            => __( 'Add New', 'lydia' ),
//             'new_item'           => __( 'New Newsletter', 'lydia' ),
//             'edit_item'          => __( 'Edit Newsletter', 'lydia' ),
//             'update_item'        => __( 'Update Newsletter', 'lydia' ),
//             'view_item'          => __( 'View Newsletter', 'lydia' ),
//             'search_items'       => __( 'Search Newsletters', 'lydia' ),
//             'not_found'          => __( 'No Newsletters found', 'lydia' ),
//             'not_found_in_trash' => __( 'No Newsletters found in Trash', 'lydia' )
//         ]
//     ] );
// } );

function newsletter_options_page()
{
    if ( function_exists( 'acf_add_options_sub_page' ) ) {
        $page = acf_add_options_sub_page( [
            'page_title' => 'Newsletter Options',
            'menu_title' => 'Newsletter Options',
            'menu_slug'  => 'newsletter-options',
            'capability' => 'edit_posts',
            'parent'     => 'edit.php?post_type=newsletters',
            'position'   => 50,
            'redirect'   => true,
            'post_id'    => 'newsletter-options',
            'show_in_graphql'       => true
        ] );
    }
}

// add_action( 'init', 'newsletter_options_page' );
