<?php
/**
 * Top bar template
 * Options for it in Customize > Top Bar Options & Colors For Top Bar
 *
 * @since 1.0
 */
?>
<div class="penci-top-bar<?php if( get_theme_mod( 'penci_top_bar_hide_social' ) ): echo ' no-social'; endif; if( get_theme_mod( 'penci_top_bar_enable_menu' ) ): echo ' topbar-menu'; endif; if( get_theme_mod( 'penci_top_bar_full_width' ) ): echo ' topbar-fullwidth'; endif; ?>">
	<div class="container">
		<div class="penci-headline">
			<?php
			if( get_theme_mod( 'penci_top_bar_enable_menu' ) ):
				/**
				 * Display topbar menu
				 */
				wp_nav_menu( array(
					'container'      => false,
					'theme_location' => 'topbar-menu',
					'menu_class'     => 'penci-topbar-menu',
					'fallback_cb'    => 'wp_page_menu',
					'walker'         => ''
				) );
			endif; /* End check if topbar is enable */
			?>
			<?php if( penci_get_setting( 'penci_top_bar_custom_text' ) && ! get_theme_mod( 'penci_top_bar_enable_menu' ) ) { ?>
				<span class="headline-title"><?php echo penci_get_setting( 'penci_top_bar_custom_text' ); ?></span>
			<?php } ?>
			<?php if( ! get_theme_mod( 'penci_top_bar_hide_social' ) ): ?>
				<div class="penci-topbar-social">
					<?php include( trailingslashit( get_template_directory() ). 'inc/modules/socials.php' ); ?>
				</div>
			<?php endif; ?>
			<?php
			if( ! get_theme_mod( 'penci_top_bar_enable_menu' ) ):
				/**
				 * Display headline slider
				 */
				$number_posts = get_theme_mod( 'penci_top_bar_posts_per_page' ) ? get_theme_mod( 'penci_top_bar_posts_per_page' ) : 10;
				$topbar_cat = get_theme_mod( 'penci_top_bar_category' );
				$args = array(
					'post_type'	=> 'post',
					'showposts'	=>	$number_posts
				);
				if( $topbar_cat ) {
					$args['cat'] = $topbar_cat;
				}
				$news = new WP_Query( $args );
				if( $news->have_posts() ):
					$auto_play = 'true';
					if( get_theme_mod( 'penci_top_bar_posts_autoplay' ) ): $auto_play = 'false'; endif;
					$auto_time = get_theme_mod( 'penci_top_bar_auto_time' );
					$auto_speed = get_theme_mod( 'penci_top_bar_auto_speed' );
					$auto_time = ( is_numeric( $auto_time ) && $auto_time > 0 ) ? $auto_time : '3000';
					$auto_speed = ( is_numeric( $auto_speed ) && $auto_speed > 0 ) ? $auto_speed : '200';
				?>
					<div class="penci-owl-carousel penci-owl-carousel-slider penci-headline-posts" data-auto="<?php echo $auto_play; ?>" data-autotime="<?php echo absint( $auto_time ); ?>" data-speed="<?php echo absint( $auto_speed ); ?>">
						<?php while( $news->have_posts() ): $news->the_post();
							$title_full = get_the_title();
						?>
							<div>
								<a class="penci-topbar-post-title" href="<?php the_permalink(); ?>"><?php echo sanitize_text_field( wp_trim_words( get_the_title(), 8, '...' ) ); ?></a>
							</div>
						<?php endwhile; wp_reset_postdata(); ?>
					</div>
				<?php endif; /* End check if no posts */?>
			<?php endif; /* End check if topbar menu is enable */?>
		</div>
	</div>
</div>