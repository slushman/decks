<?php

/**
 * Works with term meta.
 *
 * @since 		1.0.0
 * @package  	Decks
 */
class Decks_Termmeta {

	/**
	 * Array of conditions where the termmeta should appear.
	 *
	 * @since 		1.0.0
	 * @var 		array
	 */
	protected $conditions = array();

	/**
	 * Array of fields used in this termmeta.
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
	 * The nonce for all the termmeta.
	 *
	 * @since 		1.0.0
	 * @access 		protected
	 * @var 		string 			$nonce 			The nonce.
	 */
	protected $nonce = '';

	/**
	 * The termmeta properties.
	 *
	 * @since 		1.0.0
	 * @access 		protected
	 * @var 		array 			$props 			The termmeta properties.
	 */
	protected $props = '';

	/**
	 * Constructors. Set the class variables.
	 *
	 * @param 		array 		$props 				The termmeta properties.
	 * @param 		array 		$conditions 		The conditions for the termmeta.
	 */
	public function __construct( $props, $nonce, $fields, $conditions = '' ) {

		$this->set_conditions( $conditions );
		$this->set_fields( $fields );
		$this->set_nonce( $nonce );
		$this->set_props( $props );

	} // __construct()

	/**
	 * Includes the view for the term meta edit fields.
	 *
	 * @exits 		If not in the admin.
	 * @exits 		If not on the pa_compress-type taxonomy.
	 * @param 		object 		$term 			The term object
	 * @param 		string 		$taxonomy 		The taxonomy slug
	 */
	public function add_termmeta_fields_to_edit_screen( $term, $taxonomy ) {

		if ( ! is_admin() ) { return; }
		if ( ! $this->check_conditions( $post_obj ) ) { return FALSE; }

		include( plugin_dir_path( dirname( __FILE__ ) ) . '/views/metaboxes/' . $this->props['file']['edit'] . '.php' );

	} // add_termmeta_fields_to_edit_screen()

	/**
	 * Includes the view for the new term meta fields.
	 */
	public function add_termmeta_fields_to_new_screen() {

		if ( ! is_admin() ) { return; }

		include( plugin_dir_path( dirname( __FILE__ ) ) . '/views/metaboxes/' . $this->props['file']['new'] . '.php' );

	} // add_termmeta_fields_to_new_screen()

	/**
	 * Returns whether the conditions are met
	 *
	 * @exits 		If the class variable conditions is empty.
	 * @param 		obj 			$post_obj 		The post object
	 * @return 		bool 							Result of the checks.
	 */
	protected function check_conditions( $post_obj ) {

		if ( empty( $this->conditions ) || ! is_array( $this->conditions ) ) { return FALSE; }

		foreach ( $this->conditions as $type => $condition ) {

			if ( empty( $condition ) ) { continue; }

			$conditioner 	= new Rosh_Conditions();
			$check			= $conditioner->check( $type, $condition, $post_obj );

			if ( ! $check ) {

				return FALSE;

			}

		}

		return TRUE;

	} // check_conditions()

	/**
	 * Sets the $conditions class variable
	 *
	 * @param 		array 		$conditions 		The conditions for this metabox.
	 */
	public function set_conditions( $conditions ) {

		$defaults['cap'] 		= 'edit_post';
		$defaults['taxonomy'] 	= '';

		$this->conditions = wp_parse_args( $conditions, $defaults );

	} // set_conditions()

	/**
	 * Sets the $fields class variable
	 *
	 * @param 		array 		$fields 		Array of field data.
	 */
	public function set_fields( $fields ) {

		$this->fields = $fields;

	} // set_fields()

	/**
	 * Sets the class variable $meta
	 *
	 * @exits 		Post is empty.
	 * @exits 		Not on the correct post type.
	 * @hooked 		add_meta_boxes
	 * @param 		string 			$post_type			The post type.
	 * @param 		object 			$post_obj 			The post object.
	 */
	public function set_meta( $post_type, $post_obj ) {

		if ( empty( $post_obj ) ) { return FALSE; }
		if ( ! $this->check_conditions( $post_obj ) ) { return FALSE; }

		$this->meta = get_post_custom( $post_obj->ID );

	} // set_meta()

	/**
	 * Sets the $nonce class variable
	 *
	 * @param 		string 		$nonce 		The nonce name for this metabox.
	 */
	public function set_nonce( $nonce ) {

		$this->nonce = $nonce;

	} // set_nonce()

	/**
	 * Sets the $props class variable
	 *
	 * All properties:
	 * 		file-edit 			The view file for the edit screen.
	 * 		file-new 			The view file for the new screen.
	 *
	 * @param 		array 		$props 		The metabox properties.
	 */
	public function set_props( $props ) {

		$defaults['file']['edit'] 	= '';
		$defaults['file']['new'] 	= '';
		$this->props 				= wp_parse_args( $props, $defaults );

	} // set_props()

} // class
