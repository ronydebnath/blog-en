<?php
/**
 * Template part for Slider Style 30
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
			<a class="penci-image-holder owl-lazy" data-src="<?php echo penci_get_featured_image_size( get_the_ID(), 'penci-slider-thumb' ); ?>" href="<?php the_permalink(); ?>" title="<?php echo wp_strip_all_tags( get_the_title() ); ?>"></a>
		<?php } else { ?>
			<a class="penci-image-holder" style="background-image: url('<?php echo penci_get_featured_image_size( get_the_ID(), 'penci-slider-thumb' ); ?>');" href="<?php the_permalink(); ?>" title="<?php echo wp_strip_all_tags( get_the_title() ); ?>"></a>
		<?php }?>

		<a href="<?php the_permalink() ?>" class="featured-slider-overlay"></a>
		<?php if ( ! get_theme_mod( 'penci_featured_center_box' ) ): ?>
			<div class="penci-featured-content">
				<div class="feat-text<?php if ( get_theme_mod( 'penci_featured_meta_date' ) ): echo ' slider-hide-date'; endif;?>">
					<?php if ( ! get_theme_mod( 'penci_featured_hide_categories' ) ): ?>
						<div class="cat featured-cat"><?php penci_category( '' ); ?></div>
					<?php endif; ?>
					<h3><a title="<?php echo wp_strip_all_tags( get_the_title() ); ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
					<div class="penci-featured-slider-button">
						<a href="<?php the_permalink() ?>"><?php echo penci_get_setting( 'penci_trans_read_more' ); ?></a>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
<?php endwhile; wp_reset_postdata(); endif; ?>
