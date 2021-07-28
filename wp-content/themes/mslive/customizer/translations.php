<?php

if ( ! function_exists( 'swm_load_customizer_translations' ) ) {
    function swm_load_customizer_translations() {

      if ( get_option('swm_enable_minify_theme_js',true) ) {
            wp_enqueue_script('swm-customizer-translations', SWM_THEME_DIR . '/customizer/js/translations-min.js','jquery','1.0', TRUE );
      } else {
            wp_enqueue_script('swm-customizer-translations', SWM_THEME_DIR . '/customizer/js/translations.js','jquery','1.0', TRUE );
      }

      wp_localize_script('swm-customizer-translations', 'swm_c_translate', array(
            'swm_widget_footer_bg_color_two'              => esc_html__('Add little dark color from primary background color to apply in tags hover, forms fields etc.','bizix'),
            'swm_widget_footer_border_color'              => esc_html__('Border color for form borders, link list separator borders, tags borders etc.','bizix'),
            'swm_sidebar_border_color'                    => esc_html__('Border color for form borders, link list separator borders, tags borders etc.','bizix'),
            'swm_footer_title_border_one'                 => esc_html__('Apply when title style has border','bizix'),
            'swm_footer_small_gotop'                      => esc_html__('Leave this field blank to hide Go Top link text','bizix'),
            'swm_body_font_size_s_title'                  => esc_html__('Body Fonts','bizix'),
            'swm_topbar_social_on_s_title'                => esc_html__('Social Icons','bizix'),
            'swm_topbar_left_style_on_s_title'            => esc_html__('Topbar Left','bizix'),
            'swm_main_header_height_d_s_title'            => esc_html__('Header Height','bizix'),
            'swm_nav_font_family_s_title'                 => esc_html__('Main Navigation Fonts','bizix'),
            'swm_header_title_font_family_s_title'        => esc_html__('Sub Header Title Fonts','bizix'),
            'swm_widget_title_font_family_s_title'        => esc_html__('Widget Title Fonts','bizix'),
            'swm_headings_font_family_s_title'            => esc_html__('Headings Fonts','bizix'),
            'swm_sub_header_height_d_s_title'             => esc_html__('Sub Header - Height','bizix'),
            'swm_sub_header_bg_color_s_title'             => esc_html__('Sub Header - Background','bizix'),
            'swm_sub_header_title_on_s_title'             => esc_html__('Sub Header Title','bizix'),
            'swm_sub_header_breadcrumb_on_s_title'        => esc_html__('Breadcrumbs','bizix'),
            'swm_sidepanel_title_color_s_title'           => esc_html__('Widget Title','bizix'),
            'swm_sidepanel_text_size_s_title'             => esc_html__('Widget Typography','bizix'),
            'swm_close_icon_on_s_title'                   => esc_html__('Close Icon','bizix'),
            'swm_megamenu_title_font_size_s_title'        => esc_html__('Mega Menu Title','bizix'),
            'swm_home_blog_header_s_title'                => esc_html__('Sub Header (If Blog as a Home)','bizix'),
            'swm_post_title_color_s_title'                => esc_html__('Post Title','bizix'),
            'swm_date_on_s_title'                         => esc_html__('On/Off Post Meta','bizix'),
            'swm_archives_sidebar_s_title'                => esc_html__('Archives Pages Options','bizix'),
            'swm_single_post_title_size_s_title'          => esc_html__('Post Title','bizix'),
            'swm_single_date_on_s_title'                  => esc_html__('On/Off Post Meta','bizix'),
            'swm_single_authorbox_on_s_title'             => esc_html__('On/Off Sections','bizix'),
            'swm_post_single_section_ttl_col_s_title'     => esc_html__('Sections Title','bizix'),
            'swm_header_bg_color_s_title'                 => esc_html__('Header Background','bizix'),
            'swm_cih_social_icons_on_s_title'             => esc_html__('Social Icons','bizix'),
            'swm_widget_footer_title_transform_s_title'   => esc_html__('Widget Title','bizix'),
            'swm_footer_logo_width_s_title'               => esc_html__('Logo','bizix'),
            'swm_cf_socialmedia_s_title'                  => esc_html__('Social Media Icons','bizix'),
            'swm_footer_sm_title_s_title'                 => esc_html__('Title and Description','bizix'),
            'swm_footer_sm_icon_color_s_title'            => esc_html__('Social Media Icons','bizix'),
            'swm_contact_footer_address_s_title'          => esc_html__('Content','bizix'),
            'swm_widget_footer_bg_color_s_title'          => esc_html__('Styling','bizix'),
            'swm_widget_footer_column_s_title'             => esc_html__('Footer Column','bizix'),
            'swm_sidebar_title_color_s_title'               => esc_html__('Widget Title','bizix'),
            'swm_search_box_style_s_title'                => esc_html__('Search Box','bizix'),
            'swm_site_content_top_padding_d_s_title'        => esc_html__('Content area between header and footer','bizix'),
            'swm_body_bg_color_s_title'                   => esc_html__('Body Background','bizix'),
            'swm_site_layout_s_title'                     => esc_html__('Site Layout','bizix'),
            'swm_contact_footer_text_size_s_title'        => esc_html__('Styling, Typography','bizix'),
            'swm_contact_footer_logo_on_s_title'          => esc_html__('Logo','bizix'),
            'swm_onsale_badge_background_s_title'         => esc_html__('"Sale" Badge','bizix'),
            'swm_woo_related_p_column_s_title'            => esc_html__('Related Products','bizix'),
            'swm_woo_upsells_p_column_s_title'            => esc_html__('Up-Sells Products Column','bizix'),
            'swm_logo_standard_info'                      => esc_html__('Upload standard and retina logo. Retina logo should be double of standard logo. For example standard logo size is 100x50 then retina logo size should be 200x100. If you do not want to add retina logo then use standard logo in retina logo upload section.','bizix'),
            'swm_icon1_info'                              => sprintf( esc_html__( 'Rererence icon site: :  %s', 'bizix' ), '<a href="https://fontawesome.com/icons?d=gallery&s=brands&m=free" target="_blank">CLICK HERE</a>' ),
            'swm_post_single_section_ttl_col_info'        => esc_html__('Add styles to section titles like Leave a Comment form in blog single page.','bizix'),
            'swm_excerpt_length_info'                     => esc_html__('If you are not using excerpt box to display summery text then you can control summery text from <strong>content</strong> text. If you are adding summery text in post excerpt section then it will display all excerpt content.','bizix'),
            'swm_skin_color_info'                         => esc_html__('Skin color will apply in small elements like buttons, scroll top arrow etc.','bizix'),
            'swm_archives_sidebar_info'                   => esc_html__('Select your preferred sidebar for blog pages like archives, categories, author and tags etc.','bizix'),
            'swm_body_font_weight_medium_info'            => esc_html__('If "Medium", "Semi-Bold" and "Bold" options are available with selected body font family then you can enable it with below on/off options for various styles in site body text.','bizix'),
            'swm_topbar_g_angle_info'                     => esc_html__('If background direction is "Angle" then you can set degree from 0 to 360.','bizix'),
            'swm_woo_single_page_gallery_thumbnails_info' => esc_html__('Select column number to display thumanail images below large image','bizix'),
            'swm_sidepanel_on_info' => esc_html__('Add widget from Admin > Appearance > Widgets > Side Panel ( Right side widget box ).','bizix'),
            'swm_cih_social_icons_on_info' => esc_html__('Add Social Media icon and links from Admin > Appearance > Customize > Social Media Icons section.','bizix'),
            'swm_main_header_height_d_info' => esc_html__('Tablet and Mobile height is required for Header Style 1.','bizix'),
            'swm_header_contact_info_on_info' => esc_html__('Display Contact Info with Header Style 2. ( Customize > Header (Panel) > Header > "Header Style" Dropdown)','bizix'),
        ));
  }

    add_action( 'customize_controls_print_footer_scripts', 'swm_load_customizer_translations' );
}