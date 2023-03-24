<?php
/**
 * Additional User metadata
 * --------
 * @category Admin
 * @version 1.0
 * @package Lydia/Admin
 */
defined( 'ABSPATH' ) || exit;

// Add additional Contact info options
function lydia_user_more_details( $contactmethods )
{
    // Add Facebook
    $contactmethods['facebook'] = 'Facebook';
    // Add Twitter
    $contactmethods['twitter'] = 'Twitter';
    // Add Instagram
    $contactmethods['instagram'] = 'Instagram';
    // Add Google +
    $contactmethods['googleplus'] = 'Google +';
    // Add LinkedIn
    $contactmethods['linkedin'] = 'LinkedIn';

    return $contactmethods;
}

add_filter( 'user_contactmethods', 'lydia_user_more_details', 10, 1 );
