<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Modules\DynamicTags\Module as TagsModule;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Gyan_Info_Box extends Widget_Base {

	public function get_name()       { return 'gyan_info_box'; }
	public function get_title()      { return esc_html__( 'Info Box', 'gyan-elements' ); }
	public function get_icon()       { return 'gyan-el-icon eicon-info-box'; }
	public function get_categories() { return ['gyan-basic-addons']; }
	public function get_keywords()   { return ['info box', 'content box', 'box','icon','service' ]; }
	public function get_style_depends()  { return ['gyan-icon','gyan-position','gyan-animation-box','gyan-info-box']; }

	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'icon_type',
			[
				'label'       => esc_html__( 'Icon Type', 'gyan-elements' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'none' => [
						'title' => esc_html__( 'None', 'gyan-elements' ),
						'icon'  => 'fa fa-ban',
					],
					'icon' => [
						'title' => esc_html__( 'Icon', 'gyan-elements' ),
						'icon'  => 'fa fa-gear',
					],
					'image' => [
						'title' => esc_html__( 'Image', 'gyan-elements' ),
						'icon'  => 'fa fa-picture-o',
					],
					'text' => [
						'title' => esc_html__( 'Text', 'gyan-elements' ),
						'icon'  => 'fa fa-font',
					],
				],
				'default'     => 'icon',
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'elementor' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'fa-solid',
				],
				'condition' => [
					'icon_type' => 'icon',
				],
			]
		);

		$this->add_control(
			'image',
			[
				'label'     => esc_html__( 'Image', 'gyan-elements' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => GYAN_PLUGIN_URL .'addons/images/choose-img.jpg',
				],
				'condition' => [
					'icon_type' => 'image',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				'default'   => 'full',
				'separator' => 'none',
				'condition' => [
					'icon_type' => 'image',
				],
			]
		);

		$this->add_control(
			'icon_text',
			[
				'label'     => esc_html__( 'Icon Text', 'gyan-elements' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '1',
				'condition' => [
					'icon_type' => 'text',
				],
			]
		);

		$this->add_control(
			'count_number',
			[
				'label'   => esc_html__( 'Count Number', 'gyan-elements' ),
				'type'    => Controls_Manager::TEXT,
				'placeholder' => '01'
			]
		);

		$this->add_control(
			'title_text',
			[
				'label'   => esc_html__( 'Title', 'gyan-elements' ),
				'type'    => Controls_Manager::TEXT,
				'separator' => 'before',
				'default' => esc_html__( 'Title', 'gyan-elements' ),
			]
		);
		$this->add_control(
			'title_html_tag',
			[
				'label'   => esc_html__( 'Title HTML Tag', 'gyan-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h4',
				'options' => [
					'h1'   => esc_html__( 'H1', 'gyan-elements' ),
					'h2'   => esc_html__( 'H2', 'gyan-elements' ),
					'h3'   => esc_html__( 'H3', 'gyan-elements' ),
					'h4'   => esc_html__( 'H4', 'gyan-elements' ),
					'h5'   => esc_html__( 'H5', 'gyan-elements' ),
					'h6'   => esc_html__( 'H6', 'gyan-elements' ),
					'div'  => esc_html__( 'div', 'gyan-elements' ),
					'span' => esc_html__( 'span', 'gyan-elements' ),
					'p'    => esc_html__( 'p', 'gyan-elements' ),
				],
			]
		);

		$this->add_control(
			'content_text',
			[
				'label'   => esc_html__( 'Content', 'gyan-elements' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'content text here', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'content_html_tag',
			[
				'label'   => esc_html__( 'Content HTML Tag', 'gyan-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'div',
				'options' => [
					'h1'   => esc_html__( 'H1', 'gyan-elements' ),
					'h2'   => esc_html__( 'H2', 'gyan-elements' ),
					'h3'   => esc_html__( 'H3', 'gyan-elements' ),
					'h4'   => esc_html__( 'H4', 'gyan-elements' ),
					'h5'   => esc_html__( 'H5', 'gyan-elements' ),
					'h6'   => esc_html__( 'H6', 'gyan-elements' ),
					'div'  => esc_html__( 'div', 'gyan-elements' ),
					'span' => esc_html__( 'span', 'gyan-elements' ),
					'p'    => esc_html__( 'p', 'gyan-elements' ),
				],
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => esc_html__( 'Link', 'gyan-elements' ),
				'type'        => Controls_Manager::URL,
				'separator' => 'before',
				'placeholder' => 'https://www.your-link.com'
			]
		);

		$this->add_control(
			'link_place',
			[
				'label'   => esc_html__( 'Add Link On', 'gyan-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'icon_content',
				'options' => [
					'icon_content'   => esc_html__( 'Icon and Title', 'gyan-elements' ),
					'button_content' => esc_html__( 'Icon, Title and Button', 'gyan-elements' ),
					'button'         => esc_html__( 'Button', 'gyan-elements' ),
					'infobox'        => esc_html__( 'Info Box', 'gyan-elements' )
				]
			]
		);

		$this->end_controls_section();

		// Button ---------------------------------

		$this->start_controls_section(
			'section_button',
			[
				'label'     => esc_html__( 'Button', 'gyan-elements' ),
				'condition' => [
					'link_place' => array('button','button_content')
				],
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'     => esc_html__( 'Button Text', 'gyan-elements' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Read More', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'button_icon',
			[
				'label' => esc_html__( 'Button Icon', 'elementor' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_control(
			'button_icon_position',
			[
				'label'     => esc_html__( 'Icon Position', 'gyan-elements' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'after',
				'options'   => [
					'after'  => esc_html__( 'After', 'gyan-elements' ),
					'before' => esc_html__( 'Before', 'gyan-elements' ),
				],
				'condition' => [
					'button_icon!' => '',
				],
			]
		);

		$this->add_control(
			'button_fullwidth',
			[
				'label'        => esc_html__( 'Full Width Button', 'gyan-elements' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'gyan-elements' ),
				'label_off'    => esc_html__( 'No', 'gyan-elements' ),
				'default'      => 'no',
				'prefix_class' => 'gyan-infobox-fullwidth-button-',
			]
		);

		$this->end_controls_section();

		// Info box style

		$this->start_controls_section(
			'section_info_box_style',
			[
				'label' => esc_html__( 'Info Box', 'gyan-elements' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'icon_position',
				[
					'label' => esc_html__( 'Icon Position', 'elementor' ),
					'type' => Controls_Manager::CHOOSE,
					'default' => 'top',
					'options' => [
						'left' => [
							'title' => esc_html__( 'Left', 'elementor' ),
							'icon' => 'eicon-h-align-left',
						],
						'top' => [
							'title' => esc_html__( 'Top', 'elementor' ),
							'icon' => 'eicon-v-align-top',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'elementor' ),
							'icon' => 'eicon-h-align-right',
						],
					],
					'prefix_class' => 'gyan-infobox-position-',
					'toggle' => false
				]
			);

			$this->add_control(
				'center_icon_at_mobile',
				[
					'label'        => esc_html__( 'Icon Position Center at Mobile', 'gyan-elements' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'gyan-elements' ),
					'label_off'    => esc_html__( 'No', 'gyan-elements' ),
					'default'      => 'no',
					'separator'    => 'after',
					'prefix_class' => 'gyan-infobox-center-',
				]
			);

			$this->add_responsive_control(
				'align',
				[
					'label'     => esc_html__( 'Text Align', 'gyan-elements' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => [
						'left'    => [
							'title' => esc_html__( 'Left', 'gyan-elements' ),
							'icon'  => 'fa fa-align-left',
						],
						'center'  => [
							'title' => esc_html__( 'Center', 'gyan-elements' ),
							'icon'  => 'fa fa-align-center',
						],
						'right'   => [
							'title' => esc_html__( 'Right', 'gyan-elements' ),
							'icon'  => 'fa fa-align-right',
						],
					],
					'default'   => 'center',
					'condition' => [
						'icon_position' => 'top',
					],
					'prefix_class'  => 'gyan-infobox-align-',
				]
			);

			$this->add_control(
				'info_box_custom_height',
				[
					'label'                 => esc_html__( 'Custom Height', 'gyan-elements' ),
					'type'                  => Controls_Manager::SWITCHER,
					'default'               => 'no',
	                'label_on'              => esc_html__( 'Yes', 'gyan-elements' ),
	                'label_off'             => esc_html__( 'No', 'gyan-elements' ),
					'condition' => [
						'icon_position' => 'top',
					],
	                'return_value'          => 'yes',
				]
			);

			$this->add_responsive_control(
				'info_box_height',
				[
					'label' => esc_html__( 'Height', 'gyan-elements' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'em' ],
					'range' => [
						'px' => [
							'max' => 1000,
						],
						'em' => [
							'max' => 50,
						],
					],
					'default' => [
						'size' => '230',
					],
					'condition' => [
						'info_box_custom_height' => 'yes',
						'icon_position' => 'top',
					],
					'selectors' => [
						'{{WRAPPER}} .gyan-info-box' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'info_box_rotate',
				[
					'label' => esc_html__( 'Rotate', 'elementor' ),
					'type' => Controls_Manager::SLIDER,
					'default' => [
						'size' => 0,
						'unit' => 'deg',
					],
					'condition'  => [
						'infobox_hover_animation' => 'none',
					],
					'selectors' => [
						'{{WRAPPER}} .gyan-info-box' => 'transform: rotate({{SIZE}}{{UNIT}});',
					],
				]
			);


		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'info_box_border',
				'label'       => esc_html__( 'Border', 'gyan-elements' ),
				'selector'    => '{{WRAPPER}} .gyan-info-box',
			]
		);
		$this->add_responsive_control(
			'info_box_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-info-box,
					{{WRAPPER}} .gyan-animation-box:before,
				    {{WRAPPER}} .gyan-animation-box:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'info_box_padding',
			[
				'label'      => esc_html__( 'Padding', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-info-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'info_box_margin',
			[
				'label'      => esc_html__( 'Margin', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-info-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// Title Style -----------------------

		$this->start_controls_section(
			'section_title_content_style',
			[
				'label' => esc_html__( 'Title/Conent', 'gyan-elements' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'gyan-elements' ),
				'selector' => '{{WRAPPER}} .gyan-infobox-title',
			]
		);

		$this->add_responsive_control(
			'title_top_margin',
			[
				'label'      => esc_html__( 'Top Margin', 'gyan-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'size' => 0,
				],
				'range'      => [
					'px' => [
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					],
					'%' => [
						'min'  => 0,
						'max'  => 30,
						'step' => 1,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-infobox-title' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		// $this->add_responsive_control(
		// 	'title_bottom_margin',
		// 	[
		// 		'label'      => esc_html__( 'Old-Bottom-Margin-Depricated', 'gyan-elements' ),
		// 		'type'       => Controls_Manager::SLIDER,
		// 		'default'    => [
		// 			'size' => 0,
		// 		],
		// 		'range'      => [
		// 			'px' => [
		// 				'min'  => -100,
		// 				'max'  => 100,
		// 				'step' => 1,
		// 			],
		// 			'%' => [
		// 				'min'  => 0,
		// 				'max'  => 30,
		// 				'step' => 1,
		// 			],
		// 		],
		// 		'size_units' => [ 'px', '%' ],
		// 		'selectors'  => [
		// 			'{{WRAPPER}} .gyan-infobox-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
		// 		],
		// 	]
		// );

		$this->add_responsive_control(
			'title_spacing',
			[
				'label'      => esc_html__( 'Bottom Margin', 'gyan-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'size' => 20,
				],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
					'%' => [
						'min'  => 0,
						'max'  => 30,
						'step' => 1,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-infobox-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'line_separator',
			[
				'label'                 => esc_html__( 'Line Separator', 'gyan-elements' ),
				'type'                  => Controls_Manager::SWITCHER,
				'default'               => 'no',
                'label_on'              => esc_html__( 'Yes', 'gyan-elements' ),
                'label_off'             => esc_html__( 'No', 'gyan-elements' ),
                'separator' => 'before',
                'return_value'          => 'yes',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'line_separator_border',
				'label'       => esc_html__( 'Border', 'gyan-elements' ),
				'selector'    => '{{WRAPPER}} .gyan-infobox-line-separator',
				'condition' => [
					'line_separator' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'line_separator_width',
			[
				'label' => esc_html__( 'Separator Width', 'gyan-elements' ),
				'type'  => Controls_Manager::SLIDER,
				'default'    => [
					'size' => 60,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 600,
					],
				],
				'condition' => [
					'line_separator' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-infobox-line-separator' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'separator_spacing',
			[
				'label'      => esc_html__( 'Spacing', 'gyan-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'size' => 20,
				],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
					'%' => [
						'min'  => 0,
						'max'  => 30,
						'step' => 1,
					],
				],
				'size_units' => [ 'px', '%' ],
				'condition' => [
					'line_separator' => 'yes',
				],
				'selectors'  => [
					'{{WRAPPER}} .gyan-infobox-line-separator' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'content_heading',
			[
				'label'     => esc_html__( 'Content', 'gyan-elements' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'content_text!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'content_typography',
				'label'     => esc_html__( 'Typography', 'gyan-elements' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'condition' => [
					'content_text!' => '',
				],
				'selector'  => '{{WRAPPER}} .gyan-infobox-content',
			]
		);

		$this->add_responsive_control(
			'content_spacing',
			[
				'label'      => esc_html__( 'Spacing', 'gyan-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'size' => 20,
				],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
					'%' => [
						'min'  => 0,
						'max'  => 30,
						'step' => 1,
					],
				],
				'size_units' => [ 'px', '%' ],
				'condition'  => [
					'content_text!' => '',
				],
				'selectors'  => [
					'{{WRAPPER}} .gyan-infobox-content' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();


		// Icon/Image -------------------------------

		$this->start_controls_section(
			'section_icon_style',
			[
				'label'     => esc_html__( 'Icon / Image', 'gyan-elements' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'icon_type!' => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'gyan-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min'  => 5,
						'max'  => 100,
						'step' => 1,
					],
				],
				'size_units' => [ 'px', 'em' ],
				'condition'  => [
					'icon_type' => 'icon',
				],
				'selectors'  => [
					'{{WRAPPER}} .gyan-infobox-icon-holder' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'icon_img_width',
			[
				'label'      => esc_html__( 'Image Width', 'gyan-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min'  => 25,
						'max'  => 600,
						'step' => 1,
					],
					'%' => [
						'min'  => 25,
						'max'  => 100,
						'step' => 1,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-infobox-image, {{WRAPPER}} .gyan-infobox-image img' => 'width: {{SIZE}}{{UNIT}}',
				],
				'condition'  => [
					'icon_type' => 'image',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'icon_typography',
				'label'     => esc_html__( 'Typography', 'gyan-elements' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'condition' => [
					'icon_type' => 'text',
				],
				'selector'  => '{{WRAPPER}} .gyan-infobox-text',
			]
		);

		if ( is_rtl() ) {

			$this->add_responsive_control(
				'icon_spacing',
				[
					'label'      => esc_html__( 'Spacing', 'gyan-elements' ),
					'type'       => Controls_Manager::SLIDER,
					'default'    => [
						'size' => 20,
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 100,
							'step' => 1,
						],
						'%' => [
							'min'  => 0,
							'max'  => 30,
							'step' => 1,
						],
					],
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}}.gyan-infobox-position-right .gyan-infobox-icon-holder' => 'margin-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}}.gyan-infobox-position-left .gyan-infobox-icon-holder' => 'margin-left: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}}.gyan-infobox-position-top .gyan-infobox-icon-holder' => 'margin-bottom: {{SIZE}}{{UNIT}};',
						'(mobile){{WRAPPER}} .gyan-infobox-icon-holder' => 'margin-bottom: {{SIZE}}{{UNIT}};',
						'(mobile){{WRAPPER}}.gyan-infobox-position-right.gyan-infobox-center-yes .gyan-infobox-icon-holder' => 'margin-right:0;',
						'(mobile){{WRAPPER}}.gyan-infobox-position-left.gyan-infobox-center-yes .gyan-infobox-icon-holder' => 'margin-left:0;',
					],
				]
			);

		} else {

			$this->add_responsive_control(
				'icon_spacing',
				[
					'label'      => esc_html__( 'Spacing', 'gyan-elements' ),
					'type'       => Controls_Manager::SLIDER,
					'default'    => [
						'size' => 20,
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 100,
							'step' => 1,
						],
						'%' => [
							'min'  => 0,
							'max'  => 30,
							'step' => 1,
						],
					],
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}}.gyan-infobox-position-right .gyan-infobox-icon-holder' => 'margin-left: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}}.gyan-infobox-position-left .gyan-infobox-icon-holder' => 'margin-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}}.gyan-infobox-position-top .gyan-infobox-icon-holder' => 'margin-bottom: {{SIZE}}{{UNIT}};',
						'(mobile){{WRAPPER}} .gyan-infobox-icon-holder' => 'margin-bottom: {{SIZE}}{{UNIT}};',
						'(mobile){{WRAPPER}}.gyan-infobox-position-right.gyan-infobox-center-yes .gyan-infobox-icon-holder' => 'margin-left:0;',
						'(mobile){{WRAPPER}}.gyan-infobox-position-left.gyan-infobox-center-yes .gyan-infobox-icon-holder' => 'margin-right:0;',
					],
				]
			);

		}

		$this->add_responsive_control(
			'icon_box_size',
			[
				'label'      => esc_html__( 'Box Size', 'gyan-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 250,
						'step' => 1,
					],
				],
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-infobox-icon-holder' => 'height:{{SIZE}}{{UNIT}}; width:{{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-infobox-icon-holder,{{WRAPPER}} .gyan-infobox-icon-holder img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'icon_border',
				'label'       => esc_html__( 'Border', 'gyan-elements' ),
				'selector'    => '{{WRAPPER}} .gyan-infobox-icon-holder',
			]
		);

		$this->add_responsive_control(
			'icon_padding',
			[
				'label'      => esc_html__( 'Padding', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'condition' => [
					'button_type' => array('button','icon_box')
				],
				'selectors'  => [
					'{{WRAPPER}} .gyan-infobox-icon-holder' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'iconbox_hover_animation',
			[
				'label'   => esc_html__( 'Hover Icon Box Animation', 'gyan-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'none',
				'separator' => 'before',
				'options' => [
					'none'       => esc_html__( 'None', 'gyan-elements' ),
					'rotate-90'  => esc_html__( 'Rotate 90 Degree', 'gyan-elements' ),
					'rotate-180' => esc_html__( 'Rotate 180 Degree', 'gyan-elements' ),
					'rotate-360' => esc_html__( 'Rotate 360 Degree', 'gyan-elements' ),
					'rotate'     => esc_html__( 'Rotate Infinite', 'gyan-elements' ),
					'scale'      => esc_html__( 'Scale', 'gyan-elements' ),
					'flip'       => esc_html__( 'Flip', 'gyan-elements' ),
					'pulse'      => esc_html__( 'Pulse', 'gyan-elements' ),
					'wiggle'     => esc_html__( 'Wiggle', 'gyan-elements' ),
					'shake'      => esc_html__( 'Shake', 'gyan-elements' )
				],
				'prefix_class'  => 'gyan-hover-animation-',
			]
		);

		$this->add_control(
			'icon_box_rotate',
			[
				'label' => esc_html__( 'Rotate Icon Box', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
					'unit' => 'deg',
				],
				'condition'  => [
					'iconbox_hover_animation' => 'none',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-infobox-icon-holder' => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_control(
			'icon_box_icon_rotate',
			[
				'label' => esc_html__( 'Rotate Icon/Image', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
					'unit' => 'deg',
				],
				'condition'  => [
					'iconbox_hover_animation' => 'none',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-infobox-icon,
					{{WRAPPER}} .gyan-infobox-image,
					{{WRAPPER}} .gyan-infobox-text' => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->end_controls_section();

		// Count Number Style -----------------------

		$this->start_controls_section(
			'count_number_style',
			[
				'label' => esc_html__( 'Count Number', 'gyan-elements' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'icon_type!' => 'none',
					'count_number!' => ''
				],
			]
		);

		$this->add_responsive_control(
		    'count_number_size',
		    [
		        'label'     => esc_html__( 'Size', 'gyan-elements' ),
		        'type'      => Controls_Manager::SLIDER,
		        'default'   => [
		            'size' => 44,
		        ],
		        'range'     => [
		            'px' => [
		                'min' => 0,
		                'max' => 200,
		            ],
		        ],
		        'selectors' => [
		            '{{WRAPPER}} .gyan-infobox-number-circle' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_control(
			'number_circle_position',
			[
				'label'     => esc_html__( 'Number Circle Position', 'gyan-elements' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => gyan_position(),
				'default'   => 'top-right',
				'condition' => [
					'icon_type!' => 'none',
				],
			]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name'  => 'count_number_typography',
		        'label' => esc_html__( 'Typography', 'gyan-elements' ),
		        'fields_options' => [
		            'typography' => [
		                'default' =>'custom',
		            ],
		            'font_size'   => [
		                'default' => [
		                    'unit' => 'px',
		                    'size' => '14',
		                ],
		            ],
		            'font_weight' => [
		                'default' => '700',
		            ],
		        ],
		        'selector' => '{{WRAPPER}} .gyan-infobox-number-circle',
		    ]
		);

		$this->add_control(
			'count_number_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-infobox-number-circle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'count_number_margin',
			[
				'label'       => esc_html__( 'Margin', 'gyan-elements' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => [ 'px', '%' ],
				'selectors'   => [
					'{{WRAPPER}} .gyan-infobox-number-circle' => 'margin-top: {{TOP}}{{UNIT}}; margin-left: {{LEFT}}{{UNIT}}; margin-right: {{RIGHT}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'count_number_text',
			[
				'label'     => esc_html__( 'Tab Text Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .gyan-infobox-number-circle' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
		    Group_Control_Background::get_type(),
		    [
		        'name' => 'count_number_bg',
		        'label' => esc_html__( 'Tabs Background', 'gyan-elements' ),
		        'types' => [ 'classic', 'gradient' ],
				'fields_options' => [
					'background' => [
						'default' =>'classic',
					],
					'color' => [
						'default' => '#d83030',
					],
				],
		        'selector' => '{{WRAPPER}} .gyan-infobox-number-circle',
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'count_number_border',
		        'selector' => '{{WRAPPER}} .gyan-infobox-number-circle',
		    ]
		);

		$this->end_controls_section();

		// Normal/Hover Colors --------------------------------------

		$this->start_controls_section(
			'section_box_all_style',
			[
				'label'     => esc_html__( 'Normal/Hover Colors', 'gyan-elements' ),
				'tab'       => Controls_Manager::TAB_STYLE
			]
		);

			$this->start_controls_tabs( 'box_all_style' );

				$this->start_controls_tab(
					'box_all_normal',
					[
						'label' => esc_html__( 'Normal', 'gyan-elements' ),
					]
				);

				$this->add_control(
					'infobox_color_heading',
					[
						'label'     => esc_html__( 'Info Box', 'gyan-elements' ),
						'type'      => Controls_Manager::HEADING
					]
				);

				$this->add_group_control(
				    Group_Control_Background::get_type(),
				    [
				        'name' => 'info_box_bg',
				        'label' => esc_html__( 'Info Box Background', 'gyan-elements' ),
				        'types' => [ 'classic', 'gradient' ],
				        'selector' => '{{WRAPPER}} .gyan-info-box',
				    ]
				);

				$this->add_group_control(
				    Group_Control_Box_Shadow::get_type(),
				    [
				        'name' => 'info_box_shadow',
				        'label' => esc_html__( 'Info Box - Box Shadow', 'gyan-elements' ),
				        'selector' => '{{WRAPPER}} .gyan-info-box',
				    ]
				);

				$this->add_control(
					'title_content_color_heading',
					[
						'label'     => esc_html__( 'Title/Content', 'gyan-elements' ),
						'type'      => Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);

				$this->add_control(
					'title_color',
					[
						'label'     => esc_html__( 'Title Color', 'gyan-elements' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#010b39',
						'selectors' => [
							'{{WRAPPER}} .gyan-info-box .gyan-infobox-title,
							{{WRAPPER}} .gyan-info-box .gyan-infobox-title a' => 'color: {{VALUE}}',
						],
					]
				);

				$this->add_control(
					'content_color',
					[
						'label'     => esc_html__( 'Content Text Color', 'gyan-elements' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#676767',
						'condition' => [
							'content_text!' => '',
						],
						'selectors' => [
							'{{WRAPPER}} .gyan-info-box .gyan-infobox-content,
							{{WRAPPER}} .gyan-info-box .gyan-infobox-content a' => 'color: {{VALUE}}',
						],
					]
				);

				$this->add_control(
					'icon_color_heading',
					[
						'label'     => esc_html__( 'Icon', 'gyan-elements' ),
						'type'      => Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);

				$this->add_control(
					'icon_color_normal',
					[
						'label'     => esc_html__( 'Icon Color', 'gyan-elements' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#d83030',
						'selectors' => [
							'{{WRAPPER}} .gyan-info-box .gyan-infobox-icon,
							{{WRAPPER}} .gyan-info-box .gyan-infobox-text' => 'color: {{VALUE}}',
							'{{WRAPPER}} .gyan-info-box .gyan-infobox-icon svg' => 'fill: {{VALUE}}',
						],
						'condition' => [
							'icon_type!' => 'image',
						],
					]
				);

				$this->add_group_control(
				    Group_Control_Background::get_type(),
				    [
				        'name' => 'icon_box_bg',
				        'label' => esc_html__( 'Icon Box Background', 'gyan-elements' ),
				        'types' => [ 'classic', 'gradient' ],
				        'selector' => '{{WRAPPER}} .gyan-info-box .gyan-infobox-icon-holder',
				    ]
				);

				$this->add_group_control(
				    Group_Control_Box_Shadow::get_type(),
				    [
				        'name' => 'icon_box_shadow',
				        'label' => esc_html__( 'Icon Box - Box Shadow', 'gyan-elements' ),
				        'selector' => '{{WRAPPER}} .gyan-info-box .gyan-infobox-icon-holder',
				    ]
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'box_all_hover',
					[
						'label' => esc_html__( 'Hover', 'gyan-elements' ),
					]
				);

				$this->add_control(
					'infobox_color_heading_hover',
					[
						'label'     => esc_html__( 'Info Box', 'gyan-elements' ),
						'type'      => Controls_Manager::HEADING
					]
				);

				$this->add_control(
					'infobox_hover_animation',
					[
						'label'   => esc_html__( 'Background Animation', 'gyan-elements' ),
						'type'    => Controls_Manager::SELECT,
						'default' => 'fade',
						'options' => Gyan_Common_Data::animation_box(),
						'prefix_class'  => 'gyan-animation-box-',
					]
				);

				$this->add_group_control(
				    Group_Control_Background::get_type(),
				    [
				        'name' => 'info_box_bg_hover',
				        'label' => esc_html__( 'Info Box Background', 'gyan-elements' ),
				        'types' => [ 'classic', 'gradient' ],
				        'selector' => '{{WRAPPER}} .gyan-animation-box:before,
				        				{{WRAPPER}} .gyan-animation-box:after',
				    ]
				);

				$this->add_control(
				    'info_box_border_hover',
				    [
				        'label' => esc_html__( 'Info Box Border Color', 'gyan-elements' ),
				        'type' => Controls_Manager::COLOR,
				        'selectors' => [
				            '{{WRAPPER}} .gyan-info-box:hover' => 'border-color: {{VALUE}};'
				        ],
				    ]
				);

				$this->add_group_control(
				    Group_Control_Box_Shadow::get_type(),
				    [
				        'name' => 'info_box_shadow_hover',
				        'label' => esc_html__( 'Info Box - Box Shadow', 'gyan-elements' ),
				        'selector' => '{{WRAPPER}} .gyan-info-box:hover',
				    ]
				);

				$this->add_control(
					'title_content_color_heading_hover',
					[
						'label'     => esc_html__( 'Title/Content', 'gyan-elements' ),
						'type'      => Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);

				$this->add_control(
					'title_color_hover',
					[
						'label'     => esc_html__( 'Title Color', 'gyan-elements' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .gyan-info-box:hover .gyan-infobox-title,
							{{WRAPPER}} .gyan-info-box:hover .gyan-infobox-title a' => 'color: {{VALUE}}',
						],
					]
				);

				$this->add_control(
				    'line_separator_border_hover',
				    [
				        'label' => esc_html__( 'Line Separator', 'gyan-elements' ),
				        'type' => Controls_Manager::COLOR,
						'condition' => [
							'line_separator' => 'yes',
						],
				        'selectors' => [
				            '{{WRAPPER}} .gyan-info-box:hover .gyan-infobox-line-separator' => 'border-color: {{VALUE}};'
				        ],
				    ]
				);

				$this->add_control(
					'content_color_hover',
					[
						'label'     => esc_html__( 'Content Text Color', 'gyan-elements' ),
						'type'      => Controls_Manager::COLOR,
						'condition' => [
							'content_text!' => '',
						],
						'selectors' => [
							'{{WRAPPER}} .gyan-info-box:hover .gyan-infobox-content,
							{{WRAPPER}} .gyan-info-box:hover .gyan-infobox-content a' => 'color: {{VALUE}}',
						],
					]
				);

				$this->add_control(
					'icon_color_heading_hover',
					[
						'label'     => esc_html__( 'Icon', 'gyan-elements' ),
						'type'      => Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);

				$this->add_control(
					'icon_color_hover',
					[
						'label'     => esc_html__( 'Icon Color', 'gyan-elements' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .gyan-info-box:hover .gyan-infobox-icon,
							{{WRAPPER}} .gyan-info-box:hover .gyan-infobox-text' => 'color: {{VALUE}}',
							'{{WRAPPER}} .gyan-info-box:hover .gyan-infobox-icon svg' => 'fill: {{VALUE}}',
						],
						'condition' => [
							'icon_type!' => 'image',
						],
					]
				);

				$this->add_group_control(
				    Group_Control_Background::get_type(),
				    [
				        'name' => 'icon_box_bg_hover',
				        'label' => esc_html__( 'Icon Box Background', 'gyan-elements' ),
				        'types' => [ 'classic', 'gradient' ],
				        'selector' => '{{WRAPPER}} .gyan-info-box:hover .gyan-infobox-icon-holder',
				    ]
				);

				$this->add_group_control(
				    Group_Control_Box_Shadow::get_type(),
				    [
				        'name' => 'icon_box_shadow_hover',
				        'label' => esc_html__( 'Icon Box - Box Shadow', 'gyan-elements' ),
				        'selector' => '{{WRAPPER}} .gyan-info-box:hover .gyan-infobox-icon-holder',
				    ]
				);

				$this->add_control(
				    'icon_box_border_hover',
				    [
				        'label' => esc_html__( 'Icon Box Border Color', 'gyan-elements' ),
				        'type' => Controls_Manager::COLOR,
				        'selectors' => [
				            '{{WRAPPER}} .gyan-info-box:hover .gyan-infobox-icon-holder' => 'border-color: {{VALUE}};'
				        ],
				    ]
				);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();

		// Button ------------------------------------

		$this->start_controls_section(
			'section_info_box_button_style',
			[
				'label'     => esc_html__( 'Button', 'gyan-elements' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'link_place' => array('button','button_content')
				],
			]
		);

		$this->add_control(
			'button_type',
			[
				'label'     => esc_html__( 'Button Type', 'gyan-elements' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'button',
				'options'   => [
					'text'  => esc_html__( 'Only Text', 'gyan-elements' ),
					'button' => esc_html__( 'Text with Button Shape', 'gyan-elements' ),
					'icon_box' => esc_html__( 'Icon Box', 'gyan-elements' ),
				],
				'condition' => [
					'button_icon!' => '',
				],
				'prefix_class' => 'gyan-infobox-button-type-',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'button_typography',
				'label'     => esc_html__( 'Typography', 'gyan-elements' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .gyan-info-box-button',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'button_border_normal',
				'label'       => esc_html__( 'Border', 'gyan-elements' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'condition' => [
					'button_type' => array('button','icon_box')
				],
				'selector'    => '{{WRAPPER}} .gyan-info-box-button',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'condition' => [
					'button_type' => array('button','icon_box')
				],
				'default' => [
                    'top' => '3',
                    'right' => '3',
                    'bottom' => '3',
                    'left' => '3',
                    'isLinked' => true,
                    'unit'   => 'px',
                ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-info-box-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-info-box-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_margin',
			[
				'label'       => esc_html__( 'Margin', 'gyan-elements' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => [ 'px', '%' ],
				'placeholder' => [
					'top'    => '',
					'right'  => '',
					'bottom' => '',
					'left'   => '',
				],
				'selectors'   => [
					'{{WRAPPER}} .gyan-info-box-button' => 'margin-top: {{TOP}}{{UNIT}}; margin-left: {{LEFT}}{{UNIT}}; margin-right: {{RIGHT}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label'     => esc_html__( 'Normal', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'button_text_color_normal',
			[
				'label'     => esc_html__( 'Text Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} a.gyan-info-box-button' => 'color: {{VALUE}}',
					'{{WRAPPER}} a.gyan-info-box-button svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
		    Group_Control_Background::get_type(),
		    [
		        'name' => 'button_bg_color_normal',
		        'label' => esc_html__( 'Button Background', 'gyan-elements' ),
		        'types' => [ 'classic', 'gradient' ],
				'fields_options' => [
					'background' => [
						'default' =>'classic',
					],
					'color' => [
						'default' => '#d83030',
					],
				],
				'condition' => [
					'button_type' => array('button','icon_box')
				],
		        'selector' => '{{WRAPPER}} .gyan-info-box-button',
		    ]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'button_box_shadow',
				'condition' => [
					'button_type' => array('button','icon_box')
				],
				'selector'  => '{{WRAPPER}} .gyan-info-box-button',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label'     => esc_html__( 'Hover', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'button_text_color_hover',
			[
				'label'     => esc_html__( 'Text Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .gyan-info-box:hover a.gyan-info-box-button' => 'color: {{VALUE}}',
					'{{WRAPPER}} .gyan-info-box:hover a.gyan-info-box-button svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
		    Group_Control_Background::get_type(),
		    [
		        'name' => 'button_bg_color_hover',
		        'label' => esc_html__( 'Button Background', 'gyan-elements' ),
		        'types' => [ 'classic', 'gradient' ],
				'fields_options' => [
					'background' => [
						'default' =>'classic',
					],
					'color' => [
						'default' => '#252628',
					],
				],
				'condition' => [
					'button_type' => array('button','icon_box')
				],
		        'selector' => '{{WRAPPER}} .gyan-info-box:hover .gyan-info-box-button',
		    ]
		);

		$this->add_control(
			'button_border_color_hover',
			[
				'label'     => esc_html__( 'Border Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'condition' => [
					'button_type' => array('button','icon_box')
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-info-box:hover .gyan-info-box-button' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'button_box_shadow_hover',
				'condition' => [
					'button_type' => array('button','icon_box')
				],
				'selector'  => '{{WRAPPER}} .gyan-info-box:hover .gyan-info-box-button',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'icon_settings',
			[
				'label'     => esc_html__( 'Icon', 'gyan-elements' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'button_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'gyan-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min'  => 5,
						'max'  => 100,
						'step' => 1,
					],
				],
				'size_units' => [ 'px', 'em' ],
				'condition' => [
					'button_type' => 'icon_box',
				],
				'selectors'  => [
					'{{WRAPPER}} .gyan-infobox-button-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_iconbox_size',
			[
				'label'      => esc_html__( 'Icon Box Size', 'gyan-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min'  => 5,
						'max'  => 100,
						'step' => 1,
					],
				],
				'size_units' => [ 'px', 'em' ],
				'condition' => [
					'button_type' => 'icon_box',
				],
				'selectors'  => [
					'{{WRAPPER}} .gyan-info-box-button' => 'height: calc({{SIZE}}{{UNIT}} * 2); width: calc({{SIZE}}{{UNIT}} * 2);',
				],
			]
		);

		$this->add_responsive_control(
			'button_icon_margin',
			[
				'label'       => esc_html__( 'Icon Margin', 'gyan-elements' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => [ 'px', '%' ],
				'placeholder' => [
					'top'    => '',
					'right'  => '',
					'bottom' => '',
					'left'   => '',
				],
				'condition' => [
					'button_type!' => 'icon_box',
				],
				'selectors'   => [
					'{{WRAPPER}} .gyan-infobox-button-icon' => 'margin-top: {{TOP}}{{UNIT}}; margin-left: {{LEFT}}{{UNIT}}; margin-right: {{RIGHT}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$number_circle_position = $settings['number_circle_position'];

		$this->add_render_attribute( 'number-circle', [
			'class'    => 'gyan-infobox-number-circle gyan-position-' . esc_attr( $number_circle_position )
		]);

		$this->add_render_attribute(
		    'gyan_info_box',
		    [
		        'class' => ['gyan-info-box gyan-animation-box gyan-ease-transition']
		    ]
		);

		if ( !empty( $settings['link']['url'] ) ) {
			$this->add_render_attribute( 'infobox_link', 'href', esc_url($settings['link']['url']) );
			$this->add_render_attribute( 'infobox_link', 'class', 'gyan-infobox-link' );

			if ( $settings['link']['is_external'] ) {
				$this->add_render_attribute( 'infobox_link', 'target', '_blank' );
			}
			if ( $settings['link']['nofollow'] ) {
				$this->add_render_attribute( 'infobox_link', 'rel', 'nofollow' );
			}

			if ( 'infobox' == $settings['link_place'] ) {
				$this->add_render_attribute( 'infobox_link', 'class', 'gyan-infobox-over-link' );
			}

		}

		?>

		<div <?php echo $this->get_render_attribute_string('gyan_info_box'); ?>>

			<?php if ( !empty( $settings['link']['url'] ) && 'infobox' == $settings['link_place'] ) { ?>
				<a <?php echo $this->get_render_attribute_string( 'infobox_link' ); ?>></a>
			<?php } ?>

			<?php if ( 'none' != $settings['icon_type'] ) : ?>

				<div class="gyan-infobox-icon-holder gyan-ease-transition">

					<?php if ( !empty( $settings['count_number'] ) ) { ?>
						<span <?php echo $this->get_render_attribute_string( 'number-circle' ); ?>><?php echo $settings['count_number']; ?></span>
					<?php } ?>

					<?php if ( !empty( $settings['link']['url'] ) && ('icon_content' == $settings['link_place'] || 'button_content' == $settings['link_place']) ) { ?>
						<a <?php echo $this->get_render_attribute_string( 'infobox_link' ); ?>></a>
					<?php } ?>

					<?php if ( 'icon' == $settings['icon_type'] ) { ?>
						<span class="gyan-infobox-icon gyan-icon gyan-ease-transition"><?php Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
					<?php } ?>

					<?php if ( 'image' == $settings['icon_type'] ) { ?>
						<span class="gyan-infobox-image">
							<?php
                                if ( ! empty( $settings['image']['url'] ) ) {
                                    echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'image', 'image' );
                                }
                            ?>
						</span>
					<?php } ?>

					<?php if ( 'text' == $settings['icon_type'] ) { ?>
						<span class="gyan-infobox-text"><?php echo $settings['icon_text']; ?></span>
					<?php } ?>

				</div>

			<?php endif; ?>

			<div class="gyan-infobox-content-holder">

				<?php if ( '' != $settings['title_text'] ) : ?>

					<<?php echo $settings['title_html_tag']; ?> class="gyan-infobox-title gyan-ease-transition">
						<?php if ( !empty( $settings['link']['url'] ) && ('icon_content' == $settings['link_place'] || 'button_content' == $settings['link_place']) ) { ?>
							<a <?php echo $this->get_render_attribute_string( 'infobox_link' ); ?>>
						<?php } ?>
						<?php echo $settings['title_text']; ?>
						<?php if ( !empty( $settings['link']['url'] ) && ('icon_content' == $settings['link_place'] || 'button_content' == $settings['link_place']) ) { ?>
							</a>
						<?php } ?>
					</<?php echo $settings['title_html_tag']; ?>>

				<?php endif; ?>

				<?php if ( 'yes' == $settings['line_separator'] ) : ?>
					<div class="gyan-infobox-line-separator gyan-ease-transition"></div>
				<?php endif; ?>

				<?php if ( '' != $settings['content_text'] ) : ?>

					<<?php echo $settings['content_html_tag']; ?> class="gyan-infobox-content gyan-ease-transition">
						<?php echo $settings['content_text']; ?>
					</<?php echo $settings['content_html_tag']; ?>>

				<?php endif; ?>

				<?php if ( 'button' == $settings['link_place'] || 'button_content' == $settings['link_place'] ) {

					if ( !empty( $settings['link']['url'] ) ) {
						$this->add_render_attribute( 'infobox_link', 'class', [
								'gyan-info-box-button',
								'gyan-ease-transition'
							]
						);
					}
					?>
						<a <?php echo $this->get_render_attribute_string( 'infobox_link' ); ?>><?php
						if ( ! empty( $settings['button_icon'] ) && 'before' == $settings['button_icon_position'] ) {
							?><span class="gyan-infobox-button-icon gyan-icon"><?php Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] ); ?></span><?php
							} ?><?php
							if ( ! empty( $settings['button_text'] ) ) {
								?><span><?php echo esc_attr( $settings['button_text'] ); ?></span><?php
							} ?><?php
							if ( ! empty( $settings['button_icon'] ) && 'after' == $settings['button_icon_position'] ) {
							?><span class="gyan-infobox-button-icon gyan-icon"><?php Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] ); ?></span><?php
						}
						?></a>

				<?php } ?>

				<div class="clear"></div>
			</div>
		</div>
	<?php
	}
}