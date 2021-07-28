<?php
namespace BizixTheme;
defined( 'ABSPATH' ) || exit;
final class Polylang {

	private static $instance;
	private function __construct() {}  // Private to disabled instantiation.
	final public function __clone()  { throw new Exception( 'You\'re doing things wrong.' ); }  // Disable the cloning of this class.
	final public function __wakeup() { throw new Exception( 'You\'re doing things wrong.' ); }  // Disable the wakeup of this class.

	// Create or retrieve the instance of Polylang.
	public static function instance() {
		if ( is_null( static::$instance ) ) {
			static::$instance = new Polylang;
			static::$instance->init_hooks();
		}
		return static::$instance;
	}

	// Hook into actions and filters.
	public function init_hooks() {
		add_action( 'init', array( $this, 'register_strings' ) );
		add_filter( 'nav_menu_css_class', array( $this, 'edit_menu_classes' ), 9, 2 );
	}

	function edit_menu_classes( $classes, $item ) {
		if ( ( $key = array_search( 'current-menu-parent', $classes ) ) !== false && ( array_search( 'pll-parent-menu-item', $classes ) ) !== false ) {
			unset( $classes[$key] );
		}
		return $classes;
	}

	// Registers theme_mod strings into Polylang
	public function register_strings() {
		if ( function_exists( 'pll_register_string' ) ) {
			$strings = swm_register_theme_mod_strings();
			if ( $strings ) {
				foreach( $strings as $string => $default ) {
					pll_register_string( $string, swm_get_option( $string, $default ), 'Theme Settings', true );
				}
			}
		}
	}

}
Polylang::instance();