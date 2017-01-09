<?php

/**
 * The class autoloader.
 *
 * Loads any classes used throughout the plugin.
 *
 * @link 		http://wpdecks.com
 * @since 		1.0.0
 * @package 	Decks
 * @subpackage 	Decks/classes
 * @author 		Slushman <chris@slushman.com>
 */
class Decks_Autoloader {

	/**
	 * Autoloader function.
	 *
	 * Will search both plugin root and includes folder for class.
	 *
	 * @param 		string 		$class_name
	 */
	public static function autoloader( $class_name ) {

		$class_name = str_replace( 'Decks_', '', $class_name );
		$lower 		= strtolower( $class_name );
		$file      	= 'class-' . str_replace( '_', '-', $lower ) . '.php';
		$base_path 	= plugin_dir_path( __FILE__ );
		$paths[] 	= $base_path . $file;
		$paths[] 	= $base_path . 'classes/' . $file;

		/**
		 * plugin_name_autoloader_paths filter
		 */
		$paths = apply_filters( 'decks_autoloader_paths', $paths );

		foreach ( $paths as $path ) :

			if ( is_readable( $path ) && file_exists( $path ) ) {

				require_once( $path );
				return;

			}

		endforeach;

	} // autoloader()

} // class

spl_autoload_register( 'Decks_Autoloader::autoloader' );
