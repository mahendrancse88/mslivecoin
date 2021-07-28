jQuery(document).ready(function ($) {

    "use strict";

    // Tooltip Options
    function swm_C_Tooltip( targetElement, description ) {
      if ( description !== false ) {
        var swm_NewDescription = '<i class="dashicons dashicons-info" title="'+ description +'" rel="tooltip"></i>';
        jQuery( '#customize-control-' + targetElement + ' span.customize-control-title').append(swm_NewDescription);
      }
    }

    swm_C_Tooltip( 'swm_widget_footer_bg_color_two',swm_c_translate.swm_widget_footer_bg_color_two );
    swm_C_Tooltip( 'swm_widget_footer_border_color',swm_c_translate.swm_widget_footer_border_color );
    swm_C_Tooltip( 'swm_footer_title_border_two',swm_c_translate.swm_footer_title_border_two );
    swm_C_Tooltip( 'swm_footer_small_gotop',swm_c_translate.swm_footer_small_gotop );

    jQuery( '#input_swm_full_width_header_on .swm-image-switch-title span').append('<i class="dashicons dashicons-info" title="'+swm_c_translate.input_swm_full_width_header_on+'" rel="tooltip"></i>' );

     // Info Text
    function swm_C_Info( targetElement, description ) {
      if ( description !== false ) {
        var swm_NewDescription = '<span class="swm-customizer-info-text">'+ description +'</span>';
        jQuery( '#customize-control-' + targetElement ).prepend(swm_NewDescription);
      }
    }

    swm_C_Info( 'swm_logo_standard',swm_c_translate.swm_logo_standard_info );
    swm_C_Info( 'swm_sticky_menu_on',swm_c_translate.swm_logo_standard_info );
    swm_C_Info( 'swm_footer_logo_standard',swm_c_translate.swm_logo_standard_info );
    swm_C_Info( 'swm_icon1',swm_c_translate.swm_icon1_info );
    swm_C_Info( 'swm_post_single_section_ttl_col',swm_c_translate.swm_post_single_section_ttl_col_info );
    swm_C_Info( 'swm_blog_author_section_on',swm_c_translate.swm_blog_author_section_on_info );
    swm_C_Info( 'swm_excerpt_length',swm_c_translate.swm_excerpt_length_info );
    swm_C_Info( 'swm_skin_color',swm_c_translate.swm_skin_color_info );
    swm_C_Info( 'swm_archives_sidebar',swm_c_translate.swm_archives_sidebar_info );
    swm_C_Info( 'swm_sidebar_w1_title',swm_c_translate.swm_sidebar_w1_title_info );
    swm_C_Info( 'swm_body_font_weight_medium',swm_c_translate.swm_body_font_weight_medium_info );
    swm_C_Info( 'swm_woo_single_page_gallery_thumbnails',swm_c_translate.swm_woo_single_page_gallery_thumbnails_info );
    swm_C_Info( 'swm_topbar_g_angle',swm_c_translate.swm_topbar_g_angle_info );
    swm_C_Info( 'swm_sidepanel_on',swm_c_translate.swm_sidepanel_on_info );
    swm_C_Info( 'swm_cih_social_icons_on',swm_c_translate.swm_cih_social_icons_on_info );
    swm_C_Info( 'swm_main_header_height_d',swm_c_translate.swm_main_header_height_d_info );
    swm_C_Info( 'swm_header_contact_info_on',swm_c_translate.swm_header_contact_info_on_info );

    function swm_C_SubTitle( targetElement, subTitle ) {

        if ( subTitle !== false ) {

        subTitle = '<li class="customize-control swm-customize-control-subtitle ' + targetElement + '-subtitle">' +
                     '<h4 class="customize-sub-title">' +
                       subTitle +
                     '</h4>' +
                   '</li>';

        jQuery( '#customize-control-' + targetElement ).before( subTitle );

        }
    }

    swm_C_SubTitle( 'swm_body_font_size',swm_c_translate.swm_body_font_size_s_title );
    swm_C_SubTitle( 'swm_topbar_social_on',swm_c_translate.swm_topbar_social_on_s_title );
    swm_C_SubTitle( 'swm_topbar_left_style_on',swm_c_translate.swm_topbar_left_style_on_s_title );
    swm_C_SubTitle( 'swm_main_header_height_d',swm_c_translate.swm_main_header_height_d_s_title );
    swm_C_SubTitle( 'swm_nav_font_family',swm_c_translate.swm_nav_font_family_s_title );
    swm_C_SubTitle( 'swm_headings_font_family',swm_c_translate.swm_headings_font_family_s_title );
    swm_C_SubTitle( 'swm_header_title_font_family',swm_c_translate.swm_header_title_font_family_s_title );
    swm_C_SubTitle( 'swm_widget_title_font_family',swm_c_translate.swm_widget_title_font_family_s_title );
    swm_C_SubTitle( 'swm_home_blog_header',swm_c_translate.swm_home_blog_header_s_title );
    swm_C_SubTitle( 'swm_post_title_color',swm_c_translate.swm_post_title_color_s_title );
    swm_C_SubTitle( 'swm_date_on',swm_c_translate.swm_date_on_s_title );
    swm_C_SubTitle( 'swm_archives_sidebar',swm_c_translate.swm_archives_sidebar_s_title );
    swm_C_SubTitle( 'swm_single_post_title_size',swm_c_translate.swm_single_post_title_size_s_title );
    swm_C_SubTitle( 'swm_single_date_on',swm_c_translate.swm_single_date_on_s_title );
    swm_C_SubTitle( 'swm_post_single_section_ttl_col',swm_c_translate.swm_post_single_section_ttl_col_s_title );
    swm_C_SubTitle( 'swm_single_authorbox_on',swm_c_translate.swm_single_authorbox_on_s_title );
    swm_C_SubTitle( 'swm_header_post_one',swm_c_translate.swm_header_post_one_s_title );
    swm_C_SubTitle( 'swm_class_grid_year_bg',swm_c_translate.swm_class_grid_year_bg_s_title );
    swm_C_SubTitle( 'swm_class_single_table_icons',swm_c_translate.swm_class_single_table_icons_s_title );
    swm_C_SubTitle( 'swm_event_grid_date_bg',swm_c_translate.swm_event_grid_date_bg_s_title );
    swm_C_SubTitle( 'swm_event_single_table1_bg',swm_c_translate.swm_event_single_table1_bg_s_title );

    swm_C_SubTitle( 'swm_sub_header_height_d',swm_c_translate.swm_sub_header_height_d_s_title );
    swm_C_SubTitle( 'swm_sub_header_bg_color',swm_c_translate.swm_sub_header_bg_color_s_title );
    swm_C_SubTitle( 'swm_sub_header_breadcrumb_on',swm_c_translate.swm_sub_header_breadcrumb_on_s_title );
    swm_C_SubTitle( 'swm_sticky_header_button_font_size',swm_c_translate.swm_sticky_header_button_font_size_s_title );
    swm_C_SubTitle( 'swm_sidepanel_title_color',swm_c_translate.swm_sidepanel_title_color_s_title );
    swm_C_SubTitle( 'swm_sidepanel_text_size',swm_c_translate.swm_sidepanel_text_size_s_title );
    swm_C_SubTitle( 'swm_close_icon_on',swm_c_translate.swm_close_icon_on_s_title );
    swm_C_SubTitle( 'swm_megamenu_title_font_size',swm_c_translate.swm_megamenu_title_font_size_s_title );

    swm_C_SubTitle( 'swm_sub_header_title_on',swm_c_translate.swm_sub_header_title_on_s_title );
    swm_C_SubTitle( 'swm_cih_social_icons_on',swm_c_translate.swm_cih_social_icons_on_s_title );

    swm_C_SubTitle( 'swm_sidebar_title_style',swm_c_translate.swm_sidebar_title_style_s_title );
    swm_C_SubTitle( 'swm_sidebar_title_color',swm_c_translate.swm_sidebar_title_color_s_title );
    swm_C_SubTitle( 'swm_site_content_top_padding_d',swm_c_translate.swm_site_content_top_padding_d_s_title );
    swm_C_SubTitle( 'swm_body_bg_color',swm_c_translate.swm_body_bg_color_s_title );
    swm_C_SubTitle( 'swm_site_layout',swm_c_translate.swm_site_layout_s_title );

    swm_C_SubTitle( 'swm_widget_footer_title_transform',swm_c_translate.swm_widget_footer_title_transform_s_title );
    swm_C_SubTitle( 'swm_contact_footer_text_size',swm_c_translate.swm_contact_footer_text_size_s_title );
    swm_C_SubTitle( 'swm_contact_footer_logo_on',swm_c_translate.swm_contact_footer_logo_on_s_title );
    swm_C_SubTitle( 'swm_contact_footer_address',swm_c_translate.swm_contact_footer_address_s_title );
    swm_C_SubTitle( 'swm_widget_footer_column',swm_c_translate.swm_widget_footer_column_s_title );
    swm_C_SubTitle( 'swm_widget_footer_bg_color',swm_c_translate.swm_widget_footer_bg_color_s_title );

    swm_C_SubTitle( 'swm_woo_related_p_column',swm_c_translate.swm_woo_related_p_column_s_title );
    swm_C_SubTitle( 'swm_woo_upsells_p_column',swm_c_translate.swm_woo_upsells_p_column_s_title );
    swm_C_SubTitle( 'swm_onsale_badge_background',swm_c_translate.swm_onsale_badge_background_s_title );
});