<?php

/**
 * Displays a metabox
 *
 * @link       http://slushman.com
 * @since      1.0.0
 *
 * @package    Decks
 * @subpackage Decks/classes/views
 */

wp_nonce_field( DECKS_SLUG, 'nonce_Decks_subtitle' );

$atts 					= array();
$atts['class'] 			= 'widefat';
$atts['description'] 	= '';
$atts['id'] 			= 'subtitle';
$atts['label'] 			= __( 'Subtitle', 'decks' );
$atts['name'] 			= 'subtitle';
$atts['placeholder'] 	= __( 'Enter the subtitle', 'decks' );
$atts['type'] 			= 'text';
$atts['value'] 			= '';

if ( ! empty( $this->meta[$atts['id']][0] ) ) {

	$atts['value'] = $this->meta[$atts['id']][0];

}

$atts = apply_filters( DECKS_SLUG . '_field_subtitle', $atts );

?><p><?php

include(  plugin_dir_url( dirname( __FILE__ ) ) . 'fields/text.php' );

?></p>
