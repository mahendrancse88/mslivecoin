<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Frontend;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Repeater;

if (!defined('ABSPATH')) { exit; }

class Gyan_Tabs extends Widget_Base {

    public function get_name()           { return 'gyan_tabs'; }
    public function get_title()          { return esc_html__( 'Tabs', 'gyan-elements' ); }
    public function get_icon()           { return 'gyan-el-icon eicon-tabs'; }
    public function get_categories()     { return ['gyan-basic-addons']; }
    public function get_keywords()       { return [ 'gyan tabs', 'tabs', 'tab' ]; }
    public function get_style_depends()  { return ['gyan-icon','gyan-tabs']; }
    public function get_script_depends() { return [ 'gyan-widgets' ]; }

    public function is_reload_preview_required() {
        return true;
    }

    protected function register_controls() {

        $this->start_controls_section(
            'tabs_settings',
            [
                'label' => esc_html__('General Settings', 'gyan-elements'),
            ]
        );
        $this->add_control(
            'tab_layout',
            [
                'label' => esc_html__('Layout', 'gyan-elements'),
                'type' => Controls_Manager::SELECT,
                'default' => 'gyan-tabs-horizontal',
                'label_block' => false,
                'options' => [
                    'gyan-tabs-horizontal' => esc_html__('Horizontal', 'gyan-elements'),
                    'gyan-tabs-vertical' => esc_html__('Vertical', 'gyan-elements'),
                ],
            ]
        );

         $this->add_control(
            'active_tab',
            [
                'label' => esc_html__( 'Active Tab Number', 'elementor' ),
                'type' => Controls_Manager::NUMBER,
                'default'     => 1,
                'min' => 1,
                'label_block' => false,
            ]
        );

        $this->add_control(
            'tabs_icon_show',
            [
                'label' => esc_html__('Enable Icon', 'gyan-elements'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            'tab_icon_position',
            [
                'label' => esc_html__('Icon Position', 'gyan-elements'),
                'type' => Controls_Manager::SELECT,
                'default' => 'gyan-tab-inline-icon',
                'label_block' => false,
                'options' => [
                    'gyan-tab-top-icon' => esc_html__('Stacked', 'gyan-elements'),
                    'gyan-tab-inline-icon' => esc_html__('Inline', 'gyan-elements'),
                ],
                'condition' => [
                    'tabs_icon_show' => 'yes',
                    'tab_layout' => 'gyan-tabs-horizontal',
                ],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'tabs_content_settings',
            [
                'label' => esc_html__('Content', 'gyan-elements'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'icon_type',
            [
                'label' => esc_html__('Icon Type', 'gyan-elements'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'none' => [
                        'title' => esc_html__('None', 'gyan-elements'),
                        'icon' => 'fa fa-ban',
                    ],
                    'icon' => [
                        'title' => esc_html__('Icon', 'gyan-elements'),
                        'icon' => 'fa fa-gear',
                    ],
                    'image' => [
                        'title' => esc_html__('Image', 'gyan-elements'),
                        'icon' => 'fa fa-picture-o',
                    ],
                ],
                'default' => 'icon',
            ]
        );

        $repeater->add_control(
            'tab_icon',
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

        $repeater->add_control(
            'tab_image',
            [
                'label' => esc_html__('Image', 'gyan-elements'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => GYAN_PLUGIN_URL .'addons/images/choose-img.jpg',
                ],
                'condition' => [
                    'icon_type' => 'image',
                ],
            ]
        );

        $repeater->add_control(
            'gyan_tabs_tab_title',
            [
                'label' => esc_html__('Tab Title', 'gyan-elements'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Tab Title', 'gyan-elements'),
                'dynamic' => ['active' => true],
            ]
        );

        $repeater->add_control(
            'tabs_text_type',
            [
                'label' => esc_html__('Content Type', 'gyan-elements'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'content' => esc_html__('Content', 'gyan-elements'),
                    'template' => esc_html__('Saved Templates', 'gyan-elements'),
                ],
                'default' => 'content',
            ]
        );

        $repeater->add_control(
            'primary_templates',
            [
                'label' => esc_html__('Choose Template', 'gyan-elements'),
                'type' => Controls_Manager::SELECT,
                'options' => gyan_get_page_templates_for_tabs(),
                'condition' => [
                    'tabs_text_type' => 'template',
                ],
            ]
        );

        $repeater->add_control(
            'tab_content',
            [
                'label' => esc_html__('Tab Content', 'gyan-elements'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => esc_html__('Lorem ipsum dolor sit amet consectetur adipisicing elit temporibus sunt magni aperiam atex recusandae inventore molestiae scepturi deleniti numquam eius quod veniam cum delectus officia exerci tationem temporibus voluptat.', 'gyan-elements'),
                'dynamic' => ['active' => true],
                'condition' => [
                    'tabs_text_type' => 'content',
                ],
            ]
        );

        $this->add_control(
            'gyan_tabs_tab',
            [
                'label' => esc_html__( 'Gyan Tabs', 'gyan-elements' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['gyan_tabs_tab_title' => esc_html__('Tab Title 1', 'gyan-elements')],
                    ['gyan_tabs_tab_title' => esc_html__('Tab Title 2', 'gyan-elements')],
                    ['gyan_tabs_tab_title' => esc_html__('Tab Title 3', 'gyan-elements')],
                ],
                'title_field' => '{{gyan_tabs_tab_title}}',
            ]
        );

        $this->end_controls_section();

        // Tab Section ------------

        $this->start_controls_section(
            'tabs_section_style',
            [
                'label' => esc_html__('Tab Section', 'gyan-elements'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'tabs_section_maxwidth',
            [
                'label' => esc_html__('Tab Section Maximum Width', 'gyan-elements'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 1200,
                    'unit' => 'px',
                ],
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1500,
                        'step' => 1,
                    ],
                ],
                'condition' => [
                    'tab_layout' => 'gyan-tabs-horizontal',
                ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-tabs-nav' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'tabs_custom_width_on',
            [
                'label' => esc_html__('Custom Tab Width', 'gyan-elements'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
                'default' => 'no',
                'condition' => [
                    'tab_layout' => 'gyan-tabs-horizontal',
                    'tab_icon_position' => 'gyan-tab-top-icon',
                    'tabs_icon_show' => 'yes',
                ],
                'return_value' => 'yes',
                'prefix_class'  => 'gyan-tabs-icon-stack-',
            ]
        );

        $this->add_responsive_control(
            'tabs_max_width',
            [
                'label' => esc_html__('Tab Width', 'gyan-elements'),
                'description' => esc_html__( 'Do not leave "Tab Width" field blank. Click on above "APPLY" button after editing width or enable/disable "Custom Tab Width" option. ".', 'gyan-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                 'default' => [
                    'size' => 220,
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 600,
                        'step' => 1,
                    ],
                ],
                'condition' => [
                    'tabs_custom_width_on' => 'yes',
                    'tab_layout' => 'gyan-tabs-horizontal',
                    'tab_icon_position' => 'gyan-tab-top-icon',
                    'tabs_icon_show' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tabs_alignment',
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
                    ]
                ],
                'default' => 'center',
                'separator' => 'before',
                'condition' => [
                    'tab_layout' => 'gyan-tabs-horizontal',
                ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-tabs.gyan-tabs-horizontal' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tabs_section_padding',
            [
                'label' => esc_html__('Padding', 'gyan-elements'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'tabs_section_margin',
            [
                'label' => esc_html__('Margin', 'gyan-elements'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'tabs_section_bg',
                'label' => esc_html__( 'Background', 'gyan-elements' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'tabs_section_border',
                'label' => esc_html__('Border', 'gyan-elements'),
                'selector' => '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav',
            ]
        );
        $this->add_responsive_control(
            'tabs_section_border_radius',
            [
                'label' => esc_html__('Border Radius', 'gyan-elements'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'tabs_section_box_shadow',
                'selector' => '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav',
            ]
        );


        $this->end_controls_section();

        // Tab
        $this->start_controls_section(
            'all_tab_style_settings',
            [
                'label' => esc_html__('Tabs', 'gyan-elements'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'all_tab_padding',
            [
                'label' => esc_html__('Padding', 'gyan-elements'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'all_tab_margin',
            [
                'label' => esc_html__('Margin', 'gyan-elements'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'separator' => 'after',
                'selectors' => [
                    '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'all_tab_border',
                'label' => esc_html__('Border', 'gyan-elements'),
                'selector' => '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li',
            ]
        );
        $this->add_responsive_control(
            'all_tab_border_radius',
            [
                'label' => esc_html__('Border Radius', 'gyan-elements'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->start_controls_tabs('gyan_tabs_all_tab');

            $this->start_controls_tab('all_tab_normal', ['label' => esc_html__('Normal', 'gyan-elements')]);

                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name' => 'all_tab_bg',
                        'label' => esc_html__( 'Background Color', 'gyan-elements' ),
                        'types' => [ 'classic', 'gradient' ],
                        'fields_options' => [
                            'background' => [
                                'default' =>'classic',
                            ],
                            'color' => [
                                'default'       => '#f2f2f2',
                            ],
                        ],
                        'selector' => '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'all_tab_box_shadow',
                        'selector' => '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li',
                    ]
                );

            $this->end_controls_tab();

            $this->start_controls_tab('all_tab_hover', ['label' => esc_html__('Hover', 'gyan-elements')]);

                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name' => 'all_tab_bg_hover',
                        'label' => esc_html__( 'Background Color', 'gyan-elements' ),
                        'types' => [ 'classic', 'gradient' ],
                        'fields_options' => [
                            'background' => [
                                'default' =>'classic',
                            ],
                            'color' => [
                                'default'       => '#f2f2f2',
                            ],
                        ],
                        'selector' => '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li:hover',
                    ]
                );

                $this->add_control(
                    'all_tab_border_hover',
                    [
                        'label' => esc_html__( 'Border Color', 'gyan-elements' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li:hover' => 'border-color: {{VALUE}};'
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'all_tab_box_shadow_hover',
                        'selector' => '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li:hover',
                    ]
                );

            $this->end_controls_tab();

            $this->start_controls_tab('all_tab_active', ['label' => esc_html__('Active', 'gyan-elements')]);

                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name' => 'all_tab_bg_active',
                        'label' => esc_html__( 'Background Color', 'gyan-elements' ),
                        'types' => [ 'classic', 'gradient' ],
                        'fields_options' => [
                            'background' => [
                                'default' =>'classic',
                            ],
                            'color' => [
                                'default'       => '#d83030',
                            ],
                        ],
                        'selector' => '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li.active,
                            {{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li.active-default',
                    ]
                );

                $this->add_control(
                    'all_tab_border_active',
                    [
                        'label' => esc_html__( 'Border Color', 'gyan-elements' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li.active,
                            {{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li.active-default' => 'border-color: {{VALUE}};'
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'all_tab_box_shadow_active',
                        'selector' => '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li.active,{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li.active-default',
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();


        // Tab Icon
        $this->start_controls_section(
            'tab_icon_style',
            [
                'label' => esc_html__('Tab Icon', 'gyan-elements'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_responsive_control(
                'tab_icon_size',
                [
                    'label' => esc_html__('Size', 'gyan-elements'),
                    'type' => Controls_Manager::SLIDER,
                    'default' => [
                        'size' => 16,
                        'unit' => 'px',
                    ],
                    'size_units' => ['px'],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 200,
                            'step' => 1,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li .gyan-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .gyan-tabs.gyan-tabs-vertical .gyan-tabs-nav > ul li .gyan-icon img' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            if ( is_rtl() ) {

                $this->add_responsive_control(
                    'tab_icon_gap',
                    [
                        'label' => esc_html__('Gap', 'gyan-elements'),
                        'type' => Controls_Manager::SLIDER,
                        'default' => [
                            'size' => 10,
                            'unit' => 'px',
                        ],
                        'size_units' => ['px'],
                        'range' => [
                            'px' => [
                                'min' => 0,
                                'max' => 100,
                                'step' => 1,
                            ],
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .gyan-tab-inline-icon li .gyan-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
                            '{{WRAPPER}} .gyan-tab-top-icon li .gyan-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                            '{{WRAPPER}} .gyan-tabs.gyan-tabs-vertical li > .gyan-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

            } else {

                $this->add_responsive_control(
                    'tab_icon_gap',
                    [
                        'label' => esc_html__('Gap', 'gyan-elements'),
                        'type' => Controls_Manager::SLIDER,
                        'default' => [
                            'size' => 10,
                            'unit' => 'px',
                        ],
                        'size_units' => ['px'],
                        'range' => [
                            'px' => [
                                'min' => 0,
                                'max' => 100,
                                'step' => 1,
                            ],
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .gyan-tab-inline-icon li .gyan-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
                            '{{WRAPPER}} .gyan-tab-top-icon li .gyan-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                            '{{WRAPPER}} .gyan-tabs.gyan-tabs-vertical li > .gyan-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );


            }

            $this->add_responsive_control(
                'tab_icon_iconbox_size',
                [
                    'label' => esc_html__('Icon Box / Image Box - Size', 'gyan-elements'),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => ['px'],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 200,
                            'step' => 1,
                        ],
                    ],
                    'condition' => [
                        'tab_layout' => 'gyan-tabs-horizontal',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li .gyan-icon' => 'width: {{SIZE}}{{UNIT}}; height:{{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name'                  => 'tab_image',
                    'label'                 => esc_html__( 'Image Size', 'gyan-elements' ),
                    'default'               => 'full',
                ]
            );

            $this->add_control(
                'tab_icon_hide',
                [
                    'label'       => esc_html__( 'Hide at', 'gyan-elements' ),
                    'type'        => Controls_Manager::SELECT,
                    'default'     => '',
                    'separator' => 'before',
                    'options'     => [
                        ''  => esc_html__('Nothing', 'gyan-elements'),
                        'm' => esc_html__('Tablet and Mobile ', 'gyan-elements'),
                        's' => esc_html__('Mobile', 'gyan-elements'),
                    ],
                ]
            );



            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'tab_iconbox_border',
                    'label' => esc_html__('Border', 'gyan-elements'),
                    'separator' => 'before',
                    'condition' => [
                        'tabs_icon_show' => 'yes',
                        'tab_layout' => 'gyan-tabs-horizontal',
                    ],
                    'selector' => '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li .gyan-icon',
                ]
            );

            $this->add_control(
                'tab_icon_border_radius',
                [
                    'label' => esc_html__('Border Radius', 'gyan-elements'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'condition' => [
                        'tab_layout' => 'gyan-tabs-horizontal',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li .gyan-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );


            $this->start_controls_tabs('gyan_tabs_icons_tabs');

                $this->start_controls_tab('tabs_icons_normal', ['label' => esc_html__('Normal', 'gyan-elements')]);

                    $this->add_control(
                        'tab_icon_color',
                        [
                            'label' => esc_html__('Icon Color', 'gyan-elements'),
                            'type' => Controls_Manager::COLOR,
                            'default' => '#555',
                            'selectors' => [
                                '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li .gyan-icon' => 'color: {{VALUE}};',
                                 '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li .gyan-icon svg' => 'fill: {{VALUE}};',
                            ],
                            'condition' => [
                                'tabs_icon_show' => 'yes',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'iconbox_bg',
                            'label' => esc_html__( 'Icon Box Background Color', 'gyan-elements' ),
                            'types' => [ 'classic', 'gradient' ],
                            'condition' => [
                                'tabs_icon_show' => 'yes',
                                'tab_layout' => 'gyan-tabs-horizontal',
                            ],
                            'selector' => '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li .gyan-icon',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Box_Shadow::get_type(),
                        [
                            'name' => 'iconbox_box_shadow',
                            'condition' => [
                                'tabs_icon_show' => 'yes',
                                'tab_layout' => 'gyan-tabs-horizontal',
                            ],
                            'selector' => '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li .gyan-icon',
                        ]
                    );

                $this->end_controls_tab();

                $this->start_controls_tab('tabs_icons_hover', ['label' => esc_html__('Hover', 'gyan-elements')]);

                    $this->add_control(
                        'tab_icon_color_hover',
                        [
                            'label' => esc_html__('Icon Color', 'gyan-elements'),
                            'type' => Controls_Manager::COLOR,
                            'default' => '#555',
                            'selectors' => [
                                '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li:hover .gyan-icon' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li:hover .gyan-icon svg' => 'fill: {{VALUE}};',
                            ],
                            'condition' => [
                                'tabs_icon_show' => 'yes',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'iconbox_bg_hover',
                            'label' => esc_html__( 'Icon Box Background Color', 'gyan-elements' ),
                            'types' => [ 'classic', 'gradient' ],
                            'condition' => [
                                'tabs_icon_show' => 'yes',
                                'tab_layout' => 'gyan-tabs-horizontal',
                            ],
                            'selector' => '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li:hover .gyan-icon',
                        ]
                    );

                    $this->add_control(
                        'iconbox_border_hover',
                        [
                            'label' => esc_html__( 'Border Color', 'gyan-elements' ),
                            'type' => Controls_Manager::COLOR,
                            'condition' => [
                                'tabs_icon_show' => 'yes',
                                'tab_layout' => 'gyan-tabs-horizontal',
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li:hover .gyan-icon' => 'border-color: {{VALUE}};'
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Box_Shadow::get_type(),
                        [
                            'name' => 'iconbox_box_shadow_hover',
                            'condition' => [
                                'tabs_icon_show' => 'yes',
                                'tab_layout' => 'gyan-tabs-horizontal',
                            ],
                            'selector' => '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li:hover .gyan-icon',
                        ]
                    );

                $this->end_controls_tab();

                $this->start_controls_tab('tabs_icons_active', ['label' => esc_html__('Active', 'gyan-elements')]);

                    $this->add_control(
                        'tab_icon_color_active',
                        [
                            'label' => esc_html__('Icon Color', 'gyan-elements'),
                            'type' => Controls_Manager::COLOR,
                            'default' => '#fff',
                            'selectors' => [
                                '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li.active .gyan-icon,
                                {{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li.active-default .gyan-icon' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li.active .gyan-icon svg' => 'fill: {{VALUE}};',
                                '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li.active-default .gyan-icon svg' => 'fill: {{VALUE}};',
                            ],
                            'condition' => [
                                'tabs_icon_show' => 'yes',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'iconbox_bg_active',
                            'label' => esc_html__( 'Icon Box Background Color', 'gyan-elements' ),
                            'types' => [ 'classic', 'gradient' ],
                            'condition' => [
                                'tabs_icon_show' => 'yes',
                                'tab_layout' => 'gyan-tabs-horizontal',
                            ],
                            'selector' => '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li.active .gyan-icon,
                                {{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li.active-default .gyan-icon',
                        ]
                    );

                    $this->add_control(
                        'iconbox_border_active',
                        [
                            'label' => esc_html__( 'Border Color', 'gyan-elements' ),
                            'type' => Controls_Manager::COLOR,
                            'condition' => [
                                'tabs_icon_show' => 'yes',
                                'tab_layout' => 'gyan-tabs-horizontal',
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li.active .gyan-icon,
                                {{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li.active-default .gyan-icon' => 'border-color: {{VALUE}};'
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Box_Shadow::get_type(),
                        [
                            'name' => 'iconbox_box_shadow_active',
                            'condition' => [
                                'tabs_icon_show' => 'yes',
                                'tab_layout' => 'gyan-tabs-horizontal',
                            ],
                            'selector' => '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li.active .gyan-icon,
                                {{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li.active-default .gyan-icon',
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();

        // Tab Title
        $this->start_controls_section(
            'tab_title_style',
            [
                'label' => esc_html__('Tab Title', 'gyan-elements'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tab_title_typography',
                'selector' => '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li',
            ]
        );
        $this->add_responsive_control(
            'vertical_tabs_width',
            [
                'label' => esc_html__('Title Min Width', 'gyan-elements'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-tabs.gyan-tabs-vertical .gyan-tabs-nav > ul' => 'min-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'tab_layout' => 'gyan-tabs-vertical',
                ],
            ]
        );

        $this->start_controls_tabs('tab_title_tabs');

        $this->start_controls_tab('tab_title_normal', ['label' => esc_html__('Normal', 'gyan-elements')]);


        $this->add_control(
            'tab_title_color',
            [
                'label' => esc_html__('Text Color', 'gyan-elements'),
                'type' => Controls_Manager::COLOR,
                'default' => '#555',
                'selectors' => [
                    '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();


        $this->start_controls_tab('tab_title_hover', ['label' => esc_html__('Hover', 'gyan-elements')]);

        $this->add_control(
            'tab_title_color_hover',
            [
                'label' => esc_html__('Text Color', 'gyan-elements'),
                'type' => Controls_Manager::COLOR,
                'default' => '#555',
                'selectors' => [
                    '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('tab_title_active', ['label' => esc_html__('Active', 'gyan-elements')]);

        $this->add_control(
            'tab_title_color_active',
            [
                'label' => esc_html__('Text Color', 'gyan-elements'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li.active,
                    {{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li.active-default' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'tab_content_style',
            [
                'label' => esc_html__('Content Section', 'gyan-elements'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'tabs_content_bg_color',
                'label' => esc_html__( 'Icon Box Background Color', 'gyan-elements' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .gyan-tabs .gyan-tabs-content > div',
            ]
        );

        $this->add_control(
            'tabs_content_text_color',
            [
                'label' => esc_html__('Text Color', 'gyan-elements'),
                'type' => Controls_Manager::COLOR,
                'default' => '#555',
                'selectors' => [
                    '{{WRAPPER}} .gyan-tabs .gyan-tabs-content > div' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tabs_content_typography',
                'selector' => '{{WRAPPER}} .gyan-tabs .gyan-tabs-content > div',
            ]
        );
        $this->add_responsive_control(
            'tabs_content_padding',
            [
                'label' => esc_html__('Padding', 'gyan-elements'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .gyan-tabs .gyan-tabs-content > div' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'tabs_content_margin',
            [
                'label' => esc_html__('Margin', 'gyan-elements'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .gyan-tabs .gyan-tabs-content > div' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'tabs_content_border',
                'label' => esc_html__('Border', 'gyan-elements'),
                'selector' => '{{WRAPPER}} .gyan-tabs .gyan-tabs-content > div',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'tabs_content_shadow',
                'selector' => '{{WRAPPER}} .gyan-tabs .gyan-tabs-content > div',
                'separator' => 'before',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'tab_caret_style',
            [
                'label' => esc_html__('Caret', 'gyan-elements'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'tabs_caret_show',
            [
                'label' => esc_html__('Show Caret on Active Tab', 'gyan-elements'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );

        if ( is_rtl() ) {

            $this->add_control(
                'tabs_caret_size',
                [
                    'label' => esc_html__('Caret Size', 'gyan-elements'),
                    'type' => Controls_Manager::SLIDER,
                    'default' => [
                        'size' => 10,
                    ],
                    'range' => [
                        'px' => [
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li:after' => 'border-width: {{SIZE}}px; bottom: -{{SIZE}}px',
                        '{{WRAPPER}} .gyan-tabs.gyan-tabs-vertical .gyan-tabs-nav > ul li:after' => 'left: -{{SIZE}}px !important; top: calc(50% - {{SIZE}}px) !important;',
                    ],
                    'condition' => [
                        'tabs_caret_show' => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'tabs_caret_color',
                [
                    'label' => esc_html__( 'Caret Color', 'gyan-elements' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#d83030',
                    'condition' => [
                        'tabs_caret_show' => 'yes',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li:after' => 'border-top-color: {{VALUE}};',
                                '{{WRAPPER}} .gyan-tabs.gyan-tabs-vertical .gyan-tabs-nav > ul li:after' => 'border-top-color: transparent; border-right-color: {{VALUE}};',
                    ],
                ]
            );

        } else {

            $this->add_control(
                'tabs_caret_size',
                [
                    'label' => esc_html__('Caret Size', 'gyan-elements'),
                    'type' => Controls_Manager::SLIDER,
                    'default' => [
                        'size' => 10,
                    ],
                    'range' => [
                        'px' => [
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li:after' => 'border-width: {{SIZE}}px; bottom: -{{SIZE}}px',
                        '{{WRAPPER}} .gyan-tabs.gyan-tabs-vertical .gyan-tabs-nav > ul li:after' => 'right: -{{SIZE}}px !important; top: calc(50% - {{SIZE}}px) !important;',
                    ],
                    'condition' => [
                        'tabs_caret_show' => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'tabs_caret_color',
                [
                    'label' => esc_html__( 'Caret Color', 'gyan-elements' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#d83030',
                    'condition' => [
                        'tabs_caret_show' => 'yes',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .gyan-tabs .gyan-tabs-nav > ul li:after' => 'border-top-color: {{VALUE}};',
                                '{{WRAPPER}} .gyan-tabs.gyan-tabs-vertical .gyan-tabs-nav > ul li:after' => 'border-top-color: transparent; border-left-color: {{VALUE}};',
                    ],
                ]
            );

        }





        $this->end_controls_section();

    }

    protected function render() {

        $settings = $this->get_settings_for_display();
        $gyan_find_default_tab = array();
        $gyan_tab_id = 1;
        $gyan_tab_content_id = 1;

        $active_tab = ( '' != $settings['active_tab'] ) ? intval($settings['active_tab']) - 1 : '';

        $this->add_render_attribute(
            'gyan_tab_wrapper',
            [
                'id' => "gyan-tabs-{$this->get_id()}",
                'class' => ['gyan-tabs', $settings['tab_layout']],
                'data-tabid' => $this->get_id(),
            ]
        );

        if ($settings['tabs_caret_show'] != 'yes') {
            $this->add_render_attribute('gyan_tab_wrapper', 'class', 'active-caret-on');
        }

        $this->add_render_attribute('tab_icon_position', 'class', esc_attr($settings['tab_icon_position']));
        ?>
    	<div <?php echo $this->get_render_attribute_string('gyan_tab_wrapper'); ?>>
      		<div class="gyan-tabs-nav">
        		<ul <?php echo $this->get_render_attribute_string('tab_icon_position'); ?>>
        	    	<?php foreach ($settings['gyan_tabs_tab'] as $index => $tab):
                        $get_active_tab = ( $active_tab == $index ) ? 'active-default' : '';
                        ?>
        	      		<li class="<?php echo esc_attr($get_active_tab); ?> gyan-ease-transition">
                            <?php if ( 'yes' == $settings['tabs_custom_width_on'] ) { ?>
                                <div class="gyan-tabs-nav-li-inner">
                            <?php } ?>
                            <?php if ($settings['tabs_icon_show'] === 'yes'): ?>
                                <span class="gyan-icon gyan-ease-transition <?php echo $tab_icon_hide = $settings['tab_icon_hide'] ? 'gyan-visible@'. $settings['tab_icon_hide'] : ''; ?>">
                                 <?php if ($tab['icon_type'] === 'icon'): ?>
                                        <?php Icons_Manager::render_icon( $tab['tab_icon'], [ 'aria-hidden' => 'true' ] ); ?>
        			      				<?php elseif ($tab['icon_type'] === 'image'):

                                            // responsive image
                                            if (  $settings['tab_image_size'] == 'full' ) {
                                                $imageTagHtml = wp_get_attachment_image( $tab['tab_image']['id'], 'full', "", ["alt" => esc_attr(get_post_meta($tab['tab_image']['id'], '_wp_attachment_image_alt', true))]);
                                            } else {
                                                $imgUrl = Group_Control_Image_Size::get_attachment_image_src( $tab['tab_image']['id'], 'tab_image', $settings );
                                                if ( ! $imgUrl ) {
                                                    $imgUrl = $tab['tab_image']['url'];
                                                }
                                                $imageTagHtml = '<img src="'.esc_url($imgUrl).'" alt="" />';
                                            }

                                            echo $imageTagHtml;
                                            ?>

        	      			      <?php endif;?></span>
        	      		   <?php endif;?><span class="gyan-tab-title"><?php echo $tab['gyan_tabs_tab_title']; ?></span>
                           <?php if ( 'yes' == $settings['tabs_custom_width_on'] ) { ?>
                               </div>
                           <?php } ?>
                        </li>
        	      	<?php endforeach;?>
            	</ul>
      		</div>
      		<div class="gyan-tabs-content">
      			<?php foreach ($settings['gyan_tabs_tab'] as $index => $tab):
                    $get_active_tab = ( $active_tab == $index ) ? 'active-default' : '';
                    ?>
                    <div class="<?php echo esc_attr($get_active_tab) ?>">
    		      		<?php if ('content' == $tab['tabs_text_type']): ?>
    							<?php echo do_shortcode($tab['tab_content']); ?>
    							<?php elseif ('template' == $tab['tabs_text_type']): ?>
                                <?php
                                if (!empty($tab['primary_templates'])) {
                                    $gyan_template_id = $tab['primary_templates'];
                                    $gyan_frontend = new Frontend;
                                    echo $gyan_frontend->get_builder_content($gyan_template_id, true);
                                }
                                ?>
    				    <?php endif;?>
                    </div>
    			<?php endforeach;?>
      		</div>
    	</div>
	   <?php
    }

    protected function content_template(){}
}