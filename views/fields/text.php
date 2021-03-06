<?php

/**
 * Provides the markup for any text field
 *
 * @link       http://wpdecks.com
 * @since      1.0.0
 *
 * @package    Decks
 * @subpackage Decks/classes/views
 */
$defaults['class'] 			= 'widefat';
$defaults['description'] 	= __( '', 'decks' );
$defaults['id'] 			= '';
$defaults['label'] 			= __( '', 'decks' );
$defaults['name'] 			= '';
$defaults['pick'] 			= '';
$defaults['placeholder'] 	= __( '', 'decks' );
$defaults['type'] 			= 'text';
$defaults['value'] 			= '';
$atts 						= wp_parse_args( $atts, $defaults );

if ( ! empty( $atts['label'] ) ) :

	?><label for="<?php echo esc_attr( $atts['id'] ); ?>"><?php echo wp_kses( $atts['label'], array( 'code' => array() ) ); ?>: </label><?php

endif;

?><input
	class="<?php echo esc_attr( $atts['class'] ); ?>"<?php

	if ( ! empty( $atts['data'] ) ) {

		foreach ( $atts['data'] as $key => $value ) {

			?>data-<?php echo $key; ?>="<?php echo esc_attr( $value ); ?>"<?php

		}

	}

	if ( ! empty( $atts['pick'] ) ) {

		?> pick="<?php echo esc_attr( $atts['id'] ); ?>"<?php

	}

	?> id="<?php echo esc_attr( $atts['id'] ); ?>"
	name="<?php echo esc_attr( $atts['name'] ); ?>"
	placeholder="<?php echo esc_attr( $atts['placeholder'] ); ?>"
	type="<?php echo esc_attr( $atts['type'] ); ?>"
	value="<?php echo esc_attr( $atts['value'] ); ?>" />
<p class="description"><?php echo wp_kses( $atts['description'], array( 'code' => array() ) ); ?></p>
