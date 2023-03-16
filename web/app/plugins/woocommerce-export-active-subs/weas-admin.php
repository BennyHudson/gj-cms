<?php

if (!class_exists('Woocommerce')) {
	echo '<p>Woocommerce is not detected on your system. Please install the plugin and re-load this page.</p>';
	return;
}

$adminPage = add_submenu_page('woocommerce', 'Export Active and Pending Cancel Subscriptions', 'Export Active Subs', 'manage_options', 'weas-admin', 'weas_admin');

add_action('load-' . $adminPage, 'load_admin_scripts');


function weas_admin() {
	require('weas-admin-template.php');
}

function load_admin_scripts() {
	wp_enqueue_script('weas-scripts', plugin_dir_url( __FILE__ ) . '/weas-admin.js', ['jquery']);
}
