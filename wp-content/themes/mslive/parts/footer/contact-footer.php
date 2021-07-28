<?php

$swm_cf_address = esc_html(swm_get_option('swm_cf_address', '65 St. Road, NY USA'));
$swm_cf_address = swm_translate_theme_mod( 'swm_cf_address', $swm_cf_address );

$swm_cf_call = esc_html(swm_get_option('swm_cf_call','+1 (888) 456 7890'));
$swm_cf_call = swm_translate_theme_mod( 'swm_cf_call', $swm_cf_call );

$swm_cf_email = sanitize_email(swm_get_option('swm_cf_email','info@example.com'));
$swm_cf_email = swm_translate_theme_mod( 'swm_cf_email', $swm_cf_email );

$swm_cf_email_s_title = esc_html(swm_get_option('swm_cf_email_s_title','Drop Us a Line'));
$swm_cf_email_s_title = swm_translate_theme_mod( 'swm_cf_email_s_title', $swm_cf_email_s_title );

$swm_cf_call_s_title = esc_html(swm_get_option('swm_cf_call_s_title','Call Us Now'));
$swm_cf_call_s_title = swm_translate_theme_mod( 'swm_cf_call_s_title', $swm_cf_call_s_title );

$swm_cf_address_s_title = esc_html(swm_get_option('swm_cf_address_s_title','Get Direction'));
$swm_cf_address_s_title = swm_translate_theme_mod( 'swm_cf_address_s_title', $swm_cf_address_s_title );

$swm_s_footer_s_icons_on = swm_get_option('swm_s_footer_s_icons_on','on');
?>

<div class="swm_contact_footer">
	<div class="swm-container">
		<div class="swm_contact_footer_holder swm-row">

			<?php if ( $swm_cf_email != '') { ?>
				<div class="swm-column swm-column<?php echo intval(swm_get_option('swm_cf_column','3')); ?> swm-cf-column">
					<span class="swm_cf_email swm-cf-title swm-heading-text"><a href="mailto:<?php
					echo antispambot($swm_cf_email,1); ?>"><?php echo esc_html($swm_cf_email); ?></a></span>
					<span class="swm-cf-subtitle"><?php echo $swm_cf_email_s_title; ?></span>
				</div>
			<?php } ?>

			<?php if ( $swm_cf_call != '') { ?>
				<div class="swm-column swm-column<?php echo intval(swm_get_option('swm_cf_column','3')); ?> swm-cf-column swm-cf-m-column">
					<span class="swm_cf_call swm-cf-title swm-heading-text"><a href="tel:<?php echo $swm_cf_call; ?>"><?php echo $swm_cf_call; ?></a></span>
					<span class="swm-cf-subtitle"><?php echo $swm_cf_call_s_title; ?></span>
				</div>
			<?php } ?>

			<?php if ( $swm_cf_address != '') { ?>
				<div class="swm-column swm-column<?php echo intval(swm_get_option('swm_cf_column','3')); ?> swm-cf-column">
					<span class="swm_cf_address swm-cf-title swm-heading-text"><?php echo do_shortcode( wp_kses_post( $swm_cf_address ) ); ?></span>
					<span class="swm-cf-subtitle"><?php echo $swm_cf_address_s_title; ?></span>
				</div>
			<?php } ?>

			<div class="clear"></div>
		</div>
	</div>
</div>