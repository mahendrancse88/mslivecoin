<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Gyan_Header_Styles {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_menu_subpage' ) );
		add_action('admin_enqueue_scripts', array(&$this, 'register_scripts') );
		add_action( 'wp_ajax_gyan-import-header-style', array( $this, 'import_header_style' ) );
	}

	public function add_menu_subpage() {
		add_submenu_page( 'swm-theme-panel', esc_html__('Header Styles','gyan-elements'), esc_html__('Header Styles','gyan-elements'), 'edit_theme_options', 'swm-header-styles', array( $this, 'gyan_header_styles_callback' ),3 );
	}

	public function gyan_header_styles_callback() {
		?>

		<style type="text/css">
			.gyan-hs-input-hidden { position: absolute; left: -9999px; }
			input[type=radio]:checked + label>img { border: 2px solid #2271b1; -webkit-box-shadow: 0 0 30px rgba(0, 0, 0, .25); -khtml-box-shadow: 0 0 30px rgba(0, 0, 0, .25); -moz-box-shadow: 0 0 30px rgba(0, 0, 0, .25); -ms-box-shadow: 0 0 30px rgba(0, 0, 0, .25); -o-box-shadow: 0 0 30px rgba(0, 0, 0, .25); box-shadow: 0 0 30px rgba(0, 0, 0, .25);  }
			input[type=radio] + label>img { border: 2px solid #ddd; width:100%; max-width:1200px; transition: 500ms all; }
		</style>

		<div id="gyan-header-styles-admin-page" class="wrap">
			<h1 class="wp-heading-inline"><?php echo esc_html__('Header Styles','gyan-elements'); ?></h1>
			<br><br>
			<div class="gyan-hs-notice notice notice-success is-dismissible" style="display:none; padding: 10px; "><span><?php echo esc_html__('Header Style Successfully Imported!', 'gyan-elements'); ?></span></div>
			<div class="gyan-hs-blank-header notice notice-warning is-dismissible" style="display:none; padding: 10px; "><span><?php echo esc_html__('Please Select Header Style.', 'gyan-elements'); ?></span></div>
			<input type="radio" id="hs_one" name="swm_set_header_styles" value="hs_one" class="gyan-hs-input-hidden" />
			<label for="hs_one"><img src="<?php echo GYAN_PLUGIN_URI; ?>admin/images/header-style1.jpg" alt="Header Style One" /></label><br><br>
			<input type="radio" id="hs_two" name="swm_set_header_styles" value="hs_two" class="gyan-hs-input-hidden" />
			<label for="hs_two"><img src="<?php echo GYAN_PLUGIN_URI; ?>admin/images/header-style2.jpg" alt="Header Style Two" /></label><br><br>
			<input type="radio" id="hs_three" name="swm_set_header_styles" value="hs_three" class="gyan-hs-input-hidden" />
			<label for="hs_three"><img src="<?php echo GYAN_PLUGIN_URI; ?>admin/images/header-style3.jpg" alt="Header Style Three" /></label><br><br><br>

			<button class="button button-primary swm_btn_header_styles">Import Header</button>


		</div>
		<?php

	}


	public function import_header_style() {

		$nonce = ( isset( $_POST['nonce'] ) ) ? sanitize_key( $_POST['nonce'] ) : '';

		$header_styles = ( isset( $_POST['init'] ) ) ? sanitize_text_field( wp_unslash( $_POST['init'] ) ) : '';

		$get_header_style = $this->header_style_options($header_styles);

		foreach ($get_header_style as $option_name => $option_value) {
	      set_theme_mod($option_name,$option_value);
	   }

		wp_send_json_success(
			array(
				'success' => true,
				'message' => __( 'Header Successfully Imported.', 'gyan-elements' ),
			)
		);

	}

	public function register_scripts() {

		$current_screen = get_current_screen();
		if ( ! is_object( $current_screen ) && null === $current_screen ) { return; }  // Bail if not on Sites screen.

		if ( 'theme-panel_page_swm-header-styles' === $current_screen->base ) {

			$gyan_min_js = get_option('swm_enable_minify_gyan_elements_js',true) ? '-min.js' : '.js';
			wp_enqueue_script( 'gyan-header-styles', GYAN_PLUGIN_URL . 'admin/js/header-styles'. $gyan_min_js, array( 'jquery', 'wp-util', 'updates' ), GYAN_ELEMENTS_VERSION, false );

			$data = array(
				'ajaxUrl'                => admin_url( 'admin-ajax.php' ),
				'gyanHeaderStylesNounce' =>  wp_create_nonce( 'gyan-recommended-plugin-nonce' )
			);

			wp_localize_script( 'gyan-header-styles', 'gyanHeaderStyles', $data );

		}

	}


	public function header_style_options($option = '') {

		$header_style_one = array(
			'swm_topbar_on'                             => 'on',
			'swm_header_style'                          => 'header_1',
			'swm_sidepanel_icon_col'                    => '#676767',
			'swm_header_bg_opacity'                     => 1,
			'swm_pr_menu_links_text_color'              => '#032e42',
			'swm_pr_menu_links_text_hover_color'        => '#d83030',
			'swm_pr_menu_active_border_on'              => 'on',
			'swm_pr_menu_active_border_color'           => '#d83030',
			'swm_main_header_bg_color'                  => '#ffffff',
			'swm_header_button_on'                      => 'off',
			'swm_pr_menu_divider_on'                    => 'off',
			'swm_sidepanel_on'                          => 'on',
			'swm_sidepanel_icon_style'                  => 's_one',
			'swm_pr_menu_bg'                            => '#f2f2f2',
			'swm_pr_menu_links_space'                   => 19,
			'swm_pr_menu_divider_color'                 => '#e6e6e6',
			'swm_sticky_pr_menu_links_text_color'       => '#032e42',
			'swm_sticky_pr_menu_links_text_hover_color' => '#d83030',
			'swm_sticky_pr_menu_active_border_color'    => '#d83030',
			'swm_sticky_pr_menu_bg'                     => '#ffffff',
			'swm_sticky_pr_menu_divider_color'          => '#e6e6e6',
			'swm_header_button_bg'                      => '#252628',
			'swm_header_button_h_bg'                    => '#101011',
			'swm_header_button_border_color'            => '#252628',
			'swm_header_button_border_h_color'          => '#101011'
		);

		$header_style_two = array(
			'swm_topbar_on'                              => 'off',
			'swm_header_style'                          => 'header_2',
			'swm_header_button_on'                      => 'on',
			'swm_pr_menu_links_space'                   => 19,
			'swm_pr_menu_links_text_color'              => '#ffffff',
			'swm_pr_menu_links_text_hover_color'        => '#ffffff',
			'swm_pr_menu_active_border_color'           => '#d83030',
			'swm_pr_menu_bg'                            => '#d83030',
			'swm_pr_menu_divider_on'                    => 'on',
			'swm_pr_menu_divider_color'                 => '#e46f6f',
			'swm_sidepanel_icon_col'                    => '#ffffff',
			'swm_sticky_pr_menu_links_text_color'       => '#ffffff',
			'swm_sticky_pr_menu_links_text_hover_color' => '#ffffff',
			'swm_sticky_pr_menu_active_border_color'    => '#d83030',
			'swm_sticky_pr_menu_bg'                     => '#d83030',
			'swm_sticky_pr_menu_divider_color'          => '#e46f6f',
			'swm_header_button_bg'                      => '#252628',
			'swm_header_button_h_bg'                    => '#101011',
			'swm_header_button_border_color'            => '#252628',
			'swm_header_button_border_h_color'          => '#101011',
			'swm_sidepanel_on'                          => 'on',
			'swm_header_bg_opacity'                     => 0.8,
			'swm_pr_menu_active_border_on'              => 'on',
			'swm_main_header_bg_color'                  => '#ffffff',
			'swm_sidepanel_icon_style'                  => 's_one'
		);

		$header_style_three = array(
			'swm_topbar_on'                              => 'off',
			'swm_header_style'                          => 'header_1_t',
			'swm_sidepanel_icon_col'                    => '#ffffff',
			'swm_header_bg_opacity'                     => 0,
			'swm_pr_menu_links_text_color'              => '#ffffff',
			'swm_pr_menu_links_text_hover_color'        => '#ffffff',
			'swm_pr_menu_active_border_on'              => 'on',
			'swm_pr_menu_active_border_color'           => '#ffffff',
			'swm_main_header_bg_color'                  => '#252628',
			'swm_header_button_on'                      => 'off',
			'swm_pr_menu_divider_on'                    => 'off',
			'swm_sidepanel_on'                          => 'on',
			'swm_sidepanel_icon_style'                  => 's_two',
			'swm_pr_menu_bg'                            => '#ffffff',
			'swm_pr_menu_links_space'                   => 19,
			'swm_pr_menu_divider_color'                 => '#e6e6e6',
			'swm_sticky_pr_menu_links_text_color'       => '#032e42',
			'swm_sticky_pr_menu_links_text_hover_color' => '#d83030',
			'swm_sticky_pr_menu_active_border_color'    => '#d83030',
			'swm_sticky_pr_menu_bg'                     => '#ffffff',
			'swm_sticky_pr_menu_divider_color'          => '#e6e6e6',
			'swm_header_button_bg'                      => '#252628',
			'swm_header_button_h_bg'                    => '#101011',
			'swm_header_button_border_color'            => '#252628',
			'swm_header_button_border_h_color'          => '#101011'
		);

		if ( $option == 'hs_one' ) {
			return $header_style_one;
		} elseif ( $option == 'hs_two' ) {
			return $header_style_two;
		} elseif ( $option == 'hs_three' ) {
			return $header_style_three;
		}

		return;

	}


}

new Gyan_Header_Styles();