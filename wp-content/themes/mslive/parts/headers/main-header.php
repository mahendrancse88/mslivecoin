<header class="swm-all-header-wrapper">
	<div class="swm-main-container swm-header-main-container <?php echo swm_get_option( 'swm_header_style','header_1' ); ?> brd-<?php echo swm_get_option( 'swm_pr_menu_active_border_style','small' ); ?>">
		<?php
		if (swm_customizer_metabox_onoff('swm_main_header_on','swm_meta_main_header_on','on','default') == 'on' ) : ?>

			<?php
			if ( swm_get_option( 'swm_header_style','header_1' ) == 'header_1' || swm_get_option( 'swm_header_style','header_1' ) == 'header_1_t' ) {
				get_template_part('parts/headers/header_1');
			} else {
				get_template_part('parts/headers/header_2');
			}
			?>
			<div class="clear"></div>

			<?php
		endif; ?>

	</div>	<!-- swm-header-main-container -->
</header>