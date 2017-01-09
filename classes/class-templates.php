<?php

if ( ! function_exists( 'decks_templates' ) ) {

	/**
	 * Public API for adding and removing temmplates.
	 *
	 * @return 		object 			Instance of the templates class
	 */
	function decks_templates() {

		return Decks_Templates::this();

	} // Decks_templates()

} // check

/**
 * The public-facing functionality of the plugin.
 *
 * @link 		http://wpdecks.com
 * @since 		1.0.0
 *
 * @package 	Decks
 * @subpackage 	Decks/classes
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the methods for creating the templates.
 *
 * @package 	Decks
 * @subpackage 	Decks/classes
 *
 */
class Decks_Templates {

	/**
	 * Private static reference to this class
	 * Useful for removing actions declared here.
	 *
	 * @var 	object 		$_this
 	 */
	private static $_this;

	/**
	 * The plugin options.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$options    The plugin options.
	 */
	private $options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 		1.0.0
	 */
	public function __construct() {

		self::$_this = $this;

		$this->set_options();

	} // __construct()

	/**
	 * Registers all the WordPress hooks and filters for this class.
	 */
	public function hooks() {

		// Loop
		add_action( 'decks-before-loop', 				array( $this, 'loop_wrap_begin' ), 10, 1 );

		add_action( 'decks-before-loop-content', 		array( $this, 'loop_content_wrap_begin' ), 10, 2 );
		add_action( 'decks-before-loop-content', 		array( $this, 'loop_content_link_begin' ), 15, 2 );

		add_action( 'decks-loop-content', 				array( $this, 'loop_content_image' ), 10, 2 );
		add_action( 'decks-loop-content', 				array( $this, 'loop_content_title' ), 15, 2 );
		add_action( 'decks-loop-content', 				array( $this, 'loop_content_subtitle' ), 20, 2 );

		add_action( 'decks-after-loop-content', 		array( $this, 'loop_content_link_end' ), 10, 2 );
		add_action( 'decks-after-loop-content', 		array( $this, 'loop_content_wrap_end' ), 90, 2 );

		add_action( 'decks-after-loop', 				array( $this, 'loop_wrap_end' ), 10, 1 );

		// Single
		add_action( 'decks-single-content', 			array( $this, 'single_slide_thumbnail' ), 10 );
		add_action( 'decks-single-content', 			array( $this, 'single_slide_posttitle' ), 15 );
		add_action( 'decks-single-content', 			array( $this, 'single_slide_subtitle' ), 20, 1 );
		add_action( 'decks-single-content', 			array( $this, 'single_slide_content' ), 25 );
		add_action( 'decks-single-content', 			array( $this, 'single_slide_meta_field' ), 30, 1 );

	} // hooks()


	/**
	 * Returns an array of the featured image details
	 *
	 * @param 	int 	$postID 		Post ID
	 * @return 	array 					Array of info about the featured image
	 */
	public function get_featured_images( $postID ) {

		if ( empty( $postID ) ) { return FALSE; }

		$imageID = get_post_thumbnail_id( $postID );

		if ( empty( $imageID ) ) { return FALSE; }

		return wp_prepare_attachment_for_js( $imageID );

	} // get_featured_images()

	/**
	 * Includes the link start template file
	 *
	 * @param 		object 		$item 		Post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function loop_content_link_begin( $item, $meta = array() ) {

		include decks_get_template( 'loop-content-link-begin', 'loop' );

	} // loop_content_link_begin()

	/**
	 * Includes the link end template file
	 *
	 * @param 		object 		$item 		Post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function loop_content_link_end( $item, $meta = array() ) {

		include decks_get_template( 'loop-content-link-end', 'loop' );

	} // loop_content_link_end()

	/**
	 * Includes the featured image template
	 *
	 * @hooked 		decks-loop-content 		10
	 *
	 * @param 		object 		$item 		A post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function loop_content_image( $item, $meta = array() ) {

		include decks_get_template( 'loop-content-image', 'loop' );

	} // loop_content_image()

	/**
	 * Includes the meta field template file
	 */
	public function loop_content_meta_field( $item, $meta = array() ) {

		include decks_get_template( 'loop-content-meta_field', 'loop' );

	} // loop_content_meta_field()

	/**
	 * Includes the decks-subtitle template
	 *
	 * @hooked 		decks-loop-content 		30
	 *
	 * @param 		object 		$item 		Post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function loop_content_subtitle( $item, $meta = array() ) {

		include decks_get_template( 'loop-content-subtitle', 'loop' );

	} // loop_content_subtitle()

	/**
	 * Includes the decks-title template
	 *
	 * @hooked 		decks-loop-content 		20
	 *
	 * @param 		object 		$item 		Post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function loop_content_title( $item, $meta = array() ) {

		include decks_get_template( 'loop-content_title', 'loop' );

	} // loop_content_title()

	/**
	 * Includes the content wrap start template file
	 *
	 * @hooked 		decks-before-loop-content 		10
	 *
	 * @param 		object 		$item 		Post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function loop_content_wrap_begin( $item, $meta = array() ) {

		include decks_get_template( 'loop-content-wrap-begin', 'loop' );

	} // loop_content_wrap_begin()

	/**
	 * Includes the content wrap end template file
	 *
	 * @param 		object 		$item 		Post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function loop_content_wrap_end( $item, $meta = array() ) {

		include decks_get_template( 'loop-content-wrap-end', 'loop' );

	} // loop_content_wrap_end()

	/**
	 * Includes the list wrap start template file and sets the value of $class.
	 *
	 * If the presentation shortcode attribute is used, it sets $class as the
	 * presentation or presentations. Otherwise, $class is blank.
	 *
	 * @param 		array 		$args 		The shortcode attributes
	 */
	public function loop_wrap_begin( $args ) {

		if ( empty( $args['presentation'] ) ) {

			$class = '';

		} elseif ( is_array( $args['presentation'] ) ) {

			$class = str_replace( ',', ' ', $args['presentation'] );

		} else {

			$class = $args['presentation'];

		}

		include decks_get_template( 'loop-wrap-begin', 'loop' );

	} // list_wrap_begin()

	/**
	 * Includes the list wrap end template file
	 *
	 * @param 		array 		$args 		The shortcode attributes
	 */
	public function loop_wrap_end( $args ) {

		include decks_get_template( 'loop-wrap-end', 'loop' );

	} // list_wrap_end()

	/**
	 * Sets the class variable $options
	 */
	private function set_options() {

		$this->options = get_option( DECKS_SLUG . '_options' );

	} // set_options()

	/**
	 * Includes the single slide meta field
	 *
	 * @param 		array 		$meta 		The post metadata
	 */
	public function single_slide_meta_field( $meta ) {

		include decks_get_template( 'single-slide-metafield', 'single' );

	} // single_slide_meta_field()

	/**
	 * Includes the single slide content
	 */
	public function single_slide_content() {

		include decks_get_template( 'single-slide-content', 'single' );

	} // single_slide_content()

	/**
	 * Includes the single slide post title
	 */
	public function single_slide_posttitle() {

		include decks_get_template( 'single-slide-posttitle', 'single' );

	} // single_slide_posttitle()

	/**
	 * Includes the single slide post title
	 */
	public function single_slide_subtitle( $meta ) {

		include decks_get_template( 'single-slide-subtitle', 'single' );

	} // single_slide_subtitle()

	/**
	 * Include the single slide thumbnail
	 */
	public function single_slide_thumbnail() {

		include decks_get_template( 'single-slide-thumbnail', 'single' );

	} // single_slide_thumbnail()

	/**
	 * Returns a reference to this class. Used for removing
	 * actions and/or filters declared here.
	 *
	 * @see 	http://hardcorewp.com/2012/enabling-action-and-filter-hook-removal-from-class-based-wordpress-plugins/
	 * @return 	object 		This class
	 */
	static function this() {

		return self::$_this;

	} // this()

} // class
