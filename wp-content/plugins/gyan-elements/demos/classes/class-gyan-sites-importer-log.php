<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'Gyan_Sites_Importer_Log' ) ) :
	class Gyan_Sites_Importer_Log {
		private static $instance = null;
		private static $log_file = null;
		public static function get_instance() { if ( ! isset( self::$instance ) ) {self::$instance = new self(); } return self::$instance; }

		private function __construct() {
			add_action( 'admin_init', array( $this, 'has_file_read_write' ) );  // Check file read/write permissions.
		}

		public function has_file_read_write() {
			$upload_dir = self::log_dir();
			$file_created = Gyan_Sites::get_instance()->get_filesystem()->put_contents( $upload_dir['path'] . 'index.html', '' );
			if ( ! $file_created ) {
				add_action( 'admin_notices', array( $this, 'file_permission_notice' ) );
				return;
			}

			self::set_log_file(); // Set log file.
			add_action( 'gyan_sites_import_start', array( $this, 'start' ), 10, 2 );  // Initial AJAX Import Hooks.
		}

		public function file_permission_notice() {
			$upload_dir = self::log_dir();
			?>
			<div class="notice notice-error gyan-sites-must-notices gyan-sites-file-permission-issue">
				<p><?php esc_html_e( 'Required File Permissions to import the templates are missing.', 'gyan-elements' ); ?></p>
				<?php if ( defined( 'FS_METHOD' ) ) { ?>
					<p><?php esc_html_e( 'This is usually due to inconsistent file permissions.', 'gyan-elements' ); ?></p>
					<p><code><?php echo esc_html( $upload_dir['path'] ); ?></code></p>
				<?php } else { ?>
					<p><?php esc_html_e( 'You can easily update permissions by adding the following code into the wp-config.php file.', 'gyan-elements' ); ?></p>
					<p><code>define( 'FS_METHOD', 'direct' );</code></p>
				<?php } ?>
			</div>
			<?php
		}

		// Add log file URL in UI response
		public static function add_log_file_url() {
			$upload_dir   = self::log_dir();
			$upload_path  = trailingslashit( $upload_dir['url'] );
			$file_abs_url = get_option( 'gyan_sites_recent_import_log_file', self::$log_file );
			$file_url     = $upload_path . basename( $file_abs_url );

			return array(
				'abs_url' => $file_abs_url,
				'url'     => $file_url,
			);
		}

		// Current Time for log
		public static function current_time() {
			return gmdate( 'H:i:s' ) . ' ' . date_default_timezone_get();
		}

		// Import Start
		public function start( $data = array(), $demo_api_uri = '' ) {
			self::add( 'Started Import Process' );
			self::add( '# System Details: ' );
			self::add( "Debug Mode \t\t: " . self::get_debug_mode() );
			self::add( "Operating System \t: " . self::get_os() );
			self::add( "Software \t\t: " . self::get_software() );
			self::add( "MySQL version \t\t: " . self::get_mysql_version() );
			self::add( "XML Reader \t\t: " . self::get_xmlreader_status() );
			self::add( "PHP Version \t\t: " . self::get_php_version() );
			self::add( "PHP Max Input Vars \t: " . self::get_php_max_input_vars() );
			self::add( "PHP Max Post Size \t: " . self::get_php_max_post_size() );
			self::add( "PHP Extension GD \t: " . self::get_php_extension_gd() );
			self::add( "PHP Max Execution Time \t: " . self::get_max_execution_time() );
			self::add( "Max Upload Size \t: " . size_format( wp_max_upload_size() ) );
			self::add( "Memory Limit \t\t: " . self::get_memory_limit() );
			self::add( "Timezone \t\t: " . self::get_timezone() );
			self::add( PHP_EOL . '-----' . PHP_EOL );
			self::add( 'Importing Started! - ' . self::current_time() );
		}

		public static function get_log_file() {
			return self::$log_file;
		}

		// Log file directory
		public static function log_dir( $dir_name = 'gyan-elements' ) {
			$upload_dir = wp_upload_dir();

			// Build the paths.
			$dir_info = array(
				'path' => $upload_dir['basedir'] . '/' . $dir_name . '/',
				'url'  => $upload_dir['baseurl'] . '/' . $dir_name . '/',
			);

			// Create the upload dir if it doesn't exist.
			if ( ! file_exists( $dir_info['path'] ) ) {
				wp_mkdir_p( $dir_info['path'] );  // Create the directory.
				Gyan_Sites::get_instance()->get_filesystem()->put_contents( $dir_info['path'] . 'index.html', '' );  // Add an index file for security.
			}

			return $dir_info;
		}

		public static function set_log_file() {
			$upload_dir = self::log_dir();
			$upload_path = trailingslashit( $upload_dir['path'] );
			self::$log_file = $upload_path . 'import-' . gmdate( 'd-M-Y-h-i-s' ) . '.txt';  // File format e.g. 'import-31-Oct-2017-06-39-12.txt'.

			if ( ! get_option( 'gyan_sites_recent_import_log_file', false ) ) {
				update_option( 'gyan_sites_recent_import_log_file', self::$log_file );
			}
		}

		// Write content to a file
		public static function add( $content ) {
			if ( get_option( 'gyan_sites_recent_import_log_file', false ) ) {
				$log_file = get_option( 'gyan_sites_recent_import_log_file', self::$log_file );
			} else {
				$log_file = self::$log_file;
			}

			$existing_data = '';
			if ( file_exists( $log_file ) ) {
				$existing_data = Gyan_Sites::get_instance()->get_filesystem()->get_contents( $log_file );
			}

			$separator = PHP_EOL;  // Style separator.
			gyan_sites_error_log( $content );

			Gyan_Sites::get_instance()->get_filesystem()->put_contents( $log_file, $existing_data . $separator . $content, FS_CHMOD_FILE );
		}

		public static function get_debug_mode() {
			if ( WP_DEBUG ) {
				return __( 'Enabled', 'gyan-elements' );
			}
			return __( 'Disabled', 'gyan-elements' );
		}

		public static function get_memory_limit() {
			$required_memory                = '64M';
			$memory_limit_in_bytes_current  = wp_convert_hr_to_bytes( WP_MEMORY_LIMIT );
			$memory_limit_in_bytes_required = wp_convert_hr_to_bytes( $required_memory );

			if ( $memory_limit_in_bytes_current < $memory_limit_in_bytes_required ) {
				return sprintf(
					/* translators: %1$s Memory Limit, %2$s Recommended memory limit. */
					_x( 'Current memory limit %1$s. We recommend setting memory to at least %2$s.', 'Recommended Memory Limit', 'gyan-elements' ),
					WP_MEMORY_LIMIT,
					$required_memory
				);
			}

			return WP_MEMORY_LIMIT;
		}

		public static function get_timezone() {
			$timezone = get_option( 'timezone_string' );
			if ( ! $timezone ) {
				return get_option( 'gmt_offset' );
			}
			return $timezone;
		}

		public static function get_os() {
			return PHP_OS;
		}

		public static function get_software() {
			return $_SERVER['SERVER_SOFTWARE'];
		}

		public static function get_mysql_version() {
			global $wpdb;
			return $wpdb->db_version();
		}

		public static function get_xmlreader_status() {
			if ( class_exists( 'XMLReader' ) ) {
				return __( 'Yes', 'gyan-elements' );
			}
			return __( 'No', 'gyan-elements' );
		}

		public static function get_php_version() {
			if ( version_compare( PHP_VERSION, '5.4', '<' ) ) {
				return _x( 'We recommend to use php 5.4 or higher', 'PHP Version', 'gyan-elements' );
			}
			return PHP_VERSION;
		}

		public static function get_php_max_input_vars() {
			// @codingStandardsIgnoreStart
			return ini_get( 'max_input_vars' ); // phpcs:disable PHPCompatibility.IniDirectives.NewIniDirectives.max_input_varsFound
			// @codingStandardsIgnoreEnd
		}

		public static function get_php_max_post_size() {
			return ini_get( 'post_max_size' );
		}

		public static function get_max_execution_time() {
			return ini_get( 'max_execution_time' );
		}

		public static function get_php_extension_gd() {
			if ( extension_loaded( 'gd' ) ) {
				return __( 'Yes', 'gyan-elements' );
			}
			return __( 'No', 'gyan-elements' );
		}

		public function display_data() {

			$crons  = _get_cron_array();
			$events = array();

			if ( empty( $crons ) ) {
				esc_html_e( 'You currently have no scheduled cron events.', 'gyan-elements' );
			}

			foreach ( $crons as $time => $cron ) {
				$keys           = array_keys( $cron );
				$key            = $keys[0];
				$events[ $key ] = $time;
			}

			$expired = get_transient( 'gyan-sites-import-check' );
			if ( $expired ) {
				global $wpdb;
				$transient = 'gyan-sites-import-check';

				$transient_timeout = $wpdb->get_col(
					$wpdb->prepare(
						"SELECT option_value
					FROM $wpdb->options
					WHERE option_name
					LIKE %s",
						'%_transient_timeout_' . $transient . '%'
					)
				);

				$older_date       = $transient_timeout[0];
				$transient_status = 'Transient: Not Expired! Recheck in ' . human_time_diff( time(), $older_date );
			} else {
				$transient_status = 'Transient: Starting.. Process for each 5 minutes.';
			}
			$temp  = get_site_option( 'gyan-sites-batch-status-string', '' );
			$temp .= isset( $events['wp_gyan_site_importer_cron'] ) ? '<br/>Batch: Recheck batch in ' . human_time_diff( time(), $events['wp_gyan_site_importer_cron'] ) : '<br/>Batch: Not Started! Until the Transient expire.';

			$upload_dir   = self::get_instance()->log_dir();
			$list_files   = list_files( $upload_dir['path'] );
			$backup_files = array();
			$log_files    = array();
			foreach ( $list_files as $key => $file ) {
				if ( strpos( $file, '.json' ) ) {
					$backup_files[] = $file;
				}
				if ( strpos( $file, '.txt' ) ) {
					$log_files[] = $file;
				}
			}
			?>
			<table>
				<tr>
					<td>
						<h2>Log Files</h2>
						<ul>
							<?php
							foreach ( $log_files as $key => $file ) {
								$file_name = basename( $file );
								$file      = str_replace( $upload_dir['path'], $upload_dir['url'], $file );
								?>
								<li>
									<a target="_blank" href="<?php echo esc_attr( $file ); ?>"><?php echo esc_html( $file_name ); ?></a>
								</li>
							<?php } ?>
						</ul>
					</td>
					<td>
						<h2>Backup Files</h2>
						<ul>
							<?php
							foreach ( $backup_files as $key => $file ) {
								$file_name = basename( $file );
								$file      = str_replace( $upload_dir['path'], $upload_dir['url'], $file );
								?>
								<li>
									<a target="_blank" href="<?php echo esc_attr( $file ); ?>"><?php echo esc_html( $file_name ); ?></a>
								</li>
							<?php } ?>
						</ul>
					</td>
					<td>
						<div class="batch-log">
							<p><?php echo wp_kses_post( $temp ); ?></p>
							<p><?php echo wp_kses_post( $transient_status ); ?></p>
						</div>
					</td>
				</tr>
			</table>
			<?php
		}

	}

	Gyan_Sites_Importer_Log::get_instance();
endif;