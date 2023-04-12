<?php
/**
 * Template for google login button.
 *
 * @package rkv-login
 */

if ( empty( $login_url ) ) {
	return;
}

if ( ! isset( $_GET['rkv'] ) ) {
    return;
}

?>
<div class="wp_google_login">
	<div class="wp_google_login__button-container">
		<a class="wp_google_login__button" href="<?php echo esc_url( $login_url ); ?>">
			<span class="wp_google_login__google-icon"></span>
			<?php esc_html_e( 'Reaktiv Login', 'rkv-login' ); ?>
		</a>
	</div>
</div>
