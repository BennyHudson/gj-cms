<?php
/**
 * GoogleMaps
 * --------
 *
 * @category Assets
 * @version 1.0
 * @package BMAS
 */
namespace BMAS\Vendor;

defined( 'ABSPATH' ) || exit;

class GoogleMaps
{

    private static $api_key = 'AIzaSyCxOwGupzNX4Ad3X5kZHbcx3QK6_zyXdu4';

    public function __construct()
    {
        $this->add_actions();
    }

    /**
     * Add Actions Hooks
     *
     * @return void
     */
    public static function add_actions() {
        add_action( 'wp_enqueue_scripts', [__CLASS__, 'enqueue_library'], 10);
    }

    public static function enqueue_library() {

        if (is_page(2)) {
            wp_enqueue_script( 'google-maps', "//maps.googleapis.com/maps/api/js?key=" . self::$api_key . "", ['jquery'], null, true );
        }

    }
}
