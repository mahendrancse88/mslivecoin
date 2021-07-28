<?php
/* ----------------------------------------------------------------------------------------
	Page Title
---------------------------------------------------------------------------------------- */

if (!function_exists('swm_get_main_titles_text')) {
	function swm_get_main_titles_text() {

		global  $wp_query;
		$swm_main_title = '';


		if ( is_archive() ) {

			if ( is_day() ) {
				$swm_main_title = sprintf( esc_html__( 'Archive: %s', 'bizix' ), get_the_date() );
			}
			elseif ( is_month() ) {
				$swm_main_title = sprintf( esc_html__( 'Archive: %s', 'bizix' ), get_the_date('F Y') );
			}
			elseif ( is_year() ) {
				$swm_main_title = sprintf( esc_html__( 'Archive: %s', 'bizix' ), get_the_date('Y') );
			}
			elseif ( is_author() ) {
				$swm_main_title = esc_html__( 'Author Archives', 'bizix' );
			}
			elseif ( is_tag() || is_category() ) {
				$swm_main_title =  $wp_query->queried_object->name;
			}
			else {
				$swm_main_title = single_term_title( '', false );
			}
		}
		elseif ( is_404() ) {
			$swm_main_title = esc_html__( 'Error Page', 'bizix' );
		}
		elseif ( is_page_template('template-blog.php') ) {
			$swm_main_title = get_the_title();
		}
		elseif ( is_single() ) {

			$swm_get_post_type = get_post_type();

			if ( $swm_get_post_type == 'post' ) {
				$swm_main_title = swm_get_option('swm_blog_single_header_title','Blog');
				$swm_main_title = swm_translate_theme_mod( 'swm_blog_single_header_title', $swm_main_title );
			} else {
				$swm_main_title = get_the_title();
			}

		}
		elseif ( is_page() ) {
			$swm_main_title = get_the_title();
		}
		elseif ( is_search() ) {
			$swm_main_title = esc_html__( 'Search', 'bizix' );
		}
		elseif ( is_home() ) {
			$swm_main_title = esc_html__( 'Blog', 'bizix' );
		}

		return apply_filters( 'swm_get_main_titles_text', $swm_main_title );

	}

}

if (!function_exists('swm_main_titles')) {
	function swm_main_titles() {

		$output = '';
		$swm_get_main_titles_text = '';

		$swm_get_main_titles_text = swm_get_main_titles_text();

		if ( $swm_get_main_titles_text != '' ) {

			$swm_sub_header_title_on = swm_get_option('swm_sub_header_title_on','on');
			$swm_meta_sub_header_on = 'default';
			$swm_meta_sub_header_on = get_post_meta( swm_get_queried_object_id(), 'swm_meta_sub_header_on', true );

			if ( function_exists('rwmb_meta') && !is_search() && !empty( $swm_meta_sub_header_on ) && $swm_meta_sub_header_on != 'default' ) {
				$swm_sub_header_title_on = get_post_meta( swm_get_queried_object_id(), 'swm_meta_sub_header_title_on', true );
			}

			if ( $swm_sub_header_title_on == 'on' ) {

				if ( is_page() || is_archive() || is_home() || is_singular( array( 'portfolio' ) ) ) {
					$output = '<h1 class="swm-sub-header-title entry-title"><span>' . do_shortcode( wp_kses( $swm_get_main_titles_text,swm_kses_allowed_text() ) ) . '</span></h1><div class="clear"></div>';
				} else {
					$output = '<div class="swm-sub-header-title entry-title"><span>' . do_shortcode( wp_kses( $swm_get_main_titles_text,swm_kses_allowed_text() ) ) . '</span></div><div class="clear"></div>';
				}

			}

		}

		return $output;

	}
}

/* ----------------------------------------------------------------------------------------
	KSES allowed tags
---------------------------------------------------------------------------------------- */

if (!function_exists('swm_kses_allowed_textarea')) {
	function swm_kses_allowed_textarea() {

		$output = '';

		$output = array(
		    'a' => swm_allowed_anchor_tag_attr(),
		    'abbr' => array( 'title' => true ),
		    'acronym' => array('title' => true, ),
		    'b' => array(),
		    'blockquote' => array(	'cite' => true,
							        'class' => true,
							        'style' => true,
							        'id'=> true
							    ),
		    'cite' => swm_allowed_attr(),
		    'code' => array(),
		    'del' => array('datetime' => true, ),
		    'em' => swm_allowed_attr(),
		    'i' => swm_allowed_attr(),
		    'q' => array('cite' => true, ),
		    'iframe' => array( 	'class' => true,
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
								'allowfullscreen' => true
							),
		    'strike' => array(),
		    'strong' => array(),
		    'h1' => swm_allowed_attr(),
		    'h2' => swm_allowed_attr(),
		    'h3' => swm_allowed_attr(),
		    'h4' => swm_allowed_attr(),
		    'h5' => swm_allowed_attr(),
		    'h6' => swm_allowed_attr(),
		    'p' => swm_allowed_attr(),
		    'ul' => swm_allowed_attr(),
		    'ol' => swm_allowed_attr(),
		    'li' => swm_allowed_attr(),
		    'div' => swm_allowed_attr(),
		    'span' => swm_allowed_attr(),
		    'small' => swm_allowed_attr(),
		    'br' => swm_allowed_attr(),
		    'img' => array(
					        'src' => true,
					        'class' => true,
					        'style' => true,
					        'id'=> true,
					        'alt'=> true,
					        'title'=> true,
						     'width' => true,
						     'height'=> true
					    )
			);

		return apply_filters( 'swm_kses_allowed_textarea', $output );
	}
}

// KSES for title or short sentenses ----------------------------------------------------------------------------------------

if (!function_exists('swm_kses_allowed_text')) {
	function swm_kses_allowed_text() {

		$output = '';

		$output = array(
		    'a' => swm_allowed_anchor_tag_attr(),
		    'abbr' => array('title' => true, ),
		    'b' => swm_allowed_attr(),
		    'cite' => swm_allowed_attr(),
		    'em' => swm_allowed_attr(),
		    'i' => swm_allowed_attr(),
		    'strike' => array(),
		    'strong' => array(),
		    'span' => swm_allowed_attr(),
		    'small' => swm_allowed_attr(),
		    'div' => swm_allowed_attr(),
		    'br' => swm_allowed_attr()
			);

		return apply_filters( 'swm_kses_allowed_text', $output );
	}
}
/* ----------------------------------------------------------------------------------------
	Related Posts
---------------------------------------------------------------------------------------- */

if( ! function_exists( 'swm_get_related_posts' ) ) {
	function swm_get_related_posts( $post_id, $number_posts = -1 ) {

		$query = new WP_Query();
		$args = '';

		if( $number_posts == 0 ) {
			return $query;
		}

		$args = wp_parse_args( $args, array(
			'category__in'			=> wp_get_post_categories( $post_id ),
			'ignore_sticky_posts'	=> 0,
			'meta_key'				=> '_thumbnail_id',
			'posts_per_page'		=> $number_posts,
			'post__not_in'			=> array( $post_id ),
		));

		$query = new WP_Query( $args );

	  	return apply_filters( 'swm_get_related_posts', $query );

	}
}
/* ----------------------------------------------------------------------------------------
	EXCERPT LIMIT
---------------------------------------------------------------------------------------- */

if( ! function_exists( 'swm_excerpt_length' ) ) {
	function swm_excerpt_length( $length ) {
		return intval(swm_get_option('swm_excerpt_length',50));
	}
	add_filter( 'excerpt_length', 'swm_excerpt_length', 999 );
}

/* ----------------------------------------------------------------------------------------
	GET COMMENTS NUMBER
---------------------------------------------------------------------------------------- */

if( ! function_exists( 'swm_get_comments_number' ) ) {
	function swm_get_comments_number() {

		$swm_num_comments = get_comments_number();

		if ( $swm_num_comments == 0 ) {
			$output =  esc_html__('0 Comments','bizix');
		} elseif ( $swm_num_comments > 1 ) {
			$output =  $swm_num_comments . esc_html__(' Comments','bizix');
		} else {
			$output =  esc_html__('1 Comment','bizix');
		}

		echo apply_filters( 'swm_get_comments_number', $output );
	}
}

/* ----------------------------------------------------------------------------------------
	Pagination
---------------------------------------------------------------------------------------- */

// Standard Pagination (1,2,3,4)
if ( !function_exists( 'swm_standard_pagination' ) ) {
	function swm_standard_pagination($total=null) {

		$swm_prevOne = '<i class="fas fa-angle-double-left"></i> <span class="swm_pg_prev"></span>';
		$swm_prevTwo = '<i class="fas fa-angle-double-right"></i> <span class="swm_pg_prev"></span>';

		$swm_NextOne = '<span class="swm_pg_next"></span> <i class="fas fa-angle-double-right"></i>';
		$swm_NextTwo = '<span class="swm_pg_next"></span> <i class="fas fa-angle-double-left"></i>';

		$swm_arrowPrev = is_rtl() ? $swm_prevTwo : $swm_prevOne;
		$swm_arrowNext = is_rtl() ? $swm_NextTwo : $swm_NextOne;

		global $wp_query;

		$swm_total_page = $wp_query->max_num_pages;
		$swm_big_number = 999999999; // need an unlikely integer
		$output = '';

		if( $swm_total_page > 1 )  {
			$output .= '<div class="swm-pagination-wrap">';
			$output .= '<div class="swm-pagination">';

			 if( !$current_page = get_query_var('paged') )
				 $current_page = 1;
			 if( get_option('permalink_structure') ) {
				 $swm_pagination_format = 'page/%#%/';
			 } else {
				 $swm_pagination_format = '&paged=%#%';
			 }

			$output .= paginate_links(array(
				'base'			=> str_replace( $swm_big_number, '%#%', esc_url( get_pagenum_link( $swm_big_number ) ) ),
				'format'		=> $swm_pagination_format,
				'current'		=> max( 1, get_query_var('paged') ),
				'total' 		=> $swm_total_page,
				'mid_size'		=> 2,
				'show_all'		=> false,
				"add_args" 		=> false,
				'type' 			=> 'plain',
				'prev_text'		=> $swm_arrowPrev,
				'next_text'		=> $swm_arrowNext
			 ) );

			$output .= '<div class="clear"></div></div></div>';

		}

		echo apply_filters( 'swm_standard_pagination', $output );
	}
}


// Next - Previous Pagination

if ( !function_exists( 'swm_next_prev_links' ) ) {
	function swm_next_prev_links() {

		$output = '';

		$output .= '<div class="alignleft post-prev">
						'.get_previous_posts_link('&larr; '. esc_html__( 'Prev', 'bizix' ) ).'
					</div>
					<div class="alignright post-next">
						'.get_next_posts_link( esc_html__( 'Next', 'bizix' ) .' &rarr;').'
					</div>';

		return apply_filters( 'swm_next_prev_links', $output );
	}
}


if ( !function_exists( 'swm_next_prev_pagination' ) ) {
	function swm_next_prev_pagination( $pages = '', $range = 4 ) {
		global $paged;
		$output = '';
		if(empty($paged)) $paged = 1;

		if( $pages == '' ) {
		   global $wp_query;
		   $pages = $wp_query->max_num_pages;
		   if(!$pages) {
			   $pages = 1;
		   }
		}

		if( 1 != $pages ) {
		  	$output .= '<div class="swm-next-prev-pagination clear">
							'.swm_next_prev_links().'
		  				</div>';
		}

		echo apply_filters( 'swm_next_prev_pagination', $output );
	}
}


if ( !function_exists( 'swm_pagination' ) ) {
	function swm_pagination($pagination_style) {

		if ( $pagination_style == 'next-prev' ) {
			swm_next_prev_pagination();
		} else {
			swm_standard_pagination();
		}
	}
}

/* **************************************************************************************
	ADD FILTERS - EDIT DEFAULT WordPress
************************************************************************************** */


/* ----------------------------------------------------------------------------------------
	Search Form
---------------------------------------------------------------------------------------- */

if (!function_exists('swm_get_search_form')) {
	function swm_get_search_form( $form ) {

	    $swm_search_keywords = swm_get_option( 'swm_header_search_placeholder_text','Search...' );
	    $swm_search_keywords = swm_translate_theme_mod( 'swm_header_search_placeholder_text', $swm_search_keywords );  // Translate the theme option

	    $swm_form_content = '<form method="get" action="'.esc_url(home_url('/')).'/" class="swm-search-form">
				<div class="swm-search-form_inner">
					<input type="text" placeholder="'.esc_attr($swm_search_keywords).'" name="s" class="swm-search-form-input" autocomplete="off" />
					<button type="submit" class="swm-search-button swm-css-transition"><i class="fas fa-search"></i></button>
					<div class="clear"></div>
				</div>
			</form>';

	    return $swm_form_content;
	}

	add_filter( 'get_search_form', 'swm_get_search_form' );
}


/* ----------------------------------------------------------------------------------------
	Body Class Filter
---------------------------------------------------------------------------------------- */

if (!function_exists('swm_body_classes')) {
	function swm_body_classes($swm_body_classes) {

		$swm_get_sidebar_type = swm_page_post_layout_type();
		$swm_blog_page_layout = swm_get_option('swm_blog_page_layout','layout-sidebar-right');

		if ( function_exists('rwmb_meta') ) {
			$swm_meta_sub_header_on = get_post_meta( swm_get_queried_object_id(), 'swm_meta_sub_header_on', true );
			$swm_meta_header_style = get_post_meta( swm_get_queried_object_id(), 'swm_meta_header_style', true );

			if ( function_exists('rwmb_meta') && !is_search() && !empty( $swm_meta_sub_header_on ) && $swm_meta_sub_header_on != 'default' ) {
				if ( $swm_meta_header_style == 'revolution_slider' ) {
					$swm_body_classes[] = 'revSlider-HeaderOn';
				}

			}
		}

		if ( is_single() ) {
			$swm_body_classes[] = get_post_meta( swm_get_queried_object_id(), 'swm_meta_content_layout', true ).'_page';
		} else {
			$swm_body_classes[] = $swm_blog_page_layout.'_page';
		}

		if ( is_front_page() && is_home() ) {
			$swm_meta_header_style = swm_get_option('swm_home_blog_header_style','standard');

			if ( $swm_meta_header_style == 'revolution_slider' ) {
				$swm_body_classes[] = 'revSlider-HeaderOn';
			}
		}

		if ( swm_customizer_metabox_onoff('swm_site_layout','swm_meta_site_layout','full-width','default') == 'boxed' ) {
			$swm_body_classes[] = 'swm-l-boxed';
			$swm_body_classes[] = 'swm-boxed-' . swm_get_option('swm_boxed_layout_dropshadow','no-shadow');
		} else {
			$swm_body_classes[] = 'swm-no-boxed';
		}

		if ( swm_get_option('swm_sticky_menu_on','off') == 'on' ) {
			$swm_body_classes[] = 'swm-stickyOn';
		} else {
			$swm_body_classes[] = 'swm-stickyOff';
		}

		if ( swm_get_option('swm_topbar_on','off') == 'off' ) {
			$swm_body_classes[] = 'topbarOn';
		}

		if ( swm_get_option( 'swm_header_style','header_1' ) == 'header_1_t' || swm_get_option( 'swm_header_style','header_1' ) == 'header_2_t' ) {
			$swm_body_classes[] = 'transparentHeader';
		}

		if ( swm_get_option('swm_sub_header_above_header_on','off') == 'on') {
			$swm_body_classes[] = 'subHeaderTop';
		}

		if ( swm_customizer_metabox_onoff('swm_topbar_on','swm_meta_topbar_on','off','default') == 'off' ) {
			$swm_body_classes[] = 'noTopbar';
		}

		return $swm_body_classes;

	}

	add_filter('body_class', 'swm_body_classes');
}

/* ----------------------------------------------------------------------------------------
	Password Form
---------------------------------------------------------------------------------------- */

if (!function_exists('swm_password_form')) {
	function swm_password_form() {
	    global $post;
	    $swm_password_form_label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );

	    $output = '<form action="' . esc_url( home_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" class="post-password-form" method="post">
		<p>' . esc_html__( 'This content is password protected. To view it please enter your password below:','bizix' ) . '</p>
		<p><label for="' . $swm_password_form_label . '">' . esc_html__( 'Password:','bizix' ) . ' <input name="post_password" id="' . $swm_password_form_label . '" type="password" size="20" /></label> <input type="submit" name="Submit" value="' . esc_attr__( 'Submit','bizix' ) . '" /></p></form>
		';

	    return $output;
	}
	add_filter( 'the_password_form', 'swm_password_form' );
}

/* ----------------------------------------------------------------------------------------
	Remove Extra 10px margin in WordPress "caption" shortcode
---------------------------------------------------------------------------------------- */
if ( ! function_exists('swm_slim_img_caption_shortcode')) {
	function swm_slim_img_caption_shortcode( $caption_width ) {
		return 0;
	}
	add_filter( 'img_caption_shortcode_width', 'swm_slim_img_caption_shortcode' );
}

/* **************************************************************************************
	Post Single Next Previous Pagination
************************************************************************************** */

if (!function_exists('swm_post_single_next_prev_pagination')) {
	function swm_post_single_next_prev_pagination($prev_link,$next_link,$prev_thumb,$next_thumb,$prev_page_title,$next_page_title,$view_all_link='') {

		$output = '';

	if ( !empty( $prev_link ) || !empty( $next_link ) ) :

			$prev_link_status =  ( empty( $prev_link ) ) ? 'no-prev-link' : '';
			$next_link_status =  ( empty( $next_link ) ) ? 'no-next-link' : '';

		$output .= '<div class="swm-post-single-pagination swm-content-color ' . $prev_link_status . ' ' . $next_link_status . '">';

			if ( !empty( $prev_link ) ) {
				$output .= '<div class="swm-pp-prev swm-next-prev-box">
					<a href="' . esc_url( $prev_link ) . '" class="swm-pp-link-title"><span class="swm-next-prev-text">'. esc_html__('Prev Post', 'bizix') .'</span><span class="swm-heading-text  swm-css-transition">' . esc_html( $prev_page_title ) . '</span></a>
					<div class="clear"></div>
				</div>';
			}

			if ( !empty( $next_link ) ) {
				$output .= '<div class="swm-pp-next swm-next-prev-box">
					<a href="' . esc_url( $next_link ) . '" class="swm-pp-link-title"><span class="swm-next-prev-text">'. esc_html__('Next Post', 'bizix') .'</span><span class="swm-heading-text  swm-css-transition">' . esc_html( $next_page_title ) . '</span></a>
					<div class="clear"></div>
				</div>';
			}

			$output .= '<div class="clear"></div>
		</div>';

	endif;

	return apply_filters( 'swm_post_single_next_prev_pagination', $output );

	}
}

/* **************************************************************************************
	Post Single Next Previous Pagination
************************************************************************************** */

if (!function_exists('swm_content_pagination_menu')) {
	function swm_content_pagination_menu() {

	$output = '';

	$args = array(
		'before'           => '<div class="clear"></div><div class="swm-pagination-menu">',
		'after'            => '<div class="clear"></div></div>',
		'link_before'      => '<span class="wp_link_pages_custom">',
		'link_after'       => '</span>',
		'next_or_number'   => 'number',
		'nextpagelink'     => esc_html__('Next Page ', 'bizix'),
		'previouspagelink' => esc_html__('Previous Page ', 'bizix'),
		'pagelink'         => '%',
		'echo'             => 0
	);

	$args = apply_filters( 'swm_content_pagination_menu_args', $args );

	return wp_link_pages( $args );

	}
}

/* **************************************************************************************
	Comment Form Customization
************************************************************************************** */

function swm_comment_field_customization( $fields ) {

	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;

	unset( $fields['url'] );
	unset( $fields['cookies'] );

	return $fields;
}

add_filter( 'comment_form_fields', 'swm_comment_field_customization' );

function ea_comment_textarea_placeholder( $args ) {
	$args['comment_field'] = str_replace( 'textarea', 'textarea placeholder="' . esc_html__( 'Write Comment', 'bizix' ) . '"', $args['comment_field'] );
	return $args;
}
add_filter( 'comment_form_defaults', 'ea_comment_textarea_placeholder' );

function be_comment_form_fields( $fields ) {
	foreach( $fields as &$field ) {

		$field = str_replace( 'id="author"', 'id="author" placeholder="' . esc_html__( 'Full Name *', 'bizix' ) . '"', $field );
		$field = str_replace( 'id="email"', 'id="email" placeholder="' . esc_html__( 'Email Address *', 'bizix' ) . '"', $field );
	}
	return $fields;
}
add_filter( 'comment_form_default_fields', 'be_comment_form_fields' );