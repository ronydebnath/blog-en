<?php
/**
 * Template display for featured category style 6
 *
 * @since 1.0
 */
?>
<?php if ( $m == 1 ): ?><div class="cat-left"><?php endif; ?>
<div class="mag-post-box<?php if ( $m == 1 ): echo ' first-post'; if( ! has_post_thumbnail() ): echo ' full-mag-cat'; endif;  endif; ?>">
	<div class="magcat-thumb">
		<?php
		/* Display Review Piechart  */
		if( function_exists('penci_display_piechart_review_html') ) {
			$size_pie = 'small';
			if( $m == 1 ): $size_pie = 'normal'; endif;
			penci_display_piechart_review_html( get_the_ID(), $size_pie );
		}
		?>
		<?php if( ! get_theme_mod( 'penci_disable_lazyload_layout' ) ) { ?>
		<a class="penci-image-holder penci-lazy<?php if( $m > 1 ): echo ' small-fix-size'; endif; ?><?php echo penci_class_lightbox_enable(); ?>" data-src="<?php echo penci_get_featured_image_size( get_the_ID(), 'penci-thumb' ); ?>" href="<?php penci_permalink_fix(); ?>" title="<?php echo wp_strip_all_tags( get_the_title() ); ?>">
		</a>
		<?php } else { ?>
		<a class="penci-image-holder<?php if( $m > 1 ): echo ' small-fix-size'; endif; ?><?php echo penci_class_lightbox_enable(); ?>" style="background-image: url('<?php echo penci_get_featured_image_size( get_the_ID(), 'penci-thumb' ); ?>');" href="<?php penci_permalink_fix(); ?>" title="<?php echo wp_strip_all_tags( get_the_title() ); ?>">
		</a>
		<?php } ?>
		<?php if( has_post_thumbnail() && get_theme_mod('penci_home_featured_cat_icons') ): ?>
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
			<?php if ( has_post_format( 'gallery' ) ) : ?>
				<a href="<?php the_permalink() ?>" class="icon-post-format"><i class="fa fa-picture-o"></i></a>
			<?php endif; ?>
		<?php endif; ?>
	</div>
	<div class="magcat-detail">
		<?php if ( $m == 1 ): ?><div class="mag-header"><?php endif; ?>
		<h3 class="magcat-titlte"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			<?php if ( ( $m == 1 && ! get_theme_mod( 'penci_home_featured_cat_author' ) ) || ! get_theme_mod( 'penci_home_featured_cat_date' ) ): ?>
				<div class="grid-post-box-meta mag-meta">
					<?php if ( $m == 1 && ! get_theme_mod( 'penci_home_featured_cat_author' ) ) : ?>
						<span class="author-italic"><?php echo penci_get_setting('penci_trans_by'); ?> <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php the_author(); ?></a></span>
					<?php endif; ?>
					<?php if ( ! get_theme_mod( 'penci_home_featured_cat_date' ) ) : ?>
						<span><?php the_time( get_option('date_format') ); ?></span>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		<?php if ( $m == 1 ): ?></div><?php endif; ?>
		<?php if ( $m == 1 && get_the_excerpt() && ! get_theme_mod( 'penci_home_featured_cat_remove_excerpt' ) ): ?>
			<div class="mag-excerpt">
				<?php the_excerpt(); ?>
			</div>
		<?php endif; ?>
	</div>
</div>
<?php if ( $m == 1 ): ?></div><div class="cat-right"><?php endif; ?>
<?php if ( $m == $numers_results ): ?></div><?php endif; ?>