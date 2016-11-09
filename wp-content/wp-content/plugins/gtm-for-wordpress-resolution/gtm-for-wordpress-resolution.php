<?php 
/*
Plugin Name: Google Tag Manager
Version: 1.4
Plugin URI: https://resolutionmedia.com/
Description: Customised Google Tag Manager Plugin
Author: Resolution Media
Author URI: https://resolutionmedia.com/
Text Domain: duracelltomi-google-tag-manager
Domain Path: /languages
*/

define( 'GTM4WP_VERSION',    '1.4' );
define( 'GTM4WP_PATH',       plugin_dir_path( __FILE__ ) );

$gtp4wp_plugin_url = plugin_dir_url( __FILE__ );
$gtp4wp_plugin_basename = plugin_basename( __FILE__ );
require_once( GTM4WP_PATH."/common/readoptions.php" );

function gtm4wp_init() {
	load_plugin_textdomain( 'duracelltomi-google-tag-manager', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	if ( is_admin() ) {
		require_once( GTM4WP_PATH."/admin/admin.php" );
	} else {
		require_once( GTM4WP_PATH."/public/frontend.php" );
	}
}
add_action('plugins_loaded', 'gtm4wp_init');
