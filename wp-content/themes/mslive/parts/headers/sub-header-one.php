<?php

if ( is_front_page() && is_home() ) {
	$swm_meta_header_style = swm_get_option('swm_home_blog_header_style','standard');
	$swm_header_rev_slider_name = swm_get_option('swm_header_rev_slider_shortcode');
} else {
	$swm_meta_header_style = get_post_meta( swm_get_queried_object_id(), 'swm_meta_header_style', true );
	$swm_header_rev_slider_name = get_post_meta( swm_get_queried_object_id(), 'swm_meta_header_revolution', true );
}

$postid = get_the_ID();

$swm_show_hide_sub_header = swm_show_hide_section_controls('swm_sub_header_on','swm_meta_sub_header_on');

if ( is_front_page() && is_home() ) {
	$swm_home_blog_header = swm_get_option('swm_home_blog_header','on');
	$swm_show_hide_sub_header = 'show_section';
	if ( $swm_home_blog_header != 'on' ) {
		$swm_show_hide_sub_header = 'hide_section';
	}
}

if ( $swm_show_hide_sub_header == 'show_section' ) {

	if ( $swm_meta_header_style == 'revolution_slider' && $swm_header_rev_slider_name != '' ) {
		?>
		<div class="swm-header-slider">
			<?php echo do_shortcode( '[rev_slider alias="'.esc_attr($swm_header_rev_slider_name).'"]' ); ?> </div>
		<?php
	} else {
		wp_reset_postdata();

		$swm_meta_sub_header_on = 'default';
		$swm_sub_header_title_position = swm_get_option('swm_sub_header_title_position','title-center');
		$swm_meta_sub_header_on = get_post_meta( swm_get_queried_object_id(), 'swm_meta_sub_header_on', true );
		$swm_sub_header_breadcrumb_on = swm_get_option( 'swm_sub_header_breadcrumb_on','on');

		if ( function_exists('rwmb_meta') && !is_search() && !empty( $swm_meta_sub_header_on ) && $swm_meta_sub_header_on != 'default' ) {
			$swm_sub_header_title_position = get_post_meta( swm_get_queried_object_id(), 'swm_meta_sub_header_title_position', true );

			$swm_meta_sub_header_breadcrumb_on = get_post_meta( swm_get_queried_object_id(), 'swm_meta_sub_header_breadcrumb_on', true );

			if ( ! empty( $swm_meta_sub_header_breadcrumb_on ) ) {
				$swm_sub_header_breadcrumb_on = $swm_meta_sub_header_breadcrumb_on;
			}

		}
		?>
		<div id="swm-sub-header" class="swm-sub-header swm-title-position-<?php echo $swm_sub_header_title_position; ?>">
			<div class="swm-container swm-css-transition">

				<div class="swm-sub-header-title-bc">

					<?php if ( $swm_sub_header_title_position == 'title-right-bc-left' ) { ?>
						<?php if ( $swm_sub_header_breadcrumb_on == 'on' ) { ?>
							<div class="swm-sub-header-breadcrumbs swm-hide-<?php echo swm_get_option( 'swm_breadcrumbs_hide_device'); ?>">
								<?php echo swm_breadcrumb_trail(); ?>
							</div>
						<?php } ?>
						<?php echo swm_main_titles(); ?>
					<?php } else { ?>
						<?php echo swm_main_titles(); ?>
						<?php if ( $swm_sub_header_breadcrumb_on == 'on' ) { ?>
							<div class="swm-sub-header-breadcrumbs swm-hide-<?php echo swm_get_option( 'swm_breadcrumbs_hide_device'); ?>">
								<?php echo swm_breadcrumb_trail(); ?>
							</div>
						<?php } ?>
					<?php } ?>
					<div class="clear"></div>
				</div>

			</div>
		</div> <!-- #swm-sub-header -->
	<?php

	}

}