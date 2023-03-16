<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.madebytribe.com/
 * @since      1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if access directly
}

$get_tab             = filter_input( INPUT_GET, 'tab', FILTER_SANITIZE_STRING );
$klaviyo_current_tab = ( ! empty( $get_tab ) ) ? esc_attr( $get_tab ) : 'settings';

$klaviyo_tabs = array(
	'settings' => array(
		'tab_name' => __( 'Settings', 'klaviyo' ),
	),
	'license'  => array(
		'tab_name' => __( 'License', 'klaviyo' ),
	),
);

$klaviyo_edd_license_status = get_option( 'klaviyo_edd_license_status' );
$klaviyo_pro_class          = ( 'valid' === $klaviyo_edd_license_status ) ? '' : ' klaviyo-pro-option';
$klaviyo_disabled_class     = ( 'valid' === $klaviyo_edd_license_status ) ? '' : ' disabled';

?>

<?php
// Show settings message based on nonce.
if ( isset( $_POST['klaviyo_submit_btn'] ) && $_POST['klaviyo_submit_btn'] == 'Y' ) { // phpcs:ignore

	if ( 'license' === $klaviyo_current_tab ) {

		$post_edd_license_key    = filter_input( INPUT_POST, 'klaviyo_edd_license_key', FILTER_SANITIZE_STRING );
		$klaviyo_edd_license_key = ! empty( $post_edd_license_key ) ? sanitize_text_field( $post_edd_license_key ) : '';
		update_option( 'klaviyo_edd_license_key', $klaviyo_edd_license_key );

	}

	if ( 'valid' === $klaviyo_edd_license_status ) {

		// UPDATE SETTINGS TAB OPTIONS
		if ( 'settings' === $klaviyo_current_tab ) {

			$post_api_key    = filter_input( INPUT_POST, 'klaviyo_api_key', FILTER_SANITIZE_STRING );
			$klaviyo_api_key = isset( $post_api_key ) ? sanitize_text_field( $post_api_key ) : '';
			update_option( 'klaviyo_api_key', $klaviyo_api_key );

			$post_private_api_key    = filter_input( INPUT_POST, 'klaviyo_private_api_key', FILTER_SANITIZE_STRING );
			$klaviyo_private_api_key = isset( $post_private_api_key ) ? sanitize_text_field( $post_private_api_key ) : '';
			update_option( 'klaviyo_private_api_key', $klaviyo_private_api_key );

			$post_viewed_page    = filter_input( INPUT_POST, 'klaviyo_viewed_page', FILTER_SANITIZE_STRING );
			$klaviyo_viewed_page = isset( $post_viewed_page ) ? sanitize_text_field( $post_viewed_page ) : 'disabled';
			update_option( 'klaviyo_viewed_page', $klaviyo_viewed_page );

			$post_viewed_pro_cat    = filter_input( INPUT_POST, 'klaviyo_viewed_pro_cat', FILTER_SANITIZE_STRING );
			$klaviyo_viewed_pro_cat = isset( $post_viewed_pro_cat ) ? sanitize_text_field( $post_viewed_pro_cat ) : 'disabled';
			update_option( 'klaviyo_viewed_pro_cat', $klaviyo_viewed_pro_cat );

			$post_viewed_post    = filter_input( INPUT_POST, 'klaviyo_viewed_post', FILTER_SANITIZE_STRING );
			$klaviyo_viewed_post = isset( $post_viewed_post ) ? sanitize_text_field( $post_viewed_post ) : 'disabled';
			update_option( 'klaviyo_viewed_post', $klaviyo_viewed_post );

			$post_searched_site    = filter_input( INPUT_POST, 'klaviyo_searched_site', FILTER_SANITIZE_STRING );
			$klaviyo_searched_site = isset( $post_searched_site ) ? sanitize_text_field( $post_searched_site ) : 'disabled';
			update_option( 'klaviyo_searched_site', $klaviyo_searched_site );

			$post_wc_subscription_created    = filter_input( INPUT_POST, 'klaviyo_wc_subscription_created', FILTER_SANITIZE_STRING );
			$klaviyo_wc_subscription_created = isset( $post_wc_subscription_created ) ? sanitize_text_field( $post_wc_subscription_created ) : 'disabled';
			update_option( 'klaviyo_wc_subscription_created', $klaviyo_wc_subscription_created );

			$post_wc_subscription_renewal    = filter_input( INPUT_POST, 'klaviyo_wc_subscription_renewal', FILTER_SANITIZE_STRING );
			$klaviyo_wc_subscription_renewal = isset( $post_wc_subscription_renewal ) ? sanitize_text_field( $post_wc_subscription_renewal ) : 'disabled';
			update_option( 'klaviyo_wc_subscription_renewal', $klaviyo_wc_subscription_renewal );

			$post_wc_subscription_status_change    = filter_input( INPUT_POST, 'klaviyo_wc_subscription_status_change', FILTER_SANITIZE_STRING );
			$klaviyo_wc_subscription_status_change = isset( $post_wc_subscription_status_change ) ? sanitize_text_field( $post_wc_subscription_status_change ) : 'disabled';
			update_option( 'klaviyo_wc_subscription_status_change', $klaviyo_wc_subscription_status_change );

			$post_subscription_events    = filter_input( INPUT_POST, 'klaviyo_subscription_events', FILTER_SANITIZE_STRING );
			$klaviyo_subscription_events = isset( $post_subscription_events ) ? sanitize_text_field( $post_subscription_events ) : 'disabled';
			update_option( 'klaviyo_subscription_events', $klaviyo_subscription_events );

			$post_wc_subscription_created      = filter_input( INPUT_POST, 'klaviyo_change_email_to_recipient', FILTER_SANITIZE_STRING );
			$klaviyo_change_email_to_recipient = isset( $post_wc_subscription_created ) ? sanitize_text_field( $post_wc_subscription_created ) : 'disabled';
			update_option( 'klaviyo_change_email_to_recipient', $klaviyo_change_email_to_recipient );

			$post_add_imgs_to_rss    = filter_input( INPUT_POST, 'klaviyo_add_imgs_to_rss', FILTER_SANITIZE_STRING );
			$klaviyo_add_imgs_to_rss = isset( $post_add_imgs_to_rss ) ? sanitize_text_field( $post_add_imgs_to_rss ) : 'disabled';
			update_option( 'klaviyo_add_imgs_to_rss', $klaviyo_add_imgs_to_rss );

			$post_email_above_name_fields    = filter_input( INPUT_POST, 'klaviyo_email_above_name_fields', FILTER_SANITIZE_STRING );
			$klaviyo_email_above_name_fields = isset( $post_email_above_name_fields ) ? sanitize_text_field( $post_email_above_name_fields ) : 'disabled';
			update_option( 'klaviyo_email_above_name_fields', $klaviyo_email_above_name_fields );

			$post_abandoned_cart_coupon    = filter_input( INPUT_POST, 'klaviyo_abandoned_cart_coupon', FILTER_SANITIZE_STRING );
			$klaviyo_abandoned_cart_coupon = isset( $post_abandoned_cart_coupon ) ? sanitize_text_field( $post_abandoned_cart_coupon ) : 'disabled';
			update_option( 'klaviyo_abandoned_cart_coupon', $klaviyo_abandoned_cart_coupon );

			$post_coupon_amount    = filter_input( INPUT_POST, 'klaviyo_coupon_amount', FILTER_SANITIZE_NUMBER_INT );
			$klaviyo_coupon_amount = isset( $post_coupon_amount ) ? sanitize_text_field( $post_coupon_amount ) : 0;
			update_option( 'klaviyo_coupon_amount', $klaviyo_coupon_amount );

			$post_coupon_type    = filter_input( INPUT_POST, 'klaviyo_coupon_type', FILTER_SANITIZE_STRING );
			$klaviyo_coupon_type = isset( $post_coupon_type ) ? sanitize_text_field( $post_coupon_type ) : 'fixed';
			update_option( 'klaviyo_coupon_type', $klaviyo_coupon_type );

			$post_coupon_expiration    = filter_input( INPUT_POST, 'klaviyo_coupon_expiration', FILTER_SANITIZE_NUMBER_INT );
			$klaviyo_coupon_expiration = isset( $post_coupon_expiration ) ? sanitize_text_field( $post_coupon_expiration ) : '';
			update_option( 'klaviyo_coupon_expiration', $klaviyo_coupon_expiration );

			$post_coupon_prefix    = filter_input( INPUT_POST, 'klaviyo_coupon_prefix', FILTER_SANITIZE_STRING );
			$klaviyo_coupon_prefix = isset( $post_coupon_prefix ) ? sanitize_text_field( $post_coupon_prefix ) : '';
			update_option( 'klaviyo_coupon_prefix', $klaviyo_coupon_prefix );

			$post_coupon_used_with_other    = filter_input( INPUT_POST, 'klaviyo_coupon_used_with_other', FILTER_SANITIZE_STRING );
			$klaviyo_coupon_used_with_other = isset( $post_coupon_used_with_other ) ? sanitize_text_field( $post_coupon_used_with_other ) : 'no';
			update_option( 'klaviyo_coupon_used_with_other', $klaviyo_coupon_used_with_other );

			$post_coupon_free_shipping    = filter_input( INPUT_POST, 'klaviyo_coupon_free_shipping', FILTER_SANITIZE_STRING );
			$klaviyo_coupon_free_shipping = isset( $post_coupon_free_shipping ) ? sanitize_text_field( $post_coupon_free_shipping ) : 'no';
			update_option( 'klaviyo_coupon_free_shipping', $klaviyo_coupon_free_shipping );
		}
	}

	?>
	<div id="message" class="updated">
		<p><strong><?php esc_html_e( 'Settings saved.', 'klaviyo' ); ?></strong></p>
	</div>
<?php } ?>

<div class="wrap">
	<div class="ktk-header-wrap">
		<div class="ktk-logo">
			<h1>
				<?php esc_html_e( 'Klaviyo Toolkit', 'klaviyo' ); ?>
				<span class="ktk-version-badge"><?php echo KLAVIYO_TOOLKIT_VERSION; ?></span>
				<div class="ktk-version">
					<?php
					echo sprintf(
						'by <a href="%1$s">%2$s</a>',
						esc_url( 'https://www.madebytribe.com/' ),
						esc_html__( 'TRIBE', 'klaviyo' )
					);
					?>
				</div>
				<div class="ktk-header-links">
					<a href="<?php echo esc_url( 'https://support.madebytribe.com/article-categories/klaviyo-toolkit-plugin/' ); ?>"
					   target="_blank"><?php echo esc_html( __( 'Read the docs', 'klaviyo' ) ); ?></a>
					| <a href="<?php echo esc_url( 'https://www.madebytribe.com/products/klaviyo-toolkit-woocommerce/#edd-reviews' ); ?>"
					     target="_blank"><?php echo esc_html( __( 'Leave a Review', 'klaviyo' ) ); ?></a>
					| <a href="<?php echo esc_url( 'https://www.madebytribe.com/contact-us/' ); ?>"
					     target="_blank"><?php echo esc_html( __( 'Get Support', 'klaviyo' ) ); ?></a>
				</div>
			</h1>
		</div>
		<p class="ktk-plugin-desc"><?php esc_html_e( 'Unlocks additional events and metrics within Klaviyo, allowing you to create new advanced automation flows and segments.', 'klaviyo' ); ?></p>
	</div>

	<h2 class="nav-tab-wrapper">
		<?php
		foreach ( $klaviyo_tabs as $key => $value ) {
			$active_tab_class = ( $key == $klaviyo_current_tab ) ? ' nav-tab-active' : '';
			?>
			<a class="nav-tab<?php echo esc_attr( $active_tab_class ); ?>"
			   href="?page=wck-sub-events&amp;tab=<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value['tab_name'] ); ?></a>
		<?php } ?>
	</h2>

	<div id="klaviyo-settings" class="klaviyo-settings-container">
		<form method="post" id="wck-form">
			<input type="hidden" name="klaviyo_submit_btn" value="Y">

			<?php
			settings_fields( 'wck-sub-events' );
			do_settings_sections( 'wck-sub-events' );

			// GET SETTINGS TAB OPTIONS
			if ( 'settings' === $klaviyo_current_tab ) {

				// GET SETTINGS TAB OPTIONS
				$klaviyo_api_key         = get_option( 'klaviyo_api_key' );
				$klaviyo_private_api_key = get_option( 'klaviyo_private_api_key' );

				$klaviyo_viewed_page     = get_option( 'klaviyo_viewed_page' );
				$klaviyo_viewed_page_opt = ( 'enabled' === $klaviyo_viewed_page ) ? 'checked' : '';

				$klaviyo_viewed_pro_cat     = get_option( 'klaviyo_viewed_pro_cat' );
				$klaviyo_viewed_pro_cat_opt = ( 'enabled' === $klaviyo_viewed_pro_cat ) ? 'checked' : '';

				$klaviyo_viewed_post     = get_option( 'klaviyo_viewed_post' );
				$klaviyo_viewed_post_opt = ( 'enabled' === $klaviyo_viewed_post ) ? 'checked' : '';

				$klaviyo_searched_site     = get_option( 'klaviyo_searched_site' );
				$klaviyo_searched_site_opt = ( 'enabled' === $klaviyo_searched_site ) ? 'checked' : '';

				$klaviyo_wc_subscription_created     = get_option( 'klaviyo_wc_subscription_created' );
				$klaviyo_wc_subscription_created_opt = ( 'enabled' === $klaviyo_wc_subscription_created ) ? 'checked' : '';

				$klaviyo_wc_subscription_renewal     = get_option( 'klaviyo_wc_subscription_renewal' );
				$klaviyo_wc_subscription_renewal_opt = ( 'enabled' === $klaviyo_wc_subscription_renewal ) ? 'checked' : '';

				$klaviyo_wc_subscription_status_change     = get_option( 'klaviyo_wc_subscription_status_change' );
				$klaviyo_wc_subscription_status_change_opt = ( 'enabled' === $klaviyo_wc_subscription_status_change ) ? 'checked' : '';

				$klaviyo_sub_events     = get_option( 'klaviyo_subscription_events' );
				$klaviyo_sub_events_opt = ( 'enabled' === $klaviyo_sub_events ) ? 'checked' : '';

				$klaviyo_change_email_to_recipient     = get_option( 'klaviyo_change_email_to_recipient' );
				$klaviyo_change_email_to_recipient_opt = ( 'enabled' === $klaviyo_change_email_to_recipient ) ? 'checked' : '';

				$klaviyo_add_imgs_to_rss     = get_option( 'klaviyo_add_imgs_to_rss' );
				$klaviyo_add_imgs_to_rss_opt = ( 'enabled' === $klaviyo_add_imgs_to_rss ) ? 'checked' : '';

				$klaviyo_email_above_name_fields     = get_option( 'klaviyo_email_above_name_fields' );
				$klaviyo_email_above_name_fields_opt = ( 'enabled' === $klaviyo_email_above_name_fields ) ? 'checked' : '';

				$klaviyo_abandoned_cart_coupon     = get_option( 'klaviyo_abandoned_cart_coupon' );
				$klaviyo_abandoned_cart_coupon_opt = ( 'enabled' === $klaviyo_abandoned_cart_coupon ) ? 'checked' : '';

				$klaviyo_coupon_amount          = get_option( 'klaviyo_coupon_amount' );
				$klaviyo_coupon_type            = get_option( 'klaviyo_coupon_type' );
				$klaviyo_coupon_expiration      = get_option( 'klaviyo_coupon_expiration' );
				$klaviyo_coupon_prefix          = get_option( 'klaviyo_coupon_prefix' );
				$klaviyo_coupon_used_with_other = get_option( 'klaviyo_coupon_used_with_other' );
				$klaviyo_coupon_used_with_other = ! empty( $klaviyo_coupon_used_with_other ) ? $klaviyo_coupon_used_with_other : 'no';
				$klaviyo_coupon_free_shipping   = get_option( 'klaviyo_coupon_free_shipping' );
				$klaviyo_coupon_free_shipping   = ! empty( $klaviyo_coupon_free_shipping ) ? $klaviyo_coupon_free_shipping : 'no';
			}
			?>
			<?php if ( 'settings' === $klaviyo_current_tab ) { ?>
				<h3><?php echo esc_html( __( 'Connect to Klaviyo', 'klaviyo' ) ); ?></h3>
				<?php
				echo sprintf(
					'<p>%1$s <a href="%2$s">%3$s</a>.</p>',
					esc_html( __( 'Insert your Klaviyo public & private API keys below to connect. You can find them on your Klaviyo', 'klaviyo' ) ),
					esc_url( 'https://www.klaviyo.com/account#api-keys-tab' ),
					esc_html__( 'account page', 'klaviyo' )
				);
				?>
				<table class="form-table">
					<tr>
						<th scope="row">
							<label for="klaviyo_api_key"><strong><?php echo esc_html( __( 'Klaviyo Public API Key', 'klaviyo' ) ); ?></strong></label>
							<?php if ( 'valid' !== $klaviyo_edd_license_status ) { ?>
								<span class="klaviyo-pro-label"><?php echo esc_html( __( 'Get License', 'klaviyo' ) ); ?></span>
							<?php } ?>
							<p class="description"><?php echo esc_html( __( '6-7 characters long max.', 'klaviyo' ) ); ?></p>
						</th>
						<td class="<?php echo esc_attr( $klaviyo_pro_class ); ?>">
							<input type="text" name="klaviyo_api_key" id="klaviyo_api_key"
							       value="<?php echo $klaviyo_api_key; ?>" <?php echo esc_attr( $klaviyo_disabled_class ); ?>>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="klaviyo_private_api_key"><strong><?php echo esc_html( __( 'Klaviyo Private API Key', 'klaviyo' ) ); ?></strong></label>
							<?php if ( 'valid' !== $klaviyo_edd_license_status ) { ?>
								<span class="klaviyo-pro-label"><?php echo esc_html( __( 'Get License', 'klaviyo' ) ); ?></span>
							<?php } ?>
							<p class="description"><?php echo esc_html( __( 'Starts with pk_', 'klaviyo' ) ); ?></p>
						</th>
						<td class="<?php echo esc_attr( $klaviyo_pro_class ); ?>">
							<input type="password" name="klaviyo_private_api_key" id="klaviyo_private_api_key"
							       value="<?php echo $klaviyo_private_api_key; ?>" <?php echo esc_attr( $klaviyo_disabled_class ); ?>>
						</td>
					</tr>
				</table>
				<h3><?php echo esc_html( __( 'General Events', 'klaviyo' ) ); ?></h3>
				<?php
				echo sprintf(
					'<p>%1$s <a href="%2$s">%3$s</a>.</p>',
					esc_html__( 'Select which events you want to send to Klaviyo. Once an event is enabled and it\'s been triggered on your site, you\'ll be able to see the event in your Klaviyo account', 'klaviyo' ),
					esc_url( 'https://www.klaviyo.com/dashboard/activity' ),
					esc_html__( 'activity feed', 'klaviyo' )
				);
				?>
				<table class="form-table">
					<tr>
						<th scope="row">
							<label for="klaviyo_viewed_page"><?php echo esc_html( __( 'Enable "Viewed Page" Event', 'klaviyo' ) ); ?></label>
							<?php if ( 'valid' !== $klaviyo_edd_license_status ) { ?>
								<span class="klaviyo-pro-label"><?php echo esc_html( __( 'Get License', 'klaviyo' ) ); ?></span>
							<?php } ?>
						</th>
						<td class="<?php echo esc_attr( $klaviyo_pro_class ); ?>">
							<div class="klaviyo-toggle klaviyo-toggle--size-small">
								<input type="checkbox" name="klaviyo_viewed_page" id="klaviyo_viewed_page"
								       value="enabled" <?php echo esc_attr( $klaviyo_viewed_page_opt ); ?> <?php echo esc_attr( $klaviyo_disabled_class ); ?>>
								<label for="klaviyo_viewed_page">
									<div class="klaviyo-toggle__switch" data-checked="On" data-unchecked="Off"></div>
								</label>
							</div>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="klaviyo_viewed_pro_cat"><?php echo esc_html( __( 'Enable "Viewed Product Category" Event', 'klaviyo' ) ); ?></label>
							<?php if ( 'valid' !== $klaviyo_edd_license_status ) { ?>
								<span class="klaviyo-pro-label"><?php echo esc_html( __( 'Get License', 'klaviyo' ) ); ?></span>
							<?php } ?>
						</th>
						<td class="<?php echo esc_attr( $klaviyo_pro_class ); ?>">
							<div class="klaviyo-toggle klaviyo-toggle--size-small">
								<input type="checkbox" name="klaviyo_viewed_pro_cat" id="klaviyo_viewed_pro_cat"
								       value="enabled" <?php echo esc_attr( $klaviyo_viewed_pro_cat_opt ); ?> <?php echo esc_attr( $klaviyo_disabled_class ); ?>>
								<label for="klaviyo_viewed_pro_cat">
									<div class="klaviyo-toggle__switch" data-checked="On" data-unchecked="Off"></div>
								</label>
							</div>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="klaviyo_viewed_post"><?php echo esc_html( __( 'Enable "Viewed Post" Event', 'klaviyo' ) ); ?></label>
							<?php if ( 'valid' !== $klaviyo_edd_license_status ) { ?>
								<span class="klaviyo-pro-label"><?php echo esc_html( __( 'Get License', 'klaviyo' ) ); ?></span>
							<?php } ?>
						</th>
						<td class="<?php echo esc_attr( $klaviyo_pro_class ); ?>">
							<div class="klaviyo-toggle klaviyo-toggle--size-small">
								<input type="checkbox" name="klaviyo_viewed_post" id="klaviyo_viewed_post"
								       value="enabled" <?php echo esc_attr( $klaviyo_viewed_post_opt ); ?> <?php echo esc_attr( $klaviyo_disabled_class ); ?>>
								<label for="klaviyo_viewed_post">
									<div class="klaviyo-toggle__switch" data-checked="On" data-unchecked="Off"></div>
								</label>
							</div>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="klaviyo_searched_site"><?php echo esc_html( __( 'Enable "Searched Site" Event', 'klaviyo' ) ); ?></label>
							<?php if ( 'valid' !== $klaviyo_edd_license_status ) { ?>
								<span class="klaviyo-pro-label"><?php echo esc_html( __( 'Get License', 'klaviyo' ) ); ?></span>
							<?php } ?>
						</th>
						<td class="<?php echo esc_attr( $klaviyo_pro_class ); ?>">
							<div class="klaviyo-toggle klaviyo-toggle--size-small">
								<input type="checkbox" name="klaviyo_searched_site" id="klaviyo_searched_site"
								       value="enabled" <?php echo esc_attr( $klaviyo_searched_site_opt ); ?> <?php echo esc_attr( $klaviyo_disabled_class ); ?>>
								<label for="klaviyo_searched_site">
									<div class="klaviyo-toggle__switch" data-checked="On" data-unchecked="Off"></div>
								</label>
							</div>
						</td>
					</tr>
				</table>
				<h3><?php echo esc_html( __( 'WooCommerce Subscriptions Events', 'klaviyo' ) ); ?></h3>
				<?php
				echo sprintf(
					'<p>%1$s <a href="%2$s">%3$s</a>%4$s.</p>',
					esc_html__( 'Requires the', 'klaviyo' ),
					esc_url( 'https://woocommerce.com/products/woocommerce-subscriptions/' ),
					esc_html__( 'WooCommerce Subscriptions', 'klaviyo' ),
					esc_html__( ' plugin', 'klaviyo' )
				);
				?>
				<table class="form-table">
					<tr>
						<th scope="row">
							<label for="klaviyo_wc_subscription_created"><?php echo esc_html( __( 'Enable "WC Subscription Created" Event', 'klaviyo' ) ); ?></label>
							<?php if ( 'valid' !== $klaviyo_edd_license_status ) { ?>
								<span class="klaviyo-pro-label"><?php echo esc_html( __( 'Get License', 'klaviyo' ) ); ?></span>
							<?php } ?>
							<p class="description"><?php echo esc_html( __( 'Triggered on new subscriptions.', 'klaviyo' ) ); ?></p>
						</th>
						<td class="<?php echo esc_attr( $klaviyo_pro_class ); ?>">
							<div class="klaviyo-toggle klaviyo-toggle--size-small">
								<input type="checkbox" name="klaviyo_wc_subscription_created" id="klaviyo_wc_subscription_created"
								       value="enabled" <?php echo esc_attr( $klaviyo_wc_subscription_created_opt ); ?> <?php echo esc_attr( $klaviyo_disabled_class ); ?>>
								<label for="klaviyo_wc_subscription_created">
									<div class="klaviyo-toggle__switch" data-checked="On" data-unchecked="Off"></div>
								</label>
							</div>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="klaviyo_wc_subscription_renewal"><?php echo esc_html( __( 'Enable "WC Subscription Renewal" Event', 'klaviyo' ) ); ?></label>
							<?php if ( 'valid' !== $klaviyo_edd_license_status ) { ?>
								<span class="klaviyo-pro-label"><?php echo esc_html( __( 'Get License', 'klaviyo' ) ); ?></span>
							<?php } ?>
							<p class="description"><?php echo esc_html( __( 'Triggered on subscription renewals.', 'klaviyo' ) ); ?></p>
						</th>
						<td class="<?php echo esc_attr( $klaviyo_pro_class ); ?>">
							<div class="klaviyo-toggle klaviyo-toggle--size-small">
								<input type="checkbox" name="klaviyo_wc_subscription_renewal" id="klaviyo_wc_subscription_renewal"
								       value="enabled" <?php echo esc_attr( $klaviyo_wc_subscription_renewal_opt ); ?> <?php echo esc_attr( $klaviyo_disabled_class ); ?>>
								<label for="klaviyo_wc_subscription_renewal">
									<div class="klaviyo-toggle__switch" data-checked="On" data-unchecked="Off"></div>
								</label>
							</div>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="klaviyo_wc_subscription_status_change"><?php echo esc_html( __( 'Enable "WC Subscription Status Change" Event', 'klaviyo' ) ); ?></label>
							<?php if ( 'valid' !== $klaviyo_edd_license_status ) { ?>
								<span class="klaviyo-pro-label"><?php echo esc_html( __( 'Get License', 'klaviyo' ) ); ?></span>
							<?php } ?>
							<p class="description"><?php echo esc_html( __( 'Triggered on subscription status change: Active, On Hold, Pending Cancellation, Cancelled, Expired.', 'klaviyo' ) ); ?></p>
						</th>
						<td class="<?php echo esc_attr( $klaviyo_pro_class ); ?>">
							<div class="klaviyo-toggle klaviyo-toggle--size-small">
								<input type="checkbox" name="klaviyo_wc_subscription_status_change" id="klaviyo_wc_subscription_status_change"
								       value="enabled" <?php echo esc_attr( $klaviyo_wc_subscription_status_change_opt ); ?> <?php echo esc_attr( $klaviyo_disabled_class ); ?>>
								<label for="klaviyo_wc_subscription_status_change">
									<div class="klaviyo-toggle__switch" data-checked="On" data-unchecked="Off"></div>
								</label>
							</div>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="klaviyo_subscription_events"><?php echo esc_html( __( 'Enable Legacy Subscription Events', 'klaviyo' ) ); ?></label>
							<?php if ( 'valid' !== $klaviyo_edd_license_status ) { ?>
								<span class="klaviyo-pro-label"><?php echo esc_html( __( 'Get License', 'klaviyo' ) ); ?></span>
							<?php } ?>
							<p class="description"><?php echo esc_html( __( 'These will eventually be phased out in replace of the above three events.', 'klaviyo' ) ); ?></p>
						</th>
						<td class="<?php echo esc_attr( $klaviyo_pro_class ); ?>">
							<div class="klaviyo-toggle klaviyo-toggle--size-small">
								<input type="checkbox" name="klaviyo_subscription_events" id="klaviyo_subscription_events"
								       value="enabled" <?php echo esc_attr( $klaviyo_sub_events_opt ); ?> <?php echo esc_attr( $klaviyo_disabled_class ); ?>>
								<label for="klaviyo_subscription_events">
									<div class="klaviyo-toggle__switch" data-checked="On" data-unchecked="Off"></div>
								</label>
							</div>
						</td>
					</tr>
				</table>
				<h3><?php echo esc_html( __( 'Subscription Gifting', 'klaviyo' ) ); ?></h3>
				<p><?php echo esc_html( __( 'Improve features with WC subscriptions gifting plugin.', 'klaviyo' ) ); ?></p>
				<table class="form-table">
					<tr>
						<th scope="row">
							<label for="klaviyo_change_email_to_recipient"><?php echo esc_html( __( 'Change the "WC Subscription Created" recipient', 'klaviyo' ) ); ?></label>
							<p class="description">
								<?php echo esc_html( __( 'Change the email address from the person buying the subscription to the gift recipient when a new subscription is created.', 'klaviyo' ) ); ?>
							</p>
							<?php if ( 'valid' !== $klaviyo_edd_license_status ) { ?>
								<span class="klaviyo-pro-label"><?php echo esc_html( __( 'Get License', 'klaviyo' ) ); ?></span>
							<?php } ?>
						</th>
						<td class="<?php echo esc_attr( $klaviyo_pro_class ); ?>">
							<div class="klaviyo-toggle klaviyo-toggle--size-small">
								<input type="checkbox" name="klaviyo_change_email_to_recipient" id="klaviyo_change_email_to_recipient"
								       value="enabled" <?php echo esc_attr( $klaviyo_change_email_to_recipient_opt ); ?> <?php echo esc_attr( $klaviyo_disabled_class ); ?>>
								<label for="klaviyo_change_email_to_recipient">
									<div class="klaviyo-toggle__switch" data-checked="On" data-unchecked="Off"></div>
								</label>
							</div>
						</td>
					</tr>
				</table>
				<h3><?php echo esc_html( __( 'Miscellaneous', 'klaviyo' ) ); ?></h3>
				<p><?php echo esc_html( __( 'Other features to improve your Klaviyo campaigns.', 'klaviyo' ) ); ?></p>
				<table class="form-table">
					<tr>
						<th scope="row">
							<label for="klaviyo_add_imgs_to_rss"><?php echo esc_html( __( 'Add images to WordPress RSS feeds', 'klaviyo' ) ); ?></label>
							<p class="description"><?php echo esc_html( __( 'Helps to add blog post feeds into your Klaviyo campaigns.', 'klaviyo' ) ); ?></p>
							<?php if ( 'valid' !== $klaviyo_edd_license_status ) { ?>
								<span class="klaviyo-pro-label"><?php echo esc_html( __( 'Get License', 'klaviyo' ) ); ?></span>
							<?php } ?>
						</th>
						<td class="<?php echo esc_attr( $klaviyo_pro_class ); ?>">
							<div class="klaviyo-toggle klaviyo-toggle--size-small">
								<input type="checkbox" name="klaviyo_add_imgs_to_rss" id="klaviyo_add_imgs_to_rss"
								       value="enabled" <?php echo esc_attr( $klaviyo_add_imgs_to_rss_opt ); ?> <?php echo esc_attr( $klaviyo_disabled_class ); ?>>
								<label for="klaviyo_add_imgs_to_rss">
									<div class="klaviyo-toggle__switch" data-checked="On" data-unchecked="Off"></div>
								</label>
							</div>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="klaviyo_email_above_name_fields"><?php echo esc_html( __( 'Move email address to above the name fields on the checkout page', 'klaviyo' ) ); ?></label>
							<p class="description"><?php echo esc_html( __( 'This allows Klaviyo to capture the users email earlier in the checkout flow (helpful for abandoned cart flows).', 'klaviyo' ) ); ?></p>
							<?php if ( 'valid' !== $klaviyo_edd_license_status ) { ?>
								<span class="klaviyo-pro-label"><?php echo esc_html( __( 'Get License', 'klaviyo' ) ); ?></span>
							<?php } ?>
						</th>
						<td class="<?php echo esc_attr( $klaviyo_pro_class ); ?>">
							<div class="klaviyo-toggle klaviyo-toggle--size-small">
								<input type="checkbox" name="klaviyo_email_above_name_fields" id="klaviyo_email_above_name_fields"
								       value="enabled" <?php echo esc_attr( $klaviyo_email_above_name_fields_opt ); ?> <?php echo esc_attr( $klaviyo_disabled_class ); ?>>
								<label for="klaviyo_email_above_name_fields">
									<div class="klaviyo-toggle__switch" data-checked="On" data-unchecked="Off"></div>
								</label>
							</div>
						</td>
					</tr>
				</table>
				<h3><?php echo esc_html( __( 'Abandoned Cart Coupon Generation', 'klaviyo' ) ); ?>
					<span class="ktk-version-badge"><?php echo esc_html( __( 'NEW!', 'klaviyo' ) ); ?></span>
				</h3>
				<p><?php echo esc_html( __( 'Automatically generate a coupon every time your customers start checkout and add that coupon\'s details to their Klaviyo customer profile.', 'klaviyo' ) ); ?></p>
				<table class="form-table">
					<tr>
						<th scope="row">
							<label for="klaviyo_abandoned_cart_coupon"><?php echo esc_html( __( 'Enable Abandoned Cart Coupons', 'klaviyo' ) ); ?></label>
							<?php if ( 'valid' !== $klaviyo_edd_license_status ) { ?>
								<span class="klaviyo-pro-label"><?php echo esc_html( __( 'Get License', 'klaviyo' ) ); ?></span>
							<?php } ?>
						</th>
						<td class="<?php echo esc_attr( $klaviyo_pro_class ); ?>">
							<div class="klaviyo-toggle klaviyo-toggle--size-small">
								<input type="checkbox" name="klaviyo_abandoned_cart_coupon" id="klaviyo_abandoned_cart_coupon"
								       value="enabled" <?php echo esc_attr( $klaviyo_abandoned_cart_coupon_opt ); ?> <?php echo esc_attr( $klaviyo_disabled_class ); ?>>
								<label for="klaviyo_abandoned_cart_coupon">
									<div class="klaviyo-toggle__switch" data-checked="On" data-unchecked="Off"></div>
								</label>
							</div>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="klaviyo_coupon_amount"><?php echo esc_html( __( 'Coupon Amount', 'klaviyo' ) ); ?></label>
							<?php if ( 'valid' !== $klaviyo_edd_license_status ) { ?>
								<span class="klaviyo-pro-label"><?php echo esc_html( __( 'Get License', 'klaviyo' ) ); ?></span>
							<?php } ?>
						</th>
						<td class="<?php echo esc_attr( $klaviyo_pro_class ); ?>">
							<input type="number" name="klaviyo_coupon_amount" id="klaviyo_coupon_amount"
							       class="klaviyo-coupon-amount <?php echo esc_attr( $klaviyo_disabled_class ); ?>"
							       value="<?php echo esc_html( $klaviyo_coupon_amount ); ?>" size="2">
							<select name="klaviyo_coupon_type" id="klaviyo_coupon_type"
							        class="klaviyo-coupon-type <?php echo esc_attr( $klaviyo_disabled_class ); ?>">
								<option value="fixed" <?php selected( $klaviyo_coupon_type, 'fixed' ) ?>><?php esc_html_e( 'Fixed cart discount', 'klaviyo' ) ?></option>
								<option value="percentage" <?php selected( $klaviyo_coupon_type, 'percentage' ) ?>><?php esc_html_e( 'Percentage discount', 'klaviyo' ) ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="klaviyo_coupon_expiration"><?php echo esc_html( __( 'Coupon Expiration', 'klaviyo' ) ); ?></label>
							<?php if ( 'valid' !== $klaviyo_edd_license_status ) { ?>
								<span class="klaviyo-pro-label"><?php echo esc_html( __( 'Get License', 'klaviyo' ) ); ?></span>
							<?php } ?>
						</th>
						<td class="<?php echo esc_attr( $klaviyo_pro_class ); ?>">
							<input type="number" name="klaviyo_coupon_expiration" id="klaviyo_coupon_expiration"
							       class="klaviyo-coupon-amount <?php echo esc_attr( $klaviyo_disabled_class ); ?>"
							       value="<?php echo esc_html( $klaviyo_coupon_expiration ); ?>" max="999">
							<?php esc_html_e( ' Days', 'klaviyo' ); ?>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="klaviyo_coupon_prefix"><?php echo esc_html( __( 'Custom Coupon Prefix', 'klaviyo' ) ); ?></label>
							<?php if ( 'valid' !== $klaviyo_edd_license_status ) { ?>
								<span class="klaviyo-pro-label"><?php echo esc_html( __( 'Get License', 'klaviyo' ) ); ?></span>
							<?php } ?>
						</th>
						<td class="<?php echo esc_attr( $klaviyo_pro_class ); ?>">
							<input type="text" name="klaviyo_coupon_prefix" id="klaviyo_coupon_prefix"
							       class="<?php echo esc_attr( $klaviyo_disabled_class ); ?>" value="<?php echo esc_html( $klaviyo_coupon_prefix ); ?>">
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="klaviyo_coupon_used_with_other"><?php echo esc_html( __( 'Can be used with other coupons?', 'klaviyo' ) ); ?></label>
							<?php if ( 'valid' !== $klaviyo_edd_license_status ) { ?>
								<span class="klaviyo-pro-label"><?php echo esc_html( __( 'Get License', 'klaviyo' ) ); ?></span>
							<?php } ?>
						</th>
						<td class="<?php echo esc_attr( $klaviyo_pro_class ); ?>">
							<input type="radio" checked id="other_coupon_no" name="klaviyo_coupon_used_with_other" class="<?php echo esc_attr( $klaviyo_disabled_class ); ?>"
							       value="no" <?php checked( $klaviyo_coupon_used_with_other, 'no' ) ?>>
							<label for="other_coupon_no">No</label>
							<input type="radio" id="other_coupon_yes" name="klaviyo_coupon_used_with_other" class="<?php echo esc_attr( $klaviyo_disabled_class ); ?>"
							       value="yes" <?php checked( $klaviyo_coupon_used_with_other, 'yes' ) ?>>
							<label for="other_coupon_yes">Yes</label>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="klaviyo_coupon_free_shipping"><?php echo esc_html( __( 'Allow free shipping?', 'klaviyo' ) ); ?></label>
							<?php if ( 'valid' !== $klaviyo_edd_license_status ) { ?>
								<span class="klaviyo-pro-label"><?php echo esc_html( __( 'Get License', 'klaviyo' ) ); ?></span>
							<?php } ?>
						</th>
						<td class="<?php echo esc_attr( $klaviyo_pro_class ); ?>">
							<input type="radio" checked id="free_shipping_no" name="klaviyo_coupon_free_shipping" class="<?php echo esc_attr( $klaviyo_disabled_class ); ?>"
							       value="no" <?php checked( $klaviyo_coupon_free_shipping, 'no' ) ?>>
							<label for="free_shipping_no">No</label>
							<input type="radio" id="free_shipping_yes" name="klaviyo_coupon_free_shipping" class="<?php echo esc_attr( $klaviyo_disabled_class ); ?>"
							       value="yes" <?php checked( $klaviyo_coupon_free_shipping, 'yes' ) ?>>
							<label for="free_shipping_yes">Yes</label>
						</td>
					</tr>
				</table>
			<?php } else if ( 'license' === $klaviyo_current_tab ) {
				include( plugin_dir_path( __FILE__ ) . 'partials/klaviyo-admin-license-screen.php' );
			} ?>
			<?php submit_button(); ?>
		</form>
		<div class="klaviyo-notices-container">
			<div class="klaviyo-box klaviyo-call ktk-woo-course" style="display:none;">
				<span class="dashicons dashicons-superhero-alt"></span>
				<h3><?php echo esc_html( __( 'Boost ', 'klaviyo' ) ); ?><?php echo get_bloginfo( 'name' ); ?><?php echo esc_html( __( ' conversions in 7 days ', 'klaviyo' ) ); ?>
					<br><span class="ktk-sub-heading"><?php echo esc_html( __( 'FREE EMAIL MICRO-COURSE', 'klaviyo' ) ); ?></span></h3>
				<p><?php echo esc_html( __( 'Learn the top strategies, tactics, plugins & tools you need to increase conversions and scale your store revenue.', 'klaviyo' ) ); ?></p>
				<form method="POST" action="https://madebytribe.activehosted.com/proc.php" id="_form_8_" class="_form _form_8 _inline-form  _dark" novalidate>
					<input type="hidden" name="u" value="8" />
					<input type="hidden" name="f" value="8" />
					<input type="hidden" name="s" />
					<input type="hidden" name="c" value="0" />
					<input type="hidden" name="m" value="0" />
					<input type="hidden" name="act" value="sub" />
					<input type="hidden" name="v" value="2" />
					<div class="_form-content">
						<div class="ktk-form-fields">
							<div class="_form_element _x75997405 _full_width ">
								<label for="firstname" class="_form-label">First Name</label>
								<div class="_field-wrapper">
									<input type="text" id="firstname" name="firstname" placeholder="First name" />
								</div>
							</div>
							<div class="_form_element _x98329165 _full_width ">
								<label for="email" class="_form-label">Email*</label>
								<div class="_field-wrapper">
									<input type="text" id="email" name="email" placeholder="Your email" required />
								</div>
							</div>
						</div>
						<div class="_button-wrapper _full_width">
							<button id="_form_8_submit" class="button-primary" type="submit">
								<?php echo esc_html( __( 'Get Your First Lesson', 'klaviyo' ) ); ?>
								<span class="dashicons dashicons-arrow-right-alt"></span></a>
							</button>
						</div>
					</div>
				</form>
			</div>
			<div class="klaviyo-box ktk-links">
				<h3><?php echo esc_html( __( 'Enhance Your Store Further with These Premium Plugins', 'klaviyo' ) ); ?></h3>
				<ul class="ktk-product-links">
					<li class="caddy-cta">
						<img src="<?php echo plugin_dir_url( __DIR__ ) ?>admin/images/caddy-logo.png" width="40" height="40" />
						<div>
							<a href="https://www.usecaddy.com/?utm_source=klaviyo-plugin&amp;utm_medium=plugin&amp;utm_campaign=klaviyo-links"
							   target="_blank" class="cta-title"><?php echo esc_html( __( 'Caddy', 'klaviyo' ) ); ?></a>
							<p><?php echo esc_html( __( 'Add an enhanced sticky side-cart to your store with free shipping meter, wishlists and more.', 'klaviyo' ) ); ?></p>
							<a href="https://www.usecaddy.com/?utm_source=klaviyo-plugin&amp;utm_medium=plugin&amp;utm_campaign=klaviyo-links" class="button">Get Caddy</a>
						</div>
					</li>
					<li class="rk-cta">
						<img src="<?php echo plugin_dir_url( __DIR__ ) ?>admin/images/rk-logo-avatar.svg" width="40" height="40" />
						<div>
							<a href="https://www.getretentionkit.com/?utm_source=klaviyo-plugin&amp;utm_medium=plugin&amp;utm_campaign=klaviyo-links"
							   target="_blank" class="cta-title"><?php echo esc_html( __( 'RetentionKit', 'klaviyo' ) ); ?></a>
							<p><?php echo esc_html( __( 'Learn why users cancel their WC subscriptions with exit surveys, offer renewal discounts to stay and more.', 'klaviyo' ) ); ?></p>
							<a href="https://www.getretentionkit.com/?utm_source=klaviyo-plugin&amp;utm_medium=plugin&amp;utm_campaign=klaviyo-links" class="button">Get
								RetentionKit</a>
						</div>
					</li>
				</ul>
			</div>
			<div class="klaviyo-box ktk-links">
				<h3><?php echo esc_html( __( 'Quick Links', 'klaviyo' ) ); ?></h3>
				<ul>
					<li>
						<a href="https://support.madebytribe.com/article-categories/klaviyo-toolkit-plugin/?utm_source=klaviyo-plugin&amp;utm_medium=plugin&amp;utm_campaign=plugin-links"><?php echo esc_html( __( 'Read the documentation', 'klaviyo' ) ); ?></a>
					</li>
					<li>
						<a href="https://support.madebytribe.com/submit-a-ticket/?utm_source=klaviyo-plugin&amp;utm_medium=plugin&amp;utm_campaign=plugin-links"><?php echo esc_html( __( 'Contact support', 'klaviyo' ) ); ?></a>
					</li>
					<li>
						<a href="https://www.facebook.com/groups/klaviyoforwoocommerce" target="_blank"><?php echo esc_html( __( 'Join our Facebook group', 'klaviyo' ) ); ?></a>
					</li>
					<li>
						<a href="https://www.madebytribe.com/products/klaviyo-toolkit-woocommerce/#edd-reviews"><?php echo esc_html( __( 'Leave a review (much appreciated!)', 'klaviyo' ) ); ?></a>
					</li>
					<li>
						<a href="https://madebytribe.com/login/?utm_source=klaviyo-plugin&amp;utm_medium=plugin&amp;utm_campaign=plugin-links"><?php echo esc_html( __( 'Access your TRIBE account', 'klaviyo' ) ); ?></a>
					</li>
					<li>
						<a href="https://www.madebytribe.com/contact-us/?utm_source=klaviyo-plugin&amp;utm_medium=plugin&amp;utm_campaign=plugin-links"><?php echo esc_html( __( '★ Hire TRIBE for a custom project', 'klaviyo' ) ); ?></a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="ktk-footer-links">
	<?php echo esc_html( __( 'Made with', 'klaviyo' ) ); ?> <span style="color: #e25555;">♥</span> <?php echo esc_html( __( 'by', 'klaviyo' ) ); ?>
	<a href="<?php echo esc_url( 'https://www.madebytribe.com' ); ?>" target="_blank"><?php echo esc_html( __( 'TRIBE', 'klaviyo' ) ); ?></a>
	| <a href="<?php echo esc_url( 'https://www.madebytribe.com/products/klaviyo-toolkit-woocommerce/#edd-reviews' ); ?>"
	     target="_blank"><?php echo esc_html( __( 'Leave a Review', 'klaviyo' ) ); ?></a>
	| <a href="<?php echo esc_url( 'https://support.madebytribe.com/article-categories/klaviyo-toolkit-plugin/' ); ?>"
	     target="_blank"><?php echo esc_html( __( 'Get Support', 'klaviyo' ) ); ?></a>
</div>
<script type="text/javascript">window.$sleek = [];
	window.SLEEK_PRODUCT_ID = 309272111;
	(function() {
		d = document;
		s = d.createElement( 'script' );
		s.src = 'https://client.sleekplan.com/sdk/e.js';
		s.async = 1;
		d.getElementsByTagName( 'head' )[ 0 ].appendChild( s );
	})();</script>