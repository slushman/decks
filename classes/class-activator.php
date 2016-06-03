<?php

/**
 * Fired during plugin activation
 *
 * @link 		http://wpdecks.com
 * @since 		1.0.0
 *
 * @package 	Decks
 * @subpackage 	Decks/classes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since 		1.0.0
 * @package 	Decks
 * @subpackage 	Decks/classes
 * @author 		Slushman <chris@slushman.com>
 */
class Decks_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-cpt-slide.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-tax-presentation.php';

		Decks_CPT_Slide::new_cpt_slide();
		Decks_Tax_Presentation::new_taxonomy_presentation();

		flush_rewrite_rules();

		$opts 		= array();
		$options 	= Decks_Admin::get_options_list();

		foreach ( $options as $option ) {

			$opts[ $option[0] ] = $option[2];

		}

		update_option( 'decks-options', $opts );

	} // activate()

} // class
