/* Top Bar -------------------------------------------- */
<?php
if ( swm_customizer_metabox_onoff('swm_topbar_on','swm_meta_topbar_on','off','default') == 'on' ) : ?>

	<?php if ( $swm_topbar_font_size || $swm_topbar_text ) : ?>

		.swm-topbar, .swm-topbar a {
			<?php if ( $swm_topbar_font_size ) { ?>
				font-size: <?php echo intval($swm_topbar_font_size); ?>px;
			<?php } ?>

			<?php if ( $swm_topbar_text ) { ?>
				color:<?php echo sanitize_hex_color($swm_topbar_text); ?>;
			<?php } ?>
		}
	<?php endif; ?>

	<?php if ( $swm_topbar_hover_text = swm_get_option( 'swm_topbar_hover_text' ) ) { ?>
		.swm-topbar a:hover { color:<?php echo sanitize_hex_color($swm_topbar_hover_text); ?>; }
	<?php } ?>
	<?php if ( $swm_topbar_left_text_color = swm_get_option( 'swm_topbar_left_text_color' ) ) { ?>
		.swm_tb_left a { color:<?php echo sanitize_hex_color($swm_topbar_left_text_color); ?>; }
	<?php } ?>
	<?php if ( $swm_topbar_left_text_hover_color = swm_get_option( 'swm_topbar_left_text_hover_color' ) ) { ?>
		.swm_tb_left a:hover { color:<?php echo sanitize_hex_color($swm_topbar_left_text_hover_color); ?>; }
	<?php } ?>
	<?php if ( $swm_topbar_sm_color = swm_get_option( 'swm_topbar_sm_color' ) ) { ?>
		ul.swm-topbar-socials li a { color:<?php echo sanitize_hex_color($swm_topbar_sm_color); ?>; }
	<?php } ?>

	<?php if ( $swm_topbar_sm_h_color = swm_get_option( 'swm_topbar_sm_h_color' ) ) { ?>
		ul.swm-topbar-socials li a:hover { color:<?php echo sanitize_hex_color($swm_topbar_sm_h_color); ?>; }
	<?php } ?>

	<?php if ( $swm_topbar_icon_col = swm_get_option( 'swm_topbar_icon_col' ) ) { ?>
		.swm-topbar-content ul li span i { color:<?php echo sanitize_hex_color($swm_topbar_icon_col); ?>; }
	<?php } ?>

	<?php if ( $swm_topbar_bg_solid_color = swm_get_option( 'swm_topbar_bg_solid_color' ) ) { ?>
		.swm-topbar { background:<?php echo sanitize_hex_color($swm_topbar_bg_solid_color); ?>; }
	<?php } ?>

	<?php if ( swm_get_option( 'swm_topbar_left_style_on','on' ) == 'on' ) { ?>

		<?php if ( $swm_topbar_left_bg_color = swm_get_option( 'swm_topbar_left_bg_color' ) ) { ?>
			.swm-topbar .swm-container:before,
			.swm-topbar-content .left:before,
			.swm-topbar-content .left:after { background:<?php echo sanitize_hex_color($swm_topbar_left_bg_color); ?>; }
		<?php } ?>

		<?php if ( $swm_topbar_left_icon_color = swm_get_option( 'swm_topbar_left_icon_color' ) ) { ?>
			.swm-topbar .left i.fas { color:<?php echo sanitize_hex_color($swm_topbar_left_icon_color); ?>; }
		<?php } ?>

		<?php if ( $swm_topbar_text ) { ?>
			ul.swm_tb_right:before { background:<?php echo sanitize_hex_color($swm_topbar_text); ?>; }
		<?php } ?>

	<?php } ?>

	<?php
endif; /* End Top Bar */ ?>

/* Top Header -------------------------------------------- */

<?php
if ( swm_customizer_metabox_onoff('swm_main_header_on','swm_meta_main_header_on','on','default') == 'on' ) : ?>

	<?php if ( $swm_header_style == 'header_1_t' || $swm_header_style == 'header_2_t' ) { ?>

		<?php if ( $swm_header_bg_opacity>0 ) { ?>
			.swm-header-main-container { background:<?php echo swm_hex2rgba($swm_main_header_bg_color,$swm_header_bg_opacity); ?>; }
		<?php } else { ?>
			.swm-header-main-container { background:transparent; }
		<?php } ?>

	<?php } else { ?>
		.swm-header-main-container { background:<?php echo sanitize_hex_color($swm_main_header_bg_color); ?>; }
	<?php } ?>

	@media only screen and (max-width: 767px) {
		body.transparentHeader .swm-header { background:<?php echo sanitize_hex_color($swm_main_header_bg_color); ?>; }
 	}

	.swm-logo { width:<?php echo intval($swm_logo_standard_width); ?>px; }

	@media only screen and (min-width: 768px) {

		.header-main,
		.swm-header-logo-section,
		.swm-header-search,
		.swm-header-button-wrap,
		#swm-mobi-nav-btn,
		#swm-sidepanel-trigger,
		.swm-sidepanel-trigger-wrap,
		.swm_header_contact_info { height:<?php echo intval($swm_main_header_height_d); ?>px; }

	}

	<?php if ( $swm_header_style == 'header_1' || $swm_header_style == 'header_1_t' ) { ?>

		@media only screen and (max-width: 767px) {
			.header-main,
			.swm-header-logo-section,
			.swm-header-button-wrap,
			.swm-header-search,
			#swm-mobi-nav-btn,
			#swm-sidepanel-trigger,
			.swm-sidepanel-trigger-wrap { height:<?php echo intval($swm_main_header_height_t); ?>px; }
		}

		@media only screen and (max-width: 480px) {
			.header-main,
			.swm-header-logo-section,
			.swm-header-button-wrap,
			.swm-header-search,
			#swm-mobi-nav-btn,
			#swm-sidepanel-trigger,
			.swm-sidepanel-trigger-wrap { height:<?php echo intval($swm_main_header_height_m); ?>px; }
		}

	<?php } ?>

	<?php if ( swm_customizer_metabox_onoff('swm_site_layout','swm_meta_site_layout','full-width','default') == 'boxed' ) { ?>

			@media (min-width:300px) {
				.swm-l-boxed .header_2s #swm-main-nav-holder.sticky-on .swm-infostack-menu {max-width: calc(100% - <?php echo intval($swm_boxed_layout_padding_left_right) * 2; ?>px); }
			}

			@media (min-width:576px) {
				.swm-l-boxed .header_2s #swm-main-nav-holder.sticky-on .swm-infostack-menu {max-width: calc(100% - <?php echo intval($swm_boxed_layout_padding_left_right) * 2; ?>px); }
			}

			@media (min-width:768px) {
				.swm-l-boxed .header_2s #swm-main-nav-holder.sticky-on .swm-infostack-menu {max-width: calc(100% - <?php echo intval($swm_boxed_layout_padding_left_right) * 2; ?>px); }
			}

			@media (max-width:992px) {
				.swm-l-boxed .header_2s #swm-main-nav-holder.sticky-on .swm-infostack-menu {max-width: calc(100% - <?php echo intval($swm_boxed_layout_padding_left_right) * 2; ?>px); }
				.swm-l-boxed .header_2s .swm-container.header-main {padding: 0 <?php echo intval($swm_boxed_layout_padding_left_right); ?>px; }
			}

			@media (min-width:<?php echo intval($swm_layout_max_width); ?>px) {
				.swm-l-boxed .header_2s #swm-main-nav-holder.sticky-on .swm-infostack-menu {max-width: calc(<?php echo intval($swm_layout_max_width); ?>px - <?php echo intval($swm_boxed_layout_padding_left_right) * 2; ?>px); }

				.swm-l-boxed .header_2_alt .swm-infostack-menu:after {
					left: -<?php echo intval($swm_boxed_layout_padding_left_right); ?>px;
					width: <?php echo intval($swm_boxed_layout_padding_left_right); ?>px;
				}

				.swm-l-boxed .header_2_alt .swm-infostack-menu:before {
					right: -<?php echo intval($swm_boxed_layout_padding_left_right); ?>px;
					left:auto;
					width: <?php echo intval($swm_boxed_layout_padding_left_right); ?>px;
				}

				.swm-l-boxed .header_2_alt .swm-header-button-wrap::before {
					right: -<?php echo intval($swm_boxed_layout_padding_left_right); ?>px;
					width: <?php echo intval($swm_boxed_layout_padding_left_right); ?>px;
				}

			}


	<?php }

	$swm_layout_max_final_width = intval($swm_layout_max_width) - (intval($swm_container_padding) * 2) ;
	?>

	@media (min-width:<?php echo intval($swm_layout_max_width); ?>px) {
		body:not(.swm-l-boxed) .header_2_alt #swm-main-nav-holder.sticky-on .swm-infostack-menu,
		body:not(.swm-l-boxed) .header_2 #swm-main-nav-holder.sticky-on .swm-infostack-menu,
		body:not(.swm-l-boxed) .header_2_t #swm-main-nav-holder.sticky-on .swm-infostack-menu {max-width:<?php echo $swm_layout_max_final_width; ?>px; }

	}
	@media (max-width:<?php echo intval($swm_layout_max_width) - 1; ?>px) {
		body:not(.swm-l-boxed) .header_2_alt #swm-main-nav-holder.sticky-on .swm-infostack-menu,
		body:not(.swm-l-boxed) .header_2 #swm-main-nav-holder.sticky-on .swm-infostack-menu,
		body:not(.swm-l-boxed) .header_2_t #swm-main-nav-holder.sticky-on .swm-infostack-menu {max-width:calc(100% - <?php echo intval($swm_container_padding) * 2; ?>px); }
	}

	/* Header Button -------------------------------------------- */

		<?php if ( $swm_header_button_on == 'on' ) { ?>

			.swm-header-button a {
				font-size:<?php echo intval(swm_get_option( 'swm_header_button_font_size', 15 )); ?>px;
				background:<?php echo sanitize_hex_color($swm_header_button_bg); ?>;
				color:<?php echo sanitize_hex_color(swm_get_option( 'swm_header_button_text_color', '#ffffff' )); ?>;
				border-color:<?php echo sanitize_hex_color(swm_get_option( 'swm_header_button_border_color', '#d83030' )); ?>;
				border-width:<?php echo intval(swm_get_option( 'swm_header_button_width',0 )); ?>px;
				border-radius:<?php echo intval(swm_get_option( 'swm_header_button_border_radius',3 )); ?>px;
				border-style:<?php echo swm_get_option( 'swm_header_button_border_style','solid' ); ?>;
			}

			.swm-header-button a:hover {
				background:<?php echo sanitize_hex_color(swm_get_option( 'swm_header_button_h_bg', '#252628' )); ?>;
				color:<?php echo sanitize_hex_color(swm_get_option( 'swm_header_button_text_h_color', '#ffffff' )); ?>;
				border-color:<?php echo sanitize_hex_color(swm_get_option( 'swm_header_button_border_h_color', '#252628' )); ?>;
			}

			.header_2_alt  .swm-header-button-wrap:before { background:<?php echo sanitize_hex_color($swm_header_button_bg); ?>; }

		<?php } ?>

	/* Main Menu -------------------------------------------- */

	<?php if ( swm_get_option( 'swm_dd_menu_pr_font_family_on','on' ) == 'on' ) : ?> .swm-primary-nav>li.pm-dropdown ul li a span,<?php endif;?>
	ul.swm-primary-nav>li>a {

		<?php
		$swm_nav_font_weight       = swm_get_option( 'swm_nav_font_weight', '600' );
		$swm_check_nav_font_italic = swm_check_google_font_italic( $swm_nav_font_weight );
		?>

		font-family:<?php echo swm_get_option( 'swm_nav_font_family', 'Roboto' ); ?>;
		font-style: <?php echo $swm_check_nav_font_italic ? 'italic' : 'normal'; ?>;
		font-weight:<?php echo swm_google_fonts_final_weight( $swm_nav_font_weight ); ?>; 	}

	ul.swm-primary-nav>li { line-height:<?php echo intval($swm_main_header_height_d); ?>px; }

	ul.swm-primary-nav>li>a {
		<?php if ( $swm_pr_menu_links_text_color ) { ?>
			color:<?php echo sanitize_hex_color($swm_pr_menu_links_text_color); ?>;
		<?php } ?>
		font-size:<?php echo intval($swm_pr_menu_font_size); ?>px;
		margin:0 <?php echo intval($swm_pr_menu_links_space); ?>px;
		text-transform: <?php echo esc_attr(swm_get_option( 'swm_pr_menu_links_text_transform', 'uppercase' )); ?>;
	}

	<?php if ( $swm_pr_menu_links_text_hover_color ) { ?>

		ul.swm-primary-nav>li>a:hover,
		ul.swm-primary-nav>li.swm-m-active>a { color:<?php echo sanitize_hex_color($swm_pr_menu_links_text_hover_color); ?>; }

		.swm-sp-icon-box:hover .swm-sp-icon-inner,
		.swm-sp-icon-box:hover .swm-sp-icon-inner:after,
		.swm-sp-icon-box:hover .swm-sp-icon-inner:before,
		.s_two .swm-sp-icon-box:hover .swm-sp-icon-inner span { background:<?php echo sanitize_hex_color($swm_pr_menu_links_text_hover_color); ?>; }

		.swm-sp-icon-box:hover,
		.swm-header-search span:hover,
		span.swm-mobi-nav-btn-box>span:hover {  color:<?php echo sanitize_hex_color($swm_pr_menu_links_text_hover_color); ?>; border-color:<?php echo sanitize_hex_color($swm_pr_menu_links_text_hover_color); ?>; }

		span.swm-mobi-nav-btn-box>span:hover:before,
		span.swm-mobi-nav-btn-box>span:hover:after,
		span.swm-mobi-nav-btn-box>span:hover>span { background:<?php echo sanitize_hex_color($swm_pr_menu_links_text_hover_color); ?>; }

	<?php } ?>

	<?php if ( $swm_pr_menu_active_border_color && $swm_pr_menu_active_border_on != 'off' ) { ?>
		.swm-primary-nav>li>a>span:before,
		.swm-primary-nav>li.swm-m-active>a>span:before,
		.swm-primary-nav>li>a:before,
		.swm-primary-nav>li.swm-m-active>a:before { background:<?php echo sanitize_hex_color($swm_pr_menu_active_border_color); ?>;}
	<?php } ?>

	<?php if ( $swm_pr_menu_active_border_on == 'off' ) { ?>
		.swm-primary-nav>li:hover>a>span:before,
		.swm-primary-nav>li.swm-m-active>a>span:before { display:none; }
	<?php } ?>

	<?php if ( swm_get_option( 'swm_pr_menu_dropdown_indicator','off' ) == 'on' ) { ?>
		.swm-primary-nav>li.pm-dropdown>a>span:after { display:inline-block; }
	<?php } ?>

	<?php if ( $swm_pr_menu_links_text_color ) { ?>
		.swm-header-search { color:<?php echo sanitize_hex_color($swm_pr_menu_links_text_color); ?>; }

		#swm-mobi-nav-icon span.swm-mobi-nav-btn-box>span { border-color:<?php echo sanitize_hex_color($swm_pr_menu_links_text_color); ?>;}

		span.swm-mobi-nav-btn-box>span:before,
		span.swm-mobi-nav-btn-box>span:after,
		span.swm-mobi-nav-btn-box>span>span { background-color: <?php echo sanitize_hex_color($swm_pr_menu_links_text_color); ?>; }
	<?php } ?>

	<?php if ( $swm_pr_menu_bg || $swm_pr_menu_bg_opacity ) {  ?>
		.swm-infostack-menu,
		.header_2_alt .swm-infostack-menu:before,
		.swm-infostack-menu:after { background:<?php echo swm_hex2rgba($swm_pr_menu_bg,$swm_pr_menu_bg_opacity); ?>;  }
	<?php } ?>

	<?php if ( $swm_pr_menu_divider_on == 'on') { ?>
		.swm-primary-nav>li:after { background:<?php echo sanitize_hex_color(swm_get_option( 'swm_pr_menu_divider_color', '#e6e6e6' )); ?>; display:block;  }
	<?php } ?>

	/* Dropdown/Mega menu ------------------------------------ */

	.swm-primary-nav>li.pm-dropdown ul,
	.swm-primary-nav>li.megamenu-on ul>li>ul>li { font-size: <?php echo intval($swm_dd_menu_font_size); ?>px; text-transform:<?php echo esc_attr($swm_dd_menu_title_transform); ?>;  }

	<?php if ( $swm_dd_menu_font_color = swm_get_option( 'swm_dd_menu_font_color') ) { ?>
		.swm-primary-nav>li li a,
		#swm-mobi-nav ul li a,
		#swm-mobi-nav .swm-mini-menu-arrow { color:<?php echo sanitize_hex_color($swm_dd_menu_font_color); ?> }
	<?php } ?>

	<?php if ( $swm_megamenu_title_lineheight = swm_get_option( 'swm_megamenu_title_lineheight') ) { ?>
		.swm-primary-nav>li.megamenu-on>ul>li { line-height:<?php echo intval($swm_megamenu_title_lineheight); ?>px; }
	<?php } ?>

	<?php if ( $swm_d_menu_font_hov_color = swm_get_option( 'swm_d_menu_font_hov_color') ) { ?>
		.swm-primary-nav>li.pm-dropdown ul>li:hover>a,
		.swm-primary-nav>li.megamenu-on ul a:hover,
		.swm-primary-nav>li.megamenu-on ul>li>ul>li:hover>a { color:<?php echo sanitize_hex_color($swm_d_menu_font_hov_color); ?>; }
	<?php } ?>

	<?php if ( $swm_dd_bg_color = swm_get_option( 'swm_dd_bg_color') ) { ?>
		.swm-primary-nav>li.pm-dropdown ul,
		.swm-primary-nav>li.megamenu-on>ul { background-color:<?php echo sanitize_hex_color($swm_dd_bg_color); ?>; }
	<?php } ?>

	.swm-primary-nav>li.megamenu-on>ul>li span.megamenu-column-header a { font-size: <?php echo intval(swm_get_option( 'swm_megamenu_title_font_size', 20 )); ?>px; color:<?php echo sanitize_hex_color(swm_get_option( 'swm_megamenu_title_font_color', '#032e42' )); ?>; }
	.swm-primary-nav>li.megamenu-on>ul>li>ul li a span { padding-top:<?php echo intval($swm_megamenu_links_space); ?>px; padding-bottom:<?php echo intval($swm_megamenu_links_space); ?>px; line-height:<?php echo intval(swm_get_option( 'swm_megamenu_text_lineheight', 23 )); ?>px;}

	.swm-primary-nav>li.pm-dropdown ul li a { padding-top:<?php echo intval($swm_dd_menu_links_space); ?>px; padding-bottom:<?php echo intval($swm_dd_menu_links_space); ?>px; }

	.swm-primary-nav>li.pm-dropdown ul { width:<?php echo intval(swm_get_option( 'swm_dd_menu_width', 236 )); ?>px; left:<?php echo intval($swm_pr_menu_links_space); ?>px; }

	<?php if ( swm_get_option( 'swm_dd_menu_box_shadow','on' ) == 'off') { ?>
		.swm-primary-nav>li.pm-dropdown ul,
		.swm-primary-nav>li.megamenu-on>ul { box-shadow:none; }
	<?php } ?>
	<?php if ( swm_get_option( 'swm_dd_menu_submenu_indicator','off' )== 'off') { ?>
		.swm-primary-nav>li.pm-dropdown li.menu-item-has-children>a:after { display:none; }
	<?php } ?>

	<?php if ( swm_get_option( 'swm_dropdown_bullet_arrow','on' ) == 'off') { ?>
		.swm-primary-nav>li.megamenu-on>ul>li>ul>li>a>span:before { display:none; }
		.swm-primary-nav>li.megamenu-on>ul>li>ul li a span { padding-left:20px; }
	<?php } ?>

	/* Mobie menu ------------------------------------ */

	#swm-mobi-nav ul li { font-size: <?php echo intval($swm_dd_menu_font_size); ?>px; text-transform:<?php echo esc_attr($swm_dd_menu_title_transform); ?>; }

	<?php if ( $swm_mobile_menu_min_resolution = swm_get_option( 'swm_mobile_menu_min_resolution', 979 ) ) { ?>
		@media only screen and (max-width: <?php echo intval($swm_mobile_menu_min_resolution); ?>px) {
			#swm-mobi-nav-icon { display:block; }
			.swm-primary-nav-wrap { display:none; }
			.swm-header-menu-section-wrap {margin-bottom:0;}

			<?php if ( is_rtl() ) { ?>
				ul.swm-primary-nav>li>a>span>i { width:auto; display:inline-block; height:auto; margin-right:0; margin-left:8px; }
				.swm-main-nav { float:left; }
			<?php } else { ?>
				ul.swm-primary-nav>li>a>span>i { width:auto; display:inline-block; height:auto; margin-right:8px; }
				.swm-main-nav { float:right; }
			<?php } ?>

		}
	<?php } ?>

	/* Sticky menu ------------------------------------ */

	<?php if ( swm_get_option( 'swm_sticky_menu_on','off' ) == 'on' ) : ?>

		<?php if ( $swm_sticky_menu_font_size || $swm_sticky_pr_menu_links_text_color ) : ?>

		    #swm-main-nav-holder.sticky-on ul.swm-primary-nav>li>a {

		    	<?php if ( $swm_sticky_menu_font_size ) { ?>
			    font-size:<?php echo intval($swm_sticky_menu_font_size); ?>px;
			    <?php } ?>

			    <?php if ( $swm_sticky_pr_menu_links_text_color ) { ?>
			    	color:<?php echo sanitize_hex_color($swm_sticky_pr_menu_links_text_color); ?>;
			    <?php } ?>

			}
		<?php endif; ?>

		<?php if ( $swm_sticky_pr_menu_links_text_hover_color = swm_get_option( 'swm_sticky_pr_menu_links_text_hover_color') ) { ?>
			#swm-main-nav-holder.sticky-on ul.swm-primary-nav>li>a:hover,
			#swm-main-nav-holder.sticky-on ul.swm-primary-nav>li.swm-m-active>a { color:<?php echo sanitize_hex_color($swm_sticky_pr_menu_links_text_hover_color); ?>; }

			#swm-main-nav-holder.sticky-on .swm-sp-icon-box:hover,
			#swm-main-nav-holder.sticky-on .swm-header-search span:hover,
			#swm-main-nav-holder.sticky-on span.swm-mobi-nav-btn-box>span:hover {  color:<?php echo sanitize_hex_color($swm_sticky_pr_menu_links_text_hover_color); ?>; border-color:<?php echo sanitize_hex_color($swm_sticky_pr_menu_links_text_hover_color); ?>; }

			#swm-main-nav-holder.sticky-on .swm-sp-icon-box:hover .swm-sp-icon-inner,
			#swm-main-nav-holder.sticky-on .swm-sp-icon-box:hover .swm-sp-icon-inner:after,
			#swm-main-nav-holder.sticky-on .swm-sp-icon-box:hover .swm-sp-icon-inner:before,
			#swm-main-nav-holder.sticky-on .s_two .swm-sp-icon-box:hover .swm-sp-icon-inner span { background-color: <?php echo sanitize_hex_color($swm_sticky_pr_menu_links_text_hover_color); ?>; }
		<?php } ?>

		<?php if ( $swm_sticky_pr_menu_bg = swm_get_option( 'swm_sticky_pr_menu_bg') ) { ?>
			#swm-main-nav-holder.sticky-on { background:<?php echo sanitize_hex_color($swm_sticky_pr_menu_bg); ?>; }
		<?php } ?>

		<?php if ( $swm_sticky_pr_menu_active_border_color = swm_get_option( 'swm_sticky_pr_menu_active_border_color') ) { ?>
			#swm-main-nav-holder.sticky-on .swm-primary-nav>li>a>span:before,
			#swm-main-nav-holder.sticky-on .swm-primary-nav>li.swm-m-active>a>span:before,
			#swm-main-nav-holder.sticky-on .swm-primary-nav>li>a:before,
			#swm-main-nav-holder.sticky-on .swm-primary-nav>li.swm-m-active>a:before { background:<?php echo sanitize_hex_color($swm_sticky_pr_menu_active_border_color); ?>;}
		<?php } ?>

	    <?php if ( $swm_pr_menu_divider_on == 'on') { ?>
	    #swm-main-nav-holder.sticky-on .swm-primary-nav>li:after { background:<?php echo sanitize_hex_color(swm_get_option( 'swm_sticky_pr_menu_divider_color', '#e6e6e6' )); ?>; display:block;  }
	    <?php } ?>

		<?php if ( $swm_sticky_pr_menu_links_text_color ) { ?>
		    #swm-main-nav-holder.sticky-on .swm-header-search { color:<?php echo sanitize_hex_color($swm_sticky_pr_menu_links_text_color); ?>; }

		    #swm-main-nav-holder.sticky-on .swm-sp-icon-box { border-color:<?php echo sanitize_hex_color($swm_sticky_pr_menu_links_text_color); ?>; }

		    #swm-main-nav-holder.sticky-on .swm-sp-icon-box .swm-sp-icon-inner,
		    #swm-main-nav-holder.sticky-on .swm-sp-icon-box .swm-sp-icon-inner:after,
		    #swm-main-nav-holder.sticky-on .swm-sp-icon-box .swm-sp-icon-inner:before,
		    #swm-main-nav-holder.sticky-on .s_two .swm-sp-icon-box .swm-sp-icon-inner span { background-color: <?php echo sanitize_hex_color($swm_sticky_pr_menu_links_text_color); ?>; }
		<?php } ?>

	<?php endif; ?>

	/* full screen search ------------------------------------ */

	<?php if ( swm_get_option( 'swm_header_search_on','on' ) == 'on' ) : ?>

		.swm_searchbox_holder {
			background-color:<?php echo swm_hex2rgba(swm_get_option( 'swm_header_search_bg_color', '#252628' ),swm_get_option( 'swm_header_search_bg_opacity',0.99 )); ?>;
			<?php if ( $swm_header_search_text_color ) { ?>
				color:<?php echo sanitize_hex_color($swm_header_search_text_color); ?>;
			<?php } ?>
		}

		<?php if ( $swm_header_search_text_size = swm_get_option( 'swm_header_search_text_size') ) { ?>
			@media only screen and (min-width: 768px) {
				.swm_overlay_search_box button.swm-search-button[type="submit"],
				.swm_overlay_search_box input.swm-search-form-input[type="text"],
				.swm_overlay_search_box .swm_search_form { font-size: <?php echo intval($swm_header_search_text_size); ?>px; }
			}
		<?php } ?>

		<?php if ( $swm_header_search_form_border_color = swm_get_option( 'swm_header_search_form_border_color') ) { ?>
			.swm_overlay_search_box { border-color:<?php echo sanitize_hex_color($swm_header_search_form_border_color); ?>; }
		<?php } ?>

		<?php if ( $swm_header_search_text_color ) { ?>
			.swm_overlay_search_box button.swm-search-button[type="submit"],
			.swm_overlay_search_box input.swm-search-form-input[type="text"],
			.swm_overlay_search_box input.swm-search-form-input[type="text"]:focus { color:<?php echo sanitize_hex_color($swm_header_search_text_color); ?>; }

			.swm_overlay_search_box input.swm-search-form-input[type="text"] { color:<?php echo sanitize_hex_color($swm_header_search_text_color); ?>; text-shadow:none; }
			.swm_overlay_search_box input::-webkit-input-placeholder { color:<?php echo sanitize_hex_color($swm_header_search_text_color); ?>; }
			.swm_overlay_search_box input::-moz-placeholder { color:<?php echo sanitize_hex_color($swm_header_search_text_color); ?>; }
			.swm_overlay_search_box input::-ms-placeholder { color:<?php echo sanitize_hex_color($swm_header_search_text_color); ?>; }
			.swm_overlay_search_box input::placeholder { color:<?php echo sanitize_hex_color($swm_header_search_text_color); ?>; }
		<?php } ?>

		<?php if ( $swm_header_search_max_width = swm_get_option( 'swm_header_search_max_width') ) { ?>
			.swm_overlay_search_box { max-width: <?php echo intval($swm_header_search_max_width); ?>px; }
		<?php } ?>

		<?php if ( $swm_header_close_icon_color = swm_get_option( 'swm_header_close_icon_color') ) { ?>
			.swm_searchbox_close { color:<?php echo sanitize_hex_color($swm_header_close_icon_color); ?>; }
		<?php } ?>

	<?php endif; ?>

	/*  Side Panel ------------------------------------ */

	<?php if ( $swm_sidepanel_on == 'on' ) : ?>

		<?php if ( $swm_sidepanel_max_width = swm_get_option( 'swm_sidepanel_max_width') ) { ?>
			.swm-sidepanel { max-width: <?php echo intval($swm_sidepanel_max_width); ?>px; }

			<?php if (is_rtl()) { ?>
				#swm-sidepanel-container { width: <?php echo intval($swm_sidepanel_max_width); ?>px; left:-<?php echo intval($swm_sidepanel_max_width) + 30; ?>px; }
			<?php } else { ?>
				#swm-sidepanel-container { width: <?php echo intval($swm_sidepanel_max_width); ?>px; right:-<?php echo intval($swm_sidepanel_max_width) + 30; ?>px; }
			<?php } ?>

		<?php } ?>

		<?php if ( $swm_sidepanel_icon_col ) { ?>
			.swm-sp-icon-box .swm-sp-icon-inner,
			.swm-sp-icon-box .swm-sp-icon-inner:after,
			.swm-sp-icon-box .swm-sp-icon-inner:before,
			.s_two .swm-sp-icon-box .swm-sp-icon-inner span { background-color: <?php echo sanitize_hex_color($swm_sidepanel_icon_col); ?>; }
		<?php } ?>

		.swm-sidePanelOn .swm-sidepanel-body-overlay {  background:<?php echo swm_hex2rgba(swm_get_option( 'swm_sidepanel_overlay_bg', '#000000' ),swm_get_option( 'swm_sidepanel_overlay_bg_opacity',0.8 )); ?>; }

		<?php if ( $swm_close_icon_on == 'on' ) { ?>
			.swm-sidepanel-close a i { border-color: <?php echo sanitize_hex_color(swm_get_option( 'swm_sidepanel_close_icon_border_col', '#e6e6e6' )); ?>; color:<?php echo sanitize_hex_color(swm_get_option( 'swm_sidepanel_close_icon_col', '#d83030' )); ?>; }
		<?php } ?>

		@media only screen and (max-width: <?php echo intval(swm_get_option( 'swm_hide_sidepanel_resolution',979 )); ?>px) {
			.swm-sidepanel,#swm-sidepanel-trigger,.swm-sidepanel-body-overlay { display:none; }
		}

		<?php if ( $swm_sidepanel_text_col = swm_get_option( 'swm_sidepanel_text_col' ) ) { ?>
			.swm-sidepanel,
			.widget-search .swm-search-form button.swm-search-button,
			.swm-sidepanel .widget_product_search #swm_product_search_form button.swm-search-button,
			#widget_search_form input[type="text"],
			.swm-sidepanel .gyan_recent_posts_tiny_title a { color:<?php echo sanitize_hex_color($swm_sidepanel_text_col); ?>; }
		<?php } ?>

		<?php if ( $swm_sidepanel_icon_col ) { ?>
			.swm-sp-icon-box { border-color:<?php echo sanitize_hex_color($swm_sidepanel_icon_col); ?>; }
		<?php } ?>

		.swm-sidepanel .swm-sidepanel-ttl h3 span,
		.swm-sidepanel .swm-archives-content h4 {
			color:<?php echo sanitize_hex_color(swm_get_option( 'swm_sidepanel_title_color', '#032e42' )); ?>;
			font-size: <?php echo intval(swm_get_option( 'swm_sidepanel_title_size', 19 )); ?>px;
			letter-spacing: <?php echo intval(swm_get_option( 'swm_sidepanel_title_letter_space', 0 )); ?>px;
			text-transform: <?php echo esc_attr(swm_get_option( 'swm_sidepanel_title_transform', 'none' )); ?>;
		}

		<?php if ( $swm_sidepanel_link = swm_get_option( 'swm_sidepanel_link' ) ) { ?>
			.swm-sidepanel .recent_posts_slider a,
			.swm-sidepanel a,
			.swm-sidepanel .tp_recent_tweets .twitter_time { color:<?php echo sanitize_hex_color($swm_sidepanel_link);?>;  }
		<?php } ?>

		<?php if ( $swm_sidepanel_link_hover = swm_get_option( 'swm_sidepanel_link_hover' ) ) { ?>
			.swm-sidepanel ul li a:hover,
			.swm-sidepanel a:hover { color:<?php echo sanitize_hex_color($swm_sidepanel_link_hover); ?>; }
		<?php } ?>

		<?php if ( $swm_sidepanel_text_size = swm_get_option( 'swm_sidepanel_text_size' ) ) { ?>
			.swm-sidepanel,
			.swm-sidepanel p,
			.swm-sidepanel ul li,
			.swm-sidepanel ul li a,
			.swm-sidepanel .tagcloud a { font-size: <?php echo intval($swm_sidepanel_text_size); ?>px; }
		<?php } ?>

		<?php if ( $swm_sidepanel_border_color = swm_get_option( 'swm_sidepanel_border_color' ) ) { ?>

			.swm-sidepanel .widget-search .swm-search-form #s,
			.swm-sidepanel .widget_rss ul li,
			.swm-sidepanel .widget_meta ul li,
			.swm-sidepanel .widget_pages ul li,
			.swm-sidepanel .widget_archive ul li,
			.swm-sidepanel .widget_recent_comments ul li,
			.swm-sidepanel .widget_recent_entries ul li,
			.swm-sidepanel .widget-nav-menu ul li,
			.swm-sidepanel .input-text,
			.swm-sidepanel input[type="text"],
			.swm-sidepanel input[type="password"],
			.swm-sidepanel input[type="email"],
			.swm-sidepanel input[type="number"],
			.swm-sidepanel input[type="url"],
			.swm-sidepanel input[type="tel"],
			.swm-sidepanel input[type="search"],
			.swm-sidepanel textarea,
			.swm-sidepanel select,
			.swm-sidepanel #wp-calendar thead th,
			.swm-sidepanel #wp-calendar caption,
			.swm-sidepanel #wp-calendar tbody td,
			.swm-sidepanel #wp-calendar tbody td:hover,
			.swm-sidepanel input[type="text"]:focus,
			.swm-sidepanel input[type="password"]:focus,
			.swm-sidepanel input[type="email"]:focus,
			.swm-sidepanel input[type="number"]:focus,
			.swm-sidepanel input[type="url"]:focus,
			.swm-sidepanel input[type="tel"]:focus,
			.swm-sidepanel input[type="search"]:focus,
			.swm-sidepanel textarea:focus,
			.swm-sidepanel .widget-search .swm-search-form #s:focus,
			.swm-sidepanel .gyan-recent-posts-large-title,
			.swm-sidepanel .gyan-recent-posts-tiny ul li,
			.swm-sidepanel .swm-list-widgets ul li {  border-color: <?php echo sanitize_hex_color($swm_sidepanel_border_color);?>;}

		<?php } ?>

	<?php endif; // sidepanel ?>

	<?php if ( swm_get_option( 'swm_header_contact_info_on','on' ) == 'on' ) : ?>

		.swm_header_contact_info, .swm_header_contact_info a { color:<?php echo sanitize_hex_color($swm_cih_title_color); ?>; }
		.swm-cih-subtitle { color:<?php echo sanitize_hex_color(swm_get_option( 'swm_cih_subtitle_color', '#676767' )); ?>; }
		.swm-cih-icon { color:<?php echo sanitize_hex_color(swm_get_option( 'swm_cih_icon_color', '#d83030' )); ?>; }
		.swm-cih-title { font-size: <?php echo intval(swm_get_option( 'swm_cih_title_size', 16 )); ?>px;  }
		.swm-cih-subtitle { font-size: <?php echo intval(swm_get_option( 'swm_cih_subtitle_size', 15 )); ?>px;  }
		.swm-header-cinfo-column:before { background:<?php echo sanitize_hex_color($swm_cih_title_color); ?>; }

		<?php if ( $swm_cih_social_icons_on != 'on' ) { ?>
			.swm_header_contact_info ul li:last-child:before { display:none; }
			.swm_header_contact_info ul li:last-child { padding-right:0; }
		<?php } ?>

		<?php if ( $swm_cih_social_icons_on == 'on' ) { ?>
			ul.swm-header-socials li a { color:<?php echo sanitize_hex_color($swm_cih_sicons_col); ?> ; background:<?php echo sanitize_hex_color($swm_cih_sicons_bg); ?>; }
			ul.swm-header-socials li:hover a { color:<?php echo sanitize_hex_color($swm_cih_sicons_col_hover); ?> ; background:<?php echo sanitize_hex_color(swm_get_option( 'swm_cih_sicons_bg_hover', '#d83030' )); ?>; }

			.header_2_t ul.swm-header-socials li a { border-color:<?php echo sanitize_hex_color($swm_cih_sicons_col); ?> ; }
			.header_2_t ul.swm-header-socials li a:hover { border-color:<?php echo sanitize_hex_color($swm_cih_sicons_col_hover); ?> ; }
		<?php } ?>

	<?php endif; // contact info ?>

<?php
endif; /* End Top Header */ ?>