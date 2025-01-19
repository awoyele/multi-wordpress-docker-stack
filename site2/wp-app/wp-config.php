<?php
/** WordPress Database Configuration */

define( 'DB_NAME', $_ENV['WORDPRESS_DB_NAME'] );
define( 'DB_USER', $_ENV['WORDPRESS_DB_USER'] );
define( 'DB_PASSWORD', $_ENV['WORDPRESS_DB_PASSWORD'] );
define( 'DB_HOST', $_ENV['WORDPRESS_DB_HOST'] );
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

/** Authentication Unique Keys and Salts */
define('AUTH_KEY',         'site2_unique_key_1_change_this');
define('SECURE_AUTH_KEY',  'site2_unique_key_2_change_this');
define('LOGGED_IN_KEY',    'site2_unique_key_3_change_this');
define('NONCE_KEY',        'site2_unique_key_4_change_this');
define('AUTH_SALT',        'site2_unique_salt_1_change_this');
define('SECURE_AUTH_SALT', 'site2_unique_salt_2_change_this');
define('LOGGED_IN_SALT',   'site2_unique_salt_3_change_this');
define('NONCE_SALT',       'site2_unique_salt_4_change_this');

/** WordPress Database Table prefix */
$table_prefix = 'wp_site2_';

/** For developers: WordPress debugging mode. */
define( 'WP_DEBUG', false );

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
