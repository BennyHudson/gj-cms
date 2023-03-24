/**
*  Modal Newsletter
*  ------
*  Reveal the Newsletter Modal After a period of time
*  ------
*  @package Lydia
*  @since Lydia 2.0
*  @requires jQuery 1.11
*/

var newsletterModal        = $('#js-modal-newsletter');
var newsletterModalClose   = $('#js-modal-newsletter-close');
var newsletterModalForm    = $('#js-newsletter-modal-form');
var newsletterModalMessage = $('.c-modal-newsletter__validation-msg');
var newsletterModalQuickOpen = $('.js-open-newsletter-modal');

// // Create a Cookie
function createCookie(name, value, days) {
    var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        var expires = "expires="+ date.toGMTString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
}

// Read the Cookie
function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

// Newsletter Functions
function openNewsletterModal() {
	$('body').addClass('js-has-news-modal-open');
    newsletterModal.addClass('is-open');
    newsletterModal.removeClass('is-closed');
}
function closeNewsletterModal() {
	$('body').removeClass('js-has-news-modal-open');
    newsletterModal.removeClass('is-open');
    newsletterModal.addClass('is-closed').css('display', '');
    localStorage.setItem('NewsletterClosed', true);
}

// Show / Hide the Modal
jQuery(document).ready(function($) {

    if (! localStorage.getItem('NewsletterClosed') ) {
        // If does not exist do not run
        if (!newsletterModal) { return; }
        // Add display block to modal before animation
        setTimeout(function() {
           newsletterModal.css({ display: "flex" });
        }, 29998);
        // Open Newsletter After 20 Seconds
        setTimeout(function() {
           openNewsletterModal();
        }, 30000);
    }
});



newsletterModalQuickOpen.on('click',  function() {
    openNewsletterModal();
    newsletterModal.css({ display: "flex" });
});

newsletterModalClose.on('click',  function() {
    closeNewsletterModal();
    setTimeout(function() {
        newsletterModal.css({ display: "none" });
    }, 400);
});

$(newsletterModal).on('click', function (e) {
    if (e.target.id === 'js-modal-newsletter') {
        closeNewsletterModal();
    }
});


// Submit the newsletter form
jQuery(document).ready(function($) {

    // Validate the form.
    newsletterModalForm.on('submit', function(e) {
		e.preventDefault();
		var email = this.querySelector('.c-modal-newsletter__entry--email').value;
        var title = this.querySelector('.c-modal-newsletter__entry--title').value;
        var fname = this.querySelector('.c-modal-newsletter__entry--fname').value;
		var lname = this.querySelector('.c-modal-newsletter__entry--lname').value;
		var data = {
			action: 'sendgrid_subscribe',
			email : email,
            title : title,
            fname : fname,
            lname : lname
		};

		$.get({
			type: 'POST',
			url: site.ajax.url,
			data: data,
			beforeSend: function() {
				newsletterModalMessage.text('Sending your details');
				newsletterModalForm.css('opacity', '0.3');
			},
			success: function(data) {
				newsletterModalMessage.text('Thank you for signing up');
				newsletterModalForm.css({'opacity':'0', 'pointer-events':'none'});
                setTimeout(function() {
                    closeNewsletterModal();
                }, 500);
                createCookie("modal-newsletter", "1", 365); // 1 Years if they have already signed up
			},
			error: function(data) {
				newsletterModalMessage.text('Sorry, there was a problem with the sign up, please try again');
				newsletterModalForm.css('opacity', '1');
			}
		});
	});
});
