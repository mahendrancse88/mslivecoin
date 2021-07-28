<?php
if ( swm_get_option( 'swm_header_contact_info_on','on' ) == 'on' ) {
	$swm_cih_call = esc_html(swm_get_option('swm_cih_call', '+1 (888) 456 7890' ));
	$swm_cih_call = swm_translate_theme_mod( 'swm_cih_call', $swm_cih_call );

	$swm_cih_email = sanitize_email(swm_get_option('swm_cih_email', 'info@example.com' ));
	$swm_cih_email = swm_translate_theme_mod( 'swm_cih_email', $swm_cih_email );

	$swm_cih_address = esc_html(swm_get_option('swm_cih_address', '65 St. Road, NY USA' ));
	$swm_cih_address = swm_translate_theme_mod( 'swm_cih_address', $swm_cih_address );

	$swm_cih_call_s_title = esc_html(swm_get_option('swm_cih_call_s_title', 'Call Us Now' ));
	$swm_cih_call_s_title = swm_translate_theme_mod( 'swm_cih_call_s_title', $swm_cih_call_s_title );

	$swm_cih_email_s_title = esc_html(swm_get_option('swm_cih_email_s_title', 'Drop Us a Line' ));
	$swm_cih_email_s_title = swm_translate_theme_mod( 'swm_cih_email_s_title', $swm_cih_email_s_title );

	$swm_cih_address_s_title = esc_html(swm_get_option('swm_cih_address_s_title','Get Direction'));
	$swm_cih_address_s_title = swm_translate_theme_mod( 'swm_cih_address_s_title', $swm_cih_address_s_title );

	$swm_cih_social_icons_on = swm_get_option('swm_cih_social_icons_on','on' );
	?>

	<div class="swm_header_contact_info swm-hide-<?php echo swm_get_option( 'swm_header_contactinfo_hide_device'); ?>">
		<ul class="swm_header_contact_info_list">

			<?php if ( $swm_cih_call != '') { ?>
				<li class="swm-header-cinfo-column col_first">
					<span class="swm-cih-icon"><i class="swm-cih-icon swm-fi-phone-call"></i></span>
					<span class="swm-cih-call swm-cih-title swm-heading-text"><a href="tel:<?php echo $swm_cih_call; ?>"><?php echo $swm_cih_call; ?></a></span>
					<span class="swm-cih-subtitle"><?php echo $swm_cih_call_s_title; ?></span>
				</li>
			<?php } ?>

			<?php if ( $swm_cih_email != '') { ?>
				<li class="swm-header-cinfo-column">
					<span class="swm-cih-icon"><i class="swm-cih-icon swm-fi-envelope"></i></span>
					<span class="swm-cih-email swm-cih-title swm-heading-text"><a href="mailto:<?php echo antispambot($swm_cih_email,1); ?>"><?php echo $swm_cih_email; ?></a></span>
					<span class="swm-cih-subtitle"><?php echo $swm_cih_email_s_title; ?></span>
				</li>
			<?php } ?>

			<?php if ( $swm_cih_address != '') { ?>
				<li class="swm-header-cinfo-column col_last">
					<span class="swm-cih-icon"><i class="swm-cih-icon swm-fi-placeholder"></i></span>
					<span class="swm-cih-address swm-cih-title swm-heading-text"><?php echo $swm_cih_address; ?></span>
					<span class="swm-cih-subtitle"><?php echo $swm_cih_address_s_title; ?></span>
				</li>
			<?php } ?>

		</ul>

		<?php if ( $swm_cih_social_icons_on == 'on' ) { ?>
			<ul class="swm-header-socials">
				<?php swm_display_social_media(); ?>
			</ul>
		<?php } ?>

	</div>

<?php } ?>