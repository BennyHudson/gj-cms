/**
* Podcast Featured Slider
* ---------
* @component Podcast
* @version 1.0
*/

jQuery(document).ready(function($) {

    var $podcastArchive = $('.c-podcast-archive');
    var $podcastArchiveInner = $('.c-podcast-archive__inner');
    var $podcastCard = $('.c-podcast-card--archive');

    if(!$podcastArchive.length) {
        return;
    }

    function selectPodcastHighlight(el) {
        $(el).on("mouseover", function () {
            var $this = $(this);

            $this.addClass('is-selected').removeClass('not-selected');
            $this.siblings().removeClass('is-selected').addClass('not-selected');

        });
    }

    function clearSelectPodcastHighlight(el) {
        $(el).on("mouseleave", function () {

            $podcastCard.removeClass('is-selected not-selected');

        });
    }

    selectPodcastHighlight($podcastCard);
    clearSelectPodcastHighlight($podcastArchiveInner);
});
