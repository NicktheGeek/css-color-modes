<?php
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @package Thincrust
 */

/**
 * Theme setup.
 */
function thincrust_setup() {
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );

	/*
	* Switch default core markup for search form, comment form, and comments
	* to output valid HTML5.
	*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'main-menu' => esc_html__( 'Main Menu', 'thincrust' ),
		)
	);
}
add_action( 'after_setup_theme', 'thincrust_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function thincrust_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'thincrust_content_width', 800 );
}
add_action( 'after_setup_theme', 'thincrust_content_width', 0 );

/**
 * Enqueue scripts and styles. Front end.
 */
function thincrust_scripts_and_styles() {
	wp_enqueue_style( 'thincrust-style', get_template_directory_uri() . '/assets/dist/main.css', [], thincrust_get_asset_version( get_template_directory() . '/assets/dist/main.css' ) );

	// Main script with source at /src/js/index.js.
	$script_asset_path = get_template_directory() . '/assets/dist/main.asset.php';
	$script_asset      = require $script_asset_path;

	wp_enqueue_script( 'thincrust-script', get_template_directory_uri() . '/assets/dist/main.js', $script_asset['dependencies'], $script_asset['version'], true );
	// Comment Reply Script.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'thincrust_scripts_and_styles' );

/**
 * <head> Meta tags.
 */
function thincrust_head_meta_tags() {     ?>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php
}
add_action( 'wp_head', 'thincrust_head_meta_tags', 1 );


/**
 * Provides a single function to return a version asset number.
 * including the option to pass a filepath and get the modified file time back.
 *
 * @param string $filepath The path, not URI, to the asset.
 *
 * @return string the version number.
 */
function thincrust_get_asset_version( $filepath = null ) {
	$version_number = '0.0.1';
	if ( $filepath ) {
		if ( file_exists( $filepath ) ) {
			$filemtime = filemtime( $filepath );
			if ( $filemtime > 0 ) {
				$version_number = $filemtime;
			}
		}
	}
	return apply_filters( 'thincrust_asset_version', $version_number );
}

/**
 * Filters the settings to pass to the block editor for all editor type.
 * We are using this here to set the content size for a Page-like post type.
 *
 * @param array                   $editor_settings      Default editor settings.
 * @param WP_Block_Editor_Context $block_editor_context The current block editor context.
 *
 * @return array
 */
function thincrust_block_editor_settings( $editor_settings, $block_editor_context ) {
	// Get all Page-like post types.
	$page_like_post_types = get_post_types( [ 'hierarchical' => true ] );
	// Check if we are in a Page-like editing context.
	if ( in_array( $block_editor_context->post->post_type, $page_like_post_types, true ) ) {
		// Set the appropriate width.
		$editor_settings['__experimentalFeatures']['layout']['contentSize'] = 'var(--wp--custom--layout--wide-size)';
	}
	return $editor_settings;
}
add_filter( 'block_editor_settings_all', 'thincrust_block_editor_settings', 10, 2 );

/**
 * Register Post Meta
 */
function thincrust_register_post_meta() {
	// Page - `thincrust_hide_title`.
	register_post_meta(
		'page',
		'thincrust_hide_title',
		[
			'type'         => 'boolean',
			'show_in_rest' => true, // Must include for it work in the Block Editor.
			'single'       => true,
		]
	);
}
add_action( 'init', 'thincrust_register_post_meta' );
