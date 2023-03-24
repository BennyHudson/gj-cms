/**
* Issue Gallery Slider
* --------
* @package GJ
* @since GJ 3.0
*/

jQuery(document).ready(function ($) {

    $('#js-issue-slider').slick({
        cssEase: 'ease-out',
        swipe: false,
        arrows: true,
        slidesToShow: 1,
        fade: true,
        rows: 0,
        autoplay: true,
        autoplaySpeed: 3000,
        prevArrow: document.getElementById('js-issue-slider-previous'),
        nextArrow: document.getElementById('js-issue-slider-next')
    });

});
