<?php

function sendinvoice($orderid)
{
    $email = new WC_Email_Customer_Invoice();
    $email->trigger($orderid);
}

add_action('woocommerce_order_status_pending_to_processing_notification','sendinvoice');
