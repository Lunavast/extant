<?php
/**
 * Helper functions and filters for scripts, styles, and fonts.
 *
 * @package    Extant
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2015, Justin Tadlock
 * @link       http://themehybrid.com/themes/extant
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Load scripts, styles, and fonts.
add_action( 'wp_enqueue_scripts',    'extant_enqueue'        );
add_action( 'enqueue_embed_scripts', 'extant_enqueue_embed'  );

/**
 * Returns an array of the font families to load from Google Fonts.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function extant_get_font_families() {

	return array(
	//	'noto-sans'    => 'Noto Sans:400,400i,700,700i',
		'roboto'    => 'Roboto:400,400i,700,700i',
		'roboto-slab'  => 'Roboto+Slab:400,700',
	//	'crimson' => 'Crimson Text:400,400italic,600'
	);
}

/**
 * Returns an array of the font subsets to include.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function extant_get_font_subsets() {

	return array( 'latin', 'latin-ext' );
}

/**
 * Loads scripts, styles, and fonts on the front end.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function extant_enqueue() {

	// Deregisters the core media player styles (rolling our own).
	wp_deregister_style( 'mediaelement' );
	wp_deregister_style( 'wp-mediaelement' );

	// Add custom mediaelement inline script.
	wp_add_inline_script( 'mediaelement', extant_get_mediaelement_inline_script() );

	// Load scripts.
	wp_enqueue_script( 'extant' );

	// Load fonts.
	//hybrid_enqueue_font( 'extant' );

	// Load styles.
	wp_enqueue_style( 'font-awesome'        );
	wp_enqueue_style( 'hybrid-one-five'     );
	wp_enqueue_style( 'hybrid-gallery'      );

	if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {

		wp_enqueue_style( 'extant-style'        );
		wp_enqueue_style( 'extant-mediaelement' );
		wp_enqueue_style( 'extant-colors'       );

	} else {

		is_child_theme() ? wp_enqueue_style( 'hybrid-parent' ) : wp_enqueue_style( 'hybrid-style' );
	}
}

/**
 * Loads scripts, styles, and fonts for embeds.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function extant_enqueue_embed() {

	// Load fonts.
	hybrid_enqueue_font( 'extant' );

	// Load styles.
	wp_enqueue_style( 'font-awesome' );

	if ( is_child_theme() )
		wp_enqueue_style( 'extant-parent-embed' );

	wp_enqueue_style( 'extant-embed' );
}

/**
 * Inline script called for the media player.  This reorders the controls.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function extant_get_mediaelement_inline_script() {

	return "( function( window ) {

		var settings = window._wpmejsSettings || {};

		settings.features = [ 'progress', 'playpause', 'volume', 'tracks', 'current', 'duration', 'fullscreen' ];
	} )( window );";
}

/**
 * This is a fix for when a user sets a custom background color with no custom background image.  What
 * happens is the theme's background image hides the user-selected background color.  If a user selects a
 * background image, we'll just use the WordPress custom background callback.  This also fixes WordPress
 * not correctly handling the theme's default background color.
 *
 * @link http://core.trac.wordpress.org/ticket/16919
 * @link http://core.trac.wordpress.org/ticket/21510
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function extant_custom_background_callback() {

	/* Get the background image. */
	$image = get_background_image();

	/* If there's an image, just call the normal WordPress callback. We won't do anything here. */
	if ( !empty( $image ) ) {
		_custom_background_cb();
		return;
	}

	/* Get the background color. */
	$color = get_background_color();

	/* If no background color, return. */
	if ( empty( $color ) )
		return;

	/* Use 'background' instead of 'background-color'. */
	$style = "background: #{$color};";

?>
<style type="text/css" id="custom-background-css">body.custom-background { <?php echo trim( $style ); ?> }</style>
<?php

}
