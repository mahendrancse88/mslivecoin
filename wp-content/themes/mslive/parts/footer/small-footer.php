<?php
$swm_small_footer_copyright = swm_get_option( 'swm_small_footer_copyright', 'Copyright 2020 Bizix, All rights reserved.' );
$swm_small_footer_copyright = swm_translate_theme_mod( 'swm_small_footer_copyright', $swm_small_footer_copyright ); ?>
<div class="swm-container">
	<div class="swm-small-footer">
		<?php echo wp_kses($swm_small_footer_copyright,swm_kses_allowed_textarea()); ?><?php echo swm_footer_menu(); ?>
	</div>
</div>