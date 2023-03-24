<?php

// Orders Export Remove Headers
// Remove a column
// function lydia_wc_csv_export_remove_column( $column_headers ) {
//
//     // the list of column keys can be found in class-wc-customer-order-csv-export-generator.php
//     unset( $column_headers['billing_email'] );
//     unset( $column_headers['cart_discount'] );
//     unset( $column_headers['coupon_items'] );
//     unset( $column_headers['discount_total'] );
//     unset( $column_headers['download_permissions'] );
//     unset( $column_headers['fee_items'] );
//     unset( $column_headers['fee_tax_total'] );
//     unset( $column_headers['fee_total'] );
//     unset( $column_headers['item_meta'] );
//     unset( $column_headers['item_refunded'] );
//     unset( $column_headers['item_sku'] );
//     unset( $column_headers['item_tax'] );
//     unset( $column_headers['item_total'] );
//     unset( $column_headers['order_currency'] );
//     unset( $column_headers['order_discount'] );
//     //unset( $column_headers['order_notes'] );
//     unset( $column_headers['payment_method'] );
//     unset( $column_headers['refunded_total'] );
//     unset( $column_headers['shipping_items'] );
//     unset( $column_headers['shipping_method'] );
//     unset( $column_headers['shipping_tax_total'] );
//     unset( $column_headers['status'] );
//     unset( $column_headers['tax_items'] );
//     unset( $column_headers['tax_total'] );
//     unset( $column_headers['order_number'] );
//
//     return $column_headers;
// }
// add_filter( 'wc_customer_order_csv_export_order_headers', 'lydia_wc_csv_export_remove_column' );
//
function wc_complete_order_after_export( $order ) {
    if ($order->is_paid()) {
		$order->update_status('completed', 'Order exported to CSV.' );
	}
}
add_action( 'wc_customer_order_csv_export_order_exported', 'wc_complete_order_after_export', 10, 1 );

// Remove recursive payments from export plugin
function tgj_csv_export_modify_row_data($order_data, $item, $order, $csv_generator) {

    if($order && count($order->order_custom_fields) > 0 && array_key_exists('_subscription_renewal',
$order->order_custom_fields) && count($order->order_custom_fields['_subscription_renewal']) > 0) {
        $subscriptions = wcs_get_subscriptions_for_order($order->id, ['order_type' => ['parent', 'renewal']]);

        foreach($subscriptions as $current_subscription) {

            if($current_subscription->post->post_parent != 0) {
                $order_data = [];
            }

        }

    }

    return $order_data;
}

add_filter('wc_customer_order_csv_export_order_row_one_row_per_item', 'tgj_csv_export_modify_row_data', 10, 4);
