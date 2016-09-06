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

wp_nonce_field( DECKS_SLUG, 'nonce_decks_background' );

$atts['class-input'] 	= 'bg-type';
$atts['description'] 	= esc_html__( 'Select the type of background for this slide.', 'decks' );
$atts['id'] 			= 'bgtype';
$atts['label'] 			= esc_html__( 'Background Type', 'decks' );
$atts['name'] 			= 'bgtype';
$atts['selections'][] 	= array( 'value' => 'none', 'label' => esc_html__( 'None', 'decks' ) );
$atts['selections'][] 	= array( 'value' => 'color', 'label' => esc_html__( 'Color', 'decks' ) );
$atts['selections'][] 	= array( 'value' => 'image', 'label' => esc_html__( 'Image', 'decks' ) );
$atts['selections'][] 	= array( 'value' => 'video', 'label' => esc_html__( 'Video', 'decks' ) );
$atts['selections'][] 	= array( 'value' => 'iframe', 'label' => esc_html__( 'iframe', 'decks' ) );
$atts['value'] 			= 'none';

if ( ! empty( $this->meta[$atts['id']][0] ) ) {

	$atts['value'] = $this->meta[$atts['id']][0];

}

$atts = apply_filters( DECKS_SLUG . '_field_' . $atts['id'], $atts );

?><p><?php

include( plugin_dir_path( dirname( __FILE__ ) ) . 'fields/radios.php' );
unset( $atts );

?></p>



<div class="" id="fields-transition"><?php

	$atts['aria'] 			= esc_html__( 'Select transition style.', 'decks' );
	$atts['class'] 			= '';
	$atts['description'] 	= esc_html__( 'Select transition style.', 'decks' );
	$atts['id'] 			= 'bgtransition';
	$atts['label'] 			= esc_html__( 'Transition', 'decks' );
	$atts['name'] 			= 'bgtransition';
	$atts['selections'][] 	= array( 'value' => 'default', 'label' => esc_html__( 'Default', 'decks' ) );
	$atts['selections'][] 	= array( 'value' => 'none', 'label' => esc_html__( 'None', 'decks' ) );
	$atts['selections'][] 	= array( 'value' => 'fade', 'label' => esc_html__( 'Fade', 'decks' ) );
	$atts['selections'][] 	= array( 'value' => 'slide', 'label' => esc_html__( 'Slide', 'decks' ) );
	$atts['selections'][] 	= array( 'value' => 'convex', 'label' => esc_html__( 'Convex', 'decks' ) );
	$atts['selections'][] 	= array( 'value' => 'concave', 'label' => esc_html__( 'Concave', 'decks' ) );
	$atts['selections'][] 	= array( 'value' => 'zoom', 'label' => esc_html__( 'Zoom', 'decks' ) );
	$atts['value'] 			= 'default';

	if ( ! empty( $this->meta[$atts['id']][0] ) ) {

		$atts['value'] = $this->meta[$atts['id']][0];

	}

	$atts = apply_filters( DECKS_SLUG . '_field_' . $atts['id'], $atts );

	?><p><?php

	include( plugin_dir_path( dirname( __FILE__ ) ) . 'fields/select.php' );
	unset( $atts );

	?></p><?php



	$atts['aria'] 			= esc_html__( 'Select transition style.', 'decks' );
	$atts['class'] 			= '';
	$atts['description'] 	= esc_html__( 'Transition-out style. If anything other than "default" is selected this value becomes the transition-out and the transition selection becomes the transition in.', 'decks' );
	$atts['id'] 			= 'bgtransitionout';
	$atts['label'] 			= esc_html__( 'Transition Out Style', 'decks' );
	$atts['name'] 			= 'bgtransitionout';
	$atts['selections'][] 	= array( 'value' => 'default', 'label' => esc_html__( 'Default', 'decks' ) );
	$atts['selections'][] 	= array( 'value' => 'none', 'label' => esc_html__( 'None', 'decks' ) );
	$atts['selections'][] 	= array( 'value' => 'fade', 'label' => esc_html__( 'Fade', 'decks' ) );
	$atts['selections'][] 	= array( 'value' => 'slide', 'label' => esc_html__( 'Slide', 'decks' ) );
	$atts['selections'][] 	= array( 'value' => 'convex', 'label' => esc_html__( 'Convex', 'decks' ) );
	$atts['selections'][] 	= array( 'value' => 'concave', 'label' => esc_html__( 'Concave', 'decks' ) );
	$atts['selections'][] 	= array( 'value' => 'zoom', 'label' => esc_html__( 'Zoom', 'decks' ) );
	$atts['value'] 			= 'default';

	if ( ! empty( $this->meta[$atts['id']][0] ) ) {

		$atts['value'] = $this->meta[$atts['id']][0];

	}

	$atts = apply_filters( DECKS_SLUG . '_field_' . $atts['id'], $atts );

	?><p><?php

	include( plugin_dir_path( dirname( __FILE__ ) ) . 'fields/select.php' );
	unset( $atts );

	?></p>
</div>



<div class="bg-fields" id="fields-color"><?php

	$atts['id'] 			= 'bg-color';
	$atts['label'] 			= __( 'Background Color', 'decks' );
	$atts['name'] 			= 'bg-color';

	if ( ! empty( $this->meta[$atts['id']][0] ) ) {

		$atts['value'] = $this->meta[$atts['id']][0];

	}

	$atts = apply_filters( DECKS_SLUG . '-field-' . $atts['id'], $atts );

	?><p><?php

	include( plugin_dir_path( dirname( __FILE__ ) ) . 'fields/color.php' );
	unset( $atts );

	?></p>
</div>



<div class="bg-fields" id="fields-image">
	<p>The <a href="https://css-tricks.com/almanac/properties/b/background-position/">position</a>, <a href="https://css-tricks.com/almanac/properties/b/background-size/">size</a>, and <a href="https://css-tricks.com/almanac/properties/b/background-repeat/">repeat</a> fields use any of the respective CSS properties. See the links for acceptable values.</p><?php

	$atts['id'] 			= 'bgsize';
	$atts['label'] 			= esc_html__( 'Background Size', 'decks' );
	$atts['name'] 			= 'bgsize';

	if ( ! empty( $this->meta[$atts['id']][0] ) ) {

		$atts['value'] = $this->meta[$atts['id']][0];

	}

	$atts = apply_filters( DECKS_SLUG . '_field_' . $atts['id'], $atts );

	?><p><?php

	include( plugin_dir_path( dirname( __FILE__ ) ) . 'fields/text.php' );
	unset( $atts );

	?></p><?php



	$atts['id'] 			= 'bgposition';
	$atts['label'] 			= esc_html__( 'Background Position', 'decks' );
	$atts['name'] 			= 'bgposition';

	if ( ! empty( $this->meta[$atts['id']][0] ) ) {

		$atts['value'] = $this->meta[$atts['id']][0];

	}

	$atts = apply_filters( DECKS_SLUG . '_field_' . $atts['id'], $atts );

	?><p><?php

	include( plugin_dir_path( dirname( __FILE__ ) ) . 'fields/text.php' );
	unset( $atts );

	?></p><?php



	$atts['id'] 			= 'bgrepeat';
	$atts['label'] 			= esc_html__( 'Background Repeat', 'decks' );
	$atts['name'] 			= 'bgrepeat';

	if ( ! empty( $this->meta[$atts['id']][0] ) ) {

		$atts['value'] = $this->meta[$atts['id']][0];

	}

	$atts = apply_filters( DECKS_SLUG . '_field_' . $atts['id'], $atts );

	?><p><?php

	include( plugin_dir_path( dirname( __FILE__ ) ) . 'fields/text.php' );
	unset( $atts );

	?></p>
</div>



<div class="bg-fields" id="fields-video"><?php

	$atts['id'] 			= 'video-url';
	$atts['label'] 			= esc_html__( 'Video URL', 'decks' );
	$atts['name'] 			= 'video-url';
	$atts['type'] 			= 'url';

	if ( ! empty( $this->meta[$atts['id']][0] ) ) {

		$atts['value'] = $this->meta[$atts['id']][0];

	}

	$atts = apply_filters( DECKS_SLUG . '_field_' . $atts['id'], $atts );

	?><p><?php

	include( plugin_dir_path( dirname( __FILE__ ) ) . 'fields/text.php' );
	unset( $atts );

	?></p><?php



	$atts['class'] 			= '';
	$atts['description'] 	= esc_html__( 'Check if the video should play repeatedly.', 'decks' );
	$atts['id'] 			= 'video-loop';
	$atts['label'] 			= esc_html__( 'Loop', 'decks' );
	$atts['name'] 			= 'video-loop';

	if ( ! empty( $this->meta[$atts['id']][0] ) ) {

		$atts['value'] = $this->meta[$atts['id']][0];

	}

	$atts = apply_filters( DECKS_SLUG . '_field_' . $atts['id'], $atts );

	?><p><?php

	include( plugin_dir_path( dirname( __FILE__ ) ) . 'fields/checkbox.php' );
	unset( $atts );

	?></p><?php



	$atts['class'] 			= '';
	$atts['description'] 	= esc_html__( 'Check if the audio should be muted.', 'decks' );
	$atts['id'] 			= 'video-muted';
	$atts['label'] 			= esc_html__( 'Muted', 'decks' );
	$atts['name'] 			= 'video-muted';

	if ( ! empty( $this->meta[$atts['id']][0] ) ) {

		$atts['value'] = $this->meta[$atts['id']][0];

	}

	$atts = apply_filters( DECKS_SLUG . '_field_' . $atts['id'], $atts );

	?><p><?php

	include( plugin_dir_path( dirname( __FILE__ ) ) . 'fields/checkbox.php' );
	unset( $atts );

	?></p>
</div>



<div class="bg-fields" id="fields-iframe"><?php

	$atts['id'] 			= 'iframe-url';
	$atts['label'] 			= esc_html__( 'iframe URL', 'decks' );
	$atts['name'] 			= 'iframe-url';
	$atts['type'] 			= 'url';

	if ( ! empty( $this->meta[$atts['id']][0] ) ) {

		$atts['value'] = $this->meta[$atts['id']][0];

	}

	$atts = apply_filters( DECKS_SLUG . '_field_' . $atts['id'], $atts );

	?><p><?php

	include( plugin_dir_path( dirname( __FILE__ ) ) . 'fields/text.php' );
	unset( $atts );

	?></p>
</div>
