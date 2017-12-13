<?php
/**
 * Penci Recipe Shortcode
 * Use penci_recipe to display the recipe on single a post
 */
function penci_recipe_shortcode_function( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'id' => ''
	), $atts ) );

	$recipe_id = get_the_ID();
	if ( ! empty( $id ) && is_numeric( $id ) ) {
		$recipe_id = $id;
	}

	// Get recipe meta
	$recipe_title = get_post_meta( $recipe_id, 'penci_recipe_title', true );
	$recipe_servings = get_post_meta( $recipe_id, 'penci_recipe_servings', true );
	$recipe_cooktime = get_post_meta( $recipe_id, 'penci_recipe_cooktime', true );
	$recipe_cooktime_fm = get_post_meta( $recipe_id, 'penci_recipe_cooktime_format', true );
	$recipe_preptime = get_post_meta( $recipe_id, 'penci_recipe_preptime', true );
	$recipe_preptime_fm = get_post_meta( $recipe_id, 'penci_recipe_preptime_format', true );
	$recipe_ingredients = get_post_meta( $recipe_id, 'penci_recipe_ingredients', true );
	$recipe_instructions = get_post_meta( $recipe_id, 'penci_recipe_instructions', true );
	$recipe_note = get_post_meta( $recipe_id, 'penci_recipe_note', true );

	// Turn ingredients into an array
	$recipe_ingredients_array = '';
	if( $recipe_ingredients ):
	$recipe_ingredients_array = preg_split( '/\r\n|[\r\n]/', $recipe_ingredients );
	endif;

	$rand = rand(100, 9999);
	wp_enqueue_script('jquery-recipe-print');
	ob_start(); ?>
	
	<div class="wrapper-penci-recipe">
		<div class="penci-recipe" id="printrepcipe<?php echo $rand; ?>" itemscope itemtype="http://schema.org/Recipe">
			<div class="penci-recipe-heading">
				<?php if ( $recipe_title ) : ?>
					<h2 itemprop="name"><?php echo $recipe_title; ?></h2>
				<?php endif; ?>

				<?php if ( has_post_thumbnail() ): ?>
				<img style="display: none !important;" itemprop="image" src="<?php the_post_thumbnail_url( 'thumbnail' ); ?>" width="50" height="50"/>
				<?php endif; ?>

				<?php if ( ! get_theme_mod( 'penci_recipe_print' ) ) : ?>
					<a href="#" class="penci-recipe-print" data-print="<?php echo plugin_dir_url( __FILE__ ) . 'print.css'; ?>"><i class="fa fa-print"></i> <?php if( get_theme_mod( 'penci_recipe_print_text' ) ) { echo do_shortcode( get_theme_mod( 'penci_recipe_print_text' ) ); } else { esc_html_e( 'Print This', 'soledad' ); } ?></a>
				<?php endif; ?>

				<?php if ( $recipe_servings || $recipe_cooktime || $recipe_preptime ) : ?>
					<div class="penci-recipe-meta">
						<?php if ( $recipe_servings ) : ?><span>
							<i class="fa fa-user"></i> <?php if( get_theme_mod( 'penci_recipe_serves_text' ) ) { echo do_shortcode( get_theme_mod( 'penci_recipe_serves_text' ) ); } else { esc_html_e( 'Serves', 'soledad' ); } ?>: <span class="servings" itemprop="recipeYield"><?php echo
								$recipe_servings; ?></span>
							</span>
						<?php endif; ?>
						<?php if ( $recipe_preptime ) : ?>
							<span>
							<i class="fa fa-clock-o"></i> <?php if( get_theme_mod( 'penci_recipe_prep_time_text' ) ) { echo do_shortcode( get_theme_mod( 'penci_recipe_prep_time_text' ) ); } else { esc_html_e( 'Prep Time', 'soledad' ); } ?>: <time <?php if( $recipe_preptime_fm ): echo 'datetime="PT'. $recipe_preptime_fm .'" '; endif;?>itemprop="prepTime"><?php echo $recipe_preptime; ?></time>
							</span>
						<?php endif; ?>
						<?php if ( $recipe_cooktime ) : ?>
							<span>
							<i class="fa fa-clock-o"></i> <?php if( get_theme_mod( 'penci_recipe_cooking_text' ) ) { echo do_shortcode( get_theme_mod( 'penci_recipe_cooking_text' ) ); } else { esc_html_e( 'Cooking Time', 'soledad' ); } ?>: <time <?php if( $recipe_cooktime_fm ): echo 'datetime="PT' . $recipe_cooktime_fm .'" '; endif;?>itemprop="cookTime"><?php echo $recipe_cooktime; ?></time>
							</span>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( $recipe_ingredients ) : ?>
				<div class="penci-recipe-ingredients<?php if( get_theme_mod( 'penci_recipe_ingredients_visual' ) ): echo ' penci-recipe-ingre-visual'; endif; ?>">
					<h3 class="penci-recipe-title"><?php if( get_theme_mod( 'penci_recipe_ingredients_text' ) ) { echo do_shortcode( get_theme_mod( 'penci_recipe_ingredients_text' ) ); } else { esc_html_e( 'Ingredients', 'soledad' ); } ?></h3>
					<?php if( ! get_theme_mod( 'penci_recipe_ingredients_visual' ) ){ ?>
					<ul>
						<?php foreach ( $recipe_ingredients_array as $ingredient ) : ?>
							<?php if ( $ingredient ) : ?>
								<li><span itemprop="recipeIngredient"><?php echo $ingredient; ?></span></li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
					<?php } else { ?>
						<?php
						echo apply_filters( 'the_content', htmlspecialchars_decode( $recipe_ingredients ) );
						?>
					<?php } ?>
				</div>
			<?php endif; ?>

			<?php if ( $recipe_instructions ) : ?>
				<div class="penci-recipe-method" itemprop="recipeInstructions">
					<h3 class="penci-recipe-title"><?php if( get_theme_mod( 'penci_recipe_instructions_text' ) ) { echo do_shortcode( get_theme_mod( 'penci_recipe_instructions_text' ) ); } else { esc_html_e( 'Instructions', 'soledad' ); } ?></h3>
					<?php
					echo apply_filters( 'the_content', htmlspecialchars_decode( $recipe_instructions ) );
					?>
				</div>
			<?php endif; ?>

			<?php if ( $recipe_note ) : ?>
				<div class="penci-recipe-notes">
					<h3 class="penci-recipe-title"><?php if( get_theme_mod( 'penci_recipe_notes_text' ) ) { echo do_shortcode( get_theme_mod( 'penci_recipe_notes_text' ) ); } else { esc_html_e( 'Notes', 'soledad' ); } ?></h3>
					<p><?php echo $recipe_note; ?></p>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<?php
	return ob_get_clean();
}

add_shortcode( 'penci_recipe', 'penci_recipe_shortcode_function' );


/**
 * Penci Recipe Index
 *
 * Use penci_index to display the recipe on single a post
 */
function penci_recipe_index_function( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'title'         => '',
		'cat'           => '',
		'numbers_posts' => '',
		'columns'       => '',
		'display_title' => 'yes',
		'display_cat'   => 'no',
		'display_date'  => 'yes',
		'display_image' => 'yes',
		'image_size'    => 'square',
		'cat_link'      => 'yes',
		'cat_link_text' => 'View All'
	), $atts ) );

	$index_title = isset( $title ) ? $title : '';
	$index_cat = isset( $cat ) ? $cat : '';
	$index_numbers_posts = isset( $numbers_posts ) ? $numbers_posts : '3';
	$index_cols = isset( $columns ) ? $columns : '3';
	$index_display_title = isset( $display_title ) ? $display_title : 'yes';
	$index_display_cat = isset( $display_cat ) ? $display_cat : 'no';
	$index_display_date = isset( $display_date ) ? $display_date : 'yes';
	$index_display_image = isset( $display_image ) ? $display_image : 'yes';
	$index_image_size = isset( $image_size ) ? $image_size : 'square';
	$index_cat_link = isset( $cat_link ) ? $cat_link : 'yes';
	$index_cat_text = isset( $cat_link_text ) ? $cat_link_text : 'View All';

	$index_query = new WP_Query( array(
		'category_name' => $index_cat,
		'posts_per_page' => $index_numbers_posts,
		'ignore_sticky_posts' => true
	) );

	ob_start();

	$cat_link = '';
	$open_link = '';
	$close_link = '';
	if($index_cat) :
		$index_cat = do_shortcode( $index_cat );
		$catOj = get_category_by_slug($index_cat);
		$cat_id = $catOj->term_id;
		$cat_link = get_category_link( $cat_id );
	endif;

	if ( $index_cat_link == "yes" && $cat_link ):
		$open_link = '<a href="'. esc_url( $cat_link ) .'">';
		$close_link = '</a>';
	endif;
	?>

	<?php if ( $index_query->have_posts() ) : ?>
	<div class="penci-recipe-index-wrap">
		<?php if ( $index_title ) : ?>
			<h4 class="recipe-index-heading"><span><?php echo $open_link. do_shortcode( $index_title ) . $close_link; ?></span></h4>
		<?php endif; ?>

		<?php
		/* Define columns of recipe index */
		$columns_class = '3';
		if( $index_cols == '2' || $index_cols == '4' ) {
			$columns_class = $index_cols;
		}
		?>
		<ul class="penci-recipe-index column-<?php echo $columns_class; ?>">
			<?php while ( $index_query->have_posts() ) : $index_query->the_post(); ?>
				<li>
					<article id="post-<?php the_ID(); ?>" <?php post_class('penci-recipe-item'); ?>>
						<?php if ( $index_display_image != 'no' && function_exists( 'penci_get_featured_image_size' ) ) : ?>
							<div class="penci-index-post-img">
								<?php $thumbnail_size = 'penci-thumb-square';
								if( $index_image_size == 'vertical' ) {
									$thumbnail_size = 'penci-thumb-vertical';
								} elseif( $index_image_size == 'horizontal' ) {
									$thumbnail_size = 'penci-thumb';
								}
								?>
								<?php if( ! get_theme_mod( 'penci_disable_lazyload_layout' ) ) { ?>
								<a href="<?php the_permalink(); ?>" class="penci-image-holder penci-holder-size-<?php echo $index_image_size; ?> penci-lazy" data-src="<?php echo penci_get_featured_image_size( get_the_ID(), $thumbnail_size ); ?>" title="<?php echo wp_strip_all_tags( get_the_title() ); ?>"></a>
								<?php } else { ?>
								<a href="<?php the_permalink(); ?>" class="penci-image-holder penci-holder-size-<?php echo $index_image_size; ?>" style="background-image: url('<?php echo penci_get_featured_image_size( get_the_ID(), $thumbnail_size ); ?>');" title="<?php echo wp_strip_all_tags( get_the_title() ); ?>"></a>
								<?php } ?>
							</div>
						<?php endif; /* End check for thumbnails */ ?>

						<?php if($index_display_cat == 'yes') : ?>
							<span class="cat"><?php penci_category( '' ); ?></span>
						<?php endif; ?>

						<?php if($index_display_title != 'no') : ?>
							<h2 class="penci-recipe-index-title"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h2>
						<?php endif; ?>

						<?php if($index_display_date != 'no') : ?>
							<span class="date"><?php the_time( get_option('date_format') ); ?></span>
						<?php endif; ?>
					</article>
				</li>
			<?php endwhile; ?>
		</ul>
		<?php if ( $index_cat_link == "yes" && $cat_link ) : ?>
			<div class="penci-index-more-link"><a href="<?php echo esc_url( $cat_link ); ?>"><?php echo do_shortcode( $index_cat_text ); ?> <i class="fa fa-long-arrow-right"></i></a></div>
		<?php endif; ?>

	</div>
	<?php wp_reset_postdata(); ?>
	<?php endif; ?>
	<?php
	return ob_get_clean();
}

add_shortcode( 'penci_index', 'penci_recipe_index_function' );
