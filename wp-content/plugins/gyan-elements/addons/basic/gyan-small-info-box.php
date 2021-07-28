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

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Gyan_Small_Info_Box extends Widget_Base {

	public function get_name()       { return 'gyan_small_info_box'; }
	public function get_title()      { return esc_html__( 'Small Info Box', 'gyan-elements' ); }
	public function get_icon()       { return 'gyan-el-icon eicon-info-box'; }
	public function get_categories() { return ['gyan-basic-addons']; }
	public function get_keywords()   { return ['small info box', 'content box', 'box','icon','service' ]; }
	public function get_style_depends()  { return ['gyan-icon','gyan-animation-box','gyan-small-info-box']; }

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
			'subtitle_text',
			[
				'label'   => esc_html__( 'Subtitle', 'gyan-elements' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'sub title text', 'gyan-elements' ),
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
					'icon_content' => esc_html__( 'Icon and Content', 'gyan-elements' ),
					'infobox'      => esc_html__( 'Info Box', 'gyan-elements' ),
				]
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
		$this->add_responsive_control(
			'align',
			[
				'label'     => esc_html__( 'Alignment', 'gyan-elements' ),
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
				'prefix_class'  => 'gyan-small-infobox-align-',
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
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-small-info-box' => 'height: {{SIZE}}{{UNIT}};',
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
				'selectors' => [
					'{{WRAPPER}} .gyan-small-info-box' => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'info_box_border',
				'label'       => esc_html__( 'Border', 'gyan-elements' ),
				'selector'    => '{{WRAPPER}} .gyan-small-info-box',
			]
		);
		$this->add_control(
			'info_box_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-small-info-box,
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
					'{{WRAPPER}} .gyan-small-info-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .gyan-small-info-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// Title Style -----------------------

		$this->start_controls_section(
			'section_title_subtitle_style',
			[
				'label' => esc_html__( 'Title/Sub Title', 'gyan-elements' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'gyan-elements' ),
				'selector' => '{{WRAPPER}} .gyan-small-infobox-title',
			]
		);

		$this->add_responsive_control(
			'title_maxwidth',
			[
				'label' => esc_html__( 'Maximum Width', 'gyan-elements' ),
				'type'  => Controls_Manager::SLIDER,
				'default'    => [
					'size' => 200,
				],
				'range' => [
					'px' => [
						'min' => 30,
						'max' => 1200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-small-infobox-title' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label'      => esc_html__( 'Margin Bottom', 'gyan-elements' ),
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
					'{{WRAPPER}} .gyan-small-infobox-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'subtitle_heading',
			[
				'label'     => esc_html__( 'Sub Title', 'gyan-elements' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'subtitle_text!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'subtitle_typography',
				'label'     => esc_html__( 'Typography', 'gyan-elements' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'condition' => [
					'subtitle_text!' => '',
				],
				'selector'  => '{{WRAPPER}} .gyan-small-infobox-subtitle',
			]
		);

		$this->add_responsive_control(
			'subtitle_maxwidth',
			[
				'label' => esc_html__( 'Maximum Width', 'gyan-elements' ),
				'type'  => Controls_Manager::SLIDER,
				'default'    => [
					'size' => 200,
				],
				'range' => [
					'px' => [
						'min' => 30,
						'max' => 1200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-small-infobox-subtitle' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'subtitle_margin',
			[
				'label'      => esc_html__( 'Margin Bottom', 'gyan-elements' ),
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
					'subtitle_text!' => '',
				],
				'selectors'  => [
					'{{WRAPPER}} .gyan-small-infobox-subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .gyan-small-infobox-icon-holder' => 'font-size: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .gyan-small-infobox-image img' => 'width: {{SIZE}}{{UNIT}}',
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
				'selector'  => '{{WRAPPER}} .gyan-small-infobox-text',
			]
		);

		$this->add_responsive_control(
			'icon_margin',
			[
				'label'      => esc_html__( 'Margin Bottom', 'gyan-elements' ),
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
					'{{WRAPPER}} .gyan-small-infobox-icon-holder' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'icon_box_size',
			[
				'label'      => esc_html__( 'Box Size', 'gyan-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min'  => 5,
						'max'  => 100,
						'step' => 1,
					],
				],
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-small-infobox-icon-holder' => 'height: calc({{SIZE}}{{UNIT}} * 2); width: calc({{SIZE}}{{UNIT}} * 2);',
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
					'{{WRAPPER}} .gyan-small-infobox-icon-holder' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'icon_border',
				'label'       => esc_html__( 'Border', 'gyan-elements' ),
				'selector'    => '{{WRAPPER}} .gyan-small-infobox-icon-holder',
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
				'selectors' => [
					'{{WRAPPER}} .gyan-small-infobox-icon-holder' => 'transform: rotate({{SIZE}}{{UNIT}});',
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
				'selectors' => [
					'{{WRAPPER}} .gyan-small-infobox-icon,
					{{WRAPPER}} .gyan-small-infobox-image,
					{{WRAPPER}} .gyan-small-infobox-text' => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
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
						'fields_options' => [
							'background' => [
								'default' =>'classic',
							],
							'color' => [
								'default' => '#ffffff',
							],
						],
				        'selector' => '{{WRAPPER}} .gyan-small-info-box',
				    ]
				);

				$this->add_group_control(
				    Group_Control_Box_Shadow::get_type(),
				    [
				        'name' => 'info_box_shadow',
				        'label' => esc_html__( 'Info Box - Box Shadow', 'gyan-elements' ),
				        'selector' => '{{WRAPPER}} .gyan-small-info-box',
				    ]
				);

				$this->add_control(
					'title_subtitle_color_heading',
					[
						'label'     => esc_html__( 'Title/Sub Title', 'gyan-elements' ),
						'type'      => Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);

				$this->add_control(
					'title_color',
					[
						'label'     => esc_html__( 'Title Color', 'gyan-elements' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#032e42',
						'selectors' => [
							'{{WRAPPER}} .gyan-small-info-box .gyan-small-infobox-title,
							{{WRAPPER}} .gyan-small-info-box .gyan-small-infobox-title a' => 'color: {{VALUE}}',
						],
					]
				);

				$this->add_control(
					'subtitle_color',
					[
						'label'     => esc_html__( 'Sub Title Color', 'gyan-elements' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#676767',
						'condition' => [
							'subtitle_text!' => '',
						],
						'selectors' => [
							'{{WRAPPER}} .gyan-small-info-box .gyan-small-infobox-subtitle,
							{{WRAPPER}} .gyan-small-info-box .gyan-small-infobox-subtitle a' => 'color: {{VALUE}}',
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
							'{{WRAPPER}} .gyan-small-info-box .gyan-small-infobox-icon,
							{{WRAPPER}} .gyan-small-info-box .gyan-small-infobox-text' => 'color: {{VALUE}}',
							'{{WRAPPER}} .gyan-small-info-box .gyan-small-infobox-icon svg' => 'fill: {{VALUE}}',
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
				        'selector' => '{{WRAPPER}} .gyan-small-info-box .gyan-small-infobox-icon-holder',
				    ]
				);

				$this->add_group_control(
				    Group_Control_Box_Shadow::get_type(),
				    [
				        'name' => 'icon_box_shadow',
				        'label' => esc_html__( 'Icon Box - Box Shadow', 'gyan-elements' ),
				        'selector' => '{{WRAPPER}} .gyan-small-info-box .gyan-small-infobox-icon-holder',
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
						'fields_options' => [
							'background' => [
								'default' =>'classic',
							],
							'color' => [
								'default' => '#ffffff',
							],
						],
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
				            '{{WRAPPER}} .gyan-small-info-box:hover' => 'border-color: {{VALUE}};'
				        ],
				    ]
				);

				$this->add_group_control(
				    Group_Control_Box_Shadow::get_type(),
				    [
				        'name' => 'info_box_shadow_hover',
				        'label' => esc_html__( 'Info Box - Box Shadow', 'gyan-elements' ),
				        'selector' => '{{WRAPPER}} .gyan-small-info-box:hover',
				    ]
				);

				$this->add_control(
					'title_subtitle_color_heading_hover',
					[
						'label'     => esc_html__( 'Title/Sub Title', 'gyan-elements' ),
						'type'      => Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);

				$this->add_control(
					'title_color_hover',
					[
						'label'     => esc_html__( 'Title Color', 'gyan-elements' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#032e42',
						'selectors' => [
							'{{WRAPPER}} .gyan-small-info-box:hover .gyan-small-infobox-title,
							{{WRAPPER}} .gyan-small-info-box:hover .gyan-small-infobox-title a' => 'color: {{VALUE}}',
						],
					]
				);

				$this->add_control(
					'subtitle_color_hover',
					[
						'label'     => esc_html__( 'Sub Title Color', 'gyan-elements' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#676767',
						'condition' => [
							'subtitle_text!' => '',
						],
						'selectors' => [
							'{{WRAPPER}} .gyan-small-info-box:hover .gyan-small-infobox-subtitle,
							{{WRAPPER}} .gyan-small-info-box:hover .gyan-small-infobox-subtitle a' => 'color: {{VALUE}}',
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
					'icon_color_normal_hover',
					[
						'label'     => esc_html__( 'Icon Color', 'gyan-elements' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#d83030',
						'selectors' => [
							'{{WRAPPER}} .gyan-small-info-box:hover .gyan-small-infobox-icon,
							{{WRAPPER}} .gyan-small-info-box:hover .gyan-small-infobox-text' => 'color: {{VALUE}}',
							'{{WRAPPER}} .gyan-small-info-box:hover .gyan-small-infobox-icon svg' => 'fill: {{VALUE}}',
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
				        'selector' => '{{WRAPPER}} .gyan-small-info-box:hover .gyan-small-infobox-icon-holder',
				    ]
				);

				$this->add_group_control(
				    Group_Control_Box_Shadow::get_type(),
				    [
				        'name' => 'icon_box_shadow_hover',
				        'label' => esc_html__( 'Icon Box - Box Shadow', 'gyan-elements' ),
				        'selector' => '{{WRAPPER}} .gyan-small-info-box:hover .gyan-small-infobox-icon-holder',
				    ]
				);

				$this->add_control(
				    'icon_box_border_hover',
				    [
				        'label' => esc_html__( 'Icon Box Border Color', 'gyan-elements' ),
				        'type' => Controls_Manager::COLOR,
				        'selectors' => [
				            '{{WRAPPER}} .gyan-small-info-box:hover .gyan-small-infobox-icon-holder' => 'border-color: {{VALUE}};'
				        ],
				    ]
				);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$this->add_render_attribute(
		    'gyan_small_info_box',
		    [
		        'class' => ['gyan-small-info-box gyan-animation-box gyan-ease-transition']
		    ]
		);

		if ( !empty( $settings['link']['url'] ) ) {
			$this->add_render_attribute( 'infobox_link', 'href', esc_url($settings['link']['url']) );
			$this->add_render_attribute( 'infobox_link', 'class', 'gyan-small-infobox-link gyan-ease-transition' );

			if ( $settings['link']['is_external'] ) {
				$this->add_render_attribute( 'infobox_link', 'target', '_blank' );
			}
			if ( $settings['link']['nofollow'] ) {
				$this->add_render_attribute( 'infobox_link', 'rel', 'nofollow' );
			}

			if ( 'infobox' == $settings['link_place'] ) {
				$this->add_render_attribute( 'infobox_link', 'class', 'gyan-small-infobox-over-link' );
			}
		}

		?>

		<div <?php echo $this->get_render_attribute_string('gyan_small_info_box'); ?>>

			<?php if ( !empty( $settings['link']['url'] ) && 'infobox' == $settings['link_place'] ) { ?>
				<a <?php echo $this->get_render_attribute_string( 'infobox_link' ); ?>></a>
			<?php } ?>

			<?php if ( 'none' != $settings['icon_type'] ) : ?>

				<div class="gyan-small-infobox-icon-holder gyan-ease-transition">

					<?php if ( !empty( $settings['link']['url'] ) && 'icon_content' == $settings['link_place'] ) { ?>
						<a <?php echo $this->get_render_attribute_string( 'infobox_link' ); ?>></a>
					<?php } ?>

					<?php if ( 'icon' == $settings['icon_type'] ) { ?>
						<span class="gyan-small-infobox-icon gyan-icon gyan-ease-transition"><?php Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
					<?php } ?>

					<?php if ( 'image' == $settings['icon_type'] ) { ?>
						<span class="gyan-small-infobox-image">
							<?php
                                if ( ! empty( $settings['image']['url'] ) ) {
                                    echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'image', 'image' );
                                }
                            ?>
						</span>
					<?php } ?>

					<?php if ( 'text' == $settings['icon_type'] ) { ?>
						<span class="gyan-small-infobox-text gyan-ease-transition"><?php echo $settings['icon_text']; ?></span>
					<?php } ?>

				</div>

			<?php endif; ?>

			<?php if ( '' != $settings['title_text'] ) : ?>

				<<?php echo $settings['title_html_tag']; ?> class="gyan-small-infobox-title gyan-ease-transition">
					<?php if ( !empty( $settings['link']['url'] ) && 'icon_content' == $settings['link_place'] ) { ?>
						<a <?php echo $this->get_render_attribute_string( 'infobox_link' ); ?>>
					<?php } ?>
					<?php echo $settings['title_text']; ?>
					<?php if ( !empty( $settings['link']['url'] ) && 'icon_content' == $settings['link_place'] ) { ?>
						</a>
					<?php } ?>
				</<?php echo $settings['title_html_tag']; ?>>

			<?php endif; ?>

			<?php if ( '' != $settings['subtitle_text'] ) : ?>

				<div class="gyan-small-infobox-subtitle gyan-ease-transition">
					<?php if ( !empty( $settings['link']['url'] ) && 'icon_content' == $settings['link_place'] ) { ?>
						<a <?php echo $this->get_render_attribute_string( 'infobox_link' ); ?>>
					<?php } ?>
					<?php echo $settings['subtitle_text']; ?>
					<?php if ( !empty( $settings['link']['url'] ) && 'icon_content' == $settings['link_place'] ) { ?>
						</a>
					<?php } ?>
				</div>

			<?php endif; ?>

		</div>

	<?php

	}
}