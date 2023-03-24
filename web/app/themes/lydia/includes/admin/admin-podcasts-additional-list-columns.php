<?php
/**
 * Add additional columns to podcast lists
 * --------
 * @category Admin
 * @version 1.0
 * @package Lydia/Admin
 */
defined( 'ABSPATH' ) || exit;

// Add the custom columns to the podcast post type:
add_filter( 'manage_podcasts_posts_columns', 'set_custom_edit_podcasts_columns', 5 );
function set_custom_edit_podcasts_columns( $columns )
{

    $columns['source']  = __( 'Source', 'lydia' );
    $columns['episode'] = __( 'Episode', 'lydia' );
    $columns['guest']   = __( 'Guest', 'lydia' );

    return $columns;
}

// Add the data to the custom columns for the podcast post type:
add_action( 'manage_podcasts_posts_custom_column', 'custom_podcasts_column', 10, 2 );
/**
 * @param $column
 * @param $post_id
 */
function custom_podcasts_column(
    $column,
    $post_id
) {

    $meta = get_field( 'podcast_meta', $post_id );

    switch ( $column ) {

        case 'episode':

            if ( is_string( $meta['number'] ) ) {
                echo $meta['number'];
            }

            break;

        case 'source':

            if ( is_string( $meta['media']['audio'] ) ) {
                echo $meta['media']['audio'];
            }

            break;

        case 'guest':
            if ( is_string( $meta['guest']['name'] ) ) {
                echo $meta['guest']['name'];
            }

            break;

    }
}
