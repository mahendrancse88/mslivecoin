<?php
/* **************************************************************************************
	Social Media
************************************************************************************** */

if ( ! function_exists('swm_display_social_media')) {
	function swm_display_social_media() {

		$swm_sm_icons = array( "icon1","icon2","icon3","icon4","icon5","icon6","icon7","icon8","icon9","icon10");
		$swm_sm_ic_names = array("facebook-f","twitter","linkedin-in","instagram","","","","","","");
		$swm_sm_ic_pos = 0;

		foreach ( $swm_sm_icons as $swm_sm_icon ) {

			$sm_icon = 'swm_' . strtolower($swm_sm_icon);
			$sm_icon_url = 'swm_' . strtolower($swm_sm_icon) . '_url';

			$swm_get_sm_icon = swm_get_option( $sm_icon );
		    if($swm_get_sm_icon != '') { ?>
				<li class="swm_sm_ic"><a href="<?php echo esc_url(swm_get_option($sm_icon_url)) ; ?>" <?php echo swm_open_sm_new_window(); ?> ><i class="fab fa-<?php echo sanitize_text_field($swm_get_sm_icon); ?>"></i></a></li>
				<?php
			}

			$swm_sm_ic_pos++;

		}  // end foreach

	} // end function
} // end if

if ( ! function_exists('swm_open_sm_new_window')) {
	 function swm_open_sm_new_window() {
		 if (swm_get_option('swm_open_sm_new_window','on') == 'on') { ?> target="_blank" <?php 	}
	 }
}

/* **************************************************************************************
	Body Font Weight
************************************************************************************** */


if ( ! function_exists( 'swm_get_body_font_all_weight' ) ) {
	function swm_get_body_font_all_weight() {

		$swm_get_body_font_all_weight = 'italic';

		if ( swm_get_option( 'swm_body_font_weight_medium', 'on' ) == 'on' ) {
			$swm_get_body_font_all_weight .= ',500,500italic';
		}

		if ( swm_get_option( 'swm_body_font_weight_semi_bold', 'on' ) == 'on' ) {
			$swm_get_body_font_all_weight .= ',600,600italic';
		}

		if ( swm_get_option( 'swm_body_font_weight_bold', 'on' ) == 'on' ) {
			$swm_get_body_font_all_weight .= ',700,700italic';
		}

		return $swm_get_body_font_all_weight;
	} // End function
} // End if

/* **************************************************************************************
	Post Page Layout
************************************************************************************** */

if ( ! function_exists( 'swm_page_post_layout_type' ) ) {
	function swm_page_post_layout_type() {

		// Vars
		$swm_page_post_layout_type_class = 'layout-sidebar-right';
		$swm_get_post_types = get_post_types( '', 'names' );
		$swm_blog_page_layout_type = swm_get_option( 'swm_blog_page_layout', 'layout-sidebar-right' );
		$swm_content_layout = swm_get_option( 'swm_content_layout', 'layout-full-width' );
		$swm_meta_content_layout = 'layout-full-width';

		if (function_exists('rwmb_meta')) {
			$swm_meta_content_layout = get_post_meta( swm_get_queried_object_id(), 'swm_meta_content_layout', true );
		}

		// Loop through post types
		if ( is_single() || is_page() ) {

				if ( $swm_meta_content_layout !== '' && $swm_meta_content_layout !== 'default' ) {
					$swm_page_post_layout_type_class = $swm_meta_content_layout;
				} else {
					$swm_page_post_layout_type_class = $swm_content_layout;
				}
			}

		if ( is_archive() || is_author() || is_tag() ) {

			$swm_page_post_layout_type_class = $swm_blog_page_layout_type;

		}

		return $swm_page_post_layout_type_class;

	} // End function
} // End if

/* **************************************************************************************
	Comments Listing
************************************************************************************** */

if ( !function_exists( 'swm_comment_listing' ) ) {

	function swm_comment_listing( $comment, $args, $depth ) {

		$GLOBALS['comment'] = $comment;

		if (isset($_COOKIE["pixel_ratio"])) {
   	 		$swm_pixel_ratio = $_COOKIE["pixel_ratio"];
    		$swm_avatar_size = $swm_pixel_ratio > 1 ? '120' : '60';
		} else {
		    $swm_avatar_size = '60';
		}

		$swm_comment_reply_icon = is_rtl() ? 'mail-forward' : 'reply';

		switch ( $comment->comment_type ) :
			case 'comment' : ?>

				<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
					<article id="comment-<?php comment_ID(); ?>" class="comment-body clearfix swm-css-transition">

						<div class="comment-content">
							<div class="comment_area">
								<div class="comment-content">

									<div class="comment-avatar">
										<span><?php echo get_avatar( $comment, $swm_avatar_size ); ?></span>
										<div class="clear"></div>
									</div>

									<div class="comment-postinfo">

										<div class="swm-comment-reply">
											<div class="swm-comment-reply-btn">
												<?php comment_reply_link(
													array_merge( $args, array(
														'depth' => $depth,
														'max_depth' => $args['max_depth'],
														'reply_text' => 'Reply'
													) )
												);?>
											</div>
										</div>

										<span class="comment-author swm-heading-text"><?php printf( esc_html__( '%s', 'bizix' ), sprintf( '%s ', get_comment_author_link()." " ) );  ?></span>
										<span class="comment-date"><?php

											printf( esc_html__( '%1$s', 'bizix' ), get_comment_date(get_option('date_format')),  get_comment_time() ); ?>

										</span>

										<div class="comment-text">
											<?php comment_text();
											if ( $comment->comment_approved == '0' ) : ?>
												<p><em><?php echo esc_html__( 'Your comment is awaiting moderation.', 'bizix' ); ?></em></p>
											<?php
											endif; ?>
										</div>

										<?php edit_comment_link( esc_html__( ' (Edit)', 'bizix' ), ' ' );	?>

										<div class="clear"></div>

									</div> <!-- end .comment-postinfo -->

									<div class="clear"></div>

								</div> <!-- end comment-content-->


								<div class="clear"></div>

							</div> <!-- end comment_area-->
						</div>
						<div class="clear"></div>

					</article> <!-- end comment-body -->
					<div class="clear"></div>

				<?php
				break;
			case 'pingback'  :
			case 'trackback' : ?>

				<li class="post pingback">
				<p><?php echo esc_html__( 'Pingback:', 'bizix' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( esc_html__('(Edit)', 'bizix'), ' ' ); ?></p>
				<?php
				break;
		endswitch;
	}
}

/* **************************************************************************************
	Hex to RGBA
************************************************************************************** */

function swm_hex2rgba($color, $opacity = false) {

	$swm_rgba_default = 'rgb(0,0,0)';

	//Return default if no color provided
	if(empty($color))
          return $swm_rgba_default;

	//Sanitize $color if "#" is provided
        if ($color[0] == '#' ) {
        	$color = substr( $color, 1 );
        }

        $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );

        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);

        //Check if opacity is set(rgba or rgb)
        if($opacity){
        	if(abs($opacity) > 1)
        		$opacity = 1.0;
        	$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
        	$output = 'rgb('.implode(",",$rgb).')';
        }

        //Return rgb(a) color string
        return $output;
}

/* **************************************************************************************
	Show Hide Element/Section
************************************************************************************** */

if (!function_exists('swm_show_hide_section_controls')) {
	function swm_show_hide_section_controls($swm_customizer_option_name,$swm_meta_option_name,$default_customizer_onoff='on') {

		$swm_section = swm_get_option( $swm_customizer_option_name,$default_customizer_onoff );
		$swm_section_onoff = 'hide_section';
		$swm_meta_section_on = 'default';

		if ( $swm_section == 'on' ) {
			$swm_section_onoff = 'show_section';
		}

		if (function_exists('rwmb_meta')) {
			$swm_meta_section_on = get_post_meta( swm_get_queried_object_id(), $swm_meta_option_name, true );
		}

		if ( $swm_section == 'on' && $swm_meta_section_on == 'default' ) {
			$swm_section_onoff = 'show_section';
		}

		if ( $swm_meta_section_on != '' && $swm_meta_section_on == 'on') {
			$swm_section_onoff = 'show_section';
		}

		if ( $swm_meta_section_on != '' && $swm_meta_section_on == 'off') {
			$swm_section_onoff = 'hide_section';
		}

		return $swm_section_onoff;

	}
}

/* **************************************************************************************
	Allow to remove method for an hook when, it's a class method used and class doesn't have global for instanciation
************************************************************************************** */

function swm_remove_class_filter( $hook_name = '', $class_name ='', $method_name = '', $priority = 0 ) {
  global $wp_filter;

  // Make sure class exists
  if ( ! class_exists( $class_name ) ) {
    return false;
  }

  // Take only filters on right hook name and priority
  if ( ! isset($wp_filter[$hook_name][$priority] ) || ! is_array( $wp_filter[$hook_name][$priority] ) ) {
    return false;
  }

  // Loop on filters registered
  foreach( (array) $wp_filter[$hook_name][$priority] as $unique_id => $filter_array ) {

    // Test if filter is an array ! (always for class/method)
    // @todo consider using has_action instead
    // @link https://make.wordpress.org/core/2016/09/08/wp_hook-next-generation-actions-and-filters/
    if ( isset( $filter_array['function'] ) && is_array( $filter_array['function'] ) ) {

      // Test if object is a class, class and method is equal to param !
      if ( is_object( $filter_array['function'][0] ) && get_class( $filter_array['function'][0] ) && get_class( $filter_array['function'][0] ) == $class_name && $filter_array['function'][1] == $method_name ) {
        if ( isset( $wp_filter[$hook_name] ) ) {
          // WP 4.7
          if ( is_object( $wp_filter[$hook_name] ) ) {
            unset( $wp_filter[$hook_name]->callbacks[$priority][$unique_id] );
          }
          // WP 4.6
          else {
            unset( $wp_filter[$hook_name][$priority][$unique_id] );
          }
        }
      }

    }

  }
  return false;
}

/* **************************************************************************************
	Background Image Style
************************************************************************************** */

function swm_background_style_css( $input ) {

	switch ($input) {
		case "stretched":
			return '-webkit-background-size: cover;
				-moz-background-size: cover;
				-o-background-size: cover;
				background-size: cover;
				background-position: center center;
				background-attachment: fixed;
				background-repeat: no-repeat;';
			break;
		case "cover":
			return 'background-position: center center;
				-webkit-background-size: cover;
				-moz-background-size: cover;
				-o-background-size: cover;
				background-size: cover;';
			break;
		case "repeat":
			return 'background-repeat:repeat;';
			break;
		case "repeat-y":
			return 'background-position: center center;background-repeat:repeat-y;';
			break;
		case "fixed":
			return 'background-repeat: no-repeat; background-position: center center; background-attachment: fixed;';
			break;
		case "fixed-top":
			return 'background-repeat: no-repeat; background-position: center top; background-attachment: fixed;';
			break;
		case "fixed-bottom":
			return 'background-repeat: no-repeat; background-position: center bottom; background-attachment: fixed;';
			break;
		default:
			return 'background-repeat:'. $input .';';
	}

}

/* **************************************************************************************
	Get Queried Object ID
************************************************************************************** */

if (!function_exists('swm_get_queried_object_id')) {
	function swm_get_queried_object_id() {
		$swm_get_queried_object_id = get_queried_object_id();

		return $swm_get_queried_object_id;

	}
}

/* **************************************************************************************
	Get Customizer / Meta Value
************************************************************************************** */

if (!function_exists('swm_customizer_metabox_onoff')) {
	function swm_customizer_metabox_onoff($customizer_option,$metabox_option,$customizer_default_value='on',$metabox_option_default_value='') {

		$swm_cm_on_off = '';
		$swm_cm_on_off = swm_get_option( $customizer_option,$customizer_default_value );
		$swm_meta_on_off = $metabox_option_default_value;

		if ( function_exists('rwmb_meta') && !is_search() ) {
			$swm_meta_on_off = get_post_meta( swm_get_queried_object_id(), $metabox_option, true );

			if ( !empty( $swm_meta_on_off ) && $swm_meta_on_off != 'default' ) {
				$swm_cm_on_off = $swm_meta_on_off;
			}
		}

		return $swm_cm_on_off;

	}
}

/* **************************************************************************************
	Sanitization
************************************************************************************** */

// Image
function swm_sanitize_image( $image ) {

    $mimes = array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif'          => 'image/gif',
        'png'          => 'image/png',
        'bmp'          => 'image/bmp',
        'svg'          => 'image/svg',
        'tif|tiff'     => 'image/tiff',
        'ico'          => 'image/x-icon'
    );

    $file = wp_check_filetype( $image, $mimes );
    return ( $file['ext'] ? $image : '' );
}

// Color
function swm_sanitize_hex_color( $hex_color ) {
    return sanitize_hex_color( $hex_color );
}

// URL
function swm_sanitize_url( $url ) {
    return esc_url_raw( $url );
}

//Number
function swm_sanitize_number_floatval( $number ) {
    $number = floatval( $number );
    return $number;
}

// Text
function swm_sanitize_simple_text( $html ) {
    return esc_html( $html );
}

/* **************************************************************************************
	Check current request
************************************************************************************** */

function swm_is_request( $type ) {
	switch ( $type ) {
		case 'admin':
			return is_admin();
		case 'ajax':
			return wp_doing_ajax();
		case 'frontend':
			return ( ! is_admin() || wp_doing_ajax() );
	}
}

/* **************************************************************************************
	Enqueue Scripts
************************************************************************************** */

function swm_enqueue_flexslider() {
	wp_enqueue_script( 'flexslider' );
	wp_enqueue_style( 'flexslider' );
}