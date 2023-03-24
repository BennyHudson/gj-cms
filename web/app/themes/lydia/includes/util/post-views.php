<?php
/**
*  Count Post Views for Use with Most Popular
*  ------
*  @package Lydia
*  @since Lydia 1.0
*/
namespace TGJ;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class PostViews {
	static $count_key = 'post_views_count';
	static function get($postID) {
		$count_key = self::$count_key;
	    $count = get_post_meta($postID, $count_key, true);
	    if($count==''){
			$count = 0;
	        delete_post_meta($postID, $count_key);
	        add_post_meta($postID, $count_key, '0');
	    }
	    return $count;
	}
	static function update($postID) {
		$count = self::get($postID);
		$count++;
		update_post_meta($postID, self::$count_key, $count);
	}
}

// Remove issues with pre-fetching adding extra views
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
