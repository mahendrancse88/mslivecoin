<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
use Elementor\Core\Schemes;

if ( ! class_exists( 'Gyan_Sites' ) ) :
	class Gyan_Sites {

		public $api_domain;
		public $api_url;
		public $search_url;
		public $pixabay_url;
		public $pixabay_api_key;
		private static $instance = null;
		public static $local_vars = array();
		public $wp_upload_url = '';

		public static function get_instance() { if ( ! isset( self::$instance ) ) {self::$instance = new self(); } return self::$instance; }

		private function __construct() {

			add_action( 'admin_init', array( $this, 'one_click_demo_import_plugin_status' ) );

			$this->set_api_url();
			$this->includes();

			add_action( 'plugin_action_links_' . GYAN_PLUGIN_BASE, array( $this, 'action_links' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue' ), 99 );
			add_action( 'elementor/editor/footer', array( $this, 'insert_templates' ) );
			add_action( 'elementor/editor/footer', array( $this, 'register_widget_scripts' ), 99 );
			add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'popup_styles' ) );
			add_action( 'elementor/preview/enqueue_styles', array( $this, 'popup_styles' ) );

			// AJAX.
			add_action( 'wp_ajax_gyan-required-plugins', array( $this, 'required_plugin' ) );
			add_action( 'wp_ajax_gyan-required-plugin-activate', array( $this, 'required_plugin_activate' ) );
			add_action( 'wp_ajax_gyan-sites-backup-settings', array( $this, 'backup_settings' ) );
			add_action( 'wp_ajax_gyan-sites-set-reset-data', array( $this, 'get_reset_data' ) );
			add_action( 'wp_ajax_gyan-sites-create-page', array( $this, 'create_page' ) );
			add_action( 'wp_ajax_gyan-sites-api-request', array( $this, 'api_request' ) );
			add_action( 'wp_ajax_gyan-page-elementor-batch-process', array( $this, 'elementor_batch_process' ) );

			// add_filter( 'heartbeat_received', array( $this, 'search_push' ), 10, 2 );
		}

		// Push Data to Search API
		// public function search_push( $response, $data ) {
		// 	if ( empty( $data['gyn-sites-search-terms'] ) ) { return $response; }  // If we didn't receive our data, don't send any back.
		// 	$args = array(
		// 		'timeout'   => 3,
		// 		'blocking'  => true,
		// 		'sslverify' => apply_filters( 'https_local_ssl_verify', false ),
		// 		'body'      => array(
		// 			'search' => $data['gyn-sites-search-terms'],
		// 			'url'    => esc_url( site_url() ),
		// 		),
		// 	);
		// 	$result                             = wp_remote_post( $this->search_url, $args );
		// 	$response['gyn-sites-search-terms'] = wp_remote_retrieve_body( $result );

		// 	return $response;
		// }


		function one_click_demo_import_plugin_status() {
		  	if ( function_exists( 'is_plugin_active' ) ) {

			  	if ( is_plugin_active('one-click-demo-import/one-click-demo-import.php') ) {
			   	deactivate_plugins('one-click-demo-import/one-click-demo-import.php');
			   }

			}
		}


		// Elementor Batch Process via AJAX
		public function elementor_batch_process() {
			check_ajax_referer( 'gyan-sites', '_ajax_nonce' );
			if ( ! current_user_can( 'edit_posts' ) ) { wp_send_json_error( __( 'You are not allowed to perform this action', 'gyan-elements' ) ); }

			if ( ! isset( $_POST['url'] ) ) {
				wp_send_json_error( __( 'Invalid API URL', 'gyan-elements' ) );
			}

			$response = wp_remote_get( $_POST['url'] );

			if ( is_wp_error( $response ) ) {
				wp_send_json_error( wp_remote_retrieve_body( $response ) );
			}

			$body = wp_remote_retrieve_body( $response );
			$data = json_decode( $body, true );
			if ( ! isset( $data['post-meta']['_elementor_data'] ) ) {
				wp_send_json_error( __( 'Invalid Post Meta', 'gyan-elements' ) );
			}

			$meta    = json_decode( $data['post-meta']['_elementor_data'], true );
			$post_id = $_POST['id'];

			if ( empty( $post_id ) || empty( $meta ) ) {
				wp_send_json_error( __( 'Invalid Post ID or Elementor Meta', 'gyan-elements' ) );
			}

			// load fa4 = font awesome version 4 migration
			if ( isset( $data['gyan-page-options-data'] ) && isset( $data['gyan-page-options-data']['elementor_load_fa4_shim'] ) ) {
				update_option( 'elementor_load_fa4_shim', $data['gyan-page-options-data']['elementor_load_fa4_shim'] );
			}

			$import      = new \Elementor\TemplateLibrary\Gyan_Sites_Elementor_Pages();
			$import_data = $import->import( $post_id, $meta );

			wp_send_json_success( $import_data );
		}

		public function api_request() {
			$url = isset( $_POST['url'] ) ? $_POST['url'] : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing

			if ( empty( $url ) ) {
				wp_send_json_error( __( 'Provided API URL is empty! Please try again!', 'gyan-elements' ) );
			}

			$api_args = apply_filters( 'gyan_sites_api_args', array('timeout' => 30 ) );

			$request = wp_remote_get( trailingslashit( self::get_instance()->get_api_domain() ) . 'wp-json/wp/v2/' . $url, $api_args );
			if ( ! is_wp_error( $request ) && 200 === (int) wp_remote_retrieve_response_code( $request ) ) {

				$demo_data = json_decode( wp_remote_retrieve_body( $request ), true );
				update_option( 'gyan_sites_import_data', $demo_data );

				wp_send_json_success( $demo_data );
			} elseif ( is_wp_error( $request ) ) {
				wp_send_json_error( 'API Request is failed due to ' . $request->get_error_message() );
			} elseif ( 200 !== (int) wp_remote_retrieve_response_code( $request ) ) {
				$demo_data = json_decode( wp_remote_retrieve_body( $request ), true );
				if ( is_array( $demo_data ) && isset( $demo_data['code'] ) ) {
					wp_send_json_error( $demo_data['message'] );
				} else {
					wp_send_json_error( wp_remote_retrieve_body( $request ) );
				}
			}
		}

		public function insert_templates() {
			ob_start();
			require_once GYAN_PLUGIN_DIR . 'demos/includes/templates.php';
			ob_end_flush();
		}

		public function create_page() {

			// Verify Nonce.
			check_ajax_referer( 'gyan-sites', '_ajax_nonce' );

			if ( ! current_user_can( 'customize' ) ) {
				wp_send_json_error( __( 'You are not allowed to perform this action', 'gyan-elements' ) );
			}

			$default_page_builder = Gyan_Sites_Page::get_instance()->get_setting( 'page_builder' );

			$content = isset( $_POST['data']['original_content'] ) ? $_POST['data']['original_content'] : ( isset( $_POST['data']['content']['rendered'] ) ? $_POST['data']['content']['rendered'] : '' );

			// load fa4 = font awesome version 4 migration
			if ( 'elementor' === $default_page_builder ) {
				if ( isset( $_POST['data']['gyan-page-options-data'] ) && isset( $_POST['data']['gyan-page-options-data']['elementor_load_fa4_shim'] ) ) {
					update_option( 'elementor_load_fa4_shim', $_POST['data']['gyan-page-options-data']['elementor_load_fa4_shim'] );
				}
			}

			$data = isset( $_POST['data'] ) ? $_POST['data'] : array();

			if ( empty( $data ) ) {
				wp_send_json_error( 'Empty page data.' );
			}

			$page_id = isset( $_POST['data']['id'] ) ? $_POST['data']['id'] : '';
			$title   = isset( $_POST['data']['title']['rendered'] ) ? $_POST['data']['title']['rendered'] : '';
			$excerpt = isset( $_POST['data']['excerpt']['rendered'] ) ? $_POST['data']['excerpt']['rendered'] : '';

			$post_args = array(
				'post_type'    => 'page',
				'post_status'  => 'draft',
				'post_title'   => $title,
				'post_content' => $content,
				'post_excerpt' => $excerpt,
			);

			$new_page_id = wp_insert_post( $post_args );
			update_post_meta( $new_page_id, '_gyan_sites_enable_for_batch', true );

			$post_meta = isset( $_POST['data']['post-meta'] ) ? $_POST['data']['post-meta'] : array();

			if ( ! empty( $post_meta ) ) {
				$this->import_post_meta( $new_page_id, $post_meta );
			}

			if ( isset( $_POST['data']['gyan-page-options-data'] ) && ! empty( $_POST['data']['gyan-page-options-data'] ) ) {

				foreach ( $_POST['data']['gyan-page-options-data'] as $option => $value ) {
					update_option( $option, $value );
				}
			}

			$get_wp_page_template = get_post_meta( $new_page_id, '_wp_page_template', true );

			if ( 'elementor' === $default_page_builder ) {
				update_post_meta( $new_page_id, '_wp_page_template', 'elementor_header_footer' );
			}

			// If page template is not defined then set as default template
			if ( '' == $get_wp_page_template ) {
				update_post_meta( $new_page_id, '_wp_page_template', '' );
			}

			do_action( 'gyan_sites_process_single', $new_page_id );

			wp_send_json_success(
				array(
					'remove-page-id' => $page_id,
					'id'             => $new_page_id,
					'link'           => get_permalink( $new_page_id ),
				)
			);
		}

		// Import Post Meta
		public function import_post_meta( $post_id, $metadata ) {

			$metadata = (array) $metadata;

			foreach ( $metadata as $meta_key => $meta_value ) {

				if ( $meta_value ) {

					if ( '_elementor_data' === $meta_key ) {

						$raw_data = json_decode( stripslashes( $meta_value ), true );

						if ( is_array( $raw_data ) ) {
							$raw_data = wp_slash( wp_json_encode( $raw_data ) );
						} else {
							$raw_data = wp_slash( $raw_data );
						}
					} else {

						if ( is_serialized( $meta_value, true ) ) {
							$raw_data = maybe_unserialize( stripslashes( $meta_value ) );
						} elseif ( is_array( $meta_value ) ) {
							$raw_data = json_decode( stripslashes( $meta_value ), true );
						} else {
							$raw_data = $meta_value;
						}
					}

					update_post_meta( $post_id, $meta_key, $raw_data );
				}
			}
		}

		// Import Post Meta
		public function import_template_meta( $post_id, $metadata ) {
			$metadata = (array) $metadata;

			foreach ( $metadata as $meta_key => $meta_value ) {

				if ( $meta_value ) {

					if ( '_elementor_data' === $meta_key ) {

						$raw_data = json_decode( stripslashes( $meta_value ), true );

						if ( is_array( $raw_data ) ) {
							$raw_data = wp_slash( wp_json_encode( $raw_data ) );
						} else {
							$raw_data = wp_slash( $raw_data );
						}
					} else {

						if ( is_serialized( $meta_value, true ) ) {
							$raw_data = maybe_unserialize( stripslashes( $meta_value ) );
						} elseif ( is_array( $meta_value ) ) {
							$raw_data = json_decode( stripslashes( $meta_value ), true );
						} else {
							$raw_data = $meta_value;
						}
					}

					update_post_meta( $post_id, $meta_key, $raw_data );
				}
			}
		}

		// Set reset data
		public function get_reset_data() {
			if ( wp_doing_ajax() ) {
				check_ajax_referer( 'gyan-sites', '_ajax_nonce' );
				if ( ! current_user_can( 'manage_options' ) ) { return; }
			}

			global $wpdb;
			$post_ids = $wpdb->get_col( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key='_gyan_sites_imported_post'" );
			$form_ids = $wpdb->get_col( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key='_gyan_sites_imported_wp_forms'" );
			$term_ids = $wpdb->get_col( "SELECT term_id FROM {$wpdb->termmeta} WHERE meta_key='_gyan_sites_imported_term'" );

			$data = array(
				'reset_posts'    => $post_ids,
				'reset_wp_forms' => $form_ids,
				'reset_terms'    => $term_ids,
			);

			if ( wp_doing_ajax() ) {
				wp_send_json_success( $data );
			}

			return $data;
		}

		// Backup our existing settings.
		public function backup_settings() {

			if ( ! defined( 'WP_CLI' ) && wp_doing_ajax() ) {
				check_ajax_referer( 'gyan-sites', '_ajax_nonce' );

				if ( ! current_user_can( 'manage_options' ) ) {
					wp_send_json_error( __( 'User does not have permission!', 'gyan-elements' ) );
				}
			}

			$file_name    = 'gyan-sites-backup-' . gmdate( 'd-M-Y-h-i-s' ) . '.json';
			$themename = Gyan_Sites::get_instance()->get_theme_name();
			$old_settings = get_option( $themename, array() );
			$upload_dir   = Gyan_Sites_Importer_Log::get_instance()->log_dir();
			$upload_path  = trailingslashit( $upload_dir['path'] );
			$log_file     = $upload_path . $file_name;
			$file_system  = self::get_instance()->get_filesystem();

			// If file system fails? Then take a backup in site option.
			if ( false === $file_system->put_contents( $log_file, wp_json_encode( $old_settings ), FS_CHMOD_FILE ) ) {
				update_option( 'gyan_sites_' . $file_name, $old_settings );
			}

			if ( defined( 'WP_CLI' ) ) {
				WP_CLI::line( 'File generated at ' . $log_file );
			} elseif ( wp_doing_ajax() ) {
				wp_send_json_success();
			}
		}

		// Show action links on the plugin screen
		public function action_links( $links ) {

			$arguments = array('page' => 'demo-templates');
			$current_page_builder = Gyan_Sites_Page::get_instance()->get_setting( 'page_builder' );

			if ( empty( $current_page_builder ) ) {
				$arguments['change-page-builder'] = 'yes';
			}
			$url = add_query_arg( $arguments, admin_url( 'themes.php' ) );

			$action_links = array(
				'settings' => '<a href="' . esc_url( $url ) . '" aria-label="' . esc_attr__( 'See Library', 'gyan-elements' ) . '">' . esc_html__( 'See Library', 'gyan-elements' ) . '</a>',
			);

			return array_merge( $action_links, $links );
		}

		// Get the API URL
		public static function get_api_domain() {
			return apply_filters( 'gyan_sites_api_domain', 'https://demos.premiumthemes.in/' );
		}

		// Setter for $api_url
		public function set_api_url() {
			$this->api_domain = trailingslashit( self::get_api_domain() );
			$this->api_url    = apply_filters( 'gyan_sites_api_url', $this->api_domain . 'wp-json/wp/v2/' );
		}

		public function get_api_url() {
			return $this->api_url;
		}

		// Enqueue admin scripts
		public function admin_enqueue( $hook = '' ) {

			if ( 'theme-panel_page_demo-templates' !== $hook ) { return; }

			global $is_IE, $is_edge;

			if ( $is_IE || $is_edge ) {
				wp_enqueue_script( 'gyan-sites-eventsource', GYAN_PLUGIN_URI . 'demos/assets/js/eventsource.min.js', array( 'jquery', 'wp-util', 'updates' ), GYAN_ELEMENTS_VERSION, true );
			}

			wp_register_script( 'gyan-sites-fetch', GYAN_PLUGIN_URI . 'demos/assets/js/fetch.umd.js', array( 'jquery' ), GYAN_ELEMENTS_VERSION, true );  // Fetch.
			wp_register_script( 'gyan-sites-history', GYAN_PLUGIN_URI . 'demos/assets/js/history.js', array( 'jquery' ), GYAN_ELEMENTS_VERSION, true );  // History.
			wp_register_script( 'gyan-sites-api', GYAN_PLUGIN_URI . 'demos/assets/js/gyan-sites-api.js', array( 'jquery', 'gyan-sites-fetch' ), GYAN_ELEMENTS_VERSION, true );  // API.

			// Admin Page.
			wp_enqueue_style( 'gyan-sites-admin', GYAN_PLUGIN_URI . 'demos/assets/css/admin.css', GYAN_ELEMENTS_VERSION, true );
			wp_style_add_data( 'gyan-sites-admin', 'rtl', 'replace' );
			wp_enqueue_script( 'gyan-sites-admin-page', GYAN_PLUGIN_URI . 'demos/assets/js/admin-page.js', array( 'jquery', 'wp-util', 'updates', 'jquery-ui-autocomplete', 'gyan-sites-api', 'gyan-sites-history' ), GYAN_ELEMENTS_VERSION, true );

			$data = $this->get_local_vars();

			wp_localize_script( 'gyan-sites-admin-page', 'gyanSitesVars', $data );
		}

		// Returns Localization Variables
		public function get_local_vars() {

			$stored_data = array(
				'gyan-site-category'        => array(),
				'gyan-site-page-builder'    => array(),
				'gyan-sites'                => array(),
				'site-pages-category'        => array(),
				'site-pages-page-builder'    => array(),
				'site-pages-parent-category' => array(),
				'site-pages'                 => array(),
			);

			// Use this for premium demos.
			$request_params = apply_filters(
				'gyan_sites_api_params',
				array(
					'site_url'     => '',
					'per-page'     => 15,
				)
			);

			$default_page_builder = Gyan_Sites_Page::get_instance()->get_setting( 'page_builder' );

			$data = apply_filters(
				'gyan_sites_localize_vars',
				array(
					'debug'                              => defined( 'WP_DEBUG' ) ? true : false,
					'demoPageTitle'                     => 'Demo Templates',
					'ajaxurl'                            => esc_url( admin_url( 'admin-ajax.php' ) ),
					'siteURL'                            => site_url(),
					'_ajax_nonce'                        => wp_create_nonce( 'gyan-sites' ),
					'requiredPlugins'                    => array(),
					'syncLibraryStart'                   => '<span class="message">' . esc_html__( 'Refreshing demos in the background. It can take up to few minutes.', 'gyan-elements' ) . '</span>',
					'xmlRequiredFilesMissing'            => __( 'Some of the files required during the import process are missing.<br/><br/>Please try again after some time.', 'gyan-elements' ),
					'importFailedMessageDueToDebug'      => __( '<p>WordPress debug mode is currently enabled on your website. This has interrupted the import process..</p><p>Kindly disable debug mode and try importing Demo Template again.</p><p>You can add the following code into the wp-config.php file to disable debug mode.</p><p><code>define(\'WP_DEBUG\', false);</code></p>', 'gyan-elements' ),
					/* translators: %s is a documentation link. */
					'importFailedMessage'                => sprintf( __( '<p>Your website is facing a temporary issue in connecting the template server.</p><p>Read <a href="%s" target="_blank">article</a> to resolve the issue and continue importing template.</p>', 'gyan-elements' ), esc_url( 'https://bizixdocs.premiumthemes.in/one-click-demo-install-problems/' ) ),
					/* translators: %s is a documentation link. */
					'importFailedRequiredPluginsMessage' => sprintf( __( '<p>Your website is facing a temporary issue in connecting the template server. Please install and activate required pluigns from <strong>Admin > Appearance > Install Plugins</strong></p><p>Read an <a href="%s" target="_blank">article</a> for more details.</p>', 'gyan-elements' ), esc_url( 'https://bizixdocs.premiumthemes.in/3-plugins-installation/' ) ),
					'strings'                            => array(
						'warningBeforeCloseWindow' => __( 'Warning! Import process is not complete. Don\'t close the window until import process complete. Do you still want to leave the window?', 'gyan-elements' ),
						'viewSite'                 => __( 'Done! View Site', 'gyan-elements' ),
						'syncCompleteMessage'      => self::get_instance()->get_sync_complete_message(),
						/* translators: %s is a template name */
						'importSingleTemplate'     => __( 'Import "%s" Page Template', 'gyan-elements' ),
					),
					'log'                                => array(
						'bulkInstall'  => __( 'Installing Required Plugins..', 'gyan-elements' ),
					),
					'default_page_builder'               => 'elementor',
					'default_page_builder_data'          => Gyan_Sites_Page::get_instance()->get_default_page_builder(),
					'default_page_builder_sites'         => Gyan_Sites_Page::get_instance()->get_sites_by_page_builder( $default_page_builder ),
					'sites'                              => $request_params,
					'categories'                         => array(),
					'page-builders'                      => array(),
					'api_sites_and_pages_tags'           => $this->get_api_option( 'gyan-sites-tags' ),
					'ApiDomain'                          => $this->api_domain,
					'ApiURL'                             => $this->api_url,
					'category_slug'                      => 'gyan-site-category',
					'page_builder'                       => 'gyan-site-page-builder',
					'cpt_slug'                           => 'gyan-sites',
					'parent_category'                    => '',
					'compatibilities'                    => $this->get_compatibilities(),
					'compatibilities_data'               => $this->get_compatibilities_data(),
					'dismiss'                            => __( 'Dismiss this notice.', 'gyan-elements' ),
				)
			);

			return $data;
		}

		// Import Compatibility Errors
		public function get_compatibilities_data() {
			return array(
				'xmlreader'            => array(
					'title'   => esc_html__( 'XMLReader Support Missing', 'gyan-elements' ),
					/* translators: %s doc link. */
					'tooltip' => '<p>' . esc_html__( 'To complete the process, enable XMLReader support on your website. Just get in touch with your service administrator and request them to enable XMLReader on your website. Once this is done you can try importing template again.', 'gyan-elements' ) . '</p>',
				),
				'curl'                 => array(
					'title'   => esc_html__( 'cURL Support Missing', 'gyan-elements' ),
					/* translators: %s doc link. */
					'tooltip' => '<p>' . esc_html__( 'Just get in touch with your service administrator and request them to enable cURL support on your website. Once this is done you can try importing template again.', 'gyan-elements' ) . '</p>',
				),
				'wp-debug'             => array(
					'title'   => esc_html__( 'Disable Debug Mode', 'gyan-elements' ),
					/* translators: %s doc link. */
					'tooltip' => '<p>' . esc_html__( 'WordPress debug mode is currently enabled on your website. With this, any errors from third-party plugins might affect the import process.', 'gyan-elements' ) . '</p><p>' . esc_html__( 'Kindly disable it to continue importing the Demo Template. To do so, you can add the following code into the wp-config.php file.', 'gyan-elements' ) . '</p><p><code>define(\'WP_DEBUG\', false);</code></p>',
				),
				'update-available'     => array(
					'title'   => esc_html__( 'Update Plugin', 'gyan-elements' ),
					/* translators: %s update page link. */
					'tooltip' => '<p>' . esc_html__( 'Updates are available for plugins used in this demo template.', 'gyan-elements' ) . '</p>##LIST##<p>' . sprintf( __( 'Kindly <a href="%s" target="_blank">update</a> them for a successful import. Skipping this step might break the template design/feature.', 'gyan-elements' ), esc_url( network_admin_url( 'update-core.php' ) ) ) . '</p>',
				),
				'third-party-required' => array(
					'title'   => esc_html__( 'Required Plugins Missing', 'gyan-elements' ),
					'tooltip' => '<p>' . esc_html__( 'This demo template requires premium plugins. As these are third party premium plugins, you\'ll need to purchase, install and activate them first.', 'gyan-elements' ) . '</p>',
				),
				'dynamic-page'         => array(
					'title'   => esc_html__( 'Dynamic Page', 'gyan-elements' ),
					'tooltip' => '<p>' . esc_html__( 'The page template you are about to import contains a dynamic widget/module. Please note this dynamic data will not be available with the imported page.', 'gyan-elements' ) . '</p><p>' . esc_html__( 'You will need to add it manually on the page.', 'gyan-elements' ) . '</p><p>' . esc_html__( 'This dynamic content will be available when you import the entire site.', 'gyan-elements' ) . '</p>',
				),
			);
		}

		public function get_compatibilities() {

			$data = $this->get_compatibilities_data();
			$compatibilities = array(
				'errors'   => array(),
				'warnings' => array(),
			);

			if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) { $compatibilities['warnings']['wp-debug'] = $data['wp-debug']; }
			if ( ! class_exists( 'XMLReader' ) ) { $compatibilities['errors']['xmlreader'] = $data['xmlreader']; }
			if ( ! function_exists( 'curl_version' ) ) { $compatibilities['errors']['curl'] = $data['curl']; }

			return $compatibilities;
		}

		// Register module required js on elementor's action
		public function register_widget_scripts() {

			$page_builders = self::get_instance()->get_page_builders();
			$has_elementor = false;

			foreach ( $page_builders as $page_builder ) {

				if ( 'elementor' === $page_builder['slug'] ) {
					$has_elementor = true;
				}
			}

			if ( ! $has_elementor ) { return; }

			wp_enqueue_script( 'gyan-sites-helper', GYAN_PLUGIN_URI . 'demos/assets/js/helper.js', array( 'jquery' ), GYAN_ELEMENTS_VERSION, true );
			wp_enqueue_script( 'masonry' );
			wp_enqueue_script( 'imagesloaded' );

			wp_enqueue_script( 'gyan-sites-elementor-admin-page', GYAN_PLUGIN_URI . 'demos/assets/js/elementor-admin-page.js', array( 'jquery', 'wp-util', 'updates', 'masonry', 'imagesloaded' ), GYAN_ELEMENTS_VERSION, true );
			wp_localize_script( 'gyan-sites-elementor-admin-page', 'pagenow', GYAN_PLUGIN_NAME );

			wp_enqueue_style( 'gyan-sites-admin', GYAN_PLUGIN_URI . 'demos/assets/css/admin.css', GYAN_ELEMENTS_VERSION, true );
			wp_style_add_data( 'gyan-sites-admin', 'rtl', 'replace' );

			// Use this for premium demos.
			$request_params = apply_filters(
				'gyan_sites_api_params',
				array(
					'site_url'     => '',
					'per-page'     => 15,
				)
			);

			$data = apply_filters(
				'gyan_sites_render_localize_vars',
				array(
					'plugin_name'                => 'Demo Templates',
					'sites'                      => $request_params,
					'settings'                   => array(),
					'page-builders'              => array(),
					'categories'                 => array(),
					'default_page_builder'       => 'elementor',
					'gyan_blocks'               => $this->get_all_blocks(),
					'ajaxurl'                    => esc_url( admin_url( 'admin-ajax.php' ) ),
					'api_sites_and_pages_tags'   => $this->get_api_option( 'gyan-sites-tags' ),
					'default_page_builder_sites' => Gyan_Sites_Page::get_instance()->get_sites_by_page_builder( 'elementor' ),
					'ApiURL'                     => $this->api_url,
					'_ajax_nonce'                => wp_create_nonce( 'gyan-sites' ),
					'gyan_block_categories'     => $this->get_api_option( 'gyan-blocks-categories' ),
					'siteURL'                    => site_url(),
					'template'                   => esc_html__( 'Template', 'gyan-elements' ),
					'block'                      => esc_html__( 'Block', 'gyan-elements' ),
					'dismiss_text'               => esc_html__( 'Dismiss', 'gyan-elements' ),
					'install_plugin_text'        => esc_html__( 'Install Required Plugins', 'gyan-elements' ),
					'syncCompleteMessage'        => self::get_instance()->get_sync_complete_message(),
					/* translators: %s are link. */
					'page_settings'              => array(
						'message'  => __( 'You can locate <strong>Demo Templates Settings</strong> under the <strong>Page Settings</strong> of the Style Tab.', 'gyan-elements' ),
						'url'      => '#',
						'url_text' => __( 'Read More →', 'gyan-elements' ),
					),
				)
			);

			wp_localize_script( 'gyan-sites-elementor-admin-page', 'gyanElementorSites', $data );
		}

		// Register module required js on elementor's action
		public function popup_styles() {
			wp_enqueue_style( 'gyan-sites-elementor-admin-page', GYAN_PLUGIN_URI . 'demos/assets/css/elementor-admin.css', GYAN_ELEMENTS_VERSION, true );
			wp_enqueue_style( 'gyan-sites-elementor-admin-page-dark', GYAN_PLUGIN_URI . 'demos/assets/css/elementor-admin-dark.css', GYAN_ELEMENTS_VERSION, true );
			wp_style_add_data( 'gyan-sites-elementor-admin-page', 'rtl', 'replace' );
		}

		public function get_all_sites() {
			$sites_and_pages = array();
			$total_requests  = (int) get_site_option( 'gyan-sites-requests', 0 );

			for ( $page = 1; $page <= $total_requests; $page++ ) {
				$current_page_data = get_site_option( 'gyan-sites-and-pages-page-' . $page, array() );
				if ( ! empty( $current_page_data ) ) {
					foreach ( $current_page_data as $page_id => $page_data ) {
						$sites_and_pages[ $page_id ] = $page_data;
					}
				}
			}

			return $sites_and_pages;
		}

		public function get_api_option( $option ) {
			return get_site_option( $option, array() );
		}

		public function get_all_blocks() {

			$blocks         = array();
			$total_requests = (int) get_site_option( 'gyan-blocks-requests', 0 );

			for ( $page = 1; $page <= $total_requests; $page++ ) {
				$current_page_data = get_site_option( 'gyan-blocks-' . $page, array() );
				if ( ! empty( $current_page_data ) ) {
					foreach ( $current_page_data as $page_id => $page_data ) {
						$blocks[ $page_id ] = $page_data;
					}
				}
			}

			return $blocks;
		}

		private function includes() {
			require_once GYAN_PLUGIN_DIR . 'demos/classes/functions.php';
			require_once GYAN_PLUGIN_DIR . 'demos/classes/class-gyan-sites-page.php';
			require_once GYAN_PLUGIN_DIR . 'demos/classes/class-gyan-sites-elementor-pages.php';
			require_once GYAN_PLUGIN_DIR . 'demos/classes/class-gyan-sites-elementor-images.php';
			require_once GYAN_PLUGIN_DIR . 'demos/classes/compatibility/class-gyan-sites-compatibility.php';
			require_once GYAN_PLUGIN_DIR . 'demos/classes/class-gyan-sites-importer.php';
		}

		public function required_plugin_activate( $init = '', $options = array(), $enabled_extensions = array() ) {

			if ( ! defined( 'WP_CLI' ) && wp_doing_ajax() ) {
				check_ajax_referer( 'gyan-sites', '_ajax_nonce' );

				if ( ! current_user_can( 'install_plugins' ) || ! isset( $_POST['init'] ) || ! $_POST['init'] ) {
					wp_send_json_error(
						array(
							'success' => false,
							'message' => __( 'Error: You don\'t have the required permissions to install plugins.', 'gyan-elements' ),
						)
					);
				}
			}

			$plugin_init = ( isset( $_POST['init'] ) ) ? esc_attr( $_POST['init'] ) : $init;

			wp_clean_plugins_cache();

			$activate = activate_plugin( $plugin_init, '', false, true );

			if ( is_wp_error( $activate ) ) {
				if ( defined( 'WP_CLI' ) ) {
					WP_CLI::error( 'Plugin Activation Error: ' . $activate->get_error_message() );
				} elseif ( wp_doing_ajax() ) {
					wp_send_json_error(
						array(
							'success' => false,
							'message' => $activate->get_error_message(),
						)
					);
				}
			}

			$options            = ( isset( $_POST['options'] ) ) ? json_decode( stripslashes( $_POST['options'] ) ) : $options;
			$enabled_extensions = ( isset( $_POST['enabledExtensions'] ) ) ? json_decode( stripslashes( $_POST['enabledExtensions'] ) ) : $enabled_extensions;

			$this->after_plugin_activate( $plugin_init, $options, $enabled_extensions );

			if ( defined( 'WP_CLI' ) ) {
				WP_CLI::line( 'Plugin Activated!' );
			} elseif ( wp_doing_ajax() ) {
				wp_send_json_success(
					array(
						'success' => true,
						'message' => __( 'Plugin Activated', 'gyan-elements' ),
					)
				);
			}
		}

		public function required_plugin( $required_plugins = array(), $options = array(), $enabled_extensions = array() ) {

			// Verify Nonce.
			if ( ! defined( 'WP_CLI' ) && wp_doing_ajax() ) {
				check_ajax_referer( 'gyan-sites', '_ajax_nonce' );
			}

			$response = array(
				'active'       => array(),
				'inactive'     => array(),
				'notinstalled' => array(),
			);

			$required_plugins = ( isset( $_POST['required_plugins'] ) ) ? $_POST['required_plugins'] : $required_plugins;

			$slider_revolution_site = 'https://www.sliderrevolution.com/';

			$third_party_required_plugins = array();
			$third_party_plugins          = array(
				'revslier' => array('init' => 'revslider/revslider.php', 'name' => 'Slider Revolution', 'link' => $slider_revolution_site ),
			);

			$options                 = ( isset( $_POST['options'] ) ) ? json_decode( stripslashes( $_POST['options'] ) ) : $options;
			$enabled_extensions      = ( isset( $_POST['enabledExtensions'] ) ) ? json_decode( stripslashes( $_POST['enabledExtensions'] ) ) : $enabled_extensions;
			$plugin_updates          = get_plugin_updates();
			$update_avilable_plugins = array();

			if ( ! empty( $required_plugins ) ) {
				foreach ( $required_plugins as $key => $plugin ) {

					if ( array_key_exists( $plugin['init'], $plugin_updates ) ) {
						$update_avilable_plugins[] = $plugin;
					}

					// Installed but Inactive.
					if ( file_exists( WP_PLUGIN_DIR . '/' . $plugin['init'] ) && is_plugin_inactive( $plugin['init'] ) ) {

						$response['inactive'][] = $plugin;

						// Not Installed.
					} elseif ( ! file_exists( WP_PLUGIN_DIR . '/' . $plugin['init'] ) ) {

						// Added premium plugins which need to install first.
						if ( array_key_exists( $plugin['slug'], $third_party_plugins ) ) {
							$third_party_required_plugins[] = $third_party_plugins[ $plugin['slug'] ];
						} else {
							$response['notinstalled'][] = $plugin;
						}

						// Active.
					} else {
						$response['active'][] = $plugin;
						$this->after_plugin_activate( $plugin['init'], $options, $enabled_extensions );
					}

				}
			}

			// Checking the `install_plugins` and `activate_plugins` capability for the current user.
			// To perform plugin installation process.
			if (
				( ! defined( 'WP_CLI' ) && wp_doing_ajax() ) &&
				( ( ! current_user_can( 'install_plugins' ) && ! empty( $response['notinstalled'] ) ) || ( ! current_user_can( 'activate_plugins' ) && ! empty( $response['inactive'] ) ) ) ) {
				$message               = __( 'Insufficient Permission. Please contact your Super Admin to allow the install required plugin permissions.', 'gyan-elements' );
				$required_plugins_list = array_merge( $response['notinstalled'], $response['inactive'] );
				$markup                = $message;
				$markup               .= '<ul>';
				foreach ( $required_plugins_list as $key => $required_plugin ) {
					$markup .= '<li>' . esc_html( $required_plugin['name'] ) . '</li>';
				}
				$markup .= '</ul>';

				wp_send_json_error( $markup );
			}

			$data = array(
				'required_plugins'             => $response,
				'third_party_required_plugins' => $third_party_required_plugins,
				'update_avilable_plugins'      => $update_avilable_plugins,
			);

			if ( wp_doing_ajax() ) {
				wp_send_json_success( $data );
			} else {
				return $data;
			}
		}

		public function after_plugin_activate( $plugin_init = '', $options = array(), $enabled_extensions = array() ) {
			$data = array(
				'gyan_site_options' => $options,
				'enabled_extensions' => $enabled_extensions,
			);

			do_action( 'gyan_sites_after_plugin_activation', $plugin_init, $data );
		}

		public function get_default_page_builders() {
			return array(
				array(
					'id'   => 33,
					'slug' => 'elementor',
					'name' => 'Elementor',
				)
			);
		}

		public function get_page_builders() {
			return $this->get_default_page_builders();
		}

		public function get_page_builder_field( $page_builder = '', $field = '' ) {
			if ( empty( $page_builder ) ) { return ''; }

			$page_builders = self::get_instance()->get_page_builders();
			if ( empty( $page_builders ) ) { return ''; }

			foreach ( $page_builders as $key => $current_page_builder ) {
				if ( $page_builder === $current_page_builder['slug'] ) {
					if ( isset( $current_page_builder[ $field ] ) ) {
						return $current_page_builder[ $field ];
					}
				}
			}

			return '';
		}

		public function get_sync_complete_message( $echo = false ) {

			$message = __( 'Demo library refreshed!', 'gyan-elements' );
			if ( $echo ) {
				echo esc_html( $message );
			} else {
				return esc_html( $message );
			}
		}

		// Get an instance of WP_Filesystem_Direct.
		public static function get_filesystem() {
			global $wp_filesystem;
			require_once ABSPATH . '/wp-admin/includes/file.php';
			WP_Filesystem();
			return $wp_filesystem;
		}

		public function get_theme_name() {
			$theme = wp_get_theme();
			$theme_name = 'theme_mods_' . strtolower($theme->get( 'Name' ));
			return apply_filters( 'gyan_get_theme_name', $theme_name );
		}

	}

	Gyan_Sites::get_instance();

endif;