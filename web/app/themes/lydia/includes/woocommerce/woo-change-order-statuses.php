<?php
/**
 *  Change Order Statuses
 *  ------
 *  @package Lydia
 *  @since Lydia 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Rename order status 'Completed' to 'Order Received' in admin main view - different hook, different value than the other places
function wc_rename_order_status_type( $order_statuses )
{
    foreach ( $order_statuses as $key => $status ) {
        $new_order_statuses[$key] = $status;
        if ( 'wc-processing' === $key ) {
            $order_statuses['wc-processing']['label_count'] = _n_noop( 'Order Accepted <span class="count">(%s)</span>', 'Order Accepted <span class="count">(%s)</span>', 'woocommerce' );
        }
    }

    return $order_statuses;
}

add_filter( 'woocommerce_register_shop_order_post_statuses', 'wc_rename_order_status_type' );

/**
 * @param $order_statuses
 * @return mixed
 */
function wc_renaming_order_status( $order_statuses )
{
    foreach ( $order_statuses as $key => $status ) {
        $new_order_statuses[$key] = $status;
        if ( 'wc-processing' === $key ) {
            $order_statuses['wc-processing'] = _x( 'Order Accepted', 'Order status', 'woocommerce' );
        }
    }

    return $order_statuses;
}

add_filter( 'wc_order_statuses', 'wc_renaming_order_status' );

// Rename order status in the bulk actions dropdown on main order list
/**
 * @param $translated_text
 * @param $untranslated_text
 * @param $domain
 * @return mixed
 */
function rename_bulk_status(
    $translated_text,
    $untranslated_text,
    $domain
) {
    if ( is_admin() ) {
        if ( $untranslated_text == 'Change Status To completed' ) {
            $translated_text = __( 'Change Status To Order Accepted', 'woocommerce' );
        }

    }

    return $translated_text;
}

add_filter( 'gettext', 'rename_bulk_status', 20, 3 );
