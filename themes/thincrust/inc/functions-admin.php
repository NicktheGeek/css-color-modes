<?php
/**
 * Registers solely admin side functionality.
 *
 * @package Thincrust
 */

/**
 * Register and enqueue the editor stylesheet in the WordPress admin.
 */
function thincrust_enqueue_admin_editor_style() {
	wp_enqueue_style( 'thincrust-editor-style', get_template_directory_uri() . '/assets/dist/editor.css', [], thincrust_get_asset_version( get_template_directory() . '/assets/dist/editor.css' ) );

	// Main script with source at /src/js/index.js.
	$script_asset_path = get_template_directory() . '/assets/dist/editor.asset.php';
	$script_asset      = require $script_asset_path;
	wp_enqueue_script( 'thincrust-editor-script', get_template_directory_uri() . '/assets/dist/editor.js', $script_asset['dependencies'], $script_asset['version'], true );
}
add_action( 'admin_enqueue_scripts', 'thincrust_enqueue_admin_editor_style' );

/**
 * Include the Front Page and Posts Page in the admin menus.
 */
function thincrust_add_front_page_to_admin_menu() {
	// Front Page.
	$page_on_front_option_id = get_option( 'page_on_front' );
	if ( isset( $page_on_front_option_id ) && intval( $page_on_front_option_id ) ) {
		$front_page_link = sprintf( '/post.php?post=%d&amp;action=edit', $page_on_front_option_id );
		add_pages_page( __( 'Front Page', 'thincrust' ), __( 'Front Page', 'thincrust' ), 'manage_options', esc_url( $front_page_link ) );
	}

	// Posts (or Blog) page.
	$page_for_posts_option_id = get_option( 'page_for_posts' );
	if ( isset( $page_for_posts_option_id ) && intval( $page_for_posts_option_id ) ) {
		$posts_page_link = sprintf( '/post.php?post=%d&amp;action=edit', $page_for_posts_option_id );
		add_pages_page( __( 'Posts Page', 'thincrust' ), __( 'Posts Page', 'thincrust' ), 'manage_options', esc_url( $posts_page_link ) );
	}
}

add_action( 'admin_menu', 'thincrust_add_front_page_to_admin_menu' );

/**
 * Adds an "/edit" endpoint that allows for easy redirecting to the Edit page.
 *
 * @return void
 */
function thincrust_add_on_edit_permalink_point() {
	add_rewrite_endpoint( 'edit', EP_PERMALINK | EP_PAGES );
}
add_action( 'init', 'thincrust_add_on_edit_permalink_point' );

/**
 * When /edit is placed on the end of a singluar URL, and the user is logged in, it will redirect to the edit screen.
 *
 * @return void
 */
function thincrust_add_on_edit_permalink_point_template_redirect() {
	global $wp_query;
	if ( isset( $wp_query->query_vars['edit'] ) && is_user_logged_in() && is_singular() ) {
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				global $post;
				wp_safe_redirect( get_edit_post_link( $post->ID, '&' ) );
				exit;
			endwhile;
		endif;
	}
}
add_action( 'template_redirect', 'thincrust_add_on_edit_permalink_point_template_redirect' );
