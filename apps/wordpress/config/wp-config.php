<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
#define( 'DB_NAME', 'wp_db' );

/** Database username */
#define( 'DB_USER', 'wp_user' );

/** Database password */
#define( 'DB_PASSWORD', 'wp_pass' );

/** Database hostname */
#define( 'DB_HOST', '172.18.0.2' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */

define('AUTH_KEY',         'S!**E]+P|l=cNP;u,5X)r=-pFxk#mkCS_JdKRJUm,IIT63T9F])4<Ql%ptt;F7tR');
define('SECURE_AUTH_KEY',  'WJNYW>a/;w9`8(shC?D(b[T*$]D0MuqQ;*+k#BS}61tT6I>D[]0|S]/Ku 7h7wXS');
define('LOGGED_IN_KEY',    'lT%I+]0//Lr~|JoK9jCT~WD/w5WGE;}WjCc-V5]J>qLr-sbx)/J730&4@aixpE+&');
define('NONCE_KEY',        '%$G9!Mo 8 R=,uBZJ/wbO#rb0=qMPEH4[]4+S`DD-|Y-ZC~G8mY%A?IWDhMy$~n~');
define('AUTH_SALT',        'EB9c+o-,L#d#We+gj[R5]UBKV_|gVGL7|4v/e!jzWA||LUW-L#I-@w;{/IeQI<W#');
define('SECURE_AUTH_SALT', '|a`VE,fN#Ms:aC+U%rYOkKH4F9:|ucfb (d0W]|S,KsX,[I6|+$UTLU JeWt$4}O');
define('LOGGED_IN_SALT',   't&8+6qhnaDF;7cTP[|RWc}rpWo(KSo!GGOP| *g)Vy,*e(|$M5L&P%m6)C+(V2Rp');
define('NONCE_SALT',       'GqAUp_z!cIyydoW}_3rCF:97|_hH_@`m(/n^#~6E>>`* e#eavOb^vlZ>Ed,,SVk');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
