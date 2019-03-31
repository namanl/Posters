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
define('DB_NAME', 'i5107646_wp5');

/** MySQL database username */
define('DB_USER', 'i5107646_wp5');

/** MySQL database password */
define('DB_PASSWORD', 'C.HwkymZVZmb29g911S98');

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
define('AUTH_KEY',         '1bZl40qkUc1Ifk5jJ6AV9meYcQ7arPGyp5wduDhbVnViwpRyODuJL2ssJGr4p0oU');
define('SECURE_AUTH_KEY',  's7swJA6ijf8CNUCqLxp1g7hEuBphz3TRFp929Kgqo8fcom3kozdcrPeo7DbP9IyJ');
define('LOGGED_IN_KEY',    'SLMumACK4Dly2fexz9XMr07iTkpHNqjDIJJv23lzMJBMNJFYgRaJblHRxGi5w334');
define('NONCE_KEY',        'DSuU6UtoEGPJzszSlNAyhW0fP3cperh7K769w7cBilutZS5z9hHA3rcUsvHEXgGM');
define('AUTH_SALT',        '9BWOSvAyBPAmzGvriE4mzBzzIWEdz3BmKtGjEap9mpAfvuadFcrYsHQ5rSilYKsr');
define('SECURE_AUTH_SALT', '4Ju8RWcJleetYIEGpHEjsVY3RYl60hKvmAQi1drVGRMVWbT7hHfvw7YTohgsnGAy');
define('LOGGED_IN_SALT',   'sadj1JUBdlJel6lQ1PTgdkpvQCUQKOeiymwl02rc2v2QvukgB2Q6upE6uKqREB0h');
define('NONCE_SALT',       '9sqxVNBPh00MfJnkLyZBRgBxeaYIC4ZVBqZ9KIQjD0ZkpooNEAlSoN7MgfHSsTrT');

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
