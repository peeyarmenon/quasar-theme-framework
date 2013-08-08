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

	// Adding Fields
	// Add Field One
	add_settings_field(
		'field_one_id',
		// ID used to identify the field throughout the theme
		'Field One Label',
		// The label to the left of the option interface element
		'quasar_toggle_field_one_id_callback',
		// The name of the function responsible for rendering the option interface
		'general',
		// The page on which this option will be displayed
		'general_settings_section',
		// The name of the section to which this field belongs
		array(
			// The array of arguments to pass to the callback. In this case, just a description.
			'The field-one description.'
		)
	);
	// Add Field Two
	add_settings_field(
		'field_two_id',
		'Field Two Label',
		'quasar_toggle_field_two_id_callback',
		'general',
		'general_settings_section',
		array(
			'The field-two description.'
		)
	);
	// Add Field Three
	add_settings_field(
		'field_three_id',
		'Field Three Label',
		'quasar_toggle_field_three_id_callback',
		'general',
		'general_settings_section',
		array(
			'The field-three description.'
		)
	);

	// Registering Fields
	// register field-one
	register_setting(
		'general',
		'field_one_id'
	);
	// register field-one
	register_setting(
		'general',
		'field_two_id'
	);
	// register field-one
	register_setting(
		'general',
		'field_three_id'
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
 /* Callback functions for rendering the fields for the registered fields. */
 // field_one callback
function quasar_toggle_field_one_id_callback($args) {
	// Note the ID and the name attribute of the element should match that of the ID in the call to add_settings_field
	$html = '<input type="checkbox" id="field_one_id" name="field_one_id" value="1" ' . checked(1, get_option('field_one_id'), false) . '/>';
	
	// Here, we will take the first argument of the array and add it to a label next to the checkbox
	$html .= '<label for="field_one_id"> '  . $args[0] . '</label>';
	
	echo $html;	
}

// field_two callback
function quasar_toggle_field_two_id_callback($args) {
	$html = '<input type="checkbox" id="field_two_id" name="field_two_id" value="1" ' . checked(1, get_option('field_two_id'), false) . '/>';

	$html .= '<label for="field_two_id"> '  . $args[0] . '</label>';

	echo $html;	
}

// field_three callback
function quasar_toggle_field_three_id_callback($args) {
	$html = '<input type="checkbox" id="field_three_id" name="field_three_id" value="1" ' . checked(1, get_option('field_three_id'), false) . '/>';

	$html .= '<label for="field_three_id"> '  . $args[0] . '</label>';
	
	echo $html;	
}