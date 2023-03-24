/**
* Featured Products
* ---------
* @component app/welcome
* @version 1.0
*/
'use strict';

import { Swiper, Pagination, Navigation, EffectFade } from 'swiper/swiper.esm.js';

class MediaText {

    constructor(el) {
        this.swipers = [];
        this.media_text = document.querySelector(el);
        if (this.media_text == null) return;
        this.media_text_slider = el.concat('__slider');
        this.initSwiper(this.media_text_slider);
    }

    initSwiper(el) {
        Swiper.use([ Pagination, Navigation, EffectFade ]);

        new Swiper(el, {
            speed: 1200,
            loop: true,
            effect: 'fade',
            simulateTouch: true,
            navigation: {
                nextEl: this.media_text.querySelector('.swiper-button-next'),
                prevEl: this.media_text.querySelector('.swiper-button-prev'),
            },
            watchOverflow: true,
            preventInteractionOnTransition: true,
            breakpoints: {
                768: {
                    preventInteractionOnTransition: false,
                    simulateTouch: false,
                }
            }
        });
    }
}

new MediaText('.c-content-builder__mediatext');
