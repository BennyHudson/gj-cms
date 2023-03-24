/**
* Back to Top
* --------
* @package GJ
* @since GJ 3.0
*/

jQuery(document).ready(function ($) {

  //Back to top link
  $('#subscription-scroll').click(function () {
      $('html, body').animate({scrollTop: $(".subscription-perks").offset().top}, 'fast');
      return false;
  });

});
