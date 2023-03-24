/**
* They see me SCROOOOOOLING
* --------
* @package GJ
* @since GJ 3.0
*/

var isScrollingAfter;

var $logoPrime = $('.o-logo--masthead .o-logo--wordmark'),
    $logoIcon =  $('.o-logo--masthead .o-logo--symbol');

function menuScroll() {
    'use strict';

    if (isScrollingAfter == 0 && window.scrollY <= isScrollingAfter) {
        document.body.classList.remove('js-is-scrolling');
    } else if(window.scrollY >= isScrollingAfter) {
        document.body.classList.add('js-is-scrolling');
    }
}

function logoScroll() {

    if (isScrollingAfter == 0 && window.scrollY <= isScrollingAfter) {

        $logoPrime.css('opacity', '1');
        $logoIcon.css('opacity', '0');

    } else if(window.scrollY >= isScrollingAfter) {
        $logoPrime.css('opacity', '0');
        $logoIcon.css('opacity', '1');
    }
}

jQuery(document).ready(function() {

    isScrollingAfter = 0;
    menuScroll();
    logoScroll();
    throttleResize(logoScroll);
    throttleResize(menuScroll);
    window.addEventListener('scroll', menuScroll);
    window.addEventListener('scroll', logoScroll);


});
