<?php

/**
 * Set a post meta data if it is a print article or delete it if no longer a print article
 */
function set_print_article( $post_id ) {
	//9415 is the category ID of Print on the main website
	$isPrint = in_category(9415, $post_id);
	if ($isPrint) {
		add_post_meta($post_id, 'print_article', true, true);
	} elseif (get_post_meta($post_id, 'print_article') && !$isPrint) {
		delete_post_meta($post_id, 'print_article');
	}
}
add_action( 'save_post', 'set_print_article' );

