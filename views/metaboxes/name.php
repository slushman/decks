<?php

/**
 * Displays a metabox
 *
 * @link       http://wpdecks.com
 * @since      1.0.0
 *
 * @package    Decks
 * @subpackage Decks/classes/views
 */

wp_nonce_field( $this->plugin_name, 'nonce_Decks_metabox_name' );

/*

$atts 					= array();
$atts['class'] 			= 'widefat';
$atts['description'] 	= '';
$atts['id'] 			= 'phone-office';
$atts['label'] 			= 'Office Phone';
$atts['name'] 			= 'phone-office';
$atts['placeholder'] 	= '';
$atts['type'] 			= 'text';
$atts['value'] 			= '';

if ( ! empty( $this->meta[$atts['id']][0] ) ) {

	$atts['value'] = $this->meta[$atts['id']][0];

}

$atts = apply_filters( $this->plugin_name . '_field_' . $atts['id'], $atts );

?><p><?php

include( plugin_dir_path( dirname( __FILE__ ) ) . 'fields/text.php' );

?></p><?php


$atts 					= array();
$atts['aria'] 			= esc_html__( 'Select a State', 'decks' );
$atts['blank'] 			= esc_html__( 'Select a State', 'decks' );
$atts['class'] 			= 'widefat';
$atts['description'] 	= '';
$atts['id'] 			= 'state';
$atts['label'] 			= 'State';
$atts['name'] 			= 'state';
$atts['selections'][] 	= array( 'value' => 'example', 'label' => esc_html__( 'Example', 'decks' ) );
$atts['value'] 			= '';

if ( ! empty( $this->meta[$atts['id']][0] ) ) {

	$atts['value'] = $this->meta[$atts['id']][0];

}

$atts = apply_filters( $this->plugin_name . '_field_' . $atts['id'], $atts );

?><p><?php

include( plugin_dir_path( dirname( __FILE__ ) ) . 'fields/select.php' );

?></p><?php

*/
