<?php

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
 * @package 	Decks
 * @subpackage 	Decks/classes
 * @author 		Slushman <chris@slushman.com>
 */
class Decks_Public {

	/**
	 * The post meta data
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$meta    			The post meta data.
	 */
	private $meta;

	/**
	 * The plugin options.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$options 		The plugin options.
	 */
	private $options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->set_options();
		$this->set_meta();

	} // __construct()

	/**
	 * Dequeues all other scripts from the presentation pages.
	 *
	 * @return 		array 		Modified $wp_scripts array
	 */
	public function dequeue_scripts() {

		if ( ! is_tax( 'presentation' ) ) { return; }

		global $wp_scripts;

		$wp_scripts->queue = array();

	} // dequeue_scripts()

	/**
	 * Dequeues all other stylsheets from the presentation pages.
	 *
	 * @return 		array 		Modified $wp_styles array
	 */
	public function dequeue_styles() {

		if ( ! is_tax( 'presentation' ) ) { return; }

		global $wp_styles;

		$wp_styles->queue = array();

	} // dequeue_styles()

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( DECKS_SLUG, plugin_dir_url( dirname( __FILE__ ) ) . 'assets/css/decks-public.min.css', array(), DECKS_VERSION, 'all' );

		wp_enqueue_style( DECKS_SLUG . '_reveal', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/css/reveal.min.css', array(), DECKS_VERSION, 'all' );

		wp_enqueue_style( DECKS_SLUG . '_defaulttheme', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/themes/default.min.css', array(), DECKS_VERSION, 'all' );

	} // enqueue_styles()

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( DECKS_SLUG . '-public', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/js/decks-public.min.js', array( 'jquery' ), DECKS_VERSION, true );

		wp_enqueue_script( 'headjs', '//cdnjs.cloudflare.com/ajax/libs/headjs/1.0.3/head.js', array(), DECKS_VERSION, true );

		wp_enqueue_script( 'reveal', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/js/reveal.min.js', array( 'headjs' ), DECKS_VERSION, true );

		wp_enqueue_script( 'html5shiv', '//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js', array(), DECKS_VERSION, true );
		wp_style_add_data( 'html5shiv', 'conditional', 'lt IE 9' );

	} // enqueue_scripts()

	/**
	 * [get_slides description]
	 * @return [type] [description]
	 */
	public function get_slides() {

		if ( ! is_tax( 'presentation' ) ) { return; }

		global $wp_query;

		$term =	$wp_query->queried_object;

		$args['tax_query']['taxonomy'] 	= 'presentation';
		$args['tax_query']['field'] 	= 'term_id';
		$args['tax_query']['terms'] 	= $term->term_id;

		$slides = decks_get_posts( 'slide', $args, $term->slug );

		if ( empty( $slides->posts ) ) { return; }

		while ( $slides->have_posts() ) : $slides->the_post();

			?><section id="<?php echo( basename( get_permalink() ) ); ?>"><?php

				the_content();

			?></section><?php

		endwhile;

	} // get_slides()

	/**
	 * Loops through plugin settings and initializes Reveal.
	 */
	public function initialize_settings() {

		if ( ! is_tax( 'presentation' ) ) { return; }

		// loop through settings
		// make sure settings names are converted to ones used by Reveal

	} // initialize_settings()

	/**
	 * Checks if the template is either taxonomy-presentation.php
	 * or taxonomy-presentation-{term-slug}.php.
	 *
	 * @param 		string 			$path 			The path.
	 * @return 		boolean 						TRUE if the path is the presentation template, otherwise FALSE.
	 */
	public function is_presentation_template( $path ) {

		$template = basename( $path );

		if ( 1 == preg_match( '/^taxonomy-presentation((-(\S*))?).php/', $template ) ) {

			return true;

		}

		return false;

	} // is_presentation_template()

	/**
	 * Loads the presentation taxonomy template.
	 *
	 * @param 		url 		$template 			The URL to the template.
	 * @return 		url 							The URL to the template.
	 */
	public function presentation_template( $template ) {

		if ( ! is_tax( 'presentation' ) ) { return $template; }
		if ( $this->is_presentation_template( $template ) ) { return $template; }

		return decks_get_template( 'taxonomy-presentation' );

	} // presentation_template()

	/**
	 * Sets the class variable $options
	 */
	public function set_meta() {

		global $post;

		if ( empty( $post ) ) { return; }
		if ( 'slide' !== $post->post_type ) { return; }

		$this->meta = get_post_custom( $post->ID );

	} // set_meta()

	/**
	 * Sets the class variable $options
	 */
	private function set_options() {

		$this->options = get_option( DECKS_SLUG . '-options' );

	} // set_options()

} // class
