<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Frontend;
use Elementor\Icons_Manager;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Gyan_Modal_Box extends Widget_Base {

	public function get_name()           { return 'gyan_modal_box'; }
	public function get_title()          { return esc_html__( 'Modal Box', 'gyan-elements' ); }
	public function get_icon()           { return 'gyan-el-icon eicon-form-horizontal'; }
	public function get_categories()     { return [ 'gyan-advanced-addons' ]; }
	public function get_keywords()       { return [ 'gyan modal box', 'gyan content box', 'gyan box' ]; }
	public function get_style_depends()  { return ['gyan-flex','gyan-icon','gyan-modal-box' ]; }
	public function get_script_depends() { return ['gyan-widgets', ]; }

	protected function register_controls() {


		$this->start_controls_section(
			'modal_content',
			[
				'label' => esc_html__( 'Modal Content', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'save_templates',
			[
				'label' => esc_html__( 'Use Save Templates', 'gyan-elements' ),
				'type' => Controls_Manager::SWITCHER,
			]
		);
		$this->add_control(
			'template',
			[
				'label' => esc_html__( 'Choose Template', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => gyan_get_page_templates(),
				'condition' => [
					'save_templates!' => '',
				],
				'description' => esc_html__('NOTE: Don\'t try to edit after insertion template. If you need to change the style or layout then you try to change the main template then save and then insert', 'gyan-elements'),
			]
		);
		$this->add_control(
			'modal_header',
			[
				'label' => esc_html__( 'Header Text', 'gyan-elements' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter Header Text', 'gyan-elements' ),
				'description' => esc_html__( 'You can use HTML.', 'gyan-elements' ),
				'default' => 'This is the Modal Box',
			]
		);
		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'gyan-elements' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter Title', 'gyan-elements' ),
				'description' => esc_html__( 'You can use HTML.', 'gyan-elements' ),
				'default' => 'This is the Modal Box Title',
				'condition' => [
					'save_templates' => '',
				],
			]
		);
		$this->add_control(
			'desc',
			[
				'label' => esc_html__( 'Description', 'gyan-elements' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter Description', 'gyan-elements' ),
				'description' => esc_html__( 'You can use HTML.', 'gyan-elements' ),
				'default' => 'Curabitur sed lacus faucibus efficitur nulla cursus dictum quam sraesent ornare nibh vel molestie fringilla bulla non vulputate odio posuere.',
				'condition' => [
					'save_templates' => '',
				],
			]
		);

		$this->add_control(
			'close_button_text',
			[
				'label' => esc_html__( '"Close" Button Text', 'gyan-elements' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'default' => 'Close',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'trigger_button',
			[
				'label' => esc_html__( 'Trigger Button', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'trigger_id',
			[
				'label' => esc_html__( 'Trigger ID', 'gyan-elements' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter Trigger ID', 'gyan-elements' ),
				'description' => esc_html__( 'Make sure this ID unique', 'gyan-elements' ),
			]
		);
		$this->add_control(
			'trigger_label',
			[
				'label' => esc_html__( 'Button Label', 'gyan-elements' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter Label', 'gyan-elements' ),
				'default' => 'Click Here',
			]
		);

		$this->add_control(
			'trigger_icon',
			[
				'label' => esc_html__( 'Button Icon', 'elementor' ),
				'type' => Controls_Manager::ICONS
			]
		);

		$this->add_control(
			'trigger_icon_position',
			[
				'label' => esc_html__( 'Icon Position', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'left' => esc_html__( 'Left', 'gyan-elements' ),
					'right' => esc_html__( 'Right', 'gyan-elements' ),
				],
				'condition' => [
					'trigger_icon!' => '',
				],
				'default' => 'right',
			]
		);
		$this->add_responsive_control(
			'trigger_icon_space',
			[
				'label' => esc_html__( 'Icon Space', 'gyan-elements' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '5',
				],
				'condition' => [
					'trigger_icon!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-modal-box .gyan-btn-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .gyan-modal-box .gyan-btn-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'modal_style',
			[
				'label' => esc_html__( 'Modal', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'modal_effects',
			[
				'label' => esc_html__( 'Effects', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'slideInDown',
				'options' => [
					'fadeIn' => esc_html__( 'Fade', 'gyan-elements' ),
					'fadeInUp' => esc_html__( 'Fade Up', 'gyan-elements' ),
					'fadeInDown' => esc_html__( 'Fade Down', 'gyan-elements' ),
					'fadeInLeft' => esc_html__( 'Fade Left', 'gyan-elements' ),
					'fadeInRight' => esc_html__( 'Fade Right', 'gyan-elements' ),
					'zoomIn' => esc_html__('Zoom In', 'gyan-elements'),
					'zoomInLeft' => esc_html__('Zoom In Left', 'gyan-elements'),
					'zoomInRight' => esc_html__('Zoom In Right', 'gyan-elements'),
					'bounceIn' => esc_html__('Bounce In', 'gyan-elements'),
					'slideInDown' => esc_html__('Slide In Down', 'gyan-elements'),
					'slideInLeft' => esc_html__('Slide In Left', 'gyan-elements'),
					'slideInRight' => esc_html__('Slide In Right', 'gyan-elements'),
					'slideInUp' => esc_html__('Slide In Up', 'gyan-elements'),
					'lightSpeedIn' => esc_html__('Light Speed In', 'gyan-elements'),
					'swing' => esc_html__( 'Swing', 'gyan-elements' ),
					'bounce' => esc_html__('Bounce', 'gyan-elements'),
					'flash' => esc_html__('Flash', 'gyan-elements'),
					'pulse' => esc_html__('Pulse', 'gyan-elements'),
					'rubberBand' => esc_html__('Rubber Band', 'gyan-elements'),
					'shake' => esc_html__('Shake', 'gyan-elements'),
					'headShake' => esc_html__('Head Shake', 'gyan-elements'),
					'swing' => esc_html__('Swing', 'gyan-elements'),
					'tada' => esc_html__('Tada', 'gyan-elements'),
					'wobble' => esc_html__('Wobble', 'gyan-elements'),
					'jello' => esc_html__('Jello', 'gyan-elements'),
				],
			]
		);
		$this->add_responsive_control(
			'modal_width',
			[
				'label' => esc_html__( 'Width', 'gyan-elements' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'max' => 900,
					],
					'%' => [
						'max' => 95,
					],
				],
				'desktop_default' => [
					'size' => 600,
				],
				'mobile_default' => [
					'size' => 300,
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-modal-content' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'modal_bg',
				'label' => esc_html__( 'Background', 'gyan-elements' ),
				'types' => [ 'classic', 'gradient' ],
				'fields_options' => [
					'background' => [
						'default' =>'classic',
					],
					'color' => [
						'default' => '#fff',
					],
				],
				'selector' => '{{WRAPPER}} .gyan-modal-content',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'modal_border',
				'selector' => '{{WRAPPER}} .gyan-modal-content',
			]
		);
		$this->add_responsive_control(
			'modal_radius',
			[
				'label' => esc_html__( 'Radius', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '8',
					'right' => '8',
					'bottom' => '8',
					'left' => '8',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-modal-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'modal_shadow',
				'fields_options' => [
					'box_shadow_type' => [
						'default' =>'yes'
					],
					'box_shadow' => [
						'default' => [
							'horizontal' => '0',
							'vertical' => '0',
							'blur' => '15',
							'color' => 'rgba(0,0,0,0.5)'
						]
					]
				],
				'selector' => '{{WRAPPER}} .gyan-modal-content',
			]
		);
		$this->add_control(
			'modal_overlay',
			[
				'label' => esc_html__( 'Overlay Background', 'gyan-elements' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'overlay_bg',
				'label' => esc_html__( 'Background', 'gyan-elements' ),
				'types' => [ 'classic', 'gradient' ],
				'fields_options' => [
					'background' => [
						'default' =>'classic',
					],
					'color' => [
						'default' => 'rgba(0,0,0,0.5)',
					],
				],
				'selector' => '{{WRAPPER}} .gyan-modal-overlay',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'header_style',
			[
				'label' => esc_html__( 'Header', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'modal_header!' => '',
				],
			]
		);

		$this->add_control(
			'header_color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .gyan-modal-header' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'header_typography',
				'fields_options' => [
					'typography' => [
						'default' =>'custom',
					],
					'font_weight' => [
						'default' => '600',
					],
					'font_size'   => [
						'default' => [
							'size' => '20',
						],
					],
					'line_height'   => [
						'default' => [
							'size' => '28',
						],
					],
					'text_transform' => [
						'default' => 'none',
					],
				],
				'selector' => '{{WRAPPER}} .gyan-modal-header',
			]
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'header_tshadow',
				'selector' => '{{WRAPPER}} .gyan-modal-header',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'header_bg',
				'label' => esc_html__( 'Background', 'gyan-elements' ),
				'types' => [ 'classic', 'gradient' ],
				'fields_options' => [
					'background' => [
						'default' =>'classic',
					],
					'color' => [
						'default' => '#d83030',
					],
				],
				'selector' => '{{WRAPPER}} .gyan-modal-header',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'header_border',
				'selector' => '{{WRAPPER}} .gyan-modal-header',
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'header_shadow',
				'selector' => '{{WRAPPER}} .gyan-modal-header',
			]
		);

		$this->add_responsive_control(
			'header_padding',
			[
				'label' => esc_html__( 'Padding', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '20',
					'right' => '25',
					'bottom' => '20',
					'left' => '25',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-modal-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'header_alignment',
			[
				'label' => esc_html__( 'Alignment', 'gyan-elements' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'gyan-elements' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'gyan-elements' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'gyan-elements' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .gyan-modal-header' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'footer_style',
			[
				'label' => esc_html__( 'Footer', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'footer_bg',
				'label' => esc_html__( 'Background', 'gyan-elements' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .gyan-modal-footer',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'footer_border',
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'color' => [
						'default' => '#e6e6e6',
					],
					'width' => [
						'default' => [
							'top' => '1',
							'right' => '0',
							'bottom' => '0',
							'left' => '0',
							'isLinked' => false,
						]
					],
				],
				'selector' => '{{WRAPPER}} .gyan-modal-footer',
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'footer_shadow',
				'selector' => '{{WRAPPER}} .gyan-modal-footer',
			]
		);
		$this->add_responsive_control(
			'footer_padding',
			[
				'label' => esc_html__( 'Padding', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '15',
					'right' => '25',
					'bottom' => '15',
					'left' => '25',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-modal-footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'close_btn',
			[
				'label' => esc_html__( 'Close Button Style', 'gyan-elements' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'close_btn_typography',
				'fields_options' => [
					'typography' => [
						'default' =>'custom',
					],
					'font_size'   => [
						'default' => [
							'size' => '14',
						],
					],
					'line_height'   => [
						'default' => [
							'size' => '18',
						],
					],
				],
				'selector' => '{{WRAPPER}} .gyan-modal-close',
			]
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'close_btn_text_shadow',
				'selector' => '{{WRAPPER}} .gyan-modal-close',
			]
		);

		$this->start_controls_tabs( 'close_btn_tabs' );

		$this->start_controls_tab(
			'close_btn_normal',
			[
				'label' => esc_html__( 'Normal', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'close_btn_color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#d83030',
				'selectors' => [
					'{{WRAPPER}} .gyan-modal-close' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'close_btn_background',
				'label' => esc_html__( 'Background', 'gyan-elements' ),
				'types' => [ 'classic', 'gradient' ],
				'fields_options' => [
					'background' => [
						'default' =>'classic',
					],
					'color' => [
						'default' => '#fff',
					],
				],
				'selector' => '{{WRAPPER}} .gyan-modal-close',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'close_btn_border',
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'color' => [
						'default' => '#d83030',
					],
					'width' => [
						'default' => [
							'top' => '1',
							'right' => '1',
							'bottom' => '1',
							'left' => '1',
							'isLinked' => true,
						]
					],
				],
				'selector' => '{{WRAPPER}} .gyan-modal-close',
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'close_btn_shadow',
				'selector' => '{{WRAPPER}} .gyan-modal-close',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'close_btn_hover',
			[
				'label' => esc_html__( 'Hover', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'close_hover_color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .gyan-modal-close:hover' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'close_hover_background',
				'label' => esc_html__( 'Background', 'gyan-elements' ),
				'types' => [ 'classic', 'gradient' ],
				'fields_options' => [
					'background' => [
						'default' =>'classic',
					],
					'color' => [
						'default' => '#d83030',
					],
				],
				'selector' => '{{WRAPPER}} .gyan-modal-close:hover'
			]
		);
		$this->add_control(
			'close_hover_border',
			[
				'label' => esc_html__( 'Border Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-modal-close:hover' => 'border-color: {{VALUE}}'
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'close_btn_hover_shadow',
				'selector' => '{{WRAPPER}} .gyan-modal-close:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'close_btn_radius',
			[
				'label' => esc_html__( 'Radius', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '4',
					'right' => '4',
					'bottom' => '4',
					'left' => '4',
					'isLinked' => false,
				],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .gyan-modal-close' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'close_btn_padding',
			[
				'label' => esc_html__( 'Padding', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '6',
					'right' => '15',
					'bottom' => '6',
					'left' => '15',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-modal-close' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'footer_alignment',
			[
				'label' => esc_html__( 'Alignment', 'gyan-elements' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'gyan-elements' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'gyan-elements' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'gyan-elements' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'right',
				'selectors' => [
					'{{WRAPPER}} .gyan-modal-footer' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'body_style',
			[
				'label' => esc_html__( 'Body', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'body_height',
			[
				'label' => esc_html__( 'Max Height', 'gyan-elements' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'max' => 900,
					],
				],
				'desktop_default' => [
					'size' => 300,
				],
				'mobile_default' => [
					'size' => 150,
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-modal-body' => 'max-height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'body_padding',
			[
				'label' => esc_html__( 'Padding', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '25',
					'right' => '25',
					'bottom' => '25',
					'left' => '25',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-modal-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'body_margin',
			[
				'label' => esc_html__( 'Margin', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '25',
					'right' => '0',
					'bottom' => '25',
					'left' => '0',
					'isLinked' => false,
				],
				'condition' => [
					'save_templates!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-modal-body' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'title_style',
			[
				'label' => esc_html__( 'Title', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'title!' => '',
					'save_templates' => '',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#222',
				'selectors' => [
					'{{WRAPPER}} .gyan-modal-title' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'fields_options' => [
					'typography' => [
						'default' =>'custom',
					],
					'font_weight' => [
						'default' => '400',
					],
					'font_size'   => [
						'default' => [
							'size' => '20',
						],
					],
					'line_height'   => [
						'default' => [
							'size' => '24',
						],
					],
				],
				'selector' => '{{WRAPPER}} .gyan-modal-title',
			]
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_shadow',
				'selector' => '{{WRAPPER}} .gyan-modal-title',
			]
		);
		$this->add_responsive_control(
			'title_margin',
			[
				'label' => esc_html__( 'Margin Bottom', 'gyan-elements' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'default' => [
					'size' => '14',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-modal-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'title_alignment',
			[
				'label' => esc_html__( 'Alignment', 'gyan-elements' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'gyan-elements' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'gyan-elements' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'gyan-elements' ),
						'icon' => 'fa fa-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'justify', 'gyan-elements' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .gyan-modal-title' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'desc_style',
			[
				'label' => esc_html__( 'Description', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'desc!' => '',
					'save_templates' => '',
				],
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#222',
				'selectors' => [
					'{{WRAPPER}} .gyan-modal-desc' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'desc_typography',
				'fields_options' => [
					'typography' => [
						'default' =>'custom',
					],
					'font_size'   => [
						'default' => [
							'size' => '16',
						],
					],
					'line_height'   => [
						'default' => [
							'size' => '24',
						],
					],
				],
				'selector' => '{{WRAPPER}} .gyan-modal-desc',
			]
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'desc_shadow',
				'selector' => '{{WRAPPER}} .gyan-modal-desc',
			]
		);
		$this->add_responsive_control(
			'desc_alignment',
			[
				'label' => esc_html__( 'Alignment', 'gyan-elements' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'gyan-elements' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'gyan-elements' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'gyan-elements' ),
						'icon' => 'fa fa-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'justify', 'gyan-elements' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .gyan-modal-desc' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'trigger_btn_style',
			[
				'label' => esc_html__( 'Trigger Button', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'trigger_btn_typography',
				'fields_options' => [
					'typography' => [
						'default' =>'custom',
					],
					'font_size'   => [
						'default' => [
							'size' => '16',
						],
					],
					'line_height'   => [
						'default' => [
							'size' => '24',
						],
					],
				],
				'selector' => '{{WRAPPER}} .gyan-modal-trigger',
			]
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'trigger_btn_text_shadow',
				'selector' => '{{WRAPPER}} .gyan-modal-trigger',
			]
		);

		$this->start_controls_tabs( 'trigger_btn_tabs' );

		$this->start_controls_tab(
			'trigger_btn_normal',
			[
				'label' => esc_html__( 'Normal', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'trigger_btn_color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .gyan-modal-trigger' => 'color: {{VALUE}};',
					'{{WRAPPER}} .gyan-modal-trigger svg' => 'fill: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'trigger_btn_background',
				'label' => esc_html__( 'Background', 'gyan-elements' ),
				'types' => [ 'classic', 'gradient' ],
				'fields_options' => [
					'background' => [
						'default' =>'classic',
					],
					'color' => [
						'default' => '#d83030',
					],
				],
				'selector' => '{{WRAPPER}} .gyan-modal-trigger',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'trigger_btn_border',
				'selector' => '{{WRAPPER}} .gyan-modal-trigger',
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'trigger_btn_shadow',
				'selector' => '{{WRAPPER}} .gyan-modal-trigger',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'trigger_btn_hover',
			[
				'label' => esc_html__( 'Hover', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'trigger_hover_color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-modal-trigger:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .gyan-modal-trigger:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'trigger_hover_background',
				'label' => esc_html__( 'Background', 'gyan-elements' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .gyan-modal-trigger:hover',
			]
		);
		$this->add_control(
			'trigger_hover_border',
			[
				'label' => esc_html__( 'Border Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-modal-trigger:hover' => 'border-color: {{VALUE}}'
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'trigger_btn_hover_shadow',
				'selector' => '{{WRAPPER}} .gyan-modal-trigger:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'trigger_btn_width',
			[
				'label' => esc_html__( 'Width', 'gyan-elements' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range' => [
					'px' => [
						'max' => 1000,
					],
					'em' => [
						'max' => 50,
					],
				],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .gyan-modal-trigger' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'trigger_btn_radius',
			[
				'label' => esc_html__( 'Radius', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '4',
					'right' => '4',
					'bottom' => '4',
					'left' => '4',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-modal-trigger' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'trigger_btn_padding',
			[
				'label' => esc_html__( 'Padding', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '11',
					'right' => '20',
					'bottom' => '11',
					'left' => '20',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-modal-trigger' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'trigger_alignment',
			[
				'label' => esc_html__( 'Alignment', 'gyan-elements' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'gyan-elements' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'gyan-elements' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'gyan-elements' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-btn-wrap' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$data = $this->get_settings_for_display();
		$trigger_id = $data['trigger_id'] ? $data['trigger_id'] : 'gyan-modal-'.$this->get_id();
		?>
		<div class="gyan-modal-box" data-modal-id="<?php echo esc_attr( $trigger_id ); ?>">
			<div class="gyan-btn-wrap">
				<button id="<?php echo esc_attr( $trigger_id ); ?>" class="gyan-button gyan-modal-trigger gyan-icon gyan-ease-transition">
					<?php if ( $data['trigger_icon'] && 'left' == $data['trigger_icon_position'] ): ?>
						<?php Icons_Manager::render_icon( $data['trigger_icon'], [ 'aria-hidden' => 'true','class' => 'gyan-btn-icon-left' ] ); ?>
					<?php endif ?>
					<span>
						<?php echo esc_html( $data['trigger_label'] ); ?>
					</span>
					<?php if ( $data['trigger_icon'] && 'right' == $data['trigger_icon_position'] ): ?>
						<?php Icons_Manager::render_icon( $data['trigger_icon'], [ 'aria-hidden' => 'true','class' => 'gyan-btn-icon-right' ] ); ?>
					<?php endif ?>
				</button>
			</div>
			<div class="gyan-modal-overlay <?php echo esc_attr( $trigger_id ); ?>">
				<div class="gyan-modal-area gyan-flex animated <?php echo esc_attr( $data['modal_effects'] ); ?>">
					<div class="gyan-modal-content">
						<?php if ( '' != $data['modal_header'] ): ?>
							<?php printf( '<h2 class="gyan-modal-header">%1$s</h2>', $data['modal_header'] ); ?>
						<?php endif; ?>
						<div class="gyan-modal-body">
							<?php
								if ( 'yes' == $data['save_templates'] && $data['template'] ) :
									$frontend = new Frontend;
									echo $frontend->get_builder_content( $data['template'], true );
								else:
							?>
								<?php if ( $data['title'] ): ?>
									<?php printf( '<h3 class="gyan-modal-title">%1$s</h3>', $data['title'] ); ?>
								<?php endif; ?>

								<?php if ( $data['desc'] ): ?>
									<?php printf( '<div class="gyan-modal-desc">%1$s</div>', $data['desc'] ); ?>
								<?php endif; ?>
							<?php endif; ?>
						</div>
						<div class="gyan-modal-footer">
							<button class="gyan-button gyan-modal-close <?php echo esc_attr( $trigger_id ); ?>"><?php echo esc_html($data['close_button_text']); ?></button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	protected function _content_template() {}

}