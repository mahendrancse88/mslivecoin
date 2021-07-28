<?php

if ( ! function_exists('swm_register_theme_widgets')) {
	function swm_register_theme_widgets() {

		register_sidebar( array(
			'name' => esc_html__('Blog Sidebar', 'bizix'),
			'id' => 'blog-sidebar',
			'description' => esc_html__('Sidebar for blog section', 'bizix'),
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="swm-sidebar-widget-box"><div class="swm-widget-content">',
			'after_widget' => '<div class="clear"></div></div></div></div>',
			'before_title' => '<div class="swm-sidebar-ttl"><h3><span>',
			'after_title' => '</span></h3><div class="clear"></div></div><div class="clear"></div>'
		));

		register_sidebar( array(
			'name' => esc_html__('Page Sidebar', 'bizix'),
			'id' => 'page-sidebar',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="swm-sidebar-widget-box"><div class="swm-widget-content">',
			'after_widget' => '<div class="clear"></div></div></div></div>',
			'before_title' => '<div class="swm-sidebar-ttl"><h3><span>',
			'after_title' => '</span></h3><div class="clear"></div></div><div class="clear"></div>'
		));

		register_sidebar( array(
			'name' => esc_html__('Side Panel', 'bizix'),
			'description' => esc_html__('Sidebar for right side hidden Side Panel. ', 'bizix'),
			'id' => 'swm-sidepanel-widgets',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="swm-sidepanel-widget-box"><div class="swm-widget-content">',
			'after_widget' => '<div class="clear"></div></div></div></div>',
			'before_title' => '<div class="swm-sidepanel-ttl"><h3><span>',
			'after_title' => '</span></h3><div class="clear"></div></div><div class="clear"></div>'
		));

		register_sidebar( array(
			'name' => esc_html__('Search Page Sidebar', 'bizix'),
			'id' => 'search-sidebar',
			'description' => esc_html__('Sidebar for search pages', 'bizix'),
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="swm-sidebar-widget-box"><div class="swm-widget-content">',
			'after_widget' => '<div class="clear"></div></div></div></div>',
			'before_title' => '<div class="swm-sidebar-ttl"><h3><span>',
			'after_title' => '</span></h3><div class="clear"></div></div><div class="clear"></div>'
		));

		register_sidebar( array(
			'name' => esc_html__('Footer Column 1', 'bizix'),
			'id' => 'swm-footer-1',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="swm-footer-widget"><div class="swm-widget-content">',
			'after_widget' => '<div class="clear"></div></div></div></div>',
			'before_title' => '<h3><span>',
			'after_title' => '</span></h3><div class="clear"></div>'
		));

		if ( swm_get_option( 'swm_widget_footer_column','col-4' ) != 'col-1' ) {

			register_sidebar( array(
				'name' => esc_html__('Footer Column 2', 'bizix'),
				'id' => 'swm-footer-2',
				'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="swm-footer-widget"><div class="swm-widget-content">',
				'after_widget' => '<div class="clear"></div></div></div></div>',
				'before_title' => '<h3><span>',
				'after_title' => '</span></h3><div class="clear"></div>'
			));

		}

		if ( swm_get_option( 'swm_widget_footer_column','col-4' ) != 'col-1' &
			swm_get_option( 'swm_widget_footer_column','col-4' ) != 'col-2' &
			swm_get_option( 'swm_widget_footer_column','col-4' ) != 'col-51-38-38-54-49' &
			swm_get_option( 'swm_widget_footer_column','col-4' ) != 'col-66-33' &
			swm_get_option( 'swm_widget_footer_column','col-4' ) != 'col-33-66' &
			swm_get_option( 'swm_widget_footer_column','col-4' ) != 'col-25-75' ) {

			register_sidebar( array(
				'name' => esc_html__('Footer Column 3', 'bizix'),
				'id' => 'swm-footer-3',
				'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="swm-footer-widget"><div class="swm-widget-content">',
				'after_widget' => '<div class="clear"></div></div></div></div>',
				'before_title' => '<h3><span>',
				'after_title' => '</span></h3><div class="clear"></div>'
			));

		}

		if ( swm_get_option( 'swm_widget_footer_column','col-4' ) == 'col-4' || swm_get_option( 'swm_widget_footer_column','col-4' ) == 'col-51-38-38-54-49' ) {

			register_sidebar( array(
				'name' => esc_html__('Footer Column 4', 'bizix'),
				'id' => 'swm-footer-4',
				'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="swm-footer-widget"><div class="swm-widget-content">',
				'after_widget' => '<div class="clear"></div></div></div></div>',
				'before_title' => '<h3><span>',
				'after_title' => '</span></h3><div class="clear"></div>'
			));

		}

		if ( swm_get_option( 'swm_widget_footer_column','col-4' ) == 'col-51-38-38-54-49' ) {

			register_sidebar( array(
				'name' => esc_html__('Footer Column 5', 'bizix'),
				'id' => 'swm-footer-5',
				'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="swm-footer-widget"><div class="swm-widget-content">',
				'after_widget' => '<div class="clear"></div></div></div></div>',
				'before_title' => '<h3><span>',
				'after_title' => '</span></h3><div class="clear"></div>'
			));

		}

	}
}

add_action( 'widgets_init', 'swm_register_theme_widgets' );