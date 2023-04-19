<?php
	function wedo_admin_bar() {
		global $wp_admin_bar;

		$wp_admin_bar->remove_menu('wp-logo');
		$wp_admin_bar->remove_menu('comments');
		$wp_admin_bar->remove_menu('view-site');
		$wp_admin_bar->remove_menu('view-store');

		$site_node = $wp_admin_bar->get_node('site-name');
		$site_node->href = 'https://thegentlemansjournal.com';
		$wp_admin_bar->add_node($site_node);
	}
?>
