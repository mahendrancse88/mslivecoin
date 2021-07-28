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

class Gyan_Services extends Widget_Base {

	public function get_name()       { return 'gyan_services'; }
	public function get_title()      { return esc_html__( 'Services', 'gyan-elements' ); }
	public function get_icon()       { return 'gyan-el-icon eicon-info-box'; }
	public function get_categories() { return ['gyan-basic-addons']; }
	public function get_keywords()   { return ['services', 'content box','info','service' ]; }
	public function get_style_depends()  { return ['gyan-icon','gyan-flex','gyan-grid','gyan-services']; }
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
				'default' => esc_html__( 'service description text here', 'gyan-elements' ),
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

		$repeater->add_control(
			'service_img',
			[
				'label'     => esc_html__( 'Service Image', 'gyan-elements' ),
				'type'      => Controls_Manager::MEDIA,
				'separator' => 'before'
			]
		);

		$repeater->add_control(
			'service_icon_type',
            [
				'label'       => esc_html__( 'Title Section Icon', 'gyan-elements' ),
                'type'        => Controls_Manager::CHOOSE,
                'label_block' => false,
                'separator' => 'before',
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
			'service_icon',
			[
				'label' => esc_html__( 'Icon', 'elementor' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'fa-solid',
				],
				'condition'     => [
                    'service_icon_type' => 'icon',
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
                    'service_icon_type' => 'image',
                ],
			]
		);

		$repeater->add_control(
			'service_overlay_icon_type',
            [
				'label'       => esc_html__( 'Overlay Section Icon', 'gyan-elements' ),
                'type'        => Controls_Manager::CHOOSE,
                'label_block' => false,
                'separator' => 'before',
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
			'service_overlay_icon',
			[
				'label' => esc_html__( 'Icon', 'elementor' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'fa-solid',
				],
				'condition'     => [
                    'service_overlay_icon_type' => 'icon',
                ],
			]
		);

		$repeater->add_control(
			'service_overlay_icon_img',
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
                    'service_overlay_icon_type' => 'image',
                ],
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
			'service_style',
			[
				'label'   => esc_html__( 'Service Style', 'gyan-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => esc_html__( 'Style 1', 'gyan-elements' ),
					'2' => esc_html__( 'Style 2', 'gyan-elements' ),
					'3' => esc_html__( 'Style 3', 'gyan-elements' ),
					'4' => esc_html__( 'Style 4 - Flip', 'gyan-elements' )
				]
			]
		);

		$this->add_control(
			'title_section_position',
			[
				'label'   => esc_html__( 'Title Section Position', 'gyan-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'b',
				'options' => [
					't' => esc_html__( 'Top', 'gyan-elements' ),
					'm' => esc_html__( 'Middle', 'gyan-elements' ),
					'b' => esc_html__( 'Bottom', 'gyan-elements' )
				],
				'condition' => [
					'service_style' => array('1','4')
				],
				'prefix_class' => 'gyan-services-title-sec-',
			]
		);

		$this->add_control(
			'service_style_animation_1',
			[
				'label'   => esc_html__( 'Overlay Animation', 'gyan-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'sb',
				'condition' => [
					'service_style' => array('1','2')
				],
				'options' => [
					'fd' => esc_html__( 'Fade', 'gyan-elements' ),
					'sb' => esc_html__( 'Sweep to Bottom', 'gyan-elements' ),
					'st' => esc_html__( 'Sweep to Top', 'gyan-elements' ),
					'sr' => esc_html__( 'Sweep to Right', 'gyan-elements' ),
					'sl' => esc_html__( 'Sweep to Left', 'gyan-elements' ),
					'slr' => esc_html__( 'Sweep Left to Right', 'gyan-elements' ),
				],
				'prefix_class' => 'gyan-overlay-animation-',
			]
		);

		$this->add_responsive_control(
			'overlay_title_height',
			[
				'label' => esc_html__( 'Set Visible Content Height', 'gyan-elements' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'max' => 300,
					],
					'em' => [
						'max' => 50,
					],
				],
				'default' => [
					'size' => '70',
				],
				'condition' => [
					'service_style' => array('3')
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-services-st-3 .gyan-services-overlay' => 'bottom: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .gyan-services-st-3 .gyan-services:hover .gyan-services-overlay' => 'bottom:0;',
				],
			]
		);

		$this->add_responsive_control(
			'service_box_height',
			[
				'label' => esc_html__( 'Service Box Height', 'gyan-elements' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'max' => 1000,
					]
				],
				'default' => [
					'size' => '300',
				],
				'condition' => [
					'service_style' => array('4')
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-services' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'services_flip_direction',
			[
				'label'   => esc_html__( 'Flip Direction', 'gyan-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'hr',
				'condition' => [
					'service_style' => array('4')
				],
				'options' => [
					'hr' => esc_html__( 'Horizontal', 'gyan-elements' ),
					'vr' => esc_html__( 'Vertical', 'gyan-elements' )
				],
				'prefix_class'          => 'gyan-services-flip-',
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
		        'separator' => 'before',
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
		            'size' => 20,
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
		            'size' => 20,
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


		// Title Section --------------------
		// -------------------------------------


		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title Section', 'gyan-elements' ),
				'condition' => [
					'service_style!' => array('3')
				],
			]
		);

		$this->add_control(
			'title_align',
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
					]
				],
				'default'   => 'left',
				'prefix_class'  => 'gyan-services-title-align-',
			]
		);

		$this->add_responsive_control(
			'title_height',
			[
				'label' => esc_html__( 'Title Section Height', 'gyan-elements' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'max' => 1000,
					]
				],
				'default' => [
					'size' => '55',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-services-title-section' => 'height: {{SIZE}}{{UNIT}};'
				],
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
				'name'      => 'title_section_title_typography',
				'label'     => esc_html__( 'Title Typography', 'gyan-elements' ),
				'selector'  => '{{WRAPPER}} .gyan-services-title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .gyan-services-title,
					{{WRAPPER}} .gyan-services-title a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
		    Group_Control_Background::get_type(),
		    [
		        'name' => 'title_bg',
		        'label' => esc_html__( 'Title Section Background', 'gyan-elements' ),
		        'types' => [ 'classic', 'gradient' ],
				'fields_options' => [
					'background' => [
						'default' =>'classic',
					],
					'color' => [
						'default' => '#d83030',
					],
				],
		        'selector' => '{{WRAPPER}} .gyan-services-title-section',
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'title_section_shadow',
		        'label' => esc_html__( 'Title Section Box Shadow', 'gyan-elements' ),
		        'selector' => '{{WRAPPER}} .gyan-services-title-section',
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'title_section_shadow_hover',
		        'label' => esc_html__( 'Title Section Hover Box Shadow', 'gyan-elements' ),
		        'selector' => '{{WRAPPER}} .gyan-services:hover .gyan-services-title-section',
		    ]
		);

		$this->add_responsive_control(
			'title_section_padding',
			[
				'label'      => esc_html__( 'Title Section Padding', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
                    'top' => '10',
                    'right' => '10',
                    'bottom' => '10',
                    'left' => '20',
                    'isLinked' => true,
            	],
				'selectors'  => [
					'{{WRAPPER}} .gyan-services-title-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_section_margin',
			[
				'label'       => esc_html__( 'Title Section Margin', 'gyan-elements' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => [ 'px', '%' ],
				'condition' => [
					'service_style' => array('1','4')
				],
				'default' => [
                    'top' => '10',
                    'right' => '10',
                    'bottom' => '10',
                    'left' => '10',
                    'isLinked' => true,
            	],
				'selectors'   => [
					'{{WRAPPER}} .gyan-services-title-section' => 'margin-top: {{TOP}}{{UNIT}}; margin-left: {{LEFT}}{{UNIT}}; margin-right: {{RIGHT}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'title_section_icon_settings',
			[
				'label'     => esc_html__( 'Icon', 'gyan-elements' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_title_icon',
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

		if ( is_rtl() ) {

			$this->add_responsive_control(
				'title_icon_spacing',
				[
					'label'      => esc_html__( 'Icon Spacing', 'gyan-elements' ),
					'type'       => Controls_Manager::SLIDER,
					'default'    => [
						'size' => 10,
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
						'show_title_icon' => 'yes',
					],
					'selectors'  => [
						'{{WRAPPER}} .gyan-services-title-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
					],
				]
			);

		} else {

			$this->add_responsive_control(
				'title_icon_spacing',
				[
					'label'      => esc_html__( 'Icon Spacing', 'gyan-elements' ),
					'type'       => Controls_Manager::SLIDER,
					'default'    => [
						'size' => 10,
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
						'show_title_icon' => 'yes',
					],
					'selectors'  => [
						'{{WRAPPER}} .gyan-services-title-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
					],
				]
			);

		}

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
					'show_title_icon' => 'yes',
				],
				'selectors'  => [
					'{{WRAPPER}} .gyan-services-title-icon' => 'font-size: {{SIZE}}{{UNIT}};',
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
					'show_title_icon' => 'yes',
				],
				'selectors'  => [
					'{{WRAPPER}} .gyan-services-title-icon' => 'height:{{SIZE}}{{UNIT}}; width:{{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'title_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'condition' => [
					'show_title_icon' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-services-title-icon' => 'color: {{VALUE}}',
					'{{WRAPPER}} .gyan-services-title-icon svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
		    Group_Control_Background::get_type(),
		    [
		        'name' => 'title_icon_box_bg',
		        'label' => esc_html__( 'Icon Box Background', 'gyan-elements' ),
		        'types' => [ 'classic', 'gradient' ],
				'condition' => [
					'show_title_icon' => 'yes',
				],
		        'selector' => '{{WRAPPER}} .gyan-services-title-icon',
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
				'default'   => esc_html__( 'Read More', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'button_icon',
			[
				'label' => esc_html__( 'Button Icon', 'elementor' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-angle-right',
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
			]
		);

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
				'selector'    => '{{WRAPPER}} .gyan-services-container:not(.gyan-services-st-4) .gyan-services,
					{{WRAPPER}} .gyan-services .gyan-services-front,
					{{WRAPPER}} .gyan-services .gyan-services-back',
			]
		);

		$this->add_control(
			'service_box_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'condition' => [
					'button_type' => array('button','icon_box')
				],
				'selectors'  => [
					'{{WRAPPER}} .gyan-services-container:not(.gyan-services-st-4) .gyan-services,
					{{WRAPPER}} .gyan-services .gyan-services-front,
					{{WRAPPER}} .gyan-services .gyan-services-back' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'service_box_shadow',
		        'label' => esc_html__( 'Service Box - Box Shadow', 'gyan-elements' ),
		        'selector' => '{{WRAPPER}} .gyan-services-container:not(.gyan-services-st-4) .gyan-services,
					{{WRAPPER}} .gyan-services .gyan-services-front,
					{{WRAPPER}} .gyan-services .gyan-services-back',
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'service_box_shadow_hover',
		        'label' => esc_html__( 'Service Box - Hover Box Shadow', 'gyan-elements' ),
				'separator' => 'after',
		        'selector' => '{{WRAPPER}} .gyan-services:hover
					{{WRAPPER}} .gyan-services .gyan-services-front,
					{{WRAPPER}} .gyan-services .gyan-services-back',
		    ]
		);

		$this->add_control(
			'image_settings_heading',
			[
				'label'     => esc_html__( 'Image', 'gyan-elements' ),
				'type'      => Controls_Manager::HEADING,
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

		$this->add_group_control(
		    Group_Control_Background::get_type(),
		    [
		        'name' => 'img_hover_bg',
		        'label' => esc_html__( 'Hover Image Background', 'gyan-elements' ),
		        'types' => [ 'classic', 'gradient' ],
		        'selector' => '{{WRAPPER}} .gyan-services:hover .gyan-services-img-overlay-bg',
		    ]
		);

		$this->end_controls_section();


		// Overlay  --------------------
		// -------------------------------------

		$this->start_controls_section(
			'overlay_style',
			[
				'label'     => esc_html__( 'Overlay', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'show_overlay',
			[
				'label'                 => esc_html__( 'Overlay', 'gyan-elements' ),
				'type'                  => Controls_Manager::SWITCHER,
				'default'               => 'yes',
                'label_on'              => esc_html__( 'Yes', 'gyan-elements' ),
                'label_off'             => esc_html__( 'No', 'gyan-elements' ),
                'return_value'          => 'yes',
			]
		);

		$this->add_control(
			'overlay_align',
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
					]
				],
				'default'   => 'center',
				'prefix_class'  => 'gyan-services-overlay-align-',
			]
		);

		$this->add_responsive_control(
			'overlay_padding',
			[
				'label'      => esc_html__( 'Overlay Box Padding', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
                    'top' => '20',
                    'right' => '20',
                    'bottom' => '20',
                    'left' => '20',
                    'isLinked' => true,
            	],
				'selectors'  => [
					'{{WRAPPER}} .gyan-services-overlay' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'overlay_border',
				'label'       => esc_html__( 'Border', 'gyan-elements' ),
				'selector'    => '{{WRAPPER}} .gyan-services-overlay'
			]
		);

		$this->add_group_control(
		    Group_Control_Background::get_type(),
		    [
		        'name' => 'overlay_bg',
		        'label' => esc_html__( 'Overlay Background', 'gyan-elements' ),
		        'types' => [ 'classic', 'gradient' ],
				'fields_options' => [
					'background' => [
						'default' =>'classic',
					],
					'color' => [
						'default' => '#343a40',
					],
				],
		        'selector' => '{{WRAPPER}} .gyan-services-overlay',
		    ]
		);

		$this->end_controls_section();


		// Overlay - Title/Description --------------------
		// -------------------------------------

		$this->start_controls_section(
			'overlay_title_style',
			[
				'label'     => esc_html__( 'Overlay - Title & Description', 'gyan-elements' ),
				'condition' => [
					'show_overlay' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_overlay_title',
			[
				'label'                 => esc_html__( 'Show Title', 'gyan-elements' ),
				'type'                  => Controls_Manager::SWITCHER,
				'default'               => 'yes',
                'label_on'              => esc_html__( 'Yes', 'gyan-elements' ),
                'label_off'             => esc_html__( 'No', 'gyan-elements' ),
                'return_value'          => 'yes',
				'condition' => [
					'service_style' => array('1','2')
				],
			]
		);

		$this->add_control(
			'title_color_hover',
			[
				'label'     => esc_html__( 'Title Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .gyan-services-overlay-title,
					{{WRAPPER}} .gyan-services-overlay-title a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'overlay_title_typography',
				'label'     => esc_html__( 'Title Typography', 'gyan-elements' ),
				'selector'  => '{{WRAPPER}} .gyan-services-overlay-title',
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label'      => esc_html__( 'Title Spacing', 'gyan-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'size' => 10,
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
					'{{WRAPPER}} .gyan-services-overlay-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'overlay_title_html_tag',
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

		$this->add_control(
			'overlay_desc_style',
			[
				'label'     => esc_html__( 'Description', 'gyan-elements' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'desc_color_hover',
			[
				'label'     => esc_html__( 'Description Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .gyan-services-overlay-desc' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'overlay_desc_typography',
				'label'     => esc_html__( 'Description Typography', 'gyan-elements' ),
				'selector'  => '{{WRAPPER}} .gyan-services-overlay-desc',
			]
		);

		$this->add_responsive_control(
			'desc_spacing',
			[
				'label'      => esc_html__( 'Description Spacing', 'gyan-elements' ),
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
					'{{WRAPPER}} .gyan-services-overlay-desc' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();


		// Overlay - Icon --------------------
		// -------------------------------------

		$this->start_controls_section(
			'overlay_icon_style',
			[
				'label'     => esc_html__( 'Overlay - Icon', 'gyan-elements' ),
				'condition' => [
					'show_overlay' => 'yes',
				],
			]
		);

		$this->add_control(
			'overlay_icon',
			[
				'label'                 => esc_html__( 'Overlay Icon', 'gyan-elements' ),
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
				'name'                  => 'overlay_icon_image_size',
                'label'                 => esc_html__( 'Icon Image Size', 'gyan-elements' ),
                'default'               => 'full',
			]
		);

		$this->add_responsive_control(
			'overlay_icon_size',
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
					'overlay_icon' => 'yes',
				],
				'selectors'  => [
					'{{WRAPPER}} .gyan-services-overlay-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .gyan-services-overlay-icon img' => 'width:{{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_control(
			'overlay_icon_color_hover',
			[
				'label'     => esc_html__( 'Icon Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .gyan-services-overlay-icon' => 'color: {{VALUE}}',
					'{{WRAPPER}} .gyan-services-overlay-icon svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'overlay_iconbox_style',
			[
				'label'     => esc_html__( 'Icon Box', 'gyan-elements' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'overlay_iconbox_size',
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
					'overlay_icon' => 'yes',
				],
				'selectors'  => [
					'{{WRAPPER}} .gyan-services-overlay-icon' => 'height:{{SIZE}}{{UNIT}}; width:{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .gyan-services-overlay-icon i' => 'line-height:{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .gyan-services-overlay-icon svg' => 'height:{{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_responsive_control(
			'overlay_iconbox_margin',
			[
				'label'       => esc_html__( 'Margin', 'gyan-elements' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => [ 'px', '%' ],
				'selectors'   => [
					'{{WRAPPER}} .gyan-services-overlay-icon' => 'margin-top: {{TOP}}{{UNIT}}; margin-left: {{LEFT}}{{UNIT}}; margin-right: {{RIGHT}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
				],
			]
		);

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
					'{{WRAPPER}} .gyan-services-overlay-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'iconbox_border',
				'label'       => esc_html__( 'Icon Box Border', 'gyan-elements' ),
				'condition' => [
					'overlay_icon' => 'yes',
				],
				'selector'    => '{{WRAPPER}} .gyan-services-overlay-icon'
			]
		);

		$this->add_control(
			'iconbox_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'condition' => [
					'button_type' => array('button','icon_box')
				],
				'selectors'  => [
					'{{WRAPPER}} .gyan-services-overlay-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
		    Group_Control_Background::get_type(),
		    [
		        'name' => 'icon_box_bg_hover',
		        'label' => esc_html__( 'Icon Box Background', 'gyan-elements' ),
		        'types' => [ 'classic', 'gradient' ],
		        'selector' => '{{WRAPPER}} .gyan-services-overlay-icon',
		    ]
		);

		$this->end_controls_section();

		// Line Separator --------------------
		// -------------------------------------

		$this->start_controls_section(
			'line_separator_style',
			[
				'label'     => esc_html__( 'Overlay - Line Separator', 'gyan-elements' ),
				'condition' => [
					'show_overlay' => 'yes',
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
                'return_value'          => 'yes',
                'separator' 			=> 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'line_separator_border',
				'label'       => esc_html__( 'Border', 'gyan-elements' ),
				'selector'    => '{{WRAPPER}} .gyan-title-line-separator',
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'color' => [
						'default' => '#eee',
					],
					'placeholder' => '1px',
					'width' => [
						'default' => [
							'top' => '',
							'right' => '',
							'bottom' => '',
							'left' => '',
							'isLinked' => false,
						]
					],
				],
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
					'{{WRAPPER}} .gyan-title-line-separator' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'line_separator_spacing',
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
					'{{WRAPPER}} .gyan-title-line-separator' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();


		// Overlay Button --------------------
		// -------------------------------------

		$this->start_controls_section(
			'button_style',
			[
				'label'     => esc_html__( 'Overlay - Button', 'gyan-elements' ),
				'condition' => [
					'show_overlay' => 'yes',
					'button_on' => 'yes'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'button_typography',
				'label'     => esc_html__( 'Typography', 'gyan-elements' ),
				'selector'  => '{{WRAPPER}} .gyan-services-button',
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
				'selector'    => '{{WRAPPER}} .gyan-services-button',
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
				'selectors'  => [
					'{{WRAPPER}} .gyan-services-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'condition' => [
					'button_type' => array('button','icon_box')
				],
				'default' => [
                    'top' => '5',
                    'right' => '15',
                    'bottom' => '5',
                    'left' => '15',
                    'isLinked' => true,
            	],
				'selectors'  => [
					'{{WRAPPER}} .gyan-services-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .gyan-services-button' => 'margin-top: {{TOP}}{{UNIT}}; margin-left: {{LEFT}}{{UNIT}}; margin-right: {{RIGHT}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
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
				'default'   => '#eeeeee',
				'selectors' => [
					'{{WRAPPER}} a.gyan-services-button' => 'color: {{VALUE}}',
					'{{WRAPPER}} a.gyan-services-button svg' => 'fill: {{VALUE}}',
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
		        'selector' => '{{WRAPPER}} .gyan-services-button',
		    ]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'button_box_shadow',
				'condition' => [
					'button_type' => array('button','icon_box')
				],
				'selector'  => '{{WRAPPER}} .gyan-services-button',
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
					'{{WRAPPER}} a.gyan-services-button:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} a.gyan-services-button:hover svg' => 'fill: {{VALUE}}',
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
						'default' => '#191a1c',
					],
				],
				'condition' => [
					'button_type' => array('button','icon_box')
				],
		        'selector' => '{{WRAPPER}} .gyan-services-button:hover',
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
					'{{WRAPPER}} .gyan-services-button:hover' => 'border-color: {{VALUE}}',
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
				'selector'  => '{{WRAPPER}} .gyan-services-button:hover',
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
					'{{WRAPPER}} .gyan-services-button-icon' => 'font-size: {{SIZE}}{{UNIT}};',
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
						'max'  => 200,
						'step' => 1,
					],
				],
				'size_units' => [ 'px', 'em' ],
				'condition' => [
					'button_type' => 'icon_box',
				],
				'selectors'  => [
					'{{WRAPPER}} .gyan-services-button' => 'height:{{SIZE}}{{UNIT}}; width:{{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_icon_margin',
			[
				'label'       => esc_html__( 'Icon Margin', 'gyan-elements' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => [ 'px', '%' ],
				'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '7',
                    'isLinked' => false,
            	],
				'condition' => [
					'button_type!' => 'icon_box',
				],
				'selectors'   => [
					'{{WRAPPER}} .gyan-services-button i,{{WRAPPER}} .gyan-services-button svg' => 'margin-top: {{TOP}}{{UNIT}}; margin-left: {{LEFT}}{{UNIT}}; margin-right: {{RIGHT}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		$i = 1;
		$data_rtl = is_rtl() ? 'true' : 'false';

		ob_start();
		Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] );
		$button_icon = ob_get_clean();
		$button_icon = '<span class="gyan-services-button-icon gyan-icon">' . $button_icon . '</span>';

		$button_text = '<span>' . $settings['button_text'] . '</span>';
		$button_text = ('icon_box' != $settings['button_type']) ? '<span>' . $settings['button_text'] . '</span>' : '';

		$service_button = ('before' == $settings['button_icon_position']) ? $button_icon . $button_text : $button_text . $button_icon;

		?>

		<div class="gyan-services-container gyan-services-st-<?php echo $settings['service_style']; ?> <?php echo esc_attr( 'gyan-services-container-'.$this->get_id() ); ?>" data-layout="<?php echo esc_attr( $settings['layout'] ); ?>" data-rtl="<?php echo $data_rtl; ?>">

			<div class="gyan-services-items gyan-elementor-grid">

				<?php foreach ( $settings['services_items'] as $index => $item ) :

					$anchor_tag = 'span';
					$service_link_key = 'service_link_' . $i;

					if ( !empty( $item['service_link']['url'] ) ) {

						$this->add_render_attribute( $service_link_key, 'href', esc_url($item['service_link']['url']) );
						$this->add_render_attribute( $service_link_key, 'class', 'gyan-service-link' );

						if ( $item['service_link']['is_external'] ) {
							$this->add_render_attribute( $service_link_key, 'target', '_blank' );
						}
						if ( $item['service_link']['nofollow'] ) {
							$this->add_render_attribute( $service_link_key, 'rel', 'nofollow' );
						}

						$anchor_tag = 'a';

					}

					// responsive image
					if (  $settings['image_size_size'] == 'full' ) {
					    $image_html = wp_get_attachment_image( $item['service_img']['id'], 'full');
					} else {
					    $imgUrl = Group_Control_Image_Size::get_attachment_image_src( $item['service_img']['id'], 'image_size', $settings );
					    if ( ! $imgUrl ) {
					        $imgUrl = $item['service_img']['url'];
					    }
					    $image_html = '<img src="'.esc_url($imgUrl).'" alt="" />';
					}

					$imgBgUrl = Group_Control_Image_Size::get_attachment_image_src( $item['service_img']['id'], 'image_size', $settings );

					$title_section_icon_html = '';

					if ( 'yes' == $settings['show_title_icon'] ) :

	                    if ( $item['service_icon_type'] == 'icon' ) {

	                    	ob_start();
	                    	Icons_Manager::render_icon( $item['service_icon'], [ 'aria-hidden' => 'true' ] );
	                    	$title_section_icon = ob_get_clean();
	                    	$title_section_icon_html = '<div class="gyan-services-title-icon">' . $title_section_icon . '</div>';

	                    } else {

	    					// responsive image
	    					if (  $settings['icon_image_size_size'] == 'full' ) {
	    					    $service_icon_image_html = wp_get_attachment_image( $item['service_icon_img']['id'], 'full');
	    					} else {
	    					    $imgUrl = Group_Control_Image_Size::get_attachment_image_src( $item['service_icon_img']['id'], 'icon_image_size', $settings );
	    					    if ( ! $imgUrl ) {
	    					        $imgUrl = $item['service_icon_img']['url'];
	    					    }
	    					    $service_icon_image_html = '<img src="'.esc_url($imgUrl).'" alt="" />';
	    					}

	    					$title_section_icon_html = '<div class="gyan-services-title-icon">' . $service_icon_image_html . '</div>';

	                    }

					endif;

					$title_section_title_html = '<' . $settings['title_html_tag'] . ' class="gyan-services-title"><' . $anchor_tag . ' ' . $this->get_render_attribute_string( $service_link_key ) . '>' . $item['service_title'] . '</' . $anchor_tag . '></' . $settings['title_html_tag'] . '>';


					$line_separator_html = ( 'yes' == $settings['line_separator'] ) ? '<div class="gyan-title-line-separator"></div>' : '';

					$description_html = ( ! empty( $item['service_desc'] )) ? '<div class="gyan-services-overlay-desc">' . $item['service_desc'] . '</div>' : '';

					$overlay_icon_html = '';

					if ( 'yes' == $settings['overlay_icon'] ) :

	                    if ( $item['service_overlay_icon_type'] == 'icon' ) {

	                    	ob_start();
	                    	Icons_Manager::render_icon( $item['service_overlay_icon'], [ 'aria-hidden' => 'true' ] );
	                    	$overlay_icon = ob_get_clean();
							$overlay_icon_html = '<div class="gyan-services-overlay-icon">' . $overlay_icon . '</div>';

	                    } else {

	                        // responsive image
	                        if (  $settings['overlay_icon_image_size_size'] == 'full' ) {
	                            $service_overlay_icon_image_html = wp_get_attachment_image( $item['service_overlay_icon_img']['id'], 'full');
	                        } else {
	                            $imgUrl = Group_Control_Image_Size::get_attachment_image_src( $item['service_overlay_icon_img']['id'], 'icon_image_size', $settings );
	                            if ( ! $imgUrl ) {
	                                $imgUrl = $item['service_overlay_icon_img']['url'];
	                            }
	                            $service_overlay_icon_image_html = '<img src="'.esc_url($imgUrl).'" alt="" />';
	                        }

	    					$overlay_icon_html = '<div class="gyan-services-overlay-icon">' . $service_overlay_icon_image_html . '</div>';

	                    }

					endif;

					$overlay_title_html = '<' . $settings['overlay_title_html_tag'] . ' class="gyan-services-overlay-title"><' . $anchor_tag . ' ' . $this->get_render_attribute_string( $service_link_key ) . '>' . $item['service_title'] . '</' . $anchor_tag . '></' . $settings['overlay_title_html_tag'] . '>';

					$overlay_button_html = '';

					if ( 'yes' == $settings['button_on'] && !empty( $item['service_link']['url'] ) ) {

						$this->add_render_attribute( $service_link_key, 'class', [
								'gyan-services-button',
								'gyan-ease-transition',
								'gyan-flex'
							]
						);

						$overlay_button_html = '<a ' . $this->get_render_attribute_string( $service_link_key ) . '>' . $service_button . '</a>';
					}
					?>

					<div class="gyan-service-item gyan-grid-item-wrap">
						<div class="gyan-services gyan-grid-item gyan-ease-transition">
							<?php include GYAN_ADDONS_DIR.'layouts/services/service-' . $settings['service_style'] . '.php'; ?>
						</div>
					</div>

				 <?php $i++;
				endforeach; ?>

			 </div> <!-- gyan-services-items -->
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
	            var gyanPGClass = '.gyan-services-container-'+'<?php echo $this->get_id(); ?>',
	                $this = $(gyanPGClass),
	                $isoGrid = $this.children('.gyan-services-items'),
	                is_rtl = $this.data('rtl') ? false : true,
	                layout = $this.data('layout');

	            $this.imagesLoaded( function() {

	                if ( 'masonry' == layout ) {
	                    var $grid = $isoGrid.isotope({
	                        itemSelector: '.gyan-service-item',
	                        percentPosition: true,
	                        originLeft: is_rtl,
	                        masonry: {
	                            columnWidth: '.gyan-service-item',
	                        }
	                    });
	                } else{
	                    var $grid = $isoGrid.isotope({
	                        itemSelector: '.gyan-service-item',
	                        layoutMode: 'fitRows',
	                        originLeft: is_rtl
	                    });
	                }

	                $this.find('.gyan-service-item').resize( function() {
	                    $grid.isotope( 'layout' );
	                });

	            });

	        });
	        </script>
	        <?php
	}

	protected function _content_template() {}

}