/**
* Newsletter
* ---------
* @component App/Foundation
* @version 1.0
*
*/
'use strict';

class Newsletter {

    constructor(el) {
        this.newsletter = document.querySelector(el);
        if (this.newsletter == null) return;
        this.isEmailFilled();
        this.submission();
    }

    isEmailFilled() {
        const email = this.newsletter.querySelector('.c-foundation-newsletter__input--email');
        email.onkeyup = () => this.readyToSubmit(email);
    }

    readyToSubmit(email) {
        if (email.value.length != 0 && email.value != '' ) {
            this.newsletter.classList.add('is-submittable');
        } else {
            this.newsletter.classList.remove('is-submittable');
        }
    }

    lowerCase(email) {
        return String(email).toLowerCase();
    }

    subscribeSubmitting() {
        this.newsletter.classList.add('is-submitting');
        this.newsletter.querySelector('i').classList.add('fal', 'fa-spinner-third', 'fa-spin');
    }

    subscribeFail() {
        this.newsletter.classList.add('has-failed');
        this.newsletter.classList.remove('is-submitting');
        this.newsletter.querySelector('i').classList.add('fal', 'fa-exclamation-circle');

        setTimeout(() => {
            this.subscribeReset();
        }, 3000);
    }

    subscribeReset() {
        this.newsletter.classList.remove('has-failed', 'has-success', 'is-submittable');
        this.newsletter.querySelector('i').classList.add('fal', 'fa-long-arrow-right');
        this.newsletter.reset();
    }

    subscribeSuccess() {
        this.newsletter.classList.add('has-success');
        this.newsletter.classList.remove('is-submitting');
        this.newsletter.querySelector('i').classList.add('fal', 'fa-check-circle');
    }

    submission() {

        this.newsletter.addEventListener('submit', (e) => {
            e.preventDefault();

            this.subscribeSubmitting();

            let data = new FormData(this.newsletter);

            data.set('email', this.lowerCase(data.get('email')));
            data.set('action', 'sendgrid_subscribe');

            // Prepare Data
            data = new URLSearchParams(data);

            fetch(site.ajax.url, {
                method: "POST",
                body: data,
            }).then(res => res.json())
                .catch(error => {
                    console.log(error);
                    this.subscribeFail();
                })
            .then(response => {
                if (response === 0 || response.status === 'error') {
                    console.log(response);
                    this.subscribeFail();
                    return;
                }
                this.subscribeSuccess();
            });

        });
    }
}

new Newsletter('.js-newsletter-form');
