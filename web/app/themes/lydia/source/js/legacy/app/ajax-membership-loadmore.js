/**
 * Ajax Infinite Scroll Single Posts
 * --------
 * @package GJ
 * @since GJ 5.0
 */

jQuery(document).ready(function($) {

    var canBeLoaded = true,
        $loadMoreBtn = $('#js-membership-loadmore'),
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
        console.log('click');
        event.preventDefault();

        if (canBeLoaded === true) {

            var data = {
                action: 'membership_loadmore',
                // members : $loadMoreBtn.data('members')
                page: $loadMoreBtn.attr('data-pagination')
            };

            $.ajax({
                url: site.ajax.url,
                data: data,
                type: 'post',

                beforeSend: function(xhr) {
                    canBeLoaded = false;
                    $('.c-ajax-members-posts').append('<div id="js-post-loader" class="c-loader"></div>');
                    $loadMoreBtn.css({'opacity':'0'});
                },
                success: function(data) {

                    if ( $.trim(data) == 'no-posts' ) {
                        $('#js-post-loader').remove();
                        $loadMoreBtn.remove();
                        $('.c-ajax-members-posts').append('<p class="c-no-posts">Sorry, there are no more posts.</p>');
                    } else {
                        $('#js-post-loader').remove();
                        //$loadMoreBtn.remove();
                        $loadMoreBtn.css({'opacity':'1'});
                        pageCount();
                        $('.c-ajax-members-posts').append(data);
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
