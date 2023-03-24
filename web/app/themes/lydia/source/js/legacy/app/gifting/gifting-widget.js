jQuery(document).ready(function ($) {
  var $widget = $(".gifting-widget");

  if (!$widget.length) {
    return;
  }

  // Initialise Slider
  $(".gifting-widget__slider").each(function () {
    var $this = $(this);
    var $count = $(".gifting-widget__count");
    $this.on("init reInit afterChange", function (event, slick, currentSlide, nextSlide) {
      var i = (currentSlide ? currentSlide : 0) + 1;
      $count.text(i);
    });
    $this.slick({
      cssEase: "ease-out",
      arrows: true,
      dots: false,
      slidesToShow: 1,
      slidesToScroll: 1,
      adaptiveHeight: true,
      prevArrow: $this.parent().find(".gifting-widget__prev"),
      nextArrow: $this.parent().find(".gifting-widget__next"),
    });
  });
});
