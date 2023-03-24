<?php
/**
 * Remove Unused Post Meta Boxes
 * --------
 * @category Admin
 * @version 1.0
 * @package Lydia/Admin
 */
defined( 'ABSPATH' ) || exit;

/**
 * Remove unused Post and Page Edit Boxes
 * --------
 * @version 1.0.0
 */
function lydia_remove_post_meta_boxes()
{
    // Removes meta boxes from Posts
    remove_meta_box( 'postcustom', 'post', 'normal' );
    remove_meta_box( 'trackbacksdiv', 'post', 'normal' );
    remove_meta_box( 'commentstatusdiv', 'post', 'normal' );
    remove_meta_box( 'commentsdiv', 'post', 'normal' );
    remove_meta_box( 'tagsdiv-post_tag', 'post', 'normal' );
    remove_meta_box( 'revisionsdiv', 'post', 'normal' );
    // Removes meta boxes from pages
    remove_meta_box( 'postcustom', 'page', 'normal' );
    remove_meta_box( 'trackbacksdiv', 'page', 'normal' );
    remove_meta_box( 'commentstatusdiv', 'page', 'normal' );
    remove_meta_box( 'commentsdiv', 'page', 'normal' );
}

add_action( 'admin_init', 'lydia_remove_post_meta_boxes' );

/**
 * Remove tags support from posts
 * --------
 * @version 1.0.0
 */
function lydia_unregister_tags()
{
    unregister_taxonomy_for_object_type( 'post_tag', 'post' );
}

add_action( 'init', 'lydia_unregister_tags' );
