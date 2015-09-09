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
define('DB_NAME', 'example_com');

/** MySQL database username */
define('DB_USER', 'admin');

/** MySQL database password */
define('DB_PASSWORD', 'password');

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
define('AUTH_KEY',         'jRC3%D7rU7ams;MX:EqGN|cUsnp-h^@|yk`mUDbG++I[^^q&KoF3Zn00p7d|!/.i');
define('SECURE_AUTH_KEY',  'YTC?Qq?UAK>/?l=;Q;2-8e?5aa)|K-s(o*vcxiJ}SWzTi?SR9/LFX-,> {}iZFr,');
define('LOGGED_IN_KEY',    'FvZE;@$0!Fv8~*boPc,cjMxTxILlg+-QQ2]Uk(-+S94 h:(q1|Ziy6ma}DtGbi9b');
define('NONCE_KEY',        'ZOCF(f.M6B}WAG|@{{ov]e_}=*i9Dp< zLkxxf5,Hi1-%D7lTIN`Z:+xI7swQM_J');
define('AUTH_SALT',        'mtjBE:2NTt/eR<|mJlsc+-icK!)wcJQk]vNe& $8KnNuRd-_>x7z-~kDN.l=N-Q+');
define('SECURE_AUTH_SALT', 'YvmTjk.MuZ$upzk]nkyEAq9Px]*}0p|tLi3gxE%)x@){Z}/F|)3k3Attz17ZQBnW');
define('LOGGED_IN_SALT',   '8kE=Ca{o,@]BhGVpT)ho2wEEIp@81cIjd*#tWv)p]?o_3`3K#$j~@(-#+0}Zf7o+');
define('NONCE_SALT',       '- %8v}+zq|kr-pY;bD}M-><Khs09xX[+b?Qtoy<siQ>p2KbMmmn0@13_Tbk84X!+');

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
