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
define('DB_NAME', 'wordpress');

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
define('AUTH_KEY',         '{/`t8kT](Wcy/s~n7Ni>}28FPjX>Ge82uLQ.m,b%1%F,/}H}*3S*WBBB/#3(iQ+.');
define('SECURE_AUTH_KEY',  'm<?%_Ox(EOxHmg^Y|?|}m;[nT+0*;,zHp8SB^mj)@-Mx!oH$PB,jv!{{-],V*Z&m');
define('LOGGED_IN_KEY',    '%MiLq2Jr^T&ZH<Ghz.E,9d.a6_./A$bSypL,:RFk?:]G,{grp[7Ltw<&k*0R]m;c');
define('NONCE_KEY',        '&+8^+n|AI:-ai|nP_.r4iuH=,MXU)h)iHn]+3rPE3U}s+(g$){oU.Rrd8:Kt#eQi');
define('AUTH_SALT',        'o;KA|$lSavm<gAI`&AITg`4DXL,=g=xGBv&hlcEOd&CkY^WpB7qg0,7&gRq6,Cpl');
define('SECURE_AUTH_SALT', '%Z)?2a-Bh$%CtUAKeq3Q@Tqw *(x-;g=|,gqeC;HB=c:jw3OHmSu}R9jf:Wu_K,4');
define('LOGGED_IN_SALT',   'QW=I}P`3o<HZ-rt+;0=Yfkb(&ts|7fA#JHp,lz8A:(9:q/9?Yi`4fn85`pjK0/>F');
define('NONCE_SALT',       'PMqa=DWuCBuQH2Q.LzjWDw,;cRax1>i/kb0B4ac9QqHdIYF2]%Y4;Lt0eGzM(0pW');

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
