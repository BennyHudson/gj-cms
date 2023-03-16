<?php
	function wedo_scripts() {
		wp_enqueue_script('jquery');
		wp_enqueue_script( 'production', get_template_directory_uri() . '/js/production.min.js', array(), '1.0.0', true );
		if (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1'))) {
			wp_register_script('livereload', 'http://localhost:35729/livereload.js?snipver=1', null, false, true);
			wp_enqueue_script('livereload');
		}
	}
?>
