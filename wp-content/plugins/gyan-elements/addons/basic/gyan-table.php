<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Gyan_Table extends Widget_Base {

	public function get_name()           { return 'gyan_table'; }
	public function get_title()          { return esc_html__( 'Table', 'gyan-elements' ); }
	public function get_icon()           { return 'gyan-el-icon eicon-table'; }
	public function get_categories()     { return ['gyan-basic-addons']; }
	public function get_keywords()       { return [ 'gyan table', 'table','data table' ]; }
	public function get_style_depends()  { return ['gyan-icon','gyan-table']; }

	protected function register_controls() {

		$this->start_controls_section(
			'table_header',
			[
				'label' => esc_html__( 'Header', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$thead = new Repeater();

		$thead->add_control(
			'header_col_span',
			[
				'label' => esc_html__( 'Column Span', 'gyan-elements' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'default' => 1,
			]
		);
		$thead->add_control(
			'header_text',
			[
				'label' => esc_html__( 'Header Text', 'gyan-elements' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__('Enter Text', 'gyan-elements'),
				'default' => 'WordPress',
			]
		);

		$thead->add_control(
			'header_icon_type',
            [
				'label'       => esc_html__( 'Icon Type', 'gyan-elements' ),
                'type'        => Controls_Manager::CHOOSE,
                'label_block' => false,
                'separator' => 'before',
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
                ],
                'default'       => 'icon',
			]
		);

		$thead->add_control(
			'header_icon',
			[
				'label' => esc_html__( 'Icon', 'gyan-elements' ),
				'type' => Controls_Manager::ICONS,
				'condition'     => [
                    'header_icon_type' => 'icon',
                ],
			]
		);

		$thead->add_control(
			'thead_icon_img',
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
                    'header_icon_type' => 'image',
                ],
			]
		);


		$thead->add_control(
			'header_icon_align',
			[
				'label' => esc_html__( 'Icon Position', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'left' => esc_html__( 'Before', 'gyan-elements' ),
					'right' => esc_html__( 'After', 'gyan-elements' ),
					'above' => esc_html__( 'Above Text', 'gyan-elements' ),
				],
				'default' => 'left',
			]
		);

		$thead->start_controls_tabs( 'header_style_tabs' );

		$thead->start_controls_tab(
			'header_normal',
			[
				'label' => esc_html__( 'Normal', 'gyan-elements' ),
			]
		);

		$thead->add_control(
			'header_color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-table table thead tr {{CURRENT_ITEM}}' => 'color: {{VALUE}};',
				],
			]
		);

		$thead->add_control(
			'header_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-table table thead tr {{CURRENT_ITEM}} i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .gyan-table table thead tr {{CURRENT_ITEM}} svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$thead->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'header_background',
				'label' => esc_html__( 'Background', 'gyan-elements' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .gyan-table table thead tr {{CURRENT_ITEM}}',
			]
		);

		$thead->end_controls_tab();

		$thead->start_controls_tab(
			'header_hover',
			[
				'label' => esc_html__( 'Hover', 'gyan-elements' ),
			]
		);

		$thead->add_control(
			'header_hover_color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-table table thead tr {{CURRENT_ITEM}}:hover' => 'color: {{VALUE}};',
				],
			]
		);
		$thead->add_control(
			'header_hover_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-table table thead tr {{CURRENT_ITEM}}:hover i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .gyan-table table thead tr {{CURRENT_ITEM}}:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$thead->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'header_hover_background',
				'label' => esc_html__( 'Background', 'gyan-elements' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .gyan-table table thead tr {{CURRENT_ITEM}}:hover',
			]
		);

		$thead->end_controls_tab();

		$thead->end_controls_tabs();

		$this->add_control(
			'header_content',
			[
				'label' => esc_html__('Add Item', 'gyan-elements'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $thead->get_controls(),
				'prevent_empty' => false,
				'default' => [
					[
						'header_text' => 'Name',
					],
					[
						'header_text' => 'Age',
					],
					[
						'header_text' => 'Job Title',
					],
					[
						'header_text' => 'Location',
					],
				],
				'title_field' => '{{{ header_text }}}',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'table_body',
			[
				'label' => esc_html__( 'Body', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$tbody = new Repeater();

		$tbody->add_control(
			'content_type',
			[
				'label' => esc_html__( 'Content Type', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'row' => esc_html__( 'Row', 'gyan-elements' ),
					'cell' => esc_html__( 'Cell', 'gyan-elements' ),
					'head' => esc_html__( 'Head', 'gyan-elements' ),
				],
				'default' => 'row',
			]
		);
		$tbody->add_control(
			'row_span',
			[
				'label' => esc_html__( 'Row Span', 'gyan-elements' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 1,
				'min' => 1,
				'condition' => [
					'content_type' => ['cell', 'head'],
				],
			]
		);
		$tbody->add_control(
			'col_span',
			[
				'label' => esc_html__( 'Column Span', 'gyan-elements' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 1,
				'min' => 1,
				'condition' => [
					'content_type' => ['cell', 'head'],
				],
			]
		);
		$tbody->add_control(
			'cell_content',
			[
				'label' => esc_html__( 'Content', 'gyan-elements' ),
				'type' => Controls_Manager::TEXTAREA,
				'description' => esc_html__( 'You can use HTML.', 'gyan-elements' ),
				'condition' => [
					'content_type' => ['cell', 'head'],
				],
			]
		);

		$tbody->add_control(
			'content_icon_type',
            [
				'label'       => esc_html__( 'Icon Type', 'gyan-elements' ),
                'type'        => Controls_Manager::CHOOSE,
                'label_block' => false,
                'separator' => 'before',
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
                ],
                'default' => 'none',
			]
		);

		$tbody->add_control(
			'content_icon',
			[
				'label' => esc_html__( 'Icon', 'gyan-elements' ),
				'type' => Controls_Manager::ICONS,
				'condition'     => [
                    'content_icon_type' => 'icon',
                    'content_type' => ['cell', 'head'],
                ],
			]
		);

		$tbody->add_control(
			'content_icon_img',
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
                    'content_icon_type' => 'image',
                    'content_type' => ['cell', 'head'],
                ],
			]
		);

		$tbody->add_control(
			'content_icon_align',
			[
				'label' => esc_html__( 'Icon Position', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'left' => esc_html__( 'Before', 'gyan-elements' ),
					'right' => esc_html__( 'After', 'gyan-elements' ),
				],
				'default' => 'left',
				'condition' => [
					'content_type' => ['cell', 'head'],
				],
			]
		);

		$tbody->start_controls_tabs( 'content_style_tabs' );

		$tbody->start_controls_tab(
			'content_normal',
			[
				'label' => esc_html__( 'Normal', 'gyan-elements' ),
			]
		);

		$tbody->add_control(
			'content_color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-table table tbody {{CURRENT_ITEM}}' => 'color: {{VALUE}};',
					'{{WRAPPER}} .gyan-table table tbody {{CURRENT_ITEM}} svg' => 'fill: {{VALUE}};',
				],
			]
		);
		$tbody->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'content_background',
				'label' => esc_html__( 'Background', 'gyan-elements' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .gyan-table table tbody {{CURRENT_ITEM}}',
			]
		);

		$tbody->end_controls_tab();

		$tbody->start_controls_tab(
			'content_hover',
			[
				'label' => esc_html__( 'Hover', 'gyan-elements' ),
			]
		);

		$tbody->add_control(
			'content_hover_color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-table table tbody {{CURRENT_ITEM}}:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .gyan-table table tbody {{CURRENT_ITEM}}:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);
		$tbody->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'content_hover_background',
				'label' => esc_html__( 'Background', 'gyan-elements' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .gyan-table table tbody {{CURRENT_ITEM}}:hover',
			]
		);

		$tbody->end_controls_tab();

		$tbody->end_controls_tabs();

		$this->add_control(
			'body_content',
			[
				'label' => esc_html__('Add Item', 'gyan-elements'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $tbody->get_controls(),
				'default' => [
					[
						'content_type' => 'row',
					],
					[
						'content_type' => 'head',
						'row_span' => 1,
						'col_span' => 1,
						'cell_content' => 'Robert White',
					],
					[
						'content_type' => 'cell',
						'row_span' => 1,
						'col_span' => 1,
						'cell_content' => '35',
					],
					[
						'content_type' => 'cell',
						'row_span' => 1,
						'col_span' => 1,
						'cell_content' => 'Sales Executive',
					],
					[
						'content_type' => 'cell',
						'row_span' => 1,
						'col_span' => 1,
						'cell_content' => '324, Station Road, NY.',
					],

					[
						'content_type' => 'row',
					],
					[
						'content_type' => 'head',
						'row_span' => 1,
						'col_span' => 1,
						'cell_content' => 'Sarah George',
					],
					[
						'content_type' => 'cell',
						'row_span' => 1,
						'col_span' => 1,
						'cell_content' => '42',
					],
					[
						'content_type' => 'cell',
						'row_span' => 1,
						'col_span' => 1,
						'cell_content' => 'Project Manager',
					],
					[
						'content_type' => 'cell',
						'row_span' => 1,
						'col_span' => 1,
						'cell_content' => '257, Hillson Road, TX.',
					],
				],
				'title_field' => '{{{ content_type }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'table_header_style',
			[
				'label' => esc_html__( 'Header', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
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
					'justify' => [
						'title' => esc_html__( 'justify', 'gyan-elements' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .gyan-table table thead th,{{WRAPPER}} .gyan-table table thead th .gyan-icon-above' => 'text-align: {{VALUE}};',
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
							'size' => '16',
						],
					],
					'line_height'   => [
						'default' => [
							'size' => '24',
						],
					],
				],
				'selector' => '{{WRAPPER}} .gyan-table table thead th',
			]
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'header_text_shadow',
				'selector' => '{{WRAPPER}} .gyan-table table thead th',
			]
		);

		$this->add_responsive_control(
			'header_padding',
			[
				'label' => esc_html__( 'Padding', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '15',
					'right' => '20',
					'bottom' => '15',
					'left' => '20',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-table table thead th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'header_icon_img_heading',
			[
				'label'     => esc_html__( 'Icon / Image', 'gyan-elements' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'header_icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'gyan-elements' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '16',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-table table thead th > .gyan-table-icon > i, {{WRAPPER}} .gyan-table table thead th > .gyan-table-icon > svg' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'header_icon_space',
			[
				'label' => esc_html__( 'Icon Spacing', 'gyan-elements' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '5',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-table table thead th > .gyan-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .gyan-table table thead th > .gyan-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .gyan-table table thead th > .gyan-icon-above' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'thead_image_size',
				'default'   => 'full',
				'separator' => 'none',
			]
		);

		$this->start_controls_tabs( 'header_tabs' );

		$this->start_controls_tab(
			'header_normal',
			[
				'label' => esc_html__( 'Normal', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'header_color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .gyan-table table thead tr th' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'header_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .gyan-table table thead tr th i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .gyan-table table thead tr svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'header_background',
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
				'selector' => '{{WRAPPER}} .gyan-table table thead tr',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'header_border',
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'color' => [
						'default' => 'rgba(255,255,255,0.5)',
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
				'selector' => '{{WRAPPER}} .gyan-table table thead th',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'header_hover',
			[
				'label' => esc_html__( 'Hover', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'header_hover_color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-table table thead tr:hover th' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'header_hover_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-table table thead tr:hover th i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .gyan-table table thead tr:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'header_hover_background',
				'label' => esc_html__( 'Background', 'gyan-elements' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .gyan-table table thead tr:hover',
			]
		);
		$this->add_control(
			'header_hover_border',
			[
				'label' => esc_html__( 'Border Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-table table thead tr:hover th' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();


		$this->end_controls_section();

		$this->start_controls_section(
			'table_content_style',
			[
				'label' => esc_html__( 'Content', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_alignment_head',
			[
				'label' => esc_html__( 'Alignment Head', 'gyan-elements' ),
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
					'{{WRAPPER}} .gyan-table table tbody th' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
		    'content_vertical_align_head',
		    [
		        'label'       => esc_html__( 'Vertical Align - Head', 'gyan-elements' ),
		        'type'        => Controls_Manager::SELECT,
		        'options'     => [
		            'top'    => esc_html__( 'Top', 'gyan-elements' ),
		            'middle' => esc_html__( 'Middle', 'gyan-elements' ),
		            'bottom' => esc_html__( 'Bottom', 'gyan-elements' ),
		        ],
		        'default' => 'top',
		    ]
		);

		$this->add_responsive_control(
			'content_alignment',
			[
				'label' => esc_html__( 'Alignment Cell', 'gyan-elements' ),
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
					'{{WRAPPER}} .gyan-table table tbody td' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
		    'content_vertical_align_cell',
		    [
		        'label'       => esc_html__( 'Vertical Align - Cell', 'gyan-elements' ),
		        'type'        => Controls_Manager::SELECT,
		        'options'     => [
		            'top'    => esc_html__( 'Top', 'gyan-elements' ),
		            'middle' => esc_html__( 'Middle', 'gyan-elements' ),
		            'bottom' => esc_html__( 'Bottom', 'gyan-elements' ),
		        ],
		        'default' => 'top',
		    ]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'fields_options' => [
					'typography' => [
						'default' =>'custom',
					],
					'font_weight' => [
						'default' => '400',
					],
					'font_size'   => [
						'default' => [
							'size' => '14',
						],
					],
				],
				'selector' => '{{WRAPPER}} .gyan-table table tbody tr',
			]
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'content_text_shadow',
				'selector' => '{{WRAPPER}} .gyan-table table tbody tr',
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label' => esc_html__( 'Padding', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '15',
					'right' => '20',
					'bottom' => '15',
					'left' => '20',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-table table tbody td, {{WRAPPER}} .gyan-table table tbody th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_control(
			'content_icon_img_heading',
			[
				'label'     => esc_html__( 'Icon / Image', 'gyan-elements' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'content_icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'gyan-elements' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '14',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-table table tbody td .gyan-table-icon > i,
					{{WRAPPER}} .gyan-table table tbody th .gyan-table-icon > i,
					{{WRAPPER}} .gyan-table table tbody td .gyan-table-icon > svg,
					{{WRAPPER}} .gyan-table table tbody th .gyan-table-icon > svg' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'content_icon_space',
			[
				'label' => esc_html__( 'Icon Spacing', 'gyan-elements' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '5',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-table table tbody td > .gyan-icon-right, {{WRAPPER}} .gyan-table table tbody th > .gyan-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .gyan-table table tbody td > .gyan-icon-left, {{WRAPPER}} .gyan-table table tbody th > .gyan-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'content_image_size',
				'default'   => 'full',
				'separator' => 'none',
			]
		);

		$this->start_controls_tabs( 'content_tabs' );

		$this->start_controls_tab(
			'content_normal',
			[
				'label' => esc_html__( 'Normal', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'content_color_head',
			[
				'label' => esc_html__( 'Text Color - Head', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#606060',
				'selectors' => [
					'{{WRAPPER}} .gyan-table table tbody tr th' => 'color: {{VALUE}};',
					'{{WRAPPER}} .gyan-table table tbody tr th svg' => 'fill: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'content_color',
			[
				'label' => esc_html__( 'Text Color - Cell', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#606060',
				'selectors' => [
					'{{WRAPPER}} .gyan-table table tbody tr td' => 'color: {{VALUE}};',
					'{{WRAPPER}} .gyan-table table tbody tr td svg' => 'fill: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'content_background',
				'label' => esc_html__( 'Background', 'gyan-elements' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .gyan-table table tbody tr',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'content_border',
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'color' => [
						'default' => '#eee',
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
				'selector' => '{{WRAPPER}} .gyan-table table tbody td, {{WRAPPER}} .gyan-table table tbody th',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'content_hover',
			[
				'label' => esc_html__( 'Hover', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'content_hover_head_color',
			[
				'label' => esc_html__( 'Text Color - Head', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#111111',
				'selectors' => [
					'{{WRAPPER}} .gyan-table table tbody tr:hover th' => 'color: {{VALUE}};',
					'{{WRAPPER}} .gyan-table table tbody tr:hover th svg' => 'fill: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'content_hover_color',
			[
				'label' => esc_html__( 'Text Color - Cell', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#111111',
				'selectors' => [
					'{{WRAPPER}} .gyan-table table tbody tr:hover td' => 'color: {{VALUE}};',
					'{{WRAPPER}} .gyan-table table tbody tr:hover td svg' => 'fill: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'content_hover_background',
				'label' => esc_html__( 'Background', 'gyan-elements' ),
				'types' => [ 'classic', 'gradient' ],
				'fields_options' => [
					'background' => [
						'default' =>'classic',
					],
					'color' => [
						'default' => 'rgba(0,0,0,0.02)',
					],
				],
				'selector' => '{{WRAPPER}} .gyan-table table tbody tr:hover',
			]
		);
		$this->add_control(
			'content_hover_border',
			[
				'label' => esc_html__( 'Border Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-table table tbody tr:hover td, {{WRAPPER}} .gyan-table table tbody tr:hover th' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	protected function render() {
		$data = $this->get_settings_for_display();

		$rows = [];
		$tid = 0;
		foreach ($data['body_content'] as $key => $content) {
			if ( 'row' == $content['content_type'] ) {
				$tid = $content['_id'];
				$rows[ $tid ] = [];
			} elseif ( 'head' == $content['content_type'] && isset( $rows[ $tid ] ) ) {
				array_push($rows[ $tid ], [
					'type' => 'th',
					'id' => $content['_id'],
					'row_span' => $content['row_span'],
					'col_span' => $content['col_span'],
					'cell_content' => $content['cell_content'],
					'icon' => $content['content_icon'],
					'icon_align' => $content['content_icon_align'],
					'get_icon_type' => $content['content_icon_type'],
					'content_icon_img' => $content['content_icon_img'],
				]);
			} elseif ( 'cell' == $content['content_type'] && isset( $rows[ $tid ] ) ) {
				array_push($rows[ $tid ], [
					'type' => 'td',
					'id' => $content['_id'],
					'row_span' => $content['row_span'],
					'col_span' => $content['col_span'],
					'cell_content' => $content['cell_content'],
					'icon' => $content['content_icon'],
					'icon_align' => $content['content_icon_align'],
					'get_icon_type' => $content['content_icon_type'],
					'content_icon_img' => $content['content_icon_img'],
				]);
			}
		}
		?>
		<div class="gyan-table gyan-table-tbody-th-<?php echo $data['content_vertical_align_head']; ?> gyan-table-tbody-td-<?php echo $data['content_vertical_align_cell']; ?>">
			<table>
				<?php if ( !empty( $data['header_content'] ) ): ?>
					<thead><tr><?php foreach ($data['header_content'] as $content):

								$thead_icon = '';
								$thead_text = '';

								if ( $content['header_icon_type'] == 'image' ) {

									// responsive image
									if (  $data['thead_image_size_size'] == 'full' ) {
									    $imageTagHtml = wp_get_attachment_image( $content['thead_icon_img']['id'], 'full');
									} else {
									    $imgUrl = Group_Control_Image_Size::get_attachment_image_src( $content['thead_icon_img']['id'], 'thead_image_size', $data );
									    if ( ! $imgUrl ) {
									        $imgUrl = $item['thead_icon_img']['url'];
									    }
									    $imageTagHtml = '<img src="'.esc_url($imgUrl).'" alt="" />';
									}

									$thead_icon = '<span class="gyan-table-icon gyan-icon-' . $content['header_icon_align'] . '">' . $imageTagHtml . '</span>';

								} else if ( $content['header_icon_type'] == 'icon' ) {

									ob_start();
						        	Icons_Manager::render_icon( $content['header_icon'], [ 'aria-hidden' => 'true' ] );
									$header_icon = ob_get_clean();

									$thead_icon = '<span class="gyan-table-icon gyan-icon-' . $content['header_icon_align'] . '">' . $header_icon . '</span>';

								}

								if ( '' != $content['header_text'] ) {
									$thead_text = '<span class="gyan-table-thead">' . $content['header_text'] . '</span>';
								}

								if ( $content['header_icon_align'] == 'left' || $content['header_icon_align'] == 'above') {
									$thead_final_content = $thead_icon.$thead_text;
								} else {
									$thead_final_content = $thead_text.$thead_icon;
								}

								?><th colspan="<?php echo esc_attr( $content['header_col_span'] ); ?>" class="elementor-repeater-item-<?php echo esc_attr( $content['_id'] ); ?> gyan-table-thead-icon-<?php echo $content['header_icon_align']; ?>"><?php echo $thead_final_content; ?></th><?php
							endforeach;

							?></tr>
					</thead>
				<?php endif; ?>

				<tbody>
					<?php foreach ($rows as $key => $row) :
						?><tr class="elementor-repeater-item-<?php echo esc_attr( $key ); ?>"><?php
						foreach ($row as $content) :

							$content_icon = '';
							$content_text = '';

							if ( $content['get_icon_type'] == 'image' ) {

								// responsive image
								if (  $data['content_image_size_size'] == 'full' ) {
								    $imageTagHtml = wp_get_attachment_image( $content['content_icon_img']['id'], 'full');
								} else {
								    $imgUrl = Group_Control_Image_Size::get_attachment_image_src( $content['content_icon_img']['id'], 'content_image_size', $data );
								    if ( ! $imgUrl ) {
								        $imgUrl = $item['content_icon_img']['url'];
								    }
								    $imageTagHtml = '<img src="'.esc_url($imgUrl).'" alt="" />';
								}

								$content_icon = '<span class="gyan-table-icon gyan-icon-' . $content['icon_align'] . '">' . $imageTagHtml . '</span>';

							} else if ( $content['get_icon_type'] == 'icon' ) {

								ob_start();
					        	Icons_Manager::render_icon( $content['icon'], [ 'aria-hidden' => 'true' ] );
								$header_icon = ob_get_clean();

								$content_icon = '<span class="gyan-table-icon gyan-icon-' . $content['icon_align'] . '">' . $header_icon . '</span>';
							}

							if ( '' != $content['cell_content'] ) {
								$content_text = '<span class="gyan-table-content-text">' . $content['cell_content'] . '</span>';
							}

							if ( $content['icon_align'] == 'left' || $content['icon_align'] == 'above') {
								$body_final_content = $content_icon.$content_text;
							} else {
								$body_final_content = $content_text.$content_icon;
							}
								?><<?php echo esc_html( $content['type'] );
								?> rowspan="<?php echo esc_attr( $content['row_span'] ); ?>" colspan="<?php echo esc_attr( $content['col_span'] ); ?>" class="elementor-repeater-item-<?php echo esc_attr( $content['id'] ); ?>" ><?php echo $body_final_content; ?></<?php echo esc_html( $content['type'] ); ?>><?php endforeach;
							?></tr><?php
					endforeach; ?></tbody>
			</table>
		</div><!-- .gyan-table -->
		<?php
	}

	protected function _content_template() {}
}