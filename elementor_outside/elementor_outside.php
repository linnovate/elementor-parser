<?php
/**
 * Plugin Name: Elementor outside
 * Description: The most advanced frontend drag & drop page builder. Create high-end, pixel perfect websites at record speeds. Any theme, any page, any design.
 * Plugin URI: https://elementor.com/?utm_source=wp-plugins&utm_campaign=plugin-uri&utm_medium=wp-dash
 * Author: Elementor.com
 * Version: 2.2.1
 * Author URI: https://elementor.com/?utm_source=wp-plugins&utm_campaign=author-uri&utm_medium=wp-dash
 *
 * Text Domain: elementor
 *
 * @package Elementor
 * @category Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'init', 'elementor_outside_pages' );

function elementor_outside_pages() {
	// add_rewrite_tag('%page%','([^/]+)', 'pagename=');
	add_permastruct('elementor_content','/elementor/content/%page_id%/',false);

// 	global $wp_rewrite;
// $projects_structure = '/projects/%year%/%monthnum%/%day%/%projects%/';
// $wp_rewrite->add_rewrite_tag("%projects%", '([^/]+)', "project=");
// $wp_rewrite->add_permastruct('projects', $projects_structure, false);

	// add_permastruct('elementor/content','/elementor/content/%post_id%',false);

	add_rewrite_rule('^elementor/content/([0-9]+)/?', 'index.php?page_id=$matches[1]', 'top');
	add_rewrite_rule('^elementor/create', '/wp-admin/edit.php?action=elementor_new_post&post_type=page', 'top');
	add_rewrite_rule('^elementor/edit/([0-9]+)/?', 'wp-admin/post.php?post=$matches[1]&action=elementor', 'top');
	add_rewrite_rule('^elementor/update', 'admin-ajax.php', 'top');
	add_rewrite_rule('^elementor/preview/([0-9]+)/?', 'index.php?page_id=$matches[1]&preview=true', 'top');
	flush_rewrite_rules();
}
