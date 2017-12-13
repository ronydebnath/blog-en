<?php
/**
 * Post slider widget
 * Display recent post or popular post for each category or all posts
 *
 * @package Wordpress
 * @since 1.0
 */

add_action( 'widgets_init', 'penci_slider_posts_news_load_widget' );

function penci_slider_posts_news_load_widget() {
	register_widget( 'penci_slider_posts_news_widget' );
}

class penci_slider_posts_news_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'penci_slider_posts_news_widget', 'description' => esc_html__('A widget that displays your latest/popular posts from all categories or a category with a slider', 'soledad') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'penci_slider_posts_news_widget' );

		/* Create the widget. */
		global $wp_version;
		if( 4.3 > $wp_version ) {
			$this->WP_Widget( 'penci_slider_posts_news_widget', esc_html__('.Soledad Posts Slider', 'soledad'), $widget_ops, $control_ops );
		} else {
			parent::__construct( 'penci_slider_posts_news_widget', esc_html__('.Soledad Posts Slider', 'soledad'), $widget_ops, $control_ops );
		}
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title      = apply_filters( 'widget_title', $instance['title'] );
		$categories = isset( $instance['categories'] ) ? $instance['categories'] : '';
		$number     = isset( $instance['number'] ) ? $instance['number'] : 5;
		$type       = isset( $instance['type'] ) ? $instance['type'] : 'latest';
		$style      = isset( $instance['style'] ) ? $instance['style'] : 'style-1';
		$date       = isset( $instance['date'] ) ? $instance['date'] : false;


		$query = array( 'posts_per_page' => $number,
			'post_type'      => 'post',
			'cat'            => $categories
		);

		if ( $type == 'popular' ) {
			$query['meta_key'] = 'penci_post_views_count';
			$query['orderby']  = 'meta_value_num';
			$query['order']    = 'DESC';
		}

		$loop = new WP_Query($query);
		if ($loop->have_posts()) :

			/* Before widget (defined by themes). */
			echo ent2ncr( $before_widget );

			/* Display the widget title if one was input (before and after defined by themes). */
			if ( $title )
				echo ent2ncr( $before_title . $title . $after_title );

			?>
			<div class="penci-owl-carousel penci-owl-carousel-slider penci-widget-slider penci-post-slider-<?php echo $style; ?>" data-lazy="true">
				<?php while ($loop->have_posts()) : $loop->the_post(); ?>
					<div class="penci-slide-widget">
						<div class="penci-slide-content">
							<?php if( $style != 'style-3' ) {?>
								<?php if( ! get_theme_mod( 'penci_disable_lazyload_layout' ) ) { ?>
								<span class="penci-image-holder owl-lazy" data-src="<?php echo penci_get_featured_image_size( get_the_ID(), 'penci-thumb' ); ?>" title="<?php echo wp_strip_all_tags( get_the_title() ); ?>"></span>
								<?php } else { ?>
								<span class="penci-image-holder" style="background-image: url('<?php echo penci_get_featured_image_size( get_the_ID(), 'penci-thumb' ); ?>');" title="<?php echo wp_strip_all_tags( get_the_title() ); ?>"></span>
								<?php } ?>
								<a href="<?php the_permalink() ?>" class="penci-widget-slider-overlay" title="<?php the_title(); ?>"></a>
							<?php } else { ?>
								<?php if( ! get_theme_mod( 'penci_disable_lazyload_layout' ) ) { ?>
								<a href="<?php the_permalink() ?>" class="penci-image-holder penci-lazy" data-src="<?php echo penci_get_featured_image_size( get_the_ID(), 'penci-thumb' ); ?>" title="<?php echo wp_strip_all_tags( get_the_title() ); ?>"></a>
								<?php } else { ?>
								<a href="<?php the_permalink() ?>" class="penci-image-holder" style="background-image: url('<?php echo penci_get_featured_image_size( get_the_ID(), 'penci-thumb' ); ?>')" title="<?php echo wp_strip_all_tags( get_the_title() ); ?>"></a>
								<?php } ?>
							<?php } ?>
							<div class="penci-widget-slide-detail">
								<h4>
									<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php echo sanitize_text_field( wp_trim_words( get_the_title(), 8, '...') ); ?></a>
								</h4>
								<?php if ( ! $date ): ?>
									<?php
									$date_format = get_option('date_format');
									$date_format = str_replace( array( 'm', 'n', 'F' ), array( 'M', 'M', 'M' ), $date_format );
									?>
									<span class="slide-item-date"><?php the_time( $date_format ); ?></span>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
			</div>

		<?php
		endif;
		wp_reset_postdata();

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
		$instance['categories'] = $new_instance['categories'];
		$instance['style'] = $new_instance['style'];
		$instance['number'] = strip_tags( $new_instance['number'] );
		$instance['type'] = strip_tags( $new_instance['type'] );
		$instance['date'] = strip_tags( $new_instance['date'] );

		return $instance;
	}


	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => esc_html__('Posts Slider', 'soledad'), 'number' => 5, 'type' => 'latest', 'categories' => '', 'date' => false, 'style' => 'style-1' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e('Title:', 'soledad'); ?></label>
			<input  type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo sanitize_text_field( $instance['title'] ); ?>"  />
		</p>

		<!-- Type -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('type') ); ?>">Slider Data Type</label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'type' ) ); ?>" class="widefat categories" style="width:100%;">
				<option value='latest' <?php if ( 'latest' == $instance['type'] ): echo 'selected="selected"'; endif; ?>><?php esc_html_e( 'Latest Posts', 'soledad' ); ?></option>
				<option value='popular' <?php if ( 'popular' == $instance['type'] ): echo 'selected="selected"'; endif; ?>><?php esc_html_e( 'Popular Posts in All Time', 'soledad' ); ?></option>
			</select>
		</p>

		<!-- Style -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('style') ); ?>">Select Style for This Slider</label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'style' ) ); ?>" class="widefat categories" style="width:100%;">
				<option value='style-1' <?php if ( 'style-1' == $instance['style'] ): echo 'selected="selected"'; endif; ?>>Style 1</option>
				<option value='style-2' <?php if ( 'style-2' == $instance['style'] ): echo 'selected="selected"'; endif; ?>>Style 2</option>
				<option value='style-3' <?php if ( 'style-3' == $instance['style'] ): echo 'selected="selected"'; endif; ?>>Style 3</option>
			</select>
		</p>

		<!-- Category -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('categories') ); ?>"><?php esc_html_e('Filter by Category:', 'soledad'); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id('categories') ); ?>" name="<?php echo esc_attr( $this->get_field_name('categories') ); ?>" class="widefat categories" style="width:100%;">
				<option value='all' <?php if ('all' == $instance['categories']) echo 'selected="selected"'; ?>><?php esc_html_e('All categories', 'soledad'); ?></option>
				<?php $categories = get_categories('hide_empty=0&depth=1&type=post'); ?>
				<?php foreach($categories as $category) { ?>
					<option value='<?php echo esc_attr( $category->term_id ); ?>' <?php if ($category->term_id == $instance['categories']) echo 'selected="selected"'; ?>><?php echo sanitize_text_field( $category->cat_name ); ?></option>
				<?php } ?>
			</select>
		</p>

		<!-- Number of posts -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e('Number of posts to show:', 'soledad'); ?></label>
			<input  type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" value="<?php echo esc_attr( $instance['number'] ); ?>" size="3" />
		</p>

		<!-- Display post date -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'date' ) ); ?>"><?php esc_html_e('Hide post date?:','soledad'); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'date' ) ); ?>" <?php checked( (bool) $instance['date'], true ); ?> />
		</p>

	<?php
	}
}
?>