<?php
/**
 * Social Helpers
 * --------
 *
 * @category Helpers
 * @version 1.0
 * @package Lydia
 */

namespace BMAS\Helpers;

defined( 'ABSPATH' ) || exit;

class Social
{
    /**
     * @var array
     */
    public $social = [];

    public function __construct()
    {
        $this->social = get_field( 'social', 'social' );
    }

    /**
     * @param $class
     */
    public function follow( $class = false )
    {

        /**
         * Get Set social media platforms
         */
        $social = $this->social;

        /**
         * Set the Class
         */
        $classes = 'c-social c-social--follow';

        if ( $class ) {
            $classes = sprintf( '%s %s', $classes, $class );
        }

        /**
         * Output Social Follow
         */
        if ( $social ):

            echo '<ul class="' . $classes . '">';

            foreach ( $social as $item ) {

                echo '<li class="c-social__item"><a href="' . esc_url( $item['social_url'] ) . '" class="c-social__link" rel="nofollow" target="_blank"><i class="fab fa-' . $item['social_channel'] . '"></i></a></li>';
                // echo '<li class="c-social__item"><a href="' . esc_url( $item['social_url'] ) . '" class="c-social__link" rel="nofollow" target="_blank">' . $item['social_channel']['label'] . '</a></li>';

            }

            echo '</ul>';

        endif;

    }

    /**
     * Get title
     */
    public static function get_share_title( $id = null )
    {

        $title = get_the_title( $id );

        return urlencode( $title );

    }

    /**
     * Share Icons
     */
    public function share(
        $id = null,
        $class = false,
        $styles = false
    ) {

        /**
         * Set the Class
         */
        $classes = 'c-social c-social--share';

        if ( $class ) {
            $classes = sprintf( '%s %s', $classes, $class );
        }

        // Add Style Class
        if ( $styles ) {
            $style = 'c-social--' . $styles;
            $classes = sprintf( '%s %s', $classes, $style );
        }

        if ( isset( $id ) ) {
            $permalink = urlencode( get_permalink( $id ) );
            $image_src = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'large' );
        }

        /**
         * Set the Social Platforms
         */
        $social_plat = [
            'facebook-f' => 'https://www.facebook.com/sharer/sharer.php?u=' . $permalink,
            'twitter'    => 'https://twitter.com/intent/tweet?text=' . self::get_share_title($id) . ' via @TheBodEdit &mdash; &url=' . $permalink,
            'pinterest'  => false,
            'envelope'   => 'mailto:?subject=' . self::get_share_title($id) . '&body=I thought you might like this ' . $permalink . '',
            'whatsapp'   => 'https://api.whatsapp.com/send?text=' . $permalink . '"'
        ];

        if ( $image_src ) {
            $social_plat['pinterest'] = 'https://pinterest.com/pin/create/button/?url=' . $permalink . '&description=' . self::get_share_title($id) . '&media=' . $image_src[0];
        }

        /**
         * Output
         */
        if ( $social_plat ):

            echo '<ul class="' . $classes . '">';

            foreach ( $social_plat as $social_network => $social_network_url ) {

                if ( ! $social_network_url ) {
                    continue;
                }

                // Tweak due to fontawesome var
                if ( $social_network === 'envelope' ) {
                    echo '<li class="c-social__item"><a href="' . esc_url( $social_network_url ) . '" class="c-social__link" rel="nofollow" target="_blank"><i class="far fa-' . $social_network . '"></i></a></li>';
                    continue;
                }

                echo '<li class="c-social__item"><a href="' . esc_url( $social_network_url ) . '" class="c-social__link" rel="nofollow" target="_blank"><i class="fab fa-' . $social_network . '"></i></a></li>';

            }

            echo '</ul>';

        endif;

    }
}
