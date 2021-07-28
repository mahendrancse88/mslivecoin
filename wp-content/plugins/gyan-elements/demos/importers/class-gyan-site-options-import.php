<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
class Gyan_Site_Options_Import {
	private static $instance = null;
	public static function instance() { if ( ! isset( self::$instance ) ) { self::$instance = new self(); } return self::$instance; }

	private static function site_options() {
		return array(
			'custom_logo',
			'nav_menu_locations',
			'show_on_front',
			'page_on_front',
			'page_for_posts',

			// Plugin: Elementor.
			'elementor_container_width',
			'elementor_cpt_support',
			'elementor_css_print_method',
			'elementor_default_generic_fonts',
			'elementor_disable_color_schemes',
			'elementor_disable_typography_schemes',
			'elementor_editor_break_lines',
			'elementor_exclude_user_roles',
			'elementor_global_image_lightbox',
			'elementor_page_title_selector',
			'elementor_scheme_color',
			'elementor_scheme_color-picker',
			'elementor_scheme_typography',
			'elementor_space_between_widgets',
			'elementor_stretched_section_container',
			'elementor_load_fa4_shim',
			'elementor_active_kit',
		);
	}

	// Import site options
	public function import_options( $options = array() ) {
		if ( ! isset( $options ) ) { return; }

		foreach ( $options as $option_name => $option_value ) {

			// Is option exist in defined array site_options()?
			if ( null !== $option_value ) {

				// Is option exist in defined array site_options()?
				if ( in_array( $option_name, self::site_options(), true ) ) {

					switch ( $option_name ) {

						case 'page_for_posts':
						case 'page_on_front':
								$this->update_page_id_by_option_value( $option_name, $option_value );
							break;

						case 'nav_menu_locations':
								$this->set_nav_menu_locations( $option_value );
							break;

						case 'custom_logo':
								$this->insert_logo( $option_value );
							break;

						case 'elementor_active_kit':
							if ( '' !== $option_value ) {
								$this->set_elementor_kit();
							}
							break;

						default:
							update_option( $option_name, $option_value );
							break;
					}
				}
			}
		}
	}

	// Update post option
	private function set_elementor_kit() {

		// Update Elementor Theme Kit Option.
		$args = array(
			'post_type'   => 'elementor_library',
			'post_status' => 'publish',
			'numberposts' => 1,
			'meta_query'  => array(
				array('key' => '_gyan_sites_imported_post', 'value' => '1' ),
				array('key' => '_elementor_template_type', 	'value' => 'kit' ),
			),
		);

		$query = get_posts( $args );
		if ( ! empty( $query ) && isset( $query[0] ) && isset( $query[0]->ID ) ) {
			update_option( 'elementor_active_kit', $query[0]->ID );
		}
	}

	// Update post option
	private function update_page_id_by_option_value( $option_name, $option_value ) {
		$page = get_page_by_title( $option_value );
		if ( is_object( $page ) ) {
			update_option( $option_name, $page->ID );
		}
	}

	// In WP nav menu is stored as ( 'menu_location' => 'menu_id' );
	private function set_nav_menu_locations( $nav_menu_locations = array() ) {

		$menu_locations = array();

		// Update menu locations.
		if ( isset( $nav_menu_locations ) ) {

			foreach ( $nav_menu_locations as $menu => $value ) {

				$term = get_term_by( 'slug', $value, 'nav_menu' );

				if ( is_object( $term ) ) {
					$menu_locations[ $menu ] = $term->term_id;
				}
			}

			set_theme_mod( 'nav_menu_locations', $menu_locations );
		}
	}

	// Insert Logo By URL
	private function insert_logo( $image_url = '' ) {
		$attachment_id = $this->download_image( $image_url );
		if ( $attachment_id ) {
			Gyan_WXR_Importer::instance()->track_post( $attachment_id );
			set_theme_mod( 'custom_logo', $attachment_id );
		}
	}

	// Download image by URL
	private function download_image( $image_url = '' ) {
		$data = (object) Gyan_Sites_Helper::sideload_image( $image_url );

		if ( ! is_wp_error( $data ) ) {
			if ( isset( $data->attachment_id ) && ! empty( $data->attachment_id ) ) {
				return $data->attachment_id;
			}
		}

		return false;
	}

}