<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( 'Gyan_Sites_Importer' ) ) {
	class Gyan_Sites_Importer {
		public static $instance = null;
		public static function get_instance() { if ( ! isset( self::$instance ) ) {self::$instance = new self(); } return self::$instance; }

		public function __construct() {
			require_once GYAN_PLUGIN_DIR . 'demos/classes/class-gyan-sites-importer-log.php';
			require_once GYAN_PLUGIN_DIR . 'demos/importers/class-gyan-sites-helper.php';
			require_once GYAN_PLUGIN_DIR . 'demos/importers/class-gyan-widget-importer.php';
			require_once GYAN_PLUGIN_DIR . 'demos/importers/class-gyan-slider-import.php';
			require_once GYAN_PLUGIN_DIR . 'demos/importers/class-gyan-customizer-import.php';
			require_once GYAN_PLUGIN_DIR . 'demos/importers/class-gyan-site-options-import.php';

			// Import AJAX.
			add_action( 'wp_ajax_gyan-sites-import-customizer-settings', array( $this, 'import_customizer_settings' ) );
			add_action( 'wp_ajax_gyan-sites-import-prepare-xml', array( $this, 'prepare_xml_data' ) );
			add_action( 'wp_ajax_gyan-sites-import-options', array( $this, 'import_options' ) );
			add_action( 'wp_ajax_gyan-sites-import-widgets', array( $this, 'import_widgets' ) );
			add_action( 'wp_ajax_gyan-sites-import-sliders', array( $this, 'import_sliders' ) );
			add_action( 'wp_ajax_gyan-sites-import-end', array( $this, 'import_end' ) );

			// Hooks in AJAX.
			add_action( 'gyan_sites_import_complete', array( $this, 'after_batch_complete' ) );
			add_action( 'init', array( $this, 'load_importer' ) );

			require_once GYAN_PLUGIN_DIR . 'demos/importers/batch-processing/class-gyan-sites-batch-processing.php';

			add_action( 'gyan_sites_image_import_complete', array( $this, 'after_batch_complete' ) );

			// Reset Customizer Data.
			add_action( 'wp_ajax_gyan-sites-reset-customizer-data', array( $this, 'reset_customizer_data' ) );
			add_action( 'wp_ajax_gyan-sites-reset-site-options', array( $this, 'reset_site_options' ) );
			add_action( 'wp_ajax_gyan-sites-reset-widgets-data', array( $this, 'reset_widgets_data' ) );
			// add_action( 'wp_ajax_gyan-sites-reset-sliders-data', array( $this, 'reset_sliders_data' ) );

			// Reset Post & Terms.
			add_action( 'wp_ajax_gyan-sites-delete-posts', array( $this, 'delete_imported_posts' ) );
			add_action( 'wp_ajax_gyan-sites-delete-wp-forms', array( $this, 'delete_imported_wp_forms' ) );
			add_action( 'wp_ajax_gyan-sites-delete-terms', array( $this, 'delete_imported_terms' ) );

			if ( version_compare( get_bloginfo( 'version' ), '5.1.0', '>=' ) ) {
				add_filter( 'http_request_timeout', array( $this, 'set_timeout_for_images' ), 10, 2 );
			}
		}

		public function set_timeout_for_images( $timeout_value, $url ) {

			// URL not contain `https://websitedemos.net` then return $timeout_value.
			if ( strpos( $url, 'https://websitedemos.net' ) === false ) {
				return $timeout_value;
			}

			// Check is image URL of type jpg|png|gif|jpeg.
			if ( Gyan_Sites_Image_Importer::get_instance()->is_image_url( $url ) ) {
				$timeout_value = 300;
			}

			return $timeout_value;
		}

		public function load_importer() {
			require_once GYAN_PLUGIN_DIR . 'demos/importers/wxr-importer/class-gyan-wxr-importer.php';
		}

		// Import Customizer Settings
		public function import_customizer_settings( $customizer_data = array() ) {

			if ( ! defined( 'WP_CLI' ) && wp_doing_ajax() ) {
				// Verify Nonce.
				check_ajax_referer( 'gyan-sites', '_ajax_nonce' );

				if ( ! current_user_can( 'customize' ) ) {
					wp_send_json_error( __( 'You are not allowed to perform this action', 'gyan-elements' ) );
				}
			}

			$customizer_data = ( isset( $_POST['customizer_data'] ) ) ? (array) json_decode( stripcslashes( $_POST['customizer_data'] ), 1 ) : $customizer_data;

			if ( ! empty( $customizer_data ) ) {

				Gyan_Sites_Importer_Log::add( 'Imported Customizer Settings ' . wp_json_encode( $customizer_data ) );

				// Set meta for tracking the post.
				gyan_sites_error_log( 'Customizer Data ' . wp_json_encode( $customizer_data ) );

				update_option( '_gyan_sites_old_customizer_data', $customizer_data );

				Gyan_Customizer_Import::instance()->import( $customizer_data );

				if ( defined( 'WP_CLI' ) ) {
					WP_CLI::line( 'Imported Customizer Settings!' );
				} elseif ( wp_doing_ajax() ) {
					wp_send_json_success( $customizer_data );
				}
			} else {
				if ( defined( 'WP_CLI' ) ) {
					WP_CLI::line( 'Customizer data is empty!' );
				} elseif ( wp_doing_ajax() ) {
					wp_send_json_error( __( 'Customizer data is empty!', 'gyan-elements' ) );
				}
			}

		}

		public function prepare_xml_data() {
			check_ajax_referer( 'gyan-sites', '_ajax_nonce' );  // Verify Nonce.
			if ( ! current_user_can( 'customize' ) ) { wp_send_json_error( __( 'You are not allowed to perform this action', 'gyan-elements' ) ); }

			if ( ! class_exists( 'XMLReader' ) ) {
				wp_send_json_error( __( 'If XMLReader is not available, it imports all other settings and only skips XML import. This creates an incomplete website. We should bail early and not import anything if this is not present.', 'gyan-elements' ) );
			}

			$wxr_url = ( isset( $_REQUEST['wxr_url'] ) ) ? urldecode( $_REQUEST['wxr_url'] ) : '';

			if ( isset( $wxr_url ) ) {

				Gyan_Sites_Importer_Log::add( 'Importing from XML ' . $wxr_url );

				$overrides = array(
					'wp_handle_sideload' => 'upload',
				);

				// Download XML file.
				$xml_path = Gyan_Sites_Helper::download_file( $wxr_url, $overrides );

				if ( $xml_path['success'] ) {

					$post = array(
						'post_title'     => basename( $wxr_url ),
						'guid'           => $xml_path['data']['url'],
						'post_mime_type' => $xml_path['data']['type'],
					);

					gyan_sites_error_log( wp_json_encode( $post ) );
					gyan_sites_error_log( wp_json_encode( $xml_path ) );

					// as per wp-admin/includes/upload.php.
					$post_id = wp_insert_attachment( $post, $xml_path['data']['file'] );

					gyan_sites_error_log( wp_json_encode( $post_id ) );

					if ( is_wp_error( $post_id ) ) {
						wp_send_json_error( __( 'There was an error downloading the XML file.', 'gyan-elements' ) );
					} else {

						update_option( 'gyan_sites_imported_wxr_id', $post_id );
						$attachment_metadata = wp_generate_attachment_metadata( $post_id, $xml_path['data']['file'] );
						wp_update_attachment_metadata( $post_id, $attachment_metadata );
						$data        = Gyan_WXR_Importer::instance()->get_xml_data( $xml_path['data']['file'], $post_id );
						$data['xml'] = $xml_path['data'];
						wp_send_json_success( $data );
					}
				} else {
					wp_send_json_error( $xml_path['data'] );
				}
			} else {
				wp_send_json_error( __( 'Invalid site XML file!', 'gyan-elements' ) );
			}

		}

		public function import_options( $options_data = array() ) {

			if ( ! defined( 'WP_CLI' ) && wp_doing_ajax() ) {
				// Verify Nonce.
				check_ajax_referer( 'gyan-sites', '_ajax_nonce' );

				if ( ! current_user_can( 'customize' ) ) {
					wp_send_json_error( __( 'You are not allowed to perform this action', 'gyan-elements' ) );
				}
			}

			$options_data = ( isset( $_POST['options_data'] ) ) ? (array) json_decode( stripcslashes( $_POST['options_data'] ), 1 ) : $options_data;

			if ( ! empty( $options_data ) ) {
				// Set meta for tracking the post.
				if ( is_array( $options_data ) ) {
					Gyan_Sites_Importer_Log::add( 'Imported - Site Options ' . wp_json_encode( $options_data ) );
					update_option( '_gyan_sites_old_site_options', $options_data );
				}

				$options_importer = Gyan_Site_Options_Import::instance();
				$options_importer->import_options( $options_data );
				if ( defined( 'WP_CLI' ) ) {
					WP_CLI::line( 'Imported Site Options!' );
				} elseif ( wp_doing_ajax() ) {
					wp_send_json_success( $options_data );
				}
			} else {
				if ( defined( 'WP_CLI' ) ) {
					WP_CLI::line( 'Site options are empty!' );
				} elseif ( wp_doing_ajax() ) {
					wp_send_json_error( __( 'Site options are empty!', 'gyan-elements' ) );
				}
			}

		}

		public function import_widgets( $widgets_data = '' ) {

			if ( ! defined( 'WP_CLI' ) && wp_doing_ajax() ) {
				// Verify Nonce.
				check_ajax_referer( 'gyan-sites', '_ajax_nonce' );

				if ( ! current_user_can( 'customize' ) ) {
					wp_send_json_error( __( 'You are not allowed to perform this action', 'gyan-elements' ) );
				}
			}

			$widgets_data = ( isset( $_POST['widgets_data'] ) ) ? (object) json_decode( stripslashes( $_POST['widgets_data'] ) ) : (object) $widgets_data;

			Gyan_Sites_Importer_Log::add( 'Imported - Widgets ' . wp_json_encode( $widgets_data ) );

			if ( ! empty( $widgets_data ) ) {

				$widgets_importer = Gyan_Widget_Importer::instance();
				$status           = $widgets_importer->import_widgets_data( $widgets_data );

				// Set meta for tracking the post.
				if ( is_object( $widgets_data ) ) {
					$widgets_data = (array) $widgets_data;

					update_option( '_gyan_sites_old_widgets_data', $widgets_data );
				}

				if ( defined( 'WP_CLI' ) ) {
					WP_CLI::line( 'Widget Imported!' );
				} elseif ( wp_doing_ajax() ) {
					wp_send_json_success( $widgets_data );
				}
			} else {
				if ( defined( 'WP_CLI' ) ) {
					WP_CLI::line( 'Widget data is empty!' );
				} elseif ( wp_doing_ajax() ) {
					wp_send_json_error( __( 'Widget data is empty!', 'gyan-elements' ) );
				}
			}

		}


		public function import_sliders( $sliders_data = '' ) {

			if ( ! defined( 'WP_CLI' ) && wp_doing_ajax() ) {
				// Verify Nonce.
				check_ajax_referer( 'gyan-sites', '_ajax_nonce' );

				if ( ! current_user_can( 'customize' ) ) {
					wp_send_json_error( __( 'You are not allowed to perform this action', 'gyan-elements' ) );
				}
			}

			$sliders_data = $_POST['sliders_data'];

			Gyan_Sites_Importer_Log::add( 'Imported - Sliders ' . wp_json_encode( $sliders_data ) );

			if ( ! empty( $sliders_data ) ) {

				$sliders_importer = Gyan_Slider_Import::instance();
				$status           = $sliders_importer->import_sliders_data( $sliders_data );

				// // Set meta for tracking the post.
				// if ( is_object( $sliders_data ) ) {
				// 	$sliders_data = (array) $sliders_data;

				// 	update_option( '_gyan_sites_old_sliders_data', $sliders_data );
				// }

				if ( defined( 'WP_CLI' ) ) {
					WP_CLI::line( 'Slider Imported!' );
				} elseif ( wp_doing_ajax() ) {
					wp_send_json_success( $status );
				}
			} else {
				if ( defined( 'WP_CLI' ) ) {
					WP_CLI::line( 'Slider data is empty!' );
				} elseif ( wp_doing_ajax() ) {
					wp_send_json_error( __( 'Slider data is empty!', 'gyan-elements' ) );
				}
			}

		}

		public function import_end() {

			if ( ! defined( 'WP_CLI' ) && wp_doing_ajax() ) {
				check_ajax_referer( 'gyan-sites', '_ajax_nonce' );
				if ( ! current_user_can( 'customize' ) ) {
					wp_send_json_error( __( 'You are not allowed to perform this action', 'gyan-elements' ) );
				}
			}

			$demo_data = get_option( 'gyan_sites_import_data', array() );
			do_action( 'gyan_sites_import_complete', $demo_data );
			update_option( 'gyan_sites_import_complete', 'yes' );

			if ( wp_doing_ajax() ) {
				wp_send_json_success();
			}
		}

		public static function get_single_demo( $demo_api_uri ) {
			if ( is_int( $demo_api_uri ) ) {
				$demo_api_uri = Gyan_Sites::get_instance()->get_api_url() . 'gyan-sites/' . $demo_api_uri;
			}

			// default values.
			$remote_args = array();
			$defaults    = array(
				'id'                          => '',
				'gyan-site-widgets-data'     => '',
				'gyan-site-customizer-data'  => '',
				'gyan-site-options-data'     => '',
				'gyan-post-data-mapping'     => '',
				'gyan-site-wxr-path'         => '',
				'gyan-enabled-extensions'    => '',
				'gyan-custom-404'            => '',
				'required-plugins'            => '',
				'gyan-site-taxonomy-mapping' => '',
				'site-type'                   => '',
				'gyan-site-url'              => '',
			);

			$api_args = apply_filters(
				'gyan_sites_api_args',
				array(
					'timeout' => 15,
				)
			);

			// Use this for premium demos.
			$request_params = apply_filters(
				'gyan_sites_api_params',
				array(
					'site_url'     => '',
				)
			);

			$demo_api_uri = add_query_arg( $request_params, $demo_api_uri );

			$response = wp_remote_get( $demo_api_uri, $api_args );  // API Call.

			if ( is_wp_error( $response ) || ( isset( $response->status ) && 0 === $response->status ) ) {
				if ( isset( $response->status ) ) {
					$data = json_decode( $response, true );
				} else {
					return new WP_Error( 'api_invalid_response_code', $response->get_error_message() );
				}
			}

			if ( wp_remote_retrieve_response_code( $response ) !== 200 ) {
				return new WP_Error( 'api_invalid_response_code', wp_remote_retrieve_body( $response ) );
			} else {
				$data = json_decode( wp_remote_retrieve_body( $response ), true );
			}

			$data = json_decode( wp_remote_retrieve_body( $response ), true );

			if ( ! isset( $data['code'] ) ) {
				$remote_args['id']                          = $data['id'];
				$remote_args['gyan-site-widgets-data']     = json_decode( $data['gyan-site-widgets-data'] );
				$remote_args['gyan-site-customizer-data']  = $data['gyan-site-customizer-data'];
				$remote_args['gyan-site-options-data']     = $data['gyan-site-options-data'];
				$remote_args['gyan-post-data-mapping']     = $data['gyan-post-data-mapping'];
				$remote_args['gyan-site-wxr-path']         = $data['gyan-site-wxr-path'];
				$remote_args['gyan-enabled-extensions']    = $data['gyan-enabled-extensions'];
				$remote_args['gyan-custom-404']            = $data['gyan-custom-404'];
				$remote_args['required-plugins']            = $data['required-plugins'];
				$remote_args['gyan-site-taxonomy-mapping'] = $data['gyan-site-taxonomy-mapping'];
				$remote_args['site-type']                   = $data['gyan-site-type'];
				$remote_args['gyan-site-url']              = $data['gyan-site-url'];
			}

			return wp_parse_args( $remote_args, $defaults );   // Merge remote demo and defaults.
		}

		// Clear Cache
		public function after_batch_complete() {

			// Clear 'Builder Builder' cache.
			if ( is_callable( 'FLBuilderModel::delete_asset_cache_for_all_posts' ) ) {
				FLBuilderModel::delete_asset_cache_for_all_posts();
			}

			// Clear 'Gyan Addon' cache.
			if ( is_callable( 'Gyan_Minify::refresh_assets' ) ) {
				Gyan_Minify::refresh_assets();
			}

			$this->update_latest_checksums();

			flush_rewrite_rules();  // Flush permalinks.

			Gyan_Sites_Importer_Log::add( 'Complete ' );
		}

		public function update_latest_checksums() {
			$latest_checksums = get_site_option( 'gyan-sites-last-export-checksums-latest', '' );
			update_site_option( 'gyan-sites-last-export-checksums', $latest_checksums, 'no' );
		}

		public function reset_customizer_data() {

			if ( ! defined( 'WP_CLI' ) && wp_doing_ajax() ) {
				check_ajax_referer( 'gyan-sites', '_ajax_nonce' );
				if ( ! current_user_can( 'customize' ) ) {
					wp_send_json_error( __( 'You are not allowed to perform this action', 'gyan-elements' ) );
				}
			}

			$themename = Gyan_Sites::get_instance()->get_theme_name();

			Gyan_Sites_Importer_Log::add( 'Deleted customizer Settings ' . wp_json_encode( get_option( $themename, array() ) ) );

			$themename = Gyan_Sites::get_instance()->get_theme_name();
			delete_option( $themename );

			if ( defined( 'WP_CLI' ) ) {
				WP_CLI::line( 'Deleted Customizer Settings!' );
			} elseif ( wp_doing_ajax() ) {
				wp_send_json_success();
			}
		}

		public function reset_site_options() {

			if ( ! defined( 'WP_CLI' ) && wp_doing_ajax() ) {
				check_ajax_referer( 'gyan-sites', '_ajax_nonce' );
				if ( ! current_user_can( 'customize' ) ) {
					wp_send_json_error( __( 'You are not allowed to perform this action', 'gyan-elements' ) );
				}
			}

			$options = get_option( '_gyan_sites_old_site_options', array() );
			Gyan_Sites_Importer_Log::add( 'Deleted - Site Options ' . wp_json_encode( $options ) );

			if ( $options ) {
				foreach ( $options as $option_key => $option_value ) {
					delete_option( $option_key );
				}
			}

			if ( defined( 'WP_CLI' ) ) {
				WP_CLI::line( 'Deleted Site Options!' );
			} elseif ( wp_doing_ajax() ) {
				wp_send_json_success();
			}
		}

		public function reset_widgets_data() {

			if ( ! defined( 'WP_CLI' ) && wp_doing_ajax() ) {
				check_ajax_referer( 'gyan-sites', '_ajax_nonce' );
				if ( ! current_user_can( 'customize' ) ) {
					wp_send_json_error( __( 'You are not allowed to perform this action', 'gyan-elements' ) );
				}
			}

			$old_widgets = (array) get_option( '_gyan_sites_old_widgets_data', array() );

			if ( ! empty( $old_widgets ) ) {

				Gyan_Sites_Importer_Log::add( 'DELETED - WIDGETS ' . wp_json_encode( $old_widgets ) );

				$sidebars_widgets = get_option( 'sidebars_widgets', array() );

				foreach ( $old_widgets as $sidebar_id => $widgets ) {

					if ( ! empty( $widgets ) && is_array( $widgets ) ) {
						foreach ( $widgets as $widget_key => $widget_data ) {

							if ( isset( $sidebars_widgets['wp_inactive_widgets'] ) ) {
								if ( ! in_array( $widget_key, $sidebars_widgets['wp_inactive_widgets'], true ) ) {
									$sidebars_widgets['wp_inactive_widgets'][] = $widget_key;
								}
							}
						}
					}
				}

				update_option( 'sidebars_widgets', $sidebars_widgets );
			}

			if ( defined( 'WP_CLI' ) ) {
				WP_CLI::line( 'Deleted Widgets!' );
			} elseif ( wp_doing_ajax() ) {
				wp_send_json_success();
			}
		}

		public function delete_imported_posts( $post_id = 0 ) {

			if ( wp_doing_ajax() ) {
				check_ajax_referer( 'gyan-sites', '_ajax_nonce' );
				if ( ! current_user_can( 'customize' ) ) {
					wp_send_json_error( __( 'You are not allowed to perform this action', 'gyan-elements' ) );
				}
			}

			$post_id = isset( $_REQUEST['post_id'] ) ? absint( $_REQUEST['post_id'] ) : $post_id;
			$message = 'Deleted - Post ID ' . $post_id . ' - ' . get_post_type( $post_id ) . ' - ' . get_the_title( $post_id );
			$message = '';

			if ( $post_id ) {

				$post_type = get_post_type( $post_id );
				$message   = 'Deleted - Post ID ' . $post_id . ' - ' . $post_type . ' - ' . get_the_title( $post_id );

				do_action( 'gyan_sites_before_delete_imported_posts', $post_id, $post_type );

				Gyan_Sites_Importer_Log::add( $message );
				wp_delete_post( $post_id, true );
			}

			if ( defined( 'WP_CLI' ) ) {
				WP_CLI::line( $message );
			} elseif ( wp_doing_ajax() ) {
				wp_send_json_success( $message );
			}
		}

		public function delete_imported_wp_forms( $post_id = 0 ) {

			if ( ! defined( 'WP_CLI' ) && wp_doing_ajax() ) {
				check_ajax_referer( 'gyan-sites', '_ajax_nonce' );
				if ( ! current_user_can( 'customize' ) ) {
					wp_send_json_error( __( 'You are not allowed to perform this action', 'gyan-elements' ) );
				}
			}

			$post_id = isset( $_REQUEST['post_id'] ) ? absint( $_REQUEST['post_id'] ) : $post_id;
			$message = '';
			if ( $post_id ) {

				do_action( 'gyan_sites_before_delete_imported_wp_forms', $post_id );

				$message = 'Deleted - Form ID ' . $post_id . ' - ' . get_post_type( $post_id ) . ' - ' . get_the_title( $post_id );
				Gyan_Sites_Importer_Log::add( $message );
				wp_delete_post( $post_id, true );
			}

			if ( defined( 'WP_CLI' ) ) {
				WP_CLI::line( $message );
			} elseif ( wp_doing_ajax() ) {
				wp_send_json_success( $message );
			}
		}

		public function delete_imported_terms( $term_id = 0 ) {
			if ( ! defined( 'WP_CLI' ) && wp_doing_ajax() ) {
				// Verify Nonce.
				check_ajax_referer( 'gyan-sites', '_ajax_nonce' );

				if ( ! current_user_can( 'customize' ) ) {
					wp_send_json_error( __( 'You are not allowed to perform this action', 'gyan-elements' ) );
				}
			}

			$term_id = isset( $_REQUEST['term_id'] ) ? absint( $_REQUEST['term_id'] ) : $term_id;

			$message = '';
			if ( $term_id ) {
				$term = get_term( $term_id );
				if ( ! is_wp_error( $term ) ) {

					do_action( 'gyan_sites_before_delete_imported_terms', $term_id, $term );

					$message = 'Deleted - Term ' . $term_id . ' - ' . $term->name . ' ' . $term->taxonomy;
					Gyan_Sites_Importer_Log::add( $message );
					wp_delete_term( $term_id, $term->taxonomy );
				}
			}

			if ( defined( 'WP_CLI' ) ) {
				WP_CLI::line( $message );
			} elseif ( wp_doing_ajax() ) {
				wp_send_json_success( $message );
			}
		}

	}

	Gyan_Sites_Importer::get_instance();
}