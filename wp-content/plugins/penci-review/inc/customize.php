<?php
/**
 * Customize for Penci review
 * @since 1.0
 */
function penci_soledad_review_customizer( $wp_customize ) {
	// Add Sections
	$wp_customize->add_section( 'penci_new_section_review' , array(
		'title'      => 'Posts Review Options',
		'description'=> '',
		'priority'   => 49,
	) );

	// Add settings
	$wp_customize->add_setting( 'penci_review_hide_average', array(
		'default'           => false,
		'sanitize_callback' => 'penci_review_sanitize_checkbox_field'
	) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'review_hide_average', array(
		'label'    => 'Hide "Average Score" text',
		'section'  => 'penci_new_section_review',
		'settings' => 'penci_review_hide_average',
		'type'     => 'checkbox',
		'priority' => 1
	) ) );

	$wp_customize->add_setting( 'penci_review_border_color', array(
		'default'           => '#dedede',
		'sanitize_callback' => 'sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'review_border_color', array(
		'label'    => 'Review Box Border Color',
		'section'  => 'penci_new_section_review',
		'settings' => 'penci_review_border_color',
		'priority' => 2
	) ) );

	$wp_customize->add_setting( 'penci_review_title_color', array(
		'default'           => '#313131',
		'sanitize_callback' => 'sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'review_title_color', array(
		'label'    => 'Review Title Color',
		'section'  => 'penci_new_section_review',
		'settings' => 'penci_review_title_color',
		'priority' => 3
	) ) );

	$wp_customize->add_setting( 'penci_review_desc_color', array(
		'default'           => '#313131',
		'sanitize_callback' => 'sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'review_desc_color', array(
		'label'    => 'Review Description Text Color',
		'section'  => 'penci_new_section_review',
		'settings' => 'penci_review_desc_color',
		'priority' => 3
	) ) );

	$wp_customize->add_setting( 'penci_review_point_title_color', array(
		'default'           => '#313131',
		'sanitize_callback' => 'sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'review_point_title_color', array(
		'label'    => 'Review Point Title & Score Color',
		'section'  => 'penci_new_section_review',
		'settings' => 'penci_review_point_title_color',
		'priority' => 4
	) ) );

	$wp_customize->add_setting( 'penci_review_process_main_color', array(
		'default'           => '#e6e6e6',
		'sanitize_callback' => 'sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'review_process_main_color', array(
		'label'    => 'Review Process Main Background Color',
		'section'  => 'penci_new_section_review',
		'settings' => 'penci_review_process_main_color',
		'priority' => 4
	) ) );

	$wp_customize->add_setting( 'penci_review_process_run_color', array(
		'default'           => '#6eb48c',
		'sanitize_callback' => 'sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'review_process_run_color', array(
		'label'    => 'Review Process Running Background Color',
		'section'  => 'penci_new_section_review',
		'settings' => 'penci_review_process_run_color',
		'priority' => 4
	) ) );

	$wp_customize->add_setting( 'penci_review_title_good_color', array(
		'default'           => '#313131',
		'sanitize_callback' => 'sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'review_title_good_color', array(
		'label'    => 'The Goods & The Bads Title Color',
		'section'  => 'penci_new_section_review',
		'settings' => 'penci_review_title_good_color',
		'priority' => 5
	) ) );

	$wp_customize->add_setting( 'penci_review_good_icon', array(
		'default'           => '#22b162',
		'sanitize_callback' => 'sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'review_good_icon', array(
		'label'    => 'Review The Goods Icon Color',
		'section'  => 'penci_new_section_review',
		'settings' => 'penci_review_good_icon',
		'priority' => 5
	) ) );

	$wp_customize->add_setting( 'penci_review_bad_icon', array(
		'default'           => '#e03030',
		'sanitize_callback' => 'sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'review_bad_icon', array(
		'label'    => 'Review The Bads Icon Color',
		'section'  => 'penci_new_section_review',
		'settings' => 'penci_review_bad_icon',
		'priority' => 5
	) ) );

	$wp_customize->add_setting( 'penci_review_average_total_bg', array(
		'default'           => '#6eb48c',
		'sanitize_callback' => 'sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'review_average_total_bg', array(
		'label'    => 'Review Average Total Background',
		'section'  => 'penci_new_section_review',
		'settings' => 'penci_review_average_total_bg',
		'priority' => 6
	) ) );

	$wp_customize->add_setting( 'penci_review_average_total_color', array(
		'default'           => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'review_average_total_color', array(
		'label'    => 'Review Average Total Score Color',
		'section'  => 'penci_new_section_review',
		'settings' => 'penci_review_average_total_color',
		'priority' => 6
	) ) );

	$wp_customize->add_setting( 'penci_review_average_text_color', array(
		'default'           => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'review_average_text_color', array(
		'label'    => 'Review "Average Score" Text Color',
		'section'  => 'penci_new_section_review',
		'settings' => 'penci_review_average_text_color',
		'priority' => 6
	) ) );

	$wp_customize->add_setting( 'penci_review_hide_piechart', array(
		'default'           => false,
		'sanitize_callback' => 'penci_review_sanitize_checkbox_field'
	) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'review_hide_piechart', array(
		'label'    => 'Hide Review Pie Chart on Featured Image',
		'section'  => 'penci_new_section_review',
		'settings' => 'penci_review_hide_piechart',
		'type'     => 'checkbox',
		'priority' => 6
	) ) );

	$wp_customize->add_setting( 'penci_review_piechart_border', array(
		'default'           => '#6eb48c',
		'sanitize_callback' => 'sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'review_piechart_border', array(
		'label'    => 'Review Pie Chart Border Color',
		'section'  => 'penci_new_section_review',
		'settings' => 'penci_review_piechart_border',
		'priority' => 6
	) ) );

	$wp_customize->add_setting( 'penci_review_piechart_text', array(
		'default'           => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'review_piechart_text', array(
		'label'    => 'Review Pie Chart Score Text Color',
		'section'  => 'penci_new_section_review',
		'settings' => 'penci_review_piechart_text',
		'priority' => 6
	) ) );

	$wp_customize->add_setting( 'penci_review_good_text', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field'
	) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'review_good_text', array(
		'label'    => 'Custom "The Goods" text',
		'section'  => 'penci_new_section_review',
		'settings' => 'penci_review_good_text',
		'type'     => 'text',
		'priority' => 7
	) ) );

	$wp_customize->add_setting( 'penci_review_bad_text', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field'
	) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'review_bad_text', array(
		'label'    => 'Custom "The Bads" text',
		'section'  => 'penci_new_section_review',
		'settings' => 'penci_review_bad_text',
		'type'     => 'text',
		'priority' => 8
	) ) );

	$wp_customize->add_setting( 'penci_review_average_text', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field'
	) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'review_average_text', array(
		'label'    => 'Custom "Average Score" text',
		'section'  => 'penci_new_section_review',
		'settings' => 'penci_review_average_text',
		'type'     => 'text',
		'priority' => 9
	) ) );

}
add_action( 'customize_register', 'penci_soledad_review_customizer' );

/**
 * Callback function for sanitizing checkbox settings.
 * Use for PenciDesign
 *
 * @param $input
 *
 * @return string default value if type is not exists
 */
function penci_review_sanitize_checkbox_field( $input ) {
	if ( $input == 1 ) {
		return true;
	}
	else {
		return false;
	}
}

/**
 * Customize colors
 * @since 3.0
 */
function penci_review_customizer_css() {
	?>
	<style type="text/css">
		<?php if(get_theme_mod( 'penci_review_border_color' )) : ?>.wrapper-penci-review { border-color:<?php echo get_theme_mod( 'penci_review_border_color' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'penci_review_title_color' )) : ?>.penci-review-container.penci-review-count h4 { color:<?php echo get_theme_mod( 'penci_review_title_color' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'penci_review_desc_color' )) : ?>.post-entry .penci-review-desc p { color:<?php echo get_theme_mod( 'penci_review_desc_color' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'penci_review_point_title_color' )) : ?>.penci-review-text { color:<?php echo get_theme_mod( 'penci_review_point_title_color' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'penci_review_process_main_color' )) : ?>.penci-review-process { background-color:<?php echo get_theme_mod( 'penci_review_process_main_color' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'penci_review_process_run_color' )) : ?>.penci-review .penci-review-process span { background-color:<?php echo get_theme_mod( 'penci_review_process_run_color' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'penci_review_title_good_color' )) : ?>.penci-review-stuff .penci-review-good h5 { color:<?php echo get_theme_mod( 'penci_review_title_good_color' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'penci_review_good_icon' )) : ?>.penci-review .penci-review-good ul li:before { color:<?php echo get_theme_mod( 'penci_review_good_icon' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'penci_review_bad_icon' )) : ?>.penci-review .penci-review-bad ul li:before { color:<?php echo get_theme_mod( 'penci_review_bad_icon' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'penci_review_average_total_bg' )) : ?>.penci-review .penci-review-score-total { background-color:<?php echo get_theme_mod( 'penci_review_average_total_bg' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'penci_review_average_total_color' )) : ?>.penci-review-score-num { color:<?php echo get_theme_mod( 'penci_review_average_total_color' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'penci_review_average_text_color' )) : ?>.penci-review-score-total span { color:<?php echo get_theme_mod( 'penci_review_average_text_color' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'penci_review_piechart_text' )) : ?>.penci-chart-text { color:<?php echo get_theme_mod( 'penci_review_piechart_text' ); ?>; }<?php endif; ?>
	</style>
<?php
}
add_action( 'wp_head', 'penci_review_customizer_css' );