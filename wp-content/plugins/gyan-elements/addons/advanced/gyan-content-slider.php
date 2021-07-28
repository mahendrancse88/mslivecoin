<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Frontend;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Gyan_Content_Slider extends Widget_Base {

	public function get_name()           { return 'gyan_content_slider'; }
	public function get_title()          { return esc_html__( 'Content Slider', 'gyan-elements' ); }
	public function get_icon()           { return 'gyan-el-icon eicon-post-slider'; }
	public function get_categories()     { return [ 'gyan-advanced-addons' ]; }
	public function get_keywords()       { return [ 'gyan slider', 'gyan content slider' ]; }
	public function get_style_depends()  { return ['owl-carousel', 'gyan-content-slider' ]; }
	public function get_script_depends() { return ['jquery-owl', 'gyan-widgets', ]; }

	protected function register_controls() {

		$this->start_controls_section(
			'slider_content',
			[
				'label' => esc_html__( 'Slider Content', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'save_templates',
			[
				'label' => esc_html__( 'Use Save Templates', 'gyan-elements' ),
				'type' => Controls_Manager::SWITCHER,
			]
		);
		$repeater->add_control(
			'template',
			[
				'label' => esc_html__( 'Choose Template', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => gyan_get_page_templates(),
				'condition' => [
					'save_templates!' => '',
				],
				'description' => esc_html__('NOTE: Don\'t try to edit after insertion template. If you need to change the style or layout then you try to change the main template then save and then insert', 'gyan-elements'),
			]
		);
		$repeater->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'gyan-elements' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__('Enter Title', 'gyan-elements'),
				'description' => esc_html__( 'You can use HTML.', 'gyan-elements' ),
				'default' => 'Web Development',
				'condition' => [
					'save_templates' => '',
				],
			]
		);
		$repeater->add_control(
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
				],
				'condition' => [
					'save_templates' => '',
				],
				'default' => 'h2',
			]
		);
		$repeater->add_control(
			'subtitle',
			[
				'label' => esc_html__( 'Sub Title', 'gyan-elements' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__('Enter Title', 'gyan-elements'),
				'description' => esc_html__( 'You can use HTML.', 'gyan-elements' ),
				'default' => 'Donec placerat tellus sed vehicula dapibu tesque',
				'condition' => [
					'save_templates' => '',
				],
			]
		);
		$repeater->add_control(
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
				],
				'default' => 'h3',
				'condition' => [
					'save_templates' => '',
				],
			]
		);
		$repeater->add_control(
			'desc',
			[
				'label' => esc_html__('Description', 'gyan-elements'),
				'label_block' => true,
				'type' => Controls_Manager::TEXTAREA,
				'description' => esc_html__( 'You can use HTML.', 'gyan-elements' ),
				'default' => 'Nam non nulla eget ex conse ctetur faucibus eu ut ipsum dolor sit amet conse ctetur adipiscing elit tiam lobortis aliquam nisl lacinia alivida nibh hendrerit sem scelerisque ac pretium nibh laoreet quilectus a volutpat ligula.',
				'condition' => [
					'save_templates' => '',
				],
			]
		);
		$this->add_control(
			'slides',
			[
				'label' => esc_html__('Add Item', 'gyan-elements'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title' => 'Language Lessons',
						'subtitle' => 'Donec placerat tellus sed vehicula dapibu tesque',
						'desc' => 'Nam non nulla eget ex conse ctetur faucibus eu ut ipsum dolor sit amet conse ctetur adipiscing elit tiam lobortis aliquam nisl lacinia alivida nibh hendrerit sem scelerisque ac pretium nibh laoreet quilectus a volutpat ligula.',
					],
					[
						'title' => 'Special Education',
						'subtitle' => 'Donec placerat tellus sed vehicula dapibu tesque',
						'desc' => 'Nam non nulla eget ex conse ctetur faucibus eu ut ipsum dolor sit amet conse ctetur adipiscing elit tiam lobortis aliquam nisl lacinia alivida nibh hendrerit sem scelerisque ac pretium nibh laoreet quilectus a volutpat ligula.',
					],
					[
						'title' => 'Qualified Teachers',
						'subtitle' => 'Donec placerat tellus sed vehicula dapibu tesque',
						'desc' => 'Nam non nulla eget ex conse ctetur faucibus eu ut ipsum dolor sit amet conse ctetur adipiscing elit tiam lobortis aliquam nisl lacinia alivida nibh hendrerit sem scelerisque ac pretium nibh laoreet quilectus a volutpat ligula.',
					],
					[
						'title' => 'Meals Provided',
						'subtitle' => 'Donec placerat tellus sed vehicula dapibu tesque',
						'desc' => 'Nam non nulla eget ex conse ctetur faucibus eu ut ipsum dolor sit amet conse ctetur adipiscing elit tiam lobortis aliquam nisl lacinia alivida nibh hendrerit sem scelerisque ac pretium nibh laoreet quilectus a volutpat ligula.',
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'carousel_settings',
			[
				'label' => esc_html__( 'Slider Settings', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'show_item',
			[
				'label' => esc_html__( 'Show Item', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'1' => esc_html__( '1', 'gyan-elements' ),
					'2' => esc_html__( '2', 'gyan-elements' ),
					'3' => esc_html__( '3', 'gyan-elements' ),
					'4' => esc_html__( '4', 'gyan-elements' ),
				],
				'desktop_default' => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
			]
		);
		$this->add_control(
			'autoplay',
			[
				'label' => esc_html__( 'Autoplay', 'gyan-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'gyan-elements' ),
				'label_off' => esc_html__( 'Off', 'gyan-elements' ),
				'default' => 'yes',
			]
		);
		$this->add_control(
			'pause',
			[
				'label' => esc_html__( 'Pause on Hover', 'gyan-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'gyan-elements' ),
				'label_off' => esc_html__( 'Off', 'gyan-elements' ),
				'default' => 'yes',
			]
		);
		$this->add_control(
			'mouse_drag',
			[
				'label' => esc_html__( 'Mouse Drag', 'gyan-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'gyan-elements' ),
				'label_off' => esc_html__( 'Off', 'gyan-elements' ),
				'default' => 'yes',
			]
		);
		$this->add_control(
			'touch_drag',
			[
				'label' => esc_html__( 'Touch Drag', 'gyan-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'gyan-elements' ),
				'label_off' => esc_html__( 'Off', 'gyan-elements' ),
				'default' => 'yes',
			]
		);
		$this->add_control(
			'loop',
			[
				'label' => esc_html__( 'Infinity Loop', 'gyan-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'gyan-elements' ),
				'label_off' => esc_html__( 'Off', 'gyan-elements' ),
				'default' => 'yes',
			]
		);
		$this->add_control(
			'dots',
			[
				'label' => esc_html__( 'Dots', 'gyan-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'gyan-elements' ),
				'label_off' => esc_html__( 'Hide', 'gyan-elements' ),
				'default' => 'yes',
			]
		);
		$this->add_control(
			'dots_color',
			[
				'label' => esc_html__( 'Dots Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'dots!' => '',
				],
				'default' => '#d83030',
				'selectors' => [
					'{{WRAPPER}} .gyan-content-slider .owl-dot' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .gyan-content-slider .owl-dot.active' => 'background-color: {{VALUE}}',
				]
			]
		);
		$this->add_control(
			'nav',
			[
				'label' => esc_html__( 'Navigation', 'gyan-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'gyan-elements' ),
				'label_off' => esc_html__( 'Hide', 'gyan-elements' ),
				'default' => 'yes',
			]
		);
		$this->add_control(
			'nav_bg',
			[
				'label' => esc_html__( 'Navigation Background', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'nav!' => '',
				],
				'default' => '#d83030',
				'selectors' => [
					'{{WRAPPER}} .gyan-content-slider .owl-prev, {{WRAPPER}} .gyan-content-slider .owl-next' => 'background-color: {{VALUE}}'
				]
			]
		);
		$this->add_control(
			'nav_color',
			[
				'label' => esc_html__( 'Navigation Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'nav!' => '',
				],
				'default' => '#eee',
				'selectors' => [
					'{{WRAPPER}} .gyan-content-slider .owl-prev, {{WRAPPER}} .gyan-content-slider .owl-next' => 'color: {{VALUE}}'
				],
			]
		);
		$this->add_control(
			'nav_top',
			[
				'label' => esc_html__( 'Navigation Top (%)', 'gyan-elements' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
					'size' => '50',
				],
				'condition' => [
					'nav!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-content-slider .owl-next, {{WRAPPER}} .gyan-content-slider .owl-prev' => 'top: calc({{SIZE}}{{UNIT}} - 18px);',
				],
			]
		);
		$this->add_control(
			'delay',
			[
				'label' => esc_html__( 'Delay', 'gyan-elements' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 5000,
				'step' => 100,
				'min' => 500,
				'max' => 15000,
			]
		);
		$this->add_control(
			'speed',
			[
				'label' => esc_html__( 'Speed', 'gyan-elements' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 500,
				'step' => 100,
				'min' => 100,
				'max' => 5000,
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'box_style',
			[
				'label' => esc_html__( 'Box', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
		    Group_Control_Background::get_type(),
		    [
		        'name' => 'box_background',
		        'label' => esc_html__( 'Background', 'gyan-elements' ),
		        'types' => [ 'classic', 'gradient' ],
		        'selector' => '{{WRAPPER}} .gyan-cs-item',
		    ]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'box_border',
				'selector' => '{{WRAPPER}} .gyan-cs-item',
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'selector' => '{{WRAPPER}} .gyan-cs-item',
			]
		);
		$this->add_responsive_control(
			'box_radius',
			[
				'label' => esc_html__( 'Radius', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '6',
					'right' => '6',
					'bottom' => '6',
					'left' => '6',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-cs-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'box_padding',
			[
				'label' => esc_html__( 'Padding', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '15',
					'right' => '15',
					'bottom' => '15',
					'left' => '15',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-cs-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'box_margin',
			[
				'label' => esc_html__( 'Margin', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '0',
					'left' => '0',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-cs-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'title_style',
			[
				'label' => esc_html__( 'Title', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#222',
				'selectors' => [
					'{{WRAPPER}} .gyan-cs-title' => 'color: {{VALUE}};',
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
					'font_weight' => [
						'default' => '600',
					],
					'font_size'   => [
						'default' => [
							'size' => '32',
						],
					],
					'line_height'   => [
						'default' => [
							'size' => '42',
						],
					],
					'text_transform' => [
						'default' => 'capitalize',
					],
				],
				'selector' => '{{WRAPPER}} .gyan-cs-title',
			]
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_shadow',
				'selector' => '{{WRAPPER}} .gyan-cs-title',
			]
		);
		$this->add_responsive_control(
			'title_margin',
			[
				'label' => esc_html__( 'Margin Bottom', 'gyan-elements' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'default' => [
					'size' => '15',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-cs-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .gyan-cs-title' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'subtitle_style',
			[
				'label' => esc_html__( 'Sub Title', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#222',
				'selectors' => [
					'{{WRAPPER}} .gyan-cs-subtitle' => 'color: {{VALUE}};',
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
							'size' => '24',
						],
					],
					'line_height'   => [
						'default' => [
							'size' => '32',
						],
					],
				],
				'selector' => '{{WRAPPER}} .gyan-cs-subtitle',
			]
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'subtitle_shadow',
				'selector' => '{{WRAPPER}} .gyan-cs-subtitle',
			]
		);
		$this->add_responsive_control(
			'subtitle_margin',
			[
				'label' => esc_html__( 'Margin Bottom', 'gyan-elements' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'default' => [
					'size' => '20',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-cs-subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .gyan-cs-subtitle' => 'text-align: {{VALUE}};',
				],
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
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#222',
				'selectors' => [
					'{{WRAPPER}} .gyan-cs-desc' => 'color: {{VALUE}};',
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
							'size' => '24',
						],
					],
				],
				'selector' => '{{WRAPPER}} .gyan-cs-desc',
			]
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'desc_shadow',
				'selector' => '{{WRAPPER}} .gyan-cs-desc',
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
				'default' => 'justify',
				'selectors' => [
					'{{WRAPPER}} .gyan-cs-desc' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}


	protected function render() {
		$data = $this->get_settings_for_display();
		$data_rtl = is_rtl() ? 'true' : 'false';
		?>
		<div class="gyan-content-slider owl-carousel"
		data-item-lg="<?php echo esc_attr( $data['show_item'] ); ?>"
		data-item-md="<?php echo esc_attr( $data['show_item_tablet'] ); ?>"
		data-item-sm="<?php echo esc_attr( $data['show_item_mobile'] ); ?>"
		data-autoplay="<?php echo esc_attr( $data['autoplay'] ); ?>"
		data-pause="<?php echo esc_attr( $data['pause'] ); ?>"
		data-nav="<?php echo esc_attr( $data['nav'] ); ?>"
		data-dots="<?php echo esc_attr( $data['dots'] ); ?>"
		data-mouse-drag="<?php echo esc_attr( $data['mouse_drag'] ); ?>"
		data-touch-drag="<?php echo esc_attr( $data['touch_drag'] ); ?>"
		data-loop="<?php echo esc_attr( $data['loop'] ); ?>"
		data-speed="<?php echo esc_attr( $data['speed'] ); ?>"
		data-delay="<?php echo esc_attr( $data['delay'] ); ?>"
		data-rtl="<?php echo $data_rtl; ?>">

			<?php foreach ($data['slides'] as $slide): ?>
				<div class="gyan-cs-item">
					<?php
						if ( 'yes' == $slide['save_templates'] && $slide['template'] ) :
							$frontend = new Frontend;
							echo $frontend->get_builder_content( $slide['template'], true );
						else :
					?>
						<?php if ( $slide['title'] ): ?>
							<?php printf( '<%1$s class="%2$s">%3$s</%1$s>', $slide['title_tag'], 'gyan-cs-title', $slide['title'] ); ?>
						<?php endif; ?>

						<?php if ( $slide['subtitle'] ): ?>
							<?php printf( '<%1$s class="%2$s">%3$s</%1$s>', $slide['subtitle_tag'], 'gyan-cs-subtitle', $slide['subtitle'] ); ?>
						<?php endif; ?>

						<?php if ( $slide['desc'] ): ?>
							<?php printf( '<div class="gyan-cs-desc">%1$s</div>', $slide['desc'] ); ?>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>

		</div>
		<?php
	}

	protected function _content_template() {}

}