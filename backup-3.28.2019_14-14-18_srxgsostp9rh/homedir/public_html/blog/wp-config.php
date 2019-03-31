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
define('DB_NAME', 'i5107646_wp2');

/** MySQL database username */
define('DB_USER', 'i5107646_wp2');

/** MySQL database password */
define('DB_PASSWORD', 'Z.EJ4ZFeS35VMjqsXEv91');

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
define('AUTH_KEY',         'sd0fsxntiLZe93rV4SNPI0MPldFcRFTBmO6bLMzxhZsGlms2tEoyBU5JSPAddRuN');
define('SECURE_AUTH_KEY',  'et2Y2YGD5SEYP5LTqj6xSUVkJRAEoWLsfe5D8g1n3gUQpifW8AUjKDEa77R8cx3d');
define('LOGGED_IN_KEY',    'FiHPKi81JiRG0DugNbHTqHXVBqFE1nRzr2m1t5rFNmwiJRMNH91BZt9aH7oMamws');
define('NONCE_KEY',        'op2q9ihXVqkAchsDdCrYXG3vz3bs0yI9FZPH9TkA9i04Z7HmTjVTI0vbDQhpqmgL');
define('AUTH_SALT',        'Shnjs6cz7tXpnmIehYDlpqJyeUv4Cp07Ap6Jr6jqHY3ka9y1WZbOq4K4rqXJEbLs');
define('SECURE_AUTH_SALT', '67twU91bUyPC8kmKXTiCg7RGDHT3KYe9tL1TaUVB1OUK5n1EXp0MrMPkOjd8NuHA');
define('LOGGED_IN_SALT',   'OQOmIfTkqp4L8pBNwsjErT5IMbCjNFk1LwOykWYaJeE7imjWfUNE6SwRgL0NU8RI');
define('NONCE_SALT',       'OrsR0oOoFcGkN6IldqEmQjQHjWZ7F9bN1VlJdJKF7UrC1aahpoQWuP3T3jqC2yCv');

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
