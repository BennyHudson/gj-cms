/**
* Video Playlist
* --------
* @package GJ
* @since GJ 3.0
*/

jQuery(document).ready(function ($) {

    setHeight($('#js-video-playlist'), $('#js-featured-video'));

    $(window).smartResize(function() {
        setHeight($('#js-video-playlist'), $('#js-featured-video'));
    });

    function setHeight(playlist, video) {
        var height = video.height();
        var $hamburger = $('#js-masthead-ham');

        if ($hamburger.is(':visible')) {
            playlist.css('height', 'auto');
        } else {
            playlist.css('height', height);
        }
    }

});
