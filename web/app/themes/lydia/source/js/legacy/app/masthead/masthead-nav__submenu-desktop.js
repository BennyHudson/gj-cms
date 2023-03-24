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

    var $masthead_nav_item = $('.c-masthead-nav__item');

    $masthead_nav_item.on('mouseover', function(){
        $(this).addClass('has-active');
    }).on('mouseout', function(){
        $(this).removeClass('has-active');
    });

});
