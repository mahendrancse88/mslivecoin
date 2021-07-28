<?php
if ( class_exists( 'WP_Background_Process' ) ) :
	class WP_Background_Process_Gyan extends WP_Background_Process {
		protected $action = 'image_process';
		protected function task( $process ) {
			if ( method_exists( $process, 'import' ) ) {
				$process->import();
			}
			return false;
		}

		protected function complete() {
			parent::complete();
			Gyan_Sites_Importer_Log::add( 'Batch Process Complete!' );
			delete_option( 'gyan_sites_recent_import_log_file' ); // Delete Log file.
			do_action( 'gyan_sites_image_import_complete' );
		}

	}
endif;