<?php
/**
 * ACF
 * --------
 *
 * @category ACF
 * @version 1.0
 * @package BMAS
 */
namespace BMAS\ACF;

defined( 'ABSPATH' ) || exit;

class Options
{

    private $parent;
    private $sub;

    public function __construct()
    {
        $this->parent = [
            [
                'page_title' => 'Global Options',
                'menu_title' => 'Global Options',
                'menu_slug'  => 'global-options',
                'capability' => 'edit_posts',
                'position'   => 50,
                'redirect'   => true,
                'post_id'    => 'global_options',
                'show_in_graphql'       => true,
                'show_in_rest'          => true,
                'graphql_single_name' => 'globalOption',
                'graphql_plural_name' => 'globalOptions',
            ],

            [
                'page_title' => 'GJ Options',
                'menu_title' => 'GJ Options',
                'menu_slug'  => 'gj-options',
                'capability' => 'edit_posts',
                'position'   => 50,
                'redirect'   => true,
                'post_id'    => 'options',
                'show_in_graphql'       => true,
                'show_in_rest'          => true,
                'graphql_single_name' => 'gjOption',
                'graphql_plural_name' => 'gjOptions',
            ]
        ];
        $this->sub = [
            [
                'page_title'  => 'General',
                'menu_title'  => 'General',
                'menu_slug'   => 'general',
                'capability'  => 'edit_posts',
                'position'    => 100,
                'redirect'    => true,
                'post_id'     => 'general',
                'show_in_graphql'       => true,
                'show_in_rest'          => true,
                'graphql_single_name' => 'generalOption',
                'graphql_plural_name' => 'generalOptions',
                'parent_slug' => 'global-options'
            ],

            [
                'page_title'  => 'Components',
                'menu_title'  => 'Components',
                'menu_slug'   => 'components',
                'capability'  => 'edit_posts',
                'position'    => 100,
                'redirect'    => true,
                'post_id'     => 'components',
                'show_in_graphql'       => true,
                'show_in_rest'          => true,
                'graphql_single_name' => 'componentOption',
                'graphql_plural_name' => 'componentOptions',
                'parent_slug' => 'global-options'
            ],

            [
                'page_title'  => 'Social',
                'menu_title'  => 'Social',
                'menu_slug'   => 'social',
                'capability'  => 'edit_posts',
                'position'    => 100,
                'redirect'    => true,
                'post_id'     => 'social',
                'show_in_graphql'       => true,
                'show_in_rest'          => true,
                'graphql_single_name' => 'socialOption',
                'graphql_plural_name' => 'socialOptions',
                'parent_slug' => 'global-options'
            ]
        ];

        $this->build_pages();
    }

    /**
     * Build the Pages
     *
     * @return void
     */
    public function build_pages() {
        self::create_parent_option_pages($this->parent);
        self::create_sub_option_pages($this->sub);
    }

    /**
     * Create Parent Options
     *
     * @return array
     */
    private static function create_parent_option_pages($options)
    {
        if ( function_exists( 'acf_add_options_page' ) ) {
            foreach ( $options as $page ) {
                acf_add_options_page( $page );
            }
        }
    }

    /**
     * Create Sub Options
     *
     * @return array
     */
    private static function create_sub_option_pages($options)
    {
        if ( function_exists( 'acf_add_options_page' ) ) {
            foreach ( $options as $page ) {
                acf_add_options_sub_page( $page );
            }
        }
    }
}
