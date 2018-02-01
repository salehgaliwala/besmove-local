<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'besmove');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', '84cb5f05bafbb9fb2d8cdac94958bc8d2ba27529493146335696de95da982966');
define('SECURE_AUTH_KEY', 'cc74e0ed85408ea310e550f17941a3a9ca8f08e5a7f4463a5cc5274a4bfb21d9');
define('LOGGED_IN_KEY', 'd810e63d5c216d661b6d15c4b75ef5bb16d95bce0a52e2a78613b08e0df138a1');
define('NONCE_KEY', 'c4f3cc56afdf45452387b298b9314ae75175e719e005105acc15b5966b97e20c');
define('AUTH_SALT', '950cd8cad7449aff63d70a3f94e421f8174eeb5270fcbb36b9e3a39d6d749074');
define('SECURE_AUTH_SALT', '381613a844f76ff7d820f07957dbeeaa27868a14c92dfb98b06766feac5bc333');
define('LOGGED_IN_SALT', 'ab17b3f33293bb4a1fccb58ab83c109e4859189217414c861f31a9ab712e2da4');
define('NONCE_SALT', '14beaf45c7b4082201a610c1db95a01ff038800cddffe25357a2e50ef8e3f660');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */
/**
 * The WP_SITEURL and WP_HOME options are configured to access from any hostname or IP address.
 * If you want to access only from an specific domain, you can modify them. For example:
 *  define('WP_HOME', 'http://www.besmove.com');
 *  define('WP_SITEURL', 'http://www.besmove.com');
 *
*/

define('WP_SITEURL', 'http://www.besmove.com');
define('WP_HOME', 'http://www.besmove.com');


/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

define('WP_TEMP_DIR', ABSPATH . 'wp-content/');


define('FS_METHOD', 'direct');


//  Disable pingback.ping xmlrpc method to prevent Wordpress from participating in DDoS attacks
//  More info at: https://docs.bitnami.com/?page=apps&name=wordpress&section=how-to-re-enable-the-xml-rpc-pingback-feature

// remove x-pingback HTTP header
add_filter('wp_headers', function($headers) {
    unset($headers['X-Pingback']);
    return $headers;
});
// disable pingbacks
add_filter( 'xmlrpc_methods', function( $methods ) {
        unset( $methods['pingback.ping'] );
        return $methods;
});
add_filter( 'auto_update_translation', '__return_false' );
