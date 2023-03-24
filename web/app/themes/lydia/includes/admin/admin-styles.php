<?php
/**
 * Additional Admin styling
 * --------
 * @category Admin
 * @version 1.0
 * @package Lydia/Admin
 */
defined( 'ABSPATH' ) || exit;
/**
 * Additional Admin Styles
 * --------
 * @version 1.0.0
 */
function lydia_admin_styles()
{
    wp_register_style( 'lydia-admin-styles', get_template_directory_uri() . '/includes/admin/scss/lydia-admin.css', false, filemtime( get_stylesheet_directory() . '/includes/admin/scss/lydia-admin.css' ) );
    wp_enqueue_style( 'lydia-admin-styles' );
}

add_action( 'admin_enqueue_scripts', 'lydia_admin_styles', 5 );

// Remove Users Select Colour Profile
remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
