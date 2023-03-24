/**
* Issue Gallery Slider
* --------
* @package GJ
* @since GJ 3.0
*/

jQuery(document).ready(function ($) {

    $('#js-section-shop').slick({
        cssEase: 'ease-out',
        swipe: true,
        arrows: true,
        slidesToShow: 5,
        rows: 0,
        slidesToScroll: 1,
        infinite: false,
        prevArrow: document.getElementById('js-section-shop-previous'),
        nextArrow: document.getElementById('js-section-shop-next'),

        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    arrows: false,
                }
            },
            {
              breakpoint: 804,
              settings: {
                arrows: false,
                slidesToShow: 2,
                slidesToScroll: 1,
              }
            },
            {
              breakpoint: 490,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                centerMode: true,
              }
            }
        ]
    });

});
