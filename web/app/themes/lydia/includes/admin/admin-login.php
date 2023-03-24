<?php
/**
 * Add BMAS Branding and Security Enhancements
 * to wp login
 * --------
 * @category Admin
 * @version 1.0
 * @package Lydia/Admin
 */
defined( 'ABSPATH' ) || exit;

// Login Styles
function lydia_login_styles()
{
    echo '<style type="text/css">
    *,
    *:before,
    *:after {
        box-sizing: border-box;
    }
    body.login div#login h1 a {
        background-image: url(' . get_template_directory_uri() . '/includes/admin/img/login-logo-fallback.png);
        background-image: url(' . get_template_directory_uri() . '/includes/admin/img/login-logo.svg);
        color: #fff;
        background-size: 120px;
        background-position: center;
        margin-bottom: 24px;
    }
    body.login,
    html {
        background: #0A0A0A !important;
        text-transform: uppercase;
    }
    body.login div#login form#loginform,
    body.login div#login form#lostpasswordform {
        background: none;
        box-shadow: none;
        margin-top: 0;
        border: none;
    }
    body.login div#login form#loginform label,
    body.login div#login form#lostpasswordform label {
        color: #fff;
        font-size: 0.5rem;
        letter-spacing: 2px;
    }
    body.login div#login form#loginform input,
    body.login div#login form#lostpasswordform input {
        color: #fff;
        font-size: 14px;
        padding: 3%;
        background-color: #212121;
        border-radius: 2px;
        border: 2px solid #212121;
        letter-spacing: 2px;
    }
    body.login div#login form#loginform input#rememberme {
        border: none;
        border-radius: 50%;
    }
    body.login div#login form#loginform input[type=checkbox]:checked:before {
        color: transparent !important;
        margin: 3px 0 0 3px;
        color: #FFFFFF;
        height: 10px;
        width: 10px;
        border-radius: 50%;
        background-color: #fff;
    }
    @media screen and (max-width: 782px) {
        body.login div#login form#loginform input[type=checkbox]:checked:before {
            height: 19px;
            width: 19px;
        }
    }
    body.login div#login form#loginform p.submit input#wp-submit,
    body.login div#login form#lostpasswordform p.submit input#wp-submit {
        padding: 0;
        text-transform: uppercase;
        text-shadow: none;
        letter-spacing: 1px;
        line-height: 1;
        height: auto;
        font-size: 10px;
        padding: 3%;
        box-shadow: none;
        border-radius: 0;
    }
    body.login div#login form#loginform p.submit input#wp-submit {
        width: 50%;
        border: none;
        border-radius: 2px;
        background: #0F8BCC;
        font-weight: bold;
    }
    body.login div#login form#loginform p.submit input#wp-submit:hover {
        background: #43db2a;
    }
    body.login div#login p#nav {
        display: none;
    }
    body.login div#login p#backtoblog a {
        font-size: 10px;
        color: #fff;
        letter-spacing: 2px;
    }
    body.login #login_error {
        border-left: none;
        background: #dd3d36;
        color: #fff;
        font-size: 10px;
        box-shadow: none;
        text-align: center;
        padding: 2%;
    }
    body.login #login_error a {
        display: block;
        text-decoration: none;
        color: #0A0A0A;
    }
    body.login #login_error br {
        display: none;
    }
    body.login div#login p.message {
        background: none;
        color: #fff;
        font-size: 10px;
        border-left: 0;
        text-align: center;
        margin-bottom: 0;
    }
    body input:-webkit-autofill,
    body input:-webkit-autofill:focus {
        -webkit-box-shadow: 0 0 0 50px #212121 inset;
        -webkit-text-fill-color: #FFF;
    }
    body .privacy-policy-link {
        text-decoration: none;
        font-size: 8px;
        font-weight: bold;
        letter-spacing: 2px;
        color: #565656;
    }

    body .privacy-policy-link:hover,
    body .privacy-policy-link:focus {
        color: white;
    }
    </style>';
}

add_action( 'login_head', 'lydia_login_styles' );

// Login Logo Link
function lydia_login_logo_url()
{
    return home_url();
}

add_filter( 'login_headerurl', 'lydia_login_logo_url' );

// Login Logo Tooltip
function lydia_change_title_login_logo()
{
    return 'Return to ' . get_bloginfo( 'name' ) . '';
}

add_filter( 'login_headertext', 'lydia_change_title_login_logo' );

// Remove Login Shake
function lydia_remove_login_shake()
{
    remove_action( 'login_head', 'wp_shake_js', 12 );
}

add_action( 'login_head', 'lydia_remove_login_shake' );

/**
 * Fix for Auth Login Wrapper
 * --------
 * @version 1.0.0
 */
function lydia_auth_admin_login_styles()
{
    echo '<style>
            body #wp-auth-check-wrap #wp-auth-check {
                background-color: #0A0A0A;
            }
        </style>';
}

add_action( 'admin_head', 'lydia_auth_admin_login_styles' );
