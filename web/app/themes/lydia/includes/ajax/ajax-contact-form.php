<?php
/**
 * Contact Form
 * --------
 * @category Ajax
 * @version 1.0
 * @package Lydia
 */
defined( 'ABSPATH' ) || exit;

function contact_enquire_form()
{

    // Get the Data from the Form
    $response = $_POST['values'];

    $message = [];

    // Create a useable Array of the Data
    foreach ( $response as $field ) {
        foreach ( $field as $key => $item ) {
            if ( $key == 'name' ) {
                $messageKey = $item;
            } elseif ( $key == 'value' ) {
                $messageValue = $item;
            }
            $message[$messageKey] = $messageValue;
        }
    }

    $contactEmail = get_field( 'contact_information', 'lydia_config' );

    // Create and Send the Enquiry Email
    $email = WP_Mail::init()
        ->to( '' . $contactEmail['email'] . '' )
        ->from( '' . $message['name'] . ' - <' . $message['email'] . '>' )
        ->subject( '[Contact Enquiry] - ' . $message['name'] . '' )
        ->template( get_template_directory() . '/views/emails/contact-form-enquiry.php', [
            'time'    => date( 'Y-m-d H:i:s' ),
            'name'    => $message['name'],
            'email'   => $message['email'],
            'message' => $message['message']
        ] )
        ->send();

    wp_die();
}

add_action( 'wp_ajax_contact_enquire_form', 'contact_enquire_form' );
add_action( 'wp_ajax_nopriv_contact_enquire_form', 'contact_enquire_form' );
