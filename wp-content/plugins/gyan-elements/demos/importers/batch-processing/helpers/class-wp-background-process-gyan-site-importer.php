<?php
if ( class_exists( 'WP_Background_Process' ) ) :
	class WP_Background_Process_Gyan_Site_Importer extends WP_Background_Process {
		protected $action = 'gyan_site_importer';
		protected function task( $object ) {
			$process = $object['instance'];
			$method  = $object['method'];
			if ( 'import_page_builders' === $method ) {
				gyan_sites_error_log( '-------- Importing Page Builders --------' );
				update_site_option( 'gyan-sites-batch-status-string', 'Importing Page Builders', 'no' );
				$process->import_page_builders();
			} elseif ( 'import_categories' === $method ) {
				gyan_sites_error_log( '-------- Importing Tags --------' );
				update_site_option( 'gyan-sites-batch-status-string', 'Importing Tags', 'no' );
				$process->import_categories();
			} elseif ( 'import_sites' === $method ) {
				gyan_sites_error_log( '-------- Importing Sites --------' );
				$page = $object['page'];
				gyan_sites_error_log( 'Inside Batch ' . $page );
				update_site_option( 'gyan-sites-batch-status-string', 'Inside Batch ' . $page, 'no' );
				$process->import_sites( $page );
			} elseif ( 'import_blocks' === $method ) {
				gyan_sites_error_log( '-------- Importing Blocks --------' );
				$page = $object['page'];
				gyan_sites_error_log( 'Inside Batch ' . $page );
				update_site_option( 'gyan-sites-batch-status-string', 'Inside Batch ' . $page, 'no' );
				$process->import_blocks( $page );
			} elseif ( 'import_block_categories' === $method ) {
				gyan_sites_error_log( '-------- Importing Blocks Categories --------' );
				update_site_option( 'gyan-sites-batch-status-string', 'Importing Blocks Categories', 'no' );
				$process->import_block_categories();
			} elseif ( 'import_site_categories' === $method ) {
				gyan_sites_error_log( '-------- Importing Site Categories --------' );
				update_site_option( 'gyan-sites-batch-status-string', 'Importing Site Categories', 'no' );
				$process->import_site_categories();
			}
			return false;
		}

		protected function complete() {
			parent::complete();
			gyan_sites_error_log( esc_html__( 'All processes are complete', 'gyan-elements' ) );
			update_site_option( 'gyan-sites-batch-status-string', 'All processes are complete', 'no' );
			delete_site_option( 'gyan-sites-batch-status' );
			update_site_option( 'gyan-sites-batch-is-complete', 'yes', 'no' );
			do_action( 'gyan_sites_site_import_batch_complete' );
		}

	}
endif;