<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Gyan_Countdown extends Widget_Base {

	public function get_name()           { return 'gyan_countdown'; }
	public function get_title()          { return esc_html__( 'Countdown', 'gyan-elements' ); }
	public function get_icon()           { return 'gyan-el-icon eicon-countdown'; }
	public function get_categories()     { return ['gyan-advanced-addons' ]; }
	public function get_keywords()       { return ['gyan countdown', 'gyan count down', 'gyan timer' ]; }
	public function get_style_depends()  { return ['gyan-countdown' ]; }
	public function get_script_depends() { return ['countdown', 'gyan-widgets', ]; }

	protected function register_controls() {

		$this->start_controls_section(
			'countdown_content',
			[
				'label' => esc_html__( 'Countdown', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'countdown_time',
			[
				'label'	=> esc_html__( 'Due Date', 'gyan-elements' ),
				'type' => Controls_Manager::DATE_TIME,
				'picker_options' => [
					'format' => 'Ym/d H:m:s'
				],
				'default' => date( "Y/m/d H:m:s", strtotime("+ 25 Day") ),
			]
		);

		$this->add_control(
			'standard_countdown',
			[
				'label' => esc_html__( 'Standard Countdown', 'gyan-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'gyan-elements' ),
				'label_off' => esc_html__( 'No', 'gyan-elements' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'units',
			[
				'label' => esc_html__( 'Time Units', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT2,
				'options' => [
					'year' => esc_html__( 'Years', 'gyan-elements' ),
					'month' => esc_html__( 'Month', 'gyan-elements' ),
					'week' => esc_html__( 'Week', 'gyan-elements' ),
					'day' => esc_html__( 'Day', 'gyan-elements' ),
					'hour' => esc_html__( 'Hours', 'gyan-elements' ),
					'minute' => esc_html__( 'Minutes', 'gyan-elements' ),
					'second' => esc_html__( 'Second', 'gyan-elements' ),
				],
				'default' => [
					'year',
					'month',
					'week',
					'day',
					'hour',
					'minute',
					'second',
				],
				'multiple' => true,
				'condition' => [
					'standard_countdown!' => 'yes'
				]
			]
		);
		$this->add_responsive_control(
			'alignment',
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
				],
				'default' => 'center',
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .gyan-countdown' => 'text-align: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'text_state',
			[
				'label' => esc_html__( 'Text', 'gyan-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'gyan-elements' ),
				'label_off' => esc_html__( 'Hide', 'gyan-elements' ),
				'default' => 'yes',
			]
		);
		$this->add_control(
			'action',
			[
				'label' => esc_html__('Action', 'gyan-elements'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'text' => esc_html__('Message', 'gyan-elements'),
					'url' => esc_html__('Redirection Link', 'gyan-elements')
				],
				'description' => esc_html__('Choose whether if you want to set a message or a redirect link', 'gyan-elements'),
				'default'		=> 'text'
			]
		);
		$this->add_control(
			'message',
			[
				'label'	=> esc_html__('Message', 'gyan-elements'),
				'type' => Controls_Manager::TEXTAREA,
				'default' => 'Countdown is finished!',
				'condition' => [
					'action' => 'text'
				]
			]
		);
		$this->add_control(
			'redirect',
			[
				'label'	=> esc_html__('Redirect To', 'gyan-elements'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'condition' => [
					'action' => 'url'
				],
				'default' => get_permalink( 1 )
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'counter_translation',
			[
				'label' => esc_html__( 'Translation', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'text_state' => 'yes'
				]
			]
		);

		$this->add_control(
			'text_year',
			[
				'label'	=> esc_html__('Year', 'gyan-elements'),
				'type' => Controls_Manager::TEXT,
				'default' => 'Year',
				'condition' => [
					'standard_countdown!' => 'yes'
				]
			]
		);

		$this->add_control(
			'text_years',
			[
				'label'	=> esc_html__('Years', 'gyan-elements'),
				'type' => Controls_Manager::TEXT,
				'default' => 'Years',
				'condition' => [
					'standard_countdown!' => 'yes'
				]
			]
		);

		$this->add_control(
			'text_month',
			[
				'label'	=> esc_html__('Month', 'gyan-elements'),
				'type' => Controls_Manager::TEXT,
				'default' => 'Month',
				'condition' => [
					'standard_countdown!' => 'yes'
				]
			]
		);

		$this->add_control(
			'text_months',
			[
				'label'	=> esc_html__('Months', 'gyan-elements'),
				'type' => Controls_Manager::TEXT,
				'default' => 'Months',
				'condition' => [
					'standard_countdown!' => 'yes'
				]
			]
		);

		$this->add_control(
			'text_week',
			[
				'label'	=> esc_html__('Week', 'gyan-elements'),
				'type' => Controls_Manager::TEXT,
				'default' => 'Week',
				'condition' => [
					'standard_countdown!' => 'yes'
				]
			]
		);

		$this->add_control(
			'text_weeks',
			[
				'label'	=> esc_html__('Weeks', 'gyan-elements'),
				'type' => Controls_Manager::TEXT,
				'default' => 'Weeks',
				'condition' => [
					'standard_countdown!' => 'yes'
				]
			]
		);

		$this->add_control(
			'text_day',
			[
				'label'	=> esc_html__('Day', 'gyan-elements'),
				'type' => Controls_Manager::TEXT,
				'default' => 'Day',
			]
		);

		$this->add_control(
			'text_days',
			[
				'label'	=> esc_html__('Days', 'gyan-elements'),
				'type' => Controls_Manager::TEXT,
				'default' => 'Days',
			]
		);

		$this->add_control(
			'text_hour',
			[
				'label'	=> esc_html__('Hour', 'gyan-elements'),
				'type' => Controls_Manager::TEXT,
				'default' => 'Hour',
			]
		);

		$this->add_control(
			'text_hours',
			[
				'label'	=> esc_html__('Hours', 'gyan-elements'),
				'type' => Controls_Manager::TEXT,
				'default' => 'Hours',
			]
		);

		$this->add_control(
			'text_minute',
			[
				'label'	=> esc_html__('Minute', 'gyan-elements'),
				'type' => Controls_Manager::TEXT,
				'default' => 'Minute',
			]
		);

		$this->add_control(
			'text_minutes',
			[
				'label'	=> esc_html__('Minutes', 'gyan-elements'),
				'type' => Controls_Manager::TEXT,
				'default' => 'Minutes',
			]
		);

		$this->add_control(
			'text_second',
			[
				'label'	=> esc_html__('Second', 'gyan-elements'),
				'type' => Controls_Manager::TEXT,
				'default' => 'Second',
			]
		);

		$this->add_control(
			'text_seconds',
			[
				'label'	=> esc_html__('Seconds', 'gyan-elements'),
				'type' => Controls_Manager::TEXT,
				'default' => 'Seconds',
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
				'name' => 'background',
				'label' => esc_html__( 'Background', 'gyan-elements' ),
				'types' => [ 'classic', 'gradient' ],
				'fields_options' => [
					'background' => [
						'default' =>'classic',
					],
					'color' => [
						'default' => '#d83030',
					],
				],
				'selector' => '{{WRAPPER}} .gyan-cd',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'box_border',
				'selector' => '{{WRAPPER}} .gyan-cd',
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'selector' => '{{WRAPPER}} .gyan-cd',
			]
		);
		$this->add_responsive_control(
			'width',
			[
				'label' => esc_html__( 'Width', 'gyan-elements' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 200,
					],
				],
				'default' => [
					'size' => '100',
				],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .gyan-cd' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'height',
			[
				'label' => esc_html__( 'Height', 'gyan-elements' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 200,
					],
				],
				'default' => [
					'size' => '110',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-cd' => 'height: {{SIZE}}{{UNIT}};',
				],
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
					'{{WRAPPER}} .gyan-cd' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'top' => '10',
					'right' => '10',
					'bottom' => '10',
					'left' => '10',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-cd' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'top' => '6',
					'right' => '6',
					'bottom' => '6',
					'left' => '6',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-cd' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'digit_style',
			[
				'label' => esc_html__( 'Digit', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'digit_color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .gyan-cd' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'digit_typography',
				'fields_options' => [
					'typography' => [
						'default' =>'custom',
					],
					'font_size'   => [
						'default' => [
							'size' => '50',
						],
					],
					'line_height'   => [
						'default' => [
							'size' => '60',
						],
					],
				],
				'selector' => '{{WRAPPER}} .gyan-cd',
			]
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'digit_shadow',
				'selector' => '{{WRAPPER}} .gyan-cd',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'text_style',
			[
				'label' => esc_html__( 'Text', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'text_state!' => ''
				]
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .gyan-cd .gyan-cd-text' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
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
				'selector' => '{{WRAPPER}} .gyan-cd .gyan-cd-text',
			]
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'selector' => '{{WRAPPER}} .gyan-cd .gyan-cd-text',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'message_style',
			[
				'label' => esc_html__( 'Message', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'message_color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#d83030',
				'selectors' => [
					'{{WRAPPER}} .gyan-cd-message' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'message_typography',
				'fields_options' => [
					'typography' => [
						'default' =>'custom',
					],
					'font_size'   => [
						'default' => [
							'size' => '32',
						],
					],
					'line_height'   => [
						'default' => [
							'size' => '40',
						],
					],
				],
				'selector' => '{{WRAPPER}} .gyan-cd-message',
			]
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'message_shadow',
				'selector' => '{{WRAPPER}} .gyan-cd-message',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$data = $this->get_settings_for_display();

		$countunit = $data['units'];

		if ( 'yes' == $data['standard_countdown'] ) {
			$countunit = array( 'day','hour','minute','second' );
		}

		?>
		<div class="gyan-countdown" <?php

		if ( 'yes' != $data['standard_countdown'] ) { ?>

			data-text-year="<?php echo esc_attr( $data['text_year'] ); ?>"
			data-text-years="<?php echo esc_attr( $data['text_years'] ); ?>"
			data-text-month="<?php echo esc_attr( $data['text_month'] ); ?>"
			data-text-months="<?php echo esc_attr( $data['text_months'] ); ?>"
			data-text-week="<?php echo esc_attr( $data['text_week'] ); ?>"
			data-text-weeks="<?php echo esc_attr( $data['text_weeks'] ); ?>"

		<?php } ?>
		data-text-day="<?php echo esc_attr( $data['text_day'] ); ?>"
		data-text-days="<?php echo esc_attr( $data['text_days'] ); ?>"
		data-text-hour="<?php echo esc_attr( $data['text_hour'] ); ?>"
		data-text-hours="<?php echo esc_attr( $data['text_hours'] ); ?>"
		data-text-minute="<?php echo esc_attr( $data['text_minute'] ); ?>"
		data-text-minutes="<?php echo esc_attr( $data['text_minutes'] ); ?>"
		data-text-second="<?php echo esc_attr( $data['text_second'] ); ?>"
		data-text-seconds="<?php echo esc_attr( $data['text_seconds'] ); ?>"
		data-time="<?php echo esc_attr( $data['countdown_time'] ); ?>"
		data-text="<?php echo esc_attr( $data['text_state'] ); ?>"
		data-standard-countdown="<?php echo esc_attr( $data['standard_countdown'] ); ?>"
		data-link="<?php echo esc_attr( $data['redirect'] ); ?>"
		data-message="<?php echo esc_attr( $data['message'] ); ?>">
			<?php
			if( date_timestamp_get( date_create( $data['countdown_time'] ) ) > time() ) :
				foreach ($countunit as $value) :
				?><div class="gyan-cd">
						<div class="gyan-cd-<?php echo esc_attr($value); ?>">00</div>
						<?php if ( 'yes' == $data['text_state'] ) : ?>
							<div class="gyan-cd-text">
								<?php echo esc_html( ucfirst($value) ); ?>
							</div>
						<?php endif; ?>
					</div><?php
				endforeach;
			endif;
			?>
		</div>
		<?php
	}

	protected function _content_template() {}

}