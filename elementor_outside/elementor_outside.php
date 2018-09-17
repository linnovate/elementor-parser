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

add_action( 'init', 'elementor_outside' );

function elementor_outside() {
	// add_rewrite_tag('%elementor_content_id%','([0-9]+)', 'elementor_content_id=');

	add_permastruct('elementor_content','/elementor/content/%post_id%',false);
	add_permastruct('elementor_edit','elementor/edit/%post_id%',false);
	add_permastruct('elementor_preview','elementor/preview/%post_id%',false);
	add_permastruct('elementor_delete','elementor/delete/%post_id%',false);
	add_permastruct('elementor_create','elementor/create',false);
	add_permastruct('elementor_update','elementor/update/',false);

	// add_rewrite_rule('^elementor/content/([0-9]+)/?', 'index.php?elementor_content=$matches[1]&page_id=$matches[1]', 'top');
	// add_rewrite_rule('^elementor/create', 'wp-admin/edit.php?action=elementor_new_post&post_type=page', 'top');
	// add_rewrite_rule('^elementor/edit/([0-9]+)/?', 'wp-admin/post.php?post=$matches[1]&action=elementor', 'top');
	// add_rewrite_rule('^elementor/update', 'admin-ajax.php', 'top');
	// add_rewrite_rule('^elementor/preview/([0-9]+)/?', 'index.php?page_id=$matches[1]&preview=true', 'top');


	flush_rewrite_rules();

	// add_filter( 'show_admin_bar', '__return_false' );

	add_action( 'save_post' , function($post_id) {
		update_metadata( 'post', $post_id, '_wp_page_template', 'elementor_canvas' );
	});

	add_filter( 'elementor/documents/register_controls', function($document) {
		$document->update_control('template', [
			'default' => 'elementor_canvas',
			'type' => 'hidden',
			'options' => ['elementor_canvas' => __( 'Elementor canvas', 'elementor' )],
		]);
		$document->remove_control('template_default_description');
		$document->remove_control('template_canvas_description');
	});
}