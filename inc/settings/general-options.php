<?php
function quasartheme_initialize_general_options()
{
	// If the general options doesn't exist, create them.
	if( false == get_option( 'quasartheme_general_options' ) ) {	
		add_option( 'quasartheme_general_options' );
	} // end if

	// First, we register a section. This is necessary since all future options must belong to a 
	add_settings_section(
		'general_settings_section',			// ID used to identify this section and with which to register options
		'General Options',					// Title to be displayed on the administration page
		'quasartheme_general_options_callback',	// Callback used to render the description of the section
		'quasartheme_general_options'		// Page on which to add this section of options
	);
	
	// Next, we'll introduce the fields for toggling the visibility of content elements.
	add_settings_field(	
		'show_header',						// ID used to identify the field throughout the theme
		'Header',							// The label to the left of the option interface element
		'quasartheme_toggle_header_callback',	// The name of the function responsible for rendering the option interface
		'quasartheme_general_options',	// The page on which this option will be displayed
		'general_settings_section',			// The name of the section to which this field belongs
		array(								// The array of arguments to pass to the callback. In this case, just a description.
			'Activate this setting to display the header.'
		)
	);
	
	add_settings_field(	
		'show_content',						
		'Content',				
		'quasartheme_toggle_content_callback',	
		'quasartheme_general_options',					
		'general_settings_section',			
		array(								
			'Activate this setting to display the content.'
		)
	);
	
	add_settings_field(	
		'show_footer',						
		'Footer',				
		'quasartheme_toggle_footer_callback',	
		'quasartheme_general_options',		
		'general_settings_section',			
		array(								
			'Activate this setting to display the footer.'
		)
	);
	
	// Finally, we register the fields with WordPress
	register_setting(
		'quasartheme_general_options',
		'quasartheme_general_options'
	);
	
} // end quasartheme_initialize_general_options
add_action('admin_init', 'quasartheme_initialize_general_options');

function quasartheme_general_options_callback() {
	echo '<p>Select which areas of content you wish to display.</p>';
} // end quasartheme_general_options_callback

function quasartheme_toggle_header_callback($args) {
	
	// First, we read the options collection
	$options = get_option('quasartheme_general_options');
	
	// Next, we update the name attribute to access this element's ID in the context of the display options array
	// We also access the show_header element of the options collection in the call to the checked() helper function
	$html = '<input type="checkbox" id="show_header" name="quasartheme_general_options[show_header]" value="1" ' . checked(1, $options['show_header'], false) . '/>'; 
	
	// Here, we'll take the first argument of the array and add it to a label next to the checkbox
	$html .= '<label for="show_header"> '  . $args[0] . '</label>'; 
	
	echo $html;
	
} // end quasartheme_toggle_header_callback

function quasartheme_toggle_content_callback($args) {

	$options = get_option('quasartheme_general_options');
	
	$html = '<input type="checkbox" id="show_content" name="quasartheme_general_options[show_content]" value="1" ' . checked(1, $options['show_content'], false) . '/>'; 
	$html .= '<label for="show_content"> '  . $args[0] . '</label>'; 
	
	echo $html;
	
} // end quasartheme_toggle_content_callback

function quasartheme_toggle_footer_callback($args) {
	
	$options = get_option('quasartheme_general_options');
	
	$html = '<input type="checkbox" id="show_footer" name="quasartheme_general_options[show_footer]" value="1" ' . checked(1, $options['show_footer'], false) . '/>'; 
	$html .= '<label for="show_footer"> '  . $args[0] . '</label>'; 
	
	echo $html;
	
} // end quasartheme_toggle_footer_callback