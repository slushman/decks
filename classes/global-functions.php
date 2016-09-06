<?php
/**
 * Globally-accessible functions
 *
 * @link 		http://slushman.com
 * @since 		1.0.0
 *
 * @package		Decks
 * @subpackage 	Decks/classes
 */

 /**
  * Returns a post object of the requested post type
  *
  * @param 	string 		$post 			The name of the post type
  * @param   array 		$params 		Optional parameters
  *
  * @return 	object 		A post object
  */
 function decks_get_posts( $post, $params = array(), $cache = '' ) {

 	if ( empty( $post ) ) { return -1; }

 	$return = '';
 	$cache_name = 'posts';

 	if ( ! empty( $cache ) ) {

 		$cache_name = '' . $cache . '_posts';

 	}

 	$return = wp_cache_get( $cache_name, 'posts' );

 	if ( false === $return ) {

 		$args['post_type'] 				= $post;
 		$args['post_status'] 			= 'publish';
 		$args['order_by'] 				= 'date';
 		$args['posts_per_page'] 		= 200;
 		$args['no_found_rows']			= true;
 		$args['update_post_meta_cache'] = false;
 		$args['update_post_term_cache'] = false;

 		$args 	= wp_parse_args( $params, $args );
 		$query 	= new WP_Query( $args );

 		if ( ! is_wp_error( $query ) && $query->have_posts() ) {

 			wp_cache_set( $cache_name, $query, 'posts', 5 * MINUTE_IN_SECONDS );

 			$return = $query;

 		}

 	}

 	return $return;

} // decks_get_posts()

/**
 * Returns the requested SVG
 *
 * @param 	string 		$svg 		The name of the icon to return
 * @param 	string 		$link 		URL to link from the SVG
 *
 * @return 	mixed 					The SVG code
 */
function decks_get_svg( $svg ) {

	if ( empty( $svg ) ) { return; }

	$list = Decks_Public::get_svg_list();

	return $list[$svg];

} // decks_get_svg()

/**
 * Returns the path to a template file
 *
 * Looks for the file in these directories, in this order:
 * 		Current theme
 * 		Parent theme
 * 		Current theme decks folder
 * 		Parent theme decks folder
 * 		Current theme templates folder
 * 		Parent theme templates folder
 * 		Current theme views folder
 * 		Parent theme views folder
 * 		This plugin
 *
 * To use a custom list template in a theme, copy the
 * file from classes/views into a folder in your theme. The
 * folder can be named "decks", "templates", or "views".
 * Customize the files as needed, but keep the file name as-is. The
 * plugin will automatically use your custom template file instead
 * of the ones included in the plugin.
 *
 * @param 	string 		$name 			The name of a template file
 * @param 	string 		$location 		The subfolder containing the view
 *
 * @return 	string 						The path to the template
 */
function decks_get_template( $name, $location = '' ) {

	$template = '';

	$locations[] = "{$name}.php";
	$locations[] = "/decks/{$name}.php";
	$locations[] = "/templates/{$name}.php";
	$locations[] = "/views/{$name}.php";

	/**
	 * Filter the locations to search for a template file
	 *
	 * @param 	array 		$locations 			File names and/or paths to check
	 */
	$locations 	= apply_filters( 'decks_template_paths', $locations );
	$template 	= locate_template( $locations, TRUE );

	if ( ! empty( $template ) ) { return $template; }

	if ( empty( $location ) ) {

		$template = plugin_dir_path( dirname( __FILE__ ) ) . 'views/' . $name . '.php';

	} else {

		$template = plugin_dir_path( dirname( __FILE__ ) ) . 'views/' . $location . '/' . $name . '.php';

	}

	return $template;

} // decks_get_template()
