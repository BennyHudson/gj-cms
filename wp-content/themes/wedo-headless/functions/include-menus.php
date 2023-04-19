<?php
	function wedo_menus() {
	  register_nav_menus(array( 
				'header'      => __( 'Header Menu' ),
				'footer'      => __( 'Footer Menu' ),
				'footer-info' => __( 'Footer Menu Info' ),
				'footer-cat'  => __( 'Footer Menu Cat' )
			)
	  );
	}
?>
