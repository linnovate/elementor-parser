<?php
/**
 * Plugin Name: Elementor outside
 * Description: The most advanced frontend drag & drop page builder. Create high-end, pixel perfect websites at record speeds. Any theme, any page, any design.
 * Plugin URI: https://elementor.com/?utm_source=wp-plugins&utm_campaign=plugin-uri&utm_medium=wp-dash
 * Author: linnovate.net
 * Version: 0.1.0
 * Author URI: linnovate.net
 *
 * Text Domain: elementor
 *
 * @package Elementor
 * @category Core
 */

use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


add_action( 'init', 'elementor_outside_init', 1000 );

function elementor_outside_init() {

	// now login user
	if (!is_user_logged_in()) {
		// $user = get_user_by("login", 'root' );
 		// wp_set_auth_cookie($user->ID);
		wp_set_auth_cookie(1);
	}

	// remove redirect_canonical
	remove_filter('template_redirect', 'redirect_canonical');

	// remove the admin_bar 
	// add_filter( 'show_admin_bar', '__return_false' );

	// Set Rewrite All posts and clean url's for create and edit post
	global $wp_rewrite;
	$wp_rewrite->set_permalink_structure("/%postname%/");
// 	$wp_rewrite->add_rule( '^create_elementor_post/?$', 'wp-admin/edit.php?action=create_elementor_post', 'top' );
// 	$wp_rewrite->add_rule( '^edit_elementor_post/([^/]+)/?$', 'wp-admin/post.php?postname=$matches[1]&action=edit_elementor_post', 'top' );
	$wp_rewrite->flush_rules();

	// action tag for create post
	add_action( 'admin_action_create_elementor_post', function() {
		$document = Plugin::$instance->documents->create( 
			'post',
			[ 'post_type' => 'post' ], 
			apply_filters( 'elementor/admin/create_new_post/meta', [] )
		);
		wp_redirect( $document->get_edit_url());
		die;
	});

	// action tag for edit post
	add_action( 'admin_action_edit_elementor_post', function() {
		$post = get_page_by_title($_REQUEST['postname'], OBJECT, 'post');
		$document = Plugin::$instance->documents->get( $post->ID );
		wp_redirect( $document->get_edit_url());
		die;
	});

	// set "canvas" template
	add_action( 'save_post' , function($post_id) {
		update_metadata( 'post', $post_id, '_wp_page_template', 'elementor_canvas' );
	});

	// allow only "canvas" template
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
	
