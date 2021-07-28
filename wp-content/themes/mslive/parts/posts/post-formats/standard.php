<?php if ( has_post_thumbnail() ) {

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

	?>
	<div class="swm-post-image">
		<div class="swm-post-format">
			<figure>
				<?php
				echo $swm_PostLinkStart . get_the_post_thumbnail(get_the_ID(), $swm_image_size_type ) . $swm_PostLinkEnd;
				?>
			</figure>
			<div class="clear"></div>
		</div>
	</div>
<?php } ?>