<?php
/**
 * Skimlinks
 * --------
 *
 * @category Assets
 * @version 1.0
 * @package BMAS
 */
namespace BMAS\Ads;

defined( 'ABSPATH' ) || exit;

class Skimlinks
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
        add_action( 'wp_enqueue_scripts', [__CLASS__, 'enqueue_library'], 10);
    }

    public static function enqueue_library() {

        if (! is_page_template('single-sponsored.php') && ! get_field('sponsor_logo') ) {
            wp_enqueue_script( 'ads-skimlinks', "//s.skimresources.com/js/164342X1631669.skimlinks.js", [], '1.0', false );
        }
    }
}
