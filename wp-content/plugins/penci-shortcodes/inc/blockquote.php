<?php
/* ------------------------------------------------------- */
/* Blockquote
/* ------------------------------------------------------- */
if ( ! function_exists( 'penci_blockquote_shortcode' ) ) {
	function penci_blockquote_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'author' => '',
			'align'  => 'none',
		), $atts ) );

		$author_html = '';
		if ( $author ): $author_html = '<div class="author"><span>' . $author . '</span></div>'; endif;

		$return = '<div class="penci-pullqoute align-' . esc_attr( $align ) . '"><blockquote>' . $content . $author_html . '</blockquote></div>';

		return $return;
	}
}