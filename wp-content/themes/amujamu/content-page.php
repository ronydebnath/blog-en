<?php
/**
 * This is content page will display in loop of page.php file
 * Don't edit this file, let create child theme and override it
 *
 * @since 1.0
 */

$pagetitle = get_post_meta( $post->ID, 'penci_page_display_title', true );
$sharebox = get_post_meta( $post->ID, 'penci_page_sharebox', true );
$block_style = get_theme_mod('penci_blockquote_style') ? get_theme_mod('penci_blockquote_style') : 'style-1';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if( get_the_title() && ( 'no' != $pagetitle ) ): ?>
	<div class="penci-page-header">
		<h1><?php the_title(); ?></h1>
	</div>
	<?php endif; ?>

	<?php if ( ( function_exists( 'has_post_thumbnail' ) ) && ( has_post_thumbnail() ) ) : ?>
		<div class="post-image">
			<a href="<?php the_permalink() ?>">
				<img class="attachment-penci-full-thumb size-penci-full-thumb penci-lazy wp-post-image" src="<?php echo get_template_directory_uri() . '/images/penci2-holder.png'; ?>" alt="<?php wp_strip_all_tags( the_title() ); ?>" data-src="<?php echo penci_get_featured_image_size( get_the_ID(),	'penci-full-thumb' ); ?>">
			</a>
		</div>
	<?php endif; ?>

	<div class="post-entry <?php echo 'blockquote-'. $block_style; ?><?php if( get_theme_mod( 'penci_page_comments' ) && get_theme_mod( 'penci_page_share' ) ): echo ' page-has-margin'; endif; ?>">
		<div class="inner-post-entry">
			<?php the_content(); ?>
			<?php wp_link_pages(); ?>
		</div>
	</div>

	<?php if ( ! get_theme_mod( 'penci_page_share' ) && ( 'no' != $sharebox ) ) : ?>
		<div class="tags-share-box hide-tags page-share<?php if( ! comments_open() || get_theme_mod( 'penci_page_comments' ) ): echo ' has-line'; endif; ?>">
			<div class="post-share">
				<span class="share-title"><?php echo penci_get_setting( 'penci_trans_share' ); ?></span>
				<div class="list-posts-share">
					<?php
					$twitter_text = 'Check out this article';
					if( get_theme_mod( 'penci_post_twitter_share_text' ) ){
						$twitter_text = get_theme_mod( 'penci_post_twitter_share_text' );
					}
					$twitter_text = trim( $twitter_text );
					$twitter_text_process = str_replace( ' ', '%20', $twitter_text );
					$facebook_share  = 'https://www.facebook.com/sharer/sharer.php?u=' . get_the_permalink();
					$twitter_share   = 'https://twitter.com/intent/tweet?text=' . $twitter_text_process . ':%20' . get_the_title() . '%20-%20' . get_the_permalink();
					$google_share    = 'https://plus.google.com/share?url=' . get_the_permalink();
					$pinterest_image = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
					$pinterest_share = 'https://pinterest.com/pin/create/button/?url=' . get_the_permalink() . '&media=' . $pinterest_image . '&description=' . get_the_title();
					?>
					<a target="_blank" href="<?php echo esc_url( $facebook_share ); ?>"><i class="fa fa-facebook"></i><span class="dt-share"><?php esc_html_e( 'Facebook', 'soledad' ); ?></span></a>
					<a target="_blank" href="<?php echo esc_url( $twitter_share ); ?>"><i class="fa fa-twitter"></i><span class="dt-share"><?php esc_html_e( 'Twitter', 'soledad' ); ?></span></a>
					<a target="_blank" href="<?php echo esc_url( $google_share ); ?>"><i class="fa fa-google-plus"></i><span class="dt-share"><?php esc_html_e( 'Google +', 'soledad' ); ?></span></a>
					<a data-pin-do="none" target="_blank" href="<?php echo esc_url( $pinterest_share ); ?>"><i class="fa fa-pinterest"></i><span class="dt-share"><?php esc_html_e( 'Pinterest', 'soledad' ); ?></span></a>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( ! get_theme_mod( 'penci_page_comments' ) ) : ?>
		<?php comments_template( '', true ); ?>
	<?php endif; ?>

</article>