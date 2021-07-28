<?php
if ( ! class_exists( 'Gyan_Sites_Batch_Processing_Widgets' ) ) :
	class Gyan_Sites_Batch_Processing_Widgets {
		private static $instance;
		public static function get_instance() { if ( ! isset( self::$instance ) ) {self::$instance = new self(); } return self::$instance; }
		public function __construct() { }

		public function import() {
			if ( defined( 'WP_CLI' ) ) {
				WP_CLI::line( 'Importing Widgets Data' );
			}
			$this->widget_media_image();
		}

		public function widget_media_image() {
			$data = get_option( 'widget_media_image', null );

			Gyan_Sites_Importer_Log::add( '---- Processing Images from Widgets -----' );
			foreach ( $data as $key => $value ) {

				if ( isset( $value['url'] ) && isset( $value['attachment_id'] ) ) {
					$image = array(
						'url' => $value['url'],
						'id'  => $value['attachment_id'],
					);

					$downloaded_image = Gyan_Sites_Image_Importer::get_instance()->import( $image );

					$data[ $key ]['url']           = $downloaded_image['url'];
					$data[ $key ]['attachment_id'] = $downloaded_image['id'];

					if ( defined( 'WP_CLI' ) ) {
						WP_CLI::line( 'Importing Widgets Image: ' . $value['url'] . ' | New Image ' . $downloaded_image['url'] );
					}
				}
			}

			update_option( 'widget_media_image', $data );
		}
	}

	Gyan_Sites_Batch_Processing_Widgets::get_instance();
endif;