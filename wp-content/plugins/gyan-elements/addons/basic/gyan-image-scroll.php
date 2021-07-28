<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Gyan_Image_Scroll extends Widget_Base {

	public function get_name()           { return 'gyan_image_scroll'; }
	public function get_title()          { return esc_html__( 'Image Scroll', 'gyan-elements' ); }
	public function get_icon()           { return 'gyan-el-icon eicon-image-rollover'; }
	public function get_categories()     { return ['gyan-basic-addons']; }
	public function get_keywords()       { return [ 'image', 'scroll', 'slide','lightbox' ]; }
	public function get_style_depends()  { return ['gyan-icon','gyan-position','gyan-image-scroll']; }

	protected function register_controls() {
		$this->start_controls_section(
			'section_image',
			[
				'label' => esc_html__( 'Image', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'image',
			[
				'label'   => esc_html__( 'Choose Image', 'gyan-elements' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => GYAN_PLUGIN_URL .'addons/images/portfolio2.jpg',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image_size',
				'default'   => 'large',
				'separator' => 'none',
			]
		);

		$this->add_responsive_control(
			'max_width',
			[
				'label'     => esc_html__( 'Width', 'gyan-elements' ),
				'type'      => Controls_Manager::SLIDER,
				'separator' => 'before',
				'range'     => [
					'px' => [
						'step' => 10,
						'min'  => 5,
						'max'  => 1200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-image-scroll-container' => 'max-width: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			'min_height',
			[
				'label' => esc_html__( 'Min Height', 'gyan-elements' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'step' => 10,
						'min'  => 5,
						'max'  => 1200,
					],
				],
				'default' => [
					'size' => 320,
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-image-scroll' => 'min-height: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'caption',
			[
				'label'       => esc_html__( 'Caption', 'gyan-elements' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your image caption', 'gyan-elements' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'link_to',
			[
				'label'   => esc_html__( 'Link To', 'gyan-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'lightbox',
				'options' => [
					'lightbox' => esc_html__( 'Lightbox', 'gyan-elements' ),
					'external' => esc_html__( 'External', 'gyan-elements' ),
					''         => esc_html__( 'None', 'gyan-elements' ),
				],
			]
		);

		$this->add_control(
			'external_link',
			[
				'label'         => esc_html__( 'External Link', 'gyan-elements' ),
				'type'          => Controls_Manager::URL,
				'show_external' => false,
				'placeholder'   => esc_html__( 'https://your-link.com', 'gyan-elements' ),
				'default'       => [
					'url' => '#',
				],
				'condition' => [
					'link_to' => ['external'],
				],
			]
		);

		$this->add_control(
			'link_icon',
			[
				'label'   => esc_html__( 'Choose Link Icon', 'gyan-elements' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'link' => [
						'title' => esc_html__( 'Link', 'gyan-elements' ),
						'icon'  => 'fas fa-link',
					],
					'plus' => [
						'title' => esc_html__( 'Plus', 'gyan-elements' ),
						'icon'  => 'fas fa-plus',
					],
					'search' => [
						'title' => esc_html__( 'Zoom', 'gyan-elements' ),
						'icon'  => 'fas fa-search',
					],
				],
				'default' => 'link',
				'condition' => [
					'link_to!' => '',
				],
			]
		);

		$this->add_control(
			'link_icon_position',
			[
				'label'     => esc_html__( 'Link Icon Position', 'gyan-elements' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => gyan_position(),
				'default'   => 'top-left',
				'condition' => [
					'link_to!'       => ''
				],
			]
		);

		$this->add_control(
			'link_icon_on_hover',
			[
				'label'        => esc_html__( 'Link Icon On Hover', 'gyan-elements' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'gyan-link-icon-on-hover-',
				'conditions'   => [
					'terms' => [
						[
							'name'     => 'link_to',
							'operator' => '!=',
							'value'    => '',
						],
						[
							'name'     => 'link_icon',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->add_control(
			'badge',
			[
				'label' => esc_html__( 'Badge', 'gyan-elements' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_badge',
			[
				'label'     => esc_html__( 'Badge', 'gyan-elements' ),
				'condition' => [
					'badge' => 'yes',
				],
			]
		);

		$this->add_control(
			'badge_text',
			[
				'label'       => esc_html__( 'Badge Text', 'gyan-elements' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'NEW',
				'placeholder' => 'Type Badge Title',
			]
		);

		$this->add_control(
			'badge_position',
			[
				'label'   => esc_html__( 'Position', 'gyan-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'top-right',
				'options' => gyan_position(),
			]
		);

		$this->add_responsive_control(
			'badge_horizontal_offset',
			[
				'label' => esc_html__( 'Horizontal Offset', 'gyan-elements' ),
				'type'  => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'tablet_default' => [
					'size' => 0,
				],
				'mobile_default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min'  => -300,
						'step' => 2,
						'max'  => 300,
					],
				],
			]
		);

		$this->add_responsive_control(
			'badge_vertical_offset',
			[
				'label' => esc_html__( 'Vertical Offset', 'gyan-elements' ),
				'type'  => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'tablet_default' => [
					'size' => 0,
				],
				'mobile_default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min'  => -300,
						'step' => 2,
						'max'  => 300,
					],
				],
			]
		);

		$this->add_responsive_control(
			'badge_rotate',
			[
				'label'   => esc_html__( 'Rotate', 'gyan-elements' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'tablet_default' => [
					'size' => 0,
				],
				'mobile_default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min'  => -360,
						'max'  => 360,
						'step' => 5,
					],
				],
				'selectors' => [
					'(desktop){{WRAPPER}} .gyan-image-scroll-badge' => 'transform: translate({{badge_horizontal_offset.SIZE}}px, {{badge_vertical_offset.SIZE}}px) rotate({{SIZE}}deg);',
					'(tablet){{WRAPPER}} .gyan-image-scroll-badge' => 'transform: translate({{badge_horizontal_offset_tablet.SIZE}}px, {{badge_vertical_offset_tablet.SIZE}}px) rotate({{SIZE}}deg);',
					'(mobile){{WRAPPER}} .gyan-image-scroll-badge' => 'transform: translate({{badge_horizontal_offset_mobile.SIZE}}px, {{badge_vertical_offset_mobile.SIZE}}px) rotate({{SIZE}}deg);',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__( 'Image', 'gyan-elements' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'transition_duration',
			[
				'label'   => esc_html__( 'Transition Duration', 'gyan-elements' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 2,
				],
				'range' => [
					'px' => [
						'step' => 0.1,
						'min'  => 0.1,
						'max'  => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-image-scroll' => 'transition: background-position {{SIZE}}s ease-in-out;-webkit-transition: background-position {{SIZE}}s ease-in-out;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'image_border',
				'selector'  => '{{WRAPPER}} .gyan-image-scroll',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-image-scroll' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'    => 'image_shadow',
				'exclude' => [
					'shadow_position',
				],
				'selector' => '{{WRAPPER}} .gyan-image-scroll',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_caption',
			[
				'label'     => esc_html__( 'Caption', 'gyan-elements' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'caption!' => '',
				],
			]
		);

		$this->add_control(
			'caption_align',
			[
				'label'   => esc_html__( 'Alignment', 'gyan-elements' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'gyan-elements' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'gyan-elements' ),
						'icon'  => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'gyan-elements' ),
						'icon'  => 'fa fa-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'gyan-elements' ),
						'icon'  => 'fa fa-align-justify',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .gyan-image-scroll-caption' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'caption_background',
			[
				'label'     => esc_html__( 'Background', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-image-scroll-caption' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'caption_color',
			[
				'label'     => esc_html__( 'Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-image-scroll-caption' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'caption_border',
				'label'       => esc_html__( 'Border', 'gyan-elements' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .gyan-image-scroll-caption',
			]
		);

		$this->add_responsive_control(
			'caption_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-image-scroll-caption' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow: hidden;',
				],
			]
		);

		$this->add_responsive_control(
			'caption_padding',
			[
				'label'      => esc_html__( 'Padding', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-image-scroll-caption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'caption_margin',
			[
				'label'      => esc_html__( 'Margin', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-image-scroll-caption' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'caption_typography',
				'selector' => '{{WRAPPER}} .gyan-image-scroll-caption',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_icon',
			[
				'label'      => esc_html__( 'Icon Style', 'gyan-elements' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'terms' => [
						[
							'name'     => 'link_to',
							'operator' => '!=',
							'value'    => '',
						],
						[
							'name'     => 'link_icon',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->start_controls_tabs( 'tabs_icon_style' );

		$this->start_controls_tab(
			'tab_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'gyan-elements' ),
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Size', 'gyan-elements' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .gyan-image-scroll-container .gyan-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-image-scroll-container .gyan-icon'    => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label'     => esc_html__( 'Background Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-image-scroll-container .gyan-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'border',
				'label'       => esc_html__( 'Border', 'gyan-elements' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .gyan-image-scroll-container .gyan-icon',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'icon_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-image-scroll-container .gyan-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'icon_shadow',
				'selector' => '{{WRAPPER}} .gyan-image-scroll-container .gyan-icon',
			]
		);

		$this->add_control(
			'icon_padding',
			[
				'label'      => esc_html__( 'Padding', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-image-scroll-container .gyan-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_icon_hover',
			[
				'label' => esc_html__( 'Hover', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label'     => esc_html__( 'Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-image-scroll-container .gyan-icon:hover'    => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-image-scroll-container .gyan-icon:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-image-scroll-container .gyan-icon:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_badge',
			[
				'label'     => esc_html__( 'Badge', 'gyan-elements' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'badge' => 'yes',
				],
			]
		);

		$this->add_control(
			'badge_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-image-scroll-badge span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'badge_background',
				'selector'  => '{{WRAPPER}} .gyan-image-scroll-badge span',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'badge_border',
				'placeholder' => '1px',
				'separator'   => 'before',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .gyan-image-scroll-badge span'
			]
		);

		$this->add_responsive_control(
			'badge_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => '3',
					'right' => '3',
					'bottom' => '3',
					'left' => '3',
					'isLinked' => true,
				],
				'separator'  => 'after',
				'selectors'  => [
					'{{WRAPPER}} .gyan-image-scroll-badge span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'badge_shadow',
				'selector' => '{{WRAPPER}} .gyan-image-scroll-badge span',
			]
		);

		$this->add_responsive_control(
			'badge_padding',
			[
				'label'      => esc_html__( 'Padding', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '10',
					'right' => '10',
					'bottom' => '10',
					'left' => '10',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .gyan-image-scroll-badge span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'badge_typography',
				'selector' => '{{WRAPPER}} .gyan-image-scroll-badge span',
			]
		);

		$this->end_controls_section();
	}

	protected function render_image($settings) {
		$image_url = Group_Control_Image_Size::get_attachment_image_src($settings['image']['id'], 'image_size', $settings);

		if ( ! $image_url ) {
			$image_url = $settings['image']['url'];
		}

		$max_width  = '1280';
		$max_height = '720';

		$this->add_render_attribute( 'image-wrapper', 'gyan-responsive', 'width: ' . $max_width . '; height: ' . $max_height );
		$this->add_render_attribute( 'image-wrapper', 'class', 'gyan-responsive-width' );

		$this->add_render_attribute( 'image', 'class', 'gyan-image-scroll' );
		$this->add_render_attribute( 'image', 'style', 'background-image: url(' . esc_url($image_url) . ');' );
 		?>
			<div <?php echo $this->get_render_attribute_string( 'image' ); ?>></div>
		<?php
	}


	protected function render() {
		$settings = $this->get_settings();

		if ( empty( $settings['image']['url'] ) ) {
			return;
		}

		$has_caption = ! empty( $settings['caption'] );
		$get_link_icon = '';

		$this->add_render_attribute( 'wrapper', 'class', 'gyan-image-scroll-holder' );

		$link_icon_position = $settings['link_icon_position'];

		if ( '' !== $settings['link_to'] ) {
			if ('lightbox' == $settings['link_to']) {
				$link = $settings['image']['url'];
			} else {
				$link = $settings['external_link']['url'];
			}

			$this->add_render_attribute( 'link', 'href', esc_url($link));

			if ( $settings['link_icon'] ) {
				$this->add_render_attribute( 'link', [
					'class'    => 'gyan-icon gyan-position-small gyan-position-' . esc_attr( $link_icon_position )
				]);
			}

			if ('link' == $settings['link_icon']) {
				$get_link_icon = '<i class="fas fa-link"></i>';
			} elseif ('plus' == $settings['link_icon']) {
				$get_link_icon = '<i class="fas fa-plus"></i>';
			} else {
				$get_link_icon = '<i class="fas fa-search"></i>';
			}

		}

		if ( 'lightbox' === $settings['link_to'] ) {
			$this->add_render_attribute('container', 'gyan-lightbox');
			$this->add_render_attribute( 'link', 'data-elementor-open-lightbox', 'yes');
			$this->add_render_attribute( 'link', 'class', 'gyan-image-scroll-lightbox-item');
		}

		$this->add_render_attribute( 'container', 'class', 'gyan-image-scroll-container' );

		?>
		<div <?php echo $this->get_render_attribute_string( 'container' ); ?>>
			<?php if (( '' !== $settings['link_to'] ) and ( '' == $settings['link_icon'] )): ?>
				<a target="_blank" <?php echo $this->get_render_attribute_string( 'link' ); ?>>
			<?php endif; ?>

				<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
					<?php $this->render_image($settings); ?>
					<?php if (('' !== $settings['link_to']) and ('' !== $settings['link_icon'])) : ?>
						<a target="_blank" <?php echo $this->get_render_attribute_string( 'link' ); ?>><?php echo $get_link_icon; ?></a>
					<?php endif; ?>
				</div>

			<?php if (('' !== $settings['link_to']) and ('' == $settings['link_icon'])): ?>
				</a>
			<?php endif; ?>
			<?php if ( $has_caption ) : ?>
				<figure class="wp-caption">
					<figcaption class="gyan-image-scroll-caption gyan-caption-text"><?php echo $settings['caption']; ?></figcaption>
				</figure>
			<?php endif; ?>
			<?php if ( $settings['badge'] and '' != $settings['badge_text'] ) : ?>
				<div class="gyan-image-scroll-badge gyan-position-<?php echo esc_attr($settings['badge_position']); ?>">
					<span class="gyan-badge gyan-padding-small"><?php echo esc_html($settings['badge_text']); ?></span>
				</div>
			<?php endif; ?>

		</div>
		<?php
	}

	protected function _content_template() {}
}
