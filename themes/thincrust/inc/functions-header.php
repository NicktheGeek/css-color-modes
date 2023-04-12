<?php
/**
 * Provides the Main Title, Main Menu and Main Mobile Menu.
 *
 * @package Thincrust
 */

/**
 * Output the Main Title.
 */
function thincrust_main_title() {
	the_custom_logo();
	?>
	<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
	<?php
}
add_action( 'thincrust_header', 'thincrust_main_title', 2 );

/**
 * Output the Main Menu.
 */
function thincrust_the_header_main_menu() {
	$header_menus = thincrust_get_header_menus();
	echo wp_kses_post( $header_menus['main'] );
}
add_action( 'thincrust_header', 'thincrust_the_header_main_menu', 3 );


/**
 * Output the Mobile Menu.
 * Toggle and Menu.
 */
function thincrust_the_header_mobile_menu() {
	$header_menus = thincrust_get_header_menus();

	$mobile_menu_pin = apply_filters( 'thincrust_mobile_menu_pin', 'right' );

	if ( ! empty( $header_menus['main'] ) ) :
		?>
	<button
		class="thincrust-mobile-menu__toggle__button mobile-menu-trigger"
		id="THINCRUST_MOBILE_MENU_TOGGLE"
		name="THINCRUST_MOBILE_MENU_TOGGLE"
	>
		<?php echo esc_html__( 'Toggle Navigation', 'thincrust' ); ?>
	</button>
	<div class="thincrust-mobile-menu" data-thincrust-pin-to-side="<?php echo esc_attr( $mobile_menu_pin ); ?>">
		<nav aria-label="<?php esc_attr_e( 'mobile', 'thincrust' ); ?>" class="thincrust-mobile-menu__nav">
			<?php echo wp_kses_post( $header_menus['mobile'] ); ?>
		</nav>
	</div>
		<?php
	endif;
}
add_action( 'thincrust_header', 'thincrust_the_header_mobile_menu', 5 );


/**
 * Get the Header Menus.
 */
function thincrust_get_header_menus() {
	$header_menus = array(
		'main'   => thincrust_get_the_main_menu(),
		'mobile' => thincrust_get_the_mobile_menu(),
	);

	return $header_menus;
}

/**
 * The Main Menu.
 */
function thincrust_get_the_main_menu() {
	$main_menu_class = apply_filters( 'thincrust_header_menu_class', 'thincrust-header-menu' );

	$thincrust_header_menu = wp_nav_menu(
		apply_filters(
			'thincrust_header_menu_args',
			array(
				'container'      => 'nav',
				'echo'           => false,
				'fallback_cb'    => '__return_false',
				'menu_class'     => $main_menu_class,
				'theme_location' => 'main-menu',
			)
		)
	);

	return $thincrust_header_menu;
}

/**
 * The Mobile Menu.
 */
function thincrust_get_the_mobile_menu() {
	$main_menu_class = apply_filters( 'thincrust_header_menu_class', 'thincrust-app-layout__nav__list' );

	$mobile_menu_class     = apply_filters( 'thincrust_header_menu_mobile_class', 'thincrust-mobile-menu__nav__list' );
	$thincrust_mobile_menu = str_replace( $main_menu_class, $mobile_menu_class, thincrust_get_the_main_menu() );

	return $thincrust_mobile_menu;
}

/**
 * Add additional HTML for items with children.
 *
 * @param string   $item_output The menu item's starting HTML output.
 * @param WP_Post  $menu_item   Menu item data object.
 * @param int      $depth       Depth of menu item. Used for padding.
 * @param stdClass $args        An object of wp_nav_menu() arguments.
 *
 * @return string
 */
function thincrust_add_submenu( $item_output, $menu_item, $depth, $args ) {
	if ( 'thincrust-header-menu' === $args->menu_class ) {
		if ( in_array( 'menu-item-has-children', $menu_item->classes, true ) ) {
			// Generate a unique ID for this.
			$menu_item_id = 'menu-sub-menu-trigger_button_' . $menu_item->ID;
			// SVG for the right chevron icon.
			$chevron_right_svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="icon-right-svg"><!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M342.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L274.7 256 105.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/></svg>';
			// Add the additional HTML.
			$button      = '<button aria-hidden="true" title="Toggle Sub Menu" id="' . $menu_item_id . '" class="menu-sub-menu-trigger" tabindex="-1" role="button">' . $chevron_right_svg . '</button>';
			$item_output = $item_output . $button;
		}
	}
	// Return the item no matter what.
	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'thincrust_add_submenu', 999, 4 );


/**
 * Filters the list of CSS body class names for the current post or page.
 *
 * @param string[] $classes An array of body class names.
 *
 * @return string[]
 */
function thincrust_body_class( $classes ) {
	if ( thincrust_is_title_hidden() ) {
		$classes[] = 'thincrust-title-is-hidden';
	}
	return $classes;
}
add_filter( 'body_class', 'thincrust_body_class', 10, 1 );

/**
 * Allows tabindex in a post context.
 *
 * @param array[] $tags    Allowed HTML tags.
 */
function thincrust_wp_kses_allowed_html_allow_tabindex( $tags ) {
	$tags['button'] = [
		'tabindex'    => [],
		'aria-hidden' => [],
		'title'       => [],
		'id'          => [],
		'class'       => [],
		'role'        => [],
	];
	return $tags;
}
/**
 * Update wp_kses_post() for the main menus.
 */
function thincrust_kses_for_menus() {
	add_filter( 'wp_kses_allowed_html', 'thincrust_wp_kses_allowed_html_allow_tabindex', 10, 1 );
}
add_action( 'thincrust_header', 'thincrust_kses_for_menus', 1 );

/**
 * Remove wp_kses_post() for the main menus.
 */
function thincrust_remove_kses_for_menus() {
	remove_filter( 'wp_kses_allowed_html', 'thincrust_wp_kses_allowed_html_allow_tabindex', 10, 1 );
}
add_action( 'thincrust_header', 'thincrust_remove_kses_for_menus', 999 );
