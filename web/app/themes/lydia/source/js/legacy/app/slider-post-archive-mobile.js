/**
* Issue Gallery Slider
* --------
* @package GJ
* @since GJ 3.0
*/

jQuery(document).ready(function ($) {

    $(window).on('load resize orientationchange', function() {
        $('.o-post-feed--slick').each(function(){
            var $carousel = $(this);
            /* Initializes a slick carousel only on mobile screens */
            // slick on mobile
            if ($(window).width() > 768) {
                if ($carousel.hasClass('slick-initialized')) {
                    $carousel.slick('unslick');
                }
            }
            else{
                if (!$carousel.hasClass('slick-initialized')) {
                    $carousel.slick({
                        cssEase: 'ease-out',
                        swipe: true,
                        arrows: false,
                        slidesToShow: 1,
                        centerMode: true,
                        infinite: false,
                    });
                }
            }
        });
    });
});
