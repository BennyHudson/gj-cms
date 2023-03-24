<?php
/**
 * Add additional columns to post and page lists
 * --------
 * @category Admin
 * @version 1.0
 * @package Lydia/Admin
 */
defined( 'ABSPATH' ) || exit;

/**
 * Add Columns to Post and Page
 * --------
 * @version 1.0.0
 */
function lydia_add_post_list_columns( $columns )
{
    return array_merge( $columns, [
        'post_id'        => __( 'ID', 'lydia' ),             // Post ID
    ] );
}

add_filter( 'manage_posts_columns', 'lydia_add_post_list_columns', 5 );
add_filter( 'manage_pages_columns', 'lydia_add_post_list_columns', 5 );

/**
 * Populate Post and Page columns
 * --------
 * @version 1.0.0
 */
function lydia_populate_post_list_columns(
    $column_name,
    $id
) {

    switch ( $column_name ) {
        case 'post_id':
            echo $id;
            break;

        default:
            break;
    }
}

add_action( 'manage_posts_custom_column', 'lydia_populate_post_list_columns', 5, 2 );
add_action( 'manage_pages_custom_column', 'lydia_populate_post_list_columns', 5, 2 );

/**
 * Remove unused columns from post lists
 * --------
 * @version 1.0.0
 */
function lydia_remove_post_columns( $defaults )
{
    unset( $defaults['comments'] );

    return $defaults;
}

add_filter( 'manage_posts_columns', 'lydia_remove_post_columns' );

/**
 * Remove unused columns from pages lists
 * --------
 * @version 1.0.0
 */
function lydia_remove_page_columns( $defaults )
{
    unset( $defaults['comments'] );
    unset( $defaults['tags'] );

    return $defaults;
}

add_filter( 'manage_pages_columns', 'lydia_remove_page_columns' );
