<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache



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
define( 'DB_NAME', 'austlzji_wp119' );

/** MySQL database username */
define( 'DB_USER', 'austlzji_wp119' );

/** MySQL database password */
define( 'DB_PASSWORD', 'O!97Qb-4pS' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'ixq20fu0moio1nwerhdkedjo1kaysxgelkvzsqsqrzwc60vt13ofmfzwuuujdbkg' );
define( 'SECURE_AUTH_KEY',  'khz1bqj8s3rxanhnvodhz6sojvfsaoofxglmqfsxzhazifgyzavp1lve3salxkhk' );
define( 'LOGGED_IN_KEY',    'caqrtxxmeiyhwao02hbxlsnnf6h7ulwnympwmnewtscibmuex39yr1mfk7jtvx8x' );
define( 'NONCE_KEY',        'b0mehfsqbqprr9z6dnoe3fxqvit1sdjqr3pmfgijnh7id44y7m3bw10gzasovqmi' );
define( 'AUTH_SALT',        'msqyb71iybg0lrz9eykuzmkrkxbeeo5wiqbowk5tpjgoqducgyqqmpsswart73sh' );
define( 'SECURE_AUTH_SALT', 'yu7bthbcjpbnhaex1ngjvlirq4wcdvsirmvzi4ceeouyyehxqv4esagmqr7g2ylw' );
define( 'LOGGED_IN_SALT',   '4yao8j6qsx7smx9lmdthcmqqx7fuwsqpbaiamjxa9g6buhurao765frgz5ilm4n0' );
define( 'NONCE_SALT',       'prsg3jv3ceolqxkoapebeygtecugwusngt3cgqs1xmrvvkscmdpxjz4je9msa9vx' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpa2_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );