<?php
if ( ! class_exists( 'Gyan_Sites_Batch_Processing' ) ) :
	class Gyan_Sites_Batch_Processing {
		private static $instance;
		public static $process_all;
		public $last_export_checksums;
		public static $process_site_importer;
		public static $process_single;
		public static function get_instance() { if ( ! isset( self::$instance ) ) {self::$instance = new self(); } return self::$instance; }

		public function __construct() {
			$this->includes();
			// Start image importing after site import complete.
			add_filter( 'gyan_sites_image_importer_skip_image', array( $this, 'skip_image' ), 10, 2 );
			add_action( 'gyan_sites_import_complete', array( $this, 'start_process' ) );
			add_action( 'gyan_sites_process_single', array( $this, 'start_process_single' ) );
			add_action( 'admin_head', array( $this, 'start_importer' ) );
			add_action( 'wp_ajax_gyan-sites-update-library', array( $this, 'update_library' ) );
			add_action( 'wp_ajax_gyan-sites-update-library-complete', array( $this, 'update_library_complete' ) );
			add_action( 'wp_ajax_gyan-sites-import-categories', array( $this, 'import_categories' ) );
			add_action( 'wp_ajax_gyan-sites-import-site-categories', array( $this, 'import_site_categories' ) );
			add_action( 'wp_ajax_gyan-sites-import-block-categories', array( $this, 'import_block_categories' ) );
			add_action( 'wp_ajax_gyan-sites-import-page-builders', array( $this, 'import_page_builders' ) );
			add_action( 'wp_ajax_gyan-sites-import-blocks', array( $this, 'import_blocks' ) );
			add_action( 'wp_ajax_gyan-sites-get-sites-request-count', array( $this, 'sites_requests_count' ) );
			add_action( 'wp_ajax_gyan-sites-get-blocks-request-count', array( $this, 'blocks_requests_count' ) );
			add_action( 'wp_ajax_gyan-sites-import-sites', array( $this, 'import_sites' ) );
		}

		public function includes() {
			// Core Helpers - Image. @todo 	This file is required for Elementor. Once we implement our logic for updating elementor data then we'll delete this file.
			require_once ABSPATH . 'wp-admin/includes/image.php';

			// Core Helpers - Image Downloader.
			require_once GYAN_PLUGIN_DIR . 'demos/importers/batch-processing/helpers/class-gyan-sites-image-importer.php';

			// Core Helpers - Batch Processing.
			require_once GYAN_PLUGIN_DIR . 'demos/importers/batch-processing/helpers/class-wp-async-request.php';
			require_once GYAN_PLUGIN_DIR . 'demos/importers/batch-processing/helpers/class-wp-background-process.php';
			require_once GYAN_PLUGIN_DIR . 'demos/importers/batch-processing/helpers/class-wp-background-process-gyan.php';
			require_once GYAN_PLUGIN_DIR . 'demos/importers/batch-processing/helpers/class-wp-background-process-gyan-single.php';
			require_once GYAN_PLUGIN_DIR . 'demos/importers/batch-processing/helpers/class-wp-background-process-gyan-site-importer.php';

			require_once GYAN_PLUGIN_DIR . 'demos/importers/batch-processing/class-gyan-sites-batch-processing-widgets.php';
			require_once GYAN_PLUGIN_DIR . 'demos/importers/batch-processing/class-gyan-sites-batch-processing-elementor.php';
			require_once GYAN_PLUGIN_DIR . 'demos/importers/batch-processing/class-gyan-sites-batch-processing-misc.php';
			require_once GYAN_PLUGIN_DIR . 'demos/importers/batch-processing/class-gyan-sites-batch-processing-importer.php';

			self::$process_all           = new WP_Background_Process_Gyan();
			self::$process_single        = new WP_Background_Process_Gyan_Single();
			self::$process_site_importer = new WP_Background_Process_Gyan_Site_Importer();
		}

		public function import_categories() {
			Gyan_Sites_Batch_Processing_Importer::get_instance()->import_categories();
			wp_send_json_success();
		}

		public function import_site_categories() {
			Gyan_Sites_Batch_Processing_Importer::get_instance()->import_site_categories();
			wp_send_json_success();
		}

		public function import_block_categories() {
			Gyan_Sites_Batch_Processing_Importer::get_instance()->import_block_categories();
			wp_send_json_success();
		}

		public function import_page_builders() {
			Gyan_Sites_Batch_Processing_Importer::get_instance()->import_page_builders();
			wp_send_json_success();
		}

		public function import_blocks() {
			$page_no = isset( $_POST['page_no'] ) ? absint( $_POST['page_no'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing
			if ( $page_no ) {
				$sites_and_pages = Gyan_Sites_Batch_Processing_Importer::get_instance()->import_blocks( $page_no );
				wp_send_json_success();
			}
			wp_send_json_error();
		}

		public function import_sites() {
			$page_no = isset( $_POST['page_no'] ) ? absint( $_POST['page_no'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing
			if ( $page_no ) {
				$sites_and_pages = Gyan_Sites_Batch_Processing_Importer::get_instance()->import_sites( $page_no );

				$page_builder_keys    = wp_list_pluck( $sites_and_pages, 'gyan-site-page-builder' );
				$default_page_builder = Gyan_Sites_Page::get_instance()->get_setting( 'page_builder' );

				$current_page_builder_sites = array();
				foreach ( $page_builder_keys as $site_id => $page_builder ) {
					if ( $default_page_builder === $page_builder ) {
						$current_page_builder_sites[ $site_id ] = $sites_and_pages[ $site_id ];
					}
				}

				wp_send_json_success( $current_page_builder_sites );
			}

			wp_send_json_error();
		}

		public function sites_requests_count() {
			$total_requests = $this->get_total_requests();
			if ( $total_requests ) {
				wp_send_json_success( $total_requests );
			}
			wp_send_json_error();
		}

		public function blocks_requests_count() {
			$total_requests = $this->get_total_blocks_requests();
			if ( $total_requests ) {
				wp_send_json_success( $total_requests );
			}
			wp_send_json_error();
		}

		public function update_library_complete() {
			Gyan_Sites_Importer::get_instance()->update_latest_checksums();
			update_site_option( 'gyan-sites-batch-is-complete', 'no', 'no' );
			update_site_option( 'gyan-sites-manual-sync-complete', 'yes', 'no' );
			wp_send_json_success();
		}

		public function get_last_export_checksums() {
			$old_last_export_checksums = get_site_option( 'gyan-sites-last-export-checksums', '' );
			$new_last_export_checksums = $this->set_last_export_checksums();
			$checksums_status = 'no';

			if ( empty( $old_last_export_checksums ) ) {
				$checksums_status = 'yes';
			}

			if ( $new_last_export_checksums !== $old_last_export_checksums ) {
				$checksums_status = 'yes';
			}
			return apply_filters( 'gyan_sites_checksums_status', $checksums_status );
		}

		public function set_last_export_checksums() {
			if ( ! empty( $this->last_export_checksums ) ) {
				return $this->last_export_checksums;
			}
			$api_args = array(
				'timeout' => 60,
			);


			$response = wp_remote_get( trailingslashit( Gyan_Sites::get_instance()->get_api_domain() ) . 'wp-json/gyan-sites/v1/get-last-export-checksums', $api_args );

			// TEMP PATH
			// $response = wp_remote_get( 'https://websitedemos.net/wp-json/gyan-sites/v1/get-last-export-checksums', $api_args );

			if ( ! is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) === 200 ) {
				$result = json_decode( wp_remote_retrieve_body( $response ), true );

				if ( ! empty( $result['last_export_checksums'] ) ) {
					update_site_option( 'gyan-sites-last-export-checksums-latest', $result['last_export_checksums'], 'no' );

					$this->last_export_checksums = $result['last_export_checksums'];
				}
			}

			return $this->last_export_checksums;
		}

		public function update_library() {

			if ( 'no' === $this->get_last_export_checksums() ) {
				wp_send_json_success( 'updated' );
			}

			$status = Gyan_Sites_Page::get_instance()->test_cron();
			if ( is_wp_error( $status ) ) {
				$import_with = 'ajax';
			} else {
				$import_with = 'batch';
				// Process import.
				$this->process_batch();
			}

			wp_send_json_success( $import_with );
		}

		public function start_importer() {
			$process_sync = apply_filters( 'gyan_sites_initial_sync', true );
			if ( ! $process_sync ) { return; }
			$is_fresh_site = get_site_option( 'gyan-sites-fresh-site', '' );

			// Process initially for the fresh user.
			if ( isset( $_GET['reset'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended

				$this->process_batch();  // Process import.

			} elseif ( empty( $is_fresh_site ) ) {

				// First time user save the data of sites, pages, categories etc from the JSON file.
				$dir        = GYAN_PLUGIN_DIR . 'demos/json';
				$list_files = list_files( $dir );
				if ( ! empty( $list_files ) ) {
					$list_files = array_map( 'basename', $list_files ); // basename = php core function
					foreach ( $list_files as $key => $file_name ) {
						$data = Gyan_Sites::get_instance()->get_filesystem()->get_contents( $dir . '/' . $file_name );
						if ( ! empty( $data ) ) {
							$option_name = str_replace( '.json', '', $file_name );
							update_site_option( $option_name, json_decode( $data, true ) );
						}
					}
				}

				$this->process_batch();  // Also, Trigger the batch to get latest data. If batch failed then user have at least the data from the JSON file.

				update_site_option( 'gyan-sites-fresh-site', 'yes', 'no' );

				// If not fresh user then trigger batch import on the transient and option only on the Sites page.
			} else {
				$current_screen = get_current_screen();

				// Bail if not on Sites screen.
				if ( ! is_object( $current_screen ) && null === $current_screen ) {
					return;
				}

				if ( 'theme-panel_page_demo-templates' === $current_screen->id ) {
					$this->process_import();   // Process import.
				}
			}
		}

		public function process_batch() {
			$process_sync = apply_filters( 'gyan_sites_process_sync_batch', true );
			if ( ! $process_sync ) { return; }

			if ( 'no' === $this->get_last_export_checksums() ) {
				$this->log( 'Library is up to date!' );
				if ( defined( 'WP_CLI' ) ) {
					WP_CLI::line( 'Library is up to date!' );
				}
				return;
			}

			$status = Gyan_Sites_Page::get_instance()->test_cron();
			if ( is_wp_error( $status ) ) {
				gyan_sites_error_log( 'Error! Batch Not Start due to disabled cron events!' );
				update_site_option( 'gyan-sites-batch-status-string', 'Error! Batch Not Start due to disabled cron events!', 'no' );

				if ( defined( 'WP_CLI' ) ) {
					WP_CLI::line( 'Error! Batch Not Start due to disabled cron events!' );
				} else {
					return;  // For non- WP CLI request return to prevent the request.
				}
			}

			$this->log( 'Refresh Demos Started!' );
			$this->log( 'Added Tags in queue.' );  // Added the categories.

			if ( defined( 'WP_CLI' ) ) {
				Gyan_Sites_Batch_Processing_Importer::get_instance()->import_categories();
			} else {
				self::$process_site_importer->push_to_queue(
					array(
						'instance' => Gyan_Sites_Batch_Processing_Importer::get_instance(),
						'method'   => 'import_categories',
					)
				);
			}

			$this->log( 'Added Site Categories in queue.' );  // Added the categories.

			if ( defined( 'WP_CLI' ) ) {
				Gyan_Sites_Batch_Processing_Importer::get_instance()->import_site_categories();
			} else {
				self::$process_site_importer->push_to_queue(
					array(
						'instance' => Gyan_Sites_Batch_Processing_Importer::get_instance(),
						'method'   => 'import_site_categories',
					)
				);
			}

			$this->log( 'Added page builders in queue.' );  // Added the page_builders.

			if ( defined( 'WP_CLI' ) ) {
				Gyan_Sites_Batch_Processing_Importer::get_instance()->import_page_builders();
			} else {
				self::$process_site_importer->push_to_queue(
					array(
						'instance' => Gyan_Sites_Batch_Processing_Importer::get_instance(),
						'method'   => 'import_page_builders',
					)
				);
			}

			// Get count.
			$total_requests = $this->get_total_blocks_requests();
			if ( $total_requests ) {
				$this->log( 'BLOCK: Total Blocks Requests ' . $total_requests );

				for ( $page = 1; $page <= $total_requests; $page++ ) {

					$this->log( 'BLOCK: Added page ' . $page . ' in queue.' );

					if ( defined( 'WP_CLI' ) ) {
						Gyan_Sites_Batch_Processing_Importer::get_instance()->import_blocks( $page );
					} else {
						self::$process_site_importer->push_to_queue(
							array(
								'page'     => $page,
								'instance' => Gyan_Sites_Batch_Processing_Importer::get_instance(),
								'method'   => 'import_blocks',
							)
						);
					}
				}
			}

			// Added the categories.
			$this->log( 'Added Block Categories in queue.' );

			if ( defined( 'WP_CLI' ) ) {
				Gyan_Sites_Batch_Processing_Importer::get_instance()->import_block_categories();
			} else {
				self::$process_site_importer->push_to_queue(
					array(
						'instance' => Gyan_Sites_Batch_Processing_Importer::get_instance(),
						'method'   => 'import_block_categories',
					)
				);
			}

			// Get count.
			$total_requests = $this->get_total_requests();
			if ( $total_requests ) {
				$this->log( 'Total Requests ' . $total_requests );

				for ( $page = 1; $page <= $total_requests; $page++ ) {

					$this->log( 'Added page ' . $page . ' in queue.' );

					if ( defined( 'WP_CLI' ) ) {
						Gyan_Sites_Batch_Processing_Importer::get_instance()->import_sites( $page );
					} else {
						self::$process_site_importer->push_to_queue(
							array(
								'page'     => $page,
								'instance' => Gyan_Sites_Batch_Processing_Importer::get_instance(),
								'method'   => 'import_sites',
							)
						);
					}
				}
			}

			if ( defined( 'WP_CLI' ) ) {
				$this->log( 'Sync Process Complete.' );
			} else {
				$this->log( 'Dispatch the Queue!' );  // Dispatch Queue.
				self::$process_site_importer->save()->dispatch();
			}

		}

		public function log( $message = '' ) {
			if ( defined( 'WP_CLI' ) ) {
				WP_CLI::line( $message );
			} else {
				gyan_sites_error_log( $message );
				update_site_option( 'gyan-sites-batch-status-string', $message, 'no' );
			}
		}

		public function process_import() {
			$process_sync = apply_filters( 'gyan_sites_process_auto_sync_library', true );
			if ( ! $process_sync ) { return; }

			// Batch is already started? Then return.
			$status = get_site_option( 'gyan-sites-batch-status' );
			if ( 'in-process' === $status ) { return; }

			// Check batch expiry.
			$expired = get_transient( 'gyan-sites-import-check' );
			if ( false !== $expired ) { return; }

			set_transient( 'gyan-sites-import-check', 'true', apply_filters( 'gyan_sites_sync_check_time', WEEK_IN_SECONDS ) );  // For 1 week.
			update_site_option( 'gyan-sites-batch-status', 'in-process', 'no' );

			$this->process_batch();  // Process batch.
		}

		public function get_total_requests() {

			gyan_sites_error_log( 'Getting Total Pages' );
			update_site_option( 'gyan-sites-batch-status-string', 'Getting Total Pages', 'no' );

			$api_args = array('timeout' => 60);

			// change per_page value as per number of site increase in future 15 is ideal number
			$response = wp_remote_get( trailingslashit( Gyan_Sites::get_instance()->get_api_domain() ) . 'wp-json/gyan-sites/v1/get-total-pages/?per_page=2', $api_args );
			if ( ! is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) === 200 ) {
				$total_requests = json_decode( wp_remote_retrieve_body( $response ), true );

				if ( isset( $total_requests['pages'] ) ) {
					$this->log( 'Updated requests ' . $total_requests['pages'] );
					update_site_option( 'gyan-sites-requests', $total_requests['pages'], 'no' );
					return $total_requests['pages'];
				}
			}

			gyan_sites_error_log( 'Request Failed! Still Calling..' );
			update_site_option( 'gyan-sites-batch-status-string', 'Request Failed! Still Calling..', 'no' );

			$this->get_total_requests();
		}

		public function get_total_blocks_requests() {

			gyan_sites_error_log( 'BLOCK: Getting Total Blocks' );
			update_site_option( 'gyan-sites-batch-status-string', 'Getting Total Blocks', 'no' );

			$api_args = array('timeout' => 60);

			$response = wp_remote_get( trailingslashit( Gyan_Sites::get_instance()->get_api_domain() ) . 'wp-json/gyan-blocks/v1/get-blocks-count/?page_builder=elementor', $api_args );
			if ( ! is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) === 200 ) {
				$total_requests = json_decode( wp_remote_retrieve_body( $response ), true );

				if ( isset( $total_requests['pages'] ) ) {
					gyan_sites_error_log( 'BLOCK: Updated requests ' . $total_requests['pages'] );
					update_site_option( 'gyan-blocks-batch-status-string', 'Updated requests ' . $total_requests['pages'], 'no' );
					update_site_option( 'gyan-blocks-requests', $total_requests['pages'], 'no' );
					return $total_requests['pages'];
				}
			}

			gyan_sites_error_log( 'BLOCK: Request Failed! Still Calling..' );
			update_site_option( 'gyan-blocks-batch-status-string', 'Request Failed! Still Calling..', 'no' );

			$this->get_total_blocks_requests();
		}

		public function start_process_single( $page_id ) {

			gyan_sites_error_log( '=================== - Single Page - Importing Images for Blog name \'' . get_the_title( $page_id ) . '\' (' . $page_id . ') ===================' );

			$default_page_builder = Gyan_Sites_Page::get_instance()->get_setting( 'page_builder' );

			// Add "elementor" in import [queue].
			if ( 'elementor' === $default_page_builder ) {
				// @todo Remove required `allow_url_fopen` support.
				if ( ini_get( 'allow_url_fopen' ) ) {
					if ( is_plugin_active( 'elementor/elementor.php' ) ) {
						\Elementor\Plugin::$instance->posts_css_manager->clear_cache();   // !important, Clear the cache after images import.

						$import = new \Elementor\TemplateLibrary\Gyan_Sites_Batch_Processing_Elementor();
						self::$process_single->push_to_queue(
							array(
								'page_id'  => $page_id,
								'instance' => $import,
							)
						);
					}
				} else {
					gyan_sites_error_log( 'Couldn\'t not import image due to allow_url_fopen() is disabled!' );
				}
			}

			self::$process_single->save()->dispatch();  // Dispatch Queue.
		}

		// Skip Image from Batch Processing
		public function skip_image( $can_process, $attachment ) {
			if ( isset( $attachment['url'] ) && ! empty( $attachment['url'] ) ) {

				// If image URL contain current site URL? then return true to skip that image from import.
				if ( strpos( $attachment['url'], site_url() ) !== false ) {
					return true;
				}

				if (
					strpos( $attachment['url'], 'brainstormforce.com' ) !== false ||
					strpos( $attachment['url'], 'sharkz.in' ) !== false ||
					strpos( $attachment['url'], 'websitedemos.net' ) !== false
				) {
					return false;
				}
			}

			return true;
		}

		// Start Image Import
		public function start_process() {

			/** WordPress Plugin Administration API */
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
			require_once ABSPATH . 'wp-admin/includes/update.php';

			$this->includes();

			$wxr_id = get_site_option( 'gyan_sites_imported_wxr_id', 0 );
			if ( $wxr_id ) {
				wp_delete_attachment( $wxr_id, true );
				gyan_sites_error_log( 'Deleted Temporary WXR file ' . $wxr_id );
				delete_option( 'gyan_sites_imported_wxr_id' );
				gyan_sites_error_log( 'Option `gyan_sites_imported_wxr_id` Deleted.' );
			}

			$classes = array();

			Gyan_Sites_Importer_Log::add( 'Batch Process Started..' );
			Gyan_Sites_Importer_Log::add( ' - Importing Images for Blog name \'' . get_bloginfo( 'name' ) . '\' (' . get_current_blog_id() . ')' );

			$classes[] = Gyan_Sites_Batch_Processing_Widgets::get_instance();  // Add "widget" in import [queue].

			// Add "elementor" in import [queue]. @todo Remove required `allow_url_fopen` support.
			if ( ini_get( 'allow_url_fopen' ) && is_plugin_active( 'elementor/elementor.php' ) ) {
				$import    = new \Elementor\TemplateLibrary\Gyan_Sites_Batch_Processing_Elementor();
				$classes[] = $import;
			}

			$classes[] = Gyan_Sites_Batch_Processing_Misc::get_instance();  // Add "misc" in import [queue].

			if ( defined( 'WP_CLI' ) ) {
				WP_CLI::line( 'Batch Process Started..' );
				// Process all classes.
				foreach ( $classes as $key => $class ) {
					if ( method_exists( $class, 'import' ) ) {
						$class->import();
					}
				}
				WP_CLI::line( 'Batch Process Complete!' );
			} else {
				// Add all classes to batch queue.
				foreach ( $classes as $key => $class ) {
					self::$process_all->push_to_queue( $class );
				}

				self::$process_all->save()->dispatch();  // Dispatch Queue.
			}

		}

		// Get all post id's
		public static function get_pages( $post_types = array() ) {

			if ( $post_types ) {
				$args = array(
					'post_type'      => $post_types,

					// Query performance optimization.
					'fields'         => 'ids',
					'no_found_rows'  => true,
					'post_status'    => 'publish',
					'posts_per_page' => -1,
				);

				$query = new WP_Query( $args );

				// Have posts?
				if ( $query->have_posts() ) :
					return $query->posts;
				endif;
			}

			return null;
		}

		// Get Supporting Post Types..
		public static function get_post_types_supporting( $feature ) {
			global $_wp_post_type_features;

			$post_types = array_keys(
				wp_filter_object_list( $_wp_post_type_features, array( $feature => true ) )
			);

			return $post_types;
		}

	}

	Gyan_Sites_Batch_Processing::get_instance();

endif;