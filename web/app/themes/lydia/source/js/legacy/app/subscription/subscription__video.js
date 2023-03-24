/**
* Subscription Video
* ---------
* @component Subscription
* @version 1.0
*/
jQuery(document).ready(function($) {

    if(!$('#video-js--subscription').length) {
        return;
    }

    // Get the Player
    var $player = videojs('video-js--subscription'),
        $playerModal = $('.c-subscription-video__modal'),
        $playButton = $('#js-subscription-video--play');

    // Fire off actions when player is ready
    $player.ready(function() {

        // Fade in Player when loaded
        this.addClass('is-loaded');

        // Set volume to half
        this.volume(0);

        this.play();

    });

    $playButton.on('click', function() {
        $player.currentTime(0);
        $player.play();
        $player.muted(false);
        $player.playsinline(false);
        $player.volume(0.5);
        // playerDim()
        // $('.c-subscription-video').css('height', 'calc(100vh - 112px');
    });

    // Dim the Player
    function playerDim() {

        $playerModal.css('visibility', 'hidden');
        // $playerModal.css('animation-fill-mode', 'initial');

        $playerModal.animate({
            opacity: 0,
        }, 400 );

    }

    // UnDim the Player
    function playerUnDim() {

        if ( !$player.scrubbing() ) {

            $player.currentTime(0);

            // $playerModal.css('visibility', 'visible');
            // $playerModal.css('animation-fill-mode', 'forwards');
            // $('.c-subscription-video').css('height', 'calc(95vh - 112px');


            // $playerModal.animate({
            //     opacity: 1,
            // }, 400 );

        }
    }

    // Do Actions on Play / Pause
    // $player.on('play', playerDim);
    // $player.on('pause', playerUnDim);
    // $player.on('ended', playerUnDim);


});
