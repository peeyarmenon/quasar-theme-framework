<?php
/**
 * Quasar Theme back compat functionality.
 *
 * Prevents Quasar Theme from running on WordPress versions prior to 3.6,
 * since this theme is not meant to be backwards compatible and relies on
 * many new functions and markup changes introduced in 3.6.
 *
 * @package WordPress
 * @subpackage Quasar Theme
 * @since Quasar Theme 1.0
 */

/**
 * Prevent switching to Quasar Theme on old versions of WordPress. Switches
 * to the default theme.
 *
 * @since Quasar Theme 1.0
 *
 * @return void
 */
function quasartheme_switch_theme() {
	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'quasartheme_upgrade_notice' );
}
add_action( 'after_switch_theme', 'quasartheme_switch_theme' );

/**
 * Prints an update nag after an unsuccessful attempt to switch to
 * Quasar Theme on WordPress versions prior to 3.6.
 *
 * @since Quasar Theme 1.0
 *
 * @return void
 */
function quasartheme_upgrade_notice() {
	$message = sprintf( __( 'Twenty Thirteen requires at least WordPress version 3.6. You are running version %s. Please upgrade and try again.', 'quasartheme' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 3.6.
 *
 * @since Quasar Theme 1.0
 *
 * @return void
 */
function quasartheme_customize() {
	wp_die( sprintf( __( 'Twenty Thirteen requires at least WordPress version 3.6. You are running version %s. Please upgrade and try again.', 'quasartheme' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'quasartheme_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 3.4.
 *
 * @since Quasar Theme 1.0
 *
 * @return void
 */
function quasartheme_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'Twenty Thirteen requires at least WordPress version 3.6. You are running version %s. Please upgrade and try again.', 'quasartheme' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'quasartheme_preview' );