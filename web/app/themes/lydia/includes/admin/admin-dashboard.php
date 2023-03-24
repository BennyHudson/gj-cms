<?php
/**
 * Admin Dashboard Additions
 * --------
 * @category Admin
 * @version 1.0
 * @package Lydia/Admin
 */
defined( 'ABSPATH' ) || exit;

/**
 * Dashboard - Theme help
 * --------
 * @version 2.0.0
 */
function lydia_help_widget_content()
{

    // Output the content
    $site_title = get_bloginfo( 'name' );
    $site_url   = get_bloginfo( 'url' );

    echo '<h2>Welcome to ' . $site_title . '</h2>';
    echo '<p>This website was developed by <a href="https://bmas.agency" target="_blank">BMAS Agency</a><br>';
    echo 'If you require any support or are facing any issues with the website please</p>';
    echo '<a class="button" target="_blank" href="mailto:support@bmas.agency?subject=[Support] ' . $site_title . ' : ' . $site_url . '">Contact Support</a>';
}

/**
 * Remove Dashboard Widgets
 * --------
 * @version 1.0.0
 */
function lydia_order_dashboard_widgets()
{
    global $wp_meta_boxes;

    // Then unset everything in the array
    unset( $wp_meta_boxes['dashboard']['normal']['core'] );
    unset( $wp_meta_boxes['dashboard']['side']['core'] );

    // Add back widgets to left column
    add_meta_box( 'lydia_help_widget', __( 'Website Support' ), 'lydia_help_widget_content', 'dashboard', 'normal', 'core' );
    add_meta_box( 'dashboard_right_now', __( 'Right Now' ), 'wp_dashboard_right_now', 'dashboard', 'side', 'core' );

}

add_action( 'wp_dashboard_setup', 'lydia_order_dashboard_widgets' );

/**
 * Admin Footer
 * --------
 * @version 1.0.0
 */
function lydia_change_admin_dashboard_footer()
{
    echo 'Powered by <a href="https://www.wordpress.org" target="_blank">WordPress</a> | Crafted by <a href="https://bmas.agency" target="_blank">BMAS Agency</a></p>';
}

add_filter( 'admin_footer_text', 'lydia_change_admin_dashboard_footer' );
