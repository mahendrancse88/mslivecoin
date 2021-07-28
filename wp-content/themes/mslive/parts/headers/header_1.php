<div class="swm-header header_1s" id="swm-header">
		<div class="swm-header-container-wrap" id="swm-main-nav-holder" data-sticky-hide="<?php echo swm_get_option('swm_sticky_hide_resolution',768);?>">
			<div class="swm-container header-main" >

				<div class="swm-header-logo-section">
					<?php get_template_part('parts/headers/header-logo'); ?>
				</div>

				<?php
				$swm_header_button_link_target = ( swm_get_option('swm_header_button_link_target','on') == 'off') ? '_self' : '_blank';

				if ( swm_get_option('swm_header_button_on','off') == 'on' || swm_get_option('swm_header_search_on','on') == 'on' || swm_get_option('swm_sidepanel_on','off') == 'on' ) { ?>

					<div class="swm-header-button-search">

						<?php if ( swm_get_option('swm_header_search_on','on') == 'on' ) { ?>
							<div class="swm-header-search">
								<span class="swm-transition"><i class="fas fa-search"></i></span>
							</div>
						<?php } ?>

						<?php if ( swm_get_option('swm_sidepanel_on','off') == 'on') { ?>

							<div id="swm-sidepanel-trigger" class="swm-sidepanel-trigger <?php echo swm_get_option('swm_sidepanel_icon_style','s_one'); ?>">
								<div class="swm-sidepanel-trigger-wrap">
									<div class="swm-sp-icon-box swm-transition">
										<div class="swm-sp-icon-inner swm-transition"><span class="swm-transition"></span></div>
									</div>
								</div>
							</div>

						<?php } ?>

						<?php if ( swm_get_option('swm_header_button_on','off') == 'on') {
									$swm_header_button_text = esc_html(swm_get_option('swm_header_button_text','Get A Quote'));
									$swm_header_button_text = swm_translate_theme_mod( 'swm_header_button_text', $swm_header_button_text );
							?>
							<div class="swm-header-button-wrap swm-hide-<?php echo swm_get_option( 'swm_header_button_hide_device'); ?>">
								<div class="swm-header-button swm-css-transition swm-heading-text"><a href="<?php echo swm_get_option('swm_header_button_link','#'); ?>" target="<?php echo $swm_header_button_link_target; ?>"><?php echo $swm_header_button_text;?></a></div>
							</div>
						<?php } ?>
					</div>
				<?php } ?>

				<div class="swm-header-menu-section-wrap">
					<div class="swm-header-menu-section" id="swm-primary-navigation">

						<div class="swm-main-nav">

							<div id="swm-mobi-nav-icon">
								<div id="swm-mobi-nav-btn"><span class="swm-mobi-nav-btn-box"><span class="swm-transition"><span class="swm-transition"></span></span></span></div>
								<div class="clear"></div>
							</div>

							<div class="swm-primary-nav-wrap">
								<?php swm_primary_nav(); ?>
							</div>
							<div class="clear"></div>

						</div>
						<div class="clear"></div>

					</div>  <!-- swm-header-menu-section -->
				</div>

				<div class="clear"></div>

				<div id="swm-mobi-nav">
					<span class="swm-mobi-nav-close"></span>
					<div class="clear"></div>
				</div>
				<div id="swm-mobi-nav-overlay-bg" class="swm-css-transition"></div>

			</div>   <!-- swm-container -->

		</div> <!-- swm-header-container-wrap -->

</div> <!-- .swm-header -->