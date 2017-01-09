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
class Decks_Shortcode_Slidecode {

	/**
	 * Constructor
	 */
	public function __construct() {}

	/**
	 * Registers all the WordPress hooks and filters for this class.
	 */
	public function hooks() {

		add_shortcode( 'slidecode', array( $this, 'shortcode_slidecode' ) );
		add_action( 'slidecode', 	array( $this, 'shortcode_slidecode' ) );

	} // hooks()

	/**
	 * Processes slidecode shortcode.
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
	public function shortcode_slidecode( $atts, $content = null ) {

		if ( empty( $content ) ) { return; }

		if ( empty( $atts['trim'] ) ) {

			$trim = '';

		} else {

			$trim = ' data-trim';

		}

		if ( empty( $atts['noescape'] ) ) {

			$esc = '';

		} else {

			$esc = ' data-noescape';

		}

		$classes = implode( ' ', $atts );

		return '<pre><code' . esc_attr( $trim ) . esc_attr( $esc ) . '>' . $content . '</code></pre>';

	} // shortcode_slidecode()

} // class
