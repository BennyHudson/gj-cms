<?php

//get the subscriptions
$subs = $this->getSubs();

//Force the browser to initialise a download of a CSV file
//Adds date to file name
header( 'Content-Type: text/csv; charset=utf-8' );
header( 'Content-Disposition: attachment; filename=subscriptions-' . date( 'd-m-Y' ) . '.csv' );

$output = fopen( 'php://output', 'w' );

//Populate the column headers
$cols = [
    'OrderNumber',
    'CompanyName',
    'Address1',
    'Address2',
    'PostCode',
    'Town',
    'Country',
    'Customer',
    'First Name',
    'Last Name',
    'Telephone',
    'Email',
    'Shipping Zone',
    'Product1',
    'Quantity1'
];

fputcsv( $output, $cols );

//Populate each row from each subscription
foreach ( $subs as $sub ) {
    if ( $sub->ID ) {
        $subObj = new WC_Subscription( $sub->ID );

        $shipping_country   = $subObj->shipping_country;
        $european_countries = [ 'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GB', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PL', 'PT', 'RO', 'SE', 'SI', 'SK' ];

        if ( $shipping_country == 'GB' ) {
            $shipping_zone = 'UK';
        } elseif ( in_array( $shipping_country, $european_countries ) ) {
            $shipping_zone = 'EU';
        } elseif ( $shipping_country == 'US' ) {
            $shipping_zone = 'US';
        } else {
            $shipping_zone = 'ROW';
        }

        $row = [
            'GJ' . $sub->ID,
            str_replace( ';', ' ', $subObj->shipping_company ),                                                               // Company
            str_replace( ';', ' ', $subObj->shipping_address_1 ),                                                             // Address 1
            str_replace( ';', ' ', $subObj->shipping_address_2 ),                                                             // Address 2
            str_replace( ';', ' ', $subObj->shipping_postcode ),                                                              // PostCode
            str_replace( ';', ' ', $subObj->shipping_city ),                                                                  // Town
            WC()->countries->countries[$subObj->shipping_country],                                                          // Country
            str_replace( ';', ' ', $subObj->shipping_first_name ) . ' ' . str_replace( ';', ' ', $subObj->shipping_last_name ), // Name
            str_replace( ';', ' ', $subObj->shipping_first_name ), // FName
            str_replace( ';', ' ', $subObj->shipping_last_name ), // LName
            str_replace( ';', ' ', $subObj->billing_phone ),                                                                  // Phone
            str_replace( ';', ' ', $subObj->billing_email ),                                                                  // Email
            $shipping_zone,                                                                                                 // Zone
            'gj-issue-37',                                                                                                  // Product
            $sub->product['qty']                                                                                           // Quantity
        ];

    }

    fputcsv( $output, $row );
}

fclose( $output );
exit();
