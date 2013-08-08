<?php
/**
 * Implements a custom header for Varahi.
 * See http://codex.wordpress.org/Custom_Headers
 *
 * @package WordPress
 * @subpackage Varahi
 * @since Varahi 1.0
 */

/**
 * Sets up the WordPress core custom header arguments and settings.
 *
 * @uses add_theme_support() to register support for 3.4 and up.
 * @uses varahi_header_style() to style front-end.
 * @uses varahi_admin_header_style() to style wp-admin form.
 * @uses varahi_admin_header_image() to add custom markup to wp-admin form.
 * @uses register_default_headers() to set up the bundled header images.
 *
 * @since Varahi 1.0
 */
function varahi_custom_header_setup() {
	$args = array(
		// Text color and image (empty to use none).
		'default-text-color'     => '0e1922',
		'default-image'          => '%s/images/headers/circle.png',

		// Set height and width, with a maximum value for the width.
		'height'                 => 230,
		'width'                  => 1920, // 1600,

		// Callbacks for styling the header and the admin preview.
		'wp-head-callback'       => 'varahi_header_style',
		'admin-head-callback'    => 'varahi_admin_header_style',
		'admin-preview-callback' => 'varahi_admin_header_image',
	);

	add_theme_support( 'custom-header', $args );

	/*
	 * Default custom headers packaged with the theme.
	 * %s is a placeholder for the theme template directory URI.
	 */
	register_default_headers( array(
		'3dwall' => array(
			'url'           => '%s/images/headers/3dwall.png',
			'thumbnail_url' => '%s/images/headers/3dwall-thumbnail.png',
			'description'   => _x( '3D Wall', 'header image description', 'varahi' )
		),
		'bokeh' => array(
			'url'           => '%s/images/headers/bokeh.png',
			'thumbnail_url' => '%s/images/headers/bokeh-thumbnail.png',
			'description'   => _x( 'Bokeh', 'header image description', 'varahi' )
		),
		'fluidwave' => array(
			'url'           => '%s/images/headers/fluidwave.png',
			'thumbnail_url' => '%s/images/headers/fluidwave-thumbnail.png',
			'description'   => _x( 'Fluid Wave', 'header image description', 'varahi' )
		),
		'glassy' => array(
			'url'           => '%s/images/headers/glassy.png',
			'thumbnail_url' => '%s/images/headers/glassy-thumbnail.png',
			'description'   => _x( 'Glassy', 'header image description', 'varahi' )
		),
		'mystical' => array(
			'url'           => '%s/images/headers/mystical.png',
			'thumbnail_url' => '%s/images/headers/mystical-thumbnail.png',
			'description'   => _x( 'Mystical', 'header image description', 'varahi' )
		),
		'rainbow' => array(
			'url'           => '%s/images/headers/rainbow.png',
			'thumbnail_url' => '%s/images/headers/rainbow-thumbnail.png',
			'description'   => _x( 'Rainbow Stripes', 'header image description', 'varahi' )
		),
		'scifi' => array(
			'url'           => '%s/images/headers/scifi.png',
			'thumbnail_url' => '%s/images/headers/scifi-thumbnail.png',
			'description'   => _x( 'Sci Fi', 'header image description', 'varahi' )
		),
	) );
}
add_action( 'after_setup_theme', 'varahi_custom_header_setup' );

/**
 * Loads our special font CSS files.
 *
 * @since Varahi 1.0
 */
function varahi_custom_header_fonts() {
	// Add Open Sans and Bitter fonts.
	wp_enqueue_style( 'varahi-fonts', varahi_fonts_url(), array(), null );

	// Add Genericons font.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/fonts/genericons.css', array(), '2.09' );
}
add_action( 'admin_print_styles-appearance_page_custom-header', 'varahi_custom_header_fonts' );

/**
 * Styles the header text displayed on the blog.
 *
 * get_header_textcolor() options: Hide text (returns 'blank'), or any hex value.
 *
 * @since Varahi 1.0
 */
function varahi_header_style() {
	$header_image = get_header_image();
	$text_color   = get_header_textcolor();

	// If no custom options for text are set, let's bail.
	if ( empty( $header_image ) && $text_color == get_theme_support( 'custom-header', 'default-text-color' ) )
		return;

	// If we get this far, we have custom styles.
	?>
	<style type="text/css" id="varahi-header-css">
	<?php
		if ( ! empty( $header_image ) ) :
	?>
		.site-header {
			background: url(<?php header_image(); ?>) no-repeat scroll top;
			background-size: 1920px auto;
		}
	<?php
		endif;

		// Has the text been hidden?
		if ( ! display_header_text() ) :
	?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px 1px 1px 1px); /* IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
			if ( empty( $header_image ) ) :
	?>
		.site-header .home-link {
			min-height: 0;
		}
	<?php
			endif;

		// If the user has set a custom color for the text, use that.
		elseif ( $text_color != get_theme_support( 'custom-header', 'default-text-color' ) ) :
	?>
		.site-title,
		.site-description {
			color: #<?php echo esc_attr( $text_color ); ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}

/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @since Varahi 1.0
 */
function varahi_admin_header_style() {
	$header_image = get_header_image();
?>
	<style type="text/css" id="varahi-admin-header-css">
	.appearance_page_custom-header #headimg {
		border: none;
		-webkit-box-sizing: border-box;
		-moz-box-sizing:    border-box;
		box-sizing:         border-box;
		<?php
		if ( ! empty( $header_image ) ) {
			echo 'background: url(' . esc_url( $header_image ) . ') no-repeat scroll top; background-size: 1920px auto;';
		} ?>
		padding: 0 20px;
	}
	#headimg .home-link {
		-webkit-box-sizing: border-box;
		-moz-box-sizing:    border-box;
		box-sizing:         border-box;
		margin: 0 auto;
		max-width: 1040px;
		<?php
		if ( ! empty( $header_image ) || display_header_text() ) {
			echo 'min-height: 230px;';
		} ?>
		width: 100%;
	}
	<?php if ( ! display_header_text() ) : ?>
	#headimg h1,
	#headimg h2 {
		position: absolute !important;
		clip: rect(1px 1px 1px 1px); /* IE7 */
		clip: rect(1px, 1px, 1px, 1px);
	}
	<?php endif; ?>
	#headimg h1 {
		font: bold 60px/1 Bitter, Georgia, serif;
		margin: 0;
		padding: 58px 0 10px;
	}
	#headimg h1 a {
		text-decoration: none;
	}
	#headimg h1 a:hover {
		text-decoration: underline;
	}
	#headimg h2 {
		font: 200 italic 24px "Open Sans", Helvetica, sans-serif;
		margin: 0;
		text-shadow: none;
	}
	.default-header img {
		max-width: 230px;
		width: auto;
	}
	</style>
<?php
}

/**
 * Outputs markup to be displayed on the Appearance > Header admin panel.
 * This callback overrides the default markup displayed there.
 *
 * @since Varahi 1.0
 */
function varahi_admin_header_image() {
	?>
	<div id="headimg" style="background: url(<?php header_image(); ?>) no-repeat scroll top; background-size: 1920px auto;">
		<?php $style = ' style="color:#' . get_header_textcolor() . ';"'; ?>
		<div class="home-link">
			<h1 class="displaying-header-text"><a id="name"<?php echo $style; ?> onclick="return false;" href="#"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 id="desc" class="displaying-header-text"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></h2>
		</div>
	</div>
<?php }