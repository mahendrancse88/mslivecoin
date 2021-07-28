<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Icons_Manager;

class Gyan_Common_Data{
	public static function animation() {
		return [
			'none' => esc_html__( 'None', 'gyan-elements' ),
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
		];
	}

	public static function animation_box() {
		return [
			'none'   => esc_html__( 'None', 'gyan-elements' ),
			'fade'   => esc_html__( 'Fade', 'gyan-elements' ),
			'sb'     => esc_html__( 'Sweep to Bottom', 'gyan-elements' ),
			'st'     => esc_html__( 'Sweep to Top', 'gyan-elements' ),
			'sr'     => esc_html__( 'Sweep to Right', 'gyan-elements' ),
			'sl'     => esc_html__( 'Sweep to Left', 'gyan-elements' ),
			'co'     => esc_html__( 'Circle Out', 'gyan-elements' ),
			'cs'     => esc_html__( 'Square Out', 'gyan-elements' ),
			'br-et'  => esc_html__( 'Border Top - Expand', 'gyan-elements' ),
			'br-eb'  => esc_html__( 'Border Bottom - Expand', 'gyan-elements' ),
			'br-tsr' => esc_html__( 'Border Top -  Sweep to Right', 'gyan-elements' ),
			'br-tsl' => esc_html__( 'Border Top : Sweep to Left', 'gyan-elements' ),
			'br-bsr' => esc_html__( 'Border Bottom -  Sweep to Right', 'gyan-elements' ),
			'br-bsl' => esc_html__( 'Border Bottom : Sweep to Left', 'gyan-elements' ),
			'br-tt'  => esc_html__( 'Thick Top Border', 'gyan-elements' ),
			'br-tb'  => esc_html__( 'Thick Bottom Border', 'gyan-elements' ),
			'br-ttb' => esc_html__( 'Thick Top & Bottom Border', 'gyan-elements' ),
		];
	}

	public static function posts_content($obj) {
		$obj->add_control(
			'posts_num',
			[
				'label' => esc_html__( 'Number of Posts', 'gyan-elements' ),
				'type' => Controls_Manager::NUMBER,
				'step' => 1,
				'min' => 1,
				'max' => 50,
				'default' => 3,
			]
		);
		$obj->add_control(
			'offset',
			[
				'label' => esc_html__( 'Number of Offset', 'gyan-elements' ),
				'type' => Controls_Manager::NUMBER,
				'step' => 1,
				'min' => 0,
				'max' => 50,
				'default' => 0,
			]
		);
		$obj->add_control(
			'order_by',
			[
				'label' => esc_html__( 'Order by', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'date' => esc_html__( 'Date', 'gyan-elements' ),
					'title' => esc_html__( 'Title', 'gyan-elements' ),
					'author' => esc_html__( 'Author', 'gyan-elements' ),
					'modified' => esc_html__( 'Modified', 'gyan-elements' ),
					'comment_count' => esc_html__( 'Comments', 'gyan-elements' ),
				],
				'default' => 'date',
			]
		);
		$obj->add_control(
			'sort',
			[
				'label' => esc_html__( 'Sort', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'ASC' => esc_html__( 'ASC', 'gyan-elements' ),
					'DESC' => esc_html__( 'DESC', 'gyan-elements' ),
				],
				'default' => 'DESC',
			]
		);
	}

	public static function carousel_content( $obj, $class = '', $cond = true ) {
		$obj->add_control(
			'autoplay',
			[
				'label' => esc_html__( 'Autoplay', 'gyan-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'gyan-elements' ),
				'label_off' => esc_html__( 'Off', 'gyan-elements' ),
				'default' => 'yes',
			]
		);
		$obj->add_control(
			'pause',
			[
				'label' => esc_html__( 'Pause on Hover', 'gyan-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'gyan-elements' ),
				'label_off' => esc_html__( 'Off', 'gyan-elements' ),
				'default' => 'yes',
			]
		);
		$obj->add_control(
			'mouse_drag',
			[
				'label' => esc_html__( 'Mouse Drag', 'gyan-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'gyan-elements' ),
				'label_off' => esc_html__( 'Off', 'gyan-elements' ),
				'default' => 'yes',
			]
		);
		$obj->add_control(
			'touch_drag',
			[
				'label' => esc_html__( 'Touch Drag', 'gyan-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'gyan-elements' ),
				'label_off' => esc_html__( 'Off', 'gyan-elements' ),
				'default' => 'yes',
			]
		);
		$obj->add_control(
			'loop',
			[
				'label' => esc_html__( 'Infinity Loop', 'gyan-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'gyan-elements' ),
				'label_off' => esc_html__( 'Off', 'gyan-elements' ),
				'default' => 'yes',
			]
		);

		if ($cond) {
			$obj->add_control(
				'dots',
				[
					'label' => esc_html__( 'Dots', 'gyan-elements' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'gyan-elements' ),
					'label_off' => esc_html__( 'Hide', 'gyan-elements' ),
					'default' => 'yes',
				]
			);
			$obj->add_control(
				'dots_color',
				[
					'label' => esc_html__( 'Dots Color', 'gyan-elements' ),
					'type' => Controls_Manager::COLOR,
					'condition' => [
						'dots!' => '',
					],
					'default' => '#d83030',
					'selectors' => [
						'{{WRAPPER}} '.$class.' .owl-dot' => 'border-color: {{VALUE}}',
						'{{WRAPPER}} '.$class.' .owl-dot.active' => 'background-color: {{VALUE}}',
					]
				]
			);
			$obj->add_control(
				'nav',
				[
					'label' => esc_html__( 'Navigation', 'gyan-elements' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'gyan-elements' ),
					'label_off' => esc_html__( 'Hide', 'gyan-elements' ),
					'default' => 'yes',
				]
			);
			$obj->add_control(
				'nav_bg',
				[
					'label' => esc_html__( 'Navigation Background', 'gyan-elements' ),
					'type' => Controls_Manager::COLOR,
					'condition' => [
						'nav!' => '',
					],
					'default' => '#d83030',
					'selectors' => [
						'{{WRAPPER}} '.$class.' .owl-prev, {{WRAPPER}} '.$class.' .owl-next' => 'background-color: {{VALUE}}'
					]
				]
			);
			$obj->add_control(
				'nav_color',
				[
					'label' => esc_html__( 'Navigation Color', 'gyan-elements' ),
					'type' => Controls_Manager::COLOR,
					'condition' => [
						'nav!' => '',
					],
					'default' => '#fff',
					'selectors' => [
						'{{WRAPPER}} '.$class.' .owl-prev, {{WRAPPER}} '.$class.' .owl-next' => 'color: {{VALUE}}'
					],
				]
			);
			$obj->add_control(
				'nav_top',
				[
					'label' => esc_html__( 'Navigation Top (%)', 'gyan-elements' ),
					'type' => Controls_Manager::SLIDER,
					'default' => [
						'unit' => '%',
						'size' => '50',
					],
					'condition' => [
						'nav!' => '',
					],
					'selectors' => [
						'{{WRAPPER}} '.$class.' .owl-prev, {{WRAPPER}} '.$class.' .owl-next' => 'top: calc({{SIZE}}{{UNIT}} - 18px);',
					],
				]
			);
		}

		$obj->add_control(
			'delay',
			[
				'label' => esc_html__( 'Delay', 'gyan-elements' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 5000,
				'step' => 100,
				'min' => 1000,
				'max' => 15000,
			]
		);
	}

	public static function button_content( $obj, $class = '', $label = 'Learn More', $prefix = 'btn', $cond = true ) {
		$obj->add_control(
			$prefix.'_text',
			[
				'label' => esc_html__( 'Label', 'gyan-elements' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter Label', 'gyan-elements' ),
				'default' => $label,
			]
		);
		if ($cond) {
			$obj->add_control(
				$prefix.'_link',
				[
					'label' => esc_html__( 'Link', 'gyan-elements' ),
					'type' => Controls_Manager::URL,
					'default' => [
						'url' => '#',
					],
					'placeholder' => esc_html__( 'https://your-link.com', 'gyan-elements' ),
				]
			);
		}
		$obj->add_control(
			$prefix.'_icon',
			[
				'label' => esc_html__( 'Icon', 'elementor' ),
				'type' => Controls_Manager::ICONS
			]
		);
		$obj->add_control(
			$prefix.'_icon_align',
			[
				'label' => esc_html__( 'Icon Position', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'left' => esc_html__( 'Left', 'gyan-elements' ),
					'right' => esc_html__( 'Right', 'gyan-elements' ),
				],
				'default' => 'left',
				'condition' => [
					$prefix.'_icon!' => '',
				],
			]
		);
		$obj->add_responsive_control(
			$prefix.'_icon_space',
			[
				'label' => esc_html__( 'Icon Spacing', 'gyan-elements' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '5',
				],
				'condition' => [
					$prefix.'_icon!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} '.$class.' .gyan-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} '.$class.' .gyan-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);
	}

	public static function button_style( $obj, $class = '', $prefix = 'btn' ) {
		$obj->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => $prefix.'_typography',
				'fields_options' => [
					'typography' => [
						'default' =>'custom',
					],
					'font_size'   => [
						'default' => [
							'size' => '15',
						],
					],
					'line_height'   => [
						'default' => [
							'unit' => 'px',
							'size' => '20',
						],
					],
					'font_weight' => [
						'default' => '400',
					],
					'transform'   => [
						'default' => [
							'size' => 'uppercase',
						],
					],
				],
				'selector' => '{{WRAPPER}} '.$class,
			]
		);

		$obj->start_controls_tabs( $prefix.'_tabs' );

		$obj->start_controls_tab(
			$prefix.'_normal',
			[
				'label' => esc_html__( 'Normal', 'gyan-elements' ),
			]
		);
		$obj->add_control(
			$prefix.'_color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} '.$class => 'color: {{VALUE}};',
					'{{WRAPPER}} '.$class.' svg' => 'fill: {{VALUE}};',
				],
			]
		);
		$obj->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => $prefix.'_bg',
				'types' => [ 'classic', 'gradient' ],
				'fields_options' => [
					'background' => [
						'default' =>'classic',
					],
					'color' => [
						'default' => '#d83030',
					],
				],
				'selector' => '{{WRAPPER}} '.$class,
			]
		);
		$obj->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => $prefix.'_tshadow',
				'selector' => '{{WRAPPER}} '.$class,
			]
		);
		$obj->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => $prefix.'_shadow',
				'selector' => '{{WRAPPER}} '.$class,
			]
		);
		$obj->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => $prefix.'_border',
				'selector' => '{{WRAPPER}} '.$class,
			]
		);
		$obj->end_controls_tab();

		$obj->start_controls_tab(
			$prefix.'_hover',
			[
				'label' => esc_html__( 'Hover', 'gyan-elements' ),
			]
		);
		$obj->add_control(
			$prefix.'_hover_color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',

				'selectors' => [
					'{{WRAPPER}} '.$class.':hover, {{WRAPPER}} '.$class.':focus' => 'color: {{VALUE}};',
					'{{WRAPPER}} '.$class.':hover svg' => 'fill: {{VALUE}};',
				],
			]
		);
		$obj->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => $prefix.'_hover_bg',
				'types' => [ 'classic', 'gradient' ],
				'fields_options' => [
					'background' => [
						'default' =>'classic',
					],
					'color' => [
						'default' => '#252628',
					],
				],
				'selector' => '{{WRAPPER}} '.$class.':hover, {{WRAPPER}} '.$class.':focus',
			]
		);
		$obj->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => $prefix.'_hover_tshadow',
				'selector' => '{{WRAPPER}} '.$class.':hover, {{WRAPPER}} '.$class.':focus',
			]
		);
		$obj->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => $prefix.'_hover_shadow',
				'selector' => '{{WRAPPER}} '.$class.':hover, {{WRAPPER}} '.$class.':focus',
			]
		);
		$obj->add_control(
			$prefix.'_hover_border',
			[
				'label' => esc_html__( 'Border Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} '.$class.':hover, {{WRAPPER}} '.$class.':focus' => 'border-color: {{VALUE}};',
				],
			]
		);
		$obj->end_controls_tab();

		$obj->end_controls_tabs();
	}

		public static function filter_button( $obj, $class = '', $prefix = 'fbtn', $active = 'yes' ) {
		$obj->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => $prefix.'_typography',
				'fields_options' => [
					'typography' => [
						'default' =>'custom',
					],
					'font_size'   => [
						'default' => [
							'size' => '15',
						],
					],
					'line_height'   => [
						'default' => [
							'unit' => 'px',
							'size' => '20',
						],
					],
					'font_weight' => [
						'default' => '400',
					]
				],
				'selector' => '{{WRAPPER}} '.$class,
			]
		);

		$obj->start_controls_tabs( $prefix.'_tabs' );

		$obj->start_controls_tab(
			$prefix.'_normal',
			[
				'label' => esc_html__( 'Normal', 'gyan-elements' ),
			]
		);
		$obj->add_control(
			$prefix.'_color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#676767',
				'selectors' => [
					'{{WRAPPER}} '.$class => 'color: {{VALUE}};',
					'{{WRAPPER}} '.$class.' svg' => 'fill: {{VALUE}};',
				],
			]
		);
		$obj->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => $prefix.'_bg',
				'types' => [ 'classic', 'gradient' ],
				'fields_options' => [
					'background' => [
						'default' =>'classic',
					],
					'color' => [
						'default' => '#ffffff',
					],
				],
				'selector' => '{{WRAPPER}} '.$class,
			]
		);
		$obj->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => $prefix.'_tshadow',
				'selector' => '{{WRAPPER}} '.$class,
			]
		);
		$obj->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => $prefix.'_shadow',
				'selector' => '{{WRAPPER}} '.$class,
			]
		);

		$obj->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => $prefix.'_border',
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
							'right' => '1',
							'bottom' => '1',
							'left' => '1',
							'isLinked' => true,
						]
					],
				],
				'selector' => '{{WRAPPER}} '.$class,
			]
		);



		$obj->end_controls_tab();

		$obj->start_controls_tab(
			$prefix.'_hover',
			[
				'label' => esc_html__( 'Hover', 'gyan-elements' ),
			]
		);
		$obj->add_control(
			$prefix.'_hover_color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} '.$class.':hover, {{WRAPPER}} '.$class.':focus' => 'color: {{VALUE}};',
					'{{WRAPPER}} '.$class.':hover svg' => 'fill: {{VALUE}};',
				],
			]
		);
		$obj->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => $prefix.'_hover_bg',
				'types' => [ 'classic', 'gradient' ],
				'fields_options' => [
					'background' => [
						'default' =>'classic',
					],
					'color' => [
						'default' => '#d83030',
					],
				],
				'selector' => '{{WRAPPER}} '.$class.':hover, {{WRAPPER}} '.$class.':focus',
			]
		);
		$obj->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => $prefix.'_hover_tshadow',
				'selector' => '{{WRAPPER}} '.$class.':hover, {{WRAPPER}} '.$class.':focus',
			]
		);
		$obj->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => $prefix.'_hover_shadow',
				'selector' => '{{WRAPPER}} '.$class.':hover, {{WRAPPER}} '.$class.':focus',
			]
		);
		$obj->add_control(
			$prefix.'_hover_border',
			[
				'label' => esc_html__( 'Border Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#d83030',
				'selectors' => [
					'{{WRAPPER}} '.$class.':hover, {{WRAPPER}} '.$class.':focus' => 'border-color: {{VALUE}};',
				],
			]
		);
		$obj->end_controls_tab();


		if ( $active == 'yes' ) {

			$obj->start_controls_tab(
				$prefix.'_active',
				[
					'label' => esc_html__( 'Active', 'gyan-elements' ),
				]
			);
			$obj->add_control(
				$prefix.'_active_color',
				[
					'label' => esc_html__( 'Text Color', 'gyan-elements' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#ffffff',
					'selectors' => [
						'{{WRAPPER}} '.$class.'.is-checked' => 'color: {{VALUE}};',
						'{{WRAPPER}} '.$class.'.is-checked svg' => 'fill: {{VALUE}};',

					],
				]
			);
			$obj->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => $prefix.'_active_bg',
					'types' => [ 'classic', 'gradient' ],
					'fields_options' => [
					'background' => [
						'default' =>'classic',
					],
					'color' => [
						'default' => '#d83030',
					],
				],
					'selector' => '{{WRAPPER}} '.$class.'.is-checked',
				]
			);
			$obj->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name' => $prefix.'_active_tshadow',
					'selector' => '{{WRAPPER}} '.$class.'.is-checked',
				]
			);
			$obj->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => $prefix.'_active_shadow',
					'selector' => '{{WRAPPER}} '.$class.'.is-checked',
				]
			);
			$obj->add_control(
				$prefix.'_active_border',
				[
					'label' => esc_html__( 'Border Color', 'gyan-elements' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#d83030',
					'selectors' => [
						'{{WRAPPER}} '.$class.'.is-checked' => 'border-color: {{VALUE}};',
					],
				]
			);
			$obj->end_controls_tab();

		}

		$obj->end_controls_tabs();
	}

	public static function input_style( $obj, $class = '', $prefix = 'email' ) {
		$obj->add_responsive_control(
			$prefix.'_width',
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
				'selectors' => [
					'{{WRAPPER}} .gyan-input-field'.$class => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$obj->add_responsive_control(
			$prefix.'_radius',
			[
				'label' => esc_html__( 'Radius', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} '.$class => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$obj->add_responsive_control(
			$prefix.'_margin',
			[
				'label' => esc_html__( 'Margin', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} '.$class => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
	}

	public static function input_fields_style( $obj ) {
		$obj->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'fields_typography',
				'fields_options' => [
					'typography' => [
						'default' =>'custom',
					],
					'font_weight' => [
						'default' => '400',
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
				'selector' => '{{WRAPPER}} .gyan-input-field',
			]
		);
		$obj->add_control(
			'placeholder_color',
			[
				'label' => esc_html__( 'Placeholder Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#aaa',
				'selectors' => [
					'{{WRAPPER}} .gyan-input-field::-webkit-input-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .gyan-input-field::-moz-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .gyan-input-field::-ms-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .gyan-input-field::placeholder' => 'color: {{VALUE}};',
				],
			]
		);

		$obj->start_controls_tabs( 'field_tabs' );

		$obj->start_controls_tab(
			'fields_normal',
			[
				'label' => esc_html__( 'Normal', 'gyan-elements' ),
			]
		);

		$obj->add_control(
			'color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#111',
				'selectors' => [
					'{{WRAPPER}} .gyan-input-field' => 'color: {{VALUE}};',
				],
			]
		);
		$obj->add_control(
			'background',
			[
				'label' => esc_html__( 'Background', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .gyan-input-field' => 'background: {{VALUE}};',
				],
			]
		);
		$obj->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
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
							'right' => '1',
							'bottom' => '1',
							'left' => '1',
							'isLinked' => true,
						]
					],
				],
				'selector' => '{{WRAPPER}} .gyan-input-field',
			]
		);

		$obj->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'field_shadow',
				'selector' => '{{WRAPPER}} .gyan-input-field',
			]
		);

		$obj->end_controls_tab();

		$obj->start_controls_tab(
			'fields_focus',
			[
				'label' => esc_html__( 'Focus', 'gyan-elements' ),
			]
		);

		$obj->add_control(
			'focus_color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-input-field:focus' => 'color: {{VALUE}};',
				],
			]
		);
		$obj->add_control(
			'focus_background',
			[
				'label' => esc_html__( 'Background', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-input-field:focus' => 'background: {{VALUE}};',
				],
			]
		);
		$obj->add_control(
			'focus_border',
			[
				'label' => esc_html__( 'Border Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-input-field:focus' => 'border-color: {{VALUE}}'
				],
			]
		);

		$obj->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'field_shadow_hover',
				'selector' => '{{WRAPPER}} .gyan-input-field:focus',
			]
		);

		$obj->end_controls_tab();

		$obj->end_controls_tabs();
	}

	public static function button_html( $data, $prefix = 'btn' ) {
		if ( $data[$prefix.'_icon'] && $data[$prefix.'_icon_align'] == 'left' ):
			Icons_Manager::render_icon( $data[$prefix.'_icon'], [ 'aria-hidden' => 'true','class' => 'gyan-icon-left' ] );
		endif;
		printf( '%s', $data[$prefix.'_text'] );
		if ( $data[$prefix.'_icon'] && $data[$prefix.'_icon_align'] == 'right' ):
			Icons_Manager::render_icon( $data[$prefix.'_icon'], [ 'aria-hidden' => 'true','class' => 'gyan-icon-right' ] );
		endif;
	}
}