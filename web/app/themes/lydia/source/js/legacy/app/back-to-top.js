/**
* Back to Top
* --------
* @package GJ
* @since GJ 3.0
*/

jQuery(document).ready(function ($) {

    //Back to top link
    $('#c-back-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 'fast');
        return false;
    });

});
