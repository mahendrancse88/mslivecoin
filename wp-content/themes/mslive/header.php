<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> data-boxed-margin="<?php echo intval(swm_get_option( 'swm_boxed_layout_margin_top_bottom', 40 )); ?>">
	<?php wp_body_open(); ?>

	<?php if ( swm_get_option('swm_page_preloader_on','off' ) == 'on' ) { ?>

		<div class="swm-site-loader">
			<div class="swm-loader-holder">
				<div class="swm-loader">
				</div>
			</div>
		</div>

	<?php } ?>

	<?php
	if ( swm_get_option('swm_header_search_on','on') == 'on') {
		get_template_part('parts/search-overlay');
	}

	if ( swm_get_option('swm_sidepanel_on','off') == 'on' && swm_customizer_metabox_onoff('swm_main_header_on','swm_meta_main_header_on','on','default') == 'on' ) {
		get_template_part('parts/side-panel');
	}
	?>

	<?php
	if ( swm_get_option('swm_sub_header_above_header_on','off') == 'on') {
		get_template_part('parts/headers/sub-header-one');
	}

	?>

	<div id="swm-page">
		<div id="swm-outer-wrap" class="clear"><?php get_template_part('parts/headers/topbar'); ?>
			<div id="swm-wrap" class="clear">
				<?php

				if ( swm_customizer_metabox_onoff('swm_main_header_on','swm_meta_main_header_on','on','default') == 'on' ) {

					get_template_part('parts/headers/main-header');

					if ( swm_get_option( 'swm_header_style','header_1' ) != 'header_1_t'  && swm_get_option( 'swm_header_style','header_1' ) != 'header_2_t' ) {
						?><div class="swm-header-placeholder" data-header-d="<?php echo swm_get_option( 'swm_main_header_height_d', 80 ); ?>" data-header-t="<?php echo swm_get_option( 'swm_main_header_height_t', 80 ); ?>" data-header-m="<?php echo swm_get_option( 'swm_main_header_height_m', 80 ); ?>" ></div><?php
					}

				}

				if ( swm_get_option('swm_sub_header_above_header_on','off') != 'on') {
					get_template_part('parts/headers/sub-header-one');
				}

				?>
			<div id="content" class="swm-main-container swm-site-content swm-css-transition" >