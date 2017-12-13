<?php
/**
 * Template to displaying single portfolio
 * This template be registered in this plugin
 *
 * @since 1.0
 */

get_header();
$block_style = get_theme_mod('penci_blockquote_style') ? get_theme_mod('penci_blockquote_style') : 'style-1';
?>

<?php if( ! get_theme_mod( 'penci_disable_breadcrumb' ) ): ?>
	<div class="container penci-breadcrumb single-breadcrumb">
		<span><a class="crumb" href="<?php echo esc_url( home_url('/') ); ?>">
			<?php
			if( function_exists( 'penci_get_setting' ) ) {
				echo penci_get_setting( 'penci_post_related_text' );
			} else {
				esc_html_e( 'Home', 'pencidesign' );
			}
			?>
		</a></span><i class="fa fa-angle-right"></i>
		<?php 
		$penci_cats = wp_get_post_terms( get_the_ID(), 'portfolio-category' );
		if ( ! empty( $penci_cats ) ):
		?>
		<span>
			<?php
			echo '<a href="' . get_term_link( $penci_cats[0], 'portfolio-category' ) . '">' . $penci_cats[0]->name . '</a>';
			?>
		</span><i class="fa fa-angle-right"></i>
		<?php endif; ?>
		<span><?php the_title(); ?></span>
	</div>
<?php endif; ?>

<div class="container <?php if ( get_theme_mod( 'penci_portfolio_single_enable_sidebar' ) ) : ?>penci_sidebar<?php endif; ?>">
	<div id="main">
		<?php /* The loop */
		while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="penci-page-header">
					<h1><?php the_title(); ?></h1>
				</div>
				<div class="post-entry <?php echo 'blockquote-'. $block_style; ?><?php if ( get_theme_mod( 'penci_portfolio_share_box' ) ): echo ' page-has-margin'; endif; ?>">
					<div class="portfolio-page-content">
						<?php /* Thumbnail */
						if ( has_post_thumbnail() ) {
							echo '<div class="single-portfolio-thumbnail">';
							the_post_thumbnail( 'penci-full-thumb' );
							echo '</div>';
						}
						?>
						<div class="portfolio-detail">
							<?php the_content(); ?>
						</div>
					</div>
				</div>
				<?php if ( ! get_theme_mod( 'penci_portfolio_share_box' ) ) : ?>
					<div class="tags-share-box hide-tags page-share has-line">
						<div class="post-share">
							<span class="share-title"><?php esc_html_e( 'Share', 'soledad' ); ?></span>
							<div class="list-posts-share">
								<?php
								$facebook_share  = 'https://www.facebook.com/sharer/sharer.php?u=' . get_the_permalink();
								$twitter_share   = 'https://twitter.com/home?status=Check%20out%20this%20article:%20' . get_the_title() . '%20-%20' . get_the_permalink();
								$google_share    = 'https://plus.google.com/share?url=' . get_the_permalink();
								$pinterest_image = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
								$pinterest_share = 'https://pinterest.com/pin/create/button/?url=' . get_the_permalink() . '&media=' . $pinterest_image . '&description=' . get_the_title();
								?>
								<a target="_blank" href="<?php echo esc_url( $facebook_share ); ?>"><i class="fa fa-facebook"></i><span class="dt-share"><?php esc_html_e( 'Facebook', 'soledad' ); ?></span></a>
								<a target="_blank" href="<?php echo esc_url( $twitter_share ); ?>"><i class="fa fa-twitter"></i><span class="dt-share"><?php esc_html_e( 'Twitter', 'soledad' ); ?></span></a>
								<a target="_blank" href="<?php echo esc_url( $google_share ); ?>"><i class="fa fa-google-plus"></i><span class="dt-share"><?php esc_html_e( 'Google +', 'soledad' ); ?></span></a>
								<a target="_blank" href="<?php echo esc_url( $pinterest_share ); ?>"><i class="fa fa-pinterest"></i><span class="dt-share"><?php esc_html_e( 'Pinterest', 'soledad' ); ?></span></a>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</article>
		<?php endwhile; ?>
	</div>

	<?php if ( get_theme_mod( 'penci_portfolio_single_enable_sidebar' ) ) : ?><?php get_sidebar(); ?><?php endif; ?>

<?php get_footer(); ?>