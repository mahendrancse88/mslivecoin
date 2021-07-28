/* PRIMARY MENU */
(function($) {

	"use strict";

	window.menuResizeTimeoutHandler = false;

    var megaMenuSettings = {};

    var ua = navigator.userAgent.toLowerCase(),
    platform = navigator.platform.toLowerCase(),
    UA = ua.match(/(opera|ie|firefox|chrome|version)[\s\/:]([\w\d\.]+)?.*?(safari|version[\s\/:]([\w\d\.]+)|$)/) || [null, 'unknown', 0],
    mode = UA[1] == 'ie' && document.documentMode;

    window.swmBrowser = {
        name: (UA[1] == 'version') ? UA[3] : UA[1],
        version: UA[2],
        platform: {
            name: ua.match(/ip(?:ad|od|hone)/) ? 'ios' : (ua.match(/(?:webos|android)/) || platform.match(/mac|win|linux/) || ['other'])[0]
            }
    };

    function getOffset(elem) {
		if (elem.getBoundingClientRect && window.swmBrowser.platform.name != 'ios'){
				var bound   = elem.getBoundingClientRect(),
				html        = elem.ownerDocument.documentElement,
				htmlScroll  = getScroll(html),
				elemScrolls = getScrolls(elem),
				isFixed     = (styleString(elem, 'position') == 'fixed');
			return {
				x: parseInt(bound.left) + elemScrolls.x + ((isFixed) ? 0 : htmlScroll.x) - html.clientLeft,
				y: parseInt(bound.top)  + elemScrolls.y + ((isFixed) ? 0 : htmlScroll.y) - html.clientTop
			};
		}

		var element = elem, position = {x: 0, y: 0};
		if (isBody(elem)) { return position; }

		while (element && !isBody(element)){
			position.x += element.offsetLeft;
			position.y += element.offsetTop;

			if (window.swmBrowser.name == 'firefox'){
				if (!borderBox(element)){
					position.x += leftBorder(element);
					position.y += topBorder(element);
				}
				var parent = element.parentNode;
				if (parent && styleString(parent, 'overflow') != 'visible'){
					position.x += leftBorder(parent);
					position.y += topBorder(parent);
				}
			} else if (element != elem && window.swmBrowser.name == 'safari'){
				position.x += leftBorder(element);
				position.y += topBorder(element);
			}

			element = element.offsetParent;
		}
		if (window.swmBrowser.name == 'firefox' && !borderBox(elem)){
			position.x -= leftBorder(elem);
			position.y -= topBorder(elem);
		}
		return position;
	};

	function getScroll(elem){
		return {x: window.pageXOffset || document.documentElement.scrollLeft, y: window.pageYOffset || document.documentElement.scrollTop};
	};

	function getScrolls(elem){
		var element = elem.parentNode, position = {x: 0, y: 0};
		while (element && !isBody(element)){
			position.x += element.scrollLeft;
			position.y += element.scrollTop;
			element    = element.parentNode;
		}
		return position;
	};

	function styleString(element, style){ return $(element).css(style); };
	function styleNumber(element, style){ return parseInt(styleString(element, style)) || 0; };
	function borderBox(element)			{ return styleString(element, '-moz-box-sizing') == 'border-box'; };
	function topBorder(element)			{ return styleNumber(element, 'border-top-width'); };
	function leftBorder(element)		{    return styleNumber(element, 'border-left-width'); };
	function isBody(element)			{    return (/^(?:body|html)$/i).test(element.tagName); };

    function checkMegaMenuSettings() {
		if (window.customMegaMenuSettings == undefined || window.customMegaMenuSettings == null) {
			return false;
		}

		var uri = window.location.pathname; // return path and file name

		window.customMegaMenuSettings.forEach(function(item) {
			for (var i = 0; i < item.urls.length; i++) {
				if (uri.match(item.urls[i])) {
					megaMenuSettings[item.menuItem] = item.data;

				}
			}
		});
	}

	function fixMegaMenuWithSettings() {

		$('.swm-primary-nav > li.megamenu-on').each(function() {
			var m = this.className.match(/(menu-item-(\d+))/);
			if (!m) {return; }

			var itemId = parseInt(m[2]); // take megamenu item id from MAIN LINKS
			if (megaMenuSettings[itemId] == undefined || megaMenuSettings[itemId] == null) {
				return;
			}

			var $megaMenu = $('> ul', this); // Main UL of mega menu which has sub columns with ULs

			if (megaMenuSettings[itemId].style != undefined) {
				$(this).removeClass('megamenu-style-default megamenu-style-grid').addClass('megamenu-style-' + megaMenuSettings[itemId].style);
			}

			var css = {};

			if (megaMenuSettings[itemId].backgroundImage != undefined) 		{css.backgroundImage = megaMenuSettings[itemId].backgroundImage; }
			if (megaMenuSettings[itemId].backgroundPosition != undefined) 	{css.backgroundPosition = megaMenuSettings[itemId].backgroundPosition; }

			$megaMenu.css(css);
		});
	}

	// Megamenu Position on Hover Event
	$('.swm-primary-nav > li.megamenu-on').hover(function() {
		fix_megamenu_position(this);
	});

	$('.swm-primary-nav > li.megamenu-on:hover').each(function() {
		fix_megamenu_position(this);
	});

	// add class "megamenu-item-inited" on all mega menu MAIN links
	$('.swm-primary-nav > li.megamenu-on').each(function() {
		var $megaMenu = $('> ul', this);
		if($megaMenu.length == 0) return;
		$megaMenu.addClass('megamenu-item-inited');
	});

	function fix_megamenu_position(elem) {

		// Item = MegaMenu
		var $megaMenu = $('> ul', elem);
		if($megaMenu.length == 0) return;
		var megaMenuSelf = $megaMenu.get(0);

		$megaMenu.addClass('megamenu-item-inited');

		var default_item_css = {width: 'auto', height: 'auto'};
			default_item_css.left = 0;

		$megaMenu.removeClass('megamenu-fullwidth').css(default_item_css);

		$(' > li', $megaMenu).css({ left: 0, top: 0 }).each(function() {
			var old_width = $(this).data('old-width') || -1;
			if (old_width != -1) {
				$(this).width(old_width).data('old-width', -1);
			}
		});

		// Header Main
		var $headerMain          	= $megaMenu.closest('.header-main'),
			headerMainWidth         = $headerMain.width(),
			headerMain_padding_left	= parseInt($headerMain.css('padding-left')),
			headerMain_padding_right= parseInt($headerMain.css('padding-right')),
			megaMenuParentWidth     = $megaMenu.parent().outerWidth();

		var megamenu_width = $megaMenu.outerWidth();

		//  make megamenu width = header main width
		if (megamenu_width > headerMainWidth) {

			megamenu_width         = headerMainWidth; // header main width
			var new_megamenu_width = headerMainWidth;
			var columns            = $megaMenu.data('megamenu-columns') || 4;
			var column_width       = parseFloat(new_megamenu_width - columns * parseInt($(' > li.menu-item:first', $megaMenu).css('margin-left'))) / columns;
			var column_width_int   = parseInt(column_width);

			$(' > li', $megaMenu).each(function() {
				$(this).data('old-width', $(this).width()).css('width', column_width_int);
			});
			$megaMenu.addClass('megamenu-fullwidth').width(new_megamenu_width - (column_width - column_width_int) * columns);

		}

		if (megamenu_width > megaMenuParentWidth) {
			var left = -(megamenu_width - megaMenuParentWidth) / 2;
		} else {
			var left = 0;
		}

		var headerMain_offset = getOffset($headerMain[0]);
		var megamenu_offset = getOffset(megaMenuSelf);

		if ((megamenu_offset.x - headerMain_offset.x - headerMain_padding_left + left) < 0) {
			left = -(megamenu_offset.x - headerMain_offset.x - headerMain_padding_left);
		}

		if ((megamenu_offset.x + megamenu_width + left) > (headerMain_offset.x + $headerMain.outerWidth() - headerMain_padding_right)) {
			left -= (megamenu_offset.x + megamenu_width + left) - (headerMain_offset.x + $headerMain.outerWidth() - headerMain_padding_right);
		}

		$megaMenu.css('left', left).css('left');

		$megaMenu.addClass('megamenu-inited');
	}

	$(function() {
		$(window).resize(function() {
			if (window.menuResizeTimeoutHandler) {
				clearTimeout(window.menuResizeTimeoutHandler);
			}
		});
	});

})(jQuery);