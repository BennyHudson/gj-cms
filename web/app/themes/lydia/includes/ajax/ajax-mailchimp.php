<?php
/**
 *  Ajax Mailchimp
 *  ------
 *  @package GJ
 *  @since GJ 5.0
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function gj_mailchimp_signup()
{
    $apiKey = '43bc0bf88e9c7857228c874d9294476d-us17';
    $listId = '6ef4231d1f';

    $memberId   = md5( strtolower( $_POST['email'] ) );
    $dataCenter = substr( $apiKey, strpos( $apiKey, '-' ) + 1 );
    $url        = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listId . '/members/' . $memberId;

    $json = json_encode( [
        'email_address'         => $_POST['email'],
        'status'                => 'subscribed',
        'merge_fields'  => [
            'FNAME'  => $_POST['fname'],
            'LNAME'  => $_POST['lname']
        ],
        'marketing_permissions' => [
            0 => [
                'marketing_permission_id' => '4a90bb6493',
                'enabled'                 => true
            ]
        ]
    ] );

    $ch = curl_init( $url );

    curl_setopt( $ch, CURLOPT_USERPWD, 'user:' . $apiKey );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json'] );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_TIMEOUT, 10 );
    curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'PUT' );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $json );

    $result   = curl_exec( $ch );
    $httpCode = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
    curl_close( $ch );

    return true;
}

add_action( 'wp_ajax_gj_mailchimp_signup', 'gj_mailchimp_signup' );
add_action( 'wp_ajax_nopriv_gj_mailchimp_signup', 'gj_mailchimp_signup' );
