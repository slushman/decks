<?php

/**
 * Provides the markup for an upload field
 *
 * Saves the Image ID in the hidden input.
 *
 * @package    Decks
 * @subpackage Decks/classes/views
 */
$remove_class 	= ( empty( $atts['value'] ) ? 'hide' : '' );
$upload_class 	= ( empty( $atts['value'] ) ? '' : 'hide' );
$preview_class 	= ( empty( $atts['value'] ) ? 'image-upload-preview bordered' : 'image-upload-preview' );
$thumbnail 		= ( empty( $atts['value'] ) ? '' : wp_get_attachment_image_src( $atts['value'] )[0] );
$label_upload 	= ( empty( $atts['label-upload'] ) ? __( 'Choose/Upload image', 'decks' ) : $atts['label-upload'] );
$label_remove 	= ( empty( $atts['label-remove'] ) ? __( 'Remove image', 'decks' ) : $atts['label-remove'] );

?><div class="image-upload-field"><?php

if ( ! empty( $atts['label'] ) ) {

	?><label for="<?php echo esc_attr( $atts['id'] ); ?>"><?php echo wp_kses( $atts['label'], array( 'code' => array() ) ); ?>: </label><?php

}

	?><div class="<?php echo esc_attr( $preview_class ); ?>" id="<?php echo esc_attr( $atts['id'] . '-img' ); ?>" style="background-image:url(<?php echo esc_url( $thumbnail ); ?>);"></div>
	<input<?php

		if ( ! empty( $atts['data'] ) ) {

			foreach ( $atts['data'] as $key => $value ) {

				?>data-<?php echo $key; ?>="<?php echo esc_attr( $value ); ?>"<?php

			}

		}

		?>id="<?php echo esc_attr( $atts['id'] ); ?>"
		name="<?php echo esc_attr( $atts['name'] ); ?>"
		type="hidden"
		value="<?php echo esc_attr( $atts['value'] ); ?>" />
	<a href="#" class="<?php echo esc_attr( $upload_class ); ?>" id="upload-file"><?php
		echo wp_kses( $label_upload, array( 'code' => array() ) );
	?></a>
	<a href="#" class="<?php echo esc_attr( $remove_class ); ?>" id="remove-file"><?php
		echo wp_kses( $label_remove, array( 'code' => array() ) );
	?></a>
</div><!-- .file-upload-field --><?php

if ( ! empty( $atts['description'] ) ) {

	?><p class="description"><?php echo wp_kses( $atts['description'], array( 'code' => array() ) ); ?></p><?php

}
