<?php
/**
 * Menu
 * --------
 *
 * @category WP
 * @version 1.0
 * @package Lydia
 */

namespace BMAS\WP;

defined( 'ABSPATH' ) || exit;

class Menu
{

    public function __construct( )
    {
        add_filter( 'nav_menu_css_class', [__CLASS__, 'class_filter'], 100, 1 );
    }

    /**
     * Reduce nav classes, leaving only 'current-menu-item'
     * --------
     * @since 3.0
     */
    public static function class_filter( $var )
    {
        foreach ( $var as $key => $value ) {
            if ( preg_match( '/^(menu-item-?.*|page_item|page-item-.*|current_page_item)$/', $value ) ) {
                unset( $var[$key] );
            }
        }
        return $var;
    }

}
