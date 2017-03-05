<?php
/**
 * Plugin Name: Deleted Posts
 * Plugin URI: https://github.com/indiewordpress/wordpress-deleted-posts
 * Description: Sends a HTTP 410 (Gone) response to requests for trashed posts/pages.
 * Author: IndieWordPress Team
 * Author URI: https://github.com/indiewordpress
 * Version: 1.0.0
 * License: MIT
 * License URI: http://opensource.org/licenses/MIT
 * Text Domain: deleted-posts
 */

add_action( 'plugins_loaded', array( 'DeletedPosts_Plugin', 'init' ) );

/**
 * Deleted Posts Plugin Class
 *
 * @author Matthias Pfefferle
 */
class DeletedPosts_Plugin {

	/**
	 * Initialize Deleted Posts Plugin
	 */
	public static function init() {
		add_action( 'template_redirect', array( 'DeletedPosts_Plugin', 'handle_410' ), 99 );
	}

	public static function handle_410() {
		if ( ! is_404() ) {
			return;
		}

		global $wp_query;

		// check slug
		if ( ! empty( $wp_query->query['pagename'] ) ) {
			$query = new WP_Query(
				array(
					'pagename' => $wp_query->query['pagename'] . '__trashed',
					'post_status' => 'trash',
				)
			);
		} elseif ( ! empty( $wp_query->query['name'] ) ) {
			$query = new WP_Query(
				array(
					'name' => $wp_query->query['name'] . '__trashed',
					'post_status' => 'trash',
				)
			);
		} else {
			return;
		}

		// return 410
		if ( $query->get_posts() ) {
			status_header( 410 );

			// check if theme has a 410.php template
			$template_410 = get_query_template( 410 );

			// return 410 template
			if ( $template_410 ) {
				load_template( $template_410 );
				exit;
			}
		}
	}
}
