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
define('DB_NAME', 'i5107646_wp6');

/** MySQL database username */
define('DB_USER', 'i5107646_wp6');

/** MySQL database password */
define('DB_PASSWORD', 'R.Az8zsUHA4DdENFRBb49');

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
define('AUTH_KEY',         '6PSGnbl6De1Tomi4sq5ud3FaowaEdECO3f6mc8nCRd5LpZRUQkFeUlPYya4suI1E');
define('SECURE_AUTH_KEY',  'Ip4Ys8tapEXSyD1H5b7vSNTyIX9rQPNUcE4fDnRDxVfLElR1RFbCWycEliXc5KMS');
define('LOGGED_IN_KEY',    'gLwwp0DWx2X2AF8L2IgcYPrOBvhn2uLoN0tX8V3Qeo883eKVBy0mrT1ckibkgTl0');
define('NONCE_KEY',        'VFWwH3jdo17VUYUq8QzCqazM46z2rvDBuVPhh0kNslJxsLFScaVcXAp8BL69nlVZ');
define('AUTH_SALT',        'DCCyZrwaRfh3ToXVCzPwbjNjIqXw7631Zxxw1btH5pviE1ugfoFK0OmTpMjmQyhC');
define('SECURE_AUTH_SALT', 'wnH7Nnb0D754KyJhFB8csp2k0zUjKBVJ5Ia2Yj9nh1pvSmT4kU94wKRcgPJAYysF');
define('LOGGED_IN_SALT',   'UAeNbHBkj5nfxUieuXFeIv084qNLtlW2SRqZea1NRl2vx8uVG8d7KNEXSzMB83Z1');
define('NONCE_SALT',       'ZpCSokgN0jbxigm4Xrqu05israHhoZCXgiqKbqX09RYTWBxNAjBQxMuZZc8zRAHi');

/**
 * Other customizations.
 */
define('FS_METHOD','direct');define('FS_CHMOD_DIR',0755);define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');

/**
 * Turn off automatic updates since these are managed upstream.
 */
define('AUTOMATIC_UPDATER_DISABLED', true);


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

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
