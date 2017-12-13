<?php
/**
 * Template loop for gird 3 columns style
 */
?>
<li class="grid-style">
	<article id="post-<?php the_ID(); ?>" class="item">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="thumbnail">
				<?php
				/* Display Review Piechart  */
				if( function_exists('penci_display_piechart_review_html') ) {
					penci_display_piechart_review_html( get_the_ID(), 'small' );
				}
				?>

				<?php if( ! get_theme_mod( 'penci_disable_lazyload_layout' ) ) { ?>
				<a class="penci-image-holder penci-lazy<?php echo penci_class_lightbox_enable(); ?>" data-src="<?php echo penci_get_featured_image_size( get_the_ID(), 'penci-thumb' ); ?>" href="<?php penci_permalink_fix(); ?>" title="<?php echo wp_strip_all_tags( get_the_title() ); ?>">
				</a>
				<?php } else { ?>
				<a class="penci-image-holder<?php echo penci_class_lightbox_enable(); ?>" style="background-image: url('<?php echo penci_get_featured_image_size( get_the_ID(), 'penci-thumb' ); ?>');" href="<?php penci_permalink_fix(); ?>" title="<?php echo wp_strip_all_tags( get_the_title() ); ?>">
				</a>
				<?php } ?>

				<?php if( ! get_theme_mod('penci_grid_icon_format') ): ?>
					<?php if ( has_post_format( 'video' ) ) : ?>
						<a href="<?php the_permalink() ?>" class="icon-post-format"><i class="fa fa-play"></i></a>
					<?php endif; ?>
					<?php if ( has_post_format( 'audio' ) ) : ?>
						<a href="<?php the_permalink() ?>" class="icon-post-format"><i class="fa fa-music"></i></a>
					<?php endif; ?>
					<?php if ( has_post_format( 'link' ) ) : ?>
						<a href="<?php the_permalink() ?>" class="icon-post-format"><i class="fa fa-link"></i></a>
					<?php endif; ?>
					<?php if ( has_post_format( 'quote' ) ) : ?>
						<a href="<?php the_permalink() ?>" class="icon-post-format"><i class="fa fa-quote-left"></i></a>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<div class="grid-header-box">
			<h2 class="grid-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

			<?php if ( ! get_theme_mod( 'penci_home_featured_cat_date' ) || ! get_theme_mod( 'penci_home_featured_cat_author' ) ) : ?>
				<div class="grid-post-box-meta">
					<?php if ( ! get_theme_mod( 'penci_home_featured_cat_author' ) ) : ?>
						<span class="author-italic"><?php echo penci_get_setting('penci_trans_by'); ?> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a></span>
					<?php endif; ?>
					<?php if ( ! get_theme_mod( 'penci_home_featured_cat_date' ) ) : ?>
						<span><?php the_time( get_option('date_format') ); ?></span>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>

	</article>
</li>