<?php
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @link 		http://wpdecks.com
 * @since 		1.0.0
 * @package 	Decks
 * @subpackage 	Decks/classes
 * @author 		Slushman <chris@slushman.com>
 */
class Decks {

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Decks 	$_instance 		Instance singleton.
	 */
	protected static $_instance;

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Decks_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->load_dependencies();
		$this->set_locale();
		$this->define_customizer_hooks();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_shortcode_hooks();
		$this->define_template_hooks();
		$this->define_metabox_hooks();
		$this->define_cpt_and_tax_hooks();

	} // __construct()

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for all global functions.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/global-functions.php';

		$this->loader = new Decks_Loader();

	} // load_dependencies()

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Decks_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Decks_i18n();

		$this->loader->action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	} // set_locale()

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Decks_Admin();

		$this->loader->action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->action( 'admin_init', $plugin_admin, 'register_fields' );
		$this->loader->action( 'admin_init', $plugin_admin, 'register_sections' );
		$this->loader->action( 'admin_init', $plugin_admin, 'register_settings' );
		$this->loader->action( 'admin_menu', $plugin_admin, 'add_menu' );
		$this->loader->action( 'plugin_action_links_' . DECKS_FILE, $plugin_admin, 'link_settings' );
		$this->loader->action( 'plugin_row_meta', $plugin_admin, 'link_row_meta', 10, 2 );

	} // define_admin_hooks()

	/**
	 * Register all of the hooks related to metaboxes
	 *
	 * @since 		1.0.0
	 * @access 		private
	 */
	private function define_cpt_and_tax_hooks() {

		$plugin_cpt_slide = new Decks_CPT_Slide();

		$this->loader->action( 'init', $plugin_cpt_slide, 'new_cpt_slide' );
		$this->loader->filter( 'manage_slide_posts_columns', $plugin_cpt_slide, 'slide_register_columns' );
		$this->loader->action( 'manage_slide_posts_custom_column', $plugin_cpt_slide, 'slide_column_content', 10, 2 );
		$this->loader->filter( 'manage_edit-slide_sortable_columns', $plugin_cpt_slide, 'slide_sortable_columns', 10, 1 );
		$this->loader->action( 'request', $plugin_cpt_slide, 'slide_order_sorting', 10, 2 );
		$this->loader->action( 'init', $plugin_cpt_slide, 'add_image_sizes' );



		$plugin_tax_presentation =new Decks_Tax_Presentation();

		$this->loader->action( 'init', $plugin_tax_presentation, 'new_taxonomy_presentation' );

	} // define_cpt_and_tax_hooks()

	/**
	 * Register all of the hooks related to the Customizer.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 */
	private function define_customizer_hooks() {

		$theme_customizer = new Decks_Customizer();

		$this->loader->action( 'customize_register', 					$theme_customizer, 'register_panels' );
		$this->loader->action( 'customize_register', 					$theme_customizer, 'register_sections' );
		$this->loader->action( 'customize_register', 					$theme_customizer, 'register_fields' );
		$this->loader->action( 'wp_head', 								$theme_customizer, 'header_output' );
		$this->loader->action( 'customize_preview_init', 				$theme_customizer, 'live_preview' );
		$this->loader->action( 'customize_controls_enqueue_scripts', 	$theme_customizer, 'control_scripts' );
		//$this->loader->action( 'customize_register', 					$theme_customizer, 'load_customize_controls', 0 );

	} // define_customizer_hooks()

	/**
	 * Register all of the hooks related to metaboxes
	 *
	 * @since 		1.0.0
	 * @access 		private
	 */
	private function define_metabox_hooks() {

		$metaboxes = array( 'Background' );

		foreach ( $metaboxes as $box ) {

			$class 	= 'Decks_Metabox_' . $box;
			$box 	= new $class();

			$this->loader->action( 'add_meta_boxes', 		$box, 'add_metaboxes', 10, 2 );
			$this->loader->action( 'add_meta_boxes', 		$box, 'set_meta', 10, 2 );
			$this->loader->action( 'save_post', 			$box, 'validate_meta', 10, 2 );
			$this->loader->action( 'edit_form_after_title', $box, 'promote_metaboxes', 10, 1 );

		}

	} // define_metabox_hooks()

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Decks_Public();

		$this->loader->action( 'wp_print_scripts', $plugin_public, 'dequeue_scripts', 99 );
		$this->loader->action( 'wp_print_styles', $plugin_public, 'dequeue_styles', 99 );
		$this->loader->action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->filter( 'template_include', $plugin_public, 'presentation_template' );
		$this->loader->filter( 'decks_slides', $plugin_public, 'get_slides' );
		$this->loader->filter( 'decks_initialize', $plugin_public, 'initialize_settings' );

	} // define_public_hooks()

	/**
	 * Registers hooks for shortcodes.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_shortcode_hooks() {

		$shortcodes = array( 'slidestep', 'slidecode', 'slidenotes' );

		foreach ( $shortcodes as $shortcode ) {

			$class 			= 'Decks_Shortcode_' . $shortcode;
			$shortcode_obj 	= new $class();
			$function 		= strtolower( $shortcode );

			$this->loader->shortcode( $function, $shortcode_obj, 'shortcode_' . $function );
			$this->loader->action( $function, $shortcode_obj, 'shortcode_' . $function );

		}

	} // define_shortcode_hooks()

	/**
	 * Register all of the hooks related to the templates.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_template_hooks() {

		$plugin_templates = new Decks_Templates();

		// Loop
		$this->loader->action( 'decks-before-loop', 			$plugin_templates, 'loop_wrap_begin', 10, 1 );

		$this->loader->action( 'decks-before-loop-content', 	$plugin_templates, 'loop_content_wrap_begin', 10, 2 );
		$this->loader->action( 'decks-before-loop-content', 	$plugin_templates, 'loop_content_link_begin', 15, 2 );

		$this->loader->action( 'decks-loop-content', 			$plugin_templates, 'loop_content_image', 10, 2 );
		$this->loader->action( 'decks-loop-content', 			$plugin_templates, 'loop_content_title', 15, 2 );
		$this->loader->action( 'decks-loop-content', 			$plugin_templates, 'loop_content_subtitle', 20, 2 );

		$this->loader->action( 'decks-after-loop-content', 		$plugin_templates, 'loop_content_link_end', 10, 2 );
		$this->loader->action( 'decks-after-loop-content', 		$plugin_templates, 'loop_content_wrap_end', 90, 2 );

		$this->loader->action( 'decks-after-loop', 				$plugin_templates, 'loop_wrap_end', 10, 1 );

		// Single
		$this->loader->action( 'decks-single-content', 			$plugin_templates, 'single_slide_thumbnail', 10 );
		$this->loader->action( 'decks-single-content', 			$plugin_templates, 'single_slide_posttitle', 15 );
		$this->loader->action( 'decks-single-content', 			$plugin_templates, 'single_slide_subtitle', 20, 1 );
		$this->loader->action( 'decks-single-content', 			$plugin_templates, 'single_slide_content', 25 );
		$this->loader->action( 'decks-single-content', 			$plugin_templates, 'single_slide_meta_field', 30, 1 );

	} // define_template_hooks()

	/**
	 * Get instance of main class
	 *
	 * @since 		1.0.0
	 * @return 		Plugin_Name
	 */
	public static function get_instance() {

		if ( empty( self::$_instance ) ) {

			self::$_instance = new self;

		}

		return self::$_instance;

	} // get_instance()

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 *
	 * @return    Decks_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {

		return $this->loader;

	} // get_loader()

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {

		$this->loader->run();

	} // run()

} // class
