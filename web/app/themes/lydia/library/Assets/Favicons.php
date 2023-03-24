<?php
/**
 * Favicons
 * --------
 *
 * @category Assets
 * @version 1.0
 * @package BMAS
 */
namespace BMAS\Assets;

defined( 'ABSPATH' ) || exit;

class Favicons
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
        add_action( 'wp_head', [__CLASS__, 'add_favicons'], 10 );
    }

    public static function add_favicons()
    {

        $path = get_template_directory_uri() . '/assets/favicons';

        echo '<link rel="apple-touch-icon" sizes="180x180" href="' . $path . '/apple-touch-icon.png">';
        echo '<link rel="icon" type="image/png" sizes="32x32" href="' . $path . '/favicon-32x32.png">';
        echo '<link rel="icon" type="image/png" sizes="16x16" href="' . $path . '/favicon-16x16.png">';
        echo '<link rel="manifest" href="' . $path . '/site.webmanifest">';
        echo '<link rel="mask-icon" href="' . $path . '/safari-pinned-tab.svg" color="#202020">';
        echo '<link rel="shortcut icon" href="' . $path . '/favicon.ico">';
        echo '<meta name="msapplication-TileColor" content="#0f8bcc">';
        echo '<meta name="msapplication-config" content="' . $path . '/browserconfig.xml">';
        echo '<meta name="theme-color" content="#202020">';
    }
}
