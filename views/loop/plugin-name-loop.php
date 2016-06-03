<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://slushman.com
 * @since      1.0.0
 *
 * @package    Decks
 * @subpackage Decks/classes/loop-views
 */

/**
 * decks-before-loop hook
 *
 * @hooked 		loop_wrap_start 		15
 */
do_action( 'decks_before_loop', $args );

foreach ( $items as $item ) {

	$meta = get_post_custom( $item->ID );

	/**
	 * decks-before-loop-content hook
	 *
	 * @param 		object  	$item 		The post object
	 *
	 * @hooked 		loop_content_wrap_begin 		10
	 * @hooked 		loop_content_link_begin 		15
	 */
	do_action( 'decks_before_loop_content', $item, $meta );

		/**
		 * lazy-load-videos-loop-content hook
		 *
		 * @param 		object  	$item 		The post object
		 *
		 * @hooked		loop_content_image 			10
		 * @hooked		loop_content_title 			15
		 * @hooked		loop_content_subtitle 		20
		 */
		do_action( 'decks_loop_content', $item, $meta );

	/**
	 * decks-after-loop-content hook
	 *
	 * @param 		object  	$item 		The post object
	 *
	 * @hooked 		loop_content_link_end 		10
	 * @hooked 		loop_content_wrap_end 		90
	 */
	do_action( 'decks_after_loop_content', $item, $meta );

} // foreach

/**
 * decks-after-loop hook
 *
 * @hooked 		loop_wrap_end 			10
 */
do_action( 'decks_after_loop', $args );
