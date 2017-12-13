<?php
/**
 * Display featured categories on magazine layout
 *
 * @since 1.0
 */

$featured_cats       = get_theme_mod( 'penci_home_featured_cat' );
$featured_cats       = str_replace( ' ', '', $featured_cats );
$featured_categories = explode( ',', $featured_cats );
foreach ( $featured_categories as $fea_cat ) {
	$fea_oj = get_category_by_slug( $fea_cat );
	if( ! empty ( $fea_oj ) ) {
		$fea_cat_id = $fea_oj->term_id;
		$fea_cat_name = $fea_oj->name;
		$cat_meta   = get_option( "category_$fea_cat_id" );
		$cat_layout = isset( $cat_meta['mag_layout'] ) ? $cat_meta['mag_layout'] : 'style-1';
		$cat_ads_code = isset( $cat_meta['mag_ads'] ) ? $cat_meta['mag_ads'] : '';
		$numbers_posts = get_theme_mod( 'penci_home_featured_posts_numbers_1' ) ? get_theme_mod( 'penci_home_featured_posts_numbers_1' ) : '5';
		if ( $cat_layout == 'style-2' ) {
			$numbers_posts = get_theme_mod( 'penci_home_featured_posts_numbers_2' ) ? get_theme_mod( 'penci_home_featured_posts_numbers_2' ) : '4';
		}
		elseif ( $cat_layout == 'style-3' ) {
			$numbers_posts = get_theme_mod( 'penci_home_featured_posts_numbers_3' ) ? get_theme_mod( 'penci_home_featured_posts_numbers_3' ) : '4';
		}
		elseif ( $cat_layout == 'style-4' ) {
			$numbers_posts = get_theme_mod( 'penci_home_featured_posts_numbers_4' ) ? get_theme_mod( 'penci_home_featured_posts_numbers_4' ) : '6';
		}
		elseif ( $cat_layout == 'style-5' ) {
			$numbers_posts = get_theme_mod( 'penci_home_featured_posts_numbers_5' ) ? get_theme_mod( 'penci_home_featured_posts_numbers_5' ) : '6';
		}
		elseif ( $cat_layout == 'style-6' ) {
			$numbers_posts = get_theme_mod( 'penci_home_featured_posts_numbers_6' ) ? get_theme_mod( 'penci_home_featured_posts_numbers_6' ) : '5';
		}
		elseif ( $cat_layout == 'style-7' ) {
			$numbers_posts = get_theme_mod( 'penci_home_featured_posts_numbers_7' ) ? get_theme_mod( 'penci_home_featured_posts_numbers_7' ) : '6';
		}
		elseif ( $cat_layout == 'style-8' ) {
			$numbers_posts = get_theme_mod( 'penci_home_featured_posts_numbers_8' ) ? get_theme_mod( 'penci_home_featured_posts_numbers_8' ) : '3';
		}
		elseif ( $cat_layout == 'style-9' ) {
			$numbers_posts = get_theme_mod( 'penci_home_featured_posts_numbers_9' ) ? get_theme_mod( 'penci_home_featured_posts_numbers_9' ) : '8';
		}
		elseif ( $cat_layout == 'style-10' ) {
			$numbers_posts = get_theme_mod( 'penci_home_featured_posts_numbers_10' ) ? get_theme_mod( 'penci_home_featured_posts_numbers_10' ) : '6';
		}
		elseif ( $cat_layout == 'style-11' ) {
			$numbers_posts = get_theme_mod( 'penci_home_featured_posts_numbers_11' ) ? get_theme_mod( 'penci_home_featured_posts_numbers_11' ) : '4';
		}
		elseif ( $cat_layout == 'style-12' ) {
			$numbers_posts = get_theme_mod( 'penci_home_featured_posts_numbers_12' ) ? get_theme_mod( 'penci_home_featured_posts_numbers_12' ) : '6';
		}
		elseif ( $cat_layout == 'style-13' ) {
			$numbers_posts = get_theme_mod( 'penci_home_featured_posts_numbers_13' ) ? get_theme_mod( 'penci_home_featured_posts_numbers_13' ) : '6';
		}
		elseif ( $cat_layout == 'style-14' ) {
			$numbers_posts = get_theme_mod( 'penci_home_featured_posts_numbers_14' ) ? get_theme_mod( 'penci_home_featured_posts_numbers_14' ) : '6';
		}

		$attr       = array(
			'post_type' => 'post',
			'showposts' => $numbers_posts,
			'tax_query' => array(
				array(
					'taxonomy' => 'category',
					'field'    => 'slug',
					'terms'    => $fea_cat
				)
			)
		);
		$fea_query = new WP_Query( $attr );
		$numers_results = $fea_query->post_count;

		if( $fea_query->have_posts() ) :

		$heading_title = get_theme_mod( 'penci_featured_cat_style' ) ? get_theme_mod( 'penci_featured_cat_style' ) : 'style-1';
		$heading_align = get_theme_mod( 'penci_featured_cat_align' ) ? get_theme_mod( 'penci_featured_cat_align' ) : 'pcalign-left';
		?>
			<?php if( $cat_layout == 'style-2' || $cat_layout == 'style-14' ) {
			$wrap_class = '';
			if( $cat_layout == 'style-14' ): $wrap_class = ' mag-cat-style-14'; endif;
			?>
			<div class="home-featured-cat mag-cat-style-2<?php echo $wrap_class; ?>">
			<?php } else { ?>
			<section class="home-featured-cat mag-cat-<?php echo esc_attr( $cat_layout ); ?>">
			<?php } ?>
				<div class="penci-border-arrow penci-homepage-title penci-magazine-title <?php echo sanitize_text_field( $heading_title . ' ' . $heading_align ); ?>">
					<h3 class="inner-arrow"><a href="<?php echo esc_url( get_category_link( $fea_cat_id ) ); ?>"><?php echo sanitize_text_field( $fea_cat_name ); ?></a></h3>
				</div>
				<div class="home-featured-cat-content <?php echo esc_attr( $cat_layout ); ?>">
				<?php if( $cat_layout == 'style-4' ): ?>
					<div class="penci-single-mag-slider penci-owl-carousel penci-owl-carousel-slider" data-auto="true" data-dots="true" data-nav="false">
				<?php endif; ?>
				<?php if( $cat_layout == 'style-5' || $cat_layout == 'style-12' ):
					$data_item = 2;
					if( $cat_layout == 'style-12' ): $data_item = 3; endif;
				?>
					<div class="penci-magcat-carousel-wrapper">
						<div class="penci-owl-carousel penci-owl-carousel-slider penci-magcat-carousel" data-auto="true" data-speed="400" data-item="<?php echo $data_item; ?>" data-desktop="<?php echo $data_item; ?>" data-tablet="2" data-tabsmall="1">
				<?php endif; ?>
				<?php if( $cat_layout == 'style-7' || $cat_layout == 'style-8' || $cat_layout == 'style-13' ): ?>
					<ul class="penci-grid penci-grid-maglayout penci-fea-cat-<?php echo $cat_layout; ?>">
				<?php endif; ?>
					<?php
						$m = 1; while( $fea_query->have_posts() ): $fea_query->the_post();
							include( locate_template( 'inc/modules/magazine-' . $cat_layout . '.php' ) );
						$m++; endwhile;
					?>
				<?php if( $cat_layout == 'style-7' || $cat_layout == 'style-8' || $cat_layout == 'style-13' ): ?>
					</ul>
				<?php endif; ?>
				<?php if( $cat_layout == 'style-5' || $cat_layout == 'style-12' ): ?>
						</div>
					</div>
				<?php endif; ?>
				<?php if( $cat_layout == 'style-4' ): ?>
					</div>
				<?php endif; ?>
				</div>

				<?php if( get_theme_mod( 'penci_home_featured_cat_seemore' ) ): ?>
				<div class="penci-featured-cat-seemore penci-seemore-<?php echo esc_attr( $cat_layout ); ?>">
					<a href="<?php echo esc_url( get_category_link( $fea_cat_id ) ); ?>"><?php echo penci_get_setting( 'penci_trans_view_all' ); ?><i class="fa fa-angle-double-right"></i></a>
				</div>
				<?php endif; ?>

				<?php if( $cat_ads_code ): ?>
					<div class="penci-featured-cat-custom-ads">
						<?php echo stripslashes( $cat_ads_code ); ?>
					</div>
				<?php endif; ?>

			<?php if( $cat_layout == 'style-2' || $cat_layout == 'style-14' ) { ?>
			</div>
			<?php } else { ?>
			</section>
			<?php } ?>
		<?php
		endif; wp_reset_postdata();
	}
}