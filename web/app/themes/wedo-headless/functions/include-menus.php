<?php
	function register_my_menus() {
	  register_nav_menus(
		array( 'mobile-menu' 	=> __( 'Mobile Menu' ),
			   'footer-menu' 	=> __( 'Footer Menu' ),
			   'header-menu' 	=> __( 'Header Menu' ),
			   'signposts'	 	=> __( 'Signposts' )
			 )
	  );
	}
?>
