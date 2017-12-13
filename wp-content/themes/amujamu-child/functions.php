<?php
/*
 Soledad child theme functions and definitions
*/
function penci_soledad_child_scripts() {
    wp_enqueue_style( 'penci-soledad-parent-style', get_template_directory_uri(). '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'penci_soledad_child_scripts' );

/*
 * All custom functions go here
 */