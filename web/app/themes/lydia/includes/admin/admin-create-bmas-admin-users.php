<?php
/**
 * Create BMAS Admin Users
 * --------
 * @category Admin
 * @version 1.0
 * @package Lydia/Admin
 */
defined( 'ABSPATH' ) || exit;

function lydia_create_bmas_admin_user( $users = [] )
{

    if ( is_admin() ) {

        foreach ( $users as $key => $userdata ) {

            // Check if the user exists
            $userID = email_exists( $userdata['user_email'] );

            if ( ! $userID ) {

                // Create the User
                $user = wp_insert_user( $userdata );

                // Set the user role
                $newUser = new WP_User( $user );
                $newUser->set_role( 'administrator' );

                // Email New User if Successful
                if ( ! is_wp_error( $user ) ) {
                    wp_mail(
                        $userdata['user_email'],
                        'User Setup -' . get_bloginfo( 'name' ) . '',
                        'Your Password: ' . $userdata['user_pass'] );
                }

            } else {

                // If user exists update
                update_user_meta($userID, 'ID', $userID);
                update_user_meta($userID, 'first_name', $userdata['first_name']);
                update_user_meta($userID, 'last_name', $userdata['last_name']);
                update_user_meta($userID, 'description', $userdata['description']);
                update_user_meta($userID, 'locale', 'en_GB');

            }
        }
    }
}

// BMAS Admin Users
$users = [

    [
        'user_email'    => 'alexander@bmas.agency',
        'user_login'    => 'Alexander BMAS',
        'user_pass'     => wp_generate_password( 16, false ),
        'user_nicename' => 'Alexander BMAS',
        'user_url'      => 'https://bmas.agency',
        'display_name'  => 'Alexander BMAS',
        'first_name'    => 'Alexander',
        'last_name'     => 'Hawkings-Byass',
        'description'   => 'Founder and Director of BMAS',
        'locale'        => 'en_GB'
    ],

    [
        'user_email'    => 'support@bmas.agency',
        'user_login'    => 'Support BMAS',
        'user_pass'     => wp_generate_password( 16, false ),
        'user_nicename' => 'Support BMAS',
        'user_url'      => 'https://bmas.agency',
        'display_name'  => 'Support BMAS',
        'first_name'    => 'Support',
        'last_name'     => 'BMAS',
        'description'   => 'BMAS Support User',
        'locale'        => 'en_GB'
    ]

];

lydia_create_bmas_admin_user( $users );
