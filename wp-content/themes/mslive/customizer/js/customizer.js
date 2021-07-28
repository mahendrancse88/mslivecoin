( function($) {

    "use strict";

    $(window).load(function() {

        $('#swm-customizer-loading').delay(500).fadeOut('slow');

        function swm_is_exist_in_obj(field, object) {
            for (var i in object) {
                if (object[i] === field) {
                    return (true);
                }
            }
            return (false);
        }

        function swm_GetFontWeight(selectField) {

            var fieldID = selectField.data('customize-setting-link').replace(/family/, "weight"),
                fontName = jQuery('option:selected', selectField).val(),
                fontWeight = _wpCustomizeSettings.settings.swm_google_font_weight_list.value[fontName];

            $('input[name="_customize-radio-' + fieldID + '"]').each( function() {
                var $this = $(this);
                if ( ! swm_is_exist_in_obj( $this.val(), fontWeight ) ) {
                    $this.parent().attr('data-custmizer-hide', 'true');
                } else {
                    $this.parent().removeAttr('data-custmizer-hide');
                }
            });

        }

        var $swm_CheckedTrigger = jQuery('#sub-accordion-section-swm_fonts_options select');

        $swm_CheckedTrigger.each( function() {
          swm_GetFontWeight( $(this) );
        }).change( function() {
          swm_GetFontWeight( $(this) );
        });

        $('#customize-control-x_custom_fonts input').change( function() {
          $swm_CheckedTrigger.each( function() {
            swm_GetFontWeight( $(this) );
          });
        });

    });

    $(document).ready(function() {

        //mini select
        var swm_MiniSelectFields = jQuery('label.swm-body-sw,label.swm-primary-nav_sw,label.swm-headings-sw');
        swm_MiniSelectFields.parent().css({
            'width': '35%',
            'margin': 0
        });

        // display element on click

        function swm_C_Default( value, targets ) {
          $.each( targets, function( index, item ) {
            if ( item.key !== value ) {
              $( item.target ).attr('data-custmizer-hide', 'true');
            } else {
              $( item.target ).removeAttr('data-custmizer-hide');
            }
          });
        }

        function swm_C_NewLook( group, targets ) {
          group.change( function() {
            var $value = $(this).val();
            $.each( targets, function( index, item ) {
              if ( item.key !== $value ) {
                $( item.target ).attr('data-custmizer-hide', 'true');
              } else {
                $( item.target ).removeAttr('data-custmizer-hide');
              }
            });
          });
        }

        // topbar social icons
        var $topBarSocialDefault = $('#customize-control-swm_topbar_social_on input:checked').val();
        var $topBarSocialOptions = $('#customize-control-swm_topbar_social_on input');
        var $topBarSocialElements = [
          { key : 'on',  target : '#customize-control-swm_topbar_sm_color, #customize-control-swm_topbar_sm_h_color' }
        ];

        swm_C_Default( $topBarSocialDefault, $topBarSocialElements );
        swm_C_NewLook( $topBarSocialOptions, $topBarSocialElements );

        // sub header background image 100% width ( show on click )
        var $subHeaderDefault = $('#customize-control-swm_sub_header_bg_size input:checked').val();
        var $subHeaderOptions = $('#customize-control-swm_sub_header_bg_size input');
        var $subHeaderElements = [
          { key : 'off',  target : '#customize-control-swm_sub_header_bg_position, #customize-control-swm_sub_header_bg_repeat, #customize-control-swm_sub_header_bg_attachment' }
        ];

        swm_C_Default( $subHeaderDefault, $subHeaderElements );
        swm_C_NewLook( $subHeaderOptions, $subHeaderElements );

        // sub header title ( show on click )
        var $subHeaderTitleDefault = $('#customize-control-swm_sub_header_title_on input:checked').val();
        var $subHeaderTitleOptions = $('#customize-control-swm_sub_header_title_on input');
        var $subHeaderTitleElements = [
          { key : 'on',  target : '#customize-control-swm_sub_header_title_position, #customize-control-swm_sub_header_title_color, #customize-control-swm_sub_header_title_font_size, #customize-control-swm_sub_header_title_transform' }
        ];

        swm_C_Default( $subHeaderTitleDefault, $subHeaderTitleElements );
        swm_C_NewLook( $subHeaderTitleOptions, $subHeaderTitleElements );

        // post excerpt
        var $sitePostExcerptDefault = $('#customize-control-swm_excerpt_on input:checked').val();
        var $sitePostExcerptOptions = $('#customize-control-swm_excerpt_on input');
        var $sitePostExcerptElements = [
          { key : 'on',  target : '#customize-control-swm_excerpt_length' }
        ];

        swm_C_Default( $sitePostExcerptDefault, $sitePostExcerptElements );
        swm_C_NewLook( $sitePostExcerptOptions, $sitePostExcerptElements );

        // google sub set
        var $siteGoogleFontDefault = $('#customize-control-swm_google_fonts_subset_on input:checked').val();
        var $siteGoogleFontOptions = $('#customize-control-swm_google_fonts_subset_on input');
        var $siteGoogleFontElements = [
          { key : 'on',  target : '#customize-control-swm_google_font_subset_cyrillic,#customize-control-swm_google_font_subset_greek,#customize-control-swm_google_font_subset_vietnamese' }
        ];

        swm_C_Default( $siteGoogleFontDefault, $siteGoogleFontElements );
        swm_C_NewLook( $siteGoogleFontOptions, $siteGoogleFontElements );

        // body bg
        var $siteBodyBgDefault = $('#customize-control-swm_site_layout input:checked').val();
        var $siteBodyBgOptions = $('#customize-control-swm_site_layout input');
        var $siteBodyBgElements = [
          { key : 'boxed',  target : '.swm_body_bg_color-subtitle,#customize-control-swm_boxed_layout_dropshadow, #customize-control-swm_boxed_layout_margin_top_bottom, #customize-control-swm_boxed_layout_no_margin_resolution, #customize-control-swm_boxed_layout_border_radius, #customize-control-swm_body_bg_color, #customize-control-swm_body_bg_opacity, #customize-control-swm_body_bg_img, #customize-control-swm_body_bg_style,#customize-control-swm_boxed_layout_padding_left_right' } ];

        swm_C_Default( $siteBodyBgDefault, $siteBodyBgElements );
        swm_C_NewLook( $siteBodyBgOptions, $siteBodyBgElements );

        // topbar bg
        var $siteTopbarLeftBgDefault = $('#customize-control-swm_topbar_left_style_on input:checked').val();
        var $siteTopbarLeftBgOptions = $('#customize-control-swm_topbar_left_style_on input');
        var $siteTopbarLeftBgElements = [
          { key : 'on',  target : '#customize-control-swm_topbar_left_bg_color, #customize-control-swm_topbar_left_text_color, #customize-control-swm_topbar_left_icon_color' } ];

        swm_C_Default( $siteTopbarLeftBgDefault, $siteTopbarLeftBgElements );
        swm_C_NewLook( $siteTopbarLeftBgOptions, $siteTopbarLeftBgElements );

        // home Slider
        var $siteHomeSliderDefault = $('#customize-control-swm_home_blog_header_style input:checked').val();
        var $siteHomeSliderOptions = $('#customize-control-swm_home_blog_header_style input');
        var $siteHomeSliderElements = [
          { key : 'revolution_slider',  target : '#customize-control-swm_header_rev_slider_shortcode' }
        ];

        swm_C_Default( $siteHomeSliderDefault, $siteHomeSliderElements );
        swm_C_NewLook( $siteHomeSliderOptions, $siteHomeSliderElements );

        // home Slider
        var $siteBlogHomeDefault = $('#customize-control-swm_home_blog_header input:checked').val();
        var $siteBlogHomeOptions = $('#customize-control-swm_home_blog_header input');
        var $siteBlogHomeElements = [
          { key : 'on',  target : '#customize-control-swm_header_rev_slider_shortcode,#customize-control-swm_home_blog_header_style' }
        ];

        swm_C_Default( $siteBlogHomeDefault, $siteBlogHomeElements );
        swm_C_NewLook( $siteBlogHomeOptions, $siteBlogHomeElements );

        // blog image
        var $siteBlogImageDefault = $('#customize-control-swm_blog_page_layout input:checked').val();
        var $siteBlogImageOptions = $('#customize-control-swm_blog_page_layout input');
        var $siteBlogImageElements = [
          { key : 'layout-full-width',  target : '#customize-control-swm_featured_fullwidth_img_height' }
        ];

        swm_C_Default( $siteBlogImageDefault, $siteBlogImageElements );
        swm_C_NewLook( $siteBlogImageOptions, $siteBlogImageElements );

        // main active links border
        var $siteActiveLinkBorderDefault = $('#customize-control-swm_pr_menu_active_border_on input:checked').val();
        var $siteActiveLinkBorderOptions = $('#customize-control-swm_pr_menu_active_border_on input');
        var $siteActiveLinkBorderElements = [
          { key : 'on',  target : '#customize-control-swm_pr_menu_active_border_color,#customize-control-swm_pr_menu_active_border_style' }
        ];

        swm_C_Default( $siteActiveLinkBorderDefault, $siteActiveLinkBorderElements );
        swm_C_NewLook( $siteActiveLinkBorderOptions, $siteActiveLinkBorderElements );

        // main links divider
        var $siteMainLinksDividerDefault = $('#customize-control-swm_pr_menu_divider_on input:checked').val();
        var $siteMainLinksDividerOptions = $('#customize-control-swm_pr_menu_divider_on input');
        var $siteMainLinksDividerElements = [
          { key : 'on',  target : '#customize-control-swm_pr_menu_divider_color' }
        ];

        swm_C_Default( $siteMainLinksDividerDefault, $siteMainLinksDividerElements );
        swm_C_NewLook( $siteMainLinksDividerOptions, $siteMainLinksDividerElements );

        // page preloader
        var $pagePreloaderDefault = $('#customize-control-swm_page_preloader_on input:checked').val();
        var $pagePreloaderOptions = $('#customize-control-swm_page_preloader_on input');
        var $pagePreloaderElements = [
          { key : 'on',  target : '#customize-control-swm_page_preloader_bg,#customize-control-swm_page_preloader_shape_color' }
        ];

        swm_C_Default( $pagePreloaderDefault, $pagePreloaderElements );
        swm_C_NewLook( $pagePreloaderOptions, $pagePreloaderElements );

        // go to top arrow
        var $goToTopArrowDefault = $('#customize-control-swm_bottom_go_top_scroll_btn_on input:checked').val();
        var $goToTopArrowOptions = $('#customize-control-swm_bottom_go_top_scroll_btn_on input');
        var $goToTopArrowElements = [
          { key : 'on',  target : '#customize-control-swm_bottom_go_top_scroll_bg,#customize-control-swm_bottom_go_top_scroll_shape_color' }
        ];

        swm_C_Default( $goToTopArrowDefault, $goToTopArrowElements );
        swm_C_NewLook( $goToTopArrowOptions, $goToTopArrowElements );

        // related Posts
        var $singleRelatedPostsDefault = $('#customize-control-swm_single_related_posts_on input:checked').val();
        var $singleRelatedPostsOptions = $('#customize-control-swm_single_related_posts_on input');
        var $singleRelatedPostsElements = [
          { key : 'on',  target : '#customize-control-swm_single_related_posts_column,#customize-control-swm_single_related_posts_number' }
        ];

        swm_C_Default( $singleRelatedPostsDefault, $singleRelatedPostsElements );
        swm_C_NewLook( $singleRelatedPostsOptions, $singleRelatedPostsElements );

        // Tooltip
        $( function() {var targets = $( '[rel~=tooltip]' ), target  = false, tooltip = false, title   = false; targets.bind( 'mouseenter', function() {target  = $( this ); var tip     = target.attr( 'title' ); tooltip = $( '<div id="swm-tooltip"></div>' ); if( !tip || tip == '' ) return false; target.removeAttr( 'title' ); tooltip.css( 'opacity', 0 ) .html( tip ) .appendTo( 'body' ); var init_tooltip = function() {if( $( window ).width() < tooltip.outerWidth() * 1.5 ) tooltip.css( 'max-width', $( window ).width() / 2 ); else tooltip.css( 'max-width', 250 ); var pos_left = target.offset().left + ( target.outerWidth() / 2 ) - ( tooltip.outerWidth() / 2 ), pos_top  = target.offset().top - tooltip.outerHeight() - 20; if( pos_left < 0 ) {pos_left = target.offset().left + target.outerWidth() / 2 - 20; tooltip.addClass( 'left' ); } else tooltip.removeClass( 'left' ); if( pos_left + tooltip.outerWidth() > $( window ).width() ) {pos_left = target.offset().left - tooltip.outerWidth() + target.outerWidth() / 2 + 20; tooltip.addClass( 'right' ); } else tooltip.removeClass( 'right' ); if( pos_top < 0 ) {var pos_top  = target.offset().top + target.outerHeight(); tooltip.addClass( 'top' ); } else tooltip.removeClass( 'top' ); tooltip.css( { left: pos_left, top: pos_top } ) .animate( { top: '+=10', opacity: 1 }, 50 ); }; init_tooltip(); $( window ).resize( init_tooltip ); var remove_tooltip = function() {tooltip.animate( { top: '-=10', opacity: 0 }, 50, function() {$( this ).remove(); }); target.attr( 'title', tip ); }; target.bind( 'mouseleave', remove_tooltip ); tooltip.bind( 'click', remove_tooltip ); }); });

        var swm_CustomControls = {
            cache: {},

            init: function() {
                // Populate cache
                this.cache.$buttonset  = $('.swm-control-buttonset');

                // Initialize Button sets
                if (this.cache.$buttonset.length > 0) {
                    this.buttonset();
                }

            },

            buttonset: function() {
                this.cache.$buttonset.buttonset();
            }

        };

        swm_CustomControls.init();

    });

})(jQuery);