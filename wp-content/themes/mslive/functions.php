<?php
define('SWM_FUNCTIONS', get_template_directory() . '/functions/');
define('SWM_ADMIN', get_template_directory() . '/admin/');
define('SWM_PLUGINS', get_template_directory() . '/plugins/');
define('SWM_CUSTOMIZER', get_template_directory() . '/customizer/');
define('SWM_THEME_DIR', get_template_directory_uri());
define('SWM_TEMPLATE_DIR', get_template_directory());

define('SWM_THEME_CSS', SWM_THEME_DIR . '/css');
define('SWM_THEME_NAME', 'bizix');
define('SWM_THEME_VERSION', '2.0.2');
define('SWM_THEME_BRANDING', 'Bizix');

define('GYAN_ELEMENTS_IS_ACTIVE', class_exists( 'Gyan_Elements' ));
define('SWM_WOOCOMMERCE_IS_ACTIVE', class_exists( 'WooCommerce' ));
define( 'SWM_WPML_ACTIVE', class_exists( 'SitePress' ) );

// DEMO START
if ( !get_option('swm_enable_demo_templates',true) ) {
	define('SWM_ONE_CLICK_DEMO_IMPORT', class_exists( 'OCDI_Plugin' ));
	if ( SWM_ONE_CLICK_DEMO_IMPORT ) {
		require_once (SWM_TEMPLATE_DIR . '/plugins/one-click-demo-import/swm-one-click-demo-import.php');
	}
}
// DEMO END

remove_action( 'wp_head', 'rest_output_link_header', 10);
remove_action( 'template_redirect', 'rest_output_link_header', 11);

include_once (SWM_FUNCTIONS . 'translations.php');
require get_template_directory() . '/functions/megamenu/megamenu.class.php';
require get_template_directory() . '/functions/megamenu/megamenu-walker.class.php';

if ( ! function_exists( 'swm_theme_custom_setup' ) ) {

	add_action( 'after_setup_theme', 'swm_theme_custom_setup' );
	function swm_theme_custom_setup(){

		do_action('swm_theme_custom_setup');
		add_theme_support( 'title-tag' );

        add_action( 'wp_enqueue_scripts', 'swm_load_scripts' );
        add_action( 'wp_enqueue_scripts', 'swm_load_styles' );

		add_action( 'wp_ajax_nopriv_swm_ajax_entries', 'swm_ajax_entries');
		add_action( 'wp_ajax_swm_ajax_entries', 'swm_ajax_entries');

		add_filter( 'use_default_gallery_style', '__return_false' );

		load_theme_textdomain( 'bizix',get_template_directory().'/languages/' );

		add_action( 'wp_print_styles', 'swm_dequeue_styles', 100 );
	}

}

if ( ! function_exists( 'swm_theme_includes' ) ) {

	add_action('swm_theme_custom_setup', 'swm_theme_includes', 2);

    function swm_theme_includes(){
		include_once (SWM_FUNCTIONS . 'arrays.php');
		include_once (SWM_FUNCTIONS . 'register-menus.php');
    	include_once (SWM_CUSTOMIZER . 'customizer.php');
		include_once (SWM_FUNCTIONS . 'image-sizes.php');
		include_once (SWM_FUNCTIONS . 'breadcrumbs.php');
		include_once (SWM_CUSTOMIZER . 'output-css.php');

		/* ---> Theme's custom function files <------------------------ */

		require_once (SWM_FUNCTIONS . 'theme-functions.php');
		require_once (SWM_FUNCTIONS . 'theme-filters.php');

		/* ----------------------------------------------------- */

		include_once (SWM_PLUGINS . 'tgm-plugin-activation/custom-plugin-activation.php');
		include_once (SWM_FUNCTIONS . 'register-widgets.php');
		include_once (SWM_FUNCTIONS . 'admin-functions.php');

		$megamenu = new Swm_Mega_Menu();

		if (function_exists('rwmb_meta')) {
			include_once (SWM_PLUGINS . 'meta-box-options.php');
		}

		// Slider revolution
		if ( class_exists( 'RevSlider' ) ) {
			include_once (SWM_PLUGINS . 'class-slider-revolution.php');
		}

		// Polylang support
		if ( class_exists( 'Polylang' ) && apply_filters( 'wpex_polylang_support', true ) ) {
			require_once SWM_PLUGINS . 'class-polylang.php';
		}

    }
}

if ( ! function_exists( 'swm_load_styles' ) ) {
    function swm_load_styles(){

			if ( swm_get_option( 'swm_google_fonts_on', 'on' ) == 'on' ) {

			    $swm_final_google_body_font     		= swm_google_fonts_query( swm_get_option( 'swm_body_font_family', 'Roboto' ) );
			    $swm_final_google_body_font_weight	= swm_google_fonts_final_weight( swm_get_option( 'swm_body_font_weight', '400' ) );

			    $swm_final_google_header_title_font	= swm_google_fonts_query( swm_get_option( 'swm_header_title_font_family', 'Fira Sans' ) );
			    $swm_header_title_fonts_with_style	= swm_get_option( 'swm_header_title_font_weight', '700' );

			    $swm_final_google_widget_title_font	= swm_google_fonts_query( swm_get_option( 'swm_widget_title_font_family', 'Fira Sans' ) );
			    $swm_widget_title_fonts_with_style	= swm_get_option( 'swm_widget_title_font_weight', '700' );

			    $swm_final_google_headings_font		= swm_google_fonts_query( swm_get_option( 'swm_headings_font_family', 'Fira Sans' ) );
			    $swm_headings_fonts_with_style		= swm_get_option( 'swm_headings_font_weight', '700' );

			    $swm_final_google_nav_font			= swm_google_fonts_query( swm_get_option( 'swm_nav_font_family', 'Roboto' ) );
			    $swm_nav_fonts_with_style			= swm_get_option( 'swm_nav_font_weight', '600' );

			    $swm_google_font_subsets            	= 'latin,latin-ext';

			    if ( swm_get_option( 'swm_google_fonts_subset_on', 'off' ) == 'on' ) {
					if ( swm_get_option( 'swm_google_font_subset_cyrillic', 'off' ) == 'on' ) { $swm_google_font_subsets .= ',cyrillic,cyrillic-ext'; }
					if ( swm_get_option( 'swm_google_font_subset_greek', 'off' ) == 'on' ) { $swm_google_font_subsets .= ',greek,greek-ext'; }
					if ( swm_get_option( 'swm_google_font_subset_vietnamese', 'off' ) == 'on' ) { $swm_google_font_subsets .= ',vietnamese'; }
			    }

			    $swm_custom_font_args = array(
			      'family' =>  $swm_final_google_body_font . ':' . $swm_final_google_body_font_weight . ',' . $swm_final_google_body_font_weight . swm_get_body_font_all_weight() . '|' . $swm_final_google_nav_font . ':' . $swm_nav_fonts_with_style . '|' . $swm_final_google_header_title_font . ':' . $swm_header_title_fonts_with_style . '|' . $swm_final_google_headings_font . ':' . $swm_headings_fonts_with_style . '|' . $swm_final_google_widget_title_font . ':' . $swm_widget_title_fonts_with_style.'&display=swap',
			      'subset' => $swm_google_font_subsets
			    );

			    $swm_get_custom_font_family   = add_query_arg( $swm_custom_font_args,   '//fonts.googleapis.com/css' );



		    }
		    // Google Fonts End

		    wp_enqueue_style( 'font-awesome-free', get_template_directory_uri() . '/webfonts/font-awesome.min.css', '', SWM_THEME_VERSION );

		    if ( !get_option('swm_enable_minify_theme_css',true) ) {
		    	wp_register_style( 'flexslider', SWM_THEME_CSS . '/flexslider.css', '', SWM_THEME_VERSION );
		    	wp_enqueue_style( 'swm-global-style', SWM_THEME_CSS . '/global.css', '', SWM_THEME_VERSION );
		    	wp_enqueue_style( 'swm-header-style', SWM_THEME_CSS . '/header.css', '', SWM_THEME_VERSION );
		    	wp_enqueue_style( 'swm-layout-style', SWM_THEME_CSS . '/layout.css', '', SWM_THEME_VERSION );
		    } else {
		    	wp_enqueue_style( 'swm-theme-style-minify', SWM_THEME_CSS . '/global-header-layout-min.css', '', SWM_THEME_VERSION );
		    	wp_register_style( 'flexslider', SWM_THEME_CSS . '/flexslider-min.css', '', SWM_THEME_VERSION );
			}

			wp_enqueue_style( 'swm-google-fonts', $swm_get_custom_font_family, NULL, SWM_THEME_VERSION, 'all' );

    }
}

function swm_dequeue_styles() {
	if ( did_action( 'elementor/loaded' ) ) {
		wp_dequeue_style('elementor-icons-fa-shared-0');
		wp_dequeue_style('elementor-icons-fa-solid');
		wp_dequeue_style('elementor-icons-fa-regular');
		wp_dequeue_style('elementor-icons-fa-brands');
	}
}

// Remove Elementor plugin fontawesome icons
add_action('elementor/frontend/after_register_styles',function() {
	wp_dequeue_style('elementor-icons-fa-shared-0');
	wp_dequeue_style('elementor-icons-fa-solid');
	wp_dequeue_style('elementor-icons-fa-regular');
	wp_dequeue_style('elementor-icons-fa-brands');
}, 20 );

if ( ! function_exists( 'swm_load_scripts' ) ) {
    function swm_load_scripts(){
    	if (!is_admin()) {

			wp_enqueue_script( 'swm-easing', SWM_THEME_DIR . '/js/easing.min.js', array( 'jquery','jquery-effects-core','jquery-effects-blind' ),SWM_THEME_VERSION, TRUE );
			wp_enqueue_script( 'swm-debouncedresize', SWM_THEME_DIR . '/js/debouncedresize.min.js', array( 'jquery','jquery-effects-core','jquery-effects-blind' ),SWM_THEME_VERSION, TRUE );
			wp_enqueue_script( 'fitVids', SWM_THEME_DIR . '/js/fitvids.min.js', array( 'jquery','jquery-effects-core','jquery-effects-blind' ),SWM_THEME_VERSION, TRUE );
			wp_register_script( 'flexslider', SWM_THEME_DIR . '/js/flexslider.min.js', array( 'jquery','jquery-effects-core','jquery-effects-blind' ),SWM_THEME_VERSION, TRUE );
			wp_enqueue_script( 'swm-cookie', SWM_THEME_DIR . '/js/cookie.min.js', array( 'jquery','jquery-effects-core','jquery-effects-blind' ),SWM_THEME_VERSION, TRUE );
			wp_enqueue_script( 'coffeescript', SWM_THEME_DIR . '/js/coffeescript.min.js', array( 'jquery','jquery-effects-core','jquery-effects-blind' ),SWM_THEME_VERSION, TRUE );
			wp_enqueue_script( 'isotope', SWM_THEME_DIR . '/js/isotope.min.js', array( 'jquery','jquery-effects-core','jquery-effects-blind' ),SWM_THEME_VERSION, TRUE );
			wp_enqueue_script( 'magnific-popup', SWM_THEME_DIR .'/js/jquery.magnific-popup.min.js', array('jquery') );

			if ( get_option('swm_enable_minify_theme_js',true) ) {
				wp_enqueue_script( 'swm-theme-settings', SWM_THEME_DIR . '/js/theme-settings-min.js', array( 'jquery','jquery-effects-core','jquery-effects-blind' ),SWM_THEME_VERSION, TRUE );
				wp_enqueue_script( 'swm-megamenu', SWM_THEME_DIR . '/js/theme-megamenu-min.js', array( 'jquery' ),SWM_THEME_VERSION, TRUE );
			} else {
				wp_enqueue_script( 'swm-theme-settings', SWM_THEME_DIR . '/js/theme-settings.js', array( 'jquery','jquery-effects-core','jquery-effects-blind' ),SWM_THEME_VERSION, TRUE );
				wp_enqueue_script( 'swm-megamenu', SWM_THEME_DIR . '/js/theme-megamenu.js', array( 'jquery' ),SWM_THEME_VERSION, TRUE );
			}

			if ( swm_get_option('swm_sticky_sidebar_on','on') == 'on') {
				wp_enqueue_script( 'theia-sticky-sidebar', SWM_THEME_DIR . '/js/theia-sticky-sidebar.min.js', array( 'jquery' ),SWM_THEME_VERSION, TRUE );
			}

			wp_enqueue_script( 'imagesloaded' );

		}
    }
}

/* **************************************************************************************
	Register Javascripts and CSS Files for Admin
************************************************************************************** */

if (!function_exists('swm_admin_scripts')) {
  function swm_admin_scripts() {

  	if ( get_option('swm_enable_minify_theme_js',true) ) {
    	wp_enqueue_script('swm-admin-settings', get_template_directory_uri() . '/js/theme-admin-settings-min.js', array('jquery','jquery-ui-slider','jquery-ui-sortable'));
    } else {
    	wp_enqueue_script('swm-admin-settings', get_template_directory_uri() . '/js/theme-admin-settings.js', array('jquery','jquery-ui-slider','jquery-ui-sortable'));
    }

    wp_enqueue_style('nav-menu');

    if ( !get_option('swm_enable_minify_theme_css',true) ) {
    	wp_enqueue_style( 'swm-admin-global', SWM_THEME_CSS . '/admin-global.css', '', SWM_THEME_VERSION );
	} else {
		wp_enqueue_style( 'swm-admin-global', SWM_THEME_CSS . '/admin-global-min.css', '', SWM_THEME_VERSION );
	}

  }
}

add_action('admin_enqueue_scripts', 'swm_admin_scripts',1000);

/* **************************************************************************************
	Remove current_page_parent nav class from blog index when in Custom Post Types
************************************************************************************** */

add_filter( 'nav_menu_css_class', 'swm_remove_cpt_blog_class', 10, 3 );

function swm_remove_cpt_blog_class( $classes, $item, $args ) {
    if( !is_singular( 'post' ) AND !is_category() AND !is_tag() AND !is_date() ):
        $blog_page_id = intval( get_option( 'page_for_posts' ) );
        if( $blog_page_id != 0 AND $item->object_id == $blog_page_id )
            unset( $classes[ array_search( 'current_page_parent', $classes ) ] );
    endif;
    return $classes;
}