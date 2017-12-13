<?php
/**
 * All functions for Penci Review Plugin
 * @since 1.0
 */

/**
 * Get review average score for a posts
 *
 * @param $post_id
 * @return string
 */
function penci_get_review_average_score( $post_id ){
	// Get review data
	$review_1 = get_post_meta( $post_id, 'penci_review_1', true );
	$review_1num = get_post_meta( $post_id, 'penci_review_1_num', true );
	$review_2 = get_post_meta( $post_id, 'penci_review_2', true );
	$review_2num = get_post_meta( $post_id, 'penci_review_2_num', true );
	$review_3 = get_post_meta( $post_id, 'penci_review_3', true );
	$review_3num = get_post_meta( $post_id, 'penci_review_3_num', true );
	$review_4 = get_post_meta( $post_id, 'penci_review_4', true );
	$review_4num = get_post_meta( $post_id, 'penci_review_4_num', true );
	$review_5 = get_post_meta( $post_id, 'penci_review_5', true );
	$review_5num = get_post_meta( $post_id, 'penci_review_5_num', true );

	$total_score = 0;
	$total_num = 0;

	if( $review_1 && $review_1num ):
		$total_score = $total_score + $review_1num;
		$total_num = $total_num + 1;
	endif;
	if( $review_2 && $review_2num ):
		$total_score = $total_score + $review_2num;
		$total_num = $total_num + 1;
	endif;
	if( $review_3 && $review_3num ):
		$total_score = $total_score + $review_3num;
		$total_num = $total_num + 1;
	endif;
	if( $review_4 && $review_4num ):
		$total_score = $total_score + $review_4num;
		$total_num = $total_num + 1;
	endif;
	if( $review_5 && $review_5num ):
		$total_score = $total_score + $review_5num;
		$total_num = $total_num + 1;
	endif;

	$total_review = 0;
	if( $total_score && $total_num ) {
		$total_review = $total_score / $total_num;
	}

	return $total_review;
}

/**
 * Get review markup piechart for a posts
 * Use this function in a loop
 *
 * @param $post_id
 * @return string
 */
function penci_display_piechart_review_html( $post_id, $size = 'normal' ){
	$total_score = penci_get_review_average_score( $post_id );
	if( empty( $total_score ) || get_theme_mod('penci_review_hide_piechart') )
		return;
	$format = number_format( $total_score, 1, '.', '' );
	$percent =	$format * 10;

	$pie_size = 50;
	if( $size == 'small' ) {
		$pie_size = 34;
	} else {
		$pie_size = 50;
	}

	$color = '#6eb48c';
	if( get_theme_mod('penci_color_accent') ):
		$color = get_theme_mod('penci_color_accent');
	endif;
	if( get_theme_mod('penci_review_piechart_border') ):
		$color = get_theme_mod('penci_review_piechart_border');
	endif;
?>
	<div class="penci-piechart penci-piechart-<?php echo $size; ?>" data-percent="<?php echo $percent; ?>" data-color="<?php echo $color; ?>" data-trackcolor="rgba(0, 0, 0, .2)" data-size="<?php echo $pie_size; ?>" data-thickness="<?php if( $size == 'small' ){ echo '2'; }else{ echo '3'; }?>">
		<span class="penci-chart-text"><?php echo $format; ?></span>
	</div>
<?php
}