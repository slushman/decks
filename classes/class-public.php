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
	 * Registers all the WordPress hooks and filters for this class.
	 */
	public function hooks() {

		add_action( 'wp_print_scripts', 		array( $this, 'dequeue_scripts' ), 99 );
		add_action( 'wp_print_styles', 			array( $this, 'dequeue_styles' ), 99 );
		add_action( 'wp_enqueue_scripts', 		array( $this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', 		array( $this, 'enqueue_scripts' ) );
		add_filter( 'template_include', 		array( $this, 'presentation_template' ) );
		add_filter( 'decks_slides', 			array( $this, 'get_slides' ) );
		add_filter( 'wp_print_footer_scripts', 	array( $this, 'initialize_reveal' ), 99, 1 );
		add_filter( 'decks_initialize', 		array( $this, 'initialize_settings' ) );
		add_filter( 'show_admin_bar', 			array( $this, 'remove_admin_bar' ) );

	} // hooks()

	/**
	 * Dequeues all other scripts from the presentation pages.
	 *
	 * @return 		array 		Modified $wp_scripts array
	 */
	public function dequeue_scripts() {

		if ( ! is_tax( 'presentation' ) ) { return; }

		global $wp_scripts;

		foreach ( $wp_scripts->registered as $key => $script ) {

			$pos = strpos( $key, DECKS_SLUG );

			if ( FALSE === $pos ) { unset( $wp_scripts->registered[$key] ); }

		}

		foreach ( $wp_scripts->queue as $count => $qued ) {

			$pos = strpos( $qued, DECKS_SLUG );

			if ( FALSE === $pos ) { unset( $wp_scripts->queue[$count] ); }

		}

	} // dequeue_scripts()

	/**
	 * Dequeues all other stylsheets from the presentation pages.
	 *
	 * @return 		array 		Modified $wp_styles array
	 */
	public function dequeue_styles() {

		if ( ! is_tax( 'presentation' ) ) { return; }

		global $wp_styles;

		foreach ( $wp_styles->registered as $key => $script ) {

			$pos = strpos( $key, DECKS_SLUG );

			if ( FALSE === $pos ) { unset( $wp_styles->registered[$key] ); }

		}

		foreach ( $wp_styles->queue as $count => $qued ) {

			$pos = strpos( $qued, DECKS_SLUG );

			if ( FALSE === $pos ) { unset( $wp_styles->queue[$count] ); }

		}

	} // dequeue_styles()

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		if ( ! is_tax( 'presentation' ) ) { return; }

		wp_enqueue_style( DECKS_SLUG . '-reveal', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/css/reveal.min.css', array(), DECKS_VERSION, 'all' );
		wp_enqueue_style( DECKS_SLUG . '-reveal-map', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/css/reveal.min.css.map', array(), DECKS_VERSION, 'all' );

		/**
		 * These cause weird formatting issues. Is there a way to have them available, but not on the presentation?
		 */
		/*
		wp_enqueue_style( DECKS_SLUG . '-reveal-pdf', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/css/print/pdf.min.css', array(), DECKS_VERSION, 'all' );
		wp_enqueue_style( DECKS_SLUG . '-reveal-pdf-map', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/css/print/pdf.min.css.map', array(), DECKS_VERSION, 'all' );
		*/

		wp_register_style( DECKS_SLUG . '-theme-beige', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/css/theme/beige.min.css', array(), DECKS_VERSION, 'all' );
		wp_register_style( DECKS_SLUG . '-theme-beige-map', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/css/theme/beige.min.css.map', array(), DECKS_VERSION, 'all' );
		wp_register_style( DECKS_SLUG . '-theme-black', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/css/theme/black.min.css', array(), DECKS_VERSION, 'all' );
		wp_register_style( DECKS_SLUG . '-theme-black-map', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/css/theme/black.min.css.map', array(), DECKS_VERSION, 'all' );
		wp_register_style( DECKS_SLUG . '-theme-blood', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/css/theme/blood.min.css', array(), DECKS_VERSION, 'all' );
		wp_register_style( DECKS_SLUG . '-theme-blood-map', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/css/theme/blood.min.css.map', array(), DECKS_VERSION, 'all' );
		wp_register_style( DECKS_SLUG . '-theme-league', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/css/theme/league.min.css', array(), DECKS_VERSION, 'all' );
		wp_register_style( DECKS_SLUG . '-theme-league-map', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/css/theme/league.min.css.map', array(), DECKS_VERSION, 'all' );
		wp_register_style( DECKS_SLUG . '-theme-moon', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/css/theme/moon.min.css', array(), DECKS_VERSION, 'all' );
		wp_register_style( DECKS_SLUG . '-theme-moon-map', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/css/theme/moon.min.css.map', array(), DECKS_VERSION, 'all' );
		wp_register_style( DECKS_SLUG . '-theme-night', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/css/theme/night.min.css', array(), DECKS_VERSION, 'all' );
		wp_register_style( DECKS_SLUG . '-theme-night-map', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/css/theme/night.min.css.map', array(), DECKS_VERSION, 'all' );
		wp_register_style( DECKS_SLUG . '-theme-paper', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/css/print/paper.min.css', array(), DECKS_VERSION, 'all' );
		wp_register_style( DECKS_SLUG . '-theme-paper-map', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/css/print/paper.min.css.map', array(), DECKS_VERSION, 'all' );
		wp_register_style( DECKS_SLUG . '-theme-serif', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/css/theme/serif.min.css', array(), DECKS_VERSION, 'all' );
		wp_register_style( DECKS_SLUG . '-theme-serif-map', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/css/theme/serif.min.css.map', array(), DECKS_VERSION, 'all' );
		wp_register_style( DECKS_SLUG . '-theme-simple', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/css/theme/simple.min.css', array(), DECKS_VERSION, 'all' );
		wp_register_style( DECKS_SLUG . '-theme-simple-map', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/css/theme/simple.min.css.map', array(), DECKS_VERSION, 'all' );
		wp_register_style( DECKS_SLUG . '-theme-sky', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/css/theme/sky.min.css', array(), DECKS_VERSION, 'all' );
		wp_register_style( DECKS_SLUG . '-theme-sky-map', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/css/theme/sky.min.css.map', array(), DECKS_VERSION, 'all' );
		wp_register_style( DECKS_SLUG . '-theme-solarized', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/css/theme/solarized.min.css', array(), DECKS_VERSION, 'all' );
		wp_register_style( DECKS_SLUG . '-theme-solarized-map', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/css/theme/solarized.min.css.map', array(), DECKS_VERSION, 'all' );
		wp_register_style( DECKS_SLUG . '-theme-white', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/css/theme/white.min.css', array(), DECKS_VERSION, 'all' );
		wp_register_style( DECKS_SLUG . '-theme-white-map', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/css/theme/white.min.css.map', array(), DECKS_VERSION, 'all' );
		wp_register_style( DECKS_SLUG . '-theme-zenburn', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/lib/css/zenburn.min.css', array(), DECKS_VERSION, 'all' );
		wp_register_style( DECKS_SLUG . '-theme-zenburn-map', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/lib/css/zenburn.min.css.map', array(), DECKS_VERSION, 'all' );

		wp_enqueue_style( $this->options['reveal_theme'] );
		wp_enqueue_style( $this->options['reveal_theme'] . '-map' );

		if ( 1 === $this->options['fonts_source_sans_pro'] ) {

			wp_enqueue_style( 'source-sans-pro-fonts', $this->fonts_url(), array(), null );

		}

		if ( 1 === $this->options['fonts_league_gothic'] ) {

			wp_enqueue_style( 'league-gothic-fonts', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/css/league-gothic.css', array(), null );

		}

	} // enqueue_styles()

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		if ( ! is_tax( 'presentation' ) ) { return; }

		/**
		 * Enqueue these scripts.
		 */
		wp_enqueue_script( DECKS_SLUG . '-headjs', '//cdnjs.cloudflare.com/ajax/libs/headjs/1.0.3/head.js', array(), DECKS_VERSION, true );
		wp_enqueue_script( DECKS_SLUG . '-reveal', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/js/reveal.min.js', array( DECKS_SLUG . '-headjs'  ), DECKS_VERSION, true );
		//wp_enqueue_script( DECKS_SLUG . '-print-pdf', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/plugin/print-pdf/print-pdf.min.js', array(), DECKS_VERSION, true );
		//wp_enqueue_script( DECKS_SLUG . '-search', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/plugin/search/search.min.js', array(), DECKS_VERSION, true );
		wp_enqueue_script( DECKS_SLUG . '-html5shiv', '//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js', array(), DECKS_VERSION, true );
		wp_script_add_data( DECKS_SLUG . '-html5shiv', 'conditional', 'lt IE 9' );

		/**
		 * Register scripts that might be used, based on plugin settings.
		 */
		/*wp_register_script( DECKS_SLUG . '-classlist', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/lib/js/classList.min.js', array(), DECKS_VERSION, true );
		wp_register_script( DECKS_SLUG . '-highlight', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/plugin/highlight/highlight.min.js', array(), DECKS_VERSION, true );
		wp_register_script( DECKS_SLUG . '-marked', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/plugin/markdown/marked.min.js', array(), DECKS_VERSION, true );
		wp_register_script( DECKS_SLUG . '-markdown', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/plugin/markdown/markdown.min.js', array( DECKS_SLUG . '-marked' ), DECKS_VERSION, true );
		wp_register_script( DECKS_SLUG . '-mathjax', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/plugin/math/math.min.js', array(), DECKS_VERSION, true );
		wp_register_script( DECKS_SLUG . '-multiplex-client', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/plugin/multiplex/client.min.js', array(), DECKS_VERSION, true );
		wp_register_script( DECKS_SLUG . '-multiplex', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/plugin/multiplex/index.min.js', array(), DECKS_VERSION, true );
		wp_register_script( DECKS_SLUG . '-multiplex-master', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/plugin/multiplex/master.min.js', array(), DECKS_VERSION, true );
		wp_register_script( DECKS_SLUG . '-notes-client', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/plugin/notes-server/client.min.js', array(), DECKS_VERSION, true );
		wp_register_script( DECKS_SLUG . '-notes-server', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/plugin/notes-server/index.min.js', array(), DECKS_VERSION, true );
		wp_register_script( DECKS_SLUG . '-notes', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/plugin/notes/notes.min.js', array(), DECKS_VERSION, true );
		wp_register_script( DECKS_SLUG . '-zoom', '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.3.0/plugin/zoom-js/zoom.min.js', array(), DECKS_VERSION, true );

		$deps = array( 'classlist', 'highlight', 'mathjax', 'zoom', 'notes' );

		foreach ( $deps as $dep ) {

			if ( ! empty( $this->options['dependency_' . $dep] ) ) {

				wp_enqueue_script( DECKS_SLUG . '-' . $dep );

			}

		}

		if ( ! empty( $this->options['dependency_notes_server'] ) ) {

			wp_enqueue_script( DECKS_SLUG . '-notes-server' );

		}

		if ( ! empty( $this->options['dependency_markdown'] ) ) {

			wp_enqueue_script( DECKS_SLUG . '-marked' );
			wp_enqueue_script( DECKS_SLUG . '-markdown' );

		}

		if ( ! empty( $this->options['multiplexing'] ) ) {

			wp_enqueue_script( DECKS_SLUG . '-multiplex' );
			wp_enqueue_script( DECKS_SLUG . '-multiplex-client' );
			wp_enqueue_script( DECKS_SLUG . '-multiplex-master' );

		}*/

	} // enqueue_scripts()

	/**
	 * Properly encode a font URLs to enqueue a Google font
	 *
	 * @see 		enqueue_public()
	 * @return 		mixed 		A properly formatted, translated URL for a Google font
	 */
	public static function fonts_url() {

		$return 	= '';
		$families 	= '';
		$fonts[] 	= array( 'font' => 'Source Sans Pro', 'weights' => '400,400i,600,600i', 'translate' => esc_html_x( 'on', 'Source Sans Pro font: on or off', 'rosh' ) );

		foreach ( $fonts as $font ) {

			if ( 'off' == $font['translate'] ) { continue; }

			$families[] = $font['font'] . ':' . $font['weights'];

		}

		if ( ! empty( $families ) ) {

			$query_args['family'] 	= urlencode( implode( '|', $families ) );
			$query_args['subset'] 	= urlencode( 'latin' );
			$return 				= add_query_arg( $query_args, '//fonts.googleapis.com/css' );

		}

		return $return;

	} // fonts_url()

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
	 * Displays the Reveal initialization script in the footer.
	 *
	 * @param 		obj 		$presentation 		The presentation object.
	 * @return 		mixed 							The Reveal initialization markup.
	 */
	public function initialize_reveal( $presentation ) {

		if ( ! is_tax( 'presentation' ) ) { return; }

		?><script>
			Reveal.initialize({<?php

			/**
			 * The decks_initialize action hook.
			 *
			 * All plugin settings are hooked here.
			 *
			 * @hooked
			 */
			do_action( 'decks_initialize', $presentation );

			?>});
		</script><?php

	} // initialize_reveal()

	/**
	 * Loops through plugin settings and initializes Reveal.
	 */
	public function initialize_settings() {

		if ( ! is_tax( 'presentation' ) ) { return; }

		$valid['controls'] 						= 'display_controls';
		$valid['progress'] 						= 'display_progress';
		$valid['slideNumber'] 					= 'display_slidenumber';
		$valid['history'] 						= 'browser_history';
		$valid['keyboard'] 						= 'enable_keyboard_shortcuts';
		$valid['overview'] 						= 'overview_mode';
		$valid['center'] 						= 'vertically_center';
		$valid['touch'] 						= 'enable_touch';
		$valid['loop'] 							= 'loop';
		$valid['rtl'] 							= 'rtl_direction';
		$valid['shuffle'] 						= 'shuffle';
		$valid['fragments'] 					= 'fragments';
		$valid['embedded'] 						= 'embedded_mode';
		$valid['help'] 							= 'help_overlay';
		$valid['showNotes'] 					= 'display_notes';
		$valid['autoSlide'] 					= 'autoslide';
		$valid['autoSlideStoppable'] 			= 'autoslide_stoppable';
		$valid['autoSlideMethod'] 				= 'autoslide_method';
		$valid['mouseWheel'] 					= 'mouse_wheel';
		$valid['hideAddressBar'] 				= 'hide_address_bar';
		$valid['previewLinks'] 					= 'preview_links';
		$valid['transition'] 					= 'transition';
		$valid['transitionSpeed'] 				= 'transition_speed';
		$valid['backgroundTransition'] 			= 'transition_bg';
		$valid['viewDistance'] 					= 'view_distance';
		$valid['parallaxBackgroundImage'] 		= 'parallax_bgimg';
		$valid['parallaxBackgroundSize'] 		= 'parallax_bgsize';
		$valid['parallaxBackgroundHorizontal'] 	= 'parallax_bghorizontal';
		$valid['parallaxBackgroundVertical'] 	= 'parallax_bgvertical';

		foreach ( $valid as $key => $option ) {

			if ( '' === $this->options[$option] ) {

				continue;

			} elseif ( is_int( $this->options[$option] ) ) {

				$value = ( 0 === $this->options[$option] ? 'false' : 'true' );

			} elseif ( is_string( $this->options[$option] ) ) {

				$value = "'" . $this->options[$option] . "'";

			} else {

				$value = $this->options[$option];

			}

			echo $key . ': ' . $value;

			if ( 'parallaxBackgroundVertical' !== $key ) {

				echo ', ';

			}

		}

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
	 * Removes the admin bar for presentations.
	 *
	 * @return 		bool 		FALSE if a presentation, otherwise TRUE.
	 */
	public function remove_admin_bar() {

		if ( is_tax( 'presentation' ) ) { return FALSE; }

		return TRUE;

	} // remove_admin_bar()

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

		$this->options = get_option( DECKS_SLUG . '_options' );

	} // set_options()

} // class
