<?php
/**
 * Remove Unwanted wordpress features
 * --------
 * @category Admin
 * @version 1.0
 * @package Lydia/Admin
 */
defined( 'ABSPATH' ) || exit;

/**
 * Remove Post by Email settings
 * --------
 * @version 1.0.0
 */
add_filter( 'enable_post_by_email_configuration', '__return_false' );

/**
 * Remove Links Manager if pre 3.5
 * --------
 * @version 1.0.0
 */
update_option( 'link_manager_enabled', 0 );


/**
 * Hide the Cotent Editor on a pages
 * --------
 * @version 1.0.0
 */
function lydia_hide_editor() {
    global $pagenow;
    if( !( 'post.php' == $pagenow ) ) return;

    $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
    if( !isset( $post_id ) ) return;

    remove_post_type_support('page', 'editor');
}
add_action( 'admin_head', 'lydia_hide_editor' );
