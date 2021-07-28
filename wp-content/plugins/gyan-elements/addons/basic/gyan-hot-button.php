<?php
// Elementor Classes.
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Widget_Button;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

class Gyan_Hot_Button extends Widget_Base {

	public function get_name()           { return 'gyan_hot_button'; }
	public function get_title()          { return esc_html__( 'Hot Button', 'gyan-elements' ); }
	public function get_icon()           { return 'gyan-el-icon eicon-button'; }
	public function get_categories()     { return ['gyan-basic-addons']; }
	public function get_keywords()       { return [ 'gyan hot button', 'hot button', 'button' ]; }
	public function get_style_depends()  { return ['gyan-icon','gyan-hot-button']; }

	public static function get_button_sizes() {
		return Widget_Button::get_button_sizes();
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_buttons',
			[
				'label' => esc_html__( 'General', 'gyan-elements' ),
			]
		);
			$this->add_control(
				'text',
				[
					'label'   => esc_html__( 'Title', 'gyan-elements' ),
					'type'    => Controls_Manager::TEXTAREA,
					'rows'    => '2',
					'default' => esc_html__( 'Join Us Now', 'gyan-elements' ),
					'dynamic' => [
						'active' => true,
					],
				]
			);

			$this->add_control(
				'desc_text',
				[
					'label'   => esc_html__( 'Description', 'gyan-elements' ),
					'type'    => Controls_Manager::TEXTAREA,
					'rows'    => '3',
					'default' => esc_html__( 'Get your discount before it’s gone!', 'gyan-elements' ),
					'dynamic' => [
						'active' => true,
					],
				]
			);

			$this->add_control(
				'link',
				[
					'label'    => esc_html__( 'Link', 'gyan-elements' ),
					'type'     => Controls_Manager::URL,
					'default'  => [
						'url'         => '#',
						'is_external' => '',
					],
					'dynamic'  => [
						'active' => true,
					],
					'selector' => '',
				]
			);

			$this->add_control(
				'icon',
				[
					'label' => esc_html__( 'Icon', 'elementor' ),
					'type' => Controls_Manager::ICONS,
					'default' => [
						'value' => 'fas fa-arrow-right',
						'library' => 'fa-solid',
					],
				]
			);

			$this->add_control(
				'icon_align',
				[
					'label'     => esc_html__( 'Icon Position', 'gyan-elements' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'left',
					'options'   => [
						'left'      => esc_html__( 'Before Title', 'gyan-elements' ),
						'right'     => esc_html__( 'After Title', 'gyan-elements' ),
						'all_left'  => esc_html__( 'Before Title & Description', 'gyan-elements' ),
						'all_right' => esc_html__( 'After Title & Description', 'gyan-elements' ),
					],
					'condition' => [
						'icon!' => '',
					],
				]
			);

			$this->add_control(
				'icon_vertical_align',
				[
					'label'       => esc_html__( 'Icon Vertical Alignment', 'gyan-elements' ),
					'type'        => Controls_Manager::CHOOSE,
					'label_block' => false,
					'default'     => 'center',
					'options'     => [
						'flex-start' => [
							'title' => esc_html__( 'Top', 'gyan-elements' ),
							'icon'  => 'eicon-v-align-top',
						],
						'center'     => [
							'title' => esc_html__( 'Middle', 'gyan-elements' ),
							'icon'  => 'eicon-v-align-middle',
						],
					],
					'condition'   => [
						'icon!'      => '',
						'icon_align' => [ 'all_left', 'all_right' ],
					],
					'selectors'   => [
						'{{WRAPPER}} .gyan-hot-buttons-all_left.elementor-button .elementor-button-icon, {{WRAPPER}} .gyan-hot-buttons-all_right.elementor-button .elementor-button-icon' => 'align-self: {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
				'icon_size',
				[
					'label'     => esc_html__( 'Icon Size', 'gyan-elements' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'max' => 200,
						],
					],
					'condition' => [
						'icon!' => '',
					],
					'selectors' => [
						'{{WRAPPER}} .elementor-button .elementor-button-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);


			if ( is_rtl() ) {

				$this->add_responsive_control(
					'icon_indent',
					[
						'label'     => esc_html__( 'Icon Spacing', 'gyan-elements' ),
						'type'      => Controls_Manager::SLIDER,
						'range'     => [
							'px' => [
								'max' => 50,
							],
						],
						'condition' => [
							'icon!' => '',
						],
						'selectors' => [
							'{{WRAPPER}} .elementor-align-icon-right,
							{{WRAPPER}} .gyan-hot-buttons-all_right.elementor-button .elementor-button-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
							'{{WRAPPER}} .elementor-align-icon-left,
							{{WRAPPER}} .gyan-hot-buttons-all_left.elementor-button .elementor-button-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
						],
					]
				);

			} else {

				$this->add_responsive_control(
					'icon_indent',
					[
						'label'     => esc_html__( 'Icon Spacing', 'gyan-elements' ),
						'type'      => Controls_Manager::SLIDER,
						'range'     => [
							'px' => [
								'max' => 50,
							],
						],
						'condition' => [
							'icon!' => '',
						],
						'selectors' => [
							'{{WRAPPER}} .elementor-align-icon-right,
							{{WRAPPER}} .gyan-hot-buttons-all_right.elementor-button .elementor-button-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
							'{{WRAPPER}} .elementor-align-icon-left,
							{{WRAPPER}} .gyan-hot-buttons-all_left.elementor-button .elementor-button-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
						],
					]
				);

			}

		$this->end_controls_section();

		$this->start_controls_section(
			'section_styling',
			[
				'label' => esc_html__( 'Button', 'gyan-elements' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_responsive_control(
				'align',
				[
					'label'        => esc_html__( 'Alignment', 'gyan-elements' ),
					'type'         => Controls_Manager::CHOOSE,
					'options'      => [
						'left'    => [
							'title' => esc_html__( 'Left', 'gyan-elements' ),
							'icon'  => 'fa fa-align-left',
						],
						'center'  => [
							'title' => esc_html__( 'Center', 'gyan-elements' ),
							'icon'  => 'fa fa-align-center',
						],
						'right'   => [
							'title' => esc_html__( 'Right', 'gyan-elements' ),
							'icon'  => 'fa fa-align-right',
						],
						'justify' => [
							'title' => esc_html__( 'Justify', 'gyan-elements' ),
							'icon'  => 'fa fa-align-justify',
						],
					],
					'default'      => 'center',
					'toggle'       => false,
					'prefix_class' => 'elementor%s-align-',
				]
			);

			$this->add_control(
				'size',
				[
					'label'   => esc_html__( 'Size', 'gyan-elements' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'md',
					'options' => self::get_button_sizes(),
				]
			);

			$this->add_responsive_control(
				'padding',
				[
					'label'      => esc_html__( 'Padding', 'gyan-elements' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->start_controls_tabs( '_button_style' );

				$this->start_controls_tab(
					'_button_normal',
					[
						'label' => esc_html__( 'Normal', 'gyan-elements' ),
					]
				);

					$this->add_control(
						'all_text_color',
						[
							'label'     => esc_html__( 'Text Color', 'gyan-elements' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '#ffffff',
							'selectors' => [
								'{{WRAPPER}} a.elementor-button' => 'color: {{VALUE}};',
								'{{WRAPPER}} a.elementor-button svg' => 'fill: {{VALUE}};',
							],
						]
					);

					$this->add_group_control(
						Group_Control_Background::get_type(),
						[
							'name'           => 'all_background_color',
							'label'          => esc_html__( 'Background Color', 'gyan-elements' ),
							'types'          => [ 'classic', 'gradient' ],
							'selector'       => '{{WRAPPER}} a.elementor-button',
							'fields_options' => [
								'background' => [
									'default' =>'classic',
								],
								'color' => [
									'scheme' => [
										'type'  => Scheme_Color::get_type(),
										'value' => Scheme_Color::COLOR_4,
									],
									'default' 		=> '#d83030',
								],
							],
						]
					);

					$this->add_group_control(
						Group_Control_Border::get_type(),
						[
							'name'     => 'all_border',
							'label'    => esc_html__( 'Border', 'gyan-elements' ),
							'selector' => '{{WRAPPER}} .elementor-button',
						]
					);

					$this->add_control(
						'all_border_radius',
						[
							'label'      => esc_html__( 'Border Radius', 'gyan-elements' ),
							'type'       => Controls_Manager::DIMENSIONS,
							'size_units' => [ 'px', '%' ],
							'selectors'  => [
								'{{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							],
						]
					);

					$this->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'name'     => 'all_button_box_shadow',
							'selector' => '{{WRAPPER}} .elementor-button',
						]
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'all_button_hover',
					[
						'label' => esc_html__( 'Hover', 'gyan-elements' ),
					]
				);

					$this->add_control(
						'all_hover_color',
						[
							'label'     => esc_html__( 'Text Color', 'gyan-elements' ),
							'type'      => Controls_Manager::COLOR,
							'default' 	=> '#ffffff',
							'selectors' => [
								'{{WRAPPER}} a.elementor-button:hover' => 'color: {{VALUE}};',
							],
						]
					);

					$this->add_group_control(
						Group_Control_Background::get_type(),
						[
							'name'           => 'all_background_hover_color',
							'label'          => esc_html__( 'Background Color', 'gyan-elements' ),
							'types'          => [ 'classic', 'gradient' ],
							'selector'       => '{{WRAPPER}} a.elementor-button:hover',
							'fields_options' => [
								'background' => [
									'default' =>'classic',
								],
								'color' => [
									'scheme' => [
										'type'  => Scheme_Color::get_type(),
										'value' => Scheme_Color::COLOR_4,
									],
									'default' 		=> '#252628',
								],
							],
						]
					);

					$this->add_control(
						'all_border_hover_color',
						[
							'label'     => esc_html__( 'Border Hover Color', 'gyan-elements' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} a.elementor-button:hover' => 'border-color: {{VALUE}};',
							],
						]
					);

					$this->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'name'      => 'all_button_hover_box_shadow',
							'selector'  => '{{WRAPPER}} .elementor-button:hover',
							'separator' => 'after',
						]
					);

					$this->add_control(
						'hover_animation',
						[
							'label'       => esc_html__( 'Hover Animation', 'gyan-elements' ),
							'type'        => Controls_Manager::HOVER_ANIMATION,
							'label_block' => false,
						]
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();


		$this->start_controls_section(
			'general_colors',
			[
				'label' => esc_html__( 'Content', 'gyan-elements' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'text_align',
				[
					'label'        => esc_html__( 'Alignment', 'gyan-elements' ),
					'type'         => Controls_Manager::CHOOSE,
					'options'      => [
						'left'   => [
							'title' => esc_html__( 'Left', 'gyan-elements' ),
							'icon'  => 'fa fa-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'gyan-elements' ),
							'icon'  => 'fa fa-align-center',
						],
						'right'  => [
							'title' => esc_html__( 'Right', 'gyan-elements' ),
							'icon'  => 'fa fa-align-right',
						],
					],
					'default'      => 'center',
					'toggle'       => false,
					'prefix_class' => 'gyan-mbutton-text-',
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'all_typography',
					'label'    => esc_html__( 'Title Typography', 'gyan-elements' ),
					'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
					'selector' => '{{WRAPPER}} .gyan-hot-button-title',
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'desc_typography',
					'label'    => esc_html__( 'Description Typography', 'gyan-elements' ),
					'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
					'selector' => '{{WRAPPER}} .gyan-hot-button .gyan-hot-button-desc',
				]
			);

			$this->add_responsive_control(
				'title_margin_bottom',
				[
					'label'      => esc_html__( 'Space between Title & Description', 'gyan-elements' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'em', 'rem' ],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .gyan-hot-button .elementor-button-content-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();
	}

	protected function render_button_text() {

		$settings = $this->get_settings();

		$this->add_render_attribute( 'content-wrapper', 'class', 'elementor-button-content-wrapper' );
		if ( '' !== $settings['icon'] ) {
			$this->add_render_attribute( 'content-wrapper', 'class', 'gyan-buttons-icon-' . $settings['icon_align'] );
		}

		$this->add_render_attribute( 'icon-align', 'class', 'elementor-align-icon-' . $settings['icon_align'] );
		$this->add_render_attribute( 'icon-align', 'class', 'elementor-button-icon gyan-icon' );

		$this->add_render_attribute( 'btn-text', 'class', 'elementor-button-text' );
		$this->add_render_attribute( 'btn-text', 'class', 'gyan-hot-button-title' );

		?>
		<?php if ( ! empty( $settings['icon'] ) && ( 'all_left' == $settings['icon_align'] || 'all_right' == $settings['icon_align'] ) ) : ?>
			<span <?php echo $this->get_render_attribute_string( 'icon-align' ); ?>>
				<?php Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
			</span>
		<?php endif; ?>
		<span class="gyan-hot-buttons-wrap">
			<span <?php echo $this->get_render_attribute_string( 'content-wrapper' ); ?>>
				<?php if ( ! empty( $settings['icon'] ) && ( 'left' == $settings['icon_align'] || 'right' == $settings['icon_align'] ) ) : ?>
					<span <?php echo $this->get_render_attribute_string( 'icon-align' ); ?>>
						<?php Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
					</span>
				<?php endif; ?>
				<span <?php echo $this->get_render_attribute_string( 'btn-text' ); ?>><?php echo $settings['text']; ?></span>
			</span>
			<?php if ( '' !== $settings['desc_text'] ) { ?>
				<span class="gyan-hot-button-desc"><?php echo $settings['desc_text']; ?></span>
			<?php } ?>
		</span>
		<?php
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 'gyan-button-wrapper elementor-button-wrapper' );

		if ( ! empty( $settings['link']['url'] ) ) {
			$this->add_render_attribute( 'button', 'href', $settings['link']['url'] );
			$this->add_render_attribute( 'button', 'class', 'elementor-button-link' );

			if ( $settings['link']['is_external'] ) {
				$this->add_render_attribute( 'button', 'target', '_blank' );
			}
			if ( $settings['link']['nofollow'] ) {
				$this->add_render_attribute( 'button', 'rel', 'nofollow' );
			}
		}

		$this->add_render_attribute( 'button', 'class', 'elementor-button' );

		if ( ! empty( $settings['size'] ) ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['size'] );
		}
		if ( '' !== $settings['icon'] ) {
			$this->add_render_attribute( 'button', 'class', 'gyan-hot-buttons-' . $settings['icon_align'] );
		}

		if ( $settings['hover_animation'] ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
		}
		?>
		<div class="gyan-hot-button">
			<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
				<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
					<?php $this->render_button_text(); ?>
				</a>
			</div>
		</div>
		<?php
	}

	protected function _content_template() {}

}