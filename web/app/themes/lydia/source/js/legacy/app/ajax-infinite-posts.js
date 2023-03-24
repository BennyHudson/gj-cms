/**
* Ajax Infinite Scroll Single Posts
* --------
* @package GJ
* @since GJ 5.0
*/

jQuery(document).ready(function($) {

    var $postAjax = $('.c-infinite-posts');
    var $houseNote = $('.c-post--house-note')

    if(!$postAjax.length || $houseNote.length) {
        return;
    }

    var postIdArray = [];
    var catIdArray = [];
    var canBeLoaded = true;
    var bottomOffset = 2000;
    var categoryID;

    function updateIDArrays() {
        var $singlePost = $('.c-post');
        var totalPosts = $singlePost.length;

        $singlePost.each(function(index) {
            if (index === totalPosts - 1) {
                postIdArray.push($(this).attr('id'));
                catIdArray.push($(this).attr('data-cat'));
            }
        });
        categoryID = catIdArray.slice(-1)[0];
    }

    updateIDArrays();

    var updateURL = function() {

        var $singlePost = $('.c-post');
        var currentURL = window.location.href;
        var viewportHeight = $(window).height();
        var viewportHalfed = viewportHeight / 2;

        $singlePost.each(function() {
            $(this).isOnScreen(function(deltas) {
                var thisURL = $(this).attr('data-single-url');
                var thisPath = $(this).attr('data-ga-path');
                var thisTitle = $(this).attr('data-title');
                if ((deltas.top >= viewportHalfed && deltas.bottom >= viewportHalfed) && (currentURL !== thisURL)) {

                    // Change URL
                    window.history.replaceState("data", thisTitle, thisURL);
                    document.title = thisTitle;

                    if (typeof __gaTracker == 'function') {
                        // Send Google Analytics
                        __gaTracker('send', {
                          hitType: 'pageview',
                          page: thisPath
                        });
                    }
                }
            });
        });
    };

    $(window).scroll(function() {

        var data = {
            action: 'infinite_posts',
            postIdArray: postIdArray,
            categoryID: categoryID
        };

        if ($(document).scrollTop() > ($(document).height() - bottomOffset) && canBeLoaded == true) {

            $.ajax({
                url: site.ajax.url,
                data: data,
                type: 'post',

                beforeSend: function(xhr) {
                    canBeLoaded = false;
                    $('.c-infinite-posts').append('<div id="js-post-loader" class="c-loader"></div>');
                },
                success: function(data) {
                    $('#js-post-loader').remove();
                    $('.c-infinite-posts').append(data);
                    canBeLoaded = true;
                    updateIDArrays();
                },
                error: function(data) {
                    console.log('There was problem loading the posts');
                }
            });
        }
        updateURL();
    });
});
