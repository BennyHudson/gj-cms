/**
*  Modal Newsletter Sign up
*  ------
*  Modal Newsletter popup, checks for local storage if previously dismissed during the session.
*  ------
*  @package Lydia
*  @since Lydia 2.0
*  @requires jQuery 1.11
*/

jQuery(document).ready(function($) {

    (function($,sr){
      var debounce = function (func, threshold, execAsap) {
          var timeout;
          return function debounced () {
              var obj = this, args = arguments;
              function delayed () {
                  if (!execAsap)
                      func.apply(obj, args);
                  timeout = null;
              }
              if (timeout)
                  clearTimeout(timeout);
              else if (execAsap)
                  func.apply(obj, args);
              timeout = setTimeout(delayed, threshold || 100);
          };
      };
      // smart resize
      $.fn[sr] = function(fn){  return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };

    })($,'smartResize');

});
