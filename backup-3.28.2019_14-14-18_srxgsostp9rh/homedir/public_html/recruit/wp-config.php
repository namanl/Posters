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
define('DB_NAME', 'i5107646_wp4');

/** MySQL database username */
define('DB_USER', 'i5107646_wp4');

/** MySQL database password */
define('DB_PASSWORD', 'W.enIjq8t3j5ScnL5uC46');

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
define('AUTH_KEY',         'LjI6DRAHUvHvPaoGF5H02WSj0B6DfUhi6dnUSunLyAlutwNfNoeZFhsQ6MgjoWIY');
define('SECURE_AUTH_KEY',  'PORN5kf4urKdrJgKwlRbFB6gs4VxD5t5UuKudIH629pgbR0ldwrFenLbUTynhjAK');
define('LOGGED_IN_KEY',    'nIh3abJuF2FA7QIf1XI9s3LrY22HlStmohYeLGaZc0Am8MnqmgTbxh9sSNApe1g0');
define('NONCE_KEY',        'emak1czcUogi9Zux4LVf9ey7kZHphyggP2SyLOfPzbs1DMJkbasawjKWdj4Kcpri');
define('AUTH_SALT',        'u6yGWQxF0RtkCD5J8TZEVUFyGDPq6zsjNd3y47GmJbkNoOOpoBe0itGbfvHT4LoT');
define('SECURE_AUTH_SALT', 'JqNYCX3EEA8DsVamiX1fJiDSKMxZDgWmcNrqBT2eFKl0wgeg01CuLMPWJkTiX2qi');
define('LOGGED_IN_SALT',   'QkHPP1GbzNShtdeXD82kEFYE6n62089DOUxDFk86dWuVwYKZ6E43jhgM0TLNGpiH');
define('NONCE_SALT',       'OODKq6lhhanxRQWmaA7kbXucAhOe8GI4htYxTT8TxvaLfzAiDZPxuS4XCNV0Sxo8');

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
