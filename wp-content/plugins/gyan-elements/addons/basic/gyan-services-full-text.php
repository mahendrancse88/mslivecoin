<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Gyan_Services_Full_Text extends Widget_Base {

	public function get_name()       { return 'gyan_services_full_text'; }
	public function get_title()      { return esc_html__( 'Services Full Text', 'gyan-elements' ); }
	public function get_icon()       { return 'gyan-el-icon eicon-info-box'; }
	public function get_categories() { return ['gyan-basic-addons']; }
	public function get_keywords()   { return ['services', 'content box','info','service','services full text' ]; }
	public function get_style_depends()  { return ['gyan-icon','gyan-flex','gyan-grid','gyan-services-full-text']; }
	public function get_script_depends() { return [ 'gyan-widgets','imagesLoaded', 'isotope','gyan-element-resize' ]; }

	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Service Items', 'gyan-elements' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'service_img',
			[
				'label'     => esc_html__( 'Image', 'gyan-elements' ),
				'type'      => Controls_Manager::MEDIA
			]
		);



		$repeater->add_control(
			'service_icon',
            [
				'label'       => esc_html__( 'Icon Type', 'gyan-elements' ),
                'type'        => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options'     => [
                    'icon' => [
                        'title' => esc_html__( 'Icon', 'gyan-elements' ),
                        'icon'  => 'fa fa-star',
                    ],
                    'image' => [
                        'title' => esc_html__( 'Image', 'gyan-elements' ),
                        'icon'  => 'fa fa-picture-o',
                    ],
                ],
                'default'       => 'icon',
			]
		);

		$repeater->add_control(
			'service_icon_svg',
			[
				'label' => esc_html__( 'Icon', 'elementor' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-bullhorn',
					'library' => 'fa-solid',
				],
				'condition'     => [
                    'service_icon' => 'icon',
                ],
			]
		);

		$repeater->add_control(
			'service_icon_img',
            [
				'label'       => esc_html__( 'Image', 'gyan-elements' ),
				'label_block' => true,
				'type'        => Controls_Manager::MEDIA,
                'dynamic'     => [
                    'active'  => true,
                ],
		        'default'     => [
                    'url' => Utils::get_placeholder_image_src(),
                 ],
		        'condition'   => [
                    'service_icon' => 'image',
                ],
			]
		);

		$repeater->add_control(
			'service_title',
			[
				'label'   => esc_html__( 'Title', 'gyan-elements' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Service Title', 'gyan-elements' ),
			]
		);

		$repeater->add_control(
			'service_desc',
			[
				'label'   => esc_html__( 'Description', 'gyan-elements' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Service description text here ipm dolr sit amet conse ctetur adipiscing elit sed do eiusmod tempor ares.', 'gyan-elements' ),
			]
		);

		$repeater->add_control(
			'service_link',
			[
				'label'       => esc_html__( 'Link', 'gyan-elements' ),
				'type'        => Controls_Manager::URL,
				'default'  => [
					'url'         => '#',
					'is_external' => '',
				],
				'placeholder' => 'https://www.your-link.com'
			]
		);

		$this->add_control(
			'services_items',
			[
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ service_title }}}',
			]
		);

		$this->end_controls_section();


		// General Settings --------------------
		// -------------------------------------

		$this->start_controls_section(
			'section_general_settings',
			[
				'label'     => esc_html__( 'General Settings', 'gyan-elements' ),
			]
		);

		$this->add_control(
		    'layout',
		    [
		        'label' => esc_html__( 'Layout', 'gyan-elements' ),
		        'type' => Controls_Manager::SELECT,
		        'options' => [
		            'grid' => esc_html__( 'Grid', 'gyan-elements' ),
		            'masonry' => esc_html__( 'Masonry', 'gyan-elements' )
		        ],
		        'default' => 'grid',
		    ]
		);

		$this->add_responsive_control(
		    'columns',
		    [
		        'label'                 => esc_html__( 'Columns', 'gyan-elements' ),
		        'type'                  => Controls_Manager::SELECT,
		        'default'               => '3',
		        'tablet_default'        => '2',
		        'mobile_default'        => '1',
		        'options'               => [
		            '1' => '1',
		            '2' => '2',
		            '3' => '3',
		            '4' => '4'
		        ],
		        'prefix_class'          => 'elementor-grid%s-',
		        'frontend_available'    => true
		    ]
		);

		$this->add_responsive_control(
		    'column_gap',
		    [
		        'label'     => esc_html__( 'Columns Gap', 'gyan-elements' ),
		        'type'      => Controls_Manager::SLIDER,
		        'default'   => [
		            'size' => 30,
		        ],
		        'range'     => [
		            'px' => [
		                'min' => 0,
		                'max' => 100,
		            ],
		        ],
		        'selectors' => [
		            '{{WRAPPER}} .gyan-grid-item-wrap' => 'padding-right: calc( {{SIZE}}{{UNIT}}/2 ); padding-left: calc( {{SIZE}}{{UNIT}}/2 );',
		            '{{WRAPPER}} .gyan-elementor-grid' => 'margin-left: calc( -{{SIZE}}{{UNIT}}/2 ); margin-right: calc( -{{SIZE}}{{UNIT}}/2 );',
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'row_gap',
		    [
		        'label'     => esc_html__( 'Rows Gap', 'gyan-elements' ),
		        'type'      => Controls_Manager::SLIDER,
		        'default'   => [
		            'size' => 30,
		        ],
		        'range'     => [
		            'px' => [
		                'min' => 0,
		                'max' => 100,
		            ],
		        ],
		        'selectors' => [
		            '{{WRAPPER}} .gyan-elementor-grid .gyan-grid-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
		        ]
		    ]
		);

		$this->end_controls_section();


		// Image Section --------------------
		// -------------------------------------


		$this->start_controls_section(
			'section_image_style',
			[
				'label' => esc_html__( 'Image', 'gyan-elements' )
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image_size',
				'default'   => 'full',
				'separator' => 'none'
			]
		);

		$this->add_control(
			'service_img_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-services-full-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'image_link',
			[
				'label'                 => esc_html__( 'Link on Image', 'gyan-elements' ),
				'type'                  => Controls_Manager::SWITCHER,
				'default'               => 'yes',
                'label_on'              => esc_html__( 'Yes', 'gyan-elements' ),
                'label_off'             => esc_html__( 'No', 'gyan-elements' ),
                'return_value'          => 'yes',
			]
		);

		$this->end_controls_section();


		// Title Section --------------------
		// -------------------------------------


		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title / Description', 'gyan-elements' )
			]
		);

		$this->add_control(
			'title_heading',
			[
				'label'     => esc_html__( 'Title', 'gyan-elements' ),
				'type'      => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'title_html_tag',
			[
				'label'   => esc_html__( 'Title HTML Tag', 'gyan-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h6',
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

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'title_typography',
				'label'     => esc_html__( 'Title Typography', 'gyan-elements' ),
				'fields_options' => [
					'typography' => [
						'default' =>'custom',
					],
					'font_size'   => [
						'default' => [
							'size' => '22',
						],
					]
				],
				'selector'  => '{{WRAPPER}} .gyan-services-full-title',
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label' => esc_html__( 'Margin', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '13',
					'left' => '0',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-services-full-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#032e42',
				'selectors' => [
					'{{WRAPPER}} .gyan-services-full-title,
					{{WRAPPER}} .gyan-services-full-title a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'desc_heading',
			[
				'label'     => esc_html__( 'Description', 'gyan-elements' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',

			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => esc_html__( 'Description Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#676767',
				'selectors' => [
					'{{WRAPPER}} .gyan-services-full-desc' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'desc_typography',
				'label'     => esc_html__( 'Description Typography', 'gyan-elements' ),
				'fields_options' => [
					'typography' => [
						'default' =>'custom',
					],
					'line_height'   => [
						'default' => [
							'size' => '27',
						],
					],
				],
				'selector'  => '{{WRAPPER}} .gyan-services-full-desc',
			]
		);

		$this->add_responsive_control(
			'title_desc_padding',
			[
				'label' => esc_html__( 'Content Padding', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '38',
					'right' => '22',
					'bottom' => '31',
					'left' => '22',
					'isLinked' => true,
				],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .gyan-services-full-title-desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Icon ---------------------------------

		$this->start_controls_section(
			'section_icon',
			[
				'label'     => esc_html__( 'Icon', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'show_service_icon',
			[
				'label'                 => esc_html__( 'Show Icon', 'gyan-elements' ),
				'type'                  => Controls_Manager::SWITCHER,
				'default'               => 'yes',
                'label_on'              => esc_html__( 'Yes', 'gyan-elements' ),
                'label_off'             => esc_html__( 'No', 'gyan-elements' ),
                'return_value'          => 'yes',
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'                  => 'icon_image_size',
                'label'                 => esc_html__( 'Icon Image Size', 'gyan-elements' ),
                'default'               => 'full',
			]
		);

		$this->add_responsive_control(
			'title_icon_size',
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
					'show_service_icon' => 'yes',
				],
				'default'    => [
					'unit' => 'px',
					'size' => 26,
				],
				'selectors'  => [
					'{{WRAPPER}} .gyan-services-full-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .gyan-services-full-icon img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_iconbox_size',
			[
				'label'      => esc_html__( 'Icon Box Size', 'gyan-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min'  => 5,
						'max'  => 200,
						'step' => 1,
					],
				],
				'size_units' => [ 'px', 'em' ],
				'condition' => [
					'show_service_icon' => 'yes',
				],
				'default'    => [
					'unit' => 'px',
					'size' => 70,
				],
				'selectors'  => [
					'{{WRAPPER}} .gyan-services-full-icon-wrap' => 'height:{{SIZE}}{{UNIT}}; width:{{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'title_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f3a712',
				'condition' => [
					'show_service_icon' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-services-full-icon' => 'color: {{VALUE}}',
					'{{WRAPPER}} .gyan-services-full-icon svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
		    Group_Control_Background::get_type(),
		    [
		        'name' => 'title_icon_box_bg',
		        'label' => esc_html__( 'Icon Box Background', 'gyan-elements' ),
		        'types' => [ 'classic', 'gradient' ],
		        'fields_options' => [
                    'background' => [
                        'default' =>'classic',
                    ],
                    'color' => [
                        'default' => '#ffffff',
                    ],
                ],
				'condition' => [
					'show_service_icon' => 'yes',
				],
		        'selector' => '{{WRAPPER}} .gyan-services-full-icon-wrap',
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'icon_box_shadow',
		        'label' => esc_html__( 'Icon Box - Box Shadow', 'gyan-elements' ),
		        'condition' => [
					'show_service_icon' => 'yes',
				],
		        'fields_options' => [
					'box_shadow_type' => [
						'default' =>'yes'
					],
					'box_shadow' => [
						'default' => [
							'horizontal' => '0',
							'vertical' => '0',
							'blur' => '40',
							'color' => 'rgba(0,0,0,0.1)'
						]
					]
				],
		        'selector' => '{{WRAPPER}} .gyan-services-full-icon-wrap',
		    ]
		);

		$this->end_controls_section();

		// Button ---------------------------------

		$this->start_controls_section(
			'section_button',
			[
				'label'     => esc_html__( 'Button', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'button_on',
			[
				'label'                 => esc_html__( 'Button', 'gyan-elements' ),
				'type'                  => Controls_Manager::SWITCHER,
				'default'               => 'yes',
                'label_on'              => esc_html__( 'Yes', 'gyan-elements' ),
                'label_off'             => esc_html__( 'No', 'gyan-elements' ),
                'return_value'          => 'yes',
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'     => esc_html__( 'Button Text', 'gyan-elements' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => [
					'button_on' => 'yes',
				],
				'default'   => esc_html__( 'Learn More', 'gyan-elements' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'button_typography',
				'label'     => esc_html__( 'Typography', 'gyan-elements' ),
				'condition' => [
					'button_on' => 'yes',
				],
				'fields_options' => [
					'typography' => [
						'default' =>'custom',
					],
					'font_weight' => [
						'default' => '700',
					],
					'font_size'   => [
						'default' => [
							'size' => '15',
						],
					],
				],
				'selector'  => '{{WRAPPER}} .gyan-services-full-button',
			]
		);

		$this->add_control(
			'service_button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-services-full-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'buttons_tabs_heading' );

		$this->start_controls_tab(
			'button_tab_normal',
			[
				'label' => esc_html__( 'Normal', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'button_text_col',
			[
				'label'     => esc_html__( 'Text Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#032e42',
				'condition' => [
					'button_on' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-services-full-button,
					{{WRAPPER}} .gyan-services-full-button a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
		    Group_Control_Background::get_type(),
		    [
		        'name' => 'button_bg',
		        'label' => esc_html__( 'Button Background', 'gyan-elements' ),
		        'types' => [ 'classic', 'gradient' ],
		        'fields_options' => [
                    'background' => [
                        'default' =>'classic',
                    ],
                    'color' => [
                        'default' => '#f5f5f5',
                    ],
                ],
				'condition' => [
					'button_on' => 'yes',
				],
		        'selector' => '{{WRAPPER}} .gyan-services-full-button',
		    ]
		);

		$this->add_control(
			'button_icon_col',
			[
				'label'     => esc_html__( 'Button Icon Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f5f5f5',
				'condition' => [
					'button_on' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-services-full-button-arrow:after' => 'background: {{VALUE}}',
					'{{WRAPPER}} .gyan-services-full-button-arrow:before' => 'border-color: transparent transparent transparent {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'arrow_bg',
			[
				'label'     => esc_html__( 'Button Icon Background', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#d83030',
				'condition' => [
					'button_on' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-services-full-button:before' => 'background: {{VALUE}}'
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'button_tab_hover',
			[
				'label' => esc_html__( 'Hover', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'button_text_col_hover',
			[
				'label'     => esc_html__( 'Text Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'condition' => [
					'button_on' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-service-full-item:hover .gyan-services-full-button,
					{{WRAPPER}} .gyan-service-full-item:hover .gyan-services-full-button a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
		    Group_Control_Background::get_type(),
		    [
		        'name' => 'button_bg_hover',
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
					'button_on' => 'yes',
				],
		        'selector' => '{{WRAPPER}} .gyan-service-full-item:hover .gyan-services-full-button',
		    ]
		);

		$this->add_control(
			'button_icon_col_hover',
			[
				'label'     => esc_html__( 'Button Icon Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'condition' => [
					'button_on' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-service-full-item:hover .gyan-services-full-button-arrow:after' => 'background: {{VALUE}}',
					'{{WRAPPER}} .gyan-service-full-item:hover .gyan-services-full-button-arrow:before' => 'border-color: transparent transparent transparent {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'arrow_bg_hover',
			[
				'label'     => esc_html__( 'Button Icon Background', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#252628',
				'condition' => [
					'button_on' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-service-full-item:hover .gyan-services-full-button:before' => 'background: {{VALUE}}'
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();


		// Service Box --------------------
		// -------------------------------------


		$this->start_controls_section(
			'section_general_all',
			[
				'label' => esc_html__( 'Service Box', 'gyan-elements' ),
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'service_box_border',
				'label'       => esc_html__( 'Border', 'gyan-elements' ),
				'selector'    => '{{WRAPPER}} .gyan-services-full',
			]
		);

		$this->add_control(
			'service_box_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-services-full' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'service_box_padding',
			[
				'label' => esc_html__( 'Padding', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '20',
					'right' => '20',
					'bottom' => '20',
					'left' => '20',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-services-full' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
		    Group_Control_Background::get_type(),
		    [
		        'name' => 'service_box_bg',
		        'label' => esc_html__( 'Service Box Background', 'gyan-elements' ),
		        'types' => [ 'classic', 'gradient' ],
		        'fields_options' => [
                    'background' => [
                        'default' =>'classic',
                    ],
                    'color' => [
                        'default' => '#ffffff',
                    ],
                ],
				'condition' => [
					'show_service_icon' => 'yes',
				],
		        'selector' => '{{WRAPPER}} .gyan-services-full',
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'service_box_shadow',
		        'label' => esc_html__( 'Service Box - Box Shadow', 'gyan-elements' ),
                'fields_options' => [
        			'box_shadow_type' => [
        				'default' =>'yes'
        			],
        			'box_shadow' => [
        				'default' => [
        					'horizontal' => '0',
        					'vertical' => '0',
        					'blur' => '40',
        					'color' => 'rgba(0,0,0,0.1)'
        				]
        			]
        		],
		        'selector' => '{{WRAPPER}} .gyan-services-full',
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'service_box_shadow_hover',
		        'label' => esc_html__( 'Service Box - Hover Box Shadow', 'gyan-elements' ),
				'separator' => 'after',
				'fields_options' => [
        			'box_shadow_type' => [
        				'default' =>'yes'
        			],
        			'box_shadow' => [
        				'default' => [
        					'horizontal' => '0',
        					'vertical' => '0',
        					'blur' => '40',
        					'color' => 'rgba(0,0,0,0.2)'
        				]
        			]
        		],
		        'selector' => '{{WRAPPER}} .gyan-services-full:hover',
		    ]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$i = 1;
		$data_rtl = is_rtl() ? 'true' : 'false';
		?>

		<div class="gyan-services-full-container <?php echo esc_attr( 'gyan-services-full-container-'.$this->get_id() ); ?>" data-layout="<?php echo esc_attr( $settings['layout'] ); ?>" data-rtl="<?php echo $data_rtl; ?>">

			<div class="gyan-services-full-items gyan-elementor-grid">

				<?php foreach ( $settings['services_items'] as $index => $item ) :

					$anchor_tag = 'span';
					$service_link_key = 'service_link_' . $i;
					$service_button_key = 'service_button_' . $i;

					if ( !empty( $item['service_link']['url'] ) ) {

						$this->add_render_attribute( $service_link_key, 'href', esc_url($item['service_link']['url']) );
						$this->add_render_attribute( $service_link_key, 'class', 'gyan-service-full-link' );

						if ( $item['service_link']['is_external'] ) {
							$this->add_render_attribute( $service_link_key, 'target', '_blank' );
						}
						if ( $item['service_link']['nofollow'] ) {
							$this->add_render_attribute( $service_link_key, 'rel', 'nofollow' );
						}

						$anchor_tag = 'a';

					}

              	if (  $settings['image_size_size'] == 'full' ) {
                  $imageTagHtml = wp_get_attachment_image( $item['service_img']['id'], 'full');
              	} else {
                  $imgUrl = Group_Control_Image_Size::get_attachment_image_src( $item['service_img']['id'], 'image_size', $settings );
                  if ( ! $imgUrl ) {
                      $imgUrl = $item['person_image']['url'];
                  }
                  $imageTagHtml = '<img src="'.esc_url($imgUrl).'" alt="" />';
              	}

              	if ( 'yes' == $settings['image_link']  ) {
					$imageTagHtml = '<a ' . $this->get_render_attribute_string( $service_link_key ) . '>' . $imageTagHtml . '</a>';
				} else {
					$imageTagHtml = $imageTagHtml;
				}

					$image_html = '<div class="gyan-services-full-img">' . $imageTagHtml .  '</div>';

					$service_icon_html = '';

					if ( 'yes' == $settings['show_service_icon'] ) :

                        if ( $item['service_icon'] == 'icon' ) {

                        	ob_start();
                        	Icons_Manager::render_icon( $item['service_icon_svg'], [ 'aria-hidden' => 'true' ] );
                        	$service_icon = ob_get_clean();
                        	$service_icon_html = '<div class="gyan-services-full-icon-wrap"><div class="gyan-services-full-icon gyan-icon">' . $service_icon . '</div></div>';

                        } else {

							if (  $settings['icon_image_size_size'] == 'full' ) {
						    	$service_icon_image_html = wp_get_attachment_image( $item['service_icon_img']['id'], 'full');
							} else {
						    	$imgUrl = Group_Control_Image_Size::get_attachment_image_src( $item['service_icon_img']['id'], 'icon_image_size', $settings );
						    if ( ! $imgUrl ) {
						   		$imgUrl = $item['service_icon_img']['url'];
						    }
						    	$service_icon_image_html = '<img src="'.esc_url($imgUrl).'" alt="" />';
							}

                            $service_icon_html = '<div class="gyan-services-full-icon-wrap"><div class="gyan-services-full-icon gyan-icon">' . $service_icon_image_html . '</div></div>';

                        }

					endif;

					$title_section_title_html = '<' . $settings['title_html_tag'] . ' class="gyan-services-full-title"><' . $anchor_tag . ' ' . $this->get_render_attribute_string( $service_link_key ) . '>' . $item['service_title'] . '</' . $anchor_tag . '></' . $settings['title_html_tag'] . '>';

					$description_html = ( ! empty( $item['service_desc'] )) ? '<div class="gyan-services-full-desc">' . $item['service_desc'] . '</div>' : '';

					$service_button_html = '';

					if ( 'yes' == $settings['button_on'] && !empty( $item['service_link']['url'] ) ) {

						$this->add_render_attribute( $service_link_key, 'class', [
								'gyan-services-full-button',
								'gyan-ease-transition',
								'gyan-flex'
							]
						);

						$service_button_html = '<a ' . $this->get_render_attribute_string( $service_link_key ) . '><span class="gyan-services-full-button-text">' . $settings['button_text'] . '</span><span class="gyan-services-full-button-arrow"></span></a>';
					}
					?>

					<div class="gyan-service-full-item gyan-grid-item-wrap">
						<div class="gyan-services-full gyan-grid-item gyan-ease-transition">
							<?php
							echo $image_html;
							echo '<div class="gyan-services-full-content">';
							echo $service_icon_html;
							echo '<div class="gyan-services-full-title-desc">'.$title_section_title_html.$description_html.'</div>';
							echo $service_button_html;
							echo '</div>';
							?>
						</div>
						<div class="clear"></div>
					</div>

				 <?php $i++;
				endforeach; ?>

			 </div> <!-- gyan-services-full-items -->
			 <div class="clear"></div>

		</div>

	<?php
		if ( Plugin::instance()->editor->is_edit_mode() ) {
            $this->render_editor_script();
        }
	}

	protected function render_editor_script() {
	        ?>
	        <script type="text/javascript">
	        jQuery( document ).ready(function( $ ) {
	            var gyanPGClass = '.gyan-services-full-container-'+'<?php echo $this->get_id(); ?>',
	                $this = $(gyanPGClass),
	                $isoGrid = $this.children('.gyan-services-full-items'),
	                is_rtl = $this.data('rtl') ? false : true,
	                layout = $this.data('layout');

	            $this.imagesLoaded( function() {

	                if ( 'masonry' == layout ) {
	                    var $grid = $isoGrid.isotope({
	                        itemSelector: '.gyan-service-full-item',
	                        percentPosition: true,
	                        originLeft: is_rtl,
	                        masonry: {
	                            columnWidth: '.gyan-service-full-item',
	                        }
	                    });
	                } else{
	                    var $grid = $isoGrid.isotope({
	                        itemSelector: '.gyan-service-full-item',
	                        originLeft: is_rtl,
	                        layoutMode: 'fitRows'
	                    });
	                }

	                $this.find('.gyan-service-full-item').resize( function() {
	                    $grid.isotope( 'layout' );
	                });

	            });

	        });
	        </script>
	        <?php
	}

	protected function _content_template() {}

}