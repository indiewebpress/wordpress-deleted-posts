<?php
/**
 * Plugin Name: Deleted Posts
 * Plugin URI: https://github.com/indiewordpress/wordpress-deleted-posts
 * Description: Sends a HTTP 410 (Gone) response to requests for trashed posts/pages.
 * Author: IndieWordPress Team
 * Author URI: https://github.com/indiewordpress
 * Version: 1.0.1
 * License: MIT
 * License URI: http://opensource.org/licenses/MIT
 * Text Domain: deleted-posts
 */

add_action( 'template_redirect', 'IndieWordPress_handle_410', 99 );

/**
 * Deleted Posts Plugin Class
 *
 * @author Matthias Pfefferle
 */
function IndieWordPress_handle_410() {
	
	if ( ! is_404() ) {
		return;
	}

	global $wp_query;

	$defaultArguments = [
		'pagename' => ( empty( $wp_query->query['pagename'] ) ? $wp_query->query['pagename'] : false ),
		'name' => ( empty( $wp_query->query['name'] ) ? $wp_query->query['name'] : false),
		'post_status' => 'trash',
	];

	$filteredArguments = array_filter($defaultArguments, function($value){
		if($value === false || $value == 'trash'){
			return $value;
		}

		return $value . '__trashed';
	});

	if ( count($filteredArguments) <= 1 ) {
		return;
	}

	$query = new WP_Query($filteredArguments);

	// return 410
	if ( count($query->get_posts()) <= 0 ) {
		return;
	}

	status_header( 410 );

	// check if theme has a 410.php template
	$template_410 = get_query_template( 410 );

	// return 410 template
	if ( $template_410 ) {
		load_template( $template_410 );
		exit;
	}
}
