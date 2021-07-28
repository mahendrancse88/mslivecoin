<?php

/* **************************************************************************************
	Remove Default Sections
************************************************************************************** */

function swm_remove_customizer_sections( $wp_customize ) {
  $wp_customize->remove_section( 'colors' );
  $wp_customize->remove_section( 'background_image' );
}

add_action( 'customize_register', 'swm_remove_customizer_sections' );

/* **************************************************************************************
	Include Customizer Custom options, settings etc. files
************************************************************************************** */

require_once( SWM_CUSTOMIZER . 'controls.php' );
require_once( SWM_CUSTOMIZER . 'fonts.php' );
require_once( SWM_CUSTOMIZER . 'theme-options.php' );
require_once( SWM_CUSTOMIZER . 'output-css.php' );
require_once( SWM_CUSTOMIZER . 'translations.php' );

add_action('customize_controls_enqueue_scripts', 'swm_customizer_admin_init');

if ( ! function_exists( 'swm_customizer_admin_init' ) ) {
  function swm_customizer_admin_init()  {
    $swm_template_uri = get_template_directory_uri();

    if ( get_option('swm_enable_minify_theme_css',true) ) {
      wp_register_style('swm_customizer_styles', $swm_template_uri . '/customizer/css/customizer-min.css', '', '1.0');
      wp_enqueue_style( 'swm_customizer_styles' );
    } else {
      wp_register_style('swm_customizer_styles', $swm_template_uri . '/customizer/css/customizer.css', '', '1.0');
      wp_enqueue_style( 'swm_customizer_styles' );
    }

  }
}

if ( ! function_exists( 'swm_customizer_scripts' ) ) {
    function swm_customizer_scripts() {

    wp_enqueue_script('jquery-ui-button');

    if ( get_option('swm_enable_minify_theme_js',true) ) {
      wp_register_script( 'customizer-app-js', get_template_directory_uri() . '/customizer/js/customizer-min.js', array( 'jquery' ), NULL, true );
      wp_enqueue_script( 'customizer-app-js' );
    } else {
      wp_register_script( 'customizer-app-js', get_template_directory_uri() . '/customizer/js/customizer.js', array( 'jquery' ), NULL, true );
      wp_enqueue_script( 'customizer-app-js' );
    }

    }

    add_action( 'customize_controls_print_footer_scripts', 'swm_customizer_scripts' );
}

/* **************************************************************************************
  Include Preloader
************************************************************************************** */

function swm_customizer_preloader() {

  echo '<div id="swm-customizer-loading"><div id="swm-cs-proload-content"><p><span class="swm-cs-loading"></span><span>'.esc_html__('Loading','bizix').'</span><span class="swm-cs-loading-title">'.esc_html__('Customizer','bizix').'</span></p></div>
</div>';
}

add_action( 'customize_controls_print_styles', 'swm_customizer_preloader' );

/* **************************************************************************************
  Get Customizer Options
************************************************************************************** */

if ( ! function_exists( 'swm_get_option' ) ) {
  function swm_get_option( $option, $default = false ) {

    if ( get_theme_mod('swm_site_layout') ) {
        $output = get_theme_mod( $option, $default );
        return apply_filters( 'swm_option_' . esc_attr($option), $output );
    } else {
        $output = get_option( $option, $default );
        return apply_filters( 'swm_option_' . esc_attr($option), $output );
    }

  }
}