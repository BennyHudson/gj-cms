<?php
/**
 *  WOOCOMMERCE Facbook Pixel Events
 *  ------
 *  @package GJ
 *  @since GJ 1.0
 */

/**
 * Checkout Thankyou Page
 * --------
 * @package GJ
 * @since GJ 3.0
 */
function woo_fbevent_purchase( $order_id )
{

    if ( is_order_received_page() ) {

        global $wp;
        $params   = [];
        $order_id = isset( $wp->query_vars['order-received'] ) ? $wp->query_vars['order-received'] : 0;
        $dp       = ( isset( $filter['dp'] ) ) ? intval( $filter['dp'] ) : 2;

        if ( $order_id ) {

            $order = new WC_Order( $order_id );

            foreach ( $order->get_items() as $item_id => $item ) {
                $product = $item->get_product();

                $product_id = null;

                if ( is_object( $product ) ) {
                    $product_id = $product->get_id();
                } elseif ( ! empty( $item->get_variation_id() ) && ( 'product_variation' === $product->post_type ) ) {
                    $product_id = $product->get_parent_id();
                }

                $order_data['contents'][] = [
                    'id'         => $product_id,
                    'quantity'   => wc_stock_amount( $item['qty'] ),
                    'item_price' => wc_format_decimal( $order->get_line_total( $item, false, false ), $dp )
                ];
            }

            $params['contents']     = $order_data['contents'];
            $params['content_type'] = 'product';
            $params['value']        = wc_format_decimal( $order->get_total(), $dp );
            $params['currency']     = get_woocommerce_currency();
        }

        echo "<script>fbq('track', 'Purchase', " . json_encode( $params ) . ');</script>';

    }
}

//add_action( 'woocommerce_thankyou', 'woo_fbevent_purchase' );


function fbevent_category()
{
    global $post;
    // Category Name
    $classes = [];
    if ( is_single() ) {
        foreach (  ( get_the_category( $post->ID ) ) as $category ) {
            $classes[] = $category->category_nicename;
        }
    }

    $params['content_type'] = $classes;

    echo "<script>fbq('track', 'ViewContent', " . json_encode( $params ) . ');</script>';

}

// add_action( 'before_single_article_content', 'fbevent_category' );
