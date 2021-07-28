<?php

function swm_customizer_options_output_css() {

	$swm_output_folder = SWM_CUSTOMIZER . 'output/';

	require_once( $swm_output_folder . 'option-variables.php' );

	ob_start();

	echo '<style id="swm_customizer_css_output" type="text/css">';

	require_once( $swm_output_folder . 'general-css.php' );
	require_once( $swm_output_folder . 'styling-css.php' );
	require_once( $swm_output_folder . 'header-css.php' );
	require_once( $swm_output_folder . 'sub-header-css.php' );
	require_once( $swm_output_folder . 'sidebar-css.php' );
	require_once( $swm_output_folder . 'blog-css.php' );
	require_once( $swm_output_folder . 'footer-css.php' );

	echo '</style>';

	$swm_output_css = ob_get_contents();

	ob_end_clean();

	$swm_clean_css = preg_replace( '#/\*.*?\*/#s', '', $swm_output_css );
	$swm_compress_css = preg_replace( '/\s*([{}|:;,])\s+/', '$1', $swm_clean_css );
	$swm_final_css = preg_replace( '/\s\s+(.*)/', '$1', $swm_compress_css );

  	echo $swm_final_css;

}

add_action( 'wp_head', 'swm_customizer_options_output_css', 9998, 0 );