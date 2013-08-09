<?php
if ( ! function_exists( 'quasartheme_paging_nav' ) ) :
	/**
	 * Displays navigation to next/previous set of posts when applicable.
	 *
	 * @since Quasar Theme 1.0
	 *
	 * @return void
	 */
	function quasartheme_paging_nav() {
		global $wp_query;

		// Don't print empty markup if there's only one page.
		if ( $wp_query->max_num_pages < 2 )
			return;
		?>
		<nav class="navigation paging-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'quasartheme' ); ?></h1>
			<div class="nav-links">

				<?php if ( get_next_posts_link() ) : ?>
				<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'quasartheme' ) ); ?></div>
				<?php endif; ?>

				<?php if ( get_previous_posts_link() ) : ?>
				<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'quasartheme' ) ); ?></div>
				<?php endif; ?>

			</div><!-- .nav-links -->
		</nav><!-- .navigation -->
		<?php
	}
endif;

if ( ! function_exists( 'quasartheme_post_nav' ) ) :
	/**
	 * Displays navigation to next/previous post when applicable.
	*
	* @since Quasar Theme 1.0
	*
	* @return void
	*/
	function quasartheme_post_nav() {
		global $post;

		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
		?>
		<nav class="navigation post-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'quasartheme' ); ?></h1>
			<div class="nav-links">

				<?php previous_post_link( '%link', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'quasartheme' ) ); ?>
				<?php next_post_link( '%link', _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link', 'quasartheme' ) ); ?>

			</div><!-- .nav-links -->
		</nav><!-- .navigation -->
		<?php
	}
endif;

if ( ! function_exists( 'quasartheme_entry_meta' ) ) :
	/**
	 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
	 *
	 * Create your own quasartheme_entry_meta() to override in a child theme.
	 *
	 * @since Quasar Theme 1.0
	 *
	 * @return void
	 */
	function quasartheme_entry_meta() {
		if ( is_sticky() && is_home() && ! is_paged() )
			echo '<span class="featured-post">' . __( 'Sticky', 'quasartheme' ) . '</span>';

		if ( ! has_post_format( 'link' ) && 'post' == get_post_type() )
			quasartheme_entry_date();

		// Translators: used between list items, there is a space after the comma.
		$categories_list = get_the_category_list( __( ', ', 'quasartheme' ) );
		if ( $categories_list ) {
			echo '<span class="categories-links">' . $categories_list . '</span>';
		}

		// Translators: used between list items, there is a space after the comma.
		$tag_list = get_the_tag_list( '', __( ', ', 'quasartheme' ) );
		if ( $tag_list ) {
			echo '<span class="tags-links">' . $tag_list . '</span>';
		}

		// Post author
		if ( 'post' == get_post_type() ) {
			printf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_attr( sprintf( __( 'View all posts by %s', 'quasartheme' ), get_the_author() ) ),
				get_the_author()
			);
		}
	}
endif;

if ( ! function_exists( 'quasartheme_entry_date' ) ) :
	/**
	 * Prints HTML with date information for current post.
	 *
	 * Create your own quasartheme_entry_date() to override in a child theme.
	 *
	 * @since Quasar Theme 1.0
	 *
	 * @param boolean $echo Whether to echo the date. Default true.
	 * @return string The HTML-formatted post date.
	 */
	function quasartheme_entry_date( $echo = true ) {
		if ( has_post_format( array( 'chat', 'status' ) ) )
			$format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', 'quasartheme' );
		else
			$format_prefix = '%2$s';

		$date = sprintf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
			esc_url( get_permalink() ),
			esc_attr( sprintf( __( 'Permalink to %s', 'quasartheme' ), the_title_attribute( 'echo=0' ) ) ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
		);

		if ( $echo )
			echo $date;

		return $date;
	}
endif;

if ( ! function_exists( 'quasartheme_the_attached_image' ) ) :
	/**
	 * Prints the attached image with a link to the next attached image.
	 *
	 * @since Quasar Theme 1.0
	 *
	 * @return void
	 */
	function quasartheme_the_attached_image() {
		$post                = get_post();
		$attachment_size     = apply_filters( 'quasartheme_attachment_size', array( 724, 724 ) );
		$next_attachment_url = wp_get_attachment_url();

		/**
		 * Grab the IDs of all the image attachments in a gallery so we can get the URL
		 * of the next adjacent image in a gallery, or the first image (if we're
		 * looking at the last image in a gallery), or, in a gallery of one, just the
		 * link to that image file.
		 */
		$attachment_ids = get_posts( array(
			'post_parent'    => $post->post_parent,
			'fields'         => 'ids',
			'numberposts'    => -1,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => 'ASC',
			'orderby'        => 'menu_order ID'
		) );

		// If there is more than 1 attachment in a gallery...
		if ( count( $attachment_ids ) > 1 ) {
			foreach ( $attachment_ids as $attachment_id ) {
				if ( $attachment_id == $post->ID ) {
					$next_id = current( $attachment_ids );
					break;
				}
			}

			// get the URL of the next image attachment...
			if ( $next_id )
				$next_attachment_url = get_attachment_link( $next_id );

			// or get the URL of the first image attachment.
			else
				$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
		}

		printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
			esc_url( $next_attachment_url ),
			the_title_attribute( array( 'echo' => false ) ),
			wp_get_attachment_image( $post->ID, $attachment_size )
		);
	}
endif;

if ( ! function_exists( 'quasartheme_get_link_url' ) ) :
	/**
	 * Returns the URL from the post.
	 *
	 * @uses get_url_in_content() to get the URL in the post meta (if it exists) or
	 * the first link found in the post content.
	 *
	 * Falls back to the post permalink if no URL is found in the post.
	 *
	 * @since Quasar Theme 1.0
	 *
	 * @return string The Link format URL.
	 */
	function quasartheme_get_link_url() {
		$content = get_the_content();
		$has_url = get_url_in_content( $content );

		return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
	}
endif;

if ( ! function_exists( 'quasartheme_fonts_url' ) ) :
	/**
	 * Returns the Google font stylesheet URL, if available.
	 *
	 * The use of Source Sans Pro and Bitter by default is localized. For languages
	 * that use characters not supported by the font, the font can be disabled.
	 *
	 * @since Quasar Theme 1.0
	 *
	 * @return string Font stylesheet or empty string if disabled.
	 */
	function quasartheme_fonts_url() {
		$fonts_url = '';

		/* Translators: If there are characters in your language that are not
		 * supported by Open Sans, translate this to 'off'. Do not translate
		 * into your own language.
		 */
		$open_sans = _x( 'on', 'Open Sans font: on or off', 'quasartheme' );

		/* Translators: If there are characters in your language that are not
		 * supported by Neuton, translate this to 'off'. Do not translate into your
		 * own language.
		 */
		$abril_fatface = _x( 'on', 'Neuton font: on or off', 'quasartheme' );

		if ( 'off' !== $open_sans || 'off' !== $abril_fatface ) {
			$font_families = array();

			if ( 'off' !== $open_sans )
				$font_families[] = 'Open Sans:300,400,700,300italic,400italic,700italic';

			if ( 'off' !== $abril_fatface )
				$font_families[] = 'Abril Fatface';

			$query_args = array(
				'family' => urlencode( implode( '|', $font_families ) ),
				'subset' => urlencode( 'latin,latin-ext' ),
			);
			$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
		}

		return $fonts_url;
	}
endif;