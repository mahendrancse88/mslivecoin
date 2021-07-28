(function($){

    SwmThemeSettings = {

        init: function() {
            $(".fitVids").fitVids();
            this._retinaRatioCookies();
            this._goTopScroll();
            this._stickyHeader();
            this._smoothScroll();
            this._listWidgets();
            this._sidePanel();
            this._subHeaderTitle();
            this._stickySidebar();
            this._magnificPopup();
            this._main_Navigation();
            this._dropDownMenu();
            this._searchOverlay();
        },

        _retinaRatioCookies: function() {
            var devicePixelRatio = !!window.devicePixelRatio ? window.devicePixelRatio : 1;
            if (!$.cookie("pixel_ratio")) {
                if (devicePixelRatio > 1 && navigator.cookieEnabled === true) {
                    $.cookie("pixel_ratio", devicePixelRatio, {expires : 360});
                    location.reload();
                }
            }
        },

        _goTopScroll: function() {

            var pageScroll = false,
                $pageScrollElement = $('a.swm-go-top-scroll-btn');

            $pageScrollElement.on("click",function(e) {
                $('body,html').animate({ scrollTop: "0" }, 750, 'easeOutExpo' );
                e.preventDefault();
            });

            $(window).scroll(function() {
                pageScroll = true;
            });

            setInterval(function() {
                if( pageScroll ) {
                    pageScroll = false;

                    if( $(window).scrollTop() > 300 ) {
                        $pageScrollElement.fadeIn('fast');
                    } else {
                        $pageScrollElement.fadeOut('fast');
                    }
                }
            }, 250);

        },

        _stickyHeader: function() {
            if( $('body').hasClass('swm-stickyOn') ){

                var getResolutionNumber = $('#swm-main-nav-holder').data('sticky-hide');
                var getResolution = getResolutionNumber ? getResolutionNumber : 768;
                //var getResolution = 768;

                 if( $(window).width() > getResolution ){

                    var header_height = 0,
                        headerHeight = $('#swm-header').innerHeight(),
                        header_height = headerHeight;

                    if ( $('.swm-header-placeholder').length ){
                        var getHeaderHeightDesktop = $('.swm-header-placeholder').data("header-d"),
                            getHeaderHeightTablet = $('.swm-header-placeholder').data("header-t"),
                            getHeaderHeightMobile = $('.swm-header-placeholder').data("header-m"),
                            spaceHolderHeight = getHeaderHeightDesktop;

                        if ( $(window).width() < 980 ) {
                            spaceHolderHeight = getHeaderHeightTablet;
                        } else if ( $(window).width() < 768 ) {
                            spaceHolderHeight = getHeaderHeightMobile;
                        }
                    }

                    if ( $('.swm-topbar-main-container').length ){
                        header_height = $('.swm-topbar-main-container').innerHeight() + header_height;
                    }

                    if ( $('body.subHeaderTop').length ){
                        header_height = $('.swm-sub-header').innerHeight() + header_height;
                    }

                    if( $('.swm-header').hasClass('header_2s') ){
                        header_height = header_height + 67;
                        spaceHolderHeight = 70;
                    }

                    if( $('body').hasClass('swm-l-boxed') ){
                        header_height = header_height + $('body').data("boxed-margin");
                    }

                    var start_y = header_height,
                        window_y = $(window).scrollTop(),
                        wpAdminBarHeight = 0;

                    if ( $('#wpadminbar').length ){
                        wpAdminBarHeight = $('#wpadminbar').innerHeight();
                    }

                    if ( $('.swm-header').hasClass('header_2s') ){
                        // Header 2
                        if ( window_y > start_y ){
                            if ( ! ($('#swm-main-nav-holder').hasClass('sticky-on'))){
                                $('#swm-main-nav-holder')
                                    .addClass('sticky-on');
                                $('#swm-main-nav-holder .swm-infostack-menu')
                                    .css('top',-67)
                                    .animate({'top': wpAdminBarHeight },300);
                                $('.swm-header-placeholder').css('height', spaceHolderHeight);
                            }
                        }
                        else {
                            if ($('#swm-main-nav-holder').hasClass('sticky-on')) {
                                $('#swm-main-nav-holder')
                                    .removeClass('sticky-on');
                                $('#swm-main-nav-holder .swm-infostack-menu')
                                    .css('top', 0);
                                $('.swm-header-placeholder').css('height', 0);
                            }
                        }

                    } else {
                        // Header 1
                        if ( window_y > start_y ){
                            if ( ! ($('#swm-main-nav-holder').hasClass('sticky-on'))){
                                $('#swm-main-nav-holder')
                                    .addClass('sticky-on')
                                    .css('top',-80)
                                    .animate({'top': wpAdminBarHeight },300);
                                $('.swm-header-placeholder').css('height', spaceHolderHeight);
                            }
                        }
                        else {
                            if ($('#swm-main-nav-holder').hasClass('sticky-on')) {
                                $('#swm-main-nav-holder')
                                    .removeClass('sticky-on')
                                    .css('top', 0);
                                $('.swm-header-placeholder').css('height', 0);
                            }
                        }
                    }

                }

            }
        },

        _smoothScroll: function() {
            $('a.smooth-scroll').on('click',function() {
                if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
                    var target = $(this.hash);
                    target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
                    if (target.length) {
                        $('html, body').animate({
                        scrollTop: target.offset().top - 140
                    }, 1000);
                    return false;
                    }
                }

            });
        },

        _listWidgets: function() {
            $(".sidebar,.sidebar .theiaStickySidebar,.footer .swm-f-widget,.swm-sidepanel-wrap").children(".widget_meta,.widget_categories,.widget_pages,.widget_archive,.widget_recent_comments,.widget_recent_entries,.widget_nav_menu,.widget_product_categories,.widget_layered_nav_filters,.archives-link,.widget_rss,.widget_rating_filter,.woocommerce-widget-layered-nav,.widget_gyan_useful_links_wid").addClass("swm-list-widgets");
        },

        _sidePanel: function() {
            var $body = $('body');
            var SWM = {};

            SWM.isMobile = {
                Android: function()    { return navigator.userAgent.match(/Android/i); },
                iOS: function()        { return navigator.userAgent.match(/iPhone|iPad|iPod/i); },
                Windows: function()    { return navigator.userAgent.match(/IEMobile/i); },
                Opera: function()      { return navigator.userAgent.match(/Opera Mini/i); },
                BlackBerry: function() { return navigator.userAgent.match(/BlackBerry/i); },
                any: function()        { return (SWM.isMobile.Android() || SWM.isMobile.BlackBerry() || SWM.isMobile.iOS() || SWM.isMobile.Opera() || SWM.isMobile.Windows()); }
            };

            if ( $('.swm-sidepanel-trigger').length > 0 ) {
                $body.addClass("swm-sidePanelOn");
            }
            $('.swm-sp-icon-box').on('click', function(e) {
                $body.toggleClass("swm-sidepanel-open");
                if ( SWM.isMobile.any() ) {
                    $body.toggleClass("overflow-hidden");
                }
                return false;
            });

            $('.swm-sidePanelOn .swm-sidepanel-body-overlay,.swm-sidepanel-close').on('click', function(e) {
                $body.toggleClass("swm-sidepanel-open");
                return false;
            });

            var $wpAdminBar = $('#wpadminbar');
            if( $wpAdminBar.length > 0 ) {
                var wpAdminBar_height = $wpAdminBar.height();
                $('#swm-sidepanel-container').css('top', wpAdminBar_height);
            }
        },

        _stickySidebar: function() {
            var $showStickySidebar = $('#sidebar.swm-sticky-sidebar');
            if( $showStickySidebar.length > 0 ) {
                $showStickySidebar .theiaStickySidebar({
                    additionalMarginTop: 130
                });
            }
        },

        _subHeaderTitle: function() {
            if ( $('#swm-wrap .header_2_t').length ){
                var headerHeight = ( $(window).width() > 768 ) ? ($('.swm-infostack-header').innerHeight() + 67) : 34;
                $('#swm-sub-header').css('padding-top', headerHeight);
            }
        },

        _magnificPopup: function() {

            $('.swm-popup-img').magnificPopup({
                type: 'image'
            });

            $('.swm-popup-gallery').magnificPopup({
                type: 'image',
                gallery:{
                    enabled:true,
                    tCounter:''
                },
                zoom: {
                    enabled: true,
                    duration: 300,
                    easing: 'ease-in-out'
                }
            });

            $('.popup-youtube, .popup-vimeo, .popup-gmaps,.swm-popup-video').magnificPopup({
                disableOn: 700,
                type: 'iframe',
                mainClass: 'mfp-fade',
                removalDelay: 160,
                preloader: false,
                fixedContentPos: false
            });

            $('.swm-popup-video-autoplay').magnificPopup({
                disableOn: 700,
                type: 'iframe',
                mainClass: 'mfp-fade',
                removalDelay: 160,
                preloader: false,
                fixedContentPos: false,
                iframe: {
                        markup: '<div class="mfp-iframe-scaler">' +
                            '<div class="mfp-close"></div>' +
                            '<iframe class="mfp-iframe" frameborder="0" allow="autoplay"></iframe>' +
                            '</div>',
                        patterns: {
                            youtube: {
                                index: 'youtube.com/',
                                id: 'v=',
                                src: 'https://www.youtube.com/embed/%id%?autoplay=1'
                            }
                        }
                    }
            });

            $('.swm-popup-gallery-alt').magnificPopup(
                {
                    delegate: 'a',
                    type: 'image',
                    tLoading: 'Loading image #%curr%...',
                    mainClass: 'mfp-img-mobile',
                    gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0,1]
                },
                image: {
                    tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                    titleSrc: function(item) {
                        return item.el.attr('title') + '<small>by Marsel Van Oosten</small>';
                    }
                }
            });

        },

        /* mobile dropdown menu */

        _mobileDropDownMenu: function(main_nav,click_button,nav_id,nav_box) {

            var main_nav = $(main_nav),
                nav_box = $(nav_box),
                wpAdminBarHeight = 0;

            if ( $('#wpadminbar').length ){
                wpAdminBarHeight = $('#wpadminbar').innerHeight();
                nav_box.css('margin-top',wpAdminBarHeight +'px');
            }

            $(click_button).on('click', function(){
                var dd_menu = $(main_nav);

                if (dd_menu.hasClass('open')) {
                    dd_menu.removeClass('open');
                } else {
                    dd_menu.addClass('open');
                }

                var mob_nav_overlay = $('#swm-mobi-nav-overlay-bg');

                if (mob_nav_overlay.hasClass('m_toggle')) {
                    mob_nav_overlay.removeClass('m_toggle');
                } else {
                    mob_nav_overlay.addClass('m_toggle');
                }
            });

            $('.swm-mobi-nav-close').on('click', function(){
                    $(main_nav).removeClass('open');
                    $('#swm-mobi-nav-overlay-bg').removeClass('m_toggle');
            });

            $('#swm-mobi-nav-overlay-bg').on('click', function(){
                    $(main_nav).removeClass('open');
                    $('#swm-mobi-nav-overlay-bg').removeClass('m_toggle');
            });

            main_nav.find('li ul').parent().addClass('swm-has-sub-menu');
            main_nav.find(".swm-has-sub-menu").prepend('<span class="swm-mini-menu-arrow"></span>');

            main_nav.find('.swm-mini-menu-arrow').on('click', function() {
                if ($(this).siblings('ul').hasClass('open')) {
                    $(this).siblings('ul').removeClass('open').slideUp();
                }
                else {
                    $(this).siblings('ul').addClass('open').slideDown();
                }
                if ($(this).hasClass('inactive')) {
                    $(this).removeClass('inactive');
                } else {
                    $(this).addClass('inactive');
                }
            });

        },

        _main_Navigation: function() {

            /* create mobile menu */
            $(".swm-primary-nav-wrap > ul").clone().appendTo("#swm-mobi-nav");
            $('#swm-mobi-nav > ul').removeClass('swm-primary-nav');

            // remove mega menu class, styles
            $('#swm-mobi-nav ul#menu-all-pages > li.megamenu-on > ul > li,#swm-mobi-nav li.megamenu-on > ul > li').css('width','auto');
            $('#swm-mobi-nav ul#menu-all-pages > li.megamenu-on > ul ').css({'background-image':'', 'background-position':''});

            $('#swm-mobi-nav').find('.swm-nav_p_meta').remove();

            SwmThemeSettings._mobileDropDownMenu('#swm-mobi-nav','#swm-mobi-nav-icon span.swm-mobi-nav-btn-box>span','#swm-mobi-nav > ul','#swm-mobi-nav');

        },

        _dropDownMenu: function() {

            $('.swm-primary-nav > li').hover(
                function() {
                    var $dropDowns = $('ul', this);
                    $dropDowns.removeClass('invert');

                    if (!$(this).hasClass('megamenu-on')) {
                        $dropDowns.css({top: ''});
                    }

                    if ($(this).hasClass('megamenu-on') ) {
                        return;
                    }

                    var dropDownCssTransformValue = 0;

                    if ($('>ul', this).css('transform')) {
                        dropDownCssTransformValue = parseInt($('>ul', this).css('transform').split(',')[5]);
                    }
                    if (isNaN(dropDownCssTransformValue)) {
                        dropDownCssTransformValue = 0;
                    }

                    var windowScroll        = $(window).scrollTop(),
                        siteHeaderOffset    = $('#swm-header').offset(),
                        siteHeaderOffsetTop = siteHeaderOffset.top - windowScroll,
                        siteHeaderHeight    = $('#swm-header').outerHeight();

                    $dropDowns.each(function() {

                        var $dropDown = $(this);
                        var self = this;

                        var itemOffset          = $dropDown.offset(),
                            dropDownTopDistance = itemOffset.top - windowScroll,
                            itemOffsetLeft      = itemOffset.left;

                        if(itemOffsetLeft - $('#swm-page').offset().left + $dropDown.outerWidth() > $('#swm-page').width()) {
                            $dropDown.addClass('invert');
                        }

                    });
                },
                function() {}
            );

        },

        _searchOverlay: function() {
            $('.swm_searchbox_close').slideUp();
            var open = false;

            $('.swm-header-search span').on('click', function() {
                if (open == false) {
                    $('.swm_searchbox_holder, .swm_searchbox_close').slideDown();
                    $('nav ul li, .btn-open').slideUp();
                    open = true;
                } else {
                    $('.swm_searchbox_holder, .swm_searchbox_close').slideUp();
                    $('nav ul li, .btn-open').slideDown();
                    open = false;
                }
            });
            $('.swm_searchbox_holder').on('mouseup', function() {
                $('.swm_searchbox_holder, .swm_searchbox_close').slideUp();
                $('nav ul li, .btn-open').slideDown();
                open = false;
            });
            $('.swm_overlay_search_box').on('mouseup', function() {
                return false;
            });
        },

        // Global masonry
        _universalGridIsotope: function() {
           if ($("#swm-item-entries").hasClass('isotope')) {
                $('.swm-universal-grid-sort').imagesLoaded( function() {
                    $('.swm-universal-grid-sort').isotope({
                        itemSelector: '.swm-universal-grid'
                    });
                });
            }
        },


    };  // SwmThemeSettings

    $(document).ready(function() {
        SwmThemeSettings.init();
    });

    $(window).scroll(function(){
        SwmThemeSettings._stickyHeader();
    });

    /* Window load functions =================== */

    var $window = $(window);

    $(window).on('load',(function () {

        if ( $('.swm-site-loader').length ){
            $(".swm-site-loader").slideUp();
        }

        SwmThemeSettings._universalGridIsotope();

        $window.resize(function () {
            SwmThemeSettings._universalGridIsotope();
            SwmThemeSettings._subHeaderTitle();
            SwmThemeSettings._stickyHeader();
        });
        window.addEventListener("orientationchange", function() {
            SwmThemeSettings._universalGridIsotope();
        });

        $('iframe').css('max-width','100%').css('width','100%');

    }));

})(jQuery);