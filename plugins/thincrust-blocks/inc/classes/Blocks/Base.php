<?php
/**
 * Base class for RKV server side render blocks.
 *
 * @package Thincrust
 */

namespace Thincrust\Blocks;

/**
 * Define the base class and associated methods.
 */
abstract class Base {

	/**
	 * Block namespace. The default is thincrust.
	 *
	 * @var string
	 */
	protected $namespace = 'thincrust';

	/**
	 * Block name.
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * Block attributes.
	 *
	 * @var array
	 */
	protected $attributes;

	/**
	 * Run the class.
	 *
	 * Called during init hook.
	 *
	 * @return void
	 */
	public function __construct() {
		// Only run if the register_block_type function exists.
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}

		$this->set_attributes();

		// Register the block type.
		register_block_type(
			$this->namespace . '/' . $this->name,
			[
				'attributes'      => $this->attributes,
				'render_callback' => [ $this, 'render' ],
			]
		);
	}

	/**
	 * Set the block type attributes.
	 *
	 * @return void
	 */
	protected function set_attributes() {
		$this->attributes = [];
	}

	/**
	 * Add additional data to the $attributes array passed down to templates. This function has the ability to override data originally set in set_attributes.
	 *
	 * @param array $attributes Full list of current attributes.
	 */
	protected function set_additional_data( $attributes ) {
		return [];
	}


	/**
	 * Render the block.
	 *
	 * @param array  $attributes Attributes passed form the block to the server for server side rendering.
	 * @param string $content    The original content.
	 *
	 * @uses validate_file
	 * @see https://developer.wordpress.org/reference/functions/validate_file/
	 *
	 * @return string
	 */
	public function render( $attributes, $content ) {
		// Check child and parent theme for templates.
		$directories = [
			get_stylesheet_directory() . '/template-parts/blocks/', // Child theme.
			get_template_directory() . '/template-parts/blocks/', // Parent theme.
		];

		$attributes = wp_parse_args( $this->set_additional_data( $attributes ), $attributes );

		$the_template = thincrust_get_template( $this->name, $directories );

		if ( empty( $the_template ) ) {
			return esc_html__( 'No template file', 'thincrust' );
		}

		if ( 0 !== validate_file( $the_template ) ) {
			return esc_html__( 'Invalid template file', 'thincrust' );
		}

		ob_start();

		do_action( "thincrust_block_editor_block_before_render_{$this->name}", $the_template );

		include $the_template;

		do_action( "thincrust_block_editor_block_after_render_{$this->name}", $the_template );

		$html = ob_get_clean();

		return $html;
	}
}
