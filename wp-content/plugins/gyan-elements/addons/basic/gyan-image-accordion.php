<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Control_Media;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Gyan_Image_Accordion extends Widget_Base {

    public function get_name()           { return 'gyan_image_accordion'; }
    public function get_title()          { return esc_html__( 'Image Accordion', 'gyan-elements' ); }
    public function get_icon()           { return 'gyan-el-icon eicon-accordion'; }
    public function get_categories()     { return ['gyan-basic-addons']; }
    public function get_keywords()       { return [ 'gyan image accordion', 'image', 'accordion','gallery' ]; }
    public function get_style_depends()  { return ['gyan-icon','gyan-image-accordion']; }
    public function get_script_depends() {
        return [ 'gyan-widgets' ];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_items',
            [
                'label' => esc_html__( 'Items', 'gyan-elements' )
            ]
        );

        $repeater = new Repeater();

        $repeater->start_controls_tabs( 'image_accordion_tabs' );

        $repeater->start_controls_tab( 'tab_content', [ 'label' => esc_html__( 'Content', 'gyan-elements' ) ] );

        $repeater->add_control(
			'title',
			[
                'label'                 => esc_html__( 'Title', 'gyan-elements' ),
                'type'                  => Controls_Manager::TEXT,
                'label_block'           => true,
                'default'               => esc_html__( 'Accordion Title', 'gyan-elements' ),
                'dynamic'               => [
                    'active'   => true,
                ],
			]
		);

        $repeater->add_control(
			'description',
			[
                'label'                 => esc_html__( 'Description', 'gyan-elements' ),
                'type'                  => Controls_Manager::WYSIWYG,
                'label_block'           => true,
                'default'               => esc_html__( 'Click on left side accordion tabs  to change title and description text. Fusce pretium, est at aliquam semper, leo ante facilisis risus in feugiat ipsum augue pellent esque metu at luctus fserf oieoenrps metus.', 'gyan-elements' ),
                'dynamic'               => [
                    'active'   => true,
                ],
			]
		);

        $repeater->end_controls_tab();

        $repeater->start_controls_tab( 'tab_image', [ 'label' => esc_html__( 'Image', 'gyan-elements' ) ] );

        $repeater->add_control(
			'image',
			[
                'label'                 => esc_html__( 'Choose Image', 'gyan-elements' ),
                'type'                  => Controls_Manager::MEDIA,
                'label_block'           => true,
                'dynamic'               => [
                    'active'   => true,
                ],
                'default'               => [
                    'url' => GYAN_PLUGIN_URL .'addons/images/portfolio2.jpg',
                ],
			]
		);

        $repeater->end_controls_tab();

        $repeater->start_controls_tab( 'tab_link', [ 'label' => esc_html__( 'Link', 'gyan-elements' ) ] );

        $repeater->add_control(
            'show_button',
            [
                'label'                 => esc_html__( 'Show Button', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => '',
                'label_on'              => esc_html__( 'Yes', 'gyan-elements' ),
                'label_off'             => esc_html__( 'No', 'gyan-elements' ),
                'return_value'          => 'yes',
            ]
        );

        $repeater->add_control(
			'link',
			[
                'label'                 => esc_html__( 'Link', 'gyan-elements' ),
                'type'                  => Controls_Manager::URL,
                'label_block'           => true,
                'default'               => [
                    'url'           => '#',
                    'is_external'   => '',
                ],
                'show_external'         => true,
                'condition'             => [
                    'show_button'   => 'yes',
                ],
			]
		);

        $repeater->add_control(
            'button_text',
            [
                'label'                 => esc_html__( 'Button Text', 'gyan-elements' ),
                'type'                  => Controls_Manager::TEXT,
                'dynamic'               => [
                    'active'   => true,
                ],
                'default'               => esc_html__( 'Get Started', 'gyan-elements' ),
                'condition'             => [
                    'show_button'   => 'yes',
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
                'condition'             => [
                    'show_button'   => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'button_icon_position',
            [
                'label'                 => esc_html__( 'Icon Position', 'gyan-elements' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => 'after',
                'options'               => [
                    'before'    => esc_html__( 'Before', 'gyan-elements' ),
                    'after'     => esc_html__( 'After', 'gyan-elements' ),
                ],
                'condition'             => [
                    'show_button'   => 'yes',
                    'button_icon!'  => '',
                ],
            ]
        );

        $repeater->end_controls_tab();

        $repeater->end_controls_tabs();

        $this->add_control(
            'accordion_items',
            [
                'type'                  => Controls_Manager::REPEATER,
                'fields'                => $repeater->get_controls(),
                'seperator'             => 'before',
                'default'               => [
                    [
                        'title'         => esc_html__( 'Accordion #1', 'gyan-elements' ),
                        'description'   => esc_html__( 'Click left side Accordion #1 tab to change this text. Fusce pretium, est at aliquam semper, leo ante facilisis risus in feugiat ipsum augue pellent esque metu at luctus fserf oieoenrps metus.', 'gyan-elements' ),
                        'image'         => [
                            'url' => GYAN_PLUGIN_URL .'addons/images/portfolio1.jpg',
                        ]
                    ],
                    [
                        'title'         => esc_html__( 'Accordion #2', 'gyan-elements' ),
                        'description'   => esc_html__( 'Click left side Accordion #2 change this text. Fusce pretium, est at aliquam semper, leo ante facilisis risus in feugiat ipsum augue pellent esque metu at luctus fserf oieoenrps metus.', 'gyan-elements' ),
                        'image'         => [
                            'url' => GYAN_PLUGIN_URL .'addons/images/portfolio2.jpg',
                        ]
                    ],
                    [
                        'title'         => esc_html__( 'Accordion #3', 'gyan-elements' ),
                        'description'   => esc_html__( 'Click left side Accordion #3 to change this text. Fusce pretium, est at aliquam semper, leo ante facilisis risus in feugiat ipsum augue pellent esque metu at luctus fserf oieoenrps metus.', 'gyan-elements' ),
                        'image'         => [
                            'url' => GYAN_PLUGIN_URL .'addons/images/portfolio3.jpg',
                        ]
                    ],
                    [
                        'title'         => esc_html__( 'Accordion #4', 'gyan-elements' ),
                        'description'   => esc_html__( 'Click left side Accordion #4 to change this text. Fusce pretium, est at aliquam semper, leo ante facilisis risus in feugiat ipsum augue pellent esque metu at luctus fserf oieoenrps metus.', 'gyan-elements' ),
                        'image'         => [
                            'url' => GYAN_PLUGIN_URL .'addons/images/portfolio4.jpg',
                        ]
                    ],
                  ],
                'title_field' => '{{title}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_image_accordion_settings',
            [
                'label'                 => esc_html__( 'Settings', 'gyan-elements' )
            ]
        );

        $this->add_responsive_control(
            'accordion_height',
            [
                'label'                 => esc_html__( 'Height', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px'        => [
                        'min'   => 50,
                        'max'   => 1000,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px' ],
				'default'               => [
					'size' => 400,
					'unit' => 'px',
				],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-accordion' => 'height: {{SIZE}}px',
                ],
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

        $this->add_control(
            'orientation',
            [
                'label'                 => esc_html__( 'Orientation', 'gyan-elements' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => 'vertical',
                'label_block'           => false,
                'options'               => [
                    'vertical'      => esc_html__( 'Vertical', 'gyan-elements' ),
                    'horizontal'    => esc_html__( 'Horizontal', 'gyan-elements' ),
                ],
                'frontend_available'    => true,
                'prefix_class'          => 'gyan-image-accordion-',
            ]
        );

        $this->add_control(
            'stack_on',
            [
                'label'                 => esc_html__( 'Stack On', 'gyan-elements' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => 'tablet',
                'label_block'           => false,
                'options'               => [
                    'tablet'    => esc_html__( 'Tablet', 'gyan-elements' ),
                    'mobile'    => esc_html__( 'Mobile', 'gyan-elements' ),
                    'none'      => esc_html__( 'None', 'gyan-elements' ),
                ],
                'frontend_available'    => true,
                'prefix_class'          => 'gyan-image-accordion-stack-on-',
                'condition'             => [
                    'orientation'   => 'vertical',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_items_style',
            [
                'label'                 => esc_html__( 'Items', 'gyan-elements' ),
                'tab'                   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'items_spacing',
            [
                'label'                 => esc_html__( 'Items Spacing', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 50,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px' ],
				'default'               => [
					'size' => '',
					'unit' => 'px',
				],
                'selectors'             => [
                    '(desktop){{WRAPPER}}.gyan-image-accordion-vertical .gyan-image-accordion-item:not(:last-child)' => 'margin-right: {{SIZE}}px',
                    '(desktop){{WRAPPER}}.gyan-image-accordion-horizontal .gyan-image-accordion-item:not(:last-child)' => 'margin-bottom: {{SIZE}}px',
                    '(tablet){{WRAPPER}}.gyan-image-accordion-vertical.gyan-image-accordion-stack-on-tablet .gyan-image-accordion-item:not(:last-child)' => 'margin-bottom: {{SIZE}}px;',
                    '(mobile){{WRAPPER}}.gyan-image-accordion-vertical.gyan-image-accordion-stack-on-mobile .gyan-image-accordion-item:not(:last-child)' => 'margin-bottom: {{SIZE}}px;',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_items_style' );

        $this->start_controls_tab(
            'tab_items_normal',
            [
                'label'                 => esc_html__( 'Normal', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'accordion_img_overlay_color',
            [
                'label'                 => esc_html__( 'Overlay Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => 'rgba(0,0,0,0.3)',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-accordion-item .gyan-image-accordion-overlay' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'                  => 'items_border',
                'label'                 => esc_html__( 'Border', 'gyan-elements' ),
                'selector'              => '{{WRAPPER}} .gyan-image-accordion-item',
            ]
        );

		$this->add_control(
			'items_border_radius',
			[
				'label'                 => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .gyan-image-accordion-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'                  => 'items_box_shadow',
                'selector'              => '{{WRAPPER}} .gyan-image-accordion-item',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_items_hover',
            [
                'label'                 => esc_html__( 'Hover', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'accordion_img_hover_color',
            [
                'label'                 => esc_html__( 'Overlay Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => 'rgba(0,0,0,0.5)',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-accordion-item:hover .gyan-image-accordion-overlay' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .gyan-image-accordion-item.gyan-image-accordion-active .gyan-image-accordion-overlay' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'items_border_color_hover',
            [
                'label'                 => esc_html__( 'Border Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-accordion-item:hover, {{WRAPPER}} .gyan-image-accordion-item.gyan-image-accordion-active' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'                  => 'items_box_shadow_hover',
                'selector'              => '{{WRAPPER}} .gyan-image-accordion-item:hover, {{WRAPPER}} .gyan-image-accordion-item.gyan-image-accordion-active',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
         * Style Tab: Content
         */
        $this->start_controls_section(
            'section_content_style',
            [
                'label'                 => esc_html__( 'Content', 'gyan-elements' ),
                'tab'                   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'content_bg_color',
            [
                'label'                 => esc_html__( 'Background Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-accordion .gyan-image-accordion-content' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'                  => 'content_border',
                'label'                 => esc_html__( 'Border', 'gyan-elements' ),
                'selector'              => '{{WRAPPER}} .gyan-image-accordion .gyan-image-accordion-content',
                'separator'             => 'before',
            ]
        );

		$this->add_control(
			'content_border_radius',
			[
				'label'                 => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .gyan-image-accordion .gyan-image-accordion-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
            'content_vertical_align',
            [
                'label'                 => esc_html__( 'Vertical Align', 'gyan-elements' ),
                'type'                  => Controls_Manager::CHOOSE,
                'default'               => 'middle',
                'options'               => [
                    'top'    	=> [
                        'title' => esc_html__( 'Top', 'gyan-elements' ),
                        'icon' 	=> 'eicon-v-align-top',
                    ],
                    'middle' 	=> [
                        'title' => esc_html__( 'Middle', 'gyan-elements' ),
                        'icon' 	=> 'eicon-v-align-middle',
                    ],
                    'bottom' 	=> [
                        'title' => esc_html__( 'Bottom', 'gyan-elements' ),
                        'icon' 	=> 'eicon-v-align-bottom',
                    ],
                ],
				'selectors_dictionary'  => [
					'top'       => 'flex-start',
					'middle'    => 'center',
					'bottom'    => 'flex-end',
				],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-accordion .gyan-image-accordion-overlay' => '-webkit-align-items: {{VALUE}}; -ms-flex-align: {{VALUE}}; align-items: {{VALUE}};',
                ],
                'separator'             => 'before',
            ]
        );

        $this->add_responsive_control(
			'content_horizontal_align',
			[
				'label'                 => esc_html__( 'Horizontal Align', 'gyan-elements' ),
				'type'                  => Controls_Manager::CHOOSE,
				'label_block'           => true,
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
				'default'               => 'center',
                'selectors_dictionary'  => [
					'left'     => 'flex-start',
					'center'   => 'center',
					'right'    => 'flex-end',
				],
				'selectors'             => [
					'{{WRAPPER}} .gyan-image-accordion .gyan-image-accordion-overlay' => '-webkit-justify-content: {{VALUE}}; justify-content: {{VALUE}};',
                    '{{WRAPPER}} .gyan-image-accordion .gyan-image-accordion-content-wrap' => '-webkit-align-items: {{VALUE}}; -ms-flex-align: {{VALUE}}; align-items: {{VALUE}};',
				],
			]
		);

        $this->add_responsive_control(
            'text_align',
            [
                'label'                 => esc_html__( 'Text Align', 'gyan-elements' ),
                'type'                  => Controls_Manager::CHOOSE,
                'default'               =>' center',
                'options'               => [
                    'left'      => [
                        'title' => esc_html__( 'Left', 'gyan-elements' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' 	=> [
                        'title' => esc_html__( 'Center', 'gyan-elements' ),
                        'icon' 	=> 'fa fa-align-center',
                    ],
                    'right' 	=> [
                        'title' => esc_html__( 'Right', 'gyan-elements' ),
                        'icon'	=> 'fa fa-align-right',
                    ],
                ],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-accordion .gyan-image-accordion-content' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_width',
            [
                'label'                 => esc_html__( 'Width', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 1000,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px', '%' ],
				'default'               => [
					'size' => '',
					'unit' => 'px',
				],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-accordion .gyan-image-accordion-content' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'separator'             => 'before',
            ]
        );

		$this->add_responsive_control(
			'content_padding',
			[
				'label'                 => esc_html__( 'Padding', 'gyan-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .gyan-image-accordion .gyan-image-accordion-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
            'title_style_heading',
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
                'default'               => '#fff',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-accordion .gyan-image-accordion-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'title_typography',
                'selector'              => '{{WRAPPER}} .gyan-image-accordion .gyan-image-accordion-title',
            ]
        );

        $this->add_responsive_control(
            'title_spacing',
            [
                'label'                 => esc_html__( 'Spacing', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px' ],
				'default'               => [
					'size' => '',
					'unit' => 'px',
				],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-accordion .gyan-image-accordion-title' => 'margin-bottom: {{SIZE}}px',
                ],
            ]
        );

        $this->add_control(
            'description_style_heading',
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
                'default'               => '#fff',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-accordion .gyan-image-accordion-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'description_typography',
                'selector'              => '{{WRAPPER}} .gyan-image-accordion .gyan-image-accordion-description',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_button_style',
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
				'default'               => 'gyan-default',
				'options'               => [
					'gyan-default' => esc_html__( 'Default', 'gyan-elements' ),
                    'xs' => esc_html__( 'Extra Small', 'gyan-elements' ),
					'sm' => esc_html__( 'Small', 'gyan-elements' ),
					'md' => esc_html__( 'Medium', 'gyan-elements' ),
					'lg' => esc_html__( 'Large', 'gyan-elements' ),
					'xl' => esc_html__( 'Extra Large', 'gyan-elements' ),
				],
			]
		);

        $this->add_responsive_control(
            'button_margin',
            [
                'label'                 => esc_html__( 'Margin', 'gyan-elements' ),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => [ 'px', 'em', '%' ],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-accordion-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'default'               => '#d83030',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-accordion-button' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_text_color_normal',
            [
                'label'                 => esc_html__( 'Text Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#ffffff',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-accordion-button' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .gyan-image-accordion-button .gyan-icon svg' => 'fill: {{VALUE}}',
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
				'selector'              => '{{WRAPPER}} .gyan-image-accordion-button',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'                 => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .gyan-image-accordion-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'button_typography',
                'label'                 => esc_html__( 'Typography', 'gyan-elements' ),
                'scheme'                => Scheme_Typography::TYPOGRAPHY_4,
                'selector'              => '{{WRAPPER}} .gyan-image-accordion-button',
            ]
        );

		$this->add_responsive_control(
			'button_padding',
			[
				'label'                 => esc_html__( 'Padding', 'gyan-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .gyan-image-accordion-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'button_box_shadow',
				'selector'              => '{{WRAPPER}} .gyan-image-accordion-button',
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
                'default'               => '#252628',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-accordion-button:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_text_color_hover',
            [
                'label'                 => esc_html__( 'Text Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#ffffff',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-accordion-button:hover' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .gyan-image-accordion-button:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );

		$this->add_control(
			'button_hover_animation',
			[
				'label'                 => esc_html__( 'Animation', 'gyan-elements' ),
				'type'                  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'button_box_shadow_hover',
				'selector'              => '{{WRAPPER}} .gyan-image-accordion-button:hover',
			]
		);

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'button_icon_heading',
            [
                'label'                 => esc_html__( 'Icon', 'gyan-elements' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
            ]
        );

        $this->add_responsive_control(
            'button_icon_spacing',
            [
                'label'                 => esc_html__( 'Icon Spacing', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 50,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px' ],
				'default'               => [
					'size' => 15,
					'unit' => 'px',
				],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-button-icon-before .gyan-button-icon' => 'margin-right: {{SIZE}}px',
                    '{{WRAPPER}} .gyan-button-icon-after .gyan-button-icon' => 'margin-left: {{SIZE}}px',
                ],
            ]
        );

        $this->end_controls_section();

    }

    protected function render( ) {

        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'image-accordion', [
            'class'     => [ 'gyan-image-accordion', 'gyan-image-accordion-hover' ],
            'id'        => 'gyan-image-accordion-' . $this->get_id(),
        ] );

        if ( !empty( $settings['accordion_items'] ) ) {
            ?>
            <div <?php echo $this->get_render_attribute_string( 'image-accordion' ); ?>>
                <?php foreach( $settings['accordion_items'] as $index => $item ) { ?>
                    <?php
                        $item_key = $this->get_repeater_setting_key( 'item', 'accordion_items', $index );

                        $this->add_render_attribute( $item_key, [
                            'class' => ['gyan-image-accordion-item','elementor-repeater-item-' . esc_attr( $item['_id'] )]
                        ] );

                        if ( $item['image']['url'] ) {

                            $image_url = Group_Control_Image_Size::get_attachment_image_src( $item['image']['id'], 'image', $settings );

                            if ( ! $image_url ) {
                                $image_url = $item['image']['url'];
                            }

                            $this->add_render_attribute( $item_key, [
                                'style' => 'background-image: url('.$image_url.');'
                            ] );
                        }

                        $content_key = $this->get_repeater_setting_key( 'content', 'accordion_items', $index );

                        $this->add_render_attribute( $content_key, 'class', 'gyan-image-accordion-content-wrap' );

                        if ( $item['show_button'] == 'yes' && !empty( $item['link']['url'] ) ) {
                            $button_key = $this->get_repeater_setting_key( 'button', 'accordion_items', $index );

                            $this->add_render_attribute( $button_key, 'class', [
                                    'gyan-image-accordion-button',
                                    'gyan-button-icon-' . $item['button_icon_position'],
                                    'elementor-button',
                                    'elementor-size-' . $settings['button_size'],
                                ]
                            );

                            if ( $settings['button_hover_animation'] ) {
                                $this->add_render_attribute( $button_key, 'class', 'elementor-animation-' . $settings['button_hover_animation'] );
                            }

                            $this->add_render_attribute( $button_key, 'href', esc_url( $item['link']['url'] ) );

                            if ( $item['link']['is_external'] ) {
                                $this->add_render_attribute( $button_key, 'target', '_blank' );
                            }

                            if ( $item['link']['nofollow'] ) {
                                $this->add_render_attribute( $button_key, 'rel', 'nofollow' );
                            }
                        }
                    ?>
                    <div <?php echo $this->get_render_attribute_string( $item_key ); ?>>
                        <div class="gyan-image-accordion-overlay">
                            <div <?php echo $this->get_render_attribute_string( $content_key ); ?>>
                                <div class="gyan-image-accordion-content">
                                    <h2 class="gyan-image-accordion-title">
                                        <?php echo $item['title']; ?>
                                    </h2>
                                    <div class="gyan-image-accordion-description">
                                        <?php echo $item['description']; ?>
                                    </div>
                                </div>
                                <?php if ( $item['show_button'] == 'yes' && $item['link']['url'] != '' ) { ?>
                                <div class="gyan-image-accordion-button-wrap">
                                    <a <?php echo $this->get_render_attribute_string( $button_key ); ?>>
                                        <?php if ( ! empty( $item['button_icon'] ) && $item['button_icon_position'] == 'before' ) { ?>
                                            <span class="gyan-button-icon gyan-icon" aria-hidden="true"><?php Icons_Manager::render_icon( $item['button_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
                                        <?php } ?>
                                        <?php if ( ! empty( $item['button_text'] ) ) { ?>
                                            <span class="gyan-button-text">
                                                <?php echo esc_attr( $item['button_text'] ); ?>
                                            </span>
                                        <?php } ?>
                                        <?php if ( ! empty( $item['button_icon'] ) && $item['button_icon_position'] == 'after' ) { ?>
                                            <span class="gyan-button-icon gyan-icon" aria-hidden="true"><?php Icons_Manager::render_icon( $item['button_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
                                        <?php } ?>
                                    </a>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php }
    }

    protected function content_template() {}
}