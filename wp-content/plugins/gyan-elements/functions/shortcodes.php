<?php

/* **************************************************************************************
	DISPLAY SHORTCODES IN SIDEBAR, TEXT FIELDS, COMMENTS ETC.
************************************************************************************** */

add_filter( 'comment_text', 'shortcode_unautop');
add_filter( 'comment_text', 'do_shortcode' );

add_filter( 'the_excerpt', 'shortcode_unautop');
add_filter( 'the_excerpt', 'do_shortcode' );

add_filter( 'widget_text', 'shortcode_unautop');
add_filter( 'widget_text', 'do_shortcode');

add_filter( 'term_description', 'shortcode_unautop');
add_filter( 'term_description', 'do_shortcode' );

/* **************************************************************************************
     DISABLE WORDPRESS AUTOMATIC FORMATTING ON POSTS
************************************************************************************** */
if (!function_exists('gyan_sc_autop_fix')) {
	function gyan_sc_autop_fix($content) {
	    $array = array (
	        '<p>[' => '[',
	        ']</p>' => ']',
	        ']<br />' => ']'
	    );

	    $content = strtr($content, $array);

	    return $content;
	}
}
add_filter('the_content', 'gyan_sc_autop_fix');

/* **************************************************************************************
     OTHERS
************************************************************************************** */

if (!function_exists('gyan_break')) {
	function gyan_break( $atts, $content = null ) {
		return '<br />';
	} add_shortcode('break', 'gyan_break');
}

if (!function_exists('gyan_clear')) {
	function gyan_clear( $atts, $content = null ) {
		return '<div class="clear"></div>';
	} add_shortcode('clear', 'gyan_clear');
}

if (!function_exists('gyan_html_tags')) {
	function gyan_html_tags($atts, $content = null, $heading) {
		return '<'.$heading.'>' . do_shortcode($content) . '</'.$heading.'>';
	}

	$gyan_general_tags = array("p","div","span","sub","sup","small","h1","h2","h3","h4","h5","h6");

	foreach ($gyan_general_tags as $gyan_general_tag) {
		add_shortcode($gyan_general_tag, 'gyan_html_tags');
	}

}


if (!function_exists('fa_icon')) {
	function fa_icon($atts, $content = null) {

		extract( shortcode_atts( array (
			'id' => '',
			'class' => '',
			'style' => '',
			'icon_name' => 'fa-star'
			), $atts ) );

		$icon_name = preg_replace('/fa-/', '', $icon_name);

		$id     = ( $id    != '' ) ? 'id="' . esc_attr( $id ) . '"' : '';
		$class  = ( $class != '' ) ? 'class="fa fa-'.$icon_name.' ' . esc_attr( $class ) . '"' : 'class="fa fa-'.$icon_name.'"';
		$style  = ( $style != '' ) ? 'style="' . $style . '"' : '';

		return '<i '.$id.' '.$class.' '.$style.'></i>';
	}

	add_shortcode('fa_icon', 'fa_icon');
}
