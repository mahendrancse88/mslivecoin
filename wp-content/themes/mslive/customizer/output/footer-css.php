<?php if ( swm_customizer_metabox_onoff('swm_widget_footer_on','swm_meta_widget_footer_on','on','default') == 'on' || swm_customizer_metabox_onoff('swm_contact_footer_on','swm_meta_contact_footer_on','off','default') == 'on' || swm_customizer_metabox_onoff('swm_small_footer_on','swm_meta_small_footer_on','on','default') == 'on' ) { ?>

	.footer {
		<?php if ( $swm_widget_footer_bg_img = swm_get_option( 'swm_widget_footer_bg_img', '' ) ) : ?>
			background-image:url("<?php echo esc_url($swm_widget_footer_bg_img); ?>");
			<?php echo swm_background_style_css(swm_get_option( 'swm_widget_footer_bg_style', 'cover' )); ?>
		<?php endif; ?>

		<?php if ( $swm_widget_footer_bg_color ) { ?>
			background-color:<?php echo sanitize_hex_color($swm_widget_footer_bg_color); ?>;
		<?php } ?>

		<?php if ( $swm_widget_footer_text_color ) { ?>
			color:<?php echo sanitize_hex_color($swm_widget_footer_text_color); ?>;
		<?php } ?>
	}

	.footer,.footer p {
		font-size:<?php echo intval(swm_get_option( 'swm_widget_footer_text_size', 15 )); ?>px;
		line-height:<?php echo intval(swm_get_option( 'swm_widget_footer_line_height', 30 )); ?>px;
	}

	<?php if ( $swm_widget_footer_text_color ) { ?>
		.footer ul li a,
		.footer .tagcloud a,
		.footer .wp-caption,
		.footer button.button,
		.footer .widget_product_search #swm_product_search_form button.swm-search-button,
		.footer .widget_search .swm-search-form button.swm-search-button,
		.footer .gyan-posts-slider-widget .owl-next,
		.footer .gyan-posts-slider-widget .owl-prev { color:<?php echo sanitize_hex_color($swm_widget_footer_text_color); ?>; }
	<?php } ?>

	<?php if ( $swm_widget_footer_links_color ) { ?>
		.footer a { color:<?php echo sanitize_hex_color($swm_widget_footer_links_color); ?>; }
	<?php } ?>

	<?php if ( $swm_widget_footer_links_hover_color ) { ?>
		.footer a:hover,
		.footer #wp-calendar tbody td a,
		.footer ul.menu > li ul li.current-menu-item > a,
		.footer .widget-nav-menu ul li.current-menu-item > a,
		.footer .widget_categories ul li.current-cat > a,
		.footer .widget.woocommerce ul li.current-cat a,
		.footer .widget ul li a:hover,
		.footer .recent_posts_slider_title p a:hover,
		.footer .recent_posts_slider_title span a:hover,
		.footer a.twitter_time:hover,
		.footer .swm-list-widgets ul li:hover:before,
		.footer .gyan-posts-slider-widget .owl-next:hover,
		.footer .gyan-posts-slider-widget .owl-prev:hover { color:<?php echo sanitize_hex_color($swm_widget_footer_links_hover_color); ?>; }

		.footer .gyan-posts-slider-widget .owl-dot.active { border-color:<?php echo sanitize_hex_color($swm_widget_footer_links_hover_color); ?>; }
	<?php } ?>

	<?php if ( $swm_widget_footer_text_color ) { ?>
		.footer .widget_search .swm-search-form input[type="text"] { color:<?php echo sanitize_hex_color($swm_widget_footer_text_color); ?>; text-shadow:none; }
		.footer .widget_search .swm-search-form input[type="text"]::-webkit-input-placeholder { color:<?php echo sanitize_hex_color($swm_widget_footer_text_color); ?>; }
		.footer .widget_search .swm-search-form input[type="text"]::-moz-placeholder { color:<?php echo sanitize_hex_color($swm_widget_footer_text_color); ?>; }
		.footer .widget_search .swm-search-form input[type="text"]::-ms-placeholder { color:<?php echo sanitize_hex_color($swm_widget_footer_text_color); ?>; }
		.footer .widget_search .swm-search-form input[type="text"]::placeholder { color:<?php echo sanitize_hex_color($swm_widget_footer_text_color); ?>; }
	<?php } ?>

	<?php if ( $swm_widget_footer_border_color ) { ?>
		.footer #widget_search_form #searchform #s,
		.footer #widget_search_form #searchform input.button,
		.footer .tagcloud a,
		.footer #swm_product_search_form button.swm-search-button i,
		.footer .gyan-posts-slider-widget .owl-dot { border-color: <?php echo sanitize_hex_color($swm_widget_footer_border_color);?>; }
	<?php } ?>

	<?php if ( $swm_widget_footer_text_color || $swm_widget_footer_border_color ) : ?>
		.footer .input-text,
		.footer input[type="text"],
		.footer input[type="password"],
		.footer input[type="email"],
		.footer input[type="number"],
		.footer input[type="url"],
		.footer input[type="tel"],
		.footer input[type="search"],
		.footer textarea,
		.footer select,
		.footer #wp-calendar thead th,
		.footer #wp-calendar tbody td,
		.footer #wp-calendar tbody td:hover,
		.footer input[type="text"]:focus,
		.footer input[type="password"]:focus,
		.footer input[type="email"]:focus,
		.footer input[type="number"]:focus,
		.footer input[type="url"]:focus,
		.footer input[type="tel"]:focus,
		.footer input[type="search"]:focus,
		.footer textarea:focus,
		.footer #widget_search_form #searchform #s:focus {

			<?php if ( $swm_widget_footer_text_color ) { ?>
				color:<?php echo sanitize_hex_color($swm_widget_footer_text_color); ?>;
			<?php } ?>
			<?php if ( $swm_widget_footer_border_color ) { ?>
			border-color: <?php echo sanitize_hex_color($swm_widget_footer_border_color);?>;
			<?php } ?>
		}

	<?php endif; ?>

	.footer .swm-footer-widget h3 {
		font-size: <?php echo intval(swm_get_option( 'swm_widget_footer_title_size', 20 )); ?>px;
		color:<?php echo sanitize_hex_color(swm_get_option( 'swm_widget_footer_title_color', '#ffffff' )); ?>;
		letter-spacing: <?php echo intval(swm_get_option( 'swm_widget_footer_title_letter_space', 0 )); ?>px;
		text-transform: <?php echo swm_get_option( 'swm_widget_footer_title_transform', 'none' ); ?>;
		line-height:<?php echo intval(swm_get_option( 'swm_widget_footer_title_lineheight', 30 )); ?>px;
	}

	<?php if ( $swm_widget_footer_space = swm_get_option( 'swm_widget_footer_space' ) ) { ?>
		.footer .swm-footer-widget,
		.footer .swm-fb-subscribe-wid { margin-bottom:<?php echo intval($swm_widget_footer_space);?>px; }
	<?php } ?>

	<?php if ( $swm_widget_footer_text_color ) { ?>
		.footer .widget_meta ul li:before,
		.footer .widget_categories ul li:before,
		.footer .widget_pages ul li:before,
		.footer .widget_archive ul li:before,
		.footer .widget_recent_comments ul li:before,
		.footer .widget_recent_entries ul li:before,
		.footer .widget-nav-menu ul li:before,
		.footer .widget_product_categories ul li:before,
		.footer .archives-link ul li:before,
		.footer .widget_rss ul li:before,
		.footer .widget-nav-menu ul li.current-menu-item:before,
		.footer .widget_categories ul li.current-cat:before { color:<?php echo sanitize_hex_color($swm_widget_footer_text_color); ?> }
	<?php } ?>

	<?php if ( $swm_widget_footer_bg_color_two ) { ?>
		.footer #wp-calendar thead th,
		.footer #wp-calendar tbody td,
		.footer .tagcloud a:hover,
		.footer ul li.cat-item small,
		.footer .wp-caption,
		.footer a.button,
		.footer a.button:hover,
		.footer .gyan-recent-posts-large-title,
		.footer button.button { background:<?php echo sanitize_hex_color($swm_widget_footer_bg_color_two); ?> }

		.footer select {
			background-color:<?php echo sanitize_hex_color($swm_widget_footer_bg_color_two); ?>
		}
	<?php } ?>

	<?php if ( $swm_widget_footer_rp_links_color ) { ?>
		.footer .gyan-recent-posts-tiny ul li a { color:<?php echo sanitize_hex_color($swm_widget_footer_rp_links_color); ?>; }
	<?php } ?>

	<?php if ( swm_customizer_metabox_onoff('swm_small_footer_on','swm_meta_small_footer_on','on','default') == 'on' ) : ?>

		<?php if ( swm_customizer_metabox_onoff('swm_contact_footer_on','swm_meta_contact_footer_on','off','default') != 'on' ) { ?>
	   	 	.footer .swm-small-footer { border-top:1px solid <?php echo sanitize_hex_color($swm_small_footer_top_border_color); ?>;  }
	    <?php } ?>

	    <?php
		$swm_small_footer_text_size  = swm_get_option( 'swm_small_footer_text_size' );
		$swm_small_footer_text_color = swm_get_option( 'swm_small_footer_text_color' );

	    if ( $swm_small_footer_text_size || $swm_small_footer_text_color ) : ?>
	    	.footer .swm-small-footer {
	    		<?php if ( $swm_small_footer_text_size ) { ?>
	    			font-size: <?php echo intval($swm_small_footer_text_size); ?>px;
	    		<?php } ?>
	    		<?php if ( $swm_small_footer_text_color ) { ?>
	    			color:<?php echo sanitize_hex_color($swm_small_footer_text_color); ?>;
	    		<?php } ?>
	    	}
	    <?php endif; ?>


	    <?php if ( $swm_small_footer_link_color ) { ?>
			.footer .swm-small-footer a { color:<?php echo sanitize_hex_color($swm_small_footer_link_color); ?>;  }
		<?php } ?>

		<?php if ( $swm_small_footer_link_h_color ) { ?>
			.footer .swm-small-footer a:hover { color:<?php echo sanitize_hex_color($swm_small_footer_link_h_color); ?>;  }
		<?php } ?>

	<?php endif; ?>

	<?php if ( swm_customizer_metabox_onoff('swm_contact_footer_on','swm_meta_contact_footer_on','off','default') == 'on' ) : ?>

		<?php if ( $swm_cf_text_color ) { ?>
			.swm_contact_footer, .swm_contact_footer a { color:<?php echo sanitize_hex_color($swm_cf_text_color); ?>; }
		<?php } ?>

		<?php if ( $swm_cf_bg_1 ) { ?>
			.swm_contact_footer_holder { background:<?php echo sanitize_hex_color($swm_cf_bg_1); ?>; }
		<?php } ?>

		<?php if ( $swm_cf_bg_2 ) { ?>
			.swm-cf-m-column { background:<?php echo sanitize_hex_color($swm_cf_bg_2); ?>; }
		<?php } ?>

		.swm_contact_footer:before { border-color:<?php echo sanitize_hex_color($swm_small_footer_top_border_color); ?>;}

	<?php endif; ?>

	<?php if ( swm_customizer_metabox_onoff('swm_contact_footer_on','swm_meta_contact_footer_on','off','default') == 'off' && swm_customizer_metabox_onoff('swm_small_footer_on','swm_meta_small_footer_on','on','default') == 'off' ) { ?>
		.footer .swm-footer-widget,
		.footer .swm-fb-subscribe-wid { margin-bottom:61px; }
	<?php } ?>

	<?php if ( swm_customizer_metabox_onoff('swm_widget_footer_on','swm_meta_widget_footer_on','on','default') == 'on' && swm_customizer_metabox_onoff('swm_contact_footer_on','swm_meta_contact_footer_on','off','default') == 'on' && swm_customizer_metabox_onoff('swm_small_footer_on','swm_meta_small_footer_on','on','default') == 'off' ) { ?>
		.footer { padding-bottom:70px; }
	<?php } ?>

<?php } ?>