jQuery(document).ready(function ($) {
  var $featured = $(".gifting-featured");

  if (!$featured.length) {
    return;
  }

  // Initialise Slider
  $(".gifting-featured__slider").each(function () {
    $(this).slick({
      cssEase: "ease-out",
      arrows: true,
      slidesToShow: 4,
      slidesToScroll: 1,
      prevArrow: $(this).parent().find(".gifting-featured__prev"),
      nextArrow: $(this).parent().find(".gifting-featured__next"),
      responsive: [
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
          },
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            centerMode: true
          },
        },
      ],
    });
  });
});
