<?php
/**
 * Display detail author of current post
 * Use in single post
 *
 * @since 1.0
 */
?>
<div class="post-author">
	<div class="author-img">
		<?php echo get_avatar( get_the_author_meta( 'email' ), '100' ); ?>
	</div>
	<div class="author-content">
		<h5><?php the_author_posts_link(); ?></h5>
		<p><?php the_author_meta( 'description' ); ?></p>
		<?php if ( get_the_author_meta( 'user_url' ) ) : ?>
			<a target="_blank" class="author-social" href="<?php the_author_meta( 'user_url'); ?>"><i class="fa fa-globe"></i></a>
		<?php endif; ?>
		<?php if ( get_the_author_meta( 'facebook' ) ) : ?>
			<a target="_blank" class="author-social" href="http://facebook.com/<?php echo esc_attr( the_author_meta( 'facebook' ) ); ?>"><i class="fa fa-facebook"></i></a>
		<?php endif; ?>
		<?php if ( get_the_author_meta( 'twitter' ) ) : ?>
			<a target="_blank" class="author-social" href="http://twitter.com/<?php echo esc_attr( the_author_meta( 'twitter' ) ); ?>"><i class="fa fa-twitter"></i></a>
		<?php endif; ?>
		<?php if ( get_the_author_meta( 'google' ) ) : ?>
			<a target="_blank" class="author-social" href="http://plus.google.com/<?php echo esc_attr( the_author_meta( 'google' ) ); ?>?rel=author"><i class="fa fa-google-plus"></i></a>
		<?php endif; ?>
		<?php if ( get_the_author_meta( 'instagram' ) ) : ?>
			<a target="_blank" class="author-social" href="http://instagram.com/<?php echo esc_attr( the_author_meta( 'instagram' ) ); ?>"><i class="fa fa-instagram"></i></a>
		<?php endif; ?>
		<?php if ( get_the_author_meta( 'pinterest' ) ) : ?>
			<a target="_blank" class="author-social" href="http://pinterest.com/<?php echo esc_attr( the_author_meta( 'pinterest' ) ); ?>"><i class="fa fa-pinterest"></i></a>
		<?php endif; ?>
		<?php if ( get_the_author_meta( 'tumblr' ) ) : ?>
			<a target="_blank" class="author-social" href="http://<?php echo esc_attr( the_author_meta( 'tumblr' ) ); ?>.tumblr.com/"><i class="fa fa-tumblr"></i></a>
		<?php endif; ?>
	</div>
</div>