<?php
namespace BizixTheme;
defined( 'ABSPATH' ) || exit;
final class WPML {

	private static $instance;
	private function __construct() { } // Private to disabled instantiation.

	private static $instance;
	private function __construct() {}  // Private to disabled instantiation.
	final public function __clone()  { throw new Exception( 'You\'re doing things wrong.' ); }  // Disable the cloning of this class.
	final public function __wakeup() { throw new Exception( 'You\'re doing things wrong.' ); }  // Disable the wakeup of this class.

	// Create or retrieve the instance of WPML.
	public static function instance() {
		if ( is_null( static::$instance ) ) {
			static::$instance = new WPML;
			static::$instance->init_hooks();
		}
		return static::$instance;
	}

	// Hook into actions and filters.
	public function init_hooks() {
		add_filter( 'upload_dir', array( $this, 'upload_dir' ) );
		if ( swm_is_request( 'admin' ) )    { add_action( 'admin_init', array( $this, 'register_strings' ) ); }
		if ( swm_is_request( 'frontend' ) ) { add_filter( 'body_class', array( $this, 'body_class' ) ); }
	}

	// Registers theme_mod strings into WPML.
	public function register_strings() {
		if ( function_exists( 'icl_register_string' ) && $strings = swm_register_theme_mod_strings() ) {
			foreach( $strings as $string => $default ) {
				icl_register_string( 'Theme Settings', $string, get_theme_mod( $string, $default ) );
			}
		}
	}

	// Registers theme_mod strings into WPML
	public function body_class( $classes ) {
		if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
			$classes[] = 'wpml-language-' . sanitize_html_class( ICL_LANGUAGE_CODE );
		}
		return $classes;
	}

	// Fix for when users have the Language URL Option on "different domains" which causes cropped images to fail.
	public function upload_dir( $upload ) {

		// Check if WPML language_negociation type
		$language_negociation = apply_filters( 'wpml_setting', false, 'language_negotiation_type' );
		if ( $language_negociation !== false && $language_negociation == 2 ) {
			$upload['baseurl'] = apply_filters( 'wpml_permalink', $upload['baseurl'] );
		}
		return $upload;  // Return $upload var
	}

}
WPML::instance();