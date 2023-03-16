<?php
	function wedo_register_sidebars() {
		register_sidebar( array(
			'name' => 'Sidebar',
			'id' => 'blog-sidebar',
			'before_widget' => '<section class="widget">',
			'after_widget' => '</section></section>',
			'before_title' => '<h2>',
			'after_title' => '</h2><section class="widget-body">',
		) );
	}
?>
