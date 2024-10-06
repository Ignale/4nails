<?php
//Begin Really Simple Security key
define('RSSSL_KEY', 'i1mUNS6kiGbzGIQBIwuddRx9FmU90pcjcm9IZr6XnrZVp5kzljOa0v2oZcefC8fz');
//END Really Simple Security key
define('WP_CACHE', true);

define('WP_HOME', 'https://4nails.us');
define('WP_SITEURL', 'https://4nails.us');
//Begin Really Simple SSL session cookie settings
@ini_set('session.cookie_httponly', true);
@ini_set('session.cookie_secure', true);
@ini_set('session.use_only_cookies', true);
//END Really Simple SSL
define('WP_AUTO_UPDATE_CORE', 'minor');
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
define('DB_NAME', 'orangew1_4nails');
/** MySQL database username */
define('DB_USER', 'orangew1_dm');
/** MySQL database password */
define('DB_PASSWORD', 'OlzU7aGxJ3kY');
/** MySQL hostname */
define('DB_HOST', 'localhost');
/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');
/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');
/** WP-cron disable */
define('DISABLE_WP_CRON', false);
/** WordPress ����������� ������: */
define('WP_MEMORY_LIMIT', '1024M');
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'nj26Z+RP){Edp5Fpfcd3EYxSN<(>-]/  _T46hSWM(w`%pcPB,_Q0a0=rh.^3?}L');
define('SECURE_AUTH_KEY', '4Inr:NhsqFUux.%c<DAdgP.<e,%!kr%?];/C^:uFf{4}iYhsnT .}I_jLciFb]`c');
define('LOGGED_IN_KEY', '^H5;`:1Fw5@Qa,sY=*^,tVbLik)9}R$)VH*3|kk<%]74.3~t.y$skL5xbGn-l{dc');
define('NONCE_KEY', 'gn*bws^TpCt0c29g<(E8_[L>*&A/6@4f:zMx-xo4mSGk;!1U3OvtiFfI&*_)6eZ_');
define('AUTH_SALT', 'A xyS]g&^EHA~n~+1Hi3Z:|viO6;fjb][_T{t>4._CJ9fUDQ^qb+2|.AV+0`0ZCg');
define('SECURE_AUTH_SALT', 'u1XZd6z^F~-6o&et=L&r]z}!J3OpZ4X1;F3+NWSo7lQFZic/v#!B@{Q v%Kl@d/k');
define('LOGGED_IN_SALT', '&PC$6I1`tsq=49d#f~P@fBLEB>}KU,,bfTQ:^[HA u=Ef)w7spUJo&GvvEhq6Zd1');
define('NONCE_SALT', '=tcB6nLy-LP+Ad{1}0XM2Y&m@u/g.%N_p{CH~.k9DK1XaHmwW`sfO$p8GD >7Y8g');
/**#@-*/
/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'nl_';
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
define('WP_DEBUG_DISPLAY', false);
define('WP_DEBUG_LOG', false);
define('MEDIA_TRASH', true);
@ini_set('max_input_vars', 6000);
/* That's all, stop editing! Happy publishing. */
/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
  define('ABSPATH', dirname(__FILE__) . '/');
}
/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');