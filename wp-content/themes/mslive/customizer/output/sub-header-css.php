<?php
$swm_meta_header_bg_color = '';
$swm_final_meta_header_bg_images = '';

$swm_show_hide_sub_header = swm_show_hide_section_controls('swm_sub_header_on','swm_meta_sub_header_on');

if ( is_front_page() && is_home() ) {
	$swm_home_blog_header = swm_get_option('swm_home_blog_header','on');
	$swm_show_hide_sub_header = 'show_section';
	if ( $swm_home_blog_header != 'on' ) {
		$swm_show_hide_sub_header = 'hide_section';
	}
}

$swm_meta_sub_header_on = get_post_meta( swm_get_queried_object_id(), 'swm_meta_sub_header_on', true );

if ( $swm_show_hide_sub_header == 'show_section' ) :

	if ( function_exists('rwmb_meta') && !is_search() && !empty( $swm_meta_sub_header_on ) && $swm_meta_sub_header_on != 'default' ) :

		$swm_meta_header_bg_color        = get_post_meta( swm_get_queried_object_id(), 'swm_meta_header_bg_color', true );
		$swm_meta_header_bg_image        = get_post_meta( swm_get_queried_object_id(), 'swm_meta_header_bg_image', true );
		$swm_meta_header_bg_image_src    = wp_get_attachment_image_src($swm_meta_header_bg_image,'full');
		$swm_final_meta_header_bg_images = $swm_meta_header_bg_image_src[0];

		if ( ! empty($swm_final_meta_header_bg_images) ) {
			$swm_sub_header_bg_style = get_post_meta( swm_get_queried_object_id(), 'swm_meta_sub_header_bg_style', true );
		}

		$swm_sub_header_title_color       = get_post_meta( swm_get_queried_object_id(), 'swm_meta_sub_header_title_color', true );
		$swm_sub_header_title_on          = get_post_meta( swm_get_queried_object_id(), 'swm_meta_sub_header_title_on', true );
		$swm_sub_header_title_font_size_d = get_post_meta( swm_get_queried_object_id(), 'swm_meta_sub_header_title_font_size_d', true );
		$swm_sub_header_title_font_size_t = get_post_meta( swm_get_queried_object_id(), 'swm_meta_sub_header_title_font_size_t', true );
		$swm_sub_header_title_font_size_m = get_post_meta( swm_get_queried_object_id(), 'swm_meta_sub_header_title_font_size_m', true );
		$swm_sub_header_title_transform   = get_post_meta( swm_get_queried_object_id(), 'swm_meta_sub_header_title_transform', true );

		$swm_sub_header_height_d = get_post_meta( swm_get_queried_object_id(), 'swm_meta_sub_header_height_d', true );
		$swm_sub_header_height_t = get_post_meta( swm_get_queried_object_id(), 'swm_meta_sub_header_height_t', true );
		$swm_sub_header_height_m = get_post_meta( swm_get_queried_object_id(), 'swm_meta_sub_header_height_m', true );

	endif;?>

	<?php
	if (is_category() ) :
		$swm_get_query_var_cat = get_query_var('cat');
		$swm_get_cat = get_category($swm_get_query_var_cat);
		$swm_cat_header_bg = swm_get_option($swm_get_cat->slug.'_bg_img');

		if ( $swm_cat_header_bg ) {
			$swm_sub_header_bg_img = $swm_cat_header_bg;
		}

		$swm_sub_header_title_color = swm_get_option($swm_get_cat->slug.'_title','#ffffff');
	endif;

	?>

	<?php if ( $swm_sub_header_title_on == 'on' ) :

		$swm_header_title_font_weight  		= swm_get_option( 'swm_header_title_font_weight', '700' );
		$swm_check_header_title_font_italic	= swm_check_google_font_italic( $swm_header_title_font_weight );
		?>
		.swm-sub-header-title,h1.swm-sub-header-title {
			font-family:<?php echo swm_get_option( 'swm_header_title_font_family', 'Fira Sans' ); ?>;
			font-size: <?php echo intval($swm_sub_header_title_font_size_d); ?>px;
			text-transform:<?php echo $swm_sub_header_title_transform; ?>;
			color:<?php echo sanitize_hex_color($swm_sub_header_title_color); ?>;
			font-weight: <?php echo swm_google_fonts_final_weight( swm_get_option( 'swm_header_title_font_weight', '700' ) ); ?>;
			font-style: <?php echo $swm_check_header_title_font_italic ? 'italic' : 'normal'; ?> !important;
		}
	<?php endif; ?>

	.swm-sub-header {

		height: <?php echo intval($swm_sub_header_height_d); ?>px;

		<?php
		$swm_final_header_bg_color = empty($swm_meta_header_bg_color) ? $swm_sub_header_bg_color : $swm_meta_header_bg_color;
		$swm_final_header_bg_image = empty($swm_final_meta_header_bg_images) ? $swm_sub_header_bg_img : $swm_final_meta_header_bg_images;
		?>

		<?php
		if ( $swm_final_meta_header_bg_images == '' && $swm_meta_header_bg_color != '' ) {
			if ( $swm_meta_header_bg_color != '' ) {
				echo 'background-color:' . sanitize_hex_color($swm_meta_header_bg_color) . ';' ;
			}
		} else { ?>

			background-color:<?php echo sanitize_hex_color($swm_final_header_bg_color); ?>;

			<?php if ( $swm_final_header_bg_image ) : ?>
				background-image:url("<?php echo esc_url($swm_final_header_bg_image); ?>");
				<?php echo swm_background_style_css($swm_sub_header_bg_style); ?>
			<?php endif; ?>

		<?php }
		?>
	}
	<?php
	$swm_subheader_extra_padding = ( $swm_header_style == 'header_2_t' ) ? 67 : 0;

	if ( $swm_sub_header_above_header_on != 'on' ) { ?>

		@media(min-width:768px){
			body.transparentHeader .swm-sub-header { padding-top:<?php echo intval($swm_main_header_height_d) + $swm_subheader_extra_padding; ?>px; }
		}
		<?php
		if ( $swm_header_style == 'header_2' ) { ?>
			.swm-sub-header { padding-top:34px; }
		<?php } ?>

	<?php } ?>

	@media(max-width:767px){
		.swm-sub-header {
			height: <?php echo intval($swm_sub_header_height_t); ?>px;
		}
		#swm-sub-header .swm-sub-header-title,
		#swm-sub-header h1.swm-sub-header-title {
			font-size: <?php echo intval($swm_sub_header_title_font_size_t); ?>px;
		}
	}

	@media(max-width:480px){
		.swm-sub-header {
			height: <?php echo intval($swm_sub_header_height_m); ?>px;
		}
		#swm-sub-header .swm-sub-header-title,
		#swm-sub-header h1.swm-sub-header-title {
			font-size: <?php echo intval($swm_sub_header_title_font_size_m); ?>px;
		}
	}

	<?php
	if ( !is_front_page() ) {

		$swm_meta_sub_header_breadcrumb_on = get_post_meta( swm_get_queried_object_id(), 'swm_meta_sub_header_breadcrumb_on', true );

		if ( function_exists('rwmb_meta') && !is_search() && ! empty( $swm_meta_sub_header_breadcrumb_on ) && $swm_meta_sub_header_breadcrumb_on == 'on' && !empty( $swm_meta_sub_header_on ) && $swm_meta_sub_header_on != 'default' ) :

			$swm_sub_header_breadcrumb_on        = $swm_meta_sub_header_breadcrumb_on;
			$swm_breadcrumbs_text_color          = get_post_meta( swm_get_queried_object_id(), 'swm_meta_breadcrumbs_text_color', true );
			$swm_sub_header_breadcrumb_transform = get_post_meta( swm_get_queried_object_id(), 'swm_meta_sub_header_breadcrumb_transform', true );
			$swm_sub_header_breadcrumb_font_size = get_post_meta( swm_get_queried_object_id(), 'swm_meta_sub_header_breadcrumb_font_size', true );
			$swm_breadcrumbs_text_hover_color    = get_post_meta( swm_get_queried_object_id(), 'swm_meta_breadcrumbs_text_hover_color', true );

		endif;

		/* Breadcrumbs ----------------- */
		if ( $swm_sub_header_breadcrumb_on == 'on' ) : ?>
			.swm-breadcrumbs,.swm-breadcrumbs a {
				color:<?php echo sanitize_hex_color($swm_breadcrumbs_text_color); ?>;
				font-size: <?php echo intval($swm_sub_header_breadcrumb_font_size); ?>px;
				text-transform:<?php echo $swm_sub_header_breadcrumb_transform; ?>;
			}
			.swm-breadcrumbs a:hover {
				color:<?php echo sanitize_hex_color($swm_breadcrumbs_text_hover_color); ?>;
			}

			.swm-breadcrumbs span.swm-bc-sep {
				color:<?php echo sanitize_hex_color($swm_breadcrumbs_icons_color); ?>;
			}

			<?php
		endif;
	}?>

	<?php
endif;