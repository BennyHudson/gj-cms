<?php
	function wedo_posts() {
		register_post_type( 
			'article', [
				'labels' => [
					'name' 								=> 'Articles',
					'singular_name' 			=> 'Article',
					'all_items' 					=> 'All Articles',
					'add_new' 						=> 'Add New',
					'add_new_item' 				=> 'Add New Article',
					'edit' 								=> 'Edit',
					'edit_item' 					=> 'Edit Article',
					'new_item' 						=> 'New Article',
					'view_item' 					=> 'View Article',
					'search_items' 				=> 'Search Articles',
					'parent_item_colon' 	=> ''
				],
				'capability_type'       => 'post',
				'description'           => 'Custom Post for Articles',
				'rewrite'               => ['slug' => 'article'],
				'public'                => true,
				'has_archive'           => true,
				'hierarchical'          => false,
				'menu_position'         => 5,
				'menu_icon'             => 'dashicons-welcome-write-blog',
				'show_in_rest'          => true,
				'rest_base'             => 'articles',
				'rest_controller_class' => 'WP_REST_Posts_Controller',
				'supports'              => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields', 'revisions', 'page-attributes', 'amp', 'post-formats'],
				'taxonomies'            => ['category'],
				'show_in_graphql'       => true,
				'graphql_single_name' 	=> 'article',
				'graphql_plural_name' 	=> 'articles',
			] 
		);

		register_post_type( 
			'clubhouse-partners', [
				'labels' => [
					'name' 								=> 'Clubhouse Partners',
					'singular_name' 			=> 'Clubhouse Partner',
					'all_items' 					=> 'All Clubhouse Partners',
					'add_new' 						=> 'Add New',
					'add_new_item' 				=> 'Add New Clubhouse Partner',
					'edit' 								=> 'Edit',
					'edit_item' 					=> 'Edit Clubhouse Partner',
					'new_item' 						=> 'New Clubhouse Partner',
					'view_item' 					=> 'View Clubhouse Partner',
					'search_items' 				=> 'Search Clubhouse Partners',
					'parent_item_colon' 	=> ''
				],
				'capability_type'       => 'post',
				'description'           => 'Custom Post for Clubhouse Partners',
				'rewrite'               => ['slug' => 'clubhouse-partners'],
				'public'                => true,
				'has_archive'           => true,
				'hierarchical'          => false,
				'menu_position'         => 5,
				'menu_icon'             => 'dashicons-groups',
				'show_in_rest'          => true,
				'rest_base'             => 'clubhouse-partners',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
				'supports'              => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields', 'revisions', 'page-attributes', 'amp', 'post-formats'],
				'taxonomies'            => [],
				'show_in_graphql'       => true,
				'graphql_single_name' 	=> 'clubhousePartner',
				'graphql_plural_name' 	=> 'clubhousePartners',
			] 
		);

		register_post_type( 
			'events', [
				'labels' => [
					'name' 								=> 'Events',
					'singular_name' 			=> 'Event',
					'all_items' 					=> 'All Events',
					'add_new' 						=> 'Add New',
					'add_new_item' 				=> 'Add New Event',
					'edit' 								=> 'Edit',
					'edit_item' 					=> 'Edit Event',
					'new_item' 						=> 'New Event',
					'view_item' 					=> 'View Event',
					'search_items' 				=> 'Search Events',
					'parent_item_colon' 	=> ''
				],
				'capability_type'       => 'post',
				'description'           => 'Custom Post for Events',
				'rewrite'               => ['slug' => 'event'],
				'public'                => true,
				'has_archive'           => true,
				'hierarchical'          => false,
				'menu_position'         => 5,
				'menu_icon'           	=> 'dashicons-tickets-alt',
				'show_in_rest'          => true,
				'rest_base'             => 'events',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
				'supports'              => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields', 'revisions', 'page-attributes', 'amp', 'post-formats'],
				'taxonomies'            => [],
				'show_in_graphql'       => true,
				'graphql_single_name' 	=> 'event',
				'graphql_plural_name' 	=> 'events',
			] 
		);

		register_post_type( 
			'gentleman', [
				'labels' => [
					'name' 								=> 'Gentlemen',
					'singular_name' 			=> 'Gentleman',
					'all_items' 					=> 'All Gentlemen',
					'add_new' 						=> 'Add New',
					'add_new_item' 				=> 'Add New Gentleman',
					'edit' 								=> 'Edit',
					'edit_item' 					=> 'Edit Gentleman',
					'new_item' 						=> 'New Gentleman',
					'view_item' 					=> 'View Gentleman',
					'search_items' 				=> 'Search Gentlemen',
					'parent_item_colon' 	=> ''
				],
				'capability_type'       => 'post',
				'description'           => 'Custom Post for Gentlemen',
				'rewrite'               => ['slug' => 'gentleman'],
				'public'                => true,
				'has_archive'           => true,
				'hierarchical'          => false,
				'menu_position'         => 5,
				'menu_icon'             => 'dashicons-businessman',
				'show_in_rest'          => true,
				'rest_base'             => 'gentlemen',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
				'supports'              => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields', 'revisions', 'page-attributes', 'amp', 'post-formats'],
				'taxonomies'            => [],
				'show_in_graphql'       => true,
				'graphql_single_name' 	=> 'gentleman',
				'graphql_plural_name' 	=> 'gentlemen',
			] 
		);

		register_post_type( 
			'gift', [
				'labels' => [
					'name' 								=> 'Gifts',
					'singular_name' 			=> 'Gift',
					'all_items' 					=> 'All Gifts',
					'add_new' 						=> 'Add New',
					'add_new_item' 				=> 'Add New Gift',
					'edit' 								=> 'Edit',
					'edit_item' 					=> 'Edit Gift',
					'new_item' 						=> 'New Gift',
					'view_item' 					=> 'View Gift',
					'search_items' 				=> 'Search Gifts',
					'parent_item_colon' 	=> ''
				],
				'capability_type'       => 'post',
				'description'           => 'Custom Post for Gifts',
				'rewrite'               => ['slug' => 'gift'],
				'public'                => true,
				'has_archive'           => true,
				'hierarchical'          => false,
				'menu_position'         => 5,
				'menu_icon'             => 'dashicons-products',
				'show_in_rest'          => true,
				'rest_base'             => 'gifts',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
				'supports'              => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields', 'revisions', 'page-attributes', 'amp', 'post-formats'],
				'taxonomies'            => [],
				'show_in_graphql'       => true,
				'graphql_single_name' 	=> 'gift',
				'graphql_plural_name' 	=> 'gifts',
			] 
		);

		register_post_type( 
			'house-note', [
				'labels' => [
					'name' 								=> 'House Notes',
					'singular_name' 			=> 'House Note',
					'all_items' 					=> 'All House Notes',
					'add_new' 						=> 'Add New',
					'add_new_item' 				=> 'Add New House Note',
					'edit' 								=> 'Edit',
					'edit_item' 					=> 'Edit House Note',
					'new_item' 						=> 'New House Note',
					'view_item' 					=> 'View House Note',
					'search_items' 				=> 'Search House Notes',
					'parent_item_colon' 	=> ''
				],
				'capability_type'       => 'post',
				'description'           => 'Custom Post for House Notes',
				'rewrite'               => ['slug' => 'house-note'],
				'public'                => true,
				'has_archive'           => true,
				'hierarchical'          => false,
				'menu_position'         => 5,
				'menu_icon'             => 'dashicons-edit',
				'show_in_rest'          => true,
				'rest_base'             => 'house-notes',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
				'supports'              => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields', 'revisions', 'page-attributes', 'amp', 'post-formats'],
				'taxonomies'            => [],
				'show_in_graphql'       => true,
				'graphql_single_name' 	=> 'houseNote',
				'graphql_plural_name' 	=> 'houseNotes',
			] 
		);

		register_post_type( 
			'landing-page', [
				'labels' => [
					'name' 								=> 'Landing Pages',
					'singular_name' 			=> 'Landing Page',
					'all_items' 					=> 'All Landing Pages',
					'add_new' 						=> 'Add New',
					'add_new_item' 				=> 'Add New Landing Page',
					'edit' 								=> 'Edit',
					'edit_item' 					=> 'Edit Landing Page',
					'new_item' 						=> 'New Landing Page',
					'view_item' 					=> 'View Landing Page',
					'search_items' 				=> 'Search Landing Pages',
					'parent_item_colon' 	=> ''
				],
				'capability_type'       => 'post',
				'description'           => 'Custom Post for Landing Pages',
				'rewrite'               => ['slug' => 'landing-page'],
				'public'                => true,
				'has_archive'           => true,
				'hierarchical'          => false,
				'menu_position'         => 5,
				'menu_icon'             => 'dashicons-welcome-view-site',
				'show_in_rest'          => true,
				'rest_base'             => 'landing-pages',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
				'supports'              => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields', 'revisions', 'page-attributes', 'amp', 'post-formats'],
				'taxonomies'            => [],
				'show_in_graphql'       => true,
				'graphql_single_name' 	=> 'landingPage',
				'graphql_plural_name' 	=> 'landingPages',
			] 
		);

		register_post_type( 
			'podcasts', [
				'labels' => [
					'name' 								=> 'Podcasts',
					'singular_name' 			=> 'Podcast',
					'all_items' 					=> 'All Podcasts',
					'add_new' 						=> 'Add New',
					'add_new_item' 				=> 'Add New Podcast',
					'edit' 								=> 'Edit',
					'edit_item' 					=> 'Edit Podcast',
					'new_item' 						=> 'New Podcast',
					'view_item' 					=> 'View Podcast',
					'search_items' 				=> 'Search Podcasts',
					'parent_item_colon' 	=> ''
				],
				'capability_type'       => 'post',
				'description'           => 'Custom Post for Podcasts',
				'rewrite'               => ['slug' => 'podcast'],
				'public'                => true,
				'has_archive'           => true,
				'hierarchical'          => false,
				'menu_position'         => 5,
				'menu_icon'             => 'dashicons-format-audio',
				'show_in_rest'          => true,
				'rest_base'             => 'podcasts',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
				'supports'              => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields', 'revisions', 'page-attributes', 'amp', 'post-formats'],
				'taxonomies'            => [],
				'show_in_graphql'       => true,
				'graphql_single_name' 	=> 'podcast',
				'graphql_plural_name' 	=> 'podcasts',
			] 
		);
	}

	function wedo_taxonomies() {}
?>
