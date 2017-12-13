<?php
/**
 * Block quote widget in sidebar
 * Display your quote on footer or sidebar
 *
 * @package Wordpress
 * @since   1.0
 */

add_action( 'widgets_init', 'penci_quote_load_widget' );

function penci_quote_load_widget() {
	register_widget( 'penci_quote_widget' );
}

class penci_quote_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname'   => 'penci_quote_widget', 'description' => esc_html__( 'A widget that displays an quote widget on your sidebar', 'soledad' ) );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'penci_quote_widget' );

		/* Create the widget. */
		global $wp_version;
		if( 4.3 > $wp_version ) {
			$this->WP_Widget( 'penci_quote_widget', esc_html__( '.Soledad Quote', 'soledad' ), $widget_ops, $control_ops );
		} else {
			parent::__construct( 'penci_quote_widget', esc_html__( '.Soledad Quote', 'soledad' ), $widget_ops, $control_ops );
		}
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title       = apply_filters( 'widget_title', $instance['title'] );
		$description = $instance['description'];

		/* Before widget (defined by themes). */
		echo ent2ncr( $before_widget );

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo ent2ncr( $before_title . $title . $after_title );

		?>

			<?php if ( $description ) : ?>
				<div class="quote-widget">
					<i class="fa fa-quote-left"></i>
					<p><?php echo do_shortcode( $description ); ?></p>
				</div>
			<?php endif; ?>

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
		$instance['description'] = $new_instance['description'];

		return $instance;
	}


	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Quote', 'description' => '' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'soledad' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo sanitize_text_field( $instance['title'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php esc_html_e( 'Quote content text:', 'soledad' ); ?></label>
			<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>" rows="6"><?php echo esc_textarea( $instance['description'] ); ?></textarea>
		</p>


	<?php
	}
}

?>