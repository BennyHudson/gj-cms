<?php
/**
 * Contact Us
 * --------
 * @category Forms
 * @version 1.0
 * @package Lydia
 */

namespace BMAS\Forms;

defined('ABSPATH') || exit;

use \WP_Mail as Mail;

class ContactUs
{

    /**
     * Action hook used by the AJAX class.
     *
     * @var string
     */
    protected const ACTION = 'form_contact';

    /**
     * Action argument used by the nonce validating the AJAX request.
     *
     * @var string
     */
    protected const NONCE = 'form-contact';

    /**
     * Contact email
     *
     * @var string
     */
    private $contact_email;

    public function __construct()
    {
        // $this->contact_email = 'info@thegentlemansjournal.com';
        $this->contact_email = 'quentin@bmas.agency';
    }

    /**
     * Register the AJAX handler class with all the appropriate WordPress hooks.
     */
    public static function register()
    {
        $handler = new self();

        add_action( 'wp_ajax_' . self::ACTION, [$handler, 'send'] );
        add_action( 'wp_ajax_nopriv_' . self::ACTION, [$handler, 'send'] );
    }

    /**
     * Subscribe the user
     */
    public function send() {

        if ( ! DOING_AJAX || ! check_ajax_referer(self::ACTION, 'form-contact') ) {
            wp_send_json([
                'code'    => 400,
                'message' => 'Failed to Validate'
            ]);
            wp_die();
        }

        $values = $this->get_form_data();
        $email_send = $this->send_email($values);

        if ($email_send == true) {
            $this->success_send_message();
        } else {
            $this->error_send_message();
        }

    }

    public function send_email($message) {

        return Mail::init()
        ->to(''. $this->contact_email .'')
        ->from('' . $message['name'] . ' - <' . $message['email'] . '>')
        ->subject('[Contact Enquiry] - '. $message['name'] . '')
        ->template(get_template_directory() .'/email/contact-enquiry.php', [
            'site'  => get_bloginfo('name'),
            'time'  => date('Y-m-d H:i:s'),
            'name'  => $message['name'],
            'email' => $message['email'],
            'subject'  => $message['subject']
        ])
        ->send();

    }

    private function get_form_data() {
        return $_POST;
    }

    private function error_send_message() {

        wp_send_json([
            'code'    => 400,
            'message' => 'Fail'
        ]);

        wp_die();
    }

    private function success_send_message() {

        wp_send_json([
            'code'    => 200,
            'message' => 'Success'
        ]);

        wp_die();
    }
}
