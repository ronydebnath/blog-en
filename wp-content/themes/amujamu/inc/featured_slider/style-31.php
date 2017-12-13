<?php
/**
 * Template part for Slider Style 31
 */

$number       = get_theme_mod( 'penci_featured_slider_slides' );
if( ! $number ): $number = -1; endif;
$penci_slider_height = get_theme_mod( 'penci_featured_penci_slider_height' );
if( ! $penci_slider_height || ! is_numeric( $penci_slider_height ) ): $penci_slider_height = 550; endif;
$orderby = 'menu_order';
if( get_theme_mod( 'penci_featured_slider_random' ) ):
	$orderby = 'rand';
endif;

$featured_args = array(
	'post_type' => 'penci_slider',
	'order'     => 'ASC',
	'orderby'   => $orderby,
	'posts_per_page' => $number
);

$feat_query = new WP_Query( $featured_args );
?>
<?php if ( $feat_query->have_posts() ) : while ( $feat_query->have_posts() ) : $feat_query->the_post(); ?>
	<?php
	/* Get data of this slide */
	$image_url    = get_post_meta( $post->ID, '_penci_slider_image', true ); $image_url    = ! $image_url ? '' : $image_url;
	$slider_title = get_post_meta( $post->ID, '_penci_slider_title', true ); $slider_title = ! $slider_title ? '' : $slider_title;
	$caption      = get_post_meta( $post->ID, '_penci_slider_caption', true ); $caption      = ! $caption ? '' : $caption;
	$button_text  = get_post_meta( $post->ID, '_penci_slider_button', true ); $button_text  = ! $button_text ? '' : $button_text;
	$title_color  = get_post_meta( $post->ID, '_penci_slider_title_color', true ); $title_style  = ! $title_color ? '' : ' style="color: '. $title_color .'"';
	$title_bgcolor  = get_post_meta( $post->ID, '_penci_slider_title_bgcolor', true ); $title_bgcolor  = ! $title_bgcolor ? '' : ' style="background-color: '. penci_cover_hex_to_rgb( $title_bgcolor, '0.4' ) .'"';
	$caption_color  = get_post_meta( $post->ID, '_penci_slider_caption_color', true ); $caption_style  = ! $caption_color ? '' : ' style="color: '. $caption_color .'"';
	$caption_bgcolor  = get_post_meta( $post->ID, '_penci_slider_caption_bgcolor', true ); $caption_bgcolor  = ! $caption_bgcolor ? '' : ' style="background-color: '. penci_cover_hex_to_rgb( $caption_bgcolor, '0.4' ) .'"';
	$button_bg  = get_post_meta( $post->ID, '_penci_slider_button_bg', true ); $button_bg  = ! $button_bg ? '' : 'background: '. $button_bg.';';
	$button_color  = get_post_meta( $post->ID, '_penci_slider_button_text_color', true ); $button_color  = ! $button_color ? '' : 'color: '. $button_color;
	$animation  = get_post_meta( $post->ID, '_penci_slide_element_animation', true ); $animation  = ! $animation ? 'fadeInUp' : $animation;

	$style_button = '';
	if( !empty( $button_bg ) || !empty( $button_color ) ): $style_button = ' style="'. $button_bg . $button_color .'"'; endif;
	$button_html  = '';

	if ( ! empty( $button_text ) ) {
		$button_html = '<div class="penci-button"><a class="pencislider-button"'.$style_button.'>' . sanitize_text_field( do_shortcode( $button_text ) ) . '</a></div>';
		$button_url  = get_post_meta( $post->ID, '_penci_slider_button_url', true );
		$button_url  = ! $button_url ? '' : $button_url;
		if ( ! empty( $button_url ) ):
			$button_html = '<div class="penci-button"><a class="pencislider-button"'.$style_button.' href="' . esc_url( do_shortcode( $button_url ) ) . '">' . sanitize_text_field( do_shortcode( $button_text ) ) . '</a></div>';
		endif;
	}
	$slider_align = get_post_meta( $post->ID, '_penci_slide_alignment', true );
	$slider_align = ! $slider_align ? 'center' : $slider_align;

	$buttonlink_url  = get_post_meta( $post->ID, '_penci_slider_button_url', true );
	$open_link_html = '';
	$close_link_html = '';
	if( $buttonlink_url ) {
		$open_link_html = '<a href="'. esc_url( do_shortcode( $buttonlink_url ) ) .'">';
		$close_link_html = '</a>';
	}

	if( !empty( $image_url ) ):
	?>
	<div class="item pencislider-item">
		<?php if( ! get_theme_mod( 'penci_disable_lazyload_slider' ) ) { ?>
			<div class="penci-image-holder owl-lazy" data-src="<?php echo esc_url( $image_url ); ?>" style="height: <?php echo $penci_slider_height; ?>px;"></div>
		<?php } else { ?>
			<div class="penci-image-holder" style="background-image: url('<?php echo esc_url( $image_url ); ?>'); height: <?php echo $penci_slider_height; ?>px;"></div>
		<?php }?>

		<div class="pencislider-container penci-<?php echo esc_attr( $animation );?> align-<?php echo esc_attr( $slider_align ); ?>">
			<div class="pencislider-content">
				<?php if( !empty( $slider_title ) ): ?>
					<h2 class="pencislider-title"<?php echo ( $title_style ); ?>><?php echo $open_link_html . '<span class="pencititle-inner-bg"'. $title_bgcolor .'>' . sanitize_text_field( do_shortcode( $slider_title ) ) . '</span>' . $close_link_html; ?></h2>
				<?php endif; ?>
				<?php if( !empty( $caption ) ): ?>
					<p class="pencislider-caption"<?php echo ( $caption_style ); ?>><span class="pencicaption-inner-bg"<?php echo $caption_bgcolor; ?>><?php echo sanitize_text_field( do_shortcode( $caption ) ); ?></span></p>
				<?php endif; ?>
				<?php echo ( $button_html ); ?>
			</div>
		</div>
	</div>
	<?php endif; /* Igrone if doesn't exists image */ ?>
<?php endwhile; wp_reset_postdata(); endif; ?>
