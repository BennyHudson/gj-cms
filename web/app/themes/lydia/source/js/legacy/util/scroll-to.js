/**
* Scroll To
* ---------
* @component Home
* @version 1.0
*/

jQuery(document).ready(function($) {

    var scrollToItem = function(element, container) {
        element.on('click', function () {
            $('html, body').animate({
                scrollTop: container.offset().top - $('.o-masthead--prime').outerHeight()
            }, 1000);
        });
    };
    scrollToItem($('.c-podcast-hero-nav__scroll'), $('.c-podcast-overview'));
});
