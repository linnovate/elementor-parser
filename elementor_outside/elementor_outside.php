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


add_action( 'init', 'elementor_outside_init' );


function elementor_outside_init() {
// 	$creds = array(
//         'user_login'    => 'admin',
//         'user_password' => 'ssWLhDgi3hvwQ!4b5m',
//         'remember'      => true
//     );
 
//     $user = wp_signon( $creds, false );
 
//     if ( is_wp_error( $user ) ) {
//         echo $user->get_error_message();
//     }


// 		$user_id = 1;
// 		$user = get_user_by( 'id', $user_id ); 
// 		if( $user ) {
// 			$curr_user=  new WP_User( $user_id , $user->user_login ); 
// 			wp_set_auth_cookie( $user_id, true );
// 			do_action( 'wp_login', $user->user_login );
// 		}
	
// 	wp_set_current_user(1);
    
//     if ( is_wp_error( $user ) ) {
//         echo $user->get_error_message();
//     }

//    $current_user = wp_get_current_user(); 

	// remove the admin_bar 
	// add_filter( 'show_admin_bar', '__return_false' );

	// action tag for a new post
	add_action( 'admin_action_elementor_outside_new_post', function() {
		$document = Plugin::$instance->documents->create( 
			'post',
			[ 'post_type' => 'post' ], 
			apply_filters( 'elementor/admin/create_new_post/meta', [] )
		);
		wp_redirect( $document->get_edit_url() );
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
	
