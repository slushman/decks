<?php

/**
 * Provides the markup for any checkbox field
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
$defaults['name'] 			= '';
$defaults['value'] 			= 0;
$atts 						= wp_parse_args( $atts, $defaults );

?><label for="<?php echo esc_attr( $atts['id'] ); ?>">
	<input <?php

		checked( 1, $atts['value'], true );

		?>class="<?php echo esc_attr( $atts['class'] ); ?>"
		id="<?php echo esc_attr( $atts['id'] ); ?>"
		name="<?php echo esc_attr( $atts['name'] ); ?>"
		type="checkbox"
		value="1" />
	<span class="description"><?php echo wp_kses( $atts['description'], array( 'code' => array() ) ); ?></span>
</label>
