<?php
/**
 * Template part for Slider Style 9
 */

$featured_cat = get_theme_mod( 'penci_featured_cat' );
$number       = get_theme_mod( 'penci_featured_slider_slides' );
if ( ! $number ): $number = 6; endif;
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
<?php $i = 1; $num_posts = $feat_query->post_count;
while ( $feat_query->have_posts() ) : $feat_query->the_post();
?>
	<div class="item">
		<div class="wrapper-item wrapper-item-classess">
			<div class="penci-item-mag penci-item-<?php echo ( $i%3 ); ?>">
				<?php if( ! get_theme_mod( 'penci_disable_lazyload_slider' ) ) { ?>
					<a class="penci-image-holder owl-lazy" data-src="<?php echo penci_get_featured_image_size( get_the_ID(), 'penci-thumb-square' ); ?>" href="<?php the_permalink(); ?>" title="<?php echo wp_strip_all_tags( get_the_title() ); ?>"></a>
				<?php } else { ?>
					<a class="penci-image-holder" style="background-image: url('<?php echo penci_get_featured_image_size( get_the_ID(), 'penci-thumb-square' ); ?>');" href="<?php the_permalink(); ?>" title="<?php echo wp_strip_all_tags( get_the_title() ); ?>"></a>
				<?php }?>
				<div class="penci-slide-overlay penci-slider7-overlay">
					<a class="overlay-link" href="<?php the_permalink(); ?>"></a>
					<?php if( ! get_theme_mod( 'penci_featured_slider_icons' ) && ( has_post_format( 'video' ) || has_post_format( 'audio' ) || has_post_format( 'link' ) || has_post_format( 'quote' ) || has_post_format( 'gallery' ) ) ): ?>
						<a href="<?php the_permalink(); ?>" class="overlay-icon-format lager-size-icon">
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
		</div>
	</div>
<?php $i++; endwhile; wp_reset_postdata(); ?>
<?php endif; ?>