<?php
/**
 * Related post template
 * Render list related posts
 *
 * @since 1.0
 */
$data_auto = 'true';
$auto = get_theme_mod( 'penci_post_related_autoplay' );
if( $auto == false ): $data_auto = 'false'; endif;

$sidebar_opts = get_post_meta( get_the_ID(), 'penci_post_sidebar_display', true );

$orig_post = $post;
global $post;
$numbers_related = get_theme_mod('penci_numbers_related_post');
if ( !isset( $numbers_related ) || $numbers_related < 1 ): $numbers_related = 10; endif;

$orderby_post = 'rand';
if( get_theme_mod('penci_related_orderby') && get_theme_mod('penci_related_orderby') != 'rand' ):
	$orderby_post = get_theme_mod('penci_related_orderby');
endif;

$categories = get_the_category( get_the_ID() );

if( get_theme_mod('penci_related_by') == 'tags' ):
	$categories = wp_get_post_terms( get_the_ID(), 'post_tag', array( 'fields' => 'ids' ) );
endif;

if ( $categories ) {
	if( get_theme_mod('penci_related_by') == 'tags' ) {
		$args = array(
			'post_type'      => 'post',
			'ignore_sticky_posts' => 1,
			'posts_per_page' => $numbers_related,
			'tax_query'      => array(
				array(
					'taxonomy' => 'post_tag',
					'terms'    => $categories
				),
			),
			'post__not_in'        => array( get_the_ID() ),
			'orderby'             => $orderby_post
		);
	} else {
		$category_ids = array();
		$featured_cat = get_theme_mod('penci_featured_cat');
		foreach ( $categories as $individual_category ) {
			/* Remove featured slider categories to related posts */
			$term_related = $individual_category->term_id;
			if( $term_related != $featured_cat ){
				$category_ids[] = $term_related;
			}
		}

		$args = array(
			'category__in'        => $category_ids,
			'post__not_in'        => array( get_the_ID() ),
			'posts_per_page'      => $numbers_related,
			'ignore_sticky_posts' => 1,
			'orderby'             => $orderby_post
		);
	}

	$my_query = new wp_query( $args );
	if ( $my_query->have_posts() ) {
		$data_loop = '';
		$number_posts_display = $my_query->post_count;
		if( $number_posts_display < 4 ):
		$data_loop = ' data-loop="false"';
		endif;
		?>
		<div class="post-related">
		<div class="post-title-box"><h4 class="post-box-title"><?php echo penci_get_setting( 'penci_post_related_text' ); ?></h4></div>
		<div class="penci-owl-carousel penci-owl-carousel-slider penci-related-carousel" data-lazy="true"<?php echo $data_loop; ?> data-item="3" data-desktop="3" data-tablet="2" data-tabsmall="2" data-auto="<?php echo $data_auto; ?>" data-speed="300"<?php if( ! get_theme_mod('penci_post_related_dots') ){ echo ' data-dots="true"'; } if( ! get_theme_mod('penci_post_related_arrows') ){ echo ' data-nav="false"'; } ?>>
		<?php while ( $my_query->have_posts() ) : $my_query->the_post(); ?>
				<div class="item-related">
					<?php if ( ( function_exists( 'has_post_thumbnail' ) ) && ( has_post_thumbnail() ) ) : ?>
						<?php if( ! get_theme_mod( 'penci_disable_lazyload_single' ) ) { ?>
							<a class="related-thumb penci-image-holder owl-lazy" data-src="<?php echo penci_get_featured_image_size( get_the_ID(), 'penci-thumb' ); ?>" href="<?php the_permalink(); ?>" title="<?php echo wp_strip_all_tags( get_the_title() ); ?>">
						<?php } else { ?>
							<a class="related-thumb penci-image-holder" style="background-image: url('<?php echo penci_get_featured_image_size( get_the_ID(), 'penci-thumb' ); ?>');" href="<?php the_permalink(); ?>" title="<?php echo wp_strip_all_tags( get_the_title() ); ?>">
						<?php }?>
							<?php if( has_post_thumbnail() && get_theme_mod('penci_post_related_icons') ): ?>
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
					<h3><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words( wp_strip_all_tags( get_the_title() ), 8, '...' ); ?></a></h3>
					<?php if( ! get_theme_mod('penci_hide_date_related') ): ?>
					<span class="date"><?php the_time( get_option( 'date_format' ) ); ?></span>
					<?php endif; ?>
				</div>
		<?php
		endwhile;
		echo '</div></div>';
	}
}
$post = $orig_post;
wp_reset_postdata();
?>