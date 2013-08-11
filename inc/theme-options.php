<?php

/**
 * This function introduces the theme options into the 'Appearance' menu and into a top-level 
 * 'Quasar Theme' menu.
 */
function quasartheme_example_theme_menu() {

	add_theme_page(
		'Quasar Theme', 					// The title to be displayed in the browser window for this page.
		'Quasar Theme',					// The text to be displayed for this menu item
		'administrator',					// Which type of users can see this menu item
		'quasartheme_options',			// The unique ID - that is, the slug - for this menu item
		'quasartheme_display'				// The name of the function to call when rendering this menu's page
	);
	
	add_menu_page(
		'Quasar Theme',					// The value used to populate the browser's title bar when the menu page is active
		'Quasar Theme',					// The text of the menu in the administrator's sidebar
		'administrator',					// What roles are able to access the menu
		'quasartheme_menu',				// The ID used to bind submenu items to this menu 
		'quasartheme_display'				// The callback function used to render this menu
	);
	
	add_submenu_page(
		'quasartheme_menu',				// The ID of the top-level menu page to which this submenu item belongs
		__( 'Display Options', 'sandbox' ),			// The value used to populate the browser's title bar when the menu page is active
		__( 'Display Options', 'sandbox' ),					// The label of this submenu item displayed in the menu
		'administrator',					// What roles are able to access this submenu item
		'quasartheme_display_options',	// The ID used to represent this submenu item
		'quasartheme_display'				// The callback function used to render the options for this submenu item
	);
	
	add_submenu_page(
		'quasartheme_menu',
		__( 'Social Options', 'sandbox' ),
		__( 'Social Options', 'sandbox' ),
		'administrator',
		'quasartheme_social_options',
		create_function( null, 'quasartheme_display( "social_options" );' )
	);
	
	add_submenu_page(
		'quasartheme_menu',
		__( 'Input Examples', 'sandbox' ),
		__( 'Input Examples', 'sandbox' ),
		'administrator',
		'quasartheme_input_examples',
		create_function( null, 'quasartheme_display( "input_examples" );' )
	);


} // end quasartheme_example_theme_menu
add_action( 'admin_menu', 'quasartheme_example_theme_menu' );

/**
 * Renders a simple page to display for the theme menu defined above.
 */
function quasartheme_display( $active_tab = '' ) {
?>
	<!-- Create a header in the default WordPress 'wrap' container -->
	<div class="wrap">
	
		<div id="icon-themes" class="icon32"></div>
		<h2><?php _e( 'Quasar Theme Options', 'sandbox' ); ?></h2>
		<?php settings_errors(); ?>
		
		<?php if( isset( $_GET[ 'tab' ] ) ) {
			$active_tab = $_GET[ 'tab' ];
		} else if( $active_tab == 'social_options' ) {
			$active_tab = 'social_options';
		} else if( $active_tab == 'input_examples' ) {
			$active_tab = 'input_examples';
		} else {
			$active_tab = 'display_options';
		} // end if/else ?>
		
		<h2 class="nav-tab-wrapper">
			<a href="?page=quasartheme_options&tab=display_options" class="nav-tab <?php echo $active_tab == 'display_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Display Options', 'sandbox' ); ?></a>
			<a href="?page=quasartheme_options&tab=social_options" class="nav-tab <?php echo $active_tab == 'social_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Social Options', 'sandbox' ); ?></a>
			<a href="?page=quasartheme_options&tab=input_examples" class="nav-tab <?php echo $active_tab == 'input_examples' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Input Examples', 'sandbox' ); ?></a>
		</h2>
		
		<form method="post" action="options.php">
			<?php
			
				if( $active_tab == 'display_options' ) {
				
					settings_fields( 'quasartheme_display_options' );
					do_settings_sections( 'quasartheme_display_options' );
					
				} elseif( $active_tab == 'social_options' ) {
				
					settings_fields( 'quasartheme_social_options' );
					do_settings_sections( 'quasartheme_social_options' );
					
				} else {
				
					settings_fields( 'quasartheme_input_examples' );
					do_settings_sections( 'quasartheme_input_examples' );
					
				} // end if/else
				
				submit_button();
			
			?>
		</form>
		
	</div><!-- /.wrap -->
<?php
} // end quasartheme_display

/* ------------------------------------------------------------------------ *
 * Setting Registration
 * ------------------------------------------------------------------------ */ 


/**
 * Provides default values for the Social Options.
 */
function quasartheme_default_social_options() {
	
	$defaults = array(
		'twitter'		=>	'',
		'facebook'		=>	'',
		'googleplus'	=>	'',
	);
	
	return apply_filters( 'quasartheme_default_social_options', $defaults );
	
} // end quasartheme_default_social_options

/**
 * Provides default values for the Display Options.
 */
function quasartheme_default_display_options() {
	
	$defaults = array(
		'show_header'		=>	'',
		'show_content'		=>	'',
		'show_footer'		=>	'',
	);
	
	return apply_filters( 'quasartheme_default_display_options', $defaults );
	
} // end quasartheme_default_display_options

/**
 * Provides default values for the Input Options.
 */
function quasartheme_default_input_options() {
	
	$defaults = array(
		'input_example'		=>	'',
		'textarea_example'	=>	'',
		'checkbox_example'	=>	'',
		'radio_example'		=>	'',
		'time_options'		=>	'default'	
	);
	
	return apply_filters( 'quasartheme_default_input_options', $defaults );
	
} // end quasartheme_default_input_options

/**
 * Initializes the theme's display options page by registering the Sections,
 * Fields, and Settings.
 *
 * This function is registered with the 'admin_init' hook.
 */ 
function quasartheme_initialize_theme_options() {

	// If the theme options don't exist, create them.
	if( false == get_option( 'quasartheme_display_options' ) ) {	
		add_option( 'quasartheme_display_options', apply_filters( 'quasartheme_default_display_options', quasartheme_default_display_options() ) );
	} // end if

	// First, we register a section. This is necessary since all future options must belong to a 
	add_settings_section(
		'general_settings_section',			// ID used to identify this section and with which to register options
		__( 'Display Options', 'sandbox' ),		// Title to be displayed on the administration page
		'quasartheme_general_options_callback',	// Callback used to render the description of the section
		'quasartheme_display_options'		// Page on which to add this section of options
	);
	
	// Next, we'll introduce the fields for toggling the visibility of content elements.
	add_settings_field(	
		'show_header',						// ID used to identify the field throughout the theme
		__( 'Header', 'sandbox' ),							// The label to the left of the option interface element
		'quasartheme_toggle_header_callback',	// The name of the function responsible for rendering the option interface
		'quasartheme_display_options',	// The page on which this option will be displayed
		'general_settings_section',			// The name of the section to which this field belongs
		array(								// The array of arguments to pass to the callback. In this case, just a description.
			__( 'Activate this setting to display the header.', 'sandbox' ),
		)
	);
	
	add_settings_field(	
		'show_content',						
		__( 'Content', 'sandbox' ),				
		'quasartheme_toggle_content_callback',	
		'quasartheme_display_options',					
		'general_settings_section',			
		array(								
			__( 'Activate this setting to display the content.', 'sandbox' ),
		)
	);
	
	add_settings_field(	
		'show_footer',						
		__( 'Footer', 'sandbox' ),				
		'quasartheme_toggle_footer_callback',	
		'quasartheme_display_options',		
		'general_settings_section',			
		array(								
			__( 'Activate this setting to display the footer.', 'sandbox' ),
		)
	);
	
	// Finally, we register the fields with WordPress
	register_setting(
		'quasartheme_display_options',
		'quasartheme_display_options'
	);
	
} // end quasartheme_initialize_theme_options
add_action( 'admin_init', 'quasartheme_initialize_theme_options' );

/**
 * Initializes the theme's social options by registering the Sections,
 * Fields, and Settings.
 *
 * This function is registered with the 'admin_init' hook.
 */ 
function quasartheme_intialize_social_options() {

	if( false == get_option( 'quasartheme_social_options' ) ) {	
		add_option( 'quasartheme_social_options', apply_filters( 'quasartheme_default_social_options', quasartheme_default_social_options() ) );
	} // end if
	
	add_settings_section(
		'social_settings_section',			// ID used to identify this section and with which to register options
		__( 'Social Options', 'sandbox' ),		// Title to be displayed on the administration page
		'quasartheme_social_options_callback',	// Callback used to render the description of the section
		'quasartheme_social_options'		// Page on which to add this section of options
	);
	
	add_settings_field(	
		'twitter',						
		'Twitter',							
		'quasartheme_twitter_callback',	
		'quasartheme_social_options',	
		'social_settings_section'			
	);

	add_settings_field(	
		'facebook',						
		'Facebook',							
		'quasartheme_facebook_callback',	
		'quasartheme_social_options',	
		'social_settings_section'			
	);
	
	add_settings_field(	
		'googleplus',						
		'Google+',							
		'quasartheme_googleplus_callback',	
		'quasartheme_social_options',	
		'social_settings_section'			
	);
	
	register_setting(
		'quasartheme_social_options',
		'quasartheme_social_options',
		'quasartheme_sanitize_social_options'
	);
	
} // end quasartheme_intialize_social_options
add_action( 'admin_init', 'quasartheme_intialize_social_options' );

/**
 * Initializes the theme's input example by registering the Sections,
 * Fields, and Settings. This particular group of options is used to demonstration
 * validation and sanitization.
 *
 * This function is registered with the 'admin_init' hook.
 */ 
function quasartheme_initialize_input_examples() {

	if( false == get_option( 'quasartheme_input_examples' ) ) {	
		add_option( 'quasartheme_input_examples', apply_filters( 'quasartheme_default_input_options', quasartheme_default_input_options() ) );
	} // end if

	add_settings_section(
		'input_examples_section',
		__( 'Input Examples', 'sandbox' ),
		'quasartheme_input_examples_callback',
		'quasartheme_input_examples'
	);
	
	add_settings_field(	
		'Input Element',						
		__( 'Input Element', 'sandbox' ),							
		'quasartheme_input_element_callback',	
		'quasartheme_input_examples',	
		'input_examples_section'			
	);
	
	add_settings_field(	
		'Textarea Element',						
		__( 'Textarea Element', 'sandbox' ),							
		'quasartheme_textarea_element_callback',	
		'quasartheme_input_examples',	
		'input_examples_section'			
	);
	
	add_settings_field(	
		'Checkbox Element',
		__( 'Checkbox Element', 'sandbox' ),
		'quasartheme_checkbox_element_callback',
		'quasartheme_input_examples',
		'input_examples_section'
	);
	
	add_settings_field(	
		'Radio Button Elements',
		__( 'Radio Button Elements', 'sandbox' ),
		'quasartheme_radio_element_callback',
		'quasartheme_input_examples',
		'input_examples_section'
	);
	
	add_settings_field(	
		'Select Element',
		__( 'Select Element', 'sandbox' ),
		'quasartheme_select_element_callback',
		'quasartheme_input_examples',
		'input_examples_section'
	);
	
	register_setting(
		'quasartheme_input_examples',
		'quasartheme_input_examples',
		'quasartheme_validate_input_examples'
	);

} // end quasartheme_initialize_input_examples
add_action( 'admin_init', 'quasartheme_initialize_input_examples' );

/* ------------------------------------------------------------------------ *
 * Section Callbacks
 * ------------------------------------------------------------------------ */ 

/**
 * This function provides a simple description for the General Options page. 
 *
 * It's called from the 'quasartheme_initialize_theme_options' function by being passed as a parameter
 * in the add_settings_section function.
 */
function quasartheme_general_options_callback() {
	echo '<p>' . __( 'Select which areas of content you wish to display.', 'sandbox' ) . '</p>';
} // end quasartheme_general_options_callback

/**
 * This function provides a simple description for the Social Options page. 
 *
 * It's called from the 'quasartheme_intialize_social_options' function by being passed as a parameter
 * in the add_settings_section function.
 */
function quasartheme_social_options_callback() {
	echo '<p>' . __( 'Provide the URL to the social networks you\'d like to display.', 'sandbox' ) . '</p>';
} // end quasartheme_general_options_callback

/**
 * This function provides a simple description for the Input Examples page.
 *
 * It's called from the 'quasartheme_intialize_input_examples_options' function by being passed as a parameter
 * in the add_settings_section function.
 */
function quasartheme_input_examples_callback() {
	echo '<p>' . __( 'Provides examples of the five basic element types.', 'sandbox' ) . '</p>';
} // end quasartheme_general_options_callback

/* ------------------------------------------------------------------------ *
 * Field Callbacks
 * ------------------------------------------------------------------------ */ 

/**
 * This function renders the interface elements for toggling the visibility of the header element.
 * 
 * It accepts an array or arguments and expects the first element in the array to be the description
 * to be displayed next to the checkbox.
 */
function quasartheme_toggle_header_callback($args) {
	
	// First, we read the options collection
	$options = get_option('quasartheme_display_options');
	
	// Next, we update the name attribute to access this element's ID in the context of the display options array
	// We also access the show_header element of the options collection in the call to the checked() helper function
	$html = '<input type="checkbox" id="show_header" name="quasartheme_display_options[show_header]" value="1" ' . checked( 1, isset( $options['show_header'] ) ? $options['show_header'] : 0, false ) . '/>'; 
	
	// Here, we'll take the first argument of the array and add it to a label next to the checkbox
	$html .= '<label for="show_header">&nbsp;'  . $args[0] . '</label>'; 
	
	echo $html;
	
} // end quasartheme_toggle_header_callback

function quasartheme_toggle_content_callback($args) {

	$options = get_option('quasartheme_display_options');
	
	$html = '<input type="checkbox" id="show_content" name="quasartheme_display_options[show_content]" value="1" ' . checked( 1, isset( $options['show_content'] ) ? $options['show_content'] : 0, false ) . '/>'; 
	$html .= '<label for="show_content">&nbsp;'  . $args[0] . '</label>'; 
	
	echo $html;
	
} // end quasartheme_toggle_content_callback

function quasartheme_toggle_footer_callback($args) {
	
	$options = get_option('quasartheme_display_options');
	
	$html = '<input type="checkbox" id="show_footer" name="quasartheme_display_options[show_footer]" value="1" ' . checked( 1, isset( $options['show_footer'] ) ? $options['show_footer'] : 0, false ) . '/>'; 
	$html .= '<label for="show_footer">&nbsp;'  . $args[0] . '</label>'; 
	
	echo $html;
	
} // end quasartheme_toggle_footer_callback

function quasartheme_twitter_callback() {
	
	// First, we read the social options collection
	$options = get_option( 'quasartheme_social_options' );
	
	// Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.
	$url = '';
	if( isset( $options['twitter'] ) ) {
		$url = esc_url( $options['twitter'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="twitter" name="quasartheme_social_options[twitter]" value="' . $url . '" />';
	
} // end quasartheme_twitter_callback

function quasartheme_facebook_callback() {
	
	$options = get_option( 'quasartheme_social_options' );
	
	$url = '';
	if( isset( $options['facebook'] ) ) {
		$url = esc_url( $options['facebook'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="facebook" name="quasartheme_social_options[facebook]" value="' . $url . '" />';
	
} // end quasartheme_facebook_callback

function quasartheme_googleplus_callback() {
	
	$options = get_option( 'quasartheme_social_options' );
	
	$url = '';
	if( isset( $options['googleplus'] ) ) {
		$url = esc_url( $options['googleplus'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="googleplus" name="quasartheme_social_options[googleplus]" value="' . $url . '" />';
	
} // end quasartheme_googleplus_callback

function quasartheme_input_element_callback() {
	
	$options = get_option( 'quasartheme_input_examples' );
	
	// Render the output
	echo '<input type="text" id="input_example" name="quasartheme_input_examples[input_example]" value="' . $options['input_example'] . '" />';
	
} // end quasartheme_input_element_callback

function quasartheme_textarea_element_callback() {
	
	$options = get_option( 'quasartheme_input_examples' );
	
	// Render the output
	echo '<textarea id="textarea_example" name="quasartheme_input_examples[textarea_example]" rows="5" cols="50">' . $options['textarea_example'] . '</textarea>';
	
} // end quasartheme_textarea_element_callback

function quasartheme_checkbox_element_callback() {

	$options = get_option( 'quasartheme_input_examples' );
	
	$html = '<input type="checkbox" id="checkbox_example" name="quasartheme_input_examples[checkbox_example]" value="1"' . checked( 1, isset( $options['checkbox_example'] ) ? $options['checkbox_example'] : 0, false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="checkbox_example">This is an example of a checkbox</label>';
	
	echo $html;

} // end quasartheme_checkbox_element_callback

function quasartheme_radio_element_callback() {

	$options = get_option( 'quasartheme_input_examples' );
	
	$html = '<input type="radio" id="radio_example_one" name="quasartheme_input_examples[radio_example]" value="1"' . checked( 1, $options['radio_example'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="radio_example_one">Option One</label>';
	$html .= '&nbsp;';
	$html .= '<input type="radio" id="radio_example_two" name="quasartheme_input_examples[radio_example]" value="2"' . checked( 2, $options['radio_example'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="radio_example_two">Option Two</label>';
	
	echo $html;

} // end quasartheme_radio_element_callback

function quasartheme_select_element_callback() {

	$options = get_option( 'quasartheme_input_examples' );
	
	$html = '<select id="time_options" name="quasartheme_input_examples[time_options]">';
		$html .= '<option value="default">' . __( 'Select a time option...', 'sandbox' ) . '</option>';
		$html .= '<option value="never"' . selected( $options['time_options'], 'never', false) . '>' . __( 'Never', 'sandbox' ) . '</option>';
		$html .= '<option value="sometimes"' . selected( $options['time_options'], 'sometimes', false) . '>' . __( 'Sometimes', 'sandbox' ) . '</option>';
		$html .= '<option value="always"' . selected( $options['time_options'], 'always', false) . '>' . __( 'Always', 'sandbox' ) . '</option>';	$html .= '</select>';
	
	echo $html;

} // end quasartheme_radio_element_callback

/* ------------------------------------------------------------------------ *
 * Setting Callbacks
 * ------------------------------------------------------------------------ */ 
 
/**
 * Sanitization callback for the social options. Since each of the social options are text inputs,
 * this function loops through the incoming option and strips all tags and slashes from the value
 * before serializing it.
 *	
 * @params	$input	The unsanitized collection of options.
 *
 * @returns			The collection of sanitized values.
 */
function quasartheme_sanitize_social_options( $input ) {
	
	// Define the array for the updated options
	$output = array();

	// Loop through each of the options sanitizing the data
	foreach( $input as $key => $val ) {
	
		if( isset ( $input[$key] ) ) {
			$output[$key] = esc_url_raw( strip_tags( stripslashes( $input[$key] ) ) );
		} // end if	
	
	} // end foreach
	
	// Return the new collection
	return apply_filters( 'quasartheme_sanitize_social_options', $output, $input );

} // end quasartheme_sanitize_social_options

function quasartheme_validate_input_examples( $input ) {

	// Create our array for storing the validated options
	$output = array();
	
	// Loop through each of the incoming options
	foreach( $input as $key => $value ) {
		
		// Check to see if the current option has a value. If so, process it.
		if( isset( $input[$key] ) ) {
		
			// Strip all HTML and PHP tags and properly handle quoted strings
			$output[$key] = strip_tags( stripslashes( $input[ $key ] ) );
			
		} // end if
		
	} // end foreach
	
	// Return the array processing any additional functions filtered by this action
	return apply_filters( 'quasartheme_validate_input_examples', $output, $input );

} // end quasartheme_validate_input_examples

?>