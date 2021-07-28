<?php
if ( swm_customizer_metabox_onoff('swm_topbar_on','swm_meta_topbar_on','off','default') == 'on' ) { ?>
	<div class="swm-main-container swm-topbar-main-container swm-topbar swm-hide-<?php echo swm_get_option( 'swm_topbar_device'); ?>">
			<div class="swm-container">
				<div class="swm-topbar-content swm-css-transition">

					<div class="left">
						<?php swm_topbar_left(); ?>
					</div>

					<?php $swm_topbar_social_icon_status = ( swm_get_option( 'swm_topbar_social_on','on' ) == 'off' ) ? 'topbar_social_status_off' : ''; ?>

					<div class="right <?php echo $swm_topbar_social_icon_status; ?>">
						<?php swm_topbar_content(); ?>
						<?php if ( swm_get_option( 'swm_topbar_social_on','on' ) == 'on' ) { ?>
							<ul class="swm-topbar-socials">
								<?php swm_display_social_media(); ?>
							</ul>
							<div class="clear"></div>
						<?php } ?>
					</div>

					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>
	</div>
<?php }