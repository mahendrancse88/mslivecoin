<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Gyan_Promo_Box extends Widget_Base {

	public function get_name()           { return 'gyan_promo_box'; }
	public function get_title()          { return esc_html__( 'Promo Box', 'gyan-elements' ); }
	public function get_icon()           { return 'gyan-el-icon eicon-text-area'; }
	public function get_categories()     { return ['gyan-basic-addons']; }
	public function get_keywords()       { return [ 'gyan promo box', 'promo', 'sell', 'marketing' ]; }
	public function get_style_depends()  { return ['gyan-icon','gyan-position','gyan-promo-box']; }

	protected function register_controls() {
		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'sub_title',
			[
				'label'       => esc_html__( 'Sub Title', 'gyan-elements' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => esc_html__( 'Promo box sub title', 'gyan-elements' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'gyan-elements' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => esc_html__( 'Promo Box Title', 'gyan-elements' ),
				'default'     => esc_html__( 'Promo Box Title', 'gyan-elements' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'content',
			[
				'label'       => esc_html__( 'Content', 'gyan-elements' ),
				'type'        => Controls_Manager::WYSIWYG,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => esc_html__( 'Description Text' , 'gyan-elements' ),
				'default'     => esc_html__( 'Description Text Here' , 'gyan-elements' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'origin',
			[
				'label'   => esc_html__( 'Origin', 'gyan-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'bottom-left',
				'options' => gyan_position(),
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'   => esc_html__( 'Alignment', 'gyan-elements' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
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
				'prefix_class' => 'elementor%s-align-',
				'description'  => 'Use align for matching position',
				'default'      => '',
			]
		);

		$this->add_responsive_control(
			'width',
			[
				'label' => esc_html__( 'Maximum Width', 'gyan-elements' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 1200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label'   => esc_html__( 'Minimum Height', 'gyan-elements' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 400,
				],
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 1024,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-promo-box' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'link_type',
			[
				'label'   => esc_html__( 'Link', 'gyan-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''       => esc_html__( 'None', 'gyan-elements' ),
					'button' => esc_html__( 'Button', 'gyan-elements' ),
					'item'   => esc_html__( 'Item', 'gyan-elements' ),
				],
			]
		);

		$this->add_control(
			'button',
			[
				'label'       => esc_html__( 'link', 'gyan-elements' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'http://your-link.com',
				'default'     => [
					'url' => '#',
				],
				'condition' => [
					'link_type!' => '',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_button',
			[
				'label'     => esc_html__( 'Button', 'gyan-elements' ),
				'condition' => [
					'link_type' => 'button',
				],
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Text', 'gyan-elements' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => esc_html__( 'View Details', 'gyan-elements' ),
				'default'     => esc_html__( 'View Details', 'gyan-elements' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'elementor' ),
				'type' => Controls_Manager::ICONS
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label'   => esc_html__( 'Icon Position', 'gyan-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left'  => esc_html__( 'Before', 'gyan-elements' ),
					'right' => esc_html__( 'After', 'gyan-elements' ),
				],
				'condition' => [
					'icon!' => '',
				],
			]
		);

		$this->add_control(
			'icon_indent',
			[
				'label'   => esc_html__( 'Icon Spacing', 'gyan-elements' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 8,
				],
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'icon!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-promo-box .gyan-promo-box-button-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .gyan-promo-box .gyan-promo-box-button-icon-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Style', 'gyan-elements' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'sub_title_color',
			[
				'label'     => esc_html__( 'Pre Title Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-promo-box .gyan-promo-box-pre-title' => 'color: {{VALUE}};',
				],
				'default'   => '#d83030',
				'condition' => [
					'sub_title!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'sub_title_typography',
				'label'     => esc_html__( 'Title Typography', 'gyan-elements' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'separator' => 'after',
				'selector'  => '{{WRAPPER}} .gyan-promo-box .gyan-promo-box-pre-title',
				'condition' => [
					'sub_title!' => '',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#032e42',
				'selectors' => [
					'{{WRAPPER}} .gyan-promo-box .gyan-promo-box-title' => 'color: {{VALUE}};',
				],
				'condition' => [
					'title!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'title_typography',
				'label'     => esc_html__( 'Title Typography', 'gyan-elements' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .gyan-promo-box .gyan-promo-box-title',
				'condition' => [
					'title!' => '',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Text Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#676767',
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .gyan-promo-box .gyan-promo-box-text' => 'color: {{VALUE}};',
				],
				'condition' => [
					'content!' => '',
				],
			]
		);

		$this->add_control(
			'text_spacing',
			[
				'label' => esc_html__('Sapce', 'gyan-elements'),
				'type'  => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .gyan-promo-box .gyan-promo-box-text' => 'margin-top: {{SIZE}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'text_typography',
				'label'     => esc_html__( 'Text Typography', 'gyan-elements' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .gyan-promo-box .gyan-promo-box-text',
				'condition' => [
					'content!' => '',
				],
			]
		);

		$this->add_control(
			'item_animation',
			[
				'label'        => esc_html__( 'Animation', 'gyan-elements' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'content',
				'prefix_class' => 'gyan-item-transition-',
				'render_type'  => 'ui',
				'options'      => [
					'content'    => esc_html__( 'Content', 'gyan-elements' ),
					'scale-up'   => esc_html__( 'Image Scale Up', 'gyan-elements' ),
					'scale-down' => esc_html__( 'Image Scale Down', 'gyan-elements' ),
					'none'       => esc_html__( 'None', 'gyan-elements' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[
				'label'     => esc_html__( 'Button', 'gyan-elements' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'link_type' => 'button',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => esc_html__( 'Normal', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.gyan-promo-box-button' => 'color: {{VALUE}};',
					'{{WRAPPER}} a.gyan-promo-box-button svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label'     => esc_html__( 'Background Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.gyan-promo-box-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => esc_html__( 'Hover', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.gyan-promo-box-button:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} a.gyan-promo-box-button:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.gyan-promo-box-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} a.gyan-promo-box-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_animation',
			[
				'label' => esc_html__( 'Animation', 'gyan-elements' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'border',
				'label'       => esc_html__( 'Border', 'gyan-elements' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} a.gyan-promo-box-button',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} a.gyan-promo-box-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_shadow',
				'selector' => '{{WRAPPER}} a.gyan-promo-box-button',
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} a.gyan-promo-box-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
		    'button_margin',
		    [
		        'label' => esc_html__('Margin', 'gyan-elements'),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => ['px', 'em', '%'],
		        'selectors' => [
		            '{{WRAPPER}} a.gyan-promo-box-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography',
				'label'    => esc_html__( 'Typography', 'gyan-elements' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} a.gyan-promo-box-button',
			]
		);

		$this->end_controls_section();

		// Background Overlay
		$this->start_controls_section(
			'section_advanced_background_overlay',
			[
				'label'     => esc_html__( 'Background Overlay', 'gyan-elements' ),
				'tab'       => Controls_Manager::TAB_ADVANCED,
				'condition' => [
					'_background_background' => [ 'classic', 'gradient' ],
				],
			]
		);

		$this->start_controls_tabs( 'tabs_background_overlay' );

		$this->start_controls_tab(
			'tab_background_overlay_normal',
			[
				'label' => esc_html__( 'Normal', 'gyan-elements' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'background_overlay',
				'selector' => '{{WRAPPER}} .elementor-widget-container > .elementor-background-overlay',
			]
		);

		$this->add_control(
			'background_overlay_opacity',
			[
				'label'   => esc_html__( 'Opacity (%)', 'gyan-elements' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => .5,
				],
				'range' => [
					'px' => [
						'max'  => 1,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container > .elementor-background-overlay' => 'opacity: {{SIZE}};',
				],
				'condition' => [
					'background_overlay_background' => [ 'classic', 'gradient' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_background_overlay_hover',
			[
				'label' => esc_html__( 'Hover', 'gyan-elements' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'background_overlay_hover',
				'selector' => '{{WRAPPER}}:hover .elementor-widget-container > .elementor-background-overlay',
			]
		);

		$this->add_control(
			'background_overlay_hover_opacity',
			[
				'label'   => esc_html__( 'Opacity (%)', 'gyan-elements' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => .5,
				],
				'range' => [
					'px' => [
						'max' => 1,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}}:hover .elementor-widget-container > .elementor-background-overlay' => 'opacity: {{SIZE}};',
				],
				'condition' => [
					'background_overlay_hover_background' => [ 'classic', 'gradient' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	public function render() {
		$settings               = $this->get_settings_for_display();

		$origin                 = ' gyan-position-' . $settings['origin'];
		$has_background_overlay = in_array( $settings['background_overlay_background'], [ 'classic', 'gradient' ] ) ||
		in_array( $settings['background_overlay_hover_background'], [ 'classic', 'gradient' ] );

		$target                 = ($settings['button']['is_external']) ? '_blank' : '_self';

		if ( $has_background_overlay ) : ?>
			<div class="elementor-background-overlay"></div>
		<?php endif; ?>

		<?php if ('item' === $settings['link_type']) : ?>
			<div onclick="window.open('<?php echo esc_url($settings['button']['url']); ?>','<?php echo esc_attr($target); ?>');" style="cursor: pointer;">
		<?php endif; ?>

			<div class="gyan-promo-box gyan-position-relative">
				<div class="gyan-promo-box-desc gyan-position-medium<?php echo esc_attr($origin); ?>">
					<div class="gyan-promo-box-desc-inner">
						<?php if ( '' !== $settings['sub_title'] ) : ?>
							<h4 class="gyan-promo-box-pre-title"><?php echo $settings['sub_title']; ?></h4>
						<?php endif; ?>

						<?php if ( '' !== $settings['title'] ) : ?>
							<h3 class="gyan-promo-box-title"><?php echo $settings['title']; ?></h3>
						<?php endif; ?>

						<?php if ( '' !== $settings['content'] ) : ?>
							<div class="gyan-promo-box-text"><?php echo wp_kses_post($settings['content']); ?></div>
						<?php endif; ?>

						<?php if ('button' === $settings['link_type']) : ?>
							<?php if (( '' !== $settings['button']['url'] ) and ('' !== $settings['button_text'] )) :

								$this->add_render_attribute(
									[
										'promo-box-button' => [
											'href'   => esc_url($settings['button']['url']),
											'target' => esc_attr($target),
											'class'  => [
												'gyan-promo-box-button gyan-ease-transition',
												$settings['button_hover_animation'] ? 'elementor-animation-'.$settings['button_hover_animation'] : ''
											]
										]
									]
								);

								?>
								<a <?php echo $this->get_render_attribute_string( 'promo-box-button' ); ?>>
									<?php echo esc_html($settings['button_text']); ?>

									<?php if ($settings['icon']) : ?>
										<span class="gyan-promo-box-button-icon-<?php echo esc_attr($settings['icon_align']); ?> gyan-icon">
											<?php Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</span>
									<?php endif; ?>

								</a>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>

		<?php if ('item' === $settings['link_type']) : ?>
			</div>
		<?php endif; ?>

		<?php
	}
}
