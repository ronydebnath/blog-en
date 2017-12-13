<?php
/**
 * Comments template
 *
 * @package Wordpress
 * @since 1.0
 */

// Get numbers comments
$comment_numbers = get_comments_number();
?>
<div class="post-comments<?php if( $comment_numbers == 0 ): echo ' no-comment-yet'; endif;?>" id="comments">
	<?php
	if ( comments_open() && ( $comment_numbers > 0 ) ) :
		echo '<div class="post-title-box"><h4 class="post-box-title">';
		comments_number( '0 ' . penci_get_setting( 'penci_trans_comment' ), '1 '. penci_get_setting( 'penci_trans_comment' ), '% ' . penci_get_setting( 'penci_trans_comments' ) );
		echo '</h4></div>';

		echo "<div class='comments'>";
		wp_list_comments( array(
			'avatar_size' => 100,
			'max_depth'   => 5,
			'style'       => 'div',
			'callback'    => 'penci_comments_template',
			'type'        => 'all'
		) );
		echo "</div>";

	endif;

	echo "<div id='comments_pagination'>";
	paginate_comments_links( array( 'prev_text' => '&laquo;', 'next_text' => '&raquo;' ) );
	echo "</div>";

	/* Custom field */
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );

	$fields =  array(
		'author' => '<p class="comment-form-author"><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" placeholder="' . penci_get_setting( 'penci_trans_name' ) . '" size="30"' . $aria_req . ' /></p>',

		'email' => '<p class="comment-form-email"><input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" placeholder="' . penci_get_setting( 'penci_trans_email' ) . '" size="30"' . $aria_req . ' /></p>',

		'url' => '<p class="comment-form-url"><input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" placeholder="' . penci_get_setting( 'penci_trans_website' ) . '" size="30" /></p>',
	);
	$custom_comment_field = '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" placeholder="' . penci_get_setting( 'penci_trans_your_comment' ) . '" aria-required="true"></textarea></p>';  //label removed for cleaner layout


	comment_form( array(
		'comment_field'        => $custom_comment_field,
		'comment_notes_after'  => '',
		'logged_in_as'         => '',
		'comment_notes_before' => '',
		'title_reply'          => '<span>' . penci_get_setting( 'penci_trans_leave_a_comment' ) . '</span>',
		'cancel_reply_link'    => penci_get_setting( 'penci_trans_cancel_reply' ),
		'label_submit'         => penci_get_setting( 'penci_trans_submit' ),
		'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
	) );
	?>
</div> <!-- end comments div -->
