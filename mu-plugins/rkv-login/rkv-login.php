<?php 
/**
 * Plugin Name: Login with Google
 * Description: Modifies the "Login with Google" plugin.
 * Version: 1.2.2
 * Author: Reaktiv
 * Author URI: https://reaktiv.co
 * Text Domain: rkv-login
 * Domain Path: /languages
 * License: GPLv2+
 * Requires at least: 5.4.2
 * Requires PHP: 7.3
 * 
 * This rebrands for "Login with Reaktiv."
 * 
 * @package rkv-login
 */

namespace RKV\Login;

use function RtCamp\GoogleLogin\plugin;

define( 'WP_GOOGLE_LOGIN_CLIENT_ID', '853884987176-gnth5924l0vceu96dqoese2sit24adi0.apps.googleusercontent.com' );
define( 'WP_GOOGLE_LOGIN_SECRET', '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' );
define( 'WP_GOOGLE_LOGIN_USER_REGISTRATION', true );
define( 'WP_GOOGLE_LOGIN_WHITELIST_DOMAINS', 'reaktivstudios.com,reaktiv.co' );
define( 'WP_GOOGLE_ONE_TAP_LOGIN', true );
define( 'WP_GOOGLE_ONE_TAP_LOGIN_SCREEN', 'sitewide' );
/**
 * Customizes the Login with WP plugin.
 */
class Customize {

	/**
	 * Add actions and filters.
	 */
	public function __construct() {
		add_filter( 'rtcamp.google_login_modules', [ $this, 'init' ] );
		add_action( 'login_enqueue_scripts', [ $this, 'enqueue_login_styles' ], 11 );
		add_action( 'rtcamp.google_user_created', [ $this, 'user_created' ] );
		add_action( 'login_init', [ $this, 'login_init' ] );
	}

	/**
	 * Modifies the plugin properties.
	 *
	 * @param array $active_modules Active modules list.
	 * @return array
	 */
	public function init( $modules ) {
		plugin()->template_dir = trailingslashit( __DIR__ ) . 'templates';

		$modules = array_flip( $modules );

		// Disable the one tap login unless the rkv query arg is set.
		if ( empty( $_GET['rkv'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			unset( $modules['one_tap_login'] );
		}

		// Disable settings page.
		unset( $modules['settings'] );

		$modules = array_flip( $modules );

		return $modules;
	}

	/**
	 * Enqueue assets.
	 *
	 * @return void
	 */
	public function enqueue_login_styles() {
		wp_dequeue_style( 'login-with-google' );

		if ( ! isset( $_GET['rkv' ] ) ) {
			wp_dequeue_script( 'login-with-google-script' );
			return;
		}

		wp_enqueue_style( 'login-with-rkv', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'assets/css/login.css', [], '1.0.0' );
	}

	/**
	 * Made reaktiv accounts admins on account creation.
	 *
	 * @param int $uid The user ID.
	 * @return void
	 */
	public function user_created( $uid ) {
		$userdata = get_userdata( $uid );

		if ( empty( $userdata->user_email ) || ! preg_match( '/(@reaktivstudios.com|reaktiv.co)/', $userdata->user_email ) ) {
			return;
		}

		$user = get_user_by( 'id', $uid );
		
		if ( is_wp_error( $user ) || ! is_a( $user, 'WP_User' ) ) {
			return;
		}

		$user->add_role( 'administrator' );

		if ( function_exists( 'grant_super_admin' ) ) {
			grant_super_admin( $uid );
		}
	}

	/**
	 * Check to see if the user is using a restricted login.
	 * 
	 * Users with a Reaktiv email address must use the Reaktiv SSO login.
	 *
	 * @return void
	 */
	public function login_init() {
		if ( ( isset( $_POST['log'] ) || isset( $_POST['user_login'] ) ) && isset( $_POST['pwd'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
			$user_login = sanitize_text_field( $_POST['log'] ?? $_POST['user_login'] ); // phpcs:ignore WordPress.Security.NonceVerification.Missing

			if ( false === strpos( $user_login, '@' ) ) {
				$user = get_user_by( 'login', $user_login );

				if ( empty( $user ) || empty( $user->user_email ) ) {
					return;
				}

				$user_email = $user->user_email;
			} else {
				$user_email = $user_login;
			}

			if ( preg_match( '/(@reaktivstudios\.com|@reaktiv\.co|@admin\.test)/', $user_email ) ) {
				$this->restrict_login();
			}
		}
	}

	/**
	 * Enforce RKV Login for RKV users.
	 *
	 * @return void
	 */
	private function restrict_login() {
		$login_url = add_query_arg( 'rkv', '', wp_login_url() );

		wp_die( 
			sprintf(
				// Translators: 1 is for the opening link tag and 2 is the closing tag.
				esc_html__( 'Reaktiv users must use Reaktiv Login. Add `rkv` to the login query or use this %1$slogin link%2$s to continue then click the "Reaktiv Login" button to login.', 'rkv-login' ),
				'<a href=' . esc_url( $login_url ) . '>',
				'</a>'
			), 
			esc_html__( 'Account Restricted', 'rkv-login' ) 
		);
	}
}

new Customize();
