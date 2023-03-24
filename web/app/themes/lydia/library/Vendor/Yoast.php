<?php
/**
 * Yoast Breadcrumbs adjustments
 * --------
 * @category Vendor
 * @version 1.0
 * @package Lydia
 */

namespace BMAS\Vendor;

use Yoast_Notification_Center as YoastNotifcations;

defined('ABSPATH') || exit;

class Yoast
{
    public function __construct()
    {
        $this->add_filters();
        $this->add_actions();
    }

    /**
     * Do actions
     *
     * @return void
     */
    public static function add_filters()
    {

        add_filter('wpseo_breadcrumb_single_link', [__CLASS__, 'remove_breadcrumbs'], 10, 2);
        add_filter('wpseo_breadcrumb_separator', [__CLASS__, 'change_seperator'], 10, 2);
        add_filter('wpseo_metabox_prio', function () {
            return 'low';
        });
    }

    /**
     * Do actions
     *
     * @return void
     */
    public static function add_actions()
    {

        add_action('admin_init', [__CLASS__, 'disable_yoast_notifications']);
    }

    /**
     * Change the separator
     *
     * @param str $separator
     * @return str
     */
    public static function change_seperator($separator)
    {

        $separator = '<span class="c-crumbs__separator far fa-angle-right"></span>';

        return $separator;
    }

    /**
     * Remove Yoast Breadcrumbs
     *
     * @param [type] $link_output
     * @param [type] $link
     * @return void
     */
    public static function remove_breadcrumbs(
        $link_output,
        $link
    ) {

        if ($link['text'] == 'Post') {
            $link_output = '';
        }

        return $link_output;
    }

    /**
     * Disable Yoast Notifcations
     *
     */
    public static function disable_yoast_notifications()
    {
        if ( class_exists('YoastNotifcations') ) {
            remove_action('admin_notices', [YoastNotifcations::get(), 'display_notifications']);
            remove_action('all_admin_notices', [YoastNotifcations::get(), 'display_notifications']);
        }
    }
}
