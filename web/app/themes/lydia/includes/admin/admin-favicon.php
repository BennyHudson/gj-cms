<?php
/**
 * Set BMAS Favicon in wp admin
 * --------
 * @category Admin
 * @version 1.0
 * @package Lydia/Admin
 */
defined( 'ABSPATH' ) || exit;

function lydia_admin_favicon()
{
    echo '<link rel="shortcut icon" href="' . get_template_directory_uri() . '/includes/admin/img/favicon-bmas-admin.ico" />';
}

add_action( 'login_head', 'lydia_admin_favicon' );
add_action( 'admin_head', 'lydia_admin_favicon' );
