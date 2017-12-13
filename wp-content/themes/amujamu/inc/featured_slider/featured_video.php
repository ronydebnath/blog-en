<?php
/**
 * Featured video background
 * When featured video background is enable, it will disable featured slider
 *
 * @since 1.0
 */

$video_url = get_theme_mod( 'penci_featured_video_url' );
$start_time = get_theme_mod( 'penci_featured_video_start' );
if( ! is_numeric( $start_time ) || ! $start_time ) { $start_time = '0'; }

$mute = 'true';
if ( get_theme_mod( 'penci_featured_video_audio' ) ): $mute = 'false'; endif;

$video_property = "{videoURL:'". esc_url( $video_url ) ."',containment:'self', showControls:false, autoPlay:true, loop:true, mute:". esc_attr( $mute ) .", startAt:". absint( $start_time ) .", opacity:1, addRaster:true, quality:'default'}";
?>
<div class="featured-area featured-video">
	<div class="featured-video-background<?php if( get_theme_mod( 'penci_featured_video_img_mobile' ) ): ?> has-bg-image<?php endif; ?>" id="penci-featured-video-bg" data-property="<?php echo esc_attr( $video_property ); ?>">
		<?php if( get_theme_mod( 'penci_featured_video_img_mobile' ) ): ?>
			<div class="penci-video-overlay-background" style="background-image: url('<?php echo get_theme_mod( 'penci_featured_video_img_mobile' ); ?>');"></div>
		<?php endif; ?>
		<?php if( get_theme_mod( 'penci_featured_video_text_heading' ) || get_theme_mod( 'penci_featured_video_sub_heading' ) || get_theme_mod( 'penci_featured_video_image' ) ): ?>
			<div class="penci-video-overlay">
				<?php if( get_theme_mod( 'penci_featured_video_image' ) ): ?>
					<div class="penci-video-custom-img<?php if( ! get_theme_mod( 'penci_featured_video_text_heading' ) && ! get_theme_mod( 'penci_featured_video_sub_heading' ) ): echo ' no-margin-bottom'; endif; ?>">
						<img src="<?php echo get_theme_mod( 'penci_featured_video_image' ); ?>" alt="Video Image" />
					</div>
				<?php endif; ?>
				<?php if( get_theme_mod( 'penci_featured_video_text_heading' ) ): ?>
					<h2 class="penci-heading-video"><?php echo get_theme_mod( 'penci_featured_video_text_heading' ); ?></h2>
				<?php endif; ?>
				<?php if( get_theme_mod( 'penci_featured_video_sub_heading' ) ): ?>
					<p class="penci-sub-heading-video"><?php echo get_theme_mod( 'penci_featured_video_sub_heading' ); ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</div>