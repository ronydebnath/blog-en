<?php
/**
 * Template display for featured category style 5
 *
 * @since 2.0
 */
?>

<div class="magcat-carousel">
	<div class="magcat-thumb">
		<a href="<?php penci_permalink_fix(); ?>" class="mag-post-thumb<?php echo penci_class_lightbox_enable(); ?>">
			<?php
			/* Display Review Piechart  */
			if( function_exists('penci_display_piechart_review_html') ) {
				penci_display_piechart_review_html( get_the_ID() );
			}
			?>
			<?php if( ! get_theme_mod( 'penci_disable_lazyload_layout' ) ) { ?>
			<span class="penci-image-holder penci-lazy" data-src="<?php echo penci_get_featured_image_size( get_the_ID(), 'penci-thumb' ); ?>" href="<?php the_permalink(); ?>" title="<?php echo wp_strip_all_tags( get_the_title() ); ?>">
			</span>
			<?php } else { ?>
			<span class="penci-image-holder" style="background-image: url('<?php echo penci_get_featured_image_size( get_the_ID(), 'penci-thumb' ); ?>');" href="<?php the_permalink(); ?>" title="<?php echo wp_strip_all_tags( get_the_title() ); ?>">
			</span>
			<?php } ?>

			<?php if( has_post_thumbnail() && get_theme_mod('penci_home_featured_cat_icons') ): ?>
				<?php if ( has_post_format( 'video' ) ) : ?>
					<i class="fa fa-play"></i>
				<?php endif; ?>
				<?php if ( has_post_format( 'audio' ) ) : ?>
					<i class="fa fa-music"></i>
				<?php endif; ?>
				<?php if ( has_post_format( 'link' ) ) : ?>
					<i class="fa fa-link"></i>
				<?php endif; ?>
				<?php if ( has_post_format( 'quote' ) ) : ?>
					<i class="fa fa-quote-left"></i>
				<?php endif; ?>
				<?php if ( has_post_format( 'gallery' ) ) : ?>
					<i class="fa fa-picture-o"></i>
				<?php endif; ?>
			<?php endif; ?>
		</a>
		<div class="magcat-detail">
			<h3 class="magcat-titlte"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			<?php if ( ! get_theme_mod( 'penci_home_featured_cat_author' ) || ! get_theme_mod( 'penci_home_featured_cat_date' ) ): ?>
				<div class="grid-post-box-meta mag-meta">
					<?php if ( ! get_theme_mod( 'penci_home_featured_cat_author' ) ) : ?>
						<span><?php echo penci_get_setting('penci_trans_by'); ?> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a></span>
					<?php endif; ?>
					<?php if ( ! get_theme_mod( 'penci_home_featured_cat_date' ) ) : ?>
						<span><?php the_time( get_option('date_format') ); ?></span>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>