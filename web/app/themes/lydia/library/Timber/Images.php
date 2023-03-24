<?php
/**
 * Timber Images
 * --------
 * @category Timber
 * @version 1.0
 * @package Lydia
 */

namespace BMAS\Timber;

defined('ABSPATH') || exit;

class Images
{

    public function __construct()
    {
        $this->prepare();
        $this->setImages();
        add_filter( 'acf/load_field/type=image', [__CLASS__, 'set_acf_img_return_id'], 1);
    }

    public function prepare()
    {
        set_post_thumbnail_size( 0, 0 );

        add_filter( 'intermediate_image_sizes', function( $sizes )
        {
            return array_filter( $sizes, function( $val )
            {
                return 'medium_large' !== $val;
            });

        });

        add_filter( 'woocommerce_resize_images', '__return_false' );

    }

    public function setImages()
    {

        if (class_exists('Timmy\Timmy')) {
            update_option( 'thumbnail_size_w', 0 );
            update_option( 'thumbnail_size_h', 0 );

            update_option( 'medium_size_w', 0 );
            update_option( 'medium_size_h', 0 );

            update_option( 'large_size_w', 0 );
            update_option( 'large_size_h', 0 );
        }

        add_filter( 'timmy/sizes', function ( $sizes ) {
            return [
                'thumbnail' => [
                    'resize' => [ 150, 150, 'center' ],
                    'name' => 'Thumbnail',
                    'post_types' => ['all'],
                ],
                'small'     => [
                    'resize' => [ 640, 640 ],
                    'name' => 'Small',
                ],
                'medium'    => [
                    'resize' => [ 1288, 1288 ],
                    'name' => 'Medium',
                ],
                'large'     => [
                    'resize' => [ 1400, 1400 ],
                    'name' => 'Large',
                ]
            ];
        } );
    }

    public static function set_acf_img_return_id($field) {

        $field['return_format'] = 'id';

        return $field;
    }
}
