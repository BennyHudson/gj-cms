<?php
	function my_login_logo() { ?>
	    <style type="text/css">
	        body.login div#login h1 a {
	            background-image: url(<?php echo get_bloginfo( 'template_directory' ) ?>/images/favicons/apple-touch-icon-120x120.png);
				display: block;
				background-size: contain;
	        }
	    </style>
	<?php }

	function my_login_logo_url() {
	    return get_bloginfo( 'url' );
	}
	add_filter( 'login_headerurl', 'my_login_logo_url' );
	// First, create a function that includes the path to your favicon
	function add_favicon() {
	  	$favicon_url = get_stylesheet_directory_uri() . '/images/favicons/favicon.ico';
		echo '<link rel="shortcut icon" href="' . $favicon_url . '" />';
}
?>
