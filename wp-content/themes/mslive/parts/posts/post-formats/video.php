<?php
if (function_exists('rwmb_meta')) {

	$swm_pf_meta_video = rwmb_meta('swm_meta_video');

	if( !empty( $swm_pf_meta_video ) ) { ?>
		<div class="swm-post-image">
			<div class="swm-post-format">
				<div class="fitVids">
					<?php echo stripslashes(wp_specialchars_decode($swm_pf_meta_video)); ?>
					<div class="clear"></div>
				</div>
			</div>
		</div>
	<?php
	}
}