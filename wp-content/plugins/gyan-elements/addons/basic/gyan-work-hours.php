<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {exit; }

class Gyan_Work_Hours extends Widget_Base {

	public function get_name()       { return 'gyan_work_hours'; }
	public function get_title()      { return esc_html__( 'Work Hours', 'gyan-elements' ); }
	public function get_icon()       { return 'gyan-el-icon eicon-bullet-list'; }
	public function get_categories() { return ['gyan-basic-addons']; }
	public function get_keywords()   { return ['gyan work hours','time','work','business','open','hours' ]; }
	public function get_style_depends()  { return ['gyan-work-hours']; }

	protected function register_controls() {

		$this->start_controls_section(
			'section_work_hours_days',
			[
				'label' => esc_html__( 'Work Hours - Days & Timings', 'gyan-elements' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'enter_day',
			[
				'label'       => esc_html__( 'Enter Day', 'gyan-elements' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => 'Monday',
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'enter_time',
			[
				'label'       => esc_html__( 'Enter Time', 'gyan-elements' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => '8:30 AM - 7:30 PM',
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'current_styling_heading',
			[
				'label'     => esc_html__( 'Styling', 'gyan-elements' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'highlight_this',
			[
				'label'        => esc_html__( 'Style This Day', 'gyan-elements' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'YES', 'gyan-elements' ),
				'label_off'    => esc_html__( 'NO', 'gyan-elements' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'separator'    => 'before',
			]
		);

		$repeater->add_control(
			'single_work_day_color',
			[
				'label'     => esc_html__( 'Day Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
				'default'   => '#db6159',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .gyan-work-day-highlight' => 'color: {{VALUE}}',
				],
				'condition' => [
					'highlight_this' => 'yes',
				],
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'single_work_timing_color',
			[
				'label'     => esc_html__( 'Time Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'default'   => '#db6159',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .gyan-work-timing-highlight' => 'color: {{VALUE}}',
				],
				'condition' => [
					'highlight_this' => 'yes',
				],
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'single_work_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-work-hours-days {{CURRENT_ITEM}}.top-border-divider' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'highlight_this' => 'yes',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'work_days_timings',
			[
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'enter_day'  => esc_html__( 'Monday', 'gyan-elements' ),
						'enter_time' => esc_html__( '9:00 AM - 6:00 PM', 'gyan-elements' ),
					],
					[
						'enter_day'  => esc_html__( 'Tuesday', 'gyan-elements' ),
						'enter_time' => esc_html__( '9:00 AM - 6:00 PM', 'gyan-elements' ),
					],
					[
						'enter_day'  => esc_html__( 'Wednesday', 'gyan-elements' ),
						'enter_time' => esc_html__( '9:00 AM - 6:00 PM', 'gyan-elements' ),
					],
					[
						'enter_day'  => esc_html__( 'Thursday', 'gyan-elements' ),
						'enter_time' => esc_html__( '9:00 AM - 6:00 PM', 'gyan-elements' ),
					],
					[
						'enter_day'  => esc_html__( 'Friday', 'gyan-elements' ),
						'enter_time' => esc_html__( '9:00 AM - 6:00 PM', 'gyan-elements' ),
					],
					[
						'enter_day'  => esc_html__( 'Saturday', 'gyan-elements' ),
						'enter_time' => esc_html__( '9:00 AM - 2:00 PM', 'gyan-elements' ),
					],
					[
						'enter_day'      => esc_html__( 'Sunday', 'gyan-elements' ),
						'enter_time'     => esc_html__( 'Closed', 'gyan-elements' ),
						'highlight_this' => esc_html__( 'yes', 'gyan-elements' ),
					],
				],
				'title_field' => '{{{ enter_day }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_bs_general',
			[
				'label' => esc_html__( 'General', 'gyan-elements' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'section_bs_list_padding',
			[
				'label'      => esc_html__( 'Row Spacing', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} div.gyan-work-hours-days div' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_bs_divider',
			[
				'label' => esc_html__( 'Divider', 'gyan-elements' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'day_divider',
			[
				'label'        => esc_html__( 'Divider', 'gyan-elements' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'YES', 'gyan-elements' ),
				'label_off'    => esc_html__( 'NO', 'gyan-elements' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'day_divider_style',
			[
				'label'     => esc_html__( 'Style', 'gyan-elements' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'solid'  => esc_html__( 'Solid', 'gyan-elements' ),
					'dotted' => esc_html__( 'Dotted', 'gyan-elements' ),
					'dashed' => esc_html__( 'Dashed', 'gyan-elements' ),
				],
				'default'   => 'solid',
				'selectors' => [
					'{{WRAPPER}} .gyan-work-hours-section div.gyan-work-hours-days div.top-border-divider:not(:first-child)' => 'border-top-style: {{VALUE}};',
				],
				'condition' => [
					'day_divider' => 'yes',
				],
			]
		);

		$this->add_control(
			'day_divider_color',
			[
				'label'     => esc_html__( 'Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#d4d4d4',
				'selectors' => [
					'{{WRAPPER}} .gyan-work-hours-section div.gyan-work-hours-days div.top-border-divider:not(:first-child)' => 'border-top-color: {{VALUE}};',
				],
				'condition' => [
					'day_divider' => 'yes',
				],
			]
		);

		$this->add_control(
			'day_divider_weight',
			[
				'label'     => esc_html__( 'Weight', 'gyan-elements' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 1,
					'unit' => 'px',
				],
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-work-hours-section div.gyan-work-hours-days div.top-border-divider:not(:first-child)' => 'border-top-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'day_divider' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_work_day_style',
			[
				'label' => esc_html__( 'Day and Time', 'gyan-elements' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'work_hours_day_align',
			[
				'label'     => esc_html__( 'Day Alignment', 'gyan-elements' ),
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
				'selectors' => [
					'{{WRAPPER}} div.gyan-work-hours-days .heading-date' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'work_hours_time_align',
			[
				'label'     => esc_html__( 'Time Alignment', 'gyan-elements' ),
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
				'selectors' => [
					'{{WRAPPER}} div.gyan-work-hours-days .heading-time' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'work_day_color',
			[
				'label'     => esc_html__( 'Day Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-work-day' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-widget-container' => 'overflow: hidden;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Day Typography', 'gyan-elements' ),
				'name'     => 'work_day_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .heading-date',
			]
		);

		$this->add_control(
			'work_timing_color',
			[
				'label'     => esc_html__( 'Time Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-work-time' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Time Typography', 'gyan-elements' ),
				'name'     => 'work_timings_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .heading-time',
			]
		);

		$this->add_control(
			'striped_effect_feature',
			[
				'label'        => esc_html__( 'Striped Effect', 'gyan-elements' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'YES', 'gyan-elements' ),
				'label_off'    => esc_html__( 'NO', 'gyan-elements' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'striped_effect_odd',
			[
				'label'     => esc_html__( 'Striped Odd Rows Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#eaeaea',
				'selectors' => [
					'{{WRAPPER}} .top-border-divider:nth-child(odd)' => 'background: {{VALUE}};',
				],
				'condition' => [
					'striped_effect_feature' => 'yes',
				],
			]
		);

		$this->add_control(
			'striped_effect_even',
			[
				'label'     => esc_html__( 'Striped Even Rows Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .top-border-divider:nth-child(even)' => 'background: {{VALUE}};',
				],
				'condition' => [
					'striped_effect_feature' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		$node_id  = $this->get_id();
		ob_start();
		?>
			<div class="gyan-work-hours-section">
			<?php
			if ( count( $settings['work_days_timings'] ) ) {
				$count = 0;
				?>
				<div class="gyan-work-hours-days">
					<?php
					foreach ( $settings['work_days_timings'] as $item ) {
						$repeater_setting__enter_day = $this->get_repeater_setting_key( 'enter_day', 'work_days_timings', $count );

						$this->add_inline_editing_attributes( $repeater_setting__enter_day );
						$repeater_setting__enter_time = $this->get_repeater_setting_key( 'enter_time', 'work_days_timings', $count );
						$this->add_inline_editing_attributes( $repeater_setting__enter_time );

						$this->add_render_attribute( 'gyan-inner-element', 'class', 'gyan-inner' );
						$this->add_render_attribute( 'gyan-inner-heading-time', 'class', 'inner-heading-time' );
						$this->add_render_attribute( 'gyan-bs-background' . $item['_id'], 'class', 'elementor-repeater-item-' . $item['_id'] );
						$this->add_render_attribute( 'gyan-bs-background' . $item['_id'], 'class', 'top-border-divider' );
						if ( 'yes' === $item['highlight_this'] ) {
							$this->add_render_attribute( 'gyan-bs-background' . $item['_id'], 'class', 'gyan-highlight-background' );
						} elseif ( 'yes' === $settings['striped_effect_feature'] ) {
							$this->add_render_attribute( 'gyan-bs-background' . $item['_id'], 'class', 'stripes' );
						} else {
							$this->add_render_attribute( 'gyan-bs-background' . $item['_id'], 'class', 'bs-background' );
						}
						$this->add_render_attribute( 'gyan-highlight-day' . $item['_id'], 'class', 'heading-date' );
						$this->add_render_attribute( 'gyan-highlight-time' . $item['_id'], 'class', 'heading-time' );
						if ( 'yes' === $item['highlight_this'] ) {
							$this->add_render_attribute( 'gyan-highlight-day' . $item['_id'], 'class', 'gyan-work-day-highlight' );
							$this->add_render_attribute( 'gyan-highlight-time' . $item['_id'], 'class', 'gyan-work-timing-highlight' );
						} else {
							$this->add_render_attribute( 'gyan-highlight-day' . $item['_id'], 'class', 'gyan-work-day' );
							$this->add_render_attribute( 'gyan-highlight-time' . $item['_id'], 'class', 'gyan-work-time' );
						}
						?>
						<!-- CURRENT_ITEM div -->
						<div <?php echo $this->get_render_attribute_string( 'gyan-bs-background' . $item['_id'] ); ?>>
							<div <?php echo $this->get_render_attribute_string( 'gyan-inner-element' ); ?>>
								<span <?php echo $this->get_render_attribute_string( 'gyan-highlight-day' . $item['_id'] ); ?>>
									<span <?php echo $this->get_render_attribute_string( $repeater_setting__enter_day ); ?>><?php echo $item['enter_day']; ?></span>
								</span>

								<span <?php echo $this->get_render_attribute_string( 'gyan-highlight-time' . $item['_id'] ); ?>>
									<span <?php echo $this->get_render_attribute_string( 'gyan-inner-heading-time' ); ?>>
										<span <?php echo $this->get_render_attribute_string( $repeater_setting__enter_time ); ?>><?php echo $item['enter_time']; ?></span>
									</span>
								</span>
							</div>
						</div>
						<?php
						$count++;
					}
					?>
				</div>
			<?php	} ?>
			</div>
			<?php
		$html = ob_get_clean();
		echo $html;
	}

	protected function _content_template() {
	}

}