/**
* Podcast Featured Slider
* ---------
* @component Podcast
* @version 1.0
*/

jQuery(document).ready(function($) {

    var $podcastFeatured = $('.c-podcast-featured__slider');

    if(!$podcastFeatured.length) {
        return;
    }

    $podcastFeatured.slick({
        cssEase: 'ease-out',
        speed : 800,
        swipe: true,
        arrows: false,
        slidesToShow: 4.3,
        slidesToScroll: 4,
        rows: 0,
        swipeToSlide : true,
        infinite : false,
        responsive: [
            {
                breakpoint: 1910,
                settings: {
                    slidesToShow: 3.3,
                    slidesToScroll: 3,
                }
            },
            {
                breakpoint: 1440,
                settings: {
                    slidesToShow: 2.3,
                    slidesToScroll: 2,
                }
            },
            {
                breakpoint: 1010,
                settings: {
                    slidesToShow: 1.3,
                    slidesToScroll: 2,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                }
            },

        ]

    });

});