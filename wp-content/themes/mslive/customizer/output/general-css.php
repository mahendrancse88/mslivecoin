<?php if ( swm_get_option('swm_page_preloader_on','off' ) == 'on' ) { ?>

	@-webkit-keyframes swm-loader-key {0%, 80%, 100% {box-shadow: 0 2.5em 0 -1.3em <?php echo sanitize_hex_color($swm_page_preloader_shape_color); ?>; } 40% {box-shadow: 0 2.5em 0 0 <?php echo sanitize_hex_color($swm_page_preloader_shape_color); ?>; } }
	@keyframes swm-loader-key {0%, 80%, 100% {box-shadow: 0 2.5em 0 -1.3em <?php echo sanitize_hex_color($swm_page_preloader_shape_color); ?>; } 40% {box-shadow: 0 2.5em 0 0 <?php echo sanitize_hex_color($swm_page_preloader_shape_color); ?>; } }
	.swm-site-loader { background:<?php echo sanitize_hex_color(swm_get_option( 'swm_page_preloader_bg', '#f6f3ee' )); ?>; }

<?php } ?>


@media (min-width:1200px) {
 	.swm-container {
  		max-width:<?php echo intval($swm_layout_max_width); ?>px;
 	}
}

a.swm-go-top-scroll-btn {
	background:<?php echo sanitize_hex_color(swm_get_option( 'swm_bottom_go_top_scroll_bg', '#252628' )); ?>;
	color:<?php echo sanitize_hex_color(swm_get_option( 'swm_bottom_go_top_scroll_shape_color', '#ffffff' )); ?>;
}

/* Fonts ----------------- */

body {
	font-size:<?php echo intval($swm_body_font_size); ?>px;
	line-height:<?php echo floatval(swm_get_option( 'swm_body_font_lineheight', 1.7 )); ?>;
}
.swm-site-content h1 { font-size:<?php echo intval(swm_get_option( 'swm_h1_font_size', 40 )); ?>px; line-height:<?php echo intval(swm_get_option( 'swm_h1_font_lineheight', 55 )); ?>px; }
.swm-site-content h2 { font-size:<?php echo intval(swm_get_option( 'swm_h2_font_size', 33 )); ?>px; line-height:<?php echo intval(swm_get_option( 'swm_h2_font_lineheight', 50 )); ?>px; }
.swm-site-content h3 { font-size:<?php echo intval(swm_get_option( 'swm_h3_font_size', 29 )); ?>px; line-height:<?php echo intval(swm_get_option( 'swm_h3_font_lineheight', 40 )); ?>px; }
.swm-site-content h4 { font-size:<?php echo intval(swm_get_option( 'swm_h4_font_size', 25 )); ?>px; line-height:<?php echo intval(swm_get_option( 'swm_h4_font_lineheight', 36 )); ?>px; }
.swm-site-content h5 { font-size:<?php echo intval(swm_get_option( 'swm_h5_font_size', 22 )); ?>px; line-height:<?php echo intval(swm_get_option( 'swm_h5_font_lineheight', 30 )); ?>px; }
.swm-site-content h6 { font-size:<?php echo intval(swm_get_option( 'swm_h6_font_size', 19 )); ?>px; line-height:<?php echo intval(swm_get_option( 'swm_h6_font_lineheight', 25 )); ?>px; }

h4.vc_tta-panel-title { font-size:<?php echo intval($swm_body_font_size); ?>px; }

<?php if ( swm_get_option( 'swm_google_fonts_on', 'on' ) == 'on' ) {

	$swm_headings_font_weight       = swm_get_option( 'swm_headings_font_weight', '700' );
	$swm_final_headings_font_weight = swm_google_fonts_final_weight( $swm_headings_font_weight );
	$swm_check_headings_font_italic = swm_check_google_font_italic( $swm_headings_font_weight );

	$swm_body_font_family       = swm_get_option( 'swm_body_font_family', 'Roboto' );
	$swm_body_font_weight       = swm_get_option( 'swm_body_font_weight', '400' );
	$swm_check_body_font_italic = swm_check_google_font_italic( $swm_body_font_weight );
	?>

	body {
		font-family:<?php echo $swm_body_font_family; ?>;
		font-style: <?php echo $swm_check_body_font_italic ? 'italic' : 'normal'; ?> !important;
		font-weight:<?php echo swm_google_fonts_final_weight( swm_get_option( 'swm_body_font_weight', '400' ) ); ?>;
	}

	<?php
	$swm_widget_title_font_weight       = swm_get_option( 'swm_widget_title_font_weight', '700' );
	$swm_check_widget_title_font_italic = swm_check_google_font_italic( $swm_widget_title_font_weight );
	?>

	.swm-site-content .sidebar .swm-sidebar-ttl h3,
	.swm-sidepanel .swm-sidepanel-ttl h3,
	.footer .swm-footer-widget h3,
	.gyan_widget_tabs .gyan_wid_tabs li,
	.gyan-heading-text,
	.swm-heading-text,
	blockquote.wp-block-quote.is-style-large p,
	p.has-large-font-size,
	.has-drop-cap:not(:focus)::first-letter {
		font-family:<?php echo swm_get_option( 'swm_widget_title_font_family', 'Fira Sans' ); ?>;
		font-style: <?php echo $swm_check_widget_title_font_italic ? 'italic' : 'normal'; ?> !important;
		font-weight:<?php echo swm_google_fonts_final_weight( $swm_widget_title_font_weight ); ?>; }

	h1,h2,h3,h4,h5,h6,
	.gyan_fancy_heading_text,
	.gyan-heading-font,
	.gyan-font-heading,
	.swm-heading-font,
	.swm-font-heading,
	.swm-pf-only-title,
	.gyan_events_main_title {
		font-family:<?php echo swm_get_option( 'swm_headings_font_family', 'Fira Sans' ); ?>;
		font-style: <?php echo $swm_check_headings_font_italic ? 'italic' : 'normal'; ?> !important;
		font-weight:<?php echo $swm_final_headings_font_weight; ?>; }

	h4.vc_tta-panel-title {
		font-family:<?php echo $swm_body_font_family; ?>;
		font-weight:<?php echo $swm_body_font_weight; ?>; }

	.swm-site-content blockquote,
	.swm-site-content blockquote p {
		font-family:<?php echo $swm_body_font_family; ?>;
		font-weight:<?php echo $swm_body_font_weight; ?>; }

	<?php
}

// container left and right padding

if ( $swm_container_padding && swm_customizer_metabox_onoff('swm_site_layout','swm_meta_site_layout','full-width','default') != 'boxed') {

	$swm_container_padding = intval($swm_container_padding);
	?>

	.swm-container { padding: 0 <?php echo $swm_container_padding; ?>px; }

	@media only screen and (min-width: 980px) {

		<?php if (is_rtl()) { ?>
			.swm-topbar-content .left:after,
			.swm-topbar-content .left:before {
			    right: -<?php echo $swm_container_padding; ?>px;
			    width: calc(100% + <?php echo $swm_container_padding; ?>px);
			}
			.swm-topbar-content .left:after {
			    right: -<?php echo $swm_container_padding - 9; ?>px;
			}
		<?php } else { ?>
			.swm-topbar-content .left:after,
			.swm-topbar-content .left:before {
			    left: -<?php echo $swm_container_padding; ?>px;
			    width: calc(100% + <?php echo $swm_container_padding; ?>px);
			}
			.swm-topbar-content .left:after {
			    left: -<?php echo $swm_container_padding - 9; ?>px;
			}
		<?php } ?>


	}

<?php }



// content top and bottom
if (  get_post_meta( swm_get_queried_object_id(), 'swm_meta_content_padding_on', 'default' ) != 'no_padding' ) :

	$swm_site_content_top_padding_d    = intval(swm_get_option( 'swm_site_content_top_padding_d', '100' ));
	$swm_site_content_bottom_padding_d = intval(swm_get_option( 'swm_site_content_bottom_padding_d', '100' ));
	$swm_site_content_top_padding_t    = intval(swm_get_option( 'swm_site_content_top_padding_t', '80'));
	$swm_site_content_bottom_padding_t = intval(swm_get_option( 'swm_site_content_bottom_padding_t', '80'));
	$swm_site_content_top_padding_m    = intval(swm_get_option( 'swm_site_content_top_padding_m', '60'));
	$swm_site_content_bottom_padding_m = intval(swm_get_option( 'swm_site_content_bottom_padding_m', '60'));

	if ( function_exists('rwmb_meta') && get_post_meta( swm_get_queried_object_id(), 'swm_meta_content_padding_on', 'default' ) == 'custom' ) {

		$swm_meta_page_content_top_padding_d    = intval(get_post_meta( swm_get_queried_object_id(), 'swm_meta_page_content_top_padding_d', '100' ));
		$swm_meta_page_content_bottom_padding_d = intval(get_post_meta( swm_get_queried_object_id(), 'swm_meta_page_content_bottom_padding_d', '100' ));
		$swm_meta_page_content_top_padding_t    = intval(get_post_meta( swm_get_queried_object_id(), 'swm_meta_page_content_top_padding_t', '80' ));
		$swm_meta_page_content_bottom_padding_t = intval(get_post_meta( swm_get_queried_object_id(), 'swm_meta_page_content_bottom_padding_t', '80' ));
		$swm_meta_page_content_top_padding_m    = intval(get_post_meta( swm_get_queried_object_id(), 'swm_meta_page_content_top_padding_m', '60' ));
		$swm_meta_page_content_bottom_padding_m = intval(get_post_meta( swm_get_queried_object_id(), 'swm_meta_page_content_bottom_padding_m', '60' ));

		$swm_site_content_top_padding_d    = $swm_meta_page_content_top_padding_d;
		$swm_site_content_bottom_padding_d = $swm_meta_page_content_bottom_padding_d;
		$swm_site_content_top_padding_t    = $swm_meta_page_content_top_padding_t;
		$swm_site_content_bottom_padding_t = $swm_meta_page_content_bottom_padding_t;
		$swm_site_content_top_padding_m    = $swm_meta_page_content_top_padding_m;
		$swm_site_content_bottom_padding_m = $swm_meta_page_content_bottom_padding_m;

		}

	$swm_content_padding_tablet = '767';
 	$swm_content_padding_tablet = apply_filters( 'swm_content_padding_tablet', $swm_content_padding_tablet );

 	$swm_content_padding_mobile = '480';
 	$swm_content_padding_mobile = apply_filters( 'swm_content_padding_mobile', $swm_content_padding_mobile );
	?>

	.swm-main-container.swm-site-content { padding-top:<?php echo $swm_site_content_top_padding_d; ?>px; padding-bottom:<?php echo $swm_site_content_bottom_padding_d; ?>px; }

	@media only screen and (max-width: <?php echo intval($swm_content_padding_tablet); ?>px) {
		.swm-main-container.swm-site-content { padding-top:<?php echo $swm_site_content_top_padding_t; ?>px; padding-bottom:<?php echo $swm_site_content_bottom_padding_t; ?>px; }
	}
	@media only screen and (max-width:  <?php echo intval($swm_content_padding_mobile); ?>px) {
		.swm-main-container.swm-site-content { padding-top:<?php echo $swm_site_content_top_padding_m; ?>px; padding-bottom:<?php echo $swm_site_content_bottom_padding_m; ?>px; }
	}

	<?php
endif; ?>

@media only screen and (min-width: 980px) {

	/* Site Content Section - With sidebar content width ----------------- */

	<?php if ($swm_content_width = swm_get_option( 'swm_content_width' )) { ?>
		.swm-custom-two-third { width: <?php echo intval($swm_content_width) - 3.20197.'%'; ?>; }
		#sidebar { width: <?php echo 100 - intval($swm_content_width).'%'; ?>; }
	<?php } ?>

	<?php
	if (function_exists('rwmb_meta') && swm_customizer_metabox_onoff('swm_content_layout','swm_meta_content_layout','layout-full-width','default') == 'layout-full-screen') {
		echo '.swm-site-content .swm-container .swm-custom-two-third { width:100%; max-width:100%; }';
	}
	?>

}

/* Boxed Layout ----------------- */

<?php if ( swm_customizer_metabox_onoff('swm_site_layout','swm_meta_site_layout','full-width','default') == 'boxed' ) { ?>

	.swm-l-boxed #swm-header,
	.swm-l-boxed #swm-page,
	.swm-l-boxed #swm-main-nav-holder.sticky-on {
		max-width:<?php echo intval($swm_layout_max_width);?>px;
	}
	@media (min-width:576px) {
		.swm-l-boxed .swm-container { padding:0 <?php echo intval($swm_boxed_layout_padding_left_right);?>px; }
	}

	body {
		background-color:<?php echo swm_hex2rgba(swm_get_option( 'swm_body_bg_color', '#444444' ),swm_get_option( 'swm_body_bg_opacity',1 )); ?>;

		<?php if ( $swm_body_bg_img = swm_get_option( 'swm_body_bg_img', '' ) ) { ?>
			background-image:url(<?php echo esc_url($swm_body_bg_img); ?>);
			<?php echo swm_background_style_css(swm_get_option( 'swm_body_bg_style', 'cover' )); ?>
		<?php } ?>
	}

	@media only screen and (min-width:<?php echo intval(swm_get_option( 'swm_boxed_layout_no_margin_resolution', 980 )); ?>px) {

		.swm-l-boxed #swm-outer-wrap { padding:<?php echo intval(swm_get_option( 'swm_boxed_layout_margin_top_bottom', 40 )); ?>px 0; }

		.swm-l-boxed #swm-page,.swm-l-boxed #swm-main-nav-holder.sticky-on { max-width:<?php echo intval($swm_layout_max_width); ?>px; }

		.swm-l-boxed #swm-wrap {border-radius:<?php echo intval($swm_boxed_layout_border_radius); ?>px; }

		<?php if ( swm_customizer_metabox_onoff('swm_topbar_on','swm_meta_topbar_on','off','default') == 'on' ) : ?>
			.swm-l-boxed #swm-wrap {border-radius:0 0 <?php echo intval($swm_boxed_layout_border_radius); ?>px <?php echo intval($swm_boxed_layout_border_radius); ?>px; }
			body.swm-l-boxed .swm-topbar-main-container {border-radius: <?php echo intval($swm_boxed_layout_border_radius); ?>px <?php echo intval($swm_boxed_layout_border_radius); ?>px 0 0; }
		<?php endif; ?>

	}

	@media only screen and (max-width: 979px) {
		.swm-l-boxed.revSlider-HeaderOn .swm-topbar-main-container,
		.swm-l-boxed.revSlider-HeaderOn .swm-logo-menu-header { width:100%; }
	}

<?php } ?>

<?php if ( $swm_content_headings_color = swm_get_option( 'swm_content_headings_color' ) ) { ?>
	.swm-site-content h1,
	.swm-site-content h2,
	.swm-site-content h3,
	.swm-site-content h4,
	.swm-site-content h5,
	.swm-site-content h6,
	.swm-site-content h1 a,
	.swm-site-content h2 a,
	.swm-site-content h3 a,
	.swm-site-content h4 a,
	.swm-site-content h5 a,
	.swm-site-content h6 a {
		color:<?php echo sanitize_hex_color($swm_content_headings_color); ?>;
	}
<?php } ?>