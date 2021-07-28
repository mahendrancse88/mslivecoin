<?php

function swm_breadcrumb_trail( $args = array() ) {

	if (is_front_page()) { return; }

	/* Create an empty variable for the breadcrumb. */
	$swm_breadcrumb = '';

	$swm_breadcrumb_arrow = is_rtl() ? '<i class="fas fa-angle-left"></i>' :'<i class="fas fa-angle-right"></i>';

	$swm_breadcrumbs_separator_symbol = swm_get_option( 'swm_breadcrumbs_separator_symbol','angle-right' );

	if ( $swm_breadcrumbs_separator_symbol != 'forward-slash' ) {
		$swm_breadcrumb_separator = '<i class="fas fa-'.$swm_breadcrumbs_separator_symbol.'"></i>';
	} else {
		$swm_breadcrumb_separator = '/';
	}

	$swm_breadcrumb_home_text = esc_html__('Home','bizix');
    $swm_breadcrumb_home_text = apply_filters( 'swm_breadcrumb_home_text', $swm_breadcrumb_home_text );

	/* Set up the default arguments for the breadcrumb. */
	$defaults = array(
		'separator' => '',
		'before' => '',
		'after' => false,
		'front_page' => true,
		'show_home' => $swm_breadcrumb_home_text,
		'echo' => true
	);

	/* Allow singular post views to have a taxonomy's terms prefixing the trail. */
	if ( is_singular() ) {
		$post = get_queried_object();
		$defaults["singular_{$post->post_type}_taxonomy"] = false;
	}

	/* Apply filters to the arguments. */
	$args = apply_filters( 'breadcrumb_trail_args', $args );

	/* Parse the arguments and extract them for easy variable naming. */
	$args = wp_parse_args( $args, $defaults );

	/* Get the trail items. */
	$swm_bc_trail = swm_breadcrumb_trail_get_items( $args );

	/* Connect the breadcrumb trail if there are items in the trail. */
	if ( !empty( $swm_bc_trail ) && is_array( $swm_bc_trail ) ) {

		/* Open the breadcrumb trail containers. */
		$swm_breadcrumb = '<div class="swm-breadcrumbs">';

		/* If $before was set, wrap it in a container. */
		$swm_breadcrumb .= ( !empty( $args['before'] ) ? '<span class="swm-bc-trail-before">' . esc_html($args['before']) . '</span> ' : '' );

		/* Wrap the $swm_bc_trail['trail_end'] value in a container. */
		$swm_get_post_format = get_post_format();
		$swm_bc_title_char_length = 250;

		if ( $swm_get_post_format == 'quote') {
			$swm_bc_title_char_length = 50;
		}

		if ( !empty( $swm_bc_trail['trail_end'] ) ){
			$swm_bc_trail['trail_end'] = '<span class="swm-bc-trail-end">' . substr($swm_bc_trail['trail_end'],0,$swm_bc_title_char_length) . '</span>';
		}

		/* Format the separator. */
		$swm_bc_separator = ( !empty( $args['separator'] ) ? '<span class="swm-bc-sep">' . esc_html($args['separator']) . '</span>' : '<span class="swm-bc-sep"></span>' );

		/* Join the individual trail items into a single string. */
		$swm_breadcrumb .= join( " {$swm_bc_separator} ", $swm_bc_trail );

		/* If $after was set, wrap it in a container. */
		$swm_breadcrumb .= ( !empty( $args['after'] ) ? ' <span class="swm-bc-trail-after">' . esc_html($args['after']) . '</span>' : '' );

		/* Close the breadcrumb trail containers. */
		$swm_breadcrumb .= '<div class="clear"></div></div>';
	}

	/* Allow developers to filter the breadcrumb trail HTML. */
	$swm_breadcrumb = apply_filters( 'swm_breadcrumb_trail', $swm_breadcrumb, $args );

	/* Output the breadcrumb. */
	if ( $args['echo'] )
		echo wp_kses( $swm_breadcrumb,swm_kses_allowed_text() );
	else
		return wp_kses( $swm_breadcrumb,swm_kses_allowed_text() );
}

function swm_breadcrumb_trail_get_items( $args = array() ) {
	global $wp_rewrite;

	/* Set up an empty trail array and empty path. */
	$swm_bc_trail = array();
	$swm_bc_path = '';

	/* If $show_home is set and we're not on the front page of the site, link to the home page. */
	if ( !is_front_page() && $args['show_home'] ){
		$swm_bc_trail[] = '<a href="' . esc_url(home_url('/')) . '" title="' . esc_attr( get_bloginfo( 'name' ) ) . '" rel="home" class="swm-bc-trail-begin">' . esc_html($args['show_home']) . '</a>';
	}

	/* If viewing the front page of the site. */
	if ( is_front_page() ) {
		if ( $args['show_home'] && $args['front_page'] )
			$swm_bc_trail['trail_end'] = "{$args['show_home']}";
	}

	/* If viewing the "home"/posts page. */
	elseif ( is_home() ) {
		$swm_bc_home_page = get_page( get_queried_object_id() );
		$swm_bc_trail = array_merge( $swm_bc_trail, swm_breadcrumb_trail_get_parents( $swm_bc_home_page->post_parent, '' ) );
		$swm_bc_trail['trail_end'] = get_the_title( $swm_bc_home_page->ID );
	}

	/* If viewing a singular post (page, attachment, etc.). */
	elseif ( is_singular() ) {

		/* Get singular post variables needed. */
		$post = get_queried_object();
		$post_id = absint( get_queried_object_id() );
		$post_type = $post->post_type;
		$swm_bc_parent = absint( $post->post_parent );

		/* Get the post type object. */
		$swm_post_type_object = get_post_type_object( $post_type );

		$swm_bc_blog_pg_title = esc_html(swm_get_option('swm_blog_single_header_title','Blog'));
		$swm_bc_blog_pg_title = swm_translate_theme_mod( 'swm_blog_single_header_title', $swm_bc_blog_pg_title );

		/* If viewing a singular 'post'. */
		if ( 'post' == $post_type ) {

			$swm_blog_page_url = swm_get_option( 'swm_blog_page_url' );

			$swm_bc_trail[] = '<a href="'. esc_url($swm_blog_page_url) .'" title="'. esc_attr($swm_bc_blog_pg_title) .'">'.esc_html($swm_bc_blog_pg_title).'</a>';

			/* If $front has been set, add it to the $swm_bc_path. */
			$swm_bc_path .= trailingslashit( $wp_rewrite->front );

			/* If there's a path, check for parents. */
			if ( !empty( $swm_bc_path ) )
				$swm_bc_trail = array_merge( $swm_bc_trail, swm_breadcrumb_trail_get_parents( '', $swm_bc_path ) );

			/* Map the permalink structure tags to actual links. */
			$swm_bc_trail = array_merge( $swm_bc_trail, swm_breadcrumb_trail_map_rewrite_tags( $post_id, get_option( 'permalink_structure' ), $args ) );

		}

		// post type portfolio
		if ( class_exists( 'WPML_String_Translation' ) ) {
			$swm_bc_portfolio_pg_title = icl_translate('Theme Mod', 'swm_portfolio_page_title', swm_get_option( 'swm_portfolio_page_title','Portfolio' ));
		} else {
			$swm_bc_portfolio_pg_title = swm_get_option('swm_portfolio_page_title','Portfolio');
		}

		$swm_bc_portfolio_pg_title = swm_get_option('swm_portfolio_page_title','Portfolio');
		$swm_bc_portfolio_pg_title = swm_translate_theme_mod( 'swm_portfolio_page_title', $swm_bc_portfolio_pg_title );



		$swm_portfolio_page_url = swm_get_option( 'swm_portfolio_page_url' );

		if( $post_type == 'portfolio' ) {
			$swm_bc_trail[] = '<a href="'. esc_url($swm_portfolio_page_url) .'" title="'. esc_attr($swm_bc_portfolio_pg_title) .'">'.esc_html($swm_bc_portfolio_pg_title).'</a>';
		}

		// post type classes
		if ( class_exists( 'WPML_String_Translation' ) ) {
			$swm_bc_classes_pg_title = icl_translate('Theme Mod', 'swm_classes_page_title', swm_get_option( 'swm_classes_page_title','Classes' ));
		} else {
			$swm_bc_classes_pg_title = swm_get_option('swm_classes_page_title','Classes');
		}

		$swm_classes_page_url = swm_get_option( 'swm_classes_page_url' );

		if( $post_type == 'classes' ) {
			$swm_bc_trail[] = '<a href="'. esc_url($swm_classes_page_url) .'" title="'. esc_attr($swm_bc_classes_pg_title) .'">'.esc_html($swm_bc_classes_pg_title).'</a>';
		}

		// post type team
		if ( class_exists( 'WPML_String_Translation' ) ) {
			$swm_bc_team_pg_title = icl_translate('Theme Mod', 'swm_team_page_title', swm_get_option( 'swm_team_page_title','Team' ));
		} else {
			$swm_bc_team_pg_title = swm_get_option('swm_team_page_title','Team');
		}

		$swm_team_page_url = swm_get_option( 'swm_team_page_url' );

		if( $post_type == 'team' ) {
			$swm_bc_trail[] = '<a href="'. esc_url($swm_team_page_url) .'" title="'. esc_attr($swm_bc_team_pg_title) .'">'.esc_html($swm_bc_team_pg_title).'</a>';
		}

		/* WooCommerce */
		if ( SWM_WOOCOMMERCE_IS_ACTIVE ) {
			$swm_bc_shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );
			$swm_bc_shop_title = get_the_title( wc_get_page_id( 'shop' ) );

			if ( is_singular('page') ) {
				if ( is_cart() || is_checkout() ) {
					$swm_bc_trail[] = '<a href="' . $swm_bc_shop_page_url . '" title="' . $swm_bc_shop_title . '">' . $swm_bc_shop_title . '</a>';
				}
			}

			if( $post_type == 'product' ) {
				$swm_bc_trail[] = '<a href="' . $swm_bc_shop_page_url . '" title="' . $swm_bc_shop_title . '">' . $swm_bc_shop_title . '</a>';
			}

		}


		/* If viewing a singular 'attachment'. */
		elseif ( 'attachment' == $post_type ) {

			/* If $front has been set, add it to the $swm_bc_path. */
			$swm_bc_path .= trailingslashit( $wp_rewrite->front );

			/* If there's a path, check for parents. */
			if ( !empty( $swm_bc_path ) ){
				$swm_bc_trail = array_merge( $swm_bc_trail, swm_breadcrumb_trail_get_parents( '', $swm_bc_path ) );
			}

			/* Map the post (parent) permalink structure tags to actual links. */
			$swm_bc_trail = array_merge( $swm_bc_trail, swm_breadcrumb_trail_map_rewrite_tags( $post->post_parent, get_option( 'permalink_structure' ), $args ) );
		}

		/* If a custom post type, check if there are any pages in its hierarchy based on the slug. */
		elseif ( 'page' !== $post_type ) {

			/* If $front has been set, add it to the $swm_bc_path. */
			if (  !empty( $swm_post_type_object->rewrite['with_front'] ) && $wp_rewrite->front ) {
				$swm_bc_path .= trailingslashit( $wp_rewrite->front );
			}

			/* If there's a slug, add it to the $swm_bc_path. */
			if ( !empty( $swm_post_type_object->rewrite['slug'] ) ) {
				$swm_bc_path .= $swm_post_type_object->rewrite['slug'];
			}

			/* If there's a path, check for parents. */
			if ( !empty( $swm_bc_path ) ) {
				$swm_bc_trail = array_merge( $swm_bc_trail, swm_breadcrumb_trail_get_parents( '', $swm_bc_path ) );
			}

			/* If there's an archive page, add it to the trail. */
			if ( !empty( $swm_post_type_object->has_archive ) ) {
				$swm_bc_trail[] = '<a href="' . get_post_type_archive_link( $post_type ) . '" title="' . esc_attr( $swm_post_type_object->labels->name ) . '">' . esc_html($swm_post_type_object->labels->name) . '</a>';
			}
		}

		/* If the post type path returns nothing and there is a parent, get its parents. */
		if ( ( empty( $swm_bc_path ) && 0 !== $swm_bc_parent ) || ( 'attachment' == $post_type ) ) {
			$swm_bc_trail = array_merge( $swm_bc_trail, swm_breadcrumb_trail_get_parents( $swm_bc_parent, '' ) );
		}

		/* Or, if the post type is hierarchical and there's a parent, get its parents. */
		elseif ( 0 !== $swm_bc_parent && is_post_type_hierarchical( $post_type ) ) {
			$swm_bc_trail = array_merge( $swm_bc_trail, swm_breadcrumb_trail_get_parents( $swm_bc_parent, '' ) );
		}

		/* Display terms for specific post type taxonomy if requested. */
		if ( !empty( $args["singular_{$post_type}_taxonomy"] ) && $terms = get_the_term_list( $post_id, $args["singular_{$post_type}_taxonomy"], '', ', ', '' ) ) {
			$swm_bc_trail[] = $terms;
		}

		/* End with the post title. */
		$post_title = get_the_title();
		if ( !empty( $post_title ) ) {
			$swm_bc_trail['trail_end'] = $post_title;
		}
	}

	/* If we're viewing any type of archive. */
	elseif ( is_archive() ) {

		/* If viewing a taxonomy term archive. */
		if ( is_tax() || is_category() || is_tag() ) {

			/* Get some taxonomy and term variables. */
			$term = get_queried_object();
			$taxonomy = get_taxonomy( $term->taxonomy );

			/* Get the path to the term archive. Use this to determine if a page is present with it. */
			if ( is_category() ) {
				$swm_bc_path = get_option( 'category_base' );
			} elseif ( is_tag() ) {
				$swm_bc_path = get_option( 'tag_base' );
			} else {
				if ( $taxonomy->rewrite['with_front'] && $wp_rewrite->front )
					$swm_bc_path = trailingslashit( $wp_rewrite->front );
				$swm_bc_path .= $taxonomy->rewrite['slug'];
			}

			/* Get parent pages by path if they exist. */
			if ( $swm_bc_path ) {
				$swm_bc_trail = array_merge( $swm_bc_trail, swm_breadcrumb_trail_get_parents( '', $swm_bc_path ) );
			}

			/* If the taxonomy is hierarchical, list its parent terms. */
			if ( is_taxonomy_hierarchical( $term->taxonomy ) && $term->parent ) {
				$swm_bc_trail = array_merge( $swm_bc_trail, swm_breadcrumb_trail_get_term_parents( $term->parent, $term->taxonomy ) );
			}

			/* Add the term name to the trail end. */
			$swm_bc_trail['trail_end'] = single_term_title( '', false );
		}

		/* If viewing a post type archive. */
		elseif ( is_post_type_archive() ) {

			if ( SWM_WOOCOMMERCE_IS_ACTIVE ) {

				if ( is_shop() ) {
					$swm_bc_trail['trail_end'] = woocommerce_page_title($echo = false);
				}

			} else {

				/* Get the post type object. */
				$swm_post_type_object = get_post_type_object( get_query_var( 'post_type' ) );

				/* If $front has been set, add it to the $swm_bc_path. */
				if ( $swm_post_type_object->rewrite['with_front'] && $wp_rewrite->front )
					$swm_bc_path .= trailingslashit( $wp_rewrite->front );

				/* If there's a slug, add it to the $swm_bc_path. */
				if ( !empty( $swm_post_type_object->rewrite['slug'] ) )
					$swm_bc_path .= $swm_post_type_object->rewrite['slug'];

				/* If there's a path, check for parents. */
				if ( !empty( $swm_bc_path ) )
					$swm_bc_trail = array_merge( $swm_bc_trail, swm_breadcrumb_trail_get_parents( '', $swm_bc_path ) );

				/* Add the post type [plural] name to the trail end. */
				$swm_bc_trail['trail_end'] = $swm_post_type_object->labels->name;

			}

		}

		/* If viewing an author archive. */
		elseif ( is_author() ) {

			/* If $front has been set, add it to $swm_bc_path. */
			if ( !empty( $wp_rewrite->front ) ) {
				$swm_bc_path .= trailingslashit( $wp_rewrite->front );
			}

			/* If an $author_base exists, add it to $swm_bc_path. */
			if ( !empty( $wp_rewrite->author_base ) ) {
				$swm_bc_path .= $wp_rewrite->author_base;
			}

			/* If $swm_bc_path exists, check for parent pages. */
			if ( !empty( $swm_bc_path ) ) {
				$swm_bc_trail = array_merge( $swm_bc_trail, swm_breadcrumb_trail_get_parents( '', $swm_bc_path ) );
			}

			/* Add the author's display name to the trail end. */
			$swm_bc_trail['trail_end'] = get_the_author_meta( 'display_name', get_query_var( 'author' ) );
		}

		/* If viewing a time-based archive. */
		elseif ( is_time() ) {

			if ( get_query_var( 'minute' ) && get_query_var( 'hour' ) ) {
				$swm_bc_trail['trail_end'] = get_the_time( esc_html__( 'g:i a', 'bizix' ) );
			} elseif ( get_query_var( 'minute' ) ) {
				$swm_bc_trail['trail_end'] = sprintf( esc_html__( 'Minute %1$s', 'bizix' ), get_the_time( esc_html__( 'i', 'bizix' ) ) );
			} elseif ( get_query_var( 'hour' ) ) {
				$swm_bc_trail['trail_end'] = get_the_time( esc_html__( 'g a', 'bizix' ) );
			}
		}

		/* If viewing a date-based archive. */
		elseif ( is_date() ) {

			/* If $front has been set, check for parent pages. */
			if ( $wp_rewrite->front ) {
				$swm_bc_trail = array_merge( $swm_bc_trail, swm_breadcrumb_trail_get_parents( '', $wp_rewrite->front ) );
			}

			if ( is_day() ) {
				$swm_bc_trail[] = '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '" title="' . get_the_time( esc_attr__( 'Y', 'bizix' ) ) . '">' . get_the_time( esc_html__( 'Y', 'bizix' ) ) . '</a>';
				$swm_bc_trail[] = '<a href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '" title="' . get_the_time( esc_attr__( 'F', 'bizix' ) ) . '">' . get_the_time( esc_html__( 'F', 'bizix' ) ) . '</a>';
				$swm_bc_trail['trail_end'] = get_the_time( esc_html__( 'd', 'bizix' ) );
			}

			elseif ( get_query_var( 'w' ) ) {
				$swm_bc_trail[] = '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '" title="' . get_the_time( esc_attr__( 'Y', 'bizix' ) ) . '">' . get_the_time( esc_html__( 'Y', 'bizix' ) ) . '</a>';
				$swm_bc_trail['trail_end'] = sprintf( esc_html__( 'Week %1$s', 'bizix' ), get_the_time( esc_attr__( 'W', 'bizix' ) ) );
			}

			elseif ( is_month() ) {
				$swm_bc_trail[] = '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '" title="' . get_the_time( esc_attr__( 'Y', 'bizix' ) ) . '">' . get_the_time( esc_html__( 'Y', 'bizix' ) ) . '</a>';
				$swm_bc_trail['trail_end'] = get_the_time( esc_html__( 'F', 'bizix' ) );
			}

			elseif ( is_year() ) {
				$swm_bc_trail['trail_end'] = get_the_time( esc_html__( 'Y', 'bizix' ) );
			}
		}
	}

	/* If viewing search results. */
	elseif ( is_search() ) {
		$swm_bc_trail['trail_end'] = sprintf( esc_html__( 'Search results for &quot;%1$s&quot;', 'bizix' ), esc_attr( get_search_query() ) );
	}

	/* If viewing a 404 error page. */
	elseif ( is_404() ) {
		$swm_bc_trail['trail_end'] = esc_html__( '404 Error', 'bizix');
	}


	/* Allow devs to step in and filter the $swm_bc_trail array. */
	return apply_filters( 'breadcrumb_trail_items', $swm_bc_trail, $args );
}

function swm_breadcrumb_trail_map_rewrite_tags( $post_id = '', $swm_bc_path = '', $args = array() ) {

	/* Set up an empty $swm_bc_trail array. */
	$swm_bc_trail = array();

	/* Make sure there's a $swm_bc_path and $post_id before continuing. */
	if ( empty( $swm_bc_path ) || empty( $post_id ) ) {
		return $swm_bc_trail;
	}

	/* Get the post based on the post ID. */
	$post = get_post( $post_id );

	/* If no post is returned, an error is returned, or the post does not have a 'post' post type, return. */
	if ( empty( $post ) || is_wp_error( $post ) || 'post' !== $post->post_type ) {
		return $swm_bc_trail;
	}

	/* Trim '/' from both sides of the $swm_bc_path. */
	$swm_bc_path = trim( $swm_bc_path, '/' );

	/* Split the $swm_bc_path into an array of strings. */
	$swm_bc_matches = explode( '/', $swm_bc_path );

	/* If matches are found for the path. */
	if ( is_array( $swm_bc_matches ) ) {

		/* Loop through each of the matches, adding each to the $swm_bc_trail array. */
		foreach ( $swm_bc_matches as $swm_bc_match ) {

			/* Trim any '/' from the $swm_bc_match. */
			$tag = trim( $swm_bc_match, '/' );

			/* If using the %year% tag, add a link to the yearly archive. */
			if ( '%year%' == $tag ) {
				$swm_bc_trail[] = '<a href="' . get_year_link( get_the_time( 'Y', $post_id ) ) . '" title="' . get_the_time( esc_attr__( 'Y', 'bizix' ), $post_id ) . '">' . get_the_time( esc_html__( 'Y', 'bizix' ), $post_id ) . '</a>';
			}
			/* If using the %monthnum% tag, add a link to the monthly archive. */
			elseif ( '%monthnum%' == $tag ) {
				$swm_bc_trail[] = '<a href="' . get_month_link( get_the_time( 'Y', $post_id ), get_the_time( 'm', $post_id ) ) . '" title="' . get_the_time( esc_attr__( 'F Y', 'bizix' ), $post_id ) . '">' . get_the_time( esc_html__( 'F', 'bizix' ), $post_id ) . '</a>';
			}
			/* If using the %day% tag, add a link to the daily archive. */
			elseif ( '%day%' == $tag ){
				$swm_bc_trail[] = '<a href="' . get_day_link( get_the_time( 'Y', $post_id ), get_the_time( 'm', $post_id ), get_the_time( 'd', $post_id ) ) . '" title="' . get_the_time( esc_attr__( 'F j, Y', 'bizix' ), $post_id ) . '">' . get_the_time( esc_html__( 'd', 'bizix' ), $post_id ) . '</a>';
			}
			/* If using the %author% tag, add a link to the post author archive. */
			elseif ( '%author%' == $tag ) {
				$swm_bc_trail[] = '<a href="' . get_author_posts_url( $post->post_author ) . '" title="' . esc_attr( get_the_author_meta( 'display_name', $post->post_author ) ) . '">' . get_the_author_meta( 'display_name', $post->post_author ) . '</a>';
			}

			/* If using the %category% tag, add a link to the first category archive to match permalinks. */
			elseif ( '%category%' == $tag && 'category' !== $args["singular_{$post->post_type}_taxonomy"] ) {

				/* Get the post categories. */
				$terms = get_the_category( $post_id );

				/* Check that categories were returned. */
				if ( $terms ) {

					/* Sort the terms by ID and get the first category. */
					usort( $terms, '_usort_terms_by_ID' );
					$term = get_term( $terms[0], 'category' );

					/* If the category has a parent, add the hierarchy to the trail. */
					if ( 0 !== $term->parent ) {
						$swm_bc_trail = array_merge( $swm_bc_trail, swm_breadcrumb_trail_get_term_parents( $term->parent, 'category' ) );
					}

					/* Add the category archive link to the trail. */
					$swm_bc_trail[] = '<a href="' . get_term_link( $term, 'category' ) . '" title="' . esc_attr( $term->name ) . '">' . esc_html($term->name) . '</a>';
				}
			}
		}
	}

	/* Return the $swm_bc_trail array. */
	return $swm_bc_trail;
}

function swm_breadcrumb_trail_get_parents( $post_id = '', $swm_bc_path = '' ) {

	/* Set up an empty trail array. */
	$swm_bc_trail = array();

	/* Trim '/' off $swm_bc_path in case we just got a simple '/' instead of a real path. */
	$swm_bc_path = trim( $swm_bc_path, '/' );

	/* If neither a post ID nor path set, return an empty array. */
	if ( empty( $post_id ) && empty( $swm_bc_path ) ) {
		return $swm_bc_trail;
	}

	/* If the post ID is empty, use the path to get the ID. */
	if ( empty( $post_id ) ) {

		/* Get parent post by the path. */
		$swm_bc_parent_page = get_page_by_path( $swm_bc_path );

		/* If a parent post is found, set the $post_id variable to it. */
		if ( !empty( $swm_bc_parent_page ) )
			$post_id = $swm_bc_parent_page->ID;
	}

	/* If a post ID and path is set, search for a post by the given path. */
	if ( $post_id == 0 && !empty( $swm_bc_path ) ) {

		/* Separate post names into separate paths by '/'. */
		$swm_bc_path = trim( $swm_bc_path, '/' );
		preg_match_all( "/\/.*?\z/", $swm_bc_path, $swm_bc_matches );

		/* If matches are found for the path. */
		if ( isset( $swm_bc_matches ) ) {

			/* Reverse the array of matches to search for posts in the proper order. */
			$swm_bc_matches = array_reverse( $swm_bc_matches );

			/* Loop through each of the path matches. */
			foreach ( $swm_bc_matches as $swm_bc_match ) {

				/* If a match is found. */
				if ( isset( $swm_bc_match[0] ) ) {

					/* Get the parent post by the given path. */
					$swm_bc_path = str_replace( $swm_bc_match[0], '', $swm_bc_path );
					$swm_bc_parent_page = get_page_by_path( trim( $swm_bc_path, '/' ) );

					/* If a parent post is found, set the $post_id and break out of the loop. */
					if ( !empty( $swm_bc_parent_page ) && $swm_bc_parent_page->ID > 0 ) {
						$post_id = $swm_bc_parent_page->ID;
						break;
					}
				}
			}
		}
	}

	/* While there's a post ID, add the post link to the $swm_bc_parents array. */
	while ( $post_id ) {

		/* Get the post by ID. */
		$page = get_page( $post_id );

		/* Add the formatted post link to the array of parents. */
		$swm_bc_parents[]  = '<a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( get_the_title( $post_id ) ) . '">' . get_the_title( $post_id ) . '</a>';

		/* Set the parent post's parent to the post ID. */
		$post_id = $page->post_parent;
	}

	/* If we have parent posts, reverse the array to put them in the proper order for the trail. */
	if ( isset( $swm_bc_parents ) ) {
		$swm_bc_trail = array_reverse( $swm_bc_parents );
	}

	/* Return the trail of parent posts. */
	return $swm_bc_trail;
}

function swm_breadcrumb_trail_get_term_parents( $swm_bc_parent_id = '', $taxonomy = '' ) {

	/* Set up some default arrays. */
	$swm_bc_trail = array();
	$swm_bc_parents = array();

	/* If no term parent ID or taxonomy is given, return an empty array. */
	if ( empty( $swm_bc_parent_id ) || empty( $taxonomy ) ) {
		return $swm_bc_trail;
	}

	/* While there is a parent ID, add the parent term link to the $swm_bc_parents array. */
	while ( $swm_bc_parent_id ) {

		/* Get the parent term. */
		$swm_bc_parent = get_term( $swm_bc_parent_id, $taxonomy );

		/* Add the formatted term link to the array of parent terms. */
		$swm_bc_parents[] = '<a href="' . get_term_link( $swm_bc_parent, $taxonomy ) . '" title="' . esc_attr( $swm_bc_parent->name ) . '">' . esc_html($swm_bc_parent->name) . '</a>';

		/* Set the parent term's parent as the parent ID. */
		$swm_bc_parent_id = $swm_bc_parent->parent;
	}

	/* If we have parent terms, reverse the array to put them in the proper order for the trail. */
	if ( !empty( $swm_bc_parents ) ) {
		$swm_bc_trail = array_reverse( $swm_bc_parents );
	}

	/* Return the trail of parent terms. */
	return $swm_bc_trail;
}