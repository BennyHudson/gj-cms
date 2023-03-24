/**
* Instagram
* ---------
* @component app/components
* @version 1.0
*/
'use strict';

import { Swiper, Lazy, Autoplay } from 'swiper/swiper.esm.js';

class Instagram {

    constructor(el) {
        this.feed = document.querySelector(el);
        if (this.feed == null) return;

        this.feed_slider = el.concat('__slider');
        this.initSwiper(this.feed_slider);
    }

    initSwiper(slider) {

        Swiper.use([ Lazy, Autoplay ]);

        this.instagram = new Swiper(slider, {
            speed: 5000,
            effect: 'slide',
            spaceBetween: 12,
            slidesPerView: 1.4,
            loop: true,
            freeMode: true,
            simulateTouch: true,
            watchOverflow: true,
            preloadImages: false,
            lazy: {
                loadPrevNext: true,
                loadPrevNextAmount: 6
            },
            autoplay : {
                delay: 0,
                disableOnInteraction: true,
            },
            breakpoints: {
                769: {
                    speed: 7000,
                    slidesPerView: 3,
                    spaceBetween: 48,
                }
            }
        });
    }
}

new Instagram('.c-instagram');
