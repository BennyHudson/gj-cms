/**
 * Ajax Infinite Scroll Single Posts
 * --------
 * @package GJ
 * @since GJ 5.0
 */

jQuery(document).ready(function($) {

    var canBeLoaded = true,
        $loadMoreBtn = $('#js-podcast-loadmore'),
        pageNum = 2;

    if (!$loadMoreBtn) {
        return;
    }

    // Update the Pagination Counter
    function pageCount() {
        pageNum++;
        $loadMoreBtn.attr('data-pagination', pageNum);
    }

    // Do the Ajax
    $loadMoreBtn.on('click', function(event) {
        event.preventDefault();

        if (canBeLoaded === true) {

            var data = {
                action: 'podcast_loadmore',
                page: $loadMoreBtn.attr('data-pagination')
            };

            $.ajax({
                url: site.ajax.url,
                data: data,
                type: 'post',

                beforeSend: function(xhr) {
                    canBeLoaded = false;
                    $('.c-ajax-podcast-posts').append('<div id="js-post-loader" class="c-loader c-loader--light"></div>');
                    $loadMoreBtn.css({'opacity':'0'});
                },
                success: function(data) {

                    if ( $.trim(data) == 'no-posts' ) {
                        $('#js-post-loader').remove();
                        $loadMoreBtn.remove();
                    } else {
                        $('#js-post-loader').remove();
                        $('.c-ajax-podcast-posts').append(data);
                        pageCount();
                        $loadMoreBtn.css({'opacity':'1'});

                        $('.c-podcast-card--archive').on("mouseover", function () {
                            var $this = $(this);

                            $this.addClass('is-selected').removeClass('not-selected');
                            $this.siblings().removeClass('is-selected').addClass('not-selected');

                        });

                        $('.c-podcast-archive').on("mouseleave", function () {

                            $('.c-podcast-card--archive').removeClass('is-selected not-selected');

                        });
                    }

                },
                complete: function() {
                    canBeLoaded = true;
                },
                error: function(data) {
                    console.log('There was problem loading the posts');
                }
            });
        }
    });
});
