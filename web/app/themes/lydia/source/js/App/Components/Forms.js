/**
 * Forms
 * ---------
 * @component App/Components
 * @version 1.0
 *
 */
'use strict';

import { safeHtml } from 'common-tags'

class Forms {

    constructor(el) {
        this.form = document.querySelector(el);
        if (this.form == null) return;
        this.isEmailFilled();
        this.submission();
    }

    isEmailFilled() {
        const email = this.form.querySelector('.events-form__input--email');
        email.onkeyup = () => this.readyToSubmit(email);
    }

    readyToSubmit(email) {
        if (email.value.length != 0 && email.value != '') {
            this.form.classList.add('is-submittable');
        } else {
            this.form.classList.remove('is-submittable');
        }
    }

    lowerCase(email) {
        return String(email).toLowerCase();
    }

    subscribeSubmitting() {
        this.form.classList.add('is-submitting');
        this.form.querySelector('.events-form__submit').innerHTML = 'Sending';
    }

    submitFail() {
        this.form.classList.add('has-failed');
        this.form.classList.remove('is-submitting');
        this.form.querySelector('.events-form__submit').insertAdjacentHTML('afterend', safeHtml `<p class="events-form__message">Sorry something went wrong</p>`);
        this.form.querySelector('.events-form__submit').innerHTML = 'Failed';

        setTimeout(() => {
            this.formReset();
        }, 3000);
    }

    formReset() {
        this.form.classList.remove('has-failed', 'has-success', 'is-submittable');
        this.form.querySelector('.events-form__message').remove();
        this.form.querySelector('.events-form__submit').innerHTML = 'Send';
        this.form.reset();
    }

    submitSuccess() {
        this.form.classList.add('has-success');
        this.form.classList.remove('is-submitting');
        this.form.querySelector('.events-form__submit').innerHTML = 'Sent';
        this.form.querySelector('.events-form__submit').insertAdjacentHTML('afterend', safeHtml `<p class="events-form__message">Thank you for your enquiry</p>`);

        setTimeout(() => {
            this.formReset();
        }, 5000);
    }

    submission() {

        this.form.addEventListener('submit', (e) => {
            e.preventDefault();

            this.subscribeSubmitting();

            let data = new FormData(this.form);

            data.set('email', this.lowerCase(data.get('email')));
            data.set('action', 'form_contact');

            // Prepare Data
            data = new URLSearchParams(data);

            fetch(site.ajax.url, {
                    method: "POST",
                    body: data,
                }).then(res => res.json())
                .catch(error => {
                    console.log(error);
                    this.submitFail();
                })
                .then(response => {
                    if (response === 0 || response.code === 400) {
                        console.log(response);
                        this.submitFail();
                        return;
                    }
                    this.submitSuccess();
                });

        });
    }
}

new Forms('.js-contact-form');
