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
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) {exit; }

class Gyan_Post_Grid extends Widget_Base {

    public function get_name() { return 'gyan_post_grid'; }
    public function get_title() { return esc_html__( 'Posts Grid', 'gyan-elements' ); }
    public function get_icon() { return 'gyan-el-icon eicon-gallery-grid'; }
    public function get_categories() { return [ 'gyan-advanced-addons' ]; }
    public function get_keywords() { return [ 'gyan post grid', 'grid', 'post','blog','posts','posts grid','posts list' ]; }
    public function get_style_depends() { return [ 'gyan-pagination','gyan-icon','gyan-flex','gyan-grid','gyan-post-grid' ]; }
    public function get_script_depends() { return [ 'gyan-widgets','imagesLoaded', 'isotope','gyan-element-resize' ]; }

    protected function register_controls() {

        $this->start_controls_section(
            'post_grid_content',
            [
                'label' => esc_html__( 'Post Settings', 'gyan-elements' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'grid_style',
            [
                'label'   => esc_html__( 'Display Style', 'gyan-elements' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    '1' => esc_html__( 'Style 1', 'gyan-elements' ),
                    '2' => esc_html__( 'Style 2', 'gyan-elements' ),
                    '3' => esc_html__( 'Style 3', 'gyan-elements' ),
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
                    '4' => '4'
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

        $this->add_control(
            'show_filter_tabs',
            [
                'label'                 => esc_html__( 'Filterable Tabs', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'no',
                'separator'             => 'before',
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
            'title_length',
            [
                'label' => esc_html__( 'Title Text Length', 'gyan-elements' ),
                'label_block' => true,
                'type' => Controls_Manager::NUMBER,
                'separator'             => 'before',
                'default' => '100',
            ]
        );

        $this->add_control(
            'show_excerpt',
            [
                'label'                 => esc_html__( 'Excerpt', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_off' => esc_html__( 'No', 'gyan-elements' ),
                'label_on'  => esc_html__( 'Yes', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label' => esc_html__( 'Excerpt Text Length', 'gyan-elements' ),
                'label_block' => true,
                'type' => Controls_Manager::NUMBER,
                'default' => '107',
                'condition'             => [
                    'show_excerpt'      => 'yes'
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'post_metas_section',
            [
                'label' => esc_html__( 'Post Metas', 'gyan-elements' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_metas',
            [
                'label'                 => esc_html__( 'Meta Section', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_off' => esc_html__( 'No', 'gyan-elements' ),
                'label_on'  => esc_html__( 'Yes', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'show_date',
            [
                'label'                 => esc_html__( 'Date', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_off' => esc_html__( 'No', 'gyan-elements' ),
                'label_on'  => esc_html__( 'Yes', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'show_metas_date',
            [
                'label'                 => esc_html__( 'Metas Date', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_off' => esc_html__( 'No', 'gyan-elements' ),
                'label_on'  => esc_html__( 'Yes', 'gyan-elements' ),
                 'condition'             => [
                    'show_metas'      => 'yes',
                    'grid_style'      => '3'
                ],
            ]
        );

        $this->add_control(
            'show_author',
            [
                'label'                 => esc_html__( 'Author Name', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'no',
                'label_off' => esc_html__( 'No', 'gyan-elements' ),
                'label_on'  => esc_html__( 'Yes', 'gyan-elements' ),
                'condition'             => [
                    'show_metas'      => 'yes'
                ],
            ]
        );

        $this->add_control(
            'show_comment_count',
            [
                'label'                 => esc_html__( 'Comment Count', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_off' => esc_html__( 'No', 'gyan-elements' ),
                'label_on'  => esc_html__( 'Yes', 'gyan-elements' ),
                'condition'             => [
                    'show_metas'      => 'yes'
                ],
            ]
        );

        $this->add_control(
            'show_likes',
            [
                'label'                 => esc_html__( 'Likes', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_off' => esc_html__( 'No', 'gyan-elements' ),
                'label_on'  => esc_html__( 'Yes', 'gyan-elements' ),
                'condition'             => [
                    'show_metas'      => 'yes'
                ],
            ]
        );

        $this->add_control(
            'show_views',
            [
                'label'                 => esc_html__( 'Views', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_off' => esc_html__( 'No', 'gyan-elements' ),
                'label_on'  => esc_html__( 'Yes', 'gyan-elements' ),
                'condition'             => [
                    'show_metas'      => 'yes'
                ],
            ]
        );

        $this->add_control(
            'show_category',
            [
                'label'                 => esc_html__( 'Category', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'no',
                'label_off' => esc_html__( 'No', 'gyan-elements' ),
                'label_on'  => esc_html__( 'Yes', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'metas_words_heading',
            [
                'label'                 => esc_html__( 'Before / After Meta Items Words (Optional)', 'gyan-elements' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
                'condition'             => [
                    'grid_style'      => '3'
                ],
            ]
        );

        $this->add_control(
            'meta_date_word',
            [
                'label'     => esc_html__( 'Date', 'gyan-elements' ),
                'placeholder' => 'Posted On:',
                'type'      => Controls_Manager::TEXT,
                'condition'             => [
                    'grid_style'      => '3'
                ],
            ]
        );

        $this->add_control(
            'meta_author_word',
            [
                'label'     => esc_html__( 'Author', 'gyan-elements' ),
                'type'      => Controls_Manager::TEXT,
                'placeholder' => 'Posted By:',
                'condition'             => [
                    'grid_style'      => '3'
                ],
            ]
        );

        $this->add_control(
            'meta_comments_word',
            [
                'label'     => esc_html__( 'Comments', 'gyan-elements' ),
                'type'      => Controls_Manager::TEXT,
                'placeholder' => 'Comments',
                'condition'             => [
                    'grid_style'      => '3'
                ],
            ]
        );

        $this->add_control(
            'meta_likes_word',
            [
                'label'     => esc_html__( 'Likes', 'gyan-elements' ),
                'type'      => Controls_Manager::TEXT,
                'placeholder' => 'Likes',
                'condition'             => [
                    'grid_style'      => '3'
                ],
            ]
        );

        $this->add_control(
            'meta_views_word',
            [
                'label'     => esc_html__( 'Views', 'gyan-elements' ),
                'type'      => Controls_Manager::TEXT,
                'placeholder' => 'Views',
                'condition'             => [
                    'grid_style'      => '3'
                ],
            ]
        );

        $this->add_control(
            'meta_category_word',
            [
                'label'     => esc_html__( 'Category', 'gyan-elements' ),
                'type'      => Controls_Manager::TEXT,
                'placeholder' => 'Posted In',
                'condition'             => [
                    'grid_style'      => '3'
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'post_button_section',
            [
                'label' => esc_html__( 'Button', 'gyan-elements' ),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition'             => [
                    'grid_style'      => '3'
                ],
            ]
        );

        $this->add_control(
            'button_on',
            [
                'label'                 => esc_html__( 'Button', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'              => esc_html__( 'Yes', 'gyan-elements' ),
                'label_off'             => esc_html__( 'No', 'gyan-elements' ),
                'return_value'          => 'yes',
                'separator'             => 'before',
                'condition'             => [
                    'grid_style'      => '3'
                ],
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label'     => esc_html__( 'Button Text', 'gyan-elements' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => esc_html__( 'Read More', 'gyan-elements' ),
                'condition'             => [
                    'grid_style'      => '3'
                ],
            ]
        );

        $this->add_control(
            'button_icon',
            [
                'label' => esc_html__( 'Button Icon', 'elementor' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-angle-right',
                    'library' => 'fa-solid',
                ],
                'condition'             => [
                    'grid_style'      => '3'
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'post_grid_query_section',
            [
                'label' => esc_html__( 'Query', 'gyan-elements' ),
                'tab' => Controls_Manager::TAB_CONTENT,
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

        $this->add_control(
            'posts_per_page',
            [
                'label' => esc_html__( 'Posts Per Page', 'gyan-elements' ),
                'label_block' => true,
                'type' => Controls_Manager::NUMBER,
                'default' => '3'
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'     => esc_html__( 'Order by', 'gyan-elements' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'date',
                'options'   => [
                    'date'       => esc_html__( 'Date', 'gyan-elements' ),
                    'title'      => esc_html__( 'Title', 'gyan-elements' ),
                    'rand'       => esc_html__( 'Random', 'gyan-elements' ),
                    'menu_order' => esc_html__( 'Menu Order', 'gyan-elements' ),
                ]
            ]
        );

        $this->add_control(
            'order',
            [
                'label'     => esc_html__( 'Order', 'gyan-elements' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'DESC',
                'options'   => [
                    'DESC' => esc_html__( 'Descending', 'gyan-elements' ),
                    'ASC'  => esc_html__( 'Ascending', 'gyan-elements' ),
                ]
            ]
        );

        $this->add_control(
            'include_posts_cat',
            [
                'label' => esc_html__( 'Include Categories', 'plugin-domain' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => gyan_get_categories()
            ]
        );

        $this->add_control(
            'exclude_posts_cat',
            [
                'label' => esc_html__( 'Exclude Categories', 'plugin-domain' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => gyan_get_categories()
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
        Gyan_Common_Data::filter_button( $this, '.gyan-post-grid-btn' );
        $this->add_responsive_control(
            'filter_tabs_gap',
            [
                'label' => esc_html__( 'Gap From Items', 'gyan-elements' ),
                'type' => Controls_Manager::SLIDER,
                'default' =>[
                    'size' => '40',
                ],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .gyan-post-grid-btns' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .gyan-post-grid-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .gyan-post-grid-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .gyan-post-grid-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .gyan-post-grid-btns' => 'text-align: {{VALUE}};',
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
                'label'     => esc_html__( 'Columns Gap', 'gyan-elements' ),
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
                    '{{WRAPPER}} .gyan-post-grid-item.gyan-grid-item-wrap' => 'padding-right: calc( {{SIZE}}{{UNIT}}/2 ); padding-left: calc( {{SIZE}}{{UNIT}}/2 );',
                    '{{WRAPPER}} .gyan-post-grid.gyan-elementor-grid' => 'margin-left: calc( -{{SIZE}}{{UNIT}}/2 ); margin-right: calc( -{{SIZE}}{{UNIT}}/2 );',
                ],
            ]
        );

        $this->add_responsive_control(
            'row_gap',
            [
                'label'     => esc_html__( 'Rows Gap', 'gyan-elements' ),
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
                    '{{WRAPPER}} .gyan-elementor-grid .gyan-post-grid-item-inner.gyan-grid-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .gyan-post-grid-item-holder' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'items_padding',
            [
                'label' => esc_html__( 'Padding', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-post-grid-item-holder' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                            'blur' => '46',
                            'color' => 'rgba(0,0,0,0.1)'
                        ]
                    ]
                ],
                'selector' => '{{WRAPPER}} .gyan-post-grid-item-holder',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'post_item_box_shadow_hover',
                'label' => esc_html__( 'Hover Box Shadow', 'gyan-elements' ),
                'selector' => '{{WRAPPER}} .gyan-post-grid-item:hover .gyan-post-grid-item-holder',
            ]
        );

        $this->add_control(
            'item_overflow',
            [
                'label'   => esc_html__( 'Overflow Property', 'gyan-elements' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'hidden',
                'options' => [
                    'hidden' => esc_html__( 'Hidden', 'gyan-elements' ),
                    'visible' => esc_html__( 'Visible', 'gyan-elements' )
                ],
                'description'   => esc_html__( 'Fix "All Content" Section Box Shadow display issue and Image Border Radius hover zoom flickring issue with overflow setting visible.', 'gyan-elements' ),
                'selectors' => [
                    '{{WRAPPER}} .gyan-post-grid-item-holder' => 'overflow:{{VALUE}};',
                ],
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

        $this->add_control(
            'show_image',
            [
                'label'                 => esc_html__( 'Post Image', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_off' => esc_html__( 'No', 'gyan-elements' ),
                'label_on'  => esc_html__( 'Yes', 'gyan-elements' ),
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

        $this->add_responsive_control(
            'image_radius',
            [
                'label' => esc_html__( 'Border Radius', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-post-grid-format,{{WRAPPER}} .gyan-post-grid-format img,{{WRAPPER}} a.gyan-post-grid-image:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'img_hover_heading',
            [
                'label'     => esc_html__( 'Image Hover', 'gyan-elements' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'image_hover_effect',
            [
                'label'     => esc_html__( 'Hover Effect', 'gyan-elements' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'none',
                'options'   => [
                    'none' => esc_html__( 'None', 'gyan-elements' ),
                    'zoom' => esc_html__( 'Zoom', 'gyan-elements' ),
                    'zoom-rotate' => esc_html__( 'Zoom Rotate', 'gyan-elements' )
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'image_hover_bg',
                'label' => esc_html__( 'Hover Background', 'gyan-elements' ),
                'types' => [ 'classic','gradient' ],
                'selector' => '{{WRAPPER}} a.gyan-post-grid-image:before',
                'condition'             => [
                    'grid_style'      => '3'
                ],
            ]
        );

        $this->add_control(
            'imgage_z_index',
            [
                'label' => esc_html__( 'Z-Index', 'elementor' ),
                'type' => Controls_Manager::NUMBER,
                'min' => -1,
                'selectors' => [
                    '{{WRAPPER}} .gyan-post-image' => 'z-index: {{VALUE}};',
                ],
                'label_block' => false,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'metas_style',
            [
                'label' => esc_html__( 'Metas', 'gyan-elements' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    'grid_style'      => '3'
                ],
            ]
        );

        $this->add_control(
            'metas_location',
            [
                'label'     => esc_html__( 'Display Location', 'gyan-elements' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'above_content',
                'description'   => esc_html__( 'Please use "Margin (Metas Section)" to adjust space between metas and other sections. For "Above Content" and  "Below Content" display location set "Content" section "Padding". ', 'gyan-elements' ),
                'options'   => [
                    'above_content' => esc_html__( 'Above Content', 'gyan-elements' ),
                    'below_title'   => esc_html__( 'Below Title', 'gyan-elements' ),
                    'below_content' => esc_html__( 'Below Content', 'gyan-elements' )
                ]
            ]
        );

        $this->add_responsive_control(
            'metas_margin',
            [
                'label' => esc_html__( 'Margin ( Metas Section )', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => '41',
                    'right' => '45',
                    'bottom' => '0',
                    'left' => '45',
                    'isLinked' => false,
                ],
                'separator' => 'after',
                'selectors' => [
                    '{{WRAPPER}} .gyan-post-grid-metas' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'metas_item_separator_type',
            [
                'label'     => esc_html__( 'Icon / Separator', 'gyan-elements' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'icon',
                'options'   => [
                    'none'       => esc_html__( 'None', 'gyan-elements' ),
                    'icon'       => esc_html__( 'Icon Style', 'gyan-elements' ),
                    'slash'       => esc_html__( '" / " Separator', 'gyan-elements' ),
                    'vline'       => esc_html__( '" | " Separator', 'gyan-elements' ),
                    'dash'       => esc_html__( '" - " Separator', 'gyan-elements' ),
                ]
            ]
        );

        $this->add_control(
            'metas_icon_color',
            [
                'label' => esc_html__( 'Icon/Separator Color', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#d83030',
                'separator' => 'after',
                'selectors' => [
                    '{{WRAPPER}} .gyan-grid-metas-item i,{{WRAPPER}} .gyan-post-grid-meta-separator:before' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'metas_typography',
                'fields_options' => [
                    'typography' => [
                        'default' =>'custom',
                    ],
                ],
                'selector' => '{{WRAPPER}} .gyan-grid-metas-item',
            ]
        );

        $this->add_control(
            'metas_text_color',
            [
                'label' => esc_html__( 'Text Color', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#676767',
                'selectors' => [
                    '{{WRAPPER}} .gyan-grid-metas-item' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'metas_link_text_color',
            [
                'label' => esc_html__( 'Link Text Color', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#676767',
                'selectors' => [
                    '{{WRAPPER}} .gyan-grid-metas-item a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'metas_link_text_weight',
            [
                'label'     => esc_html__( 'Link Text - Font Weight', 'gyan-elements' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => '400',
                'options'   => [
                    '300'       => esc_html__( '300', 'gyan-elements' ),
                    '400'       => esc_html__( '400', 'gyan-elements' ),
                    '500'       => esc_html__( '500', 'gyan-elements' ),
                    '600'       => esc_html__( '600', 'gyan-elements' ),
                    '700'       => esc_html__( '700', 'gyan-elements' ),
                    '800'       => esc_html__( '800', 'gyan-elements' ),
                    '900'       => esc_html__( '900', 'gyan-elements' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-grid-metas-item a' => 'font-weight:{{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'metas_alignment',
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
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .gyan-post-grid-metas' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'selector' => '{{WRAPPER}} .gyan-post-grid-metas',
            ]
        );

        $this->add_responsive_control(
            'metas_radius',
            [
                'label' => esc_html__( 'Border Radius', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-post-grid-metas' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'metas_padding',
            [
                'label' => esc_html__( 'Padding', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-post-grid-metas' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'metas_bg',
                'label' => esc_html__( 'Background', 'gyan-elements' ),
                'types' => [ 'classic','gradient' ],
                'selector' => '{{WRAPPER}} .gyan-post-grid-metas',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'metas_box_shadow',
                'label' => esc_html__( 'Box Shadow', 'gyan-elements' ),
                'selector' => '{{WRAPPER}} .gyan-post-grid-metas',
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'content_styling',
            [
                'label' => esc_html__( 'Content', 'gyan-elements' ),
                'tab' => Controls_Manager::TAB_STYLE,
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
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .gyan-post-grid-content' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__( 'Padding', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-post-grid-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'all_content_heading',
            [
                'label'     => esc_html__( 'All Content', 'gyan-elements' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'all_content_margin',
            [
                'label' => esc_html__( 'All Content Margin', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-post-content-block' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'all_content_border',
                'selector' => '{{WRAPPER}} .gyan-post-content-block',
            ]
        );

        $this->add_responsive_control(
            'all_content_radius',
            [
                'label' => esc_html__( 'All Content Border Radius', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-post-content-block' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'post_item_bg',
            [
                'label' => esc_html__( 'Background Under All Content', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gyan-post-grid-item-holder' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'all_content_z_index',
            [
                'label' => esc_html__( 'Z-Index', 'elementor' ),
                'type' => Controls_Manager::NUMBER,
                'min' => -1,
                'selectors' => [
                    '{{WRAPPER}} .gyan-post-content-block' => 'z-index: {{VALUE}};',
                ],
            ]
        );

        $this->start_controls_tabs('all_content_tabs');

            $this->start_controls_tab('all_content_tab_normal', ['label' => esc_html__('Normal', 'gyan-elements')]);

                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name' => 'content_bg',
                        'label' => esc_html__( 'All Content Background', 'gyan-elements' ),
                        'types' => [ 'classic','gradient' ],
                        'fields_options' => [
                            'background' => [
                                'default' =>'classic',
                            ],
                            'color' => [
                                'default' => '#ffffff',
                            ],
                        ],
                        'selector' => '{{WRAPPER}} .gyan-post-content-block',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'all_content_box_shadow',
                        'label' => esc_html__( 'All Content Box Shadow', 'gyan-elements' ),
                        'selector' => '{{WRAPPER}} .gyan-post-content-block',
                    ]
                );

            $this->end_controls_tab();

            $this->start_controls_tab('all_content_tab_hover', ['label' => esc_html__('Hover', 'gyan-elements')]);

                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name' => 'content_bg_hover',
                        'label' => esc_html__( 'All Content Background', 'gyan-elements' ),
                        'types' => [ 'classic','gradient' ],
                        'selector' => '{{WRAPPER}} .gyan-post-grid-item:hover .gyan-post-content-block',
                    ]
                );

                $this->add_control(
                    'all_content_border_hover',
                    [
                        'label' => esc_html__( 'Border Color', 'gyan-elements' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .gyan-post-grid-item:hover .gyan-post-content-block' => 'border-color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'all_content_box_shadow_hover',
                        'label' => esc_html__( 'All Content Box Shadow', 'gyan-elements' ),
                        'selector' => '{{WRAPPER}} .gyan-post-grid-item:hover .gyan-post-content-block',
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
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Color', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#032e42',
                'selectors' => [
                    '{{WRAPPER}} .gyan-post-title h2,{{WRAPPER}} .gyan-post-title h2 a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_hover_color',
            [
                'label' => esc_html__( 'Hover Color', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#d83030',
                'selectors' => [
                    '{{WRAPPER}} .gyan-post-title h2 a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'fields_options' => [
                    'typography' => [
                        'default' =>'custom',
                    ],
                    'font_size'   => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '22',
                        ],
                    ],
                    'line_height'   => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '30',
                        ],
                    ],
                ],
                'selector' => '{{WRAPPER}} .gyan-post-title h2',
            ]
        );
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'title_shadow',
                'selector' => '{{WRAPPER}} .gyan-post-title h2',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__( 'Margin', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '13',
                    'left' => '0',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-post-title h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'default' => '#676767',
                'selectors' => [
                    '{{WRAPPER}} .gyan-post-list-excerpt' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'excerpt_typography',
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
                            'size' => '25',
                        ],
                    ],
                ],
                'selector' => '{{WRAPPER}} .gyan-post-list-excerpt',
            ]
        );
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'excerpt_shadow',
                'selector' => '{{WRAPPER}} .gyan-post-list-excerpt',
            ]
        );

        $this->add_responsive_control(
            'excerpt_margin',
            [
                'label' => esc_html__( 'Margin', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-post-list-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'date_styling',
            [
                'label' => esc_html__( 'Date', 'gyan-elements' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    'show_date' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'date_format',
            [
                'label'   => esc_html__( 'Date Format', 'gyan-elements' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__( 'Default', 'gyan-elements' ),
                    'custom' => esc_html__( 'Custom', 'gyan-elements' )
                ]
            ]
        );

        $this->add_control(
            'custom_date_format',
            [
                'label'   => esc_html__( 'Custom Date', 'gyan-elements' ),
                'type'    => Controls_Manager::TEXT,
                'default' => 'F j, Y',
                'description' => __( '<a target="_blank" href="https://wordpress.org/support/article/formatting-date-and-time/#format-string-examples">Click Here</a> for date format reference.', 'gyan-elements' ),
                'condition'             => [
                    'date_format'      => 'custom'
                ],
            ]
        );

        $this->add_control(
            'date_color',
            [
                'label' => esc_html__( 'Color', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#000538',
                'selectors' => [
                    '{{WRAPPER}} .gyan-post-grid-date' => 'color: {{VALUE}};',
                ],
                'condition'             => [
                    'grid_style'      => array('1','2')
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'date_typography',
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
                ],
                'condition'             => [
                    'grid_style'      => array('1','2')
                ],
                'selector' => '{{WRAPPER}} .gyan-post-grid-date',
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'p_cat_styling',
            [
                'label' => esc_html__( 'Category', 'gyan-elements' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    'show_category' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'category_location',
            [
                'label'   => esc_html__( 'Display Location', 'gyan-elements' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'below_title',
                'options' => [
                    'below_title' => esc_html__( 'Below Title', 'gyan-elements' ),
                    'above_title' => esc_html__( 'Above Title', 'gyan-elements' ),
                    'before_metas_section' => esc_html__( 'Before Metas Section', 'gyan-elements' ),
                    'before_metas' => esc_html__( 'Before Metas Items', 'gyan-elements' ),
                    'after_metas' => esc_html__( 'After Meta Items', 'gyan-elements' ),
                    'inside_post_img' => esc_html__( 'Inside Post Image', 'gyan-elements' )
                ],
                'description' => esc_html__( 'For "Inside Post Image" display location select "Button Style" from below dropdown.', 'gyan-elements' ),
                'condition'             => [
                    'grid_style!' => array('1','2'),
                ],
            ]
        );

        $this->add_control(
            'cat_origin',
            [
                'label'   => esc_html__( 'Origin', 'gyan-elements' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'top-left',
                'options' => gyan_position(),
                 'condition'             => [
                    'grid_style!' => array('1','2'),
                    'category_location' => 'inside_post_img'
                ],
            ]
        );

        $this->add_control(
            'category_style',
            [
                'label'   => esc_html__( 'Category Style', 'gyan-elements' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__( 'Default Style', 'gyan-elements' ),
                    'button' => esc_html__( 'Button Style', 'gyan-elements' ),
                ],
                'condition'             => [
                    'grid_style!' => array('1','2'),
                    'category_location!' => array('before_metas','after_metas')
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'p_cat_typography',
                'selector' => '{{WRAPPER}} .gyan-post-grid-category',
            ]
        );
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'p_cat_shadow',
                'selector' => '{{WRAPPER}} .gyan-post-grid-category',
            ]
        );

        $this->add_responsive_control(
            'category_padding',
            [
                'label' => esc_html__( 'Padding', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'condition'             => [
                    'category_style' => 'button'
                ],
                'default' => [
                    'top' => '0',
                    'right' => '7',
                    'bottom' => '0',
                    'left' => '7',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-post-grid-category-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'p_cat_list_margin',
            [
                'label' => esc_html__( 'Margin ( Category List Items )', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'condition'             => [
                    'category_style' => 'button'
                ],
                'default' => [
                    'top' => '0',
                    'right' => '7',
                    'bottom' => '7',
                    'left' => '0',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-post-grid-category-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'p_cat_margin',
            [
                'label' => esc_html__( 'Margin ( Category Section )', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'condition'             => [
                    'category_location!' => array('before_metas_section','before_metas','after_metas')
                ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-post-grid-category' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );



        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'category_border',
                'condition'             => [
                    'category_style' => 'button'
                ],
                'selector' => '{{WRAPPER}} .gyan-post-grid-category-item',
            ]
        );

        $this->add_responsive_control(
            'category_radius',
            [
                'label' => esc_html__( 'Border Radius', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'condition'             => [
                            'category_style' => 'button'
                        ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-post-grid-category-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('cat_tabs_all_tab');

            $this->start_controls_tab('cat_tab_normal', ['label' => esc_html__('Normal', 'gyan-elements')]);

                $this->add_control(
                    'p_cat_color',
                    [
                        'label' => esc_html__( 'Text Color', 'gyan-elements' ),
                        'type' => Controls_Manager::COLOR,
                        'default' => '#888888',
                        'selectors' => [
                            '{{WRAPPER}} .gyan-post-grid-category-item a,{{WRAPPER}} .gyan-post-grid-category-item' => 'color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_control(
                    'cat_bg',
                    [
                        'label' => esc_html__( 'Background Color', 'gyan-elements' ),
                        'type' => Controls_Manager::COLOR,
                        'condition'             => [
                            'category_style' => 'button'
                        ],
                        'default' => '#f2f2f2',
                        'selectors' => [
                            '{{WRAPPER}} .gyan-post-grid-category-item' => 'background-color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_control(
                    'cat2_bg',
                    [
                        'label' => esc_html__( 'Category 2 Background Color', 'gyan-elements' ),
                        'type' => Controls_Manager::COLOR,
                        'condition'             => [
                            'category_style' => 'button'
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .gyan-post-grid-category-item:nth-child(2)' => 'background-color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_control(
                    'cat3_bg',
                    [
                        'label' => esc_html__( 'Category 3 Background Color', 'gyan-elements' ),
                        'type' => Controls_Manager::COLOR,
                        'condition'             => [
                            'category_style' => 'button'
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .gyan-post-grid-category-item:nth-child(3)' => 'background-color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_control(
                    'cat4_bg',
                    [
                        'label' => esc_html__( 'Category 4 Background Color', 'gyan-elements' ),
                        'type' => Controls_Manager::COLOR,
                        'condition'             => [
                            'category_style' => 'button'
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .gyan-post-grid-category-item:nth-child(4)' => 'background-color: {{VALUE}};',
                        ],
                    ]
                );

            $this->end_controls_tab();

            $this->start_controls_tab('cat_tab_hover', ['label' => esc_html__('Hover', 'gyan-elements')]);

                $this->add_control(
                    'p_cat_color_hover',
                    [
                        'label' => esc_html__( 'Text Color', 'gyan-elements' ),
                        'type' => Controls_Manager::COLOR,
                        'default' => '#d83030',
                        'selectors' => [
                            '{{WRAPPER}} .gyan-post-grid-category-item:hover a' => 'color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_control(
                    'cat_bg_hover',
                    [
                        'label' => esc_html__( 'Background Color', 'gyan-elements' ),
                        'type' => Controls_Manager::COLOR,
                        'condition'             => [
                            'category_style' => 'button'
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .gyan-post-grid-category-item:hover' => 'background-color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_control(
                    'cat_border_col_hover',
                    [
                        'label' => esc_html__( 'Border Color', 'gyan-elements' ),
                        'type' => Controls_Manager::COLOR,
                        'condition'             => [
                            'category_style' => 'button'
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .gyan-post-grid-category-item:hover' => 'border-color: {{VALUE}};',
                        ],
                    ]
                );

            $this->end_controls_tab();
        $this->end_controls_tabs();


        $this->end_controls_section();

        $this->start_controls_section(
            'button_style',
            [
                'label' => esc_html__( 'Button', 'gyan-elements' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    'button_on'      => 'yes',
                    'grid_style!' => array('1','2'),
                ],
            ]
        );

        $this->add_control(
            'button_icon_position',
            [
                'label'     => esc_html__( 'Icon Position', 'gyan-elements' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'after',
                'options'   => [
                    'after'  => esc_html__( 'After', 'gyan-elements' ),
                    'before' => esc_html__( 'Before', 'gyan-elements' ),
                ],
                'condition' => [
                    'button_icon!' => '',
                ],
            ]
        );

        $this->add_control(
            'button_type',
            [
                'label'     => esc_html__( 'Button Type', 'gyan-elements' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'button',
                'options'   => [
                    'text'  => esc_html__( 'Only Text', 'gyan-elements' ),
                    'button' => esc_html__( 'Text with Button Shape', 'gyan-elements' ),
                    'icon_box' => esc_html__( 'Icon Box', 'gyan-elements' ),
                ],
                'condition' => [
                    'button_icon!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'post_button_alignment',
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
                        'title' => esc_html__( 'Justified', 'gyan-elements' ),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'default' => 'left',
                'prefix_class' => 'gyan-post-grid-button-',
                'selectors' => [
                    '{{WRAPPER}} .gyan-post-grid-button-wrap' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'button_typography',
                'label'     => esc_html__( 'Typography', 'gyan-elements' ),
                'selector'  => '{{WRAPPER}} .gyan-post-grid-button',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'button_border_normal',
                'label'       => esc_html__( 'Border', 'gyan-elements' ),
                'placeholder' => '1px',
                'default'     => '1px',
                'condition' => [
                    'button_type' => array('button','icon_box')
                ],
                'selector'    => '{{WRAPPER}} .gyan-post-grid-button',
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'gyan-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'condition' => [
                    'button_type' => array('button','icon_box')
                ],
                'selectors'  => [
                    '{{WRAPPER}} .gyan-post-grid-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label'      => esc_html__( 'Padding', 'gyan-elements' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'condition' => [
                    'button_type' => array('button','icon_box')
                ],
                'default' => [
                    'top' => '5',
                    'right' => '15',
                    'bottom' => '5',
                    'left' => '15',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .gyan-post-grid-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_margin',
            [
                'label'       => esc_html__( 'Margin', 'gyan-elements' ),
                'type'        => Controls_Manager::DIMENSIONS,
                'size_units'  => [ 'px', '%' ],
                'placeholder' => [
                    'top'    => '',
                    'right'  => '',
                    'bottom' => '',
                    'left'   => '',
                ],
                'selectors'   => [
                    '{{WRAPPER}} .gyan-post-grid-button-wrap' => 'margin-top: {{TOP}}{{UNIT}}; margin-left: {{LEFT}}{{UNIT}}; margin-right: {{RIGHT}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_button_style' );

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label'     => esc_html__( 'Normal', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'button_text_color_normal',
            [
                'label'     => esc_html__( 'Text Color', 'gyan-elements' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#eeeeee',
                'selectors' => [
                    '{{WRAPPER}} a.gyan-post-grid-button' => 'color: {{VALUE}}',
                    '{{WRAPPER}} a.gyan-post-grid-button svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'button_bg_color_normal',
                'label' => esc_html__( 'Button Background', 'gyan-elements' ),
                'types' => [ 'classic', 'gradient' ],
                'fields_options' => [
                    'background' => [
                        'default' =>'classic',
                    ],
                    'color' => [
                        'default' => '#d83030',
                    ],
                ],
                'condition' => [
                    'button_type' => array('button','icon_box')
                ],
                'selector' => '{{WRAPPER}} .gyan-post-grid-button',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'button_box_shadow',
                'condition' => [
                    'button_type' => array('button','icon_box')
                ],
                'selector'  => '{{WRAPPER}} .gyan-post-grid-button',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label'     => esc_html__( 'Hover', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'button_text_color_hover',
            [
                'label'     => esc_html__( 'Text Color', 'gyan-elements' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} a.gyan-post-grid-button:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} a.gyan-post-grid-button:hover svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'button_bg_color_hover',
                'label' => esc_html__( 'Button Background', 'gyan-elements' ),
                'types' => [ 'classic', 'gradient' ],
                'fields_options' => [
                    'background' => [
                        'default' =>'classic',
                    ],
                    'color' => [
                        'default' => '#191a1c',
                    ],
                ],
                'condition' => [
                    'button_type' => array('button','icon_box')
                ],
                'selector' => '{{WRAPPER}} .gyan-post-grid-button:hover',
            ]
        );

        $this->add_control(
            'button_border_color_hover',
            [
                'label'     => esc_html__( 'Border Color', 'gyan-elements' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'condition' => [
                    'button_type' => array('button','icon_box')
                ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-post-grid-button:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'button_box_shadow_hover',
                'condition' => [
                    'button_type' => array('button','icon_box')
                ],
                'selector'  => '{{WRAPPER}} .gyan-post-grid-button:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'icon_settings_heading',
            [
                'label'     => esc_html__( 'Icon', 'gyan-elements' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'button_icon_size',
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
                'condition' => [
                    'button_type' => 'icon_box',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .gyan-post-grid-button-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_iconbox_size',
            [
                'label'      => esc_html__( 'Icon Box Size', 'gyan-elements' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min'  => 5,
                        'max'  => 200,
                        'step' => 1,
                    ],
                ],
                'size_units' => [ 'px', 'em' ],
                'condition' => [
                    'button_type' => 'icon_box',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .gyan-post-grid-button' => 'height:{{SIZE}}{{UNIT}}; width:{{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_icon_margin',
            [
                'label'       => esc_html__( 'Icon Margin', 'gyan-elements' ),
                'type'        => Controls_Manager::DIMENSIONS,
                'size_units'  => [ 'px', '%' ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '7',
                    'isLinked' => false,
                ],
                'condition' => [
                    'button_type!' => 'icon_box',
                ],
                'selectors'   => [
                    '{{WRAPPER}} .gyan-post-grid-button i,{{WRAPPER}} .gyan-post-grid-button svg' => 'margin-top: {{TOP}}{{UNIT}}; margin-left: {{LEFT}}{{UNIT}}; margin-right: {{RIGHT}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'skin_style',
            [
                'label' => esc_html__( 'Skin', 'gyan-elements' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    'grid_style' => array('1','2'),
                ],
            ]
        );

        $this->add_control(
            'skin_1_color',
            [
                'label'                 => esc_html__( 'Skin 1 - Text Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#ffffff',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-post-grid-c-button span:before,{{WRAPPER}} .gyan-post-grid-c-button span:after' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'skin_1_bg',
            [
                'label'                 => esc_html__( 'Skin 1 - Background', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#d83030',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-post-grid-c-button' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'skin_2_color',
            [
                'label'                 => esc_html__( 'Skin 2 - Text Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#ffffff',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-post-grid-c-button:hover span:before,{{WRAPPER}} .gyan-post-grid-c-button:hover span:after' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'skin_2_bg',
            [
                'label'                 => esc_html__( 'Skin 2 - Background', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#f3a712',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-post-grid-c-button:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

    }


    protected function get_filterable_tabs() {

        $data = $this->get_settings_for_display();

        if ( 'yes' === $data['show_filter_tabs'] ) {

            $exclude_cat = ($data['exclude_posts_cat']) ? implode(",",$data['exclude_posts_cat']) : '';
            $include_cat = ($data['include_posts_cat']) ? implode(",",$data['include_posts_cat']) : '';

            $gyan_filter_post_grid_cats = array(
                'orderby' => 'name',
                'show_count' => 0,
                'pad_counts' => 0,
                'hierarchical' => false,
                'title_li' => '',
                'style' => 'none',
                'echo' => 0,
                'order' => 'asc',
                'exclude' => $exclude_cat,
                'include'  => $include_cat,
                'walker' => new Gyan_Posts_Walker_Category()
            );

            if ($data['all_tab_label']) {
                $gyan_view_all_post_grids = '<button class="gyan-post-grid-btn gyan-button is-checked" data-filter="*">'. esc_html($data['all_tab_label']) .'</button>';
            } else {
                $gyan_view_all_post_grids = '';
            }

            $gyan_sort_post_grid_cats = wp_list_categories($gyan_filter_post_grid_cats);
            $gyan_sort_post_grid_cats = str_replace('<br />', '', $gyan_sort_post_grid_cats);
            $gyan_sort_post_grid_cats = $gyan_view_all_post_grids . $gyan_sort_post_grid_cats;
            $gyan_sort_post_grid_cats = preg_replace('~>\\s+<~m', '><', $gyan_sort_post_grid_cats);

            $get_filterable_tabs =  '<div class="gyan-post-grid-btns">' . $gyan_sort_post_grid_cats . '</div>';

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

        $args = array(
            'post_type'        => 'post',
            'posts_per_page'   => intval($data['posts_per_page']),
            'paged'            => $paged,
            'type'             => get_query_var('type'),
            'category__not_in' => $data['exclude_posts_cat'],
            'cat'              => $data['include_posts_cat'],
            'order'            => $data['order'],
            'orderby'          => $data['orderby']
        );

        $wp_query = new WP_Query( $args );

        $data_rtl = is_rtl() ? 'true' : 'false';

        ?>
        <div class="gyan-post-grid-container gyan-post-grid-s<?php echo $data['grid_style']; ?> <?php echo esc_attr( 'gyan-post-grid-container-'.$this->get_id() ); ?>" data-layout="<?php echo esc_attr( $data['layout'] ); ?>" data-rtl="<?php echo $data_rtl; ?>">

            <?php echo $this->get_filterable_tabs(); ?>

            <div class="gyan-post-grid gyan-elementor-grid">
                <?php
                $settings = $this->get_settings();

                $gyan_post_date_on       = $data['show_date'];
                $gyan_post_metas_date_on = $data['show_metas_date'];
                $gyan_post_author_name   = $data['show_author'];
                $gyan_post_cats          = $data['show_category'];
                $gyan_post_comments      = $data['show_comment_count'];
                $gyan_post_views         = $data['show_views'];
                $gyan_post_likes         = $data['show_likes'];
                $gyan_show_metas         = $data['show_metas'];
                $metas_location          = $data['metas_location'];
                $category_location       = $data['category_location'];
                $metas_item_separator_type = $data['metas_item_separator_type'];
                $gyan_post_image_on       = $data['show_image'];

                $metas_item_separator_html = ( $metas_item_separator_type == 'dash' || $metas_item_separator_type == 'slash' || $metas_item_separator_type == 'vline' ) ? '<span class="gyan-post-grid-meta-separator"></span>' :  '';

                $meta_author_word   = ( '' != $data['meta_author_word'] ) ? $data['meta_author_word'] . ' ' :  '';
                $meta_date_word     = ( '' != $data['meta_date_word'] ) ? $data['meta_date_word'] . ' ' :  '';
                $meta_likes_word    = ( '' != $data['meta_likes_word'] ) ? ' ' . $data['meta_likes_word'] :  '';
                $meta_views_word    = ( '' != $data['meta_views_word'] ) ? ' ' . $data['meta_views_word'] :  '';
                $meta_comments_word = ( '' != $data['meta_comments_word'] ) ? ' ' . $data['meta_comments_word'] :  '';
                $meta_category_word = ( '' != $data['meta_category_word'] ) ? $data['meta_category_word'] . ' ' :  '';

                //post date format
                $post_date = ( $gyan_post_date_on == 'yes' && $data['date_format'] == 'custom' ) ? $data['custom_date_format'] : '';

                // post button
                ob_start();
                Icons_Manager::render_icon( $data['button_icon'], [ 'aria-hidden' => 'true' ] );
                $button_icon = ob_get_clean();
                $button_icon = '<span class="gyan-post-grid-button-icon gyan-icon">' . $button_icon . '</span>';

                $button_text = '<span>' . $data['button_text'] . '</span>';
                $button_text = ('icon_box' != $data['button_type']) ? '<span>' . $data['button_text'] . '</span>' : '';

                $post_button_html = ('before' == $data['button_icon_position']) ? $button_icon . $button_text : $button_text . $button_icon;

                while ($wp_query->have_posts()) : $wp_query->the_post();

                    $postid              = get_the_ID();
                    $get_the_excerpt     = get_the_excerpt();
                    $gyan_get_the_title  = get_the_title( $postid );
                    $gyan_attached_image = wp_get_attachment_url(get_post_thumbnail_id($postid));
                    $post_thumbnail_id   = get_post_thumbnail_id($postid);
                    $get_permalink       = get_permalink($postid);

                    $terms = get_the_category();
                    $get_recent_post_cats = array();
                    if ( !empty( $terms ) ) :
                        foreach ($terms as $term) {
                            $get_recent_post_cats[] = 'cat-' . strtolower(preg_replace('/\s+/', '-', $term->term_id));
                        }
                    endif;
                    $get_pf_cats_list = implode(" ",$get_recent_post_cats);

                        // responsive image
                        if (  $data['image_size'] == 'full' ) {
                            $post_image = wp_get_attachment_image( $post_thumbnail_id, 'full', "", ["class" => "gyan-ease-transition"]);
                        } else {
                            $imgUrl = Group_Control_Image_Size::get_attachment_image_src( $post_thumbnail_id, 'image', $data );
                            if ( ! $imgUrl ) {
                                $imgUrl = $gyan_attached_image;
                            }
                            $post_image = '<img class="gyan-ease-transition" src="'.esc_url($imgUrl).'" alt="" />';
                        }

                        $imgBgUrl = Group_Control_Image_Size::get_attachment_image_src( $post_thumbnail_id, 'image', $data );

                        $overlay_button_html = '';

                        if ( 'yes' == $data['button_on'] ) {

                            $overlay_button_html = '<div class="gyan-post-grid-button-wrap"><div class="gyan-post-grid-button-holder"><a href="' . esc_url( $get_permalink ) . '" class="gyan-post-grid-button gyan-ease-transition gyan-flex">' . $post_button_html . '</a></div></div>';
                        }

                        include GYAN_ADDONS_DIR.'layouts/post-grid/post-' . $data['grid_style'] . '.php';

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
            var gyanPGClass = '.gyan-post-grid-container-'+'<?php echo $this->get_id(); ?>',
                $this = $(gyanPGClass),
                $isoGrid = $this.children('.gyan-post-grid'),
                $btns = $this.children('.gyan-post-grid-btns'),
                is_rtl = $this.data('rtl') ? false : true,
                layout = $this.data('layout');

            $this.imagesLoaded( function() {
                if ( 'masonry' == layout ) {
                    var $grid = $isoGrid.isotope({
                        itemSelector: '.gyan-post-grid-item',
                        percentPosition: true,
                        originLeft: is_rtl,
                        masonry: {
                            columnWidth: '.gyan-post-grid-item',
                        }
                    });
                } else{
                    var $grid = $isoGrid.isotope({
                        itemSelector: '.gyan-post-grid-item',
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

                $this.find('.gyan-post-grid-item').resize( function() {
                    $grid.isotope( 'layout' );
                });

                $btns.each(function (i, btns) {
                    var btns = $(btns);

                    btns.on('click', '.gyan-post-grid-btn', function () {
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