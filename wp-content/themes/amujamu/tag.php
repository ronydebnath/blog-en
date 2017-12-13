<?php
/**
 * The template for displaying tag pages.
 *
 * @package Wordpress
 * @since 1.0
 */
get_header();

/* Sidebar position */
$sidebar_position = 'right-sidebar';
if( get_theme_mod( "penci_left_sidebar_archive" ) ) { $sidebar_position = 'left-sidebar'; }

/* Tag layout */
$layout_this = get_theme_mod( 'penci_archive_layout' );
if ( ! isset( $layout_this ) || empty( $layout_this ) ): $layout_this = 'standard'; endif;
$class_layout = '';
if( $layout_this == 'classic' ): $class_layout = ' classic-layout'; endif;
?>

	<?php if( ! get_theme_mod( 'penci_disable_breadcrumb' ) ): ?>
		<div class="container penci-breadcrumb">
			<span><a class="crumb" href="<?php echo esc_url( home_url('/') ); ?>"><?php echo penci_get_setting( 'penci_trans_home' ); ?></a></span><i class="fa fa-angle-right"></i>
			<span><?php echo penci_get_setting( 'penci_trans_tags' ); ?></span><i class="fa fa-angle-right"></i>
			<span><?php printf( penci_get_setting( 'penci_trans_posts_tagged' ) . ' "%s"', single_tag_title( '', false ) ); ?></span>
		</div>
	<?php endif; ?>

	<div class="container<?php echo esc_attr( $class_layout ); if ( penci_get_setting( 'penci_sidebar_archive' ) ) : ?> penci_sidebar <?php echo esc_attr( $sidebar_position ); ?><?php endif; ?>">
		<div id="main" class="penci-layout-<?php echo esc_attr( $layout_this ); ?><?php if ( get_theme_mod( 'penci_sidebar_sticky' ) ): ?> penci-main-sticky-sidebar<?php endif; ?>">
			<div class="theiaStickySidebar">
				<div class="archive-box">
					<div class="title-bar">
						<span><?php echo penci_get_setting( 'penci_trans_tag' ); ?> </span>
						<h1><?php printf( esc_html__( '%s', 'soledad' ), single_tag_title( '', false ) ); ?></h1>
					</div>
				</div>

				<?php if ( tag_description() ) : // Show an optional tag description ?>
					<div class="penci-category-description align-center"><?php echo tag_description(); ?></div>
				<?php endif; ?>

				<?php echo penci_render_google_adsense( 'penci_archive_ad_above' ); ?>

				<?php if ( have_posts() ) : ?>
					<?php if( in_array( $layout_this, array( 'mixed', 'mixed-2', 'overlay-grid', 'overlay-list', 'photography', 'grid', 'grid-2', 'list', 'boxed-1', 'boxed-2', 'boxed-3', 'standard-grid', 'standard-grid-2', 'standard-list', 'standard-boxed-1', 'classic-grid', 'classic-grid-2', 'classic-list', 'classic-boxed-1', 'magazine-1', 'magazine-2' ) ) ) : ?><ul class="penci-grid"><?php endif; ?>
					<?php if( in_array( $layout_this, array( 'masonry', 'masonry-2' ) ) ) : ?><div class="penci-wrap-masonry"><div class="masonry penci-masonry"><?php endif; ?>

					<?php /* The loop */
					while ( have_posts() ) : the_post();
						include( locate_template( 'content-' . $layout_this . '.php' ) );
					endwhile;
					?>

					<?php if( in_array( $layout_this, array( 'masonry', 'masonry-2' ) ) ) : ?></div></div><?php endif; ?>
					<?php if( in_array( $layout_this, array( 'mixed', 'mixed-2', 'overlay-grid', 'overlay-list', 'photography', 'grid', 'grid-2', 'list', 'boxed-1', 'boxed-2', 'boxed-3', 'standard-grid', 'standard-grid-2', 'standard-list', 'standard-boxed-1', 'classic-grid', 'classic-grid-2', 'classic-list', 'classic-boxed-1', 'magazine-1', 'magazine-2' ) ) ) : ?></ul><?php endif; ?>

					<?php penci_soledad_pagination(); ?>
				<?php endif; wp_reset_postdata(); /* End if of the loop */ ?>

				<?php echo penci_render_google_adsense( 'penci_archive_ad_below' ); ?>

			</div>
		</div>

	<?php if ( penci_get_setting( 'penci_sidebar_archive' ) ) : ?><?php get_sidebar(); ?><?php endif; ?>

<?php get_footer(); ?>