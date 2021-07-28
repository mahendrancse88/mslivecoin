<?php
// Customizer Partial Refresh Support.

defined( 'ABSPATH' ) || exit;

if ( ! isset( $wp_customize->selective_refresh ) ) {
	return; // Abort if selective refresh is not available.
}

// Footer Bottom.
// $wp_customize->selective_refresh->add_partial( 'footer_bottom', array(
// 	'selector'            => '#footer-bottom',
// 	'settings'            => array( 'bottom_footer_text_align', 'footer_copyright_text' ),
// 	'primarySetting'      => 'footer_bottom',
// 	'container_inclusive' => true,
// 	'render_callback'     => function() {
// 		wpex_get_template_part( 'footer_bottom' );
// 	},
// ) );

$wp_customize->selective_refresh->add_partial( 'swm_small_footer_copyright', array(
    'selector'            => '.swm-small-footer',
    'settings'            => array( 'swm_small_footer_copyright' ),
    'primarySetting'      => 'swm_small_footer_copyright',
    'container_inclusive' => true,
    'render_callback'     => function() {
        get_template_part('parts/footer/small-footer');
    },
) );

