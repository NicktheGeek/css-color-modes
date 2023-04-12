<?php
/**
 * Registers Blocks in PHP, in JavaScript, and provides a space for callback functions.
 *
 * @package Thincrust
 */

/**
 * Registers the custom blocks in the /blocks directory.
 */
function thincrust_register_blocks() {
	// Register the Individual Blocks by Namespace.
	new Thincrust\Blocks\Render_Callback_Example();
}
add_action( 'init', 'thincrust_register_blocks', 1 );

/**
 * Registers the admin script for the blocks.
 */
function thincrust_blocks_register_admin_scripts() {
	// Path to the built files.
	$blocks_asset_relative_path = '/assets/dist/blocks/';

	$script_asset_path = get_template_directory() . $blocks_asset_relative_path . 'index.asset.php';
	$index_js          = get_template_directory_uri() . $blocks_asset_relative_path . 'index.js';

	$script_asset = require $script_asset_path;
	// Register the script which registers the blocks.
	wp_enqueue_script(
		'thincrust-blocks',
		"$index_js",
		$script_asset['dependencies'],
		$script_asset['version'],
		false
	);
}
add_action( 'admin_enqueue_scripts', 'thincrust_blocks_register_admin_scripts' );
