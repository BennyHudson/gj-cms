<?php
/**
 * Styles
 * --------
 *
 * @category Assets
 * @version 1.0
 * @package BMAS
 */
namespace BMAS\Assets;

defined( 'ABSPATH' ) || exit;

class Styles
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
        add_action( 'wp_enqueue_scripts', [__CLASS__, 'lydia_style'], 1 );
    }

    /**
     * Add Lydia Styles to Frontend
     *
     * @return void
     */
    public static function lydia_style()
    {
        wp_enqueue_style( 'lydia-style', get_stylesheet_directory_uri() . '/style.css', [], filemtime( get_stylesheet_directory() . '/style.css' ), false );
    }

}
