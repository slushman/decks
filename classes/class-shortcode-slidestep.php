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
class Decks_Shortcode_Slidestep {

	/**
	 * Constructor
	 */
	public function __construct() {}

	/**
	 * Registers all the WordPress hooks and filters for this class.
	 */
	public function hooks() {

		add_shortcode( 'slidestep', array( $this, 'shortcode_slidestep' ) );
		add_action( 'slidestep', 	array( $this, 'shortcode_slidestep' ) );

	} // hooks()

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
