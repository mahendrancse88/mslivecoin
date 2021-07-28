<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Swm_Theme_Panel {

	public $settings = array();

	public function __construct() {
		add_action( 'init', array( $this, 'init_settings' ), 11 );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_menu', array( $this, 'add_menu_item' ),0 );
	}

	public function init_settings() {
		$this->settings = $this->settings_fields();
	}

	public function add_menu_item() {
		add_menu_page( esc_html__('Theme Panel','gyan-elements'), esc_html__('Theme Panel','gyan-elements'), 'edit_theme_options', 'swm-theme-panel', array( $this, 'settings_page' ), NULL,59);
	}

	private function settings_fields() {

		$settings['standard'] = array(
			'title'       => esc_html__( 'General', 'gyan-elements' ),
			'description' => esc_html__( 'Enable or disable various core features of the theme in order to keep the site optimized for your needs.', 'gyan-elements' ),
			'fields'      => array(
				array(
					'id'          => 'swm_enable_customizer_manager',
					'label'       => 'Customizer Manager',
					'description' => esc_html__( 'Unchecking this box will remove the "Customizer Manager" page from Dashboard > Theme Panel.','gyan-elements' ),
					'type'        => 'checkbox',
					'default'     => '1',
				),
				array(
					'id'          => 'swm_enable_header_styles',
					'label'       => 'Header Styles',
					'description' => esc_html__( 'Unchecking this box will remove the "Header Styles" page from Dashboard > Theme Panel.','gyan-elements' ),
					'type'        => 'checkbox',
					'default'     => '1',
				),
				array(
					'id'          => 'swm_enable_demo_templates',
					'label'       => 'Demo Templates',
					'description' => esc_html__( 'Unchecking this box will remove the "Demo Templates" page from Dashboard > Theme Panel.','gyan-elements' ),
					'type'        => 'checkbox',
					'default'     => '1',
				),
				array(
					'id'          => 'swm_enable_add_new_sidebar',
					'label'       => 'Add New Sidebar',
					'description' => esc_html__( 'Unchecking this box will remove the "Add New Sidebar" section where you can create a custom widget area. ( Dashboard > Appearance > Widgets > "Add New Sidebar" on Right Side ) ','gyan-elements' ),
					'type'        => 'checkbox',
					'default'     => '1',
				),
				array(
					'id'          => 'swm_enable_theme_widgets',
					'label'       => 'Theme Custom Widgets',
					'description' => esc_html__( 'Unchecking this box will remove Theme\'s custom widgets ( Dashboard > Appearance > Widgets ): Company Information, Contact Info, Posts Slider, Recent Posts, Useful Links. (Note: Unchecking will also unset custom widget area locations - blog, page, sidepanel, search page, and footer columns.) ','gyan-elements' ),
					'type'        => 'checkbox',
					'default'     => '1',
				),
				array(
					'id'          => 'swm_enable_portfolio',
					'label'       => 'Portfolio',
					'description' => esc_html__( 'Unchecking this box will remove Portfolio post type. ( Disable Portfolio from elementor addons: Go to Dashboard > Theme Panel > Add-Ons Settings > Advanced Add-Ons > Disable "Portfolio" )','gyan-elements' ),
					'type'        => 'checkbox',
					'default'     => '1',
				),
			),
		);

		$settings['extra'] = array(
			'title'       => esc_html__( 'Performance', 'gyan-elements' ),
			'description' => esc_html__( 'Improve Page Load Speed.', 'gyan-elements' ),
			'fields'      => array(
				array(
					'id'          => 'swm_enable_minify_theme_js',
					'label'       => 'Minify Theme Javascripts',
					'description' => esc_html__( 'You can decrease the size of js files.','gyan-elements' ),
					'type'        => 'checkbox',
					'default'     => '1',
				),
				array(
					'id'          => 'swm_enable_minify_theme_css',
					'label'       => 'Minify Theme CSS',
					'description' => esc_html__( 'Minification CSS code can save many bytes of data and speed up downloading, parsing, and execution time.','gyan-elements' ),
					'type'        => 'checkbox',
					'default'     => '1',
				),
				array(
					'id'          => 'swm_enable_minify_gyan_elements_js',
					'label'       => 'Minify Gyan Elements Javascripts',
					'description' => esc_html__( 'You can decrease the size of js files.','gyan-elements' ),
					'type'        => 'checkbox',
					'default'     => '1',
				),
				array(
					'id'          => 'swm_enable_minify_gyan_elements_css',
					'label'       => 'Minify Gyan Elements CSS',
					'description' => esc_html__( 'Minification CSS code can save many bytes of data and speed up downloading, parsing, and execution time.','gyan-elements' ),
					'type'        => 'checkbox',
					'default'     => '1',
				),
				array(
					'id'          => 'swm_enable_remove_emoji_scripts',
					'label'       => 'Remove Emoji Scripts',
					'description' => esc_html__( 'WordPress by default supports the use of emojis. However, unless your blog has a personal nature, you might not require feature at all and need to disable it.','gyan-elements' ),
					'type'        => 'checkbox',
					'default'     => '1',
				),
			),
		);

		$settings = apply_filters( 'wordpress_plugin_template_settings_fields', $settings );

		return $settings;
	}

	public function register_settings() {
		if ( is_array( $this->settings ) ) {

			// Check posted/selected tab.
			$current_section = '';
			if ( isset( $_POST['tab'] ) && $_POST['tab'] ) {
				$current_section = $_POST['tab'];
			} else {
				if ( isset( $_GET['tab'] ) && $_GET['tab'] ) {
					$current_section = $_GET['tab'];
				}
			}

			foreach ( $this->settings as $section => $data ) {

				if ( $current_section && $current_section !== $section ) {
					continue;
				}

				// Add section to page.
				add_settings_section( $section, $data['title'], array( $this, 'settings_section' ), 'swm_theme_panel_settings' );

				foreach ( $data['fields'] as $field ) {

					// Register field.
					$option_name = $field['id'];
					register_setting( 'swm_theme_panel_settings', $field['id'] );

					// Add field to page.
					add_settings_field(
						$field['id'],
						$field['label'],
						array( $this, 'display_field' ),
						'swm_theme_panel_settings',
						$section,
						array(
							'field'  => $field,
							'default' => $field['default']
						)
					);
				}

				if ( ! $current_section ) {
					break;
				}
			}
		}
	}

	public function settings_section( $section ) {
		$html = '<p> ' . $this->settings[ $section['id'] ]['description'] . '</p>' . "\n";
		echo $html;
	}

	public function settings_page() {

		// Build page HTML.
		$html      = '<div class="wrap" id="swm_theme_panel_settings">' . "\n";
			$html .= '<h2>' . esc_html__( 'Theme Panel', 'gyan-elements' ) . '</h2>' . "\n";

			$tab = '';

		if ( isset( $_GET['tab'] ) && $_GET['tab'] ) {
			$tab .= $_GET['tab'];
		}

		// Show page tabs.
		if ( is_array( $this->settings ) && 1 < count( $this->settings ) ) {

			$html .= '<h2 class="nav-tab-wrapper">' . "\n";

			$c = 0;
			foreach ( $this->settings as $section => $data ) {

				// Set tab class.
				$class = 'nav-tab';
				if ( ! isset( $_GET['tab'] ) ) {
					if ( 0 === $c ) {
						$class .= ' nav-tab-active';
					}
				} else {
					if ( isset( $_GET['tab'] ) && $section == $_GET['tab'] ) {
						$class .= ' nav-tab-active';
					}
				}

				// Set tab link.
				$tab_link = add_query_arg( array( 'tab' => $section ) );
				if ( isset( $_GET['settings-updated'] ) ) {
					$tab_link = remove_query_arg( 'settings-updated', $tab_link );
				}

				// Output tab.
				$html .= '<a href="' . $tab_link . '" class="' . esc_attr( $class ) . '">' . esc_html( $data['title'] ) . '</a>' . "\n";

				++$c;
			}

			$html .= '</h2>' . "\n";
		}

			$html .= '<form method="post" action="options.php" enctype="multipart/form-data">' . "\n";

				// Get settings fields.
				ob_start();
				settings_fields( 'swm_theme_panel_settings' );
				do_settings_sections( 'swm_theme_panel_settings' );
				$html .= ob_get_clean();

				$html     .= '<p class="submit">' . "\n";
					$html .= '<input type="hidden" name="tab" value="' . esc_attr( $tab ) . '" />' . "\n";
					$html .= '<input name="Submit" type="submit" class="button-primary" value="' . esc_attr__( 'Save Settings', 'gyan-elements' ) . '" />' . "\n";
				$html     .= '</p>' . "\n";
			$html         .= '</form>' . "\n";
		$html             .= '</div>' . "\n";

		$html .= '
		<br/>
		<hr>
		<ul class="gyan-themepanel-blocks">
			<li><a class="doc" href="https://bizixdocs.premiumthemes.in" target="_blank">' . esc_html__('Documentation','gyan-elements') . '</a></li>
			<li><a class="video" href="https://www.youtube.com/playlist?list=PLXFhS0UVwaV6TXs6uW2MJIKLW17IlwaOT" target="_blank">' . esc_html__('Video Tutorials','gyan-elements') . '</a></li>
			<li><a class="support" href="https://themeforest.net/item/bizix-corporate-and-business-wordpress-theme/25806086/support" target="_blank">' . esc_html__('Support','gyan-elements') . '</a></li>
			<li><a class="log" href="https://bizixdocs.premiumthemes.in/changelog/" target="_blank">' . esc_html__('Changelog','gyan-elements') . '</a></li>
		</ul>
		<hr>
		<br/>
		<h3>Useful Links</h3>
		<ul class="gyan-themepanel-links">
		<li><a href="https://bizixdocs.premiumthemes.in/4-one-click-demo-import/" target="_blank"><strong>' . esc_html__('Make your site look like a demo preview','gyan-elements') . '</strong></a></li>
		<li><a href="https://bizixdocs.premiumthemes.in/3-plugins-installation/" target="_blank"><strong>' . esc_html__('Install included plugins','gyan-elements') . '</strong></a></li>
		<li><a href="https://bizixdocs.premiumthemes.in/category/updating-the-theme/" target="_blank"><strong>' . esc_html__('Updating the theme','gyan-elements') . '</strong></a></li>
		<li><a href="https://bizixdocs.premiumthemes.in/category/speed-up-your-website/" target="_blank"><strong>' . esc_html__('Speed up your website','gyan-elements') . '</strong></a></li>
		</ul>';

		echo $html;

	}

	public function display_field( $data = array() )	{

		// Get field info.
		if ( isset( $data['field'] ) ) {
			$field = $data['field'];
		} else {
			$field = $data;
		}

		$option_name = '';

		// Get saved data.
		$data = '';

		// Get saved option.
		$option_name .= $field['id'];
		$option       = get_option( $option_name );

		// Get data to display in field.
		if ( isset( $option ) ) {
			$data = $option;
		}

		// Show default data if no option saved and default is supplied.
		if ( false === $data && isset( $field['default'] ) ) {
			$data = $field['default'];
		} elseif ( false === $data ) {
			$data = '';
		}

		$html = '';

		switch ( $field['type'] ) {

			case 'text':
				$html .= '<input id="' . esc_attr( $field['id'] ) . '" type="text" name="' . esc_attr( $option_name ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" value="' . esc_attr( $data ) . '" />' . "\n";
				break;

			case 'checkbox':
				$val = get_option($option_name, $field['default']);
				$checked = '';
				if( $val ) { $checked = ' checked="checked" '; }

				$html .= '<input id="' . esc_attr( $field['id'] ) . '" type="' . esc_attr( $field['type'] ) . '" name="' . esc_attr( $option_name ) . '" ' . $checked . '/>' . "\n";
				break;

			case 'select':
				$html .= '<select name="' . esc_attr( $option_name ) . '" id="' . esc_attr( $field['id'] ) . '">';
				foreach ( $field['options'] as $k => $v ) {
					$selected = false;
					if ( $k === $data ) {
						$selected = true;
					}
					$html .= '<option ' . selected( $selected, true, false ) . ' value="' . esc_attr( $k ) . '">' . $v . '</option>';
				}
				$html .= '</select> ';
				break;

		}

		$html .= '<label for="' . esc_attr( $field['id'] ) . '">' . $field['description'] . '</label>' . "\n";

		echo $html;

	} // End display_field

}

new Swm_Theme_Panel();