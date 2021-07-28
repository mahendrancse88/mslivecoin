( function( $ ) {

	"use strict";

		var gyanAddNewSidebar = function(){
			if ( $('.sidebars-column-2').length !== 0 ) {
				this.widget_page_sidebars_column = $('.sidebars-column-2');
			} else {
				this.widget_page_sidebars_column = $('.sidebars-column-1');
			}
			this.custom_sidebar = $('#widgets-right');
			this.widget_page_right_section = $('.widget-liquid-right');
			this.sidebar_template = $('#gyan-add-sidebar-template');
			this.custom_sidebar_form();
			this.delete_confirm_cancel_buttons();
			this.delete_confirm_cancel_events();
		};

		gyanAddNewSidebar.prototype = {

			custom_sidebar_form: function() {

					this.widget_page_sidebars_column.append( this.sidebar_template.html() );
					this.widget_name = this.widget_page_sidebars_column.find('input[name="gyan-add-sidebar-input"]');
					this.nonce       = this.widget_page_sidebars_column.find('input[name="gyan-nonce"]').val();
			},

			delete_confirm_cancel_buttons: function() {
				var i = 0;
				this.custom_sidebar.find('.sidebar-gyan-custom .widgets-sortables').each(function() {
					if ( i >= gyanLocalizeCustomSidebars.count ) {
						var widgetID = $(this).attr('id'),
						widgetLayout = '<div class="gyan-widget-box-bottom"><div class="gyan-custom-sidebar-id">'+ gyanLocalizeCustomSidebars.widget_id +':<span class="description"> '+ widgetID +'</span></div><div class="gyan-custom-sidebar-buttons"><a href="#" class="gyan-custom-sidebar-delete button-secondary">'+ gyanLocalizeCustomSidebars.delete +'</a><a href="#" class="gyan-custom-sidebar-delete-cancel button-secondary">'+ gyanLocalizeCustomSidebars.cancel +'</a><a href="#" class="gyan-custom-sidebar-delete-confirm button-primary">'+ gyanLocalizeCustomSidebars.confirm +'</a></div></div>';
						$(this).append(widgetLayout)
					}
					i++;
				} );
			},

			delete_confirm_cancel_events: function() {
				this.widget_page_right_section.on( 'click', 'a.gyan-custom-sidebar-delete', function(event) {
					event.preventDefault();
					$(this).hide();
					$(this).next('a.gyan-custom-sidebar-delete-cancel').show().next('a.gyan-custom-sidebar-delete-confirm').show();
				} );
				this.widget_page_right_section.on( 'click', 'a.gyan-custom-sidebar-delete-cancel', function(event) {
					event.preventDefault();
					$(this).hide();
					$(this).prev('a.gyan-custom-sidebar-delete').show();
					$(this).next('a.gyan-custom-sidebar-delete-confirm').hide();
				} );

				this.widget_page_right_section.on('click', 'a.gyan-custom-sidebar-delete-confirm', $.proxy( this.delete_custom_sidebar, this));

				$( "#add-new-sidebar-form" ).on('submit',(function() {
						$.proxy( this.add_new_sidebar, this);
				} ));
			},

			add_new_sidebar: function(e) {
				e.preventDefault();
				return false;
			},

			//delete custom sidebar, recalculate all sidebars ids and reorder all
			delete_custom_sidebar: function(e) {
				var widget = $(e.currentTarget).parents('.widgets-holder-wrap:eq(0)'),
					title = widget.find('.sidebar-name h2'),
					spinner = title.find('.spinner'),
					widget_name = $.trim(title.text()),
					obj = this;
				widget.addClass('closed');
				spinner.css('display', 'inline-block');
				$.ajax({
					type: "POST",
					url: window.ajaxurl,
					data: {
						 action: 'gyan_delete_custom_sidebar',
						 name: widget_name,
						 _wpnonce: obj.nonce
					},
					success: function(response) {
					 if(response.trim() == 'custom-sidebar-is-removed') {
							widget.slideUp(200).remove();
					 }
					}
				} );
			}
		};

	$( function( ) {

		new gyanAddNewSidebar();

	} );

} ) ( jQuery );