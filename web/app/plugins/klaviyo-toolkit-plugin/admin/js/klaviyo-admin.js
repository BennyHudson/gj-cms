(function( $ ) {
	'use strict';

	jQuery( document ).ready( function( $ ) {

		// Klaviyo license button
		$( document ).on( 'click', '.klaviyo-edd-license-btn', function() {

			var button_name = $( this ).attr( 'name' );
			var data = {
				action: 'klaviyo_license_button',
				button_name: button_name
			};
			$.ajax( {
				type: 'post',
				url: klaviyoAdminAjax.ajaxurl,
				data: data,
				beforeSend: function() {
					$( '.klaviyo-admin-loader' ).show();
					$( '.klaviyo-license-table' ).addClass( 'klaviyo-fade-table' );
				},
				complete: function( response ) {
					$( '.klaviyo-license-table' ).removeClass( 'klaviyo-fade-table' );
					$( '.klaviyo-admin-loader' ).hide();
				},
				success: function( response ) {
					var redirectUrl = response.redirect_url,
						klaviyo_activation_flag = response.sl_activation,
						klaviyo_activation_msg = response.message;

					if ( 'false' === klaviyo_activation_flag ) {
						$( '.klaviyo-license-msg' ).html( '<div class="error"><p>' + klaviyo_activation_msg + '</p></div>' );
					} else {
						$( '.klaviyo-license-msg' ).html( '<div class="notice"><p>' + klaviyo_activation_msg + '</p></div>' );
					}

					window.location.href = redirectUrl;
				}
			} );

		} );
	} );

})( jQuery );
