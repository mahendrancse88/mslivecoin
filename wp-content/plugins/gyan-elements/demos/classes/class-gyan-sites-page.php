<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( 'Gyan_Sites_Page' ) ) {

	class Gyan_Sites_Page {

		public $view_actions = array();
		private static $instance;
		public static function get_instance() { if ( ! isset( self::$instance ) ) {self::$instance = new self(); } return self::$instance; }

		public function __construct() {
			if ( ! is_admin() ) { return; }
			add_action( 'after_setup_theme', array( $this, 'init_admin_settings' ), 99 );
			add_action( 'wp_ajax_gyan-sites-change-page-builder', array( $this, 'save_page_builder_on_ajax' ) );
			add_action( 'admin_init', array( $this, 'save_page_builder_on_submit' ) );
			add_action( 'admin_notices', array( $this, 'getting_started' ) );
			add_action( 'admin_body_class', array( $this, 'admin_body_class' ) );
		}

		// Admin Body Classes
		public function admin_body_class( $classes = '' ) {
			$is_page_builder_screen = isset( $_GET['change-page-builder'] ) ? true : false; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$current_page_builder   = self::get_instance()->get_setting( 'page_builder' );

			if ( $is_page_builder_screen || empty( $current_page_builder ) ) {
				return $classes . ' gyan-sites-change-page-builder ';
			}
			return $classes;
		}

		// Admin notice
		public function getting_started() {
			$current_screen = get_current_screen();
			if ( ! is_object( $current_screen ) && null === $current_screen ) { return; }  // Bail if not on Sites screen.

			if ( 'theme-panel_page_demo-templates' === $current_screen->base ) {
				$manual_sync = get_site_option( 'gyan-sites-manual-sync-complete', 'no' );
				if ( 'yes' === $manual_sync ) {
					$status = get_site_option( 'gyan-sites-batch-is-complete', 'no' );
					if ( 'yes' === $status ) {
						?>
						<div class="gyan-sites-sync-library-message success gyan-sites-notice  notice notice-success is-dismissible">
							<p><?php Gyan_Sites::get_instance()->get_sync_complete_message( true ); ?></p>
						</div>
						<?php
					}
				}
			}

		}

		// Save Page Builder
		public function save_page_builder_on_submit( $page_builder_slug = '' ) {
			if ( ! defined( 'WP_CLI' ) && ! current_user_can( 'manage_options' ) ) { return; }
			if ( ! defined( 'WP_CLI' ) && ( ! isset( $_REQUEST['gyan-sites-page-builder'] ) || ! wp_verify_nonce( $_REQUEST['gyan-sites-page-builder'], 'gyan-sites-welcome-screen' ) ) ) { return; }

			$stored_data = $this->get_settings(); // Stored Settings.
			$page_builder = isset( $_REQUEST['page_builder'] ) ? sanitize_key( $_REQUEST['page_builder'] ) : sanitize_key( $page_builder_slug );

			if ( ! empty( $page_builder ) ) {
				$new_data = array('page_builder' => $page_builder );   // New settings.
				$data = wp_parse_args( $new_data, $stored_data );      // Merge settings.
				update_option( 'gyan_sites_settings', $data, 'no' );  // Update settings.
			}

			if ( ! defined( 'WP_CLI' ) ) {
				wp_safe_redirect( admin_url( '/themes.php?page=demo-templates' ) );
				exit();
			}
		}

		// Save Page Builder
		public function save_page_builder_on_ajax() {
			if ( ! current_user_can( 'manage_options' ) ) { wp_send_json_error(); }
			$stored_data = $this->get_settings(); // Stored Settings.

			// New settings.
			$new_data = array(
				'page_builder' => ( isset( $_REQUEST['page_builder'] ) ) ? sanitize_key( $_REQUEST['page_builder'] ) : '', // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			);

			$data = wp_parse_args( $new_data, $stored_data ); // Merge settings.
			update_option( 'gyan_sites_settings', $data, 'no' ); // Update settings.

			$sites = $this->get_sites_by_page_builder( $new_data['page_builder'] );
			wp_send_json_success( $sites );
		}

		// Get Page Builder Sites
		public function get_sites_by_page_builder( $default_page_builder = '' ) {
			$sites_and_pages            = Gyan_Sites::get_instance()->get_all_sites();
			$current_page_builder_sites = array();
			if ( ! empty( $sites_and_pages ) ) {
				$page_builder_keys = wp_list_pluck( $sites_and_pages, 'gyan-site-page-builder' );
				foreach ( $page_builder_keys as $site_id => $page_builder ) {
					if ( $default_page_builder === $page_builder ) {
						$current_page_builder_sites[ $site_id ] = $sites_and_pages[ $site_id ];
					}
				}
			}
			return $current_page_builder_sites;
		}

		// Get single setting value
		public function get_setting( $key = '', $defaults = '' ) {
			$settings = $this->get_settings();
			if ( empty( $settings ) ) { return $defaults; }
			if ( array_key_exists( $key, $settings ) ) { return $settings[ $key ]; }
			return $defaults;
		}

		// Get Settings
		public function get_settings() {
			$defaults = array('page_builder' => 'elementor');
			$stored_data = get_option( 'gyan_sites_settings', $defaults );
			return wp_parse_args( $stored_data, $defaults );
		}

		// Update Settings
		public function update_settings( $args = array() ) {
			$stored_data = get_option( 'gyan_sites_settings', array() );
			$new_data = wp_parse_args( $args, $stored_data );
			update_option( 'gyan_sites_settings', $new_data, 'no' );
		}

		// Admin settings init
		public function init_admin_settings() {
			add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
			add_action( 'admin_notices', array( $this, 'notices' ) );
			add_action( 'gyan_sites_menu_general_action', array( $this, 'general_page' ) );
		}

		// Admin notice
		public function notices() {
			$current_screen = get_current_screen();
			if ( ! is_object( $current_screen ) && null === $current_screen ) { return; } // Bail if not on Sites screen.
			if ( 'theme-panel_page_demo-templates' !== $current_screen->id ) { return; }
			if ( ! class_exists( 'XMLReader' ) ) { ?>
				<div class="notice gyan-sites-xml-notice gyan-sites-notice  notice-error">
					<p><b><?php esc_html_e( 'Required XMLReader PHP extension is missing on your server!', 'gyan-elements' ); ?></b></p>
					<?php /* translators: %s is the white label name. */ ?>
					<p><?php esc_html_e( 'Demo templates import requires XMLReader extension to be installed. Please contact your web hosting provider and ask them to install and activate the XMLReader PHP extension.', 'gyan-elements' ); ?></p>
				</div><?php
			}
		}

		// Init Nav Menu
		public function init_nav_menu( $action = '' ) {
			if ( '' !== $action ) { $this->render_tab_menu( $action ); }
		}

		public function render_tab_menu( $action = '' ) { ?>
			<div id="gyan-sites-menu-page">
				<?php $this->render( $action ); ?>
			</div> <?php
		}

		// Prints HTML content for tabs
		public function render( $action ) {

			// Settings update message.
			if ( isset( $_REQUEST['message'] ) && ( 'saved' === $_REQUEST['message'] || 'saved_ext' === $_REQUEST['message'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				?>
					<span id="message" class="notice gyan-sites-notice  notice-success is-dismissive"><p> <?php esc_html_e( 'Settings saved successfully.', 'gyan-elements' ); ?> </p></span>
				<?php
			}

			$current_slug = isset( $_GET['page'] ) ? esc_attr( $_GET['page'] ) : 'demo-templates'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$default_page_builder = $this->get_setting( 'page_builder' );

			?>
				<div class="nav-tab-wrapper">
					<div class="logo">
						<div class="gyan-sites-logo-wrap">
							<img src="<?php echo esc_url( GYAN_PLUGIN_URI . 'demos/assets/images/logo.svg' ); ?>">
						</div>
					</div>

					<div class="back-to-layout" title="Back to Layout"><i class="dashicons-arrow-left-alt2 dashicons"></i></div>
					<div id="gyan-sites-filters" class="hide-on-mobile">
						<?php $this->site_filters(); ?>
					</div>
					<div class="form">
						<div class="filters-wrap header-actions">
							<div class="filters-slug">
								<ul class="filter-links">
									<li>
										<a title="<?php esc_html_e( 'Refresh Demos', 'gyan-elements' ); ?>" href="#" class="gyan-sites-sync-library-button"><i class="dashicons dashicons-update-alt"></i> Refresh Demos
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div><!-- .nav-tab-wrapper -->
				<div id="gyan-sites-filters" class="hide-on-desktop">
					<?php $this->site_filters(); ?>
				</div>
				<?php

		}

		// Site Filters
		public function site_filters() {
			?>
			<div class="wp-filter hide-if-no-js">
				<div class="section-left">
					<div class="search-form">
							<div class="gyn-wp-filter-search-input-wrap">
								<input autocomplete="off" placeholder="<?php esc_html_e( 'Search...', 'gyan-elements' ); ?>" type="search" aria-describedby="live-search-desc" id="wp-filter-search-input" class="wp-filter-search">
								<span class="search-icon dashicons dashicons-search"></span>
							</div>

							<?php
							$categories = Gyan_Sites::get_instance()->get_api_option( 'gyan-sites-categories' );
							if ( ! empty( $categories ) ) {
								?>
							<div id="gyan-sites__category-filter" class="dropdown-check-list" tabindex="100">
								<span class="gyan-sites__category-filter-anchor" data-slug=""><?php esc_html_e( 'All', 'gyan-elements' ); ?></span>
								<ul class="gyan-sites__category-filter-items">
									<li class="gyn-sites__filter-wrap category-active" data-slug=""><?php esc_html_e( 'All', 'gyan-elements' ); ?> </li>
								<?php
								foreach ( $categories as $key => $value ) {  ?>
									<li class="gyn-sites__filter-wrap" data-slug="<?php echo esc_attr( $value['slug'] ); ?>"><?php echo esc_html( $value['name'] ); ?> </li>
									<?php
								}
								?>
								</ul>
							</div>
								<?php
							}
							?>

							<div class="gyan-sites-autocomplete-result"></div>
					</div>
				</div>
			</div>
			<?php
		}

		// Get Default Page Builder
		public function get_default_page_builder() {
			$default_page_builder = $this->get_setting( 'page_builder' );
			$page_builders = Gyan_Sites::get_instance()->get_page_builders();

			foreach ( $page_builders as $key => $page_builder ) {
				if ( $page_builder['slug'] === $default_page_builder ) {
					return $page_builder;
				}
			}

			return '';
		}

		// Page Builder List
		public function get_page_builders() {
			return array(
				'elementor'      => array(
					'slug'      => 'elementor',
					'name'      => esc_html__( 'Elementor', 'gyan-elements' ),
					'image_url' => GYAN_PLUGIN_URI . 'demos/assets/images/elementor.jpg',
				)
			);
		}

		// Get and return page URL
		public function get_page_url( $menu_slug ) {

			$current_slug = isset( $_GET['page'] ) ? esc_attr( $_GET['page'] ) : 'demo-templates'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$parent_page  = 'themes.php';

			if ( strpos( $parent_page, '?' ) !== false ) {
				$query_var = '&page=' . $current_slug;
			} else {
				$query_var = '?page=' . $current_slug;
			}

			$parent_page_url = admin_url( $parent_page . $query_var );
			$url = $parent_page_url . '&action=' . $menu_slug;

			return esc_url( $url );
		}

		public function add_admin_menu() {
			$page_title = apply_filters( 'gyan_sites_menu_page_title', esc_html__( 'Demo Templates', 'gyan-elements' ) );
			add_submenu_page( 'swm-theme-panel', $page_title, $page_title, 'edit_theme_options', 'demo-templates', array( $this, 'menu_callback' ),6 );
		}

		// Menu callback
		public function menu_callback() {
			$current_slug = isset( $_GET['action'] ) ? esc_attr( $_GET['action'] ) : 'general'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$active_tab   = str_replace( '_', '-', $current_slug );
			?>
			<div class="gyan-sites-menu-page-wrapper">
				<?php $this->init_nav_menu( $active_tab ); ?>
				<?php do_action( 'gyan_sites_menu_general_action' ); ?>
			</div>
			<?php
		}

		// Include general page
		public function general_page() {
			$default_page_builder = $this->get_setting( 'page_builder' );
			if ( empty( $default_page_builder ) || isset( $_GET['change-page-builder'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				return;
			}

			$global_cpt_meta = array(
				'category_slug' => 'gyan-site-category',
				'cpt_slug'      => 'gyan-sites',
				'page_builder'  => 'gyan-site-page-builder',
			);
			require_once GYAN_PLUGIN_DIR . 'demos/includes/admin-page.php';
		}

		// Converts a period of time in seconds into a human-readable format representing the interval.
		public function interval( $since ) {
			$chunks = array(
				array( 60 * 60 * 24 * 365, _n_noop( '%s year', '%s years', 'gyan-elements' ) ),
				array( 60 * 60 * 24 * 30, _n_noop( '%s month', '%s months', 'gyan-elements' ) ),
				array( 60 * 60 * 24 * 7, _n_noop( '%s week', '%s weeks', 'gyan-elements' ) ),
				array( 60 * 60 * 24, _n_noop( '%s day', '%s days', 'gyan-elements' ) ),
				array( 60 * 60, _n_noop( '%s hour', '%s hours', 'gyan-elements' ) ),
				array( 60, _n_noop( '%s minute', '%s minutes', 'gyan-elements' ) ),
				array( 1, _n_noop( '%s second', '%s seconds', 'gyan-elements' ) ),
			);
			if ( $since <= 0 ) { return esc_html__( 'now', 'gyan-elements' ); }

			$j = count( $chunks );
			for ( $i = 0; $i < $j; $i++ ) {
				$seconds = $chunks[ $i ][0];
				$name    = $chunks[ $i ][1];
				$count = floor( $since / $seconds );
				if ( $count ) {
					break;
				}
			}
			$output = sprintf( translate_nooped_plural( $name, $count, 'gyan-elements' ), $count );
			if ( $i + 1 < $j ) {
				$seconds2 = $chunks[ $i + 1 ][0];
				$name2    = $chunks[ $i + 1 ][1];
				$count2   = floor( ( $since - ( $seconds * $count ) ) / $seconds2 );
				if ( $count2 ) {
					$output .= ' ' . sprintf( translate_nooped_plural( $name2, $count2, 'gyan-elements' ), $count2 );
				}
			}
			return $output;
		}

		// Check Cron Status
		public static function test_cron( $cache = true ) {
			global $wp_version;

			if ( defined( 'DISABLE_WP_CRON' ) && DISABLE_WP_CRON ) {
				return new WP_Error( 'wp_portfolio_cron_error', esc_html__( 'ERROR! Cron schedules are disabled by setting constant DISABLE_WP_CRON to true.<br/>To start the import process please enable the cron by setting the constant to false. E.g. define( \'DISABLE_WP_CRON\', false );', 'gyan-elements' ) );
			}
			if ( defined( 'ALTERNATE_WP_CRON' ) && ALTERNATE_WP_CRON ) {
				return new WP_Error( 'wp_portfolio_cron_error', esc_html__( 'ERROR! Cron schedules are disabled by setting constant ALTERNATE_WP_CRON to true.<br/>To start the import process please enable the cron by setting the constant to false. E.g. define( \'ALTERNATE_WP_CRON\', false );', 'gyan-elements' ) );
			}

			$cached_status = get_transient( 'gyan-portfolio-cron-test-ok' );
			if ( $cache && $cached_status ) { return true; }

			$sslverify     = version_compare( $wp_version, 4.0, '<' );
			$doing_wp_cron = sprintf( '%.22F', microtime( true ) );

			$cron_request = apply_filters(
				'cron_request',
				array(
					'url'  => site_url( 'wp-cron.php?doing_wp_cron=' . $doing_wp_cron ),
					'key'  => $doing_wp_cron,
					'args' => array(
						'timeout'   => 3,
						'blocking'  => true,
						'sslverify' => apply_filters( 'https_local_ssl_verify', $sslverify ),
					),
				)
			);

			$cron_request['args']['blocking'] = true;
			$result = wp_remote_post( $cron_request['url'], $cron_request['args'] );

			if ( is_wp_error( $result ) ) {
				return $result;
			} elseif ( wp_remote_retrieve_response_code( $result ) >= 300 ) {
				return new WP_Error(
					'unexpected_http_response_code',
					sprintf(__( 'Unexpected HTTP response code: %s', 'gyan-elements' ), intval( wp_remote_retrieve_response_code( $result ) ) ) ); /* translators: 1: The HTTP response code. */
			} else {
				set_transient( 'gyan-portfolio-cron-test-ok', 1, 3600 );
				return true;
			}

		}
	}

	Gyan_Sites_Page::get_instance();

} // End if.