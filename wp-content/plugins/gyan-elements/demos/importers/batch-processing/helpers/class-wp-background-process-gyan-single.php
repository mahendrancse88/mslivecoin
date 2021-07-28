<?php
if ( class_exists( 'WP_Background_Process' ) ) :
	class WP_Background_Process_Gyan_Single extends WP_Background_Process {
		protected $action = 'gyan_sites_single_page';

		protected function task( $object ) {
			$page_id = $object['page_id'];
			$process = $object['instance'];
			if ( method_exists( $process, 'import_single_post' ) ) {
				$process->import_single_post( $page_id );
			}
			return false;
		}

		protected function complete() {
			gyan_sites_error_log( 'Complete' );
			parent::complete();
			do_action( 'gyan_sites_image_import_complete' );
		}

	}
endif;