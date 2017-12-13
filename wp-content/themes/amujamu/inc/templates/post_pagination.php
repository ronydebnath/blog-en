<?php
/**
 * Post navigation in single post
 * Create next and prev button to next and prev posts
 *
 * @package Wordpress
 * @since 1.0
 */
?>
<div class="post-pagination">
	<?php
	$prev_post = get_previous_post();
	$next_post = get_next_post();
	?>
	<?php if ( ! empty( $prev_post ) ) : ?>
		<div class="prev-post">
			<?php if( has_post_thumbnail( $prev_post->ID ) && get_theme_mod( 'penci_post_nav_thumbnail' ) ): ?>
				<?php if( ! get_theme_mod( 'penci_disable_lazyload_single' ) ) { ?>
					<a class="penci-post-nav-thumb penci-holder-load penci-lazy" href="<?php echo esc_url( get_the_permalink( $prev_post->ID ) ); ?>" data-src="<?php echo penci_get_featured_image_size( $prev_post->ID, 'thumbnail' ); ?>">
					</a>
				<?php } else { ?>
					<a class="penci-post-nav-thumb" href="<?php echo esc_url( get_the_permalink( $prev_post->ID ) ); ?>" style="background-image: url('<?php echo penci_get_featured_image_size( $prev_post->ID, 'thumbnail' ); ?>');">
					</a>
				<?php }?>
			<?php endif; ?>
			<div class="prev-post-inner">
				<div class="prev-post-title">
					<span><?php echo penci_get_setting( 'penci_trans_previous_post' ); ?></span>
				</div>
				<a href="<?php echo esc_url( get_the_permalink( $prev_post->ID ) ); ?>">
					<div class="pagi-text">
						<h5 class="prev-title"><?php echo sanitize_text_field( get_the_title( $prev_post->ID ) ); ?></h5>
					</div>
				</a>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( ! empty( $next_post ) ) : ?>
		<div class="next-post">
			<?php if( has_post_thumbnail( $next_post->ID ) && get_theme_mod( 'penci_post_nav_thumbnail' ) ): ?>
				<?php if( ! get_theme_mod( 'penci_disable_lazyload_single' ) ) { ?>
					<a class="penci-post-nav-thumb penci-holder-load penci-lazy nav-thumb-next" href="<?php echo esc_url( get_the_permalink( $next_post->ID ) ); ?>" data-src="<?php echo penci_get_featured_image_size( $next_post->ID, 'thumbnail' ); ?>">
					</a>
				<?php } else { ?>
					<a class="penci-post-nav-thumb nav-thumb-next" href="<?php echo esc_url( get_the_permalink( $next_post->ID ) ); ?>" style="background-image: url('<?php echo penci_get_featured_image_size( $next_post->ID, 'thumbnail' ); ?>');">
					</a>
				<?php } ?>
			<?php endif; ?>
			<div class="next-post-inner">
				<div class="prev-post-title next-post-title">
					<span><?php echo penci_get_setting( 'penci_trans_next_post' ); ?></span>
				</div>
				<a href="<?php echo esc_url( get_the_permalink( $next_post->ID ) ); ?>">
					<div class="pagi-text">
						<h5 class="next-title"><?php echo sanitize_text_field( get_the_title( $next_post->ID ) ); ?></h5>
					</div>
				</a>
			</div>
		</div>
	<?php endif; ?>
</div>