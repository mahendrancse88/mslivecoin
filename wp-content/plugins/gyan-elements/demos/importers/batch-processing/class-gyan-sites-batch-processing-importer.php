<?php
if ( ! class_exists( 'Gyan_Sites_Batch_Processing_Importer' ) ) :
	class Gyan_Sites_Batch_Processing_Importer {
		private static $instance;
		public static function get_instance() { if ( ! isset( self::$instance ) ) { self::$instance = new self(); } return self::$instance; }
		public function __construct() {}

		public function import_categories() {
			gyan_sites_error_log( 'Requesting Tags' );
			update_site_option( 'gyan-sites-batch-status-string', 'Requesting Tags', 'no' );

			$api_args     = array(
				'timeout' => 30,
			);
			$tags_request = wp_remote_get( trailingslashit( Gyan_Sites::get_instance()->get_api_domain() ) . 'wp-json/wp/v2/gyan-sites-tag/?_fields=id,name,slug', $api_args );
			if ( ! is_wp_error( $tags_request ) && 200 === (int) wp_remote_retrieve_response_code( $tags_request ) ) {
				$tags = json_decode( wp_remote_retrieve_body( $tags_request ), true );

				if ( isset( $tags['code'] ) ) {
					$message = isset( $tags['message'] ) ? $tags['message'] : '';
					if ( ! empty( $message ) ) {
						gyan_sites_error_log( 'HTTP Request Error: ' . $message );
					} else {
						gyan_sites_error_log( 'HTTP Request Error!' );
					}
				} else {
					update_site_option( 'gyan-sites-tags', $tags, 'no' );
				}
			}

			gyan_sites_error_log( 'Tags Imported Successfully!' );
			update_site_option( 'gyan-sites-batch-status-string', 'Tags Imported Successfully!', 'no' );
		}

		public function import_site_categories() {
			gyan_sites_error_log( 'Requesting Site Categories' );
			update_site_option( 'gyan-sites-batch-status-string', 'Requesting Site Categories', 'no' );

			$api_args           = array(
				'timeout' => 30,
			);
			$categories_request = wp_remote_get( trailingslashit( Gyan_Sites::get_instance()->get_api_domain() ) . 'wp-json/wp/v2/gyan-site-category/?_fields=id,name,slug&per_page=100', $api_args );
			if ( ! is_wp_error( $categories_request ) && 200 === (int) wp_remote_retrieve_response_code( $categories_request ) ) {
				$categories = json_decode( wp_remote_retrieve_body( $categories_request ), true );

				if ( isset( $categories['code'] ) ) {
					$message = isset( $categories['message'] ) ? $categories['message'] : '';
					if ( ! empty( $message ) ) {
						gyan_sites_error_log( 'HTTP Request Error: ' . $message );
					} else {
						gyan_sites_error_log( 'HTTP Request Error!' );
					}
				} else {
					update_site_option( 'gyan-sites-categories', $categories, 'no' );
				}
			}

			gyan_sites_error_log( 'Site Categories Imported Successfully!' );
			update_site_option( 'gyan-sites-batch-status-string', 'Site Categories Imported Successfully!', 'no' );
		}

		public function import_block_categories() {
			gyan_sites_error_log( 'Requesting Block Categories' );
			update_site_option( 'gyan-sites-batch-status-string', 'Requesting Block Categories', 'no' );

			$api_args     = array(
				'timeout' => 30,
			);
			$tags_request = wp_remote_get( trailingslashit( Gyan_Sites::get_instance()->get_api_domain() ) . 'wp-json/wp/v2/blocks-category/?_fields=id,name,slug&per_page=100&hide_empty=1', $api_args );
			if ( ! is_wp_error( $tags_request ) && 200 === (int) wp_remote_retrieve_response_code( $tags_request ) ) {
				$tags = json_decode( wp_remote_retrieve_body( $tags_request ), true );

				if ( isset( $tags['code'] ) ) {
					$message = isset( $tags['message'] ) ? $tags['message'] : '';
					if ( ! empty( $message ) ) {
						gyan_sites_error_log( 'HTTP Request Error: ' . $message );
					} else {
						gyan_sites_error_log( 'HTTP Request Error!' );
					}
				} else {
					$categories = array();
					foreach ( $tags as $key => $value ) {
						$categories[ $value['id'] ] = $value;
					}

					update_site_option( 'gyan-blocks-categories', $categories, 'no' );
				}
			}

			gyan_sites_error_log( 'Block Categories Imported Successfully!' );
			update_site_option( 'gyan-sites-batch-status-string', 'Categories Imported Successfully!', 'no' );
		}

		public function import_page_builders() {
			gyan_sites_error_log( 'Requesting Page Builders' );
			update_site_option( 'gyan-sites-batch-status-string', 'Requesting Page Builders', 'no' );

			$site_url = get_site_url();
			$api_args = array('timeout' => 30 );

			$page_builder_request = wp_remote_get( trailingslashit( Gyan_Sites::get_instance()->get_api_domain() ) . 'wp-json/wp/v2/gyan-site-page-builder/?_fields=id,name,slug&site_url=' . $site_url , $api_args );
			if ( ! is_wp_error( $page_builder_request ) && 200 === (int) wp_remote_retrieve_response_code( $page_builder_request ) ) {
				$page_builders = json_decode( wp_remote_retrieve_body( $page_builder_request ), true );

				if ( isset( $page_builders['code'] ) ) {
					$message = isset( $page_builders['message'] ) ? $page_builders['message'] : '';
					if ( ! empty( $message ) ) {
						gyan_sites_error_log( 'HTTP Request Error: ' . $message );
					} else {
						gyan_sites_error_log( 'HTTP Request Error!' );
					}
				} else {
					update_site_option( 'gyan-sites-page-builders', $page_builders, 'no' );
				}
			}

			gyan_sites_error_log( 'Page Builders Imported Successfully!' );
			update_site_option( 'gyan-sites-batch-status-string', 'Page Builders Imported Successfully!', 'no' );
		}

		public function import_blocks( $page = 1 ) {
			gyan_sites_error_log( 'BLOCK: -------- ACTUAL IMPORT --------' );
			$api_args   = array('timeout' => 30 );
			$all_blocks = array();
			gyan_sites_error_log( 'BLOCK: Requesting ' . $page );
			update_site_option( 'gyan-blocks-batch-status-string', 'Requesting for blocks page - ' . $page, 'no' );

			$query_args = apply_filters(
				'gyan_sites_blocks_query_args',
				array(
					'page_builder' => 'elementor',
					'per_page'     => 100,
					'page'         => $page,
				)
			);

			$api_url = add_query_arg( $query_args, trailingslashit( Gyan_Sites::get_instance()->get_api_domain() ) . 'wp-json/gyan-blocks/v1/blocks/' );
			$response = wp_remote_get( $api_url, $api_args );

			if ( ! is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) === 200 ) {
				$gyan_blocks = json_decode( wp_remote_retrieve_body( $response ), true );

				if ( isset( $gyan_blocks['code'] ) ) {
					$message = isset( $gyan_blocks['message'] ) ? $gyan_blocks['message'] : '';
					if ( ! empty( $message ) ) {
						gyan_sites_error_log( 'HTTP Request Error: ' . $message );
					} else {
						gyan_sites_error_log( 'HTTP Request Error!' );
					}
				} else {
					gyan_sites_error_log( 'BLOCK: Storing data for page ' . $page . ' in option gyan-blocks-' . $page );
					update_site_option( 'gyan-blocks-batch-status-string', 'Storing data for page ' . $page . ' in option gyan-blocks-' . $page, 'no' );

					update_site_option( 'gyan-blocks-' . $page, $gyan_blocks, 'no' );
				}
			} else {
				gyan_sites_error_log( 'BLOCK: API Error: ' . $response->get_error_message() );
			}

			gyan_sites_error_log( 'BLOCK: Complete storing data for blocks ' . $page );
			update_site_option( 'gyan-blocks-batch-status-string', 'Complete storing data for page ' . $page, 'no' );
		}

		public function import_sites( $page = 1 ) {
			$api_args        = array(
				'timeout' => 30,
			);
			$sites_and_pages = array();
			gyan_sites_error_log( 'Requesting ' . $page );
			update_site_option( 'gyan-sites-batch-status-string', 'Requesting ' . $page, 'no' );

			$query_args = apply_filters(
				'gyan_sites_import_sites_query_args',
				array(
					'per_page' => 15,
					'page'     => $page,
				)
			);

			$api_url = add_query_arg( $query_args, trailingslashit( Gyan_Sites::get_instance()->get_api_domain() ) . 'wp-json/gyan-sites/v1/sites-and-pages/' );

			$response = wp_remote_get( $api_url, $api_args );
			if ( ! is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) === 200 ) {
				$sites_and_pages = json_decode( wp_remote_retrieve_body( $response ), true );

				if ( isset( $sites_and_pages['code'] ) ) {
					$message = isset( $sites_and_pages['message'] ) ? $sites_and_pages['message'] : '';
					if ( ! empty( $message ) ) {
						gyan_sites_error_log( 'HTTP Request Error: ' . $message );
					} else {
						gyan_sites_error_log( 'HTTP Request Error!' );
					}
				} else {
					gyan_sites_error_log( 'Storing data for page ' . $page . ' in option gyan-sites-and-pages-page-' . $page );
					update_site_option( 'gyan-sites-batch-status-string', 'Storing data for page ' . $page . ' in option gyan-sites-and-pages-page-' . $page, 'no' );

					update_site_option( 'gyan-sites-and-pages-page-' . $page, $sites_and_pages, 'no' );
				}
			} else {
				gyan_sites_error_log( 'API Error: ' . $response->get_error_message() );
			}

			gyan_sites_error_log( 'Complete storing data for page ' . $page );
			update_site_option( 'gyan-sites-batch-status-string', 'Complete storing data for page ' . $page, 'no' );

			return $sites_and_pages;
		}
	}

	Gyan_Sites_Batch_Processing_Importer::get_instance();

endif;