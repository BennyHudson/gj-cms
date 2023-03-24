<?php
/**
 * Dump to Console
 * --------
 * Accepts multiple variables
 *
 * @category Util
 * @version 1.0
 * @package Lydia
 */
namespace BMAS\Util;

defined( 'ABSPATH' ) || exit;

class Console
{
    /**
     * Pass multiple args to the log function above and this dumps out a nice log (pun not intented)
     * basically makes it do what a regular js console log would look like if you pass muliple arguments
     * @param $args
     * @return string
     */
    public static function implode( $args )
    {
        $results = [];

        foreach ( $args as $arg ) {
            $results[] = wp_json_encode( $arg, JSON_PARTIAL_OUTPUT_ON_ERROR, 10 );
        }

        return implode( ',', $results );
    }

    public static function log()
    {
        return '<script>console.log(' . self::implode( func_get_args() ) . ')</script>';
    }
}
