<?php

/**
 * Lydia Init Setup
 * --------
 * Sets up theme defaults and registers support for various WordPress features.
 * --------
 * @category Base
 * @version 1.0
 * @package Lydia
 */

namespace BMAS;

defined( 'ABSPATH' ) || exit;

class LydiaSite extends \Timber\Site
{
    public function __construct()
    {
        $this->add_theme_supports();
        $this->add_menus();
        $this->set_timber_folders();
        $this->set_post_thumbnails();

        parent::__construct();
    }

    public function add_menus()
    {
        // Register menus for use with wp_nav_menu()
        register_nav_menus( [
            'header'      => __( 'Header Menu', 'lydia' ),
            'footer'      => __( 'Footer Menu', 'lydia' ),
            'footer-info' => __( 'Footer Menu Info', 'lydia' ),
            'footer-cat'  => __( 'Footer Menu Cat', 'lydia' )
        ] );
    }

    public function add_theme_supports()
    {
        // Make theme available for translation, languages can be filed in the /languages/ directory
        load_theme_textdomain( 'lydia', get_template_directory() . '/languages' );
        // Title tag added dynamically through WP and not hard coded in template
        add_theme_support( 'title-tag' );
        // Enable post thumbnails
        add_theme_support( 'post-thumbnails' );

        add_theme_support( 'custom-logo', [
            'height'      => 100,
            'width'       => 400,
            'flex-height' => true,
            'flex-width'  => true,
            'header-text' => ['site-title', 'site-description']
        ] );

        add_post_type_support( 'page', 'excerpt' );

        // Add Theme support for HTML5 elements
        add_theme_support( 'html5', [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption'
        ] );

        add_theme_support( 'post-formats', [
            'image',
            'video',
            'gallery',
            'audio'
        ] );
    }

    public function set_timber_folders()
    {

        \Timber\Timber::$dirname   = ['views', 'img'];
        \Timber\Timber::$locations = ['views', 'img'];
    }
}
