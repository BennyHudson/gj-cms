(function( $ ) {
	'use strict';

	jQuery( document ).ready( function( $ ) {
		$( '#billing_email' ).blur( function() {
			var billing_email = $( this ).val();
			if ( billing_email !== '' ) {
				var data = {
					action: 'klaviyo_profile_update_generate_coupon',
					billing_email: billing_email
				};
				$.ajax( {
					type: 'post',
					url: klaviyoPublicAjax.ajaxurl,
					data: data,
					success: function( response ) {
					}
				} );
			}
		} );
	} );

})( jQuery );
