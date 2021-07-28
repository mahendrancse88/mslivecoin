<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Gyan_Multi_Image extends Widget_Base {

    public function get_name()       { return 'gyan_multi_image'; }
    public function get_title()      { return esc_html__( 'Multi Image', 'gyan-elements' ); }
    public function get_icon()       { return 'gyan-el-icon eicon-image'; }
    public function get_categories() { return [ 'gyan-advanced-addons' ]; }
    public function get_keywords()   { return [ 'image', 'title', 'multi image' ]; }
    public function get_style_depends()  { return ['gyan-icon','gyan-position','magnific-popup','gyan-multi-image']; }
    public function get_script_depends() { return ['gyan-widgets','magnific-popup' ]; }

    protected function register_controls() {
        $this->start_controls_section(
            'section_content_heading',
            [
                'label' => esc_html__( 'Multi Images', 'gyan-elements' ),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'display_type',
            [
                'label'                 => esc_html__( 'Display Type', 'gyan-elements' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => 'image',
                'options'               => [
                    'image'     => esc_html__( 'Image', 'gyan-elements' ),
                    'content'   => esc_html__( 'Content', 'gyan-elements' ),
                    'shape'     => esc_html__( 'Shape', 'gyan-elements' ),
                ],
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label'                 => esc_html__( 'Image', 'gyan-elements' ),
                'type'                  => Controls_Manager::MEDIA,
                'default'   => [
                    'url' => GYAN_PLUGIN_URL .'addons/images/choose-img.jpg',
                ],
                'condition'             => [
                    'display_type'  => 'image',
                ],
            ]
        );

        $repeater->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'                  => 'image_size',
                'label'                 => esc_html__( 'Image Size', 'gyan-elements' ),
                'default'               => 'full',
                'condition'             => [
                    'display_type'  => 'image',
                ],
            ]
        );

        $repeater->add_control(
            'content_icon',
            [
                'label'                 => esc_html__( 'Icon', 'gyan-elements' ),
                'type'                  => Controls_Manager::ICONS,
                'condition'             => [
                    'display_type' => 'content',
                ],
            ]
        );

        $repeater->add_control(
            'content_text',
            [
                'label' => esc_html__( 'Content', 'gyan-elements' ),
                'label_block' => true,
                'type' => Controls_Manager::TEXTAREA,
                'placeholder' => esc_html__( 'Enter Description', 'gyan-elements' ),
                'default' => 'This is sample text',
                'condition'             => [
                    'display_type' => 'content',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'width',
            [
                'label' => esc_html__( 'Width', 'gyan-elements' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range' => [
                    'px' => [
                        'min'  => 1,
                        'max'  => 500,
                    ],
                ],
                'default'    => [
                        'size' => 100,
                        'unit' => 'px',
                    ],
                'condition'             => [
                    'display_type!' => 'image',
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.gyan-multi-image' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'height',
            [
                'label' => esc_html__( 'Height', 'gyan-elements' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range' => [
                    'px' => [
                        'min'  => 1,
                        'max'  => 500,
                    ],
                ],
                'default'    => [
                        'size' => 100,
                        'unit' => 'px',
                    ],
                'condition'             => [
                    'display_type!' => 'image',
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.gyan-multi-image' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $repeater->add_control(
            'origin',
            [
                'label'   => esc_html__( 'Origin', 'gyan-elements' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'top-left',
                'options' => gyan_position(),
            ]
        );

        $repeater->add_responsive_control(
            'position',
            [
                'label' => esc_html__( 'Margin', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.gyan-multi-image' => 'margin-top: {{TOP}}{{UNIT}}; margin-right: {{RIGHT}}{{UNIT}}; margin-bottom:{{BOTTOM}}{{UNIT}}; margin-left:{{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $repeater->add_control(
            'z_index',
            [
                'label' => esc_html__( 'Z-Index', 'elementor' ),
                'type' => Controls_Manager::NUMBER,
                'default'     => 0,
                'min' => -1,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.gyan-multi-image' => 'z-index: {{VALUE}};',
                ],
                'label_block' => false,
            ]
        );

        $repeater->add_control(
            'show_video',
            [
                'label'                 => esc_html__( 'Video', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'no',
                'separator'             => 'before',
                'label_off'             => esc_html__( 'No', 'gyan-elements' ),
                'label_on'              => esc_html__( 'Yes', 'gyan-elements' ),
                'condition'             => [
                    'display_type'  => 'image',
                ],
            ]
        );

        $repeater->add_control(
            'video_url',
            [
                'label' => esc_html__('YouTube/Vimeo Video URL', 'gyan-elements'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'condition' => [
                    'show_video' => 'yes',
                    'display_type'  => 'image',
                ]
            ]
        );

        $repeater->add_control(
            'video_origin',
            [
                'label'   => esc_html__( 'Video Box Origin', 'gyan-elements' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'bottom-right',
                'options' => gyan_position(),
                'condition' => [
                    'show_video' => 'yes',
                    'display_type'  => 'image',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'video_position',
            [
                'label' => esc_html__( 'Video Margin', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => '20px',
                    'right' => '20px',
                    'bottom' => '20px',
                    'left' => '20px',
                    'isLinked' => false,
                ],
                'condition' => [
                    'show_video' => 'yes',
                    'display_type'  => 'image',
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.gyan-multi-image .gyan-multi-image-video' => 'margin-top: {{TOP}}{{UNIT}}; margin-right: {{RIGHT}}{{UNIT}}; margin-bottom:{{BOTTOM}}{{UNIT}}; margin-left:{{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $repeater->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'section_background',
                'label' => esc_html__( 'Background', 'gyan-elements' ),
                'types' => [ 'classic' ],
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}.gyan-multi-image',
                'separator' => 'before'
            ]
        );

        $repeater->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}.gyan-multi-image',
            ]
        );

        $repeater->add_control(
            'border_radius',
            [
                'label'                 => esc_html__( 'Border Radius', 'gyan-elements' ),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => [ 'px', '%' ],
                'selectors'             => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.gyan-multi-image,{{WRAPPER}} {{CURRENT_ITEM}}.gyan-multi-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'padding',
            [
                'label' => esc_html__( 'Padding', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.gyan-multi-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $repeater->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'                  => 'box_shadow',
                'selector'              => '{{WRAPPER}} {{CURRENT_ITEM}}.gyan-multi-image',
            ]
        );

        $repeater->add_control(
            'opacity',
            [
                'label' => esc_html__( 'Opacity', 'gyan-elements' ),
                'type'  => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 1,
                ],
                'range' => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 1,
                        'step' => 0.01,
                    ],
                ],
                'condition'             => [
                    'display_type!' => 'content',
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.gyan-multi-image' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $repeater->add_control(
            'animation_type',
            [
                'label'                 => esc_html__( 'Animation', 'gyan-elements' ),
                'type'                  => Controls_Manager::SELECT,
                'options'               => [
                    ''       => esc_html__( 'None', 'gyan-elements' ),
                    'rotate' => esc_html__( 'Rotate', 'gyan-elements' ),
                    'hang'   => esc_html__( 'Hang', 'gyan-elements' ),
                    'pulse'  => esc_html__( 'Pulse', 'gyan-elements' ),
                    'buzz'   => esc_html__( 'Buzz', 'gyan-elements' ),
                ],
            ]
        );

        $repeater->add_control(
            'transition_duration',
            [
                'label' => esc_html__( 'Transition Duration', 'elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0.3,
                ],
                'range' => [
                    'px' => [
                        'max' => 10,
                        'step' => 0.01,
                    ],
                ],
                'condition' => [
                    'animation_type!' => '',
                ],
                'render_type' => 'ui',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.gyan-multi-image' => 'animation-duration:{{SIZE}}s;',
                ],
            ]
        );

        $repeater->add_control(
            'section_hide',
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

        $this->add_control(
            'multi_images',
            [
                'label' => '',
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'display_type' => 'image',
                    ],
                ],
                'title_field' => '{{{ display_type }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'content_style',
            [
                'label' => esc_html__( 'Content', 'gyan-elements' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#d83030',
                'selectors' => [
                    '{{WRAPPER}} .gyan-multi-image .gyan-multi-image-content i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .gyan-multi-image .gyan-multi-image-content svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icons_size',
            [
                'label' => esc_html__( 'Icon Size', 'gyan-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range' => [
                    'px' => [
                        'min'  => 1,
                        'max'  => 500,
                    ],
                ],
                'default' => [
                    'size' => '20',
                ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-multi-image .gyan-multi-image-content i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .gyan-multi-image .gyan-multi-image-content svg' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__( 'Text Color', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#222',
                'selectors' => [
                    '{{WRAPPER}} .gyan-multi-image' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'text_typography',
                'label'                 => esc_html__( 'Typography', 'gyan-elements' ),
                'selector'              => '{{WRAPPER}} .gyan-multi-image',
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
                        'icon'  => 'fas fa-align-left',
                    ],
                    'center'    => [
                        'title' => esc_html__( 'Center', 'gyan-elements' ),
                        'icon'  => 'fas fa-align-center',
                    ],
                    'right'     => [
                        'title' => esc_html__( 'Right', 'gyan-elements' ),
                        'icon'  => 'fas fa-align-right',
                    ],
                ],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-multi-image .gyan-multi-image-content' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'video_section',
            [
                'label' => esc_html__( 'Video', 'gyan-elements' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'video_play_icon',
            [
                'label'                 => esc_html__( 'Play Icon', 'gyan-elements' ),
                'type'                  => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-play',
                    'library' => 'fa-solid',
                ]
            ]
        );

        $this->start_controls_tabs( 'video_style' );

        $this->start_controls_tab(
            'tab_video_normal',
            [
                'label' => esc_html__( 'Normal', 'gyan-elements' ),
            ]
        );


        $this->add_responsive_control(
            'video_width',
            [
                'label' => esc_html__( 'Width', 'gyan-elements' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range' => [
                    'px' => [
                        'min'  => 1,
                        'max'  => 500,
                    ],
                ],
                'default'    => [
                        'size' => 60,
                        'unit' => 'px',
                    ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-multi-images  .gyan-multi-image .gyan-multi-image-video' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'video_height',
            [
                'label' => esc_html__( 'Height', 'gyan-elements' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range' => [
                    'px' => [
                        'min'  => 1,
                        'max'  => 500,
                    ],
                ],
                'default'    => [
                        'size' => 60,
                        'unit' => 'px',
                    ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-multi-images  .gyan-multi-image .gyan-multi-image-video' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .gyan-multi-images  .gyan-multi-image .gyan-multi-image-video i' => 'line-height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .gyan-multi-images  .gyan-multi-image .gyan-multi-image-video svg' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'video_icons_size',
            [
                'label' => esc_html__( 'Icon Size', 'gyan-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range' => [
                    'px' => [
                        'min'  => 1,
                        'max'  => 500,
                    ],
                ],
                'default' => [
                    'size' => '20',
                ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-multi-images  .gyan-multi-image .gyan-multi-image-video' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'video_color',
            [
                'label' => esc_html__( 'Icon Color', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#fda128',
                'selectors' => [
                    '{{WRAPPER}} .gyan-multi-images  .gyan-multi-image a.gyan-multi-image-video i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .gyan-multi-images  .gyan-multi-image a.gyan-multi-image-video svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'video_background',
                'label' => esc_html__( 'Background', 'gyan-elements' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .gyan-multi-images  .gyan-multi-image .gyan-multi-image-video',
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'video_border',
                'selector' => '{{WRAPPER}} .gyan-multi-images  .gyan-multi-image .gyan-multi-image-video',
            ]
        );

        $this->add_control(
            'video_border_radius',
            [
                'label'                 => esc_html__( 'Border Radius', 'gyan-elements' ),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => [ 'px', '%' ],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-multi-images  .gyan-multi-image .gyan-multi-image-video' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'                  => 'video_box_shadow',
                'selector'              => '{{WRAPPER}} .gyan-multi-images  .gyan-multi-image .gyan-multi-image-video',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_video_hover',
            [
                'label' => esc_html__( 'Hover', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'video_hover_color',
            [
                'label' => esc_html__( 'Icon Color', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gyan-multi-images  .gyan-multi-image a.gyan-multi-image-video:hover i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .gyan-multi-images  .gyan-multi-image a.gyan-multi-image-video:hover svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

         $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'video_hover_background',
                'label' => esc_html__( 'Background', 'gyan-elements' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .gyan-multi-images  .gyan-multi-image .gyan-multi-image-video:hover'
            ]
        );

         $this->add_control(
            'video_hover_border',
            [
                'label' => esc_html__( 'Border Color', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gyan-multi-images  .gyan-multi-image .gyan-multi-image-video:hover' => 'border-color: {{VALUE}};'
                ],
            ]
        );

         $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'                  => 'video_hover_box_shadow',
                'selector'              => '{{WRAPPER}} .gyan-multi-images  .gyan-multi-image .gyan-multi-image-video:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();
?>
        <div class="gyan-multi-images">

            <?php foreach ( $settings['multi_images'] as $index => $item ) : ?>

                <?php
                $video_origin = ' gyan-position-' . $item['video_origin'];
                $multi_image_key = $this->get_repeater_setting_key( 'display_type', 'multi_images', $index );

                $this->add_render_attribute( [
                    $multi_image_key => [
                        'class' => [
                            'gyan-multi-image',
                            $item['section_hide'] ? 'gyan-visible@'. $item['section_hide'] : '',
                            $item['animation_type'] ? 'gyan-animation-'. $item['animation_type'] : '',
                            'elementor-repeater-item-' . $item['_id'],
                            'gyan-position-' . $item['origin'],
                        ],
                    ],
                ] );
                ?>

                <div <?php echo $this->get_render_attribute_string( $multi_image_key ); ?>>
                    <?php if ( 'image' == $item['display_type'] ) { ?>
                        <div class="gyan-multi-image-img">

                            <?php if ( 'yes' == $item['show_video'] && '' != $item['video_url'] ) { ?>
                                <a class="gyan-multi-image-video gyan-icon gyan-video-lightbox gyan-ease-transition <?php echo esc_attr($video_origin); ?>" href="<?php echo $item['video_url']; ?>" ><?php Icons_Manager::render_icon( $settings['video_play_icon'], [ 'aria-hidden' => 'true' ] ); ?></a>
                            <?php } ?>
                            <?php echo Group_Control_Image_Size::get_attachment_image_html( $item, 'image_size', 'image' ); ?>
                        </div>

                    <?php } elseif ( 'content' == $item['display_type'] ) { ?>

                        <div class="gyan-multi-image-content">
                            <div class="gyan-icon"><?php Icons_Manager::render_icon( $item['content_icon'], [ 'aria-hidden' => 'true' ] ); ?></div>
                            <div class="gyan-multi-image-content-text gyan-icon"><?php echo $item['content_text']; ?></div>
                        </div>

                    <?php } else { ?>
                            <div class="gyan-multi-image-shape"></div>
                    <?php } ?>

                </div>

            <?php endforeach; ?>
        </div> <!-- gyan-multi-images -->
<?php
    }

    protected function _content_template() {}

}