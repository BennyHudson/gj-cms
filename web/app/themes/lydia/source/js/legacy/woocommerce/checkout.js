(function($) {
    'use strict';
    $(document).ready(function() {
        if ((!document.getElementsByClassName('woocommerce-checkout')[0]) || (document.getElementsByClassName('woocommerce-order-received')[0])) {
            return;
        }

        //Hide coupon and form toggle
        $('.showcoupon').parent('.woocommerce-info').css('display', 'none');

        //Move Coupons
        $('.checkout_coupon').insertAfter('.woocommerce-checkout-review-order-table');

        //Change Apply Coupon wording
        $('input[name="apply_coupon"]').val('Apply');

        //Move Order Title
        $('#order_review_heading').prependTo('#order_review');

        //Wrap billing divs
        $('#customer_details .col-1, #customer_details .col-2').wrapAll("<div class='woocommerce-billing-details-custom' />");

        //Wrap payment and order review
        // $('#order_review, #payment').wrapAll("<div class='woocommerce-col-2-custom' />");

        //Add Payment Title
        $('<h3 class="custom-single-tag">Payment</h3>').insertBefore('#payment');

        if (!document.getElementsByClassName('woocommerce-form-login')[0]) {
            return;
        }

        //Move Login form
        $('.woocommerce-form-login').prependTo('#customer_details');

        //Insert Sign In title
        $('.woocommerce-form-login').prepend('<h3>Sign In</h3>');

        //Wrap signin form P tags
        $('.woocommerce-form-login p').wrapAll("<div class='sign-in-custom' />");

        //Move Show Loging tag
        $('.showlogin').parent('.woocommerce-info').insertAfter('.page-title');

        //Move Remember me checkbox
        $('.woocommerce-form-login .woocommerce-form__label-for-checkbox').insertBefore('.woocommerce-form-login .button');

    });
}(jQuery));
