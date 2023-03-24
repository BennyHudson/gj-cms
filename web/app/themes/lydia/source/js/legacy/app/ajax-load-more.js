(function ($, document) {
  "use strict";

  $(document).ready(function () {
    var $loadMoreButton = $(".load-more");

    if (!$loadMoreButton[0]) {
      return;
    }

    var $archiveContent = $(".ajax__container");
    var $archivePostTease = $(".ajax__tease");
    var canBeLoaded = true;
    var buttonOffset = parseInt($loadMoreButton.attr("data-offset"));

    $archivePostTease.removeClass("ajax__tease--ajaxed");

    $loadMoreButton.on("click", function () {
      var data = {
        action: "ajax_load_more",
        offset: $(".ajax__tease").length + buttonOffset,
        postType: $loadMoreButton.attr("data-post-type"),
        template: $loadMoreButton.attr("data-template"),
        taxonomy: $loadMoreButton.attr("data-taxonomy"),
        category: $loadMoreButton.attr("data-category"),
        postsPerPage: $loadMoreButton.attr("data-posts-per-page"),
      };

      if (canBeLoaded === true) {
        canBeLoaded = false;

        $.ajax({
          type: "POST",
          url: site.ajax.url,
          data: data,
          dataType: "JSON",
          beforeSend: function (xhr) {
            $loadMoreButton.addClass("o-btn--disabled");
          },
          success: function (response) {
            $archiveContent.append(response.template);

            $(".ajax__tease--ajaxed").hide().fadeIn(500);
            $("html, body").animate(
              {
                scrollTop: $(".ajax__tease--ajaxed").first().offset().top - 150,
              },
              500
            );

            $(".ajax__tease--ajaxed").removeClass("ajax__tease--ajaxed");
            canBeLoaded = true;
            $loadMoreButton.removeClass("o-btn--disabled");
          },
          complete: function (response) {
            data.offset = $(".ajax__tease").length;

            if (data.offset + buttonOffset >= parseInt(response.responseJSON.postCount)) {
              $loadMoreButton.fadeOut(300);
            }
          },
          error: function (response) {
            $loadMoreButton.text("Error!");
            canBeLoaded = true;
          },
        });
      }
    });
  });
})(jQuery, document);
