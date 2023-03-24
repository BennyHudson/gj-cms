<?php
/**
 * Development Helpers
 * --------
 *
 * @category Util
 * @version 1.0
 * @package BMAS
 */
namespace BMAS\Util;

defined( 'ABSPATH' ) || exit;

class Development
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
    public static function add_actions()
    {
        add_action( 'wp_footer', [__CLASS__, 'add_browser_sync'], 100 );
    }

    /**
     * Conditionally add browsersync script
     *
     * @return void
     */
    public static function add_browser_sync()
    {
        if ( self::is_localhost() && WP_DEBUG && ! is_admin() ) {
            self::browser_sync_script();
        }
    }

    /**
     * Output BrowserSync Script
     *
     * @return void
     */
    public static function browser_sync_script()
    {

        $script = "<script id=\"__bs_script__\">
            //<![CDATA[
            document.write(\"<script async src='http://HOST:3000/browser-sync/browser-sync-client.js?v=2.26.14'><\/script>\".replace(\"HOST\", location.hostname));
            //]]>
        </script>";

        echo $script;
    }

    /**
     * Check for localhost
     *
     * @return boolean
     */
    public static function is_localhost()
    {

        $whitelist = ['127.0.0.1', '::1'];

        if ( in_array( $_SERVER['REMOTE_ADDR'], $whitelist ) ) {
            return true;
        }
    }
}
