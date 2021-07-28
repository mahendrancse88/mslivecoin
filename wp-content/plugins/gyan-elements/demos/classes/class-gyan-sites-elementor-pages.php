<?php
namespace Elementor\TemplateLibrary;

if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\Elementor\Plugin' ) ) { return; }  // If plugin - 'Elementor' not exist then return.

use Elementor\Core\Base\Document;
use Elementor\DB;
use Elementor\Core\Settings\Page\Manager as PageSettingsManager;
use Elementor\Core\Settings\Manager as SettingsManager;
use Elementor\Core\Settings\Page\Model;
use Elementor\Editor;
use Elementor\Plugin;
use Elementor\Settings;
use Elementor\Utils;

class Gyan_Sites_Elementor_Pages extends Source_Local {

	// Update post meta
	public function import( $post_id = 0, $data = array() ) {
		if ( ! empty( $post_id ) && ! empty( $data ) ) {

			$data = wp_json_encode( $data, true );

			$data = json_decode( $data, true );
			$data = $this->process_export_import_content( $data, 'on_import' );  // Import the data.

			// Replace the site urls.
			$demo_data = get_option( 'gyan_sites_import_data', array() );
			if ( isset( $demo_data['gyan-site-url'] ) ) {
				$site_url      = get_site_url();
				$site_url      = str_replace( '/', '\/', $site_url );
				$demo_site_url = 'https:' . $demo_data['gyan-site-url'];
				$demo_site_url = str_replace( '/', '\/', $demo_site_url );
				$data          = str_replace( $demo_site_url, $site_url, $data );
			}

			// Replace the site urls.
			$demo_data = get_option( 'gyan_sites_import_data', array() );
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

			update_metadata( 'post', $post_id, '_elementor_data', $data );  // Update processed meta.
			Plugin::$instance->posts_css_manager->clear_cache();  // !important, Clear the cache after images import.

			return $data;
		}

		return array();
	}
}