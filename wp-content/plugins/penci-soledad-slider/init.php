<?php
/*
Plugin Name: Penci Slider
Plugin URI: http://pencidesign.com/
Description: Add new 2 styles slider for Soledad theme. Activate this plugin, add new slides and go to Appearance > Customize > Featured Slider Options > Choose Penci Slider Style 1 or Penci Slider Style 2 to use
Version: 1.0
Author: PenciDesign
Author URI: http://themeforest.net/user/pencidesign?ref=pencidesign
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

/**
 * Define
 */
define( 'PENCI_SLIDER_DIR', plugin_dir_path( __FILE__ ) );
define( 'PENCI_SLIDER_URL', plugin_dir_url( __FILE__ ) );

/**
 * Penci_Slider_Main_Class Class
 *
 * This class will run main modules of plugin
 */
if ( ! class_exists( 'Penci_Slider_Main_Class' ) ) :

	class Penci_Slider_Main_Class {

		/**
		 * Global plugin version
		 */
		static $version = '1.0';

		/**
		 * Penci_Slider_Main_Class Constructor.
		 *
		 * @access public
		 * @return Penci_Slider_Main_Class
		 * @since  1.0
		 */
		public function __construct() {
			// Include files
			include_once( 'penci-slider-func.php' );

			// Register PenciSlider Post Type
			add_action( 'init', array( $this, 'register_pencislider_post_type' ) );

			// Add pencislider meta
			add_action( 'add_meta_boxes', array( $this, 'pencislider_meta_boxes' ) );

			// Change default column title
			add_filter( 'manage_penci_slider_posts_columns', array( $this, 'penci_slider_modify_table_title' ) );

			// Add columns to manage columns pencislider
			add_filter( 'manage_edit-penci_slider_columns', array( $this, 'add_columns_penci_slider' ) );

			// Custom columns pencislider
			add_action( 'manage_penci_slider_posts_custom_column', array( $this, 'penci_slider_custom_columns' ), 10, 2 );

			// Ajax action to update reorder
			add_action( 'wp_ajax_penci_update_slide_order', array( $this, 'penci_slider_update_order' ) );

			// Reorder default columns pencislider in backend
			add_filter( 'pre_get_posts', array( $this, 'set_penci_slider_admin_order' ) );
		}

		/**
		 * Register PenciSlider Post Type
		 * @since 1.0
		 */
		public function register_pencislider_post_type() {
			$labels = array(
				'name'          => __( 'Slides', 'taxonomy general name', 'pencidesign' ),
				'singular_name' => __( 'Slide', 'pencidesign' ),
				'search_items'  => __( 'Search Slides', 'pencidesign' ),
				'all_items'     => __( 'All Slides', 'pencidesign' ),
				'parent_item'   => __( 'Parent Slide', 'pencidesign' ),
				'edit_item'     => __( 'Edit Slide', 'pencidesign' ),
				'update_item'   => __( 'Update Slide', 'pencidesign' ),
				'add_new_item'  => __( 'Add New Slide', 'pencidesign' ),
				'menu_name'     => __( 'Penci Slider', 'pencidesign' )
			);

			$pencislider_icon = PENCI_SLIDER_URL . '/images/penci-icon.png';

			$args = array(
				'labels'              => $labels,
				'singular_label'      => __( 'Penci Slider', 'pencidesign' ),
				'public'              => false,
				'show_ui'             => true,
				'hierarchical'        => false,
				'menu_position'       => 10,
				'menu_icon'           => $pencislider_icon,
				'exclude_from_search' => true,
				'supports'            => false
			);

			register_post_type( 'penci_slider', $args );
		}

		/**
		 * Add pencislider meta boxes
		 *
		 * @access public
		 * @return void
		 * @since  1.0
		 */
		public function pencislider_meta_boxes() {
			$meta_box = array(
				'id'          => 'pencislider-meta',
				'title'       => __( 'Slide Settings', 'pencidesign' ),
				'description' => __( 'Choose image and fill to fields bellow to save all slide settings', 'pencidesign' ),
				'post_type'   => 'penci_slider',
				'context'     => 'normal',
				'priority'    => 'high',
				'fields'      => array(
					array(
						'name' => __( 'Slide Image', 'pencidesign' ),
						'desc' => __( 'The image should be between 1600px - 2000px in width and have a minimum height of 650px for best results. Click the "Upload" button to begin uploading your image', 'pencidesign' ),
						'id'   => '_penci_slider_image',
						'type' => 'file',
						'std'  => ''
					),
					array(
						'name' => __( 'Slide Title', 'pencidesign' ),
						'desc' => __( 'Fill the slide title', 'pencidesign' ),
						'id'   => '_penci_slider_title',
						'type' => 'text',
						'std'  => ''
					),
					array(
						'name' => __( 'Slide Title Color', 'pencidesign' ),
						'desc' => __( 'Color for Slide Title', 'pencidesign' ),
						'id'   => '_penci_slider_title_color',
						'type' => 'color',
						'std'  => '#ffffff'
					),
					array(
						'name' => __( 'Slide Caption', 'pencidesign' ),
						'desc' => __( 'Fill the slide caption', 'pencidesign' ),
						'id'   => '_penci_slider_caption',
						'type' => 'textarea',
						'std'  => ''
					),
					array(
						'name' => __( 'Slide Caption Color', 'pencidesign' ),
						'desc' => __( 'Color for Slide Caption', 'pencidesign' ),
						'id'   => '_penci_slider_caption_color',
						'type' => 'color',
						'std'  => '#ffffff'
					),
					array(
						'name' => __( 'Button Text', 'pencidesign' ),
						'desc' => __( 'If you would like a button to appear below your slide caption, please fill the text for it here.', 'pencidesign' ),
						'id'   => '_penci_slider_button',
						'type' => 'text',
						'std'  => ''
					),
					array(
						'name' => __( 'Button Background Color', 'pencidesign' ),
						'desc' => __( 'Background for Button', 'pencidesign' ),
						'id'   => '_penci_slider_button_bg',
						'type' => 'color',
						'std'  => '#BF9F5A'
					),
					array(
						'name' => __( 'Button Text Color', 'pencidesign' ),
						'desc' => __( 'Text Color for Button', 'pencidesign' ),
						'id'   => '_penci_slider_button_text_color',
						'type' => 'color',
						'std'  => '#ffffff'
					),
					array(
						'name' => __( 'Button Link', 'pencidesign' ),
						'desc' => __( 'Fill the URL for slide button here.', 'pencidesign' ),
						'id'   => '_penci_slider_button_url',
						'type' => 'text',
						'std'  => ''
					),
					array(
						'name'    => __( 'Slide Alignment', 'pencidesign' ),
						'desc'    => __( 'Select the alignment for your caption and button.', 'pencidesign' ),
						'id'      => '_penci_slide_alignment',
						'type'    => 'select',
						'options' => array(
							'left'   => 'Left',
							'center' => 'Center',
							'right'  => 'Right',
						),
						'std'     => 'center'
					),
					array(
						'name'    => __( 'Elements Animation', 'pencidesign' ),
						'desc'    => __( 'Choose Animation of Slide title, Caption and Button when slide is active', 'pencidesign' ),
						'id'      => '_penci_slide_element_animation',
						'type'    => 'select',
						'options' => array(
							'fadeInUp'    => 'fadeInUp',
							'fadeInDown'  => 'fadeInDown',
							'fadeInLeft'  => 'fadeInLeft',
							'fadeInRight' => 'fadeInRight',
						),
						'std'     => 'fadeInUp'
					)
				)
			);
			$callback = create_function( '$post,$meta_box', 'pencislider_create_meta_box( $post, $meta_box["args"] );' );
			add_meta_box( $meta_box['id'], $meta_box['title'], $callback, $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
		}

		/**
		 * Change title default for Actions
		 *
		 * @access public
		 * @return array new $defaults
		 * @since  1.0
		 */
		public function penci_slider_modify_table_title( $defaults ) {
			$defaults['title'] = 'Actions';

			return $defaults;
		}

		/**
		 * Add thumbnail & caption columns
		 *
		 * @access public
		 * @return array $columns
		 * @since  1.0
		 */
		public function add_columns_penci_slider( $columns ) {
			$column_thumbnail = array( 'thumbnail' => 'Thumbnail' );
			$column_caption   = array( 'caption' => 'Caption' );
			$columns          = array_slice( $columns, 0, 1, true ) + $column_thumbnail + array_slice( $columns, 1, null, true );
			$columns          = array_slice( $columns, 0, 2, true ) + $column_caption + array_slice( $columns, 2, null, true );

			return $columns;
		}

		/**
		 * Enqueue media to use choose image in a slide
		 *
		 * @access public
		 * @return void
		 * @since  1.0
		 */
		public function penci_slider_custom_columns( $column, $post_id ) {
			switch ( $column ) {
				case 'thumbnail':
					$thumbnail = get_post_meta( $post_id, '_penci_slider_image', true );

					if ( ! empty( $thumbnail ) ) {
						echo '<a href="' . get_admin_url() . 'post.php?post=' . $post_id . '&action=edit"><img class="slider-thumb" src="' . $thumbnail . '" /></a>';
					}
					else {
						echo '<a href="' . get_admin_url() . 'post.php?post=' . $post_id . '&action=edit"><img class="slider-thumb" src="' . get_template_directory() . '/images/no-thumb.jpg" /></a>' . '<strong><a class="row-title" href="' . get_admin_url() . 'post.php?post=' . $post_id . '&action=edit">' . __( 'No image', 'pencidesign' ) . '</a></strong>';
					}
					break;

				case 'caption':
					$caption = get_post_meta( $post_id, '_penci_slider_caption', true );
					$title   = get_post_meta( $post_id, '_penci_slider_title', true );
					echo '<h2>' . $title . '</h2><p>' . $caption . '</p>';
					break;

				default:
					break;
			}
		}

		/**
		 * Reorder ajax callback
		 * @return void
		 * @since 1.1
		 */
		public function penci_slider_update_order() {
			global $wpdb;

			$post_type = $_POST['postType'];
			$order     = $_POST['order'];

			if ( ! is_array( $order ) || $post_type != 'penci_slider' )
				return;

			foreach ( $order as $menu_order => $post_id ) {
				$post_id    = intval( str_ireplace( 'post-', '', $post_id ) );
				$menu_order = intval( $menu_order );

				wp_update_post( array(
					'ID'         => stripslashes( htmlspecialchars( $post_id ) ),
					'menu_order' => stripslashes( htmlspecialchars( $menu_order ) )
				) );
			}
			die( '1' );
		}

		/**
		 * Order the default penci slider page correctly
		 * @return void
		 * @since 1.0
		 */
		public function set_penci_slider_admin_order( $wp_query ) {
			if ( is_admin() ) {
				$post_type = '';
				if( isset( $wp_query->query['post_type'] ) ):
					$post_type = $wp_query->query['post_type'];
				endif;

				if ( $post_type == 'penci_slider' ) {
					$wp_query->set( 'orderby', 'menu_order' );
					$wp_query->set( 'order', 'ASC' );
				}
			}
		}

	}

	new Penci_Slider_Main_Class();

endif; // End Check if Class Not Exists