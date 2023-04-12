<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Thincrust
 */

?>
<?php do_action( 'thincrust_main_close' ); ?>
</main><!-- #main -->
<?php do_action( 'thincrust_before_footer' ); ?>
	<footer class="site-footer">
		<div class="site-footer-inner">
			<?php do_action( 'thincrust_footer' ); ?>
		</div>
	</footer>
</div><!-- #page -->
<?php do_action( 'thincrust_after_footer' ); ?>
<?php wp_footer(); ?>

</body>
</html>
