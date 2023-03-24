<?php
/**
* Disable Gravity forms admin notifcation
* --------
* @package GJ
* @since GJ 3.0
*/
add_filter( 'gform_disable_notification', 'gf_disable_notification', 10, 4 );
function gf_disable_notification( $is_disabled, $notification, $form, $entry ) {
    return true;
}
