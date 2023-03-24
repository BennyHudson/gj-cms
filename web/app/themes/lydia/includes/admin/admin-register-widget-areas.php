<?php
/**
 * Register Widget Areas
 * --------
 * @category Admin
 * @version 1.0
 * @package Lydia/Admin
 */
defined( 'ABSPATH' ) || exit;

function lydia_register_widget_areas()
{
    // Pages Sidebar
    register_sidebar(
        [
            'name'          => __( 'Pages', 'lydia' ),
            'id'            => 'widget-area-page',
            'description'   => __( 'Sidebar widgets for pages', 'lydia' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>'
        ]
    );
    // Footer Widget area
    register_sidebar(
        [
            'name'          => __( 'Footer', 'lydia' ),
            'id'            => 'widget-area-footer',
            'description'   => __( 'Widget area for Footer', 'lydia' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>'
        ]
    );
    // Posts Sidebar
    register_sidebar(
        [
            'name'          => __( 'Blog', 'lydia' ),
            'id'            => 'widget-area-blog',
            'description'   => __( 'Sidebar widgets for categories and single posts', 'lydia' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>'
        ]
    );
}

add_action( 'widgets_init', 'lydia_register_widget_areas' );

// Remove unsed default widgets
function lydia_remove_core_widgets()
{
    unregister_widget( 'WP_Widget_Calendar' );
    unregister_widget( 'WP_Widget_Tag_Cloud' );
    unregister_widget( 'WP_Widget_Recent_Comments' );
}

add_action( 'widgets_init', 'lydia_remove_core_widgets', 1 );
