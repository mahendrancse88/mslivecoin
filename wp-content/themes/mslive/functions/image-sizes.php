<?php
if (!function_exists('swm_image_sizes')) {
	function swm_image_sizes() {

		$swm_featured_img_height           = intval(swm_get_option('swm_featured_img_height','580' ));
		$swm_featured_fullwidth_img_height = intval(swm_get_option('swm_featured_fullwidth_img_height','580' ));
		$swm_layout_max_width              = intval(swm_get_option('swm_layout_max_width','1200' ));

		add_image_size('swm_image_size_post',850,$swm_featured_img_height,true);
		add_image_size('swm_image_size_post_fullwidth',$swm_layout_max_width,$swm_featured_fullwidth_img_height,true);
		add_image_size('swm_image_size_post_grid',670,480, true);
		add_image_size('swm_image_size_post_tiny',90,90, true);
		add_image_size('swm_image_size_post_tiny_alt',100,70, true);
		add_image_size('swm_image_size_related_posts',500,344, true);
		add_image_size('swm_image_size_standard',670,9999999999, true);
		add_image_size('swm_image_size_square',670,670, true);

	}
}

add_action( 'init', 'swm_image_sizes' );