<?php
/**
 * The view for the featured image used in the single-postttypename template
 */

if ( ! has_post_thumbnail() ) { return; }

$thumb_atts['class'] 	= 'alignleft img-slide photo';
$thumb_atts['itemtype'] = 'image';
$thumb_atts 			= apply_filters( 'decks_single_post_featured_image_attributes', $thumb_atts );

the_post_thumbnail( 'medium', $thumb_atts );
