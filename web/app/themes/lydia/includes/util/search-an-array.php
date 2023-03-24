<?php
/**
*  Search and Array and Match Items
*  ------
*  @package Lydia
*  @since Lydia 1.0
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function in_array_any($needles, $haystack) {

    if ($haystack && $needles) {
        if ( array_intersect($needles, $haystack) ) {
            return true;
        } else {
            return false;
        }
    }
}
