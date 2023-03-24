jQuery(document).ready(function ($) {
  $sessionsLink = $(".js-sessions-link");
  $overlayImage = $(".subnav-sessions__thumbnail");

  $sessionsLink.hover(function () {
    nameAttr = $(this).attr("name-attr");
    $overlayImage.hide();
    $overlayImage.each(function () {
      $(this).attr("categories-attr") === nameAttr && $(this).show();
    });
  });
});
