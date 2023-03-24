/**
 * Pause Other Videoes when you play another
 * --------
 * @package GJ
 * @since GJ 3.0
 */

(function ($, document) {
  "use strict";

  $(document).ready(function () {
    var $videoJS = $(".video-js");
    // Do not run the code if video JS is not present
    if (!$($videoJS)[0]) {
      return;
    }
    var videoInfo = $(".sessions-featured__info");
    //Pause all other videos on single video play
    $videoJS.each(function (videoIndex) {
      var videoId = $(this).attr("id");

      videojs(videoId).ready(function () {
        this.on("play", function (e) {

          videoInfo[0] && videoInfo.remove();

          $(".video-js").each(function (index) {
            if (videoIndex !== index) {
              this.player.pause();
            }
          });
        });
      });
    });
  });
})(jQuery, document);
