<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Repeater;
use Elementor\Group_Control_Background;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Gyan_Animated_Text extends Widget_Base {

	public function get_name()           { return 'gyan_animated_text'; }
	public function get_title()          { return esc_html__( 'Animated Text', 'gyan-elements' ); }
	public function get_icon()           { return 'gyan-el-icon eicon-animation-text'; }
	public function get_categories()     { return ['gyan-basic-addons']; }
	public function get_keywords()       { return [ 'gyan animated text', 'gyan slide text','typing','text','animation','animated' ]; }
	public function get_style_depends()  { return ['gyan-animated-text']; }
	public function get_script_depends() { return ['typed', 'gyan-widgets', ]; }

	protected function register_controls() {

		$this->start_controls_section(
			'animated_text_content',
			[
				'label' => esc_html__( 'Animated Text', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'animated_text_items',
			[
				'label' => esc_html__( 'Text', 'gyan-elements' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'default' => 'Fancy text',
			]
		);

		$this->add_control(
			'animated_text',
			[
				'label' => esc_html__( 'Animated Text', 'gyan-elements' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'animated_text_items' => 'First text',
					],
					[
						'animated_text_items' => 'Second text',
					],
					[
						'animated_text_items' => 'Third text',
					],
					[
						'animated_text_items' => 'Fourth text',
					],
				],
				'title_field' => '{{{ animated_text_items }}}',
			]
		);

		$this->add_control(
			'animated_prefix',
			[
				'label' => esc_html__( 'Prefix', 'gyan-elements' ),
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter prefix text', 'gyan-elements' ),
				'default' => 'Prefix text ',
			]
		);
		$this->add_control(
			'animated_suffix',
			[
				'label' => esc_html__( 'Suffix', 'gyan-elements' ),
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter suffix text', 'gyan-elements' ),
				'default' => ' Suffix text',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'animated_settings',
			[
				'label' => esc_html__( 'Animated Settings', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'display',
			[
				'label' => esc_html__( 'Display', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'inline' => esc_html__( 'Inline', 'gyan-elements' ),
					'block' => esc_html__( 'Block', 'gyan-elements' ),
				],
				'default' => 'inline',
				'selectors' => [
					'{{WRAPPER}} .gyan-animated-text-prefix, {{WRAPPER}} .gyan-animated-text-suffix' => 'display: {{VALUE}};',
				],
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
					'justify' => [
						'title' => esc_html__( 'justify', 'gyan-elements' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .gyan-animated-text' => 'text-align: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'animation_type',
			[
				'label' => esc_html__( 'Animation Type', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'typing',
				'options' => [
					'typing' => esc_html__( 'Typing', 'gyan-elements' ),
					'fadeIn' => esc_html__( 'Fade', 'gyan-elements' ),
					'fadeInUp' => esc_html__( 'Fade Up', 'gyan-elements' ),
					'fadeInDown' => esc_html__( 'Fade Down', 'gyan-elements' ),
					'fadeInLeft' => esc_html__( 'Fade Left', 'gyan-elements' ),
					'fadeInRight' => esc_html__( 'Fade Right', 'gyan-elements' ),
					'zoomIn' => esc_html__('Zoom In', 'gyan-elements'),
					'zoomInLeft' => esc_html__('Zoom In Left', 'gyan-elements'),
					'zoomInRight' => esc_html__('Zoom In Right', 'gyan-elements'),
					'bounceIn' => esc_html__('Bounce In', 'gyan-elements'),
					'slideInDown' => esc_html__('Slide In Down', 'gyan-elements'),
					'slideInLeft' => esc_html__('Slide In Left', 'gyan-elements'),
					'slideInRight' => esc_html__('Slide In Right', 'gyan-elements'),
					'slideInUp' => esc_html__('Slide In Up', 'gyan-elements'),
					'lightSpeedIn' => esc_html__('Light Speed In', 'gyan-elements'),
					'swing' => esc_html__( 'Swing', 'gyan-elements' ),
					'bounce' => esc_html__('Bounce', 'gyan-elements'),
					'flash' => esc_html__('Flash', 'gyan-elements'),
					'pulse' => esc_html__('Pulse', 'gyan-elements'),
					'rubberBand' => esc_html__('Rubber Band', 'gyan-elements'),
					'shake' => esc_html__('Shake', 'gyan-elements'),
					'headShake' => esc_html__('Head Shake', 'gyan-elements'),
					'swing' => esc_html__('Swing', 'gyan-elements'),
					'tada' => esc_html__('Tada', 'gyan-elements'),
					'wobble' => esc_html__('Wobble', 'gyan-elements'),
					'jello' => esc_html__('Jello', 'gyan-elements'),
				],
			]
		);
		$this->add_control(
			'delay',
			[
				'label' => esc_html__( 'Delay', 'gyan-elements' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 100,
				'max' => 10000,
				'step' => 100,
				'default' => '2000'
			]
		);
		$this->add_control(
			'typing_speed',
			[
				'label' => esc_html__( 'Typing Speed', 'gyan-elements' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 100,
				'max' => 10000,
				'step' => 100,
				'default' => '100',
				'condition' => [
					'animation_type' => 'typing',
				],
			]
		);
		$this->add_control(
			'loop',
			[
				'label' => esc_html__( 'Loop', 'gyan-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'animation_type' => 'typing',
				],
				'default' => 'yes',
			]
		);
		$this->add_control(
			'cursor',
			[
				'label' => esc_html__( 'Cursor', 'gyan-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'gyan-elements' ),
				'label_off' => esc_html__( 'Hide', 'gyan-elements' ),
				'default' => 'yes',
				'condition' => [
					'animation_type' => 'typing',
				],
			]
		);
		$this->add_control(
			'cursor_color',
			[
				'label' => esc_html__( 'Cursor Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#d83030',
				'condition' => [
					'cursor' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-animated-text .typed-cursor' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'tag',
			[
				'label' => esc_html__( 'Selct Tag', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'p' => 'p',
				],
				'default' => 'h3',
			]
		);

		$this->add_responsive_control(
			'animated_text_tag',
			[
				'label'      => esc_html__( 'Margin', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-animated-text-tag' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();



		$this->start_controls_section(
			'animated_style',
			[
				'label' => esc_html__( 'Animated Text', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_responsive_control(
            'content_width',
            [
                'label'                 => esc_html__( 'Width', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 500,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px', '%' ],
                'condition' => [
                	'animation_type!' => 'typing'
                ],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-animated-text-strings' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'separator'             => 'before',
            ]
        );

		$this->add_control(
			'animated_color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#d83030',
				'selectors' => [
					'{{WRAPPER}} .gyan-animated-text-strings, {{WRAPPER}} .typed-cursor' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'animated_typography',
				'selector' => '{{WRAPPER}} .gyan-animated-text-strings span,{{WRAPPER}} .gyan-animated-text-strings, {{WRAPPER}} .typed-cursor',
			]
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'animated_shadow',
				'selector' => '{{WRAPPER}} .gyan-animated-text-strings',
			]
		);

		$this->add_responsive_control(
			'animated_text_radius',
			[
				'label' => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .gyan-animated-text-strings' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'animated_text_padding',
			[
				'label'      => esc_html__( 'Padding', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-animated-text-strings' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'animated_text_margin',
			[
				'label'      => esc_html__( 'Margin', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-animated-text-strings' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'animated_text_bg',
				'label'    => esc_html__( 'Background', 'gyan-elements' ),
				'types'    => [ 'none','classic','gradient' ],
				'selector' => '{{WRAPPER}} .gyan-animated-text-strings',
			]
		);


		$this->end_controls_section();


		$this->start_controls_section(
			'prefix_style',
			[
				'label' => esc_html__( 'Prefix Text', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'animated_prefix!' => ''
				],
			]
		);

		$this->add_control(
			'prefix_color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#032e42',
				'selectors' => [
					'{{WRAPPER}} .gyan-animated-text-prefix' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'prefix_typography',
				'selector' => '{{WRAPPER}} .gyan-animated-text-prefix',
			]
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'prefix_shadow',
				'selector' => '{{WRAPPER}} .gyan-animated-text-prefix',
			]
		);

		$this->end_controls_section();



		$this->start_controls_section(
			'suffix_style',
			[
				'label' => esc_html__( 'Suffix Text', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'animated_suffix!' => ''
				],
			]
		);

		$this->add_control(
			'suffix_color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#032e42',
				'selectors' => [
					'{{WRAPPER}} .gyan-animated-text-suffix' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'suffix_typography',
				'selector' => '{{WRAPPER}} .gyan-animated-text-suffix',
			]
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'suffix_shadow',
				'selector' => '{{WRAPPER}} .gyan-animated-text-suffix',
			]
		);

		$this->end_controls_section();

	}


	protected function render() {
		$data = $this->get_settings_for_display();

		// comma (,) is separator for both type and animated text

		$animated_text = '';
		foreach ($data['animated_text'] as $text) {
			$animated_text .= $text['animated_text_items'].'@@';
		}
		?>
		<div class="gyan-animated-text"
		data-animated-text="<?php echo esc_attr( $animated_text ); ?>"
		data-anim="<?php echo esc_attr( $data['animation_type'] ); ?>"
		data-speed="<?php echo esc_attr( $data['typing_speed'] ); ?>"
		data-delay="<?php echo esc_attr( $data['delay'] ); ?>"
		data-cursor="<?php echo esc_attr( $data['cursor'] ); ?>"
		data-loop="<?php echo esc_attr( $data['loop'] ); ?>">
			<<?php echo esc_html( $data['tag'] ); ?> class="gyan-animated-text-tag"><?php
				if ( $data['animated_prefix'] ) :
					?><span class="gyan-animated-text-prefix"><?php echo esc_html( $data['animated_prefix'] ); ?></span> <?php
				endif;

				if ( 'typing' == $data['animation_type'] ) :
					?><span class="gyan-animated-text-strings"><?php echo esc_html( $data['animated_text'][0]['animated_text_items'] ); ?></span> <?php
				else :
					?><span class="gyan-animated-text-strings"><?php echo esc_html( rtrim($animated_text, '@@') ); ?></span> <?php
				endif;

				if ( $data['animated_suffix'] ) :
					?><span class="gyan-animated-text-suffix"><?php echo esc_html( $data['animated_suffix'] ); ?></span><?php
				endif;
			?></<?php echo esc_html( $data['tag'] ); ?>>
		</div><!-- .gyan-animated-text -->
		<?php
	}

	protected function _content_template() {

	}
}