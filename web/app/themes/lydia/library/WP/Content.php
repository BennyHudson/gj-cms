<?php
/**
 * Content
 * --------
 *
 * @category WP
 * @version 1.0
 * @package Lydia
 */

namespace BMAS\WP;

defined( 'ABSPATH' ) || exit;

class Content
{

    public function __construct( )
    {
        remove_filter( 'the_content', 'wpautop' );
        remove_filter( 'the_excerpt', 'wpautop' );
        add_filter( 'the_content', [__CLASS__, 'remove_br'] );
        add_filter( 'the_excerpt', [__CLASS__, 'remove_br'] );
    }

    /**
     * Attachment Display Options
     * --------
     */
    public static function remove_br($content)
    {
        return wpautop( $content, false );
    }
}
