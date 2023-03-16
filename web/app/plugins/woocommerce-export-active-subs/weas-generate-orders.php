<?php
// Temp plugin
// https://www.thegentlemansjournal.com/wp-admin/admin.php?page=weas-admin&generate_csv_order

	$orders = $this->getOrders();

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=orders-'. date('d-m-Y') .'.csv');

	$output = fopen('php://output', 'w');

	$cols = [
        'order_id',
        'order_date',
        'status',
        'shipping_first_name',
        'shipping_last_name',
        'shipping_address_1',
        'shipping_address_2',
        'shipping_postcode',
        'shipping_city',
        'shipping_state',
        'shipping_country',
        'shipping_company',
        'customer_note',
        'item_name',
        'item_quantity',
        'order_number',
        'billing_email'
    ];

	fputcsv($output, $cols);

	foreach ($orders as $order) {

        $woo_order = new WC_Order($order->ID);

	    if(
            $woo_order->date_created->date('Ymd') >= '20170530'
            && $woo_order->date_created->date('Ymd') <= '20170612'
        )
	    {
	        $items = $woo_order->get_items();

	        foreach ($items as $item_id => $item) {

                $row = [
                    $woo_order->ID,
                    $woo_order->date_created->date('d-m-Y'),
                    $woo_order->status,
                    str_replace(';', ' ', $woo_order->data['shipping']['first_name']),
                    str_replace(';', ' ', $woo_order->data['shipping']['last_name']),
                    str_replace(';', ' ', $woo_order->data['shipping']['address_1']),
                    str_replace(';', ' ', $woo_order->data['shipping']['address_2']),
                    str_replace(';', ' ', $woo_order->data['shipping']['postcode']),
                    str_replace(';', ' ', $woo_order->data['shipping']['city']),
                    str_replace(';', ' ', $woo_order->data['shipping']['state']),
                    str_replace(';', ' ', $woo_order->data['shipping']['country']),
                    str_replace(';', ' ', $woo_order->data['shipping']['company']),
                    str_replace(';', ' ',$woo_order->data['customer_note']),
                    $item['name'],
                    $woo_order->get_item_meta($item_id, '_qty', true),
                    $woo_order->ID,
                    $woo_order->data['billing']['email']
                ];

                fputcsv($output, $row);

            }
        }

	}

	fclose($output);
	exit();
