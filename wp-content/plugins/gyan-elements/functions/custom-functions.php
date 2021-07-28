<?php

add_filter( 'http_request_timeout', 'sar_custom_http_request_timeout', 9999 );
function sar_custom_http_request_timeout( $timeout_value ) {
	return 300; // 30 seconds. Too much for production, only for testing.
}
/* ----------------------------------------------------------------------------------------
	Customizer Options List
---------------------------------------------------------------------------------------- */

function gyan_customizer_options_list() {

  	$gyan_theme_options_list = array(
  		'swm_icon10_url' => '#'
  	);
	return apply_filters( 'gyan_customizer_options_list', $gyan_theme_options_list );

}

/* ----------------------------------------------------------------------------------------
	Singular Pagination Fix
---------------------------------------------------------------------------------------- */

function gyan_singular_pagination_fix( $redirect_url ) {
	if ( is_paged() && is_singular() ) {
		$redirect_url = false;
	}
	return $redirect_url;
}
add_filter( 'redirect_canonical', 'gyan_singular_pagination_fix' );

/* ----------------------------------------------------------------------------------------
	KSES allowed tags
---------------------------------------------------------------------------------------- */

if (!function_exists('gyan_kses_allowed_textarea')) {
	function gyan_kses_allowed_textarea() {

		$output = '';

		$gyan_allowed_attr = array( 'class' => true,'style' => true,'id'=> true );

		$output = array(
		    'a' => array(
		        'href' => true,
		        'title' => true,
		        'class' => true,
		        'style' => true,
		        'target' => true,
		        'data-filter' => true,
		        'rel' => true
		    ),
		    'abbr' => array(
		        'title' => true,
		    ),
		    'acronym' => array(
		        'title' => true,
		    ),
		    'b' => array(),
		    'blockquote' => array(
		        'cite' => true,
		        'class' => true,
		        'style' => true,
		        'id'=> true
		    ),
		    'cite' => $gyan_allowed_attr,
		    'code' => array(),
		    'del' => array(
		        'datetime' => true,
		    ),
		    'em' => $gyan_allowed_attr,
		    'i' => $gyan_allowed_attr,
		    'q' => array(
		        'cite' => true,
		    ),
		    'iframe' => array(
		    	'class' => true,
		    	'style' => true,
		    	'id'=> true,
				'src' => true,
				'title' => true,
				'byline' => true,
				'portrait' => true,
				'color' => true,
				'width' => true,
				'height' => true,
				'frameborder' => true,
				'webkitAllowFullScreen' => true,
				'mozallowfullscreen' => true,
				'allowFullScreen' => true,
				'allowfullscreen' => true,
			),
		    'strike' => array(),
		    'strong' => array(),
		    'h1' => $gyan_allowed_attr,
		    'h2' => $gyan_allowed_attr,
		    'h3' => $gyan_allowed_attr,
		    'h4' => $gyan_allowed_attr,
		    'h5' => $gyan_allowed_attr,
		    'h6' => $gyan_allowed_attr,
		    'p' => $gyan_allowed_attr,
		    'ul' => $gyan_allowed_attr,
		    'ol' => $gyan_allowed_attr,
		    'li' => $gyan_allowed_attr,
		    'div' => $gyan_allowed_attr,
		    'span' => $gyan_allowed_attr,
		    'small' => $gyan_allowed_attr,
		    'br' => $gyan_allowed_attr,
		    'img' => array(
		        'src' => true,
		        'class' => true,
		        'style' => true,
		        'id'=> true,
		        'alt'=> true,
		        'title'=> true
		    	)
			);

		return apply_filters( 'gyan_kses_allowed_textarea', $output );
	}
}

// KSES for title or short sentenses ----------------------------------------------------------------------------------------


if (!function_exists('gyan_kses_allowed_text')) {
	function gyan_kses_allowed_text() {

		$output = '';

		$gyan_allowed_attr = array( 'class' => true,'style' => true,'id'=> true );

		$output = array(
		    'a' => array(
		        'href' => true,
		        'title' => true,
		        'class' => true,
		        'style' => true
		    ),
		    'abbr' => array(
		        'title' => true,
		    ),
		    'b' => $gyan_allowed_attr,
		    'cite' => $gyan_allowed_attr,
		    'em' => $gyan_allowed_attr,
		    'i' => $gyan_allowed_attr,
		    'strike' => array(),
		    'strong' => array(),
		    'span' => $gyan_allowed_attr,
		    'small' => $gyan_allowed_attr,
		    'div' => $gyan_allowed_attr,
		    'br' => $gyan_allowed_attr
			);

		return apply_filters( 'gyan_kses_allowed_text', $output );
	}
}

/* ----------------------------------------------------------------------------------------
	Post Author Social Icons : Admin > Users > User Profile page > Contact Info
---------------------------------------------------------------------------------------- */

if (!function_exists('gyan_author_social_icons')) {
	function gyan_author_social_icons( $contactmethods ) {

	$contactmethods['author-subtitle'] = esc_html__( 'Author Job Title', 'gyan-elements' );
	$contactmethods['facebook-f'] = esc_html__( 'Facebook URL', 'gyan-elements' );
	$contactmethods['twitter'] = esc_html__( 'Twitter URL', 'gyan-elements' );
	$contactmethods['google-plus'] = esc_html__( 'Google Plus URL', 'gyan-elements' );
	$contactmethods['pinterest'] = esc_html__( 'Pinterest URL', 'gyan-elements' );
	$contactmethods['linkedin-in'] = esc_html__( 'LinkedIn URL', 'gyan-elements' );
	$contactmethods['instagram'] = esc_html__( 'Instagram URL', 'gyan-elements' );
	$contactmethods['tumblr'] = esc_html__( 'Tumblr URL', 'gyan-elements' );
	$contactmethods['delicious'] = esc_html__( 'Delicious URL', 'gyan-elements' );
	$contactmethods['vimeo'] = esc_html__( 'Vimeo URL', 'gyan-elements' );
	$contactmethods['youtube-play'] = esc_html__( 'YouTube URL', 'gyan-elements' );

	return $contactmethods;

	}

	add_filter('user_contactmethods','gyan_author_social_icons',10,1);
}

/* ----------------------------------------------------------------------------------------
	Social Media Meta
---------------------------------------------------------------------------------------- */

function gyan_og_excerpt($text, $excerpt){
	if ($excerpt) { return $excerpt; }
	$text = strip_shortcodes( $text );
	$text = apply_filters('the_content', $text);
	$text = str_replace(']]>', ']]&gt;', $text);
	$text = strip_tags($text);
	$excerpt_length = apply_filters('excerpt_length', 60);
	$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
	$words = preg_split("/[n
	]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);

	if ( count($words) > $excerpt_length ) {
		array_pop($words);
		$text = implode(' ', $words);
		$text = $text . $excerpt_more;
	} else {
		$text = implode(' ', $words);
	}
	return apply_filters('wp_trim_excerpt', $text);
}

/* ----------------------------------------------------------------------------------------
	Social Media Share Buttons
---------------------------------------------------------------------------------------- */

if ( !function_exists( 'gyan_post_share_icons' ) ) {
	function gyan_post_share_icons( $postid=false ) {

		if ( post_password_required() ) return;

		global $post;
		$postid = $postid ? $postid :$post->ID;
		if (!$postid) return;

		$gyan_psi_source = esc_url(home_url('/'));
		$gyan_psi_url = get_permalink($postid);
		$gyan_psi_url = urlencode( $gyan_psi_url );
		$gyan_psi_title = esc_attr( the_title_attribute( 'echo=0' ) );
		$gyan_psi_summary = substr(get_the_excerpt(), 0,120);
		$gyan_psi_img = wp_get_attachment_url( get_post_thumbnail_id($postid) );

		$output = '';

		$output .= '<div class="gyan-post-share-links gyan-share-id-box-'.$postid.'">';
		$output .= '<ul class="gyan-post-share-icons-list">';

		$output .= '<li class="s-twitter"><a href="http://twitter.com/share?text='. urlencode($gyan_psi_title) .'&amp;url='. $gyan_psi_url .'" target="_blank" title="'. esc_attr__( 'Share on Twitter', 'gyan-elements' ) .'" class="tipUp"><i class="fab fa-twitter"></i></a></li>';

		$output .= '<li class="s-facebook"><a href="http://www.facebook.com/share.php?u='.$gyan_psi_url.'&amp;t='. urlencode($gyan_psi_title) .'" target="_blank" title="'. esc_attr__( 'Share on Facebook', 'gyan-elements' ) .'" class="tipUp"><i class="fab fa-facebook"></i></a></li>';

		$output .= '<li class="s-pinterest"><a href="http://pinterest.com/pin/create/button/?url='. $gyan_psi_url .'&amp;media='. $gyan_psi_img .'&amp;description='. urlencode($gyan_psi_summary) .'" target="_blank" title="'. esc_attr__( 'Share on Pinterest', 'gyan-elements' ) .'" class="tipUp"><i class="fab fa-pinterest"></i></a></li>';

		$output .= '<li class="s-linkedin"><a title="'. esc_attr__( 'Share on LinkedIn', 'gyan-elements' ) .'" rel="external" href="http://www.linkedin.com/shareArticle?mini=true&amp;url='. $gyan_psi_url .'&amp;title='. urlencode($gyan_psi_title) .'&amp;summary='. urlencode($gyan_psi_summary) .'&amp;source='. $gyan_psi_source .'" target="_blank" class="tipUp"><i class="fab fa-linkedin"></i></a></li>';

		$output .= '<li class="s-tumblr"><a title="'. esc_attr__( 'Share on Tumblr', 'gyan-elements' ) .'" rel="external" href="http://www.tumblr.com/share/link?url='. $gyan_psi_url .'&amp;name='. urlencode($gyan_psi_title) .'&amp;description='. urlencode($gyan_psi_summary) .'" target="_blank" class="tipUp"><i class="fab fa-tumblr"></i></a></li>';

		$output .= '</ul>';
		$output .= '<div class="clear"></div>';
		$output .= '</div>';

		return apply_filters( 'gyan_post_share_icons', $output );

	}
}

/* ----------------------------------------------------------------------------------------
	Register Custom Widget
---------------------------------------------------------------------------------------- */

function gyan_custom_widgets_list() {

	// Define widgets
	$widgets = array(
		'recent-posts' => 'GyanRecentPostsWidget',
		'contact'      => 'GyanContactWidget',
		'social'       => 'GyanCompanyInfoWidget',
		'useful-links' => 'GyanUsefulLinksWidget',
		'posts-slider' => 'GyanPostsSliderWidget'
	);

	return apply_filters( 'gyan_custom_widgets_list', $widgets );

}

function gyan_register_custom_widgets() {

	if ( get_option('swm_enable_theme_widgets',true) ) {

		// Get array of custom widgets
		$widgets = gyan_custom_widgets_list();

		// Loop through array and register the custom widgets
		if ( $widgets && is_array( $widgets ) ) {
			foreach ( $widgets as $widget ) {
				$file = GYAN_WIDGET_DIR . $widget . '.php';
				if ( file_exists ( $file ) ) {
					require_once $file;
				}
			}
		}

	}

}
add_action( 'widgets_init', 'gyan_register_custom_widgets' );

/* ----------------------------------------------------------------------------------------
Enable SVG File Upload
---------------------------------------------------------------------------------------- */

function gyan_mime_types($mimes) {
 	$mimes['svg'] = 'image/svg+xml';
 	return $mimes;
}
add_filter('upload_mimes', 'gyan_mime_types');

/* ----------------------------------------------------------------------------------------
	Get Ajax URL
---------------------------------------------------------------------------------------- */

function gyan_get_current_page_url() {

	if ( is_front_page() ) {
		$current_url = home_url( '/' );
	} else {
		$http_host   = sanitize_text_field( $_SERVER['HTTP_HOST'] );
		$request_uri = sanitize_text_field( $_SERVER['REQUEST_URI'] );
		$current_url = set_url_scheme( 'http://' . $http_host . untrailingslashit( $request_uri ) );
	}

	return apply_filters( 'gyan_get_current_page_url', $current_url );
}

function gyan_get_ajax_url() {
	$scheme = defined( 'FORCE_SSL_ADMIN' ) && FORCE_SSL_ADMIN ? 'https' : 'admin';

	$current_url = gyan_get_current_page_url();
	$ajax_url    = admin_url( 'admin-ajax.php', $scheme );

	if ( preg_match( '/^https/', $current_url ) && ! preg_match( '/^https/', $ajax_url ) ) {
		$ajax_url = preg_replace( '/^http/', 'https', $ajax_url );
	}

	return apply_filters( 'gyan_ajax_url', $ajax_url );
}