jQuery(document).ready(function ($) {
  $editorialLink = $(".js-editorial-link");
  $preview = $(".subnav-editorial__article");

  $editorialLink.hover(function () {
    nameAttr = $(this).attr("name-attr");
    $preview.hide();
    $preview.each(function () {
      $(this).attr("categories-attr") === nameAttr && $(this).show();
    });
  });
});
