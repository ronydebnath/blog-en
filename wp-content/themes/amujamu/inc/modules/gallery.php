<?php
if ( ! class_exists( 'Penci_Add_Options_To_Gallery_Setting' ) ) {
	class Penci_Add_Options_To_Gallery_Setting {
		/**
		 * Stores the class instance.
		 *
		 * @var Penci_Add_Options_To_Gallery_Setting
		 */
		private static $instance = null;


		/**
		 * Returns the instance of this class.
		 *
		 * It's a singleton class.
		 *
		 * @return Penci_Add_Options_To_Gallery_Setting The instance
		 */
		public static function get_instance() {

			if ( ! self::$instance )
				self::$instance = new self;

			return self::$instance;
		}

		/**
		 * Initialises the plugin.
		 */
		public function init_plugin() {

			$this->init_hooks();
		}

		/**
		 * Initialises the WP actions.
		 *  - admin_print_scripts
		 */
		private function init_hooks() {

			add_action( 'wp_enqueue_media', array( $this, 'wp_enqueue_media' ) );
			add_action( 'print_media_templates', array( $this, 'print_media_templates' ) );
		}


		/**
		 * Enqueues the script.
		 */
		public function wp_enqueue_media() {

			if ( ! isset( get_current_screen()->id ) || get_current_screen()->base != 'post' )
				return;

			wp_enqueue_script( 'penci-custom-gallery-options', get_template_directory_uri() . '/js/admin-gallery.js', array( 'jquery', 'media-views' ) );

		}

		/**
		 * Outputs the view template with the custom setting.
		 */
		public function print_media_templates() {

			if ( ! isset( get_current_screen()->id ) || get_current_screen()->base != 'post' )
				return;

			?>
			<script type="text/html" id="tmpl-penci-custom-gallery-options">
				<label class="setting type">
					<span>Style</span>
					<select class="type" name="type" data-setting="type">
						<?php
						$sizes = apply_filters( 'image_size_names_choose', array(
							'justified'     => 'Justified',
							'masonry'       => 'Masonry',
							'grid'          => 'Grid',
							'single-slider' => 'Single Slider',
							'none'          => 'None'
						) );

						foreach ( $sizes as $value => $name ) { ?>
							<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, 'justified' ); ?>>
								<?php echo esc_html( $name ); ?>
							</option>
						<?php } ?>
					</select>
				</label>
			</script>
		<?php
		}

	}

	add_action( 'admin_init', array( Penci_Add_Options_To_Gallery_Setting::get_instance(), 'init_plugin' ), 20 );
}