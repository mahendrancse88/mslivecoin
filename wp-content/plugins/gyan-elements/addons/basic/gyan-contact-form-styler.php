<?php
// Elementor Classes.
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

class Gyan_Contact_Form_Styler extends Widget_Base {

	public function get_name()          { return 'gyan_contact_form_styler'; }
	public function get_title()         { return esc_html__( 'Contact Form 7 Styler', 'gyan-elements' ); }
	public function get_icon()          { return 'gyan-el-icon eicon-form-horizontal'; }
	public function get_categories()    { return ['gyan-basic-addons']; }
	public function get_keywords()      { return [ 'contact form', 'form', 'contact' ]; }
	public function get_style_depends() { return ['gyan-contact-form-7']; }
	public function get_script_depends() { return [ 'gyan-widgets' ]; }


	protected function get_cf7_forms() {

		$field_options = array();

		if ( class_exists( 'WPCF7_ContactForm' ) ) {
			$args               = array(
				'post_type'      => 'wpcf7_contact_form',
				'posts_per_page' => -1,
			);
			$forms              = get_posts( $args );
			$field_options['0'] = 'Select';
			if ( $forms ) {
				foreach ( $forms as $form ) {
					$field_options[ $form->ID ] = $form->post_title;
				}
			}
		}

		if ( empty( $field_options ) ) {
			$field_options = array(
				'-1' => esc_html__( 'Contact Form not found. Please add contact form from Dashboard > Contact > Add New.', 'gyan-elements' ),
			);
		}
		return $field_options;
	}

	protected function get_cf7_form_id() {
		if ( class_exists( 'WPCF7_ContactForm' ) ) {
			$args  = array(
				'post_type'      => 'wpcf7_contact_form',
				'posts_per_page' => -1,
			);
			$forms = get_posts( $args );

			if ( $forms ) {
				foreach ( $forms as $form ) {
					return $form->ID;
				}
			}
		}
		return -1;
	}

	protected function register_controls() {

		$this->register_general_content_controls();
		$this->register_input_style_controls();
		$this->register_radio_content_controls();
		$this->register_button_content_controls();
		$this->register_error_content_controls();
		$this->register_typography_style_controls();

	}

	protected function register_general_content_controls() {

		$this->start_controls_section(
			'section_general_field',
			[
				'label' => esc_html__( 'General', 'gyan-elements' ),
			]
		);
			$this->add_control(
				'select_form',
				[
					'label'   => esc_html__( 'Select Form', 'gyan-elements' ),
					'type'    => Controls_Manager::SELECT,
					'options' => $this->get_cf7_forms(),
					'default' => '0'
				]
			);

			$this->add_control(
				'cf7_style',
				[
					'label'        => esc_html__( 'Field Style', 'gyan-elements' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => 'box',
					'options'      => [
						'box'       => esc_html__( 'Box', 'gyan-elements' ),
						'underline' => esc_html__( 'Underline', 'gyan-elements' ),
					],
					'prefix_class' => 'gyan-cf7-style-',
				]
			);

			$this->add_responsive_control(
				'cf7_input_padding',
				[
					'label'      => esc_html__( 'Field Padding', 'gyan-elements' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .gyan-cf7-style input:not([type="submit"]):not([type="file"]),
						{{WRAPPER}} .gyan-cf7-icon i,
						{{WRAPPER}} .gyan-cf7-style select,
						{{WRAPPER}} .gyan-cf7-style textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .gyan-cf7-style select[multiple="multiple"]'  => 'padding: 0px;',
						'{{WRAPPER}} .gyan-cf7-style select[multiple="multiple"] option'  => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .gyan-cf7-style input[type="checkbox"] + span:before,{{WRAPPER}} .gyan-cf7-style input[type="radio"] + span:before' => 'height: {{TOP}}{{UNIT}}; width: {{TOP}}{{UNIT}};',
						'{{WRAPPER}}.gyan-cf7-style-underline input[type="checkbox"] + span:before,{{WRAPPER}} .gyan-cf7-style-underline input[type="radio"] + span:before' => 'height: {{TOP}}{{UNIT}}; width: {{TOP}}{{UNIT}};',
						'{{WRAPPER}} .gyan-cf7-style input[type="checkbox"]:checked + span:before, {{WRAPPER}}.gyan-cf7-style-underline input[type="checkbox"]:checked + span:before' => 'font-size: calc({{BOTTOM}}{{UNIT}} / 1.2);',
						'{{WRAPPER}} .gyan-cf7-style input[type=range]::-webkit-slider-thumb' => 'font-size: {{BOTTOM}}{{UNIT}};',
						'{{WRAPPER}} .gyan-cf7-style input[type=range]::-moz-range-thumb' => 'font-size: {{BOTTOM}}{{UNIT}};',
						'{{WRAPPER}} .gyan-cf7-style input[type=range]::-ms-thumb' => 'font-size: {{BOTTOM}}{{UNIT}};',
						'{{WRAPPER}} .gyan-cf7-style input[type=range]::-webkit-slider-runnable-track' => 'font-size: {{BOTTOM}}{{UNIT}};',
						'{{WRAPPER}} .gyan-cf7-style input[type=range]::-moz-range-track' => 'font-size: {{BOTTOM}}{{UNIT}};',
						'{{WRAPPER}} .gyan-cf7-style input[type=range]::-ms-fill-lower' => 'font-size: {{BOTTOM}}{{UNIT}};',
						'{{WRAPPER}} .gyan-cf7-style input[type=range]::-ms-fill-upper' => 'font-size: {{BOTTOM}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'cf7_input_bgcolor',
				[
					'label'     => esc_html__( 'Field Background Color', 'gyan-elements' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#ffffff',
					'selectors' => [
						'{{WRAPPER}} .gyan-cf7-style input:not([type=submit]):not([type="file"]), {{WRAPPER}} .gyan-cf7-style select, {{WRAPPER}} .gyan-cf7-style textarea, {{WRAPPER}} .gyan-cf7-style .wpcf7-checkbox input[type="checkbox"] + span:before,{{WRAPPER}} .gyan-cf7-style .wpcf7-acceptance input[type="checkbox"] + span:before, {{WRAPPER}} .gyan-cf7-style .wpcf7-radio input[type="radio"]:not(:checked) + span:before' => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .gyan-cf7-style input[type=range]::-webkit-slider-runnable-track,{{WRAPPER}} .gyan-cf7-style input[type=range]:focus::-webkit-slider-runnable-track' => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .gyan-cf7-style input[type=range]::-moz-range-track,{{WRAPPER}} input[type=range]:focus::-moz-range-track' => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .gyan-cf7-style input[type=range]::-ms-fill-lower,{{WRAPPER}} .gyan-cf7-style input[type=range]:focus::-ms-fill-lower' => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .gyan-cf7-style input[type=range]::-ms-fill-upper,{{WRAPPER}} .gyan-cf7-style input[type=range]:focus::-ms-fill-upper' => 'background-color: {{VALUE}};',
						'{{WRAPPER}}.gyan-cf7-style-box .wpcf7-radio input[type="radio"]:checked + span:before, {{WRAPPER}}.gyan-cf7-style-underline .wpcf7-radio input[type="radio"]:checked + span:before' => 'box-shadow:inset 0px 0px 0px 4px {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'cf7_label_color',
				[
					'label'     => esc_html__( 'Label Color', 'gyan-elements' ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_3,
					],
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .gyan-cf7-style .wpcf7 form.wpcf7-form:not(input)' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'cf7_input_color',
				[
					'label'     => esc_html__( 'Input Text', 'gyan-elements' ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_3,
					],
					'default'   => '#676767',
					'selectors' => [
						'{{WRAPPER}} .gyan-cf7-style .wpcf7 input:not([type=submit]),
						{{WRAPPER}} .gyan-cf7-style .wpcf7 select,
						{{WRAPPER}} .gyan-cf7-style .wpcf7 textarea,
						{{WRAPPER}} .gyan-cf7-style .gyan-cf7-select-custom:after' => 'color: {{VALUE}};',

						'{{WRAPPER}}.elementor-widget-gyan-cf7-styler .wpcf7-checkbox input[type="checkbox"]:checked + span:before,
						{{WRAPPER}}.elementor-widget-gyan-cf7-styler .wpcf7-acceptance input[type="checkbox"]:checked + span:before' => 'color: {{VALUE}};',

						'{{WRAPPER}}.gyan-cf7-style-box .wpcf7-radio input[type="radio"]:checked + span:before, {{WRAPPER}}.gyan-cf7-style-underline .wpcf7-radio input[type="radio"]:checked + span:before' => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .gyan-cf7-style input[type=range]::-webkit-slider-thumb' => 'border: 1px solid {{VALUE}}; background: {{VALUE}};',
						'{{WRAPPER}} .gyan-cf7-style input[type=range]::-moz-range-thumb' => 'border: 1px solid {{VALUE}}; background: {{VALUE}};',
						'{{WRAPPER}} .gyan-cf7-style input[type=range]::-ms-thumb' => 'border: 1px solid {{VALUE}}; background: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'cf7_input_placeholder_color',
				[
					'label'     => esc_html__( 'Placeholder Color', 'gyan-elements' ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_3,
					],
					'default'   => '#8d8d8d',
					'selectors' => [
						'{{WRAPPER}} .gyan-cf7-style .wpcf7 input::placeholder,
						{{WRAPPER}} .gyan-cf7-style .wpcf7 textarea::placeholder' => 'color: {{VALUE}};',
						'{{WRAPPER}} .gyan-cf7-style .wpcf7 input:not([type=submit])::-webkit-input-placeholder ' => 'color:{{VALUE}};',
						'{{WRAPPER}} .gyan-cf7-style .wpcf7 input:not([type=submit])::-moz-placeholder ' => 'color:{{VALUE}};',
						'{{WRAPPER}} .gyan-cf7-style .wpcf7 input:not([type=submit])::-ms-placeholder ' => 'color:{{VALUE}};',
						'{{WRAPPER}} .gyan-cf7-style .wpcf7 input:not([type=submit])::placeholder ' => 'color:{{VALUE}};',
					],
				]
			);

			$this->add_control(
				'input_border_style',
				[
					'label'       => esc_html__( 'Border Style', 'gyan-elements' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'solid',
					'label_block' => false,
					'options'     => [
						'none'   => esc_html__( 'None', 'gyan-elements' ),
						'solid'  => esc_html__( 'Solid', 'gyan-elements' ),
						'double' => esc_html__( 'Double', 'gyan-elements' ),
						'dotted' => esc_html__( 'Dotted', 'gyan-elements' ),
						'dashed' => esc_html__( 'Dashed', 'gyan-elements' ),
					],
					'condition'   => [
						'cf7_style' => 'box',
					],
					'selectors'   => [
						'{{WRAPPER}} .gyan-cf7-style input:not([type=submit]):not([type="file"]), {{WRAPPER}} .gyan-cf7-style select,{{WRAPPER}} .gyan-cf7-style textarea,{{WRAPPER}}.gyan-cf7-style-box .wpcf7-checkbox input[type="checkbox"]:checked + span:before, {{WRAPPER}}.gyan-cf7-style-box .wpcf7-checkbox input[type="checkbox"] + span:before,{{WRAPPER}}.gyan-cf7-style-box .wpcf7-acceptance input[type="checkbox"]:checked + span:before, {{WRAPPER}}.gyan-cf7-style-box .wpcf7-acceptance input[type="checkbox"] + span:before, {{WRAPPER}}.gyan-cf7-style-box .wpcf7-radio input[type="radio"] + span:before' => 'border-style: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'input_border_size',
				[
					'label'      => esc_html__( 'Border Width', 'gyan-elements' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'default'    => [
						'top'    => '2',
						'bottom' => '2',
						'left'   => '2',
						'right'  => '2',
						'unit'   => 'px',
					],
					'condition'  => [
						'cf7_style'           => 'box',
						'input_border_style!' => 'none',
					],
					'selectors'  => [
						'{{WRAPPER}} .gyan-cf7-style input:not([type=submit]):not([type="file"]), {{WRAPPER}} .gyan-cf7-style select,{{WRAPPER}} .gyan-cf7-style textarea,{{WRAPPER}}.gyan-cf7-style-box .wpcf7-checkbox input[type="checkbox"]:checked + span:before, {{WRAPPER}}.gyan-cf7-style-box .wpcf7-checkbox input[type="checkbox"] + span:before,{{WRAPPER}}.gyan-cf7-style-box .wpcf7-acceptance input[type="checkbox"]:checked + span:before, {{WRAPPER}}.gyan-cf7-style-box .wpcf7-acceptance input[type="checkbox"] + span:before,{{WRAPPER}}.gyan-cf7-style-box .wpcf7-radio input[type="radio"] + span:before' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'input_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'gyan-elements' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'cf7_style'           => 'box',
						'input_border_style!' => 'none',
					],
					'default'   => '#eeeeee',
					'selectors' => [
						'{{WRAPPER}} .gyan-cf7-style input:not([type=submit]), {{WRAPPER}} .gyan-cf7-style select,{{WRAPPER}} .gyan-cf7-style textarea,{{WRAPPER}}.gyan-cf7-style-box .wpcf7-checkbox input[type="checkbox"]:checked + span:before, {{WRAPPER}}.gyan-cf7-style-box .wpcf7-checkbox input[type="checkbox"] + span:before,{{WRAPPER}}.gyan-cf7-style-box .wpcf7-acceptance input[type="checkbox"]:checked + span:before, {{WRAPPER}}.gyan-cf7-style-box .wpcf7-acceptance input[type="checkbox"] + span:before, {{WRAPPER}}.gyan-cf7-style-box .wpcf7-radio input[type="radio"] + span:before' => 'border-color: {{VALUE}};',
						'{{WRAPPER}} .gyan-cf7-style input[type=range]::-webkit-slider-runnable-track' => 'border: 0.2px solid {{VALUE}}; box-shadow: 1px 1px 1px {{VALUE}}, 0px 0px 1px {{VALUE}};',
						'{{WRAPPER}} .gyan-cf7-style input[type=range]::-moz-range-track' => 'border: 0.2px solid {{VALUE}}; box-shadow: 1px 1px 1px {{VALUE}}, 0px 0px 1px {{VALUE}};',
						'{{WRAPPER}} .gyan-cf7-style input[type=range]::-ms-fill-lower' => 'border: 0.2px solid {{VALUE}}; box-shadow: 1px 1px 1px {{VALUE}}, 0px 0px 1px {{VALUE}};',
						'{{WRAPPER}} .gyan-cf7-style input[type=range]::-ms-fill-upper' => 'border: 0.2px solid {{VALUE}}; box-shadow: 1px 1px 1px {{VALUE}}, 0px 0px 1px {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
				'cf7_border_bottom',
				[
					'label'      => esc_html__( 'Border Size', 'gyan-elements' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'em', 'rem' ],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 20,
						],
					],
					'default'    => [
						'size' => '2',
						'unit' => 'px',
					],
					'condition'  => [
						'cf7_style' => 'underline',
					],
					'selectors'  => [
						'{{WRAPPER}}.gyan-cf7-style-underline input:not([type=submit]),{{WRAPPER}}.gyan-cf7-style-underline select,{{WRAPPER}}.gyan-cf7-style-underline textarea' => 'border-width: 0 0 {{SIZE}}{{UNIT}} 0; border-style: solid;',
						'{{WRAPPER}}.gyan-cf7-style-underline .wpcf7-checkbox input[type="checkbox"]:checked + span:before, {{WRAPPER}}.gyan-cf7-style-underline .wpcf7-checkbox input[type="checkbox"] + span:before,{{WRAPPER}}.gyan-cf7-style-underline .wpcf7-acceptance input[type="checkbox"]:checked + span:before, {{WRAPPER}}.gyan-cf7-style-underline .wpcf7-acceptance input[type="checkbox"] + span:before,{{WRAPPER}} .wpcf7-radio input[type="radio"] + span:before' => 'border-width: {{SIZE}}{{UNIT}}; border-style: solid; box-sizing: content-box;',
					],
				]
			);

			$this->add_control(
				'cf7_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'gyan-elements' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'cf7_style' => 'underline',
					],
					'default'   => '#eeeeee',
					'selectors' => [
						'{{WRAPPER}}.gyan-cf7-style-underline input:not([type=submit]),{{WRAPPER}}.gyan-cf7-style-underline select,{{WRAPPER}}.gyan-cf7-style-underline textarea, {{WRAPPER}}.gyan-cf7-style-underline .wpcf7-checkbox input[type="checkbox"]:checked + span:before, {{WRAPPER}}.gyan-cf7-style-underline .wpcf7-checkbox input[type="checkbox"] + span:before, {{WRAPPER}}.gyan-cf7-style-underline .wpcf7-acceptance input[type="checkbox"]:checked + span:before, {{WRAPPER}}.gyan-cf7-style-underline .wpcf7-acceptance input[type="checkbox"] + span:before, {{WRAPPER}} .wpcf7-radio input[type="radio"] + span:before' => 'border-color: {{VALUE}};',
						'{{WRAPPER}} .gyan-cf7-style-underline input[type=range]::-webkit-slider-runnable-track' => 'border: 0.2px solid {{VALUE}}; box-shadow: 1px 1px 1px {{VALUE}}, 0px 0px 1px {{VALUE}};',
						'{{WRAPPER}} .gyan-cf7-style input[type=range]::-moz-range-track' => 'border: 0.2px solid {{VALUE}}; box-shadow: 1px 1px 1px {{VALUE}}, 0px 0px 1px {{VALUE}};',
						'{{WRAPPER}} .gyan-cf7-style input[type=range]::-ms-fill-lower' => 'border: 0.2px solid {{VALUE}}; box-shadow: 1px 1px 1px {{VALUE}}, 0px 0px 1px {{VALUE}};',
						'{{WRAPPER}} .gyan-cf7-style input[type=range]::-ms-fill-upper' => 'border: 0.2px solid {{VALUE}}; box-shadow: 1px 1px 1px {{VALUE}}, 0px 0px 1px {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'cf7_ipborder_active',
				[
					'label'     => esc_html__( 'Border Active Color', 'gyan-elements' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#d83030',
					'selectors' => [
						'{{WRAPPER}} .gyan-cf7-style .wpcf7 form input:not([type=submit]):focus, {{WRAPPER}} .gyan-cf7-style select:focus, {{WRAPPER}} .gyan-cf7-style .wpcf7 textarea:focus, {{WRAPPER}} .gyan-cf7-style .wpcf7-checkbox input[type="checkbox"]:checked + span:before,{{WRAPPER}} .gyan-cf7-style .wpcf7-acceptance input[type="checkbox"]:checked + span:before, {{WRAPPER}} .gyan-cf7-style .wpcf7-radio input[type="radio"]:checked + span:before' => 'border-color: {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
				'cf7_input_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'gyan-elements' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .gyan-cf7-style input:not([type="submit"]), {{WRAPPER}} .gyan-cf7-style select, {{WRAPPER}} .gyan-cf7-style textarea, {{WRAPPER}} .wpcf7-checkbox input[type="checkbox"] + span:before, {{WRAPPER}} .wpcf7-acceptance input[type="checkbox"] + span:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'cf7_input_icon_heading',
				[
					'label'     => esc_html__( 'Fields Icon', 'gyan-elements' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control(
				'cf7_input_icon_color',
				[
					'label'     => esc_html__( 'Fields Icon Color', 'gyan-elements' ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_3,
					],
					'default'   => '#d83030',
					'selectors' => [
						'{{WRAPPER}} .gyan-cf7-icon i' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
				'cf7_input_icon_size',
				[
					'label'      => esc_html__( 'Icon Size', 'gyan-elements' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'em', 'rem' ],
					'range'      => [
						'px' => [
							'min' => 6,
							'max' => 100,
						],
					],
					'default'    => [
						'unit' => 'px',
						'size' => 16,
					],
					'selectors'  => [
						'{{WRAPPER}} .gyan-cf7-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'cf7_input_icon_space',
				[
					'label'      => esc_html__( 'Space Between Icon and Text', 'gyan-elements' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'em', 'rem' ],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 100,
						],
					],
					'default'    => [
						'unit' => 'px',
						'size' => 50,
					],
					'selectors'  => [
						'{{WRAPPER}} .gyan-cf7-icon:not(.icon-right) input:not([type="submit"]),
						{{WRAPPER}} .gyan-cf7-icon:not(.icon-right) textarea' => 'padding-left: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .gyan-cf7-icon.icon-right input:not([type="submit"]),
						{{WRAPPER}} .gyan-cf7-icon.icon-right textarea' => 'padding-right: {{SIZE}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();
	}

	protected function register_radio_content_controls() {

		$this->start_controls_section(
			'cf7_radio_check_style',
			[
				'label' => esc_html__( 'Radio & Checkbox', 'gyan-elements' ),
			]
		);

			$this->add_control(
				'cf7_radio_check_adv',
				[
					'label'        => esc_html__( 'Override Current Style', 'gyan-elements' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'gyan-elements' ),
					'label_off'    => esc_html__( 'No', 'gyan-elements' ),
					'return_value' => 'yes',
					'default'      => '',
					'separator'    => 'before',
					'prefix_class' => 'gyan-cf7-check-',
				]
			);

			$this->add_control(
				'cf7_radio_check_size',
				[
					'label'      => _x( 'Size', 'gyan-elements' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'em', 'rem' ],
					'condition'  => [
						'cf7_radio_check_adv!' => '',
					],
					'default'    => [
						'unit' => 'px',
						'size' => 20,
					],
					'range'      => [
						'px' => [
							'min' => 15,
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}}.gyan-cf7-check-yes .wpcf7-checkbox input[type="checkbox"] + span:before,{{WRAPPER}}.gyan-cf7-check-yes .wpcf7-acceptance input[type="checkbox"] + span:before,{{WRAPPER}}.gyan-cf7-check-yes .wpcf7-radio input[type="radio"] + span:before' => 'width: {{SIZE}}{{UNIT}}; height:{{SIZE}}{{UNIT}};',
						'{{WRAPPER}}.gyan-cf7-check-yes .wpcf7-checkbox input[type="checkbox"]:checked + span:before,{{WRAPPER}}.gyan-cf7-check-yes .wpcf7-acceptance input[type="checkbox"]:checked + span:before'  => 'font-size: calc( {{SIZE}}{{UNIT}} / 1.2 );',
						'{{WRAPPER}}.gyan-cf7-check-yes input[type=range]::-webkit-slider-thumb' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}}.gyan-cf7-check-yes input[type=range]::-moz-range-thumb' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}}.gyan-cf7-check-yes input[type=range]::-ms-thumb' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}}.gyan-cf7-check-yes input[type=range]::-webkit-slider-runnable-track' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}}.gyan-cf7-check-yes input[type=range]::-moz-range-track' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}}.gyan-cf7-check-yes input[type=range]::-ms-fill-lower' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}}.gyan-cf7-check-yes input[type=range]::-ms-fill-upper' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'cf7_radio_check_bgcolor',
				[
					'label'     => esc_html__( 'Background Color', 'gyan-elements' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#fafafa',
					'condition' => [
						'cf7_radio_check_adv!' => '',
					],
					'selectors' => [
						'{{WRAPPER}}.gyan-cf7-check-yes .wpcf7-checkbox input[type="checkbox"] + span:before,{{WRAPPER}}.gyan-cf7-check-yes .wpcf7-acceptance input[type="checkbox"] + span:before, {{WRAPPER}}.gyan-cf7-check-yes .wpcf7-radio input[type="radio"]:not(:checked) + span:before' => 'background-color: {{VALUE}};',
						'{{WRAPPER}}.gyan-cf7-check-yes input[type=range]::-webkit-slider-runnable-track,{{WRAPPER}}.gyan-cf7-check-yes input[type=range]:focus::-webkit-slider-runnable-track' => 'background-color: {{VALUE}};',
						'{{WRAPPER}}.gyan-cf7-check-yes input[type=range]::-moz-range-track,{{WRAPPER}} input[type=range]:focus::-moz-range-track' => 'background-color: {{VALUE}};',
						'{{WRAPPER}}.gyan-cf7-check-yes input[type=range]::-ms-fill-lower,{{WRAPPER}}.gyan-cf7-check-yes input[type=range]:focus::-ms-fill-lower' => 'background-color: {{VALUE}};',
						'{{WRAPPER}}.gyan-cf7-check-yes input[type=range]::-ms-fill-upper,{{WRAPPER}}.gyan-cf7-check-yes input[type=range]:focus::-ms-fill-upper' => 'background-color: {{VALUE}};',
						'{{WRAPPER}}.gyan-cf7-check-yes .wpcf7-radio input[type="radio"]:checked + span:before' => 'box-shadow:inset 0px 0px 0px 4px {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'cf7_selected_color',
				[
					'label'     => esc_html__( 'Selected Color', 'gyan-elements' ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_3,
					],
					'condition' => [
						'cf7_radio_check_adv!' => '',
					],
					'selectors' => [
						'{{WRAPPER}}.gyan-cf7-check-yes .wpcf7-checkbox input[type="checkbox"]:checked + span:before,{{WRAPPER}}.gyan-cf7-check-yes .wpcf7-acceptance input[type="checkbox"]:checked + span:before' => 'color: {{VALUE}};',
						'{{WRAPPER}}.gyan-cf7-check-yes .wpcf7-radio input[type="radio"]:checked + span:before' => 'background-color: {{VALUE}};',
						'{{WRAPPER}}.gyan-cf7-check-yes input[type=range]::-webkit-slider-thumb' => 'border: 1px solid {{VALUE}}; background: {{VALUE}};',
						'{{WRAPPER}} .gyan-cf7-style input[type=range]::-moz-range-thumb' => 'border: 1px solid {{VALUE}}; background: {{VALUE}};',
						'{{WRAPPER}} .gyan-cf7-style input[type=range]::-ms-thumb' => 'border: 1px solid {{VALUE}}; background: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'cf7_radio_label_color',
				[
					'label'     => esc_html__( 'Label Color', 'gyan-elements' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'condition' => [
						'cf7_radio_check_adv!' => '',
					],
					'selectors' => [
						'{{WRAPPER}} .gyan-cf7-style input[type="checkbox"] + span, .gyan-cf7-style input[type="radio"] + span' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'cf7_check_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'gyan-elements' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#eaeaea',
					'condition' => [
						'cf7_radio_check_adv!' => '',
					],
					'selectors' => [
						'{{WRAPPER}}.gyan-cf7-check-yes .wpcf7-checkbox input[type="checkbox"]:checked + span:before, {{WRAPPER}}.gyan-cf7-check-yes .wpcf7-checkbox input[type="checkbox"] + span:before,{{WRAPPER}}.gyan-cf7-check-yes .wpcf7-acceptance input[type="checkbox"]:checked + span:before, {{WRAPPER}}.gyan-cf7-check-yes .wpcf7-acceptance input[type="checkbox"] + span:before, {{WRAPPER}}.gyan-cf7-check-yes .wpcf7-radio input[type="radio"] + span:before' => 'border-color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'cf7_check_border_width',
				[
					'label'      => esc_html__( 'Border Width', 'gyan-elements' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 20,
						],
					],
					'default'    => [
						'size' => '1',
						'unit' => 'px',
					],
					'condition'  => [
						'cf7_radio_check_adv!' => '',
					],
					'selectors'  => [
						'{{WRAPPER}}.gyan-cf7-check-yes .wpcf7-checkbox input[type="checkbox"] + span:before,{{WRAPPER}}.gyan-cf7-check-yes .wpcf7-acceptance input[type="checkbox"]:checked + span:before, {{WRAPPER}}.gyan-cf7-check-yes .wpcf7-acceptance input[type="checkbox"] + span:before, {{WRAPPER}}.gyan-cf7-check-yes .wpcf7-radio input[type="radio"] + span:before, {{WRAPPER}}.gyan-cf7-check-yes .wpcf7-checkbox input[type="checkbox"]:checked + span:before' => 'border-width: {{SIZE}}{{UNIT}}; border-style: solid;',
					],
				]
			);

			$this->add_control(
				'cf7_check_border_radius',
				[
					'label'      => esc_html__( 'Checkbox Rounded Corners', 'gyan-elements' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'condition'  => [
						'cf7_radio_check_adv!' => '',
					],
					'selectors'  => [
						'{{WRAPPER}}.gyan-cf7-check-yes .wpcf7-checkbox input[type="checkbox"] + span:before, {{WRAPPER}}.gyan-cf7-check-yes .wpcf7-acceptance input[type="checkbox"] + span:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'default'    => [
						'top'    => '0',
						'bottom' => '0',
						'left'   => '0',
						'right'  => '0',
						'unit'   => 'px',
					],
				]
			);

		$this->end_controls_section();
	}

	protected function register_button_content_controls() {

		$this->start_controls_section(
			'cf7_submit_button',
			[
				'label' => esc_html__( 'Submit Button', 'gyan-elements' ),
			]
		);

			$this->add_responsive_control(
				'cf7_button_align',
				[
					'label'        => esc_html__( 'Button Alignment', 'gyan-elements' ),
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
							'title' => esc_html__( 'Justified', 'gyan-elements' ),
							'icon'  => 'fa fa-align-justify',
						],
					],
					'default'      => 'left',
					'prefix_class' => 'gyan%s-cf7-button-',
					'toggle'       => false,
				]
			);

			$this->add_responsive_control(
				'cf7_button_padding',
				[
					'label'      => esc_html__( 'Padding', 'gyan-elements' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .gyan-cf7-style input[type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'cf7_button_margin',
				[
					'label'      => esc_html__( 'Margin', 'gyan-elements' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .gyan-cf7-style input[type="submit"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator'  => 'after',
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
							'default'   => '#ffffff',
							'selectors' => [
								'{{WRAPPER}} .gyan-cf7-style input[type="submit"]' => 'color: {{VALUE}};',
							],
						]
					);

					$this->add_group_control(
						Group_Control_Background::get_type(),
						[
							'name'           => 'btn_background_color',
							'label'          => esc_html__( 'Background Color', 'gyan-elements' ),
							'types'          => [ 'classic', 'gradient' ],
							'fields_options' => [
								'background' => [
									'default' =>'classic',
								],
								'color' => [
									'default' => '#d83030',
								],
							],
							'selector'       => '{{WRAPPER}} .gyan-cf7-style input[type="submit"]',
						]
					);

					$this->add_group_control(
						Group_Control_Border::get_type(),
						[
							'name'        => 'btn_border',
							'label'       => esc_html__( 'Border', 'gyan-elements' ),
							'placeholder' => '1px',
							'default'     => '1px',
							'selector'    => '{{WRAPPER}} .gyan-cf7-style input[type="submit"]',
						]
					);

					$this->add_responsive_control(
						'btn_border_radius',
						[
							'label'      => esc_html__( 'Border Radius', 'gyan-elements' ),
							'type'       => Controls_Manager::DIMENSIONS,
							'size_units' => [ 'px', '%' ],
							'selectors'  => [
								'{{WRAPPER}} .gyan-cf7-style input[type="submit"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							],
						]
					);

					$this->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'name'     => 'button_box_shadow',
							'selector' => '{{WRAPPER}} .gyan-cf7-style input[type="submit"]',
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
						'btn_hover_color',
						[
							'label'     => esc_html__( 'Text Color', 'gyan-elements' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '#ffffff',
							'selectors' => [
								'{{WRAPPER}} .gyan-cf7-style input[type="submit"]:hover' => 'color: {{VALUE}};',
							],
						]
					);

					$this->add_control(
						'button_hover_border_color',
						[
							'label'     => esc_html__( 'Border Hover Color', 'gyan-elements' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .gyan-cf7-style input[type="submit"]:hover' => 'border-color: {{VALUE}};',
							],
						]
					);

					$this->add_group_control(
						Group_Control_Background::get_type(),
						[
							'name'     => 'button_background_hover_color',
							'label'    => esc_html__( 'Background Color', 'gyan-elements' ),
							'types'    => [ 'classic', 'gradient' ],
							'fields_options' => [
								'background' => [
									'default' =>'classic',
								],
								'color' => [
									'default' => '#252628',
								],
							],
							'selector' => '{{WRAPPER}} .gyan-cf7-style input[type="submit"]:hover',
						]
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_error_content_controls() {

		$this->start_controls_section(
			'cf7_error_field',
			[
				'label' => esc_html__( 'Success / Error Message', 'gyan-elements' ),
			]
		);

			$this->add_control(
				'cf7_field_message',
				[
					'label'     => esc_html__( 'Field Validation', 'gyan-elements' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

				$this->add_control(
					'cf7_highlight_style',
					[
						'label'        => esc_html__( 'Message Position', 'gyan-elements' ),
						'type'         => Controls_Manager::SELECT,
						'default'      => 'default',
						'options'      => [
							'default'      => esc_html__( 'Default', 'gyan-elements' ),
							'bottom_right' => esc_html__( 'Bottom Right Side of Field', 'gyan-elements' ),
						],
						'prefix_class' => 'gyan-cf7-highlight-style-',
					]
				);

				$this->add_control(
					'cf7_message_color',
					[
						'label'     => esc_html__( 'Message Color', 'gyan-elements' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#d83030',
						'condition' => [
							'cf7_highlight_style' => 'default',
						],
						'selectors' => [
							'{{WRAPPER}} .gyan-cf7-style span.wpcf7-not-valid-tip' => 'color: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'cf7_message_highlight_color',
					[
						'label'     => esc_html__( 'Message Color', 'gyan-elements' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ffffff',
						'condition' => [
							'cf7_highlight_style' => 'bottom_right',
						],
						'selectors' => [
							'{{WRAPPER}} .gyan-cf7-style span.wpcf7-not-valid-tip' => 'color: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'cf7_message_bgcolor',
					[
						'label'     => esc_html__( 'Message Background Color', 'gyan-elements' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => 'rgba(255, 0, 0, 0.6)',
						'condition' => [
							'cf7_highlight_style' => 'bottom_right',
						],
						'selectors' => [
							'{{WRAPPER}} .gyan-cf7-style span.wpcf7-not-valid-tip' => 'background-color: {{VALUE}}; padding: 0.1em 0.8em;',
						],
					]
				);

				$this->add_control(
					'cf7_highlight_border',
					[
						'label'        => esc_html__( 'Highlight Borders', 'gyan-elements' ),
						'type'         => Controls_Manager::SWITCHER,
						'label_on'     => esc_html__( 'Yes', 'gyan-elements' ),
						'label_off'    => esc_html__( 'No', 'gyan-elements' ),
						'return_value' => 'yes',
						'default'      => '',
						'prefix_class' => 'gyan-cf7-highlight-',
					]
				);

				$this->add_control(
					'cf7_highlight_border_color',
					[
						'label'     => esc_html__( 'Highlight Border Color', 'gyan-elements' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#d83030',
						'condition' => [
							'cf7_highlight_border' => 'yes',
						],
						'selectors' => [
							'{{WRAPPER}} .gyan-cf7-style .wpcf7-form-control.wpcf7-not-valid, {{WRAPPER}} .gyan-cf7-style .wpcf7-form-control.wpcf7-not-valid .wpcf7-list-item-label:before' => 'border-color: {{VALUE}};',
						],
					]
				);

				$this->add_responsive_control(
					'cf7_valid_message_margin',
					[
						'label'      => esc_html__( 'Margin', 'gyan-elements' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', 'em', '%' ],
						'selectors'  => [
							'{{WRAPPER}} .gyan-cf7-style span.wpcf7-not-valid-tip' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'name'     => 'cf7_message_typo',
						'selector' => '{{WRAPPER}} .gyan-cf7-style span.wpcf7-not-valid-tip',
					]
				);

			$this->add_control(
				'cf7_validation_message',
				[
					'label'     => esc_html__( 'Form Success / Error Validation', 'gyan-elements' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

				$this->add_control(
					'cf7_success_message_color',
					[
						'label'     => esc_html__( 'Success Message Color', 'gyan-elements' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => [
							'{{WRAPPER}} .gyan-cf7-style .sent .wpcf7-response-output, {{WRAPPER}} .gyan-cf7-style .wpcf7-mail-sent-ok' => 'color: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'cf7_success_message_bgcolor',
					[
						'label'     => esc_html__( 'Success Message Background Color', 'gyan-elements' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => [
							'{{WRAPPER}} .gyan-cf7-style .sent .wpcf7-response-output, {{WRAPPER}} .gyan-cf7-style .wpcf7-mail-sent-ok' => 'background-color: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'cf7_success_border_color',
					[
						'label'     => esc_html__( 'Success Border Color', 'gyan-elements' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#008000',
						'condition' => [
							'cf7_valid_border_size!' => '',
						],
						'selectors' => [
							'{{WRAPPER}} .gyan-cf7-style .sent .wpcf7-response-output, {{WRAPPER}} .gyan-cf7-style .wpcf7-mail-sent-ok' => 'border-color: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'cf7_error_message_color',
					[
						'label'     => esc_html__( 'Error Message Color', 'gyan-elements' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => [
							'{{WRAPPER}} .gyan-cf7-style .invalid .wpcf7-response-output, {{WRAPPER}} .gyan-cf7-style .wpcf7 .wpcf7-validation-errors, {{WRAPPER}} .gyan-cf7-style div.wpcf7-mail-sent-ng,{{WRAPPER}} .gyan-cf7-style .wpcf7-acceptance-missing' => 'color: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'cf7_error_message_bgcolor',
					[
						'label'     => esc_html__( 'Error Message Background Color', 'gyan-elements' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => [
							'{{WRAPPER}} .gyan-cf7-style .invalid .wpcf7-response-output, {{WRAPPER}} .gyan-cf7-style .wpcf7 .wpcf7-validation-errors, {{WRAPPER}} .gyan-cf7-style div.wpcf7-mail-sent-ng,{{WRAPPER}} .gyan-cf7-style .wpcf7-acceptance-missing' => 'background-color: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'cf7_error_border_color',
					[
						'label'     => esc_html__( 'Error Border Color', 'gyan-elements' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#d83030',
						'condition' => [
							'cf7_valid_border_size!' => '',
						],
						'selectors' => [
							'{{WRAPPER}} .gyan-cf7-style .wpcf7 .wpcf7-validation-errors, {{WRAPPER}} .gyan-cf7-style div.wpcf7-mail-sent-ng,{{WRAPPER}} .gyan-cf7-style .wpcf7-acceptance-missing' => 'border-color: {{VALUE}};',
						],
					]
				);

				$this->add_responsive_control(
					'cf7_valid_border_size',
					[
						'label'      => esc_html__( 'Border Size', 'gyan-elements' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', 'em', '%' ],
						'default'    => [
							'top'    => '2',
							'bottom' => '2',
							'left'   => '2',
							'right'  => '2',
							'unit'   => 'px',
						],
						'selectors'  => [
							'{{WRAPPER}} .gyan-cf7-style .wpcf7 .wpcf7-validation-errors, {{WRAPPER}} .gyan-cf7-style div.wpcf7-mail-sent-ng,{{WRAPPER}} .gyan-cf7-style .wpcf7-acceptance-missing' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
						],
					]
				);

				$this->add_responsive_control(
					'cf7_valid_message_radius',
					[
						'label'      => esc_html__( 'Border Radius', 'gyan-elements' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', 'em', '%' ],
						'selectors'  => [
							'{{WRAPPER}} .gyan-cf7-style .wpcf7 .wpcf7-validation-errors, {{WRAPPER}} .gyan-cf7-style div.wpcf7-mail-sent-ng, {{WRAPPER}} .gyan-cf7-style .wpcf7-acceptance-missing' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);

				$this->add_responsive_control(
					'cf7_valid_message_padding',
					[
						'label'      => esc_html__( 'Padding', 'gyan-elements' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', 'em', '%' ],
						'selectors'  => [
							'{{WRAPPER}} .gyan-cf7-style .wpcf7 .wpcf7-validation-errors, {{WRAPPER}} .gyan-cf7-style div.wpcf7-mail-sent-ng, {{WRAPPER}} .gyan-cf7-style .wpcf7-acceptance-missing' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);

				$this->add_responsive_control(
					'cf7_valid_message_box_margin',
					[
						'label'      => esc_html__( 'Margin', 'gyan-elements' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', 'em', '%' ],
						'selectors'  => [
							'{{WRAPPER}} .gyan-cf7-style .wpcf7 .wpcf7-validation-errors, {{WRAPPER}} .gyan-cf7-style div.wpcf7-mail-sent-ng, {{WRAPPER}} .gyan-cf7-style .wpcf7-acceptance-missing' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
						'separator'  => 'after',
					]
				);

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'name'     => 'cf7_validation_typo',
						'selector' => '{{WRAPPER}} .gyan-cf7-style .wpcf7 .wpcf7-validation-errors, {{WRAPPER}} .gyan-cf7-style div.wpcf7-mail-sent-ng,{{WRAPPER}} .gyan-cf7-style .wpcf7-mail-sent-ok,{{WRAPPER}} .gyan-cf7-style .wpcf7-acceptance-missing',
					]
				);

		$this->end_controls_section();
	}

	protected function register_input_style_controls() {

		$this->start_controls_section(
			'cf7_input_spacing',
			[
				'label' => esc_html__( 'Spacing & Height', 'gyan-elements' ),
			]
		);

			$this->add_responsive_control(
				'cf7_input_margin_top',
				[
					'label'      => esc_html__( 'Between Label & Input', 'gyan-elements' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'em', 'rem' ],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 60,
						],
					],
					'default'    => [
						'unit' => 'px',
						'size' => 5,
					],
					'selectors'  => [
						'{{WRAPPER}} .gyan-cf7-style input:not([type=submit]):not([type=checkbox]):not([type=radio]),
						{{WRAPPER}} .gyan-cf7-style .gyan-cf7-icon i,
						{{WRAPPER}} .gyan-cf7-style select,
						{{WRAPPER}} .gyan-cf7-style textarea,
						{{WRAPPER}} .gyan-cf7-style span.wpcf7-list-item' => 'margin-top: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'cf7_input_margin_bottom',
				[
					'label'      => esc_html__( 'Between Fields', 'gyan-elements' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'em', 'rem' ],
					'range'      => [
						'px' => [
							'min' => -50,
							'max' => 100,
						],
					],
					'default'    => [
						'unit' => 'px',
						'size' => 10,
					],
					'selectors'  => [
						'{{WRAPPER}} .gyan-cf7-style input:not([type=submit]):not([type=checkbox]):not([type=radio]),
						{{WRAPPER}} .gyan-cf7-style .gyan-cf7-icon i,
						{{WRAPPER}} .gyan-cf7-style select,
						{{WRAPPER}} .gyan-cf7-style textarea,
						{{WRAPPER}} .gyan-cf7-style span.wpcf7-list-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'cf7_textarea_height',
				[
					'label'      => esc_html__( 'Textarea Height', 'gyan-elements' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'em', 'rem' ],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 500,
						],
					],
					'default'    => [
						'unit' => 'px',
						'size' => 150,
					],
					'selectors'  => [
						'{{WRAPPER}} .gyan-cf7-style .wpcf7 textarea' => 'height:{{SIZE}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();
	}

	protected function register_typography_style_controls() {

		$this->start_controls_section(
			'cf7_typo',
			[
				'label' => esc_html__( 'Typography', 'gyan-elements' ),
			]
		);

			$this->add_control(
				'cf7_label_typo',
				[
					'label'     => esc_html__( 'Form Label', 'gyan-elements' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'form_label_typography',
					'selector' => '{{WRAPPER}} .gyan-cf7-style .wpcf7 form.wpcf7-form label',
				]
			);

			$this->add_control(
				'cf7_input_typo',
				[
					'label'     => esc_html__( 'Input Text / Placeholder', 'gyan-elements' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'input_typography',
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
					    'font_weight' => [
					        'default' => '700',
					    ],
					],
					'selector' => '{{WRAPPER}} .gyan-cf7-style .wpcf7 input:not([type=submit]),
					{{WRAPPER}} .gyan-cf7-style .wpcf7 .gyan-cf7-icon,
					{{WRAPPER}} .gyan-cf7-style .wpcf7 input::placeholder,
					{{WRAPPER}} .wpcf7 select,
					{{WRAPPER}} .gyan-cf7-style .wpcf7 textarea,
					{{WRAPPER}} .gyan-cf7-style .wpcf7 textarea::placeholder,
					{{WRAPPER}} .gyan-cf7-style input[type=range]::-webkit-slider-thumb,{{WRAPPER}} .gyan-cf7-style .gyan-cf7-select-custom',
				]
			);

			$this->add_control(
				'btn_typography_label',
				[
					'label'     => esc_html__( 'Button', 'gyan-elements' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'btn_typography',
					'label'    => esc_html__( 'Typography', 'gyan-elements' ),
					'selector' => '{{WRAPPER}} .gyan-cf7-style input[type=submit]',
				]
			);

			$this->add_control(
				'cf7_radio_check_typo',
				[
					'label'     => esc_html__( 'Radio Button & Checkbox', 'gyan-elements' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'cf7_radio_check_adv!' => '',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'radio_check_typography',
					'condition' => [
						'cf7_radio_check_adv!' => '',
					],
					'selector'  => '{{WRAPPER}} .gyan-cf7-style input[type="checkbox"] + span, .gyan-cf7-style input[type="radio"] + span',
				]
			);

		$this->end_controls_section();
	}

	protected function render_editor_script() {

		if ( \Elementor\Plugin::instance()->editor->is_edit_mode() === false ) {
			return;
		}

		$pre_url = wpcf7_get_request_uri();

		if ( strpos( $pre_url, 'admin-ajax.php' ) === false ) {
			return;
		}

		?><script type="text/javascript">
			jQuery( document ).ready( function( $ ) {

				$( '.gyan-cf7-container' ).each( function() {

					var $node_id 	= '<?php echo $this->get_id(); ?>';
					var	scope 		= $( '[data-id="' + $node_id + '"]' );
					var selector 	= $(this);

					if ( selector.closest( scope ).length < 1 ) {
						return;
					}

					if ( selector.find( 'div.wpcf7 > form' ).length < 1 ) {
						return;
					}

					selector.find( 'div.wpcf7 > form' ).each( function() {
						var $form = $( this );
						wpcf7.initForm( $form );
					} );
				});
			});
		</script>
		<?php
	}

	protected function render() {

		if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
			return;
		}

		$settings      = $this->get_settings();
		$node_id       = $this->get_id();
		$field_options = array();
		$classname     = '';

		$args = array(
			'post_type'      => 'wpcf7_contact_form',
			'posts_per_page' => -1,
		);

		$forms              = get_posts( $args );
		$field_options['0'] = 'select';
		if ( $forms ) {
			foreach ( $forms as $form ) {
				$field_options[ $form->ID ] = $form->post_title;
			}
		}

		$this->add_inline_editing_attributes( 'gyan_cf7_title' );
		$forms = $this->get_cf7_forms();

		$html = '';

		if ( ! empty( $forms ) && ! isset( $forms[-1] ) ) {
			if ( 0 == $settings['select_form'] ) {
				$html = esc_html__( 'Please select a Contact Form 7 from dropdown.', 'gyan-elements' );
			} else {
				?>
				<div class = "gyan-cf7-container">
						<div class = "gyan-cf7 gyan-cf7-style elementor-clickable">
						<?php
						if ( $settings['select_form'] ) {
							echo do_shortcode( '[contact-form-7 id=' . $settings['select_form'] . ']' );
						}
						?>
					</div>
				</div>
				<?php
			}
		} else {
			$html = esc_html__( 'Contact Form not found. Please add contact form from Dashboard > Contact > Add New.', 'gyan-elements' );
		}
		echo $html;

		$this->render_editor_script();
	}

}