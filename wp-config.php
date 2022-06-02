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
define( 'DB_NAME', 'portfolio' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'exG%?uI( @%l_R~4#/F%KAn->zaT6TgU38ZUxS{2l%d#[9+ h2w8vF:D`GIY$_Sm' );
define( 'SECURE_AUTH_KEY',  'EmP`dH%LcJn?~!>.T o 8|f(yLGU9?k99WIq8A1AcwxgZp,bN2RspaSopQ(J|0;v' );
define( 'LOGGED_IN_KEY',    'YIb;m%7r}OEK~K1d.a<FzT_M./I.G@6}A!Ig tE_@E60?E!wAP9YIG.ZZ:hCOS7c' );
define( 'NONCE_KEY',        '&gv$W`EgaW#Wkbba!%Gln*?c+JbF$2URR)&#rDV|Xd]@[/IH*%tX^b%eI87P5ja?' );
define( 'AUTH_SALT',        '.9&.BFg1Itt;4t4x,N*.gmgdL:<4XCrTIDiFj*a_8%]~HjzK1Hlf8$Vilo1:Zl .' );
define( 'SECURE_AUTH_SALT', '6Fe@YFj3Mchgy111TT8^z=omh*Bhbuv~e`%J]baI-b=#{HXQtY4)T}E4^EB$LotQ' );
define( 'LOGGED_IN_SALT',   '9M!D.[?;4^W|d.J*y<Yn}7x1s@u1qtDHsbhSm)WW5|p_Zv5TEcEl;3A=}g}E9un|' );
define( 'NONCE_SALT',       'kvvm,z*:8.LE^`.|g9wAdz59e4u7c{W{p}dl&SO)o{LN83+dWT}XYxk7Er@D`t#`' );

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
