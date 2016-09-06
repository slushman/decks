<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines a custom post type and other related functionality.
 *
 * @link 		http://wpdecks.com
 * @since 		1.0.0
 *
 * @package 	Decks
 * @subpackage 	Decks/classes
 * @author 		Slushman <chris@slushman.com>
 */
class Decks_CPT_Slide {

	/**
	 * Constructor
	 */
	public function __construct() {} // __construct()

	/**
	 * Registers additional image sizes
	 */
	public function add_image_sizes() {

		add_image_size( 'col-thumb', 75, 75, true );

	} // add_image_sizes()

	/**
	 * Populates the custom columns with content.
	 *
	 * @param 		string 		$column_name 		The name of the column
	 * @param 		int 		$post_id 			The post ID
	 *
	 * @return 		string 							The column content
	 */
	public function slide_column_content( $column_name, $post_id  ) {

		if ( empty( $post_id ) ) { return; }

		if ( 'col-thumb' === $column_name ) {

			$thumb = get_the_post_thumbnail( $post_id, 'col-thumb' );

			echo $thumb;

		}

		if ( 'sortable-column' === $column_name ) {

			$col = get_post_meta( $post_id, 'sortable-column', true );

			echo '<a href="' . esc_url( get_edit_post_link( $post_id ) ) .  '">';
			echo $col;
			echo '</a>';

		}

	} // slide_column_content()

	/**
	 * Sorts the slide admin list by the display order
	 *
	 * @param 		array 		$vars 			The current query vars array
	 *
	 * @return 		array 						The modified query vars array
	 */
	public function slide_order_sorting( $vars ) {

		if ( empty( $vars ) ) { return $vars; }
		if ( ! is_admin() ) { return $vars; }
		if ( ! isset( $vars['post_type'] ) || 'slide' !== $vars['post_type'] ) { return $vars; }

		if ( isset( $vars['orderby'] ) && 'sortable-column' === $vars['orderby'] ) {

			$vars = array_merge( $vars, array(
				'meta_key' => 'sortable-column',
				'orderby' => 'meta_value'
			) );

		}

		return $vars;

	} // slide_order_sorting()

	/**
	 * Registers additional columns for the Decks admin listing
	 * and reorders the columns.
	 *
	 * @param 		array 		$columns 		The current columns
	 *
	 * @return 		array 						The modified columns
	 */
	public function slide_register_columns( $columns ) {

		$new['cb'] 				= '<input type="checkbox" />';
		$new['thumbnail'] 		= __( 'Thumbnail', 'decks' );
		$new['sortable-column'] = __( 'Sortable Column', 'decks' );
		$new['date'] 			= __( 'Date' );

		return $new;

	} // slide_register_columns()

	/**
	 * Registers sortable columns
	 *
	 * @param 		array 		$sortables 			The current sortable columns
	 *
	 * @return 		array 							The modified sortable columns
	 */
	public function slide_sortable_columns( $sortables ) {

		$sortables['sortable-column'] = 'display-order';

		return $sortables;

	} // slide_sortable_columns()

	/**
	 * Creates a new custom post type
	 */
	public static function new_cpt_slide() {

		$cap_type 										= 'post';
		$opts['can_export']								= TRUE;
		$opts['capability_type']						= $cap_type;
		$opts['description']							= '';
		$opts['exclude_from_search']					= FALSE;
		$opts['has_archive']							= FALSE;
		$opts['hierarchical']							= TRUE;
		$opts['map_meta_cap']							= TRUE;
		$opts['menu_icon']								= 'dashicons-images-alt2';
		$opts['menu_position']							= 25;
		$opts['public']									= FALSE;
		$opts['publicly_querable']						= TRUE;
		$opts['query_var']								= TRUE;
		$opts['register_meta_box_cb']					= '';
		$opts['rest_base'] 								= 'slide';
		$opts['rest_controller_class'] 					= 'WP_REST_Posts_Controller';
		$opts['rewrite']								= FALSE;
		$opts['show_in_admin_bar']						= TRUE;
		$opts['show_in_menu']							= TRUE;
		$opts['show_in_nav_menu']						= TRUE;
		$opts['show_in_rest']							= TRUE;
		$opts['show_ui']								= TRUE;
		$opts['supports']								= array( 'title', 'editor', 'thumbnail' );
		$opts['taxonomies']								= array();

		$opts['capabilities']['delete_others_posts']	= "delete_others_{$cap_type}s";
		$opts['capabilities']['delete_post']			= "delete_{$cap_type}";
		$opts['capabilities']['delete_posts']			= "delete_{$cap_type}s";
		$opts['capabilities']['delete_private_posts']	= "delete_private_{$cap_type}s";
		$opts['capabilities']['delete_published_posts']	= "delete_published_{$cap_type}s";
		$opts['capabilities']['edit_others_posts']		= "edit_others_{$cap_type}s";
		$opts['capabilities']['edit_post']				= "edit_{$cap_type}";
		$opts['capabilities']['edit_posts']				= "edit_{$cap_type}s";
		$opts['capabilities']['edit_private_posts']		= "edit_private_{$cap_type}s";
		$opts['capabilities']['edit_published_posts']	= "edit_published_{$cap_type}s";
		$opts['capabilities']['publish_posts']			= "publish_{$cap_type}s";
		$opts['capabilities']['read_post']				= "read_{$cap_type}";
		$opts['capabilities']['read_private_posts']		= "read_private_{$cap_type}s";

		$opts['labels']['add_new']						= esc_html__( 'Add New Slide', 'decks' );
		$opts['labels']['add_new_item']					= esc_html__( 'Add New Slide', 'decks' );
		$opts['labels']['all_items']					= esc_html__( 'Slides', 'decks' );
		$opts['labels']['archives']						= esc_html__( 'Slides', 'decks' );
		$opts['labels']['edit_item']					= esc_html__( 'Edit Slide', 'decks');
		$opts['labels']['featured_image']				= esc_html__( 'Background Image', 'decks');
		$opts['labels']['filter_items_list']			= esc_html__( 'Slides', 'decks');
		$opts['labels']['insert_into_item']				= esc_html__( 'Slide', 'decks' );
		$opts['labels']['items_list']					= esc_html__( 'Slides', 'decks');
		$opts['labels']['items_list_navigation']		= esc_html__( 'Slides', 'decks');
		$opts['labels']['menu_name']					= esc_html__( 'Slides', 'decks' );
		$opts['labels']['name']							= esc_html__( 'Slides', 'decks' );
		$opts['labels']['name_admin_bar']				= esc_html__( 'Slide', 'decks' );
		$opts['labels']['new_item']						= esc_html__( 'New Slide', 'decks' );
		$opts['labels']['not_found']					= esc_html__( 'No Slides Found', 'decks' );
		$opts['labels']['not_found_in_trash']			= esc_html__( 'No Slides Found in Trash', 'decks' );
		$opts['labels']['parent_item_colon']			= esc_html__( 'Parent Slides :', 'decks' );
		$opts['labels']['remove_featured_image']		= esc_html__( 'Remove background image', 'decks');
		$opts['labels']['search_items']					= esc_html__( 'Search Slides', 'decks' );
		$opts['labels']['set_featured_image']			= esc_html__( 'Set background image', 'decks');
		$opts['labels']['singular_name']				= esc_html__( 'Slide', 'decks' );
		$opts['labels']['upload_to_this_item']			= esc_html__( 'Slide', 'decks' );
		$opts['labels']['use_featured_image']			= esc_html__( 'Use as background image', 'decks');
		$opts['labels']['view_item']					= esc_html__( 'View Slide', 'decks' );

		$opts['rewrite']['ep_mask']						= EP_PERMALINK;
		$opts['rewrite']['feeds']						= FALSE;
		$opts['rewrite']['pages']						= TRUE;
		$opts['rewrite']['slug']						= esc_html__( 'slide', 'decks' );
		$opts['rewrite']['with_front']					= TRUE;

		$opts = apply_filters( 'decks_cpt_slide_options', $opts );

		register_post_type( 'slide', $opts );

	} // new_cpt_slide()

} // class
