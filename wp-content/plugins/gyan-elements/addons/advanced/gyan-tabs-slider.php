<?php
// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Gyan_Tabs_Slider extends Widget_Base {

    public function get_name()           { return 'gyan_tabs_slider'; }
    public function get_title()          { return esc_html__( 'Tabs Slider', 'gyan-elements' ); }
    public function get_icon()           { return 'gyan-el-icon eicon-gallery-group'; }
    public function get_categories()     { return ['gyan-advanced-addons' ]; }
    public function get_keywords()       { return ['gyan tabs slider', 'tabs', 'slider','image','slide', ]; }
    public function get_style_depends()  { return ['gyan-grid','gyan-tabs-slider']; }
    public function get_script_depends() { return [ 'gyan-widgets' ]; }

    protected function register_controls() {

        $this->start_controls_section(
            'section_gallery',
            [
                'label'                 => esc_html__( 'Tabs', 'gyan-elements' ),
            ]
        );

            $repeater = new Repeater();

            $repeater->add_control(
                'unique_id',
                [
                    'label' => esc_html__( 'Unique ID (Required)', 'gyan-elements' ),
                    'type' => Controls_Manager::TEXT,
                    'placeholder' => esc_html__( 'Enter Unique ID', 'gyan-elements' ),
                    'description' => esc_html__( 'Make sure this ID is unique. Do not add # key before id. You can use any text for unique id.', 'gyan-elements' ),
                ]
            );

            $repeater->add_control(
                'tab_image',
                [
                    'label'                 => esc_html__( 'Image', 'gyan-elements' ),
                    'type'                  => Controls_Manager::MEDIA
                ]
            );

            $repeater->add_control(
                'title_text',
                [
                    'label' => esc_html__( 'Title', 'gyan-elements' ),
                    'label_block' => true,
                    'type' => Controls_Manager::TEXT,
                    'default' => 'Title text',
                ]
            );

            $repeater->add_control(
                'desc_text',
                [
                    'label' => esc_html__( 'Description', 'gyan-elements' ),
                    'label_block' => true,
                    'type' => Controls_Manager::TEXTAREA,
                    'placeholder' => esc_html__( 'Enter Description', 'gyan-elements' ),
                    'description' => esc_html__( 'You can use HTML.', 'gyan-elements' ),
                    'default' => 'This is sample description text auctor oned scelerisquinterdum leo anet onpe',
                ]
            );

            $this->add_control(
                'tabs',
                [
                    'label' => esc_html__( 'Tabs', 'gyan-elements' ),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'title_field' => '{{{ title_text }}}',
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
            'tabs_settings',
            [
                'label' => esc_html__( 'Tabs Settings', 'gyan-elements' ),
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
             'tab_image_stack',
             [
                 'label'                 => esc_html__( 'Stack On', 'gyan-elements' ),
                 'type'                  => Controls_Manager::SELECT,
                 'default'               => 'tablet',
                 'options'               => [
                     'tablet'    => esc_html__( 'Tablet', 'gyan-elements' ),
                     'mobile'    => esc_html__( 'Mobile', 'gyan-elements' ),
                 ],
                 'prefix_class'          => 'gyan-tabs-slider-stack-',
             ]
         );

        $this->add_control(
            'tabslider_align',
            [
                 'label'                 => esc_html__( 'Tabs Align', 'gyan-elements' ),
                 'type'                  => Controls_Manager::CHOOSE,
                 'label_block'           => false,
                 'toggle'                => false,
                 'default'               => 'left',
                 'options'               => [
                     'left'          => [
                         'title'     => esc_html__( 'Left', 'gyan-elements' ),
                         'icon'      => 'eicon-h-align-left',
                     ],
                     'right'         => [
                         'title'     => esc_html__( 'Right', 'gyan-elements' ),
                         'icon'      => 'eicon-h-align-right',
                     ],
                 ],
                 'prefix_class'          => 'gyan-tabs-slider-align-',
                 'frontend_available'    => true,
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

         $this->add_group_control(
             Group_Control_Image_Size::get_type(),
             [
                 'name'                  => 'tab_image',
                 'label'                 => esc_html__( 'Image Size', 'gyan-elements' ),
                 'default'               => 'full',
             ]
         );


        $this->add_responsive_control(
            'tab_image_width',
            [
                'label'                 => esc_html__( 'Width', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'size_units'            => [ '%' ],
                'range'                 => [
                    '%'     => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'               => [
                    'size'  => 67,
                ],
                'selectors'             => [
                    '{{WRAPPER}}.gyan-tabs-slider-align-left .gyan-tabs-slider-images' => 'width: {{SIZE}}%',
                    '{{WRAPPER}}.gyan-tabs-slider-align-right .gyan-tabs-slider-images' => 'width: {{SIZE}}%',
                    '{{WRAPPER}}.gyan-tabs-slider-align-right .gyan-tabs-slider-tabs' => 'width: calc(100% - {{SIZE}}%)',
                    '{{WRAPPER}}.gyan-tabs-slider-align-left .gyan-tabs-slider-tabs' => 'width: calc(100% - {{SIZE}}%)',
                ],
            ]
        );

        $this->add_responsive_control(
            'tab_image_spacing',
            [
                'label'                 => esc_html__( 'Spacing', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px'    => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'default'               => [
                    'size'  => 10,
                ],
                'selectors'             => [
                    '{{WRAPPER}}.gyan-tabs-slider-align-left .gyan-tabs-slider,
                    {{WRAPPER}}.gyan-tabs-slider-align-right .gyan-tabs-slider' => 'margin-left: -{{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.gyan-tabs-slider-align-left .gyan-tabs-slider > *,
                    {{WRAPPER}}.gyan-tabs-slider-align-right .gyan-tabs-slider > *' => 'padding-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.gyan-tabs-slider-align-top .gyan-tabs-slider-tabs' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    '(tablet){{WRAPPER}}.gyan-tabs-slider-stack-tablet .gyan-tabs-slider-tabs' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    '(mobile){{WRAPPER}}.gyan-tabs-slider-stack-mobile .gyan-tabs-slider-tabs' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'tab_image_border',
                'selector' => '{{WRAPPER}} .gyan-tabs-slider-image img',
            ]
        );

        $this->add_control(
            'tab_image_border_radius',
            [
                'label'                 => esc_html__( 'Border Radius', 'gyan-elements' ),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => [ 'px', '%' ],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-tabs-slider-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'tabs_style_section',
            [
                'label' => esc_html__( 'Tabs', 'gyan-elements' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'slider_tabs_spacing',
            [
                'label'                 => esc_html__( 'Tabs Spacing', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px'    => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'default'               => [
                    'size'  => '10',
                ],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-tabs-slider-tab' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'tab_border',
                'selector' => '{{WRAPPER}} .gyan-tabs-slider-tab',
            ]
        );

        $this->add_control(
            'tab_border_radius',
            [
                'label'                 => esc_html__( 'Border Radius', 'gyan-elements' ),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => [ 'px', '%' ],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-tabs-slider-tab,{{WRAPPER}} .gyan-tabs-slider-tab:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'padding',
            [
                'label' => esc_html__( 'Padding', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'after',
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-tabs-slider-tab' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_style' );

            $this->start_controls_tab(
                'tabs_normal',
                [
                    'label' => esc_html__( 'Normal', 'gyan-elements' ),
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'tabs_background',
                    'label' => esc_html__( 'Background', 'gyan-elements' ),
                    'types' => [ 'classic','gradient' ],
                    'fields_options' => [
                        'background' => [
                            'default' =>'classic',
                        ],
                        'color' => [
                            'default' => '#f2f2f2',
                        ],
                    ],
                    'selector' => '{{WRAPPER}} .gyan-tabs-slider-tab',
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'tabs_border',
                    'selector' => '{{WRAPPER}} .gyan-tabs-slider-tab',
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name'                  => 'tabs_box_shadow',
                    'selector'              => '{{WRAPPER}} .gyan-tabs-slider-tab',
                ]
            );

            $this->end_controls_tab();

            $this->start_controls_tab(
                'tabs_hover',
                [
                    'label' => esc_html__( 'Hover/Active', 'gyan-elements' ),
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'tabs_hover_background',
                    'label' => esc_html__( 'Background', 'gyan-elements' ),
                    'types' => [ 'classic','gradient' ],
                    'fields_options' => [
                        'background' => [
                            'default' =>'classic',
                        ],
                        'color' => [
                            'default' => '#d83030',
                        ],
                    ],
                    'selector' => '{{WRAPPER}} .gyan-tabs-slider-tab:hover:before,
                                    {{WRAPPER}} .gyan-tabs-slider-tab.active-tab',
                ]
            );

            $this->add_control(
                'tabs_hover_border',
                [
                    'label' => esc_html__( 'Border Color', 'gyan-elements' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .gyan-tabs-slider-tab:hover,
                        {{WRAPPER}} .gyan-tabs-slider-tab.active-tab' => 'border-color: {{VALUE}};'
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name'                  => 'tabs_hover_box_shadow',
                    'selector'              => '{{WRAPPER}} .gyan-tabs-slider-tab:hover,
                                                {{WRAPPER}} .gyan-tabs-slider-tab.active-tab',
                ]
            );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'title_style',
            [
                'label' => esc_html__( 'Title', 'gyan-elements' ),
                'tab' => Controls_Manager::TAB_STYLE,
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
                ],
                'default' => 'h3',
            ]
        );

        $this->add_responsive_control(
            'tab_title_spacing',
            [
                'label'                 => esc_html__( 'Bottom Margin', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px'    => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'default'               => [
                    'size'  => '10',
                ],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-tabs-slider-tab .gyan-tabs-slider-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Color', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#032e42',
                'selectors' => [
                    '{{WRAPPER}} .gyan-tabs-slider-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label' => esc_html__( 'Hover/Active Color', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .gyan-tabs-slider-tab:hover .gyan-tabs-slider-title,
                    {{WRAPPER}} .gyan-tabs-slider-tab.active-tab .gyan-tabs-slider-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'title_text_typography',
                'label'                 => esc_html__( 'Typography', 'gyan-elements' ),
                'selector'              => '{{WRAPPER}} .gyan-tabs-slider-title',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'desc_style',
            [
                'label' => esc_html__( 'Description', 'gyan-elements' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'desc_color',
            [
                'label' => esc_html__( 'Color', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#676767',
                'selectors' => [
                    '{{WRAPPER}} .gyan-tabs-slider-desc' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'desc_hover_color',
            [
                'label' => esc_html__( 'Hover/Active Color', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .gyan-tabs-slider-tab:hover .gyan-tabs-slider-desc,
                    {{WRAPPER}} .gyan-tabs-slider-tab.active-tab .gyan-tabs-slider-desc' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'desc_text_typography',
                'label'                 => esc_html__( 'Typography', 'gyan-elements' ),
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
                            'size' => '25',
                        ],
                    ],
                ],
                'selector'              => '{{WRAPPER}} .gyan-tabs-slider-desc',
            ]
        );

        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $active_tab = ( '' != $settings['active_tab'] ) ? intval($settings['active_tab']) - 1 : '';
        ?>

        <div class="gyan-tabs-slider">
            <div class="gyan-tabs-slider-tabs">
                <ul class="gyan-tabs-slider-list-tabs">

                    <?php foreach ( $settings['tabs'] as $index => $item ) :

                        if ( '' != $item['unique_id'] ) {
                            $unique_id = $item['unique_id'];
                        } else {
                            $unique_id = $item['_id'];
                        }

                        $get_active_tab = ( $active_tab == $index ) ? 'active-tab' : '';
                        ?>

                        <li data-tab="#<?php echo $unique_id;?>" class="gyan-tabs-slider-tab gyan-ease-transition <?php echo $get_active_tab; ?>">
                            <?php if ( $item['title_text'] ) { ?>
                                <<?php echo $settings['title_tag']; ?> class="gyan-tabs-slider-title gyan-ease-transition"><?php echo esc_html($item['title_text']); ?></<?php echo $settings['title_tag']; ?>>
                            <?php } ?>
                            <?php if ( $item['desc_text'] ) { ?>
                                <div class="gyan-tabs-slider-desc gyan-ease-transition"><?php echo esc_html($item['desc_text']); ?></div>
                            <?php } ?>
                        </li>

                    <?php endforeach; ?>

                </ul>
            </div>
            <div class="gyan-tabs-slider-images">
                <div class="gyan-tabs-slider-content">
                    <?php
                    foreach ( $settings['tabs'] as $index => $item ) :

                        $get_active_tab_image = ( $active_tab == $index ) ? 'active-tab-image' : '';

                        if ( '' != $item['unique_id'] ) {
                            $unique_id = $item['unique_id'];
                        } else {
                            $unique_id = $item['_id'];
                        }

                        // responsive image
                        if (  $settings['tab_image_size'] == 'full' ) {
                            $imageTagHtml = wp_get_attachment_image( $item['tab_image']['id'], 'full');
                        } else {
                            $imgUrl = Group_Control_Image_Size::get_attachment_image_src( $item['tab_image']['id'], 'tab_image', $settings );
                            if ( ! $imgUrl ) {
                                $imgUrl = $item['tab_image']['url'];
                            }
                            $imageTagHtml = '<img src="'.esc_url($imgUrl).'" alt="" />';
                        }

                        ?>
                        <div class="gyan-tabs-slider-image <?php echo $get_active_tab_image; ?>" id="<?php echo $unique_id;?>">
                            <?php echo $imageTagHtml; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

    <?php

    }

    protected function _content_template() {}

}