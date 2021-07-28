<?php
class gyan_Love {

	function __construct() {
		add_action( 'wp_ajax_gyan_love', array( &$this, 'ajax' ) );
		add_action( 'wp_ajax_nopriv_gyan_love', array( &$this, 'ajax' ) );
		add_action( 'wp_ajax_gyan_love_randomize', array( &$this, 'randomize' ) );
		add_action( 'wp_ajax_nopriv_gyan_love_randomize', array( &$this, 'randomize' ) );
	}

	public static function ajax( $post_id ) {

		if ( isset( $_POST['post_id'] ) ) {
			echo self::love( intval($_POST['post_id']), 'update' );
		}
		else {
			echo self::love( intval($_POST['post_id']), 'get' );
		}

		exit;
	}

	public static function randomize( ){

		$gyan_post_type = htmlspecialchars(stripslashes($_POST['post_type']));

		$gyan_array_posts = get_posts(array(
			'posts_per_page' 	=> -1,
			'post_type' 		=> $gyan_post_type ? $gyan_post_type : false,
		));

		if( is_array( $gyan_array_posts ) ){
			foreach( $gyan_array_posts as $post ){
				$gyan_love_count = rand( 10, 100 );	// Random number of loves [min:10, max:100]
				update_post_meta( $post->ID, 'gyan-post-love', $gyan_love_count );
			}

			_e( 'Love randomized',  'shanti-elements' );
		}

		exit;
	}

	public static function love( $post_id, $action = 'get' ) {
		if ( ! is_numeric( $post_id ) ) return;

		switch ( $action ) {

		case 'get':
			$gyan_love_count = get_post_meta( $post_id, 'gyan-post-love', true );
			if ( !$gyan_love_count ) {
				$gyan_love_count = 0;
				add_post_meta( $post_id, 'gyan-post-love', $gyan_love_count, true );
			}

			return $gyan_love_count;
			break;

		case 'update':
			$gyan_love_count = get_post_meta( $post_id, 'gyan-post-love', true );
			if ( isset( $_COOKIE['gyan-post-love-'. $post_id] ) ) { return $gyan_love_count; }

			$gyan_love_count++;
			update_post_meta( $post_id, 'gyan-post-love', $gyan_love_count );
			setcookie( 'gyan-post-love-'. $post_id, $post_id, time()*20, '/' );

			return $gyan_love_count;
			break;

		}
	}

	public static function get($show = 'all') {
		global $post;

		$output = self::love( $post->ID );
		$class = '';
		if ( isset( $_COOKIE['gyan-post-love-'. $post->ID] ) ) {
			$class = 'loved';
		}

		if ( $show == 'icon_number' ) {
			return '<div class="gyan_love_icontext"><a href="#" class="gyan-love '. $class .'" data-id="'. $post->ID .'"><i class="fas fa-heart fas-regular"></i><i class="fas fa-heart"></i><span class="gyan_postmeta_text gyan-like-number">'. $output .'</span></a></div>';
		} elseif ( $show == 'number' ) {
			return $output;
		} else {
			return '<span class="gyan-love '. $class .'" data-id="'. $post->ID .'"><i class="fas fa-heart fas-regular"></i><i class="fas fa-heart"></i><span class="gyan-like-number">'. $output .'</span></span>';
		}

	}

}

new gyan_Love();

function gyan_love( $return = '' ) {
	return gyan_Love::get();
}

function gyan_love_icon( $return = '' ) {
	return gyan_Love::get($show='icon_number');
}

function gyan_get_love_number( $return = '' ) {
	return gyan_Love::get($show='number');
}