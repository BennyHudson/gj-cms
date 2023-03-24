<?php
/**
 * SendGrid
 * --------
 * @category Vendor
 * @version 1.0
 * @package Lydia
 */

namespace BMAS\Vendor;

defined('ABSPATH') || exit;

use SendGrid as SG;
use RuntimeException;

class SendGrid
{

    /**
     * Action hook used by the AJAX class.
     *
     * @var string
     */
    public const ACTION = 'sendgrid_subscribe';

    /**
     * Action argument used by the nonce validating the AJAX request.
     *
     * @var string
     */
    public const NONCE = 'sendgrid-subscribe';

    /**
     * SendGrid API Key
     *
     * @var string
     */
    private $api_key;

    /**
     * SendGrid List ID
     *
     * @var array
     */
    private $list_ids;

    /**
     * Submission Data
     *
     * @var array
     */
    private $user;

    /**
     * Setup API Client and Validate API Keys.
     */
    public function __construct(string $api_key, array $list_ids)
    {

        if ($this->validate_api_key($api_key)) {
            $this->sg = new SG($this->api_key);
            $this->list_ids = $list_ids;
        }
    }

    /**
     * Register the Mailchimp Ajax handler class
     * with all the appropriate WordPress hooks.
     */
    public static function register($api_key = '', $list_id = [])
    {

        if (empty($api_key)) {
            throw new RuntimeException("API Key Required");
            return;
        }

        $instance = new self($api_key, $list_id);

        add_action( 'wp_ajax_' . self::ACTION, [$instance, 'handle'] );
        add_action( 'wp_ajax_nopriv_' . self::ACTION, [$instance, 'handle'] );
    }

    /**
     * Validate the API Key
     * @param string $api_key
     * @return bool
     */
    public function validate_api_key($api_key) {

        if (strpos($api_key, 'SG') === false) {
            throw new RuntimeException("Invalid SednGrid API key supplied.");
            return false;
        } else {
            $this->api_key = $api_key;
            return true;
        }
    }

    /**
     * Handles the AJAX request.
     */
    public function handle()
    {
        // Make sure we are getting a valid AJAX request
        // check_ajax_referer(self::ACTION, self::NONCE) ?? wp_send_json([
        //     'status'    => 400,
        //     'body' => 'Failed to Validate'
        // ]);

        $this->user = [
            'email' => $_POST['email'],
            'first_name'  => $_POST['fname'],
            'last_name'   => $_POST['lname']
        ];

        $this->subscribe();

    }

    /**
     * Subscribe the user
     */
    public function subscribe() {

        $request_body = $this->get_request_body();

        if (!$request_body) {
            wp_send_json([
                'status' => '400',
                'body' => 'No request body'
            ]);
        }

        try {

            $response = $this->sg->client->marketing()->contacts()->put($request_body);

            wp_send_json([
                'status' => $response->statusCode(),
                'headers' => $response->headers(),
                'body' => $response->body()
            ]);

        } catch (RuntimeException $ex) {
            throw new RuntimeException($ex->getMessage());
        }

    }

    /**
     * Prepare the request body
     * @return array
     * @throws RuntimeException
     */

    public function get_request_body() {

        if (empty($this->user['email'])) {
            throw new RuntimeException("Email is required");
            return false;
        }

        $request_body = [
            'list_ids' => [
                '40eeee23-681b-49f0-9074-06fe86ce612c', // Newsletter
            ],
            'contacts' => [
                [
                    'email' => $this->user['email'],
                    'first_name' => $this->user['first_name'],
                    'last_name' => $this->user['last_name']
                ]
            ],
        ];

        return $request_body;
    }
}
