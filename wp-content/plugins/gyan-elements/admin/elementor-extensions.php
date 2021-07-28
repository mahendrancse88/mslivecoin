<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SWM_Addons_Settings {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'gyan_add_submenu' ),550 );
	}

	public function gyan_add_submenu() {

		add_action( 'admin_init', array( $this, 'gyan_settings_group') );
		add_option( 'gyan_map_apikey', '' );
		add_option( 'gyan_mailchimp', [
			'apikey'	=> '',
			'list_id'	=> '',
		] );

		add_submenu_page( 'swm-theme-panel', esc_html__('Add-Ons Settings','gyan-elements'), esc_html__('Add-Ons Settings','gyan-elements'), 'edit_theme_options', 'gyan-addons-settings', array( $this, 'gyan_page_content' ),1 );

	}

	public function gyan_settings_group() {

		register_setting( 'gyan_settings_group', 'gyan_map_apikey' );
		register_setting( 'gyan_settings_group', 'gyan_addons' );
		register_setting( 'gyan_settings_group', 'gyan_mailchimp' );

		add_settings_section( 'gyan_api_section', '', '', 'gyan_addons_settings' );
		add_settings_field( 'gyan_google_map_key', esc_html__('Google Map API Key', 'gyan-elements'), array( $this, 'gyan_map_api_key'), 'gyan_addons_settings', 'gyan_api_section' );

		add_settings_field( 'gyan_mailchimp_key', esc_html__('MailChimp API Key', 'gyan-elements'), array( $this, 'gyan_mail_chimp_key'), 'gyan_addons_settings', 'gyan_api_section' );
		add_settings_field( 'gyan_mailchimp_list_id', esc_html__('MailChimp List Id', 'gyan-elements'), array( $this, 'gyan_mail_chimp_list_id'), 'gyan_addons_settings', 'gyan_api_section' );

		global $gyan_addons_list;

		foreach ( $gyan_addons_list as $cat => $addons ) {
			$section = 'gyan_'.$cat.'_widgets_section';
			$page = 'gyan_addons_'.$cat;
			add_settings_section( $section, '', '', $page );

			foreach ($addons as $addon => $status) {
				add_settings_field(
					'gyan_'.str_replace('-', '_', $addon),
					__(ucwords( str_replace('-', ' ', $addon) ), 'gyan-elements'),
					array( $this, 'gyan_addons_ac_dc'),
					$page, $section,['widget' => $addon, 'cat' => $cat]
				);
			}
		}
	}

	public function gyan_page_content() {
		?>
		<div class="wrap">
			<h1><?php echo esc_html__( 'Gyan Add-Ons Settings', 'gyan-elements' ); ?></h1>
		</div>

		<?php
		if ( ! did_action( 'elementor/loaded' ) ) {

			$message = sprintf(
				/* translators: 1: Plugin name 2: Elementor */
				esc_html__( 'Please install and activate  "%1$s" plugin to manage Add-Ons.', 'gyan-elements' ),
				'<a href="https://wordpress.org/plugins/elementor/" target="_blank">' . esc_html__( 'Elementor', 'gyan-elements' ) . '</a>' );

			echo '<div class="notice notice-warning is-dismissible"><p>'.$message.'</p></div>';
			return;
		}
		?>

		<form action="options.php" method="post">
			<?php settings_errors(); ?>

			<div class="gyan-widget-options">
				<p><?php echo esc_html__( 'You can disable the element if you would like to not using on your site.', 'gyan-elements' ); ?></p>
				<?php

					global $gyan_addons_list;

					foreach ($gyan_addons_list as $cat => $data) {
						printf("<div class='gyan-widget-cats'><h2>%s Add-Ons</h2>", __( ucfirst($cat), 'gyan-elements' ));
						do_settings_sections( 'gyan_addons_'.$cat );
						echo '</div>';
					}
					settings_fields( 'gyan_settings_group' );
					submit_button();
				?>
			</div>

			<hr>

			<div class='gyan-widget-section' id="gyan-addons-api-settings">
			<h2><?php echo esc_html__( 'API Settings', 'gyan-elements' ); ?></h2>

			<?php do_settings_sections( 'gyan_addons_settings' ); ?>

			<?php
			if (  '' == get_option( 'gyan_map_apikey' ) ) {
				echo '<p>' . sprintf(
				esc_html__( '"%1$s" to create your own free Google Maps API key.', 'gyan-elements' ),
				'<a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">' . esc_html__( 'Click here', 'gyan-elements' ) . '</a>' ) . '</p>';
			}
			?>

			</div>

			<?php submit_button(); ?>
		</form>
		<?php
	}

	public function gyan_map_api_key() {
		?>
		<input type="text" class="regular-text" name="gyan_map_apikey" value="<?php echo esc_attr( get_option( 'gyan_map_apikey' ) ); ?>">
		<?php
	}

	public function gyan_mail_chimp_key() {
		?>
		<input type="text" class="regular-text" name="gyan_mailchimp[apikey]" value="<?php echo esc_attr( get_option( 'gyan_mailchimp' )['apikey'] ); ?>">
		<?php
	}

	public function gyan_mail_chimp_list_id() {
		?>
		<input type="text" class="regular-text" name="gyan_mailchimp[list_id]" value="<?php echo esc_attr( get_option( 'gyan_mailchimp' )['list_id'] ); ?>">
		<?php
	}

	public function gyan_addons_ac_dc($data) {
		$widget 		= $data['widget'];
		$cat 			= $data['cat'];
		$name 			= 'gyan-'.$widget;
		$option_name	= 'gyan_addons';
		$checkbox 		= get_option( $option_name );
		$checked		= isset( $checkbox[ $cat ][ $widget ] ) && 1 == $checkbox[ $cat ][ $widget ]  ? 'checked' : '';

		echo '<div class="gyan-widget-toggle"><input type="checkbox" id="'. $name .'" name="'.$option_name.'['.$cat.']['. $widget .']" value="1" '. $checked.'><label for="'. $name .'"><div></div></label></div>';
	}


}

new SWM_Addons_Settings();