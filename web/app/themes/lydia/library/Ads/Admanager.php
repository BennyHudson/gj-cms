<?php
/**
 * Admanager
 * --------
 *
 * @category Assets
 * @version 1.0
 * @package BMAS
 */
namespace BMAS\Ads;

defined( 'ABSPATH' ) || exit;

class Admanager
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
        add_action( 'wp_enqueue_scripts', [__CLASS__, 'load_gpt_library'], 10);
    }

    public static function load_gpt_library() {

        wp_enqueue_script(
            'google-admanager',
            '//securepubads.g.doubleclick.net/tag/js/gpt.js',
            [],
            false,
            false
        );

        wp_localize_script( 'google-admanager', 'ads_keyvalues', [
            'category' => self::get_category_key_values(),
            'id' => get_the_ID(),
            'sponsored' => self::get_sponsored_key_values()
        ]);
    }

    public static function get_sponsored_key_values() {
        $queried_object = get_queried_object();

        // Sponsored
        if (is_singular() && get_field('sponsor_logo', $queried_object->ID)) {
            return true;
        } else {
            return false;
        }
    }

    public static function get_category_key_values() {

        $queried_object = get_queried_object();

        // Is Term
        if (is_a($queried_object, 'WP_Term')) {
            return $queried_object->slug;
        }

        // Is Post
        if (is_singular() && has_category()) {
            $categories = get_the_category($queried_object->ID);

            return wp_list_pluck($categories, 'slug');
        }

        // Is Post Type
        if (is_a($queried_object, 'WP_Post_Type')) {
            return $queried_object->name;
        }

        // Is Front Page
        if (is_front_page()) {
            return 'front-page';
        }

        return 'none';

    }
}
