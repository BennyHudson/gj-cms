/**
* Podcast Hero Slider
* ---------
* @component Podcast
* @version 1.0
*/

jQuery(document).ready(function($) {

    var $podcastHero = $('.c-podcast-hero-slider__main');
    var $podcastHeroNav = $('.c-podcast-hero-nav');
    var $podcastHeroNavItem = $('.c-podcast-hero-nav__item');
    var $podcastHeroNavItemCurrent = $podcastHeroNav.find('.is-current');
    var $podcastHeroNavMarker = $('.c-podcast-hero-nav__marker');

    if(!$podcastHero.length) {
        return;
    }

    // Hero Slider
    $podcastHero.slick({
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
    $podcastHeroNavMarker
        .width($podcastHeroNavItemCurrent.outerWidth())
        .css('transform', 'translateX(' + $podcastHeroNavItemCurrent.position().left +'px)');

    $(window).smartResize(function resize() {
        $podcastHeroNavMarker
            .width($podcastHeroNavItemCurrent.outerWidth())
            .css('transform', 'translateX(' + $podcastHeroNavItemCurrent.position().left +'px)');
    }).trigger('resize');

    function moveMarker(item) {
        leftPos = $(item).position().left;
        width = $(item).outerWidth();

        $podcastHeroNavMarker
            .css('transform', 'translateX(' + leftPos +'px)')
            .width(width);
    }

    // Do the things on nav click
    $podcastHeroNavItem.on('click', function() {
        var $this = $(this);

        gotToSlide($this, $podcastHero);
        moveMarker($this);
        $this.addClass('is-current').siblings().removeClass('is-current');

    });


});