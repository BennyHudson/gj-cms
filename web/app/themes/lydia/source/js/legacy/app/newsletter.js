/**
*  Newsletter Footer
*  ------
*  @package Lydia
*  @since Lydia 2.0
*  @requires jQuery 1.11
*/

var newsletterForm    = $('#js-newsletter-form');
var newsletterMessage = $('.js-newsletter-form__message');

// Submit the newsletter form
jQuery(document).ready(function($) {

    // Send the Data
	newsletterForm.on('submit', function(e) {
		e.preventDefault();
        var email = this.querySelector('.js-newsletter-form__email').value;

        var data = {
			action: 'sendgrid_subscribe',
			email: email
		};

		$.get({
			type: 'POST',
			url: site.ajax.url,
			data: data,
			beforeSend: function(data) {
				console.log(data);
				newsletterMessage.text('Sending your details');
				newsletterForm.css('opacity', '0.3');
			},
			success: function(data) {
				console.log(data);
                newsletterMessage.text('Thank you for signing up');
				newsletterForm.css({'opacity':'0.2', 'pointer-events':'none'});
			},
			error: function(data) {
                newsletterMessage.text('Sorry, there was a problem with the sign up, please try again');
				newsletterForm.css('opacity', '1');
			}
		});
	});
});
