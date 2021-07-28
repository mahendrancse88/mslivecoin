<?php
/**
 * Register meta boxes
 *
 * @return void
 */

function wpex_get_widget_areas() {
	global $wp_registered_sidebars;
	$widgets_areas = array();
	if ( ! empty( $wp_registered_sidebars ) ) {
		foreach ( $wp_registered_sidebars as $widget_area ) {
			$name = isset ( $widget_area['name'] ) ? $widget_area['name'] : '';
			$id = isset ( $widget_area['id'] ) ? $widget_area['id'] : '';
			if ( $name && $id ) {
				$widgets_areas[$id] = $name;
			}
		}
	}
	return $widgets_areas;
}

function swm_register_custom_meta_boxes( $swm_meta_boxes )
{

	// Page Layout
	$swm_page_layout = array(
		"default" 				=> esc_html__( 'Default', 'bizix' ),
		"layout-sidebar-right" 	=> esc_html__( 'Content Left - Sidebar Right', 'bizix' ),
		"layout-sidebar-left" 	=> esc_html__( 'Content Right - Sidebar Left', 'bizix' ),
		"layout-full-width" 	=> esc_html__( 'No Sidebar', 'bizix' ),
		"layout-full-screen" 	=> esc_html__( '100% Width - Full Screen', 'bizix' )
	);

	//swm_content_layout

	// Revolution sliders list
	$swm_meta_rev_slider_list = '';

	if (class_exists('RevSlider')) {
	    $swm_rev_theslider     = new RevSlider();
	    $swm_rev_arrSliders = $swm_rev_theslider->getArrSliders();
	    $swm_rev_arrA	= array();
	    $swm_rev_arrT	= array();
	    foreach($swm_rev_arrSliders as $slider){
	        $swm_rev_arrA[]     = $slider->getAlias();
	        $swm_rev_arrT[]     = $slider->getTitle();
	    }
	    if($swm_rev_arrA && $swm_rev_arrT){
	        $swm_meta_rev_slider_list = array_combine($swm_rev_arrA, $swm_rev_arrT);
	    }

	}

	if ( $swm_meta_rev_slider_list == '' ) {
		$swm_meta_rev_slider_list = array( 'norevslider' => 'No Slider is Created');
	}


	//Sidebar list
	global $wp_registered_sidebars;
	$swm_meta_sidebar_list = '';

    $swm_reg_sidebar_id	= array();
    $swm_reg_sidebar_name	= array();

    foreach($wp_registered_sidebars as $swm_reg_sidebar){
        $swm_reg_sidebar_id[]     = $swm_reg_sidebar['id'];
        $swm_reg_sidebar_name[]     = $swm_reg_sidebar['name'];
    }
    if($swm_reg_sidebar_id && $swm_reg_sidebar_name){
        $swm_meta_sidebar_list = array_combine($swm_reg_sidebar_id, $swm_reg_sidebar_name);
    }

	if ( $swm_meta_sidebar_list == '' ) {
		$swm_meta_sidebar_list = array( 'noreg_sidebar' => 'No Sidebar is Created');
	}

	/* *********************************************************
		POST TYPE VIDEO
	********************************************************** */


	$swm_meta_boxes[] = array(
		'id' => 'swm-meta-post-format-options',
		'title' =>  esc_html__('Post Format Options', 'bizix'),
		'pages' => array('post'),
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(

			array( "name" => esc_html__('Add YouTube video Embed code','bizix'),
					'desc' => esc_html__('Default embed video width - 616', 'bizix'),
					"id" => "swm_meta_video",
					"type" => "textarea",
					'sanitize_callback' => 'none',
					'my_class' => 'swm_divider_line',
					"std" => ''
			),
			array( "name" => esc_html__('Audio Embed code','bizix'),
					"id" => "swm_meta_audio",
					"type" => "textarea",
					'sanitize_callback' => 'none',
					'my_class' => 'swm_divider_line',
					"std" => ''
			),
			array(
				'name' => esc_html__('Galley Post Format Images', 'bizix'),
				'desc' => '',
				'id'  => "swm_meta_pf_gallery_images",
				'type'  => 'image_advanced',
			),

		)
	);


	/* *********************************************************
		PAGE/POST OPTIONS
	********************************************************** */

	$swm_meta_boxes[] = array(
		'id' => 'swm-page-meta-box',
		'title' => esc_html__('Page Options', 'bizix'),
		'pages' => array( 'post','page','portfolio','product','elementor_library'),
		'context' => 'normal',
		'priority' => 'high',
		'autosave' => true,
		'fields' => array(

			array(
			    'name' => esc_html__('Site Layout', 'bizix'),
				"id" => "swm_meta_site_layout",
				"std" => "default",
			    'type'     => 'button_group',
			    'options'  => array(
			        "default" => esc_html__( 'Default', 'bizix' ),
					"full-width" => esc_html__( 'Full Width', 'bizix' ),
					"boxed" => esc_html__( 'Boxed', 'bizix' )
			    ),
			    'inline'   => true,
			    'multiple' => false,
			),
			array(
			    'name' => esc_html__('Display Top Bar', 'bizix'),
				"id" => "swm_meta_topbar_on",
				"std" => "default",
			    'type'     => 'button_group',
			    "options" => swm_default_on_off(),
			    'inline'   => true,
			    'multiple' => false,
			),
			array(
			   	'name' => esc_html__('Display Main Header', 'bizix'),
				"id" => "swm_meta_main_header_on",
				"std" => "default",
			    'type'     => 'button_group',
			    "options" => swm_default_on_off(),
			    'inline'   => true,
			    'multiple' => false,
			),
			array(
			    'name' => esc_html__('Display Widget Footer', 'bizix'),
				"id" => "swm_meta_widget_footer_on",
				"std" => "default",
			    'type'     => 'button_group',
			    "options" => swm_default_on_off(),
			    'inline'   => true,
			    'multiple' => false,
			),
			array(
			    'name' => esc_html__('Display Contact Footer', 'bizix'),
				"id" => "swm_meta_contact_footer_on",
				"std" => "default",
			    'type'     => 'button_group',
			    "options" => swm_default_on_off(),
			    'inline'   => true,
			    'multiple' => false,
			),
			array(
			    'name' => esc_html__('Display Small Footer', 'bizix'),
				"id" => "swm_meta_small_footer_on",
				"std" => "default",
			    'type'     => 'button_group',
			    "options" => swm_default_on_off(),
			    'inline'   => true,
			    'multiple' => false,
			),
			array(
				"name" => esc_html__('Page Content', 'bizix'),
				"id" => "swm_meta_page_content_heading",
				"type" => "heading"
			),
			array(
				"name" => esc_html__('Content Layout', 'bizix'),
				"id" => "swm_meta_content_layout",
				"std" => "layout-full-width",
				"type" => "select",
				"options" => $swm_page_layout,
			),
			array(
				"name" => esc_html__('Sidebar', 'bizix'),
				"id" => "swm_meta_all_sidebar_list",
				"std" => "blog-sidebar",
				"type" => "select",
				"options" => wpex_get_widget_areas(),
			),
			array(
			    'name' => esc_html__('Page Content Top and Bottom Padding', 'bizix'),
				"id" => "swm_meta_content_padding_on",
				"std" => "default",
			    'type'     => 'button_group',
			    "options" => swm_content_padding_on_off(),
			    'inline'   => true,
			    'multiple' => false,
			),
			array(
				'name' => esc_html__('Page Content Top Padding (Desktop)', 'bizix'),
				'id' => "swm_meta_page_content_top_padding_d",
				"class" => "swm-meta-content-padding-fields",
				'std' => '100',
				"type" => "slider",
				'suffix' => 'px',
				'js_options' => array(
					'min'   => 0,
					'max'   => 500,
					'step'  => 1,
				),
			),
			array(
				'name' => esc_html__('Page Content Bottom Padding (Desktop)', 'bizix'),
				'id' => "swm_meta_page_content_bottom_padding_d",
				"class" => "swm-meta-content-padding-fields",
				'std' => '100',
				"type" => "slider",
				'suffix' => 'px',
				'js_options' => array(
					'min'   => 0,
					'max'   => 500,
					'step'  => 1,
				),
			),
			array(
				'name' => esc_html__('Page Content Top Padding (Tablet)', 'bizix'),
				'id' => "swm_meta_page_content_top_padding_t",
				"class" => "swm-meta-content-padding-fields",
				'std' => '80',
				"type" => "slider",
				'suffix' => 'px',
				'js_options' => array(
					'min'   => 0,
					'max'   => 500,
					'step'  => 1,
				),
			),
			array(
				'name' => esc_html__('Page Content Bottom Padding (Tablet)', 'bizix'),
				'id' => "swm_meta_page_content_bottom_padding_t",
				"class" => "swm-meta-content-padding-fields",
				'std' => '80',
				"type" => "slider",
				'suffix' => 'px',
				'js_options' => array(
					'min'   => 0,
					'max'   => 500,
					'step'  => 1,
				),
			),
			array(
				'name' => esc_html__('Page Content Top Padding (Mobile)', 'bizix'),
				'id' => "swm_meta_page_content_top_padding_m",
				"class" => "swm-meta-content-padding-fields",
				'std' => '60',
				"type" => "slider",
				'suffix' => 'px',
				'js_options' => array(
					'min'   => 0,
					'max'   => 500,
					'step'  => 1,
				),
			),
			array(
				'name' => esc_html__('Page Content Bottom Padding (Mobile)', 'bizix'),
				'id' => "swm_meta_page_content_bottom_padding_m",
				"class" => "swm-meta-content-padding-fields",
				'std' => '60',
				"type" => "slider",
				'suffix' => 'px',
				'js_options' => array(
					'min'   => 0,
					'max'   => 500,
					'step'  => 1,
				),
			),
			array(
				"name" => esc_html__('Sub Header (Hero Banner)', 'bizix'),
				"id" => "swm_meta_page_content_heading",
				"type" => "heading"
			),
			array(
			    'name' => esc_html__('Display Sub Header', 'bizix'),
				"id" => "swm_meta_sub_header_on",
				"class" => "swm_meta_sub_header_on",
				"std" => "default",
			    'type'     => 'button_group',
			    "options" => swm_default_on_off(),
			    'inline'   => true,
			    'multiple' => false,
			),
			array(
				"name" => esc_html__('Sub Header Options', 'bizix'),
				"id" => "swm_meta_page_content_heading",
				"class" => "swm-meta-subheader-fields",
				"type" => "heading"
			),
			array(
				"name" => esc_html__('Sub Header Display Style', 'bizix'),
				"id" => "swm_meta_header_style",
				"class" => "swm-meta-subheader-fields",
				"std" => "standard",
				"type" => "select",
				"options" => array(
					"standard" => esc_html__('Standard - Title with Background', 'bizix'),
					"revolution_slider" => esc_html__('Revolution Slider', 'bizix')
				),
			),

			array( "name" => esc_html__('Header Height (Desktop)','bizix'),
				"id" => "swm_meta_sub_header_height_d",
				"type" => "slider",
				"class" => "swm-meta-header-background-fields swm-meta-subheader-fields",
				"std" => '500',
				'suffix' => 'px',
				'js_options' => array(
					'min'   => 0,
					'max'   => 1500,
					'step'  => 1,
				),
			),
			array( "name" => esc_html__('Header Height (Tablet)','bizix'),
				"id" => "swm_meta_sub_header_height_t",
				"type" => "slider",
				"class" => "swm-meta-header-background-fields swm-meta-subheader-fields",
				"std" => '400',
				'suffix' => 'px',
				'js_options' => array(
					'min'   => 0,
					'max'   => 1500,
					'step'  => 1,
				),
			),
			array( "name" => esc_html__('Header Height (Mobile)','bizix'),
				"id" => "swm_meta_sub_header_height_m",
				"type" => "slider",
				"class" => "swm-meta-header-background-fields swm-meta-subheader-fields",
				"std" => '300',
				'suffix' => 'px',
				'js_options' => array(
					'min'   => 0,
					'max'   => 1500,
					'step'  => 1,
				),
			),

			array(
			    'type' => 'divider',
			    "class" => "swm-meta-subheader-fields swm-meta-header-background-fields",
			),
			array(
				"name" => esc_html__('Background Color', 'bizix'),
				"desc" => esc_html__('If you do not want to upload background image then add background color value', 'bizix'),
				"id" => "swm_meta_header_bg_color",
				"std" => '',
				"type" => "color",
				"class" => "swm-meta-header-background-fields swm-meta-subheader-fields",
			),
			array(
				'name' => esc_html__('Background Image', 'bizix'),
				'desc' => esc_html__('Upload background image to display in this page (recommended size : 1920x400) Note: Only upload/add single image', 'bizix'),
				'id'  => "swm_meta_header_bg_image",
				'type'  => 'image_advanced',
				"class" => "swm-meta-header-background-fields swm-meta-subheader-fields",
			),
			array(
				"name" => esc_html__('Background Image Style', 'bizix'),
				"id" => "swm_meta_sub_header_bg_style",
				"class" => "swm-meta-header-background-fields swm-meta-subheader-fields swm-meta-subheader-bgimage-fields",
				"std" => "center-center",
				"type" => "select",
				"options" => swm_get_bg_img_styles(),
			),
			array(
			    'type' => 'divider',
			    "class" => "swm-meta-subheader-fields swm-meta-header-background-fields",
			),
			array(
			    'name' => esc_html__('Display Title', 'bizix'),
				"id" => "swm_meta_sub_header_title_on",
				"class" => "swm-meta-header-background-fields swm-meta-subheader-fields",
			    'type'     => 'button_group',
			    "std" => "on",
			    "options" => swm_on_off(),
			    'inline'   => true,
			    'multiple' => false,
			),
			array(
				"name" => esc_html__('Title Position', 'bizix'),
				"id" => "swm_meta_sub_header_title_position",
				"class" => "swm-meta-header-background-fields swm-meta-subheader-fields swm-meta-subheader-title-fields",
				"std" => "title-center",
				"type" => "select",
				"options" => swm_sub_header_title_options(),
			),
			array(
				"name" => esc_html__('Title Text Color', 'bizix'),
				"id" => "swm_meta_sub_header_title_color",
				"class" => "swm-meta-header-background-fields swm-meta-subheader-fields swm-meta-subheader-title-fields",
				"std" => '#ffffff',
				"type" => "color",
			),
			array( "name" => esc_html__('Title Text Size (Desktop)','bizix'),
				"id" => "swm_meta_sub_header_title_font_size_d",
				"type" => "slider",
				"class" => "swm-meta-header-background-fields swm-meta-subheader-fields swm-meta-subheader-title-fields",
				"std" => '59',
				'suffix' => 'px',
				'js_options' => array(
					'min'   => 6,
					'max'   => 100,
					'step'  => 1,
				),
			),
			array( "name" => esc_html__('Title Text Size (Tablet)','bizix'),
				"id" => "swm_meta_sub_header_title_font_size_t",
				"type" => "slider",
				"class" => "swm-meta-header-background-fields swm-meta-subheader-fields swm-meta-subheader-title-fields",
				"std" => '49',
				'suffix' => 'px',
				'js_options' => array(
					'min'   => 6,
					'max'   => 100,
					'step'  => 1,
				),
			),
			array( "name" => esc_html__('Title Text Size (Mobile)','bizix'),
				"id" => "swm_meta_sub_header_title_font_size_m",
				"type" => "slider",
				"class" => "swm-meta-header-background-fields swm-meta-subheader-fields swm-meta-subheader-title-fields",
				"std" => '30',
				'suffix' => 'px',
				'js_options' => array(
					'min'   => 6,
					'max'   => 100,
					'step'  => 1,
				),
			),
			array(
				"name" => esc_html__('Title Text Transform', 'bizix'),
				"id" => "swm_meta_sub_header_title_transform",
				"class" => "swm-meta-header-background-fields swm-meta-subheader-fields swm-meta-subheader-title-fields",
				"std" => "none",
				"type" => "select",
				"options" => swm_text_transform(),
			),
			array(
			    'type' => 'divider',
			    "class" => "swm-meta-subheader-fields swm-meta-header-background-fields",
			),
			array(
			    'name' => esc_html__('Display Breadcrumbs', 'bizix'),
				"id" => "swm_meta_sub_header_breadcrumb_on",
				"class" => "swm-meta-header-background-fields swm-meta-subheader-fields",
				"std" => "on",
			    'type'     => 'button_group',
			    "options" => swm_on_off(),
			    'inline'   => true,
			    'multiple' => false,
			),
			array(
				"name" => esc_html__('Breadcrumbs Text Size','bizix'),
				"id" => "swm_meta_sub_header_breadcrumb_font_size",
				"type" => "slider",
				"class" => "swm-meta-header-background-fields swm-meta-subheader-fields swm-meta-subheader-breadcrumbs-fields",
				"std" => '14',
				'suffix' => 'px',
				'js_options' => array(
					'min'   => 6,
					'max'   => 100,
					'step'  => 1,
				),
			),
			array(
				"name" => esc_html__('Breadcrumbs Text Transform', 'bizix'),
				"id" => "swm_meta_sub_header_breadcrumb_transform",
				"class" => "swm-meta-header-background-fields swm-meta-subheader-fields swm-meta-subheader-breadcrumbs-fields",
				"std" => "none",
				"type" => "select",
				"options" => swm_text_transform(),
			),
			array(
				"name" => esc_html__('Breadcrumbs Text Color', 'bizix'),
				"id" => "swm_meta_breadcrumbs_text_color",
				"class" => "swm-meta-header-background-fields swm-meta-subheader-fields swm-meta-subheader-breadcrumbs-fields",
				"std" => '#ffffff',
				"type" => "color",
			),
			array(
				"name" => esc_html__('Breadcrumbs Text Hover Color', 'bizix'),
				"id" => "swm_meta_breadcrumbs_text_hover_color",
				"class" => "swm-meta-header-background-fields swm-meta-subheader-fields swm-meta-subheader-breadcrumbs-fields",
				"std" => '#ffffff',
				"type" => "color",
			),
			array(
				"name" => esc_html__('Breadcrumbs Icon Color', 'bizix'),
				"id" => "swm_meta_breadcrumbs_symbol_color",
				"class" => "swm-meta-header-background-fields swm-meta-subheader-fields swm-meta-subheader-breadcrumbs-fields",
				"std" => '#ffffff',
				"type" => "color",
			),
			array(
				"name" => esc_html__('Revolution Slider', 'bizix'),
				"id" => "swm_meta_header_revolution",
				"std" => "default",
				"type" => "select",
				"class" => "swm-meta-header-revolution-fields",
				"options" => $swm_meta_rev_slider_list,
			)
		)
	);

	return $swm_meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'swm_register_custom_meta_boxes' );