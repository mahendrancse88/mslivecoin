<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Modules\DynamicTags\Module as TagsModule;
use Elementor\Icons_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Gyan_Pricing_Table extends Widget_Base {

    public function get_name()           { return 'gyan_pricing_table'; }
    public function get_title()          { return esc_html__( 'Price Table', 'gyan-elements' ); }
    public function get_icon()           { return 'gyan-el-icon eicon-price-table'; }
    public function get_categories()     { return [ 'gyan-advanced-addons' ]; }
    public function get_keywords()       { return [ 'gyan price table','pricing', 'price', 'table','box','package' ]; }
    public function get_style_depends()  { return [ 'gyan-icon','gyan-pricing-table' ]; }

    protected function register_controls() {

        $this->start_controls_section(
            'section_header',
            [
                'label'                 => esc_html__( 'Icon', 'gyan-elements' ),
            ]
        );

        $this->add_control(
			'icon_type',
			[
				'label'                 => esc_html__( 'Icon Type', 'gyan-elements' ),
				'type'                  => Controls_Manager::CHOOSE,
				'label_block'           => false,
				'options'               => [
					'none'        => [
						'title'   => esc_html__( 'None', 'gyan-elements' ),
						'icon'    => 'fa fa-ban',
					],
					'icon'        => [
						'title'   => esc_html__( 'Icon', 'gyan-elements' ),
						'icon'    => 'fa fa-info-circle',
					],
					'image'       => [
						'title'   => esc_html__( 'Image', 'gyan-elements' ),
						'icon'    => 'fa fa-picture-o',
					],
				],
				'default'               => 'icon',
			]
		);

        $this->add_control(
            'table_icon',
            [
                'label'                 => esc_html__( 'Icon', 'gyan-elements' ),
                'type'                  => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
				'condition'             => [
					'icon_type' => 'icon',
				],
            ]
        );

        $this->add_control(
            'icon_image',
            [
                'label'                 => esc_html__( 'Image', 'gyan-elements' ),
                'type'                  => Controls_Manager::MEDIA,
                'default'               => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
				'condition'             => [
					'icon_type'  => 'image',
				],
            ]
        );

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'                  => 'image',
				'default'               => 'full',
				'separator'             => 'none',
				'condition'             => [
					'icon_type'  => 'image',
				],
			]
		);

        $this->end_controls_section();


        $this->start_controls_section(
            'section_title',
            [
                'label'                 => esc_html__( 'Title', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'table_title',
            [
                'label'                 => esc_html__( 'Title', 'gyan-elements' ),
                'type'                  => Controls_Manager::TEXT,
				'dynamic'               => [
					'active'   => true,
				],
                'default'               => esc_html__( 'Standard Pack', 'gyan-elements' ),
                'title'                 => esc_html__( 'Enter table title', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'table_subtitle',
            [
                'label'                 => esc_html__( 'Subtitle', 'gyan-elements' ),
                'type'                  => Controls_Manager::TEXT,
				'dynamic'               => [
					'active'   => true,
				],
                'title'                 => esc_html__( 'Enter table subtitle', 'gyan-elements' ),
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_pricing',
            [
                'label'                 => esc_html__( 'Pricing', 'gyan-elements' ),
            ]
        );

		$this->add_control(
			'currency_symbol',
			[
				'label'                 => esc_html__( 'Currency Symbol', 'gyan-elements' ),
				'type'                  => Controls_Manager::SELECT,
				'options'               => [
					'none'             => esc_html__( 'None', 'gyan-elements' ),
					'dollar'       => '&#36; ' . esc_html__( 'Dollar', 'gyan-elements' ),
					'euro'         => '&#128; ' . esc_html__( 'Euro', 'gyan-elements' ),
					'baht'         => '&#3647; ' . esc_html__( 'Baht', 'gyan-elements' ),
					'franc'        => '&#8355; ' . esc_html__( 'Franc', 'gyan-elements' ),
					'guilder'      => '&fnof; ' . esc_html__( 'Guilder', 'gyan-elements' ),
					'krona'        => 'kr ' . esc_html__( 'Krona', 'gyan-elements' ),
					'lira'         => '&#8356; ' . esc_html__( 'Lira', 'gyan-elements' ),
					'peseta'       => '&#8359 ' . esc_html__( 'Peseta', 'gyan-elements' ),
					'peso'         => '&#8369; ' . esc_html__( 'Peso', 'gyan-elements' ),
					'pound'        => '&#163; ' . esc_html__( 'Pound Sterling', 'gyan-elements' ),
					'real'         => 'R$ ' . esc_html__( 'Real', 'gyan-elements' ),
					'ruble'        => '&#8381; ' . esc_html__( 'Ruble', 'gyan-elements' ),
					'rupee'        => '&#8360; ' . esc_html__( 'Rupee', 'gyan-elements' ),
					'indian_rupee' => '&#8377; ' . esc_html__( 'Rupee (Indian)', 'gyan-elements' ),
					'shekel'       => '&#8362; ' . esc_html__( 'Shekel', 'gyan-elements' ),
					'yen'          => '&#165; ' . esc_html__( 'Yen/Yuan', 'gyan-elements' ),
					'won'          => '&#8361; ' . esc_html__( 'Won', 'gyan-elements' ),
					'custom'       => esc_html__( 'Custom', 'gyan-elements' ),
				],
				'default'               => 'dollar',
			]
		);

        $this->add_control(
            'currency_symbol_custom',
            [
                'label'                 => esc_html__( 'Custom Currency Symbol', 'gyan-elements' ),
                'type'                  => Controls_Manager::TEXT,
                'dynamic'               => [
                    'active'   => true,
                ],
                'condition'             => [
                    'currency_symbol'  => 'custom',
                ],
            ]
        );

        $this->add_control(
            'currency_symbol_position',
            [
                'label'                 => esc_html__( 'Currency Symbol Position', 'gyan-elements' ),
                'type'                  => Controls_Manager::SELECT,
                'options'               => [
                    'before'             => esc_html__( 'Before Price', 'gyan-elements' ),
                    'after'             => esc_html__( 'After Price', 'gyan-elements' )
                ],
                'default'               => 'before',
                'condition'             => [
                    'currency_symbol!'   => 'none',
                ],
            ]
        );

        $this->add_control(
            'table_price',
            [
                'label'                 => esc_html__( 'Price', 'gyan-elements' ),
                'type'                  => Controls_Manager::TEXT,
				'dynamic'               => [
					'active'   => true,
				],
                'default'               => '25',
            ]
        );

        $this->add_control(
            'table_duration',
            [
                'label'                 => esc_html__( 'Duration', 'gyan-elements' ),
                'type'                  => Controls_Manager::TEXT,
                'default'               => esc_html__( '/ MO', 'gyan-elements' ),
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_features',
            [
                'label'                 => esc_html__( 'Features', 'gyan-elements' ),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
        	'feature_text',
			[
				'label'               => esc_html__( 'Text', 'gyan-elements' ),
				'type'                => Controls_Manager::TEXT,
                'dynamic'             => [
                    'active'   => true,
                ],
				'placeholder'         => esc_html__( 'Feature', 'gyan-elements' ),
				'default'             => esc_html__( 'Feature', 'gyan-elements' ),
			]
        );

		$repeater->add_control(
        	'exclude',
            [
                'label'               => esc_html__( 'Exclude', 'gyan-elements' ),
                'type'                => Controls_Manager::SWITCHER,
                'default'             => '',
                'label_on'            => esc_html__( 'Yes', 'gyan-elements' ),
                'label_off'           => esc_html__( 'No', 'gyan-elements' ),
                'return_value'        => 'yes',
            ]
        );

        $repeater->add_control(
        	'feature_icon',
			[
				'label'               => esc_html__( 'Icon', 'gyan-elements' ),
				'type'                => Controls_Manager::ICONS,
			]
        );

		$repeater->add_control(
        	'feature_icon_color',
			[
				'label'               => esc_html__( 'Icon Color', 'gyan-elements' ),
				'type'                => Controls_Manager::COLOR,
                'selectors'           => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .fa' => 'color: {{VALUE}}',
                ],
                'selectors'             => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .gyan-pricing-table-fature-icon' => 'color: {{VALUE}}',
                    '{{WRAPPER}} {{CURRENT_ITEM}} .gyan-pricing-table-fature-icon svg' => 'fill: {{VALUE}}',
                ],
			]
        );

		$repeater->add_control(
        	'feature_text_color',
			[
				'label'               => esc_html__( 'Text Color', 'gyan-elements' ),
				'type'                => Controls_Manager::COLOR,
		        'default'             => '',
                'selectors'           => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}}',
                ],
			]
        );

		$repeater->add_control(
        	'feature_bg_color',
			[
				'label'               => esc_html__( 'Background Color', 'gyan-elements' ),
				'type'                => Controls_Manager::COLOR,
		        'default'             => '',
                'selectors'           => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}}',
                ],
			]
        );

        $this->add_control(
        	'table_features',
        	[
        		'label' => esc_html__( 'Animated Text', 'gyan-elements' ),
        		'type' => Controls_Manager::REPEATER,
        		'fields' => $repeater->get_controls(),
        		'default'               => [
					[
						'feature_text'        => esc_html__( 'Veritatis rtrdr modimodi', 'gyan-elements' ),
					],
					[
						'feature_text'        => esc_html__( 'Similique rgjhu pariatur', 'gyan-elements' ),
					],
					[
						'feature_text'        => esc_html__( 'Commodi oklgy facilisra', 'gyan-elements' ),
					],
                    [
                        'feature_text'        => esc_html__( 'Reidis umkol noiupus', 'gyan-elements' ),
                    ],
				],
        		'title_field' => '{{{ feature_text }}}',
        	]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_ribbon',
            [
                'label'                 => esc_html__( 'Ribbon', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'show_ribbon',
            [
                'label'                 => esc_html__( 'Ribbon', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => '',
                'label_on'              => esc_html__( 'On', 'gyan-elements' ),
                'label_off'             => esc_html__( 'Off', 'gyan-elements' ),
                'return_value'          => 'yes',
            ]
        );

        $this->add_control(
            'ribbon_style',
            [
                'label'                => esc_html__( 'Style', 'gyan-elements' ),
                'type'                 => Controls_Manager::SELECT,
                'default'              => '1',
                'options'              => [
                    '1'         => esc_html__( 'Default', 'gyan-elements' ),
                    '2'         => esc_html__( 'Circle', 'gyan-elements' ),
                    '3'         => esc_html__( 'Flag', 'gyan-elements' ),
                ],
				'condition'             => [
					'show_ribbon'  => 'yes',
				],
            ]
        );

        $this->add_control(
            'ribbon_title',
            [
                'label'                 => esc_html__( 'Title', 'gyan-elements' ),
                'type'                  => Controls_Manager::TEXT,
				'dynamic'               => [
					'active'   => true,
				],
                'default'               => esc_html__( 'New', 'gyan-elements' ),
				'condition'             => [
					'show_ribbon'  => 'yes',
				],
            ]
        );

        $this->add_responsive_control(
            'ribbon_size',
            [
                'label'                 => esc_html__( 'Size', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'size_units'            => [ 'px', 'em' ],
                'range'                 => [
                    'px' => [
                        'min'   => 1,
                        'max'   => 200,
                    ],
                    'em' => [
                        'min'   => 1,
                        'max'   => 15,
                    ],
                ],
				'default'               => [
					'size'      => 4,
					'unit'      => 'em',
				],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-pricing-table-ribbon-2' => 'min-width: {{SIZE}}{{UNIT}}; min-height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
                ],
				'condition'             => [
					'show_ribbon'  => 'yes',
					'ribbon_style' => [ '2' ],
				],
            ]
        );

        $this->add_responsive_control(
            'top_distance',
            [
                'label'                 => esc_html__( 'Distance from Top', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'size_units'            => [ 'px', '%' ],
                'range'                 => [
                    'px' => [
                        'min'   => 1,
                        'max'   => 200,
                    ],
                ],
				'default'               => [
					'size'      => 20,
					'unit'      => '%',
				],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-pricing-table-ribbon' => 'top: {{SIZE}}{{UNIT}};',
                ],
				'condition'             => [
					'show_ribbon'  => 'yes',
					'ribbon_style' => [ '2', '3' ],
				],
            ]
        );

        $ribbon_distance_transform = is_rtl() ? 'translateY(-50%) translateX({{SIZE}}{{UNIT}}) rotate(-45deg)' : 'translateY(-50%) translateX(-50%) translateX({{SIZE}}{{UNIT}}) rotate(-45deg)';

		$this->add_responsive_control(
			'ribbon_distance',
			[
				'label'                 => esc_html__( 'Distance', 'gyan-elements' ),
				'type'                  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .gyan-pricing-table-ribbon-inner' => 'margin-top: {{SIZE}}{{UNIT}}; transform: ' . $ribbon_distance_transform,
				],
				'condition'             => [
					'show_ribbon'  => 'yes',
					'ribbon_style' => [ '1' ],
				],
			]
		);

        $this->add_control(
			'ribbon_position',
			[
				'label'                 => esc_html__( 'Position', 'gyan-elements' ),
				'type'                  => Controls_Manager::CHOOSE,
				'toggle'                => false,
				'label_block'           => false,
				'options'               => [
					'left'  => [
						'title' => esc_html__( 'Left', 'gyan-elements' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'gyan-elements' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'               => 'right',
				'condition'             => [
					'show_ribbon'  => 'yes',
					'ribbon_style' => [ '1', '2', '3' ],
				],
			]
		);

        $this->end_controls_section();


        $this->start_controls_section(
            'section_button',
            [
                'label'                 => esc_html__( 'Button', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'table_button_text',
            [
                'label'                 => esc_html__( 'Button Text', 'gyan-elements' ),
                'type'                  => Controls_Manager::TEXT,
				'dynamic'               => [
					'active'   => true,
				],
                'default'               => esc_html__( 'Get Started', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'link',
            [
                'label'                 => esc_html__( 'Link', 'gyan-elements' ),
				'label_block'           => false,
                'type'                  => Controls_Manager::URL,
				'dynamic'               => [
					'active'   => true,
				],
                'placeholder'           => 'https://www.your-link.com',
                'default'               => [
                    'url' => '#',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_other_info',
            [
                'label'                 => esc_html__( 'Other Info', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'table_other_info',
            [
                'label'                 => esc_html__( 'Other Info', 'gyan-elements' ),
                'type'                  => Controls_Manager::TEXTAREA,
				'dynamic'               => [
					'active'   => true,
				],
                'title'                 => esc_html__( 'Other Info', 'gyan-elements' ),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_pricing_table_style',
            [
                'label'                 => esc_html__( 'Pricing Table', 'gyan-elements' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'table_align',
            [
                'label'                 => esc_html__( 'Alignment', 'gyan-elements' ),
                'type'                  => Controls_Manager::CHOOSE,
                'label_block'           => false,
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
                ],
                'default'               => '',
                'prefix_class'      => 'gyan-pricing-table-align-'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'                  => 'pricing_table_border',
                'label'                 => esc_html__( 'Border', 'gyan-elements' ),
                'selector'              => '{{WRAPPER}} .gyan-pricing-table-container',
            ]
        );

        $this->add_control(
            'pricing_table_border_radius',
            [
                'label'                 => esc_html__( 'Border Radius', 'gyan-elements' ),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => [ 'px', '%' ],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-pricing-table-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'pricing_table_bg',
                'types' => [ 'classic', 'gradient' ],
                'fields_options' => [
                    'background' => [
                        'default' =>'classic',
                    ],
                    'color' => [
                        'default' => '#ffffff',
                    ],
                ],
                'selector' => '{{WRAPPER}} .gyan-pricing-table-container',
            ]
        );

		$this->add_responsive_control(
			'table_padding',
			[
				'label'                 => esc_html__( 'Padding', 'gyan-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .gyan-pricing-table-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'table_box_shadow',
                'label' => esc_html__( 'Box Shadow', 'gyan-elements' ),
                'fields_options' => [
                    'box_shadow_type' => [
                        'default' =>'yes'
                    ],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => '0',
                            'vertical' => '0',
                            'blur' => '46',
                            'color' => 'rgba(0,0,0,0.1)'
                        ]
                    ]
                ],
                'selector' => '{{WRAPPER}} .gyan-pricing-table-container',
            ]
        );

        $this->add_control(
            'table_top_area_heading',
            [
                'label'                 => esc_html__( 'Table Top Area', 'gyan-elements' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
            ]
        );

        $this->add_responsive_control(
            'table_top_area_margin',
            [
                'label'                 => esc_html__( 'Margin', 'gyan-elements' ),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => [ 'px', '%' ],
                'condition'             => [
                    'icon_type!' => 'none',
                ],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-pricing-table-top' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'pricing_table_top_bg',
                'types' => [ 'classic', 'gradient' ],
                'fields_options' => [
                    'background' => [
                        'default' =>'classic',
                    ],
                    'color' => [
                        'default' => '#d83030',
                    ],
                ],
                'selector' => '{{WRAPPER}} .gyan-pricing-table-top',
            ]
        );


        $this->add_control(
            'table_bottom_area_heading',
            [
                'label'                 => esc_html__( 'Table Bottom Area', 'gyan-elements' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
            ]
        );

        $this->add_responsive_control(
            'table_bottom_area_padding',
            [
                'label'                 => esc_html__( 'Padding', 'gyan-elements' ),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => [ 'px', '%' ],
                'condition'             => [
                    'icon_type!' => 'none',
                ],
                'default' => [
                    'top' => '82',
                    'right' => '20',
                    'bottom' => '58',
                    'left' => '20',
                    'isLinked' => false,
                ],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-pricing-table-bottom' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'pricing_table_bottom_bg',
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .gyan-pricing-table-bottom',
            ]
        );

        $this->end_controls_section();

        // --------------------------------

        $this->start_controls_section(
            'section_icon_style',
            [
                'label'                 => esc_html__( 'Icon', 'gyan-elements' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    'icon_type!' => 'none',
                ],
            ]
        );

        $this->add_responsive_control(
            'table_icon_size',
            [
                'label'                 => esc_html__( 'Icon Size', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 5,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => '40',
                ],
                'size_units'            => [ 'px', 'em' ],
				'condition'             => [
                    'icon_type'   => 'icon',
					'table_icon!' => '',
				],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-pricing-table-icon' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'table_icon_image_width',
            [
                'label'                 => esc_html__( 'Width', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 1,
                        'max'   => 1200,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px', '%' ],
				'condition'             => [
                    'icon_type'   => 'image',
					'table_icon!' => '',
				],
                'default' => [
                    'unit' => 'px',
                    'size' => '40',
                ],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-pricing-table-icon' => 'width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_box_size',
            [
                'label'      => esc_html__( 'Icon Box Size', 'gyan-elements' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min'  => 5,
                        'max'  => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => '46',
                ],
                'size_units' => [ 'px', 'em' ],
                'condition'             => [
                    'icon_type'   => 'icon',
                    'table_icon!' => '',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .gyan-pricing-table-icon' => 'height: calc({{SIZE}}{{UNIT}} * 2); width: calc({{SIZE}}{{UNIT}} * 2);',
                ],
            ]
        );

        $this->add_control(
            'table_icon_color',
            [
                'label'                 => esc_html__( 'Icon Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#d83030',
                'condition'             => [
                    'icon_type'   => 'icon',
                    'table_icon!' => '',
                ],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-pricing-table-icon' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .gyan-pricing-table-icon svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'table_icon_bg_color',
            [
                'label'                 => esc_html__( 'Background Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#ffffff',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-pricing-table-icon' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'table_icon_border',
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'color' => [
                        'default' => 'rgba(0,0,0,0.1)',
                    ],
                    'width' => [
                        'default' => [
                            'top' => '2',
                            'right' => '2',
                            'bottom' => '2',
                            'left' => '2',
                            'isLinked' => true,
                        ]
                    ],
                ],
                'selector' => '{{WRAPPER}} .gyan-pricing-table-icon',
            ]
        );

		$this->add_control(
			'icon_border_radius',
			[
				'label'                 => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
                'default' => [
                    'top' => '100',
                    'right' => '100',
                    'bottom' => '100',
                    'left' => '100',
                    'isLinked' => true,
                    'unit'   => '%',
                ],
				'condition'             => [
					'icon_type!' => 'none',
				],
				'selectors'             => [
					'{{WRAPPER}} .gyan-pricing-table-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
            'table_icon_margin',
            [
                'label'                 => esc_html__( 'Margin', 'gyan-elements' ),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => [ 'px', '%' ],
                'condition'             => [
                    'icon_type!' => 'none',
                ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '-46',
                    'left' => '0',
                    'isLinked' => false,
                ],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-pricing-table-icon-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'                  => 'icon_box_shadow',
                'selector'              => '{{WRAPPER}} .gyan-pricing-table-icon',
            ]
        );

        $this->end_controls_section();

        // --------------------------------

        $this->start_controls_section(
            'section_title_style',
            [
                'label'                 => esc_html__( 'Title', 'gyan-elements' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'table_title_heading',
            [
                'label'                 => esc_html__( 'Title', 'gyan-elements' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
            ]
        );

        $this->add_control(
            'table_title_color',
            [
                'label'                 => esc_html__( 'Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#ffffff',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-pricing-table-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'table_title_typography',
                'label'                 => esc_html__( 'Typography', 'gyan-elements' ),
                'fields_options' => [
                    'typography' => [
                        'default' =>'custom',
                    ],
                    'font_size'   => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '24',
                        ],
                    ],
                ],
                'selector'              => '{{WRAPPER}} .gyan-pricing-table-title',
            ]
        );

        $this->add_control(
            'table_title_html_tag',
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
            'table_subtitle_heading',
            [
                'label'                 => esc_html__( 'Sub Title', 'gyan-elements' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
				'condition'             => [
					'table_subtitle!' => '',
				],
            ]
        );

        $this->add_control(
            'table_subtitle_color',
            [
                'label'                 => esc_html__( 'Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#ffffff',
				'condition'             => [
					'table_subtitle!' => '',
				],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-pricing-table-subtitle' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'table_subtitle_typography',
                'label'                 => esc_html__( 'Typography', 'gyan-elements' ),
                'fields_options' => [
                    'typography' => [
                        'default' =>'custom',
                    ],
                    'font_size'   => [
                        'default' => [
                            'unit' => 'px',
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
                ],
				'condition'             => [
					'table_subtitle!' => '',
				],
                'selector'              => '{{WRAPPER}} .gyan-pricing-table-subtitle',
            ]
        );

        $this->add_responsive_control(
            'table_subtitle_spacing',
            [
                'label'                 => esc_html__( 'Spacing', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px', '%' ],
				'condition'             => [
					'table_subtitle!' => '',
				],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-pricing-table-subtitle' => 'margin-top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_title_margin',
            [
                'label'                 => esc_html__( 'Margin', 'gyan-elements' ),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => [ 'px', '%' ],
                'default' => [
                    'top' => '35',
                    'right' => '0',
                    'bottom' => '16',
                    'left' => '0',
                    'isLinked' => false,
                ],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-pricing-table-title-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->add_control(
            'table_title_divider_heading',
            [
                'label'                 => esc_html__( 'Divider', 'gyan-elements' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
            ]
        );

        $this->add_control(
            'table_title_divider_onoff',
            [
                'label'                 => esc_html__( 'Show Divider', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'              => esc_html__( 'On', 'gyan-elements' ),
                'label_off'             => esc_html__( 'Off', 'gyan-elements' ),
                'return_value'          => 'yes',
            ]
        );

        $this->add_control(
            'table_title_divider_color',
            [
                'label'                 => esc_html__( 'Divider Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#ffffff',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-pricing-table-title-divider:after,{{WRAPPER}} .gyan-pricing-table-title-divider:before' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_title_divider_margin',
            [
                'label'                 => esc_html__( 'Margin Bottom', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 200,
                        'step'  => 1,
                    ],
                ],
                'default'               => [
                    'size'      => 23,
                    'unit'      => 'px',
                ],
                'size_units'            => [ 'px' ],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-pricing-table-title-divider' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_table_pricing_style',
            [
                'label'                 => esc_html__( 'Pricing', 'gyan-elements' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'table_price_heading',
            [
                'label'                 => esc_html__( 'Price', 'gyan-elements' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'table_pricing_typography',
                'label'                 => esc_html__( 'Typography', 'gyan-elements' ),

                'fields_options' => [
                    'typography' => [
                        'default' =>'custom',
                    ],
                    'font_size'   => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '72',
                        ],
                    ],
                    'font_weight' => [
                        'default' => '700',
                    ]
                ],

                'selector'              => '{{WRAPPER}} .gyan-pricing-table-price',
                'separator'             => 'before',
            ]
        );

        $this->add_control(
            'table_price_color_normal',
            [
                'label'                 => esc_html__( 'Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#ffffff',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-pricing-table-price' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_responsive_control(
			'table_price_margin',
			[
				'label'                 => esc_html__( 'Margin', 'gyan-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .gyan-pricing-table-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
            'table_curreny_heading',
            [
                'label'                 => esc_html__( 'Currency Symbol', 'gyan-elements' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
            ]
        );

		$this->add_control(
			'currency_vertical_position',
			[
				'label'                 => esc_html__( 'Vertical Position', 'gyan-elements' ),
				'type'                  => Controls_Manager::CHOOSE,
				'label_block'           => false,
				'options'               => [
					'top'       => [
						'title' => esc_html__( 'Top', 'gyan-elements' ),
						'icon'  => 'eicon-v-align-top',
					],
					'middle'    => [
						'title' => esc_html__( 'Middle', 'gyan-elements' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom'    => [
						'title' => esc_html__( 'Bottom', 'gyan-elements' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'default'               => 'top',
				'selectors_dictionary'  => [
					'top'      => 'flex-start',
					'middle'   => 'center',
					'bottom'   => 'flex-end',
				],
				'selectors'             => [
					'{{WRAPPER}} .gyan-pricing-table-price-prefix' => 'align-self: {{VALUE}}',
				],
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'table_currency_symbol_typography',
                'label'                 => esc_html__( 'Typography', 'gyan-elements' ),

                'fields_options' => [
                    'typography' => [
                        'default' =>'custom',
                    ],
                    'font_size'   => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '40',
                        ],
                    ],
                ],

                'selector'              => '{{WRAPPER}} .gyan-pricing-table-price-prefix',
            ]
        );

        $this->add_control(
            'table_duration_heading',
            [
                'label'                 => esc_html__( 'Duration', 'gyan-elements' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
            ]
        );

        $this->add_control(
          'duration_position',
          [
             'label'                => esc_html__( 'Position', 'gyan-elements' ),
             'type'                 => Controls_Manager::SELECT,
             'default'              => 'nowrap',
             'options'              => [
                'nowrap'    => esc_html__( 'Same Line', 'gyan-elements' ),
                'wrap'      => esc_html__( 'Next Line', 'gyan-elements' ),
             ],
            'prefix_class' => 'gyan-pricing-table-price-duration-'
          ]
        );

        $this->add_control(
            'duration_text_color',
            [
                'label'                 => esc_html__( 'Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#ffffff',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-pricing-table-price-duration' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'table_price_duration_typography',
                'label'                 => esc_html__( 'Typography', 'gyan-elements' ),

                'fields_options' => [
                    'typography' => [
                        'default' =>'custom',
                    ],
                    'font_size'   => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '15',
                        ],
                    ],
                    'line_height'   => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '30',
                        ],
                    ],
                ],

                'selector' => '{{WRAPPER}} .gyan-pricing-table-price-duration',
            ]
        );

        $this->add_responsive_control(
            'table_price_duration_padding',
            [
                'label'                 => esc_html__( 'Padding', 'gyan-elements' ),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => [ 'px', 'em', '%' ],
                'condition'             => [
                    'table_button_text!' => '',
                ],
                'default' => [
                    'top' => '',
                    'right' => '',
                    'bottom' => '',
                    'left' => '9',
                    'isLinked' => false,
                ],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-pricing-table-price-duration' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();


        $this->start_controls_section(
            'section_table_features_style',
            [
                'label'                 => esc_html__( 'Features', 'gyan-elements' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'table_features_align',
			[
				'label'                 => esc_html__( 'Alignment', 'gyan-elements' ),
				'type'                  => Controls_Manager::CHOOSE,
				'label_block'           => false,
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
				],
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .gyan-pricing-table-features'   => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->add_control(
            'table_features_text_color',
            [
                'label'                 => esc_html__( 'Text Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#676767',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-pricing-table-features' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_responsive_control(
			'table_features_padding',
			[
				'label'                 => esc_html__( 'Padding', 'gyan-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .gyan-pricing-table-features' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
            'table_features_margin',
            [
                'label'                 => esc_html__( 'Margin Bottom', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 200,
                        'step'  => 1,
                    ],
                ],
                'default'               => [
                    'size'      => 43,
                    'unit'      => 'px',
                ],
                'size_units'            => [ 'px' ],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-pricing-table-features' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'table_features_typography',
                'label'                 => esc_html__( 'Typography', 'gyan-elements' ),
                'fields_options' => [
                    'typography' => [
                        'default' =>'custom',
                    ],
                    'font_size'   => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '17',
                        ],
                    ],
                    'line_height'   => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '30',
                        ],
                    ],
                ],
                'selector'              => '{{WRAPPER}} .gyan-pricing-table-features',
            ]
        );

        $this->add_control(
            'table_features_icon_heading',
            [
                'label'                 => esc_html__( 'Icon', 'gyan-elements' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
            ]
        );

        $this->add_control(
            'table_features_icon_color',
            [
                'label'                 => esc_html__( 'Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#b9b9b9',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-pricing-table-fature-icon' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .gyan-pricing-table-fature-icon svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'table_features_icon_size',
            [
                'label'                 => esc_html__( 'Size', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 5,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px', 'em' ],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-pricing-table-fature-icon' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'table_features_icon_spacing',
            [
                'label'                 => esc_html__( 'Spacing', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px' ],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-pricing-table-fature-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'table_features_rows_heading',
            [
                'label'                 => esc_html__( 'Rows', 'gyan-elements' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
            ]
        );

        $this->add_responsive_control(
            'table_features_spacing',
            [
                'label'                 => esc_html__( 'Spacing', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
				'default'               => [
					'unit' => 'px',
					'size' => 6,
				],
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px' ],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-pricing-table-features li:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'table_features_alternate',
            [
                'label'                 => esc_html__( 'Striped Rows', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => '',
                'label_on'              => esc_html__( 'Yes', 'gyan-elements' ),
                'label_off'             => esc_html__( 'No', 'gyan-elements' ),
                'return_value'          => 'yes',
            ]
        );

        $this->add_control(
            'table_minimum_width_rows',
            [
                'label'                 => esc_html__( 'Minimum Width Rows', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'no',
                'label_on'              => esc_html__( 'Yes', 'gyan-elements' ),
                'label_off'             => esc_html__( 'No', 'gyan-elements' ),
                'return_value'          => 'yes',
            ]
        );

		$this->add_responsive_control(
			'table_features_rows_padding',
			[
				'label'                 => esc_html__( 'Padding', 'gyan-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .gyan-pricing-table-features li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'             => [
					'table_features_alternate' => 'yes',
				],
			]
		);

        $this->start_controls_tabs( 'tabs_features_style' );

        $this->start_controls_tab(
            'tab_features_even',
            [
                'label'                 => esc_html__( 'Even', 'gyan-elements' ),
				'condition'             => [
					'table_features_alternate' => 'yes',
				],
            ]
        );

        $this->add_control(
            'table_features_bg_color_even',
            [
                'label'                 => esc_html__( 'Background Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-pricing-table-features li:nth-child(even)' => 'background-color: {{VALUE}}',
                ],
				'condition'             => [
					'table_features_alternate' => 'yes',
				],
            ]
        );

        $this->add_control(
            'table_features_text_color_even',
            [
                'label'                 => esc_html__( 'Text Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-pricing-table-features li:nth-child(even)' => 'color: {{VALUE}}',
                ],
				'condition'             => [
					'table_features_alternate' => 'yes',
				],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_features_odd',
            [
                'label'                 => esc_html__( 'Odd', 'gyan-elements' ),
				'condition'             => [
					'table_features_alternate' => 'yes',
				],
            ]
        );

        $this->add_control(
            'table_features_bg_color_odd',
            [
                'label'                 => esc_html__( 'Background Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-pricing-table-features li:nth-child(odd)' => 'background-color: {{VALUE}}',
                ],
				'condition'             => [
					'table_features_alternate' => 'yes',
				],
            ]
        );

        $this->add_control(
            'table_features_text_color_odd',
            [
                'label'                 => esc_html__( 'Text Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-pricing-table-features li:nth-child(odd)' => 'color: {{VALUE}}',
                ],
				'condition'             => [
					'table_features_alternate' => 'yes',
				],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'table_divider_heading',
            [
                'label'                 => esc_html__( 'Divider', 'gyan-elements' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'table_feature_divider',
				'label'                 => esc_html__( 'Divider', 'gyan-elements' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .gyan-pricing-table-features li',
			]
		);

        $this->end_controls_section();


        $this->start_controls_section(
            'section_table_ribbon_style',
            [
                'label'                 => esc_html__( 'Ribbon', 'gyan-elements' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'ribbon_text_color',
            [
                'label'                 => esc_html__( 'Text Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#ffffff',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-pricing-table-ribbon .gyan-pricing-table-ribbon-inner' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_control(
			'ribbon_bg_color',
			[
				'label'                 => esc_html__( 'Background Color', 'gyan-elements' ),
				'type'                  => Controls_Manager::COLOR,
                'default'               => '#252628',
				'selectors'             => [
					'{{WRAPPER}} .gyan-pricing-table-ribbon .gyan-pricing-table-ribbon-inner' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .gyan-pricing-table-ribbon-3.gyan-pricing-table-ribbon-right:before' => 'border-left-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'                  => 'ribbon_typography',
				'selector'              => '{{WRAPPER}} .gyan-pricing-table-ribbon .gyan-pricing-table-ribbon-inner',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'ribbon_box_shadow',
				'selector'              => '{{WRAPPER}} .gyan-pricing-table-ribbon .gyan-pricing-table-ribbon-inner',
			]
		);

        $this->end_controls_section();


        $this->start_controls_section(
            'section_table_button_style',
            [
                'label'                 => esc_html__( 'Button', 'gyan-elements' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'tabs_button_style' );

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label'                 => esc_html__( 'Normal', 'gyan-elements' ),
				'condition'             => [
					'table_button_text!' => '',
				],
            ]
        );

        $this->add_control(
            'button_bg_color_normal',
            [
                'label'                 => esc_html__( 'Background Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#ffffff',
				'condition'             => [
					'table_button_text!' => '',
				],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-pricing-table-button' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_text_color_normal',
            [
                'label'                 => esc_html__( 'Text Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#032e42',
				'condition'             => [
					'table_button_text!' => '',
				],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-pricing-table-button' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'button_border_normal',
				'label'                 => esc_html__( 'Border', 'gyan-elements' ),
				'placeholder'           => '2px',
				'default'               => '2px',
				'condition'             => [
					'table_button_text!' => '',
				],
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'color' => [
                        'default' => '#d83030',
                    ],
                    'width' => [
                        'default' => [
                            'top' => '2',
                            'right' => '2',
                            'bottom' => '2',
                            'left' => '2',
                            'isLinked' => true,
                        ]
                    ],
                ],
				'selector'  => '{{WRAPPER}} .gyan-pricing-table-button',
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'button_typography',
                'label'                 => esc_html__( 'Typography', 'gyan-elements' ),
                'scheme'                => Scheme_Typography::TYPOGRAPHY_4,
				'condition'             => [
					'table_button_text!' => '',
				],
                'fields_options' => [
                    'typography' => [
                        'default' =>'custom',
                    ],
                    'font_size'   => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '16',
                        ],
                    ],
                    'font_weight' => [
                        'default' => '700',
                    ]
                ],
                'selector'              => '{{WRAPPER}} .gyan-pricing-table-button',
            ]
        );

		$this->add_responsive_control(
			'table_button_padding',
			[
				'label'                 => esc_html__( 'Padding', 'gyan-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'condition'             => [
					'table_button_text!' => '',
				],
				'selectors'             => [
					'{{WRAPPER}} .gyan-pricing-table-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'                 => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'condition'             => [
					'table_button_text!' => '',
				],
                'default' => [
                    'top' => '5',
                    'right' => '5',
                    'bottom' => '5',
                    'left' => '5',
                    'isLinked' => true,
                    'unit'   => 'px',
                ],
				'selectors'             => [
					'{{WRAPPER}} .gyan-pricing-table-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'pa_pricing_table_button_shadow',
				'condition'             => [
					'table_button_text!' => '',
				],
				'selector'              => '{{WRAPPER}} .gyan-pricing-table-button',
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label'                 => esc_html__( 'Hover', 'gyan-elements' ),
				'condition'             => [
					'table_button_text!' => '',
				],
            ]
        );

        $this->add_control(
            'button_bg_color_hover',
            [
                'label'                 => esc_html__( 'Background Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#d83030',
				'condition'             => [
					'table_button_text!' => '',
				],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-pricing-table-button:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_text_color_hover',
            [
                'label'                 => esc_html__( 'Text Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#fff',
				'condition'             => [
					'table_button_text!' => '',
				],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-pricing-table-button:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'button_border_hover',
				'label'                 => esc_html__( 'Border', 'gyan-elements' ),
				'placeholder'           => '2px',
				'default'               => '2px',
				'condition'             => [
					'table_button_text!' => '',
				],
				'selector'              => '{{WRAPPER}} .gyan-pricing-table-button:hover',
			]
		);

		$this->add_control(
			'button_hover_animation',
			[
				'label'                 => esc_html__( 'Animation', 'gyan-elements' ),
				'type'                  => Controls_Manager::HOVER_ANIMATION,
				'condition'             => [
					'table_button_text!' => '',
				],
			]
		);

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();


        $this->start_controls_section(
            'section_table_other_info_style',
            [
                'label'                 => esc_html__( 'Other Info', 'gyan-elements' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    'table_other_info!' => '',
                ],
            ]
        );

        $this->add_control(
            'other_info_color',
            [
                'label'                 => esc_html__( 'Text Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#5e5f66',
				'condition'             => [
					'table_other_info!' => '',
				],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-pricing-table-other-info' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'other_info_margin',
            [
                'label'                 => esc_html__( 'Margin Top', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
				'default'               => [
					'size'      => 20,
					'unit'      => 'px',
				],
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px' ],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-pricing-table-other-info' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
				'condition'             => [
					'table_other_info!' => '',
				],
            ]
        );

		$this->add_responsive_control(
			'other_info_padding',
			[
				'label'                 => esc_html__( 'Padding', 'gyan-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'condition'             => [
					'table_other_info!' => '',
				],
				'selectors'             => [
					'{{WRAPPER}} .gyan-pricing-table-other-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'other_info_typography',
                'label'                 => esc_html__( 'Typography', 'gyan-elements' ),
                'fields_options' => [
                    'typography' => [
                        'default' =>'custom',
                    ],
                    'font_size'   => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '14',
                        ],
                    ],
                    'line_height'   => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '30',
                        ],
                    ],
                    'letter_spacing' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '1',
                        ],
                    ],
                    'font_weight' => [
                        'default' => '500',
                    ]
                ],
				'condition'             => [
					'table_other_info!' => '',
				],
                'selector'              => '{{WRAPPER}} .gyan-pricing-table-other-info',
            ]
        );

        $this->end_controls_section();

    }

	private function get_currency_symbol( $symbol_name ) {
		$symbols = [
			'dollar'         => '&#36;',
			'euro'           => '&#128;',
			'franc'          => '&#8355;',
			'pound'          => '&#163;',
			'ruble'          => '&#8381;',
			'shekel'         => '&#8362;',
			'baht'           => '&#3647;',
			'yen'            => '&#165;',
			'won'            => '&#8361;',
			'guilder'        => '&fnof;',
			'peso'           => '&#8369;',
			'peseta'         => '&#8359',
			'lira'           => '&#8356;',
			'rupee'          => '&#8360;',
			'indian_rupee'   => '&#8377;',
			'real'           => 'R$',
			'krona'          => 'kr',
		];
		return isset( $symbols[ $symbol_name ] ) ? $symbols[ $symbol_name ] : '';
	}

    protected function render() {
        $settings = $this->get_settings_for_display();
		$symbol = '';

		if ( 'none' != $settings['currency_symbol'] ) {
			if ( 'custom' !== $settings['currency_symbol'] ) {
				$symbol = $this->get_currency_symbol( $settings['currency_symbol'] );
			} else {
				$symbol = $settings['currency_symbol_custom'];
			}
		}

        $this->add_inline_editing_attributes( 'table_title', 'none' );
        $this->add_render_attribute( 'table_title', 'class', 'gyan-pricing-table-title' );

        $this->add_inline_editing_attributes( 'table_subtitle', 'none' );
        $this->add_render_attribute( 'table_subtitle', 'class', 'gyan-pricing-table-subtitle' );

        $this->add_inline_editing_attributes( 'table_price', 'none' );
        $this->add_render_attribute( 'table_price', 'class', 'gyan-pricing-table-price-value' );

        $this->add_inline_editing_attributes( 'table_duration', 'none' );
        $this->add_render_attribute( 'table_duration', 'class', 'gyan-pricing-table-price-duration' );

        $this->add_inline_editing_attributes( 'table_other_info', 'none' );
        $this->add_render_attribute( 'table_other_info', 'class', 'gyan-pricing-table-other-info' );

        $this->add_render_attribute( 'pricing-table', 'class', 'gyan-pricing-table' );

        if ( $settings['table_minimum_width_rows'] == 'yes' ) {
            $this->add_render_attribute( 'pricing-table', 'class', 'gyan-pricing-table-min-row' );
        }

        $this->add_render_attribute( 'feature-list-item', 'class', '' );

        $this->add_inline_editing_attributes( 'table_button_text', 'none' );

        if ( ! empty( $settings['link']['url'] ) ) {
            $this->add_render_attribute( 'table_button_text', 'href', $settings['link']['url'] );

            if ( ! empty( $settings['link']['is_external'] ) ) {
                $this->add_render_attribute( 'table_button_text', 'target', '_blank' );
            }
        }

        $this->add_render_attribute( 'pricing-table-duration', 'class', 'gyan-pricing-table-price-duration' );
		if ( $settings['duration_position'] == 'wrap' ) {
            $this->add_render_attribute( 'pricing-table-duration', 'class', 'next-line' );
        }

        $this->add_render_attribute( 'table_button_text', 'class', 'gyan-pricing-table-button' );

        if ( $settings['button_hover_animation'] ) {
			$this->add_render_attribute( 'table_button_text', 'class', 'elementor-animation-' . $settings['button_hover_animation'] );
		}
        ?>
        <div class="gyan-pricing-table-container">
            <div <?php echo $this->get_render_attribute_string( 'pricing-table' ); ?>>

                <div class="gyan-pricing-table-top">

                    <div class="gyan-pricing-table-head">
                        <div class="gyan-pricing-table-title-wrap">
                            <?php if ( ! empty( $settings['table_title'] ) ) { ?>
                                <<?php echo $settings['table_title_html_tag']; ?> <?php echo $this->get_render_attribute_string( 'table_title' ); ?>><?php echo $settings['table_title']; ?></<?php echo $settings['table_title_html_tag']; ?>>
                            <?php } ?>
                            <?php if ( ! empty( $settings['table_subtitle'] ) ) { ?>
                                <p <?php echo $this->get_render_attribute_string( 'table_subtitle' ); ?>><?php echo $settings['table_subtitle']; ?></p>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="clear"></div>

                    <?php if ( $settings['table_title_divider_onoff'] == 'yes' ) { ?>
                        <div class="gyan-pricing-table-title-divider"></div>
                    <?php } ?>

                    <?php if ( ! empty( $settings['table_price'] ) ) { ?>
                        <div class="gyan-pricing-table-price-wrap">
                            <div class="gyan-pricing-table-price">
                                <?php if ( ! empty( $symbol ) && $settings['currency_symbol_position'] == 'before' ) { ?>
                                    <span class="gyan-pricing-table-price-prefix"><?php echo $symbol; ?></span>
                                <?php } ?>
                                <span <?php echo $this->get_render_attribute_string( 'table_price' ); ?>><?php echo $settings['table_price']; ?></span>
                                <?php if ( ! empty( $symbol ) && $settings['currency_symbol_position'] == 'after' ) { ?>
                                    <span class="gyan-pricing-table-price-prefix"><?php echo $symbol; ?></span>
                                <?php } ?>
                                <?php if ( ! empty( $settings['table_duration'] ) ) { ?>
                                    <span <?php echo $this->get_render_attribute_string( 'table_duration' ); ?>><?php echo $settings['table_duration']; ?></span>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="clear"></div>
                    <?php } ?>

                    <?php if ( $settings['icon_type'] != 'none' ) { ?>
                        <div class="gyan-pricing-table-icon-wrap">
                            <?php if ( $settings['icon_type'] == 'icon' ) { ?>
                                <?php if ( ! empty( $settings['table_icon'] ) ) { ?>
                                    <span class="gyan-pricing-table-icon gyan-icon"><?php Icons_Manager::render_icon( $settings['table_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
                                <?php } ?>
                            <?php } else if ( $settings['icon_type'] == 'image' ) { ?>
                                <?php $image = $settings['icon_image'];
                                if ( ! empty( $image['url'] ) ) { ?>
                                    <span class="gyan-pricing-table-icon gyan-pricing-table-icon-image"><?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'image', 'icon_image' ); ?></span>
                                <?php } ?>
                            <?php } ?>
                        </div>
                        <div class="clear"></div>
                    <?php } ?>

                    </div>

                    <div class="gyan-pricing-table-bottom">

                        <ul class="gyan-pricing-table-features">
                            <?php foreach ( $settings['table_features'] as $index => $item ) : ?>
                                <?php
                                    $feature_key = $this->get_repeater_setting_key( 'feature_text', 'table_features', $index );
                                    $this->add_render_attribute( $feature_key, 'class', 'gyan-pricing-table-feature-text' );
                                    $this->add_inline_editing_attributes( $feature_key, 'none' );

                                    $pa_class = '';

                                    if ( $item['exclude'] == 'yes' ) {
                                        $pa_class .= ' excluded';
                                    } else {
                                        $pa_class .= '';
                                    }
                                ?>
                                <li class="elementor-repeater-item-<?php echo $item['_id'] . $pa_class; ?>">
                                    <?php
                                        ob_start();
                                        Icons_Manager::render_icon( $item['feature_icon'], [ 'aria-hidden' => 'true' ] );
                                        $button_icon = ob_get_clean();

                                        if ( !empty($button_icon) ) : ?>
                                            <span class="gyan-pricing-table-fature-icon gyan-icon"><?php echo $button_icon; ?></span>
                                    <?php endif; ?>
                                    <?php if ( $item['feature_text'] ) { ?>
                                        <span <?php echo $this->get_render_attribute_string( $feature_key ); ?>><?php echo $item['feature_text']; ?></span>
                                    <?php } ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="gyan-pricing-table-footer">
                            <?php if ( ! empty( $settings['table_button_text'] ) ) { ?>
                                <a <?php echo $this->get_render_attribute_string( 'table_button_text' ); ?>><?php echo esc_attr( $settings['table_button_text'] ); ?></a>
                            <?php } ?>
                            <?php if ( ! empty( $settings['table_other_info'] ) ) { ?>
                                <div <?php echo $this->get_render_attribute_string( 'table_other_info' ); ?>><?php echo $this->parse_text_editor( $settings['table_other_info'] ); ?></div>
                            <?php } ?>
                        </div>
                        <div class="clear"></div>

                    </div>

            </div>
            <?php if ( $settings['show_ribbon'] == 'yes' && $settings['ribbon_title'] != '' ) { ?>
                <?php
                    $classes = [
                        'gyan-pricing-table-ribbon',
                        'gyan-pricing-table-ribbon-' . $settings['ribbon_style'],
                        'gyan-pricing-table-ribbon-' . $settings['ribbon_position'],
                    ];
                    $this->add_render_attribute( 'ribbon', 'class', $classes );
                ?>
                <div <?php echo $this->get_render_attribute_string( 'ribbon' ); ?>>
                    <div class="gyan-pricing-table-ribbon-inner">
                        <div class="gyan-pricing-table-ribbon-title">
                            <?php echo $settings['ribbon_title']; ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php
    }

    protected function _content_template() {}

}