<?php
/**
 * Template part for Slider Style 17
 */

$featured_cat = get_theme_mod( 'penci_featured_cat' );
$number       = get_theme_mod( 'penci_featured_slider_slides' );
if ( ! $number ): $number = 10; endif;
$featured_args = array( 'posts_per_page' => $number, 'post_type' => 'post' );
if ( $featured_cat && '0' != $featured_cat ):
	$featured_args['cat'] = $featured_cat;
endif;
if( get_theme_mod( 'penci_featured_slider_random' ) ):
	$featured_args['orderby'] = 'rand';
endif;
?>

<?php $feat_query = new WP_Query( $featured_args ); ?>
<?php if ( $feat_query->have_posts() ) : ?>
	<div class="item">
		<div class="wrapper-item wrapper-item-classess">
			<?php $i = 1; $num_posts = $feat_query->post_count;
			while ( $feat_query->have_posts() ) : $feat_query->the_post();
			$thumb = 'penci-thumb';
			if( $i%5 == 3 ): $thumb = 'penci-magazine-slider'; endif;
			?>

			<?php if( $i%5 == 1 ): ?>
				<div class="penci-slider17-mag-item penci-slide17-item-<?php echo ( $i%5 ); ?>">
			<?php endif; ?>

			<div class="penci-item-mag penci-item-<?php echo ( $i%5 ); ?>">
				<?php if( ! get_theme_mod( 'penci_disable_lazyload_slider' ) ) { ?>
					<a class="penci-image-holder owl-lazy" data-src="<?php echo penci_get_featured_image_size( get_the_ID(), $thumb ); ?>" href="<?php the_permalink(); ?>" title="<?php echo wp_strip_all_tags( get_the_title() ); ?>"></a>
				<?php } else { ?>
					<a class="penci-image-holder" style="background-image: url('<?php echo penci_get_featured_image_size( get_the_ID(), $thumb ); ?>');" href="<?php the_permalink(); ?>" title="<?php echo wp_strip_all_tags( get_the_title() ); ?>"></a>
				<?php }?>
				<div class="penci-slide-overlay penci-slider6-overlay">
					<a class="overlay-link" href="<?php the_permalink(); ?>"></a>
					<?php if( ! get_theme_mod( 'penci_featured_slider_icons' ) && ( has_post_format( 'video' ) || has_post_format( 'audio' ) || has_post_format( 'link' ) || has_post_format( 'quote' ) || has_post_format( 'gallery' ) ) ): ?>
						<a href="<?php the_permalink(); ?>" class="overlay-icon-format <?php if( $i%5 == 3 ): echo ' lager-size-icon'; endif; ?>">
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
						</a>
					<?php endif; ?>
					<div class="penci-mag-featured-content">
						<div class="feat-text<?php if ( get_theme_mod( 'penci_featured_meta_date' ) ): echo ' slider-hide-date'; endif;?>">
							<?php if( $i%5 == 3 && ! get_theme_mod( 'penci_featured_hide_categories' ) ): ?>
								<div class="cat featured-cat"><?php penci_category( '' ); ?></div>
							<?php endif; ?>
							<h3><a title="<?php echo wp_strip_all_tags( get_the_title() ); ?>" href="<?php the_permalink() ?>"><?php echo wp_trim_words( wp_strip_all_tags( get_the_title() ), 12, '...' ); ?></a></h3>
							<?php if ( ! get_theme_mod( 'penci_featured_meta_comment' ) || ! get_theme_mod( 'penci_featured_meta_date' ) ): ?>
								<div class="feat-meta">
									<?php if ( ! get_theme_mod( 'penci_featured_meta_date' ) ): ?>
										<span class="feat-time"><?php the_time( get_option('date_format') ); ?></span>
									<?php endif; ?>
									<?php if ( ! get_theme_mod( 'penci_featured_meta_comment' ) ): ?>
										<span class="feat-comments"><a href="<?php comments_link(); ?> "><?php comments_number( '0 ' . penci_get_setting( 'penci_trans_comment' ), '1 '. penci_get_setting( 'penci_trans_comment' ), '% ' . penci_get_setting( 'penci_trans_comments' ) ); ?></a></span>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>

			<?php if( $i%5 == 2 || $i%5 == 3 ): ?>
				</div><div class="penci-slider17-mag-item penci-slide17-item-<?php echo ( $i%5 ); ?>">
			<?php endif; ?>

			<?php if( $i%5 == 0 && $i > 1 && $i < $num_posts ):  echo '</div></div></div><div class="item"><div class="wrapper-item wrapper-item-classess">';  endif;?>

			<?php if( $i == $num_posts ): ?>
				</div>
			<?php endif; ?>

			<?php $i++; endwhile; wp_reset_postdata(); ?>
		</div>
	</div>
<?php endif; ?>