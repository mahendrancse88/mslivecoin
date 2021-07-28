<?php
namespace Elementor\TemplateLibrary;
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\Elementor\Plugin' ) ) { return; }  // If plugin - 'Elementor' not exist then return.

use Elementor\Core\Base\Document;
use Elementor\Core\Editor\Editor;
use Elementor\DB;
use Elementor\Core\Settings\Manager as SettingsManager;
use Elementor\Core\Settings\Page\Model;
use Elementor\Modules\Library\Documents\Library_Document;
use Elementor\Plugin;
use Elementor\Utils;

class Gyan_Sites_Batch_Processing_Elementor extends Source_Local {

	public function import() {

		if ( defined( 'WP_CLI' ) ) {
			\WP_CLI::line( 'Processing "Elementor" Batch Import' );
		}
		\Gyan_Sites_Importer_Log::add( '---- Processing WordPress Posts / Pages - for Elementor ----' );
		$post_types = \Gyan_Sites_Batch_Processing::get_post_types_supporting( 'elementor' );

		if ( defined( 'WP_CLI' ) ) {
			\WP_CLI::line( 'For post types: ' . implode( ', ', $post_types ) );
		}
		if ( empty( $post_types ) && ! is_array( $post_types ) ) { return; }

		$post_ids = \Gyan_Sites_Batch_Processing::get_pages( $post_types );
		if ( empty( $post_ids ) && ! is_array( $post_ids ) ) { return; }

		foreach ( $post_ids as $post_id ) {
			$this->import_single_post( $post_id );
		}
	}
	// Update post meta
	public function import_single_post( $post_id = 0 ) {

		$is_elementor_post = get_post_meta( $post_id, '_elementor_version', true );
		if ( ! $is_elementor_post ) { return; }

		// Is page imported with Demo Sites? If not then skip batch process.
		$imported_from_demo_site = get_post_meta( $post_id, '_gyan_sites_enable_for_batch', true );
		if ( ! $imported_from_demo_site ) { return; }

		if ( defined( 'WP_CLI' ) ) { \WP_CLI::line( 'Elementor - Processing page: ' . $post_id ); }

		\Gyan_Sites_Importer_Log::add( '---- Processing WordPress Page - for Elementor ---- "' . $post_id . '"' );

		if ( ! empty( $post_id ) ) {

			$data = get_post_meta( $post_id, '_elementor_data', true );
			\Gyan_Sites_Importer_Log::add( wp_json_encode( $data ) );

			if ( ! empty( $data ) ) {

				if ( ! is_array( $data ) ) { $data = json_decode( $data, true ); }
				\Gyan_Sites_Importer_Log::add( wp_json_encode( $data ) );

				$document = Plugin::$instance->documents->get( $post_id );
				if ( $document ) { $data = $document->get_elements_raw_data( $data, true ); }

				$data = $this->process_export_import_content( $data, 'on_import' );  // Import the data.

				// Replace the site urls.
				$demo_data = get_option( 'gyan_sites_import_data', array() );
				\Gyan_Sites_Importer_Log::add( wp_json_encode( $demo_data ) );
				if ( isset( $demo_data['gyan-site-url'] ) ) {
					$data = wp_json_encode( $data, true );
					if ( ! empty( $data ) ) {
						$site_url      = get_site_url();
						$site_url      = str_replace( '/', '\/', $site_url );
						$demo_site_url = 'https:' . $demo_data['gyan-site-url'];
						$demo_site_url = str_replace( '/', '\/', $demo_site_url );
						$data          = str_replace( $demo_site_url, $site_url, $data );
						$data          = json_decode( $data, true );
					}
				}

				update_metadata( 'post', $post_id, '_elementor_data', $data );							// Update processed meta.
				update_metadata( 'post', $post_id, '_gyan_sites_hotlink_imported', true );

				Plugin::$instance->files_manager->clear_cache();  // !important, Clear the cache after images import.
			}
		}
	}
}