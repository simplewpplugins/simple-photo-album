<?php
/*
 Plugin Name: Simple Photo Album
 Plugin URI: https://wordpress.org/plugins/simple-photo-album
 Description: Creates a simple photo album system with minimal settings as the name suggests, it\'s simple.
 Version: 1.2
 Requires at least: 3.0
 Requires PHP: 7.0
 Author: Simple Plugins
 Author URI: https://aswin.com.np
 License: GPL v2 or later
 License URI: https://www.gnu.org/licenses/gpl-2.0.html
 Text Domain: simple-photo-album
 Domain Path: /languages
 */

if( ! defined( 'SIMPLE_PHOTO_ALBUM_PLUGIN' )){
	define( 'SIMPLE_PHOTO_ALBUM_PLUGIN', __FILE__  );
}

if( ! defined( 'SIMPLE_PHOTO_ALBUM_URL' )){
	define( 'SIMPLE_PHOTO_ALBUM_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
}


if( ! defined( 'SIMPLE_PHOTO_ALBUM_PATH' )){
	define( 'SIMPLE_PHOTO_ALBUM_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
}


include SIMPLE_PHOTO_ALBUM_PATH.'includes/init.php';