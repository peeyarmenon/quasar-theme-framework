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

		<?php
		if ( isset( $_GET[ 'tab' ])) {
			$active_tab = $_GET[ 'tab' ];
		} else {
			$active_tab = 'settings_home';
		}// end if
		?>

		<h2 class="nav-tab-wrapper">
			<a href="?page=quasartheme_options&tab=settings_home" class="nav-tab <?php echo $active_tab == 'settings_home' ? 'nav-tab-active' : ''; ?>">Home</a>
			<a href="?page=quasartheme_options&tab=general_options" class="nav-tab <?php echo $active_tab == 'general_options' ? 'nav-tab-active' : ''; ?>">General Settings</a>
			<a href="?page=quasartheme_options&tab=color_options" class="nav-tab <?php echo $active_tab == 'color_options' ? 'nav-tab-active' : ''; ?>">Color Settings</a>
			<a href="?page=quasartheme_options&tab=social_options" class="nav-tab <?php echo $active_tab == 'social_options' ? 'nav-tab-active' : ''; ?>">Social Settings</a>
			<a href="?page=quasartheme_options&tab=widget_options" class="nav-tab <?php echo $active_tab == 'widget_options' ? 'nav-tab-active' : ''; ?>">Widget Settings</a>
			<a href="?page=quasartheme_options&tab=posttypes_options" class="nav-tab <?php echo $active_tab == 'posttypes_options' ? 'nav-tab-active' : ''; ?>">Post Types</a>
			<a href="?page=quasartheme_options&tab=location_options" class="nav-tab <?php echo $active_tab == 'location_options' ? 'nav-tab-active' : ''; ?>">Location Settings</a>
		</h2>
		
		<form method="post" action="options.php">
			<?php
				if ( $active_tab == 'general_options' ) {
					settings_fields( 'quasartheme_general_options' );
					do_settings_sections( 'quasartheme_general_options' );
				} else if ( $active_tab == 'social_options' ) {
					settings_fields( 'quasartheme_social_options' );
					do_settings_sections( 'quasartheme_social_options' );
				}

				submit_button();
			?>
		</form>
		
	</div><!-- /.wrap -->
<?php
} // end quasartheme_display

// general options
require( TEMPLATEPATH . '/inc/settings/general-options.php' );

// social options
require( TEMPLATEPATH . '/inc/settings/social-options.php' );