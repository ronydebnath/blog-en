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
define('DB_NAME', 'blog-en');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'm]d19B&;|pKUYd4=hIM$@O.PYaZ@SJ-je%qhi)Mm_(5TIj!D7]VuQ&u&nKl%4TZ1');
define('SECURE_AUTH_KEY',  't#nUtOjgM$IJ8~V!.]z>w-9 <$v~<%67YQFCsaC~FOPwhOK@.xo-h$e}PJD?,/!r');
define('LOGGED_IN_KEY',    'fd7]x`}Lls;nsEY6wT*rf2NJ0+Tx>b&},lD2K]_W4yjr@!:bnJ-tiajrih]e:!m:');
define('NONCE_KEY',        'hj0%ZGp0[2tyXUR){@~vR]0JXm#p}sk2!$%on*rN<xT UA)w,FNhuPF+LQ(;HDn#');
define('AUTH_SALT',        'MjX<#P#Pef^Dy/ld>n+&;F5 y_g`Ivza7@?ToC-c%:3kg}D4kYlPZVj`Z ,rGq-u');
define('SECURE_AUTH_SALT', '!Zpo26ABISf^v,:1VL1^C{PloqQt8wwFc5B4=0d.A{[/).8DNi=BkqDto_HRbM$Y');
define('LOGGED_IN_SALT',   'u<H0+o0L-@ShpmL`mB7lIH:YLDnyjL6QB`ww9uR*(Z)zQi*xQO$![onATi8IZ33Z');
define('NONCE_SALT',       '&n=`KD^-~{^cbt_J`Fl6;kc7 >zq]Y_Yj<4P.0(^qmUbv7`&wXQw<r(DSmlcQ3_h');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'amjben_';

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

