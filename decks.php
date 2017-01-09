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
 * Author URI: 			https://www.slushman.com/
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
 * Load Autoloader
 */
require plugin_dir_path( __FILE__ ) . 'classes/class-autoloader.php';

/**
 * Load Global Functions.
 */
require plugin_dir_path( __FILE__ ) . 'classes/global-functions.php';

/**
 * Initializes each class and adds the hooks action in each to after_setup_theme
 *
 *
 *
 * @TODO: move all plugin settings to term meta on the taxonomies. These are settings that
 * may need to change between presentations.
 */
function decks_init() {

	$obj_admin 		= new Decks_Admin();
	$obj_cpt_slide 	= new Decks_CPT_Slide();
	$obj_customizer = new Decks_Customizer();
	$obj_i18n 		= new Decks_i18n();
	$obj_mb_bg 		= new Decks_Metabox_Background();
	$obj_public 	= new Decks_Public();
	$obj_slidecode 	= new Decks_Shortcode_Slidecode();
	$obj_slidenotes = new Decks_Shortcode_Slidenotes();
	$obj_slidestep 	= new Decks_Shortcode_Slidestep();
	$obj_tax_pres 	= new Decks_Tax_Presentation();
	$obj_templates 	= new Decks_Templates();

	add_action( 'after_setup_theme', array( $obj_admin, 'hooks' ) );
	add_action( 'after_setup_theme', array( $obj_cpt_slide, 'hooks' ) );
	add_action( 'after_setup_theme', array( $obj_customizer, 'hooks' ) );
	add_action( 'after_setup_theme', array( $obj_i18n, 'hooks' ) );
	add_action( 'after_setup_theme', array( $obj_mb_bg, 'hooks' ) );
	add_action( 'after_setup_theme', array( $obj_public, 'hooks' ) );
	add_action( 'after_setup_theme', array( $obj_slidecode, 'hooks' ) );
	add_action( 'after_setup_theme', array( $obj_slidenotes, 'hooks' ) );
	add_action( 'after_setup_theme', array( $obj_slidestep, 'hooks' ) );
	add_action( 'after_setup_theme', array( $obj_tax_pres, 'hooks' ) );
	add_action( 'after_setup_theme', array( $obj_templates, 'hooks' ) );

} // decks_init()

add_action( 'plugins_loaded', 'decks_init' );
