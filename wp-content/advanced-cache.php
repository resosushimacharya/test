<?php
defined( 'ABSPATH' ) or die( 'Cheatin\' uh?' );

define( 'WP_ROCKET_ADVANCED_CACHE', true );
$rocket_cache_path = 'D:\xampp\htdocs\carpetcall/wp-content/cache/wp-rocket/';
$rocket_config_path = 'D:\xampp\htdocs\carpetcall/wp-content/wp-rocket-config/';

if ( file_exists( 'D:\xampp\htdocs\carpetcall\wp-content\plugins\wp-rocket\inc\vendors/Mobile_Detect.php' ) ) {
	include( 'D:\xampp\htdocs\carpetcall\wp-content\plugins\wp-rocket\inc\vendors/Mobile_Detect.php' );
}
if ( file_exists( 'D:\xampp\htdocs\carpetcall\wp-content\plugins\wp-rocket\inc\front/process.php' ) ) {
	include( 'D:\xampp\htdocs\carpetcall\wp-content\plugins\wp-rocket\inc\front/process.php' );
} else {
	define( 'WP_ROCKET_ADVANCED_CACHE_PROBLEM', true );
}