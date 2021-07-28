<?php
if ( ! class_exists( 'Gyan_Sites_Compatibility' ) ) :
	class Gyan_Sites_Compatibility {
		private static $instance;
		public static function instance() { if ( ! isset( self::$instance ) ) { self::$instance = new self(); } return self::$instance; }

		public function __construct() {
			require_once GYAN_PLUGIN_DIR . 'demos/classes/compatibility/elementor/class-gyan-sites-compatibility-elementor.php';
		}
	}
	Gyan_Sites_Compatibility::instance();
endif;