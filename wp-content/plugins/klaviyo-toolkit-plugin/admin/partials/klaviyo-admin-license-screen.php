<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin license screen of the plugin.
 */
?>

<?php
$klaviyo_premium_license = get_option( 'klaviyo_edd_license_key' );
$klaviyo_premium_status  = get_option( 'klaviyo_edd_license_status' );
?>
<div class="klaviyo-license-msg"></div>
<h2><?php esc_html_e( 'Plugin License Options', 'klaviyo' ); ?></h2>
<table class="form-table klaviyo-license-table">
	<tbody>
	<tr>
		<th scope="row"><?php esc_html_e( 'License Key', 'klaviyo' ); ?></th>
		<td>
			<input id="klaviyo_edd_license_key" name="klaviyo_edd_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $klaviyo_premium_license ); ?>" />
			<p class="description" for="klaviyo_edd_license_key"><?php esc_html_e( 'Enter your license key', 'klaviyo' ); ?></p>
		</td>
	</tr>
	<?php if ( false !== $klaviyo_premium_license ) { ?>
		<tr>
			<th scope="row"><?php esc_html_e( 'Activate License', 'klaviyo' ); ?></th>
			<td>
				<?php if ( $klaviyo_premium_status !== false && $klaviyo_premium_status == 'valid' ) { ?>
					<span class="ktk-active-license-text"><span class="dashicons dashicons-saved"></span> <?php esc_html_e( 'Active', 'klaviyo' ); ?></span>
					<?php wp_nonce_field( 'klaviyo_edd_license_nonce', 'klaviyo_edd_license_nonce' ); ?>
					<input type="button" class="button-secondary klaviyo-edd-license-btn" name="klaviyo_edd_license_deactivate"
					       value="<?php esc_html_e( 'Deactivate License', 'klaviyo' ); ?>" />
				<?php } else {
					wp_nonce_field( 'klaviyo_edd_license_nonce', 'klaviyo_edd_license_nonce' ); ?>
					<input type="button" class="button-secondary klaviyo-edd-license-btn" name="klaviyo_edd_license_activate"
					       value="<?php esc_html_e( 'Activate License', 'klaviyo' ); ?>" />
				<?php } ?>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<div class="klaviyo-admin-loader" style="display: none;"></div>
