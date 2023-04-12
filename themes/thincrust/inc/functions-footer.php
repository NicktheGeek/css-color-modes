<?php
/**
 * Provides the Footer
 *
 * @package Thincrust
 */

/**
 * Registers a Sidebar to be used in the footer
 */
function thincrust_register_footer_sidebar() {
	register_sidebar(
		array(
			'name'          => __( 'Footer Blocks', 'thincrust' ),
			'id'            => 'footer-blocks',
			'description'   => __( 'Widgets in this area will be shown in the footer.', 'thincrust' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="footer-blocks-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'thincrust_register_footer_sidebar' );


/**
 * Outputs the main title
 */
function thincrust_footer_title() {
	the_custom_logo();
	if ( is_front_page() && is_home() ) :
		?>
		<h1 class="footer-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		<?php
	else :
		?>
		<p class="footer-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
		<?php
	endif;
}
add_action( 'thincrust_footer', 'thincrust_footer_title', 10 );

/**
 * Outputs the footer sidebar for the widgets/blocks area.
 */
function thincrust_footer_render_sidebar() {
	if ( is_active_sidebar( 'footer-blocks' ) ) {
		?>
		<div class="footer-blocks">
			<?php dynamic_sidebar( 'footer-blocks' ); ?>
		</div>
		<?php
	}
}
add_action( 'thincrust_footer', 'thincrust_footer_render_sidebar', 10 );
