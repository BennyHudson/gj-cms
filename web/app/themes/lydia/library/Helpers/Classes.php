<?php
/**
 * Classes
 * --------
 *
 * @category Helpers
 * @version 1.0
 * @package Lydia
 */

namespace BMAS\Helpers;

defined( 'ABSPATH' ) || exit;

class Classes
{

    public function __construct( )
    {
        add_filter( 'body_class', [__CLASS__, 'add_body_classes'] );
    }

    /**
     * Allow SVG in Media Library
     * --------
     */
    public static function add_body_classes($classes)
    {
        global $post;

        // Main Page
        if ( is_home() ) {
            $classes[] = 't-home';
        }

        // Front Page
        if ( is_front_page() ) {
            $classes[] = 't-front';
        }

        // Blog Page
        if ( is_front_page() && is_home() ) {
            $classes[] = 't-blog';
        }

        // Single Post
        if ( is_singular() && ! is_front_page() ) {
            $classes[] = 't-singular';
        }

        // Author
        if ( is_author() ) {
            $classes[] = 't-author';
        }

        // Multi Author
        if ( is_multi_author() ) {
            $classes[] = 't-author-multi';
        }

        // Category Name
        if ( is_single() ) {
            foreach (  ( get_the_category( $post->ID ) ) as $category ) {
                $classes[] = 't-cat-' . $category->category_nicename;
            }
        }

        // Archive
        if ( is_archive() ) {
            $classes[] = 't-archive';
        }

        // Paged Page
        if ( is_paged() ) {
            $classes[] = 't-paged';
        }

        // Search Results Page
        if ( is_search() ) {
            $classes[] = 't-search-results';
        }

        // Sidebar
        if ( is_active_sidebar( 'widget-area-page', 'widget-area-post' ) && ! is_attachment() && ! is_404() ) {
            $classes[] = 't-sidebar';
        }

        // 404
        if ( is_404() ) {
            $classes[] = 't-error-404';
        }

        // Password Protected
        if ( post_password_required() ) {
            $classes[] = 't-password-protected';
        }

        // Attachment
        if ( is_attachment() ) {
            $classes[] = 't-attachment';
        }

        // Attachment Image
        if ( wp_attachment_is_image() ) {
            $classes[] = 't-attachment-img';
        }

        if ( isset( $post ) ) {
            $classes[] = $post->post_type . '-' . $post->post_name;
        }

        $classes[] = 'u-has-sticky-footer';

        // Remove unnecessary classes
        $remove_classes = [
            'page-template-default',
            'wp-embed-responsive'
        ];

        $classes = array_diff($classes, $remove_classes);


        return $classes;
    }
}
