<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
class Gyan_WXR_Importer {

	private static $instance = null;
	public static function instance() { if ( ! isset( self::$instance ) ) {self::$instance = new self(); } return self::$instance; }

	private function __construct() {
		require_once ABSPATH . '/wp-admin/includes/class-wp-importer.php';
		require_once GYAN_PLUGIN_DIR . 'demos/importers/wxr-importer/class-wp-importer-logger.php';
		require_once GYAN_PLUGIN_DIR . 'demos/importers/wxr-importer/class-wp-importer-logger-serversentevents.php';
		require_once GYAN_PLUGIN_DIR . 'demos/importers/wxr-importer/class-wxr-importer.php';
		require_once GYAN_PLUGIN_DIR . 'demos/importers/wxr-importer/class-wxr-import-info.php';

		add_filter( 'upload_mimes', array( $this, 'custom_upload_mimes' ) );
		add_action( 'wp_ajax_gyan-wxr-import', array( $this, 'sse_import' ) );
		add_filter( 'wxr_importer.pre_process.user', '__return_null' );
		add_filter( 'wp_import_post_data_processed', array( $this, 'pre_post_data' ), 10, 2 );
		add_filter( 'wxr_importer.pre_process.post', array( $this, 'pre_process_post' ), 10, 4 );
		if ( version_compare( get_bloginfo( 'version' ), '5.1.0', '>=' ) ) {
			add_filter( 'wp_check_filetype_and_ext', array( $this, 'real_mime_types_5_1_0' ), 10, 5 );
		} else {
			add_filter( 'wp_check_filetype_and_ext', array( $this, 'real_mime_types' ), 10, 4 );
		}
	}

	public function track_post( $post_id = 0, $data = array() ) {
		Gyan_Sites_Importer_Log::add( 'Inserted - Post ' . $post_id . ' - ' . get_post_type( $post_id ) . ' - ' . get_the_title( $post_id ) );

		update_post_meta( $post_id, '_gyan_sites_imported_post', true );
		update_post_meta( $post_id, '_gyan_sites_enable_for_batch', true );

		// Set the full width template for the pages.
		if ( isset( $data['post_type'] ) && 'page' === $data['post_type'] ) {
			$is_elementor_page = get_post_meta( $post_id, '_elementor_version', true );
			$get_wp_page_template = get_post_meta( $post_id, '_wp_page_template', true );

			if ( $is_elementor_page ) {
				update_post_meta( $post_id, '_wp_page_template', 'elementor_header_footer' );
			}

			// If page template is not defined then set as default template
			if ( '' == $get_wp_page_template ) {
				update_post_meta( $post_id, '_wp_page_template', '' );
			}

		} elseif ( isset( $data['post_type'] ) && 'attachment' === $data['post_type'] ) {
			$remote_url          = isset( $data['guid'] ) ? $data['guid'] : '';
			$attachment_hash_url = Gyan_Sites_Image_Importer::get_instance()->get_hash_image( $remote_url );
			if ( ! empty( $attachment_hash_url ) ) {
				update_post_meta( $post_id, '_gyan_sites_image_hash', $attachment_hash_url );
				update_post_meta( $post_id, '_elementor_source_image_hash', $attachment_hash_url );
			}
		}

	}

	public function track_term( $term_id ) {
		$term = get_term( $term_id );
		if ( $term ) {
			Gyan_Sites_Importer_Log::add( 'Inserted - Term ' . $term_id . ' - ' . wp_json_encode( $term ) );
		}
		update_term_meta( $term_id, '_gyan_sites_imported_term', true );
	}

	public function pre_post_data( $postdata, $data ) {
		$postdata['guid'] = '';  // Skip GUID field which point to the https://websitedemos.net.
		return $postdata;
	}

	public function pre_process_post( $data, $meta, $comments, $terms ) {
		if ( isset( $data['post_content'] ) ) {
			$meta_data = wp_list_pluck( $meta, 'key' );
			$is_attachment          = ( 'attachment' === $data['post_type'] ) ? true : false;
			$is_elementor_page      = in_array( '_elementor_version', $meta_data, true ); // Blog blank excerpt issue fix
			$disable_post_content = apply_filters( 'gyan_sites_pre_process_post_disable_content', ( $is_attachment ) ); // ( ... || $is_elementor_page )

			// If post type is `attachment OR If page contain Elementor meta then skip this page.
			if ( $disable_post_content ) {
				$data['post_content'] = '';
			} else {
				$data['post_content'] = wp_slash( $data['post_content'] ); // Gutenberg Content Data Fix
			}
		}
		return $data;
	}

	public function real_mime_types_5_1_0( $defaults, $file, $filename, $mimes, $real_mime ) {
		return $this->real_mimes( $defaults, $filename );
	}

	public function real_mime_types( $defaults, $file, $filename, $mimes ) {
		return $this->real_mimes( $defaults, $filename );
	}

	public function real_mimes( $defaults, $filename ) {

		// Set EXT and real MIME type only for the file name `wxr.xml`.
		if ( strpos( $filename, 'wxr' ) !== false ) {
			$defaults['ext']  = 'xml';
			$defaults['type'] = 'text/xml';
		}

		return $defaults;
	}

	public function fix_image_duplicate_issue( $data, $meta, $comments, $terms ) {
		$remote_url   = ! empty( $data['attachment_url'] ) ? $data['attachment_url'] : $data['guid'];
		$data['guid'] = $remote_url;
		return $data;
	}

	public function enable_wp_image_editor_gd( $editors ) {
		$gd_editor = 'WP_Image_Editor_GD';
		$editors   = array_diff( $editors, array( $gd_editor ) );
		array_unshift( $editors, $gd_editor );
		return $editors;
	}

	// Constructor
	public function sse_import( $xml_url = '' ) {
		if ( wp_doing_ajax() ) {
			check_ajax_referer( 'gyan-sites', '_ajax_nonce' );  // Verify Nonce.

			// @codingStandardsIgnoreStart. Start the event stream.
			header( 'Content-Type: text/event-stream, charset=UTF-8' );
			// Turn off PHP output compression.
			$previous = error_reporting( error_reporting() ^ E_WARNING );
			ini_set( 'output_buffering', 'off' );
			ini_set( 'zlib.output_compression', false );
			error_reporting( $previous );

			if ( $GLOBALS['is_nginx'] ) {
				// Setting this header instructs Nginx to disable fastcgi_buffering and disable gzip for this request.
				header( 'X-Accel-Buffering: no' );
				header( 'Content-Encoding: none' );
			}
			// @codingStandardsIgnoreEnd

			echo esc_html( ':' . str_repeat( ' ', 2048 ) . "\n\n" );  // 2KB padding for IE.
		}

		$xml_id = isset( $_REQUEST['xml_id'] ) ? absint( $_REQUEST['xml_id'] ) : '';
		if ( ! empty( $xml_id ) ) { $xml_url = get_attached_file( $xml_id ); }
		if ( empty( $xml_url ) ) { exit; }

		if ( ! wp_doing_ajax() ) {
			set_time_limit( 0 );  // Time to run the import!
			wp_ob_end_flush_all();  // Ensure we're not buffered.
			flush();
		}

		add_filter( 'wp_image_editors', array( $this, 'enable_wp_image_editor_gd' ) );  // Enable default GD library.
		add_filter( 'wxr_importer.pre_process.post', array( $this, 'fix_image_duplicate_issue' ), 10, 4 );  // Change GUID image URL.
		add_filter( 'wxr_importer.pre_process.user', '__return_null' );  // Are we allowed to create users?

		// Keep track of our progress.
		add_action( 'wxr_importer.processed.post', array( $this, 'imported_post' ), 10, 2 );
		add_action( 'wxr_importer.process_failed.post', array( $this, 'imported_post' ), 10, 2 );
		add_action( 'wxr_importer.process_already_imported.post', array( $this, 'already_imported_post' ), 10, 2 );
		add_action( 'wxr_importer.process_skipped.post', array( $this, 'already_imported_post' ), 10, 2 );
		add_action( 'wxr_importer.processed.comment', array( $this, 'imported_comment' ) );
		add_action( 'wxr_importer.process_already_imported.comment', array( $this, 'imported_comment' ) );
		add_action( 'wxr_importer.processed.term', array( $this, 'imported_term' ) );
		add_action( 'wxr_importer.process_failed.term', array( $this, 'imported_term' ) );
		add_action( 'wxr_importer.process_already_imported.term', array( $this, 'imported_term' ) );
		add_action( 'wxr_importer.processed.user', array( $this, 'imported_user' ) );
		add_action( 'wxr_importer.process_failed.user', array( $this, 'imported_user' ) );

		// Keep track of our progress.
		add_action( 'wxr_importer.processed.post', array( $this, 'track_post' ), 10, 2 );
		add_action( 'wxr_importer.processed.term', array( $this, 'track_term' ) );

		flush(); // Flush once more.

		$importer = $this->get_importer();
		$response = $importer->import( $xml_url );

		// Let the browser know we're done.
		$complete = array(
			'action' => 'complete',
			'error'  => false,
		);
		if ( is_wp_error( $response ) ) {
			$complete['error'] = $response->get_error_message();
		}

		$this->emit_sse_message( $complete );
		if ( wp_doing_ajax() ) {
			exit;
		}
	}

	public function custom_upload_mimes( $mimes ) {
		$mimes['svg']  = 'image/svg+xml';   	// Allow SVG files.
		$mimes['svgz'] = 'image/svg+xml';
		$mimes['xml'] = 'text/xml';				// Allow XML files.
		$mimes['json'] = 'application/json';	// Allow JSON files.
		return $mimes;
	}

	// Start the xml import
	public function get_xml_data( $path, $post_id ) {

		$args = array(
			'action'      => 'gyan-wxr-import',
			'id'          => '1',
			'_ajax_nonce' => wp_create_nonce( 'gyan-sites' ),
			'xml_id'      => $post_id,
		);
		$url  = add_query_arg( urlencode_deep( $args ), admin_url( 'admin-ajax.php' ) );
		$data = $this->get_data( $path );

		return array(
			'count'   => array(
				'posts'    => $data->post_count,
				'media'    => $data->media_count,
				'users'    => count( $data->users ),
				'comments' => $data->comment_count,
				'terms'    => $data->term_count,
			),
			'url'     => $url,
			'strings' => array(
				'complete' => __( 'Import complete!', 'gyan-elements' ),
			),
		);
	}

	// Get XML data
	public function get_data( $url ) {
		$importer = $this->get_importer();
		$data     = $importer->get_preliminary_information( $url );
		if ( is_wp_error( $data ) ) {
			return $data;
		}
		return $data;
	}

	public function get_importer() {
		$options = apply_filters(
			'gyan_sites_xml_import_options',
			array(
				'update_attachment_guids' => true,
				'fetch_attachments'       => true,
				'default_author'          => get_current_user_id(),
			)
		);
		$importer = new WXR_Importer( $options );
		$logger   = new WP_Importer_Logger_ServerSentEvents();
		$importer->set_logger( $logger );
		return $importer;
	}

	// Send message when a ...
	public function imported_post( $id, $data )    { $this->emit_sse_message(array('action' => 'updateDelta', 'type' => ( 'attachment' === $data['post_type'] ) ? 'media' : 'posts', 'delta'  => 1 ) ); } // post has been imported
	public function already_imported_post( $data ) { $this->emit_sse_message(array('action' => 'updateDelta', 'type' => ( 'attachment' === $data['post_type'] ) ? 'media' : 'posts', 'delta'  => 1 ) ); } // post is marked as already imported
	public function imported_comment()             { $this->emit_sse_message(array('action' => 'updateDelta', 'type' => 'comments', 'delta'  => 1 ) ); } // comment has been imported
	public function imported_term()                { $this->emit_sse_message(array('action' => 'updateDelta', 'type' => 'terms', 'delta'  => 1 ) ); } // term has been imported
	public function imported_user()                { $this->emit_sse_message(array('action' => 'updateDelta', 'type' => 'users', 'delta'  => 1 ) ); } // user has been imported

	// Emit a Server-Sent Events message
	public function emit_sse_message( $data ) {
		if ( wp_doing_ajax() ) {
			echo "event: message\n";
			echo 'data: ' . wp_json_encode( $data ) . "\n\n";
			echo esc_html( ':' . str_repeat( ' ', 2048 ) . "\n\n" );		// Extra padding.
		}
		flush();
	}

}

Gyan_WXR_Importer::instance();