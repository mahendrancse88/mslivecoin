<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Control_Media;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) {exit; }

class Gyan_Icon_List extends Widget_Base {

	public function get_name()           { return 'gyan_icon_list'; }
	public function get_title()          { return esc_html__( 'Icon List', 'gyan-elements' ); }
	public function get_icon()           { return 'gyan-el-icon eicon-bullet-list'; }
	public function get_categories()     { return ['gyan-basic-addons']; }
	public function get_keywords()       { return [ 'gyan icon list', 'list', 'icon','image list' ]; }
	public function get_style_depends()  { return ['gyan-icon','gyan-icon-list']; }

    protected function register_controls() {

        $this->start_controls_section(
            'section_list',
            [
                'label'                 => esc_html__( 'List', 'gyan-elements' ),
            ]
        );

		$this->add_control(
			'view',
			[
				'label'                 => esc_html__( 'Layout', 'gyan-elements' ),
				'type'                  => Controls_Manager::CHOOSE,
				'default'               => 'traditional',
				'options'               => [
					'traditional'  => [
						'title'    => esc_html__( 'Default', 'gyan-elements' ),
						'icon'     => 'eicon-editor-list-ul',
					],
					'inline'       => [
						'title'    => esc_html__( 'Inline', 'gyan-elements' ),
						'icon'     => 'eicon-ellipsis-h',
					],
				],
				'render_type'           => 'template',
				'prefix_class'          => 'gyan-icon-list-',
				'label_block'           => false,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'text',
			[
				'label'       => esc_html__( 'Text', 'gyan-elements' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active'  => true,
                ],
                'default'     => esc_html__('List Item #1','gyan-elements')
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
                        'icon'  => 'fa fa-star',
                    ],
                    'image' => [
                        'title' => esc_html__( 'Image', 'gyan-elements' ),
                        'icon'  => 'fa fa-picture-o',
                    ],
                    'number' => [
                        'title' => esc_html__( 'Number', 'gyan-elements' ),
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
		        'condition'     => [
                    'gyan_icon_type' => 'icon',
                ],
			]
		);

		$repeater->add_control(
			'list_image',
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
                    'gyan_icon_type' => 'image',
                ],
			]
		);

		$repeater->add_control(
			'link',
			[
				'label'       => esc_html__( 'Link', 'gyan-elements' ),
				'type'        => Controls_Manager::URL,
				'label_block' => true,
                'dynamic'     => [
                    'active'  => true,
                ],
				'placeholder' => esc_html__( 'http://your-link.com', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'list_items',
			[
				'label' => esc_html__( 'List Items', 'gyan-elements' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'text'      => esc_html__( 'List Item #1', 'gyan-elements' ),
                        'list_icon' => esc_html__('fa fa-check','gyan-elements')
					],
                    [
						'text'      => esc_html__( 'List Item #2', 'gyan-elements' ),
                        'list_icon' => esc_html__('fa fa-check','gyan-elements')
					],
				],
				'title_field' => '<i class="{{ list_icon }}" aria-hidden="true"></i> {{{ text }}}',
			]
		);


		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'                  => 'image',
                'label'                 => esc_html__( 'Image Size', 'gyan-elements' ),
                'default'               => 'full',
				'separator'             => 'before',
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

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'                  => 'items_background',
                'label'                 => esc_html__( 'Background', 'gyan-elements' ),
                'types'                 => [ 'classic','gradient' ],
                'selector'              => '{{WRAPPER}} .gyan-ilist-items li',
            ]
        );

        if ( is_rtl() ) {

			$this->add_control(
				'items_spacing',
				[
					'label'                 => esc_html__( 'List Items Gap', 'gyan-elements' ),
					'type'                  => Controls_Manager::SLIDER,
					'range'                 => [
						'px' => [
							'max' => 50,
						],
					],
					'separator'             => 'before',
					'selectors'             => [
						'{{WRAPPER}} .gyan-ilist-items:not(.gyan-inline-items) li:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .gyan-ilist-items.gyan-inline-items li:not(:last-child)' => 'margin-left: {{SIZE}}{{UNIT}};',
					],
				]
			);

		} else {

			$this->add_control(
				'items_spacing',
				[
					'label'                 => esc_html__( 'List Items Gap', 'gyan-elements' ),
					'type'                  => Controls_Manager::SLIDER,
					'range'                 => [
						'px' => [
							'max' => 50,
						],
					],
					'separator'             => 'before',
					'selectors'             => [
						'{{WRAPPER}} .gyan-ilist-items:not(.gyan-inline-items) li:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .gyan-ilist-items.gyan-inline-items li:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
					],
				]
			);

		}

		$this->add_responsive_control(
			'list_items_padding',
			[
				'label'                 => esc_html__( 'Padding', 'gyan-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .gyan-ilist-items li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'list_items_alignment',
			[
				'label'                 => esc_html__( 'Alignment', 'gyan-elements' ),
				'type'                  => Controls_Manager::CHOOSE,
				'options'               => [
					'left'      => [
						'title' => esc_html__( 'Left', 'gyan-elements' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center'    => [
						'title' => esc_html__( 'Center', 'gyan-elements' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'     => [
						'title' => esc_html__( 'Right', 'gyan-elements' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}}.gyan-icon-list-traditional .gyan-ilist-items li, {{WRAPPER}}.gyan-icon-list-inline .gyan-ilist-items' => 'justify-content: {{VALUE}};',
				],
				'selectors_dictionary' => [
					'left' => 'flex-start',
					'right' => 'flex-end',
				],
			]
		);

		$this->add_control(
			'item_middle',
			[
				'label'                 => esc_html__( 'Item Center', 'gyan-elements' ),
				'type'                  => Controls_Manager::SWITCHER,
				'label_off'             => esc_html__( 'Off', 'gyan-elements' ),
				'label_on'              => esc_html__( 'On', 'gyan-elements' ),
				'prefix_class'          => 'gyan-icon-center-',
			]
		);

		$this->add_control(
			'divider',
			[
				'label'                 => esc_html__( 'Divider', 'gyan-elements' ),
				'type'                  => Controls_Manager::SWITCHER,
				'label_off'             => esc_html__( 'Off', 'gyan-elements' ),
				'label_on'              => esc_html__( 'On', 'gyan-elements' ),
				'separator'             => 'before',
			]
		);

		if ( is_rtl() ) {

			$this->add_control(
				'divider_style',
				[
					'label'                 => esc_html__( 'Style', 'gyan-elements' ),
					'type'                  => Controls_Manager::SELECT,
					'options'               => [
						'solid'    => esc_html__( 'Solid', 'gyan-elements' ),
						'double'   => esc_html__( 'Double', 'gyan-elements' ),
						'dotted'   => esc_html__( 'Dotted', 'gyan-elements' ),
						'dashed'   => esc_html__( 'Dashed', 'gyan-elements' ),
						'groove'   => esc_html__( 'Groove', 'gyan-elements' ),
						'ridge'    => esc_html__( 'Ridge', 'gyan-elements' ),
					],
					'default'               => 'solid',
					'condition'             => [
						'divider' => 'yes',
					],
					'selectors'             => [
						'{{WRAPPER}} .gyan-ilist-items:not(.gyan-inline-items) li:not(:last-child)' => 'border-bottom-style: {{VALUE}};',
						'{{WRAPPER}} .gyan-ilist-items.gyan-inline-items li:not(:last-child)' => 'border-left-style: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'divider_weight',
				[
					'label'                 => esc_html__( 'Weight', 'gyan-elements' ),
					'type'                  => Controls_Manager::SLIDER,
					'default'               => [
						'size' => 1,
					],
					'range'                 => [
						'px'   => [
							'min' => 1,
							'max' => 10,
						],
					],
					'condition'             => [
						'divider' => 'yes',
					],
					'selectors'             => [
						'{{WRAPPER}} .gyan-ilist-items:not(.gyan-inline-items) li:not(:last-child)' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .gyan-ilist-items.gyan-inline-items li:not(:last-child)' => 'border-left-width: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'divider_color',
				[
					'label'                 => esc_html__( 'Color', 'gyan-elements' ),
					'type'                  => Controls_Manager::COLOR,
					'default'               => '#ddd',
					'scheme'                => [
						'type'     => Scheme_Color::get_type(),
						'value'    => Scheme_Color::COLOR_3,
					],
					'condition'             => [
						'divider'  => 'yes',
					],
					'selectors'             => [
						'{{WRAPPER}} .gyan-ilist-items:not(.gyan-inline-items) li:not(:last-child)' => 'border-bottom-color: {{VALUE}};',
						'{{WRAPPER}} .gyan-ilist-items.gyan-inline-items li:not(:last-child)' => 'border-left-color: {{VALUE}};',
					],
				]
			);

		} else {

			$this->add_control(
				'divider_style',
				[
					'label'                 => esc_html__( 'Style', 'gyan-elements' ),
					'type'                  => Controls_Manager::SELECT,
					'options'               => [
						'solid'    => esc_html__( 'Solid', 'gyan-elements' ),
						'double'   => esc_html__( 'Double', 'gyan-elements' ),
						'dotted'   => esc_html__( 'Dotted', 'gyan-elements' ),
						'dashed'   => esc_html__( 'Dashed', 'gyan-elements' ),
						'groove'   => esc_html__( 'Groove', 'gyan-elements' ),
						'ridge'    => esc_html__( 'Ridge', 'gyan-elements' ),
					],
					'default'               => 'solid',
					'condition'             => [
						'divider' => 'yes',
					],
					'selectors'             => [
						'{{WRAPPER}} .gyan-ilist-items:not(.gyan-inline-items) li:not(:last-child)' => 'border-bottom-style: {{VALUE}};',
						'{{WRAPPER}} .gyan-ilist-items.gyan-inline-items li:not(:last-child)' => 'border-right-style: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'divider_weight',
				[
					'label'                 => esc_html__( 'Weight', 'gyan-elements' ),
					'type'                  => Controls_Manager::SLIDER,
					'default'               => [
						'size' => 1,
					],
					'range'                 => [
						'px'   => [
							'min' => 1,
							'max' => 10,
						],
					],
					'condition'             => [
						'divider' => 'yes',
					],
					'selectors'             => [
						'{{WRAPPER}} .gyan-ilist-items:not(.gyan-inline-items) li:not(:last-child)' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .gyan-ilist-items.gyan-inline-items li:not(:last-child)' => 'border-right-width: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'divider_color',
				[
					'label'                 => esc_html__( 'Color', 'gyan-elements' ),
					'type'                  => Controls_Manager::COLOR,
					'default'               => '#ddd',
					'scheme'                => [
						'type'     => Scheme_Color::get_type(),
						'value'    => Scheme_Color::COLOR_3,
					],
					'condition'             => [
						'divider'  => 'yes',
					],
					'selectors'             => [
						'{{WRAPPER}} .gyan-ilist-items:not(.gyan-inline-items) li:not(:last-child)' => 'border-bottom-color: {{VALUE}};',
						'{{WRAPPER}} .gyan-ilist-items.gyan-inline-items li:not(:last-child)' => 'border-right-color: {{VALUE}};',
					],
				]
			);

		}


        $this->end_controls_section();

        $this->start_controls_section(
            'section_icon_style',
            [
                'label'                 => esc_html__( 'Icon', 'gyan-elements' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
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
                    'right'     => [
                        'title' => esc_html__( 'Right', 'gyan-elements' ),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
				'prefix_class'          => 'gyan-icon-',
			]
		);

        $this->add_control(
			'icon_vertical_align',
			[
				'label'                 => esc_html__( 'Vertical Alignment', 'gyan-elements' ),
				'type'                  => Controls_Manager::CHOOSE,
                'label_block'           => false,
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
				'selectors'             => [
					'{{WRAPPER}} .gyan-icon-list-wrap .gyan-ilist-items li'   => 'align-items: {{VALUE}};',
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
				'label'                 => esc_html__( 'Color', 'gyan-elements' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '#d83030',
				'selectors'             => [
					'{{WRAPPER}} .gyan-ilist-items .gyan-icon-list-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .gyan-ilist-items .gyan-icon-list-icon svg' => 'fill: {{VALUE}};',
				],
				'scheme'                => [
					'type'     => Scheme_Color::get_type(),
					'value'    => Scheme_Color::COLOR_2,
				],
			]
		);

		$this->add_control(
			'icon_bg_color',
			[
				'label'                 => esc_html__( 'Background Color', 'gyan-elements' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .gyan-ilist-items .gyan-icon-wrapper' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
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
						'max' => 100,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .gyan-ilist-items .gyan-icon-list-icon' => 'font-size: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .gyan-ilist-items .gyan-icon-list-image img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		if ( is_rtl() ) {

			$this->add_control(
				'icon_spacing',
				[
					'label'                 => esc_html__( 'Spacing', 'gyan-elements' ),
					'type'                  => Controls_Manager::SLIDER,
					'default'               => [
						'size' => 8,
					],
					'range'                 => [
						'px' => [
							'max' => 50,
						],
					],
					'selectors'             => [
						'{{WRAPPER}}.gyan-icon-left .gyan-ilist-items .gyan-icon-wrapper' => 'margin-left: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}}.gyan-icon-right .gyan-ilist-items .gyan-icon-wrapper' => 'margin-right: {{SIZE}}{{UNIT}};',
					],
				]
			);

		} else {

			$this->add_control(
				'icon_spacing',
				[
					'label'                 => esc_html__( 'Spacing', 'gyan-elements' ),
					'type'                  => Controls_Manager::SLIDER,
					'default'               => [
						'size' => 8,
					],
					'range'                 => [
						'px' => [
							'max' => 50,
						],
					],
					'selectors'             => [
						'{{WRAPPER}}.gyan-icon-left .gyan-ilist-items .gyan-icon-wrapper' => 'margin-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}}.gyan-icon-right .gyan-ilist-items .gyan-icon-wrapper' => 'margin-left: {{SIZE}}{{UNIT}};',
					],
				]
			);

		}

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'icon_border',
				'label'                 => esc_html__( 'Border', 'gyan-elements' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .gyan-ilist-items .gyan-icon-wrapper',
			]
		);

		$this->add_control(
			'icon_border_radius',
			[
				'label'                 => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .gyan-ilist-items .gyan-icon-wrapper, {{WRAPPER}} .gyan-ilist-items .gyan-icon-list-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_padding',
			[
				'label'                 => esc_html__( 'Padding', 'gyan-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .gyan-ilist-items .gyan-icon-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
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
				'label'                 => esc_html__( 'Color', 'gyan-elements' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .gyan-ilist-items .gyan-icon-wrapper:hover .gyan-icon-list-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .gyan-ilist-items .gyan-icon-wrapper:hover .gyan-icon-list-icon svg' => 'fill: {{VALUE}};',
				],
				'scheme'                => [
					'type'     => Scheme_Color::get_type(),
					'value'    => Scheme_Color::COLOR_2,
				],
			]
		);

		$this->add_control(
			'icon_bg_color_hover',
			[
				'label'                 => esc_html__( 'Background Color', 'gyan-elements' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .gyan-ilist-items .gyan-icon-wrapper:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_border_color_hover',
			[
				'label'                 => esc_html__( 'Border Color', 'gyan-elements' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .gyan-ilist-items .gyan-icon-wrapper:hover' => 'border-color: {{VALUE}};',
				],
				'scheme'                => [
					'type'     => Scheme_Color::get_type(),
					'value'    => Scheme_Color::COLOR_2,
				],
			]
		);

		$this->add_control(
			'icon_hover_animation',
			[
				'label'                 => esc_html__( 'Animation', 'gyan-elements' ),
				'type'                  => Controls_Manager::HOVER_ANIMATION,
			]
		);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_text_style',
            [
                'label'                 => esc_html__( 'Text', 'gyan-elements' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
			'text_color',
			[
				'label'                 => esc_html__( 'Color', 'gyan-elements' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .gyan-icon-list-text' => 'color: {{VALUE}};',
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
                'name'                  => 'text_typography',
                'label'                 => esc_html__( 'Typography', 'gyan-elements' ),
                'scheme'                => Scheme_Typography::TYPOGRAPHY_4,
                'selector'              => '{{WRAPPER}} .gyan-icon-list-text',
            ]
        );

        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'icon-list', 'class', 'gyan-ilist-items' );

        $this->add_render_attribute( 'icon', 'class', 'gyan-icon-list-icon' );

        $this->add_render_attribute( 'icon-wrap', 'class', 'gyan-icon-wrapper' );

        if ( 'inline' === $settings['view'] ) {
			$this->add_render_attribute( 'icon-list', 'class', 'gyan-inline-items' );
		}

        $i = 1;
        ?>
        <div class="gyan-icon-list-wrap">
            <ul <?php echo $this->get_render_attribute_string( 'icon-list' ); ?>>
                <?php foreach ( $settings['list_items'] as $index => $item ) : ?>
                    <?php if ( $item['text'] ) { ?>
                        <li>
                            <?php
                                $text_key = $this->get_repeater_setting_key( 'text', 'list_items', $index );
                                $this->add_render_attribute( $text_key, 'class', 'gyan-icon-list-text' );
                                $this->add_inline_editing_attributes( $text_key, 'none' );

                                if ( ! empty( $item['link']['url'] ) ) {
                                    $link_key = 'link_' . $i;

                                    $this->add_render_attribute( $link_key, 'href', $item['link']['url'] );

                                    if ( $item['link']['is_external'] ) {
                                        $this->add_render_attribute( $link_key, 'target', '_blank' );
                                    }

                                    if ( $item['link']['nofollow'] ) {
                                        $this->add_render_attribute( $link_key, 'rel', 'nofollow' );
                                    }

                                    echo '<a ' . $this->get_render_attribute_string( $link_key ) . '>';
                                }
                                if ( $item['gyan_icon_type'] != 'none' ) {
                                    $icon_key = 'icon_' . $i;
                                    $this->add_render_attribute( $icon_key, 'class', 'gyan-icon-wrapper' );

                                    if ( $settings['icon_hover_animation'] != '' ) {
                                        $icon_animation = 'elementor-animation-' . $settings['icon_hover_animation'];
                                    } else {
                                        $icon_animation = '';
                                    }
                                    ?>
                                    <span <?php echo $this->get_render_attribute_string( $icon_key ); ?>>
                                        <?php
                                            if ( $item['gyan_icon_type'] == 'icon' ) { ?>
                                                <span class="gyan-icon-list-icon gyan-icon <?php echo $icon_animation; ?>"><?php Icons_Manager::render_icon( $item['list_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
												<?php
                                            } elseif ( $item['gyan_icon_type'] == 'image' ) {


                                            		// responsive image
                                            		if (  $settings['image_size'] == 'full' ) {
                                            		    $imageTagHtml = wp_get_attachment_image( $item['list_image']['id'], 'full', "", ["alt" => esc_attr( Control_Media::get_image_alt( $item['list_image'] ) )] );
                                            		} else {
                                            		    $imgUrl = Group_Control_Image_Size::get_attachment_image_src( $item['list_image']['id'], 'image', $settings );
                                            		    if ( ! $imgUrl ) {
                                            		        $imgUrl = $item['list_image']['url'];
                                            		    }
                                            		    $imageTagHtml = '<img src="'.esc_url($imgUrl).'" alt="" />';
                                            		}

                                                printf( '<span class="gyan-icon-list-image %2$s">%1$s</span>', $imageTagHtml, $icon_animation );
                                            } elseif ( $item['gyan_icon_type'] == 'number' ) {
                                                printf( '<span class="gyan-icon-list-icon %2$s">%1$s</span>', $i, $icon_animation );
                                            }
                                        ?>
                                    </span>
                                    <?php
                                }

                                printf( '<span %1$s>%2$s</span>', $this->get_render_attribute_string( $text_key ), $item['text'] );

                                if ( ! empty( $item['link']['url'] ) ) {
                                    echo '</a>';
                                }
                            ?>
                        </li>
                    <?php } ?>
                <?php $i++; endforeach; ?>
            </ul>
        </div>
        <?php
    }


    protected function _content_template() {}
}