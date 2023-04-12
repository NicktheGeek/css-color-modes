<?php
/**
 * Thincrust functions and definitions
 *
 * @package Thincrust
 * @link    https://developer.wordpress.org/themes/basics/theme-functions/
 */

// Autoloader.
if ( defined( 'WPCOM_VIP_CLIENT_MU_PLUGIN_DIR' ) ) {
	require WPCOM_VIP_CLIENT_MU_PLUGIN_DIR . '/vendor/autoload.php';
} else {
	require WP_CONTENT_DIR . '/vendor/autoload.php';
}

// Setup.
require_once get_template_directory() . '/inc/functions-setup.php';

// Header, Main Menu, and Main Mobile Setup.
require_once get_template_directory() . '/inc/functions-header.php';

// Footer, Footer Title, and Footer Widgets.
require_once get_template_directory() . '/inc/functions-footer.php';

// Admin and Dashboard.
require_once get_template_directory() . '/inc/functions-admin.php';

// Blocks Registration and Callbacks.
require_once get_template_directory() . '/inc/functions-blocks.php';

// Template Tags.
require_once get_template_directory() . '/inc/functions-template-tags.php';
