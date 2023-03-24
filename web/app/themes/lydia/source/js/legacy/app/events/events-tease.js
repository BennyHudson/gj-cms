/**
 * Issue Gallery Slider
 * --------
 * @package GJ
 * @since GJ 3.0
 */

jQuery(document).ready(function ($) {

  var $eventsTease = $(".events-tease");

  if (!$eventsTease.length) {
    return;
  }

  // Initialise Slider
  $(".events-tease__slider").each(function () {
    $(this).slick({
      cssEase: "ease-out",
      arrows: true,
      fade: true,
      slidesToShow: 1,
      prevArrow: $(this).parent().find(".events-tease__prev"),
      nextArrow: $(this).parent().find(".events-tease__next"),
    });
  });
});
