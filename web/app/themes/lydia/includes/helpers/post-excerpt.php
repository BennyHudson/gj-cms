<?php
/**
 * Post excerpt adjustments
 * --------
 * @category Helpers
 * @version 1.0
 * @package Lydia
 */
defined( 'ABSPATH' ) || exit;

/**
 * Change WP Excerpt Length
 * --------
 * @since 1.5
 */
function lydia_excerpt_length( $length )
{
    return 150;
}

add_filter( 'excerpt_length', 'lydia_excerpt_length' );

/**
 * Add Read More to Excerpt
 * --------
 * @since 1.5
 */
function lydia_excerpt_read_more( $more )
{
    global $post;

    return '... <a class="c-readmore" href="' . get_permalink( $post->ID ) . '">Read more</a>';
}

add_filter( 'excerpt_more', 'lydia_excerpt_read_more' );

/**
 * Add Expert Class to the_expert
 * --------
 * @since 1.5
 */
function lydia_add_class_to_excerpt( $excerpt )
{
    return str_replace( '<p', '<p class="c-excerpt"', $excerpt );
}

add_filter( 'the_excerpt', 'lydia_add_class_to_excerpt' );
