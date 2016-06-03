<?php
/**
 * The template for displaying single post meta field data.
 *
 * @package Decks
 */

if ( empty( $meta['meta_field'][0] ) ) { return; }

?><p class="<?php echo esc_attr( 'meta_field' ); ?>"><?php

	esc_html_e( $meta['meta_field'][0] );

?></p>