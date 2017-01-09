<?php
/**
 * The metabox-specific functionality of the plugin.
 *
 * @link 		http://slushman.com
 * @since 		1.0.0
 *
 * @package 	Decks
 */
class Decks_Metabox_Background {

	/**
	 * Array of conditions where the metabox should appear.
	 *
	 * @since 		1.0.0
	 * @var 		array
	 */
	protected $conditions = array();

	/**
	 * Array of fields used in these metaboxes.
	 *
	 * @since 		1.0.0
	 *
	 * @var [type]
	 */
	protected $fields = array();

	/**
	 * The post meta data
	 *
	 * @since 		1.0.0
	 * @access 		protected
	 * @var 		string 			$meta    			The post meta data.
	 */
	protected $meta = array();

	/**
	 * The nonces for all the metaboxes.
	 *
	 * @since 		1.0.0
	 * @access 		protected
	 * @var 		string 			$nonce 			The nonce.
	 */
	protected $nonce = '';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 		1.0.0
	 */
	public function __construct() {

		$this->nonce = 'nonce_decks_background';

		$this->conditions['post_type'] 	= 'slide';
		$this->conditions['cap'] 		= 'edit_post';

		$this->fields[] 	= array( 'bgtype', 'radio', 'none' );
		$this->fields[] 	= array( 'bgtransition', 'select', 'default' );
		$this->fields[] 	= array( 'bgtransitionout', 'select', 'default' );
		$this->fields[] 	= array( 'bg-color', 'color', '#fff' );
		$this->fields[] 	= array( 'bgsize', 'text', '' );
		$this->fields[] 	= array( 'bgposition', 'text', '' );
		$this->fields[] 	= array( 'bgrepeat', 'text', '' );
		$this->fields[] 	= array( 'video-url', 'url', '' );
		$this->fields[] 	= array( 'video-loop', 'checkbox', 0 );
		$this->fields[] 	= array( 'video-muted', 'checkbox', 0 );
		$this->fields[] 	= array( 'iframe-url', 'url', '' );

	} // __construct()

	/**
	 * Registers all the WordPress hooks and filters for this class.
	 */
	public function hooks() {

		add_action( 'add_meta_boxes', 			array( $this, 'add_metaboxes' ), 10, 2 );
		add_action( 'add_meta_boxes', 			array( $this, 'set_meta' ), 10, 2 );
		add_action( 'save_post', 				array( $this, 'validate_meta' ), 10, 2 );
		add_action( 'edit_form_after_title', 	array( $this, 'promote_metaboxes' ), 10, 1 );

	} // hooks()

	/**
	 * Registers metaboxes with WordPress
	 *
	 * @hooked 		add_meta_boxes
	 * @since 	1.0.0
	 * @access 	public
	 * @param 		string 			$post_type		The post type.
	 * @param 		object 			$post_obj 			The post object.
	 */
	public function add_metaboxes( $post_type, $post_obj ) {

		if ( ! is_admin() ) { return; }
		if ( ! $this->check_conditions( $post_obj ) ) { return; }

		$post_type = $this->get_post_type();

		add_meta_box(
			'slide-background',
			apply_filters( DECKS_SLUG . '-slide-background-title', esc_html__( 'Slide Background', 'decks' ) ),
			array( $this, 'metabox' ),
			$post_type,
			'normal',
			'default',
			array(
				'file' => 'slide-background'
			)
		);

	} // add_metaboxes()

	/**
	 * Uses the condition class to check if the metabox should appear or not.
	 *
	 * @exits 		If the class variables "conditions" is empty or not an array.
	 * @param 		obj 			$post_obj 		The post object
	 * @return 		bool 							Result of the checks.
	 */
	private function check_conditions( $post_obj ) {

		if ( empty( $this->conditions ) || ! is_array( $this->conditions ) ) { return FALSE; }

		foreach ( $this->conditions as $type => $condition ) {

			if ( empty( $condition ) ) { continue; }

			$conditioner 	= new Decks_Conditions();
			$check			= $conditioner->check( $type, $condition, $post_obj );

			if ( ! $check ) {

				return FALSE;

			}

		}

		return TRUE;

	} // check_conditions()

	/**
	 * Returns the post type or the current screen's post type.
	 *
	 * @return 		string 		The post type.
	 */
	private function get_post_type() {

		if ( array_key_exists( 'post_type', $this->conditions ) ) { return $this->conditions['post_type']; }

		$screen = get_current_screen();

		return $screen->post_type;

	} // get_post_type()

	/**
	 * Calls a metabox file specified in the add_meta_box args.
	 *
	 * @exits 		Not in the admin.
	 * @exits 		Not on the correct post type.
	 * @since 		1.0.0
	 * @access 		public
	 */
	public function metabox( $post_obj, $params ) {

		if ( ! is_admin() ) { return FALSE; }
		if ( ! $this->check_conditions( $post_obj ) ) { return FALSE; }

		include( plugin_dir_path( dirname( __FILE__ ) ) . '/views/metaboxes/' . $params['args']['file'] . '.php' );

	} // metabox()

	/**
	 * Checks conditions before validating metabox submissions.
	 *
	 * Returns FALSE under these conditions:
	 * 		Doing autosave.
	 * 		User doesn't have the capabilities.
	 * 		Not on the correct post type.
	 * 		Nonce isn't set.
	 * 		Nonce does't validate.
	 *
	 * @param 		object 		$posted 		The submitted data.
	 * @param 		int 		$post_id 		The post ID.
	 * @param 		object 		$post_obj 		The post object.
	 * @return 		bool 						FALSE if any conditions are met, otherwise TRUE.
	 */
	private function pre_validation_checks( $posted, $post_id, $post_obj ) {

		if ( wp_is_post_autosave( $post_id ) ) { return FALSE; }
		if ( wp_is_post_revision( $post_id ) ) { return FALSE; }
		if ( ! $this->check_conditions( $post_obj ) ) { return FALSE; }
		if ( ! isset( $posted[$this->nonce] ) ) { return FALSE; }
		if ( isset( $posted[$this->nonce] ) && ! wp_verify_nonce( $posted[$this->nonce], DECKS_SLUG ) ) { return FALSE; }

		return TRUE;

	} // pre_validation_checks()

	/**
	 * Adds all metaboxes in the "top" priority to just under the title field.
	 *
	 * @exits 		If the conditions aren't met.
	 * @hooked 		edit_form_after_title
	 * @param `		object 		$post_obj 		The post object.`
	 */
	public function promote_metaboxes( $post_obj ) {

		if ( ! $this->check_conditions( $post_obj ) ) { return FALSE; }

		global $wp_meta_boxes;

		do_meta_boxes( get_current_screen(), 'top', $post_obj );

		$post_type = $this->get_post_type();

		unset( $wp_meta_boxes[$post_type]['top'] );

	} // promote_metaboxes()

	/**
	 * Saves the metadata to the database.
	 *
	 * @exits 		If $meta is empty.
	 * @exits 		If $posted is empty.
	 * @param 		array 		$meta 			The field info.
	 * @param 		array 		$posted 		Data posted by the form.
	 * @param 		int 		$post_id 		The post ID.
	 * @return 		bool 						The result from update_post_meta().
	 */
	private function save_meta( $meta, $posted, $post_id ) {

		if ( empty( $meta ) ) { return FALSE; }
		if ( empty( $posted ) ) { return FALSE; }
		if ( empty( $post_id ) ) { return FALSE; }

		$value 		= ( empty( $this->meta[$meta[0]][0] ) ? '' : $this->meta[$meta[0]][0] );
		$sanitizer 	= new Decks_Sanitize();
		$new_value 	= $sanitizer->clean( $posted[$meta[0]], $meta[1] );
		$updated 	= update_post_meta( $post_id, $meta[0], $new_value );

		return $updated;

	} // save_meta()

	/**
	 * Sets the class variable $options
	 *
	 * @exits 		Post is empty.
	 * @exits 		Not on the correct post type.
	 * @hooked 		add_meta_boxes
	 * @param 		string 			$post_type		The post type.
	 * @param 		object 			$post_obj 			The post object.
	 */
	public function set_meta( $post_type, $post_obj ) {

		if ( empty( $post_obj ) ) { return FALSE; }
		if ( ! $this->check_conditions( $post_obj ) ) { return FALSE; }

		$this->meta = get_post_custom( $post_obj->ID );

	} // set_meta()

	/**
	 * Saves metabox data
	 *
	 * @hooked 		save_post 		10
	 * @since 		1.0.0
	 * @access 		public
	 * @param 		int 			$post_id 		The post ID
	 * @param 		object 			$post_obj 			The post object
	 */
	public function validate_meta( $post_id, $post_obj ) {

		$validate = $this->pre_validation_checks( $_POST, $post_id, $post_obj );

		if ( ! $validate ) { return $post_id; }

		foreach ( $this->fields as $meta ) {

			$this->save_meta( $meta, $_POST, $post_id );

		} // foreach

	} // validate_meta()

} // class
