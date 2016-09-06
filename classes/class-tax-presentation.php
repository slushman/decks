<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines a taxonomy and other related functionality.
 *
 * @link 		http://wpdecks.com
 * @since 		1.0.0
 *
 * @package 	Decks
 * @subpackage 	Decks/classes
 * @author		Slushman <chris@slushman.com>
 */
class Decks_Tax_Presentation {

	/**
	 * Constructor
	 */
	public function __construct() {} // __construct()

	/**
	 * Creates a new taxonomy for a custom post type
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @uses 	register_taxonomy()
	 */
	public static function new_taxonomy_presentation() {

		$opts['hierarchical']							= TRUE;
		//$opts['meta_box_cb'] 							= '';
		$opts['public']									= TRUE;
		$opts['query_var']								= 'presentation';
		$opts['show_admin_column'] 						= FALSE;
		$opts['show_in_nav_menus']						= TRUE;
		$opts['show_tag_cloud'] 						= TRUE;
		$opts['show_ui']								= TRUE;
		$opts['sort'] 									= '';
		//$opts['update_count_callback'] 					= '';

		$opts['capabilities']['assign_terms'] 			= 'edit_posts';
		$opts['capabilities']['delete_terms'] 			= 'manage_categories';
		$opts['capabilities']['edit_terms'] 			= 'manage_categories';
		$opts['capabilities']['manage_terms'] 			= 'manage_categories';

		$opts['labels']['add_new_item'] 				= esc_html__( 'Add New Presentation', 'decks' );
		$opts['labels']['add_or_remove_items'] 			= esc_html__( 'Add or remove presentations', 'decks' );
		$opts['labels']['all_items'] 					= esc_html__( 'Presentations', 'decks' );
		$opts['labels']['choose_from_most_used'] 		= esc_html__( 'Choose from most used presentations', 'decks' );
		$opts['labels']['edit_item'] 					= esc_html__( 'Edit Presentation' , 'decks');
		$opts['labels']['menu_name'] 					= esc_html__( 'Presentations', 'decks' );
		$opts['labels']['name'] 						= esc_html__( 'Presentations', 'decks' );
		$opts['labels']['new_item_name'] 				= esc_html__( 'New Presentation Name', 'decks' );
		$opts['labels']['not_found'] 					= esc_html__( 'No Presentations Found', 'decks' );
		$opts['labels']['parent_item'] 					= esc_html__( 'Parent Presentation', 'decks' );
		$opts['labels']['parent_item_colon'] 			= esc_html__( 'Parent Presentation', 'decks' );
		$opts['labels']['popular_items'] 				= esc_html__( 'Popular Presentations', 'decks' );
		$opts['labels']['search_items'] 				= esc_html__( 'Search Presentations', 'decks' );
		$opts['labels']['separate_items_with_commas'] 	= esc_html__( 'Separate presentations with commas', 'decks' );
		$opts['labels']['singular_name'] 				= esc_html__( 'Presentation', 'decks' );
		$opts['labels']['update_item'] 					= esc_html__( 'Update Presentation', 'decks' );
		$opts['labels']['view_item'] 					= esc_html__( 'View Presentation', 'decks' );

		$opts['rewrite']['ep_mask']						= EP_NONE;
		$opts['rewrite']['hierarchical']				= FALSE;
		$opts['rewrite']['slug']						= esc_html__( 'presentation', 'decks' );
		$opts['rewrite']['with_front']					= FALSE;

		$opts = apply_filters( 'decks_taxonomy_presentation_options', $opts );

		register_taxonomy( 'presentation', 'slide', $opts );

	} // new_taxonomy_presentation()

} // class
