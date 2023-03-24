/**
 * Ajax Infinite Scroll Single Posts
 * --------
 * @package GJ
 * @since GJ 5.0
 */

jQuery(document).ready(function($) {

    var canBeLoaded = true,
        $loadMoreBtn = $('#js-archive-loadmore'),
        pageNum = site.archive.current_page + 1;
        urlNum = site.archive.current_page;
        windowURL = window.location.protocol + "//" + window.location.host + window.location.pathname;

    if (!$loadMoreBtn) {
        return;
    }

    // Update the Pagination Counter
    function pageCount() {
        pageNum++;
        urlNum++;
        $loadMoreBtn.attr('data-pagination', pageNum);
    }

    // Do the Ajax
    $loadMoreBtn.on('click', function(event) {
        event.preventDefault();

        if (canBeLoaded === true) {

            var data = {
                action: 'archive_loadmore',
                termID: site.termID,
                search: $loadMoreBtn.attr('data-search'),
                page: pageNum
            };

            $.ajax({
                url: site.ajax.url,
                data: data,
                type: 'post',

                beforeSend: function(xhr) {
                    canBeLoaded = false;
                    $('.c-ajax-archive-posts').append('<div id="js-post-loader" class="c-loader"></div>');
                    $loadMoreBtn.css({'opacity':'0'});
                },
                success: function(data) {

                    if ( $.trim(data) == 'no-posts' ) {
                        $('#js-post-loader').remove();
                        $loadMoreBtn.remove();
                        $('.c-ajax-archive-posts').append('<p class="c-no-posts">Sorry, there are no more posts.</p>');
                    } else {
                        $('#js-post-loader').remove();
                        $('.o-post-feed--archive').append(data);
                        pageCount();
                        $loadMoreBtn.css({'opacity':'1'});

                        var index = window.location.href.indexOf("page/");

                        if (index > 0) {
                            windowURL = windowURL.substr(0, index);
                        }

                        var refresh = windowURL + 'page/' + urlNum;
                        window.history.pushState(null, null, refresh);

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
