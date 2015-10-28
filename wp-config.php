<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
//define('DB_NAME', 'db578329536');
//define('DB_NAME', 'db582749724');
define('DB_NAME', 'dosnoventa');

/** MySQL database username */
//define('DB_USER', 'dbo582749724');
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'eerahgha');
//define('DB_PASSWORD', 'dosnoventa2');

/** MySQL hostname */
define('DB_HOST', '127.0.0.1:13312');

//define('DB_HOST', 'db582749724.db.1and1.com');
//define('DB_HOST', 'db578329536.db.1and1.com');


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
define('AUTH_KEY',         'nD^spSLu|tl{T6V-<=jo-ZbBp nU.Z] _-?Z|%n8=lkc<&31|[XaHbnY.I1r=YSV');
define('SECURE_AUTH_KEY',  'd<{j+[278;Z(s9[,_NY-[G`u+_bP2}S=3tNwhRmK}:_-./3240bQ8AR ;z~CGstU');
define('LOGGED_IN_KEY',    '|p_|mqUH2R60`LO4L&P}xLkB<HQ~bbJwr(WrlURO+F*#iW=0S3pEb5SM)+K<~-sE');
define('NONCE_KEY',        'vql]sZ@P->*IRG)(|L/jny`>p )R=9]z.C1pY3@0KRt3-[+o,4VK7qCJ=QzPk}^&');
define('AUTH_SALT',        'cgc@L^[lyx|!(uE)9AKTbRI]$<ywT9?DO*.<r^2z:!i%4OoFil-bV4&2p#U/swXv');
define('SECURE_AUTH_SALT', '|Hs$bU`wEL/<Y=ic73)gb++5fap]o}P-Dfb#`T}S3]b:h;zJjJ`%y@{9-3ZmNf6$');
define('LOGGED_IN_SALT',   '~yNL9yMqz<IsLis2|9=/BW1LxFS!Z:$]YLZB*A2p&y #Jiv8=4GWlZ2H3NRAnQr%');
define('NONCE_SALT',       'r_8YQtodJ?{^%9W4v1+*.{:4n)+N&)U{|##j@zPeTuj8WOIF>/PZoB4w.Q9=~TQ3');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'dn2_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
