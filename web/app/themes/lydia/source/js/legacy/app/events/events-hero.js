/**
 * Issue Gallery Slider
 * --------
 * @package GJ
 * @since GJ 3.0
 */

jQuery(document).ready(function ($) {
  var $eventsHero = $(".events-hero");

  if (!$eventsHero.length) {
    return;
  }

  // Resize Hero
  function heroPadding() {
    var $hero = $(".events-hero__slide");
    var $menu = $(".o-masthead");
    var viewPadding = $menu.outerHeight();

    $hero.css("min-height", "calc( 100vh - " + viewPadding + "px)");
  }

  $(window).on("load", function () {
    heroPadding();
  });

  $(window)
    .smartResize(function resize() {
      heroPadding();
    })
    .trigger("resize");

  // Initialise Slider
  $(".events-hero__slider").slick({
    cssEase: "ease-out",
    arrows: true,
    fade: true,
    slidesToShow: 1,
    autoplay: false,
    autoplaySpeed: 4000,
    prevArrow: $(".events-hero__prev"),
    nextArrow: $(".events-hero__next"),
  });

  // It's the final count down: 🎺🎹🥁
  function pad(n) {
    return n < 10 ? "0" + n : n;
  }

  function setDate() {
    var eventDate = new Date($(".events-hero__countdown").attr("date-attr")).getTime();
    var currentDate = new Date().getTime();
    var difference = eventDate - currentDate;

    var days = pad(Math.floor(difference / (1000 * 60 * 60 * 24)));
    var hours = pad(Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)));
    var minutes = pad(Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60)));
    var seconds = pad(Math.floor((difference % (1000 * 60)) / 1000));

    var $days = $(".events-hero__digit--days");
    var $hours = $(".events-hero__digit--hours");
    var $minutes = $(".events-hero__digit--minutes");
    var $seconds = $(".events-hero__digit--seconds");

    $days.text(days);
    $hours.text(hours);
    $minutes.text(minutes);
    $seconds.text(seconds);
  }

  setDate();

  window.setInterval(function () {
    setDate();
  }, 1000);
});
