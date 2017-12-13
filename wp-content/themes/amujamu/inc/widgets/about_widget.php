<?php
/**
 * About me widget
 * Display your information on footer or sidebar
 *
 * @package Wordpress
 * @since   1.0
 */

add_action( 'widgets_init', 'penci_about_load_widget' );

function penci_about_load_widget() {
	register_widget( 'penci_about_widget' );
}

class penci_about_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname'   => 'penci_about_widget', 'description' => esc_html__( 'A widget that displays an About widget', 'soledad' ) );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'penci_about_widget' );

		/* Create the widget. */
		global $wp_version;
		if( 4.3 > $wp_version ) {
			$this->WP_Widget( 'penci_about_widget', esc_html__( '.Soledad About Me', 'soledad' ), $widget_ops, $control_ops );
		} else {
			parent::__construct( 'penci_about_widget', esc_html__( '.Soledad About Me', 'soledad' ), $widget_ops, $control_ops );
		}
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title       = apply_filters( 'widget_title', $instance['title'] );
		$align       = isset( $instance['align'] ) ? $instance['align'] : '';
		$image       = $instance['image'];
		$circle      = isset( $instance['circle'] ) ? $instance['circle'] : '';
		$lazyload      = isset( $instance['lazyload'] ) ? $instance['lazyload'] : '';
		$imageurl    = isset( $instance['imageurl'] ) ? $instance['imageurl'] : '';
		$target      = isset( $instance['target'] ) ? $instance['target'] : '';
		$heading     = $instance['heading'];
		$description = $instance['description'];

		/* Before widget (defined by themes). */
		echo ent2ncr( $before_widget );

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo ent2ncr( $before_title . $title . $after_title );

		$circle_style = '';
		$open_image = '';
		$close_image = '';
		$target_html = '';

		if( $circle ):
			$circle_style = ' style="border-radius: 50%; -webkit-border-radius: 50%;"';
		endif;
		if( $imageurl ):
			if( $target ): $target_html = ' target="_blank"'; endif;
			$open_image = '<a href="'. $imageurl .'"'. $target_html .'>';
			$close_image = '</a>';
		endif;
		?>

		<div class="about-widget<?php if( $align ): echo ' ' . $align; endif; ?>">
			<?php if ( $image ) : ?>
				<?php echo $open_image; ?>
				<?php if( ! $lazyload ) { ?>
					<img class="penci-widget-about-image holder-square penci-lazy" src="<?php echo get_template_directory_uri() . '/images/penci2-holder.png'; ?>" data-src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>"<?php echo $circle_style; ?>/>
				<?php } else { ?>
					<img class="penci-widget-about-image holder-square" src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>"<?php echo $circle_style; ?>/>
				<?php }?>
				<?php echo $close_image; ?>
			<?php endif; ?>

			<?php if ( $heading ) : ?>
				<h2 class="about-me-heading"><?php echo sanitize_text_field( $heading ); ?></h2>
			<?php endif; ?>

			<?php if ( $description ) : ?>
				<p><?php echo wp_kses( $description, penci_allow_html() ); ?></p>
			<?php endif; ?>

		</div>

		<?php

		/* After widget (defined by themes). */
		echo ent2ncr( $after_widget );
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title']       = strip_tags( $new_instance['title'] );
		$instance['align']       = strip_tags( $new_instance['align'] );
		$instance['image']       = strip_tags( $new_instance['image'] );
		$instance['circle']      = strip_tags( $new_instance['circle'] );
		$instance['lazyload']    = strip_tags( $new_instance['lazyload'] );
		$instance['imageurl']    = strip_tags( $new_instance['imageurl'] );
		$instance['target']      = strip_tags( $new_instance['target'] );
		$instance['heading']     = strip_tags( $new_instance['heading'] );
		$instance['description'] = $new_instance['description'];

		return $instance;
	}


	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'About Me', 'align' => '', 'image' => '', 'circle' => '', 'lazyload' => '', 'imageurl' => '', 'target' => '', 'heading' => '', 'description' => '' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'soledad' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo sanitize_text_field( $instance['title'] ); ?>" />
		</p>

		<!-- Align -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('align') ); ?>">Align This Widget:</label>
			<select id="<?php echo esc_attr( $this->get_field_id('align') ); ?>" name="<?php echo esc_attr( $this->get_field_name('align') ); ?>" class="widefat categories" style="width:100%;">
				<option value='pc_aligncenter' <?php if ('' == $instance['align']) echo 'selected="selected"'; ?>>Align Center</option>
				<option value='pc_alignleft' <?php if ('pc_alignleft' == $instance['align']) echo 'selected="selected"'; ?>>Align Left</option>
				<option value='pc_alignright' <?php if ('pc_alignright' == $instance['align']) echo 'selected="selected"'; ?>>Align Right</option>
			</select>
		</p>

		<!-- image url -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>"><?php esc_html_e( 'About Image URL:', 'soledad' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" value="<?php echo esc_url( $instance['image'] ); ?>" /><br />
			<small><?php esc_html_e( 'Insert your image URL. For best result use 365px width.', 'soledad' ); ?></small>
		</p>

		<!-- Circle image -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'circle' ) ); ?>"><?php esc_html_e('Make About Image Circle:','soledad'); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'circle' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'circle' ) ); ?>" <?php checked( (bool) $instance['circle'], true ); ?> /><br />
			<small><?php esc_html_e( 'To use this feature, please use square image for your image above to get best display.', 'soledad' ); ?></small>
		</p>

		<!-- Lazyload image -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'lazyload' ) ); ?>"><?php esc_html_e('Disable Lazyload for About Me Image:','soledad'); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'lazyload' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'lazyload' ) ); ?>" <?php checked( (bool) $instance['lazyload'], true ); ?> />
		</p>

		<!-- Link for image -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'imageurl' ) ); ?>"><?php esc_html_e( 'Add Link for About Image:', 'soledad' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'imageurl' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'imageurl' ) ); ?>" value="<?php echo sanitize_text_field( $instance['imageurl'] ); ?>" />
			<small>If you want to clickable on the about me image link to other page, put the link here. Include <strong style="font-weight: bold;">http://</strong> or <strong style="font-weight: bold;">https://</strong> on the link</small>
		</p>

		<!-- Open new tab image -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>"><?php esc_html_e('Click About Image Open in New Tab?','soledad'); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'target' ) ); ?>" <?php checked( (bool) $instance['target'], true ); ?> />
		</p>

		<!-- heading text -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'heading' ) ); ?>"><?php esc_html_e( 'Heading Text:', 'soledad' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'heading' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'heading' ) ); ?>" value="<?php echo sanitize_text_field( $instance['heading'] ); ?>" />
		</p>

		<!-- description -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php esc_html_e( 'About me text: ( you can use HTML here )', 'soledad' ); ?></label>
			<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>" rows="6"><?php echo esc_textarea( $instance['description'] ); ?></textarea>
		</p>


	<?php
	}
}

?>