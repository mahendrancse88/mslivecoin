<?php
/* Characters control */

if ( !function_exists( 'gyan_short_text' ) ) {
	function gyan_short_text($text, $limit) {

	  	$truncate = get_the_excerpt();
		$truncate = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
		$truncate = preg_replace('@<style[^>]*?>.*?</style>@si', '', $truncate);
		$truncate = strip_tags($truncate);
		$truncate = $truncate . ' ';
		$truncate = substr($truncate, 0, strrpos(substr($truncate, 0, $limit), ' '));

		return $truncate;
	}
}

/* Get Comments Number */

if( ! function_exists( 'gyan_get_comments_number' ) ) {
	function gyan_get_comments_number() {

		$gyan_num_comments = get_comments_number();

		if ( $gyan_num_comments == 0 ) {
			$output =  esc_html__('No Comments','gyan-elements');
		} elseif ( $gyan_num_comments > 1 ) {
			$output =  $gyan_num_comments . esc_html__(' Comments','gyan-elements');
		} else {
			$output =  esc_html__('1 Comment','gyan-elements');
		}

		echo apply_filters( 'gyan_get_comments_number', $output );
	}
}

/* Pagination - Standard */

if ( !function_exists( 'gyan_standard_pagination' ) ) {
	function gyan_standard_pagination($query = '', $echo = true) {

		$gyan_prevOne = '<i class="fas fa-angle-double-left"></i> <span class="gyan_pg_prev"></span>';
		$gyan_prevTwo = '<i class="fas fa-angle-double-right"></i> <span class="gyan_pg_prev"></span>';

		$gyan_NextOne = '<span class="gyan_pg_next"></span> <i class="fas fa-angle-double-right"></i>';
		$gyan_NextTwo = '<span class="gyan_pg_next"></span> <i class="fas fa-angle-double-left"></i>';

		$gyan_arrowPrev = is_rtl() ? $gyan_prevTwo : $gyan_prevOne;
		$gyan_arrowNext = is_rtl() ? $gyan_NextTwo : $gyan_NextOne;

		global $wp_query;

		// Get global $query
		if ( ! $query ) {
			global $wp_query;
			$query = $wp_query;
		}

		$gyan_total_page  = $query->max_num_pages;
		$gyan_big_number = 999999999; // need an unlikely integer
		$output = '';

		if( $gyan_total_page > 1 )  {

			$output .= '<div class="gyan-pagination-wrap">';
			$output .= '<div class="gyan-pagination">';

			 // Get current page
			if ( $current_page = get_query_var( 'paged' ) ) {
				$current_page = $current_page;
			} elseif ( $current_page = get_query_var( 'page' ) ) {
				$current_page = $current_page;
			} else {
				$current_page = 1;
			}

			// Get permalink structure
			if ( get_option( 'permalink_structure' ) ) {
				if ( is_page() ) {
					$gyan_pagination_format = 'page/%#%/';
				} else {
					$gyan_pagination_format = '/%#%/';
				}
			} else {
				$gyan_pagination_format = '&paged=%#%';
			}

			$args = apply_filters( 'gyan_standard_pagination_args', array(
				'base'			=> str_replace( $gyan_big_number, '%#%', html_entity_decode( get_pagenum_link( $gyan_big_number ) ) ),
				'format'		=> $gyan_pagination_format,
				'current'		=> max( 1, $current_page ),
				'total' 		=> $gyan_total_page,
				'mid_size'		=> 2,
				'show_all'		=> false,
				"add_args" 		=> false,
				'type' 			=> 'plain',
				'prev_text'		=> $gyan_arrowPrev,
				'next_text'		=> $gyan_arrowNext
			 ) );

			$output .= paginate_links($args);

			$output .= '<div class="clear"></div></div></div>';

			return $output;

		}
	}
}

/* Filterable Gallery Category */

function gyan_get_filterable_gallery_cat( $filterable_gallery ) {
	$category_in = [];

	foreach ( $filterable_gallery as $item ) {
		if ( $item['category'] ) {
			$cat_explode = explode( ',', $item['category'] );

			foreach ( $cat_explode as $name ) {
				$category = strtolower( str_replace( ' ', '_', $name ) );

				if ( !in_array($category, $category_in) ) {
					$category_in[] = $category;
				}
			}
		}
	}

	sort($category_in);

	return $category_in;
}

/* Get Category */

function gyan_get_categories(){
	$terms = get_terms( [
		'taxonomy' => 'category',
		'hide_empty' => true,
	] );

	$options = [];
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
		foreach ( $terms as $term ) {
			$options[ $term->term_id ] = $term->name;
		}
	}
	return $options;
}

/* Portfolio Category List */

function get_portfolio_cat_list() {

    $args = array(
        'type'     => 'portfolio',
        'taxonomy' => 'portfolio_category' );

    $pf_all_categories = get_categories($args);

    $pf_category_list = array();

    foreach ($pf_all_categories as $category) {
        $taxonomy_term_name = $category->term_id;
        $taxonomy_term_slug = $category->slug;
        $pf_category_list[ $taxonomy_term_name ] = $taxonomy_term_slug;
    }

    return $pf_category_list;

}

/* Get Page Templates */

function gyan_get_page_templates(){
	$page_templates = get_posts( [
		'post_type'         => 'elementor_library',
		'posts_per_page'    => -1
	] );

	$options = [];

	if ( ! empty( $page_templates ) && ! is_wp_error( $page_templates ) ){
		foreach ( $page_templates as $template ) {
			$options[ $template->ID ] = $template->post_title;
		}
	}
	return $options;
}

/* Image Caption */

function get_image_caption( $id, $caption_type = 'caption' ) {

	if ( empty( $caption_type ) ) {
		return '';
	}

    $attachment = get_post( $id );
    $attachment_caption = '';

    if ( $caption_type == 'title' ) {
        $attachment_caption = $attachment->post_title;
    } elseif ( $caption_type == 'caption' ) {
        $attachment_caption = $attachment->post_excerpt;
    }

    return $attachment_caption;
}

/* Page Templates for Tabs */

function gyan_get_page_templates_for_tabs($type = null) {
    $args = [
        'post_type' => 'elementor_library',
        'posts_per_page' => -1,
    ];

    if ($type) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'elementor_library_type',
                'field' => 'slug',
                'terms' => $type,
            ],
        ];
    }

    $page_templates = get_posts($args);
    $options = array();

    if (!empty($page_templates) && !is_wp_error($page_templates)) {
        foreach ($page_templates as $post) {
            $options[$post->ID] = $post->post_title;
        }
    }
    return $options;
}

/* Mail Chimp Subscribe */

function gyan_mailchimp_subscribe() {
	if ( check_ajax_referer( 'gyan_mc_subscribe', 'nonce') && wp_verify_nonce( $_POST['nonce'], 'gyan_mc_subscribe' ) ) {

		$email = sanitize_email( $_POST['email'] );
		$fname = sanitize_text_field( $_POST['fname'] );
		$lname = sanitize_text_field( $_POST['lname'] );
		$phone = sanitize_text_field( $_POST['phone'] );
		$status = 'subscribed';
		$err = '';

		if ( '' == $fname) {
			$fname = $fname;
		} elseif ( strlen($fname) < 3 ) {
			$err = esc_html__( 'First name too short! Must be contain 3-32 characters.', 'gyan-elements' );
		} elseif ( strlen($fname) > 32 ) {
			$err = esc_html__( 'First name too large! Must be contain 3-32 characters.', 'gyan-elements' );
		} elseif ( preg_match("/^[a-zA-Z][ a-zA-Z0-9]{2,31}$/", $fname) ) {
			$fname = $fname;
		} else {
			$err = esc_html__( 'Special character(s) not allowed in your first name!', 'gyan-elements' );
		}

		if ( '' == $err ) {
			if ( '' == $lname) {
				$lname = $lname;
			} elseif ( strlen($lname) < 3 ) {
				$err = esc_html__( 'Last name too short! Must be contain 3-32 characters.', 'gyan-elements' );
			} elseif ( strlen($lname) > 32 ) {
				$err = esc_html__( 'Last name too large! Must be contain 3-32 characters.', 'gyan-elements' );
			} elseif ( preg_match("/^[a-zA-Z][ a-zA-Z0-9]{2,31}$/", $lname) ) {
				$lname = $lname;
			} else {
				$err = esc_html__( 'Special character(s) not allowed in your last name!', 'gyan-elements' );
			}
		}

		if ( '' == $err ) {
			if ( '' == $email) {
				$err = esc_html__( 'Invalid email!', 'gyan-elements' );
			}
		}

		if ( '' == $err ) {
			if ( '' == $phone ) {
				$phone = $phone;
			} elseif ( preg_match("/^[0-9\(\+][ 0-9-\(\)]{2,19}$/", $phone) ) {
				$phone = $phone;
			} else {
				$err = esc_html__( 'Invalid phone number!', 'gyan-elements' );
			}
		}

		if ( '' == $err ) {
			$mail_chimp = get_option( 'gyan_mailchimp' );
			$api_parts = explode( '-', $mail_chimp['apikey'] );
			$list_id = $mail_chimp['list_id'];
			$url = 'https://'.$api_parts[1].'.api.mailchimp.com/3.0/lists/'.$list_id.'/members';

			$args = [
				'method' => 'POST',
				'headers' => [
					'Authorization'	=> 'Basic ' . base64_encode( 'user:'. implode('-', $api_parts) ),
					'Content-Type'	=> 'application/json; charset=utf-8',
				],
				'body' => json_encode( [
					'email_address' => $email,
					'merge_fields'	=> [
						'FNAME' => $fname,
						'LNAME' => $lname,
						'PHONE' => $phone,
					],
					'status'        => $status
				] )
			];

			$response = wp_remote_post( $url, $args );

			if ( is_wp_error( $response ) ) {
				$err = "Internal Error!";
			} else {
				$body = json_decode( $response['body'] );
				if ( $response['response']['code'] == 200 && $body->status == $status ) {
					$err = 'success';
				} else {
					$err = $body->title.'!';
				}
			}
		}

		printf( '%s', $err );
	}
	die();
}
add_action( 'wp_ajax_gyan_mc_subscribe', 'gyan_mailchimp_subscribe' );
add_action( 'wp_ajax_nopriv_gyan_mc_subscribe', 'gyan_mailchimp_subscribe' );

/* Walker Category */

if ( !class_exists( 'Gyan_Walker_Category' ) ) {
	class Gyan_Walker_Category extends Walker_Category {
		function start_el( &$output, $object, $depth = 0, $args = Array(), $current_object_id = 0 ) {

			extract($args);

			$gyan_cat_name = esc_attr( $object->name);
			$gyan_cat_id = esc_attr( $object->term_id);
			$gyan_cat_name = apply_filters( 'gyan_cat_list_walker', $gyan_cat_name, $object );
			$gyan_item_link = '<button href="#" class="gyan-portfolio-btn gyan-button" data-filter=".cat-' . intval($gyan_cat_id) . '" title="'.$gyan_cat_name.'">'.$gyan_cat_name.'</button>';

			if ( isset($show_count) && $show_count ){
				$gyan_item_link .= ' (' . intval($object->count) . ')';
			}
			if ( isset($show_date) && $show_date ) {
				$gyan_item_link .= ' ' . gmdate('Y-m-d', $object->last_update_timestamp);
			}
			if ( isset($current_category) && $current_category )
				$_current_category = get_category( $current_category );
			if ( 'list' == $args['style'] ) {
				$output .= "$gyan_item_link";
			} else {
				$output .= "\t$gyan_item_link<br />\n";
			}
		}
	}
}

/* Posts Walker Category */

if ( !class_exists( 'Gyan_Posts_Walker_Category' ) ) {
	class Gyan_Posts_Walker_Category extends Walker_Category {
		function start_el( &$output, $object, $depth = 0, $args = Array(), $current_object_id = 0 ) {

			extract($args);

			$gyan_cat_name = esc_attr( $object->name);
			$gyan_cat_id = esc_attr( $object->term_id);
			$gyan_cat_name = apply_filters( 'gyan_cat_list_walker', $gyan_cat_name, $object );
			$gyan_item_link = '<button href="#" class="gyan-post-grid-btn gyan-button" data-filter=".cat-' . intval($gyan_cat_id) . '" title="'.$gyan_cat_name.'">'.$gyan_cat_name.'</button>';

			if ( isset($show_count) && $show_count ){
				$gyan_item_link .= ' (' . intval($object->count) . ')';
			}
			if ( isset($show_date) && $show_date ) {
				$gyan_item_link .= ' ' . gmdate('Y-m-d', $object->last_update_timestamp);
			}
			if ( isset($current_category) && $current_category )
				$_current_category = get_category( $current_category );
			if ( 'list' == $args['style'] ) {
				$output .= "$gyan_item_link";
			} else {
				$output .= "\t$gyan_item_link<br />\n";
			}
		}
	}
}

/* View Count */

if (!function_exists('gyan_get_post_views')) {
	function gyan_get_post_views($postID){
	    $gyan_view_count_key = 'post_views_count';
	    $gyan_view_count = get_post_meta($postID, $gyan_view_count_key, true);
	    if($gyan_view_count==''){
	        delete_post_meta($postID, $gyan_view_count_key);
	        add_post_meta($postID, $gyan_view_count_key, '0');
	        return "0";
	    }
	    return $gyan_view_count;
	}
}

if (!function_exists('gyan_set_post_views')) {
	function gyan_set_post_views($postID) {
	    $gyan_view_count_key = 'post_views_count';
	    $gyan_view_count = get_post_meta($postID, $gyan_view_count_key, true);

	    if($gyan_view_count==''){
	        $gyan_view_count = 0;
	        delete_post_meta($postID, $gyan_view_count_key);
	        add_post_meta($postID, $gyan_view_count_key, '0');
	    }else{
	        $gyan_view_count++;
	        update_post_meta($postID, $gyan_view_count_key, $gyan_view_count);
	    }
	    return $gyan_view_count;
	}
}

/* WordPress Menus List */

 function gyan_wp_menu_names_list() {

 	$get_wp_menus_name = get_terms( 'nav_menu', array( 'hide_empty' => false ) );

 	$pf_menu_list = array();

	foreach ( $get_wp_menus_name as $menu_name ) {
		$taxonomy_menu_id = $menu_name->term_id;
    	$taxonomy_menu_name = $menu_name->name;
    	$pf_menu_list[ $taxonomy_menu_id ] = $taxonomy_menu_name;
	}

	return $pf_menu_list;

 }
/* -------------------------------------------
   Arrays
------------------------------------------- */

function gyan_position() {
	return array(
		'top-left'      => esc_html__('Top Left', 'gyan-elements') ,
		'top-center'    => esc_html__('Top Center', 'gyan-elements') ,
		'top-right'     => esc_html__('Top Right', 'gyan-elements') ,
		'center'        => esc_html__('Center', 'gyan-elements') ,
		'center-left'   => esc_html__('Center Left', 'gyan-elements') ,
		'center-right'  => esc_html__('Center Right', 'gyan-elements') ,
		'bottom-left'   => esc_html__('Bottom Left', 'gyan-elements') ,
		'bottom-center' => esc_html__('Bottom Center', 'gyan-elements') ,
		'bottom-right'  => esc_html__('Bottom Right', 'gyan-elements') ,
	);
}

 /* Title Tags  */

 function gyan_title_tags() {
     return array(
         'h1'   => esc_html__( 'H1', 'gyan-elements' ),
         'h2'   => esc_html__( 'H2', 'gyan-elements' ),
         'h3'   => esc_html__( 'H3', 'gyan-elements' ),
         'h4'   => esc_html__( 'H4', 'gyan-elements' ),
         'h5'   => esc_html__( 'H5', 'gyan-elements' ),
         'h6'   => esc_html__( 'H6', 'gyan-elements' ),
         'div'  => esc_html__( 'div', 'gyan-elements' ),
         'span' => esc_html__( 'span', 'gyan-elements' ),
         'p'    => esc_html__( 'p', 'gyan-elements' ),
     );
 }

 /* One to Ten */

 function gyan_one_to_ten_array() {
     return array(
		'1'  => '1',
		'2'  => '2',
		'3'  => '3',
		'4'  => '4',
		'5'  => '5',
		'6'  => '6',
		'7'  => '7',
		'8'  => '8',
		'9'  => '9',
		'10' => '10',
     );
 }