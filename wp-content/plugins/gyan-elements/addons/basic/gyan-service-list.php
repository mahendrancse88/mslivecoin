<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Control_Media;
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
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Gyan_Service_List extends Widget_Base {

	public function get_name()           { return 'gyan_service_list'; }
	public function get_title()          { return esc_html__( 'Service List', 'gyan-elements' ); }
	public function get_icon()           { return 'gyan-el-icon eicon-post-list'; }
	public function get_categories()     { return ['gyan-basic-addons']; }
	public function get_keywords()       { return [ 'gyan service list', 'service', 'list', 'info','content','services' ]; }
	public function get_style_depends()  { return ['gyan-icon','gyan-service-list']; }

    protected function register_controls() {

        $this->start_controls_section(
            'section_list',
            [
                'label' => esc_html__( 'List Items', 'gyan-elements' ),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
        	'text',
			[
				'label'       => esc_html__( 'Title', 'gyan-elements' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active'  => true,
                ],
                'default'     => esc_html__('List Item Title','gyan-elements')
			]
        );

        $repeater->add_control(
            'title_prefix',
            [
                'label'       => esc_html__( 'Title Prefix Text', 'gyan-elements' ),
                'label_block' => true,
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active'  => true,
                ]
            ]
        );

        $repeater->add_control(
        	'description',
			[
				'label'       => esc_html__( 'Description', 'gyan-elements' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
                'dynamic'     => [
                    'active'  => true,
                ],
                'default'     => esc_html__('List Item Description','gyan-elements')
			]
        );

        $repeater->add_control(
        	'gyan_icon_type',
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
                        'icon'  => 'fa fa-hashtag',
                    ],
                ],
                'default'       => 'icon',
			]
        );

        $repeater->add_control(
        	'list_icon',
        	[
        		'label' => esc_html__( 'Icon', 'elementor' ),
        		'type' => Controls_Manager::ICONS,
        		'default' => [
        			'value' => 'fas fa-check',
        			'library' => 'fa-solid',
        		],
        		'condition'         => [
                    'gyan_icon_type' => 'icon',
                ],
        	]
        );

        $repeater->add_control(
        	'list_image',
            [
				'label'             => esc_html__( 'Image', 'gyan-elements' ),
				'label_block'       => true,
				'type'              => Controls_Manager::MEDIA,
		        'default'           => [
                    'url' => Utils::get_placeholder_image_src(),
                 ],
		        'condition'         => [
                    'gyan_icon_type' => 'image',
                ],
			]
        );

        $repeater->add_control(
        	'icon_text',
			[
				'label'             => esc_html__( 'Icon Text', 'gyan-elements' ),
				'label_block'       => false,
				'type'              => Controls_Manager::TEXT,
                'default'           => esc_html__('1','gyan-elements'),
		        'condition'         => [
                    'gyan_icon_type' => 'text',
                ],
			]
        );

        $repeater->add_control(
        	'link_type',
            [
                'label'             => esc_html__( 'Link Type', 'gyan-elements' ),
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                    'none'      => esc_html__( 'None', 'gyan-elements' ),
                    'box'       => esc_html__( 'Box', 'gyan-elements' ),
                    'title'     => esc_html__( 'Title', 'gyan-elements' ),
                    'button'    => esc_html__( 'Button', 'gyan-elements' ),
                ],
                'default'           => 'none',
            ]
        );

        $repeater->add_control(
        	'button_text',
            [
                'label'             => esc_html__( 'Button Text', 'gyan-elements' ),
                'type'              => Controls_Manager::TEXT,
                'dynamic'           => [
                    'active'    => true,
                ],
                'default'           => esc_html__( 'Get Started', 'gyan-elements' ),
                'condition'         => [
                    'link_type' => 'button',
                ],
            ]
        );

        $repeater->add_control(
        	'button_icon',
        	[
        		'label' => esc_html__( 'Button Icon', 'elementor' ),
        		'type' => Controls_Manager::ICONS,
        		'default' => [
        			'value' => 'fas fa-star',
        			'library' => 'fa-solid',
        		],
        		'condition'         => [
        		    'link_type' => 'button',
        		],
        	]
        );

        $repeater->add_control(
        	'button_icon_position',
            [
                'label'             => esc_html__( 'Icon Position', 'gyan-elements' ),
                'type'              => Controls_Manager::SELECT,
                'default'           => 'after',
                'options'           => [
                    'after'     => esc_html__( 'After', 'gyan-elements' ),
                    'before'    => esc_html__( 'Before', 'gyan-elements' ),
                ],
                'condition'         => [
                    'link_type'     => 'button',
                    'button_icon!'  => '',
                ],
            ]
        );

        $repeater->add_control(
        	'link',
			[
				'label'             => esc_html__( 'Link', 'gyan-elements' ),
				'type'              => Controls_Manager::URL,
                'dynamic'           => [
                    'active'  => true,
                ],
				'label_block'       => true,
				'placeholder'       => esc_html__( 'http://your-link.com', 'gyan-elements' ),
                'default'               => [
                    'url' => '#',
                ],
                'conditions'        => [
					'terms' => [
						[
							'name' => 'link_type',
							'operator' => '!=',
							'value' => 'none',
						],
					],
				],
			]
        );

        $repeater->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'icon_bg_unique',
                'label'     => esc_html__( 'Icon Box Background', 'gyan-elements' ),
                'types'     => [ 'classic', 'gradient' ],
                'condition'         => [
                    'gyan_icon_type!' => 'none',
                    'gyan_icon_type!' => 'image',
                ],
                'selector'  => '{{WRAPPER}} {{CURRENT_ITEM}}.gyan-service-list-item-inner .gyan-servicelist-icon-wrapper',
            ]
        );

        $this->add_control(
        	'list_items',
        	[
        		'type' => Controls_Manager::REPEATER,
        		'fields' => $repeater->get_controls(),
        		'default'               => [
					[
						'text'      => esc_html__( 'List Item One', 'gyan-elements' ),
                        'list_icon' => esc_html__('fa fa-check','gyan-elements')
					],
                    [
						'text'      => esc_html__( 'List Item Two', 'gyan-elements' ),
                        'list_icon' => esc_html__('fa fa-heart','gyan-elements')
					],
					[
						'text'      => esc_html__( 'List Item Three', 'gyan-elements' ),
                        'list_icon' => esc_html__('fa fa-star','gyan-elements')
					],
				],
        		'title_field' => '{{{ text }}}',
        	]
        );


		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'                  => 'thumbnail',
                'label'                 => esc_html__( 'Image Size', 'gyan-elements' ),
                'default'               => 'full',
				'separator'             => 'before',
			]
		);

		$this->add_control(
			'connector',
			[
				'label'                 => esc_html__( 'Connector', 'gyan-elements' ),
				'type'                  => Controls_Manager::SWITCHER,
				'default'               => 'yes',
                'label_on'              => esc_html__( 'Yes', 'gyan-elements' ),
                'label_off'             => esc_html__( 'No', 'gyan-elements' ),
                'return_value'          => 'yes',
			]
		);

		$this->add_control(
			'corner_lines',
			[
				'label'                 => esc_html__( 'Hide Corner Lines', 'gyan-elements' ),
				'type'                  => Controls_Manager::SWITCHER,
				'default'               => 'yes',
                'label_on'              => esc_html__( 'Yes', 'gyan-elements' ),
                'label_off'             => esc_html__( 'No', 'gyan-elements' ),
                'return_value'          => 'yes',
                'condition'             => [
                    'connector' => 'yes',
                ],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'section_list_style',
            [
                'label'                 => esc_html__( 'List', 'gyan-elements' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_responsive_control(
			'items_spacing',
			[
				'label'                 => esc_html__( 'Items Spacing', 'gyan-elements' ),
				'type'                  => Controls_Manager::SLIDER,
				'default'               => [
                    'size' => 15,
                ],
				'range'                 => [
					'px' => [
						'max' => 300,
					],
				],
				'selectors'             => [
					'{{WRAPPER}}.gyan-service-list-icon-left .gyan-service-list-item:not(:last-child) .gyan-service-list-item-inner, {{WRAPPER}}.gyan-service-list-icon-right .gyan-service-list-item:not(:last-child) .gyan-service-list-item-inner' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.gyan-service-list-icon-top .gyan-service-list-item .gyan-service-list-item-inner' => 'margin-right: calc({{SIZE}}{{UNIT}}/2); margin-left: calc({{SIZE}}{{UNIT}}/2);',
					'{{WRAPPER}}.gyan-service-list-icon-top .gyan-list-items' => 'margin-right: calc(-{{SIZE}}{{UNIT}}/2); margin-left: calc(-{{SIZE}}{{UNIT}}/2);',

					'(tablet){{WRAPPER}}.gyan-service-list-stack-tablet.gyan-service-list-icon-top .gyan-service-list-item .gyan-service-list-item-inner' => 'margin-bottom: {{SIZE}}{{UNIT}}; margin-left: 0; margin-right: 0;',
                    '(tablet){{WRAPPER}}.gyan-service-list-stack-tablet.gyan-service-list-icon-top .gyan-list-items' => 'margin-right: 0; margin-left: 0;',

					'(mobile){{WRAPPER}}.gyan-service-list-stack-mobile.gyan-service-list-icon-top .gyan-service-list-item .gyan-service-list-item-inner' => 'margin-bottom: {{SIZE}}{{UNIT}}; margin-left: 0; margin-right: 0;',
                    '(mobile){{WRAPPER}}.gyan-service-list-stack-mobile.gyan-service-list-icon-top .gyan-list-items' => 'margin-right: 0; margin-left: 0;',
				],
			]
		);

		$this->add_control(
			'icon_position',
			[
                'label'                 => esc_html__( 'Position', 'gyan-elements' ),
                'type'                  => Controls_Manager::CHOOSE,
				'label_block'           => false,
				'toggle'                => false,
                'default'               => 'left',
                'options'               => [
                    'left'      => [
                        'title' => esc_html__( 'Left', 'gyan-elements' ),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'top'       => [
                        'title' => esc_html__( 'Top', 'gyan-elements' ),
                        'icon'  => 'eicon-v-align-top',
                    ],
                    'right'     => [
                        'title' => esc_html__( 'Right', 'gyan-elements' ),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
				'prefix_class'          => 'gyan-service-list-icon-',
			]
		);

		$this->add_control(
			'responsive_breakpoint',
			[
				'label'                 => esc_html__( 'Responsive Breakpoint', 'gyan-elements' ),
				'type'                  => Controls_Manager::SELECT,
				'label_block'           => false,
				'default'               => 'mobile',
				'options'               => [
					''         => esc_html__( 'None', 'gyan-elements' ),
					'tablet'   => esc_html__( 'Tablet', 'gyan-elements' ),
					'mobile'   => esc_html__( 'Mobile', 'gyan-elements' ),
				],
				'prefix_class'          => 'gyan-service-list-stack-',
                'condition'             => [
                    'icon_position' => 'top',
                ],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'section_connector_style',
            [
                'label'                 => esc_html__( 'Connector', 'gyan-elements' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    'connector' => 'yes',
                ],
            ]
        );

		$this->add_control(
			'connector_color',
			[
				'label'                 => esc_html__( 'Color', 'gyan-elements' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '#e6e6e6',
				'selectors'             => [
					'{{WRAPPER}} .gyan-service-list-connector .gyan-servicelist-icon-outer:before, {{WRAPPER}} .gyan-service-list-connector .gyan-servicelist-icon-outer:after' => 'border-color: {{VALUE}};',
				],
                'condition'             => [
                    'connector' => 'yes',
                ],
			]
		);

		$this->add_control(
			'connector_style',
			[
				'label'                 => esc_html__( 'Style', 'gyan-elements' ),
				'type'                  => Controls_Manager::SELECT,
				'options'               => [
					'solid'    => esc_html__( 'Solid', 'gyan-elements' ),
					'double'   => esc_html__( 'Double', 'gyan-elements' ),
					'dotted'   => esc_html__( 'Dotted', 'gyan-elements' ),
					'dashed'   => esc_html__( 'Dashed', 'gyan-elements' ),
				],
				'default'               => 'solid',
				'selectors'             => [
					'{{WRAPPER}}.gyan-service-list-icon-left .gyan-service-list-connector .gyan-servicelist-icon-outer:before, {{WRAPPER}}.gyan-service-list-icon-left .gyan-service-list-connector .gyan-servicelist-icon-outer:after' => 'border-right-style: {{VALUE}};',
					'{{WRAPPER}}.gyan-service-list-icon-right .gyan-service-list-connector .gyan-servicelist-icon-outer:before, {{WRAPPER}}.gyan-service-list-icon-right .gyan-service-list-connector .gyan-servicelist-icon-outer:after' => 'border-left-style: {{VALUE}};',
					'{{WRAPPER}}.gyan-service-list-icon-top .gyan-service-list-connector .gyan-servicelist-icon-outer:before, {{WRAPPER}}.gyan-service-list-icon-top .gyan-service-list-connector .gyan-servicelist-icon-outer:after' => 'border-top-style: {{VALUE}};',

					'(tablet){{WRAPPER}}.gyan-service-list-stack-tablet.gyan-service-list-icon-top .gyan-service-list-connector .gyan-servicelist-icon-outer:before, {{WRAPPER}}.gyan-service-list-icon-top .gyan-service-list-connector .gyan-servicelist-icon-outer:after' => 'border-right-style: {{VALUE}};',

					'(mobile){{WRAPPER}}.gyan-service-list-stack-mobile.gyan-service-list-icon-top .gyan-service-list-connector .gyan-servicelist-icon-outer:before, {{WRAPPER}}.gyan-service-list-icon-top .gyan-service-list-connector .gyan-servicelist-icon-outer:after' => 'border-right-style: {{VALUE}};',
				],
                'condition'             => [
                    'connector' => 'yes',
                ],
			]
		);

		$this->add_responsive_control(
			'connector_width',
			[
				'label'                 => esc_html__( 'Width', 'gyan-elements' ),
				'type'                  => Controls_Manager::SLIDER,
				'default'               => [
					'size' => 1,
				],
				'range'                 => [
					'px' => [
						'min' => 1,
						'max' => 50,
					],
				],
				'selectors'             => [
					'{{WRAPPER}}.gyan-service-list-icon-left .gyan-service-list-connector .gyan-servicelist-icon-outer:before, {{WRAPPER}}.gyan-service-list-icon-left .gyan-service-list-connector .gyan-servicelist-icon-outer:after' => 'border-right-width: {{SIZE}}px;',
					'{{WRAPPER}}.gyan-service-list-icon-right .gyan-service-list-connector .gyan-servicelist-icon-outer:before, {{WRAPPER}}.gyan-service-list-icon-right .gyan-servicelist-icon-outer:after' => 'border-left-width: {{SIZE}}px;',
					'{{WRAPPER}}.gyan-service-list-icon-top .gyan-service-list-connector .gyan-servicelist-icon-outer:before, {{WRAPPER}}.gyan-service-list-icon-top .gyan-service-list-connector .gyan-servicelist-icon-outer:after' => 'border-top-width: {{SIZE}}px;',

					'(tablet){{WRAPPER}}.gyan-service-list-stack-tablet.gyan-service-list-icon-top .gyan-service-list-connector .gyan-servicelist-icon-outer:before, {{WRAPPER}}.gyan-service-list-icon-top .gyan-service-list-connector .gyan-servicelist-icon-outer:after' => 'border-right-width: {{SIZE}}px;',

					'(mobile){{WRAPPER}}.gyan-service-list-stack-mobile.gyan-service-list-icon-top .gyan-service-list-connector .gyan-servicelist-icon-outer:before, {{WRAPPER}}.gyan-service-list-icon-top .gyan-service-list-connector .gyan-servicelist-icon-outer:after' => 'border-right-width: {{SIZE}}px;',
				],
                'condition'             => [
                    'connector' => 'yes',
                ],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'section_icon_style',
            [
                'label'                 => esc_html__( 'Icon', 'gyan-elements' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'icon_vertical_align',
			[
				'label'                 => esc_html__( 'Vertical Align', 'gyan-elements' ),
				'type'                  => Controls_Manager::CHOOSE,
				'label_block'           => false,
				'toggle'                => false,
				'default'               => 'middle',
				'options'               => [
					'top'          => [
						'title'    => esc_html__( 'Top', 'gyan-elements' ),
						'icon'     => 'eicon-v-align-top',
					],
					'middle'       => [
						'title'    => esc_html__( 'Center', 'gyan-elements' ),
						'icon'     => 'eicon-v-align-middle',
					],
					'bottom'       => [
						'title'    => esc_html__( 'Bottom', 'gyan-elements' ),
						'icon'     => 'eicon-v-align-bottom',
					],
				],
				'selectors_dictionary'  => [
					'top'          => 'flex-start',
					'middle'       => 'center',
					'bottom'       => 'flex-end',
				],
				'prefix_class'          => 'gyan-service-list-icon-vertical-',
                'condition'             => [
                    'icon_position' => ['left','right'],
                ],
			]
		);

        $this->add_control(
			'icon_horizontal_align',
			[
				'label'                 => esc_html__( 'Horizontal Align', 'gyan-elements' ),
				'type'                  => Controls_Manager::CHOOSE,
				'label_block'           => false,
				'toggle'                => false,
				'options'               => [
					'left'      => [
						'title' => esc_html__( 'Left', 'gyan-elements' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center'           => [
						'title' => esc_html__( 'Center', 'gyan-elements' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'            => [
						'title' => esc_html__( 'Right', 'gyan-elements' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'               => 'left',
                'selectors_dictionary'  => [
					'left'     => 'flex-start',
					'center'   => 'center',
					'right'    => 'flex-end',
				],
				'prefix_class'          => 'gyan-service-list-icon-horizontal-',
                'condition'             => [
                    'icon_position' => 'top',
                ],
			]
		);

        $this->add_responsive_control(
            'icon_size',
            [
                'label'                 => esc_html__( 'Size', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [
                    'size' => 14,
                ],
                'range'                 => [
                    'px' => [
                        'min' => 6,
                        'max' => 200,
                    ],
                ],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-list-items .gyan-service-list-icon' => 'font-size: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .gyan-list-items .gyan-service-list-image img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'icon_number_typography',
                'label'                 => esc_html__( 'Typography for Numbers', 'gyan-elements' ),
                'selector'              => '{{WRAPPER}} .gyan-list-items .gyan-service-list-icon.gyan-service-list-number'
            ]
        );

        $this->add_responsive_control(
            'icon_box_size',
            [
                'label'                 => esc_html__( 'Box Size', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [
                    'size' => 40,
                ],
                'range'                 => [
                    'px' => [
                        'min' => 6,
                        'max' => 200,
                    ],
                ],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-servicelist-icon-wrapper' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        if ( is_rtl() ) {

            $this->add_responsive_control(
                'icon_spacing',
                [
                    'label'                 => esc_html__( 'Spacing', 'gyan-elements' ),
                    'type'                  => Controls_Manager::SLIDER,
                    'default'               => [
                        'size' => 15,
                    ],
                    'range'                 => [
                        'px' => [
                            'max' => 200,
                        ],
                    ],
                    'selectors'             => [
                        '{{WRAPPER}}.gyan-service-list-icon-left .gyan-servicelist-icon-outer' => 'margin-left: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}}.gyan-service-list-icon-right .gyan-servicelist-icon-outer' => 'margin-right: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}}.gyan-service-list-icon-top .gyan-servicelist-icon-outer' => 'margin-bottom: {{SIZE}}{{UNIT}};',

                        '(tablet){{WRAPPER}}.gyan-service-list-stack-tablet.gyan-service-list-icon-top .gyan-servicelist-icon-outer' => 'margin-right: {{SIZE}}{{UNIT}}; margin-bottom: 0;',

                        '(mobile){{WRAPPER}}.gyan-service-list-stack-mobile.gyan-service-list-icon-top .gyan-servicelist-icon-outer' => 'margin-right: {{SIZE}}{{UNIT}}; margin-bottom: 0;',
                    ],
                ]
            );

        } else {

            $this->add_responsive_control(
                'icon_spacing',
                [
                    'label'                 => esc_html__( 'Spacing', 'gyan-elements' ),
                    'type'                  => Controls_Manager::SLIDER,
                    'default'               => [
                        'size' => 15,
                    ],
                    'range'                 => [
                        'px' => [
                            'max' => 200,
                        ],
                    ],
                    'selectors'             => [
                        '{{WRAPPER}}.gyan-service-list-icon-left .gyan-servicelist-icon-outer' => 'margin-right: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}}.gyan-service-list-icon-right .gyan-servicelist-icon-outer' => 'margin-left: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}}.gyan-service-list-icon-top .gyan-servicelist-icon-outer' => 'margin-bottom: {{SIZE}}{{UNIT}};',

                        '(tablet){{WRAPPER}}.gyan-service-list-stack-tablet.gyan-service-list-icon-top .gyan-servicelist-icon-outer' => 'margin-right: {{SIZE}}{{UNIT}}; margin-bottom: 0;',

                        '(mobile){{WRAPPER}}.gyan-service-list-stack-mobile.gyan-service-list-icon-top .gyan-servicelist-icon-outer' => 'margin-right: {{SIZE}}{{UNIT}}; margin-bottom: 0;',
                    ],
                ]
            );

        }

        $this->add_control(
            'icon_border_radius',
            [
                'label'                 => esc_html__( 'Box Border Radius', 'gyan-elements' ),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => [ 'px', '%' ],
                'default'    => [
                    'top'    => '100',
                    'bottom' => '100',
                    'left'   => '100',
                    'right'  => '100',
                    'unit'   => '%',
                ],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-list-items .gyan-servicelist-icon-wrapper,
                    {{WRAPPER}} .gyan-list-items .gyan-servicelist-icon-outer,
                    {{WRAPPER}} .gyan-list-items .gyan-servicelist-icon-outer' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'img_border_radius',
            [
                'label'                 => esc_html__( 'Image Border Radius', 'gyan-elements' ),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => [ 'px', '%' ],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-list-items .gyan-service-list-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_icon_style' );

        $this->start_controls_tab(
            'tab_icon_normal',
            [
                'label'                 => esc_html__( 'Normal', 'gyan-elements' ),
            ]
        );

		$this->add_control(
			'icon_color',
			[
				'label'                 => esc_html__( 'Icon Color', 'gyan-elements' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .gyan-list-items .gyan-service-list-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .gyan-list-items .gyan-service-list-icon svg' => 'fill: {{VALUE}};',
				],
				'scheme'                => [
					'type'     => Scheme_Color::get_type(),
					'value'    => Scheme_Color::COLOR_2,
				],
			]
		);

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'icon_bg',
                'label'     => esc_html__( 'Icon Box Background', 'gyan-elements' ),
                'types'     => [ 'classic', 'gradient' ],
                'fields_options' => [
                    'background' => [
                        'default' =>'classic',
                    ],
                    'color' => [
                        'default' => '#f5f5f5',
                    ],
                ],
                'selector'  => '{{WRAPPER}} .gyan-list-items .gyan-servicelist-icon-wrapper',
            ]
        );

        $this->add_control(
            'icon_border_outer_heading',
            [
                'label'                 => esc_html__( 'Outside Border', 'gyan-elements' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'icon_border',
				'label'                 => esc_html__( 'Outside Border', 'gyan-elements' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .gyan-list-items .gyan-servicelist-icon-outer',
			]
		);

        $this->add_control(
            'icon_border_inside_heading',
            [
                'label'                 => esc_html__( 'Inside Border', 'gyan-elements' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'                  => 'icon_border_outside',
                'label'                 => esc_html__( 'Inside Border', 'gyan-elements' ),
                'selector'              => '{{WRAPPER}} .gyan-list-items .gyan-servicelist-icon-wrapper',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_hover',
            [
                'label'                 => esc_html__( 'Hover', 'gyan-elements' ),
            ]
        );

		$this->add_control(
			'icon_color_hover',
			[
				'label'                 => esc_html__( 'Icon Color', 'gyan-elements' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .gyan-list-items .gyan-servicelist-icon-wrapper:hover .gyan-service-list-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .gyan-list-items .gyan-servicelist-icon-wrapper:hover .gyan-service-list-icon svg' => 'fill: {{VALUE}};',
				],
				'scheme'                => [
					'type'     => Scheme_Color::get_type(),
					'value'    => Scheme_Color::COLOR_2,
				],
			]
		);

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'icon_bg_hover',
                'label' => esc_html__( 'Icon Box Background', 'gyan-elements' ),
                'types' => [ 'classic', 'gradient' ],
                'separator'             => 'before',
                'selector' => '{{WRAPPER}} .gyan-list-items .gyan-servicelist-icon-wrapper:hover',
            ]
        );

		$this->add_control(
			'icon_border_inside_color_hover',
			[
				'label'                 => esc_html__( 'Inside Border Color', 'gyan-elements' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .gyan-list-items .gyan-servicelist-icon-wrapper:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

        $this->add_control(
            'icon_border_outside_color_hover',
            [
                'label'                 => esc_html__( 'Outside Border Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-list-items .gyan-servicelist-icon-outer:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_style',
            [
                'label'                 => esc_html__( 'Content', 'gyan-elements' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
			'content_align',
			[
				'label'                 => esc_html__( 'Alignment', 'gyan-elements' ),
				'type'                  => Controls_Manager::CHOOSE,
				'options'               => [
					'left'      => [
						'title' => esc_html__( 'Left', 'gyan-elements' ),
						'icon'  => 'fa fa-align-left',
					],
					'center'    => [
						'title' => esc_html__( 'Center', 'gyan-elements' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'     => [
						'title' => esc_html__( 'Right', 'gyan-elements' ),
						'icon'  => 'fa fa-align-right',
					],
					'justify'   => [
						'title' => esc_html__( 'Justified', 'gyan-elements' ),
						'icon'  => 'fa fa-align-justify',
					],
				],
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .gyan-servicelist-content-wrapper' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->add_control(
            'title_heading',
            [
                'label'                 => esc_html__( 'Title', 'gyan-elements' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
            ]
        );

		$this->add_control(
			'title_color',
			[
				'label'                 => esc_html__( 'Color', 'gyan-elements' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .gyan-service-list-title' => 'color: {{VALUE}};',
				],
				'scheme'                => [
					'type'     => Scheme_Color::get_type(),
					'value'    => Scheme_Color::COLOR_2,
				],
			]
		);

        $this->add_responsive_control(
            'title_spacing',
            [
                'label'                 => esc_html__( 'Spacing', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [
                    'size' => 0,
                ],
                'range'                 => [
                    'px' => [
                        'min' => -25,
                        'max' => 150,
                    ],
                ],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-service-list-title ' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label' => esc_html__( 'Select Tag', 'gyan-elements' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                ],
                'default' => 'h3',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'title_typography',
                'label'                 => esc_html__( 'Typography', 'gyan-elements' ),
                'scheme'                => Scheme_Typography::TYPOGRAPHY_4,
                'fields_options' => [
                    'typography' => [
                        'default' =>'custom',
                    ],
                    'font_size'   => [
                        'default' => [
                            'size' => '20',
                        ],
                    ]
                ],
                'selector'              => '{{WRAPPER}} .gyan-service-list-title',
            ]
        );

        $this->add_control(
            'title_prefix_heading',
            [
                'label'                 => esc_html__( 'Title Prefix', 'gyan-elements' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
            ]
        );

        $this->add_control(
            'title_prefix_color',
            [
                'label'                 => esc_html__( 'Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-service-list-title span' => 'color: {{VALUE}};',
                ],
                'scheme'                => [
                    'type'     => Scheme_Color::get_type(),
                    'value'    => Scheme_Color::COLOR_2,
                ],
            ]
        );

        if ( is_rtl() ) {

            $this->add_responsive_control(
                'title_prefix_spacing',
                [
                    'label'                 => esc_html__( 'Spacing', 'gyan-elements' ),
                    'type'                  => Controls_Manager::SLIDER,
                    'default'               => [
                        'size' => 15,
                    ],
                    'range'                 => [
                        'px' => [
                            'max' => 150,
                        ],
                    ],
                    'selectors'             => [
                        '{{WRAPPER}} .gyan-service-list-title span ' => 'margin-left: {{SIZE}}{{UNIT}};'
                    ],
                ]
            );

        } else {

            $this->add_responsive_control(
                'title_prefix_spacing',
                [
                    'label'                 => esc_html__( 'Spacing', 'gyan-elements' ),
                    'type'                  => Controls_Manager::SLIDER,
                    'default'               => [
                        'size' => 15,
                    ],
                    'range'                 => [
                        'px' => [
                            'max' => 150,
                        ],
                    ],
                    'selectors'             => [
                        '{{WRAPPER}} .gyan-service-list-title span ' => 'margin-right: {{SIZE}}{{UNIT}};'
                    ],
                ]
            );

        }

        $this->add_control(
            'description_heading',
            [
                'label'                 => esc_html__( 'Description', 'gyan-elements' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
            ]
        );

		$this->add_control(
			'description_color',
			[
				'label'                 => esc_html__( 'Color', 'gyan-elements' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .gyan-service-list-description' => 'color: {{VALUE}};',
				],
				'scheme'                => [
					'type'     => Scheme_Color::get_type(),
					'value'    => Scheme_Color::COLOR_2,
				],
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'description_typography',
                'label'                 => esc_html__( 'Typography', 'gyan-elements' ),
                'scheme'                => Scheme_Typography::TYPOGRAPHY_4,
                'selector'              => '{{WRAPPER}} .gyan-service-list-description',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_service_box_button_style',
            [
                'label'                 => esc_html__( 'Button', 'gyan-elements' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
			'button_size',
			[
				'label'                 => esc_html__( 'Size', 'gyan-elements' ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'sm',
				'options'               => [
					'xs' => esc_html__( 'Extra Small', 'gyan-elements' ),
					'sm' => esc_html__( 'Small', 'gyan-elements' ),
					'md' => esc_html__( 'Medium', 'gyan-elements' ),
					'lg' => esc_html__( 'Large', 'gyan-elements' ),
					'xl' => esc_html__( 'Extra Large', 'gyan-elements' ),
				],
			]
		);

        $this->start_controls_tabs( 'tabs_button_style' );

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label'                 => esc_html__( 'Normal', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'button_bg_color_normal',
            [
                'label'                 => esc_html__( 'Background Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-service-list-button' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_text_color_normal',
            [
                'label'                 => esc_html__( 'Text Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-service-list-button' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .gyan-service-list-button svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'button_border_normal',
				'label'                 => esc_html__( 'Border', 'gyan-elements' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .gyan-service-list-button',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'                 => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .gyan-service-list-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'button_typography',
                'label'                 => esc_html__( 'Typography', 'gyan-elements' ),
                'scheme'                => Scheme_Typography::TYPOGRAPHY_4,
                'selector'              => '{{WRAPPER}} .gyan-service-list-button',
            ]
        );

		$this->add_responsive_control(
			'button_padding',
			[
				'label'                 => esc_html__( 'Padding', 'gyan-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .gyan-service-list-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'button_box_shadow',
				'selector'              => '{{WRAPPER}} .gyan-service-list-button',
			]
		);

        $this->add_control(
            'service_box_button_icon_heading',
            [
                'label'                 => esc_html__( 'Button Icon', 'gyan-elements' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
            ]
        );

		$this->add_responsive_control(
			'button_icon_margin',
			[
				'label'                 => esc_html__( 'Margin', 'gyan-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'placeholder'       => [
					'top'      => '',
					'right'    => '',
					'bottom'   => '',
					'left'     => '',
				],
				'selectors'             => [
					'{{WRAPPER}} .gyan-service-list-button .gyan-button-icon' => 'margin-top: {{TOP}}{{UNIT}}; margin-left: {{LEFT}}{{UNIT}}; margin-right: {{RIGHT}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label'                 => esc_html__( 'Hover', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'button_bg_color_hover',
            [
                'label'                 => esc_html__( 'Background Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-service-list-button:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_text_color_hover',
            [
                'label'                 => esc_html__( 'Text Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-service-list-button:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .gyan-service-list-button:hover svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_border_color_hover',
            [
                'label'                 => esc_html__( 'Border Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-service-list-button:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );

		$this->add_control(
			'button_animation',
			[
				'label'                 => esc_html__( 'Animation', 'gyan-elements' ),
				'type'                  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'button_box_shadow_hover',
				'selector'              => '{{WRAPPER}} .gyan-service-list-button:hover',
			]
		);

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( [
            'service-list' => [
                'class' => [
                    'gyan-service-list-container'
                ]
            ],
            'service-list-items' => [
                'class' => 'gyan-list-items'
            ],
            'list-item' => [
                'class' => 'gyan-service-list-item'
            ],
            'icon' => [
                'class' => 'gyan-service-list-icon'
            ],
            'service-list-button' => [
                'class' => [
                    'gyan-service-list-button',
                    'gyan-ease-transition',
                    'elementor-size-' . $settings['button_size'],
                ]
            ]
		] );

		if ( $settings['connector'] == 'yes' ) {
            $this->add_render_attribute( 'service-list', 'class', 'gyan-service-list-connector' );
			if ( $settings['corner_lines'] == 'yes' ) {
				$this->add_render_attribute( 'service-list', 'class', 'gyan-service-list-corners-hide' );
			}
        }

		if ( $settings['button_animation'] ) {
			$this->add_render_attribute( 'service-list-button', 'class', 'elementor-animation-' . $settings['button_animation'] );
		}

        $i = 1;
        ?>
        <div <?php echo $this->get_render_attribute_string( 'service-list' ); ?>>
            <ul <?php echo $this->get_render_attribute_string( 'service-list-items' ); ?>>
                <?php foreach ( $settings['list_items'] as $index => $item ) : ?>
                    <?php if ( $item['text'] || $item['description'] ) {

                        $item_id = 'elementor-repeater-item-' . $item['_id'];
                        ?>
                        <li <?php echo $this->get_render_attribute_string( 'list-item' ); ?>>
                            <div class="gyan-service-list-item-inner <?php echo $item_id; ?>">
                            <?php
                                $text_key = $this->get_repeater_setting_key( 'text', 'list_items', $index );
                                $this->add_render_attribute( $text_key, 'class', 'gyan-service-list-title' );
                                $this->add_inline_editing_attributes( $text_key, 'none' );

                                $description_key = $this->get_repeater_setting_key( 'description', 'list_items', $index );
                                $this->add_render_attribute( $description_key, 'class', 'gyan-service-list-description' );
                                $this->add_inline_editing_attributes( $description_key, 'basic' );

                                $button_key = $this->get_repeater_setting_key( 'button-wrap', 'list_items', $index );
                                $this->add_render_attribute( $button_key, 'class', 'gyan-service-list-button-wrapper gyan-service-list-button-icon-'.$item['button_icon_position'] );

                                if ( ! empty( $item['link']['url'] ) ) {
                                    $link_key = 'link_' . $i;

                                    $this->add_render_attribute( $link_key, 'href', $item['link']['url'] );

                                    if ( $item['link']['is_external'] ) {
                                        $this->add_render_attribute( $link_key, 'target', '_blank' );
                                    }

                                    if ( $item['link']['nofollow'] ) {
                                        $this->add_render_attribute( $link_key, 'rel', 'nofollow' );
                                    }
                                }
                                if ( $item['gyan_icon_type'] != 'none' ) {
                                    $icon_key = 'icon_' . $i;

                                    $this->add_render_attribute( [
                                        $icon_key => [
                                            'class' => [
                                                'gyan-servicelist-icon-wrapper',
                                                'gyan-ease-transition',
                                            ]
                                        ]
                                    ] );
                                    ?>
                                    <div class="gyan-servicelist-icon-outer">
                                        <div <?php echo $this->get_render_attribute_string( $icon_key ); ?>>

                                            <?php
                                                if ( $item['gyan_icon_type'] == 'icon' ) { ?>
                                                    <span class="gyan-service-list-icon gyan-icon "><?php Icons_Manager::render_icon( $item['list_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
    											<?php
                                                } elseif ( $item['gyan_icon_type'] == 'image' ) {




                                                    if (  $settings['thumbnail_size'] == 'full' ) {
                                                        $imageTagHtml = wp_get_attachment_image( $item['list_image']['id'], 'full', "", ["alt" => esc_attr( Control_Media::get_image_alt( $item['list_image'] ) ) ]);
                                                    } else {
                                                        $imgUrl = Group_Control_Image_Size::get_attachment_image_src( $item['list_image']['id'], 'thumbnail', $settings );
                                                        if ( ! $imgUrl ) {
                                                            $imgUrl = $item['list_image']['url'];
                                                        }
                                                        $imageTagHtml = '<img src="'.esc_url($imgUrl).'" alt="" />';
                                                    }

                                                    echo '<span class="gyan-service-list-image">' . $imageTagHtml . '</span>';

                                                } elseif ( $item['gyan_icon_type'] == 'text' ) {
                                                    printf( '<span class="gyan-service-list-icon gyan-service-list-number">%1$s</span>', esc_attr( $item['icon_text'] ) );
                                                }
                                            ?>
                                        </div>
                                    </div>

                                    <?php
                                }
                            ?>
                            <div class="gyan-servicelist-content-wrapper">
                                <?php if ( ! empty( $item['link']['url'] ) && $item['link_type'] == 'box' ) { ?>
                                    <a <?php echo $this->get_render_attribute_string( $link_key ); ?>>
                                <?php } ?>
                                <<?php echo $settings['title_tag']; ?> <?php echo $this->get_render_attribute_string( $text_key ); ?>>
                                    <?php if ( ! empty( $item['link']['url'] ) && $item['link_type'] == 'title' ) { ?>
                                        <a <?php echo $this->get_render_attribute_string( $link_key ); ?>>
                                    <?php } ?>
                                        <?php if ( '' != $item['title_prefix'] ) { ?><span><?php echo $item['title_prefix']; ?></span><?php } ?><?php echo $item['text']; ?>
                                    <?php if ( ! empty( $item['link']['url'] ) && $item['link_type'] == 'title' ) { ?>
                                        </a>
                                    <?php } ?>
                                </<?php echo $settings['title_tag']; ?>>
                                <?php
                                    printf( '<div %1$s>%2$s</div>', $this->get_render_attribute_string( $description_key ), $item['description'] );
                                ?>
                                <?php if ( ! empty( $item['link']['url'] ) && $item['link_type'] == 'button' ) { ?>
                                    <div <?php echo $this->get_render_attribute_string( $button_key ); ?>>
                                        <a <?php echo $this->get_render_attribute_string( $link_key ); ?>>
                                            <div <?php echo $this->get_render_attribute_string( 'service-list-button' ); ?>>
                                                <?php if ( ! empty( $item['button_icon'] ) ) { ?>
                                                    <span class="gyan-button-icon gyan-icon">
                                                    	<?php Icons_Manager::render_icon( $item['button_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
                                                <?php } ?>
                                                <?php if ( ! empty( $item['button_text'] ) ) { ?>
                                                    <span <?php echo $this->get_render_attribute_string( 'button_text' ); ?>>
                                                        <?php echo esc_attr( $item['button_text'] ); ?>
                                                    </span>
                                                <?php } ?>
                                            </div>
                                        </a>
                                    </div>
                                <?php } ?>
                                <?php
                                if ( ! empty( $item['link']['url'] ) && $item['link_type'] == 'box' ) {
                                    echo '</a>';
                                }
                                ?>
                            </div>
                            </div>
                        </li>
                    <?php } ?>
                <?php $i++; endforeach; ?>
            </ul>
        </div>
        <?php
    }

    protected function _content_template() {}
}