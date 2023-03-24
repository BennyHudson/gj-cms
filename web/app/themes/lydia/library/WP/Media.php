<?php
/**
 * Media
 * --------
 *
 * @category WP
 * @version 1.0
 * @package Lydia
 */

namespace BMAS\WP;

defined( 'ABSPATH' ) || exit;

class Media
{

    public function __construct( )
    {
        add_filter( 'after_setup_theme', [__CLASS__, 'attachment_display'] );
        add_filter( 'upload_mimes', [__CLASS__, 'allow_additional_media_types'] );
        add_filter( 'admin_head', [__CLASS__, 'fix_svg_display_admin'] );
        add_filter( 'jpeg_quality', [__CLASS__, 'change_upload_compression'], 10, 2);
        add_filter( 'wp_editor_set_quality', [__CLASS__, 'change_upload_compression'], 10, 2);
        add_filter( 'use_default_gallery_style', '__return_false' );
        add_filter( 'wp_calculate_image_srcset', '__return_false' );
    }

    /**
     * Attachment Display Options
     * --------
     */
    public static function attachment_display()
    {
        update_option( 'image_default_align', 'center' );
        update_option( 'image_default_link_type', 'none' );
        update_option( 'image_default_size', 'large' );
    }

    /**
     * Allow SVG in Media Library
     * --------
     */
    public static function allow_additional_media_types($mimes)
    {
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    }

    public static function fix_svg_display_admin() {
        $css = '';
        $css = '#postimagediv .inside img[src$=".svg"] { width: 100% }';
        echo '<style type="text/css">'.$css.'</style>';
    }

    /**
     * JPEG Compression Remove
     * --------
     */
    public static function change_upload_compression()
    {
        return 80;
    }
}
