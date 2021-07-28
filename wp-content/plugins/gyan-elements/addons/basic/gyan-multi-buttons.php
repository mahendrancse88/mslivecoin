<?php
// Elementor Classes.
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Scheme_Color;
use Elementor\Repeater;
use Elementor\Widget_Button;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

class Gyan_Multi_Buttons extends Widget_Base {

	public function get_name()           { return 'gyan_multi_buttons'; }
	public function get_title()          { return esc_html__( 'Multi Buttons', 'gyan-elements' ); }
	public function get_icon()           { return 'gyan-el-icon eicon-dual-button'; }
	public function get_categories()     { return ['gyan-basic-addons']; }
	public function get_keywords()       { return ['gyan multi buttons', 'gyan buttons', 'multi buttons']; }
	public function get_style_depends()  { return ['gyan-icon','gyan-multi-buttons']; }

	public static function get_button_sizes() {
		return Widget_Button::get_button_sizes();
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_buttons',
			[
				'label' => esc_html__( 'Button', 'gyan-elements' ),
			]
		);

			$repeater = new Repeater();

				$repeater->start_controls_tabs( 'button_repeater' );

					$repeater->start_controls_tab(
						'button_general',
						[
							'label' => esc_html__( 'General', 'gyan-elements' ),
						]
					);

					$repeater->add_control(
						'text',
						[
							'label'       => esc_html__( 'Text', 'gyan-elements' ),
							'type'        => Controls_Manager::TEXT,
							'default'     => esc_html__( 'Click Me', 'gyan-elements' ),
							'placeholder' => esc_html__( 'Click Me', 'gyan-elements' ),
							'dynamic'     => [
								'active' => true,
							],
						]
					);

					$repeater->add_control(
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

					$repeater->add_control(
						'icon',
						[
							'label' => esc_html__( 'Icon', 'elementor' ),
							'type' => Controls_Manager::ICONS,
							'default' => [
								'value' => 'fas fa-star',
								'library' => 'fa-solid',
							],
						]
					);

					$repeater->add_control(
						'icon_align',
						[
							'label'     => esc_html__( 'Icon Position', 'gyan-elements' ),
							'type'      => Controls_Manager::SELECT,
							'default'   => 'left',
							'options'   => [
								'left'  => esc_html__( 'Before', 'gyan-elements' ),
								'right' => esc_html__( 'After', 'gyan-elements' ),
							],
							'condition' => [
								'icon!' => '',
							],
						]
					);

					$repeater->add_control(
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
								'{{WRAPPER}} {{CURRENT_ITEM}} .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
								'{{WRAPPER}} {{CURRENT_ITEM}} .elementor-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
							],
						]
					);

					$repeater->add_control(
						'css_id',
						[
							'label'       => esc_html__( 'CSS ID', 'gyan-elements' ),
							'type'        => Controls_Manager::TEXT,
							'default'     => '',
							'label_block' => true,
							'title'       => esc_html__( 'Add custom id for this button. Do not add # key.', 'gyan-elements' ),
						]
					);

					$repeater->add_control(
						'css_classes',
						[
							'label'       => esc_html__( 'CSS Classes', 'gyan-elements' ),
							'type'        => Controls_Manager::TEXT,
							'default'     => '',
							'label_block' => true,
							'title'       => esc_html__( 'Add custom class for this button. Do not add DOT before class name.', 'gyan-elements' ),
						]
					);

				$repeater->end_controls_tab();

				$repeater->start_controls_tab(
					'button_design',
					[
						'label' => esc_html__( 'Design', 'gyan-elements' ),
					]
				);

					$repeater->add_control(
						'html_message',
						[
							'type'            => Controls_Manager::RAW_HTML,
							'raw'             => esc_html__( 'You can add custom style for this button or leave it for default style.', 'gyan-elements' ),
							'content_classes' => 'elementor-control-field-description',
						]
					);

					$repeater->add_control(
						'color_options',
						[
							'label'     => esc_html__( 'Normal', 'gyan-elements' ),
							'type'      => Controls_Manager::HEADING,
							'separator' => 'before',
						]
					);

					$repeater->add_control(
						'btn_text_color',
						[
							'label'     => esc_html__( 'Text Color', 'gyan-elements' ),
							'type'      => Controls_Manager::COLOR,
							'default' => '#ffffff',
							'selectors' => [
								'{{WRAPPER}} {{CURRENT_ITEM}} .elementor-button' => 'color: {{VALUE}};',
							],
						]
					);

					$repeater->add_control(
						'btn_background_color',
						[
							'label'     => esc_html__( 'Background Color', 'gyan-elements' ),
							'type'      => Controls_Manager::COLOR,
							'default' => '#d83030',
							'scheme'    => [
								'type'  => Scheme_Color::get_type(),
								'value' => Scheme_Color::COLOR_4,
							],
							'selectors' => [
								'{{WRAPPER}} {{CURRENT_ITEM}} .elementor-button' => 'background-color: {{VALUE}};',
							],
						]
					);

					$repeater->add_group_control(
						Group_Control_Border::get_type(),
						[
							'name'      => 'btn_border',
							'label'     => esc_html__( 'Border', 'gyan-elements' ),
							'selector'  => '{{WRAPPER}} {{CURRENT_ITEM}} .elementor-button',
							'separator' => 'before',
						]
					);

					$repeater->add_control(
						'btn_border_radius',
						[
							'label'      => esc_html__( 'Border Radius', 'gyan-elements' ),
							'type'       => Controls_Manager::DIMENSIONS,
							'size_units' => [ 'px', '%' ],
							'selectors'  => [
								'{{WRAPPER}} {{CURRENT_ITEM}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							],
						]
					);

					$repeater->add_control(
						'hover_options',
						[
							'label' => esc_html__( 'Hover', 'gyan-elements' ),
							'type'  => Controls_Manager::HEADING,
						]
					);

					$repeater->add_control(
						'btn_text_hover_color',
						[
							'label'     => esc_html__( 'Text Color', 'gyan-elements' ),
							'type'      => Controls_Manager::COLOR,
							'default' => '#ffffff',
							'selectors' => [
								'{{WRAPPER}} {{CURRENT_ITEM}} .elementor-button:hover' => 'color: {{VALUE}};',
							],
						]
					);

					$repeater->add_control(
						'btn_background_hover_color',
						[
							'label'     => esc_html__( 'Background Color', 'gyan-elements' ),
							'type'      => Controls_Manager::COLOR,
							'default' => '#252628',
							'scheme'    => [
								'type'  => Scheme_Color::get_type(),
								'value' => Scheme_Color::COLOR_4,
							],
							'selectors' => [
								'{{WRAPPER}} {{CURRENT_ITEM}} .elementor-button:hover' => 'background-color: {{VALUE}};',
							],
						]
					);

					$repeater->add_control(
						'btn_border_hover_color',
						[
							'label'     => esc_html__( 'Border Hover Color', 'gyan-elements' ),
							'type'      => Controls_Manager::COLOR,
							'scheme'    => [
								'type'  => Scheme_Color::get_type(),
								'value' => Scheme_Color::COLOR_4,
							],
							'selectors' => [
								'{{WRAPPER}} {{CURRENT_ITEM}} .elementor-button:hover' => 'border-color: {{VALUE}};',
							],
						]
					);

					$repeater->add_group_control(
						Group_Control_Typography::get_type(),
						[
							'name'     => 'btn_typography',
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
							    		'size' => '27',
							    	],
							    ],
							    'font_weight' => [
							        'default' => '700',
							    ],
							],
							'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} a.elementor-button, {{WRAPPER}} {{CURRENT_ITEM}} a.elementor-button .elementor-button-icon i',
						]
					);

				$repeater->end_controls_tab();

			$repeater->end_controls_tabs();

			$this->add_control(
				'buttons',
				[
					'label'       => esc_html__( 'Buttons', 'gyan-elements' ),
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater->get_controls(),
					'show_label'  => true,
					'title_field' => '{{{ text }}}',
					'default'     => [
						[
							'text' => esc_html__( 'Button One', 'gyan-elements' ),
						],
						[
							'text' => esc_html__( 'Button Two', 'gyan-elements' ),
						],
					],
				]
			);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_styling',
			[
				'label' => esc_html__( 'Design', 'gyan-elements' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_responsive_control(
				'padding',
				[
					'label'      => esc_html__( 'Padding', 'gyan-elements' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'default' => [
						'top' => '14',
						'right' => '35',
						'bottom' => '14',
						'left' => '35',
						'isLinked' => false,
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'all_typography',
					'fields_options' => [
					    'typography' => [
					        'default' =>'custom',
					    ],
					    'font_size'   => [
					        'default' => [
					            'unit' => 'px',
					            'size' => '16',
					        ],
					    ],
					    'line_height'   => [
							'default' => [
								'size' => '27',
							],
						],
					    'font_weight' => [
					        'default' => '700',
					    ],
					],
					'selector' => '{{WRAPPER}} a.elementor-button, {{WRAPPER}} a.elementor-button .elementor-button-icon i',
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
					'prefix_class' => 'gyan%s-button-halign-',
				]
			);

			$this->add_control(
				'hover_animation',
				[
					'label' => esc_html__( 'Hover Animation', 'gyan-elements' ),
					'type'  => Controls_Manager::HOVER_ANIMATION,
				]
			);

		$this->end_controls_section();


		$this->start_controls_section(
			'general_colors',
			[
				'label' => esc_html__( 'Styling', 'gyan-elements' ),
				'tab'   => Controls_Manager::TAB_STYLE,
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
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} .gyan-multi-button a.elementor-button' => 'color: {{VALUE}};',
								'{{WRAPPER}} .gyan-multi-button a.elementor-button .elementor-button-icon svg' => 'fill: {{VALUE}};',
							],
						]
					);

					$this->add_control(
						'all_background_color',
						[
							'label'     => esc_html__( 'Background Color', 'gyan-elements' ),
							'type'      => Controls_Manager::COLOR,
							'scheme'    => [
								'type'  => Scheme_Color::get_type(),
								'value' => Scheme_Color::COLOR_4,
							],
							'selectors' => [
								'{{WRAPPER}} .gyan-multi-button a.elementor-button' => 'background-color: {{VALUE}};',
							],
						]
					);

					$this->add_group_control(
						Group_Control_Border::get_type(),
						[
							'name'     => 'all_border',
							'label'    => esc_html__( 'Border', 'gyan-elements' ),
							'selector' => '{{WRAPPER}} .gyan-multi-button .elementor-button',
						]
					);

					$this->add_control(
						'all_border_radius',
						[
							'label'      => esc_html__( 'Border Radius', 'gyan-elements' ),
							'type'       => Controls_Manager::DIMENSIONS,
							'size_units' => [ 'px', '%' ],
							'selectors'  => [
								'{{WRAPPER}} .gyan-multi-button .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							],
						]
					);

					$this->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'name'     => 'all_button_box_shadow',
							'selector' => '{{WRAPPER}} .gyan-multi-button .elementor-button',
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
							'selectors' => [
								'{{WRAPPER}} .gyan-multi-button a.elementor-button:hover' => 'color: {{VALUE}};',
								'{{WRAPPER}} .gyan-multi-button a.elementor-button:hover .elementor-button-icon svg' => 'fill: {{VALUE}};',
							],
						]
					);

					$this->add_control(
						'all_background_hover_color',
						[
							'label'     => esc_html__( 'Background Color', 'gyan-elements' ),
							'type'      => Controls_Manager::COLOR,
							'scheme'    => [
								'type'  => Scheme_Color::get_type(),
								'value' => Scheme_Color::COLOR_4,
							],
							'selectors' => [
								'{{WRAPPER}} .gyan-multi-button a.elementor-button:hover' => 'background-color: {{VALUE}};',
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
								'{{WRAPPER}} .gyan-multi-button a.elementor-button:hover' => 'border-color: {{VALUE}};',
							],
						]
					);

					$this->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'name'      => 'all_button_hover_box_shadow',
							'selector'  => '{{WRAPPER}} .gyan-multi-button .elementor-button:hover',
							'separator' => 'after',
						]
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();


		$this->start_controls_section(
			'general_spacing',
			[
				'label' => esc_html__( 'Spacing', 'gyan-elements' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_responsive_control(
				'gap',
				[
					'label'      => esc_html__( 'Space between buttons', 'gyan-elements' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'em', 'rem' ],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 1000,
						],
					],
					'default'    => [
						'size' => 10,
						'unit' => 'px',
					],
					'selectors'  => [
						'{{WRAPPER}} .gyan-multi-button-wrap .gyan-button-wrapper' => 'margin-right: calc( {{SIZE}}{{UNIT}} / 2) ; margin-left: calc( {{SIZE}}{{UNIT}} / 2);',
						'{{WRAPPER}}.gyan-button-stack-none .gyan-multi-button-wrap' => 'margin-right: calc( -{{SIZE}}{{UNIT}} / 2) ; margin-left: calc( -{{SIZE}}{{UNIT}} / 2);',
						'(desktop){{WRAPPER}}.gyan-button-stack-desktop .gyan-multi-button-wrap .gyan-button-wrapper'  => 'margin-bottom: calc( {{SIZE}}{{UNIT}} / 2 ); margin-top: calc( {{SIZE}}{{UNIT}} / 2 ); margin-right: 0; margin-left: 0;',
						'(desktop){{WRAPPER}}.gyan-button-stack-desktop .gyan-multi-button-wrap .gyan-button-wrapper:last-child' => 'margin-bottom: 0;',
						'(desktop){{WRAPPER}}.gyan-button-stack-desktop .gyan-multi-button-wrap .gyan-button-wrapper:first-child' => 'margin-top: 0;',
						'(tablet){{WRAPPER}}.gyan-button-stack-tablet .gyan-multi-button-wrap .gyan-button-wrapper'        => 'margin-bottom: calc( {{SIZE}}{{UNIT}} / 2 ); margin-top: calc( {{SIZE}}{{UNIT}} / 2 ); margin-right: 0; margin-left: 0;',
						'(tablet){{WRAPPER}}.gyan-button-stack-tablet .gyan-multi-button-wrap .gyan-button-wrapper:last-child' => 'margin-bottom: 0;',
						'(tablet){{WRAPPER}}.gyan-button-stack-tablet .gyan-multi-button-wrap .gyan-button-wrapper:first-child' => 'margin-top: 0;',
						'(mobile){{WRAPPER}}.gyan-button-stack-mobile .gyan-multi-button-wrap .gyan-button-wrapper'        => 'margin-bottom: calc( {{SIZE}}{{UNIT}} / 2 ); margin-top: calc( {{SIZE}}{{UNIT}} / 2 ); margin-right: 0; margin-left: 0;',
						'(mobile){{WRAPPER}}.gyan-button-stack-mobile .gyan-multi-button-wrap .gyan-button-wrapper:last-child' => 'margin-bottom: 0;',
						'(mobile){{WRAPPER}}.gyan-button-stack-mobile .gyan-multi-button-wrap .gyan-button-wrapper:first-child' => 'margin-top: 0;',
					],
				]
			);

			$this->add_control(
				'stack_on',
				[
					'label'        => esc_html__( 'Stack on', 'gyan-elements' ),
					'description'  => esc_html__( 'Choose on what breakpoint where the buttons will stack.', 'gyan-elements' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => 'none',
					'options'      => [
						'none'    => esc_html__( 'None', 'gyan-elements' ),
						'desktop' => esc_html__( 'Desktop', 'gyan-elements' ),
						'tablet'  => esc_html__( 'Tablet', 'gyan-elements' ),
						'mobile'  => esc_html__( 'Mobile', 'gyan-elements' ),
					],
					'prefix_class' => 'gyan-button-stack-',
				]
			);

		$this->end_controls_section();
	}



	protected function render_button_text( $button, $i ) {

		$settings = $this->get_settings();

		$this->add_render_attribute( 'content-wrapper-' . $i, 'class', 'elementor-button-content-wrapper' );
		if ( ! empty( $button['icon'] ) ) {
			$this->add_render_attribute( 'content-wrapper-' . $i, 'class', 'gyan-buttons-icon-' . $button['icon_align'] );
		}

		$this->add_render_attribute( 'icon-align_' . $i, 'class', 'elementor-align-icon-' . $button['icon_align'] );
		$this->add_render_attribute( 'icon-align_' . $i, 'class', 'gyan-icon elementor-button-icon' );

		$this->add_render_attribute( 'btn-text_' . $i, 'class', 'elementor-button-text' );
		$this->add_render_attribute( 'btn-text_' . $i, 'class', 'elementor-inline-editing' );

		$text_key = $this->get_repeater_setting_key( 'text', 'buttons', $i );
		$this->add_inline_editing_attributes( $text_key, 'none' );
		?>
		<span <?php echo $this->get_render_attribute_string( 'content-wrapper-' . $i ); ?>>
			<?php if ( ! empty( $button['icon'] ) ) : ?>
			<span <?php echo $this->get_render_attribute_string( 'icon-align_' . $i ); ?>>
				<?php Icons_Manager::render_icon( $button['icon'], [ 'aria-hidden' => 'true' ] ); ?>
			</span>
			<?php endif; ?>
			<span <?php echo $this->get_render_attribute_string( 'btn-text_' . $i ); ?>><?php echo $button['text']; ?></span>
		</span>
		<?php
	}


	protected function render() {

		$settings = $this->get_settings_for_display();
		$node_id  = $this->get_id();
		ob_start();
		?>
		<div class="gyan-multi-button-outer-wrap">
			<div class="gyan-multi-button-wrap">
				<?php
				for ( $i = 0; $i < count( $settings['buttons'] ); $i++ ) :
					if ( ! is_array( $settings['buttons'][ $i ] ) ) {
						continue;
					}
					$button = $settings['buttons'][ $i ];

					$this->add_render_attribute( 'button_wrap_' . $i, 'class', 'gyan-button-wrapper elementor-button-wrapper gyan-multi-button' );
					$this->add_render_attribute( 'button_wrap_' . $i, 'class', 'elementor-repeater-item-' . $button['_id'] );
					$this->add_render_attribute( 'button_wrap_' . $i, 'class', 'gyan-multi-button-' . $i );

					$this->add_render_attribute( 'button_' . $i, 'class', 'elementor-button-link elementor-button' );

					if ( '' != $button['css_classes'] ) {
						$this->add_render_attribute( 'button_' . $i, 'class', $button['css_classes'] );
					}

					if ( '' != $button['css_id'] ) {
						$this->add_render_attribute( 'button_' . $i, 'id', $button['css_id'] );
					}

					if ( ! empty( $button['link']['url'] ) ) {
						$this->add_render_attribute( 'button_' . $i, 'href', $button['link']['url'] );
						$this->add_render_attribute( 'button_' . $i, 'class', 'elementor-button-link' );

						if ( $button['link']['is_external'] ) {
							$this->add_render_attribute( 'button_' . $i, 'target', '_blank' );
						}

						if ( $button['link']['nofollow'] ) {
							$this->add_render_attribute( 'button_' . $i, 'rel', 'nofollow' );
						}
					}

					if ( $settings['hover_animation'] ) {
						$this->add_render_attribute( 'button_' . $i, 'class', 'elementor-animation-' . $settings['hover_animation'] );
					}
					?>
				<div <?php echo $this->get_render_attribute_string( 'button_wrap_' . $i ); ?>>
					<a <?php echo $this->get_render_attribute_string( 'button_' . $i ); ?>>
						<?php $this->render_button_text( $button, $i ); ?>
					</a>
				</div>
				<?php endfor; ?>
			</div>
		</div>
		<?php
		$html = ob_get_clean();
		echo $html;
	}

	protected function _content_template() {}

}