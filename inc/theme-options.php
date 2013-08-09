<?php

function quasartheme_options_menu() {

	add_theme_page(
		'Quasar Theme', 			// The title to be displayed in the browser window for this page.
		'Quasar Theme',			// The text to be displayed for this menu item
		'administrator',			// Which type of users can see this menu item
		'quasartheme_options',	// The unique ID - that is, the slug - for this menu item
		'quasartheme_display'		// The name of the function to call when rendering this menu's page
	);

} // end quasartheme_options_menu
add_action( 'admin_menu', 'quasartheme_options_menu' );

/**
 * Renders a simple page to display for the theme menu defined above.
 */
function quasartheme_display() {
?>
	<!-- Create a header in the default WordPress 'wrap' container -->
	<div class="wrap">
	
		<div id="icon-themes" class="icon32"></div>
		<h2>Quasar Theme Options</h2>
		<?php settings_errors(); ?>

		<h2 class="nav-tab-wrapper">
			<a href="#" class="nav-tab">General Options</a>
			<a href="#" class="nav-tab">Social Options</a>
		</h2>
		
		<form method="post" action="options.php">
			<?php settings_fields( 'quasartheme_general_options' ); ?>
			<?php do_settings_sections( 'quasartheme_general_options' ); ?>

			<?php settings_fields( 'quasartheme_social_options' ); ?>
			<?php do_settings_sections( 'quasartheme_social_options' ); ?>

			<?php submit_button(); ?>
		</form>
		
	</div><!-- /.wrap -->
<?php
} // end quasartheme_display

// general options
require( TEMPLATEPATH . '/inc/settings/general-options.php' );

// social options
require( TEMPLATEPATH . '/inc/settings/social-options.php' );