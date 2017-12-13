<?php
/**
 * Custom controller numbers type and categories type
 *
 * @package Wordpress
 * @since 1.0
 */
add_action( 'customize_register', 'pencidesign_customize_register' );
function pencidesign_customize_register( $wp_customize ) {
	class Customize_Number_Control extends WP_Customize_Control {
		public $type = 'number';

		public function render_content() {
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<input type="number" name="quantity" <?php $this->link(); ?> value="<?php echo esc_textarea( $this->value() ); ?>" style="width:70px;">
			</label>
		<?php
		}
	}

	class Customize_CustomCss_Control extends WP_Customize_Control {
		public $type = 'custom_css';

		public function render_content() {
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<textarea style="width:100%; height:150px;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
			</label>
		<?php
		}
	}
}

if ( class_exists( 'WP_Customize_Control' ) ) {
	class WP_Customize_Category_Control extends WP_Customize_Control {
		public function render_content() {
			$dropdown = wp_dropdown_categories( array(
				'name'              => '_customize-dropdown-categories-' . $this->id,
				'echo'              => 0,
				'show_option_none'  => esc_html__( '&mdash; Select &mdash;', 'soledad' ),
				'option_none_value' => '0',
				'selected'          => $this->value(),
			) );

			// Hackily add in the data link parameter.
			$dropdown = str_replace( '<select', '<select ' . $this->get_link(), $dropdown );

			printf( '<label class="customize-control-select"><span class="customize-control-title">%s</span> %s</label>', $this->label, $dropdown );
		}
	}
}


/**
 * Add customize documentation for Soledad
 *
 * @since 4.0
 *
 */
add_action( 'customize_controls_enqueue_scripts', 'penci_customizer_documentation' );
/**
 * Enqueue script for customizer control
 */
if ( ! function_exists( 'penci_customizer_documentation' ) ) {
	function penci_customizer_documentation() {
		wp_enqueue_script( 'penci-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'jquery' ), '', true );
		wp_localize_script( 'penci-customizer', 'SoledadCustomizerDoc',
			array(
				'docs' => 'View Documentation'
			)
		);
	}
}
?>