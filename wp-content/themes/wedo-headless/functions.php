<?php

	add_action( 'after_setup_theme', 'wedo_theme_setup');

	function wedo_theme_setup() {
		add_action('login_enqueue_scripts', 'wedo_login_logo');
		add_action('login_head', 'wedo_favicon');
		add_action('admin_head', 'wedo_favicon');
		add_action('init', 'wedo_posts');
		add_action('init', 'wedo_taxonomies');
		add_action('init', 'wedo_options');
		add_action('init', 'wedo_menus' );
		add_action('init', 'flush_rewrite_rules');
		add_action('wp_before_admin_bar_render', 'wedo_admin_bar', 0);
		add_filter('wp_mail_from_name', 'new_mail_from_name');
		add_filter('wpseo_metabox_prio', function() { return 'low';});
		add_filter('admin_footer_text', 'wedo_footer');
		add_image_size('post-thumb', 510, 340, true);
		add_image_size('post-square', 510, 510, true);
		add_theme_support('automatic-feed-links');
		add_theme_support('post-thumbnails');
	}

	get_template_part('functions/include', 'adminstyle');
	get_template_part('functions/include', 'cpts');
	get_template_part('functions/include', 'email');
	get_template_part('functions/include', 'favicons');
	get_template_part('functions/include', 'footer');
	get_template_part('functions/include', 'menus');
	get_template_part('functions/include', 'options');
	get_template_part('functions/include', 'taxonomies');

	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'feed_links', 2);
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('wp_head', 'start_post_rel_link', 10, 0);
	remove_action('wp_head', 'parent_post_rel_link', 10, 0);
	remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

	add_filter( 'graphql_connection_max_query_amount', function( $amount, $source, $args, $context, $info  ) {
    $amount = 1000; // increase post limit to 1000
    return $amount;
	}, 10, 5 );

	add_filter( 'graphql_object_visibility', function( $visibility, $model_name, $data, $owner, $current_user ) {
		if ( 'UserObject' === $model_name ) {
			$visibility = 'public';
		}

		return $visibility;
	}, 10, 5 );

	add_filter( 'preview_post_link', 'headless_preview' );

	function headless_preview() {
		global $post;
		$postType = get_post_type();
		$post_id = get_the_id();
		return "https://gj-2023-preview.vercel.app/api/preview/?postType=$postType&id=$post_id";
	}
?>
