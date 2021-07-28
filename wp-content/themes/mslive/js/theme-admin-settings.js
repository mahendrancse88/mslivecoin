(function ($) { $(document).ready(function() {

	"use strict";

	/* Post Metabox Display as per Post Format ------------------------------------------------------ */

	function swm_onOffMetas() {

		function swm_onOffMetaItem(mainElement,subElement,value) {

			var selectedValue = $('input[name='+mainElement+']:checked').val();

			if (selectedValue == value){
				$(subElement).css('display','block');
			} else {
				$(subElement).css('display','none');
			}
		}

		swm_onOffMetaItem('swm_meta_sub_header_title_on','.swm-meta-sub-header-title-elements','on');

		$("input[name=swm_meta_sub_header_title_on]").on('click',function() {
			swm_onOffMetaItem('swm_meta_sub_header_title_on','.swm-meta-sub-header-title-elements','on');
		});

		swm_onOffMetaItem('swm_meta_sub_header_on','.swm-meta-subheader-fields','on');

		$("input[name=swm_meta_sub_header_on]").on('click',function() {
			swm_onOffMetaItem('swm_meta_sub_header_on','.swm-meta-subheader-fields','on');
		});

		swm_onOffMetaItem('swm_meta_sub_header_title_on','.swm-meta-subheader-title-fields','on');

		$("input[name=swm_meta_sub_header_title_on]").on('click',function() {
			swm_onOffMetaItem('swm_meta_sub_header_title_on','.swm-meta-subheader-title-fields','on');
		});

		swm_onOffMetaItem('swm_meta_sub_header_breadcrumb_on','.swm-meta-subheader-breadcrumbs-fields','on');

		$("input[name=swm_meta_sub_header_breadcrumb_on]").on('click',function() {
			swm_onOffMetaItem('swm_meta_sub_header_breadcrumb_on','.swm-meta-subheader-breadcrumbs-fields','on');
		});

		swm_onOffMetaItem('swm_meta_content_padding_on','.swm-meta-content-padding-fields','custom');

		$("input[name=swm_meta_content_padding_on]").on('click',function() {
			swm_onOffMetaItem('swm_meta_content_padding_on','.swm-meta-content-padding-fields','custom');
		});

	}

	function swmPageHeaderTitleOptions() {

		var get_swm_meta_sub_header_title_on = $('input[name=swm_meta_sub_header_title_on]:checked').val();

		if ( get_swm_meta_sub_header_title_on == 'off' ) {
			$('.swm-meta-subheader-title-fields').hide();
		}

	}

	function swmPageHeaderBreadcrumbsOptions() {

		var get_swm_meta_sub_header_breadcrumb_on = $('input[name=swm_meta_sub_header_breadcrumb_on]:checked').val();

		if ( get_swm_meta_sub_header_breadcrumb_on == 'off' ) {
			$('.swm-meta-subheader-breadcrumbs-fields').hide();
		}

	}

	function swmPagePadding() {

		var get_swm_meta_page_content_on = $('input[name=swm_meta_content_padding_on]:checked').val();

		if ( get_swm_meta_page_content_on == 'default' ) {
			$('.swm-meta-content-padding').hide();
		}

	}

	function swmPageHeaderOptions() {

	var swm_header_bg_field = $('.swm-meta-header-background-fields').hide(),
		swm_header_slider_field = $('.swm-meta-header-revolution-fields').hide(),
		header_style = $( '#swm_meta_header_style' ).val();

		if ( header_style == 'standard' ) {
				swm_header_bg_field.show();
		}
		else if ( header_style == 'revolution_slider' ) {
			swm_header_slider_field.show();
		}

		var get_swm_meta_sub_header_on = $('input[name=swm_meta_sub_header_on]:checked').val();

		if ( get_swm_meta_sub_header_on == 'off' ||  get_swm_meta_sub_header_on == 'default' ) {
			$('.swm-meta-subheader-fields').hide();
		}

	}


	/* Page Options Display as per Page Template ------------------------------------------------------ */

	function swm_pageTemplateMetabox() {

		// meta boxes
		var m_archives = $( '#swm_archives_page' ).hide(),
			m_events = $( '#swm_events_page' ).hide(),
			template = $( '#page_template' ).val();

		if ( template == 'templates/archives.php' ) { m_archives.show(); }
	}



	/* Page Options Display as per Page Template ------------------------------------------------------ */

	/* Run all functions ------------------------------------------------------ */

	swm_pageTemplateMetabox();
	$( '#page_template' ).on( 'change', swm_pageTemplateMetabox );

	swm_onOffMetas();

	swmPageHeaderOptions();
	$( '#swm_meta_header_style' ).on( 'change', swmPageHeaderOptions );

	swmPageHeaderTitleOptions();
	$( '#swm_meta_sub_header_title_on' ).on( 'change', swmPageHeaderTitleOptions );

	swmPageHeaderBreadcrumbsOptions();
	$( '#swm_meta_sub_header_breadcrumb_on' ).on( 'change', swmPageHeaderBreadcrumbsOptions );

	swmPagePadding();
	$( '#swm_meta_content_padding_on' ).on( 'change', swmPagePadding );

	/* Insert Media Upload Popup ------------------------------------------------------ */

   function swm_insert_media_upload_popup() {
        var media_selector_frame;
        $('body').on('click', 'input.picture-select + button', function(event) {
                var $this = $(this);
                event.preventDefault();
                var mediaType = 'image';
                var mediaTypeTitle = 'Image';
                var $formfield = $(this).prev('input.picture-select');

                // Create the media frame.
                media_selector_frame = wp.media.frames.mediaSelector = wp.media({
                    // Set the title of the modal.
                    title: 'Select '+mediaTypeTitle,
                    button: {
                        text: 'Insert '+mediaTypeTitle,
                    },
                    library: {
                        type: mediaType
                    }
                });
                // When an image is selected, run a callback.
                media_selector_frame.on( 'select', function() {
                    var attachment = media_selector_frame.state().get('selection').first();
                    attachment = attachment.toJSON();
                    if(attachment.id) {
                        if($formfield.hasClass('picture-select-id')) {
                            $formfield.val(attachment.id).trigger('change');
                        } else {
                            $formfield.val(attachment.url).trigger('change');
                        }
                    }
                });
                    // Finally, open the modal.
                media_selector_frame.open();
        });
    }
    swm_insert_media_upload_popup();

}); })(jQuery); // if document ready