<?php

/**
 * Provides the markup for a date picker field
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Decks
 * @subpackage Decks/views/fields
 */
$defaults['class'] 			= '';
$defaults['description'] 	= __( '', 'text-domain' );
$defaults['id'] 			= '';
$defaults['label'] 			= __( '', 'text-domain' );
$defaults['name'] 			= '';
$defaults['placeholder'] 	= __( 'Select date', 'text-domain' );
$defaults['type'] 			= 'text';
$defaults['value'] 			= '';
$atts 						= wp_parse_args( $atts, $defaults );

if ( ! empty( $atts['label'] ) ) :

	?><label for="<?php echo esc_attr( $atts['id'] ); ?>"><?php echo wp_kses( $atts['label'], array( 'code' => array() ) ); ?>: </label><?php

endif;

?><span class="dashicons dashicons-calendar-alt date-field-icon"></span>
<input
	class="field-date <?php echo esc_attr( $atts['class'] ); ?>"<?php

	if ( ! empty( $atts['data'] ) ) {

		foreach ( $atts['data'] as $key => $value ) {

			?>data-<?php echo $key; ?>="<?php echo esc_attr( $value ); ?>"<?php

		}

	}

	?> id="<?php echo esc_attr( $atts['id'] ); ?>"
	name="<?php echo esc_attr( $atts['name'] ); ?>"
	pick="date"
	placeholder="<?php echo esc_attr( $atts['placeholder'] ); ?>"
	type="<?php echo esc_attr( $atts['type'] ); ?>"
	value="<?php echo esc_attr( $atts['value'] ); ?>" />
<p class="description"><?php echo wp_kses( $atts['description'], array( 'code' => array() ) ); ?></p>
