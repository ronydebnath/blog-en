<?php
/**
 * Template Name: Page No Sidebar
 */
get_header();
$breadcrumb = get_post_meta( get_the_ID(), 'penci_page_breadcrumb', true );
$featured_boxes = get_post_meta( get_the_ID(), 'penci_page_display_featured_boxes', true );
$page_meta = get_post_meta( get_the_ID(), 'penci_page_slider', true );
$rev_shortcode = get_post_meta( get_the_ID(), 'penci_page_rev_shortcode', true );

if( in_array( $page_meta, array('style-1', 'style-2', 'style-3', 'style-4', 'style-5', 'style-6', 'style-7', 'style-8', 'style-9', 'style-10', 'style-11', 'style-12', 'style-13', 'style-14', 'style-15', 'style-16', 'style-17', 'style-18', 'style-19', 'style-20', 'style-21', 'style-22', 'style-23', 'style-24', 'style-25',	'style-26', 'style-27', 'style-28', 'style-29', 'style-30',	'style-31', 'style-32', 'style-33', 'style-34', 'video' ) ) ) {
	if( $page_meta == 'video' && get_theme_mod( 'penci_featured_video_url' ) ) {
		get_template_part( 'inc/featured_slider/featured_video' );
	} else {
		if( ( $page_meta == 'style-33' || $page_meta == 'style-34' ) && $rev_shortcode ) {
			echo '<div class="featured-area featured-' . $page_meta . '">';
			if( $page_meta == 'style-34' ): echo '<div class="container">'; endif;
			echo do_shortcode( $rev_shortcode );
			if( $page_meta == 'style-34' ): echo '</div>'; endif;
			echo '</div>';
		} else {
			if ( get_theme_mod( 'penci_body_boxed_layout' ) ) {
				if( $page_meta == 'style-3' ) {
					$page_meta == 'style-1';
				} elseif( $page_meta == 'style-5' ) {
					$page_meta == 'style-4';
				} elseif( $page_meta == 'style-7' ) {
					$page_meta == 'style-8';
				} elseif( $page_meta == 'style-9' ) {
					$page_meta == 'style-10';
				} elseif( $page_meta == 'style-11' ) {
					$page_meta == 'style-12';
				} elseif( $page_meta == 'style-13' ) {
					$page_meta == 'style-14';
				} elseif( $page_meta == 'style-15' ) {
					$page_meta == 'style-16';
				} elseif( $page_meta == 'style-17' ) {
					$page_meta == 'style-18';
				} elseif( $page_meta == 'style-29' ) {
					$page_meta == 'style-30';
				}
			}
			$slider_class = $page_meta;
			if( $page_meta == 'style-5' ) {
				$slider_class = 'style-4 style-5';
			} elseif ( $page_meta == 'style-30' ) {
				$slider_class = 'style-29 style-30';
			}
			$data_auto = 'false';
			$data_loop = 'true';
			$data_res = '';

			if( $page_meta == 'style-7' || $page_meta == 'style-8' ){
				$data_res = ' data-item="4" data-desktop="4" data-tablet="2" data-tabsmall="1"';
			} elseif( $page_meta == 'style-9' || $page_meta == 'style-10' ){
				$data_res = ' data-item="3" data-desktop="3" data-tablet="2" data-tabsmall="1"';
			} elseif( $page_meta == 'style-11' || $page_meta == 'style-12' ){
				$data_res = ' data-item="2" data-desktop="2" data-tablet="2" data-tabsmall="1"';
			} elseif( $page_meta == 'style-31' || $page_meta == 'style-32' ) {
				$data_res = ' data-dots="true" data-nav="false"';
				if( get_theme_mod( 'penci_enable_next_prev_penci_slider' ) ):
					$data_res = ' data-dots="true" data-nav="true"';
				endif;
			}

			if( get_theme_mod( 'penci_featured_autoplay' ) ): $data_auto = 'true'; endif;
			if( get_theme_mod( 'penci_featured_loop' ) ): $data_loop = 'false'; endif;
			$auto_time = get_theme_mod( 'penci_featured_slider_auto_time' );
			if( !is_numeric( $auto_time ) ): $auto_time = '4000'; endif;
			$auto_speed = get_theme_mod( 'penci_featured_slider_auto_speed' );
			if( !is_numeric( $auto_speed ) ): $auto_speed = '600'; endif;
			$open_container = '';
			$close_container = '';
			if( in_array( $page_meta, array( 'style-1', 'style-4', 'style-6', 'style-8', 'style-10', 'style-12', 'style-14', 'style-16', 'style-18', 'style-19', 'style-20', 'style-21', 'style-22', 'style-23', 'style-24', 'style-25', 'style-26', 'style-27', 'style-30', 'style-32' ) ) ):
				$open_container = '<div class="container">';
				$close_container = '</div>';
			endif;

			echo '<div class="featured-area featured-' . $slider_class . '">' . $open_container;
			echo '<div class="penci-owl-carousel penci-owl-featured-area"'. $data_res .' data-style="'. $page_meta .'" data-auto="'. $data_auto .'" data-autotime="'. $auto_time .'" data-speed="'. $auto_speed .'" data-loop="'. $data_loop .'">';
			get_template_part( 'inc/featured_slider/' . $page_meta );
			echo '</div>';
			echo $close_container. '</div>';
		}
	}
}

/* Display Featured Boxes */
if ( $featured_boxes == 'yes' && ! get_theme_mod( 'penci_home_hide_boxes' ) && ( get_theme_mod( 'penci_home_box_img1' ) || get_theme_mod( 'penci_home_box_img2' ) || get_theme_mod( 'penci_home_box_img3' ) || get_theme_mod( 'penci_home_box_img4' ) ) ):
	get_template_part( 'inc/modules/home_boxes' );
endif;

?>

	<?php if ( ! get_theme_mod( 'penci_disable_breadcrumb' ) && ( 'no' != $breadcrumb ) ): ?>
		<div class="container container-single-page penci-breadcrumb">
			<span><a class="crumb" href="<?php echo esc_url( home_url('/') ); ?>"><?php echo penci_get_setting( 'penci_trans_home' ); ?></a></span><i class="fa fa-angle-right"></i>
			<?php
			$page_parent = get_post_ancestors( get_the_ID() );
			if( ! empty( $page_parent ) ):
				$page_parent = array_reverse($page_parent);
				foreach( $page_parent as $pages ){
			?>
				<span><a class="crumb" href="<?php echo get_permalink( $pages ); ?>"><?php echo get_the_title( $pages ); ?></a></span><i class="fa fa-angle-right"></i>
			<?php }
			endif; ?>
			<span><?php the_title(); ?></span>
		</div>
	<?php endif; ?>

	<div class="container container-single-page container-single-page-full-width">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php get_template_part('content', 'page'); ?>
		<?php endwhile; endif; ?>

<?php get_footer(); ?>