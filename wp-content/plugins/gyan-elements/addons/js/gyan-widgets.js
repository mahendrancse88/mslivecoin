(function ($) {
	"use strict";

	var getElementSettings = function ( $element ) {
		var elementSettings = {},
			modelCID 		= $element.data( 'model-cid' );

		if ( elementorFrontend.isEditMode() && modelCID ) {
			var settings 		= elementorFrontend.config.elements.data[ modelCID ],
				settingsKeys 	= elementorFrontend.config.elements.keys[ settings.attributes.widgetType || settings.attributes.elType ];

			jQuery.each( settings.getActiveControls(), function( controlKey ) {
				if ( -1 !== settingsKeys.indexOf( controlKey ) ) {
					elementSettings[ controlKey ] = settings.attributes[ controlKey ];
				}
			} );
		} else {
			elementSettings = $element.data('settings') || {};
		}

		return elementSettings;
	}

	var gyanAccordion = function ($scope, $) {
		var elementSettings 	= getElementSettings( $scope ),
			$accordion_title    = $scope.find(".gyan-accordion-tab-title"),
			$accordion_type     = elementSettings.accordion_type,
			$accordion_speed    = elementSettings.toggle_speed;

		    // Open default actived tab
		    $accordion_title.each(function(){
		        if ( $(this).hasClass('gyan-accordion-tab-active-default') ) {
		            $(this).addClass('gyan-accordion-tab-show gyan-accordion-tab-active');
		            $(this).next().slideDown($accordion_speed);
		           	$(this).parent().addClass('gyan-accordion-item-active');
		        }
		    })

		    // Remove multiple click event for nested accordion
		    $accordion_title.unbind("click");

		    $accordion_title.click(function(e) {
		        e.preventDefault();

		        var $this = $(this);

		        if ( $accordion_type === 'accordion' ) {
		            if ( $this.hasClass("gyan-accordion-tab-show") ) {
		                $this.removeClass("gyan-accordion-tab-show gyan-accordion-tab-active");
		                $this.parent().parent().find(".gyan-accordion-tab-title").removeClass("gyan-accordion-tab-active-default");
		                $this.next().slideUp($accordion_speed);
		                $this.parent().removeClass("gyan-accordion-item-active");
		            } else {
		                $this.parent().parent().find(".gyan-accordion-tab-title").removeClass("gyan-accordion-tab-show gyan-accordion-tab-active");
		                $this.parent().parent().find(".gyan-accordion-tab-title").removeClass("gyan-accordion-tab-active-default");
		                $this.parent().parent().find(".gyan-accordion-tab-content").slideUp($accordion_speed);
		                $this.toggleClass("gyan-accordion-tab-show gyan-accordion-tab-active");
		                $this.next().slideToggle($accordion_speed);
		                $this.parent().parent().find(".gyan-accordion-item").removeClass("gyan-accordion-item-active");
		                $this.parent().toggleClass('gyan-accordion-item-active');
		            }
		        } else {
		            // For acccordion type 'toggle'
		            if ( $this.hasClass("gyan-accordion-tab-show") ) {
		                $this.removeClass("gyan-accordion-tab-show gyan-accordion-tab-active");
		                $this.next().slideUp($accordion_speed);
		                $this.parent().removeClass("gyan-accordion-item-active");
		            } else {
		                $this.addClass("gyan-accordion-tab-show gyan-accordion-tab-active");
		                $this.next().slideDown($accordion_speed);
		                $this.parent().addClass('gyan-accordion-item-active');
		            }
		        }
		    });
	}

	var gyanAnimatedText = function ($scope, $) {

		var $animated_text = $scope.find( '.gyan-animated-text' );

		if ( ! $animated_text.length ) {
			return;
		}

		$animated_text.each(function () {
			var $this = $(this),
				$heading = $scope.find( '.gyan-animated-text > *' ),
				strings = $this.find('.gyan-animated-text-strings'),
				anim = $this.data('anim'),
				speed = $this.data('speed'),
				delay = $this.data('delay'),
				cursor = $this.data('cursor') ? true : false,
				loop = $this.data('loop') ? true : false,
				animatedText = $this.data('animated-text'),
				animatedText = animatedText.split('@@');

			if ( 'typing' == anim ) {
				strings.typed({
					strings: animatedText,
					typeSpeed: speed,
					startDelay: delay,
					showCursor: cursor,
					loop: loop,
				});
			} else{
				strings.Morphext({
					animation: anim,
					separator: '@@',
					speed: delay
				});
			}

			$($heading).animate({
	        	easing:  'slow',
                opacity: 1
            }, 500 );
		});
	}

	var gyanButtonScroll = function ($scope, $) {

		var $this = $scope.find( '.gyan-button-scroll' );

		$this.click(function(e) {
			e.preventDefault();

			var getSettings = $(this).data( 'settings' );
			var getDuration = ( getSettings.duration ) ? ( getSettings.duration ) : '';
			var getOffset = ( getSettings.offset ) ? ( getSettings.offset ) : '';

			var position = $($(this).data('selector')).offset().top;

			$("body, html").animate({
				scrollTop: position + getOffset
			},getDuration );
		});

	}

	var gyanImageCarousel = function ($scope, $) {
		$scope.find('.gyan-image-carousel').each(function () {

			var $this = $(this),
				play = $this.data('autoplay') ? true : false,
				pause = $this.data('pause') ? true : false,
				mouse = $this.data('mouse-drag') ? true : false,
				touch = $this.data('touch-drag') ? true : false,
				loop = $this.data('loop') ? true : false,
				speed = $this.data('speed'),
				speed = speed ? speed : 500,
				delay = $this.data('delay'),
				itemMargin = $this.data('margin'),
				breakpoint1_items = $this.data('breakpoint1-items') ? $this.data('breakpoint1-items') : 5,
				breakpoint2_items = $this.data('breakpoint2-items') ? $this.data('breakpoint2-items') : 4,
				breakpoint3_items = $this.data('breakpoint3-items') ? $this.data('breakpoint3-items') : 3,
				breakpoint4_items = $this.data('breakpoint4-items') ? $this.data('breakpoint4-items') : 2,
				breakpoint5_items = $this.data('breakpoint5-items') ? $this.data('breakpoint5-items') : 1,
				breakpoint6_items = $this.data('breakpoint6-items') ? $this.data('breakpoint6-items') : 1,
				is_rtl = $this.data('rtl') ? true : false;

			//Initialize carousel
			$this.owlCarousel({
				autoplay: play,
				autoplayHoverPause: pause,
				nav: false,
				dots: false,
				mouseDrag: mouse,
				touchDrag: touch,
				loop: loop,
				smartSpeed: speed,
				autoplayTimeout: delay,
				margin:itemMargin,
				rtl:is_rtl,
				responsive: {
					1200: {
						items: breakpoint1_items
					},
					1100: {
						items: breakpoint2_items
					},
					1024: {
						items: breakpoint3_items
					},
					900: {
						items: breakpoint4_items
					},
					700: {
						items: breakpoint5_items
					},
					400: {
						items: breakpoint6_items
					},
					0: {
						items: 1
					},
				}
			});

		});
	}

	var gyanContactFormSevenStyler = function ($scope, $) {

		if ( 'undefined' == typeof $scope )
			return;

		var	cf7SelectFields = $scope.find('select:not([multiple])'),
			cf7Loader = $scope.find('span.ajax-loader');

		cf7SelectFields.wrap( "<span class='gyan-cf7-select-custom'></span>" );

		cf7Loader.wrap( "<div class='gyan-cf7-loader-active'></div>" );

		var wpcf7event = document.querySelector( '.wpcf7' );

		if( null !== wpcf7event ) {
			wpcf7event.addEventListener( 'wpcf7submit', function( event ) {
				var cf7ErrorFields = $scope.find('.wpcf7-not-valid-tip');
			    cf7ErrorFields.wrap( "<span class='gyan-cf7-alert'></span>" );
			}, false );
		}

	}

	var gyanContentSlider = function ($scope, $) {
		$scope.find('.gyan-content-slider').each(function () {

			var $this = $(this),
				itemLg = $this.data('item-lg'),
				itemLg = itemLg ? itemLg : 2,
				itemMd = $this.data('item-md'),
				itemMd = itemMd ? itemMd : 2,
				itemSm = $this.data('item-sm'),
				itemSm = itemSm ? itemSm : 1,
				play = $this.data('autoplay') ? true : false,
				pause = $this.data('pause') ? true : false,
				nav = $this.data('nav') ? true : false,
				dots = $this.data('dots') ? true : false,
				mouse = $this.data('mouse-drag') ? true : false,
				touch = $this.data('touch-drag') ? true : false,
				loop = $this.data('loop') ? true : false,
				speed = $this.data('speed'),
				speed = speed ? speed : 500,
				is_rtl = $this.data('rtl') ? true : false;
				delay = $this.data('delay');

			// Initialize carousel
			$this.owlCarousel({
				autoplay: play,
				autoplayHoverPause: pause,
				nav: nav,
				dots: dots,
				mouseDrag: mouse,
				touchDrag: touch,
				loop: loop,
				smartSpeed: speed,
				autoplayTimeout: delay,
				rtl:is_rtl,
				responsive: {
					0: {
						items: itemSm
					},
					600: {
						items: itemMd
					},
					900: {
						items: itemLg
					},
				}
			});

		});
	}

	var gyanCountdown = function ($scope, $) {
		$scope.find('.gyan-countdown').each(function (item , index) {
			var $this = $(this),
				year  = $this.find('.gyan-cd-year'),
				month = $this.find('.gyan-cd-month'),
				week  = $this.find('.gyan-cd-week'),
				day   = $this.find('.gyan-cd-day'),
				hour  = $this.find('.gyan-cd-hour'),
				min   = $this.find('.gyan-cd-minute'),
				sec   = $this.find('.gyan-cd-second'),
				text  = $this.data('text'),
				standardCountdown  = $this.data('standard-countdown'),
				mesg  = $this.data('message'),
				link   = $this.data('link'),
				time  = $this.data('time'),
				data_text_year    = $this.data('text-year'),
				data_text_years   = $this.data('text-years'),
				data_text_month   = $this.data('text-month'),
				data_text_months  = $this.data('text-months'),
				data_text_week    = $this.data('text-week'),
				data_text_weeks   = $this.data('text-weeks'),
				data_text_day     = $this.data('text-day'),
				data_text_days    = $this.data('text-days'),
				data_text_hour    = $this.data('text-hour'),
				data_text_hours   = $this.data('text-hours'),
				data_text_minute  = $this.data('text-minute'),
				data_text_minutes = $this.data('text-minutes'),
				data_text_second  = $this.data('text-second'),
				data_text_seconds = $this.data('text-seconds');

			$this.countdown( time ).on('update.countdown', function (e) {
				var m = e.strftime('%m'),
					w = e.strftime('%w'),
					Y = Math.floor(m / 12),
					m = m % 12,
					w = w % 4;

				function addZero(val) {
					if ( val < 10 ) {
						return '0'+val;
					}
					return val;
				}

				if ( standardCountdown == 'yes' ) {
					day.html( e.strftime('%D') );
				} else {
					year.html( addZero(Y) );
					month.html( addZero(m) );
					week.html( '0'+w );
					day.html( e.strftime('%d') );
				}

				hour.html( e.strftime('%H') );
				min.html( e.strftime('%M') );
				sec.html( e.strftime('%S') );

				if ( text == 'yes' ) {

					if ( standardCountdown == 'yes' ) {
						day.next().html( e.strftime('%D') < 2 ? data_text_day : data_text_days );
					} else {
						year.next().html( Y < 2 ? data_text_year : data_text_years );
						month.next().html( m < 2 ? data_text_month : data_text_months );
						week.next().html( w < 2 ? data_text_week : data_text_weeks );
						day.next().html( e.strftime('%d') < 2 ? data_text_day : data_text_days );
					}

					hour.next().html( e.strftime('%H') < 2 ? data_text_hour : data_text_hours );
					min.next().html( e.strftime('%M') < 2 ? data_text_minute : data_text_minutes );
					sec.next().html( e.strftime('%S') < 2 ? data_text_second : data_text_seconds );
				}

			}).on('finish.countdown', function (e) {
				$this.children().remove();
				if ( mesg ) {
					$this.append('<div class="gyan-cd-message">'+ mesg +'</div>');
				} else if( link && elementorFrontend.isEditMode() ){
					$this.append('<h2>You can\'t redirect url from elementor edit mode!!</h2>');
				} else if (link) {
					window.location.href = link;
				} else{
					$this.append('<h2>May be you don\'t enter a valid redirect url</h2>');
				}
			});
		});
	}

	var gyanCounter = function ($scope, $) {
		elementorFrontend.waypoint($scope.find('.gyan-counter-number'), function () {
			var $this 	= $(this),
				data 	= $this.data(),
				digit	= data.toValue.toString().match(/\.(.*)/);

			if (digit) {
				data.rounding = digit[1].length;
			}

			$this.numerator(data);
		});
	}

	var gyanGoogleMap = function ($scope, $) {

			if ( 'undefined' == typeof $scope )
				return;

			var selector                = $scope.find( '.gyan-google-map' ).eq(0),
				locations               = selector.data( 'locations' ),
				map_style               = ( selector.data( 'custom-style' ) != '' ) ? selector.data( 'custom-style' ) : '',
				predefined_style 		= ( selector.data( 'predefined-style' ) != '' ) ? selector.data( 'predefined-style' ) : '',
				info_window_size        = ( selector.data( 'max-width' ) != '' ) ? selector.data( 'max-width' ) : '',
				m_cluster            	= ( selector.data( 'cluster' ) == 'yes' ) ? true : false,
				animate            		= selector.data( 'animate' ),
				auto_center				= selector.data( 'auto-center' ),
				map_options             = selector.data( 'map_options' ),
				i                       = '',
				bounds 					= new google.maps.LatLngBounds(),
				marker_cluster 			= [],
				device_size 			= elementorFrontend.getCurrentDeviceMode();

			if( 'drop' == animate ) {
				var animation = google.maps.Animation.DROP;
			} else if( 'bounce' == animate ) {
				var animation = google.maps.Animation.BOUNCE;
			}

			var skins = {
				"silver" : "[{\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#f5f5f5\"}]},{\"elementType\":\"labels.icon\",\"stylers\":[{\"visibility\":\"off\"}]},{\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#616161\"}]},{\"elementType\":\"labels.text.stroke\",\"stylers\":[{\"color\":\"#f5f5f5\"}]},{\"featureType\":\"administrative.land_parcel\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#bdbdbd\"}]},{\"featureType\":\"poi\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#eeeeee\"}]},{\"featureType\":\"poi\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#757575\"}]},{\"featureType\":\"poi.park\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#e5e5e5\"}]},{\"featureType\":\"poi.park\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#9e9e9e\"}]},{\"featureType\":\"road\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#ffffff\"}]},{\"featureType\":\"road.arterial\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#757575\"}]},{\"featureType\":\"road.highway\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#dadada\"}]},{\"featureType\":\"road.highway\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#616161\"}]},{\"featureType\":\"road.local\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#9e9e9e\"}]},{\"featureType\":\"transit.line\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#e5e5e5\"}]},{\"featureType\":\"transit.station\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#eeeeee\"}]},{\"featureType\":\"water\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#c9c9c9\"}]},{\"featureType\":\"water\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#9e9e9e\"}]}]",

				"retro" : "[{\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#ebe3cd\"}]},{\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#523735\"}]},{\"elementType\":\"labels.text.stroke\",\"stylers\":[{\"color\":\"#f5f1e6\"}]},{\"featureType\":\"administrative\",\"elementType\":\"geometry.stroke\",\"stylers\":[{\"color\":\"#c9b2a6\"}]},{\"featureType\":\"administrative.land_parcel\",\"elementType\":\"geometry.stroke\",\"stylers\":[{\"color\":\"#dcd2be\"}]},{\"featureType\":\"administrative.land_parcel\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#ae9e90\"}]},{\"featureType\":\"landscape.natural\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#dfd2ae\"}]},{\"featureType\":\"poi\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#dfd2ae\"}]},{\"featureType\":\"poi\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#93817c\"}]},{\"featureType\":\"poi.park\",\"elementType\":\"geometry.fill\",\"stylers\":[{\"color\":\"#a5b076\"}]},{\"featureType\":\"poi.park\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#447530\"}]},{\"featureType\":\"road\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#f5f1e6\"}]},{\"featureType\":\"road.arterial\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#fdfcf8\"}]},{\"featureType\":\"road.highway\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#f8c967\"}]},{\"featureType\":\"road.highway\",\"elementType\":\"geometry.stroke\",\"stylers\":[{\"color\":\"#e9bc62\"}]},{\"featureType\":\"road.highway.controlled_access\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#e98d58\"}]},{\"featureType\":\"road.highway.controlled_access\",\"elementType\":\"geometry.stroke\",\"stylers\":[{\"color\":\"#db8555\"}]},{\"featureType\":\"road.local\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#806b63\"}]},{\"featureType\":\"transit.line\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#dfd2ae\"}]},{\"featureType\":\"transit.line\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#8f7d77\"}]},{\"featureType\":\"transit.line\",\"elementType\":\"labels.text.stroke\",\"stylers\":[{\"color\":\"#ebe3cd\"}]},{\"featureType\":\"transit.station\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#dfd2ae\"}]},{\"featureType\":\"water\",\"elementType\":\"geometry.fill\",\"stylers\":[{\"color\":\"#b9d3c2\"}]},{\"featureType\":\"water\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#92998d\"}]}]",

				"dark" : "[{\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#212121\"}]},{\"elementType\":\"labels.icon\",\"stylers\":[{\"visibility\":\"off\"}]},{\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#757575\"}]},{\"elementType\":\"labels.text.stroke\",\"stylers\":[{\"color\":\"#212121\"}]},{\"featureType\":\"administrative\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#757575\"}]},{\"featureType\":\"administrative.country\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#9e9e9e\"}]},{\"featureType\":\"administrative.land_parcel\",\"stylers\":[{\"visibility\":\"off\"}]},{\"featureType\":\"administrative.locality\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#bdbdbd\"}]},{\"featureType\":\"poi\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#757575\"}]},{\"featureType\":\"poi.park\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#181818\"}]},{\"featureType\":\"poi.park\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#616161\"}]},{\"featureType\":\"poi.park\",\"elementType\":\"labels.text.stroke\",\"stylers\":[{\"color\":\"#1b1b1b\"}]},{\"featureType\":\"road\",\"elementType\":\"geometry.fill\",\"stylers\":[{\"color\":\"#2c2c2c\"}]},{\"featureType\":\"road\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#8a8a8a\"}]},{\"featureType\":\"road.arterial\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#373737\"}]},{\"featureType\":\"road.highway\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#3c3c3c\"}]},{\"featureType\":\"road.highway.controlled_access\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#4e4e4e\"}]},{\"featureType\":\"road.local\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#616161\"}]},{\"featureType\":\"transit\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#757575\"}]},{\"featureType\":\"water\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#000000\"}]},{\"featureType\":\"water\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#3d3d3d\"}]}]",

				"night" : "[{\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#242f3e\"}]},{\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#746855\"}]},{\"elementType\":\"labels.text.stroke\",\"stylers\":[{\"color\":\"#242f3e\"}]},{\"featureType\":\"administrative.locality\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#d59563\"}]},{\"featureType\":\"poi\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#d59563\"}]},{\"featureType\":\"poi.park\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#263c3f\"}]},{\"featureType\":\"poi.park\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#6b9a76\"}]},{\"featureType\":\"road\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#38414e\"}]},{\"featureType\":\"road\",\"elementType\":\"geometry.stroke\",\"stylers\":[{\"color\":\"#212a37\"}]},{\"featureType\":\"road\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#9ca5b3\"}]},{\"featureType\":\"road.highway\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#746855\"}]},{\"featureType\":\"road.highway\",\"elementType\":\"geometry.stroke\",\"stylers\":[{\"color\":\"#1f2835\"}]},{\"featureType\":\"road.highway\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#f3d19c\"}]},{\"featureType\":\"transit\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#2f3948\"}]},{\"featureType\":\"transit.station\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#d59563\"}]},{\"featureType\":\"water\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#17263c\"}]},{\"featureType\":\"water\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#515c6d\"}]},{\"featureType\":\"water\",\"elementType\":\"labels.text.stroke\",\"stylers\":[{\"color\":\"#17263c\"}]}]",

				"aubergine" : "[{\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#1d2c4d\"}]},{\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#8ec3b9\"}]},{\"elementType\":\"labels.text.stroke\",\"stylers\":[{\"color\":\"#1a3646\"}]},{\"featureType\":\"administrative.country\",\"elementType\":\"geometry.stroke\",\"stylers\":[{\"color\":\"#4b6878\"}]},{\"featureType\":\"administrative.land_parcel\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#64779e\"}]},{\"featureType\":\"administrative.province\",\"elementType\":\"geometry.stroke\",\"stylers\":[{\"color\":\"#4b6878\"}]},{\"featureType\":\"landscape.man_made\",\"elementType\":\"geometry.stroke\",\"stylers\":[{\"color\":\"#334e87\"}]},{\"featureType\":\"landscape.natural\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#023e58\"}]},{\"featureType\":\"poi\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#283d6a\"}]},{\"featureType\":\"poi\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#6f9ba5\"}]},{\"featureType\":\"poi\",\"elementType\":\"labels.text.stroke\",\"stylers\":[{\"color\":\"#1d2c4d\"}]},{\"featureType\":\"poi.park\",\"elementType\":\"geometry.fill\",\"stylers\":[{\"color\":\"#023e58\"}]},{\"featureType\":\"poi.park\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#3C7680\"}]},{\"featureType\":\"road\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#304a7d\"}]},{\"featureType\":\"road\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#98a5be\"}]},{\"featureType\":\"road\",\"elementType\":\"labels.text.stroke\",\"stylers\":[{\"color\":\"#1d2c4d\"}]},{\"featureType\":\"road.highway\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#2c6675\"}]},{\"featureType\":\"road.highway\",\"elementType\":\"geometry.stroke\",\"stylers\":[{\"color\":\"#255763\"}]},{\"featureType\":\"road.highway\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#b0d5ce\"}]},{\"featureType\":\"road.highway\",\"elementType\":\"labels.text.stroke\",\"stylers\":[{\"color\":\"#023e58\"}]},{\"featureType\":\"transit\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#98a5be\"}]},{\"featureType\":\"transit\",\"elementType\":\"labels.text.stroke\",\"stylers\":[{\"color\":\"#1d2c4d\"}]},{\"featureType\":\"transit.line\",\"elementType\":\"geometry.fill\",\"stylers\":[{\"color\":\"#283d6a\"}]},{\"featureType\":\"transit.station\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#3a4762\"}]},{\"featureType\":\"water\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#0e1626\"}]},{\"featureType\":\"water\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#4e6d70\"}]}]",

				"magnesium" : "[{\"featureType\":\"all\",\"stylers\":[{\"saturation\":0},{\"hue\":\"#e7ecf0\"}]},{\"featureType\":\"road\",\"stylers\":[{\"saturation\":-70}]},{\"featureType\":\"transit\",\"stylers\":[{\"visibility\":\"off\"}]},{\"featureType\":\"poi\",\"stylers\":[{\"visibility\":\"off\"}]},{\"featureType\":\"water\",\"stylers\":[{\"visibility\":\"simplified\"},{\"saturation\":-60}]}]",

				"classic_blue" : "[{\"featureType\":\"all\",\"elementType\":\"labels\",\"stylers\":[{\"visibility\":\"on\"}]},{\"featureType\":\"administrative.country\",\"elementType\":\"labels\",\"stylers\":[{\"visibility\":\"on\"}]},{\"featureType\":\"administrative.country\",\"elementType\":\"labels.text\",\"stylers\":[{\"visibility\":\"on\"}]},{\"featureType\":\"administrative.province\",\"elementType\":\"labels\",\"stylers\":[{\"visibility\":\"on\"}]},{\"featureType\":\"administrative.province\",\"elementType\":\"labels.text\",\"stylers\":[{\"visibility\":\"on\"}]},{\"featureType\":\"administrative.locality\",\"elementType\":\"labels\",\"stylers\":[{\"visibility\":\"on\"}]},{\"featureType\":\"administrative.neighborhood\",\"elementType\":\"labels\",\"stylers\":[{\"visibility\":\"off\"}]},{\"featureType\":\"administrative.land_parcel\",\"elementType\":\"labels\",\"stylers\":[{\"visibility\":\"off\"}]},{\"featureType\":\"landscape\",\"elementType\":\"all\",\"stylers\":[{\"hue\":\"#FFBB00\"},{\"saturation\":43.400000000000006},{\"lightness\":37.599999999999994},{\"gamma\":1}]},{\"featureType\":\"landscape\",\"elementType\":\"geometry.fill\",\"stylers\":[{\"saturation\":\"-40\"},{\"lightness\":\"36\"}]},{\"featureType\":\"landscape.man_made\",\"elementType\":\"geometry\",\"stylers\":[{\"visibility\":\"off\"}]},{\"featureType\":\"landscape.natural\",\"elementType\":\"geometry.fill\",\"stylers\":[{\"saturation\":\"-77\"},{\"lightness\":\"28\"}]},{\"featureType\":\"landscape.natural\",\"elementType\":\"labels\",\"stylers\":[{\"visibility\":\"off\"}]},{\"featureType\":\"poi\",\"elementType\":\"all\",\"stylers\":[{\"hue\":\"#00FF6A\"},{\"saturation\":-1.0989010989011234},{\"lightness\":11.200000000000017},{\"gamma\":1}]},{\"featureType\":\"poi\",\"elementType\":\"labels\",\"stylers\":[{\"visibility\":\"off\"}]},{\"featureType\":\"poi.attraction\",\"elementType\":\"labels\",\"stylers\":[{\"visibility\":\"off\"}]},{\"featureType\":\"poi.park\",\"elementType\":\"geometry.fill\",\"stylers\":[{\"saturation\":\"-24\"},{\"lightness\":\"61\"}]},{\"featureType\":\"road\",\"elementType\":\"labels\",\"stylers\":[{\"visibility\":\"on\"}]},{\"featureType\":\"road\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"visibility\":\"on\"}]},{\"featureType\":\"road\",\"elementType\":\"labels.icon\",\"stylers\":[{\"visibility\":\"off\"}]},{\"featureType\":\"road.highway\",\"elementType\":\"all\",\"stylers\":[{\"hue\":\"#FFC200\"},{\"saturation\":-61.8},{\"lightness\":45.599999999999994},{\"gamma\":1}]},{\"featureType\":\"road.highway\",\"elementType\":\"labels.icon\",\"stylers\":[{\"visibility\":\"off\"}]},{\"featureType\":\"road.highway.controlled_access\",\"elementType\":\"labels.icon\",\"stylers\":[{\"visibility\":\"off\"}]},{\"featureType\":\"road.arterial\",\"elementType\":\"all\",\"stylers\":[{\"hue\":\"#FF0300\"},{\"saturation\":-100},{\"lightness\":51.19999999999999},{\"gamma\":1}]},{\"featureType\":\"road.local\",\"elementType\":\"all\",\"stylers\":[{\"hue\":\"#ff0300\"},{\"saturation\":-100},{\"lightness\":52},{\"gamma\":1}]},{\"featureType\":\"road.local\",\"elementType\":\"labels.icon\",\"stylers\":[{\"visibility\":\"off\"}]},{\"featureType\":\"transit\",\"elementType\":\"geometry\",\"stylers\":[{\"visibility\":\"off\"}]},{\"featureType\":\"transit\",\"elementType\":\"geometry.stroke\",\"stylers\":[{\"visibility\":\"off\"}]},{\"featureType\":\"transit\",\"elementType\":\"labels\",\"stylers\":[{\"visibility\":\"off\"}]},{\"featureType\":\"transit\",\"elementType\":\"labels.icon\",\"stylers\":[{\"visibility\":\"off\"}]},{\"featureType\":\"transit.line\",\"elementType\":\"labels\",\"stylers\":[{\"visibility\":\"off\"}]},{\"featureType\":\"transit.station\",\"elementType\":\"labels.icon\",\"stylers\":[{\"visibility\":\"off\"}]},{\"featureType\":\"water\",\"elementType\":\"all\",\"stylers\":[{\"hue\":\"#0078FF\"},{\"saturation\":-13.200000000000003},{\"lightness\":2.4000000000000057},{\"gamma\":1}]},{\"featureType\":\"water\",\"elementType\":\"labels\",\"stylers\":[{\"visibility\":\"off\"}]}]",

				"aqua" : "[{\"featureType\":\"administrative\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#444444\"}]},{\"featureType\":\"landscape\",\"elementType\":\"all\",\"stylers\":[{\"color\":\"#f2f2f2\"}]},{\"featureType\":\"poi\",\"elementType\":\"all\",\"stylers\":[{\"visibility\":\"off\"}]},{\"featureType\":\"road\",\"elementType\":\"all\",\"stylers\":[{\"saturation\":-100},{\"lightness\":45}]},{\"featureType\":\"road.highway\",\"elementType\":\"all\",\"stylers\":[{\"visibility\":\"simplified\"}]},{\"featureType\":\"road.arterial\",\"elementType\":\"labels.icon\",\"stylers\":[{\"visibility\":\"off\"}]},{\"featureType\":\"transit\",\"elementType\":\"all\",\"stylers\":[{\"visibility\":\"off\"}]},{\"featureType\":\"water\",\"elementType\":\"all\",\"stylers\":[{\"color\":\"#46bcec\"},{\"visibility\":\"on\"}]}]",

				"earth" : "[{\"featureType\":\"landscape.man_made\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#f7f1df\"}]},{\"featureType\":\"landscape.natural\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#d0e3b4\"}]},{\"featureType\":\"landscape.natural.terrain\",\"elementType\":\"geometry\",\"stylers\":[{\"visibility\":\"off\"}]},{\"featureType\":\"poi\",\"elementType\":\"labels\",\"stylers\":[{\"visibility\":\"off\"}]},{\"featureType\":\"poi.business\",\"elementType\":\"all\",\"stylers\":[{\"visibility\":\"off\"}]},{\"featureType\":\"poi.medical\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#fbd3da\"}]},{\"featureType\":\"poi.park\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#bde6ab\"}]},{\"featureType\":\"road\",\"elementType\":\"geometry.stroke\",\"stylers\":[{\"visibility\":\"off\"}]},{\"featureType\":\"road\",\"elementType\":\"labels\",\"stylers\":[{\"visibility\":\"off\"}]},{\"featureType\":\"road.highway\",\"elementType\":\"geometry.fill\",\"stylers\":[{\"color\":\"#ffe15f\"}]},{\"featureType\":\"road.highway\",\"elementType\":\"geometry.stroke\",\"stylers\":[{\"color\":\"#efd151\"}]},{\"featureType\":\"road.arterial\",\"elementType\":\"geometry.fill\",\"stylers\":[{\"color\":\"#ffffff\"}]},{\"featureType\":\"road.local\",\"elementType\":\"geometry.fill\",\"stylers\":[{\"color\":\"black\"}]},{\"featureType\":\"transit.station.airport\",\"elementType\":\"geometry.fill\",\"stylers\":[{\"color\":\"#cfb2db\"}]},{\"featureType\":\"water\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#a2daf2\"}]}]"
			};

			if( 'undefined' != typeof skins[predefined_style] ) {
				map_style = JSON.parse( skins[predefined_style] );
			}


			( function initMap () {

				var latlng = new google.maps.LatLng( locations[0][0], locations[0][1] );

				map_options.center = latlng;
				map_options.styles = map_style;

				var map = new google.maps.Map( $scope.find( '.gyan-google-map' )[0], map_options );
				var infowindow = new google.maps.InfoWindow();

				for ( i = 0; i < locations.length; i++ ) {

					var title = locations[i][3];
					var description = locations[i][4];
					var icon_size = parseInt( locations[i][7] );
					var icon_type = locations[i][5];
					var icon = '';
					var icon_url = locations[i][6];
					var enable_iw = locations[i][2];
					var click_open = locations[i][8];
					var lat = locations[i][0];
					var lng = locations[i][1];

					if( 'undefined' === typeof locations[i] ) {
						return;
					}

					if ( '' != lat.length && '' != lng.length ) {

						if ( 'custom' == icon_type ) {

							icon = {
								url: icon_url,
							};
							if( ! isNaN( icon_size ) ) {

								icon.scaledSize = new google.maps.Size( icon_size, icon_size );
								icon.origin = new google.maps.Point( 0, 0 );
								icon.anchor = new google.maps.Point( icon_size/2, icon_size );

							}
						}

						var marker = new google.maps.Marker( {
							position:       new google.maps.LatLng( lat, lng ),
							map:            map,
							title:          title,
							icon:           icon,
							animation: 		animation
						});

						if( locations.length > 1 ) {

							// Extend the bounds to include each marker's position
							bounds.extend( marker.position );
						}

						marker_cluster[i] = marker;

						if ( enable_iw && 'iw_open' == click_open ) {

							var content_string = '<div class="gyan-infowindow-content"><div class="gyan-infowindow-title">' + title + '</div>';

							if ( '' != description.length ) {
								content_string += '<div class="gyan-infowindow-description">' + description + '</div>';
							}
							content_string += '</div>';

							if ( '' != info_window_size  ) {
								var width_val = parseInt( info_window_size );
								var infowindow = new google.maps.InfoWindow( {
									content: content_string,
									maxWidth: width_val
								} );
							} else {
								var infowindow = new google.maps.InfoWindow( {
									content: content_string,
								} );
							}

							infowindow.open( map, marker );
						}

						// Adding close event for info window
						google.maps.event.addListener( map, 'click', ( function ( infowindow ) {

							return function() {
								infowindow.close();
							}
						})( infowindow ));

						if ( enable_iw && '' != locations[i][3] ) {

							google.maps.event.addListener( marker, 'click', ( function( marker, i ) {
								return function() {
									var infowindow = new google.maps.InfoWindow();
									var content_string = '<div class="gyan-infowindow-content"><div class="gyan-infowindow-title">' + locations[i][3] + '</div>';

									if ( '' != locations[i][4].length ) {
										content_string += '<div class="gyan-infowindow-description">' + locations[i][4] + '</div>';
									}

									content_string += '</div>';

									infowindow.setContent( content_string );

									if ( '' != info_window_size ) {
										var width_val = parseInt( info_window_size );
										var InfoWindowOptions = { maxWidth : width_val };
										infowindow.setOptions( { options:InfoWindowOptions } );
									}

									infowindow.open( map, marker );
								}
							})( marker, i ));
						}
					}
				}

				if( locations.length > 1 ) {

					if ( 'center' == auto_center ) {

						// Now fit the map to the newly inclusive bounds.
						map.fitBounds( bounds );
					}

					// Restore the zoom level after the map is done scaling.
					var listener = google.maps.event.addListener( map, "idle", function () {
						map.setZoom( map_options.zoom );
						google.maps.event.removeListener( listener );
					});
				}

				var cluster_listener = google.maps.event.addListener( map, "idle", function () {

					if( 0 < marker_cluster.length && m_cluster ) {

						var markerCluster = new MarkerClusterer(
							map,
							marker_cluster,
							{
								imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
							}
						);
					}
					google.maps.event.removeListener( cluster_listener );
				});


			})();
		}

	var gyanPiechart = function ($scope, $) {
		elementorFrontend.waypoint($scope.find('.gyan-piechart-wrap'), function () {
			var $this 		= $(this),
				trackColor	= $this.data('track'),
				trackWidth	= $this.data('track-width'),
				barColor	= $this.data('bar'),
				lineWidth	= $this.data('line'),
				lineCap		= $this.data('cap'),
				animSpeed	= $this.data('speed'),
				scale		= $this.data('scale'),
				size		= $this.data('size');

			$this.easyPieChart({
				trackColor: trackColor,
				barColor: barColor,
				lineWidth: lineWidth,
				lineCap: lineCap,
				animate: animSpeed,
				scaleColor: scale,
				size: size,
				rotate:0
			});
		});
	}

	var gyanModalBox = function ($scope, $) {
		$scope.find('.gyan-modal-box').each(function () {
			var $this = $(this),
				$id = $this.data('modal-id'),
				$btn = $('#'+$id),
				$cBtn = $('.gyan-modal-close.'+$id),
				$modal = $('.gyan-modal-overlay.'+$id);

				$btn.click( function() {
					$modal.fadeIn( 400 );
				});
				$cBtn.click( function() {
					$modal.fadeOut('400');
				});
		});
	}

	var gyanProgressbars = function ($scope, $) {

        var item = $scope.find('.gyan-progress-bar');

        if (item.length) {
            item.each(function() {
					var item      = jQuery(this),
					default_title = false,
					title         = item.find('.gyan-pbar-title-holder'),
					pbar           = item.find('.gyan-progress-bar-data'),
					data_width    = pbar.data('width'),
					counter       = item.find('.gyan-pbar-p-number'),
					duration      = parseFloat(pbar.css('transition-duration'))*1000,
					interval      = Math.floor(duration/data_width),
					cnt           = 0;
                    if (item.hasClass('pbp-default')) {
                        default_title = true;
                    }
               pbar.css('width',data_width+'%');
                    if ( default_title ) {
                        title.css('width', data_width+'%');
                    }
                    var recap = setInterval( function() {
                        counter.text(cnt);
                        cnt++;
                    }, interval);
                    var stopCounter = setTimeout(function() {
                    clearInterval(recap);
                    counter.text(data_width);
                    }, duration);
            });
        }
	}

	var gyanTestimonials = function ($scope, $) {
		$scope.find('.gyan-testimonials').each(function () {
			var $this = $(this),
				play = $this.data('autoplay') ? true : false,
				pause = $this.data('pause') ? true : false,
				nav = $this.data('nav') ? true : false,
				dots = $this.data('dots') ? true : false,
				mouse = $this.data('mouse-drag') ? true : false,
				touch = $this.data('touch-drag') ? true : false,
				loop = $this.data('loop') ? true : false,
				speed = $this.data('speed') ? $this.data('speed') : 500,
				space = $this.data('item-space') ? $this.data('item-space') : 30,
				breakpoint1_items = $this.data('breakpoint1-items') ? $this.data('breakpoint1-items') : 1,
				breakpoint2_items = $this.data('breakpoint2-items') ? $this.data('breakpoint2-items') : 1,
				breakpoint3_items = $this.data('breakpoint3-items') ? $this.data('breakpoint3-items') : 1,
				breakpoint4_items = $this.data('breakpoint4-items') ? $this.data('breakpoint4-items') : 1,
				is_rtl = $this.data('rtl') ? true : false,
				delay = $this.data('delay');

			//Initialize carousel
			$this.owlCarousel({
				autoplay: play,
				autoplayHoverPause: pause,
				nav: nav,
				dots: dots,
				mouseDrag: mouse,
				touchDrag: touch,
				loop: loop,
				smartSpeed: speed,
				autoplayTimeout: delay,
				margin: 0,
				navText:'',
				rtl:is_rtl,
				responsive: {
					1000: {
						items: breakpoint1_items
					},
					900: {
						items: breakpoint2_items
					},
					700: {
						items: breakpoint3_items
					},
					400: {
						items: breakpoint4_items
					},
					0: {
						items: 1
					},
				}
			});

		});
	}

	var gyanMCSubscribe = function ($scope, $) {
		$scope.find('.gyan-subs-form').each(function () {
			var $this = $(this),
				$uid = $this.data('uid'),
				$nonce = $this.find('#gyan_mc_subscribe_nonce'+$uid),
				$fname = $this.find('.gyan-input-fname'),
				$lname = $this.find('.gyan-input-lname'),
				$email = $this.find('.gyan-input-email'),
				$phone = $this.find('.gyan-input-phone'),
				$success = $this.children('.gyan-subs-success'),
				$error = $this.children('.gyan-subs-error'),
				$process = $this.children('.gyan-subs-process'),
				timeout;

			$this.on('submit', function(e) {
				e.preventDefault();
				clearTimeout(timeout);

				$error.fadeOut(0);
				$success.fadeOut(0);
				$process.fadeIn(200);


				$.post(
					gyanAjax.ajaxURL,
					{
						action: "gyan_mc_subscribe",
						fname: $fname.val() || ' ',
						lname: $lname.val() || ' ',
						phone: $phone.val() || ' ',
						email: $email.val(),
						nonce: $nonce.val(),
					},
					function( data, status, code ) {
						if ( status == 'success' ) {
							if ( 'success' == data ) {
								$process.fadeOut(0);
								$success.html( "Thanks for subscribed!" ).fadeIn(200);

								timeout = setTimeout( function() {
									$success.fadeOut(200);
								}, 10000 );
							} else{
								$process.fadeOut(0);
								$error.html( data ).fadeIn(200);

								timeout = setTimeout( function() {
									$error.fadeOut(200);
								}, 10000 );
							}
						}
					}
				);

			});
		});
	}

	var gyanContentToggle = function ($scope, $) {

		if ( 'undefined' == typeof $scope ) {
			return;
		}

		var $this             = $scope.find( '.gyan-ctoggle-wrapper' );
		var node_id           = $scope.data( 'id' );
		var ctoggle_section_1 = $scope.find( ".gyan-ctoggle-section-1" );
		var ctoggle_section_2 = $scope.find( ".gyan-ctoggle-section-2" );
		var main_btn          = $scope.find( ".gyan-main-btn" );
		var switch_type       = main_btn.attr( 'data-switch-type' );
		var ctoggle_label_1   = $scope.find( ".gyan-sec-1" );
		var ctoggle_label_2   = $scope.find( ".gyan-sec-2" );
		var current_class;

		switch ( switch_type ) {
			case 'round_1':
				current_class = '.gyan-switch-round-1';
				break;
			case 'round_2':
				current_class = '.gyan-switch-round-2';
				break;
			case 'rectangle':
				current_class = '.gyan-switch-rectangle';
				break;
			default:
				current_class = 'No Class Selected';
				break;
		}

		var ctoggle_switch = $scope.find( current_class );

		if( ctoggle_switch.is( ':checked' ) ) {
			ctoggle_section_1.hide();
			ctoggle_section_2.show();
		} else {
			ctoggle_section_1.show();
			ctoggle_section_2.hide();
		}

		ctoggle_switch.on('click', function(e){
	        ctoggle_section_1.toggle();
	        ctoggle_section_2.toggle();
	    });

		ctoggle_label_1.on('click', function(e){
			ctoggle_switch.prop("checked", false);
			ctoggle_section_1.show();
			ctoggle_section_2.hide();

	    });

		ctoggle_label_2.on('click', function(e){
			ctoggle_switch.prop("checked", true);
			ctoggle_section_1.hide();
			ctoggle_section_2.show();
	    });
	}

	var gyanVideo = function ($scope, $) {

		var shalPlayVideo = {

			/* Auto Play Video */
			_play: function( selector ) {

				var iframe 		= $( "<iframe/>" );
		        var vurl 		= selector.data( 'src' );

		        if ( 0 == selector.find( 'iframe' ).length ) {

					iframe.attr( 'src', vurl );
					iframe.attr( 'frameborder', '0' );
					iframe.attr( 'allowfullscreen', '1' );
					iframe.attr( 'allow', 'autoplay;encrypted-media;' );

					selector.html( iframe );
		        }

		        selector.closest( '.gyan-video-container' ).find( '.gyan-video-vimeo-wrap' ).hide();
			}
		}

		var video_container = $scope.find( '.gyan-video-container' );
		var video_holder = $scope.find( '.gyan-video-holder' );

		video_container.off( 'click' ).on( 'click', function( e ) {

			var selector = $( this ).find( '.gyan-video__play' );

			shalPlayVideo._play( selector );
		});

		if( '1' == video_container.data( 'autoplay' ) || true == video_container.data( 'device' ) ) {

			shalPlayVideo._play( $scope.find( '.gyan-video__play' ) );
		}

	}

	var gyanImageSlider = function ($scope, $) {

	    var $carousel            = $scope.find( '.gyan-image-slider' ).eq( 0 ),
	        $slider_id           = $carousel.attr( 'id' ),
	        $carousel_settings   = $carousel.data('slider-settings'),
	        $slider_wrap         = $scope.find( '.gyan-image-slider-wrap' ),
	        $thumbs_nav          = $scope.find( '.gyan-image-slider-container .gyan-image-slider-thumb-item-wrap' ),
	        elementSettings      = getElementSettings( $scope );

	        $carousel.slick( $carousel_settings );

	        $carousel.slick( 'setPosition' );

	        if ( elementSettings.skin == 'slideshow' ) {
	            $thumbs_nav.removeClass('gyan-active-slide');
	            $thumbs_nav.eq(0).addClass('gyan-active-slide');

	            $carousel.on('beforeChange', function ( event, slick, currentSlide, nextSlide ) {
	                var currentSlide = nextSlide;
	                $thumbs_nav.removeClass('gyan-active-slide');
	                $thumbs_nav.eq( currentSlide ).addClass('gyan-active-slide');
	            });

	            $thumbs_nav.each( function( currentSlide ) {
	                $(this).on( 'click', function ( e ) {
	                    e.preventDefault();
	                    $carousel.slick( 'slickGoTo', currentSlide );
	                });
	            });
	        }

	        if ( elementorFrontend.isEditMode() ) {
	            $slider_wrap.resize( function() {
	                $carousel.slick( 'setPosition' );
	            });
	        }
	}

	var gyanImageAccordion = function ($scope, $) {

		$scope.find('.gyan-image-accordion').each(function () {

			var $image_accordion            = $(this).eq(0),
	            elementSettings             = getElementSettings( $scope ),
	            $action                     = elementSettings.accordion_action,
			    $id                         = $image_accordion.attr( 'id' ),
			    $item                       = $('#'+ $id +' .gyan-image-accordion-item');

	            $item.hover(
	                function ImageAccordionHover() {
	                    $item.css('flex', '1');
	                    $item.removeClass('gyan-image-accordion-active');
	                    $(this).addClass('gyan-image-accordion-active');
	                    $item.find('.gyan-image-accordion-content-wrap').removeClass('gyan-image-accordion-content-active');
	                    $(this).find('.gyan-image-accordion-content-wrap').addClass('gyan-image-accordion-content-active');
	                    $(this).css('flex', '3');
	                },
	                function() {
	                    $item.css('flex', '1');
	                    $item.find('.gyan-image-accordion-content-wrap').removeClass('gyan-image-accordion-content-active');
	                    $item.removeClass('gyan-image-accordion-active');
	                }
	            );

		});

    }

	var gyanFilterableGallery = function ($scope, $) {
		$scope.find('.gyan-filterable-gallery').each(function () {
			var $this = $(this),
				$isoGrid = $this.children('.gyan-filterable-gallery-grid'),
				$btns = $this.children('.gyan-filterable-gallery-btns'),
				is_rtl = $this.data('rtl') ? false : true,
				layout = $this.data('layout');

			$this.imagesLoaded( function() {
				if ( 'masonry' == layout ) {
					var $grid = $isoGrid.isotope({
						itemSelector: '.gyan-filterable-gallery-item',
						percentPosition: true,
						originLeft: is_rtl,
						masonry: {
							columnWidth: '.gyan-filterable-gallery-item',
						}
					});
				} else{
					var $grid = $isoGrid.isotope({
						itemSelector: '.gyan-filterable-gallery-item',
						layoutMode: 'fitRows',
						originLeft: is_rtl
					});

				}

				$btns.on('click', 'button', function () {
					var filterValue = $(this).attr('data-filter');
					$grid.isotope({
						filter: filterValue,
						originLeft: is_rtl
					});
				});

				$btns.each(function (i, btns) {
					var btns = $(btns);

					btns.on('click', '.gyan-filterable-gallery-btn', function () {
						btns.find('.is-checked').removeClass('is-checked');
						$(this).addClass('is-checked');
					});
				});

			});

		});
	}


	var gyanPortfolio = function ($scope, $) {
		$scope.find('.gyan-portfolio').each(function () {
			var $this = $(this),
				$isoGrid = $this.children('.gyan-portfolio-grid'),
				$btns = $this.children('.gyan-portfolio-btns'),
				is_rtl = $this.data('rtl') ? false : true,
				layout = $this.data('layout');

			$this.imagesLoaded( function() {
				if ( 'masonry' == layout ) {
					var $grid = $isoGrid.isotope({
						itemSelector: '.gyan-portfolio-item',
						percentPosition: true,
						originLeft: is_rtl,
						masonry: {
							columnWidth: '.gyan-portfolio-item',
						}
					});
				} else{
					var $grid = $isoGrid.isotope({
						itemSelector: '.gyan-portfolio-item',
						layoutMode: 'fitRows',
						originLeft: is_rtl,
					});

				}

				$btns.on('click', 'button', function () {
					var filterValue = $(this).attr('data-filter');
					$grid.isotope({
						filter: filterValue,
						originLeft: is_rtl
					});
				});

				$btns.each(function (i, btns) {
					var btns = $(btns);

					btns.on('click', '.gyan-portfolio-btn', function () {
						btns.find('.is-checked').removeClass('is-checked');
						$(this).addClass('is-checked');
					});
				});

			});

		});
	}

	var gyanTeam = function ($scope, $) {
		$scope.find('.gyan-team').each(function () {
			var $this = $(this),
				$isoGrid = $this.children('.gyan-team-grid'),
				$btns = $this.children('.gyan-team-btns'),
				is_rtl = $this.data('rtl') ? false : true,
				layout = $this.data('layout');

			$this.imagesLoaded( function() {
				if ( 'masonry' == layout ) {
					var $grid = $isoGrid.isotope({
						itemSelector: '.gyan-team-item',
						percentPosition: true,
						originLeft: is_rtl,
						masonry: {
							columnWidth: '.gyan-team-item',
						}
					});
				} else{
					var $grid = $isoGrid.isotope({
						itemSelector: '.gyan-team-item',
						layoutMode: 'fitRows',
						originLeft: is_rtl
					});

				}

			});

		});
	}

	var gyanVideoPopup = function ($scope, $) {
		$scope.find('.gyan-video-lightbox').each(function () {
			var $this = $(this);
			$this.magnificPopup({
	            disableOn: 700,
	            type: 'iframe',
	            mainClass: 'mfp-fade',
	            removalDelay: 160,
	            preloader: false,
	            fixedContentPos: false
        	});
		});
	}


	var gyanPostGrid = function ($scope, $) {
		$scope.find('.gyan-post-grid-container').each(function () {
			var $this = $(this),
				$isoGrid = $this.children('.gyan-post-grid'),
				$btns = $this.children('.gyan-post-grid-btns'),
				is_rtl = $this.data('rtl') ? false : true,
				layout = $this.data('layout');

			$this.imagesLoaded( function() {
				if ( 'masonry' == layout ) {
					var $grid = $isoGrid.isotope({
						itemSelector: '.gyan-post-grid-item',
						percentPosition: true,
						originLeft: is_rtl,
						masonry: {
							columnWidth: '.gyan-post-grid-item',
						}
					});
				} else{
					var $grid = $isoGrid.isotope({
						itemSelector: '.gyan-post-grid-item',
						originLeft: is_rtl,
						layoutMode: 'fitRows'
					});

				}

				$btns.on('click', 'button', function () {
					var filterValue = $(this).attr('data-filter');
					$grid.isotope({
						filter: filterValue,
						originLeft: is_rtl
					});
				});

				$btns.each(function (i, btns) {
					var btns = $(btns);

					btns.on('click', '.gyan-post-grid-btn', function () {
						btns.find('.is-checked').removeClass('is-checked');
						$(this).addClass('is-checked');
					});
				});

			});

		});
	}

   var gyanTabs = function ($scope, $) {
        var $currentTab = $scope.find(".gyan-tabs"),
            $currentTabId = "#" + $currentTab.attr("id").toString();

        $($currentTabId + " .gyan-tabs-nav ul li").each(function(index) {
            if ($(this).hasClass("active-default")) {
                $($currentTabId + " .gyan-tabs-nav > ul li").removeClass("active").addClass("inactive");
                $(this).removeClass("inactive");

            } else {
                if (index == 0) {
                    $(this).removeClass("inactive").addClass("active");
                }
            }
        });

        $($currentTabId + " .gyan-tabs-content div").each(function(index) {
            if ($(this).hasClass("active-default")) {
                $($currentTabId + " .gyan-tabs-content > div").removeClass(
                    "active"
                );
            } else {
                if (index == 0) {
                    $(this).removeClass("inactive").addClass("active");
                }
            }
        });

        $($currentTabId + " .gyan-tabs-nav ul li").click(function() {
            var currentTabIndex = $(this).index();
            var tabsContainer = $(this).closest(".gyan-tabs");
            var tabsNav = $(tabsContainer).children(".gyan-tabs-nav").children("ul").children("li");
            var tabsContent = $(tabsContainer).children(".gyan-tabs-content").children("div");
            $(this).parent("li") .addClass("active");
            $(tabsNav).removeClass("active active-default").addClass("inactive");
            $(this).addClass("active").removeClass("inactive");
            $(tabsContent).removeClass("active").addClass("inactive");
            $(tabsContent).eq(currentTabIndex).addClass("active").removeClass("inactive");

            $(tabsContent).each(function(index) {
                $(this).removeClass("active-default");
            });
        });
    }

   var gyanTabsSlider = function ($scope, $) {

    	$scope.find('.gyan-tabs-slider').each(function () {

			var gyanTabsSliderTab = $(this).find( ".gyan-tabs-slider-tab" );

            $(gyanTabsSliderTab).on('click', function(e) {
                e.preventDefault();
                var target = $($(this).attr('data-tab'));
                console.log(target);

                if ($(target).is(':visible')){
                    return false;
                }else{
                    target.parents('.gyan-tabs-slider').find('.gyan-tabs-slider-list-tabs').find('.gyan-tabs-slider-tab').removeClass('active-tab');
                    $(this).addClass('active-tab');
                    target.parents('.gyan-tabs-slider').find('.gyan-tabs-slider-content').find('.gyan-tabs-slider-image').fadeOut(0);
                    target.parents('.gyan-tabs-slider').find('.gyan-tabs-slider-content').find('.gyan-tabs-slider-image').removeClass('active-tab-image');
                    $(target).fadeIn(300);
                    $(target).addClass('active-tab-image');
                }
            });

        });
    }

   var gyanImageMarquee = function ($scope, $) {
    	$scope.find('.gyan-image-marquee').each(function () {

    		var $this = $(this),
    		hover = ( 'yes' === $this.data('hover') ) ? 1 : 0,
    		drag = ( 'yes' === $this.data('drag') ) ? 1 : 0,
    		direction = $this.data('direction');

    		$this.imagesLoaded( function() {
    			$this.liMarquee({
					direction: direction,
					loop: -1,
					hoverstop: hover,
					scrolldelay: 0,
					scrollamount: 30,
					circular: !0,
					drag: drag
			    });

    		});
    	});
    }

   var gyanServices = function ($scope, $) {
    	$scope.find('.gyan-services-container').each(function () {
    		var $this = $(this),
    			$isoGrid = $this.children('.gyan-services-items'),
    			is_rtl = $this.data('rtl') ? false : true,
    			layout = $this.data('layout');

    		$this.imagesLoaded( function() {
    			if ( 'masonry' == layout ) {
    				var $grid = $isoGrid.isotope({
    					itemSelector: '.gyan-service-item',
    					percentPosition: true,
    					originLeft: is_rtl,
    					masonry: {
    						columnWidth: '.gyan-service-item',
    					}
    				});
    			} else{
    				var $grid = $isoGrid.isotope({
    					itemSelector: '.gyan-service-item',
    					layoutMode: 'fitRows',
    					originLeft: is_rtl
    				});
    			}
    		});
    	});
    }

   var gyanServicesFullText = function ($scope, $) {
    	$scope.find('.gyan-services-full-container').each(function () {
    		var $this = $(this),
    			$isoGrid = $this.children('.gyan-services-full-items'),
    			is_rtl = $this.data('rtl') ? false : true,
    			layout = $this.data('layout');

    		$this.imagesLoaded( function() {
    			if ( 'masonry' == layout ) {
    				var $grid = $isoGrid.isotope({
    					itemSelector: '.gyan-service-full-item',
    					percentPosition: true,
    					originLeft: is_rtl,
    					masonry: {
    						columnWidth: '.gyan-service-full-item',
    					}
    				});
    			} else{
    				var $grid = $isoGrid.isotope({
    					itemSelector: '.gyan-service-full-item',
    					layoutMode: 'fitRows',
    					originLeft: is_rtl
    				});
    			}
    		});
    	});
    }

	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/gyan_accordion.default', gyanAccordion);
		elementorFrontend.hooks.addAction('frontend/element_ready/gyan_image_carousel.default', gyanImageCarousel);
		elementorFrontend.hooks.addAction('frontend/element_ready/gyan_content_slider.default', gyanContentSlider);
		elementorFrontend.hooks.addAction('frontend/element_ready/gyan_countdown.default', gyanCountdown);
		elementorFrontend.hooks.addAction('frontend/element_ready/gyan_counter.default', gyanCounter);
		elementorFrontend.hooks.addAction('frontend/element_ready/gyan_animated_text.default', gyanAnimatedText);
		elementorFrontend.hooks.addAction('frontend/element_ready/gyan_piechart.default', gyanPiechart);
		elementorFrontend.hooks.addAction('frontend/element_ready/gyan_modal_box.default', gyanModalBox);
		elementorFrontend.hooks.addAction('frontend/element_ready/gyan_progressbar.default', gyanProgressbars);
		elementorFrontend.hooks.addAction('frontend/element_ready/gyan_testimonials.default', gyanTestimonials);
		elementorFrontend.hooks.addAction('frontend/element_ready/gyan_mc_subscribe.default', gyanMCSubscribe);
		elementorFrontend.hooks.addAction('frontend/element_ready/gyan_content_toggle.default', gyanContentToggle );
		elementorFrontend.hooks.addAction('frontend/element_ready/gyan_google_map.default', gyanGoogleMap );
		elementorFrontend.hooks.addAction('frontend/element_ready/gyan_contact_form_styler.default', gyanContactFormSevenStyler );
		elementorFrontend.hooks.addAction('frontend/element_ready/gyan_button_scroll.default', gyanButtonScroll );
		elementorFrontend.hooks.addAction('frontend/element_ready/gyan_video.default', gyanVideo );
		elementorFrontend.hooks.addAction('frontend/element_ready/gyan_image_slider.default', gyanImageSlider );
		elementorFrontend.hooks.addAction('frontend/element_ready/gyan_image_accordion.default', gyanImageAccordion );
		elementorFrontend.hooks.addAction('frontend/element_ready/gyan_filterable_gallery.default', gyanFilterableGallery );
		elementorFrontend.hooks.addAction('frontend/element_ready/gyan_portfolio.default', gyanPortfolio );
		elementorFrontend.hooks.addAction('frontend/element_ready/gyan_team.default', gyanTeam );
		elementorFrontend.hooks.addAction('frontend/element_ready/gyan_post_grid.default', gyanPostGrid );
		elementorFrontend.hooks.addAction('frontend/element_ready/gyan_tabs.default', gyanTabs );
		elementorFrontend.hooks.addAction('frontend/element_ready/gyan_multi_image.default', gyanVideoPopup );
		elementorFrontend.hooks.addAction('frontend/element_ready/gyan_video_icon.default', gyanVideoPopup );
		elementorFrontend.hooks.addAction('frontend/element_ready/gyan_tabs_slider.default', gyanTabsSlider );
		elementorFrontend.hooks.addAction('frontend/element_ready/gyan_image_marquee.default', gyanImageMarquee );
		elementorFrontend.hooks.addAction('frontend/element_ready/gyan_services.default', gyanServices );
		elementorFrontend.hooks.addAction('frontend/element_ready/gyan_services_full_text.default', gyanServicesFullText );
	});

})(jQuery);