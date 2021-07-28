<?php
if (!function_exists('gyan_posttype_portfolio')) {
	function gyan_posttype_portfolio() {

		// register post types
		$labels = array(
			'name' => esc_html__( 'Portfolio', 'gyan-elements'),
			'singular_name' => esc_html__( 'Portfolio', 'gyan-elements'),
			'add_new' =>  esc_html__( 'Add New' , 'gyan-elements'),
			'add_new_item' => esc_html__('Add New Portfolio', 'gyan-elements'),
			'edit_item' => esc_html__('Edit Portfolio', 'gyan-elements'),
			'new_item' => esc_html__('New Portfolio Item', 'gyan-elements'),
			'view_item' => esc_html__('View Portfolio Item', 'gyan-elements'),
			'search_items' => esc_html__('Search Portfolio Items', 'gyan-elements'),
			'not_found' =>  esc_html__('No portfolio items found', 'gyan-elements'),
			'not_found_in_trash' => esc_html__('No portfolio items found in Trash', 'gyan-elements'),
			'parent_item_colon' => ''
		);

		$labels = apply_filters( 'gyan_portfolio_labels', $labels );
		$gyan_portfolio_slug = 'portfolio-item';
    	$gyan_portfolio_slug = apply_filters( 'gyan_portfolio_slug', $gyan_portfolio_slug );

		$args = array(
			'labels' => $labels,
			'public' => true,
			'exclude_from_search' => false,
			'publicly_queryable' => true,
			'rewrite' => array('slug' => $gyan_portfolio_slug),
			'show_ui' => true,
			'query_var' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'show_in_rest' => true,
			'supports' => array('title','editor','thumbnail','excerpt','revisions','custom-fields','comments','author','page-attributes')
		);

		register_post_type(__( 'portfolio' , 'gyan-elements'),$args);

		// register taxonomy
		$gyan_portfolio_category_slug	= 'portfolio_category';
    	$gyan_portfolio_category_slug	= apply_filters( 'gyan_portfolio_category_slug', $gyan_portfolio_category_slug );

		$portfolio_categories_name = esc_html__( 'Portfolio Categories', 'gyan-elements' );
		$portfolio_categories_name = apply_filters( 'gyan_portfolio_categories_name', $portfolio_categories_name );

		register_taxonomy("portfolio_category","portfolio",	array(
				'labels' => array(
					'name' => $portfolio_categories_name,
					'singular_name' => $portfolio_categories_name,
					'menu_name' => $portfolio_categories_name,
					'search_items' => esc_html__( 'Search','gyan-elements' ),
					'popular_items' => esc_html__( 'Popular', 'gyan-elements' ),
					'all_items' => esc_html__( 'All', 'gyan-elements' ),
					'parent_item' => esc_html__( 'Parent', 'gyan-elements' ),
					'parent_item_colon' => esc_html__( 'Parent', 'gyan-elements' ),
					'edit_item' => esc_html__( 'Edit', 'gyan-elements' ),
					'update_item' => esc_html__( 'Update', 'gyan-elements' ),
					'add_new_item' => esc_html__( 'Add New', 'gyan-elements' ),
					'new_item_name' => esc_html__( 'New', 'gyan-elements' ),
					'separate_items_with_commas' => esc_html__( 'Separate with commas', 'gyan-elements' ),
					'add_or_remove_items' => esc_html__( 'Add or remove', 'gyan-elements' ),
					'choose_from_most_used' => esc_html__( 'Choose from the most used', 'gyan-elements' ),
				),
				"hierarchical" => true,
				"query_var" => true,
				'show_in_rest' => true,
				"rewrite" => array(
					'slug' => $gyan_portfolio_category_slug,
					'hierarchical' => true,
					'with_front' => false
				)
		));

	}
}

add_action( 'init', 'gyan_posttype_portfolio' );

// register columns

add_filter("manage_edit-portfolio_columns", "gyan_posttype_portfolio_edit_columns");
if (!function_exists('gyan_posttype_portfolio_edit_columns')) {
	function gyan_posttype_portfolio_edit_columns($columns){
		$columns = array(
			"cb" 					=> "<input type=\"checkbox\" />",
			"title" 				=> esc_html__( 'Title' , 'gyan-elements'),
			"image" 				=> esc_html__( 'Image' , 'gyan-elements'),
			"portfolio_category" 	=> esc_html__( 'Category' , 'gyan-elements'),
			'date' 					=> esc_html__( 'Date', 'gyan-elements')
		);
		return $columns;
	}
}

// display columns

add_action("manage_posts_custom_column",  "gyan_custom_posts_display_column");
if (!function_exists('gyan_custom_posts_display_column')) {
	function gyan_custom_posts_display_column($column){
		global $post;
		switch ($column)  {

			case 'portfolio_category':
				echo wp_strip_all_tags( get_the_term_list($post->ID, 'portfolio_category', '', ', ',''));
				break;

			case 'image':
				echo '<a href="' . get_edit_post_link() . '">' . get_the_post_thumbnail($post->ID, array(80,80)) . '</a>';
				break;

		}
	}
}