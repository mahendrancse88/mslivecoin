<?php
// Elementor Classes.
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Scheme_Typography;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Gyan_Google_Map extends Widget_Base {

	public function get_name()       { return 'gyan_google_map'; }
	public function get_title()      { return esc_html__( 'Google Map', 'gyan-elements' ); }
	public function get_icon()       { return 'gyan-el-icon eicon-google-maps'; }
	public function get_categories() { return ['gyan-basic-addons']; }
	public function get_keywords()   { return ['google map', 'map', 'location']; }
	public function get_style_depends() { return ['gyan-google-map']; }

	public function get_script_depends() {
		return [ 'gyan-widgets', 'gyan-google-maps-api', 'gyan-google-maps-cluster' ];
	}

	protected function register_controls() {

		$this->register_addresses_controls();
		$this->register_layout_controls();
		$this->register_controls_controls();
		$this->register_info_window_controls();
	}

	protected function register_addresses_controls() {

		$this->start_controls_section(
			'section_map_addresses',
			[
				'label' => esc_html__( 'Addresses', 'gyan-elements' ),
			]
		);

		if (  '' == get_option( 'gyan_map_apikey' ) ) {

			$admin_link = "admin.php?page=gyan-addons-settings#gyan-addons-api-settings";
			$this->add_control(
				'err_msg',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf( __( 'Google Map API is required to display customized Google Map without an issue. Please add Google Map API key from <a href="%s" target="_blank" rel="noopener">HERE</a>.', 'gyan-elements' ), $admin_link ),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
				]
			);
		}

			$repeater = new Repeater();

			$repeater->add_control(
			   'latitude',
			   [
					'label'       => esc_html__( 'Latitude', 'gyan-elements' ),
					'description' => sprintf( '<a href="https://www.latlong.net/" target="_blank">%1$s</a> %2$s', __( 'Click here', 'gyan-elements' ), __( 'to find Latitude of your location', 'gyan-elements' ) ),
					'type'        => Controls_Manager::TEXT,
					'default'     => '',
					'label_block' => true,
					'dynamic'     => [
						'active' => true,
					],
			   ]
			);

			$repeater->add_control(
			   'longitude',
			   [
					'label'       => esc_html__( 'Longitude', 'gyan-elements' ),
					'description' => sprintf( '<a href="https://www.latlong.net/" target="_blank">%1$s</a> %2$s', __( 'Click here', 'gyan-elements' ), __( 'to find Longitude of your location', 'gyan-elements' ) ),
					'type'        => Controls_Manager::TEXT,
					'default'     => '',
					'label_block' => true,
					'dynamic'     => [
						'active' => true,
					],
			   ]
			);

			$repeater->add_control(
			   'map_title',
			   [
					'label'       => esc_html__( 'Address Title', 'gyan-elements' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => '',
					'label_block' => true,
					'dynamic'     => [
						'active' => true,
					],
			   ]
			);

			$repeater->add_control(
			   'marker_infowindow',
			   [
					'label'       => esc_html__( 'Display Info Window', 'gyan-elements' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'none',
					'label_block' => true,
					'options'     => [
						'none'  => esc_html__( 'None', 'gyan-elements' ),
						'click' => esc_html__( 'On Mouse Click', 'gyan-elements' ),
						'load'  => esc_html__( 'On Page Load', 'gyan-elements' ),
					],
			   ]
			);

			$repeater->add_control(
			   'map_description',
			   [
					'label'       => esc_html__( 'Address Information', 'gyan-elements' ),
					'type'        => Controls_Manager::TEXTAREA,
					'label_block' => true,
					'conditions'  => [
						'terms' => [
							[
								'name'     => 'marker_infowindow',
								'operator' => '!=',
								'value'    => 'none',
							],
						],
					],
					'dynamic'     => [
						'active' => true,
					],
			   ]
			);

			$repeater->add_control(
			   'marker_icon_type',
			   [
					'label'   => esc_html__( 'Marker Icon', 'gyan-elements' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'default',
					'options' => [
						'default' => esc_html__( 'Default', 'gyan-elements' ),
						'custom'  => esc_html__( 'Custom', 'gyan-elements' ),
					],
			   ]
			);

			$repeater->add_control(
			   'marker_icon',
			   [
					'label'      => esc_html__( 'Select Marker', 'gyan-elements' ),
					'type'       => Controls_Manager::MEDIA,
					'conditions' => [
						'terms' => [
							[
								'name'     => 'marker_icon_type',
								'operator' => '==',
								'value'    => 'custom',
							],
						],
					],
			   ]
			);

			$repeater->add_control(
			   'custom_marker_size',
			   [
					'label'       => esc_html__( 'Marker Size', 'gyan-elements' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [ 'px' ],
					'description' => esc_html__( 'Note: Leave above size field blank to display Marker image with original size.', 'gyan-elements' ),
					'default'     => [
						'size' => 30,
						'unit' => 'px',
					],
					'range'       => [
						'px' => [
							'min' => 5,
							'max' => 100,
						],
					],
					'conditions'  => [
						'terms' => [
							[
								'name'     => 'marker_icon_type',
								'operator' => '==',
								'value'    => 'custom',
							],
						],
					],
			   ]
			);


			$this->add_control(
				'addresses',
				[
					'label'       => '',
					'type'        => Controls_Manager::REPEATER,
					'fields' 		=> $repeater->get_controls(),
					'default'     => [
						[
							'latitude'        => 40.721810,
							'longitude'       => -73.995540,
							'map_title'       => esc_html__( 'Canal Street, New York', 'gyan-elements' ),
							'map_description' => '',
						],
					],
					'title_field' => '<i class="fa fa-map-marker"></i> {{{ map_title }}}',
				]
			);

		$this->end_controls_section();
	}

	protected function register_layout_controls() {

		$this->start_controls_section(
			'section_map_settings',
			[
				'label' => esc_html__( 'Layout', 'gyan-elements' ),
			]
		);

			$this->add_control(
				'type',
				[
					'label'   => esc_html__( 'Map Type', 'gyan-elements' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'roadmap',
					'options' => [
						'roadmap'   => esc_html__( 'Road Map', 'gyan-elements' ),
						'satellite' => esc_html__( 'Satellite', 'gyan-elements' ),
						'hybrid'    => esc_html__( 'Hybrid', 'gyan-elements' ),
						'terrain'   => esc_html__( 'Terrain', 'gyan-elements' ),
					],
				]
			);

			$this->add_control(
				'skin',
				[
					'label'     => esc_html__( 'Map Skin', 'gyan-elements' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'standard',
					'options'   => [
						'standard'     => esc_html__( 'Default', 'gyan-elements' ),
						'aqua'         => esc_html__( 'Aqua', 'gyan-elements' ),
						'aubergine'    => esc_html__( 'Aubergine', 'gyan-elements' ),
						'classic_blue' => esc_html__( 'Classic Blue', 'gyan-elements' ),
						'dark'         => esc_html__( 'Dark', 'gyan-elements' ),
						'earth'        => esc_html__( 'Earth', 'gyan-elements' ),
						'magnesium'    => esc_html__( 'Magnesium', 'gyan-elements' ),
						'night'        => esc_html__( 'Night', 'gyan-elements' ),
						'retro'        => esc_html__( 'Retro', 'gyan-elements' ),
						'silver'       => esc_html__( 'Silver', 'gyan-elements' ),
						'custom'       => esc_html__( 'Custom', 'gyan-elements' ),
					],
					'condition' => [
						'type!' => 'satellite',
					],
				]
			);

			$this->add_control(
				'map_custom_style',
				[
					'label'       => esc_html__( 'Custom Style', 'gyan-elements' ),
					'description' => sprintf( '<a href="https://mapstyle.withgoogle.com/" target="_blank">%1$s</a> %2$s', __( 'Click here', 'gyan-elements' ), __( 'to get custom style Google Map JSON code.', 'gyan-elements' ) ),
					'type'        => Controls_Manager::TEXTAREA,
					'condition'   => [
						'skin'  => 'custom',
						'type!' => 'satellite',
					],
				]
			);

			$this->add_control(
				'animate',
				[
					'label'   => esc_html__( 'Marker Animation', 'gyan-elements' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						''       => esc_html__( 'None', 'gyan-elements' ),
						'drop'   => esc_html__( 'On Load', 'gyan-elements' ),
						'bounce' => esc_html__( 'Continuous', 'gyan-elements' ),
					],
				]
			);

			$this->add_control(
				'zoom',
				[
					'label'   => esc_html__( 'Map Zoom', 'gyan-elements' ),
					'type'    => Controls_Manager::SLIDER,
					'default' => [
						'size' => 12,
					],
					'range'   => [
						'px' => [
							'min' => 1,
							'max' => 22,
						],
					],
				]
			);

			$this->add_responsive_control(
				'height',
				[
					'label'      => esc_html__( 'Height', 'gyan-elements' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'default'    => [
						'size' => 500,
						'unit' => 'px',
					],
					'range'      => [
						'px' => [
							'min' => 80,
							'max' => 1200,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .gyan-google-map' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();
	}

	protected function register_controls_controls() {

		$this->start_controls_section(
			'section_map_controls',
			[
				'label' => esc_html__( 'Controls', 'gyan-elements' ),
			]
		);

			$this->add_control(
				'option_streeview',
				[
					'label'        => esc_html__( 'Street View Controls', 'gyan-elements' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'yes',
					'label_on'     => esc_html__( 'On', 'gyan-elements' ),
					'label_off'    => esc_html__( 'Off', 'gyan-elements' ),
					'return_value' => 'yes',
				]
			);

			$this->add_control(
				'type_control',
				[
					'label'        => esc_html__( 'Map Type Control', 'gyan-elements' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'yes',
					'label_on'     => esc_html__( 'On', 'gyan-elements' ),
					'label_off'    => esc_html__( 'Off', 'gyan-elements' ),
					'return_value' => 'yes',
				]
			);

			$this->add_control(
				'zoom_control',
				[
					'label'        => esc_html__( 'Zoom Control', 'gyan-elements' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'yes',
					'label_on'     => esc_html__( 'On', 'gyan-elements' ),
					'label_off'    => esc_html__( 'Off', 'gyan-elements' ),
					'return_value' => 'yes',
				]
			);

			$this->add_control(
				'fullscreen_control',
				[
					'label'        => esc_html__( 'Fullscreen Control', 'gyan-elements' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'yes',
					'label_on'     => esc_html__( 'On', 'gyan-elements' ),
					'label_off'    => esc_html__( 'Off', 'gyan-elements' ),
					'return_value' => 'yes',
				]
			);

			$this->add_control(
				'scroll_zoom',
				[
					'label'        => esc_html__( 'Zoom on Scroll', 'gyan-elements' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'yes',
					'label_on'     => esc_html__( 'On', 'gyan-elements' ),
					'label_off'    => esc_html__( 'Off', 'gyan-elements' ),
					'return_value' => 'yes',
				]
			);

			$this->add_control(
				'auto_center',
				[
					'label'       => esc_html__( 'Map Alignment', 'gyan-elements' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'center',
					'options'     => [
						'center'   => esc_html__( 'Center', 'gyan-elements' ),
						'moderate' => esc_html__( 'Moderate', 'gyan-elements' ),
					],
					'description' => esc_html__( 'Default setting of map is center align. You can switch to moderate mode when you have multiple locations. Moderate mode will make first location center point.', 'gyan-elements' ),
				]
			);

			$this->add_control(
				'cluster',
				[
					'label'        => esc_html__( 'Cluster the Markers', 'gyan-elements' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'no',
					'label_on'     => esc_html__( 'On', 'gyan-elements' ),
					'label_off'    => esc_html__( 'Off', 'gyan-elements' ),
					'return_value' => 'yes'
				]
			);

			$this->add_control(
				'cluster_doc',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => esc_html__( 'Enable this If you have a lot of markers on the map and they are close to each other. This utility helps you to manage multiple markers at different zoom levels.', 'gyan-elements' ),
					'content_classes' => 'gyan-editor-doc',
					'condition'       => [ 'cluster' => 'yes' ],
				]
			);


		$this->end_controls_section();
	}

	protected function register_info_window_controls() {

		$this->start_controls_section(
			'section_info_window_style',
			[
				'label' => esc_html__( 'Info Window', 'gyan-elements' ),
			]
		);

			$this->add_control(
				'info_window_size',
				[
					'label'       => esc_html__( 'Maximum Width', 'gyan-elements' ),
					'type'        => Controls_Manager::SLIDER,
					'default'     => [
						'size' => 250,
						'unit' => 'px',
					],
					'range'       => [
						'px' => [
							'min'  => 50,
							'max'  => 1000,
							'step' => 1,
						],
					],
					'size_units'  => [ 'px' ],
					'label_block' => true,
				]
			);

			$this->add_responsive_control(
				'info_padding',
				[
					'label'      => esc_html__( 'Padding', 'gyan-elements' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .gm-style .gyan-infowindow-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'title_spacing',
				[
					'label'      => esc_html__( 'Spacing Between Title & Description', 'gyan-elements' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 100,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 5,
						'unit' => 'px',
					],
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .gm-style .gyan-infowindow-description' => 'margin-top: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .gm-style .gyan-infowindow-title' => 'font-weight: bold;',
					],
				]
			);

			$this->add_control(
				'title_heading',
				[
					'label' => esc_html__( 'Title Text', 'gyan-elements' ),
					'type'  => Controls_Manager::HEADING,
				]
			);

			$this->add_control(
				'title_color',
				[
					'label'     => esc_html__( 'Color', 'gyan-elements' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .gm-style .gyan-infowindow-title' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'title_typography',
					'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
					'selector' => '{{WRAPPER}} .gm-style .gyan-infowindow-title',
				]
			);

			$this->add_control(
				'description_heading',
				[
					'label' => esc_html__( 'Description Text', 'gyan-elements' ),
					'type'  => Controls_Manager::HEADING,
				]
			);

			$this->add_control(
				'description_color',
				[
					'label'     => esc_html__( 'Color', 'gyan-elements' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .gm-style .gyan-infowindow-description' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'description_typography',
					'selector' => '{{WRAPPER}} .gm-style .gyan-infowindow-description',
				]
			);

		$this->end_controls_section();

	}

	protected function get_locations() {

		$settings = $this->get_settings_for_display();

		$locations = array();

		foreach ( $settings['addresses'] as $index => $item ) {

			$latitude  = apply_filters( 'gyan_google_map_latitude', $item['latitude'] );
			$longitude = apply_filters( 'gyan_google_map_longitude', $item['longitude'] );

			$location_object = array(
				$latitude,
				$longitude,
			);

			$location_object[] = ( 'none' != $item['marker_infowindow'] ) ? true : false;
			$location_object[] = apply_filters( 'gyan_google_map_title', $item['map_title'] );
			$location_object[] = apply_filters( 'gyan_google_map_description', $item['map_description'] );

			if (
				'custom' == $item['marker_icon_type'] && is_array( $item['marker_icon'] ) &&
				'' != $item['marker_icon']['url']
			) {
				$location_object[] = 'custom';
				$location_object[] = $item['marker_icon']['url'];
				$location_object[] = $item['custom_marker_size']['size'];
			} else {
				$location_object[] = '';
				$location_object[] = '';
				$location_object[] = '';
			}

			$location_object[] = ( 'load' == $item['marker_infowindow'] ) ? 'iw_open' : '';

			$locations[] = $location_object;
		}

		return $locations;
	}

	protected function get_map_options() {

		$settings = $this->get_settings_for_display();

		return array(
			'zoom'              => ( ! empty( $settings['zoom']['size'] ) ) ? $settings['zoom']['size'] : 4,
			'mapTypeId'         => ( ! empty( $settings['type'] ) ) ? $settings['type'] : 'roadmap',
			'mapTypeControl'    => ( 'yes' == $settings['type_control'] ) ? true : false,
			'streetViewControl' => ( 'yes' == $settings['option_streeview'] ) ? true : false,
			'zoomControl'       => ( 'yes' == $settings['zoom_control'] ) ? true : false,
			'fullscreenControl' => ( 'yes' == $settings['fullscreen_control'] ) ? true : false,
			'gestureHandling'   => ( 'yes' == $settings['scroll_zoom'] ) ? true : false,
		);
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		ob_start();

		$map_options = $this->get_map_options();
		$locations   = $this->get_locations();

		$this->add_render_attribute(
			'google-map',
			[
				'id'               => 'gyan-google-map-' . esc_attr( $this->get_id() ),
				'class'            => 'gyan-google-map',
				'data-map_options' => wp_json_encode( $map_options ),
				'data-cluster'     => $settings['cluster'],
				'data-max-width'   => $settings['info_window_size']['size'],
				'data-locations'   => wp_json_encode( $locations ),
				'data-animate'     => $settings['animate'],
				'data-auto-center' => $settings['auto_center'],
			]
		);

		if ( 'standard' != $settings['skin'] ) {
			if ( 'custom' != $settings['skin'] ) {
				$this->add_render_attribute( 'google-map', 'data-predefined-style', $settings['skin'] );
			} elseif ( ! empty( $settings['map_custom_style'] ) ) {
				$this->add_render_attribute( 'google-map', 'data-custom-style', $settings['map_custom_style'] );
			}
		}

		?>
		<div class="gyan-google-map-wrap">
			<div <?php echo $this->get_render_attribute_string( 'google-map' ); ?>></div>
		</div>
		<?php
		$html = ob_get_clean();
		echo $html;
	}

	protected function _content_template() {}

}