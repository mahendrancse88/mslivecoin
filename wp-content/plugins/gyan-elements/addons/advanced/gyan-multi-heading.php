<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Gyan_Multi_Heading extends Widget_Base {

	public function get_name()       { return 'gyan_multi_heading'; }
	public function get_title()      { return esc_html__( 'Multi Heading', 'gyan-elements' ); }
	public function get_icon()       { return 'gyan-el-icon eicon-heading'; }
	public function get_categories() { return [ 'gyan-advanced-addons' ]; }
	public function get_keywords()   { return [ 'heading', 'title', 'multi heading' ]; }
	public function get_style_depends()  { return ['gyan-multi-heading']; }

	protected function register_controls() {
		$this->start_controls_section(
			'section_content_heading',
			[
				'label' => esc_html__( 'Heading', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'sub_heading',
			[
				'label'       => esc_html__( 'Sub Heading', 'gyan-elements' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => esc_html__( 'Enter your prefix title', 'gyan-elements' ),
				'default'     => esc_html__( 'SUB HEADING TEXT', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'main_heading',
			[
				'label'       => esc_html__( 'Main Heading', 'gyan-elements' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => esc_html__( 'Enter main heading text here', 'gyan-elements' ),
				'default'     => esc_html__( 'Main Heading', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'split_main_heading',
			[
				'label'     => esc_html__( 'Split Main Heading', 'gyan-elements' ),
				'separator' => 'before',
				'type'      => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'split_text',
			[
				'label'       => esc_html__( 'Split Text', 'gyan-elements' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
                'placeholder' => esc_html__( 'Enter your split text', 'gyan-elements' ),
                'default'     => esc_html__( 'Split Text', 'gyan-elements' ),
                'condition'   => [
                    'split_main_heading' => 'yes'
				]
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => esc_html__( 'Link', 'gyan-elements' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'http://your-link.com',
			]
		);

		$this->add_control(
			'header_size',
			[
				'label'   => esc_html__( 'HTML Tag', 'gyan-elements' ),
				'type'    => Controls_Manager::SELECT,
				'options' => gyan_title_tags(),
				'default' => 'h2',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'   => esc_html__( 'Alignment', 'gyan-elements' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'gyan-elements' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'gyan-elements' ),
						'icon'  => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'gyan-elements' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],

			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_large_heading',
			[
				'label' => esc_html__( 'Large Heading', 'gyan-elements' ),
			]
		);
		$this->add_control(
			'large_heading',
			[
				'label'       => esc_html__( 'Large Heading', 'gyan-elements' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => esc_html__( 'Enter your large heading text', 'gyan-elements' ),
				'description' => esc_html__( 'This heading will show as style as background and you can move and style many way.', 'gyan-elements' ),
				'default'     => esc_html__( 'Large Heading', 'gyan-elements' ),
			]
		);

		$this->add_responsive_control(
			'large_heading_align',
			[
				'label'   => esc_html__( 'Alignment', 'gyan-elements' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'gyan-elements' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'gyan-elements' ),
						'icon'  => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'gyan-elements' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-multi-heading-content' => 'text-align: {{VALUE}};',
				],
			]
		);


		$this->add_responsive_control(
			'large_heading_x_position',
			[
				'label'   => esc_html__( 'X Offset', 'gyan-elements' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'tablet_default' => [
					'size' => 0,
				],
				'mobile_default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => -800,
						'max' => 800,
					],
				],
			]
		);

		$this->add_responsive_control(
			'large_heading_y_position',
			[
				'label'   => esc_html__( 'Y Offset', 'gyan-elements' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'tablet_default' => [
					'size' => 0,
				],
				'mobile_default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => -800,
						'max' => 800,
					],
				],
			]
		);

		$this->add_control(
			'large_heading_origin',
			[
				'label'       => esc_html__( 'Rotate Origin', 'gyan-elements' ),
				'description' => esc_html__( 'Origin work when you set rotate value', 'gyan-elements' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'top-left',
				'options'     => gyan_position(),
			]
		);

		$this->add_responsive_control(
			'large_heading_rotate',
			[
				'label'   => esc_html__( 'Rotate', 'gyan-elements' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'tablet_default' => [
					'size' => 0,
				],
				'mobile_default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min'  => -180,
						'max'  => 180,
						'step' => 5,
					],
				],
				'selectors' => [
					'(desktop){{WRAPPER}} .gyan-multi-heading .gyan-multi-heading-content > div' => 'transform: translate({{large_heading_x_position.SIZE}}px, {{large_heading_y_position.SIZE}}px) rotate({{SIZE}}deg);',
					'(tablet){{WRAPPER}} .gyan-multi-heading .gyan-multi-heading-content > div' => 'transform: translate({{large_heading_x_position_tablet.SIZE}}px, {{large_heading_y_position_tablet.SIZE}}px) rotate({{SIZE}}deg);',
					'(mobile){{WRAPPER}} .gyan-multi-heading .gyan-multi-heading-content > div' => 'transform: translate({{large_heading_x_position_mobile.SIZE}}px, {{large_heading_y_position_mobile.SIZE}}px) rotate({{SIZE}}deg);',
				],
			]
		);

		$this->add_control(
			'large_heading_hide',
			[
				'label'       => esc_html__( 'Hide at', 'gyan-elements' ),
				'description' => esc_html__( 'You can use this option in some cases where tablet, mobile devices show wrong width or doesn\'t look nice in layout design.', 'gyan-elements' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'm',
				'options'     => [
					''  => esc_html__('Nothing', 'gyan-elements'),
					'm' => esc_html__('Tablet and Mobile ', 'gyan-elements'),
					's' => esc_html__('Mobile', 'gyan-elements'),
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_sub_heading',
			[
				'label'     => esc_html__( 'Sub Heading', 'gyan-elements' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'sub_heading!' => '',
				]
			]
		);

		$this->add_control(
			'sub_heading_color',
			[
				'label'     => esc_html__( 'Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-multi-heading .gyan-sub-heading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'sub_heading_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .gyan-multi-heading .gyan-sub-heading',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'sub_heading_text_shadow',
				'selector' => '{{WRAPPER}} .gyan-multi-heading .gyan-sub-heading',
			]
		);

		$this->add_control(
			'sub_heading_style',
			[
				'label'   => esc_html__( 'Style', 'gyan-elements' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''     => esc_html__('None', 'gyan-elements'),
					'line' => esc_html__('Line', 'gyan-elements'),
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'sub_heading_style_color',
			[
				'label'     => esc_html__( 'Style Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-multi-heading .gyan-sub-heading .line:after' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'sub_heading_style' => 'line',
				],
			]
		);

		$this->add_responsive_control(
			'sub_heading_style_width',
			[
				'label' => esc_html__( 'Width', 'gyan-elements' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 1,
						'max'  => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-multi-heading .gyan-sub-heading .line:after' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'sub_heading_style' => 'line',
				],
			]
		);

		$this->add_responsive_control(
			'sub_heading_style_height',
			[
				'label' => esc_html__( 'Height', 'gyan-elements' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 1,
						'max'  => 48,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-multi-heading .gyan-sub-heading .line:after' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'sub_heading_style' => 'line',
				],
			]
		);

		$this->add_control(
			'sub_heading_style_align',
			[
				'label'   => esc_html__( 'Style Position', 'gyan-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'right'      => esc_html__( 'After', 'gyan-elements' ),
					'left'       => esc_html__( 'Before', 'gyan-elements' ),
					'left-right' => esc_html__( 'After and Before', 'gyan-elements' ),
					'bottom'     => esc_html__( 'Bottom', 'gyan-elements' ),
				],
				'condition' => [
					'sub_heading_style' => 'line',
				],
			]
		);

		$this->add_responsive_control(
			'sub_heading_style_indent',
			[
				'label'   => esc_html__( 'Style Spacing', 'gyan-elements' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 8,
				],
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'sub_heading_style' => 'line',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-multi-heading .gyan-button-icon-align-right'  => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .gyan-multi-heading .gyan-button-icon-align-left'   => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .gyan-multi-heading .gyan-button-icon-align-bottom' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_main_heading',
			[
				'label'     => esc_html__( 'Main Heading', 'gyan-elements' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'main_heading!' => '',
				],
			]
		);

		$this->start_controls_tabs('tabs_style_main_heading');

		$this->start_controls_tab(
			'tab_style_normal',
			[
				'label' => esc_html__('Normal', 'gyan-elements')
			]
		);

		$this->add_control(
			'main_heading_color',
			[
				'label'     => esc_html__( 'Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-multi-heading .gyan-main-heading > div' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'main_heading_background',
			[
				'label'     => esc_html__( 'Background', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-multi-heading .gyan-main-heading > div' => 'background-color: {{VALUE}};',
				]
			]
		);

		$this->add_responsive_control(
			'main_heading_padding',
			[
				'label'      => esc_html__('Padding', 'gyan-elements'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-multi-heading .gyan-main-heading > div' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'main_heading_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .gyan-multi-heading .gyan-main-heading > div'
			]
		);

		$this->add_control(
			'main_heading_radius',
			[
				'label'      => esc_html__('Radius', 'gyan-elements'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-multi-heading .gyan-main-heading > div' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'main_heading_shadow',
				'selector' => '{{WRAPPER}} .gyan-multi-heading .gyan-main-heading > div'
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'main_heading_text_shadow',
				'selector' => '{{WRAPPER}} .gyan-multi-heading .gyan-main-heading > div'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'main_heading_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .gyan-multi-heading .gyan-main-heading > div',
			]
		);

		$this->add_control(
			'heading_mainh_split_text',
			[
				'label'     => esc_html__( 'Split Text', 'gyan-elements' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'split_main_heading' => 'yes',
					'split_text!'        => ''
				]
			]
		);

		$this->add_control(
			'mainh_split_text_color',
			[
				'label'     => esc_html__( 'Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .gyan-multi-heading .gyan-main-heading .gyan-mainh-split-text' => 'color: {{VALUE}};',
				],
				'condition' => [
					'split_main_heading' => 'yes',
					'split_text!'        => ''
				]
			]
		);

		$this->add_control(
			'mainh_split_text_background',
			[
				'label'     => esc_html__( 'Background', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-multi-heading .gyan-main-heading .gyan-mainh-split-text' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'split_main_heading' => 'yes',
					'split_text!'        => ''
				]
			]
		);

        $this->add_responsive_control(
            'split_text_space',
            [
                'label'   => esc_html__( 'Split Space', 'gyan-elements' ),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-main-heading .gyan-main-heading-inner' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
                'condition'   => [
                    'split_main_heading' => 'yes'
                ],
                'separator'   => 'after',
            ]
        );

		$this->add_responsive_control(
			'mainh_split_text_padding',
			[
				'label'      => esc_html__('Padding', 'gyan-elements'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-multi-heading .gyan-main-heading .gyan-mainh-split-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
				'condition' => [
					'split_main_heading' => 'yes',
					'split_text!'        => ''
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'mainh_split_text_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .gyan-multi-heading .gyan-main-heading .gyan-mainh-split-text',
				'condition'   => [
					'split_main_heading' => 'yes',
					'split_text!'        => ''
				]
			]
		);

		$this->add_control(
			'mainh_split_text_radius',
			[
				'label'      => esc_html__('Radius', 'gyan-elements'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-multi-heading .gyan-main-heading .gyan-mainh-split-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;'
				],
				'condition' => [
					'split_main_heading' => 'yes',
					'split_text!'        => ''
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'mainh_split_text_shadow',
				'selector'  => '{{WRAPPER}} .gyan-multi-heading .gyan-main-heading .gyan-mainh-split-text',
				'condition' => [
					'split_main_heading' => 'yes',
					'split_text!'        => ''
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'mainh_split_text_typography',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .gyan-multi-heading .gyan-main-heading .gyan-mainh-split-text',
				'condition' => [
					'split_main_heading' => 'yes',
					'split_text!'        => ''
				]
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_style_multi',
			[
				'label' => esc_html__('Multi', 'gyan-elements')
			]
		);

		$this->add_control(
			'main_heading_multi_color',
			[
				'label'        => esc_html__( 'Multi Style', 'gyan-elements' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'gyan-ep-main-color-',
				'render_type'  => 'template',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'main_heading_multi_color',
				'selector' => '{{WRAPPER}} .gyan-multi-heading .gyan-main-heading > div'
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'main_heading_style',
			[
				'label'   => esc_html__( 'Style', 'gyan-elements' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''     => esc_html__('None', 'gyan-elements'),
					'line' => esc_html__('Line', 'gyan-elements'),
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'main_heading_style_color',
			[
				'label'     => esc_html__( 'Style Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-multi-heading .gyan-main-heading .line:after' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'main_heading_style' => 'line',
				],
			]
		);

		$this->add_responsive_control(
			'main_heading_style_width',
			[
				'label' => esc_html__( 'Width', 'gyan-elements' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 1,
						'max'  => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-multi-heading .gyan-main-heading .line:after' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'main_heading_style' => 'line',
				],
			]
		);

		$this->add_responsive_control(
			'main_heading_style_height',
			[
				'label' => esc_html__( 'Height', 'gyan-elements' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 1,
						'max'  => 48,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-multi-heading .gyan-main-heading .line:after' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'main_heading_style' => 'line',
				],
			]
		);

		$this->add_control(
			'main_heading_style_align',
			[
				'label'   => esc_html__( 'Style Position', 'gyan-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'bottom',
				'options' => [
					'right'      => esc_html__( 'After', 'gyan-elements' ),
					'left'       => esc_html__( 'Before', 'gyan-elements' ),
					'left-right' => esc_html__( 'After and Before', 'gyan-elements' ),
					'bottom'     => esc_html__( 'Bottom', 'gyan-elements' ),
				],
				'condition' => [
					'main_heading_style' => 'line',
				],
			]
		);

		$this->add_responsive_control(
			'main_heading_style_indent',
			[
				'label'   => esc_html__( 'Style Spacing', 'gyan-elements' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 8,
				],
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'main_heading_style' => 'line',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-multi-heading .gyan-main-heading .gyan-button-icon-align-right'  => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .gyan-multi-heading .gyan-main-heading .gyan-button-icon-align-left'   => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .gyan-multi-heading .gyan-main-heading .gyan-button-icon-align-bottom' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_large_heading',
			[
				'label'     => esc_html__( 'Large Heading', 'gyan-elements' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'large_heading!' => '',
				],
			]
		);

		$this->add_control(
			'large_heading_multi_color',
			[
				'label'        => esc_html__( 'Multi Style', 'gyan-elements' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'gyan-ep-multi-color-',
				'render_type'  => 'template',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'large_heading_multi_color',
				'selector'  => '{{WRAPPER}} .gyan-multi-heading .gyan-multi-heading-content > div',
				'condition' => [
					'large_heading_multi_color' => 'yes',
				],
			]
		);

		$this->add_control(
			'large_heading_color',
			[
				'label'     => esc_html__( 'Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-multi-heading .gyan-multi-heading-content > div' => 'color: {{VALUE}};',
				],
				'condition' => [
					'large_heading_multi_color!' => 'yes',
				],
			]
		);

		$this->add_control(
			'large_heading_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-multi-heading .gyan-multi-heading-content > div' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'large_heading_multi_color!' => 'yes',
				],
			]
		);

		$this->add_control(
			'large_heading_padding',
			[
				'label'      => esc_html__( 'Padding', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-multi-heading .gyan-multi-heading-content > div' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'large_heading_typography',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .gyan-multi-heading .gyan-multi-heading-content > div',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'large_heading_shadow',
				'selector' => '{{WRAPPER}} .gyan-multi-heading .gyan-multi-heading-content > div',
			]
		);


		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'large_heading_border',
				'label'       => esc_html__( 'Border', 'gyan-elements' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .gyan-multi-heading .gyan-multi-heading-content > div',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'large_heading_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-multi-heading .gyan-multi-heading-content > div' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'large_heading_box_shadow',
				'selector' => '{{WRAPPER}} .gyan-multi-heading .gyan-multi-heading-content > div',
			]
		);

		$this->add_control(
			'large_heading_opacity',
			[
				'label' => esc_html__( 'Opacity', 'gyan-elements' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 0.05,
						'max'  => 1,
						'step' => 0.05,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-multi-heading .gyan-multi-heading-content > div' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings         = $this->get_settings_for_display();
		$id               = $this->get_id();
		$heading_html     = [];
		$large_heading = '';
		$sub_heading      = '';
		$main_heading     = '';
		$split_heading    = '';

		if ( empty( $settings['sub_heading'] ) and empty( $settings['large_heading'] ) and empty( $settings['main_heading'] ) ) {
			return;
		}

		$this->add_render_attribute( 'heading', 'class', 'gyan-heading-title' );


		if ($settings['sub_heading']) {
			$subh_style = '';
			if ('line' === $settings['sub_heading_style']) {
				if ('left-right' === $settings['sub_heading_style_align']) {
					$subh_style = '<div class="line gyan-button-icon-align-left"></div><div class="line gyan-button-icon-align-right"></div>';
				} elseif ('bottom' === $settings['sub_heading_style_align']) {
					$subh_style = '<div class="line gyan-button-icon-align-'.$settings['sub_heading_style_align'].'"></div>';
				} else {
					$subh_style = '<div class="line gyan-button-icon-align-'.$settings['sub_heading_style_align'].'"></div>';
				}
			}

			$sub_heading = '<div class="gyan-sub-heading"><div class="gyan-sub-heading-content">'.$settings['sub_heading'].'</div>'.$subh_style.'</div> ';
		}

		if ($settings['large_heading']) {

			$this->add_render_attribute(
				[
					'avd-hclass' => [
						'class' => [
							'gyan-multi-heading-content',
							$settings['large_heading_hide'] ? 'gyan-visible@'. $settings['large_heading_hide'] : '',
						],
					],
				]
			);

			$this->add_render_attribute(
				[
					'avd-hcclass' => [
						'class' => [
							$settings['large_heading_origin'] ? 'gyan-transform-origin-'.$settings['large_heading_origin'] : '',
						],
					],
				]
			);

	   		$large_heading = '<div ' . $this->get_render_attribute_string( 'avd-hclass' ) . '><div ' . $this->get_render_attribute_string( 'avd-hcclass' ) . '>' .$settings['large_heading']. '</div></div>';
		}

		$this->add_render_attribute( 'main_heading', 'class', 'gyan-main-heading-inner' );
		$this->add_inline_editing_attributes( 'main_heading' );

		$this->add_render_attribute( 'split_heading', 'class', 'gyan-mainh-split-text' );

		if ($settings['main_heading']) :

			$mainh_style = '';

			if ('line' === $settings['main_heading_style']) {
				if ('left-right' === $settings['main_heading_style_align']) {
					$mainh_style = '<div class="line gyan-button-icon-align-left"></div><div class="line gyan-button-icon-align-right"></div>';
				} elseif ('bottom' === $settings['main_heading_style_align']) {
					$mainh_style = '<div class="line gyan-button-icon-align-'.$settings['main_heading_style_align'].'"></div>';
				} else {
					$mainh_style = '<div class="line gyan-button-icon-align-'.$settings['main_heading_style_align'].'"></div>';
				}
			}

			if ( ( 'yes' == $settings['split_main_heading'] ) and ( ! empty($settings['split_text']) ) ) {
				$split_heading = '<div '.$this->get_render_attribute_string( 'split_heading' ).'>' . $settings['split_text'] . '</div>';
			}

			$main_heading = '<div '.$this->get_render_attribute_string( 'main_heading' ).'>' . $settings['main_heading'] . '</div>';

			$main_heading = '<div class="gyan-main-heading">' . $main_heading . $split_heading . $mainh_style . '</div>';

		endif;

		if ( ! empty( $settings['link']['url'] ) ) {
			$this->add_render_attribute( 'url', 'href', $settings['link']['url'] );

			if ( $settings['link']['is_external'] ) {
				$this->add_render_attribute( 'url', 'target', '_blank' );
			}

			if ( ! empty( $settings['link']['nofollow'] ) ) {
				$this->add_render_attribute( 'url', 'rel', 'nofollow' );
			}

			$main_heading = sprintf( '<a %1$s>%2$s</a>', $this->get_render_attribute_string( 'url' ), $main_heading );
		}

		$heading_html[] = '<div id ="'.$id.'" class="gyan-multi-heading">';

		$heading_html[] = $large_heading;
		$heading_html[] = $sub_heading;
		$heading_html[] = sprintf( '<%1$s %2$s>%3$s</%1$s>', $settings['header_size'], $this->get_render_attribute_string( 'heading' ), $main_heading );

		$heading_html[] = '</div>';

		echo implode("", $heading_html);

	}

	protected function _content_template() {}

}