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

// Used for referring to the plugin file or basename
if ( ! defined( 'DECKS_FILE' ) ) {
	define( 'DECKS_FILE', plugin_basename( __FILE__ ) );
}

/**
 * Runs during plugin activation.
 * This action is documented in classes/class-activator.php
 */
require_once plugin_dir_path( __FILE__ ) . 'classes/class-activator.php';
register_activation_hook( __FILE__, array( 'Decks_Activator', 'activate' ) );

/**
 * Code that runs during plugin deactivation.
 * This action is documented in classes/class-deactivator.php
 */
require_once plugin_dir_path( __FILE__ ) . 'classes/class-deactivator.php';
register_deactivation_hook( __FILE__, array( 'Decks_Deactivator', 'deactivate' ) );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'classes/class-decks.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
call_user_func( array( new Decks(), 'run' ) );
