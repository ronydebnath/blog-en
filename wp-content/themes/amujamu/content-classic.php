<?php
/**
 * Content classic homepage, archive page
 *
 * @since 1.0
 */
$block_style = get_theme_mod('penci_blockquote_style') ? get_theme_mod('penci_blockquote_style') : 'style-1';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="header-standard header-classic">
		<?php if ( ! get_theme_mod( 'penci_standard_cat' ) ) : ?>
			<div class="penci-standard-cat"><span class="cat"><?php penci_category( '' ); ?></span></div>
		<?php endif; ?>

		<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

		<?php if ( ! get_theme_mod( 'penci_standard_author' ) ) : ?>
			<div class="author-post"><span><?php echo penci_get_setting( 'penci_trans_written_by' ); ?> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a></span></div>
		<?php endif; ?>
	</div>

	<?php if( ! get_theme_mod( 'penci_standard_thumbnail' ) ): ?>

		<?php if ( has_post_format( 'link' ) || has_post_format( 'quote' ) ) : ?>
			<div class="standard-post-special<?php if ( has_post_format( 'quote' ) ): ?> penci-special-format-quote<?php endif; ?><?php if ( ! has_post_thumbnail() || get_theme_mod( 'penci_standard_thumbnail' ) ) : echo ' no-thumbnail'; endif; ?>">
				<?php if ( has_post_thumbnail() && ! get_theme_mod( 'penci_standard_thumbnail' ) ) : ?>
					<?php if( ! get_theme_mod( 'penci_disable_lazyload_layout' ) ) { ?>
					<a <?php if( get_theme_mod( 'penci_standard_thumb_crop' ) ): ?> class="penci-image-holder penci-lazy" data-src="<?php echo penci_get_featured_image_size( get_the_ID(), 'penci-full-thumb' ); ?>"<?php endif; ?> href="<?php the_permalink() ?>">
						<?php if( ! get_theme_mod( 'penci_standard_thumb_crop' ) ): ?><img class="attachment-penci-full-thumb size-penci-full-thumb penci-lazy wp-post-image" src="<?php echo get_template_directory_uri() . '/images/penci2-holder.png'; ?>" alt="<?php wp_strip_all_tags( the_title() ); ?>" data-src="<?php echo penci_get_featured_image_size( get_the_ID(),	'penci-full-thumb' ); ?>"><?php endif; ?>
					</a>
					<?php } else { ?>
					<a <?php if( get_theme_mod( 'penci_standard_thumb_crop' ) ): ?> class="penci-image-holder" style="background-image: url('<?php echo penci_get_featured_image_size( get_the_ID(), 'penci-full-thumb' ); ?>');"<?php endif; ?> href="<?php the_permalink() ?>">
						<?php if( ! get_theme_mod( 'penci_standard_thumb_crop' ) ): ?><?php the_post_thumbnail( 'penci-full-thumb' ); ?><?php endif; ?>
					</a>
					<?php } ?>
				<?php endif; ?>
				<div class="standard-content-special">
					<?php if ( has_post_format( 'quote' ) ): ?><a href="<?php the_permalink();?>"><?php endif; ?>
						<div class="format-post-box<?php if ( has_post_format( 'quote' ) ) { echo ' penci-format-quote'; } else { echo ' penci-format-link'; } ?>">
							<span class="post-format-icon"><i class="fa fa-<?php if ( has_post_format( 'quote' ) ) { echo 'quote-left'; } else { echo 'link'; } ?>"></i></span>
							<p class="dt-special">
								<?php
								if ( has_post_format( 'quote' ) ) {
									$dt_content = get_post_meta( get_the_ID(), '_format_quote_source_name', true );
									if ( ! empty( $dt_content ) ): echo sanitize_text_field( $dt_content ); endif;
								}
								else {
									$dt_content = get_post_meta( get_the_ID(), '_format_link_url', true );
									if ( ! empty( $dt_content ) ):
										echo '<a href="'. esc_url( get_permalink() ) .'">'. sanitize_text_field( $dt_content ) .'</a>';
									endif;
								}
								?>
							</p>
							<?php
							if ( has_post_format( 'quote' ) ):
								$quote_author = get_post_meta( get_the_ID(), '_format_quote_source_url', true );
								if ( ! empty( $quote_author ) ):
									echo '<div class="author-quote"><span>' . sanitize_text_field( $quote_author ) . '</span></div>';
								endif;
							endif; ?>
						</div>
						<?php if ( has_post_format( 'quote' ) ): ?></a><?php endif; ?>
				</div>
			</div>

		<?php elseif ( has_post_format( 'gallery' ) ) : ?>

			<?php $images = get_post_meta( get_the_ID(), '_format_gallery_images', true ); ?>

			<?php if ( $images ) : ?>
				<div class="standard-post-image">
					<div class="penci-owl-carousel penci-owl-carousel-slider penci-nav-visible" data-auto="true">
						<?php foreach ( $images as $image ) : ?>

							<?php $the_image = wp_get_attachment_image_src( $image, 'penci-full-thumb' ); ?>
							<?php $the_caption = get_post_field( 'post_excerpt', $image ); ?>
							<figure class="penci-gallery-images" alt="<?php the_title(); ?>"<?php if ($the_caption) : ?> title="<?php echo esc_attr( $the_caption ); ?>"<?php endif; ?>>
								<img src="<?php echo esc_url( $the_image[0] ); ?>" alt="<?php the_title(); ?>">
							</figure>

						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

		<?php elseif ( has_post_format( 'video' ) ) : ?>

			<div class="standard-post-image video-post">
				<?php $penci_video = get_post_meta( get_the_ID(), '_format_video_embed', true ); ?>
				<?php if ( wp_oembed_get( $penci_video ) ) : ?>
					<?php echo wp_oembed_get( $penci_video ); ?>
				<?php else : ?>
					<?php echo $penci_video; ?>
				<?php endif; ?>
			</div>

		<?php elseif ( has_post_format( 'audio' ) ) : ?>

			<div class="standard-post-image audio<?php if ( ! has_post_thumbnail() ) : echo ' no-thumbnail'; endif; ?>">
				<?php if ( has_post_thumbnail() ) : ?>
				<?php if( ! get_theme_mod( 'penci_disable_lazyload_layout' ) ) { ?>
					<a <?php if( get_theme_mod( 'penci_standard_thumb_crop' ) ): ?> class="penci-image-holder penci-lazy" data-src="<?php echo penci_get_featured_image_size( get_the_ID(), 'penci-full-thumb' ); ?>"<?php endif; ?> href="<?php the_permalink() ?>">
						<?php if( ! get_theme_mod( 'penci_standard_thumb_crop' ) ): ?><img class="attachment-penci-full-thumb size-penci-full-thumb penci-lazy wp-post-image" src="<?php echo get_template_directory_uri() . '/images/penci2-holder.png'; ?>" alt="<?php wp_strip_all_tags( the_title() ); ?>" data-src="<?php echo penci_get_featured_image_size( get_the_ID(),	'penci-full-thumb' ); ?>"><?php endif; ?>
					</a>
				<?php } else { ?>
					<a <?php if( get_theme_mod( 'penci_standard_thumb_crop' ) ): ?> class="penci-image-holder" style="background-image: url('<?php echo penci_get_featured_image_size( get_the_ID(), 'penci-full-thumb' ); ?>');"<?php endif; ?> href="<?php the_permalink() ?>">
						<?php if( ! get_theme_mod( 'penci_standard_thumb_crop' ) ): ?><?php the_post_thumbnail( 'penci-full-thumb' ); ?><?php endif; ?>
					</a>
				<?php } ?>
				<?php endif; ?>
				<div class="audio-iframe">
					<?php $penci_audio = get_post_meta( get_the_ID(), '_format_audio_embed', true );
					$penci_audio_str = substr( $penci_audio, -4 );
					?>
					<?php if ( wp_oembed_get( $penci_audio ) ) : ?>
						<?php echo wp_oembed_get( $penci_audio ); ?>
					<?php elseif( $penci_audio_str == '.mp3' ) : ?>
						<?php echo do_shortcode('[audio src="'. esc_url( $penci_audio ) .'"]'); ?>
					<?php else : ?>
						<?php echo $penci_audio; ?>
					<?php endif; ?>
				</div>
			</div>

		<?php else : ?>

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="standard-post-image">
					<?php if( ! get_theme_mod( 'penci_disable_lazyload_layout' ) ) { ?>
						<a <?php if( get_theme_mod( 'penci_standard_thumb_crop' ) ): ?> class="penci-image-holder penci-lazy" data-src="<?php echo penci_get_featured_image_size( get_the_ID(), 'penci-full-thumb' ); ?>"<?php endif; ?> href="<?php the_permalink() ?>">
							<?php if( ! get_theme_mod( 'penci_standard_thumb_crop' ) ): ?><img class="attachment-penci-full-thumb size-penci-full-thumb penci-lazy wp-post-image" src="<?php echo get_template_directory_uri() . '/images/penci2-holder.png'; ?>" alt="<?php wp_strip_all_tags( the_title() ); ?>" data-src="<?php echo penci_get_featured_image_size( get_the_ID(),	'penci-full-thumb' ); ?>"><?php endif; ?>
						</a>
					<?php } else { ?>
						<a <?php if( get_theme_mod( 'penci_standard_thumb_crop' ) ): ?> class="penci-image-holder" style="background-image: url('<?php echo penci_get_featured_image_size( get_the_ID(), 'penci-full-thumb' ); ?>');"<?php endif; ?> href="<?php the_permalink() ?>">
							<?php if( ! get_theme_mod( 'penci_standard_thumb_crop' ) ): ?><?php the_post_thumbnail( 'penci-full-thumb' ); ?><?php endif; ?>
						</a>
					<?php } ?>
				</div>
			<?php endif; ?>

		<?php endif; /* End Thumbnail */ ?>
	<?php endif; ?>

	<div class="standard-content">
		<div class="standard-main-content">
			<div class="post-entry standard-post-entry classic-post-entry <?php echo 'blockquote-'. $block_style; ?>">
				<?php if( get_theme_mod( 'penci_standard_auto_excerpt' ) ) { ?>
					<?php the_excerpt(); ?>
					<div class="penci-more-link"><a href="<?php the_permalink(); ?>" class="more-link"><?php echo penci_get_setting( 'penci_trans_continue_reading' ); ?></a></div>
				<?php } else { ?>
				<?php the_content( penci_get_setting( 'penci_trans_continue_reading' ) ); ?>
				<?php wp_link_pages(); ?>
				<?php } ?>
			</div>
		</div>

		<?php if ( ! get_theme_mod( 'penci_standard_share_box' ) || ! get_theme_mod( 'penci_standard_date' ) || ! get_theme_mod( 'penci_standard_comment' ) ) : ?>
			<div class="penci-post-box-meta<?php if( get_theme_mod( 'penci_standard_share_box' ) || ( get_theme_mod( 'penci_standard_date' ) && get_theme_mod( 'penci_standard_comment' ) ) ): echo ' center-inner'; endif; ?>">
				<?php if ( ! get_theme_mod( 'penci_standard_date' ) || ! get_theme_mod( 'penci_standard_comment' ) ) : ?>
					<div class="penci-box-meta">
						<?php if ( ! get_theme_mod( 'penci_standard_date' ) ) : ?>
							<span><i class="fa fa-clock-o"></i><?php the_time( get_option('date_format') ); ?></span>
						<?php endif; ?>
						<?php if ( ! get_theme_mod( 'penci_standard_comment' ) ) : ?>
							<span><a href="<?php comments_link(); ?> "><i class="fa fa-comment-o"></i><?php comments_number( '0 ' . penci_get_setting( 'penci_trans_comment' ), '1 '. penci_get_setting( 'penci_trans_comment' ), '% ' . penci_get_setting( 'penci_trans_comments' ) ); ?></a></span>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				<?php if ( ! get_theme_mod( 'penci_standard_share_box' ) ) : ?>
					<div class="penci-post-share-box">
						<?php echo penci_getPostLikeLink( get_the_ID() ); ?>
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
						$pinterest_image = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
						$pinterest_share = 'https://pinterest.com/pin/create/button/?url=' . get_the_permalink() . '&media=' . $pinterest_image . '&description=' . get_the_title();
						?>
						<a target="_blank" href="<?php echo esc_url( $facebook_share ); ?>"><i class="fa fa-facebook"></i><span class="dt-share"><?php esc_html_e( 'Facebook', 'soledad' ); ?></span></a>
						<a target="_blank" href="<?php echo esc_url( $twitter_share ); ?>"><i class="fa fa-twitter"></i><span class="dt-share"><?php esc_html_e( 'Twitter', 'soledad' ); ?></span></a>
						<a target="_blank" href="<?php echo esc_url( $google_share ); ?>"><i class="fa fa-google-plus"></i><span class="dt-share"><?php esc_html_e( 'Google +', 'soledad' ); ?></span></a>
						<a data-pin-do="none" target="_blank" href="<?php echo esc_url( $pinterest_share ); ?>"><i class="fa fa-pinterest"></i><span class="dt-share"><?php esc_html_e( 'Pinterest', 'soledad' ); ?></span></a>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>

</article>