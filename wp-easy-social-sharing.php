<?php
/**
* Plugin Name: WP Easy Social Sharing
* Plugin URI: https://github.com/mfikria/wp-easy-social-sharing
* Description: A plugin for easy sharing your content to social media.
* Author: Muhamad Fikri Alhawarizmi
* Author URI: https://mfikria.com
* Version: 0.1
* License: GPLv2
*/

// Do not access this file directly
if ( ! defined( 'WPINC' ) ) { die; }

/* Constants
------------------------------------------ */

// Set the version constant.
define( 'WESS_VERSION', '0.1.1' );

// Set the constant path to the plugin path.
define( 'WESS_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );

// Set the constant path to the plugin directory URI.
define( 'WESS_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );


function wess_plugins_loaded() {
	// Load Functions
	require_once('includes/functions.php' );

	// Load Settings
	if( is_admin() ){
		require_once('includes/settings.php' );
		$wess_settings = new WESS_Settings();
	}
}
add_action( 'plugins_loaded', 'wess_plugins_loaded' );

?>
