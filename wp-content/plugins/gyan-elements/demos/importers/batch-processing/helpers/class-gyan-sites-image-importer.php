<?php
if ( ! class_exists( 'Gyan_Sites_Image_Importer' ) ) :
	class Gyan_Sites_Image_Importer {

		private static $instance;
		private $already_imported_ids = array();
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct() {
			if ( ! function_exists( 'WP_Filesystem' ) ) {
				require_once ABSPATH . 'wp-admin/includes/file.php';
			}
			WP_Filesystem();
		}

		public function process( $attachments ) {
			$downloaded_images = array();
			foreach ( $attachments as $key => $attachment ) {
				$downloaded_images[] = $this->import( $attachment );
			}
			return $downloaded_images;
		}

		public function get_hash_image( $attachment_url ) {
			return sha1( $attachment_url );
		}

		private function get_saved_image( $attachment ) {
			if ( apply_filters( 'gyan_sites_image_importer_skip_image', false, $attachment ) ) {
				Gyan_Sites_Importer_Log::add( 'BATCH - SKIP Image - {from filter} - ' . $attachment['url'] . ' - Filter name `gyan_sites_image_importer_skip_image`.' );
				return array(
					'status'     => true,
					'attachment' => $attachment,
				);
			}

			global $wpdb;

			// 1. Is already imported in Batch Import Process?
			$post_id = $wpdb->get_var(
				$wpdb->prepare(
					'SELECT `post_id` FROM `' . $wpdb->postmeta . '`
						WHERE `meta_key` = \'_gyan_sites_image_hash\'
							AND `meta_value` = %s
					;',
					$this->get_hash_image( $attachment['url'] )
				)
			);

			// 2. Is image already imported though XML?
			if ( empty( $post_id ) ) {

				// Get file name without extension. To check it exist in attachment.
				$filename = basename( $attachment['url'] );

				// Find the attachment by meta value. Code reused from Elementor plugin.
				$post_id = $wpdb->get_var(
					$wpdb->prepare(
						"SELECT post_id FROM {$wpdb->postmeta}
						WHERE meta_key = '_wp_attached_file'
						AND meta_value LIKE %s",
						'%/' . $filename . '%'
					)
				);

				Gyan_Sites_Importer_Log::add( 'BATCH - SKIP Image {already imported from xml} - ' . $attachment['url'] );
			}

			if ( $post_id ) {
				$new_attachment               = array(
					'id'  => $post_id,
					'url' => wp_get_attachment_url( $post_id ),
				);
				$this->already_imported_ids[] = $post_id;

				return array(
					'status'     => true,
					'attachment' => $new_attachment,
				);
			}

			return array(
				'status'     => false,
				'attachment' => $attachment,
			);
		}

		// Import Image
		public function import( $attachment ) {

			Gyan_Sites_Importer_Log::add( 'Source - ' . $attachment['url'] );
			$saved_image = $this->get_saved_image( $attachment );
			Gyan_Sites_Importer_Log::add( 'Log - ' . wp_json_encode( $saved_image['attachment'] ) );

			if ( $saved_image['status'] ) {
				return $saved_image['attachment'];
			}

			$file_content = wp_remote_retrieve_body(
				wp_safe_remote_get(
					$attachment['url'],
					array(
						'timeout'   => '60',
						'sslverify' => false,
					)
				)
			);

			// Empty file content?
			if ( empty( $file_content ) ) {
				Gyan_Sites_Importer_Log::add( 'BATCH - FAIL Image {Error: Failed wp_remote_retrieve_body} - ' . $attachment['url'] );
				return $attachment;
			}

			$filename = basename( $attachment['url'] );  // Extract the file name and extension from the URL.
			$upload = wp_upload_bits( $filename, null, $file_content );

			gyan_sites_error_log( $filename );
			gyan_sites_error_log( wp_json_encode( $upload ) );

			$post = array(
				'post_title' => $filename,
				'guid'       => $upload['url'],
			);
			gyan_sites_error_log( wp_json_encode( $post ) );

			$info = wp_check_filetype( $upload['file'] );
			if ( $info ) {
				$post['post_mime_type'] = $info['type'];
			} else {
				return $attachment;  // For now just return the origin attachment.
			}

			$post_id = wp_insert_attachment( $post, $upload['file'] );
			wp_update_attachment_metadata(
				$post_id,
				wp_generate_attachment_metadata( $post_id, $upload['file'] )
			);
			update_post_meta( $post_id, '_gyan_sites_image_hash', $this->get_hash_image( $attachment['url'] ) );

			Gyan_WXR_Importer::instance()->track_post( $post_id );

			$new_attachment = array(
				'id'  => $post_id,
				'url' => $upload['url'],
			);

			Gyan_Sites_Importer_Log::add( 'BATCH - SUCCESS Image {Imported} - ' . $new_attachment['url'] );

			$this->already_imported_ids[] = $post_id;

			return $new_attachment;
		}

		public function is_image_url( $url = '' ) {
			if ( empty( $url ) ) {
				return false;
			}

			if ( preg_match( '/^((https?:\/\/)|(www\.))([a-z0-9-].?)+(:[0-9]+)?\/[\w\-]+\.(jpg|png|svg|gif|jpeg)\/?$/i', $url ) ) {
				return true;
			}

			return false;
		}

	}

	Gyan_Sites_Image_Importer::get_instance();
endif;