<?php
add_theme_support( 'post-thumbnails' );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'post-formats', array( 'audio','gallery','video') );
add_theme_support('customize-selective-refresh-widgets');
add_post_type_support('page', 'excerpt');
add_editor_style();

if ( ! isset( $content_width ) )  { $content_width = 960; }

if (!function_exists('swm_tag_cloud_fonts')) {
  function swm_tag_cloud_fonts($args = array()) {
     $args['smallest'] = 13;
     $args['largest'] = 13;
     $args['unit'] = 'px';
     return $args;
  }
}

add_filter('widget_tag_cloud_args', 'swm_tag_cloud_fonts', 90);