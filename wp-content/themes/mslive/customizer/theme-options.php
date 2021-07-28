<?php
function swm_customizer_options_register( $wp_customize ) {

    $defaults = array(
        'general'             =>    '1',
        'layout'              =>    '1',
        'styling'             =>    '1',
        'top_bar'             =>    '1',
        'header'              =>    '1',
        'sub_header'          =>    '1',
        'sidebar'             =>    '1',
        'footer'              =>    '1',
        'fonts'               =>    '1',
        'blog'                =>    '1',
        'page'                =>    '1',
        'portfolio'           =>    '1',
        'social_media_icons' =>     '1',
    );

    $swm_enabled_panels = get_option( 'customizer_theme_panel', $defaults );

    // move Site Identity Tab at Bottom
    $wp_customize->get_section('title_tagline')->priority = 80;

    // Panels
    $swm_cust_panels = array(
            array( 'swm_blog_panel', esc_html__( 'Blog', 'bizix' ),  24 ),
            array( 'swm_header_panel', esc_html__( 'Header', 'bizix' ),  12 ),
            array( 'swm_footer_panel', esc_html__( 'Footer', 'bizix' ),  21 ),
        );

    foreach ( $swm_cust_panels as $panel ) {
        $wp_customize->add_panel( $panel[0], array(
          'title'    => $panel[1],
          'priority' => $panel[2]
        ) );
    }

    // Sections
    $swm_cust_sections = array(
        array( 'swm_blog_section', esc_html__( 'Blog', 'bizix' ), 1, 'swm_blog_panel'),
        array( 'swm_blog_single_section', esc_html__( 'Blog Single', 'bizix' ), 2, 'swm_blog_panel'),
        array( 'swm_category_section', esc_html__( 'Category', 'bizix' ), 3, 'swm_blog_panel'),

        array( 'swm_main_header_options', esc_html__( 'Header', 'bizix' ), 1, 'swm_header_panel'),
        array( 'swm_logo_options', esc_html__( 'Logo', 'bizix' ), 2, 'swm_header_panel'),
        array( 'swm_mainmenu_options', esc_html__( 'Main Menu', 'bizix' ), 3, 'swm_header_panel'),
        array( 'swm_dropdown_menu_options', esc_html__( 'Dropdown Menu', 'bizix' ), 4, 'swm_header_panel'),
        array( 'swm_megamenu_options', esc_html__( 'Mega Menu', 'bizix' ), 5, 'swm_header_panel'),
        array( 'swm_mobile_menu_options', esc_html__( 'Mobile Menu', 'bizix' ), 6, 'swm_header_panel'),
        array( 'swm_sticky_menu_options', esc_html__( 'Sticky Menu', 'bizix' ), 7, 'swm_header_panel'),
        array( 'swm_header_search_options', esc_html__( 'Search', 'bizix' ), 8, 'swm_header_panel'),
        array( 'swm_header_button_options', esc_html__( 'Header Button', 'bizix' ), 9, 'swm_header_panel'),
        array( 'swm_sidepanel_options', esc_html__( 'Side Panel', 'bizix' ), 10, 'swm_header_panel'),
        array( 'swm_header_contact_info', esc_html__( 'Contact Info', 'bizix' ), 11, 'swm_header_panel'),

        array( 'swm_footer_widget', esc_html__( 'Widget Footer', 'bizix' ), 1, 'swm_footer_panel'),
        array( 'swm_contact_footer', esc_html__( 'Contact Footer', 'bizix' ), 1, 'swm_footer_panel'),
        array( 'swm_footer_small', esc_html__( 'Small Footer', 'bizix' ), 1, 'swm_footer_panel'),

        array( 'swm_wc_shop_options', esc_html__( 'Shop Page', 'bizix' ), 1, 'swm_wc_panel'),
        array( 'swm_wc_shop_single_options', esc_html__( 'Shop Signel/Product Detail Page', 'bizix' ), 2, 'swm_wc_panel'),
        array( 'swm_wc_cart_options', esc_html__( 'Cart Page', 'bizix' ), 3, 'swm_wc_panel'),

        array( 'swm_general_options', esc_html__( 'Ganeral', 'bizix' ), 8 ),
        array( 'swm_layout_options', esc_html__( 'Layout', 'bizix' ), 9 ),
        array( 'swm_styling_options', esc_html__( 'Styling', 'bizix' ), 10),
        array( 'swm_topbar_options', esc_html__( 'Top Bar', 'bizix' ), 11),
        array( 'swm_sub_header_options', esc_html__( 'Sub Header ( Hero Banner )', 'bizix' ), 16),
        array( 'swm_sidebar_section', esc_html__( 'Sidebar', 'bizix' ), 20 ),
        array( 'swm_fonts_options', esc_html__( 'Fonts', 'bizix' ), 23),
        array( 'swm_page_options', esc_html__( 'Page', 'bizix' ), 24),
        array( 'swm_portfolio_section', esc_html__( 'Portfolio', 'bizix' ), 25),
        array( 'swm_classes_section', esc_html__( 'Classes', 'bizix' ), 25),
        array( 'swm_team_section', esc_html__( 'Team', 'bizix' ), 25),
        array( 'swm_social_media_icons', esc_html__( 'Social Media Icons', 'bizix' ), 27),

    );

    foreach ( $swm_cust_sections as $section ) {

        $swm_get_sec_one = !empty($section[1]) ? $section[1] : '';
        $swm_get_sec_three = !empty($section[3]) ? $section[3] : '';

        $wp_customize->add_section( $section[0], array(
          'title'    => $swm_get_sec_one,
          'priority' => $section[2],
          'panel'    => $swm_get_sec_three
        ) );
    }

    // Settings Start
    $swm_list_opacity        = array('min' => '0','max' => '1','step' => '0.01');
    $zero_to_twenty          = array('min' => '0','max' => '20','step' => '1');
    $zero_to_fifty           = array('min' => '0','max' => '50','step' => '1');
    $zero_to_hundred         = array('min' => '0','max' => '100','step' => '1');
    $zero_to_hundred_alt     = array('min' => '-100','max' => '100','step' => '1');
    $zero_to_two_hundred     = array('min' => '0','max' => '200','step' => '1');
    $zero_to_five_hundred    = array('min' => '0','max' => '500','step' => '1');
    $zero_to_thousand        = array('min' => '0','max' => '1000','step' => '1');
    $zero_to_fifteenhundred  = array('min' => '0','max' => '1500','step' => '1');
    $swm_font_size           = array('min' => '6','max' => '100','step' => '1');
    $swm_font_size_em        = array('min' => '0.7','max' => '5','step' => '0.1');
    $swm_menu_height         = array('min' => '20','max' => '400','step' => '1');
    $swm_letter_space        = array('min' => '-10','max' => '10','step' => '0.1');
    $swm_layout_width        = array('min' => '70','max' => '90','step' => '1');
    $swm_layout_max_width    = array('min' => '500','max' => '1500','step' => '1');
    $swm_content_width       = array('min' => '60','max' => '74','step' => '1');
    $swm_menu_resolution     = array('min' => '300','max' => '1500','step' => '1');
    $swm_zero_to_three_sixty = array('min' => '0','max' => '360','step' => '1');
    $swm_zero_to_ten         = array('min' => '0','max' => '10','step' => '1');
    $swm_line_height         = array('min' => '1','max' => '5','step' => '0.01');
    $swm_one_to_twenty       = array('min' => '1','max' => '20','step' => '1');

    $swm_widget_footer_column = array(
        'col-1'              => get_template_directory_uri() . '/customizer/images/footer1.jpg',
        'col-2'              => get_template_directory_uri() . '/customizer/images/footer2.jpg',
        'col-3'              => get_template_directory_uri() . '/customizer/images/footer3.jpg',
        'col-4'              => get_template_directory_uri() . '/customizer/images/footer4.jpg',
        'col-66-33'          => get_template_directory_uri() . '/customizer/images/footer5.jpg',
        'col-33-66'          => get_template_directory_uri() . '/customizer/images/footer6.jpg',
        'col-25-75'          => get_template_directory_uri() . '/customizer/images/footer7.jpg',
        'col-25-25-50'       => get_template_directory_uri() . '/customizer/images/footer8.jpg',
        'col-50-25-25'       => get_template_directory_uri() . '/customizer/images/footer9.jpg',
        'col-25-50-25'       => get_template_directory_uri() . '/customizer/images/footer10.jpg',
        'col-51-38-38-54-49' => get_template_directory_uri() . '/customizer/images/footer11.jpg'
    );

    $swm_footer_column_three = array(
        "1" => "1",
        "2" => "2",
        "3" => "3"
    );

    $swm_one_to_four_column = array(
        "1" => "1",
        "2" => "2",
        "3" => "3",
        "4" => "4"
    );

    $swm_sidepanel_icon_style = array(
        "s_one" => "Style 1",
        "s_two" => "Style 2"
    );

    $swm_header_styles_list = array(
        "header_1"     => "Style 1",
        "header_1_t"   => "Style 1 - Transparent",
        "header_2"     => "Style 2",
        "header_2_alt" => "Style 2 - Wide Menu",
        "header_2_t"   => "Style 2 - Transparent"
    );

    $swm_pr_menu_active_border_style_list = array(
        "no" => "None",
        "small" => "Small Border",
        "large" => "Large Border",
        "large-alt" => "Large Border at Bottom"
    );

    $swm['set']= array();
    $swm['ctrl'] = array();

    if ( isset( $swm_enabled_panels['general'] ) ) {

        /* ******************************************************************** */
        /* GENERAL OPTIONS */
        /* ******************************************************************** */

        $swm['set'][]  = array( 'swm_page_preloader_on','off' );
        $swm['ctrl'][] = array( 'swm_page_preloader_on', 'radio-switch', esc_html__( 'Page Preloader', 'bizix' ), 'swm_general_options' );

        $swm['set'][]  = array( 'swm_page_preloader_bg', '#f6f3ee', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_page_preloader_bg', 'color', esc_html__( 'Preloader Background Color', 'bizix' ), 'swm_general_options' );

        $swm['set'][]  = array( 'swm_page_preloader_shape_color', '#d83030', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_page_preloader_shape_color', 'color', esc_html__( 'Preloader Shape Color', 'bizix' ), 'swm_general_options' );

        $swm['set'][]  = array( 'swm_bottom_go_top_scroll_btn_on','off' );
        $swm['ctrl'][] = array( 'swm_bottom_go_top_scroll_btn_on', 'radio-switch', esc_html__( 'Bottom Right Go to Top Arrow', 'bizix' ), 'swm_general_options' );

        $swm['set'][]  = array( 'swm_bottom_go_top_scroll_bg', '#252628', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_bottom_go_top_scroll_bg', 'color', esc_html__( 'Go to Top Arrow Background Color', 'bizix' ), 'swm_general_options' );

        $swm['set'][]  = array( 'swm_bottom_go_top_scroll_shape_color', '#ffffff', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_bottom_go_top_scroll_shape_color', 'color', esc_html__( 'Go to Top Arrow Color', 'bizix' ), 'swm_general_options' );

    } // end enabled panel

    if ( isset( $swm_enabled_panels['layout'] ) ) {

        /* ******************************************************************** */
        /* LAYOUT OPTIONS */
        /* ******************************************************************** */

        $swm['set'][]  = array( 'swm_layout_max_width', 1200, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_layout_max_width', 'slider', esc_html__( 'Max Width (px)', 'bizix' ), $swm_layout_max_width, 'swm_layout_options' );

        $swm['set'][]  = array( 'swm_content_width', 72, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_content_width', 'slider', esc_html__( 'Content Width for Page with Sidebar (%)', 'bizix' ), $swm_content_width, 'swm_layout_options' );

        $swm['set'][]  = array( 'swm_container_padding', 15, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_container_padding', 'slider', esc_html__( 'Layout Left and Right Padding', 'bizix' ), $zero_to_two_hundred, 'swm_layout_options' );

        // content area padding
        $swm['set'][]  = array( 'swm_site_content_top_padding_d', 100, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_site_content_top_padding_d', 'slider', esc_html__( 'Top Padding (Desktop)', 'bizix' ), $zero_to_five_hundred, 'swm_layout_options' );

        $swm['set'][]  = array( 'swm_site_content_bottom_padding_d', 100, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_site_content_bottom_padding_d', 'slider', esc_html__( 'Bottom Padding (Desktop)', 'bizix' ), $zero_to_five_hundred, 'swm_layout_options' );

        $swm['set'][]  = array( 'swm_site_content_top_padding_t', 80, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_site_content_top_padding_t', 'slider', esc_html__( 'Top Padding (Tablet)', 'bizix' ), $zero_to_five_hundred, 'swm_layout_options' );

        $swm['set'][]  = array( 'swm_site_content_bottom_padding_t', 80, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_site_content_bottom_padding_t', 'slider', esc_html__( 'Bottom Padding (Tablet)', 'bizix' ), $zero_to_five_hundred, 'swm_layout_options' );

        $swm['set'][]  = array( 'swm_site_content_top_padding_m', 60, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_site_content_top_padding_m', 'slider', esc_html__( 'Top Padding (Mobile)', 'bizix' ), $zero_to_five_hundred, 'swm_layout_options' );

        $swm['set'][]  = array( 'swm_site_content_bottom_padding_m', 60, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_site_content_bottom_padding_m', 'slider', esc_html__( 'Bottom Padding (Mobile)', 'bizix' ), $zero_to_five_hundred, 'swm_layout_options' );

        $swm['set'][]  = array( 'swm_content_layout', 'layout-full-width' );
        $swm['ctrl'][] = array( 'swm_content_layout', 'select', esc_html__( 'Content Layout', 'bizix' ), swm_page_content_layout(), 'swm_layout_options' );

        $swm['set'][]  = array( 'swm_site_layout', 'full-width' );
        $swm['ctrl'][] = array( 'swm_site_layout', 'buttontab', esc_html__( 'Site Layout', 'bizix' ),swm_site_layout(), 'swm_layout_options' );

        $swm['set'][]  = array( 'swm_boxed_layout_dropshadow', 'no-shadow' );
        $swm['ctrl'][] = array( 'swm_boxed_layout_dropshadow', 'select', esc_html__( 'Boxed Layout Drop Shadow', 'bizix' ), boxed_layout_shadow(), 'swm_layout_options' );

        $swm['set'][]  = array( 'swm_boxed_layout_margin_top_bottom', 40, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_boxed_layout_margin_top_bottom', 'slider', esc_html__( 'Boxed Layout Top and Bottom Margin', 'bizix' ), $zero_to_hundred, 'swm_layout_options' );

        $swm['set'][]  = array( 'swm_boxed_layout_no_margin_resolution', 980, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_boxed_layout_no_margin_resolution', 'slider', esc_html__( 'Remove Boxed Layout Effect from this Resolution', 'bizix' ), $swm_menu_resolution, 'swm_layout_options' );

        $swm['set'][]  = array( 'swm_boxed_layout_border_radius', 0, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_boxed_layout_border_radius', 'slider', esc_html__( 'Boxed Layout Border Radius', 'bizix' ), $zero_to_fifty, 'swm_layout_options' );

        $swm['set'][]  = array( 'swm_boxed_layout_padding_left_right', 30, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_boxed_layout_padding_left_right', 'slider', esc_html__( 'Boxed Layout Left and Right Padding', 'bizix' ), $zero_to_hundred, 'swm_layout_options' );

        // Body Background
        $swm['set'][]  = array( 'swm_body_bg_color', '#444444', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_body_bg_color', 'color', esc_html__( 'Background Color', 'bizix' ), 'swm_layout_options' );

        $swm['set'][]  = array( 'swm_body_bg_opacity',1, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_body_bg_opacity', 'slider', esc_html__( 'Background Color Opacity', 'bizix' ), $swm_list_opacity, 'swm_layout_options' );

        $swm['set'][]  = array( 'swm_body_bg_img', '', 'swm_sanitize_image' );
        $swm['ctrl'][] = array( 'swm_body_bg_img', 'image', esc_html__( 'Background Image', 'bizix' ), 'swm_layout_options' );

        $swm['set'][]  = array( 'swm_body_bg_style', 'cover' );
        $swm['ctrl'][] = array( 'swm_body_bg_style', 'select', esc_html__( 'Body Background Image Style', 'bizix' ), swm_get_bg_img_styles(), 'swm_layout_options' );

    } // end enabled panel

    if ( isset( $swm_enabled_panels['styling'] ) ) {

        /* ******************************************************************** */
        /* STYLING OPTIONS */
        /* ******************************************************************** */

        $swm['set'][]  = array( 'swm_skin_color', '#d83030', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_skin_color', 'color', esc_html__( 'Primary Skin Color', 'bizix' ), 'swm_styling_options' );

        $swm['set'][]  = array( 'swm_skin_text_color', '#ffffff', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_skin_text_color', 'color', esc_html__( 'Text Color on Primary Skin Color Background', 'bizix' ), 'swm_styling_options' );

        $swm['set'][]  = array( 'swm_secondary_skin_color', '#252628', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_secondary_skin_color', 'color', esc_html__( 'Secondary Skin Color', 'bizix' ), 'swm_styling_options' );

        $swm['set'][]  = array( 'swm_secondary_skin_text_color', '#ffffff', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_secondary_skin_text_color', 'color', esc_html__( 'Text Color on Secondary Skin Color Background', 'bizix' ), 'swm_styling_options' );

        $swm['set'][]  = array( 'swm_content_headings_color', '#032e42', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_content_headings_color', 'color', esc_html__( 'Site Content Headings ( H1 to H6 ) Color', 'bizix' ), 'swm_styling_options' );

        $swm['set'][]  = array( 'swm_content_color', '#676767', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_content_color', 'color', esc_html__( 'Site Content Text Color', 'bizix' ), 'swm_styling_options' );

        $swm['set'][]  = array( 'swm_content_link_color', '#676767', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_content_link_color', 'color', esc_html__( 'Site Content Link Color', 'bizix' ), 'swm_styling_options' );

        $swm['set'][]  = array( 'swm_content_link_hover_color', '#d83030', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_content_link_hover_color', 'color', esc_html__( 'Site Content Link Hover Color', 'bizix' ), 'swm_styling_options' );

        $swm['set'][]  = array( 'swm_highlight_bg', '#d83030', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_highlight_bg', 'color', esc_html__( 'Highlight Background', 'bizix' ), 'swm_styling_options' );

        $swm['set'][]  = array( 'swm_highlight_color', '#ffffff', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_highlight_color', 'color', esc_html__( 'Highlight Text Color', 'bizix' ), 'swm_styling_options' );

    }  // end enabled panel

    if ( isset( $swm_enabled_panels['top_bar'] ) ) {

        /* ******************************************************************** */
        /* TOPBAR OPTIONS */
        /* ******************************************************************** */

        $swm['set'][]  = array( 'swm_topbar_on','off' );
        $swm['ctrl'][] = array( 'swm_topbar_on', 'radio-switch', esc_html__( 'Top Bar', 'bizix' ), 'swm_topbar_options' );

        $swm['set'][]  = array( 'swm_topbar_font_size', 14, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_topbar_font_size', 'slider', esc_html__( 'Font Size', 'bizix' ), $swm_font_size, 'swm_topbar_options' );

        $swm['set'][]  = array( 'swm_topbar_bg_solid_color', '#252628', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_topbar_bg_solid_color', 'color', esc_html__( 'Background Color', 'bizix' ), 'swm_topbar_options' );

        $swm['set'][]  = array( 'swm_topbar_text', '#bbbbbb', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_topbar_text', 'color', esc_html__( 'Text Color', 'bizix' ), 'swm_topbar_options' );

        $swm['set'][]  = array( 'swm_topbar_hover_text', '#ffffff', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_topbar_hover_text', 'color', esc_html__( 'Text (Link) Hover Color', 'bizix' ), 'swm_topbar_options' );

        $swm['set'][]  = array( 'swm_topbar_icon_col', '#7f7f7f', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_topbar_icon_col', 'color', esc_html__( 'Menu Icons Color', 'bizix' ), 'swm_topbar_options' );

        $swm['set'][]  = array( 'swm_topbar_device', '' );
        $swm['ctrl'][] = array( 'swm_topbar_device', 'select', esc_html__( 'Hide Topbar At', 'bizix' ), swm_hide_tablet_mobile(), 'swm_topbar_options' );

        $swm['set'][]  = array( 'swm_topbar_social_on','on' );
        $swm['ctrl'][] = array( 'swm_topbar_social_on', 'radio-switch', esc_html__( 'Social Icons', 'bizix' ), 'swm_topbar_options' );

        $swm['set'][]  = array( 'swm_topbar_sm_color', '#bbbbbb', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_topbar_sm_color', 'color', esc_html__( 'Icons Color', 'bizix' ), 'swm_topbar_options' );

        $swm['set'][]  = array( 'swm_topbar_sm_h_color', '#ffffff', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_topbar_sm_h_color', 'color', esc_html__( 'Icons Hover Color', 'bizix' ), 'swm_topbar_options' );

        $swm['set'][]  = array( 'swm_topbar_left_style_on','on' );
        $swm['ctrl'][] = array( 'swm_topbar_left_style_on', 'radio-switch', esc_html__( 'Topbar Left Styling', 'bizix' ), 'swm_topbar_options' );

        $swm['set'][]  = array( 'swm_topbar_left_bg_color', '#d83030', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_topbar_left_bg_color', 'color', esc_html__( 'Background Color', 'bizix' ), 'swm_topbar_options' );

        $swm['set'][]  = array( 'swm_topbar_left_text_color', '#ffffff', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_topbar_left_text_color', 'color', esc_html__( 'Text Color', 'bizix' ), 'swm_topbar_options' );

        $swm['set'][]  = array( 'swm_topbar_left_text_hover_color', '#ffffff', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_topbar_left_text_hover_color', 'color', esc_html__( 'Text Hover Color', 'bizix' ), 'swm_topbar_options' );

        $swm['set'][]  = array( 'swm_topbar_left_icon_color', '#e89999', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_topbar_left_icon_color', 'color', esc_html__( 'Icon Color', 'bizix' ), 'swm_topbar_options' );

    }  // end enabled panel

    if ( isset( $swm_enabled_panels['header'] ) ) {

        /* ******************************************************************** */
        /* HEADER OPTIONS */
        /* ******************************************************************** */

        $swm['set'][]  = array( 'swm_main_header_on','on' );
        $swm['ctrl'][] = array( 'swm_main_header_on', 'radio-switch', esc_html__( 'Header', 'bizix' ), 'swm_main_header_options' );

        $swm['set'][]  = array( 'swm_header_style', 'header_1' );
        $swm['ctrl'][] = array( 'swm_header_style', 'select', esc_html__( 'Header Style', 'bizix' ), $swm_header_styles_list, 'swm_main_header_options' );

        $swm['set'][]  = array( 'swm_main_header_bg_color', '#ffffff', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_main_header_bg_color', 'color', esc_html__( 'Header Background Color', 'bizix' ), 'swm_main_header_options' );

        $swm['set'][]  = array( 'swm_header_bg_opacity',0.8, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_header_bg_opacity', 'slider', esc_html__( 'Transparent Header Background Color Opacity', 'bizix' ), $swm_list_opacity, 'swm_main_header_options' );

        $swm['set'][]  = array( 'swm_main_header_height_d', 107, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_main_header_height_d', 'slider', esc_html__( 'Header Height (Desktop)', 'bizix' ), $zero_to_fifteenhundred, 'swm_main_header_options' );

        $swm['set'][]  = array( 'swm_main_header_height_t', 107, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_main_header_height_t', 'slider', esc_html__( 'Header Height (Tablet)', 'bizix' ), $zero_to_fifteenhundred, 'swm_main_header_options' );

        $swm['set'][]  = array( 'swm_main_header_height_m', 80, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_main_header_height_m', 'slider', esc_html__( 'Header Height (Mobile)', 'bizix' ), $zero_to_fifteenhundred, 'swm_main_header_options' );

        // logo options

        $swm['set'][]  = array( 'swm_logo_standard', '', 'swm_sanitize_image' );
        $swm['ctrl'][] = array( 'swm_logo_standard', 'image', esc_html__( 'Standard Logo Image (for Desktop)', 'bizix' ), 'swm_logo_options' );

        $swm['set'][]  = array( 'swm_logo_retina', '', 'swm_sanitize_image' );
        $swm['ctrl'][] = array( 'swm_logo_retina', 'image', esc_html__( 'Retina Logo Image (for Mobile)', 'bizix' ), 'swm_logo_options' );

        $swm['set'][]  = array( 'swm_logo_standard_width', '126px', 'swm_sanitize_simple_text' );
        $swm['ctrl'][] = array( 'swm_logo_standard_width', 'text', esc_html__( 'Standard Logo Width (px)', 'bizix' ), 'swm_logo_options' );

        $swm['set'][]  = array( 'swm_logo_standard_height', '', 'swm_sanitize_simple_text' );
        $swm['ctrl'][] = array( 'swm_logo_standard_height', 'text', esc_html__( 'Standard Logo Height (only number)', 'bizix' ), 'swm_logo_options' );

        // Main Links Options

        $swm['set'][]  = array( 'swm_pr_menu_font_size', 15, 'swm_sanitize_number_floatval','postMessage' );
        $swm['ctrl'][] = array( 'swm_pr_menu_font_size', 'slider', esc_html__( 'Main Links Font Size', 'bizix' ), $swm_font_size, 'swm_mainmenu_options' );

        $swm['set'][]  = array( 'swm_pr_menu_links_space', 19, 'swm_sanitize_number_floatval','postMessage' );
        $swm['ctrl'][] = array( 'swm_pr_menu_links_space', 'slider', esc_html__( 'Space Between Main Links', 'bizix' ), $zero_to_hundred, 'swm_mainmenu_options' );

        $swm['set'][]  = array( 'swm_pr_menu_links_text_color', '#032e42', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_pr_menu_links_text_color', 'color', esc_html__( 'Main Links Text Color', 'bizix' ), 'swm_mainmenu_options' );

        $swm['set'][]  = array( 'swm_pr_menu_links_text_hover_color', '#d83030', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_pr_menu_links_text_hover_color', 'color', esc_html__( 'Main Links Hover/Active Text Color', 'bizix' ), 'swm_mainmenu_options' );

        $swm['set'][]  = array( 'swm_pr_menu_active_border_on','on','','postMessage' );
        $swm['ctrl'][] = array( 'swm_pr_menu_active_border_on', 'radio-switch', esc_html__( 'Active Link Border', 'bizix' ), 'swm_mainmenu_options' );

        $swm['set'][]  = array( 'swm_pr_menu_active_border_color', '#d83030', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_pr_menu_active_border_color', 'color', esc_html__( 'Active Link Border Color', 'bizix' ), 'swm_mainmenu_options' );

        $swm['set'][]  = array( 'swm_pr_menu_active_border_style', 'small','','postMessage' );
        $swm['ctrl'][] = array( 'swm_pr_menu_active_border_style', 'select', esc_html__( 'Active Link Border Style', 'bizix' ), $swm_pr_menu_active_border_style_list, 'swm_mainmenu_options' );

        $swm['set'][]  = array( 'swm_pr_menu_bg', '#f2f2f2', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_pr_menu_bg', 'color', esc_html__( 'Main Links Background', 'bizix' ), 'swm_mainmenu_options' );

        $swm['set'][]  = array( 'swm_pr_menu_bg_opacity',1, 'swm_sanitize_number_floatval','postMessage' );
        $swm['ctrl'][] = array( 'swm_pr_menu_bg_opacity', 'slider', esc_html__( 'Main Links Background Color Opacity', 'bizix' ), $swm_list_opacity, 'swm_mainmenu_options' );

        $swm['set'][]  = array( 'swm_pr_menu_links_text_transform', 'uppercase','','postMessage' );
        $swm['ctrl'][] = array( 'swm_pr_menu_links_text_transform', 'buttontab', esc_html__( 'Main links Text Transform', 'bizix' ),swm_text_transform(), 'swm_mainmenu_options' );

        $swm['set'][]  = array( 'swm_pr_menu_dropdown_indicator','off','','postMessage' );
        $swm['ctrl'][] = array( 'swm_pr_menu_dropdown_indicator', 'radio-switch', esc_html__( 'Dropdown Indicator - Arrow Icon', 'bizix' ), 'swm_mainmenu_options' );

        $swm['set'][]  = array( 'swm_pr_menu_divider_on','off','','postMessage' );
        $swm['ctrl'][] = array( 'swm_pr_menu_divider_on', 'radio-switch', esc_html__( 'Links Divider Line', 'bizix' ), 'swm_mainmenu_options' );

        $swm['set'][]  = array( 'swm_pr_menu_divider_color', '#e6e6e6', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_pr_menu_divider_color', 'color', esc_html__( 'Divider Line Color', 'bizix' ), 'swm_mainmenu_options' );

        // Dropdown Options
        $swm['set'][]  = array( 'swm_dd_menu_font_size', 14, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_dd_menu_font_size', 'slider', esc_html__( 'Text Size', 'bizix' ), $swm_font_size, 'swm_dropdown_menu_options' );

        $swm['set'][]  = array( 'swm_dd_menu_font_color', '#676767', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_dd_menu_font_color', 'color', esc_html__( 'Text Color', 'bizix' ), 'swm_dropdown_menu_options' );

        $swm['set'][]  = array( 'swm_d_menu_font_hov_color', '#d83030', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_d_menu_font_hov_color', 'color', esc_html__( 'Text Hover Color', 'bizix' ), 'swm_dropdown_menu_options' );

        $swm['set'][]  = array( 'swm_dd_bg_color', '#ffffff', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_dd_bg_color', 'color', esc_html__( 'Background Color', 'bizix' ), 'swm_dropdown_menu_options' );

        $swm['set'][]  = array( 'swm_dd_menu_title_transform', 'none' );
        $swm['ctrl'][] = array( 'swm_dd_menu_title_transform', 'buttontab', esc_html__( 'Text Transform', 'bizix' ),swm_text_transform(), 'swm_dropdown_menu_options' );

        $swm['set'][]  = array( 'swm_dd_menu_pr_font_family_on','on' );
        $swm['ctrl'][] = array( 'swm_dd_menu_pr_font_family_on', 'radio-switch', esc_html__( 'Use Main Links Font Family', 'bizix' ), 'swm_dropdown_menu_options' );

        $swm['set'][]  = array( 'swm_dd_menu_links_space', 7, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_dd_menu_links_space', 'slider', esc_html__( 'Space Between Links (Top/Bottom Padding)', 'bizix' ), $zero_to_hundred, 'swm_dropdown_menu_options' );

        $swm['set'][]  = array( 'swm_dd_menu_width', 236, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_dd_menu_width', 'slider', esc_html__( 'Dropdown Menu Width', 'bizix' ), $zero_to_five_hundred, 'swm_dropdown_menu_options' );

        $swm['set'][]  = array( 'swm_dd_menu_box_shadow','on' );
        $swm['ctrl'][] = array( 'swm_dd_menu_box_shadow', 'radio-switch', esc_html__( 'Box(Outer) Shadow', 'bizix' ), 'swm_dropdown_menu_options' );

        $swm['set'][]  = array( 'swm_dd_menu_submenu_indicator','off' );
        $swm['ctrl'][] = array( 'swm_dd_menu_submenu_indicator', 'radio-switch', esc_html__( 'Sub Menu Indicator - Arrow Icon', 'bizix' ), 'swm_dropdown_menu_options' );

        //mega menu
        $swm['set'][]  = array( 'swm_megamenu_links_space',5, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_megamenu_links_space', 'slider', esc_html__( 'Space Between Two Items (Top/Bottom Padding)', 'bizix' ), $zero_to_fifty, 'swm_megamenu_options' );

        $swm['set'][]  = array( 'swm_megamenu_text_lineheight', 23, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_megamenu_text_lineheight', 'slider', esc_html__( 'Menu List Text Line Height', 'bizix' ), $zero_to_hundred, 'swm_megamenu_options' );

        $swm['set'][]  = array( 'swm_dropdown_bullet_arrow','on' );
        $swm['ctrl'][] = array( 'swm_dropdown_bullet_arrow', 'radio-switch', esc_html__( 'Bullet Arrow Before Items', 'bizix' ), 'swm_megamenu_options' );

        $swm['set'][]  = array( 'swm_megamenu_title_font_size', 20, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_megamenu_title_font_size', 'slider', esc_html__(  'Font Size', 'bizix' ), $swm_font_size, 'swm_megamenu_options' );

        $swm['set'][]  = array( 'swm_megamenu_title_lineheight', 30, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_megamenu_title_lineheight', 'slider', esc_html__( 'Line Height', 'bizix' ), $zero_to_hundred, 'swm_megamenu_options' );

        $swm['set'][]  = array( 'swm_megamenu_title_font_color', '#032e42', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_megamenu_title_font_color', 'color', esc_html__( 'Color', 'bizix' ), 'swm_megamenu_options' );

        // mobile menu
        $swm['set'][]  = array( 'swm_mobile_menu_min_resolution',979, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_mobile_menu_min_resolution', 'slider', esc_html__( 'Width At Which Menu Becomes Responsive', 'bizix' ), $swm_menu_resolution, 'swm_mobile_menu_options' );

        // sticky menu
        $swm['set'][]  = array( 'swm_sticky_menu_on','off' );
        $swm['ctrl'][] = array( 'swm_sticky_menu_on', 'radio-switch', esc_html__( 'Sticky Menu', 'bizix' ), 'swm_sticky_menu_options' );

        $swm['set'][]  = array( 'swm_sticky_logo_standard', '', 'swm_sanitize_image' );
        $swm['ctrl'][] = array( 'swm_sticky_logo_standard', 'image', esc_html__( 'Sticky Menu Standard Logo Image (for Desktop)', 'bizix' ), 'swm_sticky_menu_options' );

        $swm['set'][]  = array( 'swm_sticky_logo_retina', '', 'swm_sanitize_image' );
        $swm['ctrl'][] = array( 'swm_sticky_logo_retina', 'image', esc_html__( 'Sticky Menu Retina Logo Image (for Mobile)', 'bizix' ), 'swm_sticky_menu_options' );

        $swm['set'][]  = array( 'swm_logo_sticky_width', '126px', 'swm_sanitize_simple_text' );
        $swm['ctrl'][] = array( 'swm_logo_sticky_width', 'text', esc_html__( 'Sticky Menu Standard Logo Width (px)', 'bizix' ), 'swm_sticky_menu_options' );

        $swm['set'][]  = array( 'swm_sticky_menu_font_size', 15, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_sticky_menu_font_size', 'slider', esc_html__( 'Main Links Font Size', 'bizix' ), $swm_font_size, 'swm_sticky_menu_options' );

        $swm['set'][]  = array( 'swm_sticky_pr_menu_links_text_color', '#032e42', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_sticky_pr_menu_links_text_color', 'color', esc_html__( 'Main Links Text Color', 'bizix' ), 'swm_sticky_menu_options' );

        $swm['set'][]  = array( 'swm_sticky_pr_menu_links_text_hover_color', '#d83030', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_sticky_pr_menu_links_text_hover_color', 'color', esc_html__( 'Main Links Hover/Active Text Color', 'bizix' ), 'swm_sticky_menu_options' );

        $swm['set'][]  = array( 'swm_sticky_pr_menu_active_border_color', '#d83030', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_sticky_pr_menu_active_border_color', 'color', esc_html__( 'Active Link Border Color', 'bizix' ), 'swm_sticky_menu_options' );

        $swm['set'][]  = array( 'swm_sticky_pr_menu_bg', '#ffffff', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_sticky_pr_menu_bg', 'color', esc_html__( 'Main Links Background', 'bizix' ), 'swm_sticky_menu_options' );

        $swm['set'][]  = array( 'swm_sticky_pr_menu_divider_color', '#e6e6e6', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_sticky_pr_menu_divider_color', 'color', esc_html__( 'Divider Line Color', 'bizix' ), 'swm_sticky_menu_options' );

        $swm['set'][]  = array( 'swm_sticky_hide_resolution',768, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_sticky_hide_resolution', 'slider', esc_html__( 'Hide Sticky Menu From This Resolution', 'bizix' ), $zero_to_fifteenhundred, 'swm_sticky_menu_options' );

        // search
        $swm['set'][] = array( 'swm_header_search_on','on' );
        $swm['ctrl'][] = array( 'swm_header_search_on', 'radio-switch', esc_html__( 'Search', 'bizix' ), 'swm_header_search_options' );

        $swm['set'][] = array( 'swm_header_search_text_size', 21, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_header_search_text_size', 'slider', esc_html__( 'Search Box Text Size', 'bizix' ), $swm_font_size, 'swm_header_search_options' );

        $swm['set'][] = array( 'swm_header_search_bg_color', '#252628', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_header_search_bg_color', 'color', esc_html__( 'Background Color', 'bizix' ), 'swm_header_search_options' );

        $swm['set'][]  = array( 'swm_header_search_bg_opacity',0.99, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_header_search_bg_opacity', 'slider', esc_html__( 'Background Color Opacity', 'bizix' ), $swm_list_opacity, 'swm_header_search_options' );

        $swm['set'][] = array( 'swm_header_search_text_color', '#ffffff', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_header_search_text_color', 'color', esc_html__( 'Text Color', 'bizix' ), 'swm_header_search_options' );

        $swm['set'][] = array( 'swm_header_search_form_border_color', '#d83030', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_header_search_form_border_color', 'color', esc_html__( 'Input Field Border Color', 'bizix' ), 'swm_header_search_options' );

        $swm['set'][] = array( 'swm_header_close_icon_color', '#ffffff', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_header_close_icon_color', 'color', esc_html__( 'Close Icon Color', 'bizix' ), 'swm_header_search_options' );

        $swm['set'][] = array( 'swm_header_search_placeholder_text', 'Search...', 'swm_sanitize_simple_text','postMessage' );
        $swm['ctrl'][] = array( 'swm_header_search_placeholder_text', 'text', esc_html__( 'Default Search Placeholder Text', 'bizix' ), 'swm_header_search_options' );

        $swm['set'][]  = array( 'swm_header_search_max_width', 905, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_header_search_max_width', 'slider', esc_html__( 'Search Form Max Width (px)', 'bizix' ), $swm_layout_max_width, 'swm_header_search_options' );

        // header button
        $swm['set'][]  = array( 'swm_header_button_on','off' );
        $swm['ctrl'][] = array( 'swm_header_button_on', 'radio-switch', esc_html__( 'Header Button', 'bizix' ), 'swm_header_button_options' );

        $swm['set'][]  = array( 'swm_header_button_text','Get A Quote', 'swm_sanitize_simple_text' );
        $swm['ctrl'][] = array( 'swm_header_button_text', 'text', esc_html__( 'Button Text', 'bizix' ), 'swm_header_button_options' );

        $swm['set'][]  = array( 'swm_header_button_link','#','swm_sanitize_url' );
        $swm['ctrl'][] = array( 'swm_header_button_link', 'text', esc_html__( 'Button Link', 'bizix' ), 'swm_header_button_options' );

        $swm['set'][]  = array( 'swm_header_button_link_target','off' );
        $swm['ctrl'][] = array( 'swm_header_button_link_target', 'radio-switch', esc_html__( 'Open Link Page in New Window', 'bizix' ), 'swm_header_button_options' );

        $swm['set'][]  = array( 'swm_header_button_font_size', 15, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_header_button_font_size', 'slider', esc_html__( 'Button Text Size', 'bizix' ), $swm_font_size, 'swm_header_button_options' );

        $swm['set'][]  = array( 'swm_header_button_text_color', '#ffffff', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_header_button_text_color', 'color', esc_html__( 'Button Text Color', 'bizix' ), 'swm_header_button_options' );

        $swm['set'][]  = array( 'swm_header_button_text_h_color', '#ffffff', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_header_button_text_h_color', 'color', esc_html__( 'Button Hover Text Color', 'bizix' ), 'swm_header_button_options' );

        $swm['set'][]  = array( 'swm_header_button_bg', '#252628', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_header_button_bg', 'color', esc_html__( 'Button Background Color', 'bizix' ), 'swm_header_button_options' );

        $swm['set'][]  = array( 'swm_header_button_h_bg', '#101011', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_header_button_h_bg', 'color', esc_html__( 'Button Hover Background Color', 'bizix' ), 'swm_header_button_options' );

        $swm['set'][]  = array( 'swm_header_button_border_color', '#252628', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_header_button_border_color', 'color', esc_html__( 'Button Border Color', 'bizix' ), 'swm_header_button_options' );

        $swm['set'][]  = array( 'swm_header_button_border_h_color', '#101011', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_header_button_border_h_color', 'color', esc_html__( 'Button Hover Border Color', 'bizix' ), 'swm_header_button_options' );

        $swm['set'][]  = array( 'swm_header_button_width',0, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_header_button_width', 'slider', esc_html__( 'Button Border Width', 'bizix' ), $swm_zero_to_ten, 'swm_header_button_options' );

        $swm['set'][]  = array( 'swm_header_button_border_radius',3, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_header_button_border_radius', 'slider', esc_html__( 'Button Border Radius', 'bizix' ), $zero_to_hundred, 'swm_header_button_options' );

        $swm['set'][]  = array( 'swm_header_button_border_style', 'solid' );
        $swm['ctrl'][] = array( 'swm_header_button_border_style', 'buttontab', esc_html__( 'Button Border Style', 'bizix' ),swm_border_styles(), 'swm_header_button_options' );

        $swm['set'][]  = array( 'swm_header_button_hide_device', '' );
        $swm['ctrl'][] = array( 'swm_header_button_hide_device', 'select', esc_html__( 'Hide Button At', 'bizix' ), swm_hide_tablet_mobile(), 'swm_header_button_options' );

        // sidepanel options
        $swm['set'][]  = array( 'swm_sidepanel_on','off' );
        $swm['ctrl'][] = array( 'swm_sidepanel_on', 'radio-switch', esc_html__( 'Side Panel', 'bizix' ), 'swm_sidepanel_options' );

        $swm['set'][]  = array( 'swm_sidepanel_max_width', 500, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_sidepanel_max_width', 'slider', esc_html__( 'Side Panel Max Width (px)', 'bizix' ), $zero_to_fifteenhundred, 'swm_sidepanel_options' );

        $swm['set'][]  = array( 'swm_hide_sidepanel_resolution',979, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_hide_sidepanel_resolution', 'slider', esc_html__( 'Hide Side Panel from this Resolution', 'bizix' ), $swm_menu_resolution, 'swm_sidepanel_options' );

        $swm['set'][]  = array( 'swm_sidepanel_icon_col', '#676767', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_sidepanel_icon_col', 'color', esc_html__( 'Side Panel Icon Color (in Header Menu)', 'bizix' ), 'swm_sidepanel_options' );

        $swm['set'][]  = array( 'swm_sidepanel_icon_style', 's_one' );
        $swm['ctrl'][] = array( 'swm_sidepanel_icon_style', 'select', esc_html__( 'Side Panel Icon Style', 'bizix' ), $swm_sidepanel_icon_style, 'swm_sidepanel_options' );

        $swm['set'][]  = array( 'swm_sidepanel_overlay_bg', '#000000', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_sidepanel_overlay_bg', 'color', esc_html__( 'Overlay Background', 'bizix' ), 'swm_sidepanel_options' );

        $swm['set'][]  = array( 'swm_sidepanel_overlay_bg_opacity',0.8, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_sidepanel_overlay_bg_opacity', 'slider', esc_html__( 'Overlay Background Opacity', 'bizix' ), $swm_list_opacity, 'swm_sidepanel_options' );

        $swm['set'][]  = array( 'swm_close_icon_on','on' );
        $swm['ctrl'][] = array( 'swm_close_icon_on', 'radio-switch', esc_html__( 'Close Icon', 'bizix' ), 'swm_sidepanel_options' );

        $swm['set'][]  = array( 'swm_sidepanel_close_icon_col', '#d83030', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_sidepanel_close_icon_col', 'color', esc_html__( 'Close Icon Color', 'bizix' ), 'swm_sidepanel_options' );

        $swm['set'][]  = array( 'swm_sidepanel_close_icon_border_col', '#e6e6e6', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_sidepanel_close_icon_border_col', 'color', esc_html__( 'Close Icon Border Color', 'bizix' ), 'swm_sidepanel_options' );

        $swm['set'][]  = array( 'swm_sidepanel_text_size', 15, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_sidepanel_text_size', 'slider', esc_html__( 'Text Size', 'bizix' ), $swm_font_size, 'swm_sidepanel_options' );

        $swm['set'][]  = array( 'swm_sidepanel_text_col', '#676767', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_sidepanel_text_col', 'color', esc_html__( 'Text Color', 'bizix' ), 'swm_sidepanel_options' );

        $swm['set'][]  = array( 'swm_sidepanel_link', '#676767', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_sidepanel_link', 'color', esc_html__( 'Link Color', 'bizix' ), 'swm_sidepanel_options' );

        $swm['set'][]  = array( 'swm_sidepanel_link_hover', '#d83030', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_sidepanel_link_hover', 'color', esc_html__( 'Link Hover Color', 'bizix' ), 'swm_sidepanel_options' );

        $swm['set'][]  = array( 'swm_sidepanel_border_color', '#e6e6e6', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_sidepanel_border_color', 'color', esc_html__( 'Elements Borders Color', 'bizix' ), 'swm_sidepanel_options' );

        $swm['set'][]  = array( 'swm_sidepanel_title_color', '#032e42', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_sidepanel_title_color', 'color', esc_html__( 'Title Text Color', 'bizix' ), 'swm_sidepanel_options' );

        $swm['set'][]  = array( 'swm_sidepanel_title_transform', 'none' );
        $swm['ctrl'][] = array( 'swm_sidepanel_title_transform', 'buttontab', esc_html__( 'Title Text Transform', 'bizix' ), swm_text_transform(), 'swm_sidepanel_options' );

        $swm['set'][]  = array( 'swm_sidepanel_title_size', 19, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_sidepanel_title_size', 'slider', esc_html__( 'Title Text Size', 'bizix' ), $swm_font_size, 'swm_sidepanel_options' );

        $swm['set'][]  = array( 'swm_sidepanel_title_letter_space', 0, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_sidepanel_title_letter_space', 'slider', esc_html__( 'Title Letter Spacing', 'bizix' ), $swm_letter_space, 'swm_sidepanel_options' );

        // Contact Info

        $swm['set'][]  = array( 'swm_header_contact_info_on','on' );
        $swm['ctrl'][] = array( 'swm_header_contact_info_on', 'radio-switch', esc_html__( 'Contact Info', 'bizix' ), 'swm_header_contact_info' );

        $swm['set'][] = array( 'swm_cih_call', '+1 (888) 456 7890', 'swm_sanitize_simple_text','postMessage' );
        $swm['ctrl'][] = array( 'swm_cih_call', 'text', esc_html__( 'Phone No.', 'bizix' ), 'swm_header_contact_info' );

        $swm['set'][] = array( 'swm_cih_call_s_title', 'Call Us Now', 'swm_sanitize_simple_text','postMessage' );
        $swm['ctrl'][] = array( 'swm_cih_call_s_title', 'text', esc_html__( 'Phone No. Sub Title', 'bizix' ), 'swm_header_contact_info' );

        $swm['set'][] = array( 'swm_cih_email', 'info@example.com', 'swm_sanitize_simple_text','postMessage' );
        $swm['ctrl'][] = array( 'swm_cih_email', 'text', esc_html__( 'Email Id', 'bizix' ), 'swm_header_contact_info' );

        $swm['set'][] = array( 'swm_cih_email_s_title', 'Drop Us a Line', 'swm_sanitize_simple_text' ,'postMessage');
        $swm['ctrl'][] = array( 'swm_cih_email_s_title', 'text', esc_html__( 'Email Id Sub Title', 'bizix' ), 'swm_header_contact_info' );

        $swm['set'][] = array( 'swm_cih_address', '65 St. Road, NY USA', 'swm_sanitize_simple_text','postMessage' );
        $swm['ctrl'][] = array( 'swm_cih_address', 'text', esc_html__( 'Address', 'bizix' ), 'swm_header_contact_info' );

        $swm['set'][] = array( 'swm_cih_address_s_title', 'Get Direction', 'swm_sanitize_simple_text','postMessage' );
        $swm['ctrl'][] = array( 'swm_cih_address_s_title', 'text', esc_html__( 'Address Sub Title', 'bizix' ), 'swm_header_contact_info' );

        $swm['set'][] = array( 'swm_cih_icon_color', '#d83030', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_cih_icon_color', 'color', esc_html__( 'Icon Color', 'bizix' ), 'swm_header_contact_info' );

        $swm['set'][] = array( 'swm_cih_title_color', '#032e42', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_cih_title_color', 'color', esc_html__( 'Title Text Color', 'bizix' ), 'swm_header_contact_info' );

        $swm['set'][] = array( 'swm_cih_subtitle_color', '#676767', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_cih_subtitle_color', 'color', esc_html__( 'Sub Title Text Color', 'bizix' ), 'swm_header_contact_info' );

        $swm['set'][]  = array( 'swm_cih_title_size', 16, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_cih_title_size', 'slider', esc_html__( 'Title Text Size', 'bizix' ), $swm_font_size, 'swm_header_contact_info' );

        $swm['set'][]  = array( 'swm_cih_subtitle_size', 15, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_cih_subtitle_size', 'slider', esc_html__( 'Sub Title Text Size', 'bizix' ), $swm_font_size, 'swm_header_contact_info' );

        $swm['set'][]  = array( 'swm_header_contactinfo_hide_device', '' );
        $swm['ctrl'][] = array( 'swm_header_contactinfo_hide_device', 'select', esc_html__( 'Hide Contact Info At', 'bizix' ), swm_hide_tablet_mobile(), 'swm_header_contact_info' );

        $swm['set'][]  = array( 'swm_cih_social_icons_on','on' );
        $swm['ctrl'][] = array( 'swm_cih_social_icons_on', 'radio-switch', esc_html__( 'Social Icons', 'bizix' ), 'swm_header_contact_info' );

        $swm['set'][] = array( 'swm_cih_sicons_col', '#676767', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_cih_sicons_col', 'color', esc_html__( 'Text Color', 'bizix' ), 'swm_header_contact_info' );

        $swm['set'][] = array( 'swm_cih_sicons_bg', '#f5f5f5', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_cih_sicons_bg', 'color', esc_html__( 'Background /Border Color', 'bizix' ), 'swm_header_contact_info' );

        $swm['set'][] = array( 'swm_cih_sicons_col_hover', '#ffffff', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_cih_sicons_col_hover', 'color', esc_html__( 'Hover Text Color', 'bizix' ), 'swm_header_contact_info' );

        $swm['set'][] = array( 'swm_cih_sicons_bg_hover', '#d83030', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_cih_sicons_bg_hover', 'color', esc_html__( 'Hover Background / Border Color', 'bizix' ), 'swm_header_contact_info' );

    } // end enabled panel

    if ( isset( $swm_enabled_panels['sub_header'] ) ) {

        /* ******************************************************************** */
        /* SUB HEADER OPTIONS */
        /* ******************************************************************** */

        $swm['set'][]  = array( 'swm_sub_header_on','on' );
        $swm['ctrl'][] = array( 'swm_sub_header_on', 'radio-switch', esc_html__( 'Sub Header', 'bizix' ), 'swm_sub_header_options' );

        $swm['set'][]  = array( 'swm_sub_header_above_header_on','off' );
        $swm['ctrl'][] = array( 'swm_sub_header_above_header_on', 'radio-switch', esc_html__( 'Move Sub Heder Above Header and Topbar', 'bizix' ), 'swm_sub_header_options' );

        $swm['set'][]  = array( 'swm_sub_header_height_d', 500, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_sub_header_height_d', 'slider', esc_html__( 'Height (Desktop)', 'bizix' ), $zero_to_thousand, 'swm_sub_header_options' );

        $swm['set'][]  = array( 'swm_sub_header_height_t', 400, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_sub_header_height_t', 'slider', esc_html__( 'Height (Tablet)', 'bizix' ), $zero_to_thousand, 'swm_sub_header_options' );

        $swm['set'][]  = array( 'swm_sub_header_height_m', 300, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_sub_header_height_m', 'slider', esc_html__( 'Height (Mobile)', 'bizix' ), $zero_to_thousand, 'swm_sub_header_options' );

        // Sub Header Background
        $swm['set'][]  = array( 'swm_sub_header_bg_color', '#343a40', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_sub_header_bg_color', 'color', esc_html__( 'Background Color', 'bizix' ), 'swm_sub_header_options' );

        $swm['set'][]  = array( 'swm_sub_header_bg_img', '', 'swm_sanitize_image' );
        $swm['ctrl'][] = array( 'swm_sub_header_bg_img', 'image', esc_html__( 'Background Image', 'bizix' ), 'swm_sub_header_options' );

        $swm['set'][]  = array( 'swm_sub_header_bg_style', 'cover' );
        $swm['ctrl'][] = array( 'swm_sub_header_bg_style', 'select', esc_html__( 'Background Image Style', 'bizix' ), swm_get_bg_img_styles(), 'swm_sub_header_options' );

        // Sub Header Title
        $swm['set'][]  = array( 'swm_sub_header_title_on','on' );
        $swm['ctrl'][] = array( 'swm_sub_header_title_on', 'radio-switch', esc_html__( 'Title Text', 'bizix' ), 'swm_sub_header_options' );

        $swm['set'][]  = array( 'swm_sub_header_title_position', 'title-center' );
        $swm['ctrl'][] = array( 'swm_sub_header_title_position', 'select', esc_html__( 'Title Position', 'bizix' ), swm_sub_header_title_options(), 'swm_sub_header_options' );

        $swm['set'][]  = array( 'swm_sub_header_title_color', '#ffffff', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_sub_header_title_color', 'color', esc_html__( 'Title Text Color', 'bizix' ), 'swm_sub_header_options' );

        $swm['set'][]  = array( 'swm_sub_header_title_font_size_d', 55, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_sub_header_title_font_size_d', 'slider', esc_html__( 'Font Size (Desktop) ', 'bizix' ), $swm_font_size, 'swm_sub_header_options' );

        $swm['set'][]  = array( 'swm_sub_header_title_font_size_t', 45, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_sub_header_title_font_size_t', 'slider', esc_html__( 'Font Size (Tablet) ', 'bizix' ), $swm_font_size, 'swm_sub_header_options' );

        $swm['set'][]  = array( 'swm_sub_header_title_font_size_m', 27, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_sub_header_title_font_size_m', 'slider', esc_html__( 'Font Size (Mobile) ', 'bizix' ), $swm_font_size, 'swm_sub_header_options' );

        $swm['set'][]  = array( 'swm_sub_header_title_transform', 'none' );
        $swm['ctrl'][] = array( 'swm_sub_header_title_transform', 'buttontab', esc_html__( 'Title Text Transform', 'bizix' ),swm_text_transform(), 'swm_sub_header_options' );

        $swm['set'][]  = array( 'swm_sub_header_breadcrumb_on','on' );
        $swm['ctrl'][] = array( 'swm_sub_header_breadcrumb_on', 'radio-switch', esc_html__( 'Breadcrumbs', 'bizix' ), 'swm_sub_header_options' );

        $swm['set'][]  = array( 'swm_sub_header_breadcrumb_font_size', 16, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_sub_header_breadcrumb_font_size', 'slider', esc_html__( 'Breadcrumbs Font Size', 'bizix' ), $swm_font_size, 'swm_sub_header_options' );

        $swm['set'][]  = array( 'swm_sub_header_breadcrumb_transform', 'none' );
        $swm['ctrl'][] = array( 'swm_sub_header_breadcrumb_transform', 'buttontab', esc_html__( 'Breadcrumbs Text Transform', 'bizix' ),swm_text_transform(), 'swm_sub_header_options' );

        $swm['set'][]  = array( 'swm_breadcrumbs_text_color', '#ffffff', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_breadcrumbs_text_color', 'color', esc_html__( 'Breadcrumbs Text Color', 'bizix' ), 'swm_sub_header_options' );

        $swm['set'][]  = array( 'swm_breadcrumbs_text_hover_color', '#ffffff', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_breadcrumbs_text_hover_color', 'color', esc_html__( 'Breadcrumbs Text Hover Color', 'bizix' ), 'swm_sub_header_options' );

        $swm['set'][]  = array( 'swm_breadcrumbs_icons_color', '#ffffff', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_breadcrumbs_icons_color', 'color', esc_html__( 'Breadcrumbs Icons Color', 'bizix' ), 'swm_sub_header_options' );

        $swm['set'][]  = array( 'swm_breadcrumbs_hide_device', '' );
        $swm['ctrl'][] = array( 'swm_breadcrumbs_hide_device', 'select', esc_html__( 'Hide Breadcrumbs At', 'bizix' ), swm_hide_tablet_mobile(), 'swm_sub_header_options' );

    } // end enabled panel

    if ( isset( $swm_enabled_panels['sidebar'] ) ) {

        /* ******************************************************************** */
        /* SIDEBAR OPTIONS */
        /* ******************************************************************** */

        $swm['set'][]  = array( 'swm_sidebar_text_size', 15, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_sidebar_text_size', 'slider', esc_html__( 'Text Size', 'bizix' ), $swm_font_size, 'swm_sidebar_section' );

        $swm['set'][]  = array( 'swm_sidebar_text_col', '#676767', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_sidebar_text_col', 'color', esc_html__( 'Text Color', 'bizix' ), 'swm_sidebar_section' );

        $swm['set'][]  = array( 'swm_sidebar_link', '#676767', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_sidebar_link', 'color', esc_html__( 'Link Color', 'bizix' ), 'swm_sidebar_section' );

        $swm['set'][]  = array( 'swm_sidebar_link_hover', '#d83030', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_sidebar_link_hover', 'color', esc_html__( 'Link Hover Color', 'bizix' ), 'swm_sidebar_section' );

        $swm['set'][]  = array( 'swm_sidebar_border_color', '#dcdcdc', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_sidebar_border_color', 'color', esc_html__( 'Elements Borders Color', 'bizix' ), 'swm_sidebar_section' );

        $swm['set'][]  = array( 'swm_sidebar_widget_box_bg', '#f6f3ee', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_sidebar_widget_box_bg', 'color', esc_html__( 'Widget Box Background', 'bizix' ), 'swm_sidebar_section' );

        $swm['set'][]  = array( 'swm_sticky_sidebar_on','on' );
        $swm['ctrl'][] = array( 'swm_sticky_sidebar_on', 'radio-switch', esc_html__( 'Sticky Sidebar', 'bizix' ), 'swm_sidebar_section' );

        // title

        $swm['set'][]  = array( 'swm_sidebar_title_color', '#032e42', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_sidebar_title_color', 'color', esc_html__( 'Title Text Color', 'bizix' ), 'swm_sidebar_section' );

        $swm['set'][]  = array( 'swm_sidebar_title_border_color', '#d83030', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_sidebar_title_border_color', 'color', esc_html__( 'Title Border Color', 'bizix' ), 'swm_sidebar_section' );

        $swm['set'][]  = array( 'swm_sidebar_title_transform', 'uppercase' );
        $swm['ctrl'][] = array( 'swm_sidebar_title_transform', 'buttontab', esc_html__( 'Title Text Transform', 'bizix' ), swm_text_transform(), 'swm_sidebar_section' );

        $swm['set'][]  = array( 'swm_sidebar_title_size', 19, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_sidebar_title_size', 'slider', esc_html__( 'Title Text Size', 'bizix' ), $swm_font_size, 'swm_sidebar_section' );

        $swm['set'][]  = array( 'swm_sidebar_title_letter_space', 0, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_sidebar_title_letter_space', 'slider', esc_html__( 'Title Letter Spacing', 'bizix' ), $swm_letter_space, 'swm_sidebar_section' );

    } // end enabled panel

    if ( isset( $swm_enabled_panels['footer'] ) ) {

        /* ******************************************************************** */
        /* FOOTER OPTIONS */
        /* ******************************************************************** */

        // Widget Footer

        $swm['set'][]  = array( 'swm_widget_footer_on','on' );
        $swm['ctrl'][] = array( 'swm_widget_footer_on', 'radio-switch', esc_html__( 'Widget Footer', 'bizix' ), 'swm_footer_widget' );

        $swm['set'][]  = array( 'swm_widget_footer_text_size', 15, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_widget_footer_text_size', 'slider', esc_html__( 'Font Size', 'bizix' ), $swm_font_size, 'swm_footer_widget' );

        $swm['set'][]  = array( 'swm_widget_footer_line_height', 30, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_widget_footer_line_height', 'slider', esc_html__( 'Line Height', 'bizix' ), $swm_font_size, 'swm_footer_widget' );

        $swm['set'][]  = array( 'swm_widget_footer_space', 30, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_widget_footer_space', 'slider', esc_html__( 'Space Between Two Widgets', 'bizix' ), $zero_to_two_hundred, 'swm_footer_widget' );

        $swm['set'][] = array( 'swm_widget_footer_column', 'col-4' );
        $swm['ctrl'][] = array( 'swm_widget_footer_column', 'radio-image', esc_html__( 'Select Column Style', 'bizix' ), $swm_widget_footer_column, 'swm_footer_widget' );

        $swm['set'][]  = array( 'swm_widget_footer_bg_color', '#252628', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_widget_footer_bg_color', 'color', esc_html__( 'Primary Background Color', 'bizix' ), 'swm_footer_widget' );

        $swm['set'][]  = array( 'swm_widget_footer_bg_color_two', '#1c1d1f', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_widget_footer_bg_color_two', 'color', esc_html__( 'Secondary Background Color', 'bizix' ), 'swm_footer_widget' );

        $swm['set'][]  = array( 'swm_widget_footer_border_color', '#343538', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_widget_footer_border_color', 'color', esc_html__( 'Elements Border Color', 'bizix' ), 'swm_footer_widget' );

        $swm['set'][]  = array( 'swm_widget_footer_text_color', '#bbbbbb', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_widget_footer_text_color', 'color', esc_html__( 'Text Color', 'bizix' ), 'swm_footer_widget' );

        $swm['set'][]  = array( 'swm_widget_footer_links_color', '#bbbbbb', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_widget_footer_links_color', 'color', esc_html__( 'Links Color', 'bizix' ), 'swm_footer_widget' );

        $swm['set'][]  = array( 'swm_widget_footer_links_hover_color', '#ffffff', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_widget_footer_links_hover_color', 'color', esc_html__( 'Links Hover Color', 'bizix' ), 'swm_footer_widget' );

        $swm['set'][]  = array( 'swm_widget_footer_rp_links_color', '#bbbbbb', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_widget_footer_rp_links_color', 'color', esc_html__( 'Custom Recent Posts - Link Color', 'bizix' ), 'swm_footer_widget' );

        $swm['set'][]  = array( 'swm_widget_footer_title_color', '#ffffff', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_widget_footer_title_color', 'color', esc_html__( 'Widget Title Text Color', 'bizix' ), 'swm_footer_widget' );

        $swm['set'][]  = array( 'swm_widget_footer_bg_img', '', 'swm_sanitize_image' );
        $swm['ctrl'][] = array( 'swm_widget_footer_bg_img', 'image', esc_html__( 'Background Image', 'bizix' ), 'swm_footer_widget' );

        $swm['set'][]  = array( 'swm_widget_footer_bg_style', 'cover' );
        $swm['ctrl'][] = array( 'swm_widget_footer_bg_style', 'select', esc_html__( 'Background Image Style', 'bizix' ), swm_get_bg_img_styles(), 'swm_footer_widget' );

        $swm['set'][]  = array( 'swm_widget_footer_title_transform', 'none' );
        $swm['ctrl'][] = array( 'swm_widget_footer_title_transform', 'buttontab', esc_html__( 'Widget Title Text Transform', 'bizix' ),swm_text_transform(), 'swm_footer_widget' );

        $swm['set'][]  = array( 'swm_widget_footer_title_size', 20, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_widget_footer_title_size', 'slider', esc_html__( 'Widget Title Text Size', 'bizix' ), $swm_font_size, 'swm_footer_widget' );

        $swm['set'][]  = array( 'swm_widget_footer_title_letter_space', 0, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_widget_footer_title_letter_space', 'slider', esc_html__( 'Widget Title Letter Spacing', 'bizix' ), $swm_letter_space, 'swm_footer_widget' );

        $swm['set'][]  = array( 'swm_widget_footer_title_lineheight', 30, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_widget_footer_title_lineheight', 'slider', esc_html__( 'Widget Title Line Height', 'bizix' ), $zero_to_hundred, 'swm_footer_widget' );

        // Contact Footer

        $swm['set'][]  = array( 'swm_contact_footer_on','off' );
        $swm['ctrl'][] = array( 'swm_contact_footer_on', 'radio-switch', esc_html__( 'Contact Footer', 'bizix' ), 'swm_contact_footer' );

        $swm['set'][] = array( 'swm_cf_column','3','','postMessage' );
        $swm['ctrl'][] = array( 'swm_cf_column', 'buttontab', esc_html__( 'Display Column', 'bizix' ),$swm_footer_column_three, 'swm_contact_footer' );

        $swm['set'][] = array( 'swm_cf_email', 'info@example.com', 'swm_sanitize_simple_text','postMessage' );
        $swm['ctrl'][] = array( 'swm_cf_email', 'text', esc_html__( 'Email Id', 'bizix' ), 'swm_contact_footer' );

        $swm['set'][] = array( 'swm_cf_email_s_title', 'Drop Us a Line', 'swm_sanitize_simple_text','postMessage' );
        $swm['ctrl'][] = array( 'swm_cf_email_s_title', 'text', esc_html__( 'Email Id Sub Title', 'bizix' ), 'swm_contact_footer' );

        $swm['set'][] = array( 'swm_cf_call', '+1 (888) 456 7890', 'swm_sanitize_simple_text','postMessage' );
        $swm['ctrl'][] = array( 'swm_cf_call', 'text', esc_html__( 'Phone No.', 'bizix' ), 'swm_contact_footer' );

        $swm['set'][] = array( 'swm_cf_call_s_title', 'Call Us Now', 'swm_sanitize_simple_text','postMessage' );
        $swm['ctrl'][] = array( 'swm_cf_call_s_title', 'text', esc_html__( 'Phone No. Sub Title', 'bizix' ), 'swm_contact_footer' );

        $swm['set'][] = array( 'swm_cf_address', '65 St. Road, NY USA', 'swm_sanitize_simple_text','postMessage' );
        $swm['ctrl'][] = array( 'swm_cf_address', 'text', esc_html__( 'Address', 'bizix' ), 'swm_contact_footer' );

        $swm['set'][] = array( 'swm_cf_address_s_title', 'Get Direction', 'swm_sanitize_simple_text','postMessage' );
        $swm['ctrl'][] = array( 'swm_cf_address_s_title', 'text', esc_html__( 'Address Sub Title', 'bizix' ), 'swm_contact_footer' );

        $swm['set'][] = array( 'swm_cf_text_color', '#ffffff', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_cf_text_color', 'color', esc_html__( 'Contact Footer Text Color', 'bizix' ), 'swm_contact_footer' );

        $swm['set'][] = array( 'swm_cf_bg_1', '#191a1c', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_cf_bg_1', 'color', esc_html__( 'Contact Footer Box Background 1', 'bizix' ), 'swm_contact_footer' );

        $swm['set'][] = array( 'swm_cf_bg_2', '#d83030', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_cf_bg_2', 'color', esc_html__( 'Contact Footer Box Background 2', 'bizix' ), 'swm_contact_footer' );

        // Small Footer
        $swm['set'][]  = array( 'swm_small_footer_on','on','' );
        $swm['ctrl'][] = array( 'swm_small_footer_on', 'radio-switch', esc_html__( 'Small Footer', 'bizix' ), 'swm_footer_small' );

        $swm['set'][]  = array( 'swm_small_footer_copyright', 'Copyright 2020 Bizix, All rights reserved.', 'wp_kses_post', 'postMessage' );
        $swm['ctrl'][] = array( 'swm_small_footer_copyright', 'textarea', esc_html__( 'Company Name 2020 - All Rights Reserved.', 'bizix' ), 'swm_footer_small' );

        $swm['set'][]  = array( 'swm_small_footer_text_size', 15, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_small_footer_text_size', 'slider', esc_html__( 'Font Size', 'bizix' ), $swm_font_size, 'swm_footer_small' );

        $swm['set'][]  = array( 'swm_small_footer_text_color', '#aaaaaa', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_small_footer_text_color', 'color', esc_html__( 'Text Color', 'bizix' ), 'swm_footer_small' );

        $swm['set'][]  = array( 'swm_small_footer_link_color', '#aaaaaa', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_small_footer_link_color', 'color', esc_html__( 'Text Link Color', 'bizix' ), 'swm_footer_small' );

        $swm['set'][]  = array( 'swm_small_footer_link_h_color', '#ffffff', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_small_footer_link_h_color', 'color', esc_html__( 'Text Link Hover Color', 'bizix' ), 'swm_footer_small' );

        $swm['set'][]  = array( 'swm_small_footer_top_border_color', '#3b3c3f', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_small_footer_top_border_color', 'color', esc_html__( 'Top Border Color', 'bizix' ), 'swm_footer_small' );

    } // end enabled panel

    if ( isset( $swm_enabled_panels['fonts'] ) ) {

        /* ******************************************************************** */
        /* FONTS OPTIONS */
        /* ******************************************************************** */

        $swm['set'][]  = array( 'swm_google_font_weight_list', swm_google_fonts_weight(), 'postMessage' );

        $swm['set'][]  = array( 'swm_google_fonts_on', 'on' );
        $swm['ctrl'][] = array( 'swm_google_fonts_on', 'radio-switch', esc_html__( 'Activate Google Fonts', 'bizix' ), 'swm_fonts_options' );

        $swm['set'][]  = array( 'swm_google_fonts_subset_on', 'off' );
        $swm['ctrl'][] = array( 'swm_google_fonts_subset_on', 'radio-switch', esc_html__( 'Fonts Subsets', 'bizix' ), 'swm_fonts_options' );

        $swm['set'][]  = array( 'swm_google_font_subset_cyrillic', 'off' );
        $swm['ctrl'][] = array( 'swm_google_font_subset_cyrillic', 'radio-switch', esc_html__( 'Cyrillic', 'bizix' ), 'swm_fonts_options' );

        $swm['set'][]  = array( 'swm_google_font_subset_greek', 'off' );
        $swm['ctrl'][] = array( 'swm_google_font_subset_greek', 'radio-switch', esc_html__( 'Greek', 'bizix' ), 'swm_fonts_options' );

        $swm['set'][]  = array( 'swm_google_font_subset_vietnamese', 'off' );
        $swm['ctrl'][] = array( 'swm_google_font_subset_vietnamese', 'radio-switch', esc_html__( 'Vietnamese', 'bizix' ), 'swm_fonts_options' );

        $swm['set'][]  = array( 'swm_body_font_size', 16, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_body_font_size', 'slider', esc_html__( 'Font Size', 'bizix' ), $swm_font_size, 'swm_fonts_options' );

        $swm['set'][]  = array( 'swm_body_font_lineheight', 1.7, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_body_font_lineheight', 'slider', esc_html__( 'Line Height', 'bizix' ), $swm_line_height, 'swm_fonts_options' );

        $swm['set'][]  = array( 'swm_body_font_family', 'Roboto' );
        $swm['ctrl'][] = array( 'swm_body_font_family', 'select', esc_html__( 'Font Family', 'bizix' ), swm_google_fonts_list(), 'swm_fonts_options' );

        $swm['set'][]  = array( 'swm_body_font_weight', '400' );
        $swm['ctrl'][] = array( 'swm_body_font_weight', 'radio', esc_html__( 'Font Weight', 'bizix' ), swm_fonts_all_weights(), 'swm_fonts_options' );

        $swm['set'][]  = array( 'swm_body_font_weight_medium', 'on' );
        $swm['ctrl'][] = array( 'swm_body_font_weight_medium', 'radio-switch', esc_html__( 'Medium', 'bizix' ), 'swm_fonts_options' );

        $swm['set'][]  = array( 'swm_body_font_weight_semi_bold', 'on' );
        $swm['ctrl'][] = array( 'swm_body_font_weight_semi_bold', 'radio-switch', esc_html__( 'Semi Bold', 'bizix' ), 'swm_fonts_options' );

        $swm['set'][]  = array( 'swm_body_font_weight_bold', 'on' );
        $swm['ctrl'][] = array( 'swm_body_font_weight_bold', 'radio-switch', esc_html__( 'Bold', 'bizix' ), 'swm_fonts_options' );

        $swm['set'][]  = array( 'swm_nav_font_family', 'Roboto' );
        $swm['ctrl'][] = array( 'swm_nav_font_family', 'select', esc_html__( 'Font Family', 'bizix' ), swm_google_fonts_list(), 'swm_fonts_options' );

        $swm['set'][]  = array( 'swm_nav_font_weight', '600' );
        $swm['ctrl'][] = array( 'swm_nav_font_weight', 'radio', esc_html__( 'Font Weight', 'bizix' ), swm_fonts_all_weights(), 'swm_fonts_options' );

        $swm['set'][]  = array( 'swm_header_title_font_family', 'Fira Sans' );
        $swm['ctrl'][] = array( 'swm_header_title_font_family', 'select', esc_html__( 'Font Family', 'bizix' ), swm_google_fonts_list(), 'swm_fonts_options' );

        $swm['set'][]  = array( 'swm_header_title_font_weight', '700' );
        $swm['ctrl'][] = array( 'swm_header_title_font_weight', 'radio', esc_html__( 'Font Weight', 'bizix' ), swm_fonts_all_weights(), 'swm_fonts_options' );

        $swm['set'][]  = array( 'swm_widget_title_font_family', 'Fira Sans' );
        $swm['ctrl'][] = array( 'swm_widget_title_font_family', 'select', esc_html__( 'Font Family', 'bizix' ), swm_google_fonts_list(), 'swm_fonts_options' );

        $swm['set'][]  = array( 'swm_widget_title_font_weight', '700' );
        $swm['ctrl'][] = array( 'swm_widget_title_font_weight', 'radio', esc_html__( 'Font Weight', 'bizix' ), swm_fonts_all_weights(), 'swm_fonts_options' );

        $swm['set'][]  = array( 'swm_headings_font_family', 'Fira Sans' );
        $swm['ctrl'][] = array( 'swm_headings_font_family', 'select', esc_html__( 'Font Family', 'bizix' ), swm_google_fonts_list(), 'swm_fonts_options' );

        $swm['set'][]  = array( 'swm_headings_font_weight', '700' );
        $swm['ctrl'][] = array( 'swm_headings_font_weight', 'radio', esc_html__( 'Font Weight', 'bizix' ), swm_fonts_all_weights(), 'swm_fonts_options' );

        $swm['set'][]  = array( 'swm_h1_font_size', 40, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_h1_font_size', 'slider', esc_html__( 'Heading H1 - Font Size', 'bizix' ), $swm_font_size, 'swm_fonts_options' );

        $swm['set'][]  = array( 'swm_h2_font_size', 33, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_h2_font_size', 'slider', esc_html__( 'Heading H2 - Font Size', 'bizix' ), $swm_font_size, 'swm_fonts_options' );

        $swm['set'][]  = array( 'swm_h3_font_size', 29, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_h3_font_size', 'slider', esc_html__( 'Heading H3 - Font Size', 'bizix' ), $swm_font_size, 'swm_fonts_options' );

        $swm['set'][]  = array( 'swm_h4_font_size', 25, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_h4_font_size', 'slider', esc_html__( 'Heading H4 - Font Size', 'bizix' ), $swm_font_size, 'swm_fonts_options' );

        $swm['set'][]  = array( 'swm_h5_font_size', 22, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_h5_font_size', 'slider', esc_html__( 'Heading H5 - Font Size', 'bizix' ), $swm_font_size, 'swm_fonts_options' );

        $swm['set'][]  = array( 'swm_h6_font_size', 19, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_h6_font_size', 'slider', esc_html__( 'Heading H6 - Font Size', 'bizix' ), $swm_font_size, 'swm_fonts_options' );

        $swm['set'][]  = array( 'swm_h1_font_lineheight', 55, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_h1_font_lineheight', 'slider', esc_html__( 'Heading H1 - Line Height', 'bizix' ), $swm_font_size, 'swm_fonts_options' );

        $swm['set'][]  = array( 'swm_h2_font_lineheight', 50, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_h2_font_lineheight', 'slider', esc_html__( 'Heading H2 - Line Height', 'bizix' ), $swm_font_size, 'swm_fonts_options' );

        $swm['set'][]  = array( 'swm_h3_font_lineheight', 40, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_h3_font_lineheight', 'slider', esc_html__( 'Heading H3 - Line Height', 'bizix' ), $swm_font_size, 'swm_fonts_options' );

        $swm['set'][]  = array( 'swm_h4_font_lineheight', 36, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_h4_font_lineheight', 'slider', esc_html__( 'Heading H4 - Line Height', 'bizix' ), $swm_font_size, 'swm_fonts_options' );

        $swm['set'][]  = array( 'swm_h5_font_lineheight', 30, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_h5_font_lineheight', 'slider', esc_html__( 'Heading H5 - Line Height', 'bizix' ), $swm_font_size, 'swm_fonts_options' );

        $swm['set'][]  = array( 'swm_h6_font_lineheight', 25, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_h6_font_lineheight', 'slider', esc_html__( 'Heading H6 - Line Height', 'bizix' ), $swm_font_size, 'swm_fonts_options' );

    } // end enabled panel

    if ( isset( $swm_enabled_panels['page'] ) ) {

        /* ******************************************************************** */
        /* PAGE OPTIONS */
        /* ******************************************************************** */

        $swm['set'][]  = array( 'swm_page_comments_on','on' );
        $swm['ctrl'][] = array( 'swm_page_comments_on', 'radio-switch', esc_html__( 'Display Comments in Pages', 'bizix' ), 'swm_page_options' );

    } // end enabled panel

    if ( isset( $swm_enabled_panels['blog'] ) ) {

        /* ******************************************************************** */
        /* BLOG OPTIONS */
        /* ******************************************************************** */

        $swm['set'][]  = array( 'swm_blog_page_layout', 'layout-sidebar-right' );
        $swm['ctrl'][] = array( 'swm_blog_page_layout', 'select', esc_html__( 'Blog Page Layout', 'bizix' ), swm_page_content_layout(), 'swm_blog_section' );

        $swm['set'][]  = array( 'swm_featured_img_height','580', 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_featured_img_height', 'text', esc_html__( 'Featured Image Height (Only Number)', 'bizix' ), 'swm_blog_section' );

        $swm['set'][]  = array( 'swm_featured_fullwidth_img_height','580', 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_featured_fullwidth_img_height', 'text', esc_html__( 'Fullwidth Featured Image Height', 'bizix' ), 'swm_blog_section' );

        $swm['set'][]  = array( 'swm_home_blog_header','on' );
        $swm['ctrl'][] = array( 'swm_home_blog_header', 'radio-switch', esc_html__( 'Sub Header', 'bizix' ), 'swm_blog_section' );

        $swm['set'][]  = array( 'swm_home_blog_header_style', 'standard' );
        $swm['ctrl'][] = array( 'swm_home_blog_header_style', 'buttontab', esc_html__( 'Header Style', 'bizix' ), swm_header_display_style(), 'swm_blog_section' );

        $swm['set'][]  = array( 'swm_header_rev_slider_shortcode','' );
        $swm['ctrl'][] = array( 'swm_header_rev_slider_shortcode', 'revslider-select', esc_html__( 'Revolution Slider', 'bizix' ), 'swm_blog_section' );

        //post title and databox
        $swm['set'][]  = array( 'swm_post_title_color', '#032e42', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_post_title_color', 'color', esc_html__( 'Title Color', 'bizix' ), 'swm_blog_section' );

        $swm['set'][]  = array( 'swm_post_title_hover_color', '#d83030', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_post_title_hover_color', 'color', esc_html__( 'Title Hover Color', 'bizix' ), 'swm_blog_section' );

        $swm['set'][]  = array( 'swm_post_title_size', 30, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_post_title_size', 'slider', esc_html__( 'Text Size', 'bizix' ), $swm_font_size, 'swm_blog_section' );

        $swm['set'][]  = array( 'swm_post_title_letter_space', 0, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_post_title_letter_space', 'slider', esc_html__( 'Letter Spacing', 'bizix' ), $swm_letter_space, 'swm_blog_section' );

        $swm['set'][]  = array( 'swm_post_title_lineheight', 44, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_post_title_lineheight', 'slider', esc_html__( 'Line Height', 'bizix' ), $zero_to_hundred, 'swm_blog_section' );

        $swm['set'][]  = array( 'swm_post_title_transform', 'none' );
        $swm['ctrl'][] = array( 'swm_post_title_transform', 'buttontab', esc_html__( 'Text Transform', 'bizix' ),swm_text_transform(), 'swm_blog_section' );

        // on-off post meta
        $swm['set'][]  = array( 'swm_date_on','on' );
        $swm['ctrl'][] = array( 'swm_date_on', 'radio-switch', esc_html__( 'Date', 'bizix' ), 'swm_blog_section' );

        $swm['set'][]  = array( 'swm_author_name_on','on' );
        $swm['ctrl'][] = array( 'swm_author_name_on', 'radio-switch', esc_html__( 'Author Name', 'bizix' ), 'swm_blog_section' );

        $swm['set'][]  = array( 'swm_cats_on','off' );
        $swm['ctrl'][] = array( 'swm_cats_on', 'radio-switch', esc_html__( 'Category Names', 'bizix' ), 'swm_blog_section' );

        $swm['set'][]  = array( 'swm_comments_on','on' );
        $swm['ctrl'][] = array( 'swm_comments_on', 'radio-switch', esc_html__( 'Comments', 'bizix' ), 'swm_blog_section' );

        if ( GYAN_ELEMENTS_IS_ACTIVE ) {

            $swm['set'][]  = array( 'swm_views_on','on' );
            $swm['ctrl'][] = array( 'swm_views_on', 'radio-switch', esc_html__( 'Views', 'bizix' ), 'swm_blog_section' );

            $swm['set'][]  = array( 'swm_likes_on','on' );
            $swm['ctrl'][] = array( 'swm_likes_on', 'radio-switch', esc_html__( 'Likes', 'bizix' ), 'swm_blog_section' );

        }

        $swm['set'][]  = array( 'swm_post_button_text','Read More', 'swm_sanitize_simple_text' );
        $swm['ctrl'][] = array( 'swm_post_button_text', 'text', esc_html__( 'Readmore Button Text', 'bizix' ), 'swm_blog_section' );

        $swm['set'][]  = array( 'swm_excerpt_on','on' );
        $swm['ctrl'][] = array( 'swm_excerpt_on', 'radio-switch', esc_html__( 'Excerpt', 'bizix' ), 'swm_blog_section' );

        $swm['set'][]  = array( 'swm_excerpt_length','50', 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_excerpt_length', 'text', esc_html__( 'Excerpt Length', 'bizix' ), 'swm_blog_section' );

        //archive page
        $swm['set'][]  = array( 'swm_archives_sidebar', 'blog-sidebar' );
        $swm['ctrl'][] = array( 'swm_archives_sidebar', 'sidebar-select', esc_html__( 'Select Sidebar Name', 'bizix' ), 'swm_blog_section' );

        /* ******************************************************************** */
        /* BLOG SINGLE OPTIONS */
        /* ******************************************************************** */

        $swm['set'][]  = array( 'swm_blog_single_header_title','Blog', 'swm_sanitize_simple_text' );
        $swm['ctrl'][] = array( 'swm_blog_single_header_title', 'text', esc_html__( 'Header Title Text', 'bizix' ), 'swm_blog_single_section' );

        $swm['set'][]  = array( 'swm_blog_page_url','#','swm_sanitize_url' );
        $swm['ctrl'][] = array( 'swm_blog_page_url', 'text', esc_html__( 'Blog Page URL for Breadcrumbs', 'bizix' ), 'swm_blog_single_section' );

        //post title
        $swm['set'][]  = array( 'swm_single_post_title_size', 30, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_single_post_title_size', 'slider', esc_html__( 'Text Size', 'bizix' ), $swm_font_size, 'swm_blog_single_section' );

        $swm['set'][]  = array( 'swm_single_post_title_letter_space', 0, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_single_post_title_letter_space', 'slider', esc_html__( 'Letter Spacing', 'bizix' ), $swm_letter_space, 'swm_blog_single_section' );

        $swm['set'][]  = array( 'swm_single_post_title_lineheight', 40, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_single_post_title_lineheight', 'slider', esc_html__( 'Line Height', 'bizix' ), $zero_to_hundred, 'swm_blog_single_section' );

        $swm['set'][]  = array( 'swm_single_post_title_transform', 'none' );
        $swm['ctrl'][] = array( 'swm_single_post_title_transform', 'buttontab', esc_html__( 'Text Transform', 'bizix' ),swm_text_transform(), 'swm_blog_single_section' );

        // on-off post meta
        $swm['set'][]  = array( 'swm_single_date_on','on' );
        $swm['ctrl'][] = array( 'swm_single_date_on', 'radio-switch', esc_html__( 'Date', 'bizix' ), 'swm_blog_single_section' );

        $swm['set'][]  = array( 'swm_single_author_name_on','on' );
        $swm['ctrl'][] = array( 'swm_single_author_name_on', 'radio-switch', esc_html__( 'Author Name', 'bizix' ), 'swm_blog_single_section' );

        $swm['set'][]  = array( 'swm_single_cats_on','on' );
        $swm['ctrl'][] = array( 'swm_single_cats_on', 'radio-switch', esc_html__( 'Category Names', 'bizix' ), 'swm_blog_single_section' );

        if ( GYAN_ELEMENTS_IS_ACTIVE ) {

            $swm['set'][]  = array( 'swm_single_views_on','on' );
            $swm['ctrl'][] = array( 'swm_single_views_on', 'radio-switch', esc_html__( 'Views', 'bizix' ), 'swm_blog_single_section' );

            $swm['set'][]  = array( 'swm_single_likes_on','on' );
            $swm['ctrl'][] = array( 'swm_single_likes_on', 'radio-switch', esc_html__( 'Likes', 'bizix' ), 'swm_blog_single_section' );

        }

        $swm['set'][]  = array( 'swm_single_tags_on','on' );
        $swm['ctrl'][] = array( 'swm_single_tags_on', 'radio-switch', esc_html__( 'Tags', 'bizix' ), 'swm_blog_single_section' );

        $swm['set'][]  = array( 'swm_single_comments_on','on' );
        $swm['ctrl'][] = array( 'swm_single_comments_on', 'radio-switch', esc_html__( 'Comments', 'bizix' ), 'swm_blog_single_section' );

        // on-off post sections
        $swm['set'][]  = array( 'swm_single_authorbox_on','off' );
        $swm['ctrl'][] = array( 'swm_single_authorbox_on', 'radio-switch', esc_html__( 'Author Bio', 'bizix' ), 'swm_blog_single_section' );

        $swm['set'][]  = array( 'swm_single_pagination_on','on' );
        $swm['ctrl'][] = array( 'swm_single_pagination_on', 'radio-switch', esc_html__( 'Next Prev Post Pagination', 'bizix' ), 'swm_blog_single_section' );

        $swm['set'][]  = array( 'swm_single_comments_section_on','on' );
        $swm['ctrl'][] = array( 'swm_single_comments_section_on', 'radio-switch', esc_html__( 'Post Comments', 'bizix' ), 'swm_blog_single_section' );

        $swm['set'][]  = array( 'swm_single_related_posts_on','on' );
        $swm['ctrl'][] = array( 'swm_single_related_posts_on', 'radio-switch', esc_html__( 'Related Posts', 'bizix' ), 'swm_blog_single_section' );

        $swm['set'][] = array( 'swm_single_related_posts_column','2' );
        $swm['ctrl'][] = array( 'swm_single_related_posts_column', 'buttontab', esc_html__( 'Display Column for Related Posts', 'bizix' ),$swm_one_to_four_column, 'swm_blog_single_section' );

        $swm['set'][]  = array( 'swm_single_related_posts_number', 2, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_single_related_posts_number', 'slider', esc_html__( 'Number of Related Posts', 'bizix' ), $swm_one_to_twenty, 'swm_blog_single_section' );

        // sections title
        $swm['set'][]  = array( 'swm_post_single_section_ttl_col', '#032e42', 'swm_sanitize_hex_color' );
        $swm['ctrl'][] = array( 'swm_post_single_section_ttl_col', 'color', esc_html__( 'Color', 'bizix' ), 'swm_blog_single_section' );

        $swm['set'][]  = array( 'swm_post_single_section_ttl_size', 25, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_post_single_section_ttl_size', 'slider', esc_html__( 'Text Size', 'bizix' ), $swm_font_size, 'swm_blog_single_section' );

        $swm['set'][]  = array( 'swm_post_single_section_ttl_letter_space', 0, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_post_single_section_ttl_letter_space', 'slider', esc_html__( 'Letter Spacing', 'bizix' ), $swm_letter_space, 'swm_blog_single_section' );

        $swm['set'][]  = array( 'swm_post_single_section_ttl_lineheight', 44, 'swm_sanitize_number_floatval' );
        $swm['ctrl'][] = array( 'swm_post_single_section_ttl_lineheight', 'slider', esc_html__( 'Line Height', 'bizix' ), $zero_to_hundred, 'swm_blog_single_section' );

        $swm['set'][]  = array( 'swm_post_single_section_ttl_transform', 'none' );
        $swm['ctrl'][] = array( 'swm_post_single_section_ttl_transform', 'buttontab', esc_html__( 'Text Transform', 'bizix' ),swm_text_transform(), 'swm_blog_single_section' );

        /* ******************************************************************** */
        /* BLOG CATEGORY OPTIONS */
        /* ******************************************************************** */

        $swm_get_categories = get_categories();

        if ($swm_get_categories) {

            foreach($swm_get_categories as $swm_category) {

                $swm_cname = $swm_category->slug.'_bg';
                $swm_cname_img = $swm_category->slug.'_bg_img';
                $swm_cname_title = $swm_category->slug.'_title';

                $swm['set'][]  = array( $swm_cname, '#343a40', 'swm_sanitize_hex_color' );
                $swm['ctrl'][] = array( $swm_cname, 'color', '"'.esc_attr($swm_category->name).'" Title Background', 'swm_category_section' );

                $swm['set'][]  = array( $swm_cname_title, '#ffffff', 'swm_sanitize_hex_color' );
                $swm['ctrl'][] = array( $swm_cname_title, 'color', '"'.esc_attr($swm_category->name).'" Page Header Title Color', 'swm_category_section' );

                $swm['set'][]  = array( $swm_cname_img, '','swm_sanitize_image' );
                $swm['ctrl'][] = array( $swm_cname_img, 'image', '"'.esc_attr($swm_category->name).'" Page Header Background', 'swm_category_section' );

            }
        }
    } // enable blog panel

    if ( isset( $swm_enabled_panels['portfolio'] ) ) {

        /* ******************************************************************** */
        /* PORTFOLIO PAGE OPTIONS */
        /* ******************************************************************** */

        $swm['set'][]  = array( 'swm_portfolio_page_title','Portfolio', 'swm_sanitize_simple_text' );
        $swm['ctrl'][] = array( 'swm_portfolio_page_title', 'text', esc_html__( 'Portfolio Page Title for Breadcrumbs', 'bizix' ), 'swm_portfolio_section' );

        $swm['set'][]  = array( 'swm_portfolio_page_url','#','swm_sanitize_url' );
        $swm['ctrl'][] = array( 'swm_portfolio_page_url', 'text', esc_html__( 'Portfolio Page URL for Breadcrumbs', 'bizix' ), 'swm_portfolio_section' );

        $swm['set'][]  = array( 'swm_portfolio_comments_on','off' );
        $swm['ctrl'][] = array( 'swm_portfolio_comments_on', 'radio-switch', esc_html__( 'Comments', 'bizix' ), 'swm_portfolio_section' );

    } // end enabled panel

    if ( isset( $swm_enabled_panels['social_media_icons'] ) ) {

        /* ******************************************************************** */
        /* SOCIAL ICONS */
        /* ******************************************************************** */

        $swm['set'][]  = array( 'swm_open_sm_new_window','on' );
        $swm['ctrl'][] = array( 'swm_open_sm_new_window', 'radio-switch', esc_html__( 'Open Social Sites in New Window', 'bizix' ), 'swm_social_media_icons' );

        $swm['set'][]  = array( 'swm_icon1', '', 'swm_sanitize_simple_text','postMessage' );
        $swm['ctrl'][] = array( 'swm_icon1', 'text', esc_html__( 'Icon 1', 'bizix' ), 'swm_social_media_icons' );

        $swm['set'][]  = array( 'swm_icon1_url', '','swm_sanitize_url' );
        $swm['ctrl'][] = array( 'swm_icon1_url', 'text', esc_html__( 'Icon 1 URL', 'bizix' ), 'swm_social_media_icons' );

        $swm['set'][]  = array( 'swm_icon2', '', 'swm_sanitize_simple_text','postMessage' );
        $swm['ctrl'][] = array( 'swm_icon2', 'text', esc_html__( 'Icon 2', 'bizix' ), 'swm_social_media_icons' );

        $swm['set'][]  = array( 'swm_icon2_url', '','swm_sanitize_url' );
        $swm['ctrl'][] = array( 'swm_icon2_url', 'text', esc_html__( 'Icon 2 URL', 'bizix' ), 'swm_social_media_icons' );

        $swm['set'][]  = array( 'swm_icon3', '', 'swm_sanitize_simple_text','postMessage' );
        $swm['ctrl'][] = array( 'swm_icon3', 'text', esc_html__( 'Icon 3', 'bizix' ), 'swm_social_media_icons' );

        $swm['set'][]  = array( 'swm_icon3_url', '','swm_sanitize_url' );
        $swm['ctrl'][] = array( 'swm_icon3_url', 'text', esc_html__( 'Icon 3 URL', 'bizix' ), 'swm_social_media_icons' );

        $swm['set'][]  = array( 'swm_icon4', '', 'swm_sanitize_simple_text','postMessage' );
        $swm['ctrl'][] = array( 'swm_icon4', 'text', esc_html__( 'Icon 4', 'bizix' ), 'swm_social_media_icons' );

        $swm['set'][]  = array( 'swm_icon4_url', '','swm_sanitize_url' );
        $swm['ctrl'][] = array( 'swm_icon4_url', 'text', esc_html__( 'Icon 4 URL', 'bizix' ), 'swm_social_media_icons' );

        $swm['set'][]  = array( 'swm_icon5', '', 'swm_sanitize_simple_text','postMessage' );
        $swm['ctrl'][] = array( 'swm_icon5', 'text', esc_html__( 'Icon 5', 'bizix' ), 'swm_social_media_icons' );

        $swm['set'][]  = array( 'swm_icon5_url', '','swm_sanitize_url' );
        $swm['ctrl'][] = array( 'swm_icon5_url', 'text', esc_html__( 'Icon 5 URL', 'bizix' ), 'swm_social_media_icons' );

        $swm['set'][]  = array( 'swm_icon6', '', 'swm_sanitize_simple_text','postMessage' );
        $swm['ctrl'][] = array( 'swm_icon6', 'text', esc_html__( 'Icon 6', 'bizix' ), 'swm_social_media_icons' );

        $swm['set'][]  = array( 'swm_icon6_url', '','swm_sanitize_url' );
        $swm['ctrl'][] = array( 'swm_icon6_url', 'text', esc_html__( 'Icon 6 URL', 'bizix' ), 'swm_social_media_icons' );

        $swm['set'][]  = array( 'swm_icon7', '', 'swm_sanitize_simple_text','postMessage' );
        $swm['ctrl'][] = array( 'swm_icon7', 'text', esc_html__( 'Icon 7', 'bizix' ), 'swm_social_media_icons' );

        $swm['set'][]  = array( 'swm_icon7_url', '','swm_sanitize_url' );
        $swm['ctrl'][] = array( 'swm_icon7_url', 'text', esc_html__( 'Icon 7 URL', 'bizix' ), 'swm_social_media_icons' );

        $swm['set'][]  = array( 'swm_icon8', '', 'swm_sanitize_simple_text','postMessage' );
        $swm['ctrl'][] = array( 'swm_icon8', 'text', esc_html__( 'Icon 8', 'bizix' ), 'swm_social_media_icons' );

        $swm['set'][]  = array( 'swm_icon8_url', '','swm_sanitize_url' );
        $swm['ctrl'][] = array( 'swm_icon8_url', 'text', esc_html__( 'Icon 8 URL', 'bizix' ), 'swm_social_media_icons' );

        $swm['set'][]  = array( 'swm_icon9', '', 'swm_sanitize_simple_text' );
        $swm['ctrl'][] = array( 'swm_icon9', 'text', esc_html__( 'Icon 9', 'bizix' ), 'swm_social_media_icons' );

        $swm['set'][]  = array( 'swm_icon9_url', '','swm_sanitize_url' );
        $swm['ctrl'][] = array( 'swm_icon9_url', 'text', esc_html__( 'Icon 9 URL', 'bizix' ), 'swm_social_media_icons' );

        $swm['set'][]  = array( 'swm_icon10', '', 'swm_sanitize_simple_text' );
        $swm['ctrl'][] = array( 'swm_icon10', 'text', esc_html__( 'Icon 10', 'bizix' ), 'swm_social_media_icons' );

        $swm['set'][]  = array( 'swm_icon10_url', '','swm_sanitize_url' );
        $swm['ctrl'][] = array( 'swm_icon10_url', 'text', esc_html__( 'Icon 10 URL', 'bizix' ), 'swm_social_media_icons' );

    } // end enabled panel

    // add customizer option in database with 'theme_mods_bizix'
    if ( get_theme_mod('swm_site_layout') ) {

        // Print Settings
        foreach ( $swm['set'] as $setting ) {

            $swm_get_set_one = !empty($setting[1]) ? $setting[1] : '';
            $swm_customizer_sanitization = !empty($setting[2]) ? $setting[2] : '';
            $swm_customizer_transport = !empty($setting[3]) ? $setting[3] : 'refresh';

            $wp_customize->add_setting( $setting[0], array(
              'type'      => 'theme_mod',
              'default'   => $swm_get_set_one,
              'transport' => $swm_customizer_transport,
              'sanitize_callback' => $swm_customizer_sanitization
            ));
        }

    } else {

        // Print Settings
        foreach ( $swm['set'] as $setting ) {

            $swm_get_set_one = !empty($setting[1]) ? $setting[1] : '';
            $swm_customizer_sanitization = !empty($setting[2]) ? $setting[2] : '';
            $swm_customizer_transport = !empty($setting[3]) ? $setting[3] : 'refresh';

            $wp_customize->add_setting( $setting[0], array(
              'type'      => 'option',
              'default'   => $swm_get_set_one,
              'transport' => $swm_customizer_transport,
              'sanitize_callback' => $swm_customizer_sanitization
            ));
        }

        // replace "get_option" with "set_theme_mod" for all theme customizer options
        swm_set_customizer_options_list();

    }


    // Print Controls
    foreach ( $swm['ctrl'] as $control ) {

        static $i = 1;

        switch ($control[1]) {

            case 'radio':

              $wp_customize->add_control( $control[0], array(
                'type'     => $control[1],
                'label'    => $control[2],
                'section'  => $control[4],
                'priority' => $i,
                'choices'  => $control[3]
              ));
              break;

            case 'radio-image':

              $wp_customize->add_control(
                 new swm_Customize_Radio_Image_Control($wp_customize, $control[0], array(
                    'label'    => $control[2],
                    'section'  => $control[4],
                    'settings' => $control[0],
                    'priority' => $i,
                    'choices'  => $control[3]
              ))
              );
              break;

            case 'buttontab':

                $wp_customize->add_control(
                    new swm_Customize_Buttontab_Control( $wp_customize, $control[0], array(
                      'label'    => $control[2],
                      'section'  => $control[4],
                      'settings' => $control[0],
                      'priority' => $i,
                      'choices'  => $control[3]
                    ))
                );
            break;

            case 'radio-switch':

              $wp_customize->add_control(
                 new swm_Customize_Radio_Switch_Control($wp_customize, $control[0], array(
                    'type'     => $control[1],
                    'label'    => $control[2],
                    'section'  => $control[3],
                    'priority' => $i
              ))
              );
              break;

            case 'select':

              $wp_customize->add_control( $control[0], array(
                'type'     => $control[1],
                'label'    => $control[2],
                'section'  => $control[4],
                'priority' => $i,
                'choices'  => $control[3]
              ));
              break;

            case 'sidebar-select':

                $wp_customize->add_control(
                  new swm_Customize_Sidebar_Control($wp_customize, $control[0], array(
                    'type'     => $control[1],
                    'label'    => $control[2],
                    'section'  => $control[3],
                    'priority' => $i
                  ))
                );
            break;

            case 'revslider-select':

                $wp_customize->add_control(
                  new swm_Customize_RevSlider_Control($wp_customize, $control[0], array(
                    'type'     => $control[1],
                    'label'    => $control[2],
                    'section'  => $control[3],
                    'priority' => $i
                  ))
                );
              break;

            case 'slider':

              $wp_customize->add_control(
                new swm_Customize_Slider_Control( $wp_customize, $control[0], array(
                  'label'    => $control[2],
                  'section'  => $control[4],
                  'settings' => $control[0],
                  'priority' => $i,
                  'choices'  => $control[3]
                ))
              );
              break;

            case 'text':
              $wp_customize->add_control( $control[0], array(
                'type'     => $control[1],
                'label'    => $control[2],
                'section'  => $control[3],
                'priority' => $i
              ));
              break;

            case 'textarea':

              $wp_customize->add_control(
                new swm_Customize_Control_Textarea( $wp_customize, $control[0], array(
                  'label'    => $control[2],
                  'section'  => $control[3],
                  'settings' => $control[0],
                  'priority' => $i
                ))
              );
              break;

            case 'color':

              $wp_customize->add_control(
                new WP_Customize_Color_Control( $wp_customize, $control[0], array(
                  'label'    => $control[2],
                  'section'  => $control[3],
                  'settings' => $control[0],
                  'priority' => $i
                ))
              );
              break;

            case 'image':

              $wp_customize->add_control(
                new WP_Customize_Image_Control( $wp_customize, $control[0], array(
                  'label'    => $control[2],
                  'section'  => $control[3],
                  'settings' => $control[0],
                  'priority' => $i
                ))
              );
              break;
        }

    $i++;

    } //end foreach

    $wp_customize->selective_refresh->add_partial( 'swm_small_footer_copyright', array(
        'selector'            => '.swm-small-footer',
        'settings'            => array('swm_small_footer_copyright'),
        'container_inclusive' => true,
        'primarySetting'      => 'swm_small_footer_copyright',
        'fallback_refresh'    => false,
        'render_callback'     => function() {
            get_template_part('parts/footer/small-footer');
        },
    ));

    $wp_customize->selective_refresh->add_partial( 'swm_cf_column', array(
        'selector'            => '.swm_contact_footer',
        'settings'            => array(
            'swm_cf_column',
            'swm_cf_email',
            'swm_cf_email_s_title',
            'swm_cf_call',
            'swm_cf_call_s_title',
            'swm_cf_address',
            'swm_cf_address_s_title'
        ),
        'container_inclusive' => true,
        'fallback_refresh'    => false,
        'render_callback'     => function() {
            get_template_part('parts/footer/contact-footer');
        },
    ));

    $wp_customize->selective_refresh->add_partial( 'swm_cih_call', array(
        'selector'            => '.swm_header_contact_info',
        'settings'            => array(
            'swm_cih_call',
            'swm_cih_call_s_title',
            'swm_cih_email',
            'swm_cih_email_s_title',
            'swm_cih_address',
            'swm_cih_address_s_title',
            'swm_icon1',
            'swm_icon2',
            'swm_icon3',
            'swm_icon4',
            'swm_icon5',
            'swm_icon6',
            'swm_icon7',
            'swm_icon8'
        ),
        'container_inclusive' => true,
        'fallback_refresh'    => false,
        'render_callback'     => function() {
            get_template_part('parts/headers/contact-info');
        },
    ));

    $wp_customize->selective_refresh->add_partial( 'swm_icon1', array(
        'selector'            => '.swm-topbar-main-container',
        'settings'            => array(
            'swm_icon1',
            'swm_icon2',
            'swm_icon3',
            'swm_icon4',
            'swm_icon5',
            'swm_icon6',
            'swm_icon7',
            'swm_icon8'
        ),
        'container_inclusive' => true,
        'fallback_refresh'    => false,
        'render_callback'     => function() {
            get_template_part('parts/headers/topbar');
        },
    ));


}  // end swm customizer options register function

add_action( 'customize_register', 'swm_customizer_options_register' );

/* ******************************************************************** */
/* OPTIONS LIST */
/* ******************************************************************** */

function swm_set_customizer_options_list() {

    $swm_get_customizer_all_options = array(
        'swm_page_preloader_on'                     => 'off',
        'swm_page_preloader_bg'                     => '#f6f3ee',
        'swm_page_preloader_shape_color'            => '#d83030',
        'swm_bottom_go_top_scroll_btn_on'           => 'off',
        'swm_bottom_go_top_scroll_bg'               => '#252628',
        'swm_bottom_go_top_scroll_shape_color'      => '#ffffff',
        'swm_layout_max_width'                      => 1200,
        'swm_content_width'                         => 72,
        'swm_container_padding'                     => 15,
        'swm_site_content_top_padding_d'            => 100,
        'swm_site_content_bottom_padding_d'         => 100,
        'swm_site_content_top_padding_t'            => 80,
        'swm_site_content_bottom_padding_t'         => 80,
        'swm_site_content_top_padding_m'            => 60,
        'swm_site_content_bottom_padding_m'         => 60,
        'swm_content_layout'                        => 'layout-full-width',
        'swm_site_layout'                           => 'full-width',
        'swm_boxed_layout_dropshadow'               => 'no-shadow',
        'swm_boxed_layout_margin_top_bottom'        => 40,
        'swm_boxed_layout_no_margin_resolution'     => 980,
        'swm_boxed_layout_border_radius'            => 0,
        'swm_boxed_layout_padding_left_right'       => 30,
        'swm_body_bg_color'                         => '#444444',
        'swm_body_bg_opacity'                       => 1,
        'swm_body_bg_img'                           => '',
        'swm_body_bg_style'                         => 'cover',
        'swm_skin_color'                            => '#d83030',
        'swm_skin_text_color'                       => '#ffffff',
        'swm_secondary_skin_color'                  => '#252628',
        'swm_secondary_skin_text_color'             => '#ffffff',
        'swm_content_headings_color'                => '#032e42',
        'swm_content_color'                         => '#676767',
        'swm_content_link_color'                    => '#676767',
        'swm_content_link_hover_color'              => '#d83030',
        'swm_highlight_bg'                          => '#d83030',
        'swm_highlight_color'                       => '#ffffff',
        'swm_topbar_on'                             => 'off',
        'swm_topbar_font_size'                      => 14,
        'swm_topbar_bg_solid_color'                 => '#252628',
        'swm_topbar_text'                           => '#bbbbbb',
        'swm_topbar_hover_text'                     => '#ffffff',
        'swm_topbar_icon_col'                       => '#7f7f7f',
        'swm_topbar_device'                         => '',
        'swm_topbar_social_on'                      => 'on',
        'swm_topbar_sm_color'                       => '#bbbbbb',
        'swm_topbar_sm_h_color'                     => '#ffffff',
        'swm_topbar_left_style_on'                  => 'on',
        'swm_topbar_left_bg_color'                  => '#d83030',
        'swm_topbar_left_text_color'                => '#ffffff',
        'swm_topbar_left_text_hover_color'          => '#ffffff',
        'swm_topbar_left_icon_color'                => '#e89999',
        'swm_main_header_on'                        => 'on',
        'swm_header_style'                          => 'header_1',
        'swm_main_header_bg_color'                  => '#ffffff',
        'swm_header_bg_opacity'                     => 0.8,
        'swm_main_header_height_d'                  => 107,
        'swm_main_header_height_t'                  => 107,
        'swm_main_header_height_m'                  => 80,
        'swm_logo_standard'                         => '',
        'swm_logo_retina'                           => '',
        'swm_logo_standard_width'                   => '126px',
        'swm_logo_standard_height'                  => '',
        'swm_pr_menu_font_size'                     => 15,
        'swm_pr_menu_links_space'                   => 19,
        'swm_pr_menu_links_text_color'              => '#032e42',
        'swm_pr_menu_links_text_hover_color'        => '#d83030',
        'swm_pr_menu_active_border_on'              => 'on',
        'swm_pr_menu_active_border_color'           => '#d83030',
        'swm_pr_menu_active_border_style'           => 'small',
        'swm_pr_menu_bg'                            => '#f2f2f2',
        'swm_pr_menu_bg_opacity'                    => 1,
        'swm_pr_menu_links_text_transform'          => 'uppercase',
        'swm_pr_menu_dropdown_indicator'            => 'off',
        'swm_pr_menu_divider_on'                    => 'off',
        'swm_pr_menu_divider_color'                 => '#e6e6e6',
        'swm_dd_menu_font_size'                     => 14,
        'swm_dd_menu_font_color'                    => '#676767',
        'swm_d_menu_font_hov_color'                 => '#d83030',
        'swm_dd_bg_color'                           => '#ffffff',
        'swm_dd_menu_title_transform'               => 'none',
        'swm_dd_menu_pr_font_family_on'             => 'on',
        'swm_dd_menu_links_space'                   => 7,
        'swm_dd_menu_width'                         => 236,
        'swm_dd_menu_box_shadow'                    => 'on',
        'swm_dd_menu_submenu_indicator'             => 'off',
        'swm_megamenu_links_space'                  => 5,
        'swm_megamenu_text_lineheight'              => 23,
        'swm_dropdown_bullet_arrow'                 => 'on',
        'swm_megamenu_title_font_size'              => 20,
        'swm_megamenu_title_lineheight'             => 30,
        'swm_megamenu_title_font_color'             => '#032e42',
        'swm_mobile_menu_min_resolution'            => 979,
        'swm_sticky_menu_on'                        => 'off',
        'swm_sticky_logo_standard'                  => '',
        'swm_sticky_logo_retina'                    => '',
        'swm_logo_sticky_width'                     => '126px',
        'swm_sticky_menu_font_size'                 => 15,
        'swm_sticky_pr_menu_links_text_color'       => '#032e42',
        'swm_sticky_pr_menu_links_text_hover_color' => '#d83030',
        'swm_sticky_pr_menu_active_border_color'    => '#d83030',
        'swm_sticky_pr_menu_bg'                     => '#ffffff',
        'swm_sticky_pr_menu_divider_color'          => '#e6e6e6',
        'swm_sticky_hide_resolution'                => 768,
        'swm_header_search_on'                      => 'on',
        'swm_header_search_text_size'               => 21,
        'swm_header_search_bg_color'                => '#252628',
        'swm_header_search_bg_opacity'              => 0.99,
        'swm_header_search_text_color'              => '#ffffff',
        'swm_header_search_form_border_color'       => '#d83030',
        'swm_header_close_icon_color'               => '#ffffff',
        'swm_header_search_placeholder_text'        => 'Search...',
        'swm_header_search_max_width'               => 905,
        'swm_header_button_on'                      => 'off',
        'swm_header_button_text'                    => 'Get A Quote',
        'swm_header_button_link'                    => '#',
        'swm_header_button_link_target'             => 'off',
        'swm_header_button_font_size'               => 15,
        'swm_header_button_text_color'              => '#ffffff',
        'swm_header_button_text_h_color'            => '#ffffff',
        'swm_header_button_bg'                      => '#252628',
        'swm_header_button_h_bg'                    => '#101011',
        'swm_header_button_border_color'            => '#252628',
        'swm_header_button_border_h_color'          => '#101011',
        'swm_header_button_width'                   => 0,
        'swm_header_button_border_radius'           => 3,
        'swm_header_button_border_style'            => 'solid',
        'swm_header_button_hide_device'             => '',
        'swm_sidepanel_on'                          => 'off',
        'swm_sidepanel_max_width'                   => 500,
        'swm_hide_sidepanel_resolution'             => 979,
        'swm_sidepanel_icon_col'                    => '#676767',
        'swm_sidepanel_icon_style'                  => 's_one',
        'swm_sidepanel_overlay_bg'                  => '#000000',
        'swm_sidepanel_overlay_bg_opacity'          => 0.8,
        'swm_close_icon_on'                         => 'on',
        'swm_sidepanel_close_icon_col'              => '#d83030',
        'swm_sidepanel_close_icon_border_col'       => '#e6e6e6',
        'swm_sidepanel_text_size'                   => 15,
        'swm_sidepanel_text_col'                    => '#676767',
        'swm_sidepanel_link'                        => '#676767',
        'swm_sidepanel_link_hover'                  => '#d83030',
        'swm_sidepanel_border_color'                => '#e6e6e6',
        'swm_sidepanel_title_color'                 => '#032e42',
        'swm_sidepanel_title_transform'             => 'none',
        'swm_sidepanel_title_size'                  => 19,
        'swm_sidepanel_title_letter_space'          => 0,
        'swm_header_contact_info_on'                => 'on',
        'swm_cih_call'                              => '+1 (888) 456 7890',
        'swm_cih_call_s_title'                      => 'Call Us Now',
        'swm_cih_email'                             => 'info@example.com',
        'swm_cih_email_s_title'                     => 'Drop Us a Line',
        'swm_cih_address'                           => '65 St. Road, NY USA',
        'swm_cih_address_s_title'                   => 'Get Direction',
        'swm_cih_icon_color'                        => '#d83030',
        'swm_cih_title_color'                       => '#032e42',
        'swm_cih_subtitle_color'                    => '#676767',
        'swm_cih_title_size'                        => 16,
        'swm_cih_subtitle_size'                     => 15,
        'swm_header_contactinfo_hide_device'        => '',
        'swm_cih_social_icons_on'                   => 'on',
        'swm_cih_sicons_col'                        => '#676767',
        'swm_cih_sicons_bg'                         => '#f5f5f5',
        'swm_cih_sicons_col_hover'                  => '#ffffff',
        'swm_cih_sicons_bg_hover'                   => '#d83030',
        'swm_sub_header_on'                         => 'on',
        'swm_sub_header_above_header_on'            => 'off',
        'swm_sub_header_height_d'                   => 500,
        'swm_sub_header_height_t'                   => 400,
        'swm_sub_header_height_m'                   => 300,
        'swm_sub_header_bg_color'                   => '#343a40',
        'swm_sub_header_bg_img'                     => '',
        'swm_sub_header_bg_style'                   => 'cover',
        'swm_sub_header_title_on'                   => 'on',
        'swm_sub_header_title_position'             => 'title-center',
        'swm_sub_header_title_color'                => '#ffffff',
        'swm_sub_header_title_font_size_d'          => 55,
        'swm_sub_header_title_font_size_t'          => 45,
        'swm_sub_header_title_font_size_m'          => 27,
        'swm_sub_header_title_transform'            => 'none',
        'swm_sub_header_breadcrumb_on'              => 'on',
        'swm_sub_header_breadcrumb_font_size'       => 16,
        'swm_sub_header_breadcrumb_transform'       => 'none',
        'swm_breadcrumbs_text_color'                => '#ffffff',
        'swm_breadcrumbs_text_hover_color'          => '#ffffff',
        'swm_breadcrumbs_icons_color'               => '#ffffff',
        'swm_breadcrumbs_hide_device'               => '',
        'swm_sidebar_text_size'                     => 15,
        'swm_sidebar_text_col'                      => '#676767',
        'swm_sidebar_link'                          => '#676767',
        'swm_sidebar_link_hover'                    => '#d83030',
        'swm_sidebar_border_color'                  => '#dcdcdc',
        'swm_sidebar_widget_box_bg'                 => '#f6f3ee',
        'swm_sticky_sidebar_on'                     => 'on',
        'swm_sidebar_title_color'                   => '#032e42',
        'swm_sidebar_title_border_color'            => '#d83030',
        'swm_sidebar_title_transform'               => 'uppercase',
        'swm_sidebar_title_size'                    => 19,
        'swm_sidebar_title_letter_space'            => 0,
        'swm_widget_footer_on'                      => 'on',
        'swm_widget_footer_text_size'               => 15,
        'swm_widget_footer_line_height'             => 30,
        'swm_widget_footer_space'                   => 30,
        'swm_widget_footer_column'                  => 'col-4',
        'swm_widget_footer_bg_color'                => '#252628',
        'swm_widget_footer_bg_color_two'            => '#1c1d1f',
        'swm_widget_footer_border_color'            => '#343538',
        'swm_widget_footer_text_color'              => '#bbbbbb',
        'swm_widget_footer_links_color'             => '#bbbbbb',
        'swm_widget_footer_links_hover_color'       => '#ffffff',
        'swm_widget_footer_rp_links_color'          => '#bbbbbb',
        'swm_widget_footer_title_color'             => '#ffffff',
        'swm_widget_footer_bg_img'                  => '',
        'swm_widget_footer_bg_style'                => 'cover',
        'swm_widget_footer_title_transform'         => 'none',
        'swm_widget_footer_title_size'              => 20,
        'swm_widget_footer_title_letter_space'      => 0,
        'swm_widget_footer_title_lineheight'        => 30,
        'swm_contact_footer_on'                     => 'off',
        'swm_cf_column'                             => '3',
        'swm_cf_email'                              => 'info@example.com',
        'swm_cf_email_s_title'                      => 'Drop Us a Line',
        'swm_cf_call'                               => '+1 (888) 456 7890',
        'swm_cf_call_s_title'                       => 'Call Us Now',
        'swm_cf_address'                            => '65 St. Road, NY USA',
        'swm_cf_address_s_title'                    => 'Get Direction',
        'swm_cf_text_color'                         => '#ffffff',
        'swm_cf_bg_1'                               => '#191a1c',
        'swm_cf_bg_2'                               => '#d83030',
        'swm_small_footer_on'                       => 'on',
        'swm_small_footer_copyright'                => 'wp_kses_post',
        'swm_small_footer_text_size'                => 15,
        'swm_small_footer_text_color'               => '#aaaaaa',
        'swm_small_footer_link_color'               => '#aaaaaa',
        'swm_small_footer_link_h_color'             => '#ffffff',
        'swm_small_footer_top_border_color'         => '#3b3c3f',
        'swm_google_fonts_on'                       => 'on',
        'swm_google_fonts_subset_on'                => 'off',
        'swm_google_font_subset_cyrillic'           => 'off',
        'swm_google_font_subset_greek'              => 'off',
        'swm_google_font_subset_vietnamese'         => 'off',
        'swm_body_font_size'                        => 16,
        'swm_body_font_lineheight'                  => 1.7,
        'swm_body_font_family'                      => 'Roboto',
        'swm_body_font_weight'                      => '400',
        'swm_body_font_weight_medium'               => 'on',
        'swm_body_font_weight_semi_bold'            => 'on',
        'swm_body_font_weight_bold'                 => 'on',
        'swm_nav_font_family'                       => 'Roboto',
        'swm_nav_font_weight'                       => '600',
        'swm_header_title_font_family'              => 'Fira Sans',
        'swm_header_title_font_weight'              => '700',
        'swm_widget_title_font_family'              => 'Fira Sans',
        'swm_widget_title_font_weight'              => '700',
        'swm_headings_font_family'                  => 'Fira Sans',
        'swm_headings_font_weight'                  => '700',
        'swm_h1_font_size'                          => 40,
        'swm_h2_font_size'                          => 33,
        'swm_h3_font_size'                          => 29,
        'swm_h4_font_size'                          => 25,
        'swm_h5_font_size'                          => 22,
        'swm_h6_font_size'                          => 19,
        'swm_h1_font_lineheight'                    => 55,
        'swm_h2_font_lineheight'                    => 50,
        'swm_h3_font_lineheight'                    => 40,
        'swm_h4_font_lineheight'                    => 36,
        'swm_h5_font_lineheight'                    => 30,
        'swm_h6_font_lineheight'                    => 25,
        'swm_page_comments_on'                      => 'on',
        'swm_blog_page_layout'                      => 'layout-sidebar-right',
        'swm_featured_img_height'                   => '580',
        'swm_featured_fullwidth_img_height'         => '580',
        'swm_home_blog_header'                      => 'on',
        'swm_home_blog_header_style'                => 'standard',
        'swm_header_rev_slider_shortcode'           => '',
        'swm_post_title_color'                      => '#032e42',
        'swm_post_title_hover_color'                => '#d83030',
        'swm_post_title_size'                       => 30,
        'swm_post_title_letter_space'               => 0,
        'swm_post_title_lineheight'                 => 44,
        'swm_post_title_transform'                  => 'none',
        'swm_date_on'                               => 'on',
        'swm_author_name_on'                        => 'on',
        'swm_cats_on'                               => 'off',
        'swm_comments_on'                           => 'on',
        'swm_views_on'                              => 'on',
        'swm_likes_on'                              => 'on',
        'swm_post_button_text'                      => 'Read More',
        'swm_excerpt_on'                            => 'on',
        'swm_excerpt_length'                        => '50',
        'swm_archives_sidebar'                      => 'blog-sidebar',
        'swm_blog_single_header_title'              => 'Blog',
        'swm_blog_page_url'                         => '#',
        'swm_single_post_title_size'                => 30,
        'swm_single_post_title_letter_space'        => 0,
        'swm_single_post_title_lineheight'          => 40,
        'swm_single_post_title_transform'           => 'none',
        'swm_single_date_on'                        => 'on',
        'swm_single_author_name_on'                 => 'on',
        'swm_single_cats_on'                        => 'on',
        'swm_single_views_on'                       => 'on',
        'swm_single_likes_on'                       => 'on',
        'swm_single_tags_on'                        => 'on',
        'swm_single_comments_on'                    => 'on',
        'swm_single_authorbox_on'                   => 'off',
        'swm_single_pagination_on'                  => 'on',
        'swm_single_comments_section_on'            => 'on',
        'swm_single_related_posts_on'               => 'on',
        'swm_single_related_posts_column'           => '2',
        'swm_single_related_posts_number'           => 2,
        'swm_post_single_section_ttl_col'           => '#032e42',
        'swm_post_single_section_ttl_size'          => 25,
        'swm_post_single_section_ttl_letter_space'  => 0,
        'swm_post_single_section_ttl_lineheight'    => 44,
        'swm_post_single_section_ttl_transform'     => 'none',
        'swm_portfolio_page_title'                  => 'Portfolio',
        'swm_portfolio_page_url'                    => '#',
        'swm_portfolio_comments_on'                 => 'off',
        'swm_open_sm_new_window'                    => 'on',
        'swm_icon1'                                 => '',
        'swm_icon1_url'                             => '',
        'swm_icon2'                                 => '',
        'swm_icon2_url'                             => '',
        'swm_icon3'                                 => '',
        'swm_icon3_url'                             => '',
        'swm_icon4'                                 => '',
        'swm_icon4_url'                             => '',
        'swm_icon5'                                 => '',
        'swm_icon5_url'                             => '',
        'swm_icon6'                                 => '',
        'swm_icon6_url'                             => '',
        'swm_icon7'                                 => '',
        'swm_icon7_url'                             => '',
        'swm_icon8'                                 => '',
        'swm_icon8_url'                             => '',
        'swm_icon9'                                 => '',
        'swm_icon9_url'                             => '',
        'swm_icon10'                                => '',
        'swm_icon10_url'                            => '',
    );

    $swm_get_categories = get_categories();
    $swm_get_customizer_cats = array();

    if ($swm_get_categories) {
        foreach($swm_get_categories as $swm_category) {

            $swm_cname = $swm_category->slug.'_bg';
            $swm_cname_img = $swm_category->slug.'_bg_img';
            $swm_cname_title = $swm_category->slug.'_title';

            $swm_get_customizer_cats[$swm_cname] .= '#343a40';
            $swm_get_customizer_cats[$swm_cname_title] .= '#ffffff';
            $swm_get_customizer_cats[$swm_cname_img] .= '';

        }
    }

    $swm_get_customizer_all_options_list = array_merge($swm_get_customizer_all_options,$swm_get_customizer_cats);

    foreach ($swm_get_customizer_all_options_list as $option_name => $option_value) {
        $get_option_value_for_mode = get_option( $option_name,$option_value );
        set_theme_mod($option_name,$get_option_value_for_mode);
    }

}