<?php
/**
 * Template for returning a 404 page built with the block editor.
 * Based on a page titled "404".
 * If not found, it will use the template-parts/content-none.php template
 *
 * @package Thincrust
 */

get_header();

$content_outputted = false;

if ( get_page_by_title( '404' ) ) { // phpcs:ignore
	global $post;
	$post_content_404 = get_page_by_title( '404' )->post_content; // phpcs:ignore
	if ( ! empty( $post_content_404 ) ) {
		?>
		<article class="thincrust-entry content-404">
			<div class="entry-content">
			<?php
				echo do_blocks( $post_content_404 ); // phpcs:ignore
			?>
			</div>
		</article>
		<?php
		$content_outputted = true;
	}
}

if ( ! $content_outputted ) {
	get_template_part( 'template-parts/content', 'none' );
}

get_footer();
