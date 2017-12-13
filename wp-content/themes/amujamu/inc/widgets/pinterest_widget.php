<?php
/**
 * Main class for render pinterest pinboard
 * Render HTML in your sidebar on front-end
 *
 * @since 1.0
 */

if ( ! class_exists( 'Penci_Pinterest' ) ):

	class Penci_Pinterest {

		// Pinterest url
		var $pinterest_feed = 'https://pinterest.com/%s/feed.rss';

		var $start_time;

		function __construct() {
			$this->start_time = microtime( true );
		}

		// Render the pinboard and output
		function render_html( $username, $numbers, $cache_time = 1200, $follow = true ) {
			$pins = $this->get_pins( $username, $numbers, $cache_time );
			if ( is_null( $pins ) ) {
				echo( "Unable to load Pinterest pins for '$username'\n" );
			}
			else {
				echo '<div class="penci-images-pin-widget">';
				foreach ( $pins as $pin ) {
					$title = $pin['title'];
					$url   = $pin['url'];
					$image = $pin['image'];

					echo '<a href="' . esc_url( $url ) . '" title="' . esc_attr( $title ) . '" target="_blank" alt="' . esc_attr( $title ) . '"><span class="penci-image-holder rectangle-fix-size penci-lazy" data-src="' . esc_url( $image ) . '"></span></a>';
				}
			}
			?>
			</div>
			<?php if ( $follow ): ?>
				<div class="pin_link">
					<a href="http://pinterest.com/<?php echo sanitize_text_field( $username ); ?>/" target="_blank">@<?php echo sanitize_text_field( $username ); ?></a>
				</div>
			<?php endif; ?>
		<?php
		}

		/**
		 * Retrieve RSS feed for username, and parse the data needed.
		 * Returns null if error, otherwise a has of pins.
		 * Callback it on render_html functions
		 *
		 * @since 1.0
		 */
		function get_pins( $username, $numbers, $cache_time = 1200 ) {

			if( !is_numeric( $cache_time ) && $cache_time < 1 ): $cache_time = 1200; endif;
			// Set caching.
			add_filter( 'wp_feed_cache_transient_lifetime', create_function( '$a', 'return ' . $cache_time . ';' ) );

			// Get the RSS feed.
			$url = sprintf( $this->pinterest_feed, $username );
			$rss = fetch_feed( $url );
			if ( is_wp_error( $rss ) ) {
				return null;
			}

			$maxitems  = $rss->get_item_quantity( $numbers );
			$rss_items = $rss->get_items( 0, $maxitems );

			$pins;
			if ( is_null( $rss_items ) ) {
				$pins = null;
			}
			else {

				// Build patterns to search/replace in the image urls
				$search  = array( '_b.jpg' );
				$replace = array( '_t.jpg' );

				// Make url protocol relative
				array_push( $search, 'https://' );
				array_push( $replace, '//' );

				$pins = array();
				foreach ( $rss_items as $item ) {
					$title       = $item->get_title();
					$description = $item->get_description();
					$url         = $item->get_permalink();
					if ( preg_match_all( '/<img src="([^"]*)".*>/i', $description, $matches ) ) {
						$image = str_replace( $search, $replace, $matches[1][0] );
					}
					array_push( $pins, array(
						'title' => $title,
						'image' => $image,
						'url'   => $url
					) );
				}
			}

			return $pins;
		}
	}

endif; /* End check if class exists */


/**
 * Create a pinterest widget on sidebar
 *
 * @since 1.0
 */

add_action( 'widgets_init', 'penci_register_pinterest_widget' );

function penci_register_pinterest_widget() {
	register_widget( 'Penci_Pinterest_Widget' );
}

class Penci_Pinterest_Widget extends WP_Widget {

	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname'   => 'penci_pinterest_widget',
							 'description' => esc_html__( 'A widget that display pinterest widget.', 'soledad' )
		);

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'penci_pinterest_widget' );

		/* Create the widget. */
		global $wp_version;
		if ( 4.3 > $wp_version ) {
			$this->WP_Widget( 'penci_pinterest_widget', esc_html__( '.Soledad Pinterest Widget', 'soledad' ), $widget_ops, $control_ops );
		}
		else {
			parent::__construct( 'penci_pinterest_widget', esc_html__( '.Soledad Pinterest Widget', 'soledad' ), $widget_ops, $control_ops );
		}
	}

	function widget( $args, $instance ) {
		extract( $args );

		echo ent2ncr( $before_widget );
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo ent2ncr( $before_title . $title . $after_title );

		echo '<div class="penci-pinterest-widget-container">';

		// Render the pinboard from the widget settings.
		$username = $instance['username'];
		$numbers  = $instance['numbers'];
		$follow   = $instance['follow'];
		$cache    = $instance['cache'];

		$pinboard = new Penci_Pinterest();
		$pinboard->render_html( $username, $numbers, $cache, $follow );

		echo '</div>';

		echo ent2ncr( $after_widget );
	}

	function update( $new_instance, $old_instance ) {
		$instance             = $old_instance;
		$instance['title']    = strip_tags( $new_instance['title'] );
		$instance['username'] = strip_tags( $new_instance['username'] );
		$instance['numbers']  = absint( $new_instance['numbers'] );
		$instance['follow']   = $new_instance['follow'];
		$instance['cache']    = $new_instance['cache'];

		return $instance;
	}

	function form( $instance ) {
		// load current values or set to default.
		$defaults = array( 'title' => 'On Pinterest', 'username' => 'username', 'numbers' => '9', 'cache' => '1200', 'follow' => true );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'soledad' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo sanitize_text_field( $instance['title'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>"><?php esc_html_e( 'Your pinterest username:', 'soledad' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'username' ) ); ?>" type="text" value="<?php echo sanitize_text_field( $instance['username'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'numbers' ) ); ?>"><?php esc_html_e( 'Numbers image to show:', 'soledad' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'numbers' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'numbers' ) ); ?>" type="number" value="<?php echo absint( $instance['numbers'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'cache' ) ); ?>"><?php esc_html_e( 'Cache life time ( unit is seconds ):', 'soledad' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cache' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cache' ) ); ?>" type="number" value="<?php echo absint( $instance['cache'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'follow' ) ); ?>"><?php esc_html_e( 'Display more link with username text?:', 'soledad' ); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'follow' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'follow' ) ); ?>" <?php checked( (bool) $instance['follow'], true ); ?> />
		</p>
	<?php
	}
}