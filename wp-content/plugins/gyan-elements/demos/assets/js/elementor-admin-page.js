var GyanSitesAjaxQueue = (function() {
	var requests = [];
	return {
		add:  function(opt) { requests.push(opt); },  			/* Add AJAX request  */
		remove:  function(opt) {										/* Remove AJAX request */
		    if( jQuery.inArray(opt, requests) > -1 )
		        requests.splice($.inArray(opt, requests), 1);
		},
		run: function() {													/* Run / Process AJAX request */
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
		stop:  function() { requests = []; clearTimeout(this.tid); } /* Stop AJAX request */
	};
}());


(function($){
	$elscope = {};
	$.fn.isInViewport = function() {
		if( ! $( this ).length ) { return false; }  // If not have the element then return false!
		var elementTop = $( this ).offset().top;
		var elementBottom = elementTop + $( this ).outerHeight();
		var viewportTop = $( window ).scrollTop();
		var viewportBottom = viewportTop + $( window ).height();
		return elementBottom > viewportTop && elementTop < viewportBottom;
	};

	GyanElementorSitesAdmin = {
		visited_pages: [],
		reset_remaining_posts: 0,
		site_imported_data: null,
		backup_taken: false,
		templateData: {},
		insertData: {},
		log_file        : '',
		pages_list      : '',
		insertActionFlag : false,
		page_id : 0,
		site_id : 0,
		block_id : 0,
		requiredPlugins : [],
		canImport : false,
		canInsert : false,
		type : 'pages',
		action : '',
		masonryObj : [],
		index : 0,
		blockCategory : '',
		blockColor : '',
		processing: false,
		siteType: '',
		page: 1,
		per_page: 20,

		init: function() {
			this._bind();
		},

		_bind: function() {
			if ( elementorCommon ) {
				let add_section_tmpl = $( "#tmpl-elementor-add-section" );

				if ( add_section_tmpl.length > 0 ) {
					let action_for_add_section = add_section_tmpl.text();
					let stylesheet = '';

					// add logo icon before "Drag widget here"
					action_for_add_section = action_for_add_section.replace( '<div class="elementor-add-section-drag-title', stylesheet + '<div class="elementor-add-section-area-button elementor-add-gyn-site-button" title="' + gyanElementorSites.plugin_name + '"> <i class="eicon-folder"></i> </div><div class="elementor-add-section-drag-title' );

					add_section_tmpl.text( action_for_add_section );

					elementor.on( "preview:loaded", function() {

						let base_skeleton = wp.template( 'gyn-template-base-skeleton' );
						let header_template = $( '#tmpl-gyn-template-modal__header' ).text();

						if ( $( '#gyn-sites-modal' ).length == 0 ) {
							$( 'body' ).append( base_skeleton() );
							$elscope = $( '#gyn-sites-modal' );
							$elscope.find( '.gyan-sites-content-wrap' ).before( header_template );
						}

						$elscope.find( '.gyan-blocks-category' ).select2();

						$elscope.find( '.gyan-blocks-category' ).on( 'select2:select', GyanElementorSitesAdmin._categoryChange );
						$elscope.find( '.gyan-blocks-filter' ).on( 'change', GyanElementorSitesAdmin._blockColorChange );

						$( elementor.$previewContents[0].body ).on( "click", ".elementor-add-gyn-site-button", GyanElementorSitesAdmin._open );

						// Click events.
						$( 'body' ).on( "click", ".gyn-sites-modal__header__close", GyanElementorSitesAdmin._close );
						$( 'body' ).on( "click", "#gyn-sites-modal .elementor-template-library-menu-item", GyanElementorSitesAdmin._libraryClick );
						$( 'body' ).on( "click", "#gyn-sites-modal .theme-screenshot", GyanElementorSitesAdmin._preview );
						$( 'body' ).on( "click", "#gyn-sites-modal .back-to-layout", GyanElementorSitesAdmin._goBack );
						$( 'body' ).on( "click", GyanElementorSitesAdmin._closeTooltip );

						$( document ).on( "click", "#gyn-sites-modal .gyn-library-template-insert", GyanElementorSitesAdmin._insert );
						$( 'body' ).on( "click", "#gyn-sites-modal .gyan-sites-tooltip-icon", GyanElementorSitesAdmin._toggleTooltip );
						$( document ).on( "click", ".elementor-template-library-menu-item", GyanElementorSitesAdmin._toggle );
						$( document ).on( 'click', '#gyn-sites-modal .gyan-sites__sync-wrap', GyanElementorSitesAdmin._sync );
						$( document ).on( 'click', '#gyn-sites-modal .gyn-sites-modal__header__logo, #gyn-sites-modal .back-to-layout-button', GyanElementorSitesAdmin._home );
						$( document ).on( 'click', '#gyn-sites-modal .notice-dismiss', GyanElementorSitesAdmin._dismiss );

						// Other events.
						$elscope.find( '.gyan-sites-content-wrap' ).scroll( GyanElementorSitesAdmin._loadLargeImages );
						$( document ).on( 'keyup input' , '#gyn-sites-modal #wp-filter-search-input', GyanElementorSitesAdmin._search );
						// $( document ).on( 'change', '#gyn-sites-modal .elementor-template-library-order-input', GyanElementorSitesAdmin._changeType );

						// Triggers.
						$( document ).on( "gyan-sites__elementor-open-after", GyanElementorSitesAdmin._initSites );
						$( document ).on( "gyan-sites__elementor-open-before", GyanElementorSitesAdmin._beforeOpen );
						$( document ).on( "gyan-sites__elementor-plugin-check", GyanElementorSitesAdmin._pluginCheck );
						$( document ).on( 'gyan-sites__elementor-close-before', GyanElementorSitesAdmin._beforeClose );

						$( document ).on( 'gyan-sites__elementor-do-step-1', GyanElementorSitesAdmin._step1 );
						$( document ).on( 'gyan-sites__elementor-do-step-2', GyanElementorSitesAdmin._step2 );

						$( document ).on( 'gyan-sites__elementor-goback-step-1', GyanElementorSitesAdmin._goStep1 );
						$( document ).on( 'gyan-sites__elementor-goback-step-2', GyanElementorSitesAdmin._goStep2 );

						// Plugin install & activate.
						$( document ).on( 'wp-plugin-installing' , GyanElementorSitesAdmin._pluginInstalling );
						$( document ).on( 'wp-plugin-install-error' , GyanElementorSitesAdmin._installError );
						$( document ).on( 'wp-plugin-install-success' , GyanElementorSitesAdmin._installSuccess );
					});
				}
			}

		},

		// _changeType: function() {
		// 	GyanElementorSitesAdmin.siteType = $( this ).val();
		// 	$elscope.find( '#wp-filter-search-input' ).trigger( 'keyup' );
		// },

		_categoryChange: function( event ) {
			GyanElementorSitesAdmin.blockCategory = $( this ).val();
			$elscope.find( '#wp-filter-search-input' ).trigger( 'keyup' );
		},

		_blockColorChange: function( event ) {
			GyanElementorSitesAdmin.blockColor = $( this ).val();
			$elscope.find( '#wp-filter-search-input' ).trigger( 'keyup' );
		},

		_dismiss: function() {

			$( this ).closest( '.gyn-sites-floating-notice-wrap' ).removeClass( 'slide-in' );
			$( this ).closest( '.gyn-sites-floating-notice-wrap' ).addClass( 'slide-out' );

			setTimeout( function() {
				$( this ).closest( '.gyn-sites-floating-notice-wrap' ).removeClass( 'slide-out' );
			}, 200 );

			if ( $( this ).closest( '.gyn-sites-floating-notice-wrap' ).hasClass( 'refreshed-notice' ) ) {
				$.ajax({
					url  : gyanElementorSites.ajaxurl,
					type : 'POST',
					data : {
						action : 'gyan-sites-update-library-complete',
					},
				});
			}
		},

		_done: function( data ) {

			console.groupEnd( 'Process Done.' );

			var str = ( GyanElementorSitesAdmin.type == 'pages' ) ? gyanElementorSites.template : gyanElementorSites.block;
			$elscope.find( '.gyn-import-elementor-template' ).removeClass( 'installing' );
			$elscope.find( '.gyn-import-elementor-template' ).attr( 'data-demo-link', data.data.link );
			setTimeout( function() {
				$elscope.find( '.gyn-import-elementor-template' ).text( 'View Saved ' + str );
				$elscope.find( '.gyn-import-elementor-template' ).addClass( 'action-done' );
			}, 200 );
		},

		_beforeClose: function() {
			if ( GyanElementorSitesAdmin.action == 'insert' ) {
				$elscope.find( '.gyn-library-template-insert' ).removeClass( 'installing' );
				$elscope.find( '.gyn-library-template-insert' ).text( 'Imported' );
				$elscope.find( '.gyn-library-template-insert' ).addClass( 'action-done' );

				if ( $elscope.find( '.gyn-sites-floating-notice-wrap' ).hasClass( 'slide-in' ) ) {

					$elscope.find( '.gyn-sites-floating-notice-wrap' ).removeClass( 'slide-in' );
					$elscope.find( '.gyn-sites-floating-notice-wrap' ).addClass( 'slide-out' );

					setTimeout( function() {
						$elscope.find( '.gyn-sites-floating-notice-wrap' ).removeClass( 'slide-out' );
					}, 200 );
				}
			}
		},

		_closeTooltip: function( event ) {

			if(
				event.target.className !== "gyn-tooltip-wrap" &&
				event.target.className !== "dashicons dashicons-editor-help"
			) {
				var wrap = $elscope.find( '.gyn-tooltip-wrap' );
				if ( wrap.hasClass( 'gyn-show-tooltip' ) ) {
					$elscope.find( '.gyn-tooltip-wrap' ).removeClass( 'gyn-show-tooltip' );
				}
			}
		},

		_sync: function( event ) {

			event.preventDefault();
			var button = $( this ).find( '.gyan-sites-sync-library-button' );

			if( button.hasClass( 'updating-message') ) {
				return;
			}

			button.addClass( 'updating-message');
			$elscope.find( '#gyn-sites-floating-notice-wrap-id' ).show().removeClass('error');
			$elscope.find( '#gyn-sites-floating-notice-wrap-id .gyn-sites-floating-notice' ).html( '<span class="message">Refreshing demos in the background. It can take up to few minutes.<span><button type="button" class="notice-dismiss"><span class="screen-reader-text">' + gyanElementorSites.dismiss_text + '</span></button>' );
			$elscope.find( '#gyn-sites-floating-notice-wrap-id' ).addClass( 'slide-in' ).removeClass( 'refreshed-notice' );

			$.ajax({
				url  : gyanElementorSites.ajaxurl,
				type : 'POST',
				data : {
					action : 'gyan-sites-update-library',
				},
			})
			.fail(function( jqXHR ){
				console.log( jqXHR );
		    })
			.done(function ( response ) {

				if( response.success ) {
					if( 'updated' === response.data ) {
						$elscope.find( '#gyn-sites-floating-notice-wrap-id').addClass('refreshed-notice').find('.gyn-sites-floating-notice' ).html( '<span class="message">'+gyanElementorSites.syncCompleteMessage+'</span><button type="button" class="notice-dismiss"><span class="screen-reader-text">' + gyanElementorSites.dismiss_text + '</span></button>' );
						button.removeClass( 'updating-message');
						console.log( 'Already sync all the sites.' );
					} else {

						// Import categories.
						$.ajax({
							url  : gyanElementorSites.ajaxurl,
							type : 'POST',
							data : {
								action : 'gyan-sites-import-categories',
							},
						})
						.fail(function( jqXHR ){
							console.log( jqXHR );
						});

						// Import Site Categories.
						$.ajax({
							url  : gyanElementorSites.ajaxurl,
							type : 'POST',
							data : {
								action : 'gyan-sites-import-site-categories',
							},
						})
						.fail(function( jqXHR ){
							console.log( jqXHR );
						});


						// Import Blocks.
						$.ajax({
							url  : gyanElementorSites.ajaxurl,
							type : 'POST',
							data : {
								action : 'gyan-sites-get-blocks-request-count',
							},
							beforeSend: function() {
								console.groupCollapsed( 'Updating Blocks' );
								console.log( 'Updating Blocks' );
							},
						})
						.fail(function( jqXHR ){
							console.log( jqXHR, 'error' );
							console.error( jqXHR.status + jqXHR.statusText, 'Blocks Count Request Failed!', jqXHR );
							console.groupEnd('Updating Blocks');
						})
						.done(function ( response ) {
							console.log( response );
							if( response.success ) {
								var total = response.data;

								for( let i = 1; i <= total; i++ ) {
									GyanSitesAjaxQueue.add({
										url: gyanElementorSites.ajaxurl,
										type: 'POST',
										data: {
											action  : 'gyan-sites-import-blocks',
											page_no : i,
										},
										beforeSend: function() {
											console.groupCollapsed( 'Importing Blocks - Page ' + i );
											console.log( 'Importing Blocks - Page ' + i );
										},
										success: function( response ){
											console.log( response );
											console.groupEnd( 'Importing Blocks - Page ' + i );
										}
									});
								}

								// Run the AJAX queue.
								GyanSitesAjaxQueue.run();
							} else {
								console.error( response.data, 'Blocks Count Request Failed!' );
							}
						});

						// Import Block Categories.
						$.ajax({
							url  : gyanElementorSites.ajaxurl,
							type : 'POST',
							data : {
								action : 'gyan-sites-import-block-categories',
							},
						})
						.fail(function( jqXHR ){
							console.log( jqXHR );
						});

						$.ajax({
							url  : gyanElementorSites.ajaxurl,
							type : 'POST',
							data : {
								action : 'gyan-sites-get-sites-request-count',
							},
						})
						.fail(function( jqXHR ){
							console.log( jqXHR );
					    })
						.done(function ( response ) {
							if( response.success ) {
								var total = response.data;

								for( let i = 1; i <= total; i++ ) {
									GyanSitesAjaxQueue.add({
										url: gyanElementorSites.ajaxurl,
										type: 'POST',
										data: {
											action  : 'gyan-sites-import-sites',
											page_no : i,
										},
										success: function( result ){

											if( i === total && gyanElementorSites.syncCompleteMessage ) {
												button.removeClass( 'updating-message');
												$elscope.find( '#gyn-sites-floating-notice-wrap-id').addClass('refreshed-notice').find('.gyn-sites-floating-notice' ).html( '<span class="message">'+gyanElementorSites.syncCompleteMessage+'</span><button type="button" class="notice-dismiss"><span class="screen-reader-text">' + gyanElementorSites.dismiss_text + '</span></button>' );
											}
										}
									});
								}

								// Run the AJAX queue.
								GyanSitesAjaxQueue.run();
							}
						});
					}
				}
			});
		},

		_toggleTooltip: function( e ) {

			var wrap = $elscope.find( '.gyn-tooltip-wrap' );


			if ( wrap.hasClass( 'gyn-show-tooltip' ) ) {
				$elscope.find( '.gyn-tooltip-wrap' ).removeClass( 'gyn-show-tooltip' );
			} else {
				$elscope.find( '.gyn-tooltip-wrap' ).addClass( 'gyn-show-tooltip' );
			}
		},

		_toggle: function( e ) {
			$elscope.find( '.elementor-template-library-menu-item' ).removeClass( 'elementor-active' );

			$elscope.find( '.dialog-lightbox-content' ).hide();

			$elscope.find( '.theme-preview' ).hide();
			$elscope.find( '.theme-preview' ).html( '' );
			$elscope.find( '.theme-preview-block' ).hide();
			$elscope.find( '.theme-preview-block' ).html( '' );
			$elscope.find( '.gyn-template-library-toolbar' ).show();

			$elscope.find( '.dialog-lightbox-content' ).hide();
			$elscope.find( '.dialog-lightbox-content-block' ).hide();

			$( this ).addClass( 'elementor-active' );
			let data_type = $( this ).data( 'template-type' );

			GyanElementorSitesAdmin.type = data_type;
			GyanElementorSitesAdmin._switchTo( data_type );
		},

		_home: function() {
			if ( GyanElementorSitesAdmin.processing ) {
				return;
			}
			$elscope.find( '#wp-filter-search-input' ).val( '' );
			// Hide Back button.
			$elscope.find( '.back-to-layout' ).css( 'visibility', 'hidden' );
			$elscope.find( '.back-to-layout' ).css( 'opacity', '0' );
			$elscope.find( '.elementor-template-library-menu-item:first-child' ).trigger( 'click' );
		},

		_switchTo: function( type ) {
			if ( 'pages' == type ) {
				GyanElementorSitesAdmin._initSites();
				$elscope.find( '.dialog-lightbox-content' ).show();
				$elscope.find( '.gyan-blocks-category-inner-wrap' ).hide();
				$elscope.find( '.gyan-blocks-filter-inner-wrap' ).hide();
				$elscope.find( '.elementor-template-library-order' ).show();
			} else {
				GyanElementorSitesAdmin._initBlocks();
				$elscope.find( '.dialog-lightbox-content-block' ).show();
				$elscope.find( '.gyan-blocks-category-inner-wrap' ).show();
				$elscope.find( '.gyan-blocks-filter-inner-wrap' ).show();
				$elscope.find( '.elementor-template-library-order' ).hide();
			}
			$elscope.find( '.gyan-sites-content-wrap' ).trigger( 'scroll' );
		},

		// _createTemplate: function( data ) {

		// 	console.groupEnd();

		// 	// Work with JSON page here
		// 	$.ajax({
		// 		url: gyanElementorSites.ajaxurl,
		// 		type: 'POST',
		// 		dataType: 'json',
		// 		data: {
		// 			'action' : 'gyan-sites-create-template',
		// 			'data'   : data,
		// 			'title'  : ( GyanElementorSitesAdmin.type == 'pages' ) ? gyanElementorSites.default_page_builder_sites[ GyanElementorSitesAdmin.site_id ]['title'] : '',
		// 			'type'   : GyanElementorSitesAdmin.type,
		// 			'_ajax_nonce' : gyanElementorSites._ajax_nonce,
		// 		},
		// 		beforeSend: function() {
		// 			console.groupCollapsed( 'Creating Template' );
		// 		}
		// 	})
		// 	.fail(function( jqXHR ){
		// 		console.log( jqXHR );
		// 	})
		// 	.done(function ( data ) {
		// 		GyanElementorSitesAdmin._done( data );
		// 	});
		// },

		/**
		 * Install All Plugins.
		 */
		_installAllPlugins: function( not_installed ) {

			$.each( not_installed, function(index, single_plugin) {

				console.log( 'Installing Plugin - ' + single_plugin.name );

				// Add each plugin activate request in Ajax queue.
				// @see wp-admin/js/updates.js
				wp.updates.queue.push( {
					action: 'install-plugin', // Required action. WordPress core function
					data:   {
						slug: single_plugin.slug
					}
				} );
			});

			// Required to set queue.
			wp.updates.queueChecker();
		},

		_activateAllPlugins: function( activate_plugins ) {

			$.each( activate_plugins, function(index, single_plugin) {

				console.log( 'Activating Plugin - ' + single_plugin.name );

				GyanSitesAjaxQueue.add({
					url: gyanElementorSites.ajaxurl,
					type: 'POST',
					data: {
						'action' : 'gyan-required-plugin-activate',
						'init' : single_plugin.init,
						'_ajax_nonce' : gyanElementorSites._ajax_nonce,
					},
					success: function( result ){

						if( result.success ) {

							var pluginsList = GyanElementorSitesAdmin.requiredPlugins.inactive;

							// Reset not installed plugins list.
							GyanElementorSitesAdmin.requiredPlugins.inactive = GyanElementorSitesAdmin._removePluginFromQueue( single_plugin.slug, pluginsList );

							// Enable Demo Import Button
							GyanElementorSitesAdmin._enableImport();
						}
					}
				});
			});
			GyanSitesAjaxQueue.run();
		},

		_removePluginFromQueue: function( removeItem, pluginsList ) {
			return jQuery.grep(pluginsList, function( value ) {
				return value.slug != removeItem;
			});
		},

		_getPluginFromQueue: function( item, pluginsList ) {

			var match = '';
			for ( ind in pluginsList ) {
				if( item == pluginsList[ind].slug ) {
					match = pluginsList[ind];
				}
			}
			return match;
		},

		_bulkPluginInstallActivate: function() {

			console.groupCollapsed( 'Bulk Plugin Install Process Started' );

			// If has class the skip-plugins then,
			// Avoid installing 3rd party plugins.
			var not_installed = GyanElementorSitesAdmin.requiredPlugins.notinstalled || '';
			var activate_plugins = GyanElementorSitesAdmin.requiredPlugins.inactive || '';

			console.log( GyanElementorSitesAdmin.requiredPlugins );

			// First Install Bulk.
			if( not_installed.length > 0 ) {
				GyanElementorSitesAdmin._installAllPlugins( not_installed );
			}

			// Second Activate Bulk.
			if( activate_plugins.length > 0 ) {
				GyanElementorSitesAdmin._activateAllPlugins( activate_plugins );
			}

			if( activate_plugins.length <= 0 && not_installed.length <= 0 ) {
				GyanElementorSitesAdmin._enableImport();
			}
		},

		_unescape: function( input_string ) {
			var title = _.unescape( input_string );

			// @todo check why below character not escape with function _.unescape();
			title = title.replace('&#8211;', '-' );

			return title;
		},

		_unescape_lower: function( input_string ) {
			input_string = $( "<textarea/>") .html( input_string ).text()
			var input_string = GyanElementorSitesAdmin._unescape( input_string );
			return input_string.toLowerCase();
		},

		_search: function() {

			let search_term = $( this ).val() || '';
			search_term = search_term.toLowerCase();

			if ( 'pages' == GyanElementorSitesAdmin.type ) {

				var items = GyanElementorSitesAdmin._getSearchedPages( search_term );

				if( search_term.length ) {
					$( this ).addClass( 'has-input' );
					GyanElementorSitesAdmin._addSites( items );
				} else {
					$( this ).removeClass( 'has-input' );
					GyanElementorSitesAdmin._appendSites( gyanElementorSites.default_page_builder_sites );
				}
			} else {

				var items = GyanElementorSitesAdmin._getSearchedBlocks( search_term );

				if( search_term.length ) {
					$( this ).addClass( 'has-input' );
					GyanElementorSitesAdmin._appendBlocks( items );
				} else {
					$( this ).removeClass( 'has-input' );
					GyanElementorSitesAdmin._appendBlocks( gyanElementorSites.gyan_blocks );
				}
			}
		},

		_getSearchedPages: function( search_term ) {
			var items = [];
			search_term = search_term.toLowerCase();

			for( site_id in gyanElementorSites.default_page_builder_sites ) {

				var current_site = gyanElementorSites.default_page_builder_sites[site_id];

				// Check in site title.
				if( current_site['title'] ) {
					var site_title = GyanElementorSitesAdmin._unescape_lower( current_site['title'] );

					if( site_title.toLowerCase().includes( search_term ) ) {

						for( page_id in current_site['pages'] ) {

							items[page_id] = current_site['pages'][page_id];
							items[page_id]['type'] = 'page';
							items[page_id]['site_id'] = site_id;
							items[page_id]['gyan-sites-type'] = current_site['gyan-sites-type'] || '';
							items[page_id]['parent-site-name'] = current_site['title'] || '';
							items[page_id]['pages-count'] = 0;
						}
					}
				}

				// Check in site tags.
				if ( undefined != current_site['gyan-sites-tag'] ) {

					if( Object.keys( current_site['gyan-sites-tag'] ).length ) {
						for( site_tag_id in current_site['gyan-sites-tag'] ) {
							var tag_title = current_site['gyan-sites-tag'][site_tag_id];
								tag_title = GyanElementorSitesAdmin._unescape_lower( tag_title.replace('-', ' ') );

							if( tag_title.toLowerCase().includes( search_term ) ) {

								for( page_id in current_site['pages'] ) {

									items[page_id] = current_site['pages'][page_id];
									items[page_id]['type'] = 'page';
									items[page_id]['site_id'] = site_id;
									items[page_id]['gyan-sites-type'] = current_site['gyan-sites-type'] || '';
									items[page_id]['parent-site-name'] = current_site['title'] || '';
									items[page_id]['pages-count'] = 0;
								}
							}
						}
					}
				}

				// Check in page title.
				if( Object.keys( current_site['pages'] ).length ) {
					var pages = current_site['pages'];

					for( page_id in pages ) {

						// Check in site title.
						if( pages[page_id]['title'] ) {

							var page_title = GyanElementorSitesAdmin._unescape_lower( pages[page_id]['title'] );

							if( page_title.toLowerCase().includes( search_term ) ) {
								items[page_id] = pages[page_id];
								items[page_id]['type'] = 'page';
								items[page_id]['site_id'] = site_id;
								items[page_id]['gyan-sites-type'] = current_site['gyan-sites-type'] || '';
								items[page_id]['parent-site-name'] = current_site['title'] || '';
								items[page_id]['pages-count'] = 0;
							}
						}

						// Check in site tags.
						if ( undefined != pages[page_id]['gyan-sites-tag'] ) {

							if( Object.keys( pages[page_id]['gyan-sites-tag'] ).length ) {
								for( page_tag_id in pages[page_id]['gyan-sites-tag'] ) {
									var page_tag_title = pages[page_id]['gyan-sites-tag'][page_tag_id];
										page_tag_title = GyanElementorSitesAdmin._unescape_lower( page_tag_title.replace('-', ' ') );
									if( page_tag_title.toLowerCase().includes( search_term ) ) {
										items[page_id] = pages[page_id];
										items[page_id]['type'] = 'page';
										items[page_id]['site_id'] = site_id;
										items[page_id]['gyan-sites-type'] = current_site['gyan-sites-type'] || '';
										items[page_id]['parent-site-name'] = current_site['title'] || '';
										items[page_id]['pages-count'] = 0;
									}
								}
							}
						}

					}
				}
			}

			return items;
		},

		_getSearchedBlocks: function( search_term ) {

			var items = [];

			if( search_term.length ) {

				for( block_id in gyanElementorSites.gyan_blocks ) {

					var current_site = gyanElementorSites.gyan_blocks[block_id];

					// Check in site title.
					if( current_site['title'] ) {
						var site_title = GyanElementorSitesAdmin._unescape_lower( current_site['title'] );

						if( site_title.toLowerCase().includes( search_term ) ) {
							items[block_id] = current_site;
							items[block_id]['type'] = 'site';
							items[block_id]['site_id'] = block_id;
						}
					}

					// Check in site tags.
					if( Object.keys( current_site['tag'] ).length ) {
						for( site_tag_id in current_site['tag'] ) {
							var tag_title = GyanElementorSitesAdmin._unescape_lower( current_site['tag'][site_tag_id] );

							if( tag_title.toLowerCase().includes( search_term ) ) {
								items[block_id] = current_site;
								items[block_id]['type'] = 'site';
								items[block_id]['site_id'] = block_id;
							}
						}
					}
				}
			}

			return items;
		},

		_addSites: function( data ) {

			if ( data ) {
				let single_template = wp.template( 'gyan-sites-search' );
				pages_list = single_template( data );
				$elscope.find( '.dialog-lightbox-content' ).html( pages_list );
				GyanElementorSitesAdmin._loadLargeImages();

			} else {
				$elscope.find( '.dialog-lightbox-content' ).html( wp.template('gyan-sites-no-sites') );
			}
		},

		_appendSites: function( data ) {
			let single_template = wp.template( 'gyan-sites-list' );
			pages_list = single_template( data );
			$elscope.find( '.dialog-lightbox-message-block' ).hide();
			$elscope.find( '.dialog-lightbox-message' ).show();
			$elscope.find( '.dialog-lightbox-content' ).html( pages_list );
			GyanElementorSitesAdmin._loadLargeImages();
		},

		_appendBlocks: function( data ) {
			let single_template = wp.template( 'gyan-blocks-list' );
			let blocks_list = single_template( data );
			$elscope.find( '.dialog-lightbox-message' ).hide();
			$elscope.find( '.dialog-lightbox-message-block' ).show();
			$elscope.find( '.dialog-lightbox-content-block' ).html( blocks_list );
			GyanElementorSitesAdmin._masonry();
		},

		_appendPaginationBlocks: function( data ) {
			let single_template = wp.template( 'gyan-blocks-list' );
			let blocks_list = single_template( data );
			$elscope.find( '.dialog-lightbox-message' ).hide();
			$elscope.find( '.dialog-lightbox-message-block' ).show();
			$elscope.find( '.dialog-lightbox-content-block' ).append( blocks_list );
			GyanElementorSitesAdmin._masonry();
		},

		_masonry: function() {
			//create empty var masonryObj
			var masonryObj;
			var container = document.querySelector( '.dialog-lightbox-content-block' );
			// initialize Masonry after all images have loaded
			imagesLoaded( container, function() {
				masonryObj = new Masonry( container, {
					itemSelector: '.gyan-sites-library-template'
				});
			});
		},

		_enableImport: function() {

			console.log( 'Required Plugins Process Done.' );
			console.groupEnd();

			if ( 'pages' == GyanElementorSitesAdmin.type ) {

					fetch( GyanElementorSitesAdmin.templateData['gyan-page-api-url'] + '?&track=true&site_url=' + gyanElementorSites.siteURL ).then(response => {
						return response.json();
					}).then( data => {

						GyanElementorSitesAdmin.insertData = data;
						if ( 'insert' == GyanElementorSitesAdmin.action ) {
							GyanElementorSitesAdmin._insertDemo( data );
						} else {
							// GyanElementorSitesAdmin._createTemplate( data );
						}
					}).catch( err => {
						console.log( err );
						console.groupEnd();
					});

			} else {

					GyanElementorSitesAdmin.insertData = GyanElementorSitesAdmin.templateData;
					if ( 'insert' == GyanElementorSitesAdmin.action ) {
						GyanElementorSitesAdmin._insertDemo( GyanElementorSitesAdmin.templateData );
					} else {
						// GyanElementorSitesAdmin._createTemplate( GyanElementorSitesAdmin.templateData );
					}

			}
		},

		_insert: function( e ) {

			if ( ! GyanElementorSitesAdmin.canInsert ) {
				return;
			}

			GyanElementorSitesAdmin.canInsert = false;
			var str = ( GyanElementorSitesAdmin.type == 'pages' ) ? gyanElementorSites.template : gyanElementorSites.block;

			$( this ).addClass( 'installing' );
			$( this ).text( 'Importing ' + str + '...' );

			GyanElementorSitesAdmin.action = 'insert';

			GyanElementorSitesAdmin._bulkPluginInstallActivate();
		},

		_insertDemo: function( data ) {

			if ( undefined !== data && undefined !== data[ 'post-meta' ][ '_elementor_data' ] ) {

				let templateModel = new Backbone.Model({
                  getTitle() {
                    return data['title']
                  },
                });
				let page_content = JSON.parse( data[ 'post-meta' ][ '_elementor_data' ]);
				let page_settings = '';
				let api_url = '';

				if ( 'blocks' == GyanElementorSitesAdmin.type ) {
					api_url = gyanElementorSites.ApiURL + 'gyan-blocks/' + data['id'] + '/?&track=true&site_url=' + gyanElementorSites.siteURL;
				} else {
					api_url = GyanElementorSitesAdmin.templateData['gyan-page-api-url'] + '?&track=true&site_url=' + gyanElementorSites.siteURL;
				}

				$.ajax({
					url  : gyanElementorSites.ajaxurl,
					type : 'POST',
					data : {
						action : 'gyan-page-elementor-batch-process',
						id : elementor.config.document.id,
						url : api_url,
						_ajax_nonce : gyanElementorSites._ajax_nonce,
					},
					beforeSend: function() {
						console.groupCollapsed( 'Inserting Demo.' );
					},
				})
				.fail(function( jqXHR ){
					console.log( jqXHR );
					console.groupEnd();
				})
				.done(function ( response ) {

					GyanElementorSitesAdmin.processing = false;
					$elscope.find( '.gyan-sites-content-wrap' ).removeClass( 'processing' );

					page_content = response.data;

					console.log( page_content );
					console.groupEnd();

					if ( undefined !== page_content && '' !== page_content ) {
						if ( undefined != $e && 'undefined' != typeof $e.internal ) {
							elementor.channels.data.trigger('template:before:insert', templateModel);
							elementor.getPreviewView().addChildModel( page_content, { at : GyanElementorSitesAdmin.index } || {} );
							elementor.channels.data.trigger('template:after:insert', {});
							$e.internal( 'document/save/set-is-modified', { status: true } )
						} else {
							elementor.channels.data.trigger('template:before:insert', templateModel);
							elementor.getPreviewView().addChildModel( page_content, { at : GyanElementorSitesAdmin.index } || {} );
							elementor.channels.data.trigger('template:after:insert', {});
							elementor.saver.setFlagEditorChange(true);
						}
					}
					GyanElementorSitesAdmin.insertActionFlag = true;
					GyanElementorSitesAdmin._close();
				});
			}
		},

		_goBack: function( e ) {

			if ( GyanElementorSitesAdmin.processing ) {
				return;
			}

			let step = $( this ).attr( 'data-step' );

			$elscope.find( '#gyn-sites-floating-notice-wrap-id.error' ).hide();

			$elscope.find( '.gyan-sites-step-1-wrap' ).show();
			$elscope.find( '.gyan-preview-actions-wrap' ).remove();

			$elscope.find( '.gyn-template-library-toolbar' ).show();
			$elscope.find( '.gyn-sites-modal__header' ).removeClass( 'gyn-preview-mode' );

			if ( 'pages' == GyanElementorSitesAdmin.type ) {

				if ( 3 == step ) {
					$( this ).attr( 'data-step', 2 );
					$( document ).trigger( 'gyan-sites__elementor-goback-step-2' );
				} else if ( 2 == step ) {
					$( this ).attr( 'data-step', 1 );
					$( document ).trigger( 'gyan-sites__elementor-goback-step-1' );
				}
			} else {
				$( this ).attr( 'data-step', 1 );
				$( document ).trigger( 'gyan-sites__elementor-goback-step-1' );
			}

			$elscope.find( '.gyan-sites-content-wrap' ).trigger( 'scroll' );
		},

		_goStep1: function( e ) {


			// Reset site and page ids to null.
			GyanElementorSitesAdmin.site_id = '';
			GyanElementorSitesAdmin.page_id = '';
			GyanElementorSitesAdmin.block_id = '';
			GyanElementorSitesAdmin.requiredPlugins = [];
			GyanElementorSitesAdmin.templateData = {};
			GyanElementorSitesAdmin.canImport = false;
			GyanElementorSitesAdmin.canInsert = false;

			// Hide Back button.
			$elscope.find( '.back-to-layout' ).css( 'visibility', 'hidden' );
			$elscope.find( '.back-to-layout' ).css( 'opacity', '0' );

			// Hide Preview Page.
			$elscope.find( '.theme-preview' ).hide();
			$elscope.find( '.theme-preview' ).html( '' );
			$elscope.find( '.theme-preview-block' ).hide();
			$elscope.find( '.theme-preview-block' ).html( '' );
			$elscope.find( '.gyn-template-library-toolbar' ).show();

			// Show listing page.
			if( GyanElementorSitesAdmin.type == 'pages' ) {

				$elscope.find( '.dialog-lightbox-content' ).show();
				$elscope.find( '.dialog-lightbox-content-block' ).hide();

				// Set listing HTML.
				GyanElementorSitesAdmin._appendSites( gyanElementorSites.default_page_builder_sites );
			} else {

				// Set listing HTML.
				GyanElementorSitesAdmin._appendBlocks( gyanElementorSites.gyan_blocks );

				$elscope.find( '.dialog-lightbox-content-block' ).show();
				$elscope.find( '.dialog-lightbox-content' ).hide();

				if ( '' !== $elscope.find( '#wp-filter-search-input' ).val() ) {
					$elscope.find( '#wp-filter-search-input' ).trigger( 'keyup' );
				}
			}
		},

		_goStep2: function( e ) {

			// Set page and site ids.
			GyanElementorSitesAdmin.site_id = $elscope.find( '#gyan-blocks' ).data( 'site-id' );
			GyanElementorSitesAdmin.page_id = '';

			if ( undefined === GyanElementorSitesAdmin.site_id ) {
				return;
			}

			// Single Preview template.
			let single_template = wp.template( 'gyan-sites-list-search' );
			let passing_data = gyanElementorSites.default_page_builder_sites[ GyanElementorSitesAdmin.site_id ]['pages'];
			passing_data['site_id'] = GyanElementorSitesAdmin.site_id;
			pages_list = single_template( passing_data );
			$elscope.find( '.dialog-lightbox-content' ).html( pages_list );

			// Hide Preview page.
			$elscope.find( '.theme-preview' ).hide();
			$elscope.find( '.theme-preview' ).html( '' );
			$elscope.find( '.gyn-template-library-toolbar' ).show();
			$elscope.find( '.theme-preview-block' ).hide();
			$elscope.find( '.theme-preview-block' ).html( '' );

			// Show listing page.
			$elscope.find( '.dialog-lightbox-content' ).show();
			$elscope.find( '.dialog-lightbox-content-block' ).hide();

			GyanElementorSitesAdmin._loadLargeImages();

			if ( '' !== $elscope.find( '#wp-filter-search-input' ).val() ) {
				$elscope.find( '#wp-filter-search-input' ).trigger( 'keyup' );
			}
		},

		_step1: function( e ) {

			if ( 'pages' == GyanElementorSitesAdmin.type ) {

				let passing_data = gyanElementorSites.default_page_builder_sites[ GyanElementorSitesAdmin.site_id ]['pages'];

				var count = 0;
				var one_page = [];
				var one_page_id = '';

				for ( key in passing_data ) {
					if ( undefined == passing_data[ key ]['site-pages-type'] ) {
						continue;
					}
					if ( 'gutenberg' == passing_data[key]['site-pages-page-builder'] ) {
						continue;
					}
					count++;
					one_page = passing_data[ key ];
					one_page_id = key;
				}

				if ( count == 1 ) {

					// Logic for one page sites.
					GyanElementorSitesAdmin.page_id = one_page_id;

					$elscope.find( '.back-to-layout' ).css( 'visibility', 'visible' );
					$elscope.find( '.back-to-layout' ).css( 'opacity', '1' );

					$elscope.find( '.back-to-layout' ).attr( 'data-step', 2 );
					$( document ).trigger( 'gyan-sites__elementor-do-step-2' );

					return;
				}


				let single_template = wp.template( 'gyan-sites-list-search' );
				passing_data['site_id'] = GyanElementorSitesAdmin.site_id;
				pages_list = single_template( passing_data );
				$elscope.find( '.dialog-lightbox-content-block' ).hide();
				$elscope.find( '.gyan-sites-step-1-wrap' ).show();
				$elscope.find( '.gyan-preview-actions-wrap' ).remove();
				$elscope.find( '.theme-preview' ).hide();
				$elscope.find( '.theme-preview' ).html( '' );
				$elscope.find( '.gyn-template-library-toolbar' ).show();
				$elscope.find( '.theme-preview-block' ).hide();
				$elscope.find( '.theme-preview-block' ).html( '' );
				$elscope.find( '.dialog-lightbox-content' ).show();
				$elscope.find( '.dialog-lightbox-content' ).html( pages_list );

				GyanElementorSitesAdmin._loadLargeImages();

			} else {

				$elscope.find( '.dialog-lightbox-content' ).hide();
				$elscope.find( '.dialog-lightbox-content-block' ).hide();
				$elscope.find( '.dialog-lightbox-message' ).animate({ scrollTop: 0 }, 50 );
				$elscope.find( '.theme-preview-block' ).show();
				$elscope.find( '.gyn-template-library-toolbar' ).hide();
				$elscope.find( '.gyn-sites-modal__header' ).addClass( 'gyn-preview-mode' );

				// Hide.
				$elscope.find( '.theme-preview' ).hide();
				$elscope.find( '.theme-preview' ).html( '' );

				let import_template = wp.template( 'gyan-sites-elementor-preview' );
				let import_template_header = wp.template( 'gyan-sites-elementor-preview-actions' );
				let template_object = gyanElementorSites.gyan_blocks[ GyanElementorSitesAdmin.block_id ];

				template_object['id'] = GyanElementorSitesAdmin.block_id;

				preview_page_html = import_template( template_object );
				$elscope.find( '.theme-preview-block' ).html( preview_page_html );

				$elscope.find( '.gyan-sites-step-1-wrap' ).hide();

				preview_action_html = import_template_header( template_object );
				$elscope.find( '.elementor-templates-modal__header__items-area' ).append( preview_action_html );
				GyanElementorSitesAdmin._masonry();

				let actual_id = GyanElementorSitesAdmin.block_id.replace( 'id-', '' );
				$( document ).trigger( 'gyan-sites__elementor-plugin-check', { 'id': actual_id } );
			}
		},

		_step2: function( e ) {

			$elscope.find( '.dialog-lightbox-content' ).hide();
			$elscope.find( '.dialog-lightbox-message' ).animate({ scrollTop: 0 }, 50 );
			$elscope.find( '.theme-preview' ).show();

			$elscope.find( '.gyn-sites-modal__header' ).addClass( 'gyn-preview-mode' );

			if ( undefined === GyanElementorSitesAdmin.site_id ) {
				return;
			}

			let import_template = wp.template( 'gyan-sites-elementor-preview' );
			let import_template_header = wp.template( 'gyan-sites-elementor-preview-actions' );
			let template_object = gyanElementorSites.default_page_builder_sites[ GyanElementorSitesAdmin.site_id ]['pages'][ GyanElementorSitesAdmin.page_id ];

			if ( undefined === template_object ) {
				return;
			}

			template_object['id'] = GyanElementorSitesAdmin.site_id;

			preview_page_html = import_template( template_object );
			$elscope.find( '.theme-preview' ).html( preview_page_html );

			$elscope.find( '.gyan-sites-step-1-wrap' ).hide();

			preview_action_html = import_template_header( template_object );
				$elscope.find( '.elementor-templates-modal__header__items-area' ).append( preview_action_html );

			let actual_id = GyanElementorSitesAdmin.page_id.replace( 'id-', '' );
			$( document ).trigger( 'gyan-sites__elementor-plugin-check', { 'id': actual_id } );
		},

		_preview : function( e ) {

			if ( GyanElementorSitesAdmin.processing ) {
				return;
			}

			let step = $( this ).attr( 'data-step' );

			GyanElementorSitesAdmin.site_id = $( this ).closest( '.gyan-theme' ).data( 'site-id' );
			GyanElementorSitesAdmin.page_id = $( this ).closest( '.gyan-theme' ).data( 'template-id' );
			GyanElementorSitesAdmin.block_id = $( this ).closest( '.gyan-theme' ).data( 'block-id' );

			$elscope.find( '.back-to-layout' ).css( 'visibility', 'visible' );
			$elscope.find( '.back-to-layout' ).css( 'opacity', '1' );

			$elscope.find( '.gyn-template-library-toolbar' ).hide();
			$elscope.find( '.gyn-sites-modal__header' ).removeClass( 'gyn-preview-mode' );

			if ( 1 == step ) {

				$elscope.find( '.back-to-layout' ).attr( 'data-step', 2 );
				$( document ).trigger( 'gyan-sites__elementor-do-step-1' );

			} else {

				$elscope.find( '.back-to-layout' ).attr( 'data-step', 3 );
				$( document ).trigger( 'gyan-sites__elementor-do-step-2' );

			}
		},

		_pluginCheck : function( e, data ) {

			var api_post = {
				slug: 'site-pages' + '/' + data['id']
			};

			if ( 'blocks' == GyanElementorSitesAdmin.type ) {
				api_post = {
					slug: 'gyan-blocks' + '/' + data['id']
				};
			}

			var params = {
				method: 'GET',
				cache: 'default',
			};

			fetch( gyanElementorSites.ApiURL + api_post.slug, params ).then( response => {
				if ( response.status === 200 ) {
					return response.json().then(items => ({
						items 		: items,
						items_count	: response.headers.get( 'x-wp-total' ),
						item_pages	: response.headers.get( 'x-wp-totalpages' ),
					}))
				} else {
					//$(document).trigger( 'gyan-sites-api-request-error' );
					return response.json();
				}
			})
			.then(data => {

				if( 'object' === typeof data ) {
					if ( undefined !== data && undefined !== data['items'] ) {
						GyanElementorSitesAdmin.templateData = data['items'];
						if ( GyanElementorSitesAdmin.type == 'pages' ) {
							if ( undefined !== GyanElementorSitesAdmin.templateData['site-pages-required-plugins'] ) {
								GyanElementorSitesAdmin._requiredPluginsMarkup( GyanElementorSitesAdmin.templateData['site-pages-required-plugins'] );
							}
						} else {
							if ( undefined !== GyanElementorSitesAdmin.templateData['post-meta']['gyan-blocks-required-plugins'] ) {
								GyanElementorSitesAdmin._requiredPluginsMarkup( PHP.parse( GyanElementorSitesAdmin.templateData['post-meta']['gyan-blocks-required-plugins'] ) );
							}
						}
					}
			   	}
			});
		},

		_requiredPluginsMarkup: function( requiredPlugins ) {

			if( '' === requiredPlugins ) {
				return;
			}

		 	// Required Required.
			$.ajax({
				url  : gyanElementorSites.ajaxurl,
				type : 'POST',
				data : {
					action           : 'gyan-required-plugins',
					_ajax_nonce      : gyanElementorSites._ajax_nonce,
					required_plugins : requiredPlugins
				},
			})
			.fail(function( jqXHR ){
				console.log( jqXHR );
				console.groupEnd();
			})
			.done(function ( response ) {
				if( false === response.success ) {

					$elscope = $( '#gyn-sites-modal' );
					$elscope.find( '#gyn-sites-floating-notice-wrap-id' ).show().removeClass('error');
					$elscope.find( '#gyn-sites-floating-notice-wrap-id .gyn-sites-floating-notice' ).show().html( '<span class="message">Insufficient Permission. Please contact your Super Admin to allow the install required plugin permissions.<span>' );
					$elscope.find( '#gyn-sites-floating-notice-wrap-id' ).addClass( 'error slide-in' ).removeClass( 'refreshed-notice' );

				} else {
					var output = '';

					/**
					 * Count remaining plugins.
					 * @type number
					 */
					var remaining_plugins = 0;
					var required_plugins_markup = '';

					required_plugins = response.data['required_plugins'];

					if( response.data['third_party_required_plugins'].length ) {
						output += '<li class="plugin-card plugin-card-'+plugin.slug+'" data-slug="'+plugin.slug+'" data-init="'+plugin.init+'" data-name="'+plugin.name+'">'+plugin.name+'</li>';
					}

					/**
					 * Not Installed
					 *
					 * List of not installed required plugins.
					 */
					if ( typeof required_plugins.notinstalled !== 'undefined' ) {

						// Add not have installed plugins count.
						remaining_plugins += parseInt( required_plugins.notinstalled.length );

						$( required_plugins.notinstalled ).each(function( index, plugin ) {
							if ( 'elementor' == plugin.slug ) {
								return;
							}
							output += '<li class="plugin-card plugin-card-'+plugin.slug+'" data-slug="'+plugin.slug+'" data-init="'+plugin.init+'" data-name="'+plugin.name+'">'+plugin.name+'</li>';
						});
					}

					/**
					 * Inactive
					 *
					 * List of not inactive required plugins.
					 */
					if ( typeof required_plugins.inactive !== 'undefined' ) {

						// Add inactive plugins count.
						remaining_plugins += parseInt( required_plugins.inactive.length );

						$( required_plugins.inactive ).each(function( index, plugin ) {
							if ( 'elementor' == plugin.slug ) {
								return;
							}
							output += '<li class="plugin-card plugin-card-'+plugin.slug+'" data-slug="'+plugin.slug+'" data-init="'+plugin.init+'" data-name="'+plugin.name+'">'+plugin.name+'</li>';
						});
					}

					/**
					 * Active
					 *
					 * List of not active required plugins.
					 */
					if ( typeof required_plugins.active !== 'undefined' ) {

						$( required_plugins.active ).each(function( index, plugin ) {
							if ( 'elementor' == plugin.slug ) {
								return;
							}
							output += '<li class="plugin-card plugin-card-'+plugin.slug+'" data-slug="'+plugin.slug+'" data-init="'+plugin.init+'" data-name="'+plugin.name+'">'+plugin.name+'</li>';
						});
					}

					if ( '' != output ) {
						output = '<li class="plugin-card-head"><strong>' + gyanElementorSites.install_plugin_text + '</strong></li>' + output;
						$elscope.find('.required-plugins-list').html( output );
						$elscope.find('.gyn-tooltip-wrap').css( 'opacity', 1 );
						$elscope.find('.gyan-sites-tooltip').css( 'opacity', 1 );
					}


					/**
					 * Enable Demo Import Button
					 * @type number
					 */
					GyanElementorSitesAdmin.requiredPlugins = response.data['required_plugins'];
					GyanElementorSitesAdmin.canImport = true;
					GyanElementorSitesAdmin.canInsert = true;
					$elscope.find( '.gyan-sites-import-template-action > div' ).removeClass( 'disabled' );
				}
			});
		},

		_libraryClick: function( e ) {
			$elscope.find( ".elementor-template-library-menu-item" ).each( function() {
				$(this).removeClass( 'elementor-active' );
			} );
			$( this ).addClass( 'elementor-active' );
		},

		_loadLargeImage: function( el ) {

			if( el.hasClass('loaded') ) {
				return;
			}

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

		_loadLargeImages: function() {
			$elscope.find('.theme-screenshot').each(function( key, el ) {
				GyanElementorSitesAdmin._loadLargeImage( $(el) );
			});
		},

		_close: function( e ) {
			console.groupEnd( 'Process Done.' );
			$( document ).trigger( 'gyan-sites__elementor-close-before' );
			setTimeout( function() {
				$elscope.fadeOut();
				$( 'body' ).removeClass( 'gyan-sites__elementor-open' );
			}, 300 );
			$( document ).trigger( 'gyan-sites__elementor-close-after' );
		},

		_open: function( e ) {
			$( document ).trigger( 'gyan-sites__elementor-open-before' );

			$( 'body' ).addClass( 'gyan-sites__elementor-open' );

			let add_section = $( this ).closest( '.elementor-add-section' );

			if ( add_section.hasClass( 'elementor-add-section-inline' ) ) {
				GyanElementorSitesAdmin.index = add_section.prevAll().length;
			} else {
				GyanElementorSitesAdmin.index = add_section.prev().children().length;
			}
			GyanElementorSitesAdmin._home();
			$elscope.fadeIn();
			if ( $( '.refreshed-notice' ).length == 1 ) {
				setTimeout(
					function() {
						$( '.refreshed-notice' ).find( '.notice-dismiss' ).click();
					},
					2500
				);
			}
			$( document ).trigger( 'gyan-sites__elementor-open-after' );
		},

		_beforeOpen: function( e ) {

			let userPrefersDark = matchMedia( '(prefers-color-scheme: dark)' ).matches;
			let uiTheme = elementor.settings.editorPreferences.model.get( 'ui_theme' );

			if ( 'dark' === uiTheme || ( 'auto' === uiTheme && userPrefersDark ) ) {
				$( 'body' ).addClass( 'gyn-sites-dark-mode' );
			} else {
				$( 'body' ).removeClass( 'gyn-sites-dark-mode' );
			}

			// Hide preview page.
			$elscope.find( '.theme-preview' ).hide();
			$elscope.find( '.theme-preview' ).html( '' );

			// Show site listing page.
			$elscope.find( '.dialog-lightbox-content' ).show();

			// Hide Back button.
			$elscope.find( '.back-to-layout' ).css( 'visibility', 'hidden' );
			$elscope.find( '.back-to-layout' ).css( 'opacity', '0' );
		},

		_initSites: function( e ) {
			GyanElementorSitesAdmin._appendSites( gyanElementorSites.default_page_builder_sites );
			GyanElementorSitesAdmin._goBack();
		},

		_initBlocks: function( e ) {
			GyanElementorSitesAdmin._appendBlocks( gyanElementorSites.gyan_blocks );
			GyanElementorSitesAdmin._goBack();
		},

		_installSuccess: function( event, response ) {

			event.preventDefault();

			// Transform the 'Install' button into an 'Activate' button.
			var $init = $( '.plugin-card-' + response.slug ).data('init');
			var $name = $( '.plugin-card-' + response.slug ).data('name');

			// Reset not installed plugins list.
			var pluginsList = GyanElementorSitesAdmin.requiredPlugins.notinstalled;
			var curr_plugin = GyanElementorSitesAdmin._getPluginFromQueue( response.slug, pluginsList );

			GyanElementorSitesAdmin.requiredPlugins.notinstalled = GyanElementorSitesAdmin._removePluginFromQueue( response.slug, pluginsList );


			// WordPress adds "Activate" button after waiting for 1000ms. So we will run our activation after that.
			setTimeout( function() {

				console.log( 'Activating Plugin - ' + curr_plugin.name );

				$.ajax({
					url: gyanElementorSites.ajaxurl,
					type: 'POST',
					data: {
						'action' : 'gyan-required-plugin-activate',
						'init' : curr_plugin.init,
						'_ajax_nonce' : gyanElementorSites._ajax_nonce,
					},
				})
				.done(function (result) {

					if( result.success ) {
						var pluginsList = GyanElementorSitesAdmin.requiredPlugins.inactive;

						console.log( 'Activated Plugin - ' + curr_plugin.name );

						// Reset not installed plugins list.
						GyanElementorSitesAdmin.requiredPlugins.inactive = GyanElementorSitesAdmin._removePluginFromQueue( response.slug, pluginsList );

						// Enable Demo Import Button
						GyanElementorSitesAdmin._enableImport();

					}
				});

			}, 1200 );

		},

		// Plugin Installation Error
		_installError: function( event, response ) {
			console.log( response );
			console.log( 'Error Installing Plugin - ' + response.slug );
			console.log( response.errorMessage );
		},

		_pluginInstalling: function(event, args) {
			console.log( 'Installing Plugin - ' + args.slug );
		},
	};

	$(function(){
		GyanElementorSitesAdmin.init();
	});

})(jQuery);