<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class GYAN_Posts_Helper {

    public static function get_post_categories() {

        $options = array();

        $terms = get_terms( array(
            'taxonomy'      => 'category',
            'hide_empty'    => true,
        ));

        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
            foreach ( $terms as $term ) {
                $options[ $term->term_id ] = $term->name;
            }
        }

        return $options;
    }

    public static function get_post_types() {

        $post_types = get_post_types(
			array(
				'public'            => true,
				'show_in_nav_menus' => true
			),
			'objects'
		);

		$options = array();

		foreach ( $post_types as $post_type ) {
			$options[ $post_type->name ] = $post_type->label;
		}

		return $options;
    }

    public static function get_all_posts() {

        $post_list = get_posts( array(
            'post_type'         => 'post',
            'orderby'           => 'date',
            'order'             => 'DESC',
            'posts_per_page'    => -1,
        ) );

        $posts = array();

        if ( ! empty( $post_list ) && ! is_wp_error( $post_list ) ) {
            foreach ( $post_list as $post ) {
               $posts[ $post->ID ] = $post->post_title;
            }
        }

        return $posts;
    }

    public static function get_all_posts_by_type( $post_type ) {

        $post_list = get_posts( array(
            'post_type'         => $post_type,
            'orderby'           => 'date',
            'order'             => 'DESC',
            'posts_per_page'    => -1,
        ) );

        $posts = array();

        if ( ! empty( $post_list ) && ! is_wp_error( $post_list ) ) {
            foreach ( $post_list as $post ) {
               $posts[ $post->ID ] = $post->post_title;
            }
        }

        return $posts;
    }

	public static function get_post_taxonomies( $post_type ) {

		$taxonomies = get_object_taxonomies( $post_type, 'objects' );
		$data       = array();

		foreach ( $taxonomies as $tax_slug => $tax ) {

			if ( ! $tax->public || ! $tax->show_ui ) {
				continue;
			}

			$data[ $tax_slug ] = $tax;
		}

		return apply_filters( 'gyan_post_loop_taxonomies', $data, $taxonomies, $post_type );
	}

	public static function get_users() {

        $users = get_users();
        $user_list = array();

		if ( empty( $users ) ) {
			return $user_list;
		}

        foreach ( $users as $user ) {
            $user_list[ $user->ID ] = $user->display_name;
        }

        return $user_list;
    }

	public static function get_post_tags() {

        $options = array();

        $tags = get_tags();

        foreach ( $tags as $tag ) {
            $options[ $tag->term_id ] = $tag->name;
        }

        return $options;
    }

	public static function custom_excerpt( $limit = '' ) {

        $excerpt = explode(' ', get_the_excerpt(), $limit);

        if ( count( $excerpt ) >= $limit ) {
            array_pop( $excerpt );
            $excerpt = implode( " ", $excerpt ).'...';
        } else {
            $excerpt = implode( " ", $excerpt );
        }

        $excerpt = preg_replace( '`[[^]]*]`', '', $excerpt );

        return $excerpt;
    }

}