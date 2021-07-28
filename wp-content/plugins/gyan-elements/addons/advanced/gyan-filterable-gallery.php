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

if ( ! defined( 'ABSPATH' ) ) {exit; }

class Gyan_Filterable_Gallery extends Widget_Base {

    public function get_name() {return 'gyan_filterable_gallery'; }
    public function get_title() {return esc_html__( 'Filterable Gallery', 'gyan-elements' ); }
    public function get_icon() { return 'gyan-el-icon eicon-gallery-grid'; }
    public function get_categories() {return [ 'gyan-advanced-addons' ]; }
    public function get_keywords() {return [ 'gyan filterable gallery', 'filterable gallery','portfolio', 'image','video','gallery' ]; }
    public function get_style_depends() {return [  'gyan-flex','gyan-grid','gyan-filterable-gallery' ]; }
    public function get_script_depends() { return [ 'gyan-widgets','imagesLoaded', 'isotope','gyan-element-resize' ]; }

    protected function register_controls() {

        $this->start_controls_section(
            'items_section',
            [
                'label' => esc_html__( 'Items', 'gyan-elements' )
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'item_name',
            [
                'label' => esc_html__( 'Item Name', 'gyan-elements' ),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter Item Name', 'gyan-elements' ),
                'default' => 'Lorem ipsum dolor sit amet',
            ]
        );
        $repeater->add_control(
            'category',
            [
                'label' => esc_html__( 'Category', 'gyan-elements' ),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'description' => esc_html__( 'Multiple category must be comma separated. Do not give blank SPACE after comma.', 'gyan-elements' ),
                'default' => 'Web Design',
            ]
        );
        $repeater->add_control(
            'image',
            [
                'label' => esc_html__( 'Choose Image', 'gyan-elements' ),
                'type' => Controls_Manager::MEDIA
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => esc_html__( 'Link', 'gyan-elements' ),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'gyan-elements' ),
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_control(
            'filterable_gallery',
            [
                'label' => esc_html__( 'Add Image', 'gyan-elements' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ item_name }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'filterable_gallery_content',
            [
                'label' => esc_html__( 'Gallery Settings', 'gyan-elements' ),
                'tab' => Controls_Manager::TAB_CONTENT,
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
                'label'   => esc_html__( 'Click Action', 'gyan-elements' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'lightbox',
                'options' => [
                    'lightbox'   => esc_html__( 'Lightbox', 'gyan-elements' ),
                    'file'       => esc_html__( 'Media File', 'gyan-elements' ),
                    'attachment' => esc_html__( 'Attachment Page', 'gyan-elements' ),
                    'custom'     => esc_html__( 'Custom Link', 'gyan-elements' ),
                    ''           => esc_html__( 'None', 'gyan-elements' ),
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
            'overlay_effects',
            [
                'label' => esc_html__( 'Overlay Effects', 'gyan-elements' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'gyan-filterable-gallery-effect-fade' => esc_html__( 'Fade', 'gyan-elements' ),
                    'gyan-filterable-gallery-effect-zoom' => esc_html__( 'Zoom', 'gyan-elements' ),
                    'gyan-filterable-gallery-effect-move' => esc_html__( 'Fade & Buttons Move', 'gyan-elements' ),
                    'gyan-filterable-gallery-effect-zoom gyan-filterable-gallery-effect-move' => esc_html__( 'Zoom & Buttons Move', 'gyan-elements' ),
                ],
                'default' => 'gyan-filterable-gallery-effect-move',
                 'condition'             => [
                    'show_overlay'      => 'yes'
                ],
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
                    'show_overlay'      => 'yes'
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
            'show_image_caption',
            [
                'label'                 => esc_html__( 'Image Caption', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'no',
                'label_off' => esc_html__( 'No', 'gyan-elements' ),
                'label_on'  => esc_html__( 'Yes', 'gyan-elements' ),
            ]
        );


        $this->add_control(
            'image_caption_source',
            [
                'label' => esc_html__( 'Image Caption Source', 'gyan-elements' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'item_name' => esc_html__( 'Item Name', 'gyan-elements' ),
                    'image_caption' => esc_html__( 'Image Caption', 'gyan-elements' ),
                    'image_title' => esc_html__( 'Image Title', 'gyan-elements' )
                ],
                'default' => 'item_name',
                 'condition'             => [
                    'show_image_caption' => 'yes'
                ],
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
        Gyan_Common_Data::filter_button( $this, '.gyan-filterable-gallery-btn' );
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
                    '{{WRAPPER}} .gyan-filterable-gallery-btns' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'filter_tabs_radius',
            [
                'label' => esc_html__( 'Radius', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-filterable-gallery-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .gyan-filterable-gallery-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .gyan-filterable-gallery-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .gyan-filterable-gallery-btns' => 'text-align: {{VALUE}};',
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
                    'size' => 20,
                ],
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-filterable-gallery-item.gyan-grid-item-wrap' => 'padding-right: calc( {{SIZE}}{{UNIT}}/2 ); padding-left: calc( {{SIZE}}{{UNIT}}/2 );',
                    '{{WRAPPER}} .gyan-filterable-gallery-grid.gyan-elementor-grid' => 'margin-left: calc( -{{SIZE}}{{UNIT}}/2 ); margin-right: calc( -{{SIZE}}{{UNIT}}/2 );',
                ],
            ]
        );

        $this->add_responsive_control(
            'row_gap',
            [
                'label'     => esc_html__( 'Rows Gap', 'gyan-elements' ),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 20,
                ],
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-elementor-grid .gyan-filterable-gallery-item-inner.gyan-grid-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'items_radius',
            [
                'label' => esc_html__( 'Radius', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-filterable-gallery-img-holder, {{WRAPPER}} .gyan-filterable-gallery-overlay' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                        'default' => 'rgba(0,0,0,0.8)',
                    ],
                ],
                'selector' => '{{WRAPPER}} .gyan-filterable-gallery-overlay',
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

        $this->start_controls_tabs( 'icons_tabs' );

        $this->start_controls_tab(
            'icons_normal',
            [
                'label' => esc_html__( 'Normal', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'icons_color',
            [
                'label' => esc_html__( 'Text Color', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .gyan-filterable-gallery-overlay i' => 'color: {{VALUE}}'
                ],
            ]
        );
        $this->add_control(
            'icons_bg',
            [
                'label' => esc_html__( 'Background', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#d83030',
                'selectors' => [
                    '{{WRAPPER}} .gyan-filterable-gallery-overlay i' => 'background: {{VALUE}}'
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'icons_border',
                'selector' => '{{WRAPPER}} .gyan-filterable-gallery-overlay i',
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
            'icons_hover_color',
            [
                'label' => esc_html__( 'Text Color', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gyan-filterable-gallery-overlay i:hover' => 'color: {{VALUE}}'
                ],
            ]
        );
        $this->add_control(
            'icons_hover_bg',
            [
                'label' => esc_html__( 'Background', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gyan-filterable-gallery-overlay i:hover' => 'background: {{VALUE}}'
                ],
            ]
        );
        $this->add_control(
            'icons_hover_border',
            [
                'label' => esc_html__( 'Border Color', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gyan-filterable-gallery-overlay i:hover' => 'border-color: {{VALUE}}'
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'icons_gap',
            [
                'label' => esc_html__( 'Icons Gap', 'gyan-elements' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '20',
                ],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .gyan-filterable-gallery-zoom' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icons_size',
            [
                'label' => esc_html__( 'Icon Size', 'gyan-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'size' => '16',
                ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-filterable-gallery-overlay i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icons_width',
            [
                'label' => esc_html__( 'Width', 'gyan-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'size' => '44',
                ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-filterable-gallery-overlay i' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icons_height',
            [
                'label' => esc_html__( 'Height', 'gyan-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'size' => '44',
                ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-filterable-gallery-overlay i' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .gyan-filterable-gallery-overlay i' => 'line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icons_radius',
            [
                'label' => esc_html__( 'Radius', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'unit' => '%',
                    'top' => '50',
                    'right' => '50',
                    'bottom' => '50',
                    'left' => '50',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-filterable-gallery-overlay i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'image_caption_styling',
            [
                'label' => esc_html__( 'Caption', 'gyan-elements' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    'show_image_caption' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'image_caption_color',
            [
                'label' => esc_html__( 'Text Color', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#606060',
                'selectors' => [
                    '{{WRAPPER}} .gyan-filterable-gallery-caption' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'image_caption_bg_color',
                'label' => esc_html__( 'Background', 'gyan-elements' ),
                'types' => [ 'classic', 'gradient' ],
                'fields_options' => [
                    'background' => [
                        'default' =>'classic',
                    ],
                    'color' => [
                        'default' => '#f2f2f2',
                    ],
                ],
                'selector' => '{{WRAPPER}} .gyan-filterable-gallery-caption',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'image_caption_typography',
                'selector' => '{{WRAPPER}} .gyan-filterable-gallery-caption',
            ]
        );
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'image_caption_shadow',
                'selector' => '{{WRAPPER}} .gyan-filterable-gallery-caption',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'image_caption_border',
                'selector' => '{{WRAPPER}} .gyan-filterable-gallery-caption',
            ]
        );

        $this->add_responsive_control(
            'image_caption_radius',
            [
                'label' => esc_html__( 'Radius', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-filterable-gallery-caption' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_caption_margin',
            [
                'label' => esc_html__( 'Margin', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-filterable-gallery-caption' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_caption_padding',
            [
                'label' => esc_html__( 'Padding', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-filterable-gallery-caption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();


    }

    protected function render() {
        $data = $this->get_settings_for_display();
        $data_rtl = is_rtl() ? 'true' : 'false';
        $all_label = esc_html($data['all_tab_label']);
        ?>
        <div class="gyan-filterable-gallery <?php echo esc_attr( 'gyan-filterable-gallery-'.$this->get_id() ); ?>"
        data-layout="<?php echo esc_attr( $data['layout'] ); ?>" data-rtl="<?php echo $data_rtl; ?>">

            <?php if ( 'yes' === $data['show_filter_tabs'] ) :  ?>

                <div class="gyan-filterable-gallery-btns">
                    <?php
                    if ( '' != $all_label ) { ?>
                        <button class="gyan-filterable-gallery-btn gyan-button is-checked" data-filter="*"><?php echo $all_label; ?></button>
                    <?php
                    }
                        $categories = gyan_get_filterable_gallery_cat( $data['filterable_gallery'] );
                        foreach ( $categories as $cat ) :
                            ?><button class="gyan-filterable-gallery-btn gyan-button" data-filter=".<?php echo esc_attr( $cat ); ?>"><?php
                            printf('%s', ucwords(str_replace('_', ' ', trim( $cat, '_'))));
                            ?></button><?php
                        endforeach; ?>
                </div>

            <?php endif; ?>

            <div class="gyan-filterable-gallery-grid gyan-elementor-grid">
            <?php

                $settings = $this->get_settings();

                $click_action = $settings['click_action'];

                $index=0;

                foreach ( $data['filterable_gallery'] as $item ) :
                    $category = strtolower( str_replace( ' ', '_', $item['category'] ) );
                    $category =  str_replace( ',', ' ', $category );

                    if ( $item['image']['url'] ):

                        // responsive image
                        if (  $data['image_size'] == 'full' ) {
                            $imageTagHtml = wp_get_attachment_image( $item['image']['id'], 'full');
                        } else {
                            $imgUrl = Group_Control_Image_Size::get_attachment_image_src( $item['image']['id'], 'image', $data );
                            if ( ! $imgUrl ) {
                                $imgUrl = $item['image']['url'];
                            }
                            $imageTagHtml = '<img src="'.esc_url($imgUrl).'" alt="" />';
                        }

                        if ( '' !== $click_action ) {

                            $item_link    = '';
                            $lightbox     = 'no';

                            switch ($click_action) {
                                case "lightbox":

                                    if ( $item['image']['id'] ) {
                                        $item_link = wp_get_attachment_image_src( $item['image']['id'], 'full' );
                                        $item_link = $item_link[0];
                                    } else {
                                        $item_link = $item['image']['url'];
                                    }

                                    $lightbox = 'yes';

                                    break;

                                case "file":

                                    if ( $item['image']['id'] ) {
                                        $item_link = wp_get_attachment_image_src( $item['image']['id'], 'full' );
                                        $item_link = $item_link[0];
                                    } else {
                                        $item_link = $item['image']['url'];
                                    }

                                    break;

                                case "attachment":

                                    $item_link = get_permalink( $item['image']['id'] );

                                    break;
                                case "custom":

                                    if ( ! empty( $item['link']['url'] ) ) {
                                        $item_link = $item['link']['url'];
                                    }

                                    break;
                            }

                            $this->add_render_attribute(
                                'grid-media-' . $index,
                                [
                                    'class'                             => 'elementor-clickable gyan-filterable-gallery-zoom',
                                    'data-elementor-open-lightbox'      => $lightbox,
                                    'data-elementor-lightbox-slideshow' => $this->get_id(),
                                    'data-elementor-lightbox-index'     => $index,
                                    'title'                             => esc_attr( $item['item_name'] )
                                ]
                            );

                            $this->add_render_attribute( 'grid-media-' . $index, 'href', $item_link );
                        }

                        ?>
                        <div class="gyan-filterable-gallery-item gyan-grid-item-wrap <?php echo esc_attr( $category ); ?>">
                            <div class="gyan-filterable-gallery-item-inner gyan-grid-item">

                                <div class="gyan-filterable-gallery-img-holder">

                                    <?php
                                    echo $imageTagHtml;

                                    if ( 'yes' === $data['show_overlay'] ) :  ?>

                                        <div class="gyan-filterable-gallery-overlay gyan-overlay gyan-flex <?php echo esc_attr( $data['overlay_effects'] ); ?>">
                                            <div class="gyan-filterable-gallery-icons gyan-flex">

                                                <?php if ( 'yes' === $data['show_zoom_icon'] ) :  ?>
                                                    <a <?php echo $this->get_render_attribute_string( 'grid-media-' . $index ); ?> >
                                                        <i class="fa fa-search-plus"></i>
                                                    </a>
                                                 <?php endif; ?>

                                                 <?php if ( 'yes' === $data['show_link_icon'] ) :  ?>
                                                    <a href="<?php echo esc_url( $item['link']['url'] ); ?>"
                                                    <?php if ( 'on' == $item['link']['is_external'] ): ?>
                                                        target="_blank"
                                                    <?php endif; ?>
                                                    <?php if ( 'on' == $item['link']['nofollow'] ): ?>
                                                        rel="nofollow"
                                                    <?php endif; ?> class="gyan-filterable-gallery-link">
                                                        <i class="fa fa-link"></i>
                                                    </a>
                                                 <?php endif; ?>
                                            </div>
                                        </div>

                                     <?php endif; ?>

                                </div>

                                 <?php if ( 'yes' === $data['show_image_caption'] ) :

                                    if ( 'item_name' === $data['image_caption_source'] ) {

                                        $caption_text = $item['item_name'];

                                    } elseif ( 'image_caption' === $data['image_caption_source'] ) {

                                        $attachment = $item['image']['id'];
                                        $caption_text = get_image_caption( $attachment, 'caption' );

                                    } else {
                                        $attachment = $item['image']['id'];
                                        $caption_text = get_image_caption( $attachment, 'title' );
                                    }
                                    ?>
                                     <div class="gyan-filterable-gallery-caption"><?php echo esc_html($caption_text); ?></div>
                                <?php endif; ?>

                            </div>
                        </div>
                <?php endif;
                    $index++; ?>
            <?php endforeach; ?>
            </div>
        </div>
        <?php
        if ( Plugin::instance()->editor->is_edit_mode() ) {
            $this->render_editor_script();
        }
    }

    protected function render_editor_script() {
        ?>
        <script type="text/javascript">
        jQuery( document ).ready(function( $ ) {
            var gyanPFClass = '.gyan-filterable-gallery-'+'<?php echo $this->get_id(); ?>',
                $this = $(gyanPFClass),
                $isoGrid = $this.children('.gyan-filterable-gallery-grid'),
                $btns = $this.children('.gyan-filterable-gallery-btns'),
                is_rtl = $this.data('rtl') ? false : true,
                layout = $this.data('layout');

            $this.imagesLoaded( function() {
                if ( 'masonry' == layout ) {
                    var $grid = $isoGrid.isotope({
                        itemSelector: '.gyan-filterable-gallery-item',
                        percentPosition: true,
                        originLeft: is_rtl,
                        masonry: {
                            columnWidth: '.gyan-filterable-gallery-item',
                        }
                    });
                } else{
                    var $grid = $isoGrid.isotope({
                        itemSelector: '.gyan-filterable-gallery-item',
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

                $this.find('.gyan-filterable-gallery-item').resize( function() {
                    $grid.isotope( 'layout' );
                });

                $btns.each(function (i, btns) {
                    var btns = $(btns);

                    btns.on('click', '.gyan-filterable-gallery-btn', function () {
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