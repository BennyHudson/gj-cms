/**
 * Ajax Infinite Scroll Single Posts
 * --------
 * @package GJ
 * @since GJ 5.0
 */

jQuery(document).ready(function($) {

    var $podcastArchive = $('.c-podcast-archive'),
        $podcastFeed = $('.c-podcast-archive__inner'),
        $podcastFeedOriginal = $('.c-podcast-archive__inner').children(),
        $archiveSort = $('.c-podcast-archive-filter__sort');

    if (!$podcastArchive) {
        return;
    }

    function sortPodcastsPopular(feed) {
        feed.find('.c-podcast-card--archive').sort(function (a, b) {
            return $(b).attr('data-play') - $(a).attr('data-play');
        }).appendTo(feed);
    }

    $archiveSort.on('change', function() {
        if (this.value == 'popular') {
            sortPodcastsPopular($podcastFeed);
        } else if (this.value == 'latest') {
            $podcastFeed.html($podcastFeedOriginal);
            $('.c-podcast-archive__loadmore').attr('data-pagination', '2');
        }

        $('.c-podcast-card--archive').on("mouseover", function () {
            var $this = $(this);

            $this.addClass('is-selected').removeClass('not-selected');
            $this.siblings().removeClass('is-selected').addClass('not-selected');

        });

        $('.c-podcast-archive').on("mouseleave", function () {

            $('.c-podcast-card--archive').removeClass('is-selected not-selected');

        });
    });

});
