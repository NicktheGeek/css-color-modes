<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Thincrust
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'thincrust' ); ?></a>
	<?php
	// 😉 Add .sticky-header to the <header>.
	?>
	<header id="masthead" class="site-header" role="banner">
		<div class="site-header-inner">
		<?php
		// See /inc/functions_header.php for title, main menu, and mobile menu.
		do_action( 'thincrust_header' );
		?>
		</div><!-- .site-header-inner -->
	</header><!-- #masthead -->
	<?php do_action( 'thincrust_after_header' ); ?>
	<main id="primary" class="site-main">
	<?php do_action( 'thincrust_main_open' ); ?>
