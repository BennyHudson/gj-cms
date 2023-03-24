<?php
/**
 * Mailchimp
 * --------
 * @category Ajax
 * @version 1.0
 * @package Lydia
 */

namespace BMAS\Vendor;

defined('ABSPATH') || exit;

use \DrewM\MailChimp\MailChimp as ChimpCaller;

class MailChimp
{

    /**
     * Action hook used by the AJAX class.
     *
     * @var string
     */
    protected const ACTION = 'mailchimp_subscribe';

    /**
     * Action argument used by the nonce validating the AJAX request.
     *
     * @var string
     */
    protected const NONCE = 'mailchimp-subscribe';

    /**
     * Mailchimp API Key
     *
     * @var string
     */
    private $key;

    /**
     * Mailchimp List ID
     *
     * @var string
     */
    private $list_ID;

    /**
     * Mailchimp API Wrapper
     *
     * @var object
     */
    public $ChimpAPI;

    /**
     * Mailchimp Members List URL
     *
     * @var string
     */
    private $members_url;

    /**
     * Submission Data
     *
     * @var array
     */
    private $user;

    public function __construct()
    {
        $this->key = '43bc0bf88e9c7857228c874d9294476d-us17';
        $this->list_ID = '6ef4231d1f';
        $this->ChimpAPI = new ChimpCaller($this->key);
        $this->members_url = sprintf('lists/%s/members', $this->list_ID);
    }

    /**
     * Register the AJAX handler class with all the appropriate WordPress hooks.
     */
    public static function register()
    {
        $handler = new self();

        add_action( 'wp_ajax_' . self::ACTION, [$handler, 'subscribe'] );
        add_action( 'wp_ajax_nopriv_' . self::ACTION, [$handler, 'subscribe'] );
    }

    /**
     * Subscribe the user
     */
    public function subscribe() {

        if ( ! DOING_AJAX || ! check_ajax_referer(self::ACTION, 'mailchimp-subscribe') ) {
            wp_send_json([
                'code'    => 400,
                'message' => 'Failed to Validate'
            ]);
            wp_die();
        }

        $this->user['email'] = $_POST['email'];
        $this->user['hash'] = $this->is_subscribed_and_get_hash($this->user['email']);

        // If the User Exists Lets update them else lets subscribe them
        if($this->ChimpAPI->success()) {
            $updated_user = $this->update_exisitng_user($this->user['hash']);
            $this->add_user_tags($updated_user);
            $this->update_marketing_permissions($updated_user);
            $this->success_send_message();
        } else {
            $this->subscribe_new_user($_POST);
            $this->success_send_message();
        }
    }

    /**
     * Check for the User and return their Mailchimp Hash ID
     */
    private function is_subscribed_and_get_hash($email) {

        $hash = $this->ChimpAPI->subscriberHash($email);
        $this->ChimpAPI->get(sprintf('%s/%s', $this->members_url, $hash));

        return ($this->ChimpAPI->success()) ? $hash : false;
    }

    /**
     * Update the User if they already exist
     */
    private function update_exisitng_user($user) {

        return $this->ChimpAPI->patch(sprintf('%s/%s', $this->members_url, $user), [
            'status' => 'subscribed',
        ]);
    }

    private function subscribe_new_user($user) {

        $new_user = $this->ChimpAPI->post("lists/" . $this->list_ID . "/members", [
            'email_address' => $user['email'],
            'status'        => 'subscribed',
            'merge_fields'  => [
                'FNAME'  => $user['fname'],
                'LNAME'  => $user['lname'],
                'DOB'    => $user['dob'] ? date("m/d", strtotime($user['dob'])) : '',
                'MOBILE' => $user['mobile']
            ]
        ]);

        if ($this->ChimpAPI->success()) {
            $this->add_user_tags($new_user);
            $this->update_marketing_permissions($new_user);
        } else {
            $this->error_send_message();
        }
    }

    private function update_marketing_permissions($user) {
        // TODO: Add IP and TimeStamp Values
        if(isset($user['marketing_permissions'])) {
            // User created now to update marketing permissions
            $permissions = $user['marketing_permissions'];

            // Loop through permissions and get ID and set status
            $data = ['marketing_permissions' => []];
            foreach ($permissions as $permission) {
                $data['marketing_permissions'][] = [
                    'marketing_permission_id' => $permission['marketing_permission_id'],
                    'enabled'                 => true
                ];
            }

            // Patch these permisions to the exisitng user.
            $updated_user_permissions = $this->ChimpAPI->patch(sprintf('%s/%s', $this->members_url, $user['id']), $data);

            if ($this->ChimpAPI->success()) {
                return $updated_user_permissions;
            } else {
                $this->error_send_message();
            }
        }
    }

    private function add_user_tags($user) {

        $add_user_tags = $this->ChimpAPI->post(sprintf('%s/%s/%s', $this->members_url, $user['id'], 'tags'), [
            'tags' => [
                [
                    'name' => 'Newspaper',
                    'status' => 'active'
                ]
            ]
        ]);

        if ($this->ChimpAPI->success()) {
            return $add_user_tags;
        } else {
            $this->error_send_message();
        }
    }


    private function error_send_message() {
        $response = $this->ChimpAPI->getLastResponse();
        $error = json_decode($response['body']);

        wp_send_json([
            'code'    => $error->status,
            'detail' => $error->detail,
            'message' => $error->message
        ]);

        wp_die();
    }

    private function success_send_message() {
        $response = $this->ChimpAPI->getLastResponse();
        $success = json_decode($response['body']);

        wp_send_json([
            'code'    => 200,
            'message' => $success->status
        ]);

        wp_die();
    }

}
