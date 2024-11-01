<?php
/**
 * Plugin Name:	WP Alert Bars
 * Plugin URI:	http://wordpress.org/plugins/wp-alert-bars/
 * Description:	Allow users to display a notification/alert box in a Post or Page multiple times. Use shortcode: [wp_alert_bars]
 * Version:		1.0
 * Author:		Hossni Mubarak
 * Author URI:	http://www.hossnimubarak.com
 * License:		GPL-2.0+
 * License URI:	http://www.gnu.org/licenses/gpl-2.0.txt
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'WAB_PATH', plugin_dir_path( __FILE__ ) );
define( 'WAB_ASSETS', plugins_url( '/assets/', __FILE__ ) );
define( 'WAB_LANG', plugins_url( '/languages/', __FILE__ ) );
define( 'WAB_SLUG', plugin_basename( __FILE__ ) );
define( 'WAB_PRFX', 'wab_' );
define( 'WAB_CLS_PRFX', 'cls-wp-alert-bars' );
define( 'WAB_TXT_DOMAIN', 'wp-alert-bars' );
define( 'WAB_VERSION', '1.0' );

require_once WAB_PATH . 'inc/' . WAB_CLS_PRFX . '-master.php';
$wab = new WAB_Master();
$wab->wab_run();
register_deactivation_hook( __FILE__, array($wab, WAB_PRFX . 'unregister_settings') );
