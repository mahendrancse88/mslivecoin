<div class="swm-sidepanel-body-overlay"></div>
<div id="swm-sidepanel-container" class="swm-sidepanel">
	<div class="swm-sidepanel-wrap">

		<?php if ( swm_get_option('swm_close_icon_on','on') == 'on') { ?>

			<div id="swm-sidepanel-trigger-close" class="swm-sidepanel-close">
				<a href="#" class="swm-sidepanel-close-link swm-sidepanel-trigger"><i class="fas fa-times"></i></a>
			</div>

		<?php } ?>

		<?php
			if ( is_active_sidebar('swm-sidepanel-widgets') ){
				dynamic_sidebar('swm-sidepanel-widgets');
			}
		?>

	</div>
</div>