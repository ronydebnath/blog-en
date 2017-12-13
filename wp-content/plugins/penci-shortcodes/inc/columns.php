<?php
/* ------------------------------------------------------- */
/* Columns
/* ------------------------------------------------------- */
if ( ! function_exists( 'penci_columns_shortcode' ) ) {
	function penci_columns_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'size' => '1/2',
			'last' => 'false',
		), $atts ) );

		//Global $cl
		$cl = array( 'penci-column' );

		/*-------------Last Column------------*/
		$clearfix = '';
		if ( $last == 'true' ) {
			$cl[] = 'column-last';
			$clearfix = '<div class="clearfix"></div>';
		}

		/*-------------Size------------*/
		if ( ! in_array( $size, array( '1/2', '1/3', '2/3', '1/4', '3/4' ) ) ) { $size = "1/2"; } else { $size = trim( $size ); }
		$size = str_replace( "/", "-", $size );
		$cl[] = 'column-' . $size;

		//Join cl class
		$cl = join( ' ', $cl );

		$return = '<div class="' . trim( $cl ) . '">';
		$return .= do_shortcode( $content );
		$return .= '</div>' . $clearfix;

		return $return;
	}
}