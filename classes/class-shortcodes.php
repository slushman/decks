<?php
/**
 * The functionality for shortcodes.
 *
 * @link 		http://slushman.com
 * @since 		1.0.0
 *
 * @package 	Decks
 * @subpackage 	Decks/classes
 */

/**
 * The shortcode-specific functionality of the plugin.
 *
 * @package 	Decks
 * @subpackage 	Decks/classes
 * @author 		Slushman <chris@slushman.com>
 */
class Decks_Shortcodes {

	/**
	 * Constructor
	 */
	public function __construct() {}

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

	/**
	 * Processes slidestep shortcode.
	 *
	 * Attributes:
	 * Highlight Colors: highlight-red, highlight-blue, highlight-green
	 * Transitions - grow, shrink, fade-out, fade-in, fade-up, fade-down, fade-right, fade-left
	 * current-visible: Only displays once
	 * Order: The order in which to step through the fragments.
	 *
	 * @param 		array 		$atts 			Shortcode attributes
	 * @param 		mixed 		$content 		The content in the shortcode
	 *
	 * @return 		mixed 						HTML markup
	 */
	public function shortcode_slidestep( $atts, $content = null ) {

		if ( empty( $content ) ) { return; }

		if ( ! empty( $atts['order'] ) ) {

			$index = ' data-fragment-index="' . absint( $atts['order'] ) . '"';
			unset( $atts['order'] );

		} else {

			$index = '';

		}

		if ( empty( $atts ) ) {

			$atts[] = 'fragment';

		} else {

			array_unshift( $atts, 'fragment' );

		}

		$classes = implode( ' ', $atts );

		return '<p class="' . esc_attr( $classes ) . '"' . esc_attr( $index ) . '>' . $content . '</p>';

	} // shortcode_slidestep()

} // class
