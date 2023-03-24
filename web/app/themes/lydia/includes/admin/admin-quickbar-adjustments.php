<?php
/**
 * Adjustments and additions to wp admin quickbar
 * --------
 * @category Admin
 * @version 1.0
 * @package Lydia/Admin
 */
defined( 'ABSPATH' ) || exit;

/**
 * Add Admin Bar BMAS Logo
 * --------
 * @version 1.0.0
 */
function lydia_admin_bar_add_bmas_logo()
{
    global $wp_admin_bar;

    // Add BMAS logo
    $wp_admin_bar->add_node( [
        'id'     => 'bmas_logo',
        'title'  => '<img src="' . get_template_directory_uri() . '/includes/admin/img/bmas-dashboard-logo.svg"/>',
        'href'   => 'https://bmas.agency',
        'parent' => false,
        'meta'   => ['target' => '_blank']
    ] );
}

add_action( 'admin_bar_menu', 'lydia_admin_bar_add_bmas_logo', 15 );

/**
 * Styling on Admin Bar BMAS Logo
 * --------
 * @version 1.0.0
 */
function lydia_admin_bar_styles()
{
    echo '<style>
        #wp-admin-bar-bmas_logo a {
            padding: 0 !important;
            background: #fff !important;
            transition: background 0.2s ease-out;
        }
        #wp-admin-bar-bmas_logo a:hover,
        #wp-admin-bar-bmas_logo a:focus  {
            background: #222 !important;
        }
        </style>';
}

if ( is_admin_bar_showing() ) {
    add_action( 'wp_head', 'lydia_admin_bar_styles' );
}
add_action( 'admin_head', 'lydia_admin_bar_styles' );

/**
 * Remove admin bar margin offset frontend
 * --------
 * @version 1.0.0
 */
add_theme_support( 'admin-bar', ['callback' => '__return_false'] );

/**
 * Remove Unused Items from the Admin Bar
 * --------
 * @version 1.0.0
 */
function lydia_admin_bar_remove_items()
{
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu( 'comments' );
    $wp_admin_bar->remove_menu( 'customize' );
    $wp_admin_bar->remove_menu( 'wp-logo' );
}

add_action( 'wp_before_admin_bar_render', 'lydia_admin_bar_remove_items' );
