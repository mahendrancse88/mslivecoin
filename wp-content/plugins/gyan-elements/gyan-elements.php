<?php
/*
Plugin Name: Gyan Elements
Plugin URI: http://themeforest.net/user/Softwebmedia
Description: Create content with Elements
Version: 2.0.1
Author: SoftWebMedia
Author URI: http://themeforest.net/user/Softwebmedia
Text Domain: gyan-elements
Domain Path: /languages/
*/

if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( !class_exists( 'Gyan_Elements' ) ) {
	class Gyan_Elements {

	   public function __construct() {

	    	define( 'GYAN_ELEM_FILE', __FILE__ );
	    	define( 'GYAN_PLUGIN_BASE', plugin_basename( GYAN_ELEM_FILE ) );
			define( 'GYAN_PLUGIN_URI', plugins_url( '/', GYAN_ELEM_FILE ) );

	    	define('GYAN_PLUGIN_URL', plugin_dir_url( GYAN_ELEM_FILE ));
	    	define('GYAN_ADDONS_CSS', plugin_dir_url( GYAN_ELEM_FILE ) .'addons/css/');
	    	define('GYAN_PLUGIN_DIR', plugin_dir_path( GYAN_ELEM_FILE ));
			define('GYAN_WIDGET_DIR', plugin_dir_path( GYAN_ELEM_FILE ) .'/widgets/');
			define('GYAN_ADDONS_DIR', plugin_dir_path( GYAN_ELEM_FILE ) .'/addons/');
			define('GYAN_ADMIN_DIR', plugin_dir_path( GYAN_ELEM_FILE ) .'admin/');
			define('GYAN_CLASS_DIR', plugin_dir_path( GYAN_ELEM_FILE ) .'/classes/');
			define('GYAN_DEMOS_DIR', plugin_dir_path( GYAN_ELEM_FILE ) .'/demos/');
			define('GYAN_ELEMENTS_VERSION', '2.0.1');
			define('GYAN_PLUGIN_NAME', 'Gyan Elements');
			define('GYAN_WPML_ACTIVE', class_exists( 'SitePress' ) );
			define('GYAN_ONE_CLICK_DEMO_IMPORT', class_exists( 'OCDI_Plugin' ));

			global $gyan_addons_list;
			$gyan_addons_list =  array(
				'basic'=>array(
					'accordion'=>1,
					'animated-text'=>1,
					'button-scroll'=>1,
					'contact-form-styler'=>1,
					'content-box'=>1,
					'counter'=>1,
					'dual-color-heading'=>1,
					'google-map'=>1,
					'hot-button'=>1,
					'icon-list'=>1,
					'image-accordion'=>1,
					'image-scroll'=>1,
					'image-marquee'=>1,
					'info-box'=>1,
					'menu-list'=>1,
					'multi-buttons'=>1,
					'piechart'=>1,
					'price-list'=>1,
					'progressbar'=>1,
					'promo-box'=>1,
					'services'=>1,
					'services-full-text'=>1,
					'service-list'=>1,
					'small-info-box'=>1,
					'table'=>1,
					'tabs'=>1,
					'title'=>1,
					'video'=>1,
					'video-icon'=>1,
					'work-hours'=>1),
				'advanced'=>array(
					'content-slider'=>1,
					'content-toggle'=>1,
					'countdown'=>1,
					'filterable-gallery'=>1,
					'image-carousel'=>1,
					'image-slider'=>1,
					'mailchimp-subscribe'=>1,
					'modal-box'=>1,
					'multi-heading'=>1,
					'multi-image'=>1,
					'portfolio'=>1,
					'post-grid'=>1,
					'pricing-table'=>1,
					'testimonials'=>1,
					'tabs-slider'=>1,
					'team'=>1),
			);

			$this->includes();
	        add_action('plugins_loaded', array(&$this, 'gyan_plugins_loaded'));
	        add_action('admin_enqueue_scripts', array(&$this, 'gyan_backend_scripts_styles'));
	        add_action('wp_enqueue_scripts', array(&$this, 'gyan_load_styles') );
	        add_action('admin_enqueue_scripts', array(&$this, 'gyan_admin_scripts') );
		}

		public function gyan_backend_scripts_styles() {
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script('wp-color-picker');
		}

		public function gyan_load_styles() {
			wp_enqueue_style( 'owl-carousel', GYAN_PLUGIN_URL .'assets/css/owl.carousel.min.css', '', '2.3.4' );
			wp_enqueue_script( 'jquery-owl', GYAN_PLUGIN_URL .'assets/js/owl.carousel.min.js', ['jquery'], '2.3.4', true );

			$gyan_min_js = get_option('swm_enable_minify_gyan_elements_js',true) ? '-min.js' : '.js';
			wp_enqueue_script( 'gyan-custom-scripts', GYAN_PLUGIN_URL .'assets/js/custom-scripts' . $gyan_min_js, ['jquery'], GYAN_ELEMENTS_VERSION, true );

			//Localize scripts
			wp_localize_script( 'gyan-custom-scripts', 'gyan_get_ajax_full_url', array( 'ajaxurl' => gyan_get_ajax_url() ) );

			if ( get_option('swm_enable_theme_widgets',true) ) {
				$gyan_min_css = get_option('swm_enable_minify_gyan_elements_css',true) ? '-min.css' : '.css';
				wp_enqueue_style( 'gyan-widget-style', GYAN_PLUGIN_URL . 'widgets/custom-widgets' . $gyan_min_css, NULL, GYAN_ELEMENTS_VERSION, 'all' );
			}

			if( is_rtl() ) {
				wp_enqueue_style( 'gyan-rtl', GYAN_PLUGIN_URL .'assets/css/rtl.css', '', GYAN_ELEMENTS_VERSION );
			}

		}

		public function gyan_admin_scripts() {

			$gyan_min_css = get_option('swm_enable_minify_gyan_elements_css',true) ? '-min.css' : '.css';
			wp_enqueue_style( 'gyan-admin-styles', GYAN_PLUGIN_URL . 'admin/css/gyan-admin' . $gyan_min_css, NULL, GYAN_ELEMENTS_VERSION, 'all' );

			if (is_rtl()) {
				wp_enqueue_style( 'gyan-admin-styles-rtl', GYAN_PLUGIN_URL . 'admin/css/gyan-admin-rtl.css', NULL, GYAN_ELEMENTS_VERSION, 'all' );
			}

		}

		public function includes() {

			require_once( GYAN_PLUGIN_DIR .'/functions/custom-functions.php' );
			require_once( GYAN_PLUGIN_DIR .'/functions/post-like.php' );
			require_once( GYAN_PLUGIN_DIR .'/functions/shortcodes.php' );

			// contact form 7
			if ( defined( 'WPCF7_VERSION' ) ) {
				require_once (GYAN_CLASS_DIR . 'ContactForm7.php');
			}

			// portfolio post
			if ( get_option('swm_enable_portfolio',true) ) {
				require_once( GYAN_PLUGIN_DIR .'/post-types/portfolio.php' );
			}

			// admin
			include_once( GYAN_PLUGIN_DIR . '/admin/theme-panel.php' );
			include_once( GYAN_PLUGIN_DIR . '/admin/elementor-extensions.php' );

			if ( get_option('swm_enable_customizer_manager',true) ) {
				include_once( GYAN_PLUGIN_DIR . '/admin/customizer-manager.php' );
			}

			if ( get_option('swm_enable_header_styles',true) ) {
				include_once( GYAN_PLUGIN_DIR . '/admin/header-styles.php' );
			}

			// sidebars
			if ( get_option('swm_enable_add_new_sidebar',true) ) {
				require_once (GYAN_PLUGIN_DIR . '/sidebars/sidebars.php');
			}

			// addons
			require_once (GYAN_ADDONS_DIR . 'gyan-addons.php');

			// remove emoji scripts
			if ( get_option('swm_enable_remove_emoji_scripts',true) ) {
				remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
				remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
				remove_action( 'wp_print_styles', 'print_emoji_styles' );
				remove_action( 'admin_print_styles', 'print_emoji_styles' );
			}
		}

		// language
		public function gyan_plugins_loaded() {
			load_plugin_textdomain( 'gyan-elements', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );

			// demo templates
			if ( get_option('swm_enable_demo_templates',true) ) {
				require_once GYAN_PLUGIN_DIR . 'demos/classes/class-gyan-sites.php';
			}

		}
	}
	$gyan_custom_elements = new Gyan_Elements();
}