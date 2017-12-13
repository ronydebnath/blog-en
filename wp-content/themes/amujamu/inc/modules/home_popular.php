<?php
/**
 * Popular Posts in Homepage
 */

$number_posts = get_theme_mod( 'penci_home_popular_post_numberposts' ) ? get_theme_mod( 'penci_home_popular_post_numberposts' ) : 10;
$query = array(
	'posts_per_page' => $number_posts,
	'post_type'      => 'post',
	'meta_key'       => 'penci_post_views_count',
	'orderby'        => 'meta_value_num',
	'order'          => 'DESC'
);

if( get_theme_mod( 'penci_home_popular_type' ) == 'week' ) {
	$query = array(
		'posts_per_page' => $number_posts,
		'post_type'      => 'post',
		'meta_key'       => 'penci_post_week_views_count',
		'orderby'        => 'meta_value_num',
		'order'          => 'DESC'
	);
} elseif ( get_theme_mod( 'penci_home_popular_type' ) == 'month' ) {
	$query = array(
		'posts_per_page' => $number_posts,
		'post_type'      => 'post',
		'meta_key'       => 'penci_post_month_views_count',
		'orderby'        => 'meta_value_num',
		'order'          => 'DESC'
	);
}

$popular_cat = get_theme_mod( 'penci_home_popular_cat' );
if( $popular_cat && '0' != $popular_cat ):
	$query['cat'] = $popular_cat;
endif;

$popular = new WP_Query( $query );

if( $popular->have_posts() ) {
$data_loop = '';
$number_posts_display = $popular->post_count;
if( $number_posts_display < 5 ):
	$data_loop = ' data-loop="false"';
endif;
$popular_title = get_theme_mod( 'penci_home_popular_title' );
?>
<div class="container penci-home-popular-posts">
	<h2 class="home-pupular-posts-title">
		<span>
			<?php echo penci_get_setting( 'penci_home_popular_title' ); ?>
		</span>
	</h2>
	<div class="penci-owl-carousel penci-owl-carousel-slider penci-related-carousel penci-home-popular-post"<?php echo $data_loop; ?> data-lazy="true" data-item="4" data-desktop="4" data-tablet="3" data-tabsmall="2" data-auto="false" data-speed="300" data-dots="true" data-nav="false">
		<?php while ( $popular->have_posts() ) : $popular->the_post(); ?>
			<div class="item-related">
				<?php if ( ( function_exists( 'has_post_thumbnail' ) ) && ( has_post_thumbnail() ) ) : ?>
					<?php if( ! get_theme_mod( 'penci_disable_lazyload_layout' ) ) { ?>
					<a class="related-thumb penci-image-holder owl-lazy" href="<?php the_permalink() ?>" title="<?php echo wp_strip_all_tags( get_the_title() ); ?>" data-src="<?php echo penci_get_featured_image_size( get_the_ID(), 'penci-thumb' ); ?>">
					<?php } else { ?>
					<a class="related-thumb penci-image-holder" href="<?php the_permalink() ?>" title="<?php echo wp_strip_all_tags( get_the_title() ); ?>" style="background-image: url('<?php echo penci_get_featured_image_size( get_the_ID(), 'penci-thumb' ); ?>');">
					<?php }?>
						<?php if( has_post_thumbnail() && get_theme_mod('penci_enable_home_popular_icons') ): ?>
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
				<?php endif; ?>

				<h3><a title="<?php echo wp_strip_all_tags( get_the_title() ); ?>" href="<?php the_permalink(); ?>"><?php echo wp_trim_words( wp_strip_all_tags( get_the_title() ), 8, '...' ); ?></a></h3>
				<?php if ( ! get_theme_mod( 'penci_hide_date_home_popular' ) ) : ?>
					<span class="date"><?php the_time( get_option( 'date_format' ) ); ?></span>
				<?php endif; ?>
			</div>
		<?php
		endwhile;
		?>
	</div>
</div>
<?php
}
wp_reset_postdata();
?>

