<?php
/**
 * Add portfolio shortcode
 *
 */
if ( ! function_exists( 'penci_portfolio_shortcode' ) ) {
	function penci_portfolio_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'style'    => 'masonry',
			'number'   => '-1',
			'column'   => '3',
			'cat'      => '',
			'filter'   => 'true',    // display filter or not
			'all_text' => __( 'All', 'pencidesign' ),
		), $atts ) );

		/* Set default value when properties is not valid */
		$image_thumb = 'penci-masonry-thumb';
		if ( $style == 'grid' ): $image_thumb = 'penci-thumb'; endif;
		if ( ! is_numeric( $number ) ): $number = '-1'; endif;
		if ( ! in_array( $column, array( '2', '3' ) ) ): $column = '3'; endif;
		if ( $filter != 'false' ): $filter = 'true'; endif;
		if ( empty( $all_text ) ): $all_text = __( 'All', 'pencidesign' ); endif;

		/* Display Portfolio */
		global $wp_query, $post;
		if ( get_query_var('paged') ) {
			$paged = get_query_var('paged');
		} elseif ( get_query_var('page') ) {
			$paged = get_query_var('page');
		} else {
			$paged = 1;
		}
		$query = array(
			'post_type'      => 'portfolio',
			'posts_per_page' => $number,
			'paged' => $paged
		);

		$cat_array = array();
		if( ! empty ( $cat ) ) {
			$cat       = str_replace( ' ', '', $cat );
			$cat_array = explode( ',', $cat );
			$query['tax_query'] =  array(
				array(
					'taxonomy' => 'portfolio-category',
					'field'    => 'slug',
					'terms'    => $cat_array
				),
			);
		}

		$portfolio_query = new WP_Query( $query );
		if ( ! $portfolio_query->have_posts() ) {
			return;
		}

		$portfolio_categories = get_terms( 'portfolio-category', array( 'orderby' => 'id' ) );

		ob_start();
		/* Portfolio Filter */
		?>
		<div class="wrapper-penci-portfolio">
			<?php if ( $filter == 'true' ):
				?>
				<?php if ( ! empty( $portfolio_categories ) ): ?>
				<div class="penci-portfolio-filter">
					<ul>
						<li class="all active">
							<a data-filter="*" href="#"><?php echo $all_text; ?></a>
						</li>
						<?php foreach ( $portfolio_categories as $catdata ):
							$cat_slug = $catdata->slug;
							if( ( ! empty( $cat_array ) && in_array( $cat_slug, $cat_array ) ) || empty( $cat_array ) ):
								?>
								<li>
									<a data-filter=".penci-<?php echo $cat_slug; ?>" href="#"><?php echo $catdata->name; ?></a>
								</li>
							<?php endif;
						endforeach; ?>
					</ul>
				</div><!-- .portfolio-filter -->
				<div class="clearfix"></div>
			<?php endif;?>
			<?php endif; ?>

			<div class="penci-portfolio penci-portfolio-wrap column-<?php echo $column; ?>">
				<div class="inner-portfolio-posts">
					<?php while ( $portfolio_query->have_posts() ): $portfolio_query->the_post(); ?>
						<?php
						$item_classes = array( 'portfolio-item' );
						$item_cats    = get_the_terms( get_the_ID(), 'portfolio-category' );
						if ( $item_cats ) {
							foreach ( $item_cats as $item_cat ) {
								$item_classes[] = 'penci-' . $item_cat->slug;
							}
						}
						$item_classes = implode( ' ', $item_classes );
						?>
						<article class="<?php echo $item_classes; ?>" id="portfolio-<?php the_ID(); ?>">
							<div class="inner-item-portfolio">
								<div class="info-portfolio">
									<div class="penci-portfolio-thumbnail">
										<a href="<?php the_permalink(); ?>">
											<?php /* Thumbnail */
											if ( has_post_thumbnail() ) {
												the_post_thumbnail( $image_thumb );
											}
											else {
												echo '<img src="' . PENCI_PORTFOLIO_URL . '/images/no-thumbnail.jpg" alt="' . __( "No Thumbnail", "pencidesign" ) . '" />';
											}
											?>
										</a>
									</div>
									<div class="portfolio-desc">
										<a href="<?php the_permalink(); ?>">
											<h3 class="portfolio-title"><?php the_title(); ?></h3>
											<?php
											/* Get list term of this portfolio */
											$get_terms = wp_get_post_terms( $post->ID, 'portfolio-category' );
											if ( ! empty( $get_terms ) ):

												$list_cats = array();
												foreach ( $get_terms as $term ) {
													$list_cats[] = $term->name;
												}
												$list_cats = implode( ', ', $list_cats );
												?>
												<span class="portfolio-cat"><?php echo $list_cats;?></span>
											<?php endif; ?>
										</a>
									</div>
								</div>
							</div>
						</article>
					<?php endwhile;
					wp_reset_postdata(); ?>
				</div>
			</div>
			
			<div class="penci-pagenavi-shortcode">
				<?php
				if( function_exists( 'penci_pagination_numbers' ) ):
				echo penci_pagination_numbers( $portfolio_query ); 
				endif;
				?>
			</div>
			
		</div>

		<?php
		$return = ob_get_clean();

		return $return;
	}

	add_shortcode( 'portfolio', 'penci_portfolio_shortcode' );
}
?>