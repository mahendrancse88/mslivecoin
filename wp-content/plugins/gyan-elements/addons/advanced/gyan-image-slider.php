<?php
// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Control_Media;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Scheme_Typography;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Gyan_Image_Slider extends Widget_Base {

    public function get_name()           { return 'gyan_image_slider'; }
    public function get_title()          { return esc_html__( 'Image Slider', 'gyan-elements' ); }
    public function get_icon()           { return 'gyan-el-icon eicon-thumbnails-down'; }
    public function get_categories()     { return ['gyan-advanced-addons' ]; }
    public function get_keywords()       { return ['gyan image slider', 'image', 'slider','gallery','carousel','slide', 'thumbnail', ]; }
    public function get_style_depends()  { return ['gyan-grid','gyan-image-slider']; }
    public function get_script_depends() { return [ 'gyan-widgets', 'jquery-resize', 'gyan-slick' ]; }

    protected function register_controls() {

        $this->start_controls_section(
            'section_gallery',
            [
                'label'                 => esc_html__( 'Gallery', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'gallery_images',
            [
                'label'                 => esc_html__( 'Add Images', 'gyan-elements' ),
                'type'                  => Controls_Manager::GALLERY,
                'dynamic'               => [
                    'active' => true
                ],
            ]
        );

		$this->add_control(
			'effect',
			[
				'type'                  => Controls_Manager::SELECT,
				'label'                 => esc_html__( 'Effect', 'gyan-elements' ),
				'default'               => 'slide',
				'options'               => [
					'slide'    => esc_html__( 'Slide', 'gyan-elements' ),
					'fade'     => esc_html__( 'Fade', 'gyan-elements' ),
				],
				'separator'             => 'before',
				'frontend_available'    => true,
			]
		);

		$this->add_control(
			'skin',
			[
				'label'                 => esc_html__( 'Layout', 'gyan-elements' ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'slideshow',
				'options'               => [
					'slideshow'    => esc_html__( 'Slideshow', 'gyan-elements' ),
					'carousel'     => esc_html__( 'Carousel', 'gyan-elements' ),
				],
				'prefix_class'          => 'gyan-image-slider-',
				'render_type'           => 'template',
				'frontend_available'    => true,
			]
		);

		$slides_per_view = range( 1, 10 );
		$slides_per_view = array_combine( $slides_per_view, $slides_per_view );

		$this->add_responsive_control(
			'slides_per_view',
			[
				'type'                  => Controls_Manager::SELECT,
				'label'                 => esc_html__( 'Slides Per View', 'gyan-elements' ),
				'options'               => $slides_per_view,
				'default'               => '3',
				'tablet_default'        => '2',
				'mobile_default'        => '2',
				'condition'             => [
					'effect'   => 'slide',
					'skin!'    => 'slideshow',
				],
				'frontend_available'    => true,
			]
		);

		$this->add_responsive_control(
			'slides_to_scroll',
			[
				'type'                  => Controls_Manager::SELECT,
				'label'                 => esc_html__( 'Slides to Scroll', 'gyan-elements' ),
				'description'           => esc_html__( 'Set how many slides are scrolled per swipe.', 'gyan-elements' ),
				'options'               => $slides_per_view,
				'default'               => 1,
				'tablet_default'        => 1,
				'mobile_default'        => 1,
				'condition'             => [
					'effect'   => 'slide',
					'skin!'    => 'slideshow',
				],
				'frontend_available'    => true,
			]
		);

        $this->end_controls_section();


        $this->start_controls_section(
            'section_thumbnails_settings',
            [
                'label'                 => esc_html__( 'Thumbnails', 'gyan-elements' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'                  => 'thumbnail',
                'label'                 => esc_html__( 'Image Size', 'gyan-elements' ),
                'default'               => 'thumbnail'
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label'                 => esc_html__( 'Columns', 'gyan-elements' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => '3',
                'tablet_default'        => '6',
                'mobile_default'        => '4',
                'options'               => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                    '8' => '8',
                    '9' => '9',
                    '10' => '10',
                    '11' => '11',
                    '12' => '12',
                ],
                'prefix_class'          => 'elementor-grid%s-',
                'frontend_available'    => true,
                'condition'             => [
					'skin'     => 'slideshow',
				],
            ]
        );

		$this->add_control(
			'thumbnails_caption',
			[
				'type'                  => Controls_Manager::SELECT,
				'label'                 => esc_html__( 'Caption', 'gyan-elements' ),
				'default'               => '',
				'options'               => [
					''         => esc_html__( 'None', 'gyan-elements' ),
					'caption'  => esc_html__( 'Caption', 'gyan-elements' ),
					'title'    => esc_html__( 'Title', 'gyan-elements' ),
				],
			]
		);

        $this->add_control(
            'carousel_link_to',
            [
                'label'                 => esc_html__( 'Link to', 'gyan-elements' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => 'none',
                'options'               => [
                    'none' 		=> esc_html__( 'None', 'gyan-elements' ),
                    'file' 		=> esc_html__( 'Media File', 'gyan-elements' ),
                    'custom' 	=> esc_html__( 'Custom URL', 'gyan-elements' ),
                ],
                'condition'             => [
					'skin'      => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'carousel_link',
            [
                'label'                 => esc_html__( 'Link', 'gyan-elements' ),
                'show_label'            => false,
                'type'                  => Controls_Manager::URL,
                'placeholder'           => esc_html__( 'http://your-link.com', 'gyan-elements' ),
                'condition'             => [
					'skin'              => 'carousel',
                    'carousel_link_to'  => 'custom',
                ],
            ]
        );

        $this->add_control(
            'carousel_open_lightbox',
            [
                'label'                 => esc_html__( 'Lightbox', 'gyan-elements' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => 'default',
                'options'               => [
                    'default' 	=> esc_html__( 'Default', 'gyan-elements' ),
                    'yes' 		=> esc_html__( 'Yes', 'gyan-elements' ),
                    'no' 		=> esc_html__( 'No', 'gyan-elements' ),
                ],
                'separator'             => 'before',
                'condition'             => [
					'skin'              => 'carousel',
                    'carousel_link_to'  => 'file',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_feature_image',
            [
                'label'                 => esc_html__( 'Feature Image', 'gyan-elements' ),
                'condition'             => [
					'skin'     => 'slideshow',
				],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'                  => 'image',
                'label'                 => esc_html__( 'Image Size', 'gyan-elements' ),
                'default'               => 'full',
                'condition'             => [
					'skin'     => 'slideshow',
				],
            ]
        );

		$this->add_control(
			'feature_image_caption',
			[
				'type'                  => Controls_Manager::SELECT,
				'label'                 => esc_html__( 'Caption', 'gyan-elements' ),
				'default'               => '',
				'options'               => [
					''         => esc_html__( 'None', 'gyan-elements' ),
					'caption'  => esc_html__( 'Caption', 'gyan-elements' ),
					'title'    => esc_html__( 'Title', 'gyan-elements' ),
				],
                'condition'             => [
					'skin'     => 'slideshow',
				],
			]
		);

        $this->add_control(
            'link_to',
            [
                'label'                 => esc_html__( 'Link to', 'gyan-elements' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => 'none',
                'options'               => [
                    'none' 		=> esc_html__( 'None', 'gyan-elements' ),
                    'file' 		=> esc_html__( 'Media File', 'gyan-elements' ),
                    'custom' 	=> esc_html__( 'Custom URL', 'gyan-elements' ),
                ],
                'condition'             => [
					'skin'      => 'slideshow',
				],
            ]
        );

        $this->add_control(
            'link',
            [
                'label'                 => esc_html__( 'Link', 'gyan-elements' ),
                'show_label'            => false,
                'type'                  => Controls_Manager::URL,
                'placeholder'           => esc_html__( 'http://your-link.com', 'gyan-elements' ),
                'condition'             => [
					'skin'      => 'slideshow',
                    'link_to'   => 'custom',
                ],
            ]
        );

        $this->add_control(
            'open_lightbox',
            [
                'label'                 => esc_html__( 'Lightbox', 'gyan-elements' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => 'default',
                'options'               => [
                    'default' 	=> esc_html__( 'Default', 'gyan-elements' ),
                    'yes' 		=> esc_html__( 'Yes', 'gyan-elements' ),
                    'no' 		=> esc_html__( 'No', 'gyan-elements' ),
                ],
				'separator'             => 'before',
                'condition'             => [
					'skin'      => 'slideshow',
                    'link_to'   => 'file',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_additional_options',
            [
                'label'                 => esc_html__( 'Additional Options', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'animation_speed',
            [
                'label'                 => esc_html__( 'Animation Speed', 'gyan-elements' ),
                'type'                  => Controls_Manager::NUMBER,
                'default'               => 600,
                'frontend_available'    => true,
            ]
        );

        $this->add_control(
            'arrows',
            [
                'label'                 => esc_html__( 'Arrows', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'              => esc_html__( 'Yes', 'gyan-elements' ),
                'label_off'             => esc_html__( 'No', 'gyan-elements' ),
                'return_value'          => 'yes',
				'frontend_available'    => true,
            ]
        );

        $this->add_control(
            'arrows_on_hover',
            [
                'label'                 => esc_html__( 'Arrows on Hover', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'              => esc_html__( 'Yes', 'gyan-elements' ),
                'label_off'             => esc_html__( 'No', 'gyan-elements' ),
                'return_value'          => 'yes',
                'frontend_available'    => true,
                'condition'             => [
                    'arrows'  => 'yes',
                ],
            ]
        );

        $this->add_control(
            'dots',
            [
                'label'                 => esc_html__( 'Dots', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'no',
                'label_on'              => esc_html__( 'Yes', 'gyan-elements' ),
                'label_off'             => esc_html__( 'No', 'gyan-elements' ),
                'return_value'          => 'yes',
				'frontend_available'    => true,
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label'                 => esc_html__( 'Autoplay', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'              => esc_html__( 'Yes', 'gyan-elements' ),
                'label_off'             => esc_html__( 'No', 'gyan-elements' ),
                'return_value'          => 'yes',
                'frontend_available'    => true,
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label'                 => esc_html__( 'Autoplay Speed', 'gyan-elements' ),
                'type'                  => Controls_Manager::NUMBER,
                'default'               => 3000,
                'frontend_available'    => true,
                'condition'             => [
                    'autoplay'  => 'yes',
                ],
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label'                 => esc_html__( 'Pause on Hover', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'              => esc_html__( 'Yes', 'gyan-elements' ),
                'label_off'             => esc_html__( 'No', 'gyan-elements' ),
                'return_value'          => 'yes',
                'frontend_available'    => true,
                'condition'             => [
                    'autoplay'  => 'yes',
                ],
            ]
        );

        $this->add_control(
            'infinite_loop',
            [
                'label'                 => esc_html__( 'Infinite Loop', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'              => esc_html__( 'Yes', 'gyan-elements' ),
                'label_off'             => esc_html__( 'No', 'gyan-elements' ),
                'return_value'          => 'yes',
                'frontend_available'    => true,
            ]
        );

        $this->add_control(
            'adaptive_height',
            [
                'label'                 => esc_html__( 'Adaptive Height', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'              => esc_html__( 'Yes', 'gyan-elements' ),
                'label_off'             => esc_html__( 'No', 'gyan-elements' ),
                'return_value'          => 'yes',
                'frontend_available'    => true,
            ]
        );

        $this->add_control(
            'direction',
            [
                'label'                 => esc_html__( 'Direction', 'gyan-elements' ),
                'type'                  => Controls_Manager::CHOOSE,
                'label_block'           => false,
                'toggle'                => false,
                'options'               => [
                    'left' 	=> [
                        'title' 	=> esc_html__( 'Left', 'gyan-elements' ),
                        'icon' 		=> 'eicon-h-align-left',
                    ],
                    'right' 		=> [
                        'title' 	=> esc_html__( 'Right', 'gyan-elements' ),
                        'icon' 		=> 'eicon-h-align-right',
                    ],
                ],
                'default'               => 'left',
                'frontend_available'    => true,
                'condition'             => [
					'skin'			=> 'carousel',
                    'effect!'		=> 'fade',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_feature_image_style',
            [
                'label'                 => esc_html__( 'Feature Image', 'gyan-elements' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    'skin'     => 'slideshow',
                ],
            ]
        );

        $this->add_control(
			'feature_image_align',
			[
                'label'                 => esc_html__( 'Align', 'gyan-elements' ),
                'type'                  => Controls_Manager::CHOOSE,
                'label_block'           => false,
                'toggle'                => false,
                'default'               => 'left',
                'options'               => [
                    'left'          => [
                        'title'     => esc_html__( 'Left', 'gyan-elements' ),
                        'icon'      => 'eicon-h-align-left',
                    ],
                    'top'           => [
                        'title'     => esc_html__( 'Top', 'gyan-elements' ),
                        'icon'      => 'eicon-v-align-top',
                    ],
                    'right'         => [
                        'title'     => esc_html__( 'Right', 'gyan-elements' ),
                        'icon'      => 'eicon-h-align-right',
                    ],
                ],
                'prefix_class'          => 'gyan-image-slider-align-',
                'frontend_available'    => true,
                'condition'             => [
					'skin'     => 'slideshow',
				],
			]
		);

        $this->add_control(
            'feature_image_stack',
            [
                'label'                 => esc_html__( 'Stack On', 'gyan-elements' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => 'tablet',
                'options'               => [
                    'tablet' 	=> esc_html__( 'Tablet', 'gyan-elements' ),
                    'mobile' 	=> esc_html__( 'Mobile', 'gyan-elements' ),
                ],
                'prefix_class'          => 'gyan-image-slider-stack-',
                'condition'             => [
					'skin'                 => 'slideshow',
					'feature_image_align!' => 'top',
				],
            ]
        );

        $this->add_responsive_control(
            'feature_image_width',
            [
                'label'                 => esc_html__( 'Width', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'size_units'            => [ '%' ],
                'range'                 => [
                    '%' 	=> [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'               => [
                    'size' 	=> 70,
                ],
                'selectors'             => [
                    '{{WRAPPER}}.gyan-image-slider-align-left .gyan-image-slider-wrap' => 'width: {{SIZE}}%',
                    '{{WRAPPER}}.gyan-image-slider-align-right .gyan-image-slider-wrap' => 'width: {{SIZE}}%',
                    '{{WRAPPER}}.gyan-image-slider-align-right .gyan-image-slider-thumb-pagination' => 'width: calc(100% - {{SIZE}}%)',
                    '{{WRAPPER}}.gyan-image-slider-align-left .gyan-image-slider-thumb-pagination' => 'width: calc(100% - {{SIZE}}%)',
                ],
                'condition'             => [
                    'skin'     => 'slideshow',
                ],
            ]
        );

        $this->add_responsive_control(
            'feature_image_spacing',
            [
                'label'                 => esc_html__( 'Spacing', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' 	=> [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'default'               => [
                    'size' 	=> 20,
                ],
                'selectors'             => [
                    '{{WRAPPER}}.gyan-image-slider-align-left .gyan-image-slider-container,
                    {{WRAPPER}}.gyan-image-slider-align-right .gyan-image-slider-container' => 'margin-left: -{{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.gyan-image-slider-align-left .gyan-image-slider-container > *,
                    {{WRAPPER}}.gyan-image-slider-align-right .gyan-image-slider-container > *' => 'padding-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.gyan-image-slider-align-top .gyan-image-slider-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    '(tablet){{WRAPPER}}.gyan-image-slider-stack-tablet .gyan-image-slider-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    '(mobile){{WRAPPER}}.gyan-image-slider-stack-mobile .gyan-image-slider-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition'             => [
                    'skin'     => 'slideshow',
                ],
            ]
        );


        $this->add_control(
            'feature_image_border_radius_normal',
            [
                'label'                 => esc_html__( 'Border Radius', 'gyan-elements' ),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => [ 'px', '%' ],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-slider-slide .gyan-image-slider-image ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'feature_image_border',
				'label'                 => esc_html__( 'Border', 'gyan-elements' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .gyan-image-slider-slide .gyan-image-slider-image',
				'separator'             => 'before',
                'condition'             => [
                    'skin'     => 'slideshow',
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'feature_image_box_shadow',
				'selector'              => '{{WRAPPER}} .gyan-image-slider',
				'separator'             => 'before',
                'condition'             => [
                    'skin'     => 'slideshow',
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'                  => 'feature_image_css_filters',
				'selector'              => '{{WRAPPER}} .gyan-image-slider img',
                'condition'             => [
                    'skin'     => 'slideshow',
                ],
			]
		);

        $this->end_controls_section();


        $this->start_controls_section(
            'section_feature_image_captions_style',
            [
                'label'                 => esc_html__( 'Feature Image Captions', 'gyan-elements' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    'skin'                      => 'slideshow',
                    'feature_image_caption!'    => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'feature_image_captions_vertical_align',
            [
                'label'                 => esc_html__( 'Vertical Align', 'gyan-elements' ),
                'type'                  => Controls_Manager::CHOOSE,
                'options'               => [
                    'top' 	=> [
                        'title' 	=> esc_html__( 'Top', 'gyan-elements' ),
                        'icon' 		=> 'eicon-v-align-top',
                    ],
                    'middle' 		=> [
                        'title' 	=> esc_html__( 'Middle', 'gyan-elements' ),
                        'icon' 		=> 'eicon-v-align-middle',
                    ],
                    'bottom' 		=> [
                        'title' 	=> esc_html__( 'Bottom', 'gyan-elements' ),
                        'icon' 		=> 'eicon-v-align-bottom',
                    ],
                ],
                'default'               => 'bottom',
				'selectors' => [
					'{{WRAPPER}} .gyan-image-slider-slide .gyan-image-slider-content' => 'justify-content: {{VALUE}};',
				],
				'selectors_dictionary'  => [
					'top'      => 'flex-start',
					'bottom'   => 'flex-end',
					'middle'   => 'center',
				],
                'condition'             => [
                    'skin'                      => 'slideshow',
                    'feature_image_caption!'    => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'feature_image_captions_horizontal_align',
            [
                'label'                 => esc_html__( 'Horizontal Align', 'gyan-elements' ),
                'type'                  => Controls_Manager::CHOOSE,
                'options'               => [
                    'left' 	=> [
                        'title' 	=> esc_html__( 'Left', 'gyan-elements' ),
                        'icon' 		=> 'eicon-h-align-left',
                    ],
                    'center' 		=> [
                        'title' 	=> esc_html__( 'Center', 'gyan-elements' ),
                        'icon' 		=> 'eicon-h-align-center',
                    ],
                    'right' 		=> [
                        'title' 	=> esc_html__( 'Right', 'gyan-elements' ),
                        'icon' 		=> 'eicon-h-align-right',
                    ],
                    'justify' 		=> [
                        'title' 	=> esc_html__( 'Justify', 'gyan-elements' ),
                        'icon' 		=> 'eicon-h-align-stretch',
                    ],
                ],
                'default'               => 'left',
				'selectors' => [
					'{{WRAPPER}} .gyan-image-slider-slide .gyan-image-slider-content' => 'align-items: {{VALUE}};',
				],
				'selectors_dictionary'  => [
					'left'     => 'flex-start',
					'right'    => 'flex-end',
					'center'   => 'center',
					'justify'  => 'stretch',
				],
                'condition'             => [
                    'skin'                      => 'slideshow',
                    'feature_image_caption!'    => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'feature_image_captions_align',
            [
                'label'                 => esc_html__( 'Text Align', 'gyan-elements' ),
                'type'                  => Controls_Manager::CHOOSE,
                'options'               => [
                    'left' 	=> [
                        'title' 	=> esc_html__( 'Left', 'gyan-elements' ),
                        'icon' 		=> 'fa fa-align-left',
                    ],
                    'center' 		=> [
                        'title' 	=> esc_html__( 'Center', 'gyan-elements' ),
                        'icon' 		=> 'fa fa-align-center',
                    ],
                    'right' 		=> [
                        'title' 	=> esc_html__( 'Right', 'gyan-elements' ),
                        'icon' 		=> 'fa fa-align-right',
                    ],
                ],
                'default'               => 'center',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-slider-slide .gyan-image-slider-caption' => 'text-align: {{VALUE}};',
                ],
                'condition'             => [
                    'skin'                                      => 'slideshow',
                    'feature_image_captions_horizontal_align'   => 'justify',
                    'feature_image_caption!'                    => '',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'feature_image_captions_typography',
                'label'                 => esc_html__( 'Typography', 'gyan-elements' ),
                'selector'              => '{{WRAPPER}} .gyan-image-slider-slide .gyan-image-slider-caption',
                'condition'             => [
                    'skin'                      => 'slideshow',
                    'feature_image_caption!'    => '',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_feature_image_captions_style' );

        $this->start_controls_tab(
            'tab_feature_image_captions_normal',
            [
                'label'                 => esc_html__( 'Normal', 'gyan-elements' ),
                'condition'             => [
                    'skin'                      => 'slideshow',
                    'feature_image_caption!'    => '',
                ],
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'                  => 'feature_image_captions_background',
				'types'            	    => [ 'classic','gradient' ],
				'selector'              => '{{WRAPPER}} .gyan-image-slider-slide .gyan-image-slider-caption',
                'exclude'               => [
                    'image',
                ],
                'condition'             => [
                    'skin'                      => 'slideshow',
                    'feature_image_caption!'    => '',
                ],
			]
		);

        $this->add_control(
            'feature_image_captions_text_color',
            [
                'label'                 => esc_html__( 'Text Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-slider-slide .gyan-image-slider-caption' => 'color: {{VALUE}}',
                ],
                'condition'             => [
                    'skin'                      => 'slideshow',
                    'feature_image_caption!'    => '',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'feature_image_captions_border_normal',
				'label'                 => esc_html__( 'Border', 'gyan-elements' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .gyan-image-slider-slide .gyan-image-slider-caption',
                'condition'             => [
                    'skin'                      => 'slideshow',
                    'feature_image_caption!'    => '',
                ],
			]
		);

		$this->add_control(
			'feature_image_captions_border_radius_normal',
			[
				'label'                 => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .gyan-image-slider-slide .gyan-image-slider-caption' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'condition'             => [
                    'skin'                      => 'slideshow',
                    'feature_image_caption!'    => '',
                ],
			]
		);

		$this->add_responsive_control(
			'feature_image_captions_margin',
			[
				'label'                 => esc_html__( 'Margin', 'gyan-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .gyan-image-slider-slide .gyan-image-slider-caption' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'condition'             => [
                    'skin'                      => 'slideshow',
                    'feature_image_caption!'    => '',
                ],
			]
		);

		$this->add_responsive_control(
			'feature_image_captions_padding',
			[
				'label'                 => esc_html__( 'Padding', 'gyan-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .gyan-image-slider-slide .gyan-image-slider-caption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'condition'             => [
                    'skin'                      => 'slideshow',
                    'feature_image_caption!'    => '',
                ],
			]
		);

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'                  => 'feature_image_text_shadow',
                'selector' 	            => '{{WRAPPER}} .gyan-image-slider-slide .gyan-image-slider-caption',
                'condition'             => [
                    'skin'                      => 'slideshow',
                    'feature_image_caption!'    => '',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_feature_image_captions_hover',
            [
                'label'                 => esc_html__( 'Hover', 'gyan-elements' ),
                'condition'             => [
                    'skin'                      => 'slideshow',
                    'feature_image_caption!'    => '',
                ],
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'                  => 'feature_image_captions_background_hover',
				'types'            	    => [ 'classic','gradient' ],
				'selector'              => '{{WRAPPER}} .gyan-image-slider-slide:hover .gyan-image-slider-caption',
                'exclude'               => [
                    'image',
                ],
                'condition'             => [
                    'skin'                      => 'slideshow',
                    'feature_image_caption!'    => '',
                ],
			]
		);

        $this->add_control(
            'feature_image_captions_text_color_hover',
            [
                'label'                 => esc_html__( 'Text Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-slider-slide:hover .gyan-image-slider-caption' => 'color: {{VALUE}}',
                ],
                'condition'             => [
                    'skin'                      => 'slideshow',
                    'feature_image_caption!'    => '',
                ],
            ]
        );

        $this->add_control(
            'feature_image_captions_border_color_hover',
            [
                'label'                 => esc_html__( 'Border Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-slider-slide:hover .gyan-image-slider-caption' => 'border-color: {{VALUE}}',
                ],
                'condition'             => [
                    'skin'                      => 'slideshow',
                    'feature_image_caption!'    => '',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'                  => 'feature_image_text_shadow_hover',
                'selector' 	            => '{{WRAPPER}} .gyan-image-slider-slide:hover .gyan-image-slider-caption',
                'condition'             => [
                    'skin'                      => 'slideshow',
                    'feature_image_caption!'    => '',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
			'feature_image_captions_blend_mode',
			[
				'label'                 => esc_html__( 'Blend Mode', 'gyan-elements' ),
				'type'                  => Controls_Manager::SELECT,
				'options'               => [
					''             => esc_html__( 'Normal', 'gyan-elements' ),
					'multiply'     => 'Multiply',
					'screen'       => 'Screen',
					'overlay'      => 'Overlay',
					'darken'       => 'Darken',
					'lighten'      => 'Lighten',
					'color-dodge'  => 'Color Dodge',
					'saturation'   => 'Saturation',
					'color'        => 'Color',
					'difference'   => 'Difference',
					'exclusion'    => 'Exclusion',
					'hue'          => 'Hue',
					'luminosity'   => 'Luminosity',
				],
				'selectors'             => [
					'{{WRAPPER}} .gyan-image-slider-slide .gyan-image-slider-caption' => 'mix-blend-mode: {{VALUE}}',
				],
				'separator'             => 'before',
                'condition'             => [
                    'skin'                      => 'slideshow',
                    'feature_image_caption!'    => '',
                ],
			]
		);

        $this->end_controls_section();

        /**
         * Style Tab: Thumbnails
         */
        $this->start_controls_section(
            'section_thumbnails_style',
            [
                'label'                 => esc_html__( 'Thumbnails', 'gyan-elements' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'thumbnails_alignment',
            [
                'label'                 => esc_html__( 'Alignment', 'gyan-elements' ),
                'type'                  => Controls_Manager::CHOOSE,
                'options'               => [
                    'left' 	=> [
                        'title' 	=> esc_html__( 'Left', 'gyan-elements' ),
                        'icon' 		=> 'eicon-h-align-left',
                    ],
                    'center' 		=> [
                        'title' 	=> esc_html__( 'Center', 'gyan-elements' ),
                        'icon' 		=> 'eicon-h-align-center',
                    ],
                    'right' 		=> [
                        'title' 	=> esc_html__( 'Right', 'gyan-elements' ),
                        'icon' 		=> 'eicon-h-align-right',
                    ],
                ],
                'default'               => 'left',
				'selectors' => [
					'{{WRAPPER}} .gyan-image-slider-thumb-pagination' => 'justify-content: {{VALUE}};',
				],
				'selectors_dictionary'  => [
					'left'     => 'flex-start',
					'right'    => 'flex-end',
					'center'   => 'center',
				],
                'condition'             => [
                    'skin'     => 'slideshow',
                ],
            ]
        );

        $this->add_control(
            'thumbnail_images_heading',
            [
                'label'                 => esc_html__( 'Images', 'gyan-elements' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
            ]
        );

        $this->add_responsive_control(
            'thumbnails_horizontal_spacing',
            [
                'label'                 => esc_html__( 'Column Spacing', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' 	=> [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'default'               => [
                    'size' 	=> '',
                ],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-slider-thumb-item-wrap,
                    {{WRAPPER}}.gyan-image-slider-carousel .gyan-image-slider-slide' => 'padding-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.gyan-image-slider-align-top .gyan-image-slider-thumb-pagination'  => 'width: calc(100% + {{SIZE}}{{UNIT}});',
                    '{{WRAPPER}} .gyan-image-slider-thumb-pagination,
                    {{WRAPPER}}.gyan-image-slider-carousel .slick-list'  => 'margin-left: -{{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'thumbnails_vertical_spacing',
            [
                'label'                 => esc_html__( 'Row Spacing', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' 	=> [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'default'               => [
                    'size' 	=> '',
                ],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-slider-thumb-item-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition'             => [
					'skin'     => 'slideshow',
				],
            ]
        );

        $this->start_controls_tabs( 'tabs_thumbnails_style' );

        $this->start_controls_tab(
            'tab_thumbnails_normal',
            [
                'label'                 => esc_html__( 'Normal', 'gyan-elements' ),
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'thumbnails_border',
				'label'                 => esc_html__( 'Border', 'gyan-elements' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .gyan-image-slider-thumb-item',
			]
		);

		$this->add_control(
			'thumbnails_border_radius',
			[
				'label'                 => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .gyan-image-slider-thumb-item,{{WRAPPER}} .gyan-image-slider-thumb-item img,{{WRAPPER}} .gyan-image-slider-thumb-overlay' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
            'thumbnails_scale',
            [
                'label'                 => esc_html__( 'Scale', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px'        => [
                        'min'   => 1,
                        'max'   => 2,
                        'step'  => 0.01,
                    ],
                ],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-slider-thumb-image img' => 'transform: scale({{SIZE}});',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'thumbnails_box_shadow',
				'selector'              => '{{WRAPPER}} .gyan-image-slider-thumb-item',
				'condition'             => [
					'skin'     => 'slideshow',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'                  => 'thumbnails_css_filters',
				'selector'              => '{{WRAPPER}} .gyan-image-slider-thumb-image img',
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_thumbnails_hover',
            [
                'label'                 => esc_html__( 'Hover', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'thumbnails_border_color_hover',
            [
                'label'                 => esc_html__( 'Border Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-slider-thumb-item:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'thumbnails_scale_hover',
            [
                'label'                 => esc_html__( 'Scale', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px'        => [
                        'min'   => 1,
                        'max'   => 2,
                        'step'  => 0.01,
                    ],
                ],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-slider-thumb-item:hover .gyan-image-slider-thumb-image img' => 'transform: scale({{SIZE}});',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'thumbnails_box_shadow_hover',
				'selector'              => '{{WRAPPER}} .gyan-image-slider-thumb-item:hover',
				'condition'             => [
					'skin'     => 'slideshow',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'                  => 'thumbnails_css_filters_hover',
				'selector'              => '{{WRAPPER}} .gyan-image-slider-thumb-item:hover .gyan-image-slider-thumb-image img',
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_thumbnails_active',
            [
                'label'                 => esc_html__( 'Active', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'thumbnails_border_color_active',
            [
                'label'                 => esc_html__( 'Border Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-active-slide .gyan-image-slider-thumb-item' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'thumbnails_scale_active',
            [
                'label'                 => esc_html__( 'Scale', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px'        => [
                        'min'   => 1,
                        'max'   => 2,
                        'step'  => 0.01,
                    ],
                ],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-active-slide .gyan-image-slider-thumb-image img' => 'transform: scale({{SIZE}});',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'thumbnails_box_shadow_active',
				'selector'              => '{{WRAPPER}} .gyan-active-slide .gyan-image-slider-thumb-item',
				'condition'             => [
					'skin'     => 'slideshow',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'                  => 'thumbnails_css_filters_active',
				'selector'              => '{{WRAPPER}} .gyan-active-slide .gyan-image-slider-thumb-image img',
			]
		);

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'thumbnail_overlay_heading',
            [
                'label'                 => esc_html__( 'Overlay', 'gyan-elements' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
            ]
        );

        $this->start_controls_tabs( 'tabs_thumbnails_overlay_style' );

        $this->start_controls_tab(
            'tab_thumbnails_overlay_normal',
            [
                'label'                 => esc_html__( 'Normal', 'gyan-elements' ),
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'                  => 'thumbnails_overlay_background',
				'types'            	    => [ 'classic','gradient' ],
				'selector'              => '{{WRAPPER}} .gyan-image-slider-thumb-overlay',
                'exclude'               => [
                    'image',
                ],
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_thumbnails_overlay_hover',
            [
                'label'                 => esc_html__( 'Hover', 'gyan-elements' ),
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'                  => 'thumbnails_overlay_background_hover',
				'types'            	    => [ 'classic','gradient' ],
				'selector'              => '{{WRAPPER}} .gyan-image-slider-thumb-item:hover .gyan-image-slider-thumb-overlay',
                'exclude'               => [
                    'image',
                ],
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_thumbnails_overlay_active',
            [
                'label'                 => esc_html__( 'Active', 'gyan-elements' ),
                'condition'             => [
                    'skin'  => 'slideshow',
                ],
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'                  => 'thumbnails_overlay_background_active',
				'types'            	    => [ 'classic','gradient' ],
				'selector'              => '{{WRAPPER}} .gyan-active-slide .gyan-image-slider-thumb-overlay',
                'exclude'               => [
                    'image',
                ],
                'condition'             => [
                    'skin'  => 'slideshow',
                ],
			]
		);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
			'feature_image_overlay_blend_mode',
			[
				'label'                 => esc_html__( 'Blend Mode', 'gyan-elements' ),
				'type'                  => Controls_Manager::SELECT,
				'options'               => [
					''             => esc_html__( 'Normal', 'gyan-elements' ),
					'multiply'     => 'Multiply',
					'screen'       => 'Screen',
					'overlay'      => 'Overlay',
					'darken'       => 'Darken',
					'lighten'      => 'Lighten',
					'color-dodge'  => 'Color Dodge',
					'saturation'   => 'Saturation',
					'color'        => 'Color',
					'difference'   => 'Difference',
					'exclusion'    => 'Exclusion',
					'hue'          => 'Hue',
					'luminosity'   => 'Luminosity',
				],
				'selectors'             => [
					'{{WRAPPER}} .gyan-image-slider-thumb-overlay' => 'mix-blend-mode: {{VALUE}}',
				],
			]
		);

        $this->end_controls_section();


        $this->start_controls_section(
            'section_thumbnails_captions_style',
            [
                'label'                 => esc_html__( 'Thumbnails Captions', 'gyan-elements' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    'thumbnails_caption!'   => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'thumbnails_captions_vertical_align',
            [
                'label'                 => esc_html__( 'Vertical Align', 'gyan-elements' ),
                'type'                  => Controls_Manager::CHOOSE,
                'options'               => [
                    'top' 	=> [
                        'title' 	=> esc_html__( 'Top', 'gyan-elements' ),
                        'icon' 		=> 'eicon-v-align-top',
                    ],
                    'middle' 		=> [
                        'title' 	=> esc_html__( 'Middle', 'gyan-elements' ),
                        'icon' 		=> 'eicon-v-align-middle',
                    ],
                    'bottom' 		=> [
                        'title' 	=> esc_html__( 'Bottom', 'gyan-elements' ),
                        'icon' 		=> 'eicon-v-align-bottom',
                    ],
                ],
                'default'               => 'bottom',
				'selectors' => [
					'{{WRAPPER}} .gyan-image-slider-thumb-item-wrap .gyan-image-slider-content' => 'justify-content: {{VALUE}};',
				],
				'selectors_dictionary'  => [
					'top'      => 'flex-start',
					'bottom'   => 'flex-end',
					'middle'   => 'center',
				],
                'condition'             => [
                    'thumbnails_caption!'   => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'thumbnails_captions_horizontal_align',
            [
                'label'                 => esc_html__( 'Horizontal Align', 'gyan-elements' ),
                'type'                  => Controls_Manager::CHOOSE,
                'options'               => [
                    'left' 	=> [
                        'title' 	=> esc_html__( 'Left', 'gyan-elements' ),
                        'icon' 		=> 'eicon-h-align-left',
                    ],
                    'center' 		=> [
                        'title' 	=> esc_html__( 'Center', 'gyan-elements' ),
                        'icon' 		=> 'eicon-h-align-center',
                    ],
                    'right' 		=> [
                        'title' 	=> esc_html__( 'Right', 'gyan-elements' ),
                        'icon' 		=> 'eicon-h-align-right',
                    ],
                    'justify' 		=> [
                        'title' 	=> esc_html__( 'Justify', 'gyan-elements' ),
                        'icon' 		=> 'eicon-h-align-stretch',
                    ],
                ],
                'default'               => 'left',
				'selectors' => [
					'{{WRAPPER}} .gyan-image-slider-thumb-item-wrap .gyan-image-slider-content' => 'align-items: {{VALUE}};',
				],
				'selectors_dictionary'  => [
					'left'     => 'flex-start',
					'right'    => 'flex-end',
					'center'   => 'center',
					'justify'  => 'stretch',
				],
                'condition'             => [
                    'thumbnails_caption!'   => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'thumbnails_captions_align',
            [
                'label'                 => esc_html__( 'Text Align', 'gyan-elements' ),
                'type'                  => Controls_Manager::CHOOSE,
                'options'               => [
                    'left' 	=> [
                        'title' 	=> esc_html__( 'Left', 'gyan-elements' ),
                        'icon' 		=> 'fa fa-align-left',
                    ],
                    'center' 		=> [
                        'title' 	=> esc_html__( 'Center', 'gyan-elements' ),
                        'icon' 		=> 'fa fa-align-center',
                    ],
                    'right' 		=> [
                        'title' 	=> esc_html__( 'Right', 'gyan-elements' ),
                        'icon' 		=> 'fa fa-align-right',
                    ],
                ],
                'default'               => 'center',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-slider-thumb-item-wrap .gyan-image-slider-caption' => 'text-align: {{VALUE}};',
                ],
                'condition'             => [
                    'thumbnails_captions_horizontal_align'  => 'justify',
                    'thumbnails_caption!'                   => '',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'thumbnails_captions_typography',
                'label'                 => esc_html__( 'Typography', 'gyan-elements' ),
                'selector'              => '{{WRAPPER}} .gyan-image-slider-thumb-item-wrap .gyan-image-slider-caption',
                'condition'             => [
                    'thumbnails_caption!'   => '',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_thumbnails_captions_style' );

        $this->start_controls_tab(
            'tab_thumbnails_captions_normal',
            [
                'label'                 => esc_html__( 'Normal', 'gyan-elements' ),
                'condition'             => [
                    'thumbnails_caption!'   => '',
                ],
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'                  => 'thumbnails_captions_background',
				'types'            	    => [ 'classic','gradient' ],
				'selector'              => '{{WRAPPER}} .gyan-image-slider-thumb-item-wrap .gyan-image-slider-caption',
                'exclude'               => [
                    'image',
                ],
                'condition'             => [
                    'thumbnails_caption!'   => '',
                ],
			]
		);

        $this->add_control(
            'thumbnails_captions_text_color',
            [
                'label'                 => esc_html__( 'Text Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-slider-thumb-item-wrap .gyan-image-slider-caption' => 'color: {{VALUE}}',
                ],
                'condition'             => [
                    'thumbnails_caption!'   => '',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'thumbnails_captions_border_normal',
				'label'                 => esc_html__( 'Border', 'gyan-elements' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .gyan-image-slider-thumb-item-wrap .gyan-image-slider-caption',
                'condition'             => [
                    'thumbnails_caption!'   => '',
                ],
			]
		);

		$this->add_control(
			'thumbnails_captions_border_radius_normal',
			[
				'label'                 => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .gyan-image-slider-thumb-item-wrap .gyan-image-slider-caption' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'condition'             => [
                    'thumbnails_caption!'   => '',
                ],
			]
		);

		$this->add_responsive_control(
			'thumbnails_captions_margin',
			[
				'label'                 => esc_html__( 'Margin', 'gyan-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .gyan-image-slider-thumb-item-wrap .gyan-image-slider-caption' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'condition'             => [
                    'thumbnails_caption!'   => '',
                ],
			]
		);

		$this->add_responsive_control(
			'thumbnails_captions_padding',
			[
				'label'                 => esc_html__( 'Padding', 'gyan-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .gyan-image-slider-thumb-item-wrap .gyan-image-slider-caption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'condition'             => [
                    'thumbnails_caption!'   => '',
                ],
			]
		);

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'                  => 'thumbnails_text_shadow',
                'selector' 	            => '{{WRAPPER}} .gyan-image-slider-thumb-item-wrap .gyan-image-slider-caption',
                'condition'             => [
                    'thumbnails_caption!'   => '',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_thumbnails_captions_hover',
            [
                'label'                 => esc_html__( 'Hover', 'gyan-elements' ),
                'condition'             => [
                    'thumbnails_caption!'   => '',
                ],
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'                  => 'thumbnails_captions_background_hover',
				'types'            	    => [ 'classic','gradient' ],
				'selector'              => '{{WRAPPER}} .gyan-image-slider-thumb-item-wrap:hover .gyan-image-slider-caption',
                'exclude'               => [
                    'image',
                ],
                'condition'             => [
                    'thumbnails_caption!'   => '',
                ],
			]
		);

        $this->add_control(
            'thumbnails_captions_text_color_hover',
            [
                'label'                 => esc_html__( 'Text Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-slider-thumb-item-wrap:hover .gyan-image-slider-caption' => 'color: {{VALUE}}',
                ],
                'condition'             => [
                    'thumbnails_caption!'   => '',
                ],
            ]
        );

        $this->add_control(
            'thumbnails_captions_border_color_hover',
            [
                'label'                 => esc_html__( 'Border Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-slider-thumb-item-wrap:hover .gyan-image-slider-caption' => 'border-color: {{VALUE}}',
                ],
                'condition'             => [
                    'thumbnails_caption!'   => '',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'                  => 'thumbnails_text_shadow_hover',
                'selector' 	            => '{{WRAPPER}} .gyan-image-slider-thumb-item-wrap:hover .gyan-image-slider-caption',
                'condition'             => [
                    'thumbnails_caption!'   => '',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
			'thumbnails_captions_blend_mode',
			[
				'label'                 => esc_html__( 'Blend Mode', 'gyan-elements' ),
				'type'                  => Controls_Manager::SELECT,
				'options'               => [
					''             => esc_html__( 'Normal', 'gyan-elements' ),
					'multiply'     => 'Multiply',
					'screen'       => 'Screen',
					'overlay'      => 'Overlay',
					'darken'       => 'Darken',
					'lighten'      => 'Lighten',
					'color-dodge'  => 'Color Dodge',
					'saturation'   => 'Saturation',
					'color'        => 'Color',
					'difference'   => 'Difference',
					'exclusion'    => 'Exclusion',
					'hue'          => 'Hue',
					'luminosity'   => 'Luminosity',
				],
				'selectors'             => [
					'{{WRAPPER}} .gyan-image-slider-thumb-item-wrap .gyan-image-slider-caption' => 'mix-blend-mode: {{VALUE}}',
				],
				'separator'             => 'before',
                'condition'             => [
                    'thumbnails_caption!'   => '',
                ],
			]
		);

        $this->end_controls_section();

        /**
         * Style Tab: Arrows
         */
        $this->start_controls_section(
            'section_arrows_style',
            [
                'label'                 => esc_html__( 'Arrows', 'gyan-elements' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    'arrows'        => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_size',
            [
                'label'                 => esc_html__( 'Arrows Size', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [ 'size' => '22' ],
                'range'                 => [
                    'px' => [
                        'min'   => 15,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px' ],
				'selectors'             => [
					'{{WRAPPER}} .gyan-image-slider-arrow' => 'font-size: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				],
                'condition'             => [
                    'arrows'        => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_position',
            [
                'label'                 => esc_html__( 'Align Arrows', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => -100,
                        'max'   => 50,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px' ],
				'selectors'         => [
					'{{WRAPPER}} .gyan-image-slider-arrow-next' => 'right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .gyan-image-slider-arrow-prev' => 'left: {{SIZE}}{{UNIT}};',
				],
                'condition'             => [
                    'arrows'        => 'yes',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_arrows_style' );

        $this->start_controls_tab(
            'tab_arrows_normal',
            [
                'label'                 => esc_html__( 'Normal', 'gyan-elements' ),
                'condition'             => [
                    'arrows'        => 'yes',
                ],
            ]
        );

        $this->add_control(
            'arrows_bg_color_normal',
            [
                'label'                 => esc_html__( 'Background Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-slider-arrow' => 'background-color: {{VALUE}};',
                ],
                'condition'             => [
                    'arrows'        => 'yes',
                ],
            ]
        );

        $this->add_control(
            'arrows_color_normal',
            [
                'label'                 => esc_html__( 'Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-slider-arrow' => 'color: {{VALUE}};',
                ],
                'condition'             => [
                    'arrows'        => 'yes',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'arrows_border_normal',
				'label'                 => esc_html__( 'Border', 'gyan-elements' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .gyan-image-slider-arrow',
                'condition'             => [
                    'arrows'        => 'yes',
                ],
			]
		);

		$this->add_control(
			'arrows_border_radius_normal',
			[
				'label'                 => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .gyan-image-slider-arrow' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'condition'             => [
                    'arrows'        => 'yes',
                ],
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_arrows_hover',
            [
                'label'                 => esc_html__( 'Hover', 'gyan-elements' ),
                'condition'             => [
                    'arrows'        => 'yes',
                ],
            ]
        );

        $this->add_control(
            'arrows_bg_color_hover',
            [
                'label'                 => esc_html__( 'Background Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-slider-arrow:hover' => 'background-color: {{VALUE}};',
                ],
                'condition'             => [
                    'arrows'        => 'yes',
                ],
            ]
        );

        $this->add_control(
            'arrows_color_hover',
            [
                'label'                 => esc_html__( 'Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-slider-arrow:hover' => 'color: {{VALUE}};',
                ],
                'condition'             => [
                    'arrows'        => 'yes',
                ],
            ]
        );

        $this->add_control(
            'arrows_border_color_hover',
            [
                'label'                 => esc_html__( 'Border Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-slider-arrow:hover',
                ],
                'condition'             => [
                    'arrows'        => 'yes',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

		$this->add_responsive_control(
			'arrows_padding',
			[
				'label'                 => esc_html__( 'Padding', 'gyan-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .gyan-image-slider-arrow' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'separator'             => 'before',
                'condition'             => [
                    'arrows'        => 'yes',
                ],
			]
		);

        $this->end_controls_section();


        $this->start_controls_section(
            'section_dots_style',
            [
                'label'                 => esc_html__( 'Dots', 'gyan-elements' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    'dots'      => 'yes',
                ],
            ]
        );

        $this->add_control(
            'dots_position',
            [
                'label'                 => esc_html__( 'Position', 'gyan-elements' ),
                'type'                  => Controls_Manager::SELECT,
                'options'               => [
                   'inside'     => esc_html__( 'Inside', 'gyan-elements' ),
                   'outside'    => esc_html__( 'Outside', 'gyan-elements' ),
                ],
                'default'               => 'outside',
				'prefix_class'          => 'gyan-image-slider-dots-',
                'condition'             => [
                    'dots'      => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_size',
            [
                'label'                 => esc_html__( 'Size', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 2,
                        'max'   => 40,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => '',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-slider .slick-dots li button' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
                'condition'             => [
                    'dots'      => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_spacing',
            [
                'label'                 => esc_html__( 'Spacing', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 1,
                        'max'   => 30,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => '',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-slider .slick-dots li' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}}',
                ],
                'condition'             => [
                    'dots'      => 'yes',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_dots_style' );

        $this->start_controls_tab(
            'tab_dots_normal',
            [
                'label'                 => esc_html__( 'Normal', 'gyan-elements' ),
                'condition'             => [
                    'dots'      => 'yes',
                ],
            ]
        );

        $this->add_control(
            'dots_color_normal',
            [
                'label'                 => esc_html__( 'Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-slider .slick-dots li' => 'background: {{VALUE}};',
                ],
                'condition'             => [
                    'dots'      => 'yes',
                ],
            ]
        );

        $this->add_control(
            'active_dot_color_normal',
            [
                'label'                 => esc_html__( 'Active Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-slider .slick-dots li.slick-active' => 'background: {{VALUE}};',
                ],
                'condition'             => [
                    'dots'      => 'yes',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'dots_border_normal',
				'label'                 => esc_html__( 'Border', 'gyan-elements' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .gyan-image-slider .slick-dots li',
                'condition'             => [
                    'dots'      => 'yes',
                ],
			]
		);

		$this->add_control(
			'dots_border_radius_normal',
			[
				'label'                 => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .gyan-image-slider .slick-dots li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'condition'             => [
                    'dots'      => 'yes',
                ],
			]
		);

		$this->add_responsive_control(
			'dots_margin',
			[
				'label'                 => esc_html__( 'Margin', 'gyan-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
                'allowed_dimensions'    => 'vertical',
				'placeholder'           => [
					'top'      => '',
					'right'    => 'auto',
					'bottom'   => '',
					'left'     => 'auto',
				],
				'selectors'             => [
					'{{WRAPPER}} .gyan-image-slider .slick-dots' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'condition'             => [
                    'dots'      => 'yes',
                ],
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_dots_hover',
            [
                'label'                 => esc_html__( 'Hover', 'gyan-elements' ),
                'condition'             => [
                    'dots'      => 'yes',
                ],
            ]
        );

        $this->add_control(
            'dots_color_hover',
            [
                'label'                 => esc_html__( 'Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-slider .slick-dots li:hover' => 'background: {{VALUE}};',
                ],
                'condition'             => [
                    'dots'      => 'yes',
                ],
            ]
        );

        $this->add_control(
            'dots_border_color_hover',
            [
                'label'                 => esc_html__( 'Border Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-slider .slick-dots li:hover' => 'border-color: {{VALUE}};',
                ],
                'condition'             => [
                    'dots'      => 'yes',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

	public function slider_settings() {
        $settings = $this->get_settings();

        if ( $settings['effect'] == 'slide' && $settings['skin'] != 'slideshow'  ) {
            $slides_to_show = ( $settings['slides_per_view'] !== '' ) ? absint( $settings['slides_per_view'] ) : 3;
            $slides_to_show_tablet = ( $settings['slides_per_view_tablet'] !== '' ) ? absint( $settings['slides_per_view_tablet'] ) : 2;
            $slides_to_show_mobile = ( $settings['slides_per_view_mobile'] !== '' ) ? absint( $settings['slides_per_view_mobile'] ) : 2;
            $slides_to_scroll = ( $settings['slides_to_scroll'] !== '' ) ? absint( $settings['slides_to_scroll'] ) : 1;
            $slides_to_scroll_tablet = ( $settings['slides_to_scroll_tablet'] !== '' ) ? absint( $settings['slides_to_scroll_tablet'] ) : 1;
            $slides_to_scroll_mobile = ( $settings['slides_to_scroll_mobile'] !== '' ) ? absint( $settings['slides_to_scroll_mobile'] ) : 1;
        } else {
            $slides_to_show = 1;
            $slides_to_show_tablet = 1;
            $slides_to_show_mobile = 1;
            $slides_to_scroll = 1;
            $slides_to_scroll_tablet = 1;
            $slides_to_scroll_mobile = 1;
        }

        $slider_options = [
            'slidesToShow'           => $slides_to_show,
            'slidesToScroll'         => $slides_to_scroll,
            'autoplay'               => ( $settings['autoplay'] === 'yes' ),
            'autoplaySpeed'          => ( $settings['autoplay_speed'] !== '' ) ? $settings['autoplay_speed'] : 3000,
            'arrows'                 => ( $settings['arrows'] === 'yes' ),
            'dots'                   => ( $settings['dots'] === 'yes' ),
            'fade'                   => ( $settings['effect'] === 'fade' ),
            'speed'                  => ( $settings['animation_speed'] !== '' ) ? $settings['animation_speed'] : 600,
            'infinite'               => ( $settings['infinite_loop'] === 'yes' ),
            'pauseOnHover'           => ( $settings['pause_on_hover'] === 'yes' ),
            'adaptiveHeight'         => ( $settings['adaptive_height'] === 'yes' ),
        ];

        if ( $settings['skin'] === 'carousel' && $settings['direction'] === 'right' || is_rtl() ) {
			$slider_options['rtl'] = true;
		}

        if ( $settings['arrows'] == 'yes' ) {

            $arrow_hover_onoff = ( $settings['arrows_on_hover'] == 'yes' ) ? 'gyan-image-slider-arrow-hover-on' : '';


            $slider_options['prevArrow'] = '<div class="gyan-image-slider-arrow gyan-image-slider-arrow-prev gyan-ease-transition ' . $arrow_hover_onoff . '"><i class="fas fa-angle-left"></i></div>';
            $slider_options['nextArrow'] = '<div class="gyan-image-slider-arrow gyan-image-slider-arrow-next gyan-ease-transition ' . $arrow_hover_onoff . '"><i class="fas fa-angle-right"></i></div>';
        }

        $slider_options['responsive'] = [
            [
                'breakpoint' => 1024,
                'settings' => [
                    'slidesToShow'      => $slides_to_show_tablet,
                    'slidesToScroll'    => $slides_to_scroll_tablet,
                ],
            ],
            [
                'breakpoint' => 768,
                'settings' => [
                    'slidesToShow'      => $slides_to_show_mobile,
                    'slidesToScroll'    => $slides_to_scroll_mobile,
                ]
            ]
        ];

        $this->add_render_attribute(
            'slider',
            [
                'data-slider-settings' => wp_json_encode( $slider_options ),
            ]
        );
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'slider-wrap', 'class', 'gyan-image-slider-wrap' );

        $this->add_render_attribute( 'slider', [
            'class' => 'gyan-image-slider',
            'id'    => 'gyan-image-slider-'.esc_attr( $this->get_id() )
        ] );

        if ( $settings['skin'] === 'carousel' && $settings['direction'] === 'right' || is_rtl() ) {
            $this->add_render_attribute( 'slider', 'dir', 'rtl' );
        }

        $this->slider_settings();
        ?>
        <div class="gyan-image-slider-container">
            <div <?php echo $this->get_render_attribute_string( 'slider-wrap' ); ?>>
                <div <?php echo $this->get_render_attribute_string( 'slider' ); ?>>
                    <?php
                        if ( $settings['skin'] == 'slideshow' ) {
                            $this->render_slideshow();
                        } else {
                            $this->render_carousel();
                        }
                    ?>
                </div>
            </div>
            <?php
                if ( $settings['skin'] == 'slideshow' ) {
                    // Slideshow Thumbnails
                    $this->render_thumbnails();
                }
            ?>
        </div>
        <?php
    }

    protected function render_slideshow() {
        $settings = $this->get_settings_for_display();
		$gallery = $settings['gallery_images'];

        foreach ( $gallery as $index => $item ) {
            ?>
            <div class="gyan-image-slider-slide">
                <?php
                    // responsive image
                    if (  $settings['image_size'] == 'full' ) {
                        $imageTagHtml = wp_get_attachment_image( $item['id'], 'full', "", ["class" => "gyan-image-slider-image", "alt" => esc_attr( Control_Media::get_image_alt( $item ) )]);
                    } else {
                        $imgUrl = Group_Control_Image_Size::get_attachment_image_src( $item['id'], 'image', $settings );
                        if ( ! $imgUrl ) {
                            $imgUrl = $item['id']['url'];
                        }
                        $imageTagHtml = '<img class="gyan-ease-transition" src="'.esc_url($imgUrl).'" alt="' . esc_attr( Control_Media::get_image_alt( $item ) ) . '" />';
                    }

                    $image_html = '<div class="gyan-image-slider-image-wrap">';
                    $image_html .= $imageTagHtml;
                    $image_html .= '</div>';

                    $caption = '';
                    $caption_rendered = '';

                    if ( $settings['feature_image_caption'] != '' ) {
                        $caption_rendered = $this->render_image_caption( $item['id'], $settings['feature_image_caption'] );
                        $image_html .= '<div class="gyan-image-slider-content">';
                            $image_html .= $caption_rendered;
                        $image_html .= '</div>';
                    }

                    if ( $settings['link_to'] != 'none' ) {

                        $image_html = $this->get_slide_link_atts('slideshow', $index, $item, $image_html, $caption);

                    }

                    echo $image_html;
                ?>
            </div>
            <?php
        }
    }

    protected function render_thumbnails() {
        $settings = $this->get_settings_for_display();
		$gallery = $settings['gallery_images'];
        ?>
        <div class="gyan-image-slider-thumb-pagination gyan-elementor-grid">
            <?php
                foreach ( $gallery as $index => $item ) {
                    // responsive image
                    if (  $settings['thumbnail_size'] == 'full' ) {
                        $imageTagHtml = wp_get_attachment_image( $item['id'], 'full', "", ["alt" => esc_attr( Control_Media::get_image_alt( $item ) )]);
                    } else {
                        $imgUrl = Group_Control_Image_Size::get_attachment_image_src( $item['id'], 'thumbnail', $settings );
                        if ( ! $imgUrl ) {
                            $imgUrl = $item['id']['url'];
                        }
                        $imageTagHtml = '<img src="'.esc_url($imgUrl).'" alt="" />';
                    }
                    ?>
                    <div class="gyan-image-slider-thumb-item-wrap gyan-grid-item-wrap">
                        <div class="gyan-grid-item gyan-image-slider-thumb-item gyan-ease-transition gyan-ins-filter-hover">
                            <div class="gyan-image-slider-thumb-image gyan-ins-filter-target">
                                <?php echo $imageTagHtml; ?>
                            </div>
                            <?php echo $this->render_image_overlay(); ?>
                            <?php if ( $settings['thumbnails_caption'] != '' ) { ?>
                                <div class="gyan-image-slider-content">
                                    <?php
                                        echo $this->render_image_caption( $item['id'], $settings['thumbnails_caption'] );
                                    ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php
                }
            ?>
        </div>
        <?php
    }

    protected function render_carousel() {
        $settings = $this->get_settings_for_display();
		$gallery = $settings['gallery_images'];

        foreach ( $gallery as $index => $item ) {

            // responsive image
            if (  $settings['thumbnail_size'] == 'full' ) {
                $imageTagHtml = wp_get_attachment_image( $item['id'], 'full', "", ["alt" => esc_attr( Control_Media::get_image_alt( $item ) )]);
            } else {
                $imgUrl = Group_Control_Image_Size::get_attachment_image_src( $item['id'], 'thumbnail', $settings );
                if ( ! $imgUrl ) {
                    $imgUrl = $item['id']['url'];
                }
                $imageTagHtml = '<img src="'.esc_url($imgUrl).'" alt="" />';
            }
            ?>
            <div class="gyan-image-slider-thumb-item-wrap">
                <div class="gyan-image-slider-thumb-item gyan-ease-transition gyan-ins-filter-hover">
                    <?php
                        $image_html = '<div class="gyan-image-slider-thumb-image gyan-ins-filter-target">';
                        $image_html .= $imageTagHtml;
                        $image_html .= '</div>';

                        $image_html .= $this->render_image_overlay();

                        $caption = '';
                        $caption_rendered = '';

                        if ( $settings['thumbnails_caption'] != '' ) {
                            $caption_rendered = $this->render_image_caption( $item['id'], $settings['thumbnails_caption'] );
                            $image_html .= '<div class="gyan-image-slider-content">';
                            $image_html .= $caption_rendered;
                            $image_html .= '</div>';
                        }

                        if ( $settings['carousel_link_to'] != 'none' ) {

                            $image_html = $this->get_slide_link_atts('carousel', $index, $item, $image_html, $caption);

                        }

                        echo $image_html;
                    ?>
                </div>
            </div>
            <?php
        }
    }

    protected function get_slide_link_atts( $layout = '', $index = '', $item = '', $image_html, $caption = '' ) {
        $settings = $this->get_settings_for_display();

        if ( $layout == 'slideshow' ) {
            $link_to = $settings['link_to'];
            $custom_link = $settings['link'];
            $link_key = $this->get_repeater_setting_key( 'link', 'gallery_images', $index );
        } elseif ( $layout == 'carousel' ) {
            $link_to = $settings['carousel_link_to'];
            $custom_link = $settings['carousel_link'];
            $link_key = $this->get_repeater_setting_key( 'carousel_link', 'gallery_images', $index );
        }

        if ( $link_to == 'file' ) {
            $link = wp_get_attachment_url( $item['id'] );

            $this->add_render_attribute( $link_key, [
                'data-elementor-open-lightbox' 		=> $settings['open_lightbox'],
                'data-elementor-lightbox-slideshow' => $this->get_id(),
                'data-elementor-lightbox-index' 	=> $index,
            ] );

            $this->add_render_attribute( $link_key, [
                'href'  => $link,
                'class' => 'elementor-clickable',
            ] );

        } elseif ( $link_to == 'custom' && $custom_link['url'] != '' ) {
            $link = $custom_link['url'];

            if ( ! empty( $link['is_external'] ) ) {
                $this->add_render_attribute( $link_key, 'target', '_blank' );
            }

            if ( ! empty( $link['nofollow'] ) ) {
                $this->add_render_attribute( $link_key, 'rel', 'nofollow' );
            }

            $this->add_render_attribute( $link_key, [
                'href' => $link,
            ] );
        }

        $this->add_render_attribute( $link_key, [
            'class' => 'gyan-image-slider-slide-link',
        ] );

        return '<a ' . $this->get_render_attribute_string( $link_key ) . '>' . $image_html . '</a>';
    }

    protected function render_image_overlay() {
        return '<div class="gyan-image-slider-thumb-overlay"></div>';
    }

    protected function render_image_caption( $id, $caption_type = 'caption' ) {
        $settings = $this->get_settings_for_display();

        $caption = get_image_caption( $id, $caption_type );

        if ( $caption == '' ) {
			return '';
		}

        ob_start();
        ?>
        <div class="gyan-image-slider-caption">
            <?php echo $caption; ?>
        </div>
        <?php
        $html = ob_get_contents();
		ob_end_clean();
        return $html;
    }

    protected function _content_template() {}

}