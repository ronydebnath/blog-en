<?php
/**
 * Plugin Name: Penci Soledad Demo Importer
 * Plugin URI: http://pencidesign.com/
 * Description: One click import demo content
 * Author: PenciDesign
 * Author URI: http://themeforest.net/user/pencidesign?ref=pencidesign
 * Version: 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main class for importing demo content
 *
 * @version 1.0.0
 */
class Penci_Soledad_Demo_Importer {
	/**
	 * Demo data configuration
	 *
	 * @var array
	 */
	public $data;

	/**
	 * Construction function
	 * Add new  submenu under Appearance menu
	 */
	public function __construct() {

		require_once dirname( __FILE__ ) . '/import.php';

		$this->data = apply_filters( 'penci_soledad_demo_packages', array() );

		add_action( 'admin_menu', array( $this, 'menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );

		add_action( 'wp_ajax_penci_soledad_download_file', array( $this, 'ajax_download_file' ) );
		add_action( 'wp_ajax_penci_soledad_import', array( $this, 'ajax_import' ) );
		add_action( 'wp_ajax_penci_soledad_config_theme', array( $this, 'ajax_config_theme' ) );
		add_action( 'wp_ajax_penci_soledad_get_images', array( $this, 'ajax_get_images' ) );
		add_action( 'wp_ajax_penci_soledad_generate_image', array( $this, 'ajax_generate_image' ) );
	}

	/**
	 * Add new menu under Appearance menu
	 */
	public function menu() {
		if ( empty( $this->data ) ) {
			return;
		}

		add_theme_page(
			esc_html__( 'Import Demo Data', 'penci_soledad' ),
			esc_html__( 'Import Demo Data', 'penci_soledad' ),
			'edit_theme_options',
			'import-demo-content',
			array( $this, 'page' )
		);
	}

	/**
	 * Load scripts
	 */
	public function scripts( $hook ) {
		if ( 'appearance_page_import-demo-content' != $hook ) {
			return;
		}

		wp_enqueue_style( 'penci-soledad-import', plugins_url( 'assets/css/penci-import.css', __FILE__ ) );
		wp_enqueue_script( 'penci-soledad-import', plugins_url( 'assets/js/penci-import.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );
	}

	/**
	 * Admin page for importing demo content
	 */
	public function page() {
		if ( isset( $_GET['step'] ) ) {
			$this->import_demo_page();
		} else {
			$this->select_demo_page();
		}
	}

	/**
	 * HTML for select demo page
	 */
	private function select_demo_page() {
		?>

		<div class="wrap">
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

			<div class="updated notice is-dismissible">
				<p>
					<?php esc_html_e( 'Before start importing, you have to install all required plugins or all plugins that you want to use come with this theme', 'penci_soledad' ) ?><br>
					<?php esc_html_e( 'If your site has old data, you should not do this, because the demo data will appears on your current site', 'penci_soledad' ) ?><br>
				</p>
				<button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php _e( 'Dismiss this notice.', 'penci_soledad' ) ?></span></button>
			</div>

			<div class="demos-container">

				<p class="description"><?php _e( 'It usally take few minutes to finish. Please be patient.', 'penci_soledad' ) ?></p>

				<?php foreach( $this->data as $demo => $data ) : ?>

					<form action="<?php echo esc_url( add_query_arg( array( 'step' => 2 ) ) ) ?>" method="post" class="demo-selector">
						<?php wp_nonce_field( 'penci_soledad_import_demo' ); ?>
						<input type="hidden" name="demo" value="<?php echo esc_attr( $demo ) ?>">

						<div class="demo-image">
							<img src="<?php echo esc_url( $data['preview'] ) ?>">
						</div>

						<div class="demo-selector-tools">
							<div class="demo-install-progress"></div>
							<div class="demo-install-actions">
								<input type="submit" class="button button-primary" value="<?php _e( 'Import', 'penci_soledad' ) ?>">
								<h2 class="demo-title"><?php echo $data['name'] ?></h2>
								<div class="clear"></div>
							</div>
						</div>
					</form>

				<?php endforeach; ?>

			</div>

		</div>

		<?php
	}

	/**
	 * HTML for import demo page
	 */
	private function import_demo_page() {
		if ( ! check_admin_referer( 'penci_soledad_import_demo' ) ) {
			printf(
				'<div class="notice warning"><p>%s <a href="%s">%s</a></p></div>',
				esc_html__( 'Are you sure want to do this?', 'penci_soledad' ),
				remove_query_arg( 'step' ),
				esc_html__( 'Please try again', 'penci_soledad' )
			);
			return;
		}

		$demo = $_POST['demo'];
		if ( ! array_key_exists( $demo, $this->data ) ) {
			printf(
				'<div class="notice warning"><p>%s <a href="%s">%s</a></p></div>',
				esc_html__( 'This import is invalid.', 'penci_soledad' ),
				remove_query_arg( 'step' ),
				esc_html__( 'Please try again', 'penci_soledad' )
			);
			return;
		}
		?>

		<div class="wrap">
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

			<form id="penci-soledad-demo-importer" class="hidden" method="post">
				<input type="hidden" name="demo" value="<?php echo esc_attr( $_POST['demo'] ) ?>">
				<?php wp_nonce_field( 'penci_soledad_demo_import' ) ?>
			</form>


			<div id="penci-soledad-demo-import-progress" class="notice warning notice-warning">
				<p>
					<span class="spinner is-active"></span>
					<span class="text"><?php esc_html_e( 'Starting...', 'penci_soledad' ) ?></span>
				</p>
			</div>

			<div id="penci-soledad-demo-import-log" class="penci-soledad-demo-log"></div>
		</div>

		<?php
	}

	/**
	 * Import content
	 * Import posts, pages, menus, custom post types
	 *
	 * @param  string $file The exported file's name
	 */
	public function import_content( $file ) {
		// Disable import of authors.
		add_filter( 'wxr_importer.pre_process.user', '__return_false' );

		// Disables generation of multiple image sizes (thumbnails) in the content import step.
		add_filter( 'intermediate_image_sizes_advanced', '__return_null' );

		if ( ! file_exists( $file ) ) {
			return false;
		}

		// Import content.
		if ( ! class_exists( 'Penci_Demo_Content_Importer' ) ) {
			require_once plugin_dir_path( __FILE__ ) . '/includes/class-content-importer.php';
		}

		do_action( 'penci_soledaddi_before_import_content', $file );

		$importer = new Penci_Demo_Content_Importer( array(
			'fetch_attachments' => true
		) );

		if ( ! class_exists( 'WP_Importer_Logger' ) ) {
			require_once plugin_dir_path( __FILE__ ) . '/includes/class-logger.php';
		}

		if ( ! class_exists( 'WP_Importer_Logger_ServerSentEvents' ) ) {
			require_once plugin_dir_path( __FILE__ ) . '/includes/class-logger-serversentevents.php';
		}

		$logger = new WP_Importer_Logger_ServerSentEvents();
		$err = $importer->set_logger( $logger );

		return $importer->import( $file );
	}

	/**
	 * Import theme options
	 *
	 * @param  string $file The exported file's name
	 */
	public function import_customizer( $file ) {
		if ( ! file_exists( $file ) ) {
			return false;
		}

		if( ! class_exists( 'Penci_Demo_Customizer_Importer' ) ) {
			require_once plugin_dir_path( __FILE__ ) . 'includes/customizer-importer.php';
		}

		do_action( 'penci_soledaddi_before_import_customizer', $file );

		// Disables generation of multiple image sizes (thumbnails) in the content import step.
		add_filter( 'intermediate_image_sizes_advanced', '__return_null' );

		$import = new Penci_Demo_Customizer_Importer();
		$import->download_images = true;
		$import->import( $file );

		return true;
	}

	/**
	 * Import widgets
	 *
	 * @param  string $file The exported file's name
	 */
	function import_widgets( $file ) {
		if ( ! file_exists( $file ) ) {
			return false;
		}

		if ( ! class_exists( 'Penci_Demo_Widgets_Importer') ) {
			require_once plugin_dir_path( __FILE__ ) . 'includes/widgets-importer.php';
		}

		do_action( 'penci_soledaddi_before_import_widgets', $file );

		$data 		= json_decode( file_get_contents( $file ) );

		$importer   = new Penci_Demo_Widgets_Importer();
		$importer->import( $data );

		return true;
	}

	/**
	 * Import exported revolution sliders
	 */
	public function import_sliders() {
		if ( ! class_exists( 'RevSlider' ) ) {
			return new WP_Error( 'plugin-not-installed', esc_html__( 'Revolution Slider plugin is not installed', 'penci_soledad' ) );
		}

		$path = $this->get_demo_path();
		$sliders_zip = $path . '/sliders.zip';

		if ( empty( $sliders_zip ) ) {
			return new WP_Error( 'import-sliders', esc_html__( 'There is no slider to import', 'penci_soledad' ) );
		}

		$unzipfile = unzip_file( $sliders_zip, $path );

		if( is_wp_error( $unzipfile ) ) {
			define('FS_METHOD', 'direct'); //lets try direct.

			WP_Filesystem();

			$unzipfile = unzip_file( $sliders_zip, $path );
			@unlink( $sliders_zip );
		}

		$files = scandir( $path . '/sliders/' );

		if ( empty( $files ) ) {
			return new WP_Error( 'import-sliders', esc_html__( 'There is no slider to import', 'penci_soledad' ) );
		}

		$slider = new RevSlider();

		$this->emit_sse_message( array(
			'action' => 'updateTotal',
			'type'   => 'slider',
			'delta'  => count( $files ) - 2,
		));

		foreach( $files as $file ) {
			if ( $file == '.' || $file == '..' ) {
				continue;
			}
			$file = $path . '/sliders/' . $file;

			$response = $slider->importSliderFromPost( true, true, $file );

			$this->emit_sse_message( array(
				'action' => 'updateDelta',
				'type'   => 'slider',
				'delta'  => $response,
			));

			unlink( $file );
		}
	}

	/**
	 * Setup mailchimp
	 */
	public static function setup_mailchimp(){

		$content = '<p class="mdes">Subscribe my Newsletter for new blog posts, tips & new photos. Let\'s stay updated!</p>
				<p class="mname"><input type="text" name="NAME" placeholder="Name..." /></p>
				<p class="memail"><input type="email" id="mc4wp_email" name="EMAIL" placeholder="Email..." required /></p>
				<p class="msubmit"><input type="submit" value="Subscribe" /></p>';
		// create post type for form
		$id = wp_insert_post(
			array(
				'post_type'    => 'mc4wp-form',
				'post_status'  => 'publish',
				'post_title'   => __( 'Default sign-up form', 'mailchimp-for-wp' ),
				'post_content' => $content,
			)
		);

		// set default_form_id
		update_option( 'mc4wp_default_form_id', $id );
	}

	/**
	 * Import menu locations
	 *
	 * @param  string $file The exported file's name
	 */
	public function setup_menus( $demo ) {
		$demo = $this->data[$demo];

		if ( ! isset( $demo['menus'] ) ) {
			return;
		}

		$data = $demo['menus'];
		$menus = wp_get_nav_menus();
		$locations = array();

		foreach( $data as $key => $val ) {
			foreach( $menus as $menu ) {
				if( $val && $menu->slug == $val ) {
					$locations[$key] = absint( $menu->term_id );
				}
			}
		}

		set_theme_mod( 'nav_menu_locations', $locations );
	}

	/**
	* Import menu locations megamenu
	*
	* @param  string $file The exported file's name
	*/
	public function setup_megamenu( $demo ) {
		$demo = $this->data[$demo];

		if ( ! isset( $demo['mega-menu'] ) ) {
			return;
		}

		$data = $demo['mega-menu'];

		foreach( $data as $k => $v ) {
			
			if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ "main-menu" ] ) ) {
				
				$menu = wp_get_nav_menu_object( $locations[ "main-menu" ] );

				$menu_items = wp_get_nav_menu_items( $menu->term_id );

				foreach ( (array) $menu_items as $key => $menu_item ) {
					$penci_soledad_cat_mega_menu = get_post_meta( $menu_item->ID, 'penci_soledad_cat_mega_menu', true );
					if ( $penci_soledad_cat_mega_menu ) {
						wp_delete_post( $menu_item->ID );
					}
					
					// if( $menu_item->title == $k ){
					// 	$term_mega = get_term_by('slug', $v, 'category');
					// 	$term_mega->term_id ;

					// 	update_post_meta( $menu_item->ID , 'penci_soledad_cat_mega_menu', $term_mega->term_id );
					// }
				}
			}
		}
	}

	/**
	 * Setup pages
	 */
	public function setup_pages( $demo ) {
		$demo = $this->data[$demo];

		if ( ! isset( $demo['pages'] ) ) {
			return;
		}

		// Front Page
		if ( isset( $demo['pages']['front_page'] ) ) {
			$home = get_page_by_title( $demo['pages']['front_page'] );

			if ( $home ) {
				update_option( 'show_on_front', 'page' );
				update_option( 'page_on_front', $home->ID );
			}
		}

		// Blog Page
		if ( isset( $demo['pages']['blog'] ) ) {
			$blog = get_page_by_title( $demo['pages']['blog'] );

			if ( $blog ) {
				update_option( 'page_for_posts', $blog->ID );
			}
		}

		// WooCommerce Pages
		if ( class_exists( 'WooCommerce' ) ) {
			// Shop page
			if ( isset( $demo['pages']['shop'] ) && ! get_option( 'woocommerce_shop_page_id' ) ) {
				$shop = get_page_by_title( $demo['pages']['shop'] );

				if ( $shop ) {
					update_option( 'woocommerce_shop_page_id', $shop->ID );
				}
			}

			// Cart page
			if ( isset( $demo['pages']['cart'] ) && ! get_option( 'woocommerce_cart_page_id' ) ) {
				$cart = get_page_by_title( $demo['pages']['cart'] );

				if ( $cart ) {
					update_option( 'woocommerce_cart_page_id', $cart->ID );
				}
			}

			// Checkout page
			if ( isset( $demo['pages']['checkout'] ) && ! get_option( 'woocommerce_checkout_page_id' ) ) {
				$checkout = get_page_by_title( $demo['pages']['checkout'] );

				if ( $checkout ) {
					update_option( 'woocommerce_checkout_page_id', $checkout->ID );
				}
			}

			// Myaccount page
			if ( isset( $demo['pages']['my_account'] ) && ! get_option( 'woocommerce_myaccount_page_id' ) ) {
				$account = get_page_by_title( $demo['pages']['my_account'] );

				if ( $account ) {
					update_option( 'woocommerce_myaccount_page_id', $account->ID );
				}
			}
		}

		do_action( 'penci_soledaddi_after_setup_pages', $demo['pages'] );

		flush_rewrite_rules();
	}

	/**
	 * Update options
	 *
	 * @param  int $demo
	 */
	public function update_options( $demo ) {
		$demo = $this->data[$demo];

		if ( empty( $demo['options'] ) ) {
			return;
		}

		foreach ( $demo['options'] as $option => $value) {
			update_option( $option, $value );
		}
	}

	/**
	 * Generate image sizes
	 * @param  int $id
	 */
	public function generate_image( $id ) {
		$fullsizepath = get_attached_file( $id );

		if ( false === $fullsizepath || ! file_exists( $fullsizepath ) ) {
			return false;
		}

		$metadata = wp_generate_attachment_metadata( $id, $fullsizepath );

		if ( ! $metadata || is_wp_error( $metadata ) ) {
			return false;
		}

		// If this fails, then it just means that nothing was changed (old value == new value)
		wp_update_attachment_metadata( $id, $metadata );

		return true;
	}

	/**
	 * Trash the default WordPress Post, "Hello World"
	 */
	public function trash_post_hello_world() {
		$post = get_post(1);
		$slug = isset( $post->post_name ) ? $post->post_name : '';

		if( 'hello-world' == $slug ) {
			wp_trash_post( 1 );
		}
	}

	/**
	 * Ajax function to import demo content
	 */
	public function ajax_import() {
		if ( ! wp_verify_nonce( $_GET['_wpnonce'], 'penci_soledad_demo_import' ) ) {
			wp_send_json_error( esc_html__( 'Verifing failed', 'penci_soledad' ) );
			eixt;
		}

		$this->trash_post_hello_world();

		// Turn off PHP output compression
		$previous = error_reporting( error_reporting() ^ E_WARNING );
		ini_set( 'output_buffering', 'off' );
		ini_set( 'zlib.output_compression', false );
		error_reporting( $previous );

		if ( $GLOBALS['is_nginx'] ) {
			// Setting this header instructs Nginx to disable fastcgi_buffering
			// and disable gzip for this request.
			header( 'X-Accel-Buffering: no' );
			header( 'Content-Encoding: none' );
		}

		// Start the event stream.
		header( 'Content-Type: text/event-stream' );

		set_time_limit( 0 );

		// Ensure we're not buffered.
		wp_ob_end_flush_all();
		flush();

		$type = $_GET['type'];
		$dir = $this->get_demo_path();

		switch ( $type ) {
			case 'content':
				$file = $dir . '/demo-content.xml';
				$result = $this->import_content( $file );
				break;

			case 'customizer':
				$file = $dir . '/customizer.dat';
				$result = $this->import_customizer( $file );
				break;

			case 'widgets':
				$file = $dir . '/widgets.wie';
				$result = $this->import_widgets( $file );
				break;

			case 'sliders':
				$result = $this->import_sliders();
				break;
		}

		// Let the browser know we're done.
		$complete = array(
			'action' => 'complete',
			'error' => false,
		);

		if ( is_wp_error( $result ) ) {
			$complete['error'] = $result->get_error_message();
		}

		@unlink( $file );

		$this->emit_sse_message( $complete );
		exit;
	}

	/**
	 * Ajax function to download file
	 */
	public function ajax_download_file() {
		if ( ! wp_verify_nonce( $_GET['_wpnonce'], 'penci_soledad_demo_import' ) ) {
			wp_send_json_error( esc_html__( 'Verifing failed', 'penci_soledad' ) );
			eixt;
		}

		$demo = $_GET['demo'];
		$demo = $this->data[$demo];

		$type = $_GET['type'];

		if ( ! isset( $demo[$type] ) ) {
			wp_send_json_error( esc_html__( 'This demo dose not need', 'penci_soledad' ) . " $type" );
			eixt;
		}

		if ( empty( $demo[$type] ) ) {
			wp_send_json_error( esc_html__( 'File does not exists', 'penci_soledad' ) );
			eixt;
		}

		@set_time_limit(0);

		$file = $this->download_file( $demo[$type] );

		if ( is_wp_error( $file ) ) {
			wp_send_json_error( $file->get_error_message() );
			exit;
		}

		wp_send_json_success();
	}

	/**
	 * Ajax function to setup front page and blog page
	 */
	public function ajax_config_theme() {
		if ( ! wp_verify_nonce( $_GET['_wpnonce'], 'penci_soledad_demo_import' ) ) {
			wp_send_json_error( esc_html__( 'Verifing failed', 'penci_soledad' ) );
			eixt;
		}

		$demo = $_GET['demo'];

		// Setup pages
		$this->setup_pages( $demo );

		//Setup menu
		$this->setup_menus( $demo );

		$this->setup_mailchimp();

		// Update options
		$this->update_options( $demo );

		wp_send_json_success( esc_html__( 'Finish setting up front page and blog page.', 'penci_soledad' ) );
	}


	/**
	 * Ajax function to get all image ids
	 */
	public function ajax_get_images() {
		if ( ! wp_verify_nonce( $_GET['_wpnonce'], 'penci_soledad_demo_import' ) ) {
			wp_send_json_error( esc_html__( 'Verifing failed', 'penci_soledad' ) );
			eixt;
		}

		global $wpdb;

		$images = $wpdb->get_results( "SELECT ID FROM $wpdb->posts WHERE post_type = 'attachment' AND post_mime_type LIKE 'image/%' ORDER BY ID DESC" );

		$ids = array();

		if ( $images ) {
			foreach ( $images as $image ) {
				$ids[] = $image->ID;
			}
		}

		wp_send_json_success( $ids );
	}

	/**
	 * Ajax function to generate a single image
	 */
	public function ajax_generate_image() {
		if ( ! wp_verify_nonce( $_GET['_wpnonce'], 'penci_soledad_demo_import' ) ) {
			wp_send_json_error( esc_html__( 'Verifing failed', 'penci_soledad' ) );
			eixt;
		}

		$id = absint( $_REQUEST['id'] );

		@set_time_limit( 900 ); // 5 minutes per image should be PLENTY

		$result = $this->generate_image( $id );

		if ( ! $result ) {
			wp_send_json_error( esc_html__( 'Failed to generate image ID:', 'penci_soledad' ) . " $id" );
		} else {
			wp_send_json_success( sprintf( esc_html__( 'Generated image ID %s successfully', 'penci_soledad' ), $id ) );
		}
	}

	/**
	 * Download file from URL
	 *
	 * @param  staring $file_url
	 * @return string  Downloaded file path
	 */
	protected function download_file( $file_url ) {
		$filename = basename( $file_url );
		$path = $this->get_demo_path();
		$file = $path . '/' . $filename;

		wp_mkdir_p( $path );

		$ifp = @fopen( $file, 'wb' );

		if ( ! $ifp ) {
			return new WP_Error( 'import_file_error', sprintf( __( 'Could not write file %s' ), $file ) );
		}

		@fwrite( $ifp, 0 );
		fclose( $ifp );
		clearstatcache();

		// Set correct file permissions
		$stat = @stat( dirname( $file ) );
		$perms = $stat['mode'] & 0007777;
		$perms = $perms & 0000666;
		@chmod( $file, $perms );
		clearstatcache();

		$response = wp_remote_get( $file_url, array(
			'stream' => true,
			'filename' => $file,
			'timeout' => 500,
		) );

		// request failed
		if ( is_wp_error( $response ) ) {
			@unlink( $file );
			return $response;
		}

		$code = (int) wp_remote_retrieve_response_code( $response );

		// make sure the fetch was successful
		if ( $code !== 200 ) {
			@unlink( $file );

			return new WP_Error(
				'import_file_error',
				sprintf(
					esc_html__( 'Remote server returned %1$d %2$s for %3$s', 'penci_soledad' ),
					$code,
					get_status_header_desc( $code ),
					$url
				)
			);
		}

		if ( 0 == filesize( $file ) ) {
			@unlink( $file );
			return new WP_Error( 'import_file_error', esc_html__( 'Zero size file downloaded', 'penci_soledad' ) );
		}


		return $file;
	}

	/**
	 * Emit a Server-Sent Events message.
	 *
	 * @param mixed $data Data to be JSON-encoded and sent in the message.
	 */
	protected function emit_sse_message( $data ) {
		echo "event: message\n";
		echo 'data: ' . wp_json_encode( $data ) . "\n\n";

		// Extra padding.
		echo ':' . str_repeat( ' ', 2048 ) . "\n\n";

		flush();
	}

	/**
	 * Get the path to demo directory
	 *
	 * @return string
	 */
	private function get_demo_path() {
		$upload_dir = wp_upload_dir();
		$dir = path_join( $upload_dir['basedir'], 'demo_files' );

		return $dir;
	}
}

if ( version_compare( phpversion(), '5.3.2', '<' ) ) {
	add_action( 'admin_notices', function() {
		$message = sprintf( __( 'The <strong>Penci Demo Importer</strong> plugin requires <strong>PHP 5.3.2+</strong> to run properly. Please contact your hosting company and ask them to update the PHP version of your site to at least PHP 5.3.2.<br> Your current version of PHP: <strong>%s</strong>', 'penci_soledad' ), phpversion() );

		printf( '<div class="notice notice-error"><p>%s</p></div>', wp_kses_post( $message ) );
	} );
} else {
	add_action( 'init', function() {
		new Penci_Soledad_Demo_Importer();
	} );
}
