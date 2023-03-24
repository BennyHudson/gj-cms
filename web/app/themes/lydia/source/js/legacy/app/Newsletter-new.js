/**
* Newsletter
* ---------
* @component App/Foundation
* @version 1.0
*
*/
'use strict';

var newNewsletterForm = $('.c-form');

  // Validate the form.
newNewsletterForm.on('submit', function(e) {
    e.preventDefault();
    var email = this.querySelector('.c-form__input--email').value;
    var title = this.querySelector('.c-form__input--title').value;
    var fname = this.querySelector('.c-form__input--fname').value;
    var lname = this.querySelector('.c-form__input--lname').value;
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
            newNewsletterForm.css('opacity', '0.3');
        },
        success: function(data) {
            console.log(data);
            newNewsletterForm.find('.c-form__submit').text('Success');
            newNewsletterForm.css({'opacity':'1', 'pointer-events':'none'});
            setTimeout(function() {
                closeNewsletterModal();
            }, 500);
            createCookie("modal-newsletter", "1", 365);
        },
        error: function(data) {
            console.log(data);
            newNewsletterForm.css('opacity', '1');
        }
    });
});
