<?php
/**
 * MailChimp Unsubscribe
 * --------
 * @category Vendor
 * @version 1.0
 * @package Lydia
 */

namespace BMAS\Vendor;

defined('ABSPATH') || exit;

use SendGrid as SG;
use RuntimeException;

class SendGridClubhouse
{

    public function __construct()
    {
        add_action('woocommerce_subscription_status_updated', [__CLASS__, 'update_user_status' ], 10, 3);
    }

    public static function get_user_email($subscription){
        $user_id = $subscription->get_user_id();
        $user = get_userdata($user_id);

        // if empty user, try to get the email from the order
        if(empty($user)){
            $order = wc_get_order($subscription->get_parent_id());
            $user = [
                'email' => $order->get_billing_email(),
                'first_name' => $order->get_billing_first_name(),
                'last_name' => $order->get_billing_last_name(),
            ];
        } else {
            $user = [
                'email' => $user->user_email,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
            ];
        }

        return $user;
    }

    public static function update_user_status($subscription, $new_status, $old_status) {

        // if the status is not changed, do nothing
        if($new_status == $old_status) {
            return;
        }

        $user = self::get_user_email($subscription);

        // if user email blank, do nothing
        if(empty($user['email'])) {
            return;
        }

        $sg = new SG('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');

        $request_body = [
            'list_ids' => [
                'b79b92c0-af65-403a-ad45-94c487941a01', // Clubhouse List ID
            ],
            'contacts' => [
                [
                    'email' => $user['email'],
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                    'custom_fields' => [
                        'e1_T' => $new_status, // clubhouse_subscription_status
                    ]
                ]
            ],
        ];

        try {

            $response = $sg->client->marketing()->contacts()->put($request_body);

        } catch (RuntimeException $ex) {
            throw new RuntimeException($ex->getMessage());
        }

    }

}
