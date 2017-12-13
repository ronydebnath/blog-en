<?php
/**
 * Template part for Slider Style 4
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
<?php if ( $feat_query->have_posts() ) : while ( $feat_query->have_posts() ) : $feat_query->the_post(); ?>
	<div class="item">
		<?php if( ! get_theme_mod( 'penci_disable_lazyload_slider' ) ) { ?>
			<a class="penci-image-holder owl-lazy" data-src="<?php echo penci_get_featured_image_size( get_the_ID(), 'penci-magazine-slider' ); ?>" href="<?php the_permalink(); ?>" title="<?php echo wp_strip_all_tags( get_the_title() ); ?>"></a>
		<?php } else { ?>
			<a class="penci-image-holder" style="background-image: url('<?php echo penci_get_featured_image_size( get_the_ID(), 'penci-magazine-slider' ); ?>');" href="<?php the_permalink(); ?>" title="<?php echo wp_strip_all_tags( get_the_title() ); ?>"></a>
		<?php }?>
		<div class="penci-slider4-overlay">
			<a class="overlay-link" href="<?php the_permalink(); ?>"></a>
			<div class="penci-featured-content">
				<div class="feat-text<?php if ( get_theme_mod( 'penci_featured_meta_date' ) ): echo ' slider-hide-date'; endif;?>">
					<div class="featured-slider-overlay"></div>
					<?php if ( ! get_theme_mod( 'penci_featured_hide_categories' ) ): ?>
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
<?php endwhile; wp_reset_postdata(); endif; ?>