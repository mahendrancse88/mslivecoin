<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Repeater;
use Elementor\Plugin;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) {exit; }

class Gyan_Portfolio extends Widget_Base {

    public function get_name() {return 'gyan_portfolio'; }
    public function get_title() {return esc_html__( 'Portfolio', 'gyan-elements' ); }
    public function get_icon() { return 'gyan-el-icon eicon-gallery-grid'; }
    public function get_categories() {return [ 'gyan-advanced-addons' ]; }
    public function get_keywords() {return [ 'gyan portfolio', 'portfolio', 'image','video','gallery' ]; }
    public function get_style_depends() {return [ 'gyan-pagination','gyan-icon','gyan-flex','gyan-grid','gyan-portfolio' ]; }
    public function get_script_depends() { return [ 'gyan-widgets','imagesLoaded', 'isotope','gyan-element-resize' ]; }

    protected function register_controls() {

        $this->start_controls_section(
            'portfolio_content',
            [
                'label' => esc_html__( 'Portfolio Settings', 'gyan-elements' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'porftolio_style',
            [
                'label'   => esc_html__( 'Display Style', 'gyan-elements' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    '1' => esc_html__( 'Style 1', 'gyan-elements' ),
                    '2' => esc_html__( 'Style 2', 'gyan-elements' ),
                    '3' => esc_html__( 'Style 3', 'gyan-elements' )
                ]
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label'                 => esc_html__( 'Columns', 'gyan-elements' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => '3',
                'tablet_default'        => '2',
                'mobile_default'        => '1',
                'options'               => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                    '8' => '8'
                ],
                'prefix_class'          => 'elementor-grid%s-',
                'frontend_available'    => true
            ]
        );

        $this->add_control(
            'layout',
            [
                'label' => esc_html__( 'Layout', 'gyan-elements' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'grid' => esc_html__( 'Grid', 'gyan-elements' ),
                    'masonry' => esc_html__( 'Masonry', 'gyan-elements' )
                ],
                'default' => 'grid',
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'                  => 'image',
                'label'                 => esc_html__( 'Image Size', 'gyan-elements' ),
                'default'               => 'full'
            ]
        );

        $this->add_control(
            'click_action',
            [
                'label'   => esc_html__( 'Click Action', 'uael' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'lightbox',
                'options' => [
                    'lightbox'   => esc_html__( 'Lightbox', 'uael' ),
                    'file'       => esc_html__( 'Media File', 'uael' ),
                    'attachment' => esc_html__( 'Attachment Page', 'uael' ),
                    ''           => esc_html__( 'None', 'uael' ),
                ],
            ]
        );


        $this->add_control(
            'show_filter_tabs',
            [
                'label'                 => esc_html__( 'Filterable Tabs', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_off' => esc_html__( 'No', 'gyan-elements' ),
                'label_on'  => esc_html__( 'Yes', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'all_tab_label',
            [
                'label' => esc_html__( '"All" Tab Label', 'gyan-elements' ),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'default' => 'All',
                'condition'             => [
                    'show_filter_tabs'      => 'yes'
                ],
            ]
        );

        $this->add_control(
            'show_overlay',
            [
                'label'                 => esc_html__( 'Overlay', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_off' => esc_html__( 'No', 'gyan-elements' ),
                'label_on'  => esc_html__( 'Yes', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'overlay_animation',
            [
                'label'   => esc_html__( 'Overlay Animation', 'gyan-elements' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'scale',
                'condition'             => [
                    'show_overlay'      => 'yes',
                ],
                'options' => [
                    'fade' => esc_html__( 'Fade', 'gyan-elements' ),
                    'scale' => esc_html__( 'Scale', 'gyan-elements' ),
                ]
            ]
        );

        $this->add_control(
            'show_zoom_icon',
            [
                'label'                 => esc_html__( 'Zoom Icon', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_off' => esc_html__( 'No', 'gyan-elements' ),
                'label_on'  => esc_html__( 'Yes', 'gyan-elements' ),
                'condition'             => [
                    'show_overlay'      => 'yes',
                    'click_action!'     => ''
                ],
            ]
        );

        $this->add_control(
            'show_link_icon',
            [
                'label'                 => esc_html__( 'Link Icon', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_off' => esc_html__( 'No', 'gyan-elements' ),
                'label_on'  => esc_html__( 'Yes', 'gyan-elements' ),
                'condition'             => [
                    'show_overlay'      => 'yes'
                ],
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label'                 => esc_html__( 'Title', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_off' => esc_html__( 'No', 'gyan-elements' ),
                'label_on'  => esc_html__( 'Yes', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'link_title',
            [
                'label'                 => esc_html__( 'Link on Title', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_off' => esc_html__( 'No', 'gyan-elements' ),
                'label_on'  => esc_html__( 'Yes', 'gyan-elements' ),
                'condition'             => [
                    'show_title'      => 'yes'
                ],
            ]
        );
        $this->add_control(
            'show_category',
            [
                'label'                 => esc_html__( 'Category', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_off' => esc_html__( 'No', 'gyan-elements' ),
                'label_on'  => esc_html__( 'Yes', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'show_excerpt',
            [
                'label'                 => esc_html__( 'Excerpt', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'no',
                'label_off' => esc_html__( 'No', 'gyan-elements' ),
                'label_on'  => esc_html__( 'Yes', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label' => esc_html__( 'Excerpt Length', 'gyan-elements' ),
                'label_block' => true,
                'type' => Controls_Manager::NUMBER,
                'default' => '50',
                'condition'             => [
                    'show_excerpt'      => 'yes'
                ],
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label'                 => esc_html__( 'Pagination', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'no',
                'label_off' => esc_html__( 'No', 'gyan-elements' ),
                'label_on'  => esc_html__( 'Yes', 'gyan-elements' ),
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'zoom_link_icons',
            [
                'label' => esc_html__( 'Zoom and Link Icons', 'gyan-elements' ),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'show_overlay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'icon_zoom',
            [
                'label' => esc_html__( 'Zoom Icon', 'elementor' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-plus',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'show_zoom_icon' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'icon_link',
            [
                'label' => esc_html__( 'Link Icon', 'elementor' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-link',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'show_link_icon' => 'yes',
                ],
            ]
        );


        $this->end_controls_section();


        $this->start_controls_section(
            'portfolio_query_section',
            [
                'label' => esc_html__( 'Query', 'gyan-elements' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => esc_html__( 'Posts Per Page', 'gyan-elements' ),
                'label_block' => true,
                'type' => Controls_Manager::NUMBER,
                'default' => '6'
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'     => esc_html__( 'Order by', 'uael' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'date',
                'options'   => [
                    'date'       => esc_html__( 'Date', 'uael' ),
                    'title'      => esc_html__( 'Title', 'uael' ),
                    'rand'       => esc_html__( 'Random', 'uael' ),
                    'menu_order' => esc_html__( 'Menu Order', 'uael' ),
                ]
            ]
        );

        $this->add_control(
            'order',
            [
                'label'     => esc_html__( 'Order', 'uael' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'DESC',
                'options'   => [
                    'DESC' => esc_html__( 'Descending', 'uael' ),
                    'ASC'  => esc_html__( 'Ascending', 'uael' ),
                ]
            ]
        );

        $this->add_control(
            'exclude_pf_cat',
            [
                'label' => esc_html__( 'Exclude Categories', 'plugin-domain' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => get_portfolio_cat_list()
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'fields_content',
            [
                'label' => esc_html__( 'Help', 'gyan-elements' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'api_url',
            [
                'label' => 'Video Tutorial - Add / Change Portfolio Image and Category : <a target="_blank" href="https://www.youtube.com/watch?v=BFNJfrH03u0&list=PLXFhS0UVwaV6TXs6uW2MJIKLW17IlwaOT&index=12&t=0s">Click Here</a>',
                'type' => Controls_Manager::RAW_HTML,
                'separator' => 'after',
            ]
        );

        $this->end_controls_section();




        $this->start_controls_section(
            'menu_style',
            [
                'label' => esc_html__( 'Filterable Tabs', 'gyan-elements' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    'show_filter_tabs'      => 'yes'
                ],
            ]
        );
        Gyan_Common_Data::filter_button( $this, '.gyan-portfolio-btn' );
        $this->add_responsive_control(
            'filter_tabs_gap',
            [
                'label' => esc_html__( 'Gap From Items', 'gyan-elements' ),
                'type' => Controls_Manager::SLIDER,
                'default' =>[
                    'size' => '40',
                ],
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .gyan-portfolio-btns' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'filter_tabs_radius',
            [
                'label' => esc_html__( 'Border Radius', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-portfolio-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'filter_tabs_padding',
            [
                'label' => esc_html__( 'Padding', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => '10',
                    'right' => '15',
                    'bottom' => '10',
                    'left' => '15',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-portfolio-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'filter_tabs_margin',
            [
                'label' => esc_html__( 'Margin', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => '3',
                    'right' => '3',
                    'bottom' => '3',
                    'left' => '3',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-portfolio-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'btn_alignment',
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
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .gyan-portfolio-btns' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'item_style',
            [
                'label' => esc_html__( 'Items', 'gyan-elements' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'column_gap',
            [
                'label'     => esc_html__( 'Columns Gap', 'uael' ),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 30,
                ],
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-portfolio-item.gyan-grid-item-wrap' => 'padding-right: calc( {{SIZE}}{{UNIT}}/2 ); padding-left: calc( {{SIZE}}{{UNIT}}/2 );',
                    '{{WRAPPER}} .gyan-portfolio-grid.gyan-elementor-grid' => 'margin-left: calc( -{{SIZE}}{{UNIT}}/2 ); margin-right: calc( -{{SIZE}}{{UNIT}}/2 );',
                ],
            ]
        );

        $this->add_responsive_control(
            'row_gap',
            [
                'label'     => esc_html__( 'Rows Gap', 'uael' ),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 30,
                ],
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-elementor-grid .gyan-portfolio-item-inner.gyan-grid-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'items_radius',
            [
                'label' => esc_html__( 'Border Radius', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-portfolio-item-inner, {{WRAPPER}} .gyan-portfolio-img-holder, {{WRAPPER}} .gyan-portfolio-overlay' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'overlay_background',
            [
                'label' => esc_html__( 'Overlay Background', 'gyan-elements' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    'show_overlay'      => 'yes'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'overlay_bg',
                'types' => [ 'classic', 'gradient' ],
                'fields_options' => [
                    'background' => [
                        'default' =>'classic',
                    ],
                    'color' => [
                        'default' => 'rgba(0,0,0,0.3)',
                    ],
                ],
                'selector' => '{{WRAPPER}} .gyan-portfolio-overlay',
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'icons_style',
            [
                'label' => esc_html__( 'Overlay Icons', 'gyan-elements' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    'show_overlay'      => 'yes'
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
                'default'               => [
                    'size'  => 12,
                    'unit'  => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .gyan-portfolio-hover-icons a' => 'font-size: {{SIZE}}{{UNIT}};',
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
                        'min'  => 0,
                        'max'  => 200,
                        'step' => 1,
                    ],
                ],
                'size_units' => [ 'px', 'em' ],
                'default'               => [
                    'size'  => 32,
                    'unit'  => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .gyan-portfolio-hover-icons a' => 'height:{{SIZE}}{{UNIT}}; width:{{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_box_margin',
            [
                'label' => esc_html__( 'Icon Box Margin', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '7',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-portfolio-hover-icons a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_border_style',
            [
                'label'       => esc_html__( 'Border Style', 'gyan-elements' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'solid',
                'options'     => [
                    'none'   => esc_html__( 'None', 'gyan-elements' ),
                    'solid'  => esc_html__( 'Solid', 'gyan-elements' ),
                    'double' => esc_html__( 'Double', 'gyan-elements' ),
                    'dotted' => esc_html__( 'Dotted', 'gyan-elements' ),
                    'dashed' => esc_html__( 'Dashed', 'gyan-elements' ),
                ],
                'selectors'   => [
                    '{{WRAPPER}} .gyan-portfolio-hover-icons a' => 'border-style: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_border_width',
            [
                'label' => esc_html__( 'Border Width', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'condition'             => [
                    'icon_border_style!'     => 'none'
                ],
                'default'               => [
                    'size'  => 2,
                    'unit'  => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-portfolio-hover-icons a' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_radius',
            [
                'label' => esc_html__( 'Border Radius', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} a.gyan-portfolio-link-icon,{{WRAPPER}} a.gyan-portfolio-zoom-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_section_margin',
            [
                'label' => esc_html__( 'Icon Section Margin', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-portfolio-hover-icons' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'icons_tabs' );

        $this->start_controls_tab(
            'icons_normal',
            [
                'label' => esc_html__( 'Normal', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'zoom_i_color',
            [
                'label' => esc_html__( 'Zoom Icon Color', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'condition'             => [
                    'click_action!'     => ''
                ],
                'selectors' => [
                    '{{WRAPPER}} a.gyan-portfolio-zoom-icon i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} a.gyan-portfolio-zoom-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'zoom_i_bg',
            [
                'label' => esc_html__( 'Zoom Icon Background', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'condition'             => [
                    'click_action!'     => ''
                ],
                'selectors' => [
                    '{{WRAPPER}} a.gyan-portfolio-zoom-icon' => 'background: {{VALUE}}'
                ],
            ]
        );

        $this->add_control(
            'zoom_i_border',
            [
                'label' => esc_html__( 'Zoom Icon Border Color', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'condition'             => [
                    'click_action!'     => '',
                    'icon_border_style!'     => 'none'
                ],
                'selectors' => [
                    '{{WRAPPER}} a.gyan-portfolio-zoom-icon' => 'border-color: {{VALUE}}'
                ],
            ]
        );

        $this->add_control(
            'link_i_color',
            [
                'label' => esc_html__( 'Link Icon Color', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'condition'             => [
                    'show_link_icon'      => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} a.gyan-portfolio-link-icon i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} a.gyan-portfolio-link-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'link_i_bg',
            [
                'label' => esc_html__( 'Link Icon Background', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'condition'             => [
                    'show_link_icon'      => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} a.gyan-portfolio-link-icon' => 'background: {{VALUE}}'
                ],
            ]
        );

        $this->add_control(
            'link_i_border',
            [
                'label' => esc_html__( 'Link Icon Border Color', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'condition'             => [
                    'show_link_icon'      => 'yes',
                    'icon_border_style!'     => 'none'
                ],
                'selectors' => [
                    '{{WRAPPER}} a.gyan-portfolio-link-icon' => 'border-color: {{VALUE}}'
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'icons_hover',
            [
                'label' => esc_html__( 'Hover', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'zoom_i_color_hover',
            [
                'label' => esc_html__( 'Zoom Icon Color', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'condition'             => [
                    'click_action!'     => ''
                ],
                'selectors' => [
                    '{{WRAPPER}} a.gyan-portfolio-zoom-icon:hover i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} a.gyan-portfolio-zoom-icon:hover svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'zoom_i_bg_hover',
            [
                'label' => esc_html__( 'Zoom Icon Background', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#252628',
                'condition'             => [
                    'click_action!'     => ''
                ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-portfolio-zoom-icon:hover' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'zoom_i_border_hover',
            [
                'label' => esc_html__( 'Zoom Icon Border Color', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#252628',
                'condition'             => [
                    'click_action!'     => '',
                    'icon_border_style!'     => 'none'
                ],
                'selectors' => [
                    '{{WRAPPER}} a.gyan-portfolio-zoom-icon:hover' => 'border-color: {{VALUE}}'
                ],
            ]
        );

        $this->add_control(
            'link_i_color_hover',
            [
                'label' => esc_html__( 'Link Icon Color', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'condition'             => [
                    'show_link_icon'      => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} a.gyan-portfolio-link-icon:hover i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} a.gyan-portfolio-link-icon:hover svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'link_i_bg_hover',
            [
                'label' => esc_html__( 'Link Icon Background', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#252628',
                'condition'             => [
                    'show_link_icon'      => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} a.gyan-portfolio-link-icon:hover' => 'background: {{VALUE}}'
                ],
            ]
        );

        $this->add_control(
            'link_i_border_hover',
            [
                'label' => esc_html__( 'Link Icon Border Color', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#252628',
                'condition'             => [
                    'show_link_icon'      => 'yes',
                    'icon_border_style!'     => 'none'
                ],
                'selectors' => [
                    '{{WRAPPER}} a.gyan-portfolio-link-icon:hover' => 'border-color: {{VALUE}}'
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->end_controls_section();


        $this->start_controls_section(
            'content_styling',
            [
                'label' => esc_html__( 'Content Box', 'gyan-elements' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'content_border',
                'selector' => '{{WRAPPER}} .gyan-portfolio-all-content',
            ]
        );

        $this->add_responsive_control(
            'content_radius',
            [
                'label' => esc_html__( 'Border Radius', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-portfolio-all-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_padding',
            [
                'label' => esc_html__( 'Padding', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-portfolio-all-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_margin',
            [
                'label' => esc_html__( 'Margin', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-portfolio-all-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_alignment',
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
                ],
                'default' => 'center',
                'condition'             => [
                    'porftolio_style!' => '1'
                ],
            ]
        );

        $this->start_controls_tabs('content_tabs_all_tab');

            $this->start_controls_tab('content_tab_normal', ['label' => esc_html__('Normal', 'gyan-elements')]);

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'content_bg_color',
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
                    'selector' => '{{WRAPPER}} .gyan-portfolio-all-content',
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name'      => 'content_shadow',
                    'selector'  => '{{WRAPPER}} .gyan-portfolio-all-content',
                ]
            );

            $this->end_controls_tab();

            $this->start_controls_tab('content_tab_hover', ['label' => esc_html__('Hover', 'gyan-elements')]);

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'content_bg_color_hover',
                    'label' => esc_html__( 'Background', 'gyan-elements' ),
                    'types' => [ 'classic', 'gradient' ],
                    'fields_options' => [
                        'background' => [
                            'default' =>'classic',
                        ],
                    ],
                    'selector' => '{{WRAPPER}} .gyan-portfolio-item-inner:hover .gyan-portfolio-all-content',
                ]
            );

            $this->add_control(
                'content_border_hover',
                [
                    'label' => esc_html__( 'Border Color', 'gyan-elements' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .gyan-portfolio-item-inner:hover .gyan-portfolio-all-content' => 'border-color: {{VALUE}}'
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name'      => 'content_shadow_hover',
                    'selector'  => '{{WRAPPER}} .gyan-portfolio-item-inner:hover .gyan-portfolio-all-content',
                ]
            );


            $this->end_controls_tab();
        $this->end_controls_tabs();


        $this->end_controls_section();


        $this->start_controls_section(
            'title_styling',
            [
                'label' => esc_html__( 'Title', 'gyan-elements' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    'show_title' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Color', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .gyan-portfolio-item .gyan-portfolio-title .gyan-portfolio-title-tag,{{WRAPPER}} .gyan-portfolio-item .gyan-portfolio-title a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_hover_color',
            [
                'label' => esc_html__( 'Hover Color', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .gyan-portfolio-item .gyan-portfolio-title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'title_typography',
                'label'     => esc_html__( 'Title Typography', 'gyan-elements' ),
                'fields_options' => [
                    'typography' => [
                        'default' =>'custom',
                    ],
                    'font_size'   => [
                        'default' => [
                            'size' => '24',
                        ],
                    ]
                ],
                'selector'  => '{{WRAPPER}} .gyan-portfolio-title-tag',
            ]
        );

        $this->add_responsive_control(
            'title_max_width',
            [
                'label'     => esc_html__( 'Title Max Width', 'uael' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-portfolio-title' => 'max-width:{{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'title_shadow',
                'selector' => '{{WRAPPER}} .gyan-portfolio-title',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__( 'Margin', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-portfolio-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_html_tag',
            [
                'label'   => esc_html__( 'Title HTML Tag', 'gyan-elements' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'h4',
                'options' => gyan_title_tags(),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'category_styling',
            [
                'label' => esc_html__( 'Category', 'gyan-elements' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    'show_category' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'category_color',
            [
                'label' => esc_html__( 'Color', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .gyan-portfolio-category' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'category_typography',
                'fields_options' => [
                    'typography' => [
                        'default' =>'custom',
                    ],
                    'font_size'   => [
                        'default' => [
                            'size' => '15',
                        ],
                    ]
                ],
                'selector' => '{{WRAPPER}} .gyan-portfolio-category',
            ]
        );
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'category_shadow',
                'selector' => '{{WRAPPER}} .gyan-portfolio-category',
            ]
        );

        $this->add_responsive_control(
            'category_margin',
            [
                'label' => esc_html__( 'Margin', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-portfolio-category' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'excerpt_styling',
            [
                'label' => esc_html__( 'Excerpt', 'gyan-elements' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    'show_excerpt' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'excerpt_color',
            [
                'label' => esc_html__( 'Color', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .gyan-portfolio-excerpt' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'excerpt_typography',
                'selector' => '{{WRAPPER}} .gyan-portfolio-excerpt',
            ]
        );
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'excerpt_shadow',
                'selector' => '{{WRAPPER}} .gyan-portfolio-excerpt',
            ]
        );

        $this->add_responsive_control(
            'excerpt_margin',
            [
                'label' => esc_html__( 'Margin', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-portfolio-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

    }


    protected function get_filterable_tabs() {

        $data = $this->get_settings_for_display();

        if ( 'yes' === $data['show_filter_tabs'] ) {

            $exclude_cat = ($data['exclude_pf_cat']) ? implode(",",$data['exclude_pf_cat']) : '';

            $gyan_filter_portfolio_cats = array(
                'orderby' => 'name',
                'show_count' => 0,
                'pad_counts' => 0,
                'hierarchical' => false,
                'taxonomy' => 'portfolio_category',
                'title_li' => '',
                'style' => 'none',
                'echo' => 0,
                'order' => 'asc',
                'exclude' => $exclude_cat,
                'walker' => new Gyan_Walker_Category()
            );

            if ($data['all_tab_label']) {
                $gyan_view_all_portfolios = '<button class="gyan-portfolio-btn gyan-button is-checked" data-filter="*">'. esc_html($data['all_tab_label']) .'</button>';
            } else {
                $gyan_view_all_portfolios = '';
            }

            $gyan_sort_portfolio_cats = wp_list_categories($gyan_filter_portfolio_cats);
            $gyan_sort_portfolio_cats = str_replace('<br />', '', $gyan_sort_portfolio_cats);
            $gyan_sort_portfolio_cats = $gyan_view_all_portfolios . $gyan_sort_portfolio_cats;
            $gyan_sort_portfolio_cats = preg_replace('~>\\s+<~m', '><', $gyan_sort_portfolio_cats);

            $get_filterable_tabs =  '<div class="gyan-portfolio-btns">' . $gyan_sort_portfolio_cats . '</div>';

            return $get_filterable_tabs;

        }

    }

    protected function render() {

        $data = $this->get_settings_for_display();

        global $paged;

        //Fix homepage pagination
        if ( get_query_var('paged') ) {
            $paged = get_query_var('paged');
        } else if ( get_query_var('page') ) {
            $paged = get_query_var('page');
        } else {
            $paged = 1;
        }

        $exclude_cat = ($data['exclude_pf_cat']) ? implode(",",$data['exclude_pf_cat']) : '';

        $args = array(
            'post_type'         => 'portfolio',
            'orderby'           => $data['orderby'],
            'order'             => $data['order'],
            'posts_per_page'    => intval($data['posts_per_page']),
            'paged'             => $paged,
            'type'              => get_query_var('type'),
            'tax_query'         => array(
                array(
                    'taxonomy' => 'portfolio_category',
                    'field' => 'id',
                    'terms' => $data['exclude_pf_cat'],
                    'operator' => 'NOT IN',
                    )
            )
        );

        $wp_query = new WP_Query( $args );

        ob_start();
        Icons_Manager::render_icon( $data['icon_zoom'], [ 'aria-hidden' => 'true' ] );
        $zoom_icon = ob_get_clean();

        ob_start();
        Icons_Manager::render_icon( $data['icon_link'], [ 'aria-hidden' => 'true' ] );
        $link_icon = ob_get_clean();

        $data_rtl = is_rtl() ? 'true' : 'false';

        ?>
        <div class="gyan-portfolio <?php echo esc_attr( 'gyan-portfolio-'.$this->get_id() ); ?>"
        data-layout="<?php echo esc_attr( $data['layout'] ); ?>" data-rtl="<?php echo $data_rtl; ?>">

            <?php echo $this->get_filterable_tabs(); ?>

            <div class="gyan-portfolio-grid gyan-elementor-grid gyan-pf-style-<?php echo $data['porftolio_style']; ?> gyan-pf-overlay-<?php echo $data['overlay_animation']; ?> gyan-pf-content-<?php echo $data['content_alignment']; ?>" >
            <?php

                $settings = $this->get_settings();
                $click_action = $settings['click_action'];
                $index=0;

                while ($wp_query->have_posts()) : $wp_query->the_post();

                    $postid              = get_the_ID();
                    $get_the_excerpt     = get_the_excerpt();
                    $gyan_get_the_title  = get_the_title( $postid );
                    $gyan_attached_image = wp_get_attachment_url(get_post_thumbnail_id($postid));
                    $post_thumbnail_id   = get_post_thumbnail_id($postid);
                    $get_permalink       = get_permalink($postid);

                    $terms = get_the_terms( get_the_ID(), 'portfolio_category' );
                    $get_pf_cats = array();
                    if ( !empty( $terms ) ) {
                        foreach ($terms as $term) {
                            $get_pf_cats[] = 'cat-' . strtolower(preg_replace('/\s+/', '-', $term->term_id));
                        }
                    }
                    $get_pf_cats_list = implode(" ",$get_pf_cats);

                    if ( $post_thumbnail_id ):

                        if (  $settings['image_size'] == 'full' ) {
                            $imageTagHtml = wp_get_attachment_image( $post_thumbnail_id, 'full');
                        } else {
                            $imgUrl = Group_Control_Image_Size::get_attachment_image_src( $post_thumbnail_id, 'image', $settings );
                            if ( ! $imgUrl ) {
                                $imgUrl = $gyan_attached_image;
                            }
                            $imageTagHtml = '<img src="'.esc_url($imgUrl).'" alt="" />';
                        }

                        if ( '' !== $click_action ) {

                            $item_link    = '';
                            $lightbox     = 'no';

                            if ( 'lightbox' === $click_action ) {

                                if ( $post_thumbnail_id ) {
                                    $item_link = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
                                    $item_link = $gyan_attached_image;
                                } else {
                                    $item_link = $gyan_attached_image;
                                }

                                $lightbox = 'yes';

                            } elseif ( 'file' === $click_action ) {

                                if ( $post_thumbnail_id ) {
                                    $item_link = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
                                    $item_link = $item_link[0];
                                } else {
                                    $item_link = $gyan_attached_image;
                                }
                            } elseif ( 'attachment' === $click_action ) {

                                $item_link = get_permalink( $post_thumbnail_id );

                            }

                            $this->add_render_attribute(
                                'grid-media-' . $index,
                                [
                                    'class'                             => 'elementor-clickable gyan-portfolio-zoom-icon gyan-ease-transition gyan-flex',
                                    'data-elementor-open-lightbox'      => $lightbox,
                                    'data-elementor-lightbox-slideshow' => $this->get_id(),
                                    'data-elementor-lightbox-index'     => $index
                                ]
                            );

                            $this->add_render_attribute( 'grid-media-' . $index, 'href', $item_link );
                        }
                        ?>
                        <div class="gyan-portfolio-item gyan-grid-item-wrap <?php echo esc_attr( $get_pf_cats_list ); ?>">
                            <div class="gyan-portfolio-item-inner gyan-grid-item">
                                <?php include GYAN_ADDONS_DIR.'layouts/portfolio/portfolio-' . $data['porftolio_style'] . '.php'; ?>
                            </div>
                        </div>
                <?php endif;
                    $index++; ?>
            <?php
                endwhile;
            ?>
            </div><div class="clear"></div>
        </div>

         <?php if ( 'yes' === $data['show_pagination'] ) : ?>
             <div class="gyan-pagination-holder"><?php echo gyan_standard_pagination($wp_query); ?></div>
        <?php endif; ?>

        <?php
        wp_reset_postdata();

        if ( Plugin::instance()->editor->is_edit_mode() ) {
            $this->render_editor_script();
        }
    }

    protected function render_editor_script() {
        ?>
        <script type="text/javascript">
        jQuery( document ).ready(function( $ ) {
            var gyanPFClass = '.gyan-portfolio-'+'<?php echo $this->get_id(); ?>',
                $this = $(gyanPFClass),
                $isoGrid = $this.children('.gyan-portfolio-grid'),
                $btns = $this.children('.gyan-portfolio-btns'),
                is_rtl = $this.data('rtl') ? false : true,
                layout = $this.data('layout');

            $this.imagesLoaded( function() {
                if ( 'masonry' == layout ) {
                    var $grid = $isoGrid.isotope({
                        itemSelector: '.gyan-portfolio-item',
                        percentPosition: true,
                        originLeft: is_rtl,
                        masonry: {
                            columnWidth: '.gyan-portfolio-item',
                        }
                    });
                } else{
                    var $grid = $isoGrid.isotope({
                        itemSelector: '.gyan-portfolio-item',
                        layoutMode: 'fitRows',
                        originLeft: is_rtl,
                    });

                }

                $btns.on('click', 'button', function () {
                    var filterValue = $(this).attr('data-filter');
                    $grid.isotope({
                        filter: filterValue,
                        originLeft: is_rtl
                    });
                });

                $this.find('.gyan-portfolio-item').resize( function() {
                    $grid.isotope( 'layout' );
                });

                $btns.each(function (i, btns) {
                    var btns = $(btns);

                    btns.on('click', '.gyan-portfolio-btn', function () {
                        btns.find('.is-checked').removeClass('is-checked');
                        $(this).addClass('is-checked');
                    });
                });

            });

        });
        </script>
        <?php
    }

    protected function _content_template() {}

}