<?php
/**
 * Template to displaying single portfolio
 * This template be registered in this plugin
 *
 * @since 1.0
 */

get_header();

$image_thumb = 'penci-masonry-thumb';
if ( get_theme_mod( 'penci_portfolio_layout' ) == 'grid' ): $image_thumb = 'penci-thumb'; endif;
?>

<?php if( ! get_theme_mod( 'penci_disable_breadcrumb' ) ): ?>
	<div class="container penci-breadcrumb">
		<span><a class="crumb" href="<?php echo esc_url( home_url('/') ); ?>"><?php esc_html_e( 'Home', 'pencidesign' ); ?></a></span><i class="fa fa-angle-right"></i>
		<span><?php single_cat_title('', true); ?></span>
	</div>
<?php endif; ?>

<div class="container <?php if ( get_theme_mod( 'penci_portfolio_cat_enable_sidebar' ) ) : ?>penci_sidebar<?php endif; ?>">
	<div id="main">
		<div class="penci-page-header">
			<h1><?php single_cat_title(); ?></h1>
		</div>
		
		<?php if ( category_description() ) : // Show an optional category description ?>
			<div class="penci-category-description align-center"><?php echo sanitize_text_field( category_description() ); ?></div>
		<?php endif; ?>
		
		<?php if( have_posts() ): ?>
		<div class="wrapper-penci-portfolio">
			<div class="penci-portfolio penci-portfolio-wrap column-<?php if ( get_theme_mod( 'penci_portfolio_cat_enable_sidebar' ) ) { echo '2'; } else { echo '3'; } ?>">
				<div class="inner-portfolio-posts">
					<?php while ( have_posts() ): the_post(); ?>
						<article class="portfolio-item" id="portfolio-<?php the_ID(); ?>">
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
					<?php endwhile; ?>
				</div>
			</div>
		</div>	
		
		<?php echo penci_pagination_numbers(); ?>
		<?php endif; ?>
	</div>

<?php if ( get_theme_mod( 'penci_portfolio_cat_enable_sidebar' ) ) : ?><?php get_sidebar(); ?><?php endif; ?>

<?php get_footer(); ?>