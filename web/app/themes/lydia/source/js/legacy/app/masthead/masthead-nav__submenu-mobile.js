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
    var $masthead_nav_subnav_icon = $('.js-masthead-nav--subnav');

    if ($hamburger.is(':hidden')) {
        return;
    }

    $masthead_nav_subnav_icon.on('click', function(event) {
        var $this = $(this);
        event.preventDefault();

        $this.toggleClass('js-is-active');
        $this.next('.c-masthead-nav__subnav').slideToggle('400').toggleClass('js-is-active');
    });

});
