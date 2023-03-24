/**
 * Ajax Infinite Scroll Single Posts
 * --------
 * @package GJ
 * @since GJ 5.0
 */

jQuery(document).ready(function($) {

    var canBeLoaded = true,
        $loadMoreBtn = $('#js-latest-loadmore');

    if (!$loadMoreBtn) {
        return;
    }

    // Do the Ajax
    $loadMoreBtn.on('click', function(event) {
        event.preventDefault();

        if (canBeLoaded === true) {

            var data = {
                action: 'latest_loadmore',
                latestIDs : $loadMoreBtn.data('latest')
            };

            $.ajax({
                url: site.ajax.url,
                data: data,
                type: 'post',

                beforeSend: function(xhr) {
                    canBeLoaded = false;
                    $('.c-ajax-latest-posts').append('<div id="js-post-loader" class="c-loader"></div>');
                    $loadMoreBtn.css({'opacity':'0'});
                },
                success: function(data) {

                    if ( $.trim(data) == 'no-posts' ) {
                        $('#js-post-loader').remove();
                        $loadMoreBtn.remove();
                        $('.c-ajax-latest-posts').append('<p class="c-no-posts">Sorry, there are no more posts.</p>');
                    } else {
                        $('#js-post-loader').remove();
                        $loadMoreBtn.remove();
                        $('.c-ajax-latest-posts').append(data);
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
