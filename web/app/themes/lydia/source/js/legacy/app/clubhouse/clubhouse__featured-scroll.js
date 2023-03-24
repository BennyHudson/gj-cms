/**
* Clubhouse Featured Scroll
* ---------
* @component Clubhouse
* @version 1.0
*/
jQuery(document).ready(function($) {

    var $featured_post = $('.c-club-partner-featured');

    if(!$featured_post.length) {
        return;
    }

    // Peep Hole Movement - Featured Home Page
    $(window).bind("load resize scroll", function() {
        var y = $(document).scrollTop();
        var h = $featured_post.height();

        var opacity = 1;

        if (y <= 0) {
            opacity = 1;
        } else if (y > 0) {
            opacity = 1 - (y / h);
        } else {
            opacity = 1;
        }

        $featured_post.find('.c-club-partner-featured__feat-img').css('opacity', opacity);
    });

});