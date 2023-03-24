/**
*  Mobile Menu
*  ------
*  Functions related to mobile navigation
*  ------
*  @package Lydia
*  @since Lydia 2.0
*  @requires jQuery 1.11
*/

jQuery(document).ready(function($) {

    // Reveal for the search bar
    $('#c-masthead-actions__item-search').click(function(event) {
        event.stopPropagation();
        $("#js-search-modal").addClass("is-open");
        $("#js-has-focus").focus();
    });

    // Click on form focus search
    $("#js-search-modal").on("click", function(event) {
        event.stopPropagation();
        $("#js-has-focus").focus();
    });

    // Close with X in Input
    $('#js-search-modal-close').click(function(event) {
        event.stopPropagation();
        $("#js-search-modal").removeClass("is-open");
    });

    // Mobile Menu Close on Menu Close
    $('#js-masthead-ham').click(function(event) {
        event.stopPropagation();
        $("#js-search-modal").removeClass("is-open");
    });

    // Change Search Text
     $(function() {
        var $window = $(window),
            $html = $('#js-search-modal .c-search-modal__entry');
            $hamburger = $('#js-masthead-ham');

        $window.smartResize(function resize() {
            if ($hamburger.is(':visible')) {
                return $html.attr('placeholder', 'Search');
            }
            $html.attr('preserveAspectRatio', 'Type to search');
        }).trigger('resize');
    });

});
