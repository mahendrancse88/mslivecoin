// AJAX Request Queue
var GyanSitesAjaxQueue = (function() {
	var requests = [];
	return {
		add:  function(opt) { requests.push(opt); },							// Add AJAX request
		remove:  function(opt) {
		    if( jQuery.inArray(opt, requests) > -1 ) {						// Remove AJAX request
		    	requests.splice($.inArray(opt, requests), 1);
		    }
		},																					// Run / Process AJAX request
		run: function() {
		    var self = this,
		        oriSuc;
		    if( requests.length ) {
		        oriSuc = requests[0].complete;
		        requests[0].complete = function() {
		             if( typeof(oriSuc) === 'function' ) oriSuc();
		             requests.shift();
		             self.run.apply(self, []);
		        };
		        jQuery.ajax(requests[0]);
		    } else {
		    	self.tid = setTimeout(function() {
		    		self.run.apply(self, []);
		    	}, 1000);
		    }
		},
		stop:  function() { requests = []; clearTimeout(this.tid); },  // Stop AJAX request

		_log: function( data, level ) {											// Debugging
			var date = new Date();
			var time = date.toLocaleTimeString();
			var color = '#444';
			if (typeof data == 'object') {
				console.log( data );
			} else {
				console.log( data + ' ' + time );
			}
		},
	};

}());

(function($){
	/** Checking the element is in viewport? */
	$.fn.isInViewport = function() {

		// If not have the element then return false!
		if( ! $( this ).length ) {
			return false;
		}

	    var elementTop = $( this ).offset().top;
	    var elementBottom = elementTop + $( this ).outerHeight();
	    var viewportTop = $( window ).scrollTop();
	    var viewportBottom = viewportTop + $( window ).height();

	    return elementBottom > viewportTop && elementTop < viewportBottom;
	};

	var GyanSSEImport = {
		complete: { posts: 0, media: 0, users: 0, comments: 0, terms: 0 },
		updateDelta: function (type, delta) {
			this.complete[ type ] += delta;

			var self = this;
			requestAnimationFrame(function () {
				self.render();
			});
		},
		updateProgress: function ( type, complete, total ) {
			var text = complete + '/' + total;

			if( 'undefined' !== type && 'undefined' !== text ) {
				total = parseInt( total, 10 );
				if ( 0 === total || isNaN( total ) ) {
					total = 1;
				}

				var percent      = parseInt( complete, 10 ) / total;
				var progress     = Math.round( percent * 100 ) + '%';
				var progress_bar = percent * 100;

				if( progress_bar <= 100 ) {
					var process_bars = document.getElementsByClassName( 'gyan-site-import-process' );
					for ( var i = 0; i < process_bars.length; i++ ) {
						process_bars[i].value = progress_bar;
					}
					GyanSitesAdmin._log_title( 'Importing Content.. ' + progress, false, false );
				}
			}
		},
		render: function () {
			var types = Object.keys( this.complete );
			var complete = 0;
			var total = 0;

			for (var i = types.length - 1; i >= 0; i--) {
				var type = types[i];
				this.updateProgress( type, this.complete[ type ], this.data.count[ type ] );

				complete += this.complete[ type ];
				total += this.data.count[ type ];
			}

			this.updateProgress( 'total', complete, total );
		}
	};

	GyanSitesAdmin = {
		site_import_status: false,
		page_import_status: false,
		imported_page_data: null,
		remaining_activate_plugins: [],
		required_plugins_original_list: [],
		compatibilities: [],
		skip_and_import_popups: [],
		required_plugins: [],
		_ref			: null,
		_api_params		: {},
		_breakpoint		: 768,
		_has_default_page_builder : false,
		_first_time_loaded : true,
		visited_sites_and_pages: [],
		reset_remaining_posts: 0,
		reset_remaining_wp_forms: 0,
		reset_remaining_terms: 0,
		reset_processed_posts: 0,
		reset_processed_wp_forms: 0,
		reset_processed_terms: 0,
		site_imported_data: null,
		backup_taken: false,
		filter_array: [],
		autocompleteTags: [],
		templateData: {},
		mouseLocation : false,
		log_file        : '',
		customizer_data : '',
		wxr_url         : '',
		options_data    : '',
		widgets_data    : '',
		enabled_extensions    : '',
		action_slug		: '',
		import_start_time  : '',
		import_end_time    : '',
		search_terms : [],
		page_settings_flag : true,

		init: function() {
			this._show_default_page_builder_sites();
			this._bind();
			this._addAutocomplete();
			this._autocomplete();
			this._load_large_images();
		},

		_load_large_image: function( el ) {
			if( el.hasClass('loaded') ) { return; }

			if( el.parents('.gyan-theme').isInViewport() ) {
				var large_img_url = el.data('src') || '';
				var imgLarge = new Image();
				imgLarge.src = large_img_url;
				imgLarge.onload = function () {
					el.removeClass('loading');
					el.addClass('loaded');
					el.css('background-image', 'url(\''+imgLarge.src+'\'' );
				};
			}
		},

		_load_large_images: function() {
			$('.theme-screenshot').each(function( key, el) {
				GyanSitesAdmin._load_large_image( $(el) );
			});
		},

		_addAutocomplete: function() {
			var tags = gyanSitesVars.api_sites_and_pages_tags || [];
			var sites = gyanSitesVars.default_page_builder_sites || [];
			var strings = [];

			for( tag_index in tags ) {
				strings.push( GyanSitesAdmin._unescape_lower( tags[ tag_index ]['name'] ) );
			}

			// Add site title's in autocomplete.
			for( site_id in sites ) {

				if( gyanSitesVars.default_page_builder === sites[ site_id ]['gyan-site-page-builder'] ) {
					var title = GyanSitesAdmin._unescape( sites[ site_id ]['title'] );

					// @todo check why below character not escape with function _.unescape();
					title = title.toLowerCase().replace('&#8211;', '-' );
					strings.push( title );
				}
			}

			GyanSitesAdmin.autocompleteTags = strings;
		},

		_autocomplete: function() {
			var strings = GyanSitesAdmin.autocompleteTags;
			strings = _.uniq( strings );
			strings = _.sortBy( strings );

		    $( "#wp-filter-search-input" ).autocomplete({
		    	appendTo: ".gyan-sites-autocomplete-result",
		    	classes: {
				    "ui-autocomplete": "gyan-sites-auto-suggest"
				},
		    	source: function(request, response) {
			        var results = $.ui.autocomplete.filter(strings, request.term);
			        response(results.slice(0, 15)); // Show only 15 results.
			    },
		    	open: function( event, ui ) {
		    		$('.search-form').addClass( 'searching' );
		    	},
		    	close: function( event, ui ) {
		    		$('.search-form').removeClass( 'searching' );
		    	}
		    });

		    $( "#wp-filter-search-input" ).trigger('focus');
		},

		_log: function( data, level ) {
			var date = new Date();
			var time = date.toLocaleTimeString();
			var color = '#444';
			switch( level ) {
				case 'emergency': 	// color = '#f44336';
				case 'critical': 	// color = '#f44336';
				case 'alert': 		// color = '#f44336';
				case 'error': 		// color = '#f44336';
					if (typeof data == 'object') {
						console.error( data );
					} else {
						console.error( data + ' ' + time );
					}
				break;
				case 'warning': 	// color = '#ffc107';
				case 'notice': 		// color = '#ffc107';
					if (typeof data == 'object') {
						console.warn( data );
					} else {
						console.warn( data + ' ' + time );
					}
				break;
				default:
					if (typeof data == 'object') {
						console.log( data );
					} else {
						console.log( data + ' ' + time );
					}
				break;
			}
		},

		_log_title: function( data, append ) {

			var markup = '<p>' + data + '</p>';
			if (typeof data == 'object' ) {
				var markup = '<p>'  + JSON.stringify( data ) + '</p>';
			}

			var selector = $('.gyn-importing-wrap');
			if( $('.current-importing-status-title').length ) {
				selector = $('.current-importing-status-title');
			}

			if ( append ) {
				selector.append( markup );
			} else {
				selector.html( markup );
			}

		},

		_bind: function()	{
			$( window ).on( 'resize scroll', GyanSitesAdmin._load_large_images);

			$( '.gyan-sites__category-filter-anchor, .gyan-sites__category-filter-items' ).hover(function(){
				GyanSitesAdmin.mouseLocation = true;
			}, function(){
				GyanSitesAdmin.mouseLocation = false;
			});

			$( "body" ).on('mouseup',(function(){
				if( ! GyanSitesAdmin.mouseLocation ) GyanSitesAdmin._closeFilter();
			}));

			// Open & Close Popup.
			$( document ).on( 'click', '.site-import-cancel, .gyan-sites-result-preview .close, .gyan-sites-popup .close', GyanSitesAdmin._close_popup );
			$( document ).on( 'click', '.gyan-sites-popup .overlay, .gyan-sites-result-preview .overlay', GyanSitesAdmin._close_popup_by_overlay );

			$( document ).on( 'click', '.gyn-sites__filter-wrap-checkbox, .gyn-sites__filter-wrap', GyanSitesAdmin._filterClick );

			// Page.
			$( document ).on( 'click', '.site-import-layout-button', GyanSitesAdmin.show_page_popup_from_sites);
			$( document ).on('click', '#gyan-sites .gyan-sites-previewing-page .theme-screenshot, #gyan-sites .gyan-sites-previewing-page .theme-name', GyanSitesAdmin.show_page_popup_from_search );
			$( document ).on( 'click', '.gyan-sites-page-import-popup .site-install-site-button, .preview-page-from-search-result .site-install-site-button', GyanSitesAdmin.import_page_process);
			$( document ).on( 'gyan-sites-after-site-pages-required-plugins', GyanSitesAdmin._page_api_call );

			// Site reset warning.
			$( document ).on( 'click', '.gyan-sites-reset-data .checkbox', GyanSitesAdmin._toggle_reset_notice );

			// Site.
			$( document ).on( 'click', '.site-import-site-button', GyanSitesAdmin._show_site_popup);
			$( document ).on( 'click', '.gyan-sites-site-import-popup .site-install-site-button', GyanSitesAdmin._resetData);

			// Skip.
			$( document ).on( 'click', '.gyan-sites-skip-and-import-step', GyanSitesAdmin._remove_skip_and_import_popup);

			// Skip & Import.
			$( document ).on( 'gyan-sites-after-gyan-sites-required-plugins'       , GyanSitesAdmin._start_site_import );

			$( document ).on( 'gyan-sites-reset-data'							, GyanSitesAdmin._backup_before_rest_options );
			$( document ).on( 'gyan-sites-backup-settings-before-reset-done'	, GyanSitesAdmin._reset_customizer_data );
			$( document ).on( 'gyan-sites-reset-customizer-data-done'			, GyanSitesAdmin._reset_site_options );
			$( document ).on( 'gyan-sites-reset-site-options-done'				, GyanSitesAdmin._reset_widgets_data );
			$( document ).on( 'gyan-sites-reset-widgets-data-done'				, GyanSitesAdmin._reset_terms );
			$( document ).on( 'gyan-sites-delete-terms-done'					, GyanSitesAdmin._reset_wp_forms );
			$( document ).on( 'gyan-sites-delete-wp-forms-done'				, GyanSitesAdmin._reset_posts );

			$( document ).on( 'gyan-sites-reset-data-done'       		    , GyanSitesAdmin._recheck_backup_options );
			$( document ).on( 'gyan-sites-backup-settings-done'       	    , GyanSitesAdmin._importCustomizerSettings );
			$( document ).on( 'gyan-sites-import-customizer-settings-done' , GyanSitesAdmin._importXML );
			$( document ).on( 'gyan-sites-import-xml-done'                 , GyanSitesAdmin.import_siteOptions );
			$( document ).on( 'gyan-sites-import-options-done'             , GyanSitesAdmin._importWidgets );
			$( document ).on( 'gyan-sites-import-widgets-done'             , GyanSitesAdmin._importSliders );
			$( document ).on( 'gyan-sites-import-sliders-done'             , GyanSitesAdmin._importEnd );

			$( document ).on( 'click', '.gyan-sites__category-filter-anchor', GyanSitesAdmin._toggleFilter );

			// Tooltip.
			$( document ).on( 'click', '.gyan-sites-tooltip-icon', GyanSitesAdmin._toggle_tooltip);

			// Plugin install & activate.
			$( document ).on( 'wp-plugin-installing'      , GyanSitesAdmin._pluginInstalling);
			$( document ).on( 'wp-plugin-install-error'   , GyanSitesAdmin._installError);
			$( document ).on( 'wp-plugin-install-success' , GyanSitesAdmin._installSuccess);

			$( document ).on('click', '#gyan-sites .gyan-sites-previewing-site .theme-screenshot, #gyan-sites .gyan-sites-previewing-site .theme-name', GyanSitesAdmin._show_pages );
			$( document ).on('click', '#single-pages .site-single', GyanSitesAdmin._change_site_preview_screenshot);

			$( document ).on('click', '.gyan-previewing-single-pages .back-to-layout', GyanSitesAdmin._go_back );
			$( document ).on('click', '.gyan-sites-no-search-result .back-to-layout, .logo, .gyan-sites-back', GyanSitesAdmin._show_sites );

			$( document ).on('keydown', GyanSitesAdmin._next_and_previous_sites );

			$( document ).on('click', '.gyan-sites-sync-library-button', GyanSitesAdmin._sync_library );
			$( document ).on('click', '.gyan-sites-sync-library-message.success .notice-dismiss', GyanSitesAdmin._sync_library_complete );
			$( document ).on('click', '.showing-page-builders #wpbody-content', GyanSitesAdmin._close_page_builder_list );
			$( document ).on('keyup input', '#wp-filter-search-input', GyanSitesAdmin._search );
			$( document ).on( 'keyup' , '#wp-filter-search-input', _.debounce(GyanSitesAdmin._searchPost, 1000 ) );
			$( document ).on( 'heartbeat-send', GyanSitesAdmin._sendHeartbeat );
			$( document ).on( 'heartbeat-tick', GyanSitesAdmin._heartbeatDone );
			$( document ).on('click', '.ui-autocomplete .ui-menu-item', GyanSitesAdmin._show_search_term );
		},

		_heartbeatDone: function( e, data ) {
			// Check for our data, and use it.
			if ( ! data['gyn-sites-search-terms'] ) {
				return;
			}
			GyanSitesAdmin.search_terms = [];
		},

		_sendHeartbeat: function( e, data ) {
			// Add additional data to Heartbeat data.
			if ( GyanSitesAdmin.search_terms.length > 0 ) {
				data['gyn-sites-search-terms'] = GyanSitesAdmin.search_terms;
			}
		},

		_searchPost: function( e ) {
			var term = $( this ).val();
			if ( '' === term ) { return; }

			if ( ! GyanSitesAdmin.search_terms.includes( term ) ) {
				GyanSitesAdmin.search_terms.push( term.toLowerCase() );
			}
		},

		_toggleFilter: function( e ) {
			var items = $( '.gyan-sites__category-filter-items' );

			if ( items.hasClass( 'visible' ) ) {
				items.removeClass( 'visible' );
				items.hide();
			} else {
				items.addClass( 'visible' );
				items.show();
			}
		},

		_closeFilter: function( e ) {
			var items = $( '.gyan-sites__category-filter-items' );
			items.removeClass( 'visible' );
			items.hide();
		},

		_filterClick: function( e ) {
			GyanSitesAdmin.filter_array = [];

			if ( $( this ).hasClass( 'gyn-sites__filter-wrap' ) ) {
				$( '.gyan-sites__category-filter-anchor' ).attr( 'data-slug', $( this ).data( 'slug' ) );
				$( '.gyan-sites__category-filter-items' ).find( '.gyn-sites__filter-wrap' ).removeClass( 'category-active' );
				$( this ).addClass( 'category-active' );
				$( '.gyan-sites__category-filter-anchor' ).text( $( this ).text() );
				$( '.gyan-sites__category-filter-anchor' ).trigger( 'click' );
				$( '#wp-filter-search-input' ).val( '' );
			}

			var $filter_name = $( '.gyan-sites__category-filter-anchor' ).attr( 'data-slug' );

			if ( '' != $filter_name ) {
				GyanSitesAdmin.filter_array.push( $filter_name );
			}

			GyanSitesAdmin._closeFilter();
			$( '#wp-filter-search-input' ).trigger( 'keyup' );
		},

		_show_search_term: function() {
			var search_term = $(this).text() || '';
			$('#wp-filter-search-input').val( search_term );
			$('#wp-filter-search-input').trigger( 'keyup' );
		},

		_search: function(event) {

			var search_input  = $( this ),
				search_term   = $.trim( search_input.val() ) || '';

			if( 13 === event.keyCode ) {
				$('.gyan-sites-autocomplete-result .ui-autocomplete').hide();
				$('.search-form').removeClass('searching');
				$('#gyan-sites-admin').removeClass('searching');
			}

			$('body').removeClass('gyan-sites-no-search-result');

			var sites         = $('#gyan-sites .gyan-theme'),
				titles = $('#gyan-sites .gyan-theme .theme-name'),
				searchTemplateFlag = false,
				items = [];

			GyanSitesAdmin.close_pages_popup();

			if( search_term.length ) {
				search_input.addClass('has-input');
				$('#gyan-sites-admin').addClass('searching');
				searchTemplateFlag = true;
			} else {
				search_input.removeClass('has-input');
				$('#gyan-sites-admin').removeClass('searching');
			}

			items = GyanSitesAdmin._get_sites_and_pages_by_search_term( search_term );

			if( ! GyanSitesAdmin.isEmpty( items ) ) {
				if ( searchTemplateFlag ) {
					GyanSitesAdmin.add_sites_after_search( items );
				} else {
					GyanSitesAdmin.add_sites( items );
				}
			} else {
				if( search_term.length ) {
					$('body').addClass('gyan-sites-no-search-result');
				}
				$('#gyan-sites').html( wp.template('gyan-sites-no-sites') );
			}
		},

		// Change URL
		_changeAndSetURL: function( url_params ) {
			var current_url = window.location.href;
			var current_url_separator = ( window.location.href.indexOf( "?" ) === -1 ) ? "?" : "&";
			var new_url = current_url + current_url_separator + decodeURIComponent( $.param( url_params ) );
			GyanSitesAdmin._changeURL( new_url );
		},

		// Clean the URL
		_changeURL: function( url ) {
			History.pushState(null, gyanSitesVars.demoPageTitle, url);
		},

		// Get URL param
		_getParamFromURL: function(name, url) {
		    if (!url) url = window.location.href;
		    name = name.replace(/[\[\]]/g, "\\$&");
		    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
		        results = regex.exec(url);
		    if (!results) return null;
		    if (!results[2]) return '';
		    return decodeURIComponent(results[2].replace(/\+/g, " "));
		},

		_clean_url_params: function( single_param ) {
			var url_params = GyanSitesAdmin._getQueryStrings();
			delete url_params[ single_param ];
			delete url_params[''];		// Removed extra empty object.

			var current_url = window.location.href;
			var root_url = current_url.substr(0, current_url.indexOf('?'));
			if( $.isEmptyObject( url_params ) ) {
				var new_url = root_url + decodeURIComponent( $.param( url_params ) );
			} else {
				var current_url_separator = ( root_url.indexOf( "?" ) === -1 ) ? "?" : "&";
				var new_url = root_url + current_url_separator + decodeURIComponent( $.param( url_params ) );
			}

			GyanSitesAdmin._changeURL( new_url );
		},

		// Get query strings
		_getQueryStrings: function( string ) {
			return ( string || document.location.search).replace(/(^\?)/,'').split("&").map(function(n){return n = n.split("="),this[n[0]] = n[1],this}.bind({}))[0];
		},

		isEmpty: function(obj) {
		    for(var key in obj) {
		        if(obj.hasOwnProperty(key))
		            return false;
		    }
		    return true;
		},

		_unescape: function( input_string ) {
			var title = _.unescape( input_string );

			// @todo check why below character not escape with function _.unescape();
			title = title.replace('&#8211;', '-' );
			title = title.replace('&#8217;', "'" );

			return title;
		},

		_unescape_lower: function( input_string ) {
			var input_string = GyanSitesAdmin._unescape( input_string );
			return input_string.toLowerCase();
		},

		_get_sites_and_pages_by_search_term: function( search_term ) {

			var items = [],
				tags_strings = [];
			search_term = search_term.toLowerCase();

			if ( search_term == '' && GyanSitesAdmin.filter_array.length == 0 ) {
				return gyanSitesVars.default_page_builder_sites;
			}

			var $filter_name = $( '.gyan-sites__category-filter-anchor' ).attr( 'data-slug' );

			for( site_id in gyanSitesVars.default_page_builder_sites ) {

				var current_site = gyanSitesVars.default_page_builder_sites[site_id];
				var text_match = true;
				var category_match = true;
				var match_id = '';

				if ( '' != search_term ) { text_match = false; }
				if ( '' != $filter_name ) { category_match = false; }

				// Check in site title.
				if( current_site['title'] ) {
					var site_title = GyanSitesAdmin._unescape_lower( current_site['title'] );

					if( site_title.toLowerCase().includes( search_term ) ) {
						text_match = true;
						match_id = site_id;
					}
				}

				// Check in site tags.
				if( Object.keys( current_site['gyan-sites-tag'] ).length ) {
					for( site_tag_id in current_site['gyan-sites-tag'] ) {
						var tag_title = current_site['gyan-sites-tag'][site_tag_id];
							tag_title = GyanSitesAdmin._unescape_lower( tag_title.replace('-', ' ') );
						if( tag_title.toLowerCase().includes( search_term ) ) {
							text_match = true;
							match_id = site_id;
						}
					}
				}

				for( filter_id in GyanSitesAdmin.filter_array ) {
					var slug = GyanSitesAdmin.filter_array[filter_id];
					if ( undefined != slug ) {
						for( cat_id in current_site['gyan-site-category'] ) {
							if( slug.toLowerCase() == current_site['gyan-site-category'][cat_id] ) {
								category_match = true;
								match_id = site_id;
							}
						}
					}
				}

				if ( '' != match_id ) {
					if ( text_match && category_match ) {
						items[site_id] = current_site;
						items[site_id]['type'] = 'site';
						items[site_id]['site_id'] = site_id;
						items[site_id]['pages-count'] = ( undefined != current_site['pages'] ) ? Object.keys( current_site['pages'] ).length : 0;
						tags_strings.push( GyanSitesAdmin._unescape_lower( current_site['title'] ));

						for( site_tag_id in current_site['gyan-sites-tag'] ) {
							var tag_title = current_site['gyan-sites-tag'][site_tag_id];
								tag_title = GyanSitesAdmin._unescape_lower( tag_title.replace('-', ' ') );
							if( tag_title.toLowerCase().includes( search_term ) ) {
								tags_strings.push( GyanSitesAdmin._unescape_lower( tag_title ));
							}
						}
					}
				}

				if ( search_term != '' ) {

					// Check in page title.
					if( Object.keys( current_site['pages'] ).length ) {

						var pages = current_site['pages'];

						for( page_id in pages ) {

							var page_text_match = false;
							var page_category_match = true;
							var page_match_id = '';

							if ( '' != $filter_name ) {
								page_category_match = false;
							}

							// Check in site title.
							if( pages[page_id]['title'] ) {
								var page_title = GyanSitesAdmin._unescape_lower( pages[page_id]['title'] );

								if( page_title.includes( search_term ) ) {
									page_text_match = true;
									page_match_id = page_id;
								}
							}

							// Check in site tags.
							if( Object.keys( pages[page_id]['gyan-sites-tag'] ).length ) {
								for( page_tag_id in pages[page_id]['gyan-sites-tag'] ) {
									var tag_title = pages[page_id]['gyan-sites-tag'][page_tag_id];
										tag_title = GyanSitesAdmin._unescape_lower( tag_title.replace('-', ' ') );
									if( tag_title.toLowerCase().includes( search_term ) ) {
										page_text_match = true;
										page_match_id = page_id;
									}
								}
							}

							for( filter_id in GyanSitesAdmin.filter_array ) {
								var pslug = GyanSitesAdmin.filter_array[filter_id];
								if ( undefined != pslug ) {
									for( cat_id in current_site['gyan-site-category'] ) {
										if( pslug.toLowerCase() == current_site['gyan-site-category'][cat_id] ) {
											page_category_match = true;
											page_match_id = page_id;
										}
									}
								}
							}

							if ( '' != page_match_id ) {
								if ( page_text_match && page_category_match ) {
									items[page_id] = pages[page_id];
									items[page_id]['type'] = 'page';
									items[page_id]['site_id'] = site_id;
									items[page_id]['gyan-sites-type'] = current_site['gyan-sites-type'] || '';
									items[page_id]['site-title'] = current_site['title'] || '';
									items[page_id]['pages-count'] = 0;

									tags_strings.push( GyanSitesAdmin._unescape_lower( current_site['title'] ));

									for( site_tag_id in pages[page_id]['gyan-sites-tag'] ) {
										var tag_title = pages[page_id]['gyan-sites-tag'][site_tag_id];
											tag_title = GyanSitesAdmin._unescape_lower( tag_title.replace('-', ' ') );
										if( tag_title.toLowerCase().includes( search_term ) ) {
											tags_strings.push( GyanSitesAdmin._unescape_lower( tag_title ) );
										}
									}
								}
							}
						}
					}
				}
			}

			if ( search_term != '' ) {
				console.groupCollapsed( 'Search for "' + search_term + '"' );
				GyanSitesAdmin._log( items );
				console.groupEnd();
			}

			if ( tags_strings.length > 0 ) {
				GyanSitesAdmin.autocompleteTags = tags_strings;
				GyanSitesAdmin._autocomplete();
			}

			return items;
		},

		_close_page_builder_list: function( event ) {
			event.preventDefault();
			$('body').removeClass( 'showing-page-builders' );
			$('.page-builder-icon').removeClass( 'active' );
		},

		_sync_library_complete: function() {
			$.ajax({
				url  : gyanSitesVars.ajaxurl,
				type : 'POST',
				data : {
					action : 'gyan-sites-update-library-complete',
				},
			}).done(function ( response ) {
				GyanSitesAdmin._log( response );
				console.groupEnd( 'Update Library Request' );
			});
		},

		_sync_library_with_ajax: function( is_append ) {
			$.ajax({
				url  : gyanSitesVars.ajaxurl,
				type : 'POST',
				data : {
					action : 'gyan-sites-get-sites-request-count',
				},
				beforeSend: function() {
					console.groupCollapsed( 'Refresh Demos' );
					GyanSitesAdmin._log( 'Refresh Demos..' );
				},
			})
			.fail(function( jqXHR ){
				GyanSitesAdmin._log( jqXHR, 'error' );
				GyanSitesAdmin._importFailMessage( jqXHR.status + jqXHR.statusText, 'Site Count Request Failed!', jqXHR );
				console.groupEnd('Refresh Demos');
		    })
			.done(function ( response ) {
				GyanSitesAdmin._log( response );
				if( response.success ) {
					var total = response.data;
					GyanSitesAdmin._log( total );
					for( let i = 1; i <= total; i++ ) {

						GyanSitesAjaxQueue.add({
							url: gyanSitesVars.ajaxurl,
							type: 'POST',
							data: {
								action  : 'gyan-sites-import-sites',
								page_no : i,
							},
							success: function( result ){
								GyanSitesAdmin._log( result );

								if( is_append ) {
									if( ! GyanSitesAdmin.isEmpty( result.data ) ) {

										var template = wp.template( 'gyan-sites-page-builder-sites' );

										// First fill the placeholders and then append remaining sites.
										if( $('.placeholder-site').length ) {
											for( site_id in result.data ) {
												if( $('.placeholder-site').length ) {
													$('.placeholder-site').first().remove();
												}
											}
											if( $('#gyan-sites .site-single:not(.placeholder-site)').length ) {
												$('#gyan-sites .site-single:not(.placeholder-site)').last().after( template( result.data ) );
											} else {
												$('#gyan-sites').prepend( template( result.data ) );  // for loop will run on this template and display all thumbnails as per per_page parameter
											}
										} else {
											$('#gyan-sites').append( template( result.data ) );  // for loop will run on this template and display all thumbnails as per per_page parameter
										}

										gyanSitesVars.default_page_builder_sites = $.extend({}, gyanSitesVars.default_page_builder_sites, result.datadata);

										GyanSitesAdmin._load_large_images();
										// $( document ).trigger( 'gyan-sites-added-pages' );
									}

								}

								if( i === total && gyanSitesVars.strings.syncCompleteMessage ) {

									console.groupEnd('Refresh Demos');
									$('#wpbody-content').find('.gyan-sites-sync-library-message').remove();
									var noticeContent = wp.updates.adminNotice( {
										className: 'notice gyan-sites-notice notice-success is-dismissible gyan-sites-sync-library-message',
										message:   gyanSitesVars.strings.syncCompleteMessage + ' <button type="button" class="notice-dismiss"><span class="screen-reader-text">'+gyanSitesVars.dismiss+'</span></button>',
									} );
									$('#screen-meta').after( noticeContent );
									$(document).trigger( 'wp-updates-notice-added' );

									$('.gyan-sites-sync-library-button').removeClass( 'updating-message');
								}
							}
						});
					}

					// Run the AJAX queue.
					GyanSitesAjaxQueue.run();
				} else {
					GyanSitesAdmin._importFailMessage( response.data, 'Site Count Request Failed!' );
				}
			});

			// Import categories.
			$.ajax({
				url  : gyanSitesVars.ajaxurl,
				type : 'POST',
				data : {
					action : 'gyan-sites-import-categories',
				},
				beforeSend: function() {
					console.groupCollapsed( 'Importing Categories' );
					GyanSitesAdmin._log( 'Importing Categories..' );
				},
			})
			.fail(function( jqXHR ){
				GyanSitesAdmin._log( jqXHR );
				GyanSitesAdmin._importFailMessage( jqXHR.status + jqXHR.statusText, 'Category Import Failed!', jqXHR );
				console.groupEnd( 'Importing Categories' );
			}).done(function ( response ) {
				GyanSitesAdmin._log( response );
				console.groupEnd( 'Importing Categories' );
			});

			// Import Site Categories.
			$.ajax({
				url  : gyanSitesVars.ajaxurl,
				type : 'POST',
				data : {
					action : 'gyan-sites-import-site-categories',
				},
				beforeSend: function() {
					console.groupCollapsed( 'Importing Site Categories' );
					GyanSitesAdmin._log( 'Importing Site Categories..' );
				},
			})
			.fail(function( jqXHR ){
				GyanSitesAdmin._log( jqXHR );
				GyanSitesAdmin._importFailMessage( jqXHR.status + jqXHR.statusText, 'Category Import Failed!', jqXHR );
				console.groupCollapsed( 'Importing Site Categories' );
			}).done(function ( response ) {
				GyanSitesAdmin._log( response );
				console.groupCollapsed( 'Importing Site Categories' );
			});

			// Import page builders.
			$.ajax({
				url  : gyanSitesVars.ajaxurl,
				type : 'POST',
				data : {
					action : 'gyan-sites-import-page-builders',
				},
				beforeSend: function() {
					console.groupCollapsed( 'Importing Page Builders' );
					GyanSitesAdmin._log( 'Importing Page Builders..' );
				},
			})
			.fail(function( jqXHR ){
				GyanSitesAdmin._log( jqXHR );
				GyanSitesAdmin._importFailMessage( jqXHR.status + ' ' + jqXHR.statusText, 'Page Builder Import Failed!', jqXHR );
				console.groupEnd( 'Importing Page Builders' );
			}).done(function ( response ) {
				GyanSitesAdmin._log( response );
				console.groupEnd( 'Importing Page Builders' );
			});

			// Import Blocks.
			$.ajax({
				url  : gyanSitesVars.ajaxurl,
				type : 'POST',
				data : {
					action : 'gyan-sites-get-blocks-request-count',
				},
				beforeSend: function() {
					console.groupCollapsed( 'Updating Blocks' );
					GyanSitesAdmin._log( 'Updating Blocks' );
				},
			})
			.fail(function( jqXHR ){
				GyanSitesAdmin._log( jqXHR, 'error' );
				GyanSitesAdmin._importFailMessage( jqXHR.status + jqXHR.statusText, 'Blocks Count Request Failed!', jqXHR );
				console.groupEnd('Updating Blocks');
		    })
			.done(function ( response ) {
				GyanSitesAdmin._log( response );
				if( response.success ) {
					var total = response.data;
					GyanSitesAdmin._log( total );

					for( let i = 1; i <= total; i++ ) {
						GyanSitesAjaxQueue.add({
							url: gyanSitesVars.ajaxurl,
							type: 'POST',
							data: {
								action  : 'gyan-sites-import-blocks',
								page_no : i,
							},
							beforeSend: function() {
								console.groupCollapsed( 'Importing Blocks - Page ' + i );
								GyanSitesAdmin._log( 'Importing Blocks - Page ' + i );
							},
							success: function( response ){
								GyanSitesAdmin._log( response );
								console.groupEnd( 'Importing Blocks - Page ' + i );
							}
						});
					}

					// Run the AJAX queue.
					GyanSitesAjaxQueue.run();
				} else {
					GyanSitesAdmin._importFailMessage( response.data, 'Blocks Count Request Failed!' );
				}
			});

			// Import Block Categories.
			$.ajax({
				url  : gyanSitesVars.ajaxurl,
				type : 'POST',
				data : {
					action : 'gyan-sites-import-block-categories',
				},
				beforeSend: function() {
					console.groupCollapsed( 'Importing Block Categories' );
					GyanSitesAdmin._log( 'Importing Block Categories..' );
				},
			})
			.fail(function( jqXHR ){
				GyanSitesAdmin._log( jqXHR );
				GyanSitesAdmin._importFailMessage( jqXHR.status + ' ' + jqXHR.statusText, 'Category Import Failed!', jqXHR );
				console.groupEnd( 'Importing Block Categories' );
			}).done(function ( response ) {
				GyanSitesAdmin._log( response );
				console.groupEnd( 'Importing Block Categories' );
			});

			GyanSitesAdmin._sync_library_complete();
		},

		_sync_library: function( event ) {
			event.preventDefault();
			var button = $(this);

			if( button.hasClass( 'updating-message') ) {
				return;
			}

			button.addClass( 'updating-message');

			$('.gyan-sites-sync-library-message').remove();

			var noticeContent = wp.updates.adminNotice( {
				className: 'gyan-sites-sync-library-message gyan-sites-notice notice notice-info',
				message:  gyanSitesVars.syncLibraryStart + '<button type="button" class="notice-dismiss"><span class="screen-reader-text">'+gyanSitesVars.dismiss+'</span></button>',
			} );
			$('#screen-meta').after( noticeContent );

			$(document).trigger( 'wp-updates-notice-added' );

			$.ajax({
				url  : gyanSitesVars.ajaxurl,
				type : 'POST',
				data : {
					action : 'gyan-sites-update-library',
				},
				beforeSend: function() {
					console.groupCollapsed( 'Update Library Request' );
					GyanSitesAdmin._log( 'Updating Library..' );
				},
			})
			.fail(function( jqXHR ){
				GyanSitesAdmin._log( jqXHR );
				GyanSitesAdmin._importFailMessage( jqXHR.status + ' ' + jqXHR.statusText, 'Refresh Demos Failed!', jqXHR );
				console.groupEnd( 'Update Library Request' );
		    })
			.done(function ( response ) {
				console.log( response );

				if( response.success ) {
					if( 'updated' === response.data ) {

						$('#wpbody-content').find('.gyan-sites-sync-library-message').remove();
						var noticeContent = wp.updates.adminNotice( {
							className: 'notice gyan-sites-notice notice-success is-dismissible gyan-sites-sync-library-message',
							message:   gyanSitesVars.strings.syncCompleteMessage + ' <button type="button" class="notice-dismiss"><span class="screen-reader-text">'+gyanSitesVars.dismiss+'</span></button>',
						} );
						$('#screen-meta').after( noticeContent );
						$(document).trigger( 'wp-updates-notice-added' );
						button.removeClass( 'updating-message');
						GyanSitesAdmin._log( 'Already sync all the sites.' );
						console.groupEnd( 'Update Library Request' );
					} else {
						GyanSitesAdmin._sync_library_with_ajax();
					}
				} else {
					$('#wpbody-content').find('.gyan-sites-sync-library-message').remove();
					var noticeContent = wp.updates.adminNotice( {
						className: 'notice gyan-sites-notice notice-error is-dismissible gyan-sites-sync-library-message',
						message:   response.data + ' <button type="button" class="notice-dismiss"><span class="screen-reader-text">'+gyanSitesVars.dismiss+'</span></button>',
					} );
					$('#screen-meta').after( noticeContent );
					$(document).trigger( 'wp-updates-notice-added' );
					button.removeClass( 'updating-message');
					GyanSitesAdmin._log( 'Already sync all the sites.' );
					console.groupEnd( 'Update Library Request' );
				}
			});
		},

		_next_and_previous_sites: function(e) {

	        if( ! $('body').hasClass('gyan-previewing-single-pages') ) { return; }

	        if( e.key === "Escape") {
	        	GyanSitesAdmin.close_pages_popup();
	        	return;
	        }

	        switch(e.which) {

	            // Left Key Pressed
	            case 37:
	            		if( $('#gyan-sites .gyan-theme.current').prev().length ) {
		            		$('#gyan-sites .gyan-theme.current').prev().addClass('current').siblings().removeClass('current');
		  					var site_id = $('#gyan-sites .gyan-theme.current').prev().attr('data-site-id') || '';
		  					if( site_id ) {
		  						GyanSitesAdmin.show_pages_by_site_id( site_id );
		  					}
	            		}
	                break;

	            // Right Key Pressed
	            case 39:
	            		if( $('#gyan-sites .gyan-theme.current').next().length ) {
		            		$('#gyan-sites .gyan-theme.current').next().addClass('current').siblings().removeClass('current');
		  					var site_id = $('#gyan-sites .gyan-theme.current').next().attr('data-site-id') || '';
		  					if( site_id ) {
		  						GyanSitesAdmin.show_pages_by_site_id( site_id );
		  					}
	            		}
	                break;
	        }

		},

		show_pages_by_site_id: function( site_id, page_id ) {
			var sites = gyanSitesVars.default_page_builder_sites || [];
			var data = sites[site_id];
			console.log(data);

			if( 'undefined' !== typeof data ) {
				var site_template  = wp.template('gyan-sites-single-site-preview');

				if( ! GyanSitesAdmin._getParamFromURL( 'gyan-site' ) ) {
					var url_params = {
						'gyan-site' : site_id,
					};
					GyanSitesAdmin._changeAndSetURL( url_params );
				}

				$('#gyan-sites').hide();
				$('#site-pages').show().html( site_template( data ) ).removeClass('elementor gutenberg').addClass( gyanSitesVars.default_page_builder );

				$('body').addClass('gyan-previewing-single-pages');
				$('#site-pages').attr( 'data-site-id', site_id);

				if( GyanSitesAdmin._getParamFromURL( 'gyan-page' ) ) {
					GyanSitesAdmin._set_preview_screenshot_by_page( $('#single-pages .site-single[data-page-id="'+GyanSitesAdmin._getParamFromURL( 'gyan-page' )+'"]') );
				// Has first item?
				// Then set default screnshot in preview.
				} else if( page_id && $('#single-pages .site-single[data-page-id="'+page_id+'"]').length ) {
					GyanSitesAdmin._set_preview_screenshot_by_page( $('#single-pages .site-single[data-page-id="'+page_id+'"]') );
				} else if( $('#single-pages .site-single').eq( 0 ).length ) {
					GyanSitesAdmin._set_preview_screenshot_by_page( $('#single-pages .site-single').eq( 0 ) );
				}

				if( ! $('#single-pages .site-single').eq( 0 ).length ) {
					$('.site-import-layout-button').hide();
				}

				GyanSitesAdmin._load_large_images();
			}

		},

		_show_sites: function( event ) {
			event.preventDefault();

			$( 'body' ).removeClass( 'gyan-sites-no-search-result' );
			$( '.gyan-sites__category-filter-items' ).find( '.gyn-sites__filter-wrap' ).removeClass( 'category-active' );
			$( '.gyn-sites__filter-wrap' ).first().addClass( 'category-active' );
			$( '.gyan-sites__category-filter-anchor' ).attr( 'data-slug', '' );
			GyanSitesAdmin.filter_array = [];
			$( '#radio-all' ).trigger( 'click' );
			$( '#radio-all' ).addClass( 'active' );
			$( '.gyan-sites__category-filter-anchor' ).text( 'All' );
			GyanSitesAdmin._closeFilter();
			$( '#wp-filter-search-input' ).val( '' );
			$('#gyan-sites-admin').removeClass('searching');
			GyanSitesAdmin.add_sites( gyanSitesVars.default_page_builder_sites );
			GyanSitesAdmin.close_pages_popup();
			GyanSitesAdmin._load_large_images();
		},

		// Go back to all sites view
		_go_back: function( event ) {
			event.preventDefault();

			GyanSitesAdmin._clean_url_params( 'search' );
			GyanSitesAdmin.close_pages_popup();
			GyanSitesAdmin._load_large_images();
		},

		close_pages_popup: function( ) {
			gyanSitesVars.cpt_slug = 'gyan-sites';

			$('#gyan-sites').show();
			$('#site-pages').hide().html( '' );
			$('body').removeClass('gyan-previewing-single-pages');
			$('.gyan-sites-result-preview').hide();

			$('#gyan-sites .gyan-theme').removeClass('current');

			GyanSitesAdmin._clean_url_params( 'gyan-site' );
			GyanSitesAdmin._clean_url_params( 'gyan-page' );
		},

		_set_preview_screenshot_by_page: function( element ) {
			var large_img_url = $(element).find( '.theme-screenshot' ).attr( 'data-featured-src' ) || '';
			var url = $(element).find( '.theme-screenshot' ).attr( 'data-src' ) || '';
			var page_name = $(element).find('.theme-name').text() || '';

			$( element ).siblings().removeClass( 'current_page' );
			$( element ).addClass( 'current_page' );

			var page_id = $( element ).attr( 'data-page-id' ) || '';
			if( page_id ) {

				GyanSitesAdmin._clean_url_params( 'gyan-page' );

				var url_params = {
					'gyan-page' : page_id,
				};
				GyanSitesAdmin._changeAndSetURL( url_params );
			}

			$( '.site-import-layout-button' ).removeClass( 'disabled' );
			if( page_name ) {
				var title = gyanSitesVars.strings.importSingleTemplate.replace( '%s', page_name.trim() );
				$( '.site-import-layout-button' ).text( title );
			}

			if( url ) {
				$('.single-site-preview').animate({
			        scrollTop: 0
			    },0);
				$('.single-site-preview img').addClass('loading').attr( 'src', url );
				var imgLarge = new Image();
				imgLarge.src = large_img_url;
				imgLarge.onload = function () {
					$('.single-site-preview img').removeClass('loading');
					$('.single-site-preview img').attr('src', imgLarge.src );
				};
			}
		},

		// Preview Inner Pages for the Site
		_change_site_preview_screenshot: function( event ) {
			event.preventDefault();
			var item = $(this);

			GyanSitesAdmin._set_preview_screenshot_by_page( item );
		},

		_show_pages: function( event ) {
			var perent = $(this).parents('.gyan-theme');
			perent.siblings().removeClass('current');
			perent.addClass('current');

			var site_id = perent.attr('data-site-id') || '';
			GyanSitesAdmin.show_pages_by_site_id( site_id );
		},

		_apiAddParam_status: function() {
			if( gyanSitesVars.sites && gyanSitesVars.sites.status ) {
				GyanSitesAdmin._api_params['status'] = gyanSitesVars.sites.status;
			}
		},

		_apiAddParam_per_page: function() {
			// Add 'per_page'
			var per_page_val = 30;
			if( gyanSitesVars.sites && gyanSitesVars.sites["per-page"] ) {
				per_page_val = parseInt( gyanSitesVars.sites["per-page"] );
			}
			GyanSitesAdmin._api_params['per_page'] = per_page_val;
		},

		_apiAddParam_gyan_site_category: function() {
			// Add 'gyan-site-category'
			var selected_category_id = jQuery( '.filter-links[data-category="' + gyanSitesVars.category_slug + '"]' ).find('.current').data('group') || '';
			if( '' !== selected_category_id && 'all' !== selected_category_id ) {
				GyanSitesAdmin._api_params[gyanSitesVars.category_slug] =  selected_category_id;
			} else if( gyanSitesVars.sites && gyanSitesVars['categories'].include ) {
				if( GyanSitesAdmin._isArray( gyanSitesVars['categories'].include ) ) {
					GyanSitesAdmin._api_params[gyanSitesVars.category_slug] = gyanSitesVars['categories'].include.join(',');
				} else {
					GyanSitesAdmin._api_params[gyanSitesVars.category_slug] = gyanSitesVars['categories'].include;
				}
			}
		},

		_apiAddParam_gyan_page_parent_category: function() {

			// Add 'site-pages-parent-category'
			if ( '' == gyanSitesVars.parent_category) {
				return;
			}

			var selected_category_id = jQuery( '.filter-links[data-category="' + gyanSitesVars.parent_category + '"]' ).find('.current').data('group') || '';
			if( '' !== selected_category_id && 'all' !== selected_category_id ) {
				GyanSitesAdmin._api_params[gyanSitesVars.parent_category] =  selected_category_id;
			} else if( gyanSitesVars.sites && gyanSitesVars['categories'].include ) {
				if( GyanSitesAdmin._isArray( gyanSitesVars['categories'].include ) ) {
					GyanSitesAdmin._api_params[gyanSitesVars.parent_category] = gyanSitesVars['categories'].include.join(',');
				} else {
					GyanSitesAdmin._api_params[gyanSitesVars.parent_category] = gyanSitesVars['categories'].include;
				}
			}
		},

		_apiAddParam_gyan_site_page_builder: function() {
			// Add 'gyan-site-page-builder'
			var selected_page_builder_id = jQuery( '.filter-links[data-category="' + gyanSitesVars.page_builder + '"]' ).find('.current').data('group') || '';
			if( '' !== selected_page_builder_id && 'all' !== selected_page_builder_id ) {
				GyanSitesAdmin._api_params[gyanSitesVars.page_builder] =  selected_page_builder_id;
			} else if( gyanSitesVars.sites && gyanSitesVars['page-builders'].include ) {
				if( GyanSitesAdmin._isArray( gyanSitesVars['page-builders'].include ) ) {
					GyanSitesAdmin._api_params[gyanSitesVars.page_builder] = gyanSitesVars['page-builders'].include.join(',');
				} else {
					GyanSitesAdmin._api_params[gyanSitesVars.page_builder] = gyanSitesVars['page-builders'].include;
				}
			}
		},

		_apiAddParam_site_url: function() {
			if( gyanSitesVars.sites && gyanSitesVars.sites.site_url ) {
				GyanSitesAdmin._api_params['site_url'] = gyanSitesVars.sites.site_url;
			}
			GyanSitesAdmin._api_params['track'] = true;
		},

		_show_default_page_builder_sites: function() {

			if( ! $('#gyan-sites').length ) { return; }

			if( Object.keys( gyanSitesVars.default_page_builder_sites ).length ) {

				var search_term = GyanSitesAdmin._getParamFromURL('search');
				if( search_term ) {
					var items = GyanSitesAdmin._get_sites_and_pages_by_search_term( search_term );

					if( ! GyanSitesAdmin.isEmpty( items ) ) {
						GyanSitesAdmin.add_sites( items );
						$('#wp-filter-search-input').val( search_term );
					} else {
						$('#gyan-sites').html( gyanSitesVars.default_page_builder_sites );
					}

				} else {
					GyanSitesAdmin.add_sites( gyanSitesVars.default_page_builder_sites );
				}

				// Show single site preview.
				var site_id = GyanSitesAdmin._getParamFromURL('gyan-site');

				if( site_id ) {
					GyanSitesAdmin.show_pages_by_site_id( site_id );
				}
			} else {
				console.log('test;');
				var temp = [];
				for (var i = 0; i < 8; i++) {
					temp['id-' + i] = {
						'title' : 'Lorem Ipsum',
						'class' : 'placeholder-site',
					};
				}

				GyanSitesAdmin.add_sites( temp );
				$('#gyan-sites').addClass( 'temp' );

				GyanSitesAdmin._sync_library_with_ajax( true );
			}

		},

		add_sites_after_search: function( data ) {
			var template = wp.template( 'gyan-sites-page-builder-sites-search' );
			$('#gyan-sites').html( template( data ) );
			GyanSitesAdmin._load_large_images();
		},

		add_sites: function( data ) {
			var template = wp.template( 'gyan-sites-page-builder-sites' );
			$('#gyan-sites').html( template( data ) );
			GyanSitesAdmin._load_large_images();
		},

		_toggle_tooltip: function( event ) {
			event.preventDefault();
			var tip_id = $( this ).data('tip-id') || '';
			if( tip_id && $( '#' + tip_id ).length ) {
				$( '#' + tip_id ).toggle();
			}
		},

		_resetData: function() {
			$('.install-theme-info').hide();
			$('.gyn-importing-wrap').show();
			GyanSitesAdmin.import_start_time = new Date();

			$(this).addClass('updating-message installing').text( 'Importing..' );
			$('body').addClass('importing-site');

			var output = '<div class="current-importing-status-title"></div><div class="current-importing-status-description"></div>';
			$('.current-importing-status').html( output );

			$.ajax({
				url  : gyanSitesVars.ajaxurl,
				type : 'POST',
				data : {
					action : 'gyan-sites-set-reset-data',
					_ajax_nonce : gyanSitesVars._ajax_nonce,
				},
				beforeSend: function() {
					console.groupCollapsed( 'Site Reset Data' );
				},
			})
			.done(function ( response ) {
				console.log( 'List of Reset Items:' );
				GyanSitesAdmin._log( response );
				console.groupEnd();
				if( response.success ) {
					GyanSitesAdmin.site_imported_data = response.data;

					// Process Bulk Plugin Install & Activate.
					GyanSitesAdmin._bulkPluginInstallActivate();
				}
			});

		},

		_remove_skip_and_import_popup: function( event ) {
			event.preventDefault();

			$(this).parents('.skip-and-import').addClass('hide-me visited');

			if( $('.skip-and-import.hide-me').not('.visited').length ) {
				$('.skip-and-import.hide-me').not('.visited').first().removeClass('hide-me');
			} else {
				$('.gyan-sites-result-preview .default').removeClass('hide-me');

				if( $('.gyan-sites-result-preview').hasClass('import-page') ) {
					GyanSitesAdmin.skip_and_import_popups = [];

					var notinstalled = GyanSitesAdmin.required_plugins.notinstalled || 0;
					if( ! notinstalled.length ) {
						GyanSitesAdmin.import_page_process();
					}
				}
			}
		},

		_start_site_import: function() {
			if ( GyanSitesAdmin._is_reset_data() ) {
				$(document).trigger( 'gyan-sites-reset-data' );
			} else {
				$(document).trigger( 'gyan-sites-reset-data-done' );
			}
		},

		_reset_customizer_data: function() {
			$.ajax({
				url  : gyanSitesVars.ajaxurl,
				type : 'POST',
				data : {
					action : 'gyan-sites-reset-customizer-data',
					_ajax_nonce      : gyanSitesVars._ajax_nonce,
				},
				beforeSend: function() {
					console.groupCollapsed( 'Reseting Customizer Data' );
					GyanSitesAdmin._log_title( 'Reseting Customizer Data..' );
					// console.log( '# Reseting Customizer Data..' );
				},
			})
			.fail(function( jqXHR ){
				GyanSitesAdmin._log( jqXHR );
				GyanSitesAdmin._importFailMessage( jqXHR.status + ' ' + jqXHR.statusText, 'Reset Customizer Settings Failed!', jqXHR );
				console.groupEnd();
		    })
			.done(function ( data ) {
				GyanSitesAdmin._log( data );
				GyanSitesAdmin._log_title( 'Complete Resetting Customizer Data..' );
				GyanSitesAdmin._log( 'Complete Resetting Customizer Data..' );
				console.groupEnd();
				$(document).trigger( 'gyan-sites-reset-customizer-data-done' );
			});
		},

		_reset_site_options: function() {
			// Site Options.
			$.ajax({
				url  : gyanSitesVars.ajaxurl,
				type : 'POST',
				data : {
					action : 'gyan-sites-reset-site-options',
					_ajax_nonce      : gyanSitesVars._ajax_nonce,
				},
				beforeSend: function() {
					console.groupCollapsed( 'Reseting Site Options' );
					GyanSitesAdmin._log_title( 'Reseting Site Options..' );
					// console.log( '# Reseting Site Options..' );
				},
			})
			.fail(function( jqXHR ){
				GyanSitesAdmin._log( jqXHR );
				GyanSitesAdmin._importFailMessage( jqXHR.status + ' ' + jqXHR.statusText, 'Reset Site Options Failed!', jqXHR );
				console.groupEnd();
		    })
			.done(function ( data ) {
				GyanSitesAdmin._log( data );
				GyanSitesAdmin._log_title( 'Complete Reseting Site Options..' );
				console.groupEnd();
				$(document).trigger( 'gyan-sites-reset-site-options-done' );
			});
		},

		_reset_widgets_data: function() {
			// Widgets.
			$.ajax({
				url  : gyanSitesVars.ajaxurl,
				type : 'POST',
				data : {
					action : 'gyan-sites-reset-widgets-data',
					_ajax_nonce      : gyanSitesVars._ajax_nonce,
				},
				beforeSend: function() {
					console.groupCollapsed( 'Reseting Widgets' );
					GyanSitesAdmin._log_title( 'Reseting Widgets..' );
					// console.log( '# Reseting Widgets..' );
				},
			})
			.fail(function( jqXHR ){
				GyanSitesAdmin._log( jqXHR );
				GyanSitesAdmin._importFailMessage( jqXHR.status + ' ' + jqXHR.statusText, 'Reset Widgets Data Failed!', jqXHR );
				console.groupEnd();
		    })
			.done(function ( data ) {
				GyanSitesAdmin._log( data );
				GyanSitesAdmin._log_title( 'Complete Reseting Widgets..' );
				console.groupEnd();
				$(document).trigger( 'gyan-sites-reset-widgets-data-done' );
			});
		},

		_reset_posts: function() {
			if( GyanSitesAdmin.site_imported_data['reset_posts'].length ) {

				GyanSitesAdmin.reset_remaining_posts = GyanSitesAdmin.site_imported_data['reset_posts'].length;

				console.groupCollapsed( 'Deleting Posts' );
				GyanSitesAdmin._log_title( 'Deleting Posts..' );

				$.each( GyanSitesAdmin.site_imported_data['reset_posts'], function(index, post_id) {

					GyanSitesAjaxQueue.add({
						url: gyanSitesVars.ajaxurl,
						type: 'POST',
						data: {
							action  : 'gyan-sites-delete-posts',
							post_id : post_id,
							_ajax_nonce      : gyanSitesVars._ajax_nonce,
						},
						success: function( result ){

							if( GyanSitesAdmin.reset_processed_posts < GyanSitesAdmin.site_imported_data['reset_posts'].length ) {
								GyanSitesAdmin.reset_processed_posts+=1;
							}

							GyanSitesAdmin._log_title( 'Deleting Post ' + GyanSitesAdmin.reset_processed_posts + ' of ' + GyanSitesAdmin.site_imported_data['reset_posts'].length + '<br/>' + result.data );

							GyanSitesAdmin.reset_remaining_posts-=1;
							if( 0 == GyanSitesAdmin.reset_remaining_posts ) {
								console.groupEnd();
								$(document).trigger( 'gyan-sites-delete-posts-done' );
								$(document).trigger( 'gyan-sites-reset-data-done' );
							}
						}
					});
				});
				GyanSitesAjaxQueue.run();

			} else {
				$(document).trigger( 'gyan-sites-delete-posts-done' );
				$(document).trigger( 'gyan-sites-reset-data-done' );
			}
		},

		_reset_wp_forms: function() {
			if( GyanSitesAdmin.site_imported_data['reset_wp_forms'].length ) {
				GyanSitesAdmin.reset_remaining_wp_forms = GyanSitesAdmin.site_imported_data['reset_wp_forms'].length;

				console.groupCollapsed( 'Deleting WP Forms' );
				GyanSitesAdmin._log_title( 'Deleting WP Forms..' );

				$.each( GyanSitesAdmin.site_imported_data['reset_wp_forms'], function(index, post_id) {
					GyanSitesAjaxQueue.add({
						url: gyanSitesVars.ajaxurl,
						type: 'POST',
						data: {
							action  : 'gyan-sites-delete-wp-forms',
							post_id : post_id,
							_ajax_nonce      : gyanSitesVars._ajax_nonce,
						},
						success: function( result ){

							if( GyanSitesAdmin.reset_processed_wp_forms < GyanSitesAdmin.site_imported_data['reset_wp_forms'].length ) {
								GyanSitesAdmin.reset_processed_wp_forms+=1;
							}

							GyanSitesAdmin._log_title( 'Deleting Form ' + GyanSitesAdmin.reset_processed_wp_forms + ' of ' + GyanSitesAdmin.site_imported_data['reset_wp_forms'].length + '<br/>' + result.data );
							GyanSitesAdmin._log( 'Deleting Form ' + GyanSitesAdmin.reset_processed_wp_forms + ' of ' + GyanSitesAdmin.site_imported_data['reset_wp_forms'].length + '<br/>' + result.data );

							GyanSitesAdmin.reset_remaining_wp_forms-=1;
							if( 0 == GyanSitesAdmin.reset_remaining_wp_forms ) {
								console.groupEnd();
								$(document).trigger( 'gyan-sites-delete-wp-forms-done' );
							}
						}
					});
				});
				GyanSitesAjaxQueue.run();

			} else {
				$(document).trigger( 'gyan-sites-delete-wp-forms-done' );
			}
		},

		_reset_terms: function() {

			if( GyanSitesAdmin.site_imported_data['reset_terms'].length ) {
				GyanSitesAdmin.reset_remaining_terms = GyanSitesAdmin.site_imported_data['reset_terms'].length;

				console.groupCollapsed( 'Deleting Terms' );
				GyanSitesAdmin._log_title( 'Deleting Terms..' );

				$.each( GyanSitesAdmin.site_imported_data['reset_terms'], function(index, term_id) {
					GyanSitesAjaxQueue.add({
						url: gyanSitesVars.ajaxurl,
						type: 'POST',
						data: {
							action  : 'gyan-sites-delete-terms',
							term_id : term_id,
							_ajax_nonce      : gyanSitesVars._ajax_nonce,
						},
						success: function( result ){
							if( GyanSitesAdmin.reset_processed_terms < GyanSitesAdmin.site_imported_data['reset_terms'].length ) {
								GyanSitesAdmin.reset_processed_terms+=1;
							}

							GyanSitesAdmin._log_title( 'Deleting Term ' + GyanSitesAdmin.reset_processed_terms + ' of ' + GyanSitesAdmin.site_imported_data['reset_terms'].length + '<br/>' + result.data );
							GyanSitesAdmin._log( 'Deleting Term ' + GyanSitesAdmin.reset_processed_terms + ' of ' + GyanSitesAdmin.site_imported_data['reset_terms'].length + '<br/>' + result.data );

							GyanSitesAdmin.reset_remaining_terms-=1;
							if( 0 == GyanSitesAdmin.reset_remaining_terms ) {
								console.groupEnd();
								$(document).trigger( 'gyan-sites-delete-terms-done' );
							}
						}
					});
				});
				GyanSitesAjaxQueue.run();
			} else {
				$(document).trigger( 'gyan-sites-delete-terms-done' );
			}

		},

		_toggle_reset_notice: function() {
			if ( $( this ).is(':checked') ) {
				$('#gyan-sites-tooltip-reset-data').show();
			} else {
				$('#gyan-sites-tooltip-reset-data').hide();
			}
		},

		_backup_before_rest_options: function() {
			GyanSitesAdmin._backupOptions( 'gyan-sites-backup-settings-before-reset-done' );
			GyanSitesAdmin.backup_taken = true;
		},

		_recheck_backup_options: function() {
			GyanSitesAdmin._backupOptions( 'gyan-sites-backup-settings-done' );
			GyanSitesAdmin.backup_taken = true;
		},

		_backupOptions: function( trigger_name ) {

			// Customizer backup is already taken then return.
			if( GyanSitesAdmin.backup_taken ) {
				$( document ).trigger( trigger_name );
			} else {

				$.ajax({
					url  : gyanSitesVars.ajaxurl,
					type : 'POST',
					data : {
						action : 'gyan-sites-backup-settings',
						_ajax_nonce      : gyanSitesVars._ajax_nonce,
					},
					beforeSend: function() {
						console.groupCollapsed( 'Processing Customizer Settings Backup' );
						GyanSitesAdmin._log_title( 'Processing Customizer Settings Backup..' );
					},
				})
				.fail(function( jqXHR ){
					GyanSitesAdmin._log( jqXHR );
					GyanSitesAdmin._importFailMessage( jqXHR.status + ' ' + jqXHR.statusText, 'Backup Customizer Settings Failed!', jqXHR );
					console.groupEnd();
			    })
				.done(function ( data ) {
					GyanSitesAdmin._log( data );

					// 1. Pass - Import Customizer Options.
					GyanSitesAdmin._log_title( 'Customizer Settings Backup Done..' );

					console.groupEnd();
					// Custom trigger.
					$(document).trigger( trigger_name );
				});
			}

		},

		// Import Complete
		_importEnd: function( event ) {

			$.ajax({
				url  : gyanSitesVars.ajaxurl,
				type : 'POST',
				dataType: 'json',
				data : {
					action : 'gyan-sites-import-end',
					_ajax_nonce      : gyanSitesVars._ajax_nonce,
				},
				beforeSend: function() {
					console.groupCollapsed( 'Import Complete!' );
					GyanSitesAdmin._log_title( 'Import Complete!' );
					// console.groupCollapsed( 'Import Complete!' );
				}
			})
			.fail(function( jqXHR ){
				GyanSitesAdmin._log( jqXHR );
				GyanSitesAdmin._importFailMessage( jqXHR.status + ' ' + jqXHR.statusText, 'Import Complete Failed!', jqXHR );
				console.groupEnd();
		    })
			.done(function ( response ) {
				GyanSitesAdmin._log( response );
				console.groupEnd();

				// 5. Fail - Import Complete.
				if( false === response.success ) {
					GyanSitesAdmin._importFailMessage( response.data, 'Import Complete Failed!' );
				} else {
					GyanSitesAdmin.site_import_status = true;
					GyanSitesAdmin.import_complete();
				}
			});
		},

		page_import_complete: function() {
			$('body').removeClass('importing-site');
			$('.rotating, .current-importing-status-wrap,.notice-warning').remove();
			var template = wp.template('gyan-sites-page-import-success');
			$('.gyan-sites-result-preview .inner').html( template( GyanSitesAdmin.imported_page_data ) );

			GyanSitesAdmin.page_import_status = false;
			console.log('Page import complete.');
		},

		import_complete: function() {
			$('body').removeClass('importing-site');

			var template = wp.template('gyan-sites-site-import-success');
			$('.gyan-sites-result-preview .inner').html( template() );

			$('.rotating,.current-importing-status-wrap,.notice-warning').remove();
			$('.gyan-sites-result-preview').addClass('gyan-sites-result-preview');

			// 5. Pass - Import Complete.
			GyanSitesAdmin._importSuccessButton();

			GyanSitesAdmin.site_import_status = false;
		},

		_importWidgets: function( event ) {
			if ( GyanSitesAdmin._is_process_widgets() ) {
				$.ajax({
					url  : gyanSitesVars.ajaxurl,
					type : 'POST',
					dataType: 'json',
					data : {
						action       : 'gyan-sites-import-widgets',
						widgets_data : GyanSitesAdmin.widgets_data,
						_ajax_nonce  : gyanSitesVars._ajax_nonce,
					},
					beforeSend: function() {
						console.groupCollapsed( 'Importing Widgets' );
						GyanSitesAdmin._log_title( 'Importing Widgets..' );
					},
				})
				.fail(function( jqXHR ){
					GyanSitesAdmin._log( jqXHR );
					GyanSitesAdmin._importFailMessage( jqXHR.status + ' ' + jqXHR.statusText, 'Import Widgets Failed!', jqXHR );
					console.groupEnd();
			    })
				.done(function ( response ) {
					GyanSitesAdmin._log( response );
					console.groupEnd();

					// 4. Fail - Import Widgets.
					if( false === response.success ) {
						GyanSitesAdmin._importFailMessage( response.data, 'Import Widgets Failed!' );

					} else {

						// 4. Pass - Import Widgets.
						$(document).trigger( 'gyan-sites-import-widgets-done' );
					}
				});
			} else {
				$(document).trigger( 'gyan-sites-import-widgets-done' );
			}
		},

		/**
		 * 5. Import Sliders.
		 */
		_importSliders: function( event ) {
			if ( GyanSitesAdmin._is_process_sliders() ) {
				$.ajax({
					url  : gyanSitesVars.ajaxurl,
					type : 'POST',
					dataType: 'json',
					data : {
						action       : 'gyan-sites-import-sliders',
						sliders_data : GyanSitesAdmin.sliders_data,
						_ajax_nonce  : gyanSitesVars._ajax_nonce,
					},
					beforeSend: function() {
						console.groupCollapsed( 'Importing Sliders' );
						GyanSitesAdmin._log_title( 'Importing Sliders..' );
					},
				})
				.fail(function( jqXHR ){
					GyanSitesAdmin._log( jqXHR );
					GyanSitesAdmin._importFailMessage( jqXHR.status + ' ' + jqXHR.statusText, 'Import Sliders Failed!', jqXHR );
					console.groupEnd();
			    })
				.done(function ( response ) {
					GyanSitesAdmin._log( response );
					console.groupEnd();

					// 4. Fail - Import Sliders.
					if( false === response.success ) {
						GyanSitesAdmin._importFailMessage( response.data, 'Import Sliders Failed!' );

					} else {

						// 4. Pass - Import Sliders.
						$(document).trigger( 'gyan-sites-import-sliders-done' );
					}
				});
			} else {
				$(document).trigger( 'gyan-sites-import-sliders-done' );
			}
		},

		importPageSlider: function( event ) {
			$.ajax({
				url  : gyanSitesVars.ajaxurl,
				type : 'POST',
				dataType: 'json',
				data : {
					action       : 'gyan-sites-import-sliders',
					sliders_data : GyanSitesAdmin.templateData['gyan-site-page-slider-path'],
					_ajax_nonce  : gyanSitesVars._ajax_nonce,
				},
				beforeSend: function() {
					console.groupCollapsed( 'Importing Slider' );
					GyanSitesAdmin._log_title( 'Importing Slider..' );
				},
			})
			.fail(function( jqXHR ){
				GyanSitesAdmin._log( jqXHR );
				GyanSitesAdmin._importFailMessage( jqXHR.status + ' ' + jqXHR.statusText, 'Import Slider Failed!', jqXHR );
				console.groupEnd();
		    })
			.done(function ( response ) {
				GyanSitesAdmin._log( response );
				console.groupEnd();

				// 4. Fail - Import Sliders.
				if( false === response.success ) {
					GyanSitesAdmin._importFailMessage( response.data, 'Import Slider Failed!' );
				} else {
					// 4. Pass - Import Sliders.
					GyanSitesAdmin.page_import_complete();
				}
			});
		},

		import_siteOptions: function( event ) {

			if ( GyanSitesAdmin._is_process_xml() ) {
				$.ajax({
					url  : gyanSitesVars.ajaxurl,
					type : 'POST',
					dataType: 'json',
					data : {
						action       : 'gyan-sites-import-options',
						options_data : GyanSitesAdmin.options_data,
						_ajax_nonce      : gyanSitesVars._ajax_nonce,
					},
					beforeSend: function() {
						console.groupCollapsed( 'Importing Options' );
						GyanSitesAdmin._log_title( 'Importing Options..' );
						$('.gyan-demo-import .percent').html('');
					},
				})
				.fail(function( jqXHR ){
					GyanSitesAdmin._log( jqXHR );
					GyanSitesAdmin._importFailMessage( jqXHR.status + ' ' + jqXHR.statusText, 'Import Site Options Failed!', jqXHR );
					console.groupEnd();
			    })
				.done(function ( response ) {
					GyanSitesAdmin._log( response );
					// 3. Fail - Import Site Options.
					if( false === response.success ) {
						GyanSitesAdmin._importFailMessage( response.data, 'Import Site Options Failed!' );
						console.groupEnd();
					} else {
						console.groupEnd();

						// 3. Pass - Import Site Options.
						$(document).trigger( 'gyan-sites-import-options-done' );
					}
				});
			} else {
				$(document).trigger( 'gyan-sites-import-options-done' );
			}
		},

		// Prepare XML Data
		_importXML: function() {

			if ( GyanSitesAdmin._is_process_xml() ) {
				$.ajax({
					url  : gyanSitesVars.ajaxurl,
					type : 'POST',
					dataType: 'json',
					data : {
						action  : 'gyan-sites-import-prepare-xml',
						wxr_url : GyanSitesAdmin.wxr_url,
						_ajax_nonce : gyanSitesVars._ajax_nonce,
					},
					beforeSend: function() {
						console.groupCollapsed( 'Importing Content' );
						GyanSitesAdmin._log_title( 'Importing Content..' );
						GyanSitesAdmin._log( GyanSitesAdmin.wxr_url );
						$('.gyan-site-import-process-wrap').show();
					},
				})
				.fail(function( jqXHR ){
					GyanSitesAdmin._log( jqXHR );
					GyanSitesAdmin._importFailMessage( jqXHR.status + ' ' + jqXHR.statusText, 'Prepare Import XML Failed!', jqXHR );
					console.groupEnd();
			    })
				.done(function ( response ) {

					GyanSitesAdmin._log( response );

					// 2. Fail - Prepare XML Data.
					if( false === response.success ) {
						var error_msg = response.data.error || response.data;

						GyanSitesAdmin._importFailMessage( gyanSitesVars.xmlRequiredFilesMissing );

						console.groupEnd();
					} else {

						var xml_processing = $('.gyan-demo-import').attr( 'data-xml-processing' );

						if( 'yes' === xml_processing ) {
							return;
						}

						$('.gyan-demo-import').attr( 'data-xml-processing', 'yes' );

						// 2. Pass - Prepare XML Data.

						// Import XML though Event Source.
						GyanSSEImport.data = response.data;
						GyanSSEImport.render();

						$('.current-importing-status-description').html('').show();

						$('.current-importing-status-wrap').append('<div class="gyan-site-import-process-wrap"><progress class="gyan-site-import-process" max="100" value="0"></progress></div>');

						var evtSource = new EventSource( GyanSSEImport.data.url );
						evtSource.onmessage = function ( message ) {
							var data = JSON.parse( message.data );
							switch ( data.action ) {
								case 'updateDelta':

										GyanSSEImport.updateDelta( data.type, data.delta );
									break;

								case 'complete':
									evtSource.close();

									$('.current-importing-status-description').hide();
									$('.gyan-demo-import').removeAttr( 'data-xml-processing' );

									document.getElementsByClassName("gyan-site-import-process").value = '100';

									$('.gyan-site-import-process-wrap').hide();
									console.groupEnd();

									$(document).trigger( 'gyan-sites-import-xml-done' );

									break;
							}
						};
						evtSource.onerror = function( error ) {
							evtSource.close();
							console.log( error );
							GyanSitesAdmin._importFailMessage('', 'Import Process Interrupted');
						};
						evtSource.addEventListener( 'log', function ( message ) {
							var data = JSON.parse( message.data );
							var message = data.message || '';
							if( message && 'info' === data.level ) {
								message = message.replace(/"/g, function(letter) {
								    return '';
								});
								$('.current-importing-status-description').html( message );
							}
							GyanSitesAdmin._log( message, data.level );
						});
					}
				});
			} else {
				$(document).trigger( 'gyan-sites-import-xml-done' );
			}
		},

		_is_reset_data: function() {
			if ( $( '.gyan-sites-reset-data' ).find('.checkbox').is(':checked') ) {
				return true;
			}
			return false;
		},

		_is_process_xml: function() {
			if ( $( '.gyan-sites-import-xml' ).find('.checkbox').is(':checked') ) {
				return true;
			}
			return false;
		},

		_is_process_customizer: function() {
			var customizer_status = $( '.gyan-sites-import-customizer' ).find('.checkbox').is(':checked');
			if ( customizer_status ) {
				return true;
			}
			return false;
		},

		_is_process_widgets: function() {
			if ( $( '.gyan-sites-import-widgets' ).find('.checkbox').is(':checked') ) {
				return true;
			}
			return false;
		},

		_is_process_sliders: function() {
			if ( $( '.gyan-sites-import-sliders' ).find('.checkbox').is(':checked') ) {
				return true;
			}
			return false;
		},

		_importCustomizerSettings: function( event ) {
			if ( GyanSitesAdmin._is_process_customizer() ) {
				$.ajax({
					url  : gyanSitesVars.ajaxurl,
					type : 'POST',
					dataType: 'json',
					data : {
						action          : 'gyan-sites-import-customizer-settings',
						customizer_data : GyanSitesAdmin.customizer_data,
						_ajax_nonce      : gyanSitesVars._ajax_nonce,
					},
					beforeSend: function() {
						console.groupCollapsed( 'Importing Customizer Settings');
						GyanSitesAdmin._log_title( 'Importing Customizer Settings..');
						GyanSitesAdmin._log( JSON.parse( GyanSitesAdmin.customizer_data ) );
					},
				})
				.fail(function( jqXHR ){
					GyanSitesAdmin._log( jqXHR );
					GyanSitesAdmin._importFailMessage( jqXHR.status + ' ' + jqXHR.statusText, 'Import Customizer Settings Failed!', jqXHR );
					console.groupEnd();
			    })
				.done(function ( response ) {
					GyanSitesAdmin._log( response );

					// 1. Fail - Import Customizer Options.
					if( false === response.success ) {
						GyanSitesAdmin._importFailMessage( response.data, 'Import Customizer Settings Failed!' );
						console.groupEnd();
					} else {
						console.groupEnd();
						// 1. Pass - Import Customizer Options.
						$(document).trigger( 'gyan-sites-import-customizer-settings-done' );
					}
				});
			} else {
				$(document).trigger( 'gyan-sites-import-customizer-settings-done' );
			}

		},

		_importSuccessButton: function() {
			$('.gyan-demo-import').removeClass('updating-message installing')
				.removeAttr('data-import')
				.addClass('view-site')
				.removeClass('gyan-demo-import')
				.text( gyanSitesVars.strings.viewSite )
				.attr('target', '_blank')
				.append('<i class="dashicons dashicons-external"></i>')
				.attr('href', gyanSitesVars.siteURL );
		},

		// Import Error Button
		_importFailMessage: function( message, heading, jqXHR, topContent ) {

			heading = heading || 'The import process interrupted';

			var status_code = '';
			if( jqXHR ) {
				status_code = jqXHR.status ? parseInt( jqXHR.status ) : '';
			}

			if( 200 == status_code && gyanSitesVars.debug ) {
				var output = gyanSitesVars.importFailedMessageDueToDebug;

			} else {
				var output  = topContent || gyanSitesVars.importFailedMessage;

				if( message ) {
					output += '<div class="current-importing-status">Error: ' + message +'</div>';
				}
			}

			$('.gyan-sites-import-content').html( output );
			$('.gyan-sites-result-preview .heading h3').html( heading );

			$('.gyan-demo-import').removeClass('updating-message installing button-primary').addClass('disabled').text('Import Failed!');
		},

		ucwords: function( str ) {
			if( ! str ) {
				return '';
			}

			str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
			    return letter.toUpperCase();
			});

			str = str.replace(/-/g, function(letter) {
			    return ' ';
			});

			return str;
		},

		_installSuccess: function( event, response ) {

			event.preventDefault();
			console.groupEnd();

			// Reset not installed plugins list.
			var pluginsList = gyanSitesVars.requiredPlugins.notinstalled;
			gyanSitesVars.requiredPlugins.notinstalled = GyanSitesAdmin._removePluginFromQueue( response.slug, pluginsList );

			// WordPress adds "Activate" button after waiting for 1000ms. So we will run our activation after that.
			setTimeout( function() {

				console.groupCollapsed('Activating Plugin "' + response.name + '"' );

				GyanSitesAdmin._log_title( 'Activating Plugin - ' + response.name );
				GyanSitesAdmin._log( 'Activating Plugin - ' + response.name );

				$.ajax({
					url: gyanSitesVars.ajaxurl,
					type: 'POST',
					data: {
						'action'            : 'gyan-required-plugin-activate',
						'init'              : response.init,
						'options'           : GyanSitesAdmin.options_data,
						'enabledExtensions' : GyanSitesAdmin.enabled_extensions,
						'_ajax_nonce'      : gyanSitesVars._ajax_nonce,
					},
				})
				.done(function (result) {
					GyanSitesAdmin._log( result );

					if( result.success ) {
						var pluginsList = gyanSitesVars.requiredPlugins.inactive;

						GyanSitesAdmin._log_title( 'Successfully Activated Plugin - ' + response.name );
						GyanSitesAdmin._log( 'Successfully Activated Plugin - ' + response.name );

						// Reset not installed plugins list.
						gyanSitesVars.requiredPlugins.inactive = GyanSitesAdmin._removePluginFromQueue( response.slug, pluginsList );

						// Enable Demo Import Button
						GyanSitesAdmin._enable_demo_import_button();
					}
					console.groupEnd();
				});

			}, 1200 );

		},

		// Plugin Installation Error
		_installError: function( event, response ) {

			event.preventDefault();
			console.log( event );
			console.log( response );

			$('.gyan-sites-result-preview .heading h3').text( 'Plugin Installation Failed' );
			$('.gyan-sites-import-content').html( '<p>Plugin "<b>' + response.name + '</b>" installation failed.</p><p>There has been an error on your website. Please install and activate required pluign from <strong>Admin > Appearance > Install Plugins</strong>. Read an article <a href="https://bizixdocs.premiumthemes.in/3-plugins-installation/" target="blank">here</a> for more details.</p>' );

			$('.gyan-demo-import').removeClass('updating-message installing button-primary').addClass('disabled').text('Import Failed!');

			wp.updates.queue = [];
			wp.updates.queueChecker();
			console.groupEnd();
		},

		_pluginInstalling: function(event, args) {
			event.preventDefault();

			console.groupCollapsed('Installing Plugin "'+args.name+'"');

			GyanSitesAdmin._log_title( 'Installing Plugin - ' + args.name );

			console.log( args );
		},

		_bulkPluginInstallActivate: function() {
			if( 0 === Object.keys( gyanSitesVars.requiredPlugins ).length ) {
				return;
			}

			// If has class the skip-plugins then,
			// Avoid installing 3rd party plugins.
			var not_installed = gyanSitesVars.requiredPlugins.notinstalled || '';
			if( $('.gyan-sites-result-preview').hasClass('skip-plugins') ) {
				not_installed = [];
			}
			var activate_plugins = gyanSitesVars.requiredPlugins.inactive || '';

			// First Install Bulk.
			if( not_installed.length > 0 ) {
				GyanSitesAdmin._installAllPlugins( not_installed );
			}

			// Second Activate Bulk.
			if( activate_plugins.length > 0 ) {
				GyanSitesAdmin._activateAllPlugins( activate_plugins );
			}

			if( activate_plugins.length <= 0 && not_installed.length <= 0 ) {
				GyanSitesAdmin._enable_demo_import_button();
			}

		},

		_activateAllPlugins: function( activate_plugins ) {

			GyanSitesAdmin.remaining_activate_plugins = activate_plugins.length;

			$.each( activate_plugins, function(index, single_plugin) {

				GyanSitesAjaxQueue.add({
					url: gyanSitesVars.ajaxurl,
					type: 'POST',
					data: {
						'action'            : 'gyan-required-plugin-activate',
						'init'              : single_plugin.init,
						'options'           : GyanSitesAdmin.options_data,
						'enabledExtensions' : GyanSitesAdmin.enabled_extensions,
						'_ajax_nonce'      : gyanSitesVars._ajax_nonce,
					},
					beforeSend: function() {
						console.groupCollapsed( 'Activating Plugin "' + single_plugin.name + '"' );
						GyanSitesAdmin._log_title( 'Activating Plugin "' + single_plugin.name + '"' );
					},
					success: function( result ){
						console.log( result );
						console.groupEnd( 'Activating Plugin "' + single_plugin.name + '"' );

						if( result.success ) {
							var pluginsList = gyanSitesVars.requiredPlugins.inactive;

							// Reset not installed plugins list.
							gyanSitesVars.requiredPlugins.inactive = GyanSitesAdmin._removePluginFromQueue( single_plugin.slug, pluginsList );

							// Enable Demo Import Button
							GyanSitesAdmin._enable_demo_import_button();
						}

						GyanSitesAdmin.remaining_activate_plugins-=1;

						if( 0 === GyanSitesAdmin.remaining_activate_plugins ) {
							console.groupEnd( 'Activating Required Plugins..' );
						}
					}
				});
			});
			GyanSitesAjaxQueue.run();
		},

		_installAllPlugins: function( not_installed ) {

			$.each( not_installed, function(index, single_plugin) {

				// Add each plugin activate request in Ajax queue.
				// @see wp-admin/js/updates.js
				wp.updates.queue.push( {
					action: 'install-plugin', // Required action. WordPress core function
					data:   {
						slug: single_plugin.slug,
						init: single_plugin.init,
						name: single_plugin.name,
						success: function() {
							$( document ).trigger( 'wp-plugin-install-success', [single_plugin] );
						},
						error: function() {
							$( document ).trigger( 'wp-plugin-install-error', [single_plugin] );
						},
					}
				} );
			});

			// Required to set queue.
			wp.updates.queueChecker();
		},

		_get_id: function( site_id ) {
			return site_id.replace('id-', '');
		},

		// Fires when a nav item is clicked
		_show_site_popup: function(event) {
			event.preventDefault();

			if( $( this ).hasClass('updating-message') ) {
				return;
			}

			$('.gyan-sites-result-preview').addClass('import-site').removeClass('import-page');

			$('.gyan-sites-result-preview')
				.removeClass('preview-page-from-search-result gyan-sites-page-import-popup')
				.addClass('gyan-sites-site-import-popup')
				.show();

			var template = wp.template( 'gyan-sites-result-preview' );
			$('.gyan-sites-result-preview').html( template( 'gyan-sites' ) ).addClass('preparing');
			$('.gyan-sites-import-content').append( '<div class="gyan-loading-wrap"><div class="gyan-loading-icon"></div></div>' );

			// .attr('data-slug', 'gyan-sites');
			GyanSitesAdmin.action_slug = 'gyan-sites';
			gyanSitesVars.cpt_slug = 'gyan-sites';

			var site_id = $('#site-pages').attr( 'data-site-id') || '';
				site_id = GyanSitesAdmin._get_id( site_id );

			if( GyanSitesAdmin.visited_sites_and_pages[ site_id ] ) {

				GyanSitesAdmin.templateData = GyanSitesAdmin.visited_sites_and_pages[ site_id ];

				GyanSitesAdmin.process_site_data( GyanSitesAdmin.templateData );
			} else {

				// GyanSitesAdmin.templateData, Add Params for API request.
				GyanSitesAdmin._api_params = {};
				GyanSitesAdmin._apiAddParam_status();
				GyanSitesAdmin._apiAddParam_gyan_site_category();
				GyanSitesAdmin._apiAddParam_gyan_site_page_builder();
				GyanSitesAdmin._apiAddParam_gyan_page_parent_category();
				GyanSitesAdmin._apiAddParam_site_url();
				var api_post = {
					id: gyanSitesVars.cpt_slug,
					slug: gyanSitesVars.cpt_slug + '/' + site_id + '?' + decodeURIComponent( $.param( GyanSitesAdmin._api_params ) ),
				};

				$.ajax({
					url  : gyanSitesVars.ajaxurl,
					type : 'POST',
					data : {
						action : 'gyan-sites-api-request',
						url : gyanSitesVars.cpt_slug + '/' + site_id + '?' + decodeURIComponent( $.param( GyanSitesAdmin._api_params ) ),
					},
					beforeSend: function() {
						console.groupCollapsed('Requesting API');
					}
				})
				.fail(function( jqXHR ){
					GyanSitesAdmin._log( jqXHR );
					GyanSitesAdmin._importFailMessage( jqXHR.status + ' ' + jqXHR.statusText, '', jqXHR );
					console.groupEnd();
				})
				.done(function ( response ) {

					console.log('Template API Response:');
					GyanSitesAdmin._log( response );
					console.groupEnd();
					if( response.success ) {
						GyanSitesAdmin.visited_sites_and_pages[ response.data.id ] = response.data;
						GyanSitesAdmin.templateData = response.data;
						GyanSitesAdmin.process_site_data( GyanSitesAdmin.templateData );
					} else {
						$('.gyan-sites-result-preview .heading > h3').text('Import Process Interrupted');
						$('.gyan-sites-import-content').find( '.gyan-loading-wrap' ).remove();
						$('.gyan-sites-result-preview').removeClass('preparing');
						$('.gyan-sites-import-content').html( wp.template( 'gyan-sites-request-failed' ) );
						$('.gyan-demo-import').removeClass('updating-message installing button-primary').addClass('disabled').text('Import Failed!');
					}
				});
			}

		},

		show_popup: function( heading, content, actions, classes ) {
			if( classes ) { $('.gyan-sites-popup').addClass( classes ); }
			if( heading ) { $('.gyan-sites-popup .heading h3').html( heading ); }
			if( content ) { $('.gyan-sites-popup .gyan-sites-import-content').html( content ); }
			if( actions ) { $('.gyan-sites-popup .gyn-btn-actions-wrap').html( actions ); }
			$('.gyan-sites-popup').show();
		},

		hide_popup: function() {
			$('.gyan-sites-popup').hide();
		},

		show_page_popup: function() {

			GyanSitesAdmin.process_import_page();
		},

		process_import_page: function() {
			GyanSitesAdmin.hide_popup();

			var page_id = GyanSitesAdmin._get_id( $( '#single-pages' ).find('.current_page').attr('data-page-id') ) || '';
			var site_id = GyanSitesAdmin._get_id( $('#site-pages').attr( 'data-site-id') ) || '';

			$('.gyan-sites-result-preview')
				.removeClass('gyan-sites-site-import-popup gyan-sites-page-import-popup')
				.addClass('preview-page-from-search-result')
				.show();

			$('.gyan-sites-result-preview').html( wp.template( 'gyan-sites-result-preview' ) ).addClass('preparing');
			$('.gyan-sites-import-content').append( '<div class="gyan-loading-wrap"><div class="gyan-loading-icon"></div></div>' );

			// .attr('data-slug', 'site-pages');
			GyanSitesAdmin.action_slug = 'site-pages';
			gyanSitesVars.cpt_slug = 'site-pages';

			if( GyanSitesAdmin.visited_sites_and_pages[ page_id ] ) {

				GyanSitesAdmin.templateData = GyanSitesAdmin.visited_sites_and_pages[ page_id ];

				GyanSitesAdmin.required_plugins_list_markup( GyanSitesAdmin.templateData['site-pages-required-plugins'] );
			} else {

				// GyanSitesAdmin.templateData
				// Add Params for API request.
				GyanSitesAdmin._api_params = {};
				GyanSitesAdmin._apiAddParam_status();
				GyanSitesAdmin._apiAddParam_per_page();
				GyanSitesAdmin._apiAddParam_gyan_site_category();
				GyanSitesAdmin._apiAddParam_gyan_site_page_builder();
				GyanSitesAdmin._apiAddParam_gyan_page_parent_category();
				GyanSitesAdmin._apiAddParam_site_url();

				// Request.
				$.ajax({
					url  : gyanSitesVars.ajaxurl,
					type : 'POST',
					data : {
						action : 'gyan-sites-api-request',
						url : gyanSitesVars.cpt_slug + '/' + page_id + '?' + decodeURIComponent( $.param( GyanSitesAdmin._api_params ) ),
					},
					beforeSend: function() {
						console.groupCollapsed( 'Requesting API URL' );
						GyanSitesAdmin._log( 'Requesting API URL' );
					}
				})
				.fail(function( jqXHR ){
					GyanSitesAdmin._log( jqXHR );
					GyanSitesAdmin._importFailMessage( jqXHR.status + ' ' + jqXHR.statusText, 'Page Import API Request Failed!', jqXHR );
					console.groupEnd();
				})
				.done(function ( response ) {
					GyanSitesAdmin._log( response );
					console.groupEnd();

					if( response.success ) {
						GyanSitesAdmin.visited_sites_and_pages[ response.data.id ] = response.data;

						GyanSitesAdmin.templateData = response.data;

						GyanSitesAdmin.required_plugins_list_markup( GyanSitesAdmin.templateData['site-pages-required-plugins'] );
					} else {
						$('.gyan-sites-result-preview .heading > h3').text('Import Process Interrupted');
						$('.gyan-sites-import-content').find( '.gyan-loading-wrap' ).remove();
						$('.gyan-sites-result-preview').removeClass('preparing');
						$('.gyan-sites-import-content').html( wp.template( 'gyan-sites-request-failed' ) );
						$('.gyan-demo-import').removeClass('updating-message installing button-primary').addClass('disabled').text('Import Failed!');
					}
				});
			}
		},

		show_page_popup_from_search: function(event) {
			event.preventDefault();
			var page_id = $( this ).parents( '.gyan-theme' ).attr( 'data-page-id') || '';
			var site_id = $( this ).parents( '.gyan-theme' ).attr( 'data-site-id') || '';

			// $('.gyan-sites-result-preview').show();
			$('#gyan-sites').hide();
			$('#site-pages').hide();
			GyanSitesAdmin.show_pages_by_site_id( site_id, page_id );
		},

		// Fires when a nav item is clicked
		show_page_popup_from_sites: function(event) {
			event.preventDefault();

			if( $( this ).hasClass('updating-message') ) {
				return;
			}

			$('.gyan-sites-result-preview').addClass('import-page').removeClass('import-site');

			GyanSitesAdmin.show_page_popup();
		},

		// Returns if a value is an array
		_isArray: function(value) {
			return value && typeof value === 'object' && value.constructor === Array;
		},

		add_skip_and_import_popups: function( templates ) {
			if( Object.keys( templates ).length ) {
				for( template_id in templates ) {
					var template = wp.template( template_id );
					var template_data = templates[template_id] || '';

					$('.gyan-sites-result-preview .inner').append( template( template_data ) );
				}
				$('.gyan-sites-result-preview .inner > .default').addClass('hide-me');
				$('.gyan-sites-result-preview .inner > .skip-and-import:not(:last-child)').addClass('hide-me');
			}
		},

		required_plugins_list_markup: function( requiredPlugins ) {

			// var requiredPlugins = GyanSitesAdmin.templateData['required_plugins'] || '';

			if( '' === requiredPlugins ) {
				return;
			}

			// or
			var $pluginsFilter  = $( '#plugin-filter' );

			// Add disabled class from import button.
			$('.gyan-demo-import')
				.addClass('disabled not-click-able')
				.removeAttr('data-import');

			$('.required-plugins').addClass('loading').html('<span class="spinner is-active"></span>');

		 	// Required Required.
			$.ajax({
				url  : gyanSitesVars.ajaxurl,
				type : 'POST',
				data : {
					action           : 'gyan-required-plugins',
					_ajax_nonce      : gyanSitesVars._ajax_nonce,
					required_plugins : requiredPlugins,
					options           : GyanSitesAdmin.options_data,
					enabledExtensions : GyanSitesAdmin.enabled_extensions,
				},
				beforeSend: function() {
					console.groupCollapsed( 'Required Plugins' );
					console.log( 'Required Plugins of Template:' );
					console.log( requiredPlugins );
				}
			})
			.fail(function( jqXHR ){
				GyanSitesAdmin._log(jqXHR);

				// Remove loader.
				$('.required-plugins').removeClass('loading').html('');
				GyanSitesAdmin._importFailMessage( jqXHR.status + jqXHR.statusText, 'Required Plugins Failed!', jqXHR );
				console.groupEnd();
			})
			.done(function ( response ) {
				console.log( 'Required Plugin Status From The Site:' );
				GyanSitesAdmin._log(response);
				console.groupEnd();

				if( false === response.success ) {
					GyanSitesAdmin._importFailMessage( response.data, 'Required Plugins Failed!', '', gyanSitesVars.importFailedRequiredPluginsMessage );
				} else {
					required_plugins = response.data['required_plugins'];

					// Set compatibilities.
					var compatibilities = gyanSitesVars.compatibilities;

					GyanSitesAdmin.skip_and_import_popups = [];

					GyanSitesAdmin.required_plugins = response.data['required_plugins'];

					if( response.data['update_avilable_plugins'].length ) {
						compatibilities.warnings['update-available'] = gyanSitesVars.compatibilities_data['update-available'];
						let list_html = '<ul>';
						for (let index = 0; index < response.data['update_avilable_plugins'].length; index++) {
							let element = response.data['update_avilable_plugins'][index];
							list_html += '<li>' + element.name + '</li>';
						}
						list_html += '</ul>';
						compatibilities.warnings['update-available']['tooltip'] = compatibilities.warnings['update-available']['tooltip'].replace( '##LIST##', list_html );
					} else {
						delete compatibilities.warnings['update-available'];
					}

					if( response.data['third_party_required_plugins'].length ) {
						GyanSitesAdmin.skip_and_import_popups['gyan-sites-third-party-required-plugins'] = response.data['third_party_required_plugins'];
					}

					var is_dynamic_page = $( '#single-pages' ).find('.current_page').attr('data-dynamic-page') || 'no';

					if( ( 'yes' === is_dynamic_page ) && 'site-pages' === GyanSitesAdmin.action_slug ) {
						GyanSitesAdmin.skip_and_import_popups['gyan-sites-dynamic-page'] = '';
					}

					// Release disabled class from import button.
					$('.gyan-demo-import')
						.removeClass('disabled not-click-able')
						.attr('data-import', 'disabled');

					// Remove loader.
					$('.required-plugins').removeClass('loading').html('');
					$('.required-plugins-list').html('');

					var output = '';
					var remaining_plugins = 0;
					var required_plugins_markup = '';

					// Not Installed, List of not installed required plugins.
					if ( typeof required_plugins.notinstalled !== 'undefined' ) {

						remaining_plugins += parseInt( required_plugins.notinstalled.length );  // Add not have installed plugins count.
						$( required_plugins.notinstalled ).each(function( index, plugin ) {
							output += '<li class="plugin-card plugin-card-'+plugin.slug+'" data-slug="'+plugin.slug+'" data-init="'+plugin.init+'" data-name="'+plugin.name+'">'+plugin.name+'</li>';
						});
					}

					// Inactive, List of not inactive required plugins.
					if ( typeof required_plugins.inactive !== 'undefined' ) {

						// Add inactive plugins count.
						remaining_plugins += parseInt( required_plugins.inactive.length );

						$( required_plugins.inactive ).each(function( index, plugin ) {
							output += '<li class="plugin-card plugin-card-'+plugin.slug+'" data-slug="'+plugin.slug+'" data-init="'+plugin.init+'" data-name="'+plugin.name+'">'+plugin.name+'</li>';
						});
					}

					if ( '' == output ) {
						$('.gyan-sites-result-preview').find('.gyan-sites-import-plugins').hide();
					} else {
						$('.gyan-sites-result-preview').find('.gyan-sites-import-plugins').show();
						$('.gyan-sites-result-preview').find('.required-plugins-list').html( output );
					}

					// Enable Demo Import Button
					gyanSitesVars.requiredPlugins = required_plugins;

					$('.gyan-sites-import-content').find( '.gyan-loading-wrap' ).remove();
					$('.gyan-sites-result-preview').removeClass('preparing');

					// Compatibility.
					if( Object.keys( compatibilities.errors ).length || Object.keys( compatibilities.warnings ).length || Object.keys( GyanSitesAdmin.skip_and_import_popups ).length ) {

						if( Object.keys( compatibilities.errors ).length || Object.keys( compatibilities.warnings ).length ) {
							GyanSitesAdmin.skip_and_import_popups['gyan-sites-compatibility-messages'] = compatibilities;
						}

						if( Object.keys( GyanSitesAdmin.skip_and_import_popups ).length ) {
							GyanSitesAdmin.add_skip_and_import_popups( GyanSitesAdmin.skip_and_import_popups );
						}

					} else {
						// Avoid plugin activation, for pages only.
						if( 'site-pages' === GyanSitesAdmin.action_slug ) {

							var notinstalled = gyanSitesVars.requiredPlugins.notinstalled || 0;
							if( ! notinstalled.length ) {
								GyanSitesAdmin.import_page_process();
							}
						}
					}
				}
				console.groupEnd();
			});
		},

		import_page_process: function() {

			if( $( '.gyan-sites-page-import-popup .site-install-site-button, .preview-page-from-search-result .site-install-site-button' ).hasClass('updating-message') ) {
				return;
			}

			$( '.gyan-sites-result-preview .default').show();

			$( '.gyan-sites-page-import-popup .site-install-site-button, .preview-page-from-search-result .site-install-site-button' ).addClass('updating-message installing').text( 'Importing..' );

			GyanSitesAdmin.import_start_time = new Date();

			$('.gyan-sites-result-preview .inner > h3').text('We\'re importing your website.');
			$('.install-theme-info').hide();
			$('.gyn-importing-wrap').show();
			var output = '<div class="current-importing-status-title"></div><div class="current-importing-status-description"></div>';
			$('.current-importing-status').html( output );

			// Process Bulk Plugin Install & Activate.
			GyanSitesAdmin._bulkPluginInstallActivate();
		},

		_close_popup_by_overlay: function(event) {
			if ( this === event.target ) {
				// Import process is started?
				// And Closing the window? Then showing the warning confirm message.
				if( $('body').hasClass('importing-site') && ! confirm( gyanSitesVars.strings.warningBeforeCloseWindow ) ) {
					return;
				}

				$('body').removeClass('importing-site');
				$('html').removeClass('gyan-site-preview-on');

				GyanSitesAdmin._close_popup();
				GyanSitesAdmin.hide_popup();
			}
		},

		_close_popup: function() {
			GyanSitesAdmin._clean_url_params( 'gyan-site' );
			GyanSitesAdmin._clean_url_params( 'gyan-page' );
			$('.gyan-sites-result-preview').html('').hide();

			GyanSitesAdmin.hide_popup();
		},

		_page_api_call: function() {

		// Have any skip and import popup in queue then return.
		if( Object.keys( GyanSitesAdmin.skip_and_import_popups ).length ) {
			return;
		}

		// Has API data of pages.
		if ( null == GyanSitesAdmin.templateData ) {
			return;
		}

			$('body').addClass('importing-site');

			// Import Page Content
			$('.current-importing-status-wrap').remove();
			$('.gyan-sites-result-preview .inner > h3').text('We are importing page!');

			fetch( GyanSitesAdmin.templateData['gyan-page-api-url'] + '?&track=true&site_url=' + gyanSitesVars.siteURL ).then(response => {
				return response.json();
			}).then(data => {

				// Import Single Page.
				$.ajax({
					url: gyanSitesVars.ajaxurl,
					type: 'POST',
					dataType: 'json',
					data: {
						'action' : 'gyan-sites-create-page',
						'_ajax_nonce' : gyanSitesVars._ajax_nonce,
						'page_settings_flag' : GyanSitesAdmin.page_settings_flag,
						'data'   : data,
					},
					success: function( response ){
						if( response.success ) {
							GyanSitesAdmin.page_import_status = true;
							GyanSitesAdmin.imported_page_data = response.data

							$get_gyan_site_page_slider_path = GyanSitesAdmin.templateData['gyan-site-page-slider-path'];

							if ( '' != $get_gyan_site_page_slider_path ) {
								GyanSitesAdmin.importPageSlider();
							} else {
								GyanSitesAdmin.page_import_complete();
							}

						} else {
							GyanSitesAdmin._importFailMessage( response.data, 'Page Rest API Request Failed!' );
						}
					}
				});

			}).catch(err => {
				GyanSitesAdmin._log( err );
				GyanSitesAdmin._importFailMessage( response.data, 'Page Rest API Request Failed!' );
			});

		},

		process_site_data: function( data ) {

			if( 'log_file' in data ){
				GyanSitesAdmin.log_file_url  = decodeURIComponent( data.log_file ) || '';
			}

			// 1. Pass - Request Site Import
			GyanSitesAdmin.customizer_data    = JSON.stringify( data['gyan-site-customizer-data'] ) || '';
			GyanSitesAdmin.wxr_url            = encodeURI( data['gyan-site-wxr-path'] ) || '';
			GyanSitesAdmin.options_data       = JSON.stringify( data['gyan-site-options-data'] ) || '';
			GyanSitesAdmin.enabled_extensions = JSON.stringify( data['gyan-enabled-extensions'] ) || '';
			GyanSitesAdmin.widgets_data       = data['gyan-site-widgets-data'] || '';
			GyanSitesAdmin.sliders_data       = data['gyan-site-slider-data'] || '';

			// Elementor Template Kit Markup.
			GyanSitesAdmin.template_kit_markup( data );

			// Required Plugins.
			GyanSitesAdmin.required_plugins_list_markup( data['required-plugins'] );
		},

		template_kit_markup: function( data ) {
			if ( 'elementor' != gyanSitesVars.default_page_builder ) {
				return;
			}
		},

		_enable_demo_import_button: function() {
			$('.install-theme-info .theme-details .site-description').remove();
			var notinstalled = gyanSitesVars.requiredPlugins.notinstalled || 0;
			var inactive     = gyanSitesVars.requiredPlugins.inactive || 0;
			if( $('.gyan-sites-result-preview').hasClass('skip-plugins') ) {
				notinstalled = [];
			}
			if( notinstalled.length === inactive.length ) {
				$(document).trigger( 'gyan-sites-after-'+GyanSitesAdmin.action_slug+'-required-plugins' );
			}

		},

		_removePluginFromQueue: function( removeItem, pluginsList ) {
			return jQuery.grep(pluginsList, function( value ) {
				return value.slug != removeItem;
			});
		}

	};

	$(function(){
		GyanSitesAdmin.init();
	});

})(jQuery);