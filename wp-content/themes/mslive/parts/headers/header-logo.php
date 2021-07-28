<?php
if ( swm_get_option('swm_header_logo_on','on') == 'on' ) {

	$swm_default_standard_logo = (swm_get_option('swm_logo_standard') <> '') ? esc_url(swm_get_option('swm_logo_standard')) : get_template_directory_uri().'/images/logo.png';
	$swm_default_retina_logo = (swm_get_option('swm_logo_retina') <> '') ? esc_url(swm_get_option('swm_logo_retina')) : get_template_directory_uri().'/images/logo-retina.png';

	$swm_sticky_standard_logo = (swm_get_option('swm_sticky_logo_standard') <> '') ? esc_url(swm_get_option('swm_sticky_logo_standard')) : get_template_directory_uri().'/images/logo-sticky.png';
	$swm_sticky_retina_logo = (swm_get_option('swm_sticky_logo_retina') <> '') ? esc_url(swm_get_option('swm_sticky_logo_retina')) : get_template_directory_uri().'/images/logo-sticky-retina.png';

	if (isset($_COOKIE["pixel_ratio"])) {
	    $swm_pixel_ratio = $_COOKIE["pixel_ratio"];
	    $swm_logo = $swm_pixel_ratio > 1 ? $swm_default_retina_logo : $swm_default_standard_logo;
	    $swm_sticky_logo = $swm_pixel_ratio > 1 ? $swm_sticky_retina_logo : $swm_sticky_standard_logo;
	} else {
	    $swm_logo = $swm_default_standard_logo;
	    $swm_sticky_logo = $swm_sticky_standard_logo;
	}

	?>

	<div class="swm-logo">
		<a href="<?php echo esc_url(home_url( '/' )); ?>" title="<?php echo esc_attr(get_bloginfo('name')); ?>">
			<img class="swm-std-logo" width="<?php echo intval( swm_get_option('swm_logo_standard_width','126') ); ?>" height="<?php echo intval( swm_get_option('swm_logo_standard_height','') ); ?>" style="max-width:<?php echo intval( swm_get_option('swm_logo_standard_width','126') ); ?>px;" src="<?php echo esc_url($swm_logo); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" />
			<img class="swm-sticky-logo" style="max-width:<?php echo intval( swm_get_option('swm_logo_sticky_width','126') ); ?>px;" src="<?php echo esc_url($swm_sticky_logo); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" />
		</a>
		<div class="clear"></div>
	</div>
<?php
}