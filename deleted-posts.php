<?php
/**
 * Plugin Name: Deleted Posts
 * Plugin URI: https://github.com/indiewordpress/wordpress-deleted-posts
 * Description: Deleted Posts
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

	}
}
