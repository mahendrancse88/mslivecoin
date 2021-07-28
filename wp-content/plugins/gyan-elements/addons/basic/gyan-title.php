<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Gyan_Title extends Widget_Base {

	public function get_name()          { return 'gyan_title'; }
	public function get_title()         { return esc_html__( 'Title', 'gyan-elements' ); }
	public function get_icon()          { return 'gyan-el-icon eicon-heading'; }
	public function get_categories()    { return ['gyan-basic-addons']; }
	public function get_keywords()      { return [ 'gyan title', 'gyan subtitle','heading','title' ]; }
	public function get_style_depends() { return ['gyan-title']; }

	protected function register_controls() {

		$this->start_controls_section(
			'title_content',
			[
				'label' => esc_html__( 'Title Content', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'gyan-elements' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter Title', 'gyan-elements' ),
				'description' => esc_html__( 'You can use HTML.', 'gyan-elements' ),
				'default' => 'Sample Title Text',
			]
		);
		$this->add_control(
			'title_tag',
			[
				'label' => esc_html__( 'Select Tag', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
				],
				'default' => 'h2',
			]
		);
		$this->add_control(
			'subtitle',
			[
				'label' => esc_html__( 'Sub Title', 'gyan-elements' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter Sub Title', 'gyan-elements' ),
				'description' => esc_html__( 'You can use HTML.', 'gyan-elements' ),
				'default' => 'Sub title text example',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'subtitle_location',
			[
				'label' => esc_html__( 'Display Location', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'above_title' => 'Above Title',
					'below_title' => 'Below Title'
				],
				'default' => 'above_title',
			]
		);


		$this->add_control(
			'subtitle_tag',
			[
				'label' => esc_html__( 'Select Tag', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
				],
				'default' => 'div',
			]
		);
		$this->add_control(
			'desc',
			[
				'label' => esc_html__( 'Description', 'gyan-elements' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter Description', 'gyan-elements' ),
				'description' => esc_html__( 'You can use HTML.', 'gyan-elements' ),
				'separator' => 'before',
				'default' => 'Lorem ipsum dolor sit amet cotetur adipisicing elit, sed do mod tempor incididunt ut labore etdolore emu some the and one baldbe dear.',
			]
		);

		$this->add_control(
			'desc_tag',
			[
				'label' => esc_html__( 'Select Tag', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
				],
				'default' => 'div',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'title_style',
			[
				'label' => esc_html__( 'Title', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'title!' => '',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#032e42',
				'selectors' => [
					'{{WRAPPER}} .gyan-title-heading' => 'color: {{VALUE}};',
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
							'size' => '45',
						],
					],
					'line_height'   => [
						'default' => [
							'size' => '55',
						],
					],
				],
				'selector' => '{{WRAPPER}} .gyan-title-heading',
			]
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_shadow',
				'selector' => '{{WRAPPER}} .gyan-title-heading',
			]
		);
		$this->add_responsive_control(
			'title_margin',
			[
				'label' => esc_html__( 'Margin Bottom', 'gyan-elements' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'default' => [
					'size' => '16',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-title-heading' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'title_alignment',
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
						'title' => esc_html__( 'justify', 'gyan-elements' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .gyan-title-heading' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'subtitle_style',
			[
				'label' => esc_html__( 'Sub Title', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'subtitle!' => '',
				],
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#d83030',
				'selectors' => [
					'{{WRAPPER}} .gyan-title-subtitle' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'fields_options' => [
					'typography' => [
						'default' =>'custom',
					],
					'font_size'   => [
						'default' => [
							'size' => '17',
						],
					],
					'font_weight'   => [
						'default' => '500',
					],
					'line_height'   => [
						'default' => [
							'size' => '27',
						],
					],
				],
				'selector' => '{{WRAPPER}} .gyan-title-subtitle',
			]
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'subtitle_shadow',
				'selector' => '{{WRAPPER}} .gyan-title-subtitle',
			]
		);
		$this->add_responsive_control(
			'subtitle_margin',
			[
				'label' => esc_html__( 'Margin Bottom', 'gyan-elements' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'default' => [
					'size' => '9',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-title-subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'subtitle_alignment',
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
						'title' => esc_html__( 'justify', 'gyan-elements' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .gyan-title-subtitle' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
            'subtitle_line_heading',
            [
                'label'                 => esc_html__( 'Sub Title Line', 'gyan-elements' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
            ]
        );

		$this->add_control(
		    'subtitle_line_on',
		    [
		        'label'                 => esc_html__( 'Sub Title Line', 'gyan-elements' ),
		        'type'                  => Controls_Manager::SWITCHER,
		        'default'               => 'yes',
		        'label_off' => esc_html__( 'Hide', 'gyan-elements' ),
		        'label_on'  => esc_html__( 'Show', 'gyan-elements' ),
		    ]
		);

		$this->add_control(
			'subtitle_line_location',
			[
				'label' => esc_html__( 'Line Location', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'before' => 'Before Sub Title',
					'after' => 'After Sub TItle',
					'both-side' => 'Before & After Sub TItle'
				],
				'default' => 'after',
				'condition' => [
					'subtitle_line_on' => 'yes',
				],
				'prefix_class' => 'gyan-title-st-line-',
			]
		);

		$this->add_responsive_control(
			'subtitle_line_width',
			[
				'label' => esc_html__( 'Line Width', 'gyan-elements' ),
				'type'  => Controls_Manager::SLIDER,
				'default'    => [
					'size' => 25,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 2000,
					],
				],
				'condition' => [
					'subtitle_line_on' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-title-subtitle span:before,
					{{WRAPPER}} .gyan-title-subtitle span:after' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
		    'subtitle_line_spacing',
		    [
		        'label'                 => esc_html__( 'Spacing', 'gyan-elements' ),
		        'type'                  => Controls_Manager::SLIDER,
		        'range'                 => [
		            'px' 	=> [
		                'min' => 0,
		                'max' => 4000,
		            ],
		        ],
		        'default'               => [
		            'size' 	=> '',
		        ],
		        'selectors'             => [
		            '{{WRAPPER}} .gyan-title-subtitle span:before' => 'left: -{{SIZE}}{{UNIT}};',
		            '{{WRAPPER}} .gyan-title-subtitle span:after' => 'right: -{{SIZE}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_control(
			'subtitle_line_color',
			[
				'label' => esc_html__( 'Line Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#d83030',
				'selectors' => [
					'{{WRAPPER}} .gyan-title-subtitle span:before,
					{{WRAPPER}} .gyan-title-subtitle span:after' => 'background: {{VALUE}};'
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'desc_style',
			[
				'label' => esc_html__( 'Description', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'desc!' => '',
				],
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#606060',
				'selectors' => [
					'{{WRAPPER}} .gyan-title-desc' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'desc_typography',
				'fields_options' => [
					'typography' => [
						'default' =>'custom',
					],
					'font_size'   => [
						'default' => [
							'size' => '16',
						],
					],
					'line_height'   => [
						'default' => [
							'size' => '27',
						],
					],
				],
				'selector' => '{{WRAPPER}} .gyan-title-desc',
			]
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'desc_shadow',
				'selector' => '{{WRAPPER}} .gyan-title-desc',
			]
		);
		$this->add_responsive_control(
			'desc_alignment',
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
						'title' => esc_html__( 'justify', 'gyan-elements' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'default' => 'left',
				'prefix_class' => 'gyan-title-desc-',
				'selectors' => [
					'{{WRAPPER}} .gyan-title-desc' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
		    'desc_width',
		    [
		        'label'                 => esc_html__( 'Max Width', 'gyan-elements' ),
		        'type'                  => Controls_Manager::SLIDER,
		        'range'                 => [
		            'px'        => [
		                'min'   => 0,
		                'max'   => 2500,
		                'step'  => 1,
		            ],
		        ],
		        'size_units'            => [ 'px', '%' ],
		        'selectors'             => [
		            '{{WRAPPER}} .gyan-title-desc' => 'max-width: {{SIZE}}{{UNIT}}',
		        ],
		        'separator'             => 'before',
		    ]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$data = $this->get_settings_for_display();
		?>
		<div class="gyan-title">
			<?php
			if ( $data['subtitle'] && $data['subtitle_location'] == 'above_title' ):
				echo '<' . $data['subtitle_tag'] . ' class="gyan-title-subtitle"><span>' . $data['subtitle'] . '</span></' . $data['subtitle_tag'] . '>';
			endif;

			if ( $data['title'] ):
				echo '<' . $data['title_tag'] . ' class="gyan-title-heading">' . $data['title'] . '</' . $data['title_tag'] . '>';
			endif;

			if ( $data['subtitle'] && $data['subtitle_location'] == 'below_title' ):
				echo '<' . $data['subtitle_tag'] . ' class="gyan-title-subtitle"><span>' . $data['subtitle'] . '</span></' . $data['subtitle_tag'] . '>';
			endif;

			if ( $data['desc'] ):
				echo '<' . $data['desc_tag'] . ' class="gyan-title-desc">' . $data['desc'] . '</' . $data['desc_tag'] . '>';
			endif; ?>
		</div>
		<?php
	}

	protected function _content_template() {}

}