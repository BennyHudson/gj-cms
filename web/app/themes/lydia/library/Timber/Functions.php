<?php
/**
 * Timber Functions
 * --------
 * @category Timber
 * @version 1.0
 * @package Lydia
 */

namespace BMAS\Timber;

defined('ABSPATH') || exit;

use Twig as Twig;
use BMAS\Helpers\Social as Social;
use BMAS\Util\Console as Console;
use BMAS\Util\CommonHelpers as CommonHelpers;

class Functions
{

    public function __construct() {
        add_filter( 'timber/twig', [__CLASS__, 'add_functions_twig'] );
    }

    public static function add_functions_twig( $twig )
    {
        $twig->addExtension( new Twig\Extension\StringLoaderExtension() );

        /**
         * Console Dump for Timber Var
         */
        $twig->addFunction( new Twig\TwigFunction( 'console', function () {
            echo Console::log( func_get_args() );
        }));

        /**
         * CompClass
         */
        $twig->addFunction( new Twig\TwigFunction( 'component', function ($class = null) {
            return $class ? ' ' . $class : '';
        }));

        /**
         * Preg Find
         */
        $twig->addFunction( new Twig\TwigFunction( 'preg_grep', function (
            $str,
            $haystack
        ) {
            return preg_grep( '/' . $str . '/', $haystack );
        }));

        /**
         * Find Items in an Array
         */
        $twig->addFunction( new Twig\TwigFunction( 'arr_find', function (
            $key,
            $haystack
        ) {
            foreach ( $haystack as $arr ) {
                if ( array_key_exists( $key, $arr ) ) {
                    return $arr[$key];
                }
            }

            return false;
        }));

        /**
         * Preg
         */
        $twig->addFilter( new Twig\TwigFilter( 'preg', function (
            $str,
            $from,
            $to
        ) {
            return preg_replace( $from, $to, $str );
        }));

        /**
         * Preg Matches
         */
        $twig->addFunction( new Twig\TwigFunction( 'preg_match', function (
            $regexp,
            $input
        ) {
            preg_match( $regexp, $input, $matches );

            return $matches;
        }));

        /**
         * Preg Replace
         */
        $twig->addFunction( new Twig\TwigFunction( 'preg_replace', function (
            $input,
            $regexp,
            $replacement
        ) {
            $count = null;

            return preg_replace( $regexp, $replacement, $input, -1, $count );
        }));

        /**
         * Return Domain Hostname
         */
        $twig->addFunction( new Twig\TwigFunction( 'parse_url', function ( $input ) {
            $hostname = parse_url( $input, PHP_URL_HOST );

            return preg_replace( "/^([a-zA-Z0-9].*\.)?([a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9]\.[a-zA-Z.]{2,})$/", '$2', $hostname );
        }));

        // Copyright
        $twig->addFunction( new Twig\TwigFunction( 'copyright', function ( $date = null ) {
            CommonHelpers::copyright($date);
        }));

        // Social Follow
        $twig->addFunction( new Twig\TwigFunction( 'socialFollow', function ( $class = null ) {
            $social = new Social();
            $social->follow( $class );
        }));

        // Social Share
        $twig->addFunction( new Twig\TwigFunction( 'socialShare', function (
            $id = null,
            $class = null,
            $styles = 'light'
        ) {
            $social = new Social();
            $social->share( $id, $class, $styles );
        }));

        // Icon
        $twig->addFunction( new Twig\TwigFunction( 'icon', function (
            $type = 'far',
            $icon = null,
            $class = null
        ) {
            return '<i class="c-icon '. $type .' fa-'. $icon .' '. $class .'"></i>';
        }));

        // Icon
        $twig->addFunction( new Twig\TwigFunction( 'wrap', function (
            $string = '',
            $el = 'div'
        ) {
            return '<'. $el .' class="u-wrap">'. $string .'</'. $el .'>';
        }));

        $twig->addFunction( new Twig\TwigFunction( 'wrapwords', function (
            $string = ''
        ) {
            // Split on spaces.
            $words = preg_split("/\s+/", $string);
            $wrapped = [];
            foreach ($words as $word) {
                $wrapped[] = '<span>'. $word .'</span>';
            }
            // Re-create the string.
            $output = join(" ", $wrapped);

            return $output;
        }));

        $twig->addFunction( new Twig\TwigFunction( 'wrapper', function (
            $modifier = 'default',
            $block = ''
        ) {
            return sprintf( 'o-wrapper o-wrapper--%s %s', $modifier, $block );
        } ) );


        // Get First Post of Category and Return its Image
        $twig->addFunction( new Twig\TwigFunction( 'categoryPostImage', function ( $termID ) {

            if ( ! $termID ) {
                return;
            }

            $args = [
                'post_status'   => 'publish',
                'post_type'     => 'article',
                'numberposts'   => 1,
                'cat'           => $termID,
                'no_found_rows' => true,
                'fields'        => 'ids'
            ];

            $termPost     = new \WP_Query( $args );
            $attachmentID = $termPost ? get_post_thumbnail_id( $termPost->posts['0'] ) : null;
            $image        = $attachmentID ? new \Timber\Image( $attachmentID ) : null;

            return $image;

        } ) );


        return $twig;
    }

}
