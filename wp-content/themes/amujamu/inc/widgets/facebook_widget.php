<?php
/**
 * Facebook page box widget
 * Display facebook page box on your website
 *
 * @package Wordpress
 * @since 1.0
 */

add_action( 'widgets_init', 'penci_facebook_load_widget' );

function penci_facebook_load_widget() {
	register_widget( 'penci_facebook_widget' );
}

class penci_facebook_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'penci_facebook_widget', 'description' => esc_html__('A widget will displays a Facebook Page', 'soledad') );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'penci_facebook_widget' );

		/* Create the widget. */
		global $wp_version;
		if( 4.3 > $wp_version ) {
			$this->WP_Widget( 'penci_facebook_widget', esc_html__('.Soledad Facebook Page Box', 'soledad'), $widget_ops, $control_ops );
		} else {
			parent::__construct( 'penci_facebook_widget', esc_html__('.Soledad Facebook Page Box', 'soledad'), $widget_ops, $control_ops );
		}
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$page_url = $instance['page_url'];
		$height = $instance['height'];
		$faces = $instance['faces'];
		$stream = $instance['stream'];
		$title_page = $instance['title_page'];

		/* Before widget (defined by themes). */
		echo ent2ncr( $before_widget );

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title ) {
			echo ent2ncr( $before_title . $title . $after_title );
		}
		wp_enqueue_script( 'penci-facebook-js' );
		?>
			<div class="fb-page" data-href="<?php echo esc_url( $page_url ); ?>"<?php if( $stream && is_numeric( $height ) && $height > 69 ): ?> data-height="<?php echo absint( $height ); ?>"<?php endif;?> data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="<?php if($faces) { echo 'true'; } else { echo 'false'; } ?>" data-show-posts="<?php if($stream) { echo 'true'; } else { echo 'false'; } ?>"><div class="fb-xfbml-parse-ignore"><blockquote cite="<?php echo esc_attr( $page_url ); ?>"><a href="<?php echo esc_url( $page_url ); ?>"><?php if($title_page) { echo sanitize_text_field( $title_page ); } else { echo 'Facebook'; } ?></a></blockquote></div></div>
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
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['page_url'] = strip_tags( $new_instance['page_url'] );
		$instance['height'] = strip_tags( $new_instance['height'] );
		$instance['faces'] = strip_tags( $new_instance['faces'] );
		$instance['stream'] = strip_tags( $new_instance['stream'] );
		$instance['title_page'] = strip_tags( $new_instance['title_page'] );

		return $instance;
	}


	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Follow Me', 'title_page' => 'Facebook', 'faces' => 'on', 'page_url' => '', 'height' => '290', 'stream' => true);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e('Title:','soledad'); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo sanitize_text_field( $instance['title'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title_page' ) ); ?>"><?php esc_html_e('Facebook Page Title:','soledad'); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_page' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_page' ) ); ?>" value="<?php echo esc_attr( $instance['title_page'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'page_url' ) ); ?>"><?php esc_html_e('Facebook Page URL:','soledad'); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'page_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'page_url' ) ); ?>" placeholder="EG. http://www.facebook.com/demo" value="<?php echo esc_attr( $instance['page_url'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>"><?php esc_html_e('Facebook Page Height:','soledad'); ?></label>
			<small style="display: block; clear: both; padding-left: 0;" class="description"><?php esc_html_e('This option is only applied when "Show Stream" option is checked', 'soledad'); ?></small>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'height' ) ); ?>" placeholder="min is 70. EG: 400" value="<?php echo absint( $instance['height'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'faces' ) ); ?>"><?php esc_html_e('Show Faces:','soledad'); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'faces' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'faces' ) ); ?>" <?php checked( (bool) $instance['faces'], true ); ?> />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'stream' ) ); ?>"><?php esc_html_e('Show Stream:','soledad'); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'stream' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'stream' ) ); ?>" <?php checked( (bool) $instance['stream'], true ); ?> />
		</p>

	<?php
	}
}

?>