<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Repeater;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Gyan_Progressbar extends Widget_Base {

	public function get_name()           { return 'gyan_progressbar'; }
	public function get_title()          { return esc_html__( 'Progressbar', 'gyan-elements' ); }
	public function get_icon()           { return 'gyan-el-icon eicon-skill-bar'; }
	public function get_categories()     { return ['gyan-basic-addons']; }
	public function get_keywords()       { return [ 'gyan progressbar', 'gyan bar' ]; }
	public function get_style_depends()  { return ['gyan-progress-bar']; }
	public function get_script_depends() { return ['gyan-widgets', ]; }

	protected function register_controls() {

		$this->start_controls_section(
			'progressbars_content',
			[
				'label' => esc_html__( 'Progressbar', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'gyan-elements' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__('Enter Title', 'gyan-elements'),
				'description' => esc_html__( 'You can use HTML.', 'gyan-elements' ),
				'default' => 'Web Development',
			]
		);
		$this->add_control(
			'percentage',
			[
				'label' => esc_html__( 'Value', 'gyan-elements' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'default' => 90,
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

		$this->end_controls_section();


		$this->start_controls_section(
			'progressbars_style',
			[
				'label' => esc_html__( 'Progressbar', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'bar_bg',
				'label' => esc_html__( 'Bar Background', 'gyan-elements' ),
				'types' => [ 'classic', 'gradient' ],
				'fields_options' => [
					'background' => [
						'default' =>'classic',
					],
					'color' => [
						'default' => '#d83030',
					],
				],
				'selector' => '{{WRAPPER}} .gyan-progress-bar-data',
			]
		);
		$this->add_responsive_control(
			'bars_height',
			[
				'label' => esc_html__('Height', 'gyan-elements'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em'],
				'selectors' => [
					'{{WRAPPER}} .gyan-pbar-bg-wrap'           => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .gyan-progress-bar-data span' => 'width: calc({{SIZE}}{{UNIT}} * 3); height: calc({{SIZE}}{{UNIT}} * 3); border-width: calc({{SIZE}}{{UNIT}} - 1{{UNIT}} ); margin-top:calc(-{{SIZE}}{{UNIT}}*3 / 2);',
				],

				'default' => [
					'size' => 8,
				],
			]
		);
		$this->add_responsive_control(
			'bars_border_radius',
			[
				'label' => esc_html__('Border Radius', 'gyan-elements'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .gyan-pbar-bg-wrap, {{WRAPPER}} .gyan-progress-bar-data' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'track',
			[
				'label' => esc_html__( 'Track', 'gyan-elements' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'track_height',
			[
				'label' => esc_html__('Track Height', 'gyan-elements'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em'],
				'default' => [
					'size' => 8,
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-pbar-bg-wrap:before' => 'height: {{SIZE}}{{UNIT}}; margin-top:calc( -{{SIZE}}{{UNIT}} / 2);',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'track_bg',
				'label' => esc_html__( 'Track Background', 'gyan-elements' ),
				'types' => [ 'classic', 'gradient' ],
				'fields_options' => [
					'background' => [
						'default' =>'classic',
					],
					'color' => [
						'default' => '#f5f5f5',
					],
				],
				'selector' => '{{WRAPPER}} .gyan-pbar-bg-wrap:before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'title_style',
			[
				'label' => esc_html__('Title', 'gyan-elements'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__('Text Color', 'gyan-elements'),
				'type' => Controls_Manager::COLOR,
				'default'=> '#111',
				'selectors' => [
					'{{WRAPPER}} .gyan-pbar-title' => 'color: {{VALUE}};',
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
				'selector' => '{{WRAPPER}} .gyan-pbar-title',
			]
		);
		$this->add_responsive_control(
			'title_margin',
			[
				'label' => esc_html__('Bottom Margin', 'gyan-elements'),
				'type' => Controls_Manager::SLIDER,
				'default'=> [
					'size' => '5',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-pbar-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'percentage_style',
			[
				'label' => esc_html__('Percentage', 'gyan-elements'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
		    'p_location',
		    [
		        'label'   => esc_html__( 'Percentage Position', 'gyan-elements' ),
		        'type'    => Controls_Manager::SELECT,
		        'options' => [
					'pbp-default'   => esc_html__( 'Default', 'gyan-elements' ),
					'pbp-right'     => esc_html__( 'Right to Title Text', 'gyan-elements' ),
					'pbp-right-alt' => esc_html__( 'Right to Title Text - Alternate', 'gyan-elements' ),
					'pbp-on-title'  => esc_html__( 'On Title Text (Hide Title Text)', 'gyan-elements' ),
		        ],
		        'default'   => 'pbp-default'
		    ]
		);

		$this->add_control(
			'bar_color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#eee',
				'condition' => [
					'p_location!' => 'pbp-on-title',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-pbar-percentage' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'percentage_typography',
				'condition' => [
					'p_location!' => 'pbp-on-title',
				],
				'selector' => '{{WRAPPER}} .gyan-pbar-percentage',
			]
		);


		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'percentage_box_bg',
				'label' => esc_html__( 'Edge Box Background', 'gyan-elements' ),
				'types' => [ 'classic', 'gradient' ],
				'fields_options' => [
					'background' => [
						'default' =>'classic',
					],
					'color' => [
						'default' => '#d83030',
					],
				],
				'condition' => [
					'p_location' => 'pbp-default',
				],
				'selector' => '{{WRAPPER}} .gyan-pbar-percentage,.gyan-progress-bar-data span',

			]
		);

		$this->add_control(
			'valuebox_border_col',
			[
				'label' => esc_html__('Edge Box Border Color', 'gyan-elements'),
				'type' => Controls_Manager::COLOR,
				'default'=> '#d83030',
				'condition' => [
					'p_location' => 'pbp-right-alt',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-progress-bar-data span' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'valuebox_bg_col',
			[
				'label' => esc_html__('Edge Box Background Color', 'gyan-elements'),
				'type' => Controls_Manager::COLOR,
				'default'=> '#ffffff',
				'condition' => [
					'p_location' => 'pbp-right-alt',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-progress-bar-data span' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'valuebox_border_radius',
			[
				'label' => esc_html__('Edge Box Border Radius', 'gyan-elements'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'condition' => [
					'p_location' => array('pbp-default','pbp-right-alt')
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-pbar-percentage,{{WRAPPER}} .gyan-progress-bar-data span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'percentage_margin',
			[
				'label' => esc_html__('Bottom Margin', 'gyan-elements'),
				'type' => Controls_Manager::SLIDER,
				'default'=> [
					'size' => '0',
				],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 300,
					],
				],
				'condition' => [
					'p_location!' => 'pbp-on-title',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-pbar-percentage' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
            'bubble_arrow',
            [
                'label'                 => esc_html__( 'Show Bubble Arrow', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'no',
                'label_on'              => esc_html__( 'Yes', 'gyan-elements' ),
                'label_off'             => esc_html__( 'No', 'gyan-elements' ),
                'return_value'          => 'yes',
				'condition' => [
					'p_location' => 'pbp-default',
				],
            ]
        );

        $this->add_control(
			'bubble_arrow_color',
			[
				'label' => esc_html__( 'Bubble Arrow Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#d83030',
				'condition' => [
					'p_location' => 'pbp-default',
					'bubble_arrow' => 'yes'
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-progress-bar .gyan-pbar-percentage:before' => 'border-color: {{VALUE}} transparent transparent;;',
				],
			]
		);

        $this->add_responsive_control(
			'bubble_arrow_size',
			[
				'label' => esc_html__('Bubble Arrow Size', 'gyan-elements'),
				'type' => Controls_Manager::SLIDER,
				'default'=> [
					'size' => '10',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 150,
					],
				],
				'condition' => [
					'p_location' => 'pbp-default',
					'bubble_arrow' => 'yes'
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-progress-bar .gyan-pbar-percentage:before' => 'bottom: -{{SIZE}}{{UNIT}};border-width: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0 0;',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$data = $this->get_settings_for_display();
		$percent = 100;
		if ( $data['percentage'] && $data['max_value']) {
			$percent = round( $data['percentage'] / $data['max_value'] * 100 );
		}

		$percentage_text = esc_html( $data['prefix'].$data['percentage'].$data['suffix'] );
		$percentage_prefix = ( $data['prefix'] ) ? '<span class="gyan-pbar-p-prefix">' . $data['prefix'] . '</span>' : '';
		$gyan_pbar_p_number = ( $data['percentage'] ) ? '<span class="gyan-pbar-p-number">' . $data['percentage'] . '</span>' : '';
		$gyan_pbar_p_unit = ( $data['suffix'] ) ? '<span class="gyan-pbar-p-unit">' . $data['suffix'] . '</span>' : '';
		$percentage_all = $percentage_prefix . $gyan_pbar_p_number . $gyan_pbar_p_unit;

		$gyan_plocation_alt = ( $data['p_location'] == 'pbp-right-alt' ) ? '<span></span>' : '';

		?>

		<div class="gyan-progress-bar <?php echo $data['p_location']; ?>">
		  <div class="gyan-pbar-wrap">
		    <div class="gyan-pbar-title-holder">
		      <div class="gyan-pbar-title"><?php

			      if ( 'pbp-on-title' == $data['p_location']) {
			      	echo $percentage_all;
			      } else {
			      	echo $data['title'];
			      }

		      ?></div>
		      <?php if ( 'pbp-on-title' != $data['p_location']) { ?>
		      	<div class="gyan-pbar-percentage"><?php echo $percentage_all; ?></div>
		      <?php } ?>
		    </div>
		    <div class="gyan-pbar-bg-holder">
		      <div class="gyan-pbar-bg-wrap">
		        <div class="gyan-progress-bar-data" data-width="<?php echo $data['percentage']; ?>"><?php echo $gyan_plocation_alt; ?></div>
		      </div>
		    </div>
		  </div>
		</div>

		<?php
	}

	protected function _content_template() {}

}