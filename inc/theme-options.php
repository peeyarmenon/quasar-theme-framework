<?php
/* ------------------------------------------------------------------------ *
 * Setting Registration
 * ------------------------------------------------------------------------ */ 

/**
 * Initializes the theme options page by registering the Sections,
 * Fields, and Settings.
 *
 * This function is registered with the 'admin_init' hook.
 */
add_action('admin_init', 'quasar_initialize_theme_options');
function quasar_initialize_theme_options() {
	// First, we register a section. This is necessary since all future options must belong to one.
	add_settings_section(
		'general_settings_section',			// ID used to identify this section and with which to register options
		'General Options',					// Title to be displayed on the administration page
		'quasar_general_options_callback',	// Callback used to render the description of the section
		'general'							// Page on which to add this section of options
	);

	// Next, we will introduce the fields for toggling the visibility of content elements.
	add_settings_field(
		'unique_field_id',						// ID used to identify the field throughout the theme
		'Field Label',							// The label to the left of the option interface element
		'quasar_toggle_unique_field_id_callback',	// The name of the function responsible for rendering the option interface
		'general',							// The page on which this option will be displayed
		'general_settings_section',			// The name of the section to which this field belongs
		array(								// The array of arguments to pass to the callback. In this case, just a description.
			'The field description.'
		)
	);
} // end quasar_initialize_theme_options

/* ------------------------------------------------------------------------ *
 * Section Callbacks
 * ------------------------------------------------------------------------ */ 

/**
 * This function provides a simple description for the General Options page. 
 *
 * It is called from the 'quasar_initialize_theme_options' function by being passed as a parameter
 * in the add_settings_section function.
 */
function quasar_general_options_callback() {
	echo '<p>A description for this settings-section.</p>';
} // end quasar_general_options_callback

/* ------------------------------------------------------------------------ * 
 * Field Callbacks 
 * ------------------------------------------------------------------------ */
 /**
 * This is the callback function for rendering the checkbox for the above registered field.
 * 
 * It accepts an array of arguments and expects the first element in the array to be the description
 * to be displayed next to the checkbox.
 */
function quasar_toggle_unique_field_id_callback($args) {
	// Note the ID and the name attribute of the element should match that of the ID in the call to add_settings_field
	$html = '<input type="checkbox" id="unique_field_id" name="unique_field_id" value="1" ' . checked(1, get_option('unique_field_id'), false) . '/>';
	
	// Here, we will take the first argument of the array and add it to a label next to the checkbox
	$html .= '<label for="unique_field_id"> '  . $args[0] . '</label>';
	
	echo $html;
	
} // end quasar_toggle_unique_field_id_callback
