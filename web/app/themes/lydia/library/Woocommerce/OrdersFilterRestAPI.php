<?php
/**
 * Woocommerce Order
 * --------
 * @category Woocommerce
 * @version 1.0
 * @package Lydia
 */
namespace BMAS\Woocommerce;

defined( 'ABSPATH' ) || exit;

class OrdersFilterRestAPI
{

    public function __construct()
    {
        $this->add_filters();
    }

    public function add_filters()
    {
        add_filter( 'rest_pre_echo_response', [__CLASS__, 'filter_orders_data_by_subscription_type'], 10, 3 );
    }

    /**
     * @param $response
     * @param $object
     * @param $request
     * @return mixed
     */
    public static function filter_orders_data_by_subscription_type(
        $response,
        $object,
        $request
    ) {

        if ( $request->get_route() == '/wc/v2/orders' || $request->get_route() == '/wc/v3/orders' ) {

            $subscription_parent_orders = array_filter($response, function($order) {
                if (array_key_exists('id', $order)) {
                    // Exclude the Order if it is a renewal
                    return wcs_order_contains_subscription($order['id'], ['parent']);
                }
            });

            $response = array_values($subscription_parent_orders);
        }

        return $response;

    }

}
