<?php
use Elementor\Utils;
if ( class_exists( 'Gyan_Sites_Elementor_Images' ) ) { return; }  // If plugin - 'Elementor' not exist then return.
class Gyan_Sites_Elementor_Images {
	private static $instance = null;
	public static function get_instance() { if ( ! isset( self::$instance ) ) {self::$instance = new self(); } return self::$instance; }

	// Import Image
	public function get_attachment_data( $image ) {
		if ( ! empty( $image ) ) {
			return array(
				'content' => array(
					array(
						'id'       => \Elementor\Utils::generate_random_string(),
						'elType'   => 'section',
						'settings' => array(),
						'isInner'  => false,
						'elements' => array(
							array(
								'id'       => \Elementor\Utils::generate_random_string(),
								'elType'   => 'column',
								'elements' => array(
									array(
										'id'         => \Elementor\Utils::generate_random_string(),
										'elType'     => 'widget',
										'settings'   => array(
											'image'      => array(
												'url' => wp_get_attachment_url( $image ),
												'id'  => $image,
											),
											'image_size' => 'full',
										),
										'widgetType' => 'image',
									),
								),
								'isInner'  => false,
							),
						),
					),
				),
			);
		}
		return array();
	}
}
Gyan_Sites_Elementor_Images::get_instance();