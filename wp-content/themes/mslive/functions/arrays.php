<?php

function swm_allowed_attr() {
	return array( 'class' => true,'style' => true,'id'=> true );
}

function swm_allowed_anchor_tag_attr() {
	return array(
        'href' => true,
        'title' => true,
        'class' => true,
        'style' => true,
        'target' => true,
        'data-filter' => true,
        'rel' => true
    );
}

function swm_on_off() {
	return array(
        'on'    => esc_html__( 'On', 'bizix' ),
        'off'   => esc_html__( 'Off', 'bizix' )
    );
}

function swm_text_transform() {
	return array(
        'none'          => esc_html__( 'None', 'bizix' ),
        'uppercase'     => esc_html__( 'Uppercase', 'bizix' ),
        'lowercase'     => esc_html__( 'Lowercase', 'bizix' )
    );
}

function swm_get_bg_img_styles() {
	return array(
		''             => esc_html__( 'Default', 'bizix' ),
		'cover'        => esc_html__( 'Cover', 'bizix' ),
		'stretched'    => esc_html__( 'Stretched', 'bizix' ),
		'repeat'       => esc_html__( 'Repeat', 'bizix' ),
		'fixed-top'    => esc_html__( 'Fixed Top', 'bizix' ),
		'fixed'        => esc_html__( 'Fixed Center', 'bizix' ),
		'fixed-bottom' => esc_html__( 'Fixed Bottom', 'bizix' ),
		'repeat-x'     => esc_html__( 'Repeat-x', 'bizix' ),
		'repeat-y'     => esc_html__( 'Repeat-y', 'bizix' ),
		'inherit'      => esc_html__( 'Inherit', 'bizix' ),
	);
}

function swm_default_on_off() {
	return array(
		"default" => esc_html__( 'Default', 'bizix' ),
		"on" => esc_html__( 'On', 'bizix' ),
		"off" => esc_html__( 'Off', 'bizix' )
	);
}

function swm_default_custom_on_off() {
	return array(
		"default" => esc_html__( 'Default', 'bizix' ),
		"custom" => esc_html__( 'Custom', 'bizix' ),
	);
}

function swm_content_padding_on_off() {
	return array(
		"default" => esc_html__( 'Default', 'bizix' ),
		"custom" => esc_html__( 'Custom', 'bizix' ),
		"no_padding" => esc_html__( 'No Padding', 'bizix' ),
	);
}

function swm_sub_header_title_options() {
	return array(
		"title-center"        => esc_html__( 'Title Center', 'bizix' ),
		"title-left"          => esc_html__( 'Title Left', 'bizix' ),
		"title-right"         => esc_html__( 'Title Right', 'bizix' ),
		"title-left-bc-right" => esc_html__( 'Title Left - Breadcrumbs Right', 'bizix' ),
		"title-right-bc-left" => esc_html__( 'Title Right - Breadcrumbs Left ', 'bizix' )
	);
}

function swm_header_display_style() {
	return array(
		"standard"          => esc_html__( 'Background Image', 'bizix' ),
		"revolution_slider" => esc_html__( 'Revolution Slider', 'bizix' )
    );
}

function swm_page_content_layout() {
	return array(
        "layout-sidebar-right"  => esc_html__( 'Content Left - Sidebar Right', 'bizix' ),
        "layout-sidebar-left"   => esc_html__( 'Content Right - Sidebar Left', 'bizix' ),
        "layout-full-width"     => esc_html__( 'No Sidebar', 'bizix' ),
        "layout-full-screen"    => esc_html__( '100% Width - Full Screen', 'bizix' )
     );
}

function boxed_layout_shadow() {
	return array(
        "no-shadow"     => esc_html__( 'No Shadow', 'bizix' ),
        "light-shadow"  => esc_html__( 'Light Shadow', 'bizix' ),
        "medium-shadow" => esc_html__( 'Medium Shadow', 'bizix' ),
        "dark-shadow"   => esc_html__( 'Dark Shadow', 'bizix' )
     );
}

function swm_contact_footer_column() {
	return array(
        "swm-column2" => "2",
        "swm-column3" => "3",
        "swm-column4" => "4"
    );
}

function swm_site_layout() {
	return array(
        "full-width" => "Full Width",
        "boxed" => "Boxed"
    );
}

function swm_post_order() {
	return array(
        "DESC" => "DESC",
        "ASC" => "ASC"
    );
}

function swm_main_header_display_options() {
	return array(
		"header_style_one"   => esc_html__( 'Style - 1: Logo Center, Menu Center', 'bizix' ),
		"header_style_two"   => esc_html__( 'Style - 2: Logo Left, Menu Left', 'bizix' ),
		"header_style_three" => esc_html__( 'Style - 3: Logo Left, Menu Left (Wide Menu)', 'bizix' ),
		"header_style_four"  => esc_html__( 'Style - 4: Logo Center, Menu Center (Wide Menu)', 'bizix' )
    );
}

function swm_border_styles() {
	return array(
		'solid'  => esc_html__( 'Solid', 'bizix' ),
		'dashed' => esc_html__( 'Dashed', 'bizix' ),
		'dotted' => esc_html__( 'Dotted', 'bizix' ),
		'double' => esc_html__( 'Double', 'bizix' ),
    );
}

function swm_hide_tablet_mobile() {
	return array(
		''       => esc_html__( 'Nothing', 'bizix' ),
		'tablet' => esc_html__( 'Tablet', 'bizix' ),
		'mobile' => esc_html__( 'Mobile', 'bizix' )
    );
}