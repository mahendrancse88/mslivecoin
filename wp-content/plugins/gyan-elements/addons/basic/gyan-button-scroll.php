<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Gyan_Button_Scroll extends Widget_Base {

	public function get_name()           { return 'gyan_button_scroll'; }
	public function get_title()          { return esc_html__( 'Button Scroll', 'gyan-elements' ); }
	public function get_icon()           { return 'gyan-el-icon  eicon-download-button'; }
	public function get_categories()     { return ['gyan-basic-addons']; }
	public function get_keywords()       { return [ 'button', 'scroll', 'slide','up','down','link','top' ]; }
	public function get_style_depends()  { return ['gyan-button-scroll']; }
	public function get_script_depends() { return ['gyan-widgets']; }

	protected function register_controls() {
		$this->start_controls_section(
			'section_scroll_button',
			[
				'label' => esc_html__( 'Button', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'duration',
			[
				'label'      => esc_html__( 'Duration', 'gyan-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 100,
						'max'  => 5000,
						'step' => 50,
					],
				],
			]
		);

		$this->add_control(
			'offset',
			[
				'label' => esc_html__( 'Offset', 'gyan-elements' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => -200,
						'max'  => 200,
						'step' => 10,
					],
				],
			]
		);

		$this->add_control(
			'scroll_button_text',
			[
				'label'       => esc_html__( 'Button Text', 'gyan-elements' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'Scroll Down', 'gyan-elements' ),
				'placeholder' => esc_html__( 'Scroll Down', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'section_id',
			[
				'label'       => esc_html__( 'Section ID', 'gyan-elements' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'section-one',
				'description' => esc_html__( "When you click on scroll button, which section you want to display. Add that section's ID, for example 'section-one'. Do not add '#' tag before id name. ", 'gyan-elements' ),
			]
		);

		$this->add_responsive_control(
			'scroll_button_align',
			[
				'label'        => esc_html__( 'Button Alignment', 'gyan-elements' ),
				'type'         => Controls_Manager::CHOOSE,
				'prefix_class' => 'elementor%s-align-',
				'default'      => 'center',
				'options'      => [
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
					]
				]
			]
		);

		$this->add_control(
			'scroll_button_icon',
			[
				'label' => esc_html__( 'Button Icon', 'elementor' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-angle-down',
					'library' => 'fa-solid',
				],
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
					'scroll_button_icon!' => '',
				],
			]
		);

		$this->add_control(
			'icon_spacing',
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
					'scroll_button_icon!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-button-scroll .gyan-button-scroll-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .gyan-button-scroll .gyan-button-scroll-align-icon-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_scroll_button',
			[
				'label' => esc_html__( 'Button', 'gyan-elements' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_scroll_button_style' );

		$this->start_controls_tab(
			'tab_scroll_button_normal',
			[
				'label' => esc_html__( 'Normal', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'scroll_button_text_color',
			[
				'label'     => esc_html__( 'Button Text Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .gyan-button-scroll' => 'color: {{VALUE}};',
					'{{WRAPPER}} .gyan-button-scroll .gyan-bs-icon' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'scroll_button_background_color',
			[
				'label'     => esc_html__( 'Button Background Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default' => '#d83030',
				'selectors' => [
					'{{WRAPPER}} .gyan-button-scroll' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'scroll_button_border',
				'label'       => esc_html__( 'Border', 'gyan-elements' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .gyan-button-scroll',
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
					'{{WRAPPER}} .gyan-button-scroll' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'scroll_button_box_shadow',
				'selector' => '{{WRAPPER}} .gyan-button-scroll',
			]
		);

		$this->add_control(
			'scroll_button_padding',
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
					'{{WRAPPER}} .gyan-button-scroll' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'scroll_button_typography',
				'label'    => esc_html__( 'Typography', 'gyan-elements' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .gyan-button-scroll',
							  '{{WRAPPER}} .gyan-button-scroll .gyan-bs-icon',

			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_scroll_button_hover',
			[
				'label' => esc_html__( 'Hover', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'scroll_button_hover_color',
			[
				'label'     => esc_html__( 'Button Text Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .gyan-button-scroll:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .gyan-button-scroll:hover .gyan-bs-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'scroll_button_background_hover_color',
			[
				'label'     => esc_html__( 'Button Background Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default' => '#252628',
				'selectors' => [
					'{{WRAPPER}} .gyan-button-scroll:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'scroll_button_hover_border_color',
			[
				'label'     => esc_html__( 'Button Border Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'scroll_button_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-button-scroll:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'scroll_button_hover_animation',
			[
				'label' => esc_html__( 'Button Animation', 'gyan-elements' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render_text($settings) {
		$this->add_render_attribute( 'content-wrapper', 'class', 'gyan-button-scroll-content-wrapper' );
		$this->add_render_attribute( 'text', 'class', 'gyan-button-scroll-text' );

		?>
		<span <?php echo $this->get_render_attribute_string( 'content-wrapper' ); ?>>
			<?php if ( ! empty( $settings['scroll_button_icon'] ) ) : ?>
			<span class="gyan-button-scroll-align-icon-<?php echo $settings['icon_align']; ?> gyan-bs-icon">
				<?php Icons_Manager::render_icon( $settings['scroll_button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
			</span>
			<?php endif; ?>
			<span <?php echo $this->get_render_attribute_string( 'text' ); ?>><?php echo $settings['scroll_button_text']; ?></span>
		</span>
		<?php
	}

	protected function render() {
		$settings = $this->get_settings();

		$this->add_render_attribute( 'gyan-button-scroll', 'class', ['gyan-button-scroll', 'gyan-button', 'gyan-button-primary'] );

		if ( $settings['scroll_button_hover_animation'] ) {
			$this->add_render_attribute( 'gyan-button-scroll', 'class', 'elementor-animation-'.esc_attr($settings['scroll_button_hover_animation']) );
		}

		$this->add_render_attribute(
			[
				'gyan-button-scroll' => [
					'data-settings' => [
						wp_json_encode(array_filter([
							'duration' => ( '' != $settings['duration']['size'] ) ? $settings['duration']['size'] : '',
							'offset' => ( '' != $settings['offset']['size'] ) ? $settings['offset']['size'] : '',
				        ]))
					]
				]
			]
		);

		$this->add_render_attribute( 'gyan-button-scroll', 'data-selector', '#' . esc_attr($settings['section_id']) );
		$this->add_render_attribute( 'gyan-scroll-wrapper', 'class', 'gyan-button-scroll-wrapper' );

		?>
		<div <?php echo $this->get_render_attribute_string( 'gyan-scroll-wrapper' ); ?>>
			<div <?php echo $this->get_render_attribute_string( 'gyan-button-scroll' ); ?>>
				<?php $this->render_text($settings); ?>
			</div>
		</div>

		<?php
	}

	protected function _content_template() {}
}