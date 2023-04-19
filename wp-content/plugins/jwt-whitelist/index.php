<?php

  /**
   * Plugin Name: JWT Whitelist
   * Description: Simple plugin for whitelisting JWT endpoints
   * Version: 0.1.0
   * Author: Ben Hudson
   * License: MIT
   *
   * Text Domain: whitelist for Contact Form 7
   * 
   * @package .
   */

   add_filter( 'jwt_auth_whitelist', function ( $endpoints ) {
		$your_endpoints = array(
				'/wp-json/wc/v3/*',
				'/wp-json/gf/v2/*',
				// '/wp-json/bdpwr/v1/*',
				'/wp-json/klaviyo/v1/*',
				'/wp-json/wp-smush/v1/*',
        '/wp-json/regenerate-thumbnails/v1/*'
		);
		return array_unique( array_merge( $endpoints, $your_endpoints ) );
	});