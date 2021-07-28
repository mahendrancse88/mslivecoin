<?php
if (function_exists('rwmb_meta')) {

	$swm_pf_meta_audio = rwmb_meta('swm_meta_audio');

	if( !empty( $swm_pf_meta_audio ) ) { ?>
		<div class="swm-post-image">
			<div class="swm-post-format">
				<div class="fitVids swm_pf_type_audio">
					<?php echo stripslashes(wp_specialchars_decode($swm_pf_meta_audio)); ?>
					<div class="clear"></div>
				</div>
			</div>
		</div>
	<?php
	}
}