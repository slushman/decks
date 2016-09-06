 <?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link 		http://wpdecks.com
 * @since 		1.0.0
 *
 * @package 	Decks
 * @subpackage 	Decks/classes
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * @package 	Decks
 * @subpackage 	Decks/classes
 * @author 		Slushman <chris@slushman.com>
 */
class Decks_Admin {

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
	 * @since 		1.0.0
	 */
	public function __construct() {

		$this->set_options();

	} // __construct()

	/**
	 * Adds a settings page link to a menu
	 *
	 * @link 		https://codex.wordpress.org/classesistration_Menus
	 * @since 		1.0.0
	 */
	public function add_menu() {

		// Top-level page
		// add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );

		// Submenu Page
		// add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function);

		add_submenu_page(
			'edit.php?post_type=slide',
			apply_filters( DECKS_SLUG . '_settings_page_title', esc_html__( 'Decks Settings', 'decks' ) ),
			apply_filters( DECKS_SLUG . '_settings_menu_title', esc_html__( 'Settings', 'decks' ) ),
			'manage_options',
			DECKS_SLUG . '-settings',
			array( $this, 'page_options' )
		);

		add_submenu_page(
			'edit.php?post_type=slide',
			apply_filters( DECKS_SLUG . '_settings_page_title', esc_html__( 'Decks Help', 'decks' ) ),
			apply_filters( DECKS_SLUG . '_settings_menu_title', esc_html__( 'Help', 'decks' ) ),
			'manage_options',
			DECKS_SLUG . '-help',
			array( $this, 'page_help' )
		);

	} // add_menu()

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( DECKS_SLUG . '-admin', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/css/decks-admin.css', array(), DECKS_VERSION, 'all' );
		wp_enqueue_style( DECKS_SLUG . '-datepicker', '//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css', array(), DECKS_VERSION, 'all' );
		wp_enqueue_style( DECKS_SLUG . '-timepicker', '//cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css', array(), DECKS_VERSION, 'all' );

	} // enqueue_styles()

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_media();

		wp_enqueue_script( 'timepicker', '//cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js', array( 'jquery', 'jquery-ui-datepicker', 'jquery-ui-slider' ), DECKS_VERSION, true );

		wp_enqueue_script( DECKS_SLUG . '-admin', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/js/decks-admin.min.js', array( 'jquery', 'media-upload', 'jquery-ui-datepicker', 'wp-color-picker', 'timepicker', 'jquery-ui-slider' ), DECKS_VERSION, true );

	} // enqueue_scripts()

	/**
	 * Creates a checkbox field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 *
	 * @return 	string 						The HTML field
	 */
	public function field_checkbox( $args ) {

		$defaults['name'] = DECKS_SLUG . '-options[' . $args['id'] . ']';

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

		}

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'views/fields/checkbox.php' );

	} // field_checkbox()

	/**
	 * Creates a set of radios field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 *
	 * @return 	string 						The HTML field
	 */
	public function field_radios( $args ) {

		$defaults['name'] = DECKS_SLUG . '-options[' . $args['id'] . ']';

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

		}

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'views/fields/radios.php' );

	} // field_radios()

	/**
	 * Creates a select field
	 *
	 * Note: label is blank since its created in the Settings API
	 *
	 * @param 	array 		$args 			The arguments for the field
	 *
	 * @return 	string 						The HTML field
	 */
	public function field_select( $args ) {

		$defaults['name'] = DECKS_SLUG . '-options[' . $args['id'] . ']';

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

		}

		if ( empty( $atts['aria'] ) && ! empty( $atts['description'] ) ) {

			$atts['aria'] = $atts['description'];

		} elseif ( empty( $atts['aria'] ) && ! empty( $atts['label'] ) ) {

			$atts['aria'] = $atts['label'];

		}

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'views/fields/select.php' );

	} // field_select()

	/**
	 * Creates a text field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 *
	 * @return 	string 						The HTML field
	 */
	public function field_text( $args ) {

		$defaults['name'] = DECKS_SLUG . '-options[' . $args['id'] . ']';

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

		}

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'views/fields/text.php' );

	} // field_text()

	/**
	 * Creates a textarea field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 *
	 * @return 	string 						The HTML field
	 */
	public function field_textarea( $args ) {

		$defaults['name'] = DECKS_SLUG . '-options[' . $args['id'] . ']';

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

		}

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'views/fields/textarea.php' );

	} // field_textarea()

	/**
	 * Creates a text field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 *
	 * @return 	string 						The HTML field
	 */
	public function field_upload( $args ) {

		$defaults['name'] = DECKS_SLUG . '-options[' . $args['id'] . ']';

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

		}

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'views/fields/file-upload.php' );

	} // field_upload()

	/**
	 * Returns an array of options names, fields types, and default values
	 *
	 * $options[] = array( 'setting_name', 'field_type', 'default_value' );
	 *
	 * @return 		array 			An array of options
	 */
	public static function get_options_list() {

		$options = array();

		$options[] = array( 'display_controls', 'checkbox', 1 );
		$options[] = array( 'display_progress', 'checkbox', 1 );
		$options[] = array( 'display_slidenumber', 'checkbox', 0 );
		$options[] = array( 'vertically_center', 'checkbox', 1 );
		$options[] = array( 'help_overlay', 'checkbox', 1 );
		$options[] = array( 'display_notes', 'checkbox', 0 );
		$options[] = array( 'view_distance', 'number', 3 );
		$options[] = array( 'hide_address_bar', 'checkbox', 1 );

		$options[] = array( 'enable_keyboard_shortcuts', 'checkbox', 1 );
		$options[] = array( 'enable_touch', 'checkbox', 1 );
		$options[] = array( 'loop', 'checkbox', 0 );
		$options[] = array( 'rtl_direction', 'checkbox', 0 );
		$options[] = array( 'shuffle', 'checkbox', 0 );
		$options[] = array( 'mouse_wheel', 'checkbox', 1 );
		$options[] = array( 'preview_links', 'checkbox', 0 );

		$options[] = array( 'browser_history', 'checkbox', 0 );
		$options[] = array( 'overview_mode', 'checkbox', 1 );
		$options[] = array( 'fragments', 'checkbox', 1 );
		$options[] = array( 'embedded_mode', 'checkbox', 0 );

		$options[] = array( 'autoslide', 'number', 0 );
		$options[] = array( 'autoslide_stoppable', 'checkbox', 1 );
		$options[] = array( 'autoslide_method', 'text', 'Reveal.navigateNext' );

		$options[] = array( 'transition', 'select', 'default' );
		$options[] = array( 'transition-out', 'select', 'default' );
		$options[] = array( 'transition_speed', 'select', 'default' );
		$options[] = array( 'transition_bg', 'select', 'default' );

		$options[] = array( 'parallax_bgimg', 'file_uploader', '' );
		$options[] = array( 'parallax_bgsize', 'text', '' );
		$options[] = array( 'parallax_bghorizontal', 'number', null );
		$options[] = array( 'parallax_bgvertical', 'number', null );

		return $options;

	} // get_options_list()

	/**
	 * Returns the registered settings section global array.
	 *
	 * @return 		array 		Settings sections.
	 */
	protected function get_settings_sections() {

		global $wp_settings_sections;

		return $wp_settings_sections;

	} // get_settings_sections

	/**
	 * Adds a link to the plugin settings page
	 *
	 * @since 		1.0.0
	 *
	 * @param 		array 		$links 		The current array of links
	 *
	 * @return 		array 					The modified array of links
	 */
	public function link_settings( $links ) {

		$links[] = sprintf( '<a href="%s">%s</a>', admin_url( 'edit.php?post_type=slide&page=decks-settings' ), esc_html__( 'Settings', 'decks' ) );

		return $links;

	} // link_settings()

	/**
	 * Adds links to the plugin links row
	 *
	 * @since 		1.0.0
	 *
	 * @param 		array 		$links 		The current array of row links
	 * @param 		string 		$file 		The name of the file
	 *
	 * @return 		array 					The modified array of row links
	 */
	public function link_row_meta( $links, $file ) {

		if ( $file == DECKS_FILE ) {

			$links[] = '<a href="http://twitter.com/slushman">Twitter</a>';

		}

		return $links;

	} // link_row_meta()

	/**
	 * Includes the help page view
	 *
	 * @since 		1.0.0
	 *
	 * @return 		void
	 */
	public function page_help() {

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'views/pages/help.php' );

	} // page_help()

	/**
	 * Includes the options page view
	 *
	 * @since 		1.0.0
	 *
	 * @return 		void
	 */
	public function page_options() {

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'views/pages/settings.php' );

	} // page_options()

	/**
	 * Registers settings fields with WordPress
	 */
	public function register_fields() {

		// add_settings_field( $id, $title, $callback, $menu_slug, $section, $args );

		/**
		 * Display Settings
		 */
		add_settings_field(
			'display_controls',
			esc_html__( 'Display Controls', 'decks' ),
			array( $this, 'field_checkbox' ),
			DECKS_SLUG,
			DECKS_SLUG . '-displaysettings',
			array(
				'description' 	=> __( 'Display controls in the bottom right corner.', 'decks' ),
				'id' 			=> 'display_controls',
				'value' 		=> 1
			)
		);

		add_settings_field(
			'display_progress',
			esc_html__( 'Display Progress Bar', 'decks' ),
			array( $this, 'field_checkbox' ),
			DECKS_SLUG,
			DECKS_SLUG . '-displaysettings',
			array(
				'description' 	=> __( 'Display a presentation progress bar.', 'decks' ),
				'id' 			=> 'display_progress',
				'value' 		=> 1
			)
		);

		add_settings_field(
			'display_slidenumber',
			esc_html__( 'Display Slide Numbers', 'decks' ),
			array( $this, 'field_checkbox' ),
			DECKS_SLUG,
			DECKS_SLUG . '-displaysettings',
			array(
				'description' 	=> __( 'Display the page number of the current slide.', 'decks' ),
				'id' 			=> 'display_slidenumber',
				'value' 		=> 0
			)
		);

		add_settings_field(
			'vertically_center',
			esc_html__( 'Vertically Center', 'decks' ),
			array( $this, 'field_checkbox' ),
			DECKS_SLUG,
			DECKS_SLUG . '-displaysettings',
			array(
				'description' 	=> __( 'Vertical centering of slides.', 'decks' ),
				'id' 			=> 'vertically_center',
				'value' 		=> 1
			)
		);

		add_settings_field(
			'help_overlay',
			esc_html__( 'Help Overlay', 'decks' ),
			array( $this, 'field_checkbox' ),
			DECKS_SLUG,
			DECKS_SLUG . '-displaysettings',
			array(
				'description' 	=> __( 'Show the help overlay when the ? key is pressed.', 'decks' ),
				'id' 			=> 'help_overlay',
				'value' 		=> 1
			)
		);

		add_settings_field(
			'display_notes',
			esc_html__( 'Display Notes', 'decks' ),
			array( $this, 'field_checkbox' ),
			DECKS_SLUG,
			DECKS_SLUG . '-displaysettings',
			array(
				'description' 	=> __( 'Display speaker notes to all viewers.', 'decks' ),
				'id' 			=> 'display_notes',
				'value' 		=> 0
			)
		);

		add_settings_field(
			'view_distance',
			esc_html__( 'View Distance', 'decks' ),
			array( $this, 'field_text' ),
			DECKS_SLUG,
			DECKS_SLUG . '-displaysettings',
			array(
				'description' 	=> __( 'Number of slides away from the current that are visible.', 'decks' ),
				'id' 			=> 'view_distance',
				'type' 			=> 'number',
				'value' 		=> 3
			)
		);

		add_settings_field(
			'hide_address_bar',
			esc_html__( 'Hide Address Bar', 'decks' ),
			array( $this, 'field_checkbox' ),
			DECKS_SLUG,
			DECKS_SLUG . '-displaysettings',
			array(
				'description' 	=> __( 'Hides the address bar on mobile devices.', 'decks' ),
				'id' 			=> 'hide_address_bar',
				'value' 		=> 1
			)
		);

		/**
		 * Presentation Controls Settings
		 */
		add_settings_field(
			'enable_keyboard_shortcuts',
			esc_html__( 'Enable Keyboard Shortcuts', 'decks' ),
			array( $this, 'field_checkbox' ),
			DECKS_SLUG,
			DECKS_SLUG . '-controls',
			array(
				'description' 	=> __( 'Enable keyboard shortcuts for navigation.', 'decks' ),
				'id' 			=> 'enable_keyboard_shortcuts',
				'value' 		=> 1
			)
		);

		add_settings_field(
			'enable_touch',
			esc_html__( 'Enable Touch', 'decks' ),
			array( $this, 'field_checkbox' ),
			DECKS_SLUG,
			DECKS_SLUG . '-controls',
			array(
				'description' 	=> __( 'Enables touch navigation on devices with touch input.', 'decks' ),
				'id' 			=> 'enable_touch',
				'value' 		=> 1
			)
		);

		add_settings_field(
			'loop',
			esc_html__( 'Loop Presentation', 'decks' ),
			array( $this, 'field_checkbox' ),
			DECKS_SLUG,
			DECKS_SLUG . '-controls',
			array(
				'description' 	=> __( 'Loop the presentation.', 'decks' ),
				'id' 			=> 'loop',
				'value' 		=> 0
			)
		);

		add_settings_field(
			'rtl_direction',
			esc_html__( 'RTL Direction', 'decks' ),
			array( $this, 'field_checkbox' ),
			DECKS_SLUG,
			DECKS_SLUG . '-controls',
			array(
				'description' 	=> __( 'Change the presentation direction to be RTL.', 'decks' ),
				'id' 			=> 'rtl_direction',
				'value' 		=> 0
			)
		);

		add_settings_field(
			'shuffle',
			esc_html__( 'Shuffle', 'decks' ),
			array( $this, 'field_checkbox' ),
			DECKS_SLUG,
			DECKS_SLUG . '-controls',
			array(
				'description' 	=> __( 'Randomizes the order of slides each time the presentation loads.', 'decks' ),
				'id' 			=> 'shuffle',
				'value' 		=> 0
			)
		);

		add_settings_field(
			'mouse_wheel',
			esc_html__( 'Mouse Wheel', 'decks' ),
			array( $this, 'field_checkbox' ),
			DECKS_SLUG,
			DECKS_SLUG . '-controls',
			array(
				'description' 	=> __( 'Enable slide navigation via mouse wheel.', 'decks' ),
				'id' 			=> 'mouse_wheel',
				'value' 		=> 0
			)
		);

		add_settings_field(
			'preview_links',
			esc_html__( 'Preview Links', 'decks' ),
			array( $this, 'field_checkbox' ),
			DECKS_SLUG,
			DECKS_SLUG . '-controls',
			array(
				'description' 	=> __( 'Open links in an iframe preview overlay.', 'decks' ),
				'id' 			=> 'preview_links',
				'value' 		=> 0
			)
		);

		/**
		 * Behavior Settings
		 */
		add_settings_field(
			'browser_history',
			esc_html__( 'Browser History', 'decks' ),
			array( $this, 'field_checkbox' ),
			DECKS_SLUG,
			DECKS_SLUG . '-behavior',
			array(
				'description' 	=> __( 'Push each slide change to the browser history.', 'decks' ),
				'id' 			=> 'browser_history',
				'value' 		=> 0
			)
		);

		add_settings_field(
			'overview_mode',
			esc_html__( 'Overview Mode', 'decks' ),
			array( $this, 'field_checkbox' ),
			DECKS_SLUG,
			DECKS_SLUG . '-behavior',
			array(
				'description' 	=> __( 'Enable the slide overview mode.', 'decks' ),
				'id' 			=> 'overview_mode',
				'value' 		=> 1
			)
		);

		add_settings_field(
			'fragments',
			esc_html__( 'Fragments on/off', 'decks' ),
			array( $this, 'field_checkbox' ),
			DECKS_SLUG,
			DECKS_SLUG . '-behavior',
			array(
				'description' 	=> __( 'Turns fragments on  and off globally.', 'decks' ),
				'id' 			=> 'fragments',
				'value' 		=> 1
			)
		);

		add_settings_field(
			'embedded_mode',
			esc_html__( 'Embedded Mode', 'decks' ),
			array( $this, 'field_checkbox' ),
			DECKS_SLUG,
			DECKS_SLUG . '-behavior',
			array(
				'description' 	=> __( 'Check if the presentation is running in embedded mode.', 'decks' ),
				'id' 			=> 'embedded_mode',
				'value' 		=> 0
			)
		);

		/**
		 * Autoslide Settings
		 */
		 add_settings_field(
 			'autoslide',
 			esc_html__( 'Autoslide', 'decks' ),
 			array( $this, 'field_text' ),
 			DECKS_SLUG,
 			DECKS_SLUG . '-autoslide',
 			array(
 				'description' 	=> __( 'Number of milliseconds between automatically proceeding to the next slide. Disabled when set to 0. Can be overriden on each slide.', 'decks' ),
 				'id' 			=> 'autoslide',
				'type' 			=> 'number',
 				'value' 		=> 0
 			)
 		);

		add_settings_field(
			'autoslide_stoppable',
			esc_html__( 'Embedded Mode', 'decks' ),
			array( $this, 'field_checkbox' ),
			DECKS_SLUG,
			DECKS_SLUG . '-autoslide',
			array(
				'description' 	=> __( 'Stop auto-sliding after user input.', 'decks' ),
				'id' 			=> 'autoslide_stoppable',
				'value' 		=> 1
			)
		);

		add_settings_field(
			'autoslide_method',
			esc_html__( 'Autoslide Method', 'decks' ),
			array( $this, 'field_text' ),
			DECKS_SLUG,
			DECKS_SLUG . '-autoslide',
			array(
				'description' 	=> __( 'Use this method for navigation when auto-sliding.', 'decks' ),
				'id' 			=> 'autoslide_method',
				'value' 		=> 'Reveal.navigateNext'
			)
		);

		/**
		 * Transition Settings
		 */
		 add_settings_field(
 		   'transition',
 		   esc_html__( 'Transition', 'decks' ),
 		   array( $this, 'field_select' ),
 		   DECKS_SLUG,
 		   DECKS_SLUG . '-transition',
 		   array(
 			   'description' 	=> __( 'Transition style. If anything other than "default" is selected for transition out, this becomes the default transition in.', 'decks' ),
 			   'id' 			=> 'transition',
			   'selections' 	=> array(
				   	array( 'label' => __( 'Default', 'decks' ), 'value' => 'default' ),
					array( 'label' => __( 'None', 'decks' ), 'value' => 'none' ),
					array( 'label' => __( 'Fade', 'decks' ), 'value' => 'fade' ),
					array( 'label' => __( 'Slide', 'decks' ), 'value' => 'slide' ),
					array( 'label' => __( 'Convex', 'decks' ), 'value' => 'convex' ),
					array( 'label' => __( 'Concave', 'decks' ), 'value' => 'concave' ),
					array( 'label' => __( 'Zoom', 'decks' ), 'value' => 'zoom' )
				),
 			   'value' 			=> 'default'
 		   )
 	   );

	   add_settings_field(
		 'transition-out',
		 esc_html__( 'Transition Out', 'decks' ),
		 array( $this, 'field_select' ),
		 DECKS_SLUG,
		 DECKS_SLUG . '-transition',
		 array(
			 'description' 	=> __( 'Transition-out style. If anything other than "default" is selected, this becomes the default transition out and the transition setting becomes the default transition in.', 'decks' ),
			 'id' 			=> 'transition-out',
			 'selections' 	=> array(
				 array( 'label' => __( 'Default', 'decks' ), 'value' => 'default' ),
				  array( 'label' => __( 'None', 'decks' ), 'value' => 'none' ),
				  array( 'label' => __( 'Fade', 'decks' ), 'value' => 'fade' ),
				  array( 'label' => __( 'Slide', 'decks' ), 'value' => 'slide' ),
				  array( 'label' => __( 'Convex', 'decks' ), 'value' => 'convex' ),
				  array( 'label' => __( 'Concave', 'decks' ), 'value' => 'concave' ),
				  array( 'label' => __( 'Zoom', 'decks' ), 'value' => 'zoom' )
			  ),
			 'value' 			=> 'default'
		 )
	 );

 	   add_settings_field(
 		   'transition_speed',
 		   esc_html__( 'Transition Speed', 'decks' ),
 		   array( $this, 'field_select' ),
 		   DECKS_SLUG,
 		   DECKS_SLUG . '-transition',
 		   array(
 			   'description' 	=> __( 'Stop auto-sliding after user input.', 'decks' ),
 			   'id' 			=> 'transition_speed',
			   'selections' 	=> array(
					array( 'label' => __( 'Default', 'decks' ), 'value' => 'default' ),
					array( 'label' => __( 'Fast', 'decks' ), 'value' => 'fast' ),
					array( 'label' => __( 'Slow', 'decks' ), 'value' => 'slow' )
				),
 			   'value' 			=> 'default'
 		   )
 	   );

 	   add_settings_field(
 		   'transition_bg',
 		   esc_html__( 'Background Transition', 'decks' ),
 		   array( $this, 'field_select' ),
 		   DECKS_SLUG,
 		   DECKS_SLUG . '-transition',
 		   array(
 			   'description' 	=> __( 'Use this method for navigation when auto-sliding.', 'decks' ),
 			   'id' 			=> 'transition_bg',
			   'selections' 	=> array(
				   array( 'label' => __( 'Default', 'decks' ), 'value' => 'default' ),
					array( 'label' => __( 'None', 'decks' ), 'value' => 'none' ),
					array( 'label' => __( 'Fade', 'decks' ), 'value' => 'fade' ),
					array( 'label' => __( 'Slide', 'decks' ), 'value' => 'slide' ),
					array( 'label' => __( 'Convex', 'decks' ), 'value' => 'convex' ),
					array( 'label' => __( 'Concave', 'decks' ), 'value' => 'concave' ),
					array( 'label' => __( 'Zoom', 'decks' ), 'value' => 'zoom' )
				),
 			   'value' 			=> 'default'
 		   )
 	   );

		/**
		 * Parallax Settings
		 */
		 add_settings_field(
	 		  'parallax_bgimg',
	 		  esc_html__( 'Parallax Background Image', 'decks' ),
	 		  array( $this, 'field_uploader' ),
	 		  DECKS_SLUG,
	 		  DECKS_SLUG . '-parallax',
	 		  array(
	 			  'description' 	=> __( '', 'decks' ),
	 			  'id' 			=> 'parallax_bgimg',
	 			  'value' 			=> ''
	 		  )
		  );

		 add_settings_field(
 		   'parallax_bgsize',
 		   esc_html__( 'Parallax Background Image Size', 'decks' ),
 		   array( $this, 'field_text' ),
 		   DECKS_SLUG,
 		   DECKS_SLUG . '-parallax',
 		   array(
 			   'description' 	=> __( 'Use CSS syntax like: 2100px 900px.', 'decks' ),
 			   'id' 			=> 'parallax_bgsize',
			   'label-remove' 	=> esc_html__( 'Remove Image', 'decks' ),
			   'label-upload' 	=> esc_html__( 'Choose/Upload Image', 'decks' ),
 			   'value' 			=> ''
 		   )
 	   );

	   add_settings_field(
		  'parallax_bghorizontal',
		  esc_html__( 'Parallax Background Horizontal', 'decks' ),
		  array( $this, 'field_text' ),
		  DECKS_SLUG,
		  DECKS_SLUG . '-parallax',
		  array(
			  'description' 	=> __( 'Number of pixels to move the parallax background per slide on the horizontal axis. Set to 0 to disable horizontal movement. If not, set this will calculated automatically.', 'decks' ),
			  'id' 				=> 'parallax_bghorizontal',
			  'type' 			=> 'number',
			  'value' 			=> ''
		  )
	  );

	  add_settings_field(
		 'parallax_bgvertical',
		 esc_html__( 'Autoslide', 'decks' ),
		 array( $this, 'field_text' ),
		 DECKS_SLUG,
		 DECKS_SLUG . '-parallax',
		 array(
			 'description' 		=> __( 'Number of pixels to move the parallax background per slide on the vertical axis. Set to 0 to disable vertical movement. If not, set this will calculated automatically..', 'decks' ),
			 'id' 				=> 'parallax_bgvertical',
			 'type' 			=> 'number',
			 'value' 			=> ''
		 )
	  );


	  /**
	   * Dependencies Settings
	   */
	   add_settings_field(
 		  'dependency_classlist',
 		  esc_html__( 'ClassList', 'decks' ),
 		  array( $this, 'field_checkbox' ),
 		  DECKS_SLUG,
 		  DECKS_SLUG . '-dependencies',
 		  array(
 			  'description' => __( 'Cross-browser shim that fully implements classList.', 'decks' ),
 			  'id' 			=> 'dependency_classlist',
 			  'value' 		=> 1
 		  )
 	  );

	  add_settings_field(
		  'dependency_markdown',
		  esc_html__( 'Markdown', 'decks' ),
		  array( $this, 'field_checkbox' ),
		  DECKS_SLUG,
		  DECKS_SLUG . '-dependencies',
		  array(
			  'description' => __( 'Interpret Markdown in <section> elements.', 'decks' ),
			  'id' 			=> 'dependency_markdown',
			  'value' 		=> 1
		  )
	  );

	  add_settings_field(
		  'dependency_highlight',
		  esc_html__( 'Syntax Highlighting', 'decks' ),
		  array( $this, 'field_checkbox' ),
		  DECKS_SLUG,
		  DECKS_SLUG . '-dependencies',
		  array(
			  'description' => __( 'Syntax highlight for <code> elements.', 'decks' ),
			  'id' 			=> 'dependency_highlight',
			  'value' 		=> 1
		  )
	  );

	  add_settings_field(
		  'dependency_zoom',
		  esc_html__( 'Zooming', 'decks' ),
		  array( $this, 'field_checkbox' ),
		  DECKS_SLUG,
		  DECKS_SLUG . '-dependencies',
		  array(
			  'description' => __( 'Zoom in and out with alt+click.', 'decks' ),
			  'id' 			=> 'dependency_zoom',
			  'value' 		=> 1
		  )
	  );

	  add_settings_field(
		  'dependency_notes',
		  esc_html__( 'Speaker Notes', 'decks' ),
		  array( $this, 'field_checkbox' ),
		  DECKS_SLUG,
		  DECKS_SLUG . '-dependencies',
		  array(
			  'description' => __( '', 'decks' ),
			  'id' 			=> 'dependency_notes',
			  'value' 		=> 1
		  )
	  );

	  add_settings_field(
		  'dependency_mathjax',
		  esc_html__( 'MathJax', 'decks' ),
		  array( $this, 'field_checkbox' ),
		  DECKS_SLUG,
		  DECKS_SLUG . '-dependencies',
		  array(
			  'description' => __( '', 'decks' ),
			  'id' 			=> 'dependency_mathjax',
			  'value' 		=> 1
		  )
	  );

	  add_settings_field(
		  'dependency_server_notes',
		  esc_html__( 'Server Side Speaker Notes', 'decks' ),
		  array( $this, 'field_checkbox' ),
		  DECKS_SLUG,
		  DECKS_SLUG . '-dependencies',
		  array(
			  'description' => __( 'Run your speaker notes on a separate device.', 'decks' ),
			  'id' 			=> 'dependency_server_notes',
			  'value' 		=> 1
		  )
	  );


	  /**
	   * Multiplexing Settings
	   */
	  add_settings_field(
		  'multiplexing',
		  esc_html__( 'Multiplexing', 'decks' ),
		  array( $this, 'field_checkbox' ),
		  DECKS_SLUG,
		  DECKS_SLUG . '-multiplexing',
		  array(
			  'description' => __( 'Allow your audience to view your presentation on their devices.', 'decks' ),
			  'id' 			=> 'multiplexing',
			  'value' 		=> 0
		  )
	  );

	  add_settings_field(
		 'multiplexing_secret',
		 esc_html__( 'Multiplexing Secret', 'decks' ),
		 array( $this, 'field_text' ),
		 DECKS_SLUG,
		 DECKS_SLUG . '-multiplexing',
		 array(
			 'description' 		=> __( 'Obtained from the socket.io server. Gives this (the master) control of the presentation.', 'decks' ),
			 'id' 				=> 'multiplexing_secret',
			 'type' 			=> 'text',
			 'value' 			=> ''
		 )
	  );

	  add_settings_field(
		 'multiplexing_id',
		 esc_html__( 'Multiplexing ID', 'decks' ),
		 array( $this, 'field_text' ),
		 DECKS_SLUG,
		 DECKS_SLUG . '-multiplexing',
		 array(
			 'description' 		=> __( 'Obtained from socket.io server.', 'decks' ),
			 'id' 				=> 'multiplexing_id',
			 'type' 			=> 'text',
			 'value' 			=> ''
		 )
	  );

	  add_settings_field(
		 'multiplexing_url',
		 esc_html__( 'Multiplexing ', 'decks' ),
		 array( $this, 'field_text' ),
		 DECKS_SLUG,
		 DECKS_SLUG . '-multiplexing',
		 array(
			 'description' 		=> __( 'URL of socket.io server.', 'decks' ),
			 'id' 				=> 'multiplexing_url',
			 'type' 			=> 'url',
			 'value' 			=> ''
		 )
	  );

	} // register_fields()

	/**
	 * Registers settings sections with WordPress
	 */
	public function register_sections() {

		// add_settings_section( $id, $title, $callback, $menu_slug );

		add_settings_section(
			DECKS_SLUG . '-displaysettings',
			esc_html__( 'Display', 'decks' ),
			array( $this, 'section_displaysettings' ),
			DECKS_SLUG
		);

		add_settings_section(
			DECKS_SLUG . '-controls',
			esc_html__( 'Controls', 'decks' ),
			array( $this, 'section_controls' ),
			DECKS_SLUG
		);

		add_settings_section(
			DECKS_SLUG . '-behavior',
			esc_html__( 'Behavior', 'decks' ),
			array( $this, 'section_behavior' ),
			DECKS_SLUG
		);

		add_settings_section(
			DECKS_SLUG . '-autoslide',
			esc_html__( 'Autoslide', 'decks' ),
			array( $this, 'section_autoslide' ),
			DECKS_SLUG
		);

		add_settings_section(
			DECKS_SLUG . '-transition',
			esc_html__( 'Transitions', 'decks' ),
			array( $this, 'section_transition' ),
			DECKS_SLUG
		);

		add_settings_section(
			DECKS_SLUG . '-parallax',
			esc_html__( 'Parallax', 'decks' ),
			array( $this, 'section_parallax' ),
			DECKS_SLUG
		);

		add_settings_section(
			DECKS_SLUG . '-dependencies',
			esc_html__( 'Dependencies', 'decks' ),
			array( $this, 'section_dependencies' ),
			DECKS_SLUG
		);

		add_settings_section(
			DECKS_SLUG . '-multiplexing',
			esc_html__( 'Multiplexing', 'decks' ),
			array( $this, 'section_multiplexing' ),
			DECKS_SLUG
		);

	} // register_sections()

	/**
	 * Registers plugin settings
	 *
	 * @since 		1.0.0
	 */
	public function register_settings() {

		// register_setting( $option_group, $option_name, $sanitize_callback );

		register_setting(
			DECKS_SLUG . '-options',
			DECKS_SLUG . '-options',
			array( $this, 'validate_options' )
		);

	} // register_settings()

	/**
	 * Displays a settings section
	 *
	 * @since 		1.0.0
	 *
	 * @param 		array 		$params 		Array of parameters for the section
	 *
	 * @return 		mixed 						The settings section
	 */
	public function section_autoslide( $params ) {

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'views/sections/autoslide.php' );

	} // section_autoslide()

	/**
	 * Displays a settings section
	 *
	 * @since 		1.0.0
	 *
	 * @param 		array 		$params 		Array of parameters for the section
	 *
	 * @return 		mixed 						The settings section
	 */
	public function section_behavior( $params ) {

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'views/sections/behavior.php' );

	} // section_behavior()

	/**
	 * Displays a settings section
	 *
	 * @since 		1.0.0
	 *
	 * @param 		array 		$params 		Array of parameters for the section
	 *
	 * @return 		mixed 						The settings section
	 */
	public function section_controls( $params ) {

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'views/sections/controls.php' );

	} // section_controls()

	/**
	 * Displays a settings section
	 *
	 * @since 		1.0.0
	 *
	 * @param 		array 		$params 		Array of parameters for the section
	 *
	 * @return 		mixed 						The settings section
	 */
	public function section_dependencies( $params ) {

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'views/sections/dependencies.php' );

	} // section_dependencies()

	/**
	 * Displays a settings section
	 *
	 * @since 		1.0.0
	 *
	 * @param 		array 		$params 		Array of parameters for the section
	 *
	 * @return 		mixed 						The settings section
	 */
	public function section_displaysettings( $params ) {

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'views/sections/displaysettings.php' );

	} // section_displaysettings()

	/**
	 * Displays a settings section
	 *
	 * @since 		1.0.0
	 *
	 * @param 		array 		$params 		Array of parameters for the section
	 *
	 * @return 		mixed 						The settings section
	 */
	public function section_multiplexing( $params ) {

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'views/sections/multiplexing.php' );

	} // section_multiplexing()

	/**
	 * Displays a settings section
	 *
	 * @since 		1.0.0
	 *
	 * @param 		array 		$params 		Array of parameters for the section
	 *
	 * @return 		mixed 						The settings section
	 */
	public function section_parallax( $params ) {

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'views/sections/parallax.php' );

	} // section_parallax()

	/**
	 * Displays a settings section
	 *
	 * @since 		1.0.0
	 *
	 * @param 		array 		$params 		Array of parameters for the section
	 *
	 * @return 		mixed 						The settings section
	 */
	public function section_transition( $params ) {

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'views/sections/transition.php' );

	} // section_transition()

	/**
	 * [sections_menu description]
	 * @return [type] [description]
	 */
	protected function sections_menu() {

		$sections = $this->get_settings_sections();

		$output = '';

		$output .= '<ul class="menu-sections">';

		foreach ( $sections['decks'] as $section ) :

			$title =

			$output .= '<li><a href="#';
			$output.= esc_attr( $section['id'] );
			$output .= '">';
			$output .= esc_html( $section['title'] );
			$output .= '</a></li>';

		endforeach;

		$output .= '</ul>';


		return $output;

	} // sections_menu()

	/**
	 * Sets the class variable $options
	 */
	private function set_options() {

		$this->options = get_option( DECKS_SLUG . '-options' );

	} // set_options()

	/**
	 * Validates saved options
	 *
	 * @since 		1.0.0
	 *
	 * @param 		array 		$input 			array of submitted plugin options
	 *
	 * @return 		array 						array of validated plugin options
	 */
	public function validate_options( $input ) {

		$valid 		= array();
		$options 	= $this->get_options_list();

		foreach ( $options as $option ) {

			$sanitizer 			= new Decks_Sanitize();
			$valid[$option[0]] 	= $sanitizer->clean( $input[$option[0]], $option[1] );

			if ( $valid[$option[0]] != $input[$option[0]] ) {

				add_settings_error( $option[0], $option[0] . '_error', esc_html__( $option[0] . ' error.', 'decks' ), 'error' );

			}

			unset( $sanitizer );

		}

		return $valid;

	} // validate_options()

} // class
