<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Gyan_Content_Toggle extends Widget_Base {

	public function get_name()           { return 'gyan_content_toggle'; }
	public function get_title()          { return esc_html__( 'Content Toggle', 'gyan-elements' ); }
	public function get_icon()           { return 'gyan-el-icon eicon-dual-button'; }
	public function get_categories()     { return ['gyan-advanced-addons' ]; }
	public function get_keywords()       { return ['gyan content toggles', 'toggle', 'switch content' ]; }
	public function get_style_depends()  { return ['owl-carousel', 'gyan-content-toggle' ]; }
	public function get_script_depends() { return ['gyan-widgets']; }

	protected function register_controls() {
		$this->register_general_content_controls();
	}

	public function get_modal_content( $settings, $node_id, $section ) {

		$normal_content_1 = $this->get_settings_for_display( 'section_content_1' );
		$normal_content_2 = $this->get_settings_for_display( 'section_content_2' );
		$content_type     = $settings[ $section ];
		if ( 'ctoggle_select_section_1' === $section ) {
			switch ( $content_type ) {
				case 'content':
					global $wp_embed;
					return '<div>' . wpautop( $wp_embed->autoembed( $normal_content_1 ) ) . '</div>';
				break;
				case 'saved_rows':
					return \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $settings['section_saved_rows_1'] );
				break;
				case 'saved_page_templates':
					return \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $settings['section_saved_pages_1'] );
				break;
				default:
					return;
				break;
			}
		} else {
			switch ( $content_type ) {
				case 'content':
					global $wp_embed;
					return '<div>' . wpautop( $wp_embed->autoembed( $normal_content_2 ) ) . '</div>';
				break;
				case 'saved_rows':
					return \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $settings['section_saved_rows_2'] );
				break;
				case 'saved_page_templates':
					return \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $settings['section_saved_pages_2'] );
				break;
				default:
					return;
				break;
			}
		}
	}

	public function get_saved_data( $type = 'page' ) {

		$saved_widgets = $this->get_post_template( $type );
		$options[-1]   = esc_html__( 'Select', 'gyan-elements' );
		if ( count( $saved_widgets ) ) {
			foreach ( $saved_widgets as $saved_row ) {
				$options[ $saved_row['id'] ] = $saved_row['name'];
			}
		} else {
			$options['no_template'] = esc_html__( 'It seems that, you have not saved any template yet.', 'gyan-elements' );
		}
		return $options;
	}

	public function get_post_template( $type = 'page' ) {
		$posts = get_posts(
			array(
				'post_type'      => 'elementor_library',
				'orderby'        => 'title',
				'order'          => 'ASC',
				'posts_per_page' => '-1',
				'tax_query'      => array(
					array(
						'taxonomy' => 'elementor_library_type',
						'field'    => 'slug',
						'terms'    => $type,
					),
				),
			)
		);

		$templates = array();

		foreach ( $posts as $post ) {

			$templates[] = array(
				'id'   => $post->ID,
				'name' => $post->post_title,
			);
		}

		return $templates;
	}

	protected function register_general_content_controls() {

		$this->start_controls_section(
			'ctoggle_section_content_1',
			[
				'label' => esc_html__( 'Content 1', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'ctoggle_section_heading_1',
			[
				'label'   => esc_html__( 'Heading', 'gyan-elements' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( 'Heading Left', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'ctoggle_select_section_1',
			[
				'label'   => esc_html__( 'Section', 'gyan-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'content',
				'options' => $this->get_content_type(),
			]
		);

		$this->add_control(
			'section_content_1',
			[
				'label'      => esc_html__( 'Description', 'gyan-elements' ),
				'type'       => Controls_Manager::WYSIWYG,
				'default'    => esc_html__( 'Left heading content. Aliquam sodales justo sit amet urna auctor scelerisque. Fusce interdum leo ante, sit amet tempus enim aliquam quis. Praesent eget cursus nisi. Cras feslin is hendrerit vel nibh vitae ornar uspendisse consequat quis sem velit aliquam facilisis.', 'gyan-elements' ),
				'rows'       => 10,
				'show_label' => false,
				'dynamic'    => [
					'active' => true,
				],
				'condition'  => [
					'ctoggle_select_section_1' => 'content',
				],
			]
		);

		$this->add_control(
			'section_saved_rows_1',
			[
				'label'     => esc_html__( 'Select Section', 'gyan-elements' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => $this->get_saved_data( 'section' ),
				'default'   => '-1',
				'condition' => [
					'ctoggle_select_section_1' => 'saved_rows',
				],
			]
		);

		$this->add_control(
			'section_saved_pages_1',
			[
				'label'     => esc_html__( 'Select Page', 'gyan-elements' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => $this->get_saved_data( 'page' ),
				'default'   => '-1',
				'condition' => [
					'ctoggle_select_section_1' => 'saved_page_templates',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'ctoggle_sections_content_2',
			[
				'label' => esc_html__( 'Content 2', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'ctoggle_section_heading_2',
			[
				'label'   => esc_html__( 'Heading', 'gyan-elements' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( 'Heading Right', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'ctoggle_select_section_2',
			[
				'label'   => esc_html__( 'Section', 'gyan-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'content',
				'options' => $this->get_content_type(),
			]
		);

		$this->add_control(
			'section_content_2',
			[
				'label'      => esc_html__( 'Description', 'gyan-elements' ),
				'type'       => Controls_Manager::WYSIWYG,
				'default'    => esc_html__( 'Right heading content. Aliquam sodales justo sit amet urna auctor scelerisque. Fusce interdum leo ante, sit amet tempus enim aliquam quis. Praesent eget cursus nisi. Cras feslin is hendrerit vel nibh vitae ornar uspendisse consequat quis sem velit aliquam facilto. ', 'gyan-elements' ),
				'rows'       => 10,
				'show_label' => false,
				'dynamic'    => [
					'active' => true,
				],
				'condition'  => [
					'ctoggle_select_section_2' => 'content',
				],
			]
		);

		$this->add_control(
			'section_saved_rows_2',
			[
				'label'     => esc_html__( 'Select Section', 'gyan-elements' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => $this->get_saved_data( 'section' ),
				'default'   => '-1',
				'condition' => [
					'ctoggle_select_section_2' => 'saved_rows',
				],
			]
		);

		$this->add_control(
			'section_saved_pages_2',
			[
				'label'     => esc_html__( 'Select Page', 'gyan-elements' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => $this->get_saved_data( 'page' ),
				'default'   => '-1',
				'condition' => [
					'ctoggle_select_section_2' => 'saved_page_templates',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'ctoggle_switch_style',
			[
				'label' => esc_html__( 'Switcher', 'gyan-elements' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'ctoggle_default_switch',
			[
				'label'        => esc_html__( 'Default Display', 'gyan-elements' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'off',
				'return_value' => 'on',
				'options'      => [
					'off' => 'Content 1',
					'on'  => 'Content 2',
				],
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'ctoggle_select_switch',
			[
				'label'   => esc_html__( 'Switch Style', 'gyan-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'round_1',
				'options' => $this->get_switch_type(),
			]
		);

		$this->add_control(
			'ctoggle_switch_color_off',
			[
				'label'     => esc_html__( 'Color 1', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default' 	=> '#d83030',
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-ctoggle-slider' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .gyan-content-toggle input[type="checkbox"] + label:before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .gyan-content-toggle input[type="checkbox"] + label:after' => 'border: 0.3em solid {{VALUE}};',
					'{{WRAPPER}} .gyan-label-box-active .gyan-label-box-switch' => 'background: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'ctoggle_switch_color_on',
			[
				'label'     => esc_html__( 'Color 2', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default' 	=> '#d83030',
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],

				'selectors' => [
					'{{WRAPPER}} .gyan-ctoggle-switch:checked + .gyan-ctoggle-slider' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .gyan-ctoggle-switch:focus + .gyan-ctoggle-slider'     => '-webkit-box-shadow: 0 0 1px {{VALUE}};box-shadow: 0 0 1px {{VALUE}};',
					'{{WRAPPER}} .gyan-content-toggle input[type="checkbox"]:checked + label:before'     => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .gyan-content-toggle input[type="checkbox"]:checked + label:after'     => '-webkit-transform: translateX(2.5em);-ms-transform: translateX(2.5em);transform: translateX(2.5em);border: 0.3em solid {{VALUE}};',
					'{{WRAPPER}} .gyan-label-box-inactive .gyan-label-box-switch' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ctoggle_switch_controller',
			[
				'label'     => esc_html__( 'Controller Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .gyan-ctoggle-slider:before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .gyan-content-toggle input[type="checkbox"] + label:after' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} span.gyan-label-box-switch' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'rds_switch_size',
			[
				'label'     => esc_html__( 'Switch Size', 'gyan-elements' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 15,
				],
				'range'     => [
					'px' => [
						'min'  => 10,
						'max'  => 35,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-main-btn' => 'font-size: {{SIZE}}px;',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_heading',
			[
				'label' => esc_html__( 'Headings', 'gyan-elements' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'section_heading_1_style',
			[
				'label'     => esc_html__( 'Heading 1', 'gyan-elements' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'section_heading_1_color',
			[
				'label'     => esc_html__( 'Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-ctoggle-head-1' => 'color: {{VALUE}};',
				],
				'separator' => 'none',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'section_heading_1_typo',
				'selector' => '{{WRAPPER}} .gyan-ctoggle-head-1',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
			]
		);

		$this->add_control(
			'section_heading_2_style',
			[
				'label'     => esc_html__( 'Heading 2', 'gyan-elements' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'section_heading_2_color',
			[
				'label'     => esc_html__( 'Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-ctoggle-head-2' => 'color: {{VALUE}};',
				],
				'separator' => 'none',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'section_heading_2_typo',
				'selector' => '{{WRAPPER}} .gyan-ctoggle-head-2',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
			]
		);

		$this->add_control(
			'ctoggle_header_size',
			[
				'label'     => esc_html__( 'HTML Tag', 'gyan-elements' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
				],
				'default'   => 'h5',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'rds_heading_alignment',
			[
				'label'     => esc_html__( 'Alignment', 'gyan-elements' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'gyan-elements' ),
						'icon'  => 'fa fa-align-left',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'gyan-elements' ),
						'icon'  => 'fa fa-align-center',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Right', 'gyan-elements' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-ctoggle' => 'justify-content: {{VALUE}};',
					'{{WRAPPER}} .gyan-ctoggle-desktop-stack-yes .gyan-ctoggle' => 'align-items: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'heading_layout',
			[
				'label'        => esc_html__( 'Layout', 'gyan-elements' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Stack', 'gyan-elements' ),
				'label_off'    => esc_html__( 'Inline', 'gyan-elements' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'heading_stack_on',
			[
				'label'        => esc_html__( 'Stack on', 'gyan-elements' ),
				'description'  => esc_html__( 'Choose on what breakpoint the heading will stack.', 'gyan-elements' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'mobile',
				'options'      => [
					'none'   => esc_html__( 'None', 'gyan-elements' ),
					'tablet' => esc_html__( 'Tablet (1023px >)', 'gyan-elements' ),
					'mobile' => esc_html__( 'Mobile (767px >)', 'gyan-elements' ),
				],
				'condition'    => [
					'heading_layout!' => 'yes',
				],
				'prefix_class' => 'gyan-ct-stack--',
			]
		);

		$this->add_control(
			'ctoggle_advance_setting',
			[
				'label'     => esc_html__( 'Advanced', 'gyan-elements' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'OFF', 'gyan-elements' ),
				'label_on'  => esc_html__( 'ON', 'gyan-elements' ),
				'default'   => 'no',
				'return'    => 'yes',
			]
		);

		$this->add_control(
			'section_heading_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-ctoggle' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'ctoggle_advance_setting' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'heading_border',
				'label'     => esc_html__( 'Border', 'gyan-elements' ),
				'selector'  => '{{WRAPPER}} .gyan-ctoggle',
				'condition' => [
					'ctoggle_advance_setting' => 'yes',
				],
			]
		);

		$this->add_control(
			'heading_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-ctoggle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'ctoggle_advance_setting' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'ctoggle_heading_padding',
			[
				'label'      => esc_html__( 'Padding', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-ctoggle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'ctoggle_advance_setting' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'ctoggle_content_style',
			[
				'label' => esc_html__( 'Content', 'gyan-elements' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'section_content_1_style',
			[
				'label'     => esc_html__( 'Content 1', 'gyan-elements' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'ctoggle_select_section_1' => 'content',
				],
			]
		);

		$this->add_control(
			'section_content_1_color',
			[
				'label'     => esc_html__( 'Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'condition' => [
					'ctoggle_select_section_1' => 'content',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-ctoggle-content-1.gyan-ctoggle-section-1' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'section_content_1_typo',
				'selector'  => '{{WRAPPER}} .gyan-ctoggle-content-1.gyan-ctoggle-section-1',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_3,
				'condition' => [
					'ctoggle_select_section_1' => 'content',
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'section_content_2_style',
			[
				'label'     => esc_html__( 'Content 2', 'gyan-elements' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'ctoggle_select_section_2' => 'content',
				],
			]
		);

		$this->add_control(
			'section_content_2_color',
			[
				'label'     => esc_html__( 'Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'condition' => [
					'ctoggle_select_section_2' => 'content',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-ctoggle-content-2.gyan-ctoggle-section-2' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'section_content_2_typo',
				'selector'  => '{{WRAPPER}} .gyan-ctoggle-content-2.gyan-ctoggle-section-2',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_3,
				'condition' => [
					'ctoggle_select_section_2' => 'content',
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'ctoggle_content_advance_setting',
			[
				'label'     => esc_html__( 'Advanced', 'gyan-elements' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'OFF', 'gyan-elements' ),
				'label_on'  => esc_html__( 'ON', 'gyan-elements' ),
				'default'   => 'no',
				'return'    => 'yes',
			]
		);

		$this->add_control(
			'ctoggle_content_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-ctoggle-sections'     => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'ctoggle_content_advance_setting' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'content_border',
				'label'     => esc_html__( 'Border', 'gyan-elements' ),
				'selector'  => '{{WRAPPER}} .gyan-ctoggle-sections',
				'condition' => [
					'ctoggle_content_advance_setting' => 'yes',
				],
			]
		);

		$this->add_control(
			'content_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-ctoggle-sections' => 'overflow: hidden;border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'ctoggle_content_advance_setting' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'ctoggle_content_padding',
			[
				'label'      => esc_html__( 'Padding', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-ctoggle-sections' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'ctoggle_content_advance_setting' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'ctoggle_switch_spacing',
			[
				'label' => esc_html__( 'Spacing', 'gyan-elements' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'rds_button_headings_spacing',
			[
				'label'     => esc_html__( 'Button & Headings', 'gyan-elements' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					],
					'%' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'default'   => [
					'size' => 5,
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-ctoggle-desktop-stack-no .gyan-sec-1'         => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .gyan-ctoggle-desktop-stack-no .gyan-sec-2'         => 'margin-left: {{SIZE}}{{UNIT}};',

					'.rtl {{WRAPPER}} .gyan-ctoggle-desktop-stack-no .gyan-sec-1'         => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: 0{{UNIT}};',
					'.rtl {{WRAPPER}} .gyan-ctoggle-desktop-stack-no .gyan-sec-2'         => 'margin-right: {{SIZE}}{{UNIT}}; margin-left: 0{{UNIT}}',

					'{{WRAPPER}} .gyan-ctoggle-desktop-stack-yes .gyan-sec-1'         => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .gyan-ctoggle-desktop-stack-yes .gyan-sec-2'         => 'margin-top: {{SIZE}}{{UNIT}};',

					'(tablet){{WRAPPER}}.gyan-ct-stack--tablet .gyan-ctoggle-desktop-stack-no .gyan-sec-1'         => 'margin-bottom: {{SIZE}}{{UNIT}};margin-right: 0px;',
					'(tablet){{WRAPPER}}.gyan-ct-stack--tablet .gyan-ctoggle-desktop-stack-no .gyan-sec-2'         => 'margin-top: {{SIZE}}{{UNIT}};margin-left: 0px;',

					'(tablet){{WRAPPER}}.gyan-ct-stack--tablet .gyan-ctoggle-desktop-stack-no .gyan-ctoggle'         => 'flex-direction: column;',

					'(mobile){{WRAPPER}}.gyan-ct-stack--mobile .gyan-ctoggle-desktop-stack-no .gyan-sec-1'         => 'margin-bottom: {{SIZE}}{{UNIT}};margin-right: 0px;',
					'(mobile){{WRAPPER}}.gyan-ct-stack--mobile .gyan-ctoggle-desktop-stack-no .gyan-sec-2'         => 'margin-top: {{SIZE}}{{UNIT}};margin-left: 0px;',

					'(mobile){{WRAPPER}}.gyan-ct-stack--mobile .gyan-ctoggle-desktop-stack-no .gyan-ctoggle'         => 'flex-direction: column;',
				],
			]
		);

		$this->add_responsive_control(
			'rds_headings_content_spacing',
			[
				'label'     => esc_html__( 'Content & Headings', 'gyan-elements' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default'   => [
					'size' => 10,
					'unit' => 'px',
				],
				'range'     => [
					'px' => [
						'min'  => -100,
						'max'  => 500,
						'step' => 1,
					],
					'%' => [
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-ctoggle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	public function get_content_type() {

		$content_type = array(
			'content'              => esc_html__( 'Content', 'gyan-elements' ),
			'saved_rows'           => esc_html__( 'Saved Section', 'gyan-elements' ),
			'saved_page_templates' => esc_html__( 'Saved Page', 'gyan-elements' ),
		);

		return $content_type;
	}

	public function get_switch_type() {

		$switch_type = array(
			'round_1'   => esc_html__( 'Round 1', 'gyan-elements' ),
			'round_2'   => esc_html__( 'Round 2', 'gyan-elements' ),
			'rectangle' => esc_html__( 'Rectangle', 'gyan-elements' )
		);

		return $switch_type;
	}

	protected function render() {

		$settings  = $this->get_settings();
		$node_id   = $this->get_id();
		$is_editor = \Elementor\Plugin::instance()->editor->is_edit_mode();
		ob_start();
		include GYAN_ADDONS_DIR.'layouts/content-toggle/layout.php';
		$html = ob_get_clean();
		echo $html;
	}

	protected function _content_template() {}

}