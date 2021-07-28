<?php
defined( 'ABSPATH' ) || exit;

// Returns correct ID for any object. Used to fix issues with translation plugins such as WPML & Polylang.
function swm_parse_obj_id( $id = '', $type = 'page', $key = '' ) {

	// WPML Check
	if ( SWM_WPML_ACTIVE ) {
		$type = ( 'term' == $type && $key ) ? $key : $type;   // If you want to set type to term and key to category for example

		// Make sure to grab the correct type. Fixes issues when using templatera for example for the topbar, header, footer, etc.
		if ( 'page' == $type ) { $type = get_post_type( $id ); }
		$id = apply_filters( 'wpml_object_id', $id, $type, true );  // Get correct ID

	}

	// Polylang check
	elseif ( function_exists( 'pll_get_post' ) ) {
		$type = taxonomy_exists( $type ) ? 'term' : $type; // Fixes issue where type may be set to 'category' instead of term
		if ( 'page' == $type || 'post' == $type ) {
			$id = pll_get_post( $id );
		} elseif ( 'term' == $type && function_exists( 'pll_get_term' ) ) {
			$id = pll_get_term( $id );
		}
	}

	return $id;  // Return ID

}

// Retrives a theme mod value and translates it
// Note : Translated strings do not have any defaults in the Customizer Because they all have localized fallbacks. (wp_localize_script(..))
function swm_get_translated_theme_mod( $id, $default = '' ) {
	return swm_translate_theme_mod( $id, get_theme_mod( $id, $default ) );
}

// Provides translation support for plugins such as WPML for theme_mods
function swm_translate_theme_mod( $id = '', $val = '' ) {

	// Translate theme mod val
	if ( $val && $id ) {
		if ( function_exists( 'icl_t' ) ) 		 { $val = icl_t( 'Theme Settings', $id, $val );   // WPML translation
		} elseif ( function_exists( 'pll__' ) ) { $val = pll__( $val ); 								  // Polylang Translation
		}
		return $val;
	}
}

// Register theme mods for translations
function swm_register_theme_mod_strings() {

	$strings = array(
		'swm_header_search_placeholder_text' => 'Search...',
		'swm_header_button_text'             => 'Get A Quote',
		'swm_cih_call'                       => '+1 (888) 456 7890',
		'swm_cih_call_s_title'               => 'Call Us Now',
		'swm_cih_email'                      => 'info@example.com',
		'swm_cih_email_s_title'              => 'Drop Us a Line',
		'swm_cih_address'                    => '65 St. Road, NY USA',
		'swm_cih_address_s_title'            => 'Get Direction',
		'swm_cf_email'                       => 'info@example.com',
		'swm_cf_email_s_title'               => 'Drop Us a Line',
		'swm_cf_call'                        => '+1 (888) 456 7890',
		'swm_cf_call_s_title'                => 'Call Us Now',
		'swm_cf_address'                     => '65 St. Road, NY USA',
		'swm_cf_address_s_title'             => 'Get Direction',
		'swm_post_button_text'               => 'Read More',
		'swm_blog_single_header_title'       => 'Blog',
		'swm_portfolio_page_title'           => 'Portfolio',
	);

	if ( SWM_WOOCOMMERCE_IS_ACTIVE ) {
		$strings['woo_shop_single_title']     = 'Store';
		$strings['woo_menu_icon_custom_link'] = '';
		$strings['woo_sale_flash_text']       = '';
	}

	return apply_filters( 'swm_register_theme_mod_strings', $strings );
}

// Prevent issues with WPGlobus trying to translate certain theme settings.
function swm_modify_wpglobus_customize_disabled_setting_mask( $disabled_setting_mask ) {

	// Design settings.
	$disabled_setting_mask[] = '_bg';
	$disabled_setting_mask[] = '_background';
	$disabled_setting_mask[] = '_border';
	$disabled_setting_mask[] = '_padding';

	return $disabled_setting_mask;  // Return disabled mask array.

}
add_filter( 'wpglobus_customize_disabled_setting_mask', 'swm_modify_wpglobus_customize_disabled_setting_mask' );