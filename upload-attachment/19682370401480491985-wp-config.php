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
define('DB_NAME', 'cleanstatedbnew');

/** MySQL database username */
define('DB_USER', 'cleanstatedbnew');

/** MySQL database password */
define('DB_PASSWORD', 'Oct@1379');

/** MySQL hostname */
define('DB_HOST', '68.178.217.52');

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
define('AUTH_KEY',         'c;pS.{L<_NRar13(1V,+5G@*,q=4Q?@X>.qfF]O~?iu~<UV;<$,Fx=}>s_TT99cZ');
define('SECURE_AUTH_KEY',  'U%f%L(BG0H79#Ryk$f+UOhp{maB#k`4oZq OZTq.TFL{0#2_8*]2N3WRN2EB9Yzs');
define('LOGGED_IN_KEY',    'cwG^J -bN0.^>yyS}}bw;ANMZ6m:VU~_raEMGmqhPiKyV.5.!>lp|~Op}3?gq!iB');
define('NONCE_KEY',        '1;=`O;j^OkYM-|:RL.b/!*-eeSJ$xX;$V;)qli>>zhI*%zC;R) @@X7Ly^rH(v_1');
define('AUTH_SALT',        'k^ gzd#%*O9z>(Tz$G8#1fhW%7~P8Atw|)SgF[^1?sF_E*# X?VE>$V$5>4u^TM-');
define('SECURE_AUTH_SALT', 'Ka#C^bNjQ|waFotJ2l:f|jUO.6xPlxW%qWMkuMjk,@2Kmf]dq]h%gj[X0XD8oS6o');
define('LOGGED_IN_SALT',   'LLoqJxXeMXxSchck]Ut]Q#9jF|bR2:p~,&Guo2On`S[ A(~=Ui}jw@S@3`ZhfZw0');
define('NONCE_SALT',       'bf$1lCU.w}bhV-!7gP.008_<!?SUNz}AFB_J1Lju&d d9jbze:HYTr;$1^^.%;bz');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'cs_';

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
