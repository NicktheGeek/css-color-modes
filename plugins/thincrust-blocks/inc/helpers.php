<?php
/**
 * Common Thincrust Block helper functions.
 *
 * @package Thincrust
 */

/**
 * Get a template from a list of possible templates.
 *
 * @param string $filename    The name of the template file.
 * @param array  $directories The list of possible directories.
 *
 * @uses validate_file
 * @see https://developer.wordpress.org/reference/functions/validate_file/
 *
 * @return string
 */
function thincrust_get_template( $filename, $directories ) {
	// Strip '.php' from the end of the filename.
	$filename = str_replace( '.php', '', $filename );

	$the_template = '';

	foreach ( $directories as $directory ) {
		$template = trailingslashit( $directory ) . $filename . '.php';

		if ( file_exists( $template ) ) {
			$the_template = $template;
			break;
		}
	}

	/**
	 * Allows filtering the template file location before getting or returning.
	 *
	 * @param string $the_template The template file path.
	 * @param array  $directories  The template directories.
	 */
	$the_template = apply_filters( "thincrust_template_{$filename}", $the_template, $directories );

	return $the_template;
}

/**
 * Get a template content from a list of possible templates.
 *
 * @param string $filename    The name of the template file.
 * @param array  $directories The list of possible directories.
 *
 * @uses rkv_get_template
 *
 * @return string
 */
function thincrust_get_template_content( $filename, $directories ) {
	$the_template = thincrust_get_template( $filename, $directories );

	ob_start();

	include $the_template;

	return ob_get_clean();
}

/**
 * Get a list of block layout templates for a given post type.
 *
 * @return array
 */
function rkv_get_block_layout_templates() {
	/**
	 * Filter the list of layout templates.
	 *
	 * @param array  $templates  The list of block layout templates.
	 *
	 * @return array
	 */
	$templates = apply_filters( 'thincrust_block_layout_templates', [] );

	return $templates;
}
