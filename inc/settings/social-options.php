<?php
function quasartheme_intialize_social_options()
{
	// If the social options doesn't exist, create them.
	if ( false == get_option( 'quasartheme_social_options' ) ) {
		add_option( 'quasartheme_social_options' );
	} // end if

	// First, we register a section.
	// This is necessary since all future options must belong to a section
	add_settings_section(
		'social_settings_section',
		// ID used to identify this section and with which to register options
		'Social Options',
		// Title to be displayed on the administration page
		'quasartheme_social_options_callback',
		// Callback used to render the description of the section
		'quasartheme_social_options'
		// Page on which to add this section of options
	);

	// twitter field
	add_settings_field(
		'twitter',
		'Twitter',
		'quasartheme_twitter_callback',
		'quasartheme_social_options',
		'social_settings_section'
	);
	// facebook field
	add_settings_field(
		'facebook',
		'Facebook',
		'quasartheme_facebook_callback',
		'quasartheme_social_options',
		'social_settings_section'
	);
	// googleplus field
	add_settings_field(
		'googleplus',
		'Google+',
		'quasartheme_googleplus_callback',
		'quasartheme_social_options',
		'social_settings_section'
	);

	// register setting
	register_setting(
		'quasartheme_social_options',
		'quasartheme_social_options',
		'quasartheme_sanitize_social_options'
	);
} // end quasartheme_intialize_social_options
add_action( 'admin_init', 'quasartheme_intialize_social_options' );

function quasartheme_social_options_callback()
{
	echo '<p>Provide the URL to the social networks you\'d like to display.</p>';
}

// twitter callback function
function quasartheme_twitter_callback()
{
	$options = get_option( 'quasartheme_social_options' );

	$url = '';
	if ( isset( $options['twitter'])) {
		$url = $options['twitter'];
	} // end if

	// render the output
	echo '<input type="text" id="twitter" name="quasartheme_social_options[twitter]" value="' . $options['twitter'] . '" />';
}

// facebook callback function
function quasartheme_facebook_callback()
{
	$options = get_option( 'quasartheme_social_options' );

	$url = '';
	if ( isset( $options['facebook'])) {
		$url = $options['facebook'];
	} // end if

	// render the output
	echo '<input type="text" id="facebook" name="quasartheme_social_options[facebook]" value="' . $options['facebook'] . '" />';
}

// googleplus callback function
function quasartheme_googleplus_callback()
{
	$options = get_option( 'quasartheme_social_options' );

	$url = '';
	if ( isset( $options['googleplus'])) {
		$url = $options['googleplus'];
	} // end if

	// render the output
	echo '<input type="text" id="googleplus" name="quasartheme_social_options[googleplus]" value="' . $options['googleplus'] . '" />';
}

function quasartheme_sanitize_social_options( $input )
{
	// define the array for the updated options
	$output = array();

	// loop through each of the options sanitizing the data
	foreach ($input as $key => $value) {
		if ( isset( $input[$key]) ) {
			$output[$key] = esc_url_raw( strip_tags( stripslashes( $input[$key] ) ) );
		} // end if
	} // end foreach

	// return the new collection
	return apply_filters( 'quasartheme_sanitize_social_options', $output, $output );
}