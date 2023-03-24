(function($) {
    'use strict';
    $(document).ready(function() {
        if (!document.getElementsByClassName('woocommerce-order-received')[0]) {
            return;
        }

        //Inject homepage link
        $('<a class="checkout-confirmation-homepage-link" href="https://www.thegentlemansjournal.com/">Return to the gentleman\'s journal</a>').prependTo('.woocommerce');

        //Wrap all divs but order details
        $('.woocommerce-order p, .woocommerce-order ul').wrapAll("<div class='woocommerce-confirmation-container-custom' />");

        //Append UL to bottom of div
        $('.woocommerce-order ul').appendTo('.woocommerce-confirmation-container-custom');

    });
}(jQuery));
