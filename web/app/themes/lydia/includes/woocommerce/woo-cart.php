<?php

// Remove Product Thumbnail from the cart
add_filter( 'woocommerce_cart_item_thumbnail', '__return_false' );

function gj_remove_cart_product_link( $product_link, $cart_item, $cart_item_key ) {
    $product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
    return $product->get_title();
}
add_filter( 'woocommerce_cart_item_name', 'gj_remove_cart_product_link', 10, 3 );

// Modify the Cart Collaterals

// Remove Collaterals
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );

// Add Back what we want
function minimal_cart_collaterals() {
    echo '<div class="cart-collaterals__total cart_totals"><h2 class="cart-collaterals__label">Total</h2>';
    echo wc_cart_totals_order_total_html();
    echo '</div>';
    echo do_action('woocommerce_proceed_to_checkout');
}
add_action( 'woocommerce_cart_collaterals', 'minimal_cart_collaterals', 10 );

function woo_change_empty_cart_button_url() {
	return get_permalink(74300);
	//Can use any page instead, like return '/sample-page/';
}
add_filter( 'woocommerce_return_to_shop_redirect', 'woo_change_empty_cart_button_url' );


// Restrict Free Products
function woo_restrict_free_products(){

    if( is_product() && has_term( 'free-gifts', 'product_cat') ) {
        wp_redirect( home_url() );
        exit;
    }
}
add_action( 'template_redirect', 'woo_restrict_free_products');

// Add free product to cart

function get_free_product_for_clubhouse() {

    $free_gifts = wc_get_products([
        'category' => ['free-gifts'],
        'status' => 'publish',
        'stock_status' => 'instock',
        'order' => 'ASC',
        'return' => 'ids',
    ]);

    if (!empty($free_gifts)) {
        return $free_gifts[0];
    } else {
        return false;
    }
}


function woo_add_gift_if_id_in_cart() {

    if (is_cart() || is_checkout()) {

        $subscriptions = [193031, 382206];
        $gift_id = get_free_product_for_clubhouse();

        if ($gift_id) {

            $gift_cart_id = WC()->cart->generate_cart_id( $gift_id );

            foreach( WC()->cart->get_cart() as $cart_item ) {

                if (in_array( $cart_item['data']->get_id(), $subscriptions )) {

                    if ( ! WC()->cart->find_product_in_cart( $gift_cart_id )) {
                        WC()->cart->add_to_cart( $gift_id );
                    }

                    break;

                } else {
                    WC()->cart->remove_cart_item( $gift_cart_id );
                }
            }
        }
    }
}

add_action( 'template_redirect', 'woo_add_gift_if_id_in_cart' );
