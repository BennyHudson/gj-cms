/**
* Logo SVG Alignment
* --------
* @package GJ
* @since GJ 3.0
*/

jQuery(document).ready(function ($) {

     $(function() {
        var $window = $(window),
            $html = $('#js-masthead-prime .o-logo--symbol');
            $hamburger = $('#js-masthead-ham');

        $window.smartResize(function resize() {
            if ($hamburger.is(':visible')) {
                return $html.attr('preserveAspectRatio', 'xMidYMid meet');
            }
            $html.attr('preserveAspectRatio', 'xMinYMid meet');
        }).trigger('resize');
    });

});
