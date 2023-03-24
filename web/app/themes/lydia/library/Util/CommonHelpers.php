<?php
/**
 * Common Helpers
 * --------
 * @category Helpers
 * @version 1.0
 * @package Lydia
 */
namespace BMAS\Util;

defined( 'ABSPATH' ) || exit;

use Timber as Timber;

class CommonHelpers
{

    public static function isAjax()
    {
        return defined( 'DOING_AJAX' ) && DOING_AJAX;
    }

    public static function copyright($date)
    {
        $date ?: date( 'Y' );
        $fromYear = $date;
        $thisYear = (int) date( 'Y' );
        $output   = $fromYear . (  ( $fromYear != $thisYear ) ? '-' . $thisYear : '' );
        echo $output;
    }

    /**
     * @param $input
     */
    public static function minify( $input )
    {
        $search = [
            '/(\n|^)(\x20+|\t)/',
            '/(\n|^)\/\/(.*?)(\n|$)/',
            '/\n/',
            '/\<\!--.*?-->/',
            '/(\x20+|\t)/', # Delete multispace (Without \n)
            '/\>\s+\</', # strip whitespaces between tags
            '/(\"|\')\s+\>/', # strip whitespaces between quotation ("') and end tags
            '/=\s+(\"|\')/']; # strip whitespaces between = "'

        $replace = [
            "\n",
            "\n",
            ' ',
            '',
            ' ',
            '><',
            '$1>',
            '=$1'];

        $output = preg_replace( $search, $replace, $input );

        return $output;
    }

    /**
     * @param $args
     * @return mixed
     */
    public static function get_category_tags( $args )
    {
        global $wpdb;
        $prefix = $wpdb->prefix;
        $tags   = $wpdb->get_results
            ( '
            SELECT
                DISTINCT terms2.term_id as tag_id,
                terms2.name as tag_name,
                null as tag_link
            FROM
                ' . $prefix . 'posts as p1
                LEFT JOIN ' . $prefix . 'term_relationships as r1 ON p1.ID = r1.object_ID
                LEFT JOIN ' . $prefix . 'term_taxonomy as t1 ON r1.term_taxonomy_id = t1.term_taxonomy_id
                LEFT JOIN ' . $prefix . 'terms as terms1 ON t1.term_id = terms1.term_id,
                ' . $prefix . 'posts as p2
                LEFT JOIN ' . $prefix . 'term_relationships as r2 ON p2.ID = r2.object_ID
                LEFT JOIN ' . $prefix . 'term_taxonomy as t2 ON r2.term_taxonomy_id = t2.term_taxonomy_id
                LEFT JOIN ' . $prefix . "terms as terms2 ON t2.term_id = terms2.term_id
            WHERE
                t1.taxonomy = 'category'
                AND p1.post_status = 'publish'
                AND terms1.term_id IN (
                " . $args . "
                )
                AND t2.taxonomy = 'post_tag'
                AND p2.post_status = 'publish'
                AND p1.ID = p2.ID
            ORDER by
                tag_name
        " );
        $count = 0;

        foreach ( $tags as $tag ) {
            $tags[$count] = new Timber\Term( $tag->tag_id );
            ++$count;
        }

        shuffle($tags);

        return $tags;
    }
}
