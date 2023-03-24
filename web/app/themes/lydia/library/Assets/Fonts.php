<?php
/**
 * Enqueue
 * --------
 *
 * @category Assets
 * @version 1.0
 * @package BMAS
 */
namespace BMAS\Assets;

defined( 'ABSPATH' ) || exit;

class Fonts
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
        add_action( 'wp_enqueue_scripts', [__CLASS__, 'typography_fonts'], 10);
    }

    /**
     * Add Lydia Styles to Frontend
     *
     * @return void
     */
    public static function typography_fonts()
    {

        wp_enqueue_style( 'fonts-typography', '//cloud.typography.com/6698996/7378992/css/fonts.css', [], null );

    }

}
