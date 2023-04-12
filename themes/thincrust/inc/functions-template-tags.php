<?php
/**
 * Template tags.
 *
 * @package Thincrust
 */

/**
 * Retrieves whether or not the page's title has been set to be hidden.
 *
 * @param int|WP_Post $post Optional. Post ID or WP_Post object. Default is global $post.
 *
 * @return boolean
 */
function thincrust_is_title_hidden( $post = 0 ) {
	$post = get_post( $post );
	$id   = isset( $post->ID ) ? $post->ID : null;
	if ( ! empty( $id ) ) {
		return get_post_meta( $id, 'thincrust_hide_title', true ) ? true : false;
	}
	return false;
}


/**
 * Allows SVGs in a post context.
 *
 * @param array[] $tags    Allowed HTML tags.
 */
function thincrust_wp_kses_allowed_html_allow_svg( $tags ) {
	$tags['svg']     = [
		'class'       => [],
		'xmlns'       => [],
		'width'       => [],
		'height'      => [],
		'viewbox'     => [],
		'aria-hidden' => [],
		'role'        => [],
		'focusable'   => [],
	];
	$tags['path']    = [
		'fill'      => [],
		'fill-rule' => [],
		'd'         => [],
		'transform' => [],
	];
	$tags['polygon'] = [
		'fill'      => [],
		'fill-rule' => [],
		'points'    => [],
		'transform' => [],
		'focusable' => [],
	];
	return $tags;
}
add_filter( 'wp_kses_allowed_html', 'thincrust_wp_kses_allowed_html_allow_svg', 10, 1 );
