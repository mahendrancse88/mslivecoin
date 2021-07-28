<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {exit; }

class Gyan_Testimonials extends Widget_Base {

	public function get_name() {return 'gyan_testimonials'; }
	public function get_title() {return esc_html__( 'Testimonials', 'gyan-elements' ); }
	public function get_icon() {return 'gyan-el-icon eicon-testimonial-carousel'; }
	public function get_categories() {return [ 'gyan-advanced-addons' ]; }
	public function get_keywords() {return [ 'gyan testimonials', 'review', 'testimonial','testimonials' ]; }
	public function get_style_depends() {return ['owl-carousel', 'gyan-testimonials' ]; }
	public function get_script_depends() {return ['jquery-owl', 'gyan-widgets', ]; }

	protected function register_controls() {

		$this->start_controls_section(
			'testimonials_content',
			[
				'label' => esc_html__( 'Testimonials', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
		   'image',
		   [
				'label'   => esc_html__( 'Choose Image', 'gyan-elements' ),
				'type'    => Controls_Manager::MEDIA
			]
		);

		$repeater->add_control(
		   'name',
		   [
				'label' => esc_html__( 'Name', 'gyan-elements' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter Name', 'gyan-elements' ),
				'default' => 'Jhon Doe',
		   ]
		);

		$repeater->add_control(
			'position',
			[
				'label' => esc_html__( 'Position', 'gyan-elements' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter Position', 'gyan-elements' ),
				'default' => 'CEO',
		   ]
		);

		$repeater->add_control(
		   'comment',
		   [
				'label' => esc_html__( 'Comment', 'gyan-elements' ),
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter Comment', 'gyan-elements' ),
				'default' => 'Lorem ipsum dolor sit amet saresw consectetur adipis cing elit sed do eiusmod tempor incidi duntut labore etolore magna aliqua ipsum suspen disse ultrices ida commodo.',
		   ]
		);

		$this->add_control(
			'testimonials',
			[
				'label' => esc_html__( 'Add Image', 'gyan-elements' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ name }}}',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'carousel_settings',
			[
				'label' => esc_html__( 'Carousel Settings', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label' => esc_html__( 'Autoplay', 'gyan-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'gyan-elements' ),
				'label_off' => esc_html__( 'Off', 'gyan-elements' ),
				'default' => 'yes',
			]
		);
		$this->add_control(
			'pause',
			[
				'label' => esc_html__( 'Pause on Hover', 'gyan-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'gyan-elements' ),
				'label_off' => esc_html__( 'Off', 'gyan-elements' ),
				'default' => 'yes',
			]
		);
		$this->add_control(
			'mouse_drag',
			[
				'label' => esc_html__( 'Mouse Drag', 'gyan-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'gyan-elements' ),
				'label_off' => esc_html__( 'Off', 'gyan-elements' ),
				'default' => 'yes',
			]
		);
		$this->add_control(
			'touch_drag',
			[
				'label' => esc_html__( 'Touch Drag', 'gyan-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'gyan-elements' ),
				'label_off' => esc_html__( 'Off', 'gyan-elements' ),
				'default' => 'yes',
			]
		);
		$this->add_control(
			'loop',
			[
				'label' => esc_html__( 'Infinity Loop', 'gyan-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'gyan-elements' ),
				'label_off' => esc_html__( 'Off', 'gyan-elements' ),
				'default' => 'yes',
			]
		);
		$this->add_control(
			'dots',
			[
				'label' => esc_html__( 'Dots Navigation', 'gyan-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'gyan-elements' ),
				'label_off' => esc_html__( 'Hide', 'gyan-elements' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'nav',
			[
				'label' => esc_html__( 'Arrow Navigation', 'gyan-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'gyan-elements' ),
				'label_off' => esc_html__( 'Hide', 'gyan-elements' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_quote_icon',
			[
				'label' => esc_html__( 'Quote Icon', 'gyan-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'gyan-elements' ),
				'label_off' => esc_html__( 'Off', 'gyan-elements' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'delay',
			[
				'label' => esc_html__( 'Delay', 'gyan-elements' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 5000,
				'step' => 100,
				'min' => 500,
				'max' => 15000,
			]
		);
		$this->add_control(
			'speed',
			[
				'label' => esc_html__( 'Speed', 'gyan-elements' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 500,
				'step' => 100,
				'min' => 100,
				'max' => 5000,
			]
		);

		$this->add_control(
			'item_space',
			[
				'label' => esc_html__( 'Space Between Two Items', 'gyan-elements' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '30'
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-testimonials-item' => 'padding: calc( {{SIZE}}px/2 );',
				],
			]
		);

		$this->add_control(
			'breakpoint1_items',
			[
				'label' => esc_html__( 'Break Point 1 Items (1000px)', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'1' => esc_html__( '1', 'gyan-elements' ),
					'2' => esc_html__( '2', 'gyan-elements' ),
					'3' => esc_html__( '3', 'gyan-elements' ),
					'4' => esc_html__( '4', 'gyan-elements' ),
				],
				'default' => '3',
			]
		);

		$this->add_control(
			'breakpoint2_items',
			[
				'label' => esc_html__( 'Break Point 2 Items (900px)', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'1' => esc_html__( '1', 'gyan-elements' ),
					'2' => esc_html__( '2', 'gyan-elements' ),
					'3' => esc_html__( '3', 'gyan-elements' ),
					'4' => esc_html__( '4', 'gyan-elements' ),
				],
				'default' => '3',
			]
		);

		$this->add_control(
			'breakpoint3_items',
			[
				'label' => esc_html__( 'Break Point 3 Items (700px)', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'1' => esc_html__( '1', 'gyan-elements' ),
					'2' => esc_html__( '2', 'gyan-elements' ),
					'3' => esc_html__( '3', 'gyan-elements' ),
					'4' => esc_html__( '4', 'gyan-elements' ),
				],
				'default' => '2',
			]
		);

		$this->add_control(
			'breakpoint4_items',
			[
				'label' => esc_html__( 'Break Point 4 Items (400px)', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'1' => esc_html__( '1', 'gyan-elements' ),
					'2' => esc_html__( '2', 'gyan-elements' ),
					'3' => esc_html__( '3', 'gyan-elements' ),
					'4' => esc_html__( '4', 'gyan-elements' ),
				],
				'default' => '1',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'general_style',
			[
				'label' => esc_html__( 'General', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
		    Group_Control_Background::get_type(),
		    [
		        'name' => 'testimonials_box_bg',
		        'label' => esc_html__( 'Testimonials Box Background', 'gyan-elements' ),
		        'types' => [ 'classic','gradient' ],
		        'fields_options' => [
		            'background' => [
		                'default' =>'classic',
		            ],
		            'color' => [
		                'default' => '#ffffff',
		            ],
		        ],
		        'selector' => '{{WRAPPER}} .gyan-testimonials-content',
		    ]
		);

		$this->add_control(
			'arrow_shape',
			[
				'label' => esc_html__( 'Arrow Shape Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .gyan-testimonials-content:before' => 'border-top-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'box_radius',
			[
				'label' => esc_html__( 'Radius', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
                    'unit' => 'px',
                    'top' => '3',
                    'right' => '3',
                    'bottom' => '3',
                    'left' => '3',
                    'isLinked' => true,
                ],
				'selectors' => [
					'{{WRAPPER}} .gyan-testimonials-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'box_padding',
			[
				'label' => esc_html__( 'Testimonials Box Padding', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .gyan-testimonials .gyan-testimonials-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'content_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'gyan-elements' ),
		        'fields_options' => [
					'box_shadow_type' => [
						'default' =>'yes'
					],
					'box_shadow' => [
						'default' => [
							'horizontal' => '0',
							'vertical' => '0',
							'blur' => '15',
							'color' => 'rgba(0,0,0,0.08)'
						]
					]
				],
				'selector' => '{{WRAPPER}} .gyan-testimonials-content',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'content_box_shadow_hover',
				'label' => esc_html__( 'Hover Box Shadow', 'gyan-elements' ),
		        'fields_options' => [
					'box_shadow_type' => [
						'default' =>'yes'
					],
					'box_shadow' => [
						'default' => [
							'horizontal' => '0',
							'vertical' => '0',
							'blur' => '15',
							'color' => 'rgba(0,0,0,0.15)'
						]
					]
				],
				'selector' => '{{WRAPPER}} .gyan-testimonials-item:hover .gyan-testimonials-content',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'image_style',
			[
				'label' => esc_html__( 'Image', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'image_size',
			[
				'label' => esc_html__( 'Size', 'gyan-elements' ),
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
					'size' => '70',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-testimonials .owl-item .gyan-testimonials-face' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .gyan-testimonials .owl-item .gyan-testimonials-face' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'image_padding',
			[
				'label' => esc_html__( 'Padding', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .gyan-testimonials .owl-item .gyan-testimonials-face' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'image_radius',
			[
				'label' => esc_html__( 'Radius', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
                    'unit' => '%',
                    'top' => '100',
                    'right' => '100',
                    'bottom' => '100',
                    'left' => '100',
                    'isLinked' => true,
                ],
				'selectors' => [
					'{{WRAPPER}} .gyan-testimonials .owl-item .gyan-testimonials-face' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_margin',
			[
				'label' => esc_html__( 'Margin', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .gyan-testimonials .owl-item .gyan-testimonials-face' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'box_border',
				'selector' => '{{WRAPPER}} .gyan-testimonials .owl-item .gyan-testimonials-face',
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'selector' => '{{WRAPPER}} .gyan-testimonials .owl-item .gyan-testimonials-face',
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'name_style',
			[
				'label' => esc_html__( 'Name', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'name_color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#032e42',
				'selectors' => [
					'{{WRAPPER}} .gyan-testimonials .gyan-testimonials-name' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'name_typography',
				'fields_options' => [
					'typography' => [
						'default' =>'custom',
					],
					'font_size'   => [
						'default' => [
							'size' => '18',
						],
					]
				],
				'selector' => '{{WRAPPER}} .gyan-testimonials .gyan-testimonials-name',
			]
		);

		$this->add_control(
		    'member_name_html_tag',
		    [
		        'label'   => esc_html__( 'Name Text HTML Tag', 'gyan-elements' ),
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

		$this->add_responsive_control(
			'name_margin',
			[
				'label' => esc_html__( 'Margin', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '12',
					'right' => '0',
					'bottom' => '-4',
					'left' => '0',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-testimonials .gyan-testimonials-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'position_style',
			[
				'label' => esc_html__( 'Position', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'position_color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#676767',
				'selectors' => [
					'{{WRAPPER}} .gyan-testimonials .gyan-testimonials-position' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'position_typography',
				'fields_options' => [
					'typography' => [
						'default' =>'custom',
					],
					'font_size'   => [
						'default' => [
							'size' => '14',
						],
					],
				],
				'selector' => '{{WRAPPER}} .gyan-testimonials .gyan-testimonials-position',
			]
		);
		$this->add_responsive_control(
			'position_margin',
			[
				'label' => esc_html__( 'Margin', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .gyan-testimonials .gyan-testimonials-pos-com' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'comment_style',
			[
				'label' => esc_html__( 'Comment', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'comment_color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#676767',
				'selectors' => [
					'{{WRAPPER}} .gyan-testimonials .gyan-testimonials-comment' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'comment_typography',
				'fields_options' => [
					'typography' => [
						'default' =>'custom',
					],
					'font_size'   => [
						'default' => [
							'size' => '17',
						],
					],
					'line_height'   => [
						'default' => [
							'size' => '33',
						],
					],
				],
				'selector' => '{{WRAPPER}} .gyan-testimonials .gyan-testimonials-comment',
			]
		);
		$this->add_responsive_control(
			'comment_margin',
			[
				'label' => esc_html__( 'Margin', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .gyan-testimonials .gyan-testimonials-comment' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'quote_icon_style',
			[
				'label' => esc_html__( 'Quote Icon', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'quote_icon_skin1_col',
			[
				'label' => esc_html__( 'Skin 1 Icon Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .gyan-testimonials .owl-item:nth-of-type(odd) .gyan-testimonials-quote-icon i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'quote_icon_skin1_bg',
			[
				'label' => esc_html__( 'Skin 1 Icon Background', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#f3a712',
				'selectors' => [
					'{{WRAPPER}} .gyan-testimonials .owl-item:nth-of-type(odd) .gyan-testimonials-quote-icon i' => 'background: {{VALUE}};',
					'{{WRAPPER}} .gyan-testimonials .owl-item:nth-of-type(odd) .gyan-testimonials-quote-icon' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'quote_icon_skin2_col',
			[
				'label' => esc_html__( 'Skin 2 Icon Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .gyan-testimonials .owl-item:nth-of-type(even) .gyan-testimonials-quote-icon i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'quote_icon_skin2_bg',
			[
				'label' => esc_html__( 'Skin 2 Icon Background', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#d83030',
				'selectors' => [
					'{{WRAPPER}} .gyan-testimonials .owl-item:nth-of-type(even) .gyan-testimonials-quote-icon i' => 'background: {{VALUE}};',
					'{{WRAPPER}} .gyan-testimonials .owl-item:nth-of-type(even) .gyan-testimonials-quote-icon' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

				$this->start_controls_section(
					'dot_nav_style',
					[
						'label' => esc_html__( 'Dot Navigation', 'gyan-elements' ),
						'tab' => Controls_Manager::TAB_STYLE,
						'condition' => [
							'dots!' => '',
						],
					]
				);

				$this->add_control(
					'dot_top_margin',
					[
						'label' => esc_html__( 'Margin Top (px)', 'gyan-elements' ),
						'type' => Controls_Manager::SLIDER,
						'default' => [
							'unit' => 'px',
							'size' => '17',
						],
						'condition' => [
							'nav!' => '',
						],
						'selectors' => [
							'{{WRAPPER}} .gyan-testimonials .owl-dots' => 'margin-top:{{SIZE}}{{UNIT}};',
						],
					]
				);

				$this->add_control(
					'dots_color',
					[
						'label' => esc_html__( 'Dots Color', 'gyan-elements' ),
						'type' => Controls_Manager::COLOR,
						'condition' => [
							'dots!' => '',
						],
						'default' => '#b7b7b7',
						'selectors' => [
							'{{WRAPPER}} .gyan-testimonials .owl-dots .owl-dot' => 'border-color: {{VALUE}}',
						]
					]
				);
				$this->add_control(
					'dots_color_active',
					[
						'label' => esc_html__( 'Active Dot Color', 'gyan-elements' ),
						'type' => Controls_Manager::COLOR,
						'condition' => [
							'dots!' => '',
						],
						'default' => '#d83030',
						'selectors' => [
							'{{WRAPPER}} .gyan-testimonials .owl-dots .owl-dot.active' => 'border-color: {{VALUE}}',
						]
					]
				);

				$this->end_controls_section();

				$this->start_controls_section(
					'arrow_nav_style',
					[
						'label' => esc_html__( 'Arrow Navigation', 'gyan-elements' ),
						'tab' => Controls_Manager::TAB_STYLE,
						'condition' => [
							'nav!' => '',
						],
					]
				);

				$this->add_control(
					'nav_top',
					[
						'label' => esc_html__( 'Navigation Top (%)', 'gyan-elements' ),
						'type' => Controls_Manager::SLIDER,
						'default' => [
							'unit' => '%',
							'size' => '35',
						],
						'condition' => [
							'nav!' => '',
						],
						'selectors' => [
							'{{WRAPPER}} .gyan-testimonials .owl-prev, {{WRAPPER}} .gyan-testimonials .owl-next' => 'top: calc({{SIZE}}{{UNIT}} - 18px);',
						],
					]
				);

				$this->start_controls_tabs( 'nav_normal_hover_style' );

		            $this->start_controls_tab(
		                'nav_style_normal',
		                [
		                    'label' => esc_html__( 'Normal', 'gyan-elements' ),
		                ]
		            );

		            $this->add_control(
		            	'nav_bg',
		            	[
		            		'label' => esc_html__( 'Background', 'gyan-elements' ),
		            		'type' => Controls_Manager::COLOR,
		            		'condition' => [
		            			'nav!' => '',
		            		],
		            		'default' => '#b7b7b7',
		            		'selectors' => [
		            			'{{WRAPPER}} .gyan-testimonials button.owl-prev,
		            			{{WRAPPER}} .gyan-testimonials button.owl-next' => 'background-color: {{VALUE}}'
		            		]
		            	]
		            );
		            $this->add_control(
		            	'nav_color',
		            	[
		            		'label' => esc_html__( 'Arrow Color', 'gyan-elements' ),
		            		'type' => Controls_Manager::COLOR,
		            		'condition' => [
		            			'nav!' => '',
		            		],
		            		'default' => '#ffffff',
		            		'selectors' => [
		            			'{{WRAPPER}} .gyan-testimonials button.owl-prev,
		            			{{WRAPPER}} .gyan-testimonials button.owl-next' => 'color: {{VALUE}}'
		            		],
		            	]
		            );

				$this->end_controls_tab();

				$this->start_controls_tab(
				    'nav_style_hover',
				    [
				        'label' => esc_html__( 'Hover', 'gyan-elements' ),
				    ]
				);

				$this->add_control(
					'nav_bg_hover',
					[
						'label' => esc_html__( 'Background', 'gyan-elements' ),
						'type' => Controls_Manager::COLOR,
						'condition' => [
							'nav!' => '',
						],
						'default' => '#d83030',
						'selectors' => [
							'{{WRAPPER}} .gyan-testimonials button.owl-prev:hover,
							{{WRAPPER}} .gyan-testimonials button.owl-next:hover' => 'background-color: {{VALUE}}'
						]
					]
				);
				$this->add_control(
					'nav_color_hover',
					[
						'label' => esc_html__( 'Arrow Color', 'gyan-elements' ),
						'type' => Controls_Manager::COLOR,
						'condition' => [
							'nav!' => '',
						],
						'default' => '#ffffff',
						'selectors' => [
							'{{WRAPPER}} .gyan-testimonials button.owl-prev:hover,
							{{WRAPPER}} .gyan-testimonials button.owl-next:hover' => 'color: {{VALUE}}'
						],
					]
				);

				$this->end_controls_tab();
		        $this->end_controls_tabs();

				$this->end_controls_section();

	}


	protected function render() {
		$data = $this->get_settings_for_display();
		$data_rtl = is_rtl() ? 'true' : 'false';

		?>
		<div class="gyan-testimonials owl-carousel" data-autoplay="<?php echo esc_attr( $data['autoplay'] ); ?>" data-pause="<?php echo esc_attr( $data['pause'] ); ?>" data-nav="<?php echo esc_attr( $data['nav'] ); ?>" data-dots="<?php echo esc_attr( $data['dots'] ); ?>" data-mouse-drag="<?php echo esc_attr( $data['mouse_drag'] ); ?>" data-touch-drag="<?php echo esc_attr( $data['touch_drag'] ); ?>" data-loop="<?php echo esc_attr( $data['loop'] ); ?>" data-speed="<?php echo esc_attr( $data['speed'] ); ?>" data-delay="<?php echo esc_attr( $data['delay'] ); ?>" data-item-space="<?php echo intval( $data['item_space']['size'] ); ?>" data-breakpoint1-items="<?php echo esc_attr( $data['breakpoint1_items'] ); ?>" data-breakpoint2-items="<?php echo esc_attr( $data['breakpoint2_items'] ); ?>" data-breakpoint3-items="<?php echo esc_attr( $data['breakpoint3_items'] ); ?>" data-breakpoint4-items="<?php echo esc_attr( $data['breakpoint4_items'] ); ?>" data-rtl="<?php echo $data_rtl; ?>">
		<?php
			foreach ($data['testimonials'] as $index => $item) :
				$name_key = $this->get_repeater_setting_key( 'name', 'testimonials', $index );
				$position_key = $this->get_repeater_setting_key( 'position', 'testimonials', $index );
				$comment_key = $this->get_repeater_setting_key( 'comment', 'testimonials', $index );

				$this->add_render_attribute( $name_key, 'class', 'gyan-testimonials-name' );
				$this->add_inline_editing_attributes( $name_key );

				$this->add_render_attribute( $position_key, 'class', 'gyan-testimonials-position' );
				$this->add_inline_editing_attributes( $position_key );

				$this->add_render_attribute( $comment_key, 'class', 'gyan-testimonials-comment' );
				$this->add_inline_editing_attributes( $comment_key );
			?>
			<div class="gyan-testimonials-item">

				<div class="gyan-testimonials-content gyan-ease-transition">
					<?php if ( 'yes' === $data['show_quote_icon'] ) :  ?>
					   <span class="gyan-testimonials-quote-icon">
					       <i class="fas fa-quote-right"></i>
					   </span>
					<?php endif; ?>

					<?php if ($item['comment']): ?>
						<div <?php echo $this->get_render_attribute_string( $comment_key ); ?>>
							<?php echo esc_html($item['comment']); ?>
						</div>
					<?php endif; ?>
				</div>

				<div class="gyan-testimonials-img-name">
					<?php if ( $item['image']['url'] ):
								// responsive image
								$imageTagHtml = wp_get_attachment_image( $item['image']['id'], 'full', "", ["class" => "gyan-testimonials-face","alt" => esc_attr( $item['name'] )]); ?>
						<div class="gyan-testimonials-img"><?php echo $imageTagHtml; ?></div>
					<?php endif; ?>

					<div class="gyan-testimonials-name-section">
						<?php if ($item['name']): ?>
							<<?php echo $data['member_name_html_tag']; ?> <?php echo $this->get_render_attribute_string( $name_key ); ?>><?php echo esc_html($item['name']); ?></<?php echo $data['member_name_html_tag'];?>>
						<?php endif; ?>

						<?php if ($item['position']): ?>
							<div class="gyan-testimonials-pos-com">
								<span <?php echo $this->get_render_attribute_string( $position_key ); ?>><?php echo esc_html($item['position']); ?></span>
							</div>
						<?php endif; ?>
					</div>

				</div>

			</div>
		<?php endforeach; ?>
		</div>
		<?php
	}

	protected function _content_template() {}

}