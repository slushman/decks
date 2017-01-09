<?php
/**
 * Decks Customizer
 *
 * Contains methods for the Customizer.
 *
 * @link 		https://codex.wordpress.org/Theme_Customization_API
 * @since 		1.0.0
 * @package  	Decks
 */
class Decks_Customizer {

	/**
	 * Constructor
	 */
	public function __construct() {}

	/**
	 * Registers all the WordPress hooks and filters for this class.
	 */
	public function hooks() {

		add_action( 'customize_register', 					array( $this, 'register_panels' ) );
		add_action( 'customize_register', 					array( $this, 'register_sections' ) );
		add_action( 'customize_register', 					array( $this, 'register_fields' ) );
		add_action( 'wp_head', 								array( $this, 'header_output' ) );
		add_action( 'customize_preview_init', 				array( $this, 'live_preview' ) );
		add_action( 'customize_controls_enqueue_scripts', 	array( $this, 'control_scripts' ) );
		//add_action( 'customize_register', 					array( $this, 'load_customize_controls' ), 0 );

	} // hooks()

	/**
	 * Registers custom panels for the Customizer
	 *
	 * @see			add_action( 'customize_register', $func )
	 * @link 		http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
	 * @since 		1.0.0
	 *
	 * @param 		WP_Customize_Manager 		$wp_customize 		Customizer object.
	 */
	public function register_panels( $wp_customize ) {

		// Theme Options Panel
		$wp_customize->add_panel( 'decks_options',
			array(
				'capability'  		=> 'edit_theme_options',
				'description'  		=> esc_html__( 'Options for Decks', 'decks' ),
				'priority'  		=> 250,
				'title'  			=> esc_html__( 'Decks', 'decks' ),
			)
		);

	} // register_panels()

	/**
	 * Registers custom sections for the Customizer
	 *
	 * Existing sections:
	 *
	 * Slug 				Priority 		Title
	 *
	 * title_tagline 		20 				Site Identity
	 * colors 				40				Colors
	 * header_image 		60				Header Image
	 * background_image 	80				Background Image
	 * nav 					100 			Navigation
	 * widgets 				110 			Widgets
	 * static_front_page 	120 			Static Front Page
	 * default 				160 			all others
	 *
	 * @see			add_action( 'customize_register', $func )
	 * @link 		http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
	 * @since 		1.0.0
	 *
	 * @param 		WP_Customize_Manager 		$wp_customize 		Theme Customizer object.
	 */
	public function register_sections( $wp_customize ) {

		$wp_customize->add_section( 'decks_display',
			array(
				'capability' 	=> 'edit_theme_options',
				'description' 	=> esc_html__( '', 'decks' ),
				'panel' 		=> 'decks_options',
				'priority' 		=> 10,
				'title' 		=> esc_html__( 'Display', 'decks' )
			)
		);

		$wp_customize->add_section( 'decks_controls',
			array(
				'capability' 	=> 'manage_options',
				'description' 	=> esc_html__( '', 'decks' ),
				'panel' 		=> 'decks_options',
				'priority' 		=> 10,
				'title' 		=> esc_html__( 'Controls', 'decks' )
			)
		);

		$wp_customize->add_section( 'decks_behavior',
			array(
				'capability' 	=> 'manage_options',
				'description' 	=> esc_html__( '', 'decks' ),
				'panel' 		=> 'decks_options',
				'priority' 		=> 10,
				'title' 		=> esc_html__( 'Behavior', 'decks' )
			)
		);

		$wp_customize->add_section( 'decks_autoslide',
			array(
				'capability' 	=> 'manage_options',
				'description' 	=> esc_html__( '', 'decks' ),
				'panel' 		=> 'decks_options',
				'priority' 		=> 10,
				'title' 		=> esc_html__( 'Autoslide', 'decks' )
			)
		);

		$wp_customize->add_section( 'decks_transitions',
			array(
				'capability' 	=> 'manage_options',
				'description' 	=> esc_html__( '', 'decks' ),
				'panel' 		=> 'decks_options',
				'priority' 		=> 10,
				'title' 		=> esc_html__( 'Transitions', 'decks' )
			)
		);

		$wp_customize->add_section( 'decks_parallax',
			array(
				'capability' 	=> 'manage_options',
				'description' 	=> esc_html__( '', 'decks' ),
				'panel' 		=> 'decks_options',
				'priority' 		=> 10,
				'title' 		=> esc_html__( 'Parallax', 'decks' )
			)
		);

		$wp_customize->add_section( 'decks_dependencies',
			array(
				'capability' 	=> 'manage_options',
				'description' 	=> esc_html__( '', 'decks' ),
				'panel' 		=> 'decks_options',
				'priority' 		=> 10,
				'title' 		=> esc_html__( 'Dependencies', 'decks' )
			)
		);

		$wp_customize->add_section( 'decks_design',
			array(
				'capability' 	=> 'manage_options',
				'description' 	=> esc_html__( '', 'decks' ),
				'panel' 		=> 'decks_options',
				'priority' 		=> 10,
				'title' 		=> esc_html__( 'Design', 'decks' )
			)
		);

	} // register_sections()

	/**
	 * Registers controls/fields for the Customizer
	 *
	 * Note: To enable instant preview, we have to actually write a bit of custom
	 * javascript. See live_preview() for more.
	 *
	 * Note: To use active_callbacks, don't add these to the selecting control, it apepars these conflict:
	 * 		'transport' => 'postMessage'
	 * 		$wp_customize->get_setting( 'field_name' )->transport = 'postMessage';
	 *
	 * @see			add_action( 'customize_register', $func )
	 * @link 		http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
	 * @since 		1.0.0
	 *
	 * @param 		WP_Customize_Manager 		$wp_customize 		Theme Customizer object.
	 */
	public function register_fields( $wp_customize ) {


		/**
		 * Display Settings
		 */
		// Display Controls Field
		$wp_customize->add_setting( 'decks[display_controls]',
			array(
				'capability' 		=> 'manage_options',
				'default'  			=> 'true',
				'sanitize_callback' => '',
				'transport' 		=> 'postMessage',
				'type' 				=> 'option'
			)
		);
		$wp_customize->add_control( 'decks_display_controls',
			array(
				'description' 		=> esc_html__( 'Display controls in the bottom right corner.', 'decks' ),
				'label' 			=> esc_html__( 'Display Controls', 'decks' ),
				'priority' 			=> 10,
				'section' 			=> 'decks_display',
				'settings' 			=> 'decks[display_controls]',
				'type' 				=> 'checkbox'
			)
		);
		$wp_customize->get_setting( 'decks[display_controls]' )->transport = 'postMessage';

		// Display Progress Field
		$wp_customize->add_setting( 'decks[display_progress]',
			array(
				'capability' 		=> 'manage_options',
				'default'  			=> 'true',
				'transport' 		=> 'postMessage',
				'type' 				=> 'option'
			)
		);
		$wp_customize->add_control( 'decks_display_progress',
			array(
				'description' 		=> esc_html__( 'Display a presentation progress bar.', 'decks' ),
				'label' 			=> esc_html__( 'Display Progress Bar', 'decks' ),
				'priority' 			=> 10,
				'section' 			=> 'decks_display',
				'settings' 			=> 'decks[display_progress]',
				'type' 				=> 'checkbox'
			)
		);
		$wp_customize->get_setting( 'decks[display_progress]' )->transport = 'postMessage';

		// Display Slide Number Field
		$wp_customize->add_setting( 'decks[display_slidenumber]',
			array(
				'capability' 		=> 'manage_options',
				'default'  			=> 'false',
				'transport' 		=> 'postMessage',
				'type' 				=> 'option'
			)
		);
		$wp_customize->add_control( 'decks_display_slidenumber',
			array(
				'description' 		=> esc_html__( 'Display the page number of the current slide.', 'decks' ),
				'label' 			=> esc_html__( 'Display Slide Numbers', 'decks' ),
				'priority' 			=> 10,
				'section' 			=> 'decks_display',
				'settings' 			=> 'decks_[display_slidenumber]',
				'type' 				=> 'checkbox'
			)
		);
		$wp_customize->get_setting( 'decks[display_slidenumber]' )->transport = 'postMessage';

		// Vertically Center Field
		$wp_customize->add_setting( 'decks[vertically_center]',
			array(
				'capability' 		=> 'manage_options',
				'default'  			=> 'true',
				'transport' 		=> 'postMessage',
				'type' 				=> 'option'
			)
		);
		$wp_customize->add_control( 'decks_vertically_center',
			array(
				'description' 		=> esc_html__( 'Vertical centering of slides.', 'decks' ),
				'label' 			=> esc_html__( 'Vertically Center', 'decks' ),
				'priority' 			=> 10,
				'section' 			=> 'decks_display',
				'settings' 			=> 'decks[vertically_center]',
				'type' 				=> 'checkbox'
			)
		);
		$wp_customize->get_setting( 'decks[vertically_center]' )->transport = 'postMessage';

		// Help Overlay Field
		$wp_customize->add_setting( 'decks[help_overlay]',
			array(
				'capability' 		=> 'manage_options',
				'default'  			=> 'true',
				'transport' 		=> 'postMessage',
				'type' 				=> 'option'
			)
		);
		$wp_customize->add_control( 'decks_help_overlay',
			array(
				'description' 		=> esc_html__( 'Show the help overlay when the ? key is pressed.', 'decks' ),
				'label' 			=> esc_html__( 'Help Overlay', 'decks' ),
				'priority' 			=> 10,
				'section' 			=> 'decks_display',
				'settings' 			=> 'decks[help_overlay]',
				'type' 				=> 'checkbox'
			)
		);
		$wp_customize->get_setting( 'decks[help_overlay]' )->transport = 'postMessage';

		// Display Notes Field
		$wp_customize->add_setting( 'decks[display_notes]',
			array(
				'capability' 		=> 'manage_options',
				'default'  			=> 'false',
				'transport' 		=> 'postMessage',
				'type' 				=> 'option'
			)
		);
		$wp_customize->add_control( 'decks_display_notes',
			array(
				'description' 		=> esc_html__( 'Display speaker notes to all viewers.', 'decks' ),
				'label' 			=> esc_html__( 'Display Notes', 'decks' ),
				'priority' 			=> 10,
				'section' 			=> 'decks_display',
				'settings' 			=> 'decks[display_notes]',
				'type' 				=> 'checkbox'
			)
		);
		$wp_customize->get_setting( 'decks[display_notes]' )->transport = 'postMessage';

		// View Distance Field
		$wp_customize->add_setting( 'decks[view_distance]',
			array(
				'capability' 		=> 'manage_options',
				'default'  			=> 3,
				'sanitize_callback' => '',
				'transport' 		=> 'postMessage',
				'type' 				=> 'option'
			)
		);
		$wp_customize->add_control( 'decks_view_distance',
			array(
				'description' 		=> esc_html__( 'Number of slides away from the current that are visible.', 'decks' ),
				'input_attrs' 		=> array(
					'class' 		=> 'number-field',
					'max' 			=> 10,
					'min' 			=> 0,
					'step' 			=> 1,
				),
				'label' 			=> esc_html__( 'View Distance', 'decks' ),
				'priority' 			=> 10,
				'section' 			=> 'decks_display',
				'settings' 			=> 'decks[view_distance]',
				'type' 				=> 'number'
			)
		);
		$wp_customize->get_setting( 'decks[view_distance]' )->transport = 'postMessage';

		// Hide Address Bar Field
		$wp_customize->add_setting( 'decks[hide_address_bar]',
			array(
				'capability' 		=> 'manage_options',
				'default'  			=> 'true',
				'transport' 		=> 'postMessage',
				'type' 				=> 'option'
			)
		);
		$wp_customize->add_control( 'decks_hide_address_bar',
			array(
				'description' 		=> esc_html__( 'Hides the address bar on mobile devices.', 'decks' ),
				'label' 			=> esc_html__( 'Hide Address Bar', 'decks' ),
				'priority' 			=> 10,
				'section' 			=> 'decks_display',
				'settings' 			=> 'decks[hide_address_bar]',
				'type' 				=> 'checkbox'
			)
		);
		$wp_customize->get_setting( 'decks[hide_address_bar]' )->transport = 'postMessage';



		 /**
 		 * Presentation Controls Settings
 		 */
		// Enable Keyboard Shortcuts Field
 		$wp_customize->add_setting( 'decks[enable_keyboard_shortcuts]',
 			array(
				'capability' 		=> 'manage_options',
 				'default'  			=> 'true',
 				'transport' 		=> 'postMessage',
 				'type' 				=> 'option'
 			)
 		);
 		$wp_customize->add_control( 'decks_enable_keyboard_shortcuts',
 			array(
 				'description' 		=> esc_html__( 'Enable keyboard shortcuts for navigation.', 'decks' ),
 				'label' 			=> esc_html__( 'Enable Keyboard Shortcuts', 'decks' ),
 				'priority' 			=> 10,
 				'section' 			=> 'decks_controls',
 				'settings' 			=> 'decks[enable_keyboard_shortcuts]',
 				'type' 				=> 'checkbox'
 			)
 		);
 		$wp_customize->get_setting( 'decks[enable_keyboard_shortcuts]' )->transport = 'postMessage';

		// Enable Touch Field
 		$wp_customize->add_setting( 'decks[enable_touch]',
 			array(
				'capability' 		=> 'manage_options',
 				'default'  			=> 'true',
 				'transport' 		=> 'postMessage',
 				'type' 				=> 'option'
 			)
 		);
 		$wp_customize->add_control( 'decks_enable_touch',
 			array(
 				'description' 		=> esc_html__( 'Enables touch navigation on devices with touch input.', 'decks' ),
 				'label' 			=> esc_html__( 'Enable Touch', 'decks' ),
 				'priority' 			=> 10,
 				'section' 			=> 'decks_controls',
 				'settings' 			=> 'decks[enable_touch]',
 				'type' 				=> 'checkbox'
 			)
 		);
 		$wp_customize->get_setting( 'decks[enable_touch]' )->transport = 'postMessage';

		// Loop Presentation Field
 		$wp_customize->add_setting( 'decks[loop]',
 			array(
				'capability' 		=> 'manage_options',
 				'default'  			=> 'false',
 				'transport' 		=> 'postMessage',
 				'type' 				=> 'option'
 			)
 		);
 		$wp_customize->add_control( 'decks_loop',
 			array(
 				'description' 		=> esc_html__( 'Loop the presentation.', 'decks' ),
 				'label' 			=> esc_html__( 'Loop Presentation', 'decks' ),
 				'priority' 			=> 10,
 				'section' 			=> 'decks_controls',
 				'settings' 			=> 'decks[loop]',
 				'type' 				=> 'checkbox'
 			)
 		);
 		$wp_customize->get_setting( 'decks[loop]' )->transport = 'postMessage';

		// RTL Direction Field
 		$wp_customize->add_setting( 'decks[rtl_direction]',
 			array(
				'capability' 		=> 'manage_options',
 				'default'  			=> 'false',
 				'transport' 		=> 'postMessage',
 				'type' 				=> 'option'
 			)
 		);
 		$wp_customize->add_control( 'decks_rtl_direction',
 			array(
 				'description' 		=> esc_html__( 'Change the presentation direction to be RTL.', 'decks' ),
 				'label' 			=> esc_html__( 'RTL Direction', 'decks' ),
 				'priority' 			=> 10,
 				'section' 			=> 'decks_controls',
 				'settings' 			=> 'decks[rtl_direction]',
 				'type' 				=> 'checkbox'
 			)
 		);
 		$wp_customize->get_setting( 'decks[rtl_direction]' )->transport = 'postMessage';

		// Shuffle Field
 		$wp_customize->add_setting( 'decks[shuffle]',
 			array(
				'capability' 		=> 'manage_options',
 				'default'  			=> 'false',
 				'transport' 		=> 'postMessage',
 				'type' 				=> 'option'
 			)
 		);
 		$wp_customize->add_control( 'decks_shuffle',
 			array(
 				'description' 		=> esc_html__( 'Randomizes the order of slides each time the presentation loads.', 'decks' ),
 				'label' 			=> esc_html__( 'Shuffle', 'decks' ),
 				'priority' 			=> 10,
 				'section' 			=> 'decks_controls',
 				'settings' 			=> 'decks[shuffle]',
 				'type' 				=> 'checkbox'
 			)
 		);
 		$wp_customize->get_setting( 'decks[shuffle]' )->transport = 'postMessage';

		// Mouse Wheel Field
 		$wp_customize->add_setting( 'decks[mouse_wheel]',
 			array(
				'capability' 		=> 'manage_options',
 				'default'  			=> 'false',
 				'transport' 		=> 'postMessage',
 				'type' 				=> 'option'
 			)
 		);
 		$wp_customize->add_control( 'decks_mouse_wheel',
 			array(
 				'description' 		=> esc_html__( 'Enable slide navigation via mouse wheel.', 'decks' ),
 				'label' 			=> esc_html__( 'Mouse Wheel', 'decks' ),
 				'priority' 			=> 10,
 				'section' 			=> 'decks_controls',
 				'settings' 			=> 'decks[mouse_wheel]',
 				'type' 				=> 'checkbox'
 			)
 		);
 		$wp_customize->get_setting( 'decks[mouse_wheel]' )->transport = 'postMessage';

		// Preview Links Field
 		$wp_customize->add_setting( 'decks[preview_links]',
 			array(
				'capability' 		=> 'manage_options',
 				'default'  			=> 'false',
 				'transport' 		=> 'postMessage',
 				'type' 				=> 'option'
 			)
 		);
 		$wp_customize->add_control( 'decks_preview_links',
 			array(
 				'description' 		=> esc_html__( 'Open links in an iframe preview overlay.', 'decks' ),
 				'label' 			=> esc_html__( 'Preview Links', 'decks' ),
 				'priority' 			=> 10,
 				'section' 			=> 'decks_controls',
 				'settings' 			=> 'decks[preview_links]',
 				'type' 				=> 'checkbox'
 			)
 		);
 		$wp_customize->get_setting( 'decks[preview_links]' )->transport = 'postMessage';



 		/**
 		 * Behavior Settings
 		 */
		// Browser History Field
  		$wp_customize->add_setting( 'decks[browser_history]',
  			array(
				'capability' 		=> 'manage_options',
  				'default'  			=> 'false',
  				'transport' 		=> 'postMessage',
  				'type' 				=> 'option'
  			)
  		);
  		$wp_customize->add_control( 'decks_browser_history',
  			array(
  				'description' 		=> esc_html__( 'Push each slide change to the browser history.', 'decks' ),
  				'label' 			=> esc_html__( 'Browser History', 'decks' ),
  				'priority' 			=> 10,
  				'section' 			=> 'decks_behavior',
  				'settings' 			=> 'decks[browser_history]',
  				'type' 				=> 'checkbox'
  			)
  		);
  		$wp_customize->get_setting( 'decks[browser_history]' )->transport = 'postMessage';

		// Overview Mode Field
  		$wp_customize->add_setting( 'decks[overview_mode]',
  			array(
				'capability' 		=> 'manage_options',
  				'default'  			=> 'true',
  				'transport' 		=> 'postMessage',
  				'type' 				=> 'option'
  			)
  		);
  		$wp_customize->add_control( 'decks_overview_mode',
  			array(
  				'description' 		=> esc_html__( 'Enable the slide overview mode.', 'decks' ),
  				'label' 			=> esc_html__( 'Overview Mode', 'decks' ),
  				'priority' 			=> 10,
  				'section' 			=> 'decks_behavior',
  				'settings' 			=> 'decks[overview_mode]',
  				'type' 				=> 'checkbox'
  			)
  		);
  		$wp_customize->get_setting( 'decks[overview_mode]' )->transport = 'postMessage';

		// Fragments Field
  		$wp_customize->add_setting( 'decks[fragments]',
  			array(
				'capability' 		=> 'manage_options',
  				'default'  			=> 'true',
  				'transport' 		=> 'postMessage',
  				'type' 				=> 'option'
  			)
  		);
  		$wp_customize->add_control( 'decks_fragments',
  			array(
  				'description' 		=> esc_html__( 'Turns fragments on  and off globally.', 'decks' ),
  				'label' 			=> esc_html__( 'Fragments', 'decks' ),
  				'priority' 			=> 10,
  				'section' 			=> 'decks_behavior',
  				'settings' 			=> 'decks[fragments]',
  				'type' 				=> 'checkbox'
  			)
  		);
  		$wp_customize->get_setting( 'decks[fragments]' )->transport = 'postMessage';

		// Embedded Mode Field
  		$wp_customize->add_setting( 'decks[embedded_mode]',
  			array(
				'capability' 		=> 'manage_options',
  				'default'  			=> 'false',
  				'transport' 		=> 'postMessage',
  				'type' 				=> 'option'
  			)
  		);
  		$wp_customize->add_control( 'decks_embedded_mode',
  			array(
  				'description' 		=> esc_html__( 'Check if the presentation is running in embedded mode.', 'decks' ),
  				'label' 			=> esc_html__( 'Embedded Mode', 'decks' ),
  				'priority' 			=> 10,
  				'section' 			=> 'decks_behavior',
  				'settings' 			=> 'decks[embedded_mode]',
  				'type' 				=> 'checkbox'
  			)
  		);
  		$wp_customize->get_setting( 'decks[embedded_mode]' )->transport = 'postMessage';



 		/**
 		 * Autoslide Settings
 		 */
		 // Autoslide Field
 		$wp_customize->add_setting( 'decks[autoslide]',
 			array(
				'capability' 			=> 'manage_options',
 				'default'  				=> 0,
 				'sanitize_callback'		=> '',
 				'transport' 			=> 'postMessage',
 				'type' 					=> 'option'
 			)
 		);
 		$wp_customize->add_control( 'decks_autoslide',
 			array(
 				'description' 		=> esc_html__( 'Number of milliseconds between automatically proceeding to the next slide. Disabled when set to 0. Can be overriden on each slide.', 'decks' ),
 				'input_attrs' 		=> array(
 					'class' 		=> 'number-field',
 					'max' 			=> 10000,
 					'min' 			=> 0,
 					'step' 			=> 100,
 				),
 				'label' 			=> esc_html__( 'Autoslide', 'decks' ),
 				'priority' 			=> 10,
 				'section' 			=> 'decks_autoslide',
 				'settings' 			=> 'decks[autoslide]',
 				'type' 				=> 'number'
 			)
 		);
 		$wp_customize->get_setting( 'decks[autoslide]' )->transport = 'postMessage';

		// Autoslide Stoppable Field
  		$wp_customize->add_setting( 'decks[autoslide_stoppable]',
  			array(
				'capability' 		=> 'manage_options',
  				'default'  			=> 'true',
  				'transport' 		=> 'postMessage',
  				'type' 				=> 'option'
  			)
  		);
  		$wp_customize->add_control( 'decks_autoslide_stoppable',
  			array(
  				'description' 		=> esc_html__( 'Stop auto-sliding after user input.', 'decks' ),
  				'label' 			=> esc_html__( 'Autoslide Stoppable', 'decks' ),
  				'priority' 			=> 10,
  				'section' 			=> 'decks_autoslide',
  				'settings' 			=> 'decks[autoslide_stoppable]',
  				'type' 				=> 'checkbox'
  			)
  		);
  		$wp_customize->get_setting( 'decks[autoslide_stoppable]' )->transport = 'postMessage';

		// Autoslide Method Field
		$wp_customize->add_setting( 'decks[autoslide_method]',
			array(
				'capability' 			=> 'manage_options',
				'default'  				=> 'Reveal.navigateNext',
				'sanitize_callback' 	=> 'sanitize_text_field',
				'sanitize_js_callback' 	=> '',
				'theme_supports' 		=> '',
				'transport' 			=> 'postMessage',
				'type' 					=> 'option'
			)
		);
		$wp_customize->add_control( 'decks_autoslide_method',
			array(
				'description' 		=> esc_html__( 'Use this method for navigation when auto-sliding.', 'decks' ),
				'label'  			=> esc_html__( 'Autoslide Method', 'decks' ),
				'priority' 			=> 10,
				'section'  			=> 'decks_autoslide',
				'settings' 			=> 'decks[autoslide_method]',
				'type' 				=> 'text'
			)
		);
		$wp_customize->get_setting( 'decks[autoslide_method]' )->transport = 'postMessage';



 		/**
 		 * Transitions Settings
 		 */
		// Transition Field
 		$wp_customize->add_setting( 'decks[transition]',
 			array(
				'capability' 		=> 'manage_options',
 				'default'  			=> 'default',
 				'transport' 		=> 'postMessage'
 			)
 		);
 		$wp_customize->add_control( 'decks_transition',
 			array(
 				'choices' 			=> array(
 					'default' 		=> esc_html__( 'Default', 'decks' ),
 					'none' 			=> esc_html__( 'None', 'decks' ),
					'fade' 			=> esc_html__( 'Fade', 'decks' ),
 					'slide' 		=> esc_html__( 'Slide', 'decks' ),
					'convex' 		=> esc_html__( 'Convex', 'decks' ),
 					'concave' 		=> esc_html__( 'Concave', 'decks' ),
 					'zoom' 			=> esc_html__( 'Zoom', 'decks' )
 				),
 				'description' 		=> esc_html__( '', 'decks' ),
 				'label' 			=> esc_html__( 'Transition Style', 'decks' ),
 				'priority' 			=> 10,
 				'section' 			=> 'decks_transitions',
 				'settings' 			=> 'decks[transition]',
 				'type' 				=> 'select'
 			)
 		);
 		$wp_customize->get_setting( 'decks[transition]' )->transport = 'postMessage';

		// Transition Out Field
 		$wp_customize->add_setting( 'decks[transition-out]',
 			array(
				'capability' 		=> 'manage_options',
 				'default'  			=> 'default',
 				'transport' 		=> 'postMessage'
 			)
 		);
 		$wp_customize->add_control( 'decks_transition_out',
 			array(
 				'choices' 			=> array(
 					'default' 		=> esc_html__( 'Default', 'decks' ),
 					'none' 			=> esc_html__( 'None', 'decks' ),
					'fade' 			=> esc_html__( 'Fade', 'decks' ),
 					'slide' 		=> esc_html__( 'Slide', 'decks' ),
					'convex' 		=> esc_html__( 'Convex', 'decks' ),
 					'concave' 		=> esc_html__( 'Concave', 'decks' ),
 					'zoom' 			=> esc_html__( 'Zoom', 'decks' )
 				),
 				'description' 		=> esc_html__( '', 'decks' ),
 				'label' 			=> esc_html__( 'Transition Out Style', 'decks' ),
 				'priority' 			=> 10,
 				'section' 			=> 'decks_transitions',
 				'settings' 			=> 'decks[transition-out]',
 				'type' 				=> 'select'
 			)
 		);
 		$wp_customize->get_setting( 'decks[transition-out]' )->transport = 'postMessage';

		// Transition Speed Field
 		$wp_customize->add_setting( 'decks[transition_speed]',
 			array(
				'capability' 		=> 'manage_options',
 				'default'  			=> 'default',
 				'transport' 		=> 'postMessage'
 			)
 		);
 		$wp_customize->add_control( 'decks_transition_speed',
 			array(
 				'choices' 			=> array(
 					'default' 		=> esc_html__( 'Default', 'decks' ),
 					'fast' 			=> esc_html__( 'Fast', 'decks' ),
					'slow' 			=> esc_html__( 'Slow', 'decks' )
 				),
 				'description' 		=> esc_html__( '', 'decks' ),
 				'label' 			=> esc_html__( 'Transition Speed', 'decks' ),
 				'priority' 			=> 10,
 				'section' 			=> 'decks_transitions',
 				'settings' 			=> 'decks[transition_speed]',
 				'type' 				=> 'select'
 			)
 		);
 		$wp_customize->get_setting( 'decks[transition_speed]' )->transport = 'postMessage';

		// Background Transition Field
 		$wp_customize->add_setting( 'decks[bg_transition]',
 			array(
				'capability' 		=> 'manage_options',
 				'default'  			=> 'default',
 				'transport' 		=> 'postMessage'
 			)
 		);
 		$wp_customize->add_control( 'decks_bg_transition',
 			array(
 				'choices' 			=> array(
 					'default' 		=> esc_html__( 'Default', 'decks' ),
 					'none' 			=> esc_html__( 'None', 'decks' ),
					'fade' 			=> esc_html__( 'Fade', 'decks' ),
 					'slide' 		=> esc_html__( 'Slide', 'decks' ),
					'convex' 		=> esc_html__( 'Convex', 'decks' ),
 					'concave' 		=> esc_html__( 'Concave', 'decks' ),
 					'zoom' 			=> esc_html__( 'Zoom', 'decks' )
 				),
 				'description' 		=> esc_html__( '', 'decks' ),
 				'label' 			=> esc_html__( 'Background Transition', 'decks' ),
 				'priority' 			=> 10,
 				'section' 			=> 'decks_transitions',
 				'settings' 			=> 'decks[bg_transition]',
 				'type' 				=> 'select'
 			)
 		);
 		$wp_customize->get_setting( 'decks[bg_transition]' )->transport = 'postMessage';



 		/**
 		 * Parallax Settings
 		 */
	 	// Media Upload Field - returns image ID
 		$wp_customize->add_setting( 'decks[parallax_bgimg]',
 			array(
 				'default' 			=> '',
 				'transport' 		=> 'postMessage'
 			)
 		);
 		$wp_customize->add_control(
 			new WP_Customize_Media_Control(
 				$wp_customize,
 				'decks_parallax_bgimg',
 				array(
 					'description' 	=> esc_html__( '', 'decks' ),
 					'label' 		=> esc_html__( 'Parallax Background Image', 'decks' ),
 					'mime_type' 	=> '',
 					'priority' 		=> 10,
 					'section'		=> 'decks_parallax',
 					'settings' 		=> 'decks[parallax_bgimg]'
 				)
 			)
 		);
 		$wp_customize->get_setting( 'decks[parallax_bgimg]' )->transport = 'postMessage';

		// Parallax Background Image Size Field
   		$wp_customize->add_setting( 'decks[parallax_bgsize]',
   			array(
   				'capability' 			=> 'manage_options',
   				'default'  				=> '',
   				'sanitize_callback' 	=> 'sanitize_text_field',
   				'sanitize_js_callback' 	=> '',
   				'theme_supports' 		=> '',
   				'transport' 			=> 'postMessage',
   				'type' 					=> 'option'
   			)
   		);
   		$wp_customize->add_control( 'decks_parallax_bgsize',
   			array(
   				'description' 		=> esc_html__( 'Use CSS syntax like: 2100px 900px.', 'decks' ),
   				'label'  			=> esc_html__( 'Parallax Background Image Size', 'decks' ),
   				'priority' 			=> 10,
   				'section'  			=> 'decks_parallax',
   				'settings' 			=> 'decks[parallax_bgsize]',
   				'type' 				=> 'text'
   			)
   		);
   		$wp_customize->get_setting( 'decks[parallax_bgsize]' )->transport = 'postMessage';

		// Parallax Background Horizontal Field
		$wp_customize->add_setting( 'decks[parallax_bg_horizontal]',
			array(
				'capability' 		=> 'manage_options',
				'default'  			=> '',
				'sanitize_callback' => '',
				'transport' 		=> 'postMessage',
				'type' 				=> 'option'
			)
		);
		$wp_customize->add_control( 'decks_parallax_bg_horizontal',
			array(
				'description' 		=> esc_html__( 'Number of pixels to move the parallax background per slide on the horizontal axis. Set to 0 to disable horizontal movement. If not, set this will calculated automatically.', 'decks' ),
				'input_attrs' 		=> array(
					'class' 		=> 'number-field',
					'max' 			=> 10,
					'min' 			=> 0,
					'step' 			=> 1,
				),
				'label' 			=> esc_html__( 'Parallax Background Horizontal', 'decks' ),
				'priority' 			=> 10,
				'section' 			=> 'decks_parallax',
				'settings' 			=> 'decks[parallax_bg_horizontal]',
				'type' 				=> 'number'
			)
		);
		$wp_customize->get_setting( 'decks[parallax_bg_horizontal]' )->transport = 'postMessage';

		// Parallax Background Vertical Field
		$wp_customize->add_setting( 'decks[parallax_bg_vertical]',
			array(
				'capability' 		=> 'manage_options',
				'default'  			=> '',
				'sanitize_callback' => '',
				'transport' 		=> 'postMessage',
				'type' 				=> 'option'
			)
		);
		$wp_customize->add_control( 'decks_parallax_bg_vertical',
			array(
				'description' 		=> esc_html__( 'Number of pixels to move the parallax background per slide on the vertical axis. Set to 0 to disable vertical movement. If not, set this will calculated automatically.', 'decks' ),
				'input_attrs' 		=> array(
					'class' 		=> 'number-field',
					'max' 			=> 10,
					'min' 			=> 0,
					'step' 			=> 1,
				),
				'label' 			=> esc_html__( 'Parallax Background Vertical', 'decks' ),
				'priority' 			=> 10,
				'section' 			=> 'decks_parallax',
				'settings' 			=> 'decks[parallax_bg_vertical]',
				'type' 				=> 'number'
			)
		);
		$wp_customize->get_setting( 'decks[parallax_bg_vertical]' )->transport = 'postMessage';



		/**
		 * Design Settings
		 */
		 // Transition Out Field
  		$wp_customize->add_setting( 'decks[theme]',
  			array(
 				'capability' 		=> 'manage_options',
  				'default'  			=> 'black',
  				'transport' 		=> 'postMessage'
  			)
  		);
  		$wp_customize->add_control( 'decks_theme',
  			array(
  				'choices' 			=> array(
  					'black' 		=> esc_html__( 'Black', 'decks' ),
  					'white' 		=> esc_html__( 'White', 'decks' ),
 					'league' 		=> esc_html__( 'League', 'decks' ),
  					'beige' 		=> esc_html__( 'Beige', 'decks' ),
 					'sky' 			=> esc_html__( 'Sky', 'decks' ),
  					'night' 		=> esc_html__( 'Night', 'decks' ),
					'serif' 		=> esc_html__( 'Serif', 'decks' ),
					'simple' 		=> esc_html__( 'Simple', 'decks' ),
					'solarized' 	=> esc_html__( 'Solarized', 'decks' ),
  					'custom' 		=> esc_html__( 'Custom', 'decks' )
  				),
  				'description' 		=> esc_html__( 'Choose a pre-built theme. To use a custom theme, choose "Custom" and use a file called custom.css.', 'decks' ),
  				'label' 			=> esc_html__( 'Theme', 'decks' ),
  				'priority' 			=> 10,
  				'section' 			=> 'decks_design',
  				'settings' 			=> 'decks[theme]',
  				'type' 				=> 'select'
  			)
  		);
  		$wp_customize->get_setting( 'decks[theme]' )->transport = 'postMessage';

		// Width Field
 		$wp_customize->add_setting( 'decks[width]',
 			array(
 				'capability' 			=> 'manage_options',
 				'default'  				=> '960',
 				'sanitize_callback' 	=> 'sanitize_text_field',
 				'sanitize_js_callback' 	=> '',
 				'theme_supports' 		=> '',
 				'transport' 			=> 'postMessage',
 				'type' 					=> 'option'
 			)
 		);
 		$wp_customize->add_control( 'decks_width',
 			array(
 				'description' 		=> esc_html__( 'The normal width of the presentation. Aspect ratio will be preserved when the presentation is scaled to fit different resolutions. Can be specified in percentage units.', 'decks' ),
 				'label'  			=> esc_html__( 'Width', 'decks' ),
 				'priority' 			=> 10,
 				'section'  			=> 'decks_design',
 				'settings' 			=> 'decks[width]',
 				'type' 				=> 'text'
 			)
 		);
 		$wp_customize->get_setting( 'decks[width]' )->transport = 'postMessage';

		// Height Field
 		$wp_customize->add_setting( 'decks[height]',
 			array(
 				'capability' 			=> 'manage_options',
 				'default'  				=> '700',
 				'sanitize_callback' 	=> 'sanitize_text_field',
 				'sanitize_js_callback' 	=> '',
 				'theme_supports' 		=> '',
 				'transport' 			=> 'postMessage',
 				'type' 					=> 'option'
 			)
 		);
 		$wp_customize->add_control( 'decks_height',
 			array(
 				'description' 		=> esc_html__( 'The normal width of the presentation. Aspect ratio will be preserved when the presentation is scaled to fit different resolutions. Can be specified in percentage units.', 'decks' ),
 				'label'  			=> esc_html__( 'Height', 'decks' ),
 				'priority' 			=> 10,
 				'section'  			=> 'decks_design',
 				'settings' 			=> 'decks[height]',
 				'type' 				=> 'text'
 			)
 		);
 		$wp_customize->get_setting( 'decks[height]' )->transport = 'postMessage';

		// Margin Field
 		$wp_customize->add_setting( 'decks[margin]',
 			array(
 				'capability' 			=> 'manage_options',
 				'default'  				=> '0.1',
 				'sanitize_callback' 	=> 'sanitize_text_field',
 				'sanitize_js_callback' 	=> '',
 				'theme_supports' 		=> '',
 				'transport' 			=> 'postMessage',
 				'type' 					=> 'option'
 			)
 		);
 		$wp_customize->add_control( 'decks_margin',
 			array(
 				'description' 		=> esc_html__( 'Factor of the display size that should remain empty around the content.', 'decks' ),
 				'label'  			=> esc_html__( 'Margin', 'decks' ),
 				'priority' 			=> 10,
 				'section'  			=> 'decks_design',
 				'settings' 			=> 'decks[margin]',
 				'type' 				=> 'text'
 			)
 		);
 		$wp_customize->get_setting( 'decks[margin]' )->transport = 'postMessage';

		// Minimum Scale Field
 		$wp_customize->add_setting( 'decks[minscale]',
 			array(
 				'capability' 			=> 'manage_options',
 				'default'  				=> '0.2',
 				'sanitize_callback' 	=> 'sanitize_text_field',
 				'sanitize_js_callback' 	=> '',
 				'theme_supports' 		=> '',
 				'transport' 			=> 'postMessage',
 				'type' 					=> 'option'
 			)
 		);
 		$wp_customize->add_control( 'decks_minscale',
 			array(
 				'description' 		=> esc_html__( 'Bounds for the smallest possible scale to apply to content.', 'decks' ),
 				'label'  			=> esc_html__( 'Minimum Scale', 'decks' ),
 				'priority' 			=> 10,
 				'section'  			=> 'decks_design',
 				'settings' 			=> 'decks[minscale]',
 				'type' 				=> 'text'
 			)
 		);
 		$wp_customize->get_setting( 'decks[minscale]' )->transport = 'postMessage';

		// Maximum Scale Field
 		$wp_customize->add_setting( 'decks[maxscale]',
 			array(
 				'capability' 			=> 'manage_options',
 				'default'  				=> '1.5',
 				'sanitize_callback' 	=> 'sanitize_text_field',
 				'sanitize_js_callback' 	=> '',
 				'theme_supports' 		=> '',
 				'transport' 			=> 'postMessage',
 				'type' 					=> 'option'
 			)
 		);
 		$wp_customize->add_control( 'decks_maxscale',
 			array(
 				'description' 		=> esc_html__( 'Bounds for the largest possible scale to apply to content.', 'decks' ),
 				'label'  			=> esc_html__( 'Maximum Scale', 'decks' ),
 				'priority' 			=> 10,
 				'section'  			=> 'decks_design',
 				'settings' 			=> 'decks[maxscale]',
 				'type' 				=> 'text'
 			)
 		);
 		$wp_customize->get_setting( 'decks[maxscale]' )->transport = 'postMessage';



		/**
		 * Dependencies Settings
		 */
		// Add Markdown Support Field
 		$wp_customize->add_setting( 'decks[add_markdown]',
 			array(
 				'capability' 		=> 'manage_options',
 				'default'  			=> 'true',
 				'sanitize_callback' => '',
 				'transport' 		=> 'postMessage',
 				'type' 				=> 'option'
 			)
 		);
 		$wp_customize->add_control( 'decks_add_markdown',
 			array(
 				'description' 		=> esc_html__( 'Interpret Markdown in <section> elements.', 'decks' ),
 				'label' 			=> esc_html__( 'Add Markdown Support', 'decks' ),
 				'priority' 			=> 10,
 				'section' 			=> 'decks_dependencies',
 				'settings' 			=> 'decks[add_markdown]',
 				'type' 				=> 'checkbox'
 			)
 		);
 		$wp_customize->get_setting( 'decks[add_markdown]' )->transport = 'postMessage';

		// Add Syntax Highlighting Field
 		$wp_customize->add_setting( 'decks[add_highlighting]',
 			array(
 				'capability' 		=> 'manage_options',
 				'default'  			=> 'true',
 				'sanitize_callback' => '',
 				'transport' 		=> 'postMessage',
 				'type' 				=> 'option'
 			)
 		);
 		$wp_customize->add_control( 'decks_add_highlighting',
 			array(
 				'description' 		=> esc_html__( 'Syntax highlighting for <code> elements.', 'decks' ),
 				'label' 			=> esc_html__( 'Add Syntax Highlighting', 'decks' ),
 				'priority' 			=> 10,
 				'section' 			=> 'decks_dependencies',
 				'settings' 			=> 'decks[add_highlighting]',
 				'type' 				=> 'checkbox'
 			)
 		);
 		$wp_customize->get_setting( 'decks[add_highlighting]' )->transport = 'postMessage';

		// Add Zooming Field
 		$wp_customize->add_setting( 'decks[add_zoom]',
 			array(
 				'capability' 		=> 'manage_options',
 				'default'  			=> 'false',
 				'sanitize_callback' => '',
 				'transport' 		=> 'postMessage',
 				'type' 				=> 'option'
 			)
 		);
 		$wp_customize->add_control( 'decks_add_zoom',
 			array(
 				'description' 		=> esc_html__( 'Zoom in and out with Alt+click.', 'decks' ),
 				'label' 			=> esc_html__( 'Add Zooming', 'decks' ),
 				'priority' 			=> 10,
 				'section' 			=> 'decks_dependencies',
 				'settings' 			=> 'decks[add_zoom]',
 				'type' 				=> 'checkbox'
 			)
 		);
 		$wp_customize->get_setting( 'decks[add_zoom]' )->transport = 'postMessage';

		// Add Speaker Notes Field
 		$wp_customize->add_setting( 'decks[add_speaker_notes]',
 			array(
 				'capability' 		=> 'manage_options',
 				'default'  			=> 'true',
 				'sanitize_callback' => '',
 				'transport' 		=> 'postMessage',
 				'type' 				=> 'option'
 			)
 		);
 		$wp_customize->add_control( 'decks_add_speaker_notes',
 			array(
 				'description' 		=> esc_html__( '', 'decks' ),
 				'label' 			=> esc_html__( 'Add Speaker Notes', 'decks' ),
 				'priority' 			=> 10,
 				'section' 			=> 'decks_dependencies',
 				'settings' 			=> 'decks[add_speaker_notes]',
 				'type' 				=> 'checkbox'
 			)
 		);
 		$wp_customize->get_setting( 'decks[add_speaker_notes]' )->transport = 'postMessage';

		// Add MathJax Field
 		$wp_customize->add_setting( 'decks[add_mathjax]',
 			array(
 				'capability' 		=> 'manage_options',
 				'default'  			=> 'false',
 				'sanitize_callback' => '',
 				'transport' 		=> 'postMessage',
 				'type' 				=> 'option'
 			)
 		);
 		$wp_customize->add_control( 'decks_add_mathjax',
 			array(
 				'description' 		=> esc_html__( '', 'decks' ),
 				'label' 			=> esc_html__( 'Add MathJax', 'decks' ),
 				'priority' 			=> 10,
 				'section' 			=> 'decks_dependencies',
 				'settings' 			=> 'decks[add_mathjax]',
 				'type' 				=> 'checkbox'
 			)
 		);
 		$wp_customize->get_setting( 'decks[add_mathjax]' )->transport = 'postMessage';


	} // register_fields()

	/**
	 * This will generate a line of CSS for use in header output. If the setting
	 * ($mod_name) has no defined value, the CSS will not be output.
	 *
	 * @access 		public
	 * @since 		1.0.0
	 *
	 * @param 		string 		$selector 		CSS selector
	 * @param 		string 		$style 			The name of the CSS *property* to modify
	 * @param 		string 		$mod_name 		The name of the 'theme_mod' option to fetch
	 * @param 		string 		$prefix 		Optional. Anything that needs to be output before the CSS property
	 * @param 		string 		$postfix 		Optional. Anything that needs to be output after the CSS property
	 * @param 		bool 		$echo 			Optional. Whether to print directly to the page (default: true).
	 *
	 * @return 		string 						Returns a single line of CSS with selectors and a property.
	 */
	public function generate_css( $selector, $style, $mod_name, $prefix = '', $postfix = '', $echo = true ) {

		$return = '';
		$mod 	= get_option( $mod_name );

		if ( ! empty( $mod ) ) {

			$return = sprintf('%s { %s:%s; }',
				$selector,
				$style,
				$prefix . $mod . $postfix
			);

			if ( $echo ) {

				echo $return;

			}

		}

		return $return;

	} // generate_css()

	/**
	 * This will output the custom WordPress settings to the live theme's WP head.
	 *
	 * Used by hook: 'wp_head'
	 *
	 * @access 		public
	 * @see 		add_action( 'wp_head', $func )
	 * @since 		1.0.0
	 */
	public function header_output() {

		?><!-- Customizer CSS -->
		<style type="text/css"><?php

			// pattern:
			// $this->generate_css( 'selector', 'style', 'mod_name', 'prefix', 'postfix', true );
			//
			// background-image example:
			// $this->generate_css( '.class', 'background-image', 'background_image_example', 'url(', ')' );


		?></style><!-- Customizer CSS --><?php

		/**
		 * Hides all but the first Soliloquy slide while using Customizer previewer.
		 */
		if ( is_customize_preview() ) {

			?><style type="text/css">

				li.soliloquy-item:not(:first-child) {
					display: none !important;
				}

			</style><!-- Customizer CSS --><?php

		}

	} // header_output()

	/**
	 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
	 *
	 * Used by hook: 'customize_preview_init'
	 *
	 * @access 		public
	 * @see 		add_action( 'customize_preview_init', $func )
	 * @since 		1.0.0
	 */
	public function live_preview() {

		wp_enqueue_script( 'decks_customizer', plugin_dir_path( dirname( __FILE__ ) ) . 'assets/js/customizer.min.js', array( 'jquery', 'customize-preview' ), '', true );

	} // live_preview()

	/**
	 * Used by customizer controls, mostly for active callbacks.
	 *
	 * @hook		customize_controls_enqueue_scripts
	 *
	 * @access 		public
	 * @see 		add_action( 'customize_preview_init', $func )
	 * @since 		1.0.0
	 */
	public function control_scripts() {

		wp_enqueue_script( 'decks_customizer_controls', plugin_dir_path( dirname( __FILE__ ) ) . 'assets/js/customizer-controls.min.js', array( 'jquery', 'customize-controls' ), false, true );

	} // control_scripts()

} // class
