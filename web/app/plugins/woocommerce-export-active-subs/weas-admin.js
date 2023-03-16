(function() {
	'use strict';
	jQuery(document).ready(function($) {
		$('#weas-btn').on('click', function() {
			window.location.href = window.location.href + '&generate_csv';
		});
	});
}());
