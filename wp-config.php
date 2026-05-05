<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'gharseva' );

/** Database username */
define( 'DB_USER', 'admin' );

/** Database password */
define( 'DB_PASSWORD', 'welcome' );

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
define( 'AUTH_KEY',         '2=;!xz_YT#<TsO[y;:E}9TcG fY|RjMI^qSTvK%DPl>5$4%#|~H1|)HR 5S5s>G5' );
define( 'SECURE_AUTH_KEY',  'JO~Z840wP8EI]>%L}# JTzQe{tKnt<OW4wA&s%)eJ3EE ebx#I(!gSu_V|h01Eii' );
define( 'LOGGED_IN_KEY',    'R/[-3Z0rLN1c8@/aGs}oOD&}EJjfdO5#CR:%#Z<m1 )Ipj_p+-(d^8A9vm`9HY^T' );
define( 'NONCE_KEY',        'nt h 96Z,9>p~97Q}}ynJO89q h3@!QlOp}?^3@PWn2_1F4N_BP%!gGeUO{zj(/a' );
define( 'AUTH_SALT',        'djdWl(djs_H~W 3gFxonrm;%:9FsbBCa0jjC@>+)xHsJ/kX7VA}b$hpYMW FfkMu' );
define( 'SECURE_AUTH_SALT', '26y#h$*,c~=<hUH*@9Iy$ZtP<Q4z=l}LcVbbgKPW)TZfn6BjyknwOTqH2)W-ma#%' );
define( 'LOGGED_IN_SALT',   ';3q/_JY3rmQ~/dNPE.Fvs#Y&],$g}WErWS[Uml5vkUcn1#{_WH$#fu;BIfD`TC/W' );
define( 'NONCE_SALT',       'xj.(OZOQA92q#)O1IbB}~GR(d;gh~|$<&5tu>b6#AkO^y:wd/22Ynp!5]ML[`XVs' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

	/* Add any custom values between this line and the "stop editing" line. */

	// Allow WordPress to write files directly (no FTP prompt) when permissions allow.
	define( 'FS_METHOD', 'direct' );

	// When sharing this local site via a tunnel (e.g., *.loca.lt), ensure assets load from the tunnel host
	// instead of http://localhost/ (which other devices can't access).
	if ( ! defined( 'WP_HOME' ) && ! defined( 'WP_SITEURL' ) && ! empty( $_SERVER['HTTP_HOST'] ) ) {
		$host = (string) $_SERVER['HTTP_HOST'];
		$is_local_host = ( 'localhost' === $host || '127.0.0.1' === $host );
		if ( ! $is_local_host ) {
			$scheme = 'http';
			if (
				( ! empty( $_SERVER['HTTPS'] ) && 'off' !== $_SERVER['HTTPS'] ) ||
				( ! empty( $_SERVER['SERVER_PORT'] ) && '443' === (string) $_SERVER['SERVER_PORT'] ) ||
				( ! empty( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && 'https' === (string) $_SERVER['HTTP_X_FORWARDED_PROTO'] )
			) {
				$scheme = 'https';
			}

			$base = $scheme . '://' . $host . '/vishal/gharseva';
			define( 'WP_HOME', $base );
			define( 'WP_SITEURL', $base );
		}
	}


	/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
