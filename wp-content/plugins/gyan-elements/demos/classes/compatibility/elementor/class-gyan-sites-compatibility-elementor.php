<?php
namespace GyanSites\Elementor;
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Gyan_Sites_Compatibility_Elementor' ) ) :
	class Gyan_Sites_Compatibility_Elementor {
		private static $instance;
		public static function get_instance() { if ( ! isset( self::$instance ) ) { self::$instance = new self(); } return self::$instance; }

		public function __construct() {
			/**
			 * Add Slashes
			 *
			 * @todo    Elementor already have below code which works on defining the constant `WP_LOAD_IMPORTERS`.
			 *          After defining the constant `WP_LOAD_IMPORTERS` in WP CLI it was not works.
			 *          Try to remove below duplicate code in future.
			 */
			if ( ! wp_doing_ajax() || ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '3.0.0', '>=' ) ) ) {
				remove_filter( 'wp_import_post_meta', array( 'Elementor\Compatibility', 'on_wp_import_post_meta' ) );
				remove_filter( 'wxr_importer.pre_process.post_meta', array( 'Elementor\Compatibility', 'on_wxr_importer_pre_process_post_meta' ) );

				add_filter( 'wp_import_post_meta', array( $this, 'on_wp_import_post_meta' ) );
				add_filter( 'wxr_importer.pre_process.post_meta', array( __CLASS__, 'on_wxr_importer_pre_process_post_meta' ) );
			}

			add_action( 'gyan_sites_before_delete_imported_posts', array( $this, 'force_delete_kit' ), 10, 2 );
		}

		// Force Delete Elementor Kit, Delete the previously imported Elementor kit
		public function force_delete_kit( $post_id = 0, $post_type = '' ) {
			if ( ! $post_id ) { return; }
			if ( 'elementor_library' === $post_type ) {
				$_GET['force_delete_kit'] = true;
			}
		}

		// Process post meta before WP importer.
		// Normalize Elementor post meta on import, We need the `wp_slash` in order to avoid the unslashing during the `add_post_meta`.
		// Fired by `wp_import_post_meta` filter.
		public function on_wp_import_post_meta( $post_meta ) {
			foreach ( $post_meta as &$meta ) {
				if ( '_elementor_data' === $meta['key'] ) {
					$meta['value'] = wp_slash( $meta['value'] );
					break;
				}
			}
			return $post_meta;
		}

		// Process post meta before WXR importer.
		// Normalize Elementor post meta on import with the new WP_importer, We need the `wp_slash` in order to avoid the unslashing during the `add_post_meta`.
		// Fired by `wxr_importer.pre_process.post_meta` filter.
		public function on_wxr_importer_pre_process_post_meta( $post_meta ) {
			if ( '_elementor_data' === $post_meta['key'] ) {
				$post_meta['value'] = wp_slash( $post_meta['value'] );
			}
			return $post_meta;
		}
	}

	Gyan_Sites_Compatibility_Elementor::get_instance();
endif;