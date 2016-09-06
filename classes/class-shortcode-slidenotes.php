<?php
/**
 * The functinality for
 *
 * @link 		http://slushman.com
 * @since 		1.0.0
 *
 * @package 	Decks
 * @subpackage 	Decks/classes
 */

/**
 * The metabox-specific functionality of the plugin.
 *
 * @package 	Decks
 * @subpackage 	Decks/classes
 * @author 		Slushman <chris@slushman.com>
 */
class Decks_Shortcode_Slidenotes {

	/**
	 * Constructor
	 */
	public function __construct() {}

	/**
	 * Processes slidenotes shortcode.
	 *
	 * Attributes:
	 * trim:
	 * noescape:
	 *
	 * @param 		array 		$atts 			Shortcode attributes
	 * @param 		mixed 		$content 		The content in the shortcode
	 *
	 * @return 		mixed 						HTML markup
	 */
	public function shortcode_slidenotes( $atts, $content = null ) {

		if ( empty( $content ) ) { return; }

		return '<aside class="notes">' . $content . '</aside>';

	} // shortcode_slidenotes()

} // class
