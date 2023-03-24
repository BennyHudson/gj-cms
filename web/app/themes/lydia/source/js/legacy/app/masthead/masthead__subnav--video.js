jQuery(document).ready(function ($) {
  $videoLink = $(".js-video-link");
  $thumbnail = $(".subnav-video__thumbnail");

  $videoLink.hover(function () {
    nameAttr = $(this).attr("name-attr");
    $thumbnail.hide();
    $thumbnail.each(function () {
      $(this).attr("categories-attr") === nameAttr && $(this).show();
    });
  });
});
