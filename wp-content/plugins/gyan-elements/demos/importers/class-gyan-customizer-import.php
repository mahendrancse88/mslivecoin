<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
class Gyan_Customizer_Import {
	private static $instance = null;
	public static function instance() { if ( ! isset( self::$instance ) ) {self::$instance = new self(); } return self::$instance; }

	// Import customizer options
	public function import( $options ) {
		if ( isset( $options['gyan-settings'] ) ) { self::import_settings( $options['gyan-settings'] ); } 	// customizer settings
		if ( isset( $options['custom-css'] ) ) { wp_update_custom_css_post( $options['custom-css'] ); } 	// Additional CSS saves in wp_posts database table
	}

	// Import Theme Setting's
	public static function import_settings( $options = array() ) {

		$themename = Gyan_Sites::get_instance()->get_theme_name();

		array_walk_recursive($options, function ( &$value ) {
				if ( ! is_array( $value ) ) {

					if ( Gyan_Sites_Helper::is_image_url( $value ) ) {
						$data = Gyan_Sites_Helper::sideload_image( $value );

						if ( ! is_wp_error( $data ) ) {
							$value = $data->url;
						}
					}
				}

			}
		);
		update_option( $themename, $options );  // Updated settings.
	}
}