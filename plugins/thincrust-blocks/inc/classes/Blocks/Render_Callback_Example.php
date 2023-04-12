<?php
/**
 * Example server side block.
 * This file can/should be replaced or removed.
 *
 * @package Thincrust
 */

namespace Thincrust\Blocks;

/**
 * Example server side block class.
 */
class Render_Callback_Example extends Base {
	/**
	 * Block name.
	 *
	 * @var string
	 */
	protected $name = 'render-callback-example';

	/**
	 * Render Callback Function.
	 * This could also call a function from within the theme.
	 *
	 * @param array  $attributes  The block attributes.
	 * @param string $content     The inner string of the content.
	 *
	 * @return string
	 */
	public function render( $attributes, $content ) {
		$return_string = 'This is the render callback function being called on the Render Callback Example plugin';

		$wrapper_attributes = get_block_wrapper_attributes();

		return sprintf(
			'<h3 %1$s>%2$s<h3>',
			$wrapper_attributes,
			esc_html( $return_string )
		);
	}
}
