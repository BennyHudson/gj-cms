/**
* Issue Gallery Slider
* --------
* @package GJ
* @since GJ 789.0
*
*/

jQuery(document).ready(function ($) {


    $gallery_sliders = $('.c-content-builder-slider');

    $gallery_sliders.each(function() {

        $(this).find( ".c-content-builder-slider__slider" ).slick({
            cssEase: 'ease-out',
            swipe: false,
            arrows: true,
            fade: true,
            slidesToShow: 1,
            prevArrow: $(this).find( ".c-content-builder-slider__previous" ),
            nextArrow: $(this).find( ".c-content-builder-slider__next" )
        });
    });


    $full = $('.c-content-builder-slider-full');

    $full.each(function() {
        const $this = $(this);

        $this.find( ".c-content-builder-slider__slider-full" ).slick({
            cssEase: 'ease-out',
            infinite: true,
            swipe: true,
            arrows: true,
            fade: false,
            slidesToShow: 4,
            rows: 0,
            prevArrow:  $this.find('.c-content-builder-slider__previous'),
            nextArrow:  $this.find('.c-content-builder-slider__next'),
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                    }
                },
    
            ]
        });
    })


    $this = $('.c-content-builder-slider-products');
    $slider = $this.find('.c-content-builder-slider__slider-products')

    $slider.slick({
        cssEase: 'ease-out',
        infinite: true,
        swipe: true,
        arrows: true,
        fade: false,
        slidesToShow: 4,
        rows: 0,
        prevArrow: document.getElementsByClassName('c-content-builder-slider__previous--prod'),
        nextArrow: document.getElementsByClassName('c-content-builder-slider__next--prod'),
        responsive: [
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
