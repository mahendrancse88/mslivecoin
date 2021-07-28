<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Gyan_Dual_Color_Heading extends Widget_Base {

	public function get_name()           { return 'gyan_dual_color_heading'; }
	public function get_title()          { return esc_html__( 'Dual Heading', 'gyan-elements' ); }
	public function get_icon()           { return 'gyan-el-icon eicon-heading'; }
	public function get_categories()     { return ['gyan-basic-addons' ]; }
	public function get_keywords()       { return ['gyan dual heading', 'gyan dual title', 'dual text','title','heading' ]; }
	public function get_style_depends()  { return ['gyan-dual-color-heading']; }

	protected function register_controls() {

		$this->start_controls_section(
			'section_headings_field',
			[
				'label' => esc_html__( 'Heading Text', 'gyan-elements' ),
			]
		);
		$this->add_control(
			'before_heading_text',
			[

				'label'    => esc_html__( 'Before Text', 'gyan-elements' ),
				'type'     => Controls_Manager::TEXT,
				'selector' => '{{WRAPPER}} .gyan-heading-text',
				'dynamic'  => [
					'active' => true,
				],
				'default'  => esc_html__( 'I love', 'gyan-elements' ),
			]
		);
		$this->add_control(
			'second_heading_text',
			[
				'label'    => esc_html__( 'Highlighted Text', 'gyan-elements' ),
				'type'     => Controls_Manager::TEXT,
				'selector' => '{{WRAPPER}} .gyan-highlight-text',
				'dynamic'  => [
					'active' => true,
				],
				'default'  => esc_html__( 'this website', 'gyan-elements' ),
			]
		);
		$this->add_control(
			'after_heading_text',
			[
				'label'    => esc_html__( 'After Text', 'gyan-elements' ),
				'type'     => Controls_Manager::TEXT,
				'dynamic'  => [
					'active' => true,
				],
				'selector' => '{{WRAPPER}} .gyan-dual-heading-text',
			]
		);
		$this->add_control(
			'heading_link',
			[
				'label'       => esc_html__( 'Link', 'gyan-elements' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'gyan-elements' ),
				'dynamic'     => [
					'active' => true,
				],
				'default'     => [
					'url' => '',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_field',
			[
				'label' => esc_html__( 'General', 'gyan-elements' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'dual_tag_selection',
			[
				'label'   => esc_html__( 'Select Tag', 'gyan-elements' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'h1'   => esc_html__( 'H1', 'gyan-elements' ),
					'h2'   => esc_html__( 'H2', 'gyan-elements' ),
					'h3'   => esc_html__( 'H3', 'gyan-elements' ),
					'h4'   => esc_html__( 'H4', 'gyan-elements' ),
					'h5'   => esc_html__( 'H5', 'gyan-elements' ),
					'h6'   => esc_html__( 'H6', 'gyan-elements' ),
					'div'  => esc_html__( 'div', 'gyan-elements' ),
					'span' => esc_html__( 'span', 'gyan-elements' ),
					'p'    => esc_html__( 'p', 'gyan-elements' ),
				],
				'default' => 'h3',
			]
		);

		$this->add_responsive_control(
			'dual_color_alignment',
			[
				'label'     => esc_html__( 'Alignment', 'gyan-elements' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
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
				'default'   => 'left',
				'selectors' => [
					'{{WRAPPER}} .gyan-dual-color-heading' => 'text-align: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'heading_layout',
			[
				'label'        => esc_html__( 'Layout', 'gyan-elements' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Stack', 'gyan-elements' ),
				'label_off'    => esc_html__( 'Inline', 'gyan-elements' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'prefix_class' => 'gyan-stack-desktop-',
			]
		);
		$this->add_control(
			'heading_stack_on',
			[
				'label'        => esc_html__( 'Responsive Support', 'gyan-elements' ),
				'description'  => esc_html__( 'Choose on what breakpoint the heading will stack.', 'gyan-elements' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'none',
				'options'      => [
					'none'   => esc_html__( 'No', 'gyan-elements' ),
					'tablet' => esc_html__( 'For Tablet & Mobile', 'gyan-elements' ),
					'mobile' => esc_html__( 'For Mobile Only', 'gyan-elements' ),
				],
				'condition'    => [
					'heading_layout!' => 'yes',
				],
				'prefix_class' => 'gyan-heading-stack-',
			]
		);

		$this->add_responsive_control(
			'heading_margin',
			[
				'label'      => esc_html__( 'Spacing Between Headings', 'gyan-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'default'    => [
					'size' => '10',
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gyan-before-heading' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .gyan-after-heading'  => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.gyan-stack-desktop-yes .gyan-before-heading' => 'margin-bottom: {{SIZE}}{{UNIT}}; margin-right: 0px; display: inline-block;',
					'{{WRAPPER}}.gyan-stack-desktop-yes .gyan-after-heading' => 'margin-top: {{SIZE}}{{UNIT}}; margin-left: 0px; display: inline-block;',
					'(tablet){{WRAPPER}}.gyan-heading-stack-tablet .gyan-before-heading ' => 'margin-bottom: {{SIZE}}{{UNIT}}; margin-right: 0px; display: inline-block;',
					'(tablet){{WRAPPER}}.gyan-heading-stack-tablet .gyan-after-heading ' => 'margin-top: {{SIZE}}{{UNIT}}; margin-left: 0px; display: inline-block;',
					'(mobile){{WRAPPER}}.gyan-heading-stack-mobile .gyan-before-heading ' => 'margin-bottom: {{SIZE}}{{UNIT}}; margin-right: 0px; display: inline-block;',
					'(mobile){{WRAPPER}}.gyan-heading-stack-mobile .gyan-after-heading ' => 'margin-top: {{SIZE}}{{UNIT}}; margin-left: 0px; display: inline-block;',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'heading_style_fields',
			[
				'label' => esc_html__( 'Heading Style', 'gyan-elements' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_heading' );

		$this->start_controls_tab(
			'tab_heading',
			[
				'label' => esc_html__( 'Normal', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'first_heading_color',
			[
				'label'     => esc_html__( 'Text Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'default'   => '#032e42',
				'selectors' => [
					'{{WRAPPER}} .gyan-dual-heading-text' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'before_heading_text_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .gyan-dual-heading-text',
			]
		);
		$this->add_control(
			'heading_adv_options',
			[
				'label'        => esc_html__( 'Advanced', 'gyan-elements' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'gyan-elements' ),
				'label_off'    => esc_html__( 'No', 'gyan-elements' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'heading_bg_color',
				'label'     => esc_html__( 'Background Color', 'gyan-elements' ),
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .gyan-dual-heading-text',
				'condition' => [
					'heading_adv_options' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'heading_padding',
			[
				'label'      => esc_html__( 'Padding', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-dual-heading-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'    => [
					'top'    => 0,
					'bottom' => 0,
					'left'   => 0,
					'right'  => 0,
					'unit'   => 'px',
				],
				'condition'  => [
					'heading_adv_options' => 'yes',
				],

			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'heading_text_border',
				'label'       => esc_html__( 'Border', 'gyan-elements' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .gyan-dual-heading-text',
				'condition'   => [
					'heading_adv_options' => 'yes',
				],
			]
		);
		$this->add_control(
			'heading_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-dual-heading-text, {{WRAPPER}} .gyan-dual-heading-text.gyan-highlight-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'heading_adv_options' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'      => 'dual_text_shadow',
				'selector'  => '{{WRAPPER}} .gyan-dual-heading-text',
				'condition' => [
					'heading_adv_options' => 'yes',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_highlight',
			[
				'label' => esc_html__( 'Highlight', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'second_heading_color',
			[
				'label'     => esc_html__( 'Highlight Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
				'default'   => '#d83030',
				'selectors' => [
					'{{WRAPPER}} .gyan-dual-heading-text.gyan-highlight-text' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'second_heading_text_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .gyan-dual-heading-text.gyan-highlight-text',
			]
		);
		$this->add_control(
			'highlight_adv_options',
			[
				'label'        => esc_html__( 'Advanced', 'gyan-elements' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'gyan-elements' ),
				'label_off'    => esc_html__( 'No', 'gyan-elements' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'highlight_bg_color',
				'label'     => esc_html__( 'Background Color', 'gyan-elements' ),
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .gyan-dual-heading-text.gyan-highlight-text',
				'condition' => [
					'highlight_adv_options' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'heading_highlight_padding',
			[
				'label'      => esc_html__( 'Padding', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [
					'top'    => 0,
					'bottom' => 0,
					'left'   => 0,
					'right'  => 0,
					'unit'   => 'px',
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-dual-heading-text.gyan-highlight-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'highlight_adv_options' => 'yes',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'highlight_text_border',
				'label'       => esc_html__( 'Border', 'gyan-elements' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .gyan-dual-heading-text.gyan-highlight-text',
				'condition'   => [
					'highlight_adv_options' => 'yes',
				],
			]
		);
		$this->add_control(
			'heading_highlight_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-dual-heading-text.gyan-highlight-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'highlight_adv_options' => 'yes',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'      => 'dual_highlight_shadow',
				'selector'  => '{{WRAPPER}} .gyan-dual-heading-text.gyan-highlight-text',
				'condition' => [
					'highlight_adv_options' => 'yes',
				],
			]
		);
		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		ob_start();
		?>
		<div class="gyan-module-content gyan-dual-color-heading">
			<<?php echo $settings['dual_tag_selection']; ?>>
				<?php if ( ! empty( $settings['heading_link']['url'] ) ) { ?>
					<a href="<?php echo esc_url( $settings['heading_link']['url'] ); ?>"
					<?php if ( 'on' == $settings['heading_link']['is_external'] ): ?>
						target="_blank"
					<?php endif; ?>
					<?php if ( 'on' == $settings['heading_link']['nofollow'] ): ?>
						rel="nofollow"
					<?php endif; ?>>
				<?php } ?>
						<span class="gyan-before-heading"><span class="gyan-dual-heading-text gyan-first-text"><?php echo $this->get_settings_for_display( 'before_heading_text'); ?></span></span><span class="gyan-adv-heading-stack"><span class="gyan-dual-heading-text gyan-highlight-text"><?php echo $this->get_settings_for_display( 'second_heading_text'); ?></span></span><?php if ( ! empty( $settings['after_heading_text'] ) ) { ?><span class="gyan-after-heading"><span class="gyan-dual-heading-text gyan-third-text"><?php echo $this->get_settings_for_display( 'after_heading_text'); ?></span></span><?php } ?>
				<?php if ( ! empty( $settings['heading_link']['url'] ) ) { ?>
					</a>
				<?php } ?>
			</<?php echo $settings['dual_tag_selection']; ?>>
		</div>
		<?php
		$html = ob_get_clean();
		echo $html;
	}

	protected function _content_template() {}
}