<?php
/**
 * Hide comments section in wp admin
 * --------
 * @category Admin
 * @version 1.0
 * @package Lydia/Admin
 */
defined( 'ABSPATH' ) || exit;

function lydia_remove_comment_post_type()
{
    remove_menu_page( 'edit-comments.php' );
}

add_action( 'admin_menu', 'lydia_remove_comment_post_type' );
