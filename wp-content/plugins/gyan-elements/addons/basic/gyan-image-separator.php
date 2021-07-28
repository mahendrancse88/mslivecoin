<?php
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Css_Filter;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Gyan_Image_Separator extends Widget_Base {

    public function get_name()           { return 'gyan_image_separator'; }
    public function get_title()          { return esc_html__( 'Image Separator', 'gyan-elements' ); }
    public function get_icon()           { return 'gyan-el-icon eicon-image'; }
    public function get_categories()     { return ['gyan-basic-addons']; }
    public function get_keywords()       { return [ 'Image Separator', 'divider', 'Separator','break','image' ]; }
    public function get_style_depends()  { return ['gyan-image-separator']; }

    protected function register_controls() {

        $this->start_controls_section('gyan_image_separator_general_settings',
                [
                    'label'         => esc_html__('Image Settings', 'gyan-elements')
                    ]
                );

        $this->add_control('gyan_image_separator_image',
                [
                    'label'         => esc_html__('Image', 'gyan-elements'),
                    'type'          => Controls_Manager::MEDIA,
                    'dynamic'       => [ 'active' => true ],
                    'default'       => [
                        'url'	=> GYAN_PLUGIN_URL .'addons/images/choose-img.jpg',
                        ],
                    'description'   => esc_html__('Choose the separator image', 'gyan-elements' ),
                    'label_block'   => true
                    ]
                );

        $this->add_responsive_control('gyan_image_separator_image_size',
                [
                    'label'         => esc_html__('Image Size', 'gyan-elements'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', '%', "em"],
                    'default'       => [
                        'unit'  => 'px',
                        'size'  => 200,
                    ],
                    'range'         => [
                        'px'    => [
                            'min'   => 1,
                            'max'   => 800,
                        ],
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .gyan-image-separator-wrap img' => 'width: {{SIZE}}{{UNIT}};'
                        ]
                    ]
                );

        $this->add_control('gyan_image_separator_image_gutter',
                [
                    'label'         => esc_html__('Image Gutter (%)', 'gyan-elements'),
                    'type'          => Controls_Manager::NUMBER,
                    'default'       => -50,
                    'description'   => esc_html__('-50% is default. Increase to push the image outside or decrease to pull the image inside.','gyan-elements'),
                    'selectors'     => [
                        '{{WRAPPER}} .gyan-image-separator-wrap' => 'transform: translateY( {{VALUE}}% );'

                        ]
                    ]
                );

        $this->add_control('gyan_image_separator_image_align',
            [
                'label'         => esc_html__('Image Alignment', 'gyan-elements'),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'left'  => [
                        'title'     => esc_html__('Left', 'gyan-elements'),
                        'icon'      => 'fa fa-align-left'
                    ],
                    'center'  => [
                        'title'     => esc_html__('Center', 'gyan-elements'),
                        'icon'      => 'fa fa-align-center'
                    ],
                    'right'  => [
                        'title'     => esc_html__('Right', 'gyan-elements'),
                        'icon'      => 'fa fa-align-right'
                    ],
                ],
                'default'       => 'center',
                'selectors'     => [
                    '{{WRAPPER}} .gyan-image-separator-wrap'   => 'text-align: {{VALUE}};',
                ]
            ]
            );

        $this->add_control('gyan_image_separator_link',
            [
                'label'       => esc_html__('Link', 'gyan-elements'),
                'type'        => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'gyan-elements' ),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('gyan_image_separator_style',
            [
                'label'         => esc_html__('Image', 'gyan-elements'),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters',
				'selector' => '{{WRAPPER}} .gyan-image-separator-wrap img',
			]
		);

        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $alt = esc_attr( Control_Media::get_image_alt( $settings['gyan_image_separator_image'] ) );
    ?>

    <div class="gyan-image-separator-wrap">

       <img class="img-responsive" src="<?php echo $settings['gyan_image_separator_image']['url']; ?>" alt="<?php echo $alt; ?>">
        <?php if ( $settings['gyan_image_separator_link']['url'] ):

            $this->add_render_attribute( 'button', 'href', $settings['gyan_image_separator_link']['url'] );
            $this->add_render_attribute( 'button', 'class', 'gyan-image-separator-link' );

            if ( $settings['gyan_image_separator_link']['is_external'] ) {
                $this->add_render_attribute( 'button', 'target', '_blank' );
            }
            if ( $settings['gyan_image_separator_link']['nofollow'] ) {
                $this->add_render_attribute( 'button', 'rel', 'nofollow' );
            }
            ?>
            <a <?php echo $this->get_render_attribute_string( 'button' ); ?>></a>
         <?php endif; ?>
    </div>
    <?php
    }

    protected function _content_template() {}
}