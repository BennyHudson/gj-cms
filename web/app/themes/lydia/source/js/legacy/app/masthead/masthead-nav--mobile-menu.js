/**
 * Masthead Submenu
 *
 * Add hover class to parent link
 * on child hover
 * --------
 * @package app/masthead
 * @version 2.0.0
 */

jQuery(document).ready(function($){

    var $hamburger = $('#js-masthead-ham');
    var $body = $('body');
    var $masthead_nav = $('.c-masthead-nav');
    var $masthead_sub_nav = $('.c-masthead-nav__subnav');
    var $masthead_actions = $('.c-masthead-actions');

    $hamburger.on('click', function(event) {
        event.preventDefault();
        $body.toggleClass('has-mob-menu-active');
        $masthead_nav.toggleClass('js-is-open');
        $hamburger.toggleClass('js-is-active');
        $masthead_actions.toggleClass('js-is-open');
    });

    // Remove mobile menu submenu Classes if window resized
    $(window).smartResize(function resize() {
        if ($hamburger.is(':hidden')) {
            $body.removeClass('has-mob-menu-active');
            $masthead_nav.removeClass('js-is-open');
            $hamburger.removeClass('js-is-active');
            $masthead_actions.removeClass('js-is-open');
            $masthead_sub_nav.removeAttr('style').removeClass('js-is-active');
        }
    }).trigger('resize');

});
