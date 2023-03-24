/**
* Subscription Item Brands
* ---------
* @component Subscription
* @version 1.0
*/

jQuery(document).ready(function ($) {

    var $subscriptionBrands = $('.c-subscription-brands__items');

    if(!$subscriptionBrands.length) {
        return;
    }

    $subscriptionBrands.slick({
        dots: false,
        cssEase: 'ease-out',
        swipe: true,
        arrows: false,
        autoplay: true,
        infinite: true,
        slidesToShow: 5,
        responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 4
              }
            },
            {
              breakpoint: 769,
              settings: {
                slidesToShow: 3,
                centerMode: true
              }
            },
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 2,
                centerMode: true
              }
            }
          ]
    });

});
