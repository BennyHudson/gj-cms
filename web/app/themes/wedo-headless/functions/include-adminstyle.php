<?php
	function annointed_admin_bar_remove() {
        global $wp_admin_bar;
	    $wp_admin_bar->remove_menu('wp-logo');
	}
?>
