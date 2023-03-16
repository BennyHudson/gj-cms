<?php
/**
 * Plugin Name: Klaviyo Toolkit
 * Plugin URI: https://www.madebytribe.com
 * Description: Triggers additional events with WooCommerce and Klaviyo.
 * Version: 1.6
 * Author: Tribe Interactive, LLC
 * Author URI: https://www.madebytribe.com
 *
 * WC requires at least: 4.0
 * WC tested up to: 6.9.4
 *
 **/

if ( ! defined( 'KLAVIYO_EDD_STORE_URL' ) ) {
	define( 'KLAVIYO_EDD_STORE_URL', 'https://www.madebytribe.com' );
}
if ( ! defined( 'KLAVIYO_EDD_ITEM_ID' ) ) {
	define( 'KLAVIYO_EDD_ITEM_ID', 16543 );
}
if ( ! defined( 'KLAVIYO_EDD_ITEM_NAME' ) ) {
	define( 'KLAVIYO_EDD_ITEM_NAME', 'Klaviyo Toolkit Plugin' );
}
if ( ! defined( 'KLAVIYO_TOOLKIT_VERSION' ) ) {
	define( 'KLAVIYO_TOOLKIT_VERSION', 'v1.6' );
}

// register activation hook
register_activation_hook( __FILE__, 'activate_klaviyo_toolkit' );

require_once( 'vendor/autoload.php' );

use Klaviyo\Client;

/**
 * The code that runs during plugin activation.
 */
function activate_klaviyo_toolkit() {

	// Check if kalviyo WC subscription events plugin is available in the active plugin list
	if ( in_array( 'tribe-klaviyo-wc/tribe-klaviyo.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		wp_die(
			sprintf(
				'<p>%1$s <strong>%2$s</strong> %3$s <strong>%4$s</strong> %5$s. <a href="%6$s">%7$s</a> %8$s</p>',
				esc_html( __( 'Please deactivate the', 'klaviyo' ) ),
				esc_html( __( 'Tribe - Klaviyo WooCommerce Subscription Events', 'klaviyo' ) ),
				esc_html( __( 'plugin before activating the', 'klaviyo' ) ),
				esc_html( __( 'Klaviyo Toolkit', 'klaviyo' ) ),
				esc_html( __( 'plugin', 'klaviyo' ) ),
				esc_url( admin_url( '/plugins.php' ) ),
				esc_html( __( 'Click here', 'klaviyo' ) ),
				esc_html( __( 'to return to Plugins page', 'klaviyo' ) )
			)
		);
	}
}

// Load EDD custom updater if it doesn't already exist
if ( ! class_exists( 'Klaviyo_Plugin_Updater' ) ) {
	include( dirname( __FILE__ ) . '/klaviyo-edd-plugin-updater.php' );
}

/**
 * Initialize the updater. Hooked into `admin_init` to work with the
 * wp_version_check cron job, which allows auto-updates.
 */
function klaviyo_toolkit_edd_sl_plugin_updater() {

	global $pagenow;
	// To support auto-updates, this needs to run during the wp_version_check cron job for privileged users.
	$doing_cron = defined( 'DOING_CRON' ) && DOING_CRON;
	if ( ! current_user_can( 'manage_options' ) && ! $doing_cron ) {
		return;
	}

	if ( $pagenow == 'update-core.php' || $pagenow == 'plugins.php' ) {
		// retrieve our license key from the DB
		$license_key = trim( get_option( 'klaviyo_edd_license_key' ) );

		// setup the updater
		$edd_updater = new Klaviyo_Plugin_Updater( KLAVIYO_EDD_STORE_URL, __FILE__,
			array(
				'version' => '1.6',                     // current version number
				'license' => $license_key,              // license key (used get_option above to retrieve from DB)
				'item_id' => KLAVIYO_EDD_ITEM_ID,       // ID of the product
				'author'  => 'Tribe Interactive, LLC',  // author of this plugin
				'beta'    => false,
			)
		);
	}
}

// Add action to initialize the updater
add_action( 'init', 'klaviyo_toolkit_edd_sl_plugin_updater' );

/**
 * Klaviyo Toolkit check license status in admin license page
 */
function klaviyo_toolkit_edd_sl_license_check() {

	// Check EDD license on KT settings or license pages
	if ( isset( $_GET['page'] ) && ( 'wck-sub-events' === $_GET['page'] ) ) {
		// retrieve our license key from the DB
		$license_key = trim( get_option( 'klaviyo_edd_license_key' ) );

		// Yearly product response and license data
		$api_params = array(
			'edd_action' => 'check_license',
			'license'    => $license_key,
			'item_id'    => KLAVIYO_EDD_ITEM_ID,
			'url'        => home_url(),
		);

		// Call the custom API.
		$edd_item_response = wp_remote_post( KLAVIYO_EDD_STORE_URL, array( 'timeout' => 15, 'sslverify' => true, 'body' => $api_params ) );
		$license_data      = json_decode( wp_remote_retrieve_body( $edd_item_response ) );

		if ( 'valid' === $license_data->license ) {
			// this license is valid
			update_option( 'klaviyo_edd_license_status', 'valid' );
		} else {
			// this license is no longer valid
			update_option( 'klaviyo_edd_license_status', 'invalid' );
		}
	}
}

// Add action for cron hook to check license status
add_action( 'admin_init', 'klaviyo_toolkit_edd_sl_license_check' );


// include klaviyo file
include( plugin_dir_path( __FILE__ ) . 'includes/klaviyo.php' );

/**
 * WCKT_Hooks class
 */
class WCKT_Hooks {

	public function __construct() {
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'plugin_settings_link' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );

		// Add action to enqueue admin stylesheets
		add_action( 'admin_enqueue_scripts', array( $this, 'klaviyo_enqueue_styles' ) );

		// Add action to trigger a event after a customer purchases a subscription products
		add_action( 'woocommerce_subscription_payment_complete', array( $this, 'klaviyo_subscription_created' ), 10, 1 );

		// Add action to trigger a event when subscription status changes to pending cancel
		add_action( 'woocommerce_subscription_status_pending-cancel', array( $this, 'klaviyo_subscription_status_pending_cancel' ), 10, 1 );

		// Add action for viewed page event
		add_action( 'wp_footer', array( $this, 'klaviyo_viewed_events' ) );

		// Add action to add images to RSS feed
		add_action( 'rss2_item', array( $this, 'klaviyo_add_imgs_to_rss_feeds' ) );

		// Add action when WC subscription status changes
		add_action( 'woocommerce_subscription_status_updated', array( $this, 'klaviyo_subscription_status_changed' ), 10, 3 );

		// Add action for subscription renewal payment complete / failed
		add_action( 'woocommerce_subscription_renewal_payment_complete', array( $this, 'klaviyo_wc_subscription_renewal_payment' ), 10, 2 );
		add_action( 'woocommerce_subscription_renewal_payment_failed', array( $this, 'klaviyo_wc_subscription_renewal_payment' ), 10, 2 );

		// Add action to activate/deactivate license key
		add_action( 'wp_ajax_klaviyo_license_button', array( $this, 'klaviyo_license_options' ) );

		// Add filter to move email address field above name field
		add_filter( 'woocommerce_billing_fields', array( $this, 'klaviyo_move_checkout_email_above_name_fields' ), 10, 1 );

		// Add action to auto generate coupon code and update a customer profile field within Klaviyo
		add_action( 'wp', array( $this, 'klaviyo_coupon_code_and_loggedin_profile_update' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'klaviyo_enqueue_scripts' ) );

		// Add action to update klaviyo profile fields and auto generate coupon code
		add_action( 'wp_ajax_klaviyo_profile_update_generate_coupon', array( $this, 'klaviyo_profile_update_generate_coupon' ) );
		add_action( 'wp_ajax_nopriv_klaviyo_profile_update_generate_coupon', array( $this, 'klaviyo_profile_update_generate_coupon' ) );
	}

	public function plugin_settings_link( $links ) {
		$url           = get_admin_url() . 'admin.php?page=wck-sub-events';
		$settings_link = '<a href="' . $url . '">' . __( 'Settings', 'klaviyo' ) . '</a>';
		array_unshift( $links, $settings_link );

		return $links;
	}

	public function register_settings() {
		register_setting( 'wck-sub-events', 'wck-api-key' );
	}

	public function add_admin_menu() {
		add_menu_page(
			__( 'Klaviyo Toolkit', 'klaviyo' ),
			__( 'Klaviyo Toolkit', 'klaviyo' ),
			'manage_options',
			'wck-sub-events',
			array( $this, 'wck_menu' ),
			'dashicons-email-alt'
		);
	}

	public function wck_menu() {
		require plugin_dir_path( __FILE__ ) . 'admin/klaviyo-admin-display.php';
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function klaviyo_enqueue_styles() {

		if ( isset( $_GET['page'] ) ) {
			if ( 'wck-sub-events' === $_GET['page'] ) {

				wp_enqueue_style( 'klaviyo-admin', plugin_dir_url( __FILE__ ) . 'admin/css/klaviyo-admin.css' );
				wp_enqueue_script( 'klaviyo-admin-js', plugin_dir_url( __FILE__ ) . 'admin/js/klaviyo-admin.js', array( 'jquery' ), null, true );
				$params = array(
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
				);
				wp_localize_script( 'klaviyo-admin-js', 'klaviyoAdminAjax', $params );

			}
		}
	}

	/**
	 * Create a new event that triggers once a new subscription has been created.
	 *
	 * @param $subscription
	 *
	 * @throws \TribeKlaviyoException
	 */
	public function klaviyo_subscription_created( $subscription ) {

		$parent_order_id          = method_exists( $subscription, 'get_parent_id' ) ? $subscription->get_parent_id() : $subscription->order->id;
		$related_orders_ids_array = $subscription->get_related_orders();
		$last_related_order_id    = reset( $related_orders_ids_array );
		if ( $parent_order_id != $last_related_order_id ) {
			return;
		}

		$klaviyo_license_status = get_option( 'klaviyo_edd_license_status' );

		$subscription_items            = $subscription->get_items();
		$subscription_billing_interval = $subscription->get_billing_interval();
		$subscription_billing_period   = $subscription->get_billing_period();
		$sub_full_billing_int          = $subscription_billing_interval . ' ' . $subscription_billing_period;
		$klaviyo_client_obj            = new TribeKlaviyo( $this->get_api_key() );

		// WC subscription created event
		$klaviyo_wc_subscription_created = get_option( 'klaviyo_wc_subscription_created' );
		if ( 'enabled' === $klaviyo_wc_subscription_created && 'valid' === $klaviyo_license_status ) {

			$subscription_length = 0;
			foreach ( $subscription_items as $item ) {
				$is_trial = $this->is_trial( $subscription );

				$subscription_id       = $subscription->get_id();
				$sub_item_data         = $item->get_data();
				$sub_item_variation_id = $sub_item_data['variation_id'];
				$sub_item_id           = $sub_item_data['product_id'];
				$sub_product           = wc_get_product( $sub_item_id );
				$billing_period        = WC_Subscriptions_Product::get_period( $sub_product );
				$subscription_length   = WC_Subscriptions_Product::get_length( $sub_product );
				$ranges                = wcs_get_subscription_ranges( $billing_period );

				$wc_sub_created_array = array(
					'PlanName'            => $item->get_name(),
					'SubID'               => $subscription_id,
					'PlanID'              => $item->get_product_id(),
					'PlanTrial'           => $is_trial ? 'True' : 'False',
					'PlanTrialEndDate'    => $subscription->get_date( 'trial_end' ),
					'PlanExpirationDate'  => $subscription->get_date( 'schedule_end' ),
					'$value'              => $is_trial ? 0 : $subscription->get_total(),
					'PlanInterval'        => $sub_full_billing_int,
					'PlanNextPaymentDate' => $subscription->get_date_to_display( 'next_payment' ),
					'PlanExpiresAfter'    => $ranges[ $subscription_length ] // Add "ExpireAfter" parameter
				);

				// If variation id is not empty then add to event parameters
				if ( ! empty( $sub_item_variation_id ) ) {
					$wc_sub_created_array['PlanVariationID'] = $sub_item_variation_id;
				}

				$subscription_email = $subscription->get_billing_email();

				// Check if the WC subscription gifting class exist
				if ( class_exists( 'WCS_Gifting' ) ) {
					$klaviyo_change_email_to_recipient = get_option( 'klaviyo_change_email_to_recipient' );
					if ( ( 'enabled' === $klaviyo_change_email_to_recipient ) &&
					     WCS_Gifting::is_gifted_subscription( $subscription ) ) {
						$recipient_user_id  = WCS_Gifting::get_recipient_user( $subscription );
						$recipient_user     = get_userdata( $recipient_user_id );
						$subscription_email = $recipient_user->user_email;
					}
				}

				$klaviyo_client_obj->track(
					'WC Subscription Created',
					array( '$email' => $subscription_email ),
					$wc_sub_created_array
				);

			}
		}

		// Subscribed to Plan event
		$klaviyo_sub_events = get_option( 'klaviyo_subscription_events' );
		if ( 'enabled' === $klaviyo_sub_events && 'valid' === $klaviyo_license_status ) {

			foreach ( $subscription_items as $item ) {
				$is_trial = $this->is_trial( $subscription );

				$klaviyo_client_obj->track(
					'Subscribed to Plan',
					array( '$email' => $subscription->get_billing_email() ),
					array(
						'Plan'     => $item->get_name(),
						'PlanID'   => $item->get_product_id(),
						'PlanType' => $is_trial ? 'Trial' : 'Paid',
						'$value'   => $is_trial ? 0 : $subscription->get_total(),
					)
				);
			}
		}

	}

	private function get_api_key() {
		$wck_api_key = get_option( 'klaviyo_api_key' );

		return $wck_api_key;
	}

	private function is_trial( $subscription ) {
		return false != $subscription->get_date( 'trial_end' );
	}

	/**
	 * Subscription status changes to pending cancel.
	 *
	 * @param $subscription
	 *
	 * @throws \TribeKlaviyoException
	 */
	public function klaviyo_subscription_status_pending_cancel( $subscription ) {

		$klaviyo_license_status = get_option( 'klaviyo_edd_license_status' );

		$klaviyo_sub_events = get_option( 'klaviyo_subscription_events' );
		if ( 'enabled' === $klaviyo_sub_events && 'valid' === $klaviyo_license_status ) {

			$subscription_items = $subscription->get_items();
			$client             = new TribeKlaviyo( $this->get_api_key() );

			foreach ( $subscription_items as $item ) {
				$is_trial = $this->is_trial( $subscription );
				$response = $client->track(
					'Cancelled Plan',
					array( '$email' => $subscription->get_billing_email() ),
					array(
						'Plan'     => $item->get_name(),
						'PlanID'   => $item->get_product_id(),
						'PlanType' => $is_trial ? 'Trial' : 'Paid',
						'$value'   => $is_trial ? 0 : $subscription->get_total(),
					)
				);
			}
		}
	}

	/**
	 * Different viewed events
	 */
	public function klaviyo_viewed_events() {
		$wck_api_key = get_option( 'klaviyo_api_key' );
		?>
		<script type="application/javascript" async src="https://static.klaviyo.com/onsite/js/klaviyo.js?company_id=<?php echo $wck_api_key; ?>"></script>
		<?php
		global $post;
		$klaviyo_license_status = get_option( 'klaviyo_edd_license_status' );
		$klaviyo_viewed_page    = get_option( 'klaviyo_viewed_page' );
		$klaviyo_viewed_pro_cat = get_option( 'klaviyo_viewed_pro_cat' );
		$klaviyo_viewed_post    = get_option( 'klaviyo_viewed_post' );
		$klaviyo_searched_site  = get_option( 'klaviyo_searched_site' );

		// Viewed Page Event
		if ( 'enabled' === $klaviyo_viewed_page && is_page() && 'valid' === $klaviyo_license_status ) {
			$page_id        = $post->ID;
			$page_title     = get_the_title( $post );
			$page_permalink = get_the_permalink( $page_id );
			?>
			<script type="text/javascript">
							var _learnq = _learnq || [];
							_learnq.push( ['track', 'Viewed Page', {
								'PageName': '<?php echo $page_title; ?>',
								'PageID': '<?php echo $page_id; ?>',
								'URL': '<?php echo $page_permalink; ?>'
							}] );
			</script>
			<?php
		}

		// Viewed Product Category Event
		if ( 'enabled' === $klaviyo_viewed_pro_cat && is_product_category() && 'valid' === $klaviyo_license_status ) {
			$queried_object      = get_queried_object();
			$pro_cat_name        = $queried_object->name;
			$pro_cat_taxonomy_id = $queried_object->term_taxonomy_id;
			$cat_thumb_image_url = '';
			$cat_thumbnail_id    = get_term_meta( $pro_cat_taxonomy_id, 'thumbnail_id', true );
			if ( ! empty( $cat_thumbnail_id ) ) {
				$cat_thumb_image_url = wp_get_attachment_url( $cat_thumbnail_id );
			}
			$product_category_url = get_category_link( $pro_cat_taxonomy_id );
			?>
			<script type="text/javascript">
							var _learnq = _learnq || [];
							_learnq.push( ['track', 'Viewed Product Category', {
								'ProductCategoryName': '<?php echo $pro_cat_name; ?>',
								'ProductCategoryID': '<?php echo $pro_cat_taxonomy_id; ?>',
								'ImageURL': '<?php echo $cat_thumb_image_url; ?>',
								'URL': '<?php echo $product_category_url; ?>'
							}] );
			</script>
			<?php
		}

		// Viewed Post Event
		if ( 'enabled' === $klaviyo_viewed_post && is_single() && 'valid' === $klaviyo_license_status ) {
			$post_id         = $post->ID;
			$post_title      = get_the_title( $post );
			$post_categories = get_the_category( $post_id );
			$post_cats_array = array();
			if ( ! empty( $post_categories ) ) {
				foreach ( $post_categories as $post_category ) {
					$post_cats_array[] = $post_category->name;
				}
			}
			$post_cats_array = implode( ",", $post_cats_array );
			if ( has_post_thumbnail() ) {
				$post_featured_image_url = get_the_post_thumbnail_url( $post_id, 'full' );
			} else {
				$post_featured_image_url = '';
			}
			$post_permalink = get_the_permalink( $post_id );
			?>
			<script type="text/javascript">
							var _learnq = _learnq || [];
							_learnq.push( ['track', 'Viewed Post', {
								'PostName': '<?php echo $post_title; ?>',
								'PostID': '<?php echo $post_id; ?>',
								'PostCategory': '<?php echo $post_cats_array; ?>',
								'ImageURL': '<?php echo $post_featured_image_url; ?>',
								'URL': '<?php echo $post_permalink; ?>'
							}] );
			</script>
			<?php
		}

		// Searched Site Event
		if ( 'enabled' === $klaviyo_searched_site && is_search() && 'valid' === $klaviyo_license_status ) {
			$search_keyword       = filter_input( INPUT_GET, 's', FILTER_SANITIZE_STRING );
			$search_query         = new WP_Query( array( 's' => $search_keyword ) );
			$total_search_results = $search_query->found_posts;
			$search_results_url   = site_url() . '/?s=' . urlencode( $search_keyword );
			?>
			<script type="text/javascript">
							var _learnq = _learnq || [];
							_learnq.push( ['track', 'Searched Site', {
								'SearchTerm': '<?php echo $search_keyword; ?>',
								'ReturnedResults': <?php echo $total_search_results; ?>,
								'SearchResultsUrl': '<?php echo $search_results_url; ?>'
							}] );
			</script>
			<?php
		}
	}

	/**
	 * RSS feed featured image for Klaviyo
	 */
	public function klaviyo_add_imgs_to_rss_feeds() {

		$klaviyo_license_status  = get_option( 'klaviyo_edd_license_status' );
		$klaviyo_add_imgs_to_rss = get_option( 'klaviyo_add_imgs_to_rss' );
		if ( 'enabled' === $klaviyo_add_imgs_to_rss && 'valid' === $klaviyo_license_status ) {
			global $post;
			if ( has_post_thumbnail( $post->ID ) ) {
				$output            = '';
				$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
				$thumbnail         = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
				$output            .= '<image>';
				$output            .= $thumbnail[0];
				$output            .= '</image>';
				echo $output;
			}
		}
	}

	/**
	 * WC subscription status changes
	 *
	 * @param $subscription
	 * @param $new_status
	 * @param $old_status
	 */
	public function klaviyo_subscription_status_changed( $subscription, $new_status, $old_status ) {

		// Proceed if old status is not pending
		if ( 'pending' !== $old_status ) {

			$klaviyo_license_status                = get_option( 'klaviyo_edd_license_status' );
			$klaviyo_wc_subscription_status_change = get_option( 'klaviyo_wc_subscription_status_change' );

			if ( 'enabled' === $klaviyo_wc_subscription_status_change && 'valid' === $klaviyo_license_status ) {

				$subscription_items = $subscription->get_items();
				$client             = new TribeKlaviyo( $this->get_api_key() );

				if ( ! empty( $subscription_items ) ) {
					foreach ( $subscription_items as $sub_item ) {

						$sub_item_data        = $sub_item->get_data();
						$subscription_plan    = $sub_item_data['name'];
						$subscription_plan_id = $sub_item_data['product_id'];
						$subscription_value   = $sub_item_data['total'];

						$wc_status_changed_event_array = array(
							'WC Subscription Status Changed Value' => $subscription_value,
							'PlanName'                             => $subscription_plan,
							'PlanID'                               => $subscription_plan_id,
							'PlanValue'                            => $subscription_value,
							'PlanStatus'                           => $new_status,
						);

						if ( 'cancelled' === $new_status || 'pending-cancel' === $new_status ) {
							$wc_status_changed_event_array['Subscription End Date'] = $subscription->get_date( 'end_date' );
						}

						// Add WC subscription status changed event to klaviyo
						$client->track(
							'WC Subscription Status Changed',
							array( '$email' => $subscription->get_billing_email() ),
							$wc_status_changed_event_array
						);

					}
				}
			}
		}

	}

	/**
	 * Subscription renewal payment complete.
	 *
	 * @param $subscription
	 * @param $last_order
	 */
	public function klaviyo_wc_subscription_renewal_payment( $subscription, $last_order ) {

		$klaviyo_license_status          = get_option( 'klaviyo_edd_license_status' );
		$klaviyo_wc_subscription_renewal = get_option( 'klaviyo_wc_subscription_renewal' );

		if ( 'enabled' === $klaviyo_wc_subscription_renewal && 'valid' === $klaviyo_license_status ) {

			$subscription_items        = $subscription->get_items();
			$client                    = new TribeKlaviyo( $this->get_api_key() );
			$last_renewal_order_status = $last_order->get_status();

			$subscription_renewal_status = 'Success';
			if ( 'failed' === $last_renewal_order_status ) {
				$subscription_renewal_status = 'Fail';
			}
			$subscription_billing_interval = $subscription->get_billing_interval();
			$subscription_billing_period   = $subscription->get_billing_period();
			$sub_full_billing_int          = $subscription_billing_interval . ' ' . $subscription_billing_period;

			if ( ! empty( $subscription_items ) ) {
				foreach ( $subscription_items as $sub_item ) {

					$sub_item_data        = $sub_item->get_data();
					$subscription_plan    = $sub_item_data['name'];
					$subscription_plan_id = $sub_item_data['product_id'];
					$subscription_value   = $sub_item_data['total'];

					// Add WC subscription renewal event to klaviyo
					$client->track(
						'WC Subscription Renewal',
						array( '$email' => $subscription->get_billing_email() ),
						array(
							'WC Subscription Renewal Value' => $subscription_value,
							'PlanName'                      => $subscription_plan,
							'PlanID'                        => $subscription_plan_id,
							'PlanValue'                     => $subscription_value,
							'PlanRenewalStatus'             => $subscription_renewal_status,
							'PlanInterval'                  => $sub_full_billing_int,
							'NextPaymentDate'               => $subscription->get_date_to_display( 'next_payment' ),
						)
					);

				}
			}
		}
	}

	/**
	 * Check license activate/deactivate functionality
	 */
	public function klaviyo_license_options() {

		$button_name = ! empty( $_POST['button_name'] ) ? $_POST['button_name'] : '';

		// listen for our activate button to be clicked
		if ( 'klaviyo_edd_license_activate' === $button_name ) {

			// retrieve the license from the database
			$klaviyo_license_key = trim( get_option( 'klaviyo_edd_license_key' ) );

			// data to send in our API request
			$api_params = array(
				'edd_action' => 'activate_license',
				'license'    => $klaviyo_license_key,
				'item_id'    => KLAVIYO_EDD_ITEM_ID, // The ID of the item in EDD
				'url'        => home_url(),
			);

			// Call the custom API.
			$response     = wp_remote_post( KLAVIYO_EDD_STORE_URL, array( 'timeout' => 15, 'sslverify' => true, 'body' => $api_params ) );
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			// make sure the response came back okay
			if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
				$message = ( is_wp_error( $response ) && ! empty( $response->get_error_message() ) ) ? $response->get_error_message() : __( 'An error occurred, please try again.', 'klaviyo' );
			} else {
				if ( false === $license_data->success ) {
					switch ( $license_data->error ) {
						case 'expired' :
							$message = sprintf(
								__( 'Your license key expired on %s.' ),
								date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) )
							);
							break;
						case 'revoked' :
							$message = __( 'Your license key has been disabled.' );
							break;
						case 'missing' :
							$message = __( 'Invalid license.' );
							break;
						case 'invalid' :
						case 'site_inactive' :
							$message = __( 'Your license is not active for this URL.' );
							break;
						case 'item_name_mismatch' :
							$message = sprintf( __( 'This appears to be an invalid license key for %s.' ), EDD_SAMPLE_ITEM_NAME );
							break;
						case 'no_activations_left':
							$message = __( 'Your license key has reached its activation limit.' );
							break;
						default :
							$message = __( 'An error occurred, please try again.' );
							break;
					}
				}
			}

			// Check if anything passed on a message constituting a failure
			if ( ! empty( $message ) ) {
				$base_url = admin_url( 'admin.php?page=wck-sub-events&tab=license' );
				// Redirect url are returned
				$data = array(
					'redirect_url'  => $base_url,
					'sl_activation' => 'false',
					'message'       => $message,
				);
				wp_send_json( $data );
			}

			// $license_data->license will be either "valid" or "invalid"
			update_option( 'klaviyo_edd_license_status', $license_data->license );

			// Redirect url are returned
			$data = array(
				'redirect_url'  => admin_url( 'admin.php?page=wck-sub-events&tab=license' ),
				'sl_activation' => 'true',
				'message'       => __( 'License successfully activated', 'klaviyo' ),
			);
			wp_send_json( $data );

		} else if ( 'klaviyo_edd_license_deactivate' === $button_name ) {

			// retrieve the license from the database
			$klaviyo_license_key = trim( get_option( 'klaviyo_edd_license_key' ) );

			// data to send in our API request
			$api_params = array(
				'edd_action' => 'deactivate_license',
				'license'    => $klaviyo_license_key,
				'item_name'  => urlencode( KLAVIYO_EDD_ITEM_NAME ), // the name of our product in EDD
				'url'        => home_url(),
			);

			// Call the custom API.
			$response = wp_remote_post( KLAVIYO_EDD_STORE_URL, array( 'timeout' => 15, 'sslverify' => true, 'body' => $api_params ) );

			// make sure the response came back okay
			if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
				if ( is_wp_error( $response ) ) {
					$message = $response->get_error_message();
				} else {
					$message = __( 'An error occurred, please try again.' );
				}
				$base_url = admin_url( 'admin.php?page=wck-sub-events&tab=license' );
				// Redirect url are returned
				$data = array(
					'redirect_url'  => $base_url,
					'sl_activation' => 'false',
					'message'       => $message,
				);
				wp_send_json( $data );
			}

			// decode the license data
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			// $license_data->license will be either "deactivated" or "failed"
			if ( $license_data->license == 'deactivated' || $license_data->license == 'failed' ) {
				delete_option( 'klaviyo_edd_license_status' );
			}

			// Redirect url are returned
			$data = array(
				'redirect_url'  => admin_url( 'admin.php?page=wck-sub-events&tab=license' ),
				'sl_activation' => 'true',
				'message'       => __( 'License deactivated', 'klaviyo' ),
			);
			wp_send_json( $data );
		}
		wp_die();
	}

	/**
	 * Move email address field on checkout to above the name fields
	 *
	 * @param $address_fields
	 *
	 * @return mixed
	 */
	public function klaviyo_move_checkout_email_above_name_fields( $address_fields ) {

		$klaviyo_license_status          = get_option( 'klaviyo_edd_license_status' );
		$klaviyo_email_above_name_fields = get_option( 'klaviyo_email_above_name_fields' );

		if ( 'enabled' === $klaviyo_email_above_name_fields && 'valid' === $klaviyo_license_status ) {
			$address_fields['billing_email']['priority'] = 5;
		}

		return $address_fields;
	}

	/**
	 * Auto generate coupon code and update a customer profile field within Klaviyo
	 */
	public function klaviyo_coupon_code_and_loggedin_profile_update() {
		if ( is_checkout() && is_user_logged_in() ) {

			$klaviyo_abandoned_cart_coupon = get_option( 'klaviyo_abandoned_cart_coupon' );
			if ( 'enabled' !== $klaviyo_abandoned_cart_coupon ) {
				return;
			}

			$current_user       = wp_get_current_user();
			$current_username   = $current_user->user_login;
			$current_user_email = $current_user->user_email;

			// Auto generate coupon code
			$this->klaviyo_auto_generate_coupon_code( $current_username, $current_user_email );

			// Update the customer profile in Klaviyo
			$this->klaviyo_update_customer_profile( $current_user_email );
		}
	}

	/**
	 * Auto generate coupon code on the checkout page.
	 *
	 * @param $username
	 * @param $user_email
	 */
	public function klaviyo_auto_generate_coupon_code( $username, $user_email ) {

		$klaviyo_coupon_amount = get_option( 'klaviyo_coupon_amount' );
		$klaviyo_coupon_amount = ! empty( $klaviyo_coupon_amount ) ? $klaviyo_coupon_amount : 0;
		$klaviyo_coupon_prefix = get_option( 'klaviyo_coupon_prefix' );
		$klaviyo_coupon_prefix = ! empty( $klaviyo_coupon_prefix ) ? $klaviyo_coupon_prefix : 'kt';

		// Generate a non existing coupon code name
		if ( is_user_logged_in() ) {
			$coupon_code = $klaviyo_coupon_prefix . '-promo-' . $username . '-' . $klaviyo_coupon_amount;
		} else {
			$coupon_code = $klaviyo_coupon_prefix . '-' . $user_email . '-' . $klaviyo_coupon_amount;
		}

		if ( wc_get_coupon_id_by_code( $coupon_code ) ) {
			return;
		}

		$current_date                   = date( 'Y-m-d', current_time( 'timestamp', 0 ) );
		$klaviyo_coupon_type            = get_option( 'klaviyo_coupon_type' );
		$klaviyo_coupon_expiration      = get_option( 'klaviyo_coupon_expiration' );
		$klaviyo_coupon_expiration_days = ! empty( $klaviyo_coupon_expiration ) ? $klaviyo_coupon_expiration : 0;
		$klaviyo_coupon_expiration_date = date( 'Y-m-d', strtotime( $current_date . ' + ' . $klaviyo_coupon_expiration_days . ' days' ) );
		$klaviyo_coupon_used_with_other = get_option( 'klaviyo_coupon_used_with_other' );
		$klaviyo_coupon_free_shipping   = get_option( 'klaviyo_coupon_free_shipping' );

		if ( 'percentage' === $klaviyo_coupon_type ) {
			$discount_type = 'percent';
		} else {
			$discount_type = 'fixed_cart';
		}

		// Get an empty instance of the WC_Coupon Object
		$coupon = new WC_Coupon();
		// Set the necessary coupon data (since WC 3+)
		$coupon->set_code( $coupon_code );
		$coupon->set_amount( $klaviyo_coupon_amount );
		$coupon->set_date_expires( $klaviyo_coupon_expiration_date );
		$coupon->set_email_restrictions( array( $user_email ) );
		$coupon->set_usage_limit( 1 );
		$coupon->set_individual_use( true );
		$coupon->set_description( 'Klaviyo Toolkit Plugin Coupon Generation' );
		$coupon->set_discount_type( $discount_type );
		// Create, publish and save coupon (data)
		$coupon->save();

		// Update individual coupon meta option
		$coupon_id = wc_get_coupon_id_by_code( $coupon_code );
		update_post_meta( $coupon_id, 'individual_use', ( 'no' === $klaviyo_coupon_used_with_other ) ? 'yes' : 'no' );
		update_post_meta( $coupon_id, 'free_shipping', ( 'yes' === $klaviyo_coupon_free_shipping ) ? 'yes' : 'no' ); // Update Allow free shipping checkbox
	}

	/**
	 * Update Klaviyo user profile.
	 *
	 * @param $user_email
	 */
	public function klaviyo_update_customer_profile( $user_email ) {

		$secret_api_key = get_option( 'klaviyo_private_api_key' );
		if ( empty( $secret_api_key ) ) {
			return;
		}

		$client = new Client( $secret_api_key, $num_retries = 3, $wait_seconds = 3 );

		$clientProfile = $client->Profiles->getProfileId( $user_email );

		$clientProfileID = $clientProfile['id'];

		$kt_coupon_amount      = get_option( 'klaviyo_coupon_amount' );
		$klaviyo_coupon_prefix = get_option( 'klaviyo_coupon_prefix' );
		$klaviyo_coupon_prefix = ! empty( $klaviyo_coupon_prefix ) ? $klaviyo_coupon_prefix : 'kt';

		// Generate a non existing coupon code name
		if ( is_user_logged_in() ) {
			$current_user     = wp_get_current_user();
			$current_username = $current_user->user_login;
			$coupon_code      = $klaviyo_coupon_prefix . '-promo-' . $current_username . '-' . $kt_coupon_amount;
		} else {
			$coupon_code = $klaviyo_coupon_prefix . '-' . $user_email . '-' . $kt_coupon_amount;
		}

		$coupon                = new WC_Coupon( $coupon_code );
		$klaviyo_coupon_amount = $coupon->get_amount();

		$expiry_date                    = $coupon->get_date_expires();
		$expiry_time                    = $coupon->get_meta( 'expiry_time' ); // Coupon custom field
		$klaviyo_coupon_expiration      = new WC_DateTime( $expiry_date->date( 'Y-m-d' ) . ' ' . $expiry_time );
		$klaviyo_coupon_expiration_date = $klaviyo_coupon_expiration->format( 'm/d/Y' );

		$body_params = array(
			'ac-coupon'            => $coupon_code,
			'ac-coupon-amount'     => $klaviyo_coupon_amount,
			'ac-coupon-expiration' => $klaviyo_coupon_expiration_date,
		);
		$client->Profiles->updateProfile( $clientProfileID, $body_params );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 */
	public function klaviyo_enqueue_scripts() {
		wp_enqueue_script( 'klaviyo-public-js', plugin_dir_url( __FILE__ ) . 'public/js/klaviyo-public.js', array( 'jquery' ), null, true );
		$params = array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
		);
		wp_localize_script( 'klaviyo-public-js', 'klaviyoPublicAjax', $params );
	}

	public function klaviyo_profile_update_generate_coupon() {
		$billing_email                 = filter_input( INPUT_POST, 'billing_email', FILTER_SANITIZE_STRING );
		$klaviyo_abandoned_cart_coupon = get_option( 'klaviyo_abandoned_cart_coupon' );

		if ( ! empty( $billing_email ) && is_email( $billing_email ) &&
		     'enabled' === $klaviyo_abandoned_cart_coupon ) {

			$current_user     = wp_get_current_user();
			$current_username = ! empty( $current_user ) ? $current_user->user_login : '';

			$this->klaviyo_auto_generate_coupon_code( $current_username, $billing_email );

			// Update the customer profile in Klaviyo
			$this->klaviyo_update_customer_profile( $billing_email );

			wp_send_json_success();
		}

		wp_die();
	}

	private function process_options( $data ) {
		settings_fields( 'wck-sub-events' );
		do_settings_sections( 'wck-sub-events' );

		$wck_api_key = sanitize_text_field( $data['wck-api-key'] );
		update_option( 'wck-api-key', $wck_api_key );
	}

}

$GLOBALS['WCKT_Hooks'] = new WCKT_Hooks();
