<?php
/**
 * Functions and Definitions
 * --------
 * @category root
 * @version 1.0
 * @package Lydia
 */
defined( 'ABSPATH' ) || exit;

/**
 * Composer Autoloader
 */
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Load Timber
 * [Composer Dependency]
 */
if (class_exists('Timber\Timber')) {
    new \Timber\Timber();
}

/**
 * Load Timmy
 * [Composer Dependency]
 */
if (class_exists('Timmy\Timmy')) {
    new \Timmy\Timmy();
}

// if ( class_exists( 'WooCommerce' ) ) {
//     \Timber\Integrations\WooCommerce\WooCommerce::init();
// }


/**
 * Initialise Lydia Base
 * --------
 * @version 1.0.0
 */
new BMAS\LydiaSite;
new BMAS\Util\Development;
new BMAS\Timber\Data;
new BMAS\Timber\Functions;
new BMAS\Timber\Images;
new BMAS\Assets\Favicons;
new BMAS\Assets\Fonts;
new BMAS\Assets\Styles;
new BMAS\Assets\Scripts;
new BMAS\Ads\Admanager;
new BMAS\Ads\Skimlinks;
new BMAS\ACF\Setup;
new BMAS\ACF\Options;
new BMAS\ACF\Data;
new BMAS\WP\Menu;
new BMAS\WP\Media;
new BMAS\WP\Content;
new BMAS\WP\Guttenburg;
new BMAS\Helpers\Classes;
new BMAS\Vendor\Yoast;
new BMAS\Vendor\GoogleMaps;
new BMAS\Vendor\HotJar;
new BMAS\Util\AjaxPost;
new BMAS\Vendor\SendGridClubhouse;
BMAS\Vendor\SendGrid::register(
    "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"
);
// BMAS\Vendor\MailChimp::register();
BMAS\Forms\ContactUs::register();

add_filter( 'preview_post_link', 'headless_preview' );

	function headless_preview() {
			global $post;
			$postType = get_post_type();
			$post_id = get_the_id();
			return "https://preview.thegentlemansjournal.com/api/preview/?postType=$postType&id=$post_id";
	}

// if ( class_exists( 'WooCommerce' ) ) {
//     new BMAS\Woocommerce\Base;
//     new BMAS\Woocommerce\Account;
//     // new BMAS\Woocommerce\OrdersFilterRestAPI;
// }

add_filter( 'graphql_connection_max_query_amount', function( $amount, $source, $args, $context, $info  ) {
    $amount = 10000; // increase post limit to 1000
    return $amount;
}, 10, 5 );

add_filter( 'graphql_object_visibility', function( $visibility, $model_name, $data, $owner, $current_user ) {

  // only apply our adjustments to the UserObject Model
  if ( 'UserObject' === $model_name ) {
    $visibility = 'public';
  }

  return $visibility;

}, 10, 5 );

add_filter( 'jwt_auth_whitelist', function ( $endpoints ) {
    $your_endpoints = array(
        '/wp-json/wc/v3/*',
        '/wp-json/gf/v2/*',
				'/wp-json/klaviyo/*',
				'/wp-json/klaviyo/v1/options',
    );

    return array_unique( array_merge( $endpoints, $your_endpoints ) );
});

add_filter( 'retrieve_password_message', function( $message, $key, $user_login, $user_data ) {
	$site_name = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
	$message   = __( 'Someone has requested a password reset for the following account:' ) . "\r\n\r\n";
	/* translators: %s: Site name. */
	$message .= sprintf( __( 'Site Name: %s', 'The Gentleman\'s Journal' ), $site_name ) . "\r\n\r\n";
	/* translators: %s: User login. */
	$message .= sprintf( __( 'Username: %s', 'The Gentleman\'s Journal' ), $user_login ) . "\r\n\r\n";
	$message .= __( 'If this was a mistake, ignore this email and nothing will happen.' ) . "\r\n\r\n";
	$message .= __( 'To reset your password, visit the following address:' ) . "\r\n\r\n";
	$message .=  'https://papaya-zuccutto-a62369.netlify.app/clubhouse/lost-password?email=' . rawurlencode( $user_login ) . "&key=$key\r\n\r\n";
	$requester_ip = $_SERVER['REMOTE_ADDR'];
	if ( $requester_ip ) {
		$message .= sprintf(
		/* translators: %s: IP address of password reset requester. */
			__( 'This password reset request originated from the IP address %s.' ),
			$requester_ip
		) . "\r\n";
	}
	return $message;
}, 10, 4 );

/**
 * Load all functions
 * ------
 * @version 1.0.0
 */
BMAS\Util\DirectoryLoader::load('includes');
