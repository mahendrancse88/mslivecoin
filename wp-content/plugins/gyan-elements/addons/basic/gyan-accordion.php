<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Control_Media;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Gyan_Accordion extends Widget_Base {

	public function get_name()           { return 'gyan_accordion'; }
	public function get_title()          { return esc_html__( 'Accordion', 'gyan-elements' ); }
	public function get_icon()           { return 'gyan-el-icon eicon-accordion'; }
	public function get_categories()     { return ['gyan-basic-addons']; }
	public function get_keywords()       { return ['gyan accordion','toggle','accordion' ]; }
	public function get_style_depends()  { return ['gyan-icon','gyan-accordion']; }
	public function get_script_depends() { return ['gyan-widgets']; }

	protected function register_controls() {

  		$this->start_controls_section(
  			'section_accordion_tabs',
  			[
  				'label'                 => esc_html__( 'Tabs', 'gyan-elements' )
  			]
  		);

        $repeater = new Repeater();

        $repeater->add_control(
            'tab_title',
            [
                'label'                 => esc_html__( 'Title', 'gyan-elements' ),
                'type'                  => Controls_Manager::TEXT,
                'default'               => esc_html__( 'Title Text', 'gyan-elements' ),
                'dynamic'               => [
                    'active'   => true,
                ],
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
        	'title_icon',
        	[
        		'label' => esc_html__( 'Icon', 'elementor' ),
        		'type' => Controls_Manager::ICONS,
        		'fa4compatibility' => 'icon',
        		'default' => [
        			'value' => 'fas fa-star',
        			'library' => 'fa-solid',
        		],
        	]
        );

        $repeater->add_control(
			'content_type',
			[
				'label'                 => esc_html__( 'Content Type', 'gyan-elements' ),
				'type'                  => Controls_Manager::SELECT,
				'label_block'           => false,
                'options'               => [
                    'content'   => esc_html__( 'Content', 'gyan-elements' ),
                    'image'     => esc_html__( 'Image', 'gyan-elements' ),
                    'section'   => esc_html__( 'Saved Section', 'gyan-elements' ),
                    'widget'    => esc_html__( 'Saved Widget', 'gyan-elements' ),
                    'template'  => esc_html__( 'Saved Page Template', 'gyan-elements' ),
                ],
				'default'               => 'content',
			]
		);

        $repeater->add_control(
            'accordion_content',
            [
                'label'                 => esc_html__( 'Content', 'gyan-elements' ),
                'type'                  => Controls_Manager::WYSIWYG,
                'default'               => esc_html__( 'Click to edit sample text of accordion content lacus quam faucibus in aliquam vitae placerat pretium eros. Aliquam et pulvinar odio vitae imperdiet purus amet blandit eros.', 'gyan-elements' ),
                'dynamic'               => [ 'active' => true ],
                'condition'             => [
                    'content_type'	=> 'content',
                ],
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label'                 => esc_html__( 'Image', 'gyan-elements' ),
                'type'                  => Controls_Manager::MEDIA,
                'dynamic'               => [
                    'active'   => true,
                ],
                'default'               => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'conditions'            => [
                    'terms' => [
                        [
                            'name'      => 'content_type',
                            'operator'  => '==',
                            'value'     => 'image',
                        ],
                    ],
                ],
            ]
        );

        $repeater->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'                  => 'image',
                'label'                 => esc_html__( 'Image Size', 'gyan-elements' ),
                'default'               => 'large',
                'exclude'               => [ 'custom' ],
                'conditions'            => [
                    'terms' => [
                        [
                            'name'      => 'content_type',
                            'operator'  => '==',
                            'value'     => 'image',
                        ],
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'saved_widget',
            [
                'label'                 => esc_html__( 'Choose Widget', 'gyan-elements' ),
                'type'                  => Controls_Manager::SELECT,
                'options'               => $this->get_page_template_options( 'widget' ),
				'default'               => '-1',
				'condition'             => [
					'content_type'    => 'widget',
				],
                'conditions'        => [
                    'terms' => [
                        [
                            'name'      => 'content_type',
                            'operator'  => '==',
                            'value'     => 'widget',
                        ],
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'saved_section',
            [
                'label'                 => esc_html__( 'Choose Section', 'gyan-elements' ),
                'type'                  => Controls_Manager::SELECT,
                'options'               => $this->get_page_template_options( 'section' ),
				'default'               => '-1',
                'conditions'        => [
                    'terms' => [
                        [
                            'name'      => 'content_type',
                            'operator'  => '==',
                            'value'     => 'section',
                        ],
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'templates',
            [
                'label'                 => esc_html__( 'Choose Template', 'gyan-elements' ),
                'type'                  => Controls_Manager::SELECT,
                'options'               => $this->get_page_template_options( 'page' ),
				'default'               => '-1',
                'conditions'        => [
                    'terms' => [
                        [
                            'name'      => 'content_type',
                            'operator'  => '==',
                            'value'     => 'template',
                        ],
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'accordion_tab_default_active',
            [
                'label'                 => esc_html__( 'Active as Default', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'no',
                'return_value'          => 'yes',
            ]
        );

  		$this->add_control(
			'tabs',
			[
				'type'                  => Controls_Manager::REPEATER,
                'fields'                => $repeater->get_controls(),
				'default'               => [
					[ 'tab_title' => esc_html__( 'Title One', 'gyan-elements' ) ],
					[ 'tab_title' => esc_html__( 'Title Two', 'gyan-elements' ) ],
					[ 'tab_title' => esc_html__( 'Title Three', 'gyan-elements' ) ],
				],
				'title_field'           => '{{tab_title}}',
			]
		);

  		$this->end_controls_section();

  		$this->start_controls_section(
  			'section_accordion_toggle_icon',
  			[
  				'label'                 => esc_html__( 'Toggle Icon', 'gyan-elements' )
  			]
  		);

		$this->add_control(
			'toggle_icon_show',
			[
				'label'                 => esc_html__( 'Toggle Icon', 'gyan-elements' ),
				'type'                  => Controls_Manager::SWITCHER,
				'default'               => 'yes',
                'label_on'              => esc_html__( 'Show', 'gyan-elements' ),
                'label_off'             => esc_html__( 'Hide', 'gyan-elements' ),
				'return_value'          => 'yes',
			]
		);


		$this->add_control(
			'toggle_icon_normal',
			[
				'label' => esc_html__( 'Normal Icon', 'elementor' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-plus',
					'library' => 'fa-solid',
				],
				'condition'             => [
					'toggle_icon_show' => 'yes'
				]
			]
		);

		$this->add_control(
			'toggle_icon_active',
			[
				'label' => esc_html__( 'Icon', 'elementor' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-minus',
					'library' => 'fa-solid',
				],
				'condition'             => [
					'toggle_icon_show' => 'yes'
				]
			]
		);

  		$this->end_controls_section();

  		$this->start_controls_section(
  			'section_accordion_settings',
  			[
  				'label'                 => esc_html__( 'Settings', 'gyan-elements' )
  			]
  		);

  		$this->add_control(
		  'accordion_type',
		  	[
                'label'                 => esc_html__( 'Accordion Type', 'gyan-elements' ),
		     	'type'                  => Controls_Manager::SELECT,
		     	'default'               => 'accordion',
		     	'label_block'           => false,
		     	'options'               => [
		     		'accordion' 	=> esc_html__( 'Accordion', 'gyan-elements' ),
		     		'toggle' 		=> esc_html__( 'Toggle', 'gyan-elements' ),
		     	],
				'frontend_available'    => true,
		  	]
		);

		$this->add_control(
			'toggle_speed',
			[
				'label'                 => esc_html__( 'Toggle Speed (ms)', 'gyan-elements' ),
				'type'                  => Controls_Manager::NUMBER,
				'label_block'           => false,
				'default'               => 300,
				'frontend_available'    => true,
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_accordion_items_style',
			[
				'label'                 => esc_html__( 'Items', 'gyan-elements' ),
				'tab'                   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'accordion_item_style' );

			$this->start_controls_tab(
				'accordion_item_normal',
				[
					'label'                 => esc_html__( 'Normal', 'gyan-elements' ),
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'                  => 'accordion_items_border',
					'label'                 => esc_html__( 'Border', 'gyan-elements' ),
					'selector'              => '{{WRAPPER}} .gyan-accordion-item',
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'accordion_item_active',
				[
					'label'                 => esc_html__( 'Active', 'gyan-elements' ),
				]
			);

			$this->add_control(
				'accordion_items_active_border',
				[
					'label'                 => esc_html__( 'Border Color', 'gyan-elements' ),
					'type'                  => Controls_Manager::COLOR,
					'default'               => '',
					'selectors'             => [
						'{{WRAPPER}} .gyan-accordion .gyan-accordion-item.gyan-accordion-item-active' => 'border-color: {{VALUE}};',
					],
				]
			);


			$this->end_controls_tab();

		$this->end_controls_tabs();

        $this->add_responsive_control(
            'accordion_items_spacing',
            [
                'label'                 => esc_html__( 'Spacing', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'separator'             => 'before',
                'range'                 => [
                    'px' 	=> [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'default'               => [
                    'size' 	=> '',
                ],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-accordion-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

		$this->add_responsive_control(
			'accordion_items_border_radius',
			[
				'label'                 => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'selectors'             => [
	 					'{{WRAPPER}} .gyan-accordion-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);

		$this->add_responsive_control(
			'accordion_items_padding',
			[
				'label'                 => esc_html__( 'Padding', 'gyan-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'selectors'             => [
	 					'{{WRAPPER}} .gyan-accordion-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'accordion_items_box_shadow',
				'selector'              => '{{WRAPPER}} .gyan-accordion-item',
			]
		);

  		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_style',
			[
				'label'                 => esc_html__( 'Title', 'gyan-elements' ),
				'tab'                   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'accordion_tabs_style' );

		$this->start_controls_tab(
			'accordion_tab_normal',
			[
				'label' => esc_html__( 'Normal', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'tab_title_text_color',
			[
				'label'                 => esc_html__( 'Color', 'gyan-elements' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '#333333',
				'selectors'             => [
					'{{WRAPPER}} .gyan-accordion .gyan-accordion-tab-title,
					{{WRAPPER}} .gyan-accordion .gyan-accordion-tab-title .gyan-accordion-tab-icon.gyan-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .gyan-accordion .gyan-accordion-tab-title .gyan-accordion-tab-icon.gyan-icon svg' => 'fill: {{VALUE}};',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'tab_title_bg_color',
				'label' => esc_html__( 'Background Color', 'gyan-elements' ),
				'types'    => [ 'none','classic','gradient' ],
				'selector' => '{{WRAPPER}} .gyan-accordion .gyan-accordion-tab-title',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
            	'name'                  => 'tab_title_typography',
				'selector'              => '{{WRAPPER}} .gyan-accordion .gyan-accordion-tab-title',
			]
		);

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'                  => 'tab_title_border',
                'label'                 => esc_html__( 'Border', 'gyan-elements' ),
                'selector'              => '{{WRAPPER}} .gyan-accordion .gyan-accordion-tab-title',
            ]
        );

    	$this->add_responsive_control(
    		'tab_title_border_radius',
    		[
    			'label'                 => esc_html__( 'Border Radius', 'gyan-elements' ),
    			'type'                  => Controls_Manager::DIMENSIONS,
    			'size_units'            => [ 'px', 'em', '%' ],
    			'selectors'             => [
     					'{{WRAPPER}} .gyan-accordion .gyan-accordion-tab-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
     			],
    		]
    	);

		$this->add_responsive_control(
			'tab_title_padding',
			[
				'label'                 => esc_html__( 'Padding', 'gyan-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'selectors'             => [
	 					'{{WRAPPER}} .gyan-accordion .gyan-accordion-tab-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);

        $this->end_controls_tab();

		$this->start_controls_tab(
			'accordion_tab_hover',
			[
				'label'                 => esc_html__( 'Hover', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'tab_title_text_color_hover',
			[
				'label'                 => esc_html__( 'Color', 'gyan-elements' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .gyan-accordion .gyan-accordion-tab-title:hover,
					{{WRAPPER}} .gyan-accordion .gyan-accordion-tab-title:hover .gyan-accordion-tab-icon.gyan-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .gyan-accordion .gyan-accordion-tab-title:hover .gyan-accordion-tab-icon.gyan-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'tab_title_bg_color_hover',
				'label' => esc_html__( 'Background Color', 'gyan-elements' ),
				'types'    => [ 'none','classic','gradient' ],
				'selector' => '{{WRAPPER}} .gyan-accordion .gyan-accordion-tab-title:hover',
			]
		);

		$this->add_control(
			'tab_title_border_color_hover',
			[
				'label'                 => esc_html__( 'Border Color', 'gyan-elements' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .gyan-accordion .gyan-accordion-tab-title:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

        $this->end_controls_tab();

		$this->start_controls_tab(
			'accordion_tab_active',
			[
				'label'                 => esc_html__( 'Active', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'tab_title_text_color_active',
			[
				'label'                 => esc_html__( 'Color', 'gyan-elements' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .gyan-accordion .gyan-accordion-tab-title.gyan-accordion-tab-active,
					{{WRAPPER}} .gyan-accordion .gyan-accordion-tab-title.gyan-accordion-tab-active .gyan-accordion-tab-icon.gyan-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .gyan-accordion .gyan-accordion-tab-title.gyan-accordion-tab-active .gyan-accordion-tab-icon.gyan-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'tab_title_bg_color_active',
				'label' => esc_html__( 'Background Color', 'gyan-elements' ),
				'types'    => [ 'none','classic','gradient' ],
				'selector' => '{{WRAPPER}} .gyan-accordion .gyan-accordion-tab-title.gyan-accordion-tab-active',
			]
		);

		$this->add_control(
			'tab_title_border_color_active',
			[
				'label'                 => esc_html__( 'Border Color', 'gyan-elements' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .gyan-accordion .gyan-accordion-tab-title.gyan-accordion-tab-active' => 'border-color: {{VALUE}};',
				],
			]
		);

        $this->end_controls_tab();

        $this->end_controls_tabs();



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
                    '{{WRAPPER}} span.gyan-accordion-title-prefix-text' => 'color: {{VALUE}};',
                ],
                'scheme'                => [
                    'type'     => Scheme_Color::get_type(),
                    'value'    => Scheme_Color::COLOR_2,
                ],
            ]
        );

        $this->add_responsive_control(
            'title_prefix_spacing',
            [
                'label'                 => esc_html__( 'Spacing', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [
                    'size' => 5,
                ],
                'range'                 => [
                    'px' => [
                        'max' => 150,
                    ],
                ],
                'selectors'             => [
                    '{{WRAPPER}} span.gyan-accordion-title-prefix-text ' => 'margin-right: {{SIZE}}{{UNIT}};'
                ],
            ]
        );



		$this->add_control(
			'tab_icon_heading',
			[
				'label'                 => esc_html__( 'Icon', 'gyan-elements' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
			]
		);

		$this->add_responsive_control(
			'tab_icon_size',
			[
				'label'                 => esc_html__( 'Icon Size', 'gyan-elements' ),
				'type'                  => Controls_Manager::SLIDER,
				'default'               => [
					'size'	=> 16,
					'unit'	=> 'px',
				],
				'size_units'            => [ 'px' ],
				'range'                 => [
					'px'		=> [
						'min'	=> 0,
						'max'	=> 100,
						'step'	=> 1,
					]
				],
				'selectors'             => [
					'{{WRAPPER}} .gyan-accordion .gyan-accordion-tab-title .gyan-accordion-tab-icon.gyan-icon ' => 'font-size: {{SIZE}}{{UNIT}};',
				]
			]
		);
		$this->add_responsive_control(
			'tab_icon_spacing',
			[
				'label'                 => esc_html__( 'Icon Spacing', 'gyan-elements' ),
				'type'                  => Controls_Manager::SLIDER,
				'default'               => [
					'size'	=> 10,
					'unit'	=> 'px',
				],
				'size_units'            => [ 'px' ],
				'range'                 => [
					'px'	=> [
						'min'	=> 0,
						'max'	=> 100,
						'step'	=> 1,
					]
				],
				'selectors'             => [
					'{{WRAPPER}} .gyan-accordion .gyan-accordion-tab-title .gyan-accordion-tab-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_content_style',
			[
				'label'                 => esc_html__( 'Content', 'gyan-elements' ),
				'tab'                   => Controls_Manager::TAB_STYLE,
			]
		);



		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'tab_content_bg_color',
				'label' => esc_html__( 'Background Color', 'gyan-elements' ),
				'types'    => [ 'none','classic','gradient' ],
				'selector' => '{{WRAPPER}} .gyan-accordion .gyan-accordion-item .gyan-accordion-tab-content',
			]
		);

		$this->add_control(
			'tab_content_text_color',
			[
				'label'                 => esc_html__( 'Text Color', 'gyan-elements' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '#676767',
				'selectors'             => [
					'{{WRAPPER}} .gyan-accordion .gyan-accordion-item .gyan-accordion-tab-content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
            	'name'                  => 'tab_content_typography',
				'selector'              => '{{WRAPPER}} .gyan-accordion .gyan-accordion-item .gyan-accordion-tab-content',
			]
		);

		$this->add_responsive_control(
			'tab_content_border_radius',
			[
				'label'                 => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'selectors'             => [
	 					'{{WRAPPER}} .gyan-accordion .gyan-accordion-item .gyan-accordion-tab-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);

		$this->add_responsive_control(
			'tab_content_padding',
			[
				'label'                 => esc_html__( 'Padding', 'gyan-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'selectors'             => [
	 					'{{WRAPPER}} .gyan-accordion .gyan-accordion-item .gyan-accordion-tab-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);

		$this->add_responsive_control(
			'tab_content_margin',
			[
				'label'                 => esc_html__( 'Margin', 'gyan-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'selectors'             => [
	 					'{{WRAPPER}} .gyan-accordion .gyan-accordion-item .gyan-accordion-tab-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);

  		$this->end_controls_section();

  		$this->start_controls_section(
  			'section_toggle_icon_style',
  			[
  				'label'                 => esc_html__( 'Toggle icon', 'gyan-elements' ),
  				'tab'                   => Controls_Manager::TAB_STYLE,
				'condition'	=> [
					'toggle_icon_show' => 'yes'
				]
  			]
  		);

		$this->add_control(
			'toggle_icon_color',
			[
				'label'                 => esc_html__( 'Color', 'gyan-elements' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '#444',
				'selectors'	=> [
					'{{WRAPPER}} .gyan-accordion .gyan-accordion-tab-title .gyan-accordion-toggle-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .gyan-accordion .gyan-accordion-tab-title .gyan-accordion-toggle-icon.gyan-icon svg' => 'fill: {{VALUE}};',
				],
				'condition'	=> [
					'toggle_icon_show' => 'yes'
				]
			]
		);

		$this->add_control(
			'toggle_icon_hover_color',
			[
				'label'                 => esc_html__( 'Hover Color', 'gyan-elements' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'	=> [
					'{{WRAPPER}} .gyan-accordion .gyan-accordion-item:hover .gyan-accordion-tab-title .gyan-accordion-toggle-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .gyan-accordion .gyan-accordion-item:hover .gyan-accordion-tab-title .gyan-accordion-toggle-icon.gyan-icon svg' => 'fill: {{VALUE}};',
				],
				'condition'             => [
					'toggle_icon_show' => 'yes'
				]
			]
		);

		$this->add_control(
			'toggle_icon_active_color',
			[
				'label'                 => esc_html__( 'Active Color', 'gyan-elements' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'	=> [
					'{{WRAPPER}} .gyan-accordion .gyan-accordion-tab-title.gyan-accordion-tab-active .gyan-accordion-toggle-icon,
					 {{WRAPPER}} .gyan-accordion .gyan-accordion-item:hover .gyan-accordion-tab-title.gyan-accordion-tab-active .gyan-accordion-toggle-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .gyan-accordion .gyan-accordion-tab-title.gyan-accordion-tab-active .gyan-accordion-toggle-icon.gyan-icon svg,
					 {{WRAPPER}} .gyan-accordion .gyan-accordion-item:hover .gyan-accordion-tab-title.gyan-accordion-tab-active .gyan-accordion-toggle-icon.gyan-icon svg' => 'fill: {{VALUE}};',
				],
				'condition'             => [
					'toggle_icon_show' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'toggle_icon_size',
			[
				'label'                 => esc_html__( 'Size', 'gyan-elements' ),
				'type'                  => Controls_Manager::SLIDER,
				'default'               => [
					'size'	=> 16,
					'unit'	=> 'px',
				],
				'size_units'            => [ 'px' ],
				'range'	=> [
					'px'	=> [
						'min'	=> 0,
						'max'	=> 100,
						'step'	=> 1,
					]
				],
				'selectors'             => [
					'{{WRAPPER}} .gyan-accordion .gyan-accordion-tab-title .gyan-accordion-toggle-icon' => 'font-size: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
				],
				'condition'             => [
					'toggle_icon_show' => 'yes'
				]
			]
		);

  		$this->end_controls_section();
	}

	protected function render() {

		$settings	= $this->get_settings_for_display();
		$id_int		= substr( $this->get_id_int(), 0, 3 );

		$this->add_render_attribute( 'accordion', [
            'class'                 => 'gyan-accordion',
            'id'                    => 'gyan-accordion-'.esc_attr( $this->get_id() ),
            'data-accordion-id'     => esc_attr( $this->get_id() )
        ] );
        ?>
        <div <?php echo $this->get_render_attribute_string('accordion'); ?>>
            <?php
                foreach( $settings['tabs'] as $index => $tab ) {

                    $tab_count = $index+1;
                    $tab_title_setting_key = $this->get_repeater_setting_key('tab_title', 'tabs', $index);
                    $tab_content_setting_key = $this->get_repeater_setting_key('accordion_content', 'tabs', $index);

                    $tab_title_class 	= ['gyan-accordion-tab-title'];
                    $tab_content_class 	= ['gyan-accordion-tab-content'];

                    if ( $tab['accordion_tab_default_active'] == 'yes' ) {
                        $tab_title_class[] 		= 'gyan-accordion-tab-active-default';
                        $tab_content_class[] 	= 'gyan-accordion-tab-active-default';
                    }

                    $this->add_render_attribute( $tab_title_setting_key, [
                        'id'                => 'gyan-accordion-tab-title-' . $id_int . $tab_count,
                        'class'             => $tab_title_class,
                        'tabindex'          => $id_int . $tab_count,
                        'data-tab'          => $tab_count,
                        'role'              => 'tab',
                        'aria-controls'     => 'gyan-accordion-tab-content-' . $id_int . $tab_count,
                    ]);

                    $this->add_render_attribute( $tab_content_setting_key, [
                        'id'                => 'gyan-accordion-tab-content-' . $id_int . $tab_count,
                        'class'             => $tab_content_class,
                        'data-tab'          => $tab_count,
                        'role'              => 'tabpanel',
                        'aria-labelledby'   => 'gyan-accordion-tab-title-' . $id_int . $tab_count,
                    ] );

                    if ( $tab['content_type'] == 'content' ) {
                        $this->add_inline_editing_attributes( $tab_content_setting_key, 'advanced' );
                    }
            ?>
            <div class="gyan-accordion-item">

                <div <?php echo $this->get_render_attribute_string($tab_title_setting_key); ?>>
                    <span class="gyan-accordion-title-icon">
                        <?php
                        ob_start();
						Icons_Manager::render_icon( $tab['title_icon'], [ 'aria-hidden' => 'true' ] );
						$title_section_icon = ob_get_clean();

                        if ( '' != $title_section_icon ) { ?>
                            <span class="gyan-accordion-tab-icon gyan-icon">
                           		<?php echo $title_section_icon; ?>
                            </span>
                        <?php } ?><?php if ( '' != $tab['title_prefix'] ) { ?><span class="gyan-accordion-title-prefix-text"><?php echo $tab['title_prefix']; ?></span><?php } ?><span class="gyan-accordion-title-text">
                            <?php echo $tab['tab_title']; ?>
                        </span>
                    </span>
                    <?php if ( $settings['toggle_icon_show'] === 'yes' ) { ?>
                        <div class="gyan-accordion-toggle-icon">
                            <?php if ( $settings['toggle_icon_normal'] ) { ?>
                                <span class="gyan-accordion-toggle-icon gyan-accordion-toggle-icon-close gyan-icon"><?php Icons_Manager::render_icon( $settings['toggle_icon_normal'], [ 'aria-hidden' => 'true' ] ); ?></span>
                            <?php } ?>
                            <?php if ( $settings['toggle_icon_active'] ) { ?>
                                <span class="gyan-accordion-toggle-icon gyan-accordion-toggle-icon-open gyan-icon"><?php Icons_Manager::render_icon( $settings['toggle_icon_active'], [ 'aria-hidden' => 'true' ] ); ?></span>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>

                <div <?php echo $this->get_render_attribute_string($tab_content_setting_key); ?>>
                    <?php
                        if ( $tab['content_type'] == 'content' ) {

                            echo do_shortcode( $tab['accordion_content'] );

                        } elseif ( $tab['content_type'] == 'image' && $tab['image']['url'] ) {

                            if (  $tab['image_size'] == 'full' ) {
                                $imgUrl = Group_Control_Image_Size::get_attachment_image_src( $tab['image']['id'], 'full', $tab );
                                $imgSrcset = ' srcset="'. wp_get_attachment_image_srcset($tab['image']['id']) . '"';
                                $imgSizes = ' sizes="'.wp_get_attachment_image_sizes($tab['image']['id'], "full") . '"';
                            } else {
                                $imgUrl = Group_Control_Image_Size::get_attachment_image_src( $tab['image']['id'], 'image', $tab );
                                $imgSrcset = '';
                                $imgSizes = '';
                            }

                            if ( ! $imgUrl ) {
                                $imgUrl = $tab['image']['url'];
                            }

                            $image_html = '<div class="gyan-showcase-preview-image">';

                            $image_html .= '<img src="' . $imgUrl . '" ' . $imgSizes . $imgSrcset . ' alt="' . esc_attr( Control_Media::get_image_alt( $tab['image'] ) ) . '">';

                            $image_html .= '</div>';

                            echo $image_html;

                        } elseif ( $tab['content_type'] == 'section' && !empty( $tab['saved_section'] ) ) {

                            echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $tab['saved_section'] );

                        } elseif ( $tab['content_type'] == 'template' && !empty( $tab['templates'] ) ) {

                            echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $tab['templates'] );

                        } elseif ( $tab['content_type'] == 'widget' && !empty( $tab['saved_widget'] ) ) {

                            echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $tab['saved_widget'] );

                        }
                    ?>
                </div>

            </div>
            <?php } ?>
        </div>
	<?php
	}

	public function get_page_template_options( $type = '' ) {

		$page_templates = gyan_get_page_templates( $type );

		$options[-1]   = esc_html__( 'Select', 'gyan-elements' );

		if ( count( $page_templates ) ) {
			foreach ( $page_templates as $id => $name ) {
				$options[ $id ] = $name;
			}
		} else {
			$options['no_template'] = esc_html__( 'No saved templates found!', 'gyan-elements' );
		}

		return $options;
	}

	protected function _content_template() {  }
}