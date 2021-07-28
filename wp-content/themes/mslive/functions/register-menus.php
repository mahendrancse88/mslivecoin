<?php

/* **************************************************************************************
	Register WordPress Menus
************************************************************************************** */

if ( ! function_exists('swm_register_menu')) {
	function swm_register_menu() {
		register_nav_menus(array(
			'primary' => esc_html__('Main Navigation', 'bizix'),
			'topbar_left' => esc_html__('Topbar Left', 'bizix'),
			'topbar_right' => esc_html__('Topbar Right', 'bizix'),
			'footer' => esc_html__('Footer Menu', 'bizix')
		));
	}
	add_action( 'init' , 'swm_register_menu' );
}

if ( ! function_exists('swm_primary_nav')) {
	function swm_primary_nav() {

		wp_nav_menu( array(
			'theme_location' => 'primary',
			'sort_column' => 'menu_order',
			'container' =>false,
			'menu_class' => 'swm-primary-nav',
			'menu_id' => 'swm-primary-nav',
			'echo' => true,
			'before' => '',
			'after' => '',
			'link_before' => '',
			'link_after' => '',
			'depth' => 0,
			'fallback_cb' => 'swm_default_topmenu',
			'walker' => new Swm_Mega_Menu_Walker
		) );

	}
}

// fallback function

if ( ! function_exists('swm_default_topmenu')) {
	function swm_default_topmenu() {
		echo '<ul class="swm-menu-setting-msg"><li>Assign Menu from Admin > Appearance > Menus > Manage Locations > Top Navigation</li></ul>';
	}
}

if ( ! function_exists('swm_topbar_left')) {
	function swm_topbar_left() {

		wp_nav_menu( array(
			'theme_location' => 'topbar_left',
			'sort_column' => 'menu_order',
			'container' =>false,
			'menu_class' => 'swm_tb_left',
			'menu_id' => 'swm_tb_left',
			'echo' => true,
			'before' => '',
			'after' => '',
			'link_before' => '<span>',
			'link_after' => '</span>',
			'depth' => 0,
			'fallback_cb' => '',
			'walker' => new Swm_Mega_Menu_Walker
		) );

	}
}

if ( ! function_exists('swm_topbar-content')) {
	function swm_topbar_content() {

		wp_nav_menu( array(
			'theme_location' => 'topbar_right',
			'sort_column' => 'menu_order',
			'container' =>false,
			'menu_class' => 'swm_tb_right',
			'menu_id' => 'swm_tb_right',
			'echo' => true,
			'before' => '',
			'after' => '',
			'link_before' => '<span>',
			'link_after' => '</span>',
			'depth' => 0,
			'fallback_cb' => '',
			'walker' => new Swm_Mega_Menu_Walker
		) );

	}
}

if ( ! function_exists('swm_footer-menu')) {
	function swm_footer_menu() {
		$swm_get_contact_footer_menu = wp_nav_menu( array(
			'theme_location' => 'footer',
			'sort_column' => 'menu_order',
			'container' =>false,
			'menu_class' => 'footer_menu',
			'menu_id' => 'footer_menu',
			'echo' => false,
			'before' => '',
			'after' => '',
			'link_before' => '',
			'link_after' => '',
			'depth' => 1,
			'fallback_cb' => '',
			'walker' => new Swm_Mega_Menu_Walker
		) );

	return $swm_get_contact_footer_menu;
	}
}

/* **************************************************************************************
	Add Active link custom class
************************************************************************************** */

add_filter('nav_menu_css_class', 'swm_add_active_class', 10, 2 );

if ( ! function_exists('swm_add_active_class')) {
	function swm_add_active_class($classes, $item) {

		if( $item->menu_item_parent == 0 &&
			in_array( 'current-menu-item', $classes ) ||
			in_array( 'current-menu-ancestor', $classes ) ||
			in_array( 'current-menu-parent', $classes ) ||
			in_array( 'current_page_parent', $classes ) ||
			in_array( 'current_page_ancestor', $classes ) ) {
	    	$classes[] = "swm-m-active";
	  	}

	  	return $classes;
	}
}