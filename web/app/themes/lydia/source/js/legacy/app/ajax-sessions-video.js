jQuery(document).ready(function ($) {
    var $tease = $('.sessions-videos__tease');

    if (!$tease) {
        return;
    }

    var $container = $('.sessions-videos__featured');
    var $list = $('.sessions-videos__playlist');
    var canBeLoaded = true;

    // Do the Ajax
    $tease.on('click', function (event) {
        event.preventDefault();

        var $this = $(this);

        if (canBeLoaded === true) {
            canBeLoaded = false;
            $list.addClass('sessions-videos__playlist--loading');

            var data = {
                action: 'sessions_video',
                id: $this.attr('attribute-id')
            };

            $.ajax({
                type: 'POST',
                url: site.ajax.url,
                data: data,
                success: function (response) {

                    videojs.getAllPlayers().forEach(element => {
                        element.dispose();
                    });

                    $container.html(response);


                    if ($('#sessions-video').length) {
                        videojs('sessions-video').ready(function () {
                            var videoInfo = $('.sessions-featured__info');
                            videoInfo[0] && videoInfo.remove();
                            this.play();
                        });
                    }

                    canBeLoaded = true;
                    $list.removeClass('sessions-videos__playlist--loading');
                },
                error: function () {
                    canBeLoaded = true;
                    $list.removeClass('sessions-videos__playlist--loading');
                    console.log('error: ' + response);
                },
            });
        }
    });
});
