<?php
/**
 * Guttenburg
 * --------
 *
 * @category WP
 * @version 1.0
 * @package Lydia
 */

namespace BMAS\WP;

defined( 'ABSPATH' ) || exit;

class Guttenburg
{
    /**
     * @var array
     */
    public $social = [];

    public function __construct()
    {
        // $this->disable();
        $this->add_actions();
        $this->remove_unwanted_features();
    }

    public static function disable() {
        add_filter('gutenberg_can_edit_post', '__return_false', 5);
        add_filter('use_block_editor_for_post_type', [__CLASS__, 'disable_by_id']);
    }

    public static function add_actions()
    {
        //add_action( 'enqueue_block_editor_assets', [__CLASS__, 'enqueue_guttenberg_overides'] );
        add_action( 'after_setup_theme', [__CLASS__, 'set_theme_colors'] );
        add_action( 'after_setup_theme', [__CLASS__, 'set_font_sizes'] );
        add_action( 'wp_enqueue_scripts', [__CLASS__, 'dequeue_guttenberg_styles'], 10 );
        add_filter( 'allowed_block_types', [__CLASS__, 'remove_unwanted_blocks'], 10, 2 );
    }

    public static function enqueue_guttenberg_overides()
    {

        wp_register_script(
            'lydia-guttenburg-script',
            get_template_directory_uri() . '/admin/lydia-guttenberg-blocks.min.js',
            ['wp-blocks', 'wp-dom-ready', 'wp-edit-post'],
            filemtime( get_stylesheet_directory() . '/admin/lydia-guttenberg-blocks.min.js' )
        );

        wp_enqueue_script( 'lydia-guttenburg-script' );

        wp_enqueue_style(
            'lydia-guttenburg-styles',
            get_template_directory_uri() . '/admin/lydia-guttenberg-styles.css',
            filemtime( get_stylesheet_directory() . '/admin/lydia-guttenberg-styles.css' ) );

    }

    public static function dequeue_guttenberg_styles()
    {
        wp_dequeue_style( 'wp-block-library' );
        wp_dequeue_style( 'wp-block-library-theme' ); // Wordpress core
        wp_dequeue_style( 'wc-block-style' ); // WooCommerce
    }

    public static function remove_unwanted_features()
    {
        add_theme_support( 'editor-color-palette' );
        // add_theme_support( 'disable-custom-colors' );
        add_theme_support( 'disable-custom-font-sizes' );
        add_theme_support( 'align-wide' );
        add_theme_support( 'responsive-embeds' );
    }

    public static function set_theme_colors()
    {

        // Editor Color Palette
        add_theme_support( 'editor-color-palette', [
            [
                'name'  => __( 'Black', 'lydia' ),
                'slug'  => 'nighthawk',
                'color' => '#000000'
            ],
            [
                'name'  => __( 'White', 'lydia' ),
                'slug'  => 'templar',
                'color' => '#ffffff'
            ],
            [
                'name'  => __( 'Primary', 'lydia' ),
                'slug'  => 'primary',
                'color' => '#000000'
            ],
            [
                'name'  => __( 'Secondary', 'lydia' ),
                'slug'  => 'secondary',
                'color' => '#ffffff'
            ]
        ] );
    }

    public static function set_font_sizes()
    {

        add_theme_support( 'editor-font-sizes', [
            [
                'name' => __( 'Small', 'lydia' ),
                'size' => 12,
                'slug' => 'small'
            ],
            [
                'name' => __( 'Normal', 'lydia' ),
                'size' => 16,
                'slug' => 'normal'
            ],
            [
                'name' => __( 'Medium', 'lydia' ),
                'size' => 18,
                'slug' => 'medium'
            ],
            [
                'name' => __( 'Large', 'lydia' ),
                'size' => 20,
                'slug' => 'large'
            ],
            [
                'name' => __( 'Huge', 'lydia' ),
                'size' => 24,
                'slug' => 'huge'
            ]
        ] );

    }

    /**
     * @param $allowed_blocks
     */
    public static function remove_unwanted_blocks( $allowed_blocks )
    {

        return [
            'core/image',
            'core/paragraph',
            'core/heading',
            'core/list',
            'core/gallery',
            'core/list',
            'core/quote',
            'core/audio',
            'core/cover',
            'core/file',
            'core/video',
            'core/table',
            'core/verse',
            'core/code',
            'core/html',
            'core/preformatted',
            'core/pullquote',
            'core/button',
            'core/text-columns',
            'core/columns',
            'core/media-text',
            'core/more',
            'core/separator',
            'core/spacer',
            'core/shortcode',
            'core/embed',
            'core-embed/youtube',
            'core-embed/instagram',
            'core-embed/vimeo',
        ];
    }

       /**
     * @param $content
     * @param $blockName
     * @return mixed
     */
    public static function get_blocks_by_type(
        $content,
        $blockName = ''
    ) {

        if (has_blocks($content)) {

            $blocks  = parse_blocks($content);
            $content = '';

            foreach ($blocks as $block) {
                if ($block['blockName'] == $blockName) {
                    $content .= $block['innerHTML'];
                }
            }
        }

        return $content;
    }

    /**
     * @param $content
     * @param $blockName
     * @return mixed
     */
    public static function get_blocks_by_type_array(
        $content,
        $blockName = ''
    ) {

        if (has_blocks($content)) {

            $blocks  = parse_blocks($content);
            $content = [];

            foreach ($blocks as $block) {
                if ($block['blockName'] == $blockName) {
                    $content[] = $block['innerHTML'];
                }
            }
        }

        return $content;
    }
}
