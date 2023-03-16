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

  function wedo_add_to_cart_redirect() {
   global $woocommerce;
   $checkout_url = wc_get_checkout_url();
   return $checkout_url;
  }

  add_action( 'init', 'woocommerce_clear_cart_url' );
  function woocommerce_clear_cart_url() {
  	if ( isset( $_GET['clear-cart'] ) ) {
  		global $woocommerce;
  		$woocommerce->cart->empty_cart();
  	}
  }

  add_action( 'woocommerce_cart_updated', 'delete_persistent_cart' );
  function delete_persistent_cart() {
      if ( get_current_user_id() ) {
          $wc = WooCommerce::instance();
          $wc->cart->persistent_cart_destroy();
      }
  }

  function wedo_cart_button_text() {
    $date_now = date("Y-m-d");
    if ($date_now < '2021-09-01') {
      return __( 'Pre-Order', 'woocommerce' );
    }
    return __('Order Now', 'woocommerce');
  }

  function wedo_change_cart_string($translated_text, $text, $domain) {
    $translated_text = str_replace('cart', 'basket', $translated_text);
    $translated_text = str_replace('Cart', 'Basket', $translated_text);
    return $translated_text;
  }

  function webroom_add_multiple_products_to_cart( $url = false ) {
	// Make sure WC is installed, and add-to-cart qauery arg exists, and contains at least one comma.
	if ( ! class_exists( 'WC_Form_Handler' ) || empty( $_REQUEST['add-to-cart'] ) || false === strpos( $_REQUEST['add-to-cart'], ',' ) ) {
		return;
	}

	// Remove WooCommerce's hook, as it's useless (doesn't handle multiple products).
	remove_action( 'wp_loaded', array( 'WC_Form_Handler', 'add_to_cart_action' ), 20 );

	$product_ids = explode( ',', $_REQUEST['add-to-cart'] );
	$count       = count( $product_ids );
	$number      = 0;

	foreach ( $product_ids as $id_and_quantity ) {
		// Check for quantities defined in curie notation (<product_id>:<product_quantity>)

		$id_and_quantity = explode( ':', $id_and_quantity );
		$product_id = $id_and_quantity[0];

		$_REQUEST['quantity'] = ! empty( $id_and_quantity[1] ) ? absint( $id_and_quantity[1] ) : 1;

		if ( ++$number === $count ) {
			// Ok, final item, let's send it back to woocommerce's add_to_cart_action method for handling.
			$_REQUEST['add-to-cart'] = $product_id;

			return WC_Form_Handler::add_to_cart_action( $url );
		}

		$product_id        = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $product_id ) );
		$was_added_to_cart = false;
		$adding_to_cart    = wc_get_product( $product_id );

		if ( ! $adding_to_cart ) {
			continue;
		}

		$add_to_cart_handler = apply_filters( 'woocommerce_add_to_cart_handler', $adding_to_cart->get_type(), $adding_to_cart );

		// Variable product handling
		if ( 'variable' === $add_to_cart_handler ) {
			woo_hack_invoke_private_method( 'WC_Form_Handler', 'add_to_cart_handler_variable', $product_id );

		// Grouped Products
		} elseif ( 'grouped' === $add_to_cart_handler ) {
			woo_hack_invoke_private_method( 'WC_Form_Handler', 'add_to_cart_handler_grouped', $product_id );

		// Custom Handler
		} elseif ( has_action( 'woocommerce_add_to_cart_handler_' . $add_to_cart_handler ) ){
			do_action( 'woocommerce_add_to_cart_handler_' . $add_to_cart_handler, $url );

		// Simple Products
		} else {
			woo_hack_invoke_private_method( 'WC_Form_Handler', 'add_to_cart_handler_simple', $product_id );
		}
	}
}

// Fire before the WC_Form_Handler::add_to_cart_action callback.
add_action( 'wp_loaded', 'webroom_add_multiple_products_to_cart', 15 );


/**
 * Invoke class private method
 *
 * @since   0.1.0
 *
 * @param   string $class_name
 * @param   string $methodName
 *
 * @return  mixed
 */
function woo_hack_invoke_private_method( $class_name, $methodName ) {
	if ( version_compare( phpversion(), '5.3', '<' ) ) {
		throw new Exception( 'PHP version does not support ReflectionClass::setAccessible()', __LINE__ );
	}

	$args = func_get_args();
	unset( $args[0], $args[1] );
	$reflection = new ReflectionClass( $class_name );
	$method = $reflection->getMethod( $methodName );
	$method->setAccessible( true );

	//$args = array_merge( array( $class_name ), $args );
	$args = array_merge( array( $reflection ), $args );
	return call_user_func_array( array( $method, 'invoke' ), $args );
}


?>
