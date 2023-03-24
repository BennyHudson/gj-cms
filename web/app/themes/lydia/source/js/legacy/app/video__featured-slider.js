/**
* Video Hero Slider
* ---------
* @component video
* @version 1.0
*/

jQuery(document).ready(function($) {

    var $videoHero = $('.c-video-hero-slider__main');
    var $videoHeroNav = $('.c-video-hero-nav');
    var $videoHeroNavItem = $('.c-video-hero-nav__item');
    var $videoHeroNavItemCurrent = $videoHeroNav.find('.is-current');
    var $videoHeroNavMarker = $('.c-video-hero-nav__marker');

    if(!$videoHero.length) {
        return;
    }

    // Hero Slider
    $videoHero.slick({
        cssEase: 'linear',
        speed: '600',
        fade: true,
        swipe: false,
        arrows: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        rows: 0,
        autoplay: false,
        infinite: false,

        responsive: [
            {
                breakpoint: 1100,
                settings: {
                    swipe: true,
                    dots: true,
                    autoplay: true,
                    autoplaySpeed: 2000,
                }
            },
        ]
    });

    // Change Hero slide on Nav Click
    function gotToSlide(nav, slider) {
        var navkId = $(nav).data('slick-nav-index');
        $(slider).slick('slickGoTo', navkId, false);

    }

    // Set the size and position of the marker on load
    $videoHeroNavMarker
        .width($videoHeroNavItemCurrent.outerWidth())
        .css('transform', 'translateX(' + $videoHeroNavItemCurrent.position().left +'px)');

    $(window).smartResize(function resize() {
        $videoHeroNavMarker
            .width($videoHeroNavItemCurrent.outerWidth())
            .css('transform', 'translateX(' + $videoHeroNavItemCurrent.position().left +'px)');
    }).trigger('resize');

    function moveMarker(item) {
        leftPos = $(item).position().left;
        width = $(item).outerWidth();

        $videoHeroNavMarker
            .css('transform', 'translateX(' + leftPos +'px)')
            .width(width);
    }

    // Do the things on nav click
    $videoHeroNavItem.on('click', function() {
        var $this = $(this);

        gotToSlide($this, $videoHero);
        moveMarker($this);
        $this.addClass('is-current').siblings().removeClass('is-current');

    });


});