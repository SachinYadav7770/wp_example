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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

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
define( 'AUTH_KEY',         '8QcvKkvSacIL/1&y$tQ@adkS<w4@nl{%9O&hM[ogl||k|KeI>Jt< q4! 6o}*21F' );
define( 'SECURE_AUTH_KEY',  ':aP{2L}l{Y0,y/bZ[8/H[:x;[sjzH5Ar(ni],EZ3 >zoD2DWKH}T/f_!MWVPn[xX' );
define( 'LOGGED_IN_KEY',    'NQE lSnQ],,9)[7Z[=mp~I+O3&0,}W4Zw<Mf`(<?xw &Kb6^_Yhv!R$rMb:e(Z1i' );
define( 'NONCE_KEY',        '?jA3L],1*F@XANuk^;,y)}: wo?_k?H%p-FLDu$c5^D*)vdS~P3%`3&RsyW><!U]' );
define( 'AUTH_SALT',        '<rF#MD1|,3jm;{XlY7>QH07r*NDF@cTenU-sIRQ/K@F9=>o&U9PI. Oa]J$2LlSn' );
define( 'SECURE_AUTH_SALT', '$hG`Y[P;sUCVd]e._!vQw:qU+] Q;y1X=sSL99@^!(dE% 7a]`rv+jUtX;:`Vj*J' );
define( 'LOGGED_IN_SALT',   '=_~@QL-(Xr{fF)fzdBRn`E8i+$*(Xt)%~}tM~Ht sFis)Y@ &C_-c3U{4o&?Y6E5' );
define( 'NONCE_SALT',       '?_n**RZ;5? dl7N+%J#Y(ux>G>zMi#S&%K)za?9jE0kdLwvg,YY&aSsgua.lty%o' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
