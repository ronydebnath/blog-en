<?php
/* ------------------------------------------------------- */
/* Icon
/* ------------------------------------------------------- */
if ( ! function_exists( 'penci_icon_shortcode' ) ) {
	function penci_icon_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'name' => '',
		), $atts ) );

		$return = '';
		if ( $name ) {
			$return .= '<i class="fa fa-' . $name . '"></i>';
		}

		return $return;
	}
}