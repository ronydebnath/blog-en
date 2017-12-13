<?php
/*
Plugin Name: Penci Shortcodes
Plugin URI: http://pencidesign.com/
Description: Shortcodes Plugin for Soledad theme.
Version: 1.0
Author: PenciDesign
Author URI: http://themeforest.net/user/pencidesign?ref=pencidesign
*/

/* ------------------------------------------------------- */
/* Include MCE button
/* ------------------------------------------------------- */
require_once( dirname(__FILE__) . '/mce/mce.php' );


/* ------------------------------------------------------- */
/* Remove empty elements
/* ------------------------------------------------------- */
add_filter( 'the_content', 'penci_pre_process_shortcode', 7 );

// Allow Shortcodes in Widgets
add_filter( 'widget_text', 'penci_pre_process_shortcode', 7 );
if ( ! function_exists( 'penci_pre_process_shortcode' ) ) {
	function penci_pre_process_shortcode( $content ) {
		$shortcodes = 'blockquote, columns';
		$shortcodes = explode( ",", $shortcodes );
		$shortcodes = array_map( "trim", $shortcodes );

		global $shortcode_tags;

		// Backup current registered shortcodes and clear them all out
		$orig_shortcode_tags = $shortcode_tags;
		$shortcode_tags      = array();

		foreach ( $shortcodes as $shortcode ) {
			add_shortcode( $shortcode, 'penci_' . $shortcode . '_shortcode' );
		}
		// Do the shortcode (only the one above is registered)
		$content = do_shortcode( $content );

		// Put the original shortcodes back
		$shortcode_tags = $orig_shortcode_tags;

		return $content;
	}
}

/* ------------------------------------------------------- */
/* Include Shortcode File - Add shortcodes to everywhere use*
/* ------------------------------------------------------- */
$shortcodes = 'blockquote, columns, icon';
$shortcodes = explode( ",", $shortcodes );
$shortcodes = array_map( "trim", $shortcodes );

foreach ( $shortcodes as $short_code ) {
	require_once( dirname( __FILE__ ) . '/inc/' . $short_code . '.php' );
	add_shortcode( $short_code, 'penci_' . $short_code . '_shortcode' );
}

/**
 * Add pencilang shortcode
 * Return language text with current lang
 *
 * @since Soledad v4.0
 */
if ( ! function_exists( 'penci_language' ) ) {
	add_shortcode( 'pencilang', 'penci_language' );
	function penci_language( $langs ) {
		$current_lang = get_locale();
		$current_lang = strtolower( $current_lang );
		if ( array_key_exists( $current_lang, $langs ) && isset( $langs[ $current_lang ] ) ) {
			return $langs[ $current_lang ];
		} elseif ( array_key_exists( 'default', $langs ) ) {
			return $langs['default'];
		}

		return;
	}
}