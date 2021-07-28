<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Gyan_Piechart extends Widget_Base {

	public function get_name()           { return 'gyan_piechart'; }
	public function get_title()          { return esc_html__( 'Piechart', 'gyan-elements' ); }
	public function get_icon()           { return 'gyan-el-icon eicon-counter-circle'; }
	public function get_categories()     { return ['gyan-basic-addons']; }
	public function get_keywords()       { return [ 'gyan piechart', 'gyan chart' ]; }
	public function get_style_depends()  { return ['gyan-flex','gyan-piechart']; }
	public function get_script_depends() { return ['easypiechart', 'gyan-widgets' ]; }

	protected function register_controls() {
		// Start piecharts Content
		// =========================
		$this->start_controls_section(
			'piecharts_content',
			[
				'label' => esc_html__( 'Piechart', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'gyan-elements' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter title', 'gyan-elements' ),
				'description' => esc_html__( 'You can use HTML.', 'gyan-elements' ),
				'default' => 'Web Development',
			]
		);
		$this->add_control(
			'value',
			[
				'label' => esc_html__( 'Value', 'gyan-elements' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'default' => 75,
			]
		);
		$this->add_control(
			'max_value',
			[
				'label' => esc_html__( 'Max Value', 'gyan-elements' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'default' => 100,
			]
		);
		$this->add_control(
			'prefix',
			[
				'label' => esc_html__( 'Prefix', 'gyan-elements' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter prefix', 'gyan-elements' ),
			]
		);
		$this->add_control(
			'suffix',
			[
				'label' => esc_html__( 'Suffix', 'gyan-elements' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter suffix', 'gyan-elements' ),
				'default' => '%',
			]
		);
		$this->add_control(
			'size',
			[
				'label' => esc_html__( 'Size', 'gyan-elements' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 500,
					],
				],
				'default' => [
					'size' => 250,
				],
			]
		);
		$this->add_control(
			'speed',
			[
				'label' => esc_html__( 'Animation Duration', 'gyan-elements' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 2000,
				'min' => 100,
				'max' => 10000,
				'step' => 100,
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'chart_style',
			[
				'label' => esc_html__( 'Chart', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'bar_color',
			[
				'label' => esc_html__('Bar Color', 'gyan-elements'),
				'type' => Controls_Manager::COLOR,
				'default' => '#d83030',
			]
		);

		$this->add_control(
			'bar_width',
			[
				'label' => esc_html__('Bar Width', 'gyan-elements'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 20,
				],
			]
		);
		$this->add_control(
			'bar_cap',
			[
				'label' => esc_html__( 'Bar Cap', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'round' => esc_html__( 'Round', 'gyan-elements' ),
					'square' => esc_html__( 'Square', 'gyan-elements' ),
				],
				'default' => 'round',
			]
		);
		$this->add_control(
			'track_color',
			[
				'label' => esc_html__('Track Color', 'gyan-elements'),
				'type' => Controls_Manager::COLOR,
				'default' => '#eee',
			]
		);
		$this->add_control(
			'track_width',
			[
				'label' => esc_html__('Track Width', 'gyan-elements'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 20,
				],
			]
		);
		$this->add_control(
			'scale_color',
			[
				'label' => esc_html__('Scale Color', 'gyan-elements'),
				'type' => Controls_Manager::COLOR,
				'default' => '#d83030',
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
			'title_position',
			[
				'label' => esc_html__( 'Position', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'top' => esc_html__( 'Top', 'gyan-elements' ),
					'bottom' => esc_html__( 'Bottom', 'gyan-elements' ),
					'below_chart' => esc_html__( 'Below Chart', 'gyan-elements' ),
				],
				'default' => 'bottom',
			]
		);
		$this->add_control(
			'title_color',
			[
				'label' => esc_html__('Text Color', 'gyan-elements'),
				'type' => Controls_Manager::COLOR,
				'default' => '#676767',
				'selectors' => [
					'{{WRAPPER}} .gyan-piechart-title' => 'color: {{VALUE}};',
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
							'size' => '16',
						],
					],
					'line_height'   => [
						'default' => [
							'size' => '24',
						],
					],
				],
				'selector' => '{{WRAPPER}} .gyan-piechart-title',
			]
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_shadow',
				'selector' => '{{WRAPPER}} .gyan-piechart-title',
			]
		);
		$this->add_responsive_control(
			'title_margin',
			[
				'label' => esc_html__( 'Margin', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '10',
					'right' => '0',
					'bottom' => '10',
					'left' => '0',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-piechart .gyan-piechart-title,{{WRAPPER}} .gyan-piechart-title-below-chart' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'value_style',
			[
				'label' => esc_html__( 'Value', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'value_color',
			[
				'label' => esc_html__('Text Color', 'gyan-elements'),
				'type' => Controls_Manager::COLOR,
				'default' => '#032e42',
				'selectors' => [
					'{{WRAPPER}} .gyan-piechart-percent' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'value_typography',
				'fields_options' => [
					'typography' => [
						'default' =>'custom',
					],
					'font_weight' => [
						'default' => '600',
					],
					'font_size'   => [
						'default' => [
							'size' => '50',
						],
					],
					'line_height'   => [
						'default' => [
							'size' => '50',
						],
					],
				],
				'selector' => '{{WRAPPER}} .gyan-piechart-percent',
			]
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'value_shadow',
				'selector' => '{{WRAPPER}} .gyan-piechart-percent',
			]
		);

		$this->end_controls_section();

	}


	protected function render() {
		$data = $this->get_settings_for_display();
		$percent = 100;
		if ( $data['value'] && $data['max_value'] ) {
			$percent = round( $data['value'] / $data['max_value'] * 100 );
		}
		?>
		<div class="gyan-piechart-wrapper">
			<div class="gyan-piechart" style="width: <?php echo esc_attr( $data['size']['size'] ); ?>px; height: <?php echo esc_attr( $data['size']['size'] ); ?>px;">
				<div class="gyan-piechart-wrap"
				data-track="<?php echo esc_attr( $data['track_color'] ); ?>"
				data-track-width="<?php echo esc_attr( $data['track_width']['size'] ); ?>"
				data-bar="<?php echo esc_attr( $data['bar_color'] ); ?>"
				data-line="<?php echo esc_attr( $data['bar_width']['size'] ); ?>"
				data-cap="<?php echo esc_attr( $data['bar_cap'] ); ?>"
				data-speed="<?php echo esc_attr( $data['speed'] ); ?>"
				data-scale="<?php echo esc_attr( $data['scale_color'] ); ?>"
				data-size="<?php echo esc_attr( $data['size']['size'] ); ?>"
				data-percent="<?php echo esc_attr( $percent ); ?>">
				</div>
				<div class="gyan-piechart-content gyan-flex">
					<div class="gyan-piechart-center">
						<?php if ( 'bottom' == $data['title_position'] || 'below_chart' == $data['title_position'] ): ?>
							<span class="gyan-piechart-percent">
								<?php echo esc_html( $data['prefix'].$data['value'].$data['suffix'] ); ?>
							</span>
						<?php endif; ?>
						<?php if ( 'below_chart' != $data['title_position'] && $data['title'] ): ?>
							<?php printf( '<h3 class="gyan-piechart-title">%1$s</h3>', $data['title'] ); ?>
						<?php endif; ?>
						<?php if ( 'top' == $data['title_position'] ): ?>
							<span class="gyan-piechart-percent">
								<?php echo esc_html( $data['prefix'].$data['value'].$data['suffix'] ); ?>
							</span>
						<?php endif; ?>
					</div>
				</div>

			</div>
			<?php if ( 'below_chart' == $data['title_position'] && $data['title'] ): ?>
					<?php printf( '<h3 class="gyan-piechart-title gyan-piechart-title-below-chart">%1$s</h3>', $data['title'] ); ?>
				<?php endif; ?>
			<div class="clear"></div>
		</div>
		<?php
	}

	protected function _content_template() {}
}