<?php
define('WP_CACHE', true); // Added by WP Rocket
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
define('AUTH_KEY',         ',dSK]^^hCw6uxPo6T1y=~%iFI76XN5_F_XW#znRn:`dkUq#`?Kr$94funxGC!nt)');
define('SECURE_AUTH_KEY',  'k((aJM#%VD4V(!CS4.ZJbxF}ecF3OZnFW^Vj+VQ.Z/^6:r~64y0PevD^[+7sVqjX');
define('LOGGED_IN_KEY',    'NX^Mx24qUO[R2b`H&xy+@@Gj)0ve_M#[[qc/F+)@3rAc^YZ7T@$Qv6x`_@.*7m^k');
define('NONCE_KEY',        'Tbs_#A0|fx&E&*~OCX@W*(cm;8:o0fMgV^%SNrP]aDp+WRfB.irsXrRjn;r/.Ur@');
define('AUTH_SALT',        'H**gKLI.`9h.g},2<iOU~4%EvrFgjv=%,^KnM#bOA9am^GhT7^.(yCtbO=1I<Y=+');
define('SECURE_AUTH_SALT', 'z#?ZylXej+NR`r:t##RZ2NmvcMW!} PX>0umFf;qWqx~{01?X]OEemB(5kabHYMs');
define('LOGGED_IN_SALT',   '<b(&Yh #y7!-y*D3*{9J,;Si[< 3|287o=YoKe{TPIY[~w %yqJ6|l.xc]qqZ<8(');
define('NONCE_SALT',       '%WL9`9>E$0G1o8|3c`Wh,(k|W.e^$t%4*rvwS5Lx;4g6ZGuf!1 DLw6q{mt QeQj');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'as_';

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
//define('DISABLE_WP_CRON', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
