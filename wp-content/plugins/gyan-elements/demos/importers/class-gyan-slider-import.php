<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
class Gyan_Slider_Import {
	private static $instance = null;
	public static function instance() { if ( ! isset( self::$instance ) ) { self::$instance = new self(); } return self::$instance; }

	// Import sliders
	public function import_sliders_data( $sliders ) {

		if ( class_exists( 'RevSlider' ) ) {
			$slider = new RevSlider();

			foreach($sliders as $filepath){
				$file = self::revSlider_tempDownload( $filepath );
				$slider->importSliderFromPost(true,true,$file);
			}

			return wp_send_json_success( $sliders );
		}

	}

	function revSlider_tempDownload( $url ) {
		$dir = wp_upload_dir();
		$temp = trailingslashit( $dir['basedir'] )  . basename( $url );
		file_put_contents( $temp, file_get_contents($url) );
		return $temp;
	}

}