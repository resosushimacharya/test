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
define('DB_NAME', 'carpetcall');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'webaits$567');

/** MySQL hostname */
define('DB_HOST', '192.168.0.28');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'utYyR2T03Ykek`w}I3>tCuW:$HuVL61>uKlRFesC}2 xNmPjx7-2.K:~S)r&Y1D,');
define('SECURE_AUTH_KEY',  '*`^(EB-ar`8LCp:Jb1&o96Dlsm*v(O.:y~pdccI]dsNCj!Yc..K*w=V? eONHaGk');
define('LOGGED_IN_KEY',    'B.]p$Y.|P?@x9u5 r@b>(& x]]6kOX)Y~J~r-Y|C SrNPA63GWmZ%%kzow`6=V|~');
define('NONCE_KEY',        '[P2l}BX-K5L],O5)xU8WPk86i`X|a=+`:a`f@FmAz{_R}9?WZ+,@ZB+(4zCt`p,*');
define('AUTH_SALT',        'aII+/f(qW&.%z(/+jE^jA)P9,ajvR@aND%}-sg6]<TY1PZeZqS`8IW5_.5PFU*o:');
define('SECURE_AUTH_SALT', 'abSeVjvcfRUV=Ft[Wsx^Cgx>BGZ?DCxBttc|k97Nn|uZg_q+p`WR/aH|??ca{^sB');
define('LOGGED_IN_SALT',   'qXxZ2r_B.^T!u8a^j7>e<Q5wQCr3TpSANK;C/[!X]!MYjgVze3WZLJg/ef^FY,%:');
define('NONCE_SALT',       '9t$iQ(&i$[w>wJh{}-lgdi+6J)#w]8`s-bR_#/CGGbnwkxd`cf*RajAe3oVZ9X2o');

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
