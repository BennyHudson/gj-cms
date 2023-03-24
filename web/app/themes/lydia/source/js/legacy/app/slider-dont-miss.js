/**
* Issue Gallery Slider
* --------
* @package GJ
* @since GJ 3.0
*/

jQuery(document).ready(function ($) {

    $('#js-dont-miss-slider').slick({
        cssEase: 'ease-out',
        swipe: true,
        arrows: true,
        slidesToShow: 8,
        slidesToScroll: 2,
        infinite: true,
        prevArrow: document.getElementById('js-dont-miss-previous'),
        nextArrow: document.getElementById('js-dont-miss-next'),

        responsive: [
            {
              breakpoint: 2526,
              settings: {
                swipe: true,
                slidesToShow: 6,
                slidesToScroll: 2,
              }
            },
            {
              breakpoint: 1944,
              settings: {
                swipe: true,
                slidesToShow: 5,
                slidesToScroll: 2,
              }
            },
            {
              breakpoint: 1445,
              settings: {
                swipe: true,
                slidesToShow: 4,
                slidesToScroll: 2,
              }
            },
            {
              breakpoint: 1380,
              settings: {
                swipe: true,
                slidesToShow: 3,
                slidesToScroll: 2
              }
            },
            {
              breakpoint: 1080,
              settings: {
                swipe: true,
                slidesToShow: 2,
                slidesToScroll: 1
              }
            },
            {
              breakpoint: 804,
              settings: {
                swipe: true,
                slidesToShow: 2,
                slidesToScroll: 1
              }
            },
            {
              breakpoint: 560,
              settings: {
                swipe: true,
                slidesToShow: 1,
                slidesToScroll: 1
              }
            }
        ]
    });

});
