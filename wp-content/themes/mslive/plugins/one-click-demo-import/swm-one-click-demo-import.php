<?php
// Increase http request time to fix cURL 28 issue.
function swm_custom_http_request_timeout( $timeout_value ) {
	return 600; // 600 seconds. Too much for production, only for demo import.
}

add_filter( 'http_request_timeout', 'swm_custom_http_request_timeout' );

function swm_ocdi_import_files() {
	return array(
		array(
			'import_file_name'           => 'Demo 1',
			'import_file_url'            => 'http://www.premiumthemes.in/demo-content/bizix/ocdi-new/ocdi-bizix.xml',
			'import_widget_file_url'     => 'http://www.premiumthemes.in/demo-content/bizix/ocdi-new/ocdi-bizix-widgets.json',
			'import_customizer_file_url' => 'http://www.premiumthemes.in/demo-content/bizix/ocdi-new/ocdi-bizix-customizer.dat',
			'preview_url'                => 'http://bizix.premiumthemes.in',
		)
	);
}
add_filter( 'pt-ocdi/import_files', 'swm_ocdi_import_files' );

function swm_ocdi_before_widgets_import( $selected_import ) {
	// Elementor fix for excessive use of `wp_slash`
	if ( ! wp_doing_ajax() || ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '3.0.0', '>=' ) ) ) {
		remove_filter( 'wxr_importer.pre_process.post_meta', array( 'AstraSites\Elementor\Gyan_Sites_Compatibility_Elementor', 'on_wxr_importer_pre_process_post_meta' ) );
	}
}
add_action( 'pt-ocdi/before_content_import', 'swm_ocdi_before_widgets_import' );

function swm_ocdi_after_import_setup() {
	// Assign menus to their locations.
	$main_menu = get_term_by( 'name', 'Main Navigation', 'nav_menu' );
	$topbar_left_menu = get_term_by( 'name', 'Topbar Left', 'nav_menu' );
	$topbar_right_menu = get_term_by( 'name', 'Topbar Right', 'nav_menu' );

	set_theme_mod( 'nav_menu_locations', array(
			'primary' => $main_menu->term_id,
			'topbar_left' => $topbar_left_menu->term_id,
			'topbar_right' => $topbar_right_menu->term_id,
		)
	);

	update_option( 'elementor_container_width', '1170' );
	update_option( 'elementor_disable_color_schemes', 'yes' );
	update_option( 'elementor_disable_typography_schemes', 'yes' );
	update_option( 'elementor_enable_inspector', 'disable' );

	//if exists, assign to $cpt_support var
	$cpt_support = get_option( 'elementor_cpt_support' );

	//check if option DOESN'T exist in db
	if( ! $cpt_support ) {
	    $cpt_support = [ 'page', 'post', 'portfolio' ];
	    update_option( 'elementor_cpt_support', $cpt_support );
	}

	// change customizer images demo path to local
	$swm_ocdi_folder_path  = get_template_directory_uri() . '/plugins/one-click-demo-import/';
	$logoimg               = $swm_ocdi_folder_path . 'content/images/logo.png';
	$logoimg_retina        = $swm_ocdi_folder_path . 'content/images/logo-retina.png';
	$sticky_logoimg        = $swm_ocdi_folder_path . 'content/images/logo-sticky.png';
	$sticky_logoimg_retina = $swm_ocdi_folder_path . 'content/images/logo-sticky-retina.png';
	$subheader_img         = $swm_ocdi_folder_path . 'content/images/sub-header.jpg';

	update_option( 'swm_logo_standard', $logoimg );
	update_option( 'swm_logo_retina', $logoimg_retina );
	update_option( 'swm_sub_header_bg_img', $subheader_img );
	update_option( 'swm_sticky_logo_standard', $sticky_logoimg );
	update_option( 'swm_sticky_logo_retina', $sticky_logoimg_retina );

	if ( class_exists( 'RevSlider' ) ) {
		$slider_array = array(
			'http://www.premiumthemes.in/demo-content/bizix/ocdi-new/home-one.zip',
			'http://www.premiumthemes.in/demo-content/bizix/ocdi-new/home-two.zip',
			'http://www.premiumthemes.in/demo-content/bizix/ocdi-new/home-three.zip'
		);

		$slider = new RevSlider();

		foreach($slider_array as $filepath){
			$file = test_tempDownload( $filepath );
			$slider->importSliderFromPost(true,true,$file);
		}

		echo ' Slider processed';
	}

	// #### Replace demo site URL with current site URL
	global $wpdb;
	$from = 'http://bizix.premiumthemes.in/'; // with str_replace:---> http:\\/\\/bizix.premiumthemes.in\\/
	$from_url = str_replace( '/', '\\\/', $from );
	$to = home_url().'/';
	$to_url = str_replace( '/', '\\\/', $to );

	$wpdb->query($wpdb->prepare( " UPDATE {$wpdb->postmeta} " . "SET `meta_value` = REPLACE(`meta_value`, '" . $from_url . "', '" . $to_url . "') " . "WHERE `meta_key` = '_elementor_data' AND `meta_value` LIKE '[%' ;") );
	wp_reset_postdata();

	// #### Replace Widget demo URl with Current URL. Update the Widget data changing old domain to new domain.
	// $widget_data = get_option( 'widget_gyan_social' );
   // update_option( 'widget_gyan_social', swm_recursive_array_replace( 'http://bizix.premiumthemes.in', get_site_url(), $widget_data ) );

   // #### Reset Permalink
   // global $wp_rewrite;
   // $wp_rewrite->set_permalink_structure( '/%postname%/' );
	//add_filter( 'http_request_timeout', array( &$this, 'swm_custom_http_request_timeout_after' ) );

	// Set Front and Blog Page
	$homepage = get_page_by_title( 'Home 1' );
	$blogpage = get_page_by_title( 'Blog' );

	if ( $homepage ) {
	    update_option( 'page_on_front', $homepage->ID );
	    update_option( 'show_on_front', 'page' );
	}

	if ( $blogpage ) {
	    update_option( 'page_for_posts', $blogpage->ID );
	}

	if ( ! wp_doing_ajax() || ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '3.0.0', '>=' ) ) ) {
		add_filter( 'wxr_importer.pre_process.post_meta', 'swm_ocdi_on_wxr_importer_pre_process_post_meta' );
	}

}
add_action( 'pt-ocdi/after_import', 'swm_ocdi_after_import_setup' );

// Process post meta before WXR importer.
// Normalize Elementor post meta on import with the new WP_importer, We need the `wp_slash` in order to avoid the unslashing during the `add_post_meta`.
// Fired by `wxr_importer.pre_process.post_meta` filter.
function swm_ocdi_on_wxr_importer_pre_process_post_meta( $post_meta ) {
	if ( '_elementor_data' === $post_meta['key'] ) {
		$post_meta['value'] = wp_slash( $post_meta['value'] );
	}
	return $post_meta;
}


// 5 seconds. Set to default WordPress time out value.
function swm_custom_http_request_timeout_after( $timeout_value ) {
	return 5;
}

function test_tempDownload( $url ) {
	$dir = wp_upload_dir();
	$temp = trailingslashit( $dir['basedir'] )  . basename( $url );
	file_put_contents( $temp, file_get_contents($url) );
	return $temp;
}

// Remove branding info box after content import
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

// Change the location, title and other parameters
function swm_ocdi_plugin_page_setup( $default_settings ) {
	$default_settings['parent_slug'] = 'swm-theme-panel';
	$default_settings['page_title']  = esc_html__( 'One Click Demo Import' , 'bizix' );
	$default_settings['menu_title']  = esc_html__( 'Import Demo Data' , 'bizix' );
	$default_settings['capability']  = 'import';
	$default_settings['menu_slug']   = 'pt-one-click-demo-import';
	$default_settings['position']   = 3;

	return $default_settings;
}
add_filter( 'pt-ocdi/plugin_page_setup', 'swm_ocdi_plugin_page_setup' );

function swm_recursive_array_replace( $find, $replace, $array ) {
    if ( ! is_array( $array ) ) {
        return str_replace( $find, $replace, $array );
    }
    $newArray = array();
    foreach ( $array as $key => $value ) {
        $newArray[ $key ] = swm_recursive_array_replace( $find, $replace, $value );
    }
    return $newArray;
}