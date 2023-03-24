<?php
/**
 * Security Enhancments to wp admin
 * --------
 * @category Admin
 * @version 1.0
 * @package Lydia/Admin
 */
defined( 'ABSPATH' ) || exit;

// Protect from Malicious ULR requests
global $user_ID;

if ( $user_ID ) {
    if ( ! current_user_can( 'level_10' ) ) {
        if ( strlen( $_SERVER['REQUEST_URI'] ) > 255 ||
            strpos( $_SERVER['REQUEST_URI'], 'eval(' ) ||
            strpos( $_SERVER['REQUEST_URI'], 'CONCAT' ) ||
            strpos( $_SERVER['REQUEST_URI'], 'UNION+SELECT' ) ||
            strpos( $_SERVER['REQUEST_URI'], 'base64' ) ) {
            @header( 'HTTP/1.1 414 Request-URI Too Long' );
            @header( 'Status: 414 Request-URI Too Long' );
            @header( 'Connection: Close' );
            @exit;
        }
    }
}

// Remove WP version number from head
remove_action( 'wp_head', 'rsd_link' );                       // remove really simple discovery link
remove_action( 'wp_head', 'wp_generator' );                   // remove wordpress version
remove_action( 'wp_head', 'feed_links', 2 );                  // remove rss feed links (make sure you add them in yourself if youre using feedblitz or an rss service)
remove_action( 'wp_head', 'feed_links_extra', 3 );            // removes all extra rss feed links
remove_action( 'wp_head', 'index_rel_link' );                 // remove link to index page
remove_action( 'wp_head', 'wlwmanifest_link' );               // remove wlwmanifest.xml (needed to support windows live writer)
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );     // remove random post link
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );    // remove parent post link
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // remove the next and previous post links
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );

remove_action( 'wp_head', 'wp_oembed_add_discovery_links');
remove_action( 'wp_head', 'wp_oembed_add_host_js');
remove_action( 'wp_head', 'rest_output_link_wp_head', 10);


remove_action( 'wp_head', 'print_emoji_detection_script', 7);
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles');
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email');
add_filter('emoji_svg_url', '__return_false');
add_filter('show_recent_comments_widget_style', '__return_false');

add_filter( 'use_default_gallery_style', '__return_false' );

add_filter('the_generator', '__return_false');

/**
 * Don't return the default description in the RSS feed if it hasn't been changed
 */
function lydia_remove_default_description($bloginfo) {
    $default_tagline = 'Just another WordPress site';
    return ($bloginfo === $default_tagline) ? '' : $bloginfo;
  }
  add_filter('get_bloginfo_rss', 'lydia_remove_default_description');


  /**
 * Remove unnecessary self-closing tags
 */
function lydia_remove_self_closing_tags($input) {
    return str_replace(' />', '>', $input);
  }
  add_filter('get_avatar', 'lydia_remove_self_closing_tags'); // <img />
  add_filter('comment_id_fields', 'lydia_remove_self_closing_tags'); // <input />
  add_filter('post_thumbnail_html', 'lydia_remove_self_closing_tags'); // <img />


  /**
 * Wrap embedded media as suggested by Readability
 *
 * @link https://gist.github.com/965956
 * @link http://www.readability.com/publishers/guidelines#publisher
 */
function lydia_embed_wrap($cache) {
    return '<div class="entry-content-asset">' . $cache . '</div>';
  }
  add_filter('embed_oembed_html','lydia_embed_wrap');


function add_gf_cap()
{
    $role = get_role( 'editor' );
    $role->add_cap( 'gform_full_access' );
}
 add_action( 'admin_init', 'add_gf_cap' );
