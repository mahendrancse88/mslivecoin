<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Gyan_Customizer_Manager {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_menu_subpage' ) );
		add_action( 'admin_init', array( $this, 'theme_options_setting' ) );
		add_action('admin_enqueue_scripts', array(&$this, 'register_scripts') );
		add_action( 'wp_ajax_gyan-sites-plugin-activate', array( $this, 'required_plugin_activate' ) );
		add_action( 'wp_ajax_gyan-sites-plugin-deactivate', array( $this, 'required_plugin_deactivate' ) );
		if ( class_exists('CEI_Core') ) {
			add_filter( 'cei_export_option_keys', array( $this, 'export_option_keys' ) );
		}
	}

	public function add_menu_subpage() {
		add_submenu_page( 'swm-theme-panel', esc_html__('Customizer Manager','gyan-elements'), esc_html__('Customizer Manager','gyan-elements'), 'edit_theme_options', 'swm-customizer-manager', array( $this, 'gyan_customizer_manager_callback' ),3 );
	}

	// theme options settings page
	public function theme_options_setting(){

		// this code basically provides an area where you can register your fields
		add_settings_section('customizer_manager_section', '', '', 'customizer_manager_options');

		register_setting('customizer_manager_section','customizer_theme_panel');

		$gyan_customizer_all_options = array(
			'general'            =>	'1',
			'layout'             =>	'1',
			'styling'            =>	'1',
			'top-bar'            =>	'1',
			'header'             =>	'1',
			'sub-header'         =>	'1',
			'sidebar'            =>	'1',
			'footer'             =>	'1',
			'fonts'              =>	'1',
			'blog'               =>	'1',
			'page'               =>	'1',
			'portfolio'          =>	'1',
			'social-media-icons' => '1',
		);

		foreach ($gyan_customizer_all_options as $options => $status) {

			$settings_slug = str_replace('-', '_', $options);
			$settings_title = __(ucwords( str_replace('-', ' ', $options) ), 'gyan-elements');

			add_settings_field( $settings_slug, $settings_title, array( $this, 'get_customizer_options_html' ),'customizer_manager_options', 'customizer_manager_section',['customizer_field' => $settings_slug] );

		}

	}

	public function get_customizer_options_html($data) {
		$customizer_field = $data['customizer_field'];
		$options          = 'customizer_theme_panel';
		$get_option       = get_option( $options );
		$checked          = isset( $get_option[ $customizer_field ] ) && 1 == $get_option[ $customizer_field ]  ? 'checked' : '';

		$gyan_checkbox_current_status = 0;
		if ( $get_option === false ) {
		    // nothing is set, so apply the default here
		    $gyan_checkbox_current_status = 1;
		}
		else if( is_array( $get_option ) && isset( $get_option[$customizer_field] ) ) {
		    // gyan_checkbox_current_status is checked
		    $gyan_checkbox_current_status = $get_option[$customizer_field];
		}

		echo '<input class="gyan-customizer-editor-checkbox" type="checkbox" id="'. $customizer_field .'" name="customizer_theme_panel[' . $customizer_field . ']' . '" value="1" '. checked( $gyan_checkbox_current_status, 1, false ).'>
				';
	}

	public function gyan_customizer_manager_callback() {
		?>

		<div id="gyan-customizer-manager-admin-page" class="wrap">
			<h1 class="wp-heading-inline"><?php echo esc_html__('Customizer Manager','gyan-elements'); ?></h1>

			<div class="nav-tab-wrapper">
				<a class='nav-tab nav-tab-active' href='?page=swm-customizer-manager'><?php echo esc_html__('Customizer Manager','gyan-elements'); ?></a>
				<a class='nav-tab' href='customize.php' target="_blank"><?php echo esc_html__('Customizer','gyan-elements'); ?> <span class="dashicons dashicons-external"></span></a>
			</div>

			<p><?php echo esc_html__('Enable/Disable Customizer Options Panel. You can increase customizer load speed by disabling sections ( like Fonts, Social Media, etc. which requires one time settings ).','gyan-elements'); ?></p>

			<div class="gyan-check-uncheck">
				<a href="#" class="gyan-customizer-check-all"><?php esc_html_e( 'Check all', 'gyan-elements' ); ?></a> | <a href="#" class="gyan-customizer-uncheck-all"><?php esc_html_e( 'Uncheck all', 'gyan-elements' ); ?></a>
			</div>

			<form action="options.php" method="post">
				<div class="swm-customizer-manager-table"><?php
				settings_errors();
				settings_fields('customizer_manager_section');
				do_settings_sections('customizer_manager_options');
				submit_button();
				?>
				</div>
			</form>
		</div>
		<br>
		<hr>
		<br>

		<?php

		$current_screen = get_current_screen();
		if ( ! is_object( $current_screen ) && null === $current_screen ) { return; }  // Bail if not on Sites screen.

		if ( 'theme-panel_page_swm-customizer-manager' === $current_screen->base ) {
			$this->customizer_import_export_plugin_new();
		}

	}

	// ACTIVATE DEACTIVATE PLUGIN FUNCTIONS ###########

	public function customizer_import_export_plugin_new() {

		$recommended_plugins =
			array(
				'customizer-export-import' =>
					array(
						'plugin-name'        => esc_html__( 'Customizer Export/Import', 'gyan-elements' ),
						'plugin-init'        => 'customizer-export-import/customizer-export-import.php',
						'settings-link'      => '',
						'settings-link-text' => 'Settings',
					),
			);
			?>

			<h3>Customizer Export/Import</h3>
			<p><?php echo esc_html__('The Customizer Export/Import plugin allows you to export or import your WordPress customizer settings from directly within the customizer interface!','gyan-elements'); ?></p>
			<?php if ( is_plugin_active( 'customizer-export-import/customizer-export-import.php' ) ) { ?>
				<p class="gyan-customizer-ie-path"><?php echo wp_kses( __('You can Export or Import Customizer settings from <strong>Admin > Appearance > Customize > Export/Import</strong>','gyan-elements'),array(  'strong' => '' )); ?></p>
			<?php } ?>
			<p class="gyanAfterPluginActivationText notice notice-info is-dismissible" style="display:none;margin-left:0; padding:10px;"></p>
			<br>

						<?php
						if ( ! empty( $recommended_plugins ) ) :
							?>
							<div>
									<?php
									foreach ( $recommended_plugins as $slug => $plugin ) {

										$plugin_active_status = '';
										if ( is_plugin_active( $plugin['plugin-init'] ) ) {
											$plugin_active_status = ' active';
										}

										echo '<span ' . $this->gyan_attr(
											'gyan-recommended-plugin-' . esc_attr( $slug ),
											array(
												'id' => esc_attr( $slug ),
												'class' => 'gyan-recommended-plugin' . $plugin_active_status,
												'data-slug' => $slug,
											)
										) . '>';

										if ( ! is_plugin_active( $plugin['plugin-init'] ) ) {

											if ( file_exists( WP_CONTENT_DIR . '/plugins/' . $plugin['plugin-init'] ) ) {
												echo '<a ' . $this->gyan_attr(
													'gyan-activate-recommended-plugin',
													array(
														'data-slug' => $slug,
														'href' => '#',
														"class" => "gyan-activate-recommended-plugin button button-primary", // testing
														'data-init' => $plugin['plugin-init'],
														'data-settings-link' => esc_url( $plugin['settings-link'] ),
														'data-settings-link-text' => $plugin['settings-link-text'],
													)
												) . '>';

												esc_html_e( 'Activate Plugin', 'gyan-elements' );

												echo '</a>';

											} else {

												echo '<a ' . $this->gyan_attr(
													'gyan-install-recommended-plugin',
													array(
														'data-slug' => $slug,
														'href' => '#',
														"class" => "gyan-install-recommended-plugin button button-primary", // testing
														'data-init' => $plugin['plugin-init'],
														'data-settings-link' => esc_url( $plugin['settings-link'] ),
														'data-settings-link-text' => $plugin['settings-link-text'],
													)
												) . '>';

												esc_html_e( 'Activate Plugin', 'gyan-elements' );

												echo '</a>';
											}
										} else {

											echo '<a ' . $this->gyan_attr(
												'gyan-deactivate-recommended-plugin',
												array(
													'data-slug' => $slug,
													'href' => '#',
													"class" => "gyan-deactivate-recommended-plugin button button-secondary", // testing
													'data-init' => $plugin['plugin-init'],
													'data-settings-link' => esc_url( $plugin['settings-link'] ),
													'data-settings-link-text' => $plugin['settings-link-text'],
												)
											) . '>';

											esc_html_e( 'Deactivate Plugin', 'gyan-elements' );

											echo '</a>';

											if ( '' !== $plugin['settings-link'] ) {

												echo '<a ' . $this->gyan_attr(
													'gyan-recommended-plugin-links',
													array(
														'data-slug' => $slug,
														"class" => "gyan-recommended-plugin-links button button-secondary", // testing
														'href' => $plugin['settings-link'],
													)
												) . '>';

												echo esc_html( $plugin['settings-link-text'] );

												echo '</a>';
											}
										}

										echo '</span>';

									}
									?>
									<span style="margin-left:5px;"><a class="button button-secondary" href="https://wordpress.org/plugins/customizer-export-import/" target="_blank"><?php echo esc_html__('View Plugin Details', 'gyan-elements' ); ?></a></span>
							</div>
							<?php endif; ?>

		<?php
	}

	public function required_plugin_activate() {

		$nonce = ( isset( $_POST['nonce'] ) ) ? sanitize_key( $_POST['nonce'] ) : '';

		if ( false === wp_verify_nonce( $nonce, 'gyan-recommended-plugin-nonce' ) ) {
			wp_send_json_error( esc_html_e( 'WordPress Nonce not validated.', 'gyan-elements' ) );
		}

		if ( ! current_user_can( 'install_plugins' ) || ! isset( $_POST['init'] ) || ! sanitize_text_field( wp_unslash( $_POST['init'] ) ) ) {
			wp_send_json_error(
				array(
					'success' => false,
					'message' => __( 'No plugin specified', 'gyan-elements' ),
				)
			);
		}

		$plugin_init = ( isset( $_POST['init'] ) ) ? sanitize_text_field( wp_unslash( $_POST['init'] ) ) : '';

		$activate = activate_plugin( $plugin_init, '', false, true );

		if ( is_wp_error( $activate ) ) {
			wp_send_json_error(
				array(
					'success' => false,
					'message' => $activate->get_error_message(),
				)
			);
		}

		wp_send_json_success(
			array(
				'success' => true,
				'message' => __( 'Plugin Successfully Activated', 'gyan-elements' ),
			)
		);

	}

	public function required_plugin_deactivate() {

		$nonce = ( isset( $_POST['nonce'] ) ) ? sanitize_key( $_POST['nonce'] ) : '';

		if ( false === wp_verify_nonce( $nonce, 'gyan-recommended-plugin-nonce' ) ) {
			wp_send_json_error( esc_html_e( 'WordPress Nonce not validated.', 'gyan-elements' ) );
		}

		if ( ! current_user_can( 'install_plugins' ) || ! isset( $_POST['init'] ) || ! sanitize_text_field( wp_unslash( $_POST['init'] ) ) ) {
			wp_send_json_error(
				array(
					'success' => false,
					'message' => __( 'No plugin specified', 'gyan-elements' ),
				)
			);
		}

		$plugin_init = ( isset( $_POST['init'] ) ) ? sanitize_text_field( wp_unslash( $_POST['init'] ) ) : '';

		$deactivate = deactivate_plugins( $plugin_init, '', false );

		if ( is_wp_error( $deactivate ) ) {
			wp_send_json_error(
				array(
					'success' => false,
					'message' => $deactivate->get_error_message(),
				)
			);
		}

		wp_send_json_success(
			array(
				'success' => true,
				'message' => __( 'Plugin Successfully Deactivated', 'gyan-elements' ),
			)
		);

	}

	public function register_scripts() {

		$current_screen = get_current_screen();
		if ( ! is_object( $current_screen ) && null === $current_screen ) { return; }  // Bail if not on Sites screen.

		if ( 'theme-panel_page_swm-customizer-manager' === $current_screen->base ) {

			$gyan_min_js = get_option('swm_enable_minify_gyan_elements_js',true) ? '-min.js' : '.js';
			wp_enqueue_script( 'gyan-customizer-manager', GYAN_PLUGIN_URL . 'admin/js/customizer-manager'. $gyan_min_js, array( 'jquery', 'wp-util', 'updates' ), GYAN_ELEMENTS_VERSION, false );

			$data = array(
				'ajaxUrl'                            => admin_url( 'admin-ajax.php' ),
				'btnActivating'                      => esc_html__( 'Activating Importer Plugin ', 'gyan-elements' ) . '&hellip;',
				'gyanSitesLink'                     => admin_url( 'admin.php?page=' ),
				'gyanSitesLinkTitle'                => esc_html__( 'See Library &#187;', 'gyan-elements' ),
				'recommendedPluiginActivatingText'   => esc_html__( 'Activating', 'gyan-elements' ) . '&hellip;',
				'recommendedPluiginDeactivatingText' => esc_html__( 'Deactivating', 'gyan-elements' ) . '&hellip;',
				'recommendedPluiginActivateText'     => esc_html__( 'Activate Plugin', 'gyan-elements' ),
				'recommendedPluiginDeactivateText'   => esc_html__( 'Deactivate Plugin', 'gyan-elements' ),
				'recommendedPluiginSettingsText'     => esc_html__( 'Settings', 'gyan-elements' ),
				'gyanPluginManagerNonce'            => wp_create_nonce( 'gyan-recommended-plugin-nonce' ),
				'afterPluginActivationText'			=> wp_kses( __('You can Export or Import Customizer settings from <strong>Admin > Appearance > Customize > Export/Import</strong>','gyan-elements'),array(  'strong' => '' ))
			);

			wp_localize_script( 'gyan-customizer-manager', 'gyanPluginInstall', $data );

		}

	}

	public function gyan_attr( $context, $attributes = array(), $args = array() ) {

		$attributes = $this->gyan_parse_attr( $context, $attributes, $args );
		$output = '';

		// Cycle through attributes, build tag attribute string.
		foreach ( $attributes as $key => $value ) {

			if ( ! $value ) { continue; }

			if ( true === $value ) {
				$output .= esc_html( $key ) . ' ';
			} else {
				$output .= sprintf( '%s="%s" ', esc_html( $key ), esc_attr( $value ) );
			}
		}

		$output = apply_filters( "gyan_attr_{$context}_output", $output, $attributes, $context, $args );

		return trim( $output );
	}

	public function gyan_parse_attr( $context, $attributes = array(), $args = array() ) {

		$defaults = array(
			'class' => sanitize_html_class( $context ),
		);

		$attributes = wp_parse_args( $attributes, $defaults );

		// Contextual filter.
		return apply_filters( "gyan_attr_{$context}", $attributes, $context, $args );
	}

	public function export_option_keys( $keys ) {
	    $keys[] = 'gyan_map_apikey';
	    $keys[] = 'gyan_mailchimp';
	    $keys[] = 'gyan_mailchimp[list_id]';
	    return $keys;
	}

}

new Gyan_Customizer_Manager();