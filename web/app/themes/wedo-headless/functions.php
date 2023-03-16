<?php

  @ini_set( 'upload_max_size' , '64M' );
  @ini_set( 'post_max_size', '64M');
  @ini_set( 'max_execution_time', '300' );

	add_action( 'after_setup_theme', 'wedo_theme_setup' );
	function wedo_theme_setup() {
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_action( 'widgets_init', 'wedo_register_sidebars' );
		add_filter('wp_mail_from_name', 'new_mail_from_name');
		add_action( 'init', 'register_my_menus' );
		add_action( 'login_enqueue_scripts', 'my_login_logo' );
		add_action('login_head', 'add_favicon');
		add_action('admin_head', 'add_favicon');
		add_action('init', 'wedo_posts');
		add_action('init', 'wedo_taxonomies');
		add_action('init', 'flush_rewrite_rules');
		add_action( 'wp_enqueue_scripts', 'wedo_scripts' );
		add_action('wp_before_admin_bar_render', 'annointed_admin_bar_remove', 0);
		add_filter( 'wpseo_metabox_prio', function() { return 'low';});
		add_image_size( 'gallery-thumb', 300, 240, true );
		add_image_size( 'post-feature', 900, 450, true );
    add_filter('woocommerce_add_to_cart_redirect', 'wedo_add_to_cart_redirect');
    add_filter( 'woocommerce_product_single_add_to_cart_text', 'wedo_cart_button_text' );
    add_filter( 'woocommerce_product_add_to_cart_text', 'wedo_cart_button_text' );
    add_filter('gettext', 'wedo_change_cart_string', 100, 3);
    add_filter( 'woocommerce_cart_item_permalink', '__return_null' );
    add_filter( 'woocommerce_cart_item_thumbnail', '__return_false' );
    add_filter( 'woocommerce_persistent_cart_enabled', '__return_false' );
	}

	get_template_part('functions/include', 'adminstyle');
	get_template_part('functions/include', 'favicons');
	get_template_part('functions/include', 'postnav');
	get_template_part('functions/include', 'menus');
	get_template_part('functions/include', 'scripts');
	get_template_part('functions/include', 'sidebar');
	get_template_part('functions/include', 'cpts');
	get_template_part('functions/include', 'users');
	get_template_part('functions/include', 'email');
	get_template_part('functions/include', 'footer');
	get_template_part('functions/include', 'gallery');

	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'feed_links', 2);
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('wp_head', 'start_post_rel_link', 10, 0);
	remove_action('wp_head', 'parent_post_rel_link', 10, 0);
	remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

	add_filter('acf/settings/google_api_key', function () {
	    return 'AIzaSyBR5bX6m_CEPwitun65XjrFWYZVRtzqADA';
	});

	
?>
