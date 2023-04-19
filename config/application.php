<?php
/**
 * Your base production configuration goes in this file. Environment-specific
 * overrides go in their respective config/environments/{{WP_ENV}}.php file.
 *
 * A good default policy is to deviate from the production config as little as
 * possible. Try to define as much of your configuration in this file as you
 * can.
 */

use Roots\WPConfig\Config;

/**
 * Directory containing all of the site's files
 *
 * @var string
 */
$root_dir = dirname( __DIR__ );

/**
 * Document Root
 *
 * @var string
 */
$webroot_dir = $root_dir . '';

/**
 * Use Dotenv to set required environment variables and load .env file in root
 */
$dotenv = Dotenv\Dotenv::createUnsafeImmutable( $root_dir );
if ( file_exists( $root_dir . '/.env' ) ) {
    $dotenv->load();
    $dotenv->required( ['WP_HOME'] );
    $dotenv->required( ['DB_NAME', 'DB_USER', 'DB_PASSWORD'] );
}
/**
 * Set up our global environment constant and load its config first
 * Default: production
 */
define( 'WP_ENV', getenv( 'WP_ENV' ) ?: 'production' );

/**
 * URLs
 */
Config::define( 'WP_DIR', '/wordpress' );
Config::define( 'WP_HOME', getenv( 'WP_HOME' ) );
Config::define( 'WP_SITEURL', getenv( 'WP_HOME' ) . Config::get( 'WP_DIR' ) );

/**
 * Custom Content Directory
 */
Config::define( 'CONTENT_DIR', '/wp-content' );
Config::define( 'WP_CONTENT_DIR', $webroot_dir . Config::get( 'CONTENT_DIR' ) );
Config::define( 'WP_CONTENT_URL', Config::get( 'WP_HOME' ) . Config::get( 'CONTENT_DIR' ) );

/**
 * Custom Uploads Directory
 */
Config::define( 'UPLOADS_FOLDER', getenv( 'UPLOADS_FOLDER' ) ?: 'uploads' );

/**
 * DB settings
 */
Config::define( 'DB_NAME', getenv( 'DB_NAME' ) );
Config::define( 'DB_USER', getenv( 'DB_USER' ) );
Config::define( 'DB_PASSWORD', getenv( 'DB_PASSWORD' ) );
Config::define( 'DB_HOST', getenv( 'DB_HOST' ) ?: 'localhost' );
Config::define( 'DB_CHARSET', 'utf8mb4' );
Config::define( 'DB_COLLATE', 'utf8mb4_unicode_520_ci' );
$table_prefix = getenv( 'DB_PREFIX' ) ?: 'wp_';

/**
 * Authentication Unique Keys and Salts
 */
Config::define( 'AUTH_KEY', getenv( 'AUTH_KEY' ) );
Config::define( 'SECURE_AUTH_KEY', getenv( 'SECURE_AUTH_KEY' ) );
Config::define( 'LOGGED_IN_KEY', getenv( 'LOGGED_IN_KEY' ) );
Config::define( 'NONCE_KEY', getenv( 'NONCE_KEY' ) );
Config::define( 'AUTH_SALT', getenv( 'AUTH_SALT' ) );
Config::define( 'SECURE_AUTH_SALT', getenv( 'SECURE_AUTH_SALT' ) );
Config::define( 'LOGGED_IN_SALT', getenv( 'LOGGED_IN_SALT' ) );
Config::define( 'NONCE_SALT', getenv( 'NONCE_SALT' ) );

/**
 * Custom Settings
 */
Config::define( 'AUTOMATIC_UPDATER_DISABLED', true );
Config::define( 'DISABLE_WP_CRON', getenv( 'DISABLE_WP_CRON' ) ?: false );
// Disable the plugin and theme file editor in the admin
Config::define( 'DISALLOW_FILE_EDIT', true );
// Disable plugin and theme updates and installation from the admin
Config::define( 'DISALLOW_FILE_MODS', true );

/**
 * Debugging Settings
 */
Config::define( 'WP_DEBUG_DISPLAY', false );
Config::define( 'SCRIPT_DEBUG', false );
ini_set( 'display_errors', '0' );

/**
 * Wordpress Settings
 */
/** Set the number of revisions to 0 keeps database lean */
Config::define( 'WP_POST_REVISIONS', false );
/** Enabling the "Trash" Feature for Media Files - original delete files */
Config::define( 'MEDIA_TRASH', false );
Config::define( 'WPLANG', 'en_GB' );

/**
 * Memory Settings
 */
Config::define( 'WP_MEMORY_LIMIT', '128M' );
Config::define( 'WP_MAX_MEMORY_LIMIT', '256M' );

/**
 * Allow WordPress to detect HTTPS when used behind a reverse proxy or a load balancer
 * See https://codex.wordpress.org/Function_Reference/is_ssl#Notes
 */
if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) {
    $_SERVER['HTTPS'] = 'on';
}

$env_config = __DIR__ . '/environments/' . WP_ENV . '.php';

if ( file_exists( $env_config ) ) {
    require_once $env_config;
}

Config::apply();

/**
 * Bootstrap WordPress
 */
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', $webroot_dir . '/wp/' );
}
