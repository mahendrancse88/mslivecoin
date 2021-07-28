<?php if (function_exists('rwmb_meta')) {

	// Enqueue slider scripts.
	swm_enqueue_flexslider();

	$swm_meta_content_layout = '';
	$swm_blog_page_layout = swm_get_option( 'swm_blog_page_layout','layout-sidebar-right');

	if (function_exists('rwmb_meta')) {
		$swm_meta_content_layout = rwmb_meta('swm_meta_content_layout');
	}

	if ( $swm_blog_page_layout == 'layout-full-width' || $swm_blog_page_layout == 'layout-full-screen' ) {
		$swm_image_size_type = 'swm_image_size_post_fullwidth';
	} else {
		$swm_image_size_type = 'swm_image_size_post';
	}

	if ( is_single() ) {
		$swm_PostLinkStart = '';
		$swm_PostLinkEnd = '';

		if ( is_single() ) {
			if ( $swm_meta_content_layout != '' && $swm_meta_content_layout == 'layout-full-width' || $swm_blog_page_layout == 'layout-full-screen') {
				$swm_image_size_type = 'swm_image_size_post_fullwidth';
			} else {
				$swm_image_size_type = 'swm_image_size_post';
			}
		}

	} else {
		$swm_PostLinkStart = '<a href="'.get_permalink().'" title="' . esc_attr( get_the_title() ) . '">';
		$swm_PostLinkEnd = '</a>';
	}

	$swm_meta_pf_gallery_images = rwmb_meta('swm_meta_pf_gallery_images', 'type=image_advanced&size='.$swm_image_size_type.'' );

	if ( $swm_meta_pf_gallery_images ) { ?>
		<div class="swm-post-image">
			<div class="swm-post-format">
				<div class="swm-slider-box">
					<div class="flexslider pfi-gallery" data-pfGalleryId="<?php echo get_the_ID(); ?>" id="swm-pf-gallery-<?php echo get_the_ID(); ?>">
						<ul class="slides">
							<?php
						    foreach ( $swm_meta_pf_gallery_images as $swm_meta_pf_gallery_image ) {

						    	echo "<li>" . $swm_PostLinkStart .
										"<img src='{$swm_meta_pf_gallery_image['url']}' width='{$swm_meta_pf_gallery_image['width']}' height='{$swm_meta_pf_gallery_image['height']}' alt='{$swm_meta_pf_gallery_image['alt']}' />
										" . $swm_PostLinkEnd . "</li>";
							}
							?>
						</ul>
						<div class="clear"></div>
			    	</div>
		    	</div>
		   	</div>
		   	<div class="clear"></div>
		</div>
	<?php }

}