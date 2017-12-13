<?php
/**
 * This template will display category page
 *
 * @package Wordpress
 * @since 1.0
 */

get_header();

/* Sidebar position */
$sidebar_position = 'right-sidebar';
if( get_theme_mod( "penci_left_sidebar_archive" ) ) { $sidebar_position = 'left-sidebar'; }

/* Categories layout */
$layout_this = get_theme_mod( 'penci_archive_layout' );
if ( ! isset( $layout_this ) || empty( $layout_this ) ): $layout_this = 'standard'; endif;

$category_oj = get_queried_object();
$fea_cat_id = $category_oj->term_id;
$cat_meta   = get_option( "category_$fea_cat_id" );
$cat_layout = isset( $cat_meta['cat_layout'] ) ? $cat_meta['cat_layout'] : '';
if( $cat_layout != '' ):
	$layout_this = $cat_layout;
endif;

$class_layout = '';
if( $layout_this == 'classic' ): $class_layout = ' classic-layout'; endif;
?>

	<?php if( ! get_theme_mod( 'penci_disable_breadcrumb' ) ): ?>
		<div class="container penci-breadcrumb">
			<span><a class="crumb" href="<?php echo esc_url( home_url('/') ); ?>"><?php echo penci_get_setting( 'penci_trans_home' ); ?></a></span><i class="fa fa-angle-right"></i>
			<?php
			$parent_ID = penci_get_category_parent_id( $fea_cat_id );
			if( $parent_ID ):
			echo penci_get_category_parents( $parent_ID );
			endif;
			?>
			<span><?php single_cat_title('', true); ?></span>
		</div>
	<?php endif; ?>

	<div class="container<?php echo esc_attr( $class_layout ); if ( penci_get_setting( 'penci_sidebar_archive' ) ) : ?> penci_sidebar <?php echo esc_attr( $sidebar_position ); ?><?php endif; ?>">
		<div id="main" class="penci-layout-<?php echo esc_attr( $layout_this ); ?><?php if ( get_theme_mod( 'penci_sidebar_sticky' ) ): ?> penci-main-sticky-sidebar<?php endif; ?>">
			<div class="theiaStickySidebar">
				<div class="archive-box">
					<div class="title-bar">
						<?php if( ! get_theme_mod( 'penci_remove_cat_words' ) ): ?><span><?php echo penci_get_setting( 'penci_trans_category' ); ?></span> <?php endif; ?>
						<h1><?php printf( esc_html__( '%s', 'soledad' ), single_cat_title( '', false ) ); ?></h1>
					</div>
				</div>

				<?php if ( category_description() ) : // Show an optional category description ?>
					<div class="post-entry penci-category-description"><?php echo do_shortcode( category_description() ); ?></div>
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