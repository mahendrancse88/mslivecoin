<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Gyan_Counter extends Widget_Base {

	public function get_name()           { return 'gyan_counter'; }
	public function get_title()          { return esc_html__( 'Counter', 'gyan-elements' ); }
	public function get_icon()           { return 'gyan-el-icon eicon-counter'; }
	public function get_categories()     { return ['gyan-basic-addons']; }
	public function get_keywords()       { return [ 'gyan counter', 'gyan number', 'gyan timer' ]; }
	public function get_style_depends()  { return ['gyan-icon','gyan-counter']; }
	public function get_script_depends() { return ['jquery-numerator', 'gyan-widgets', ]; }

	protected function register_controls() {

		$this->start_controls_section(
			'counter_content',
			[
				'label' => esc_html__( 'Counter', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'gyan-elements' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'Enter Title', 'gyan-elements' ),
				'description' => esc_html__( 'You can use HTML.', 'gyan-elements' ),
				'default' => 'Satisfied Customers',
			]
		);

		$this->add_control(
			'icon_type',
			[
				'label'       => esc_html__( 'Icon Type', 'gyan-elements' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'none' => [
						'title' => esc_html__( 'None', 'gyan-elements' ),
						'icon'  => 'fa fa-ban',
					],
					'icon' => [
						'title' => esc_html__( 'Icon', 'gyan-elements' ),
						'icon'  => 'fa fa-gear',
					],
					'image' => [
						'title' => esc_html__( 'Image', 'gyan-elements' ),
						'icon'  => 'fa fa-picture-o',
					],
				],
				'default'     => 'icon',
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'elementor' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'fa-solid',
				],
				'condition' => [
					'icon_type' => 'icon',
				],
			]
		);

		$this->add_control(
			'image',
			[
				'label'     => esc_html__( 'Image', 'gyan-elements' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => GYAN_PLUGIN_URL .'addons/images/choose-img.jpg',
				],
				'condition' => [
					'icon_type' => 'image',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image_size',
				'default'   => 'full',
				'separator' => 'none',
				'condition' => [
					'icon_type' => 'image',
				],
			]
		);


		$this->add_control(
			'start_number',
			[
				'label' => esc_html__( 'Start Number', 'gyan-elements' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 100,
				'step' => 1,
			]
		);
		$this->add_control(
			'stop_number',
			[
				'label' => esc_html__( 'Stop Number', 'gyan-elements' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 500,
				'step' => 1,
			]
		);
		$this->add_control(
			'delimiter',
			[
				'label' => esc_html__( 'Thousand Delimiter', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'None', 'gyan-elements' ),
					',' => esc_html__( 'Comma', 'gyan-elements' ),
					'.' => esc_html__( 'Dot', 'gyan-elements' ),
					'|' => esc_html__( 'Pipe', 'gyan-elements' ),
					' ' => esc_html__( 'space', 'gyan-elements' ),
				],
				'default' => '',
			]
		);
		$this->add_control(
			'speed',
			[
				'label' => esc_html__( 'Counting Duration', 'gyan-elements' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 2000,
				'min' => 100,
				'max' => 10000,
				'step' => 100,
			]
		);
		$this->add_control(
			'prefix',
			[
				'label' => esc_html__( 'Prefix', 'gyan-elements' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter Prefix', 'gyan-elements' ),
			]
		);
		$this->add_control(
			'prefix_space',
			[
				'label' => esc_html__( 'Prefix Space', 'gyan-elements' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em'],
				'range' => [
					'px' => [
						'min' => -20,
					],
				],
				'condition' => [
					'prefix!' => ''
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-counter-prefix' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'suffix',
			[
				'label' => esc_html__( 'Suffix', 'gyan-elements' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter Suffix', 'gyan-elements' ),
			]
		);
		$this->add_control(
			'suffix_space',
			[
				'label' => esc_html__( 'Suffix space', 'gyan-elements' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em'],
				'range' => [
					'px' => [
						'min' => -20,
					],
				],
				'condition' => [
					'suffix!' => ''
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-counter-suffix' => 'margin-left: {{SIZE}}{{UNIT}};',
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
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .gyan-counter' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'icon_style',
			[
				'label' => esc_html__( 'Icon/Image', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'icon_type!' => 'none'
				]
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#d83030',
				'selectors' => [
					'{{WRAPPER}} .gyan-counter-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .gyan-counter-icon svg' => 'fill: {{VALUE}};',
				],
				'condition' => [
					'icon_type' => 'icon',
				],
			]
		);
		$this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Size', 'gyan-elements' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'max' => 200,
					],
				],
				'default' => [
					'size' => '40'
				],
				'condition' => [
					'icon_type' => 'icon',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-counter-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'icon_bg',
				'label'    => esc_html__( 'Background', 'gyan-elements' ),
				'types'    => [ 'none','classic','gradient' ],
				'selector' => '{{WRAPPER}} .gyan-counter-icon',
			]
		);

		$this->add_responsive_control(
			'info_padding',
			[
				'label'      => esc_html__( 'Padding', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-counter-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'icon_border',
				'selector' => '{{WRAPPER}} .gyan-counter-icon',
			]
		);

		$this->add_responsive_control(
			'icon_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .gyan-counter-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_margin',
			[
				'label' => esc_html__( 'Margin', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .gyan-counter-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'icon_shadow',
				'selector' => '{{WRAPPER}} .gyan-counter-icon',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'number_style',
			[
				'label' => esc_html__( 'Number', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'number_color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#032e42',
				'selectors' => [
					'{{WRAPPER}} .gyan-counter-number-wrap' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'number_typography',
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
							'size' => '70',
						],
					],
				],
				'selector' => '{{WRAPPER}} .gyan-counter-number-wrap',
			]
		);

		$this->add_responsive_control(
			'number_margin',
			[
				'label' => esc_html__( 'Margin', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .gyan-counter-number-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'number_shadow',
				'selector' => '{{WRAPPER}} .gyan-counter-number-wrap',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'title_style',
			[
				'label' => esc_html__( 'Title', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'title!' => ''
				]
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#676767',
				'selectors' => [
					'{{WRAPPER}} .gyan-counter-title' => 'color: {{VALUE}};',
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
							'size' => '20',
						],
					],
					'line_height'   => [
						'default' => [
							'size' => '40',
						],
					],
				],
				'selector' => '{{WRAPPER}} .gyan-counter-title',
			]
		);

		$this->add_control(
			'title_html_tag',
			[
				'label'   => esc_html__( 'Title HTML Tag', 'gyan-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h4',
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
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label' => esc_html__( 'Margin', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .gyan-counter-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_shadow',
				'selector' => '{{WRAPPER}} .gyan-counter-title',
			]
		);

		$this->end_controls_section();

	}


	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<div class="gyan-counter">


		<?php if ( 'none' != $settings['icon_type'] ) : ?>


			<?php if ( 'icon' == $settings['icon_type'] ) {
		        ob_start();
				Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );
				$counter_icon = ob_get_clean();

		        if ( '' != $counter_icon ) { ?>
		            <div class="gyan-counter-icon gyan-icon">
		           		<?php echo $counter_icon; ?>
		            </div>
		        <?php }
			} ?>

			<?php if ( 'image' == $settings['icon_type'] ) { ?>
				<span class="gyan-counter-icon gyan-icon">
					<?php
                    if ( ! empty( $settings['image']['url'] ) ) {
                        echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'image_size', 'image' );
                    }
                    ?>
				</span>
			<?php } ?>


		<?php endif; ?>


			<?php if ( $settings['start_number'] && $settings['stop_number'] ): ?>
				<div class="gyan-counter-number-wrap">
					<?php if ( $settings['prefix']): ?>
						<span class="gyan-counter-prefix"><?php echo esc_html($settings['prefix']); ?></span>
					<?php endif; ?>

					<span class="gyan-counter-number"
					data-duration="<?php echo esc_attr($settings['speed']); ?>"
					data-to-value="<?php echo esc_attr($settings['stop_number']); ?>"
					data-delimiter="<?php echo esc_attr($settings['delimiter']); ?>">
						<?php echo esc_html($settings['start_number']); ?>
					</span>

					<?php if ( $settings['suffix']): ?>
						<span class="gyan-counter-suffix">
							<?php echo esc_html($settings['suffix']); ?>
						</span>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( '' != $settings['title'] ) : ?>
				<<?php echo $settings['title_html_tag']; ?> class="gyan-counter-title">
					<?php echo $settings['title']; ?>
				</<?php echo $settings['title_html_tag']; ?>>
			<?php endif; ?>

			<div class="clear"></div>
		</div><!-- .gyan-counter -->
		<?php
	}


	protected function _content_template() {}

}