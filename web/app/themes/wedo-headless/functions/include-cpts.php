<?php
	function wedo_posts() {
		register_post_type(
			'landing-pages',
			[
				'public' => true,
				'has_archive' => true,
				'label' => 'Landing Pages',
				'show_in_graphql' => true,
				'supports'		=> array(
					'title',
					'editor',
					'excerpt',
					'revisions',
					'thumbnail'
				),
				'graphql_single_name' => 'landingPage',
				'graphql_plural_name' => 'landingPages'
			]
		);
	}
	function wedo_taxonomies() {
		/*
			register_taxonomy(
				'publication-type',
				'publications',
				array(
		            'labels' 		=> array(
							 			'name'              => _x( 'Publication Type', 'taxonomy general name' ),
							            'singular_name'     => _x( 'Publication Type', 'taxonomy singular name' ),
							            'search_items'      => __( 'Search Publication Types' ),
							            'all_items'         => __( 'All Publication Types' ),
							            'parent_item'       => __( 'Parent Publication Type' ),
							            'parent_item_colon' => __( 'Parent Publication Type:' ),
							            'edit_item'         => __( 'Edit Publication Type' ),
							            'update_item'       => __( 'Update Publication Type' ),
							            'add_new_item'      => __( 'Add New Publication Type' ),
							            'new_item_name'     => __( 'New Publication Type' ),
							            'menu_name'         => __( 'Publication Types' ),
							        ),
		            'hierarchical' => true,
		        )
			);
		*/
    }
?>
