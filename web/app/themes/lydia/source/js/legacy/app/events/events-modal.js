/**
 * Issue Gallery Slider
 * --------
 * @package GJ
 * @since GJ 3.0
 */

jQuery(document).ready(function ($) {
  var $eventsModal = $(".events-modal");

  if (!$eventsModal.length) {
    return;
  }

  // Initialise Slider
  $(".js-events-modal").on("click", function () {
    $(this).siblings(".events-modal").css("display", "flex").hide().fadeIn(300);
  });

  $(".events-modal__close").on("click", function () {
    $(this).parents(".events-modal").fadeOut(300);
  });
});
