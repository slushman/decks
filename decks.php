<?php

/**
 * The plugin bootstrap file
 *
 * @link 				http://wpdecks.com
 * @since 				1.0.0
 * @package 			Plugin_Name
 *
 * @wordpress-plugin
 * Plugin Name: 		Decks
 * Plugin URI: 			http://wpdecks.com
 * Description: 		An easy way to create presentations with Reveal.js.
 * Version: 			1.0.0
 * Author: 				Slushman
 * Author URI: 			http://slushman.com/
 * License: 			GPL-2.0+
 * License URI: 		http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: 		decks
 * Domain Path: 		/assets/languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) { die; }

/**
 * Define constants
 */
define( 'DECKS_VERSION', '1.0.0' );
define( 'DECKS_SLUG', 'decks' );
define( 'DECKS_FILE', plugin_basename( __FILE__ ) );

/**
 * Activation/Deactivation Hooks
 */
register_activation_hook( __FILE__, array( 'Decks_Activator', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Decks_Deactivator', 'deactivate' ) );

/**
 * Autoloader function
 *
 * Will search both plugin root and includes folder for class
 *
 * @param string $class_name
 */
if ( ! function_exists( 'decks_autoloader' ) ) :

	function decks_autoloader( $class_name ) {

		$class_name = str_replace( 'Decks_', '', $class_name );
		$lower 		= strtolower( $class_name );
		$file      	= 'class-' . str_replace( '_', '-', $lower ) . '.php';
		$base_path 	= plugin_dir_path( __FILE__ );
		$paths[] 	= $base_path . $file;
		$paths[] 	= $base_path . 'classes/' . $file;

		/**
		 * plugin_name_autoloader_paths filter
		 */
		$paths = apply_filters( 'decks-autoloader-paths', $paths );

		foreach ( $paths as $path ) :

			if ( is_readable( $path ) && file_exists( $path ) ) {

				require_once( $path );
				return;

			}

		endforeach;

	} // decks_autoloader()

endif;

spl_autoload_register( 'decks_autoloader' );

if ( ! function_exists( 'decks_init' ) ) :

	/**
	 * Function to initialize plugin
	 */
	function decks_init() {

		decks()->run();

	}

	add_action( 'plugins_loaded', 'decks_init' );

endif;

if ( ! function_exists( 'decks' ) ) :

	/**
	 * Function wrapper to get instance of plugin
	 *
	 * @return Plugin_Name_Class
	 */
	function decks() {

		return Decks::get_instance();

	}

endif;
