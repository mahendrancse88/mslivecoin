<?php
if ( ! class_exists( 'Gyan_Sites_Batch_Processing_Misc' ) ) :
	class Gyan_Sites_Batch_Processing_Misc {
		private static $instance;
		public static function get_instance() { if ( ! isset( self::$instance ) ) {self::$instance = new self(); } return self::$instance; }
		public function __construct() {}

		public function import() {
			if ( defined( 'WP_CLI' ) ) {
				WP_CLI::line( 'Processing "MISC" Batch Import' );
			}
			Gyan_Sites_Importer_Log::add( '---- Processing MISC ----' );
			self::fix_nav_menus();
		}

		// Import Module Images
		public static function fix_nav_menus() {
			if ( defined( 'WP_CLI' ) ) { WP_CLI::line( 'Setting Nav Menus' ); }

			// Not found site data, then return.
			$demo_data = get_option( 'gyan_sites_import_data', array() );
			if ( ! isset( $demo_data['gyan-post-data-mapping'] ) ) {
				return;
			}

			$xml_url = ( isset( $demo_data['gyan-site-wxr-path'] ) ) ? esc_url( $demo_data['gyan-site-wxr-path'] ) : '';
			if ( empty( $xml_url ) ) { return; }  // Not found/empty XML URL, then return.

			$site_url = strpos( $xml_url, '/wp-content' );
			if ( false === $site_url ) { return; }  // Not empty site URL, then return.

			$site_url = substr( $xml_url, 0, $site_url ); // Get remote site URL.

			$post_ids = self::get_menu_post_ids();
			if ( is_array( $post_ids ) ) {
				foreach ( $post_ids as $post_id ) {
					if ( defined( 'WP_CLI' ) ) {
						WP_CLI::line( 'Post ID: ' . $post_id );
					}
					Gyan_Sites_Importer_Log::add( 'Post ID: ' . $post_id );
					$menu_url = get_post_meta( $post_id, '_menu_item_url', true );

					if ( $menu_url ) {
						$menu_url = str_replace( $site_url, site_url(), $menu_url );
						update_post_meta( $post_id, '_menu_item_url', $menu_url );
					}
				}
			}
		}

		// Get all post id's
		public static function get_menu_post_ids() {
			$args = array(
				'post_type'     => 'nav_menu_item',

				// Query performance optimization.
				'fields'        => 'ids',
				'no_found_rows' => true,
				'post_status'   => 'any',
			);

			$query = new WP_Query( $args );
			if ( $query->have_posts() ) :
				return $query->posts;
			endif;
			return null;
		}

	}

	Gyan_Sites_Batch_Processing_Misc::get_instance();
endif;