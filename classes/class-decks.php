<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link 		http://wpdecks.com
 * @since 		1.0.0
 *
 * @package 	Decks
 * @subpackage 	Decks/classes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since 		1.0.0
 * @package 	Decks
 * @subpackage 	Decks/classes
 * @author 		Slushman <chris@slushman.com>
 */
class Decks {

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
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the Decks and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name 	= 'decks';
		$this->version 		= '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_template_hooks();
		$this->define_metabox_hooks();
		$this->define_cpt_and_tax_hooks();

	} // __construct()

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Decks_Loader. Orchestrates the hooks of the plugin.
	 * - Decks_i18n. Defines internationalization functionality.
	 * - Decks_Admin. Defines all hooks for the admin area.
	 * - Decks_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-i18n.php';

		/**
		 * The class responsible for sanitizing user input
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-sanitizer.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-public.php';

		/**
		 * The class responsible for defining all actions relating to metaboxes.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-metaboxes.php';

		/**
		 * The class responsible for defining all actions relating to the slide custom post type.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-cpt-slide.php';

		/**
		 * The class responsible for defining all actions relating to the Presentation taxonomy.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-tax-presentation.php';

		/**
		 * The class responsible for defining all actions creating the templates.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-templates.php';

		/**
		 * The class responsible for all global functions.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/global-functions.php';

		/**
		 * The class with methods shared by admin and public
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-shared.php';

		$this->loader 		= new Decks_Loader();
		$this->sanitizer 	= new Decks_Sanitize();

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

		$plugin_admin = new Decks_Admin( $this->get_plugin_name(), $this->get_version() );

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

		$plugin_cpt_slide = new Decks_CPT_Slide( $this->get_plugin_name(), $this->get_version() );

		$this->loader->action( 'init', $plugin_cpt_slide, 'new_cpt_slide' );
		$this->loader->filter( 'manage_slide_posts_columns', $plugin_cpt_slide, 'slide_register_columns' );
		$this->loader->action( 'manage_slide_posts_custom_column', $plugin_cpt_slide, 'slide_column_content', 10, 2 );
		$this->loader->filter( 'manage_edit-slide_sortable_columns', $plugin_cpt_slide, 'slide_sortable_columns', 10, 1 );
		$this->loader->action( 'request', $plugin_cpt_slide, 'slide_order_sorting', 10, 2 );
		$this->loader->action( 'init', $plugin_cpt_slide, 'add_image_sizes' );

		$plugin_tax_presentation =new Decks_Tax_Presentation( $this->get_plugin_name(), $this->get_version() );

		$this->loader->action( 'init', $plugin_tax_presentation, 'new_taxonomy_presentation' );

	} // define_cpt_and_tax_hooks()

	/**
	 * Register all of the hooks related to metaboxes
	 *
	 * @since 		1.0.0
	 * @access 		private
	 */
	private function define_metabox_hooks() {

		$plugin_metaboxes = new Decks_Admin_Metaboxes( $this->get_plugin_name(), $this->get_version() );

		$this->loader->action( 'add_meta_boxes_slide', $plugin_metaboxes, 'add_metaboxes' );
		$this->loader->action( 'save_post_slide', $plugin_metaboxes, 'validate_meta', 10, 2 );
		//$this->loader->action( 'edit_form_after_title', $plugin_metaboxes, 'metabox_subtitle', 10, 2 );
		$this->loader->action( 'add_meta_boxes_slide', $plugin_metaboxes, 'set_meta' );
		$this->loader->filter( 'post_type_labels_slide', $plugin_metaboxes, 'change_featured_image_labels', 10, 1 );

	} // define_metabox_hooks()

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Decks_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->filter( 'single_template', $plugin_public, 'single_cpt_template', 11 );

	} // define_public_hooks()

	/**
	 * Register all of the hooks related to the templates.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_template_hooks() {

		$plugin_templates = new Decks_Templates( $this->get_plugin_name(), $this->get_version() );

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
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {

		$this->loader->run();

	} // run()

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 *
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {

		return $this->plugin_name;

	} // get_Decks()

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
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 *
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {

		return $this->version;

	} // get_version()

} // class
