/**
 * Ajax Most Popular
 * --------
 * @package GJ
 * @since GJ 5.0
 */

jQuery(document).ready(function($) {

    var canBeLoaded = true,
        $postsBox = $('.c-widget-pop-post__posts');

    if (!$postsBox) {
        return;
    }

    // Do the Ajax
    $('.c-widget-pop-post__btn').on('click', function(event) {
        event.preventDefault();

        if (canBeLoaded === true) {

            $('.c-widget-pop-post__btn').removeClass('is-active');
            $(this).addClass('is-active');

            var data = {
                action: 'ajax_most_popular',
                period: $(this).attr('data-period')
            };

            $('.c-widget-pop-post__period').html(data.period);

            $.ajax({
                url: site.ajax.url,
                data: data,
                type: 'post',

                beforeSend: function(xhr) {
                    canBeLoaded = false;
                    $postsBox.html('<div id="js-post-loader" class="c-loader"></div>');

                },
                success: function(data) {

                    if ( $.trim(data) == 'no-posts' ) {
                        $('#js-post-loader').remove();
                        $postsBox.html('<p>Nothing popular found</p>');
                    } else {
                        $('#js-post-loader').remove();
                        $postsBox.html(data).show(1000);
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
