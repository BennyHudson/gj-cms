<?php
/**
 * ACF
 * --------
 *
 * @category ACF
 * @version 1.0
 * @package BMAS
 */
namespace BMAS\ACF;

defined( 'ABSPATH' ) || exit;

use Roots\WPConfig\Config;

class Setup
{

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
        // add_action( 'acf/settings/show_admin', [__CLASS__, 'remove_admin_menu']);
        // add_action( 'acf/settings/load_json', [__CLASS__, 'move_acf_json_load_point']);
        // add_action( 'acf/settings/save_json', [__CLASS__, 'move_acf_json_save_point']);
        add_action( 'acf/fields/google_map/api', [__CLASS__, 'set_google_maps_api_key']);
        // add_action( 'acf/update_value/type=password', [__CLASS__, 'encrypt_password_fields'], 10, 3);
    }

    /**
     * Hide the custom Fields Menu
     *
     * @return void
     */
    public static function remove_admin_menu($show)
    {
        // return current_user_can('manage_options');
        return false;
    }

    /**
     * Move ACF Google Maps Key
     *
     * @return void
     */
    public static function set_google_maps_api_key($api)
    {
        // BMAS Default Key
        $api['key'] = 'AIzaSyCxOwGupzNX4Ad3X5kZHbcx3QK6_zyXdu4';
        return $api;
    }

    /**
     * Move ACF json Load point
     *
     * @return void
     */
    public static function move_acf_json_load_point($paths)
    {
        // remove original path (optional)
        unset( $paths[0] );
        // append path
        $paths[] = Config::get('WP_CONTENT_DIR') . '/acf-json';
        // return
        return $paths;
    }

    /**
     * Move ACF json Save point
     *
     * @return void
     */
    public static function move_acf_json_save_point($paths)
    {
        // update path
        $path = Config::get('WP_CONTENT_DIR') . '/acf-json';;
        // return
        return $path;
    }

    public static function encrypt_password_fields( $value, $post_id, $field  )
    {
        $value = wp_hash_password( $value );
        return $value;
    }

}
