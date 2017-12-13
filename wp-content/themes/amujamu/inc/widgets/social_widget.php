<?php
/**
 * Socials Widget
 * Get in touch with your clients
 *
 * @package Wordpress
 * @since 1.0
 */

add_action( 'widgets_init', 'penci_social_load_widget' );

function penci_social_load_widget() {
	register_widget( 'penci_social_widget' );
}

class penci_social_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname'   => 'penci_social_widget', 'description' => esc_html__( 'A widget that displays your social icons', 'soledad' ) );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'penci_social_widget' );

		/* Create the widget. */
		global $wp_version;
		if( 4.3 > $wp_version ) {
			$this->WP_Widget( 'penci_social_widget', esc_html__( '.Soledad Social Media', 'soledad' ), $widget_ops, $control_ops );
		} else {
			parent::__construct( 'penci_social_widget', esc_html__( '.Soledad Social Media', 'soledad' ), $widget_ops, $control_ops );
		}
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title      = apply_filters( 'widget_title', $instance['title'] );
		$align      = isset( $instance['align'] ) ? $instance['align'] : '';
		$text       = $instance['text'];
		$circle     = isset( $instance['circle'] ) ? $instance['circle'] : false;
		$size_icon  = isset( $instance['size_icon'] ) ? $instance['size_icon'] : '14';
		$size_upper = isset( $instance['size_upper'] ) ? $instance['size_upper'] : false;
		$size_text  = isset( $instance['size_text'] ) ? $instance['size_text'] : '13';
		$facebook   = $instance['facebook'];
		$twitter    = $instance['twitter'];
		$googleplus = $instance['googleplus'];
		$instagram  = $instance['instagram'];
		$youtube    = $instance['youtube'];
		$tumblr     = $instance['tumblr'];
		$behance    = $instance['behance'];
		$linkedin   = $instance['linkedin'];
		$flickr     = $instance['flickr'];
		$pinterest  = $instance['pinterest'];
		$email      = $instance['email'];
		$vk         = $instance['vk'];
		$bloglovin  = isset( $instance['bloglovin'] ) ? $instance['bloglovin'] : '';
		$vine       = isset( $instance['vine'] ) ? $instance['vine'] : '';
		$soundcloud = isset( $instance['soundcloud'] ) ? $instance['soundcloud'] : '';
		$snapchat   = isset( $instance['snapchat'] ) ? $instance['snapchat'] : '';
		$spotify    = isset( $instance['spotify'] ) ? $instance['spotify'] : '';
		$github     = isset( $instance['github'] ) ? $instance['github'] : '';
		$stack      = isset( $instance['stack'] ) ? $instance['stack'] : '';
		$twitch     = isset( $instance['twitch'] ) ? $instance['twitch'] : '';
		$vimeo      = isset( $instance['vimeo'] ) ? $instance['vimeo'] : '';
		$steam      = isset( $instance['steam'] ) ? $instance['steam'] : '';
		$rss        = $instance['rss'];

		/* Before widget (defined by themes). */
		echo ent2ncr( $before_widget );

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo ent2ncr( $before_title . $title . $after_title );

			$style_icon = 'style="font-size: '. $size_icon .'px"';
			$style_text = 'style="font-size: '. $size_text .'px"';
		?>

		<div class="widget-social<?php if( $align ): echo ' '. $align; endif; ?><?php if( $text ): echo ' show-text'; endif; ?><?php if( $circle ): echo ' remove-circle'; endif; ?><?php if( $size_upper ): echo ' remove-uppercase-text'; endif; ?>">
			<?php if ( $facebook ) : ?>
				<a href="<?php echo esc_attr( get_theme_mod( 'penci_facebook' ) ); ?>" target="_blank"><i class="fa fa-facebook" <?php echo $style_icon; ?>></i><span <?php echo $style_text; ?>><?php esc_html_e( 'Facebook', 'soledad' ); ?></span></a>
			<?php endif; ?>

			<?php if ( $twitter ) : ?>
				<a href="<?php echo esc_attr( get_theme_mod( 'penci_twitter' ) ); ?>" target="_blank"><i class="fa fa-twitter" <?php echo $style_icon; ?>></i><span <?php echo $style_text; ?>><?php esc_html_e( 'Twitter', 'soledad' ); ?></span></a>
			<?php endif; ?>

			<?php if ( $googleplus ) : ?>
				<a href="<?php echo esc_attr( get_theme_mod( 'penci_google' ) ); ?>" target="_blank"><i class="fa fa-google-plus" <?php echo $style_icon; ?>></i><span <?php echo $style_text; ?>><?php esc_html_e( 'Google +', 'soledad' ); ?></span></a>
			<?php endif; ?>

			<?php if ( $instagram ) : ?>
				<a href="<?php echo esc_attr( get_theme_mod( 'penci_instagram' ) ); ?>" target="_blank"><i class="fa fa-instagram" <?php echo $style_icon; ?>></i><span <?php echo $style_text; ?>><?php esc_html_e( 'Instagram', 'soledad' ); ?></span></a>
			<?php endif; ?>

			<?php if ( $pinterest ) : ?>
				<a href="<?php echo esc_attr( get_theme_mod( 'penci_pinterest' ) ); ?>" target="_blank"><i class="fa fa-pinterest" <?php echo $style_icon; ?>></i><span <?php echo $style_text; ?>><?php esc_html_e( 'Pinterest', 'soledad' ); ?></span></a>
			<?php endif; ?>

			<?php if ( $linkedin ) : ?>
				<a href="<?php echo esc_url( get_theme_mod( 'penci_linkedin' ) ); ?>" target="_blank"><i class="fa fa-linkedin" <?php echo $style_icon; ?>></i><span <?php echo $style_text; ?>><?php esc_html_e( 'Linkedin', 'soledad' ); ?></span></a>
			<?php endif; ?>

			<?php if ( $flickr ) : ?>
				<a href="<?php echo esc_attr( get_theme_mod( 'penci_flickr' ) ); ?>" target="_blank"><i class="fa fa-flickr" <?php echo $style_icon; ?>></i><span <?php echo $style_text; ?>><?php esc_html_e( 'Flickr', 'soledad' ); ?></span></a>
			<?php endif; ?>

			<?php if ( $behance ) : ?>
				<a href="<?php echo esc_attr( get_theme_mod( 'penci_behance' ) ); ?>" target="_blank"><i class="fa fa-behance" <?php echo $style_icon; ?>></i><span <?php echo $style_text; ?>><?php esc_html_e( 'Behance', 'soledad' ); ?></span></a>
			<?php endif; ?>

			<?php if ( $tumblr ) : ?>
				<a href="<?php echo esc_attr( get_theme_mod( 'penci_tumblr' ) ); ?>" target="_blank"><i class="fa fa-tumblr" <?php echo $style_icon; ?>></i><span <?php echo $style_text; ?>><?php esc_html_e( 'Tumblr', 'soledad' ); ?></span></a>
			<?php endif; ?>

			<?php if ( $youtube ) : ?>
				<a href="<?php echo esc_attr( get_theme_mod( 'penci_youtube' ) ); ?>" target="_blank"><i class="fa fa-youtube-play" <?php echo $style_icon; ?>></i><span <?php echo $style_text; ?>><?php esc_html_e( 'Youtube', 'soledad' ); ?></span></a>
			<?php endif; ?>

			<?php if ( $email ) : ?>
				<a href="<?php echo get_theme_mod( 'penci_email_me' ); ?>"><i class="fa fa-envelope-o" <?php echo $style_icon; ?>></i><span <?php echo $style_text; ?>><?php esc_html_e( 'Email', 'soledad' ); ?></span></a>
			<?php endif; ?>

			<?php if ( $vk ) : ?>
				<a href="<?php echo esc_attr( get_theme_mod( 'penci_vk' ) ); ?>" target="_blank"><i class="fa fa-vk" <?php echo $style_icon; ?>></i><span <?php echo $style_text; ?>><?php esc_html_e( 'Vk', 'soledad' ); ?></span></a>
			<?php endif; ?>

			<?php if ( $bloglovin ) : ?>
				<a href="<?php echo esc_attr( get_theme_mod( 'penci_bloglovin' ) ); ?>" target="_blank"><i class="fa fa-heart" <?php echo $style_icon; ?>></i><span <?php echo $style_text; ?>><?php esc_html_e( 'Bloglovin', 'soledad' ); ?></span></a>
			<?php endif; ?>

			<?php if ( $vine ) : ?>
				<a href="<?php echo esc_attr( get_theme_mod( 'penci_vine' ) ); ?>" target="_blank"><i class="fa fa-vine" <?php echo $style_icon; ?>></i><span <?php echo $style_text; ?>><?php esc_html_e( 'Vine', 'soledad' ); ?></span></a>
			<?php endif; ?>

			<?php if ( $soundcloud ) : ?>
				<a href="<?php echo esc_attr( get_theme_mod( 'penci_soundcloud' ) ); ?>" target="_blank"><i class="fa fa-soundcloud" <?php echo $style_icon; ?>></i><span <?php echo $style_text; ?>><?php esc_html_e( 'Soundcloud', 'soledad' ); ?></span></a>
			<?php endif; ?>

			<?php if ( $snapchat ) : ?>
				<a href="<?php echo esc_attr( get_theme_mod( 'penci_snapchat' ) ); ?>" target="_blank"><i class="fa fa-snapchat-ghost" <?php echo $style_icon; ?>></i><span <?php echo $style_text; ?>><?php esc_html_e( 'Snapchat', 'soledad' ); ?></span></a>
			<?php endif; ?>

			<?php if ( $spotify ) : ?>
				<a href="<?php echo esc_attr( get_theme_mod( 'penci_spotify' ) ); ?>" target="_blank"><i class="fa fa-spotify" <?php echo $style_icon; ?>></i><span <?php echo $style_text; ?>><?php esc_html_e( 'Spotify', 'soledad' ); ?></span></a>
			<?php endif; ?>

			<?php if ( $github ) : ?>
				<a href="<?php echo esc_attr( get_theme_mod( 'penci_github' ) ); ?>" target="_blank"><i class="fa fa-github" <?php echo $style_icon; ?>></i><span <?php echo $style_text; ?>><?php esc_html_e( 'Github', 'soledad' ); ?></span></a>
			<?php endif; ?>

			<?php if ( $stack ) : ?>
				<a href="<?php echo esc_attr( get_theme_mod( 'penci_stack' ) ); ?>" target="_blank"><i class="fa fa-stack-overflow" <?php echo $style_icon; ?>></i><span <?php echo $style_text; ?>><?php esc_html_e( 'Stack-Overflow', 'soledad' ); ?></span></a>
			<?php endif; ?>

			<?php if ( $twitch ) : ?>
				<a href="<?php echo esc_attr( get_theme_mod( 'penci_twitch' ) ); ?>" target="_blank"><i class="fa fa-twitch" <?php echo $style_icon; ?>></i><span <?php echo $style_text; ?>><?php esc_html_e( 'Twitch', 'soledad' ); ?></span></a>
			<?php endif; ?>

			<?php if ( $vimeo ) : ?>
				<a href="<?php echo esc_attr( get_theme_mod( 'penci_vimeo' ) ); ?>" target="_blank"><i class="fa fa-vimeo" <?php echo $style_icon; ?>></i><span <?php echo $style_text; ?>><?php esc_html_e( 'Vimeo', 'soledad' ); ?></span></a>
			<?php endif; ?>

			<?php if ( $steam ) : ?>
				<a href="<?php echo esc_attr( get_theme_mod( 'penci_steam' ) ); ?>" target="_blank"><i class="fa fa-steam" <?php echo $style_icon; ?>></i><span <?php echo $style_text; ?>><?php esc_html_e( 'Steam', 'soledad' ); ?></span></a>
			<?php endif; ?>

			<?php if ( $rss ) : ?>
				<a href="<?php echo esc_url( get_theme_mod( 'penci_rss' ) ); ?>" target="_blank"><i class="fa fa-rss" <?php echo $style_icon; ?>></i><span <?php echo $style_text; ?>><?php esc_html_e( 'RSS', 'soledad' ); ?></span></a>
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
		$instance['title']      = strip_tags( $new_instance['title'] );
		$instance['text']       = strip_tags( $new_instance['text'] );
		$instance['align']      = strip_tags( $new_instance['align'] );
		$instance['circle']     = strip_tags( $new_instance['circle'] );
		$instance['size_icon']  = strip_tags( $new_instance['size_icon'] );
		$instance['size_upper'] = strip_tags( $new_instance['size_upper'] );
		$instance['size_text']  = strip_tags( $new_instance['size_text'] );
		$instance['facebook']   = strip_tags( $new_instance['facebook'] );
		$instance['twitter']    = strip_tags( $new_instance['twitter'] );
		$instance['googleplus'] = strip_tags( $new_instance['googleplus'] );
		$instance['instagram']  = strip_tags( $new_instance['instagram'] );
		$instance['linkedin']   = strip_tags( $new_instance['linkedin'] );
		$instance['flickr']     = strip_tags( $new_instance['flickr'] );
		$instance['behance']    = strip_tags( $new_instance['behance'] );
		$instance['youtube']    = strip_tags( $new_instance['youtube'] );
		$instance['tumblr']     = strip_tags( $new_instance['tumblr'] );
		$instance['pinterest']  = strip_tags( $new_instance['pinterest'] );
		$instance['email']      = strip_tags( $new_instance['email'] );
		$instance['vk']         = strip_tags( $new_instance['vk'] );
		$instance['bloglovin']  = strip_tags( $new_instance['bloglovin'] );
		$instance['vine']       = strip_tags( $new_instance['vine'] );
		$instance['soundcloud'] = strip_tags( $new_instance['soundcloud'] );
		$instance['snapchat']   = strip_tags( $new_instance['snapchat'] );
		$instance['spotify']    = strip_tags( $new_instance['spotify'] );
		$instance['github']     = strip_tags( $new_instance['github'] );
		$instance['stack']      = strip_tags( $new_instance['stack'] );
		$instance['twitch']     = strip_tags( $new_instance['twitch'] );
		$instance['vimeo']      = strip_tags( $new_instance['vimeo'] );
		$instance['steam']      = strip_tags( $new_instance['steam'] );
		$instance['rss']        = strip_tags( $new_instance['rss'] );

		return $instance;
	}


	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
			'title'      => 'Keep in touch',
			'text'       => false,
			'align'      => '',
			'circle'     => false,
			'size_icon'  => '14',
			'size_upper' => false,
			'size_text'  => '13',
			'facebook'   => 'on',
			'twitter'    => 'on',
			'googleplus' => 'on',
			'instagram'  => 'on',
			'linkedin'   => '',
			'behance'    => '',
			'flickr'     => '',
			'youtube'    => '',
			'tumblr'     => '',
			'pinterest'  => 'on',
			'email'      => '',
			'vk'         => '',
			'bloglovin'  => '',
			'vine'       => '',
			'soundcloud' => '',
			'snapchat'   => '',
			'spotify'    => '',
			'github'     => '',
			'stack'      => '',
			'twitch'     => '',
			'vimeo'      => '',
			'steam'      => '',
			'rss'        => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e('Title:','soledad'); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo sanitize_text_field( $instance['title'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php esc_html_e('Display Social Text on Right Icons?:','soledad'); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" <?php checked( (bool) $instance['text'], true ); ?> />
		</p>

		<!-- Align -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('align') ); ?>">Align This Widget:</label>
			<select id="<?php echo esc_attr( $this->get_field_id('align') ); ?>" name="<?php echo esc_attr( $this->get_field_name('align') ); ?>" class="widefat categories" style="width:100%;">
				<option value='pc_aligncenter' <?php if ('' == $instance['align']) echo 'selected="selected"'; ?>>Align Center</option>
				<option value='pc_alignleft' <?php if ('pc_alignleft' == $instance['align']) echo 'selected="selected"'; ?>>Align Left</option>
				<option value='pc_alignright' <?php if ('pc_alignright' == $instance['align']) echo 'selected="selected"'; ?>>Align Right</option>
			</select>
			<small>This option only apply when you hide text on the right side of social icons.</small>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'circle' ) ); ?>"><?php esc_html_e('Remove Circle Around Icons?:','soledad'); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'circle' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'circle' ) ); ?>" <?php checked( (bool) $instance['circle'], true ); ?> />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'size_icon' ) ); ?>"><?php esc_html_e('Custom Font Size for Icons:', 'soledad'); ?></label>
			<input  type="number" style="width: 50px;" id="<?php echo esc_attr( $this->get_field_id( 'size_icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'size_icon' ) ); ?>" value="<?php echo esc_attr( $instance['size_icon'] ); ?>" size="3" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'size_upper' ) ); ?>"><?php esc_html_e('Disable Uppercase Text on Right Icons?:','soledad'); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'size_upper' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'size_upper' ) ); ?>" <?php checked( (bool) $instance['size_upper'], true ); ?> />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'size_text' ) ); ?>"><?php esc_html_e('Custom Font Size for Text on Right Icons:', 'soledad'); ?></label>
			<input  type="number" style="width: 50px;" id="<?php echo esc_attr( $this->get_field_id( 'size_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'size_text' ) ); ?>" value="<?php echo esc_attr( $instance['size_text'] ); ?>" size="3" />
		</p>

		<p class="description"><?php esc_html_e('Note: Setup your social links in the Appearance -> Customizer','soledad'); ?></p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'facebook' ) ); ?>"><?php esc_html_e('Show Facebook:','soledad'); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'facebook' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'facebook' ) ); ?>" <?php checked( (bool) $instance['facebook'], true ); ?> />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'twitter' ) ); ?>"><?php esc_html_e('Show Twitter:','soledad'); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'twitter' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'twitter' ) ); ?>" <?php checked( (bool) $instance['twitter'], true ); ?> />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'instagram' ) ); ?>"><?php esc_html_e('Show Instagram:','soledad'); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'instagram' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'instagram' ) ); ?>" <?php checked( (bool) $instance['instagram'], true ); ?> />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'pinterest' ) ); ?>"><?php esc_html_e('Show Pinterest:','soledad'); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'pinterest' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'pinterest' ) ); ?>" <?php checked( (bool) $instance['pinterest'], true ); ?> />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'googleplus' ) ); ?>"><?php esc_html_e('Show Google Plus:','soledad'); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'googleplus' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'googleplus' ) ); ?>" <?php checked( (bool) $instance['googleplus'], true ); ?> />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'linkedin' ) ); ?>"><?php esc_html_e('Show Likedin:','soledad'); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'linkedin' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'linkedin' ) ); ?>" <?php checked( (bool) $instance['linkedin'], true ); ?> />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'behance' ) ); ?>"><?php esc_html_e('Show Behance:','soledad'); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'behance' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'behance' ) ); ?>" <?php checked( (bool) $instance['behance'], true ); ?> />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'flickr' ) ); ?>"><?php esc_html_e('Show Flickr:','soledad'); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'flickr' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'flickr' ) ); ?>" <?php checked( (bool) $instance['flickr'], true ); ?> />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'tumblr' ) ); ?>"><?php esc_html_e('Show Tumblr:','soledad'); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'tumblr' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tumblr' ) ); ?>" <?php checked( (bool) $instance['tumblr'], true ); ?> />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'youtube' ) ); ?>"><?php esc_html_e('Show Youtube:','soledad'); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'youtube' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'youtube' ) ); ?>" <?php checked( (bool) $instance['youtube'], true ); ?> />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>"><?php esc_html_e('Show Email:','soledad'); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'email' ) ); ?>" <?php checked( (bool) $instance['email'], true ); ?> />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'vk' ) ); ?>"><?php esc_html_e('Show Vk:','soledad'); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'vk' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'vk' ) ); ?>" <?php checked( (bool) $instance['vk'], true ); ?> />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'bloglovin' ) ); ?>"><?php esc_html_e('Show Bloglovin:','soledad'); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'bloglovin' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'bloglovin' ) ); ?>" <?php checked( (bool) $instance['bloglovin'], true ); ?> />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'vine' ) ); ?>"><?php esc_html_e('Show Vine:','soledad'); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'vine' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'vine' ) ); ?>" <?php checked( (bool) $instance['vine'], true ); ?> />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'soundcloud' ) ); ?>"><?php esc_html_e('Show Soundcloud:','soledad'); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'soundcloud' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'soundcloud' ) ); ?>" <?php checked( (bool) $instance['soundcloud'], true ); ?> />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'snapchat' ) ); ?>"><?php esc_html_e('Show Snapchat:','soledad'); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'snapchat' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'snapchat' ) ); ?>" <?php checked( (bool) $instance['snapchat'], true ); ?> />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'spotify' ) ); ?>"><?php esc_html_e('Show Spotify:','soledad'); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'spotify' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'spotify' ) ); ?>" <?php checked( (bool) $instance['spotify'], true ); ?> />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'github' ) ); ?>"><?php esc_html_e('Show Github:','soledad'); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'github' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'github' ) ); ?>" <?php checked( (bool) $instance['github'], true ); ?> />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'stack' ) ); ?>"><?php esc_html_e('Show Stack Overflow:','soledad'); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'stack' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'stack' ) ); ?>" <?php checked( (bool) $instance['stack'], true ); ?> />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'twitch' ) ); ?>"><?php esc_html_e('Show Twitch:','soledad'); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'twitch' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'twitch' ) ); ?>" <?php checked( (bool) $instance['twitch'], true ); ?> />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'vimeo' ) ); ?>"><?php esc_html_e('Show Vimeo:','soledad'); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'vimeo' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'vimeo' ) ); ?>" <?php checked( (bool) $instance['vimeo'], true ); ?> />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'steam' ) ); ?>"><?php esc_html_e('Show Steam:','soledad'); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'steam' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'steam' ) ); ?>" <?php checked( (bool) $instance['steam'], true ); ?> />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'rss' ) ); ?>"><?php esc_html_e('Show RSS:','soledad'); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'rss' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'rss' ) ); ?>" <?php checked( (bool) $instance['rss'], true ); ?> />
		</p>


	<?php
	}
}

?>