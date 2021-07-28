<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {exit; }

class Gyan_Image_Carousel extends Widget_Base {

	public function get_name()           { return 'gyan_image_carousel'; }
	public function get_title()          { return esc_html__( 'Image Carousel', 'gyan-elements' ); }
	public function get_icon()           { return 'gyan-el-icon eicon-carousel'; }
	public function get_categories()     { return [ 'gyan-advanced-addons' ]; }
	public function get_keywords()       { return [ 'gyan image', 'gyan carousel', 'gyan image' ]; }
	public function get_style_depends()  { return ['owl-carousel','gyan-image-carousel']; }
	public function get_script_depends() { return ['jquery-owl', 'gyan-widgets', ]; }

	protected function register_controls() {

		$this->start_controls_section(
			'image_content',
			[
				'label' => esc_html__( 'Image', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
		    'c_image',
		    [
				'label' => esc_html__( 'Choose Image', 'gyan-elements' ),
				'type' => Controls_Manager::MEDIA
		    ]
		);

		$repeater->add_control(
		    'link',
		    [
		        'label' => esc_html__( 'Image Link', 'gyan-elements' ),
					'type' => Controls_Manager::URL,
					'placeholder' => esc_html__( 'https://your-link.com', 'gyan-elements' ),
		    ]
		);

		$repeater->add_control(
		    'title',
		    [
		        'label' => esc_html__( 'Image Name', 'gyan-elements' ),
					'type' => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'Enter Name', 'gyan-elements' ),
					'description' => esc_html__( 'This name will be show only item header', 'gyan-elements' ),
					'default' => 'Youtube',
		    ]
		);

		$this->add_control(
			'images',
			[
				'label' => esc_html__( 'Add Image', 'gyan-elements' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'carousel_settings',
			[
				'label' => esc_html__( 'Slider Settings', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'gray_to_color',
			[
				'label' => esc_html__( 'Gray to hover Color Image', 'gyan-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'gyan-elements' ),
				'label_off' => esc_html__( 'Off', 'gyan-elements' ),
				'default' => 'no',
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label' => esc_html__( 'Autoplay', 'gyan-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'gyan-elements' ),
				'label_off' => esc_html__( 'Off', 'gyan-elements' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'pause',
			[
				'label' => esc_html__( 'Pause on Hover', 'gyan-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'gyan-elements' ),
				'label_off' => esc_html__( 'Off', 'gyan-elements' ),
				'default' => 'yes',
			]
		);
		$this->add_control(
			'mouse_drag',
			[
				'label' => esc_html__( 'Mouse Drag', 'gyan-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'gyan-elements' ),
				'label_off' => esc_html__( 'Off', 'gyan-elements' ),
				'default' => 'yes',
			]
		);
		$this->add_control(
			'touch_drag',
			[
				'label' => esc_html__( 'Touch Drag', 'gyan-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'gyan-elements' ),
				'label_off' => esc_html__( 'Off', 'gyan-elements' ),
				'default' => 'yes',
			]
		);
		$this->add_control(
			'loop',
			[
				'label' => esc_html__( 'Infinity Loop', 'gyan-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'gyan-elements' ),
				'label_off' => esc_html__( 'Off', 'gyan-elements' ),
				'default' => 'yes',
			]
		);
		$this->add_control(
			'nav_color',
			[
				'label' => esc_html__( 'Navigation Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'nav!' => '',
				],
				'default' => '#111',
				'selectors' => [
					'{{WRAPPER}} .gyan-image-carousel .owl-prev, {{WRAPPER}} .gyan-image-carousel .owl-next' => 'color: {{VALUE}}'
				],
			]
		);
		$this->add_control(
			'delay',
			[
				'label' => esc_html__( 'Delay', 'gyan-elements' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 5000,
				'step' => 100,
				'min' => 1000,
				'max' => 15000,
			]
		);
		$this->add_control(
			'speed',
			[
				'label' => esc_html__( 'Speed', 'gyan-elements' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 1000,
				'step' => 100,
				'min' => 100,
				'max' => 5000,
			]
		);

		$this->add_control(
			'item_margin',
			[
				'label' => esc_html__( 'Space Between Two Images', 'gyan-elements' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0,
				'step' => 1,
				'min' => 0,
				'max' => 100,
			]
		);

		$this->add_control(
			'breakpoint1_items',
			[
				'label' => esc_html__( 'Break Point 1 Items (1200px)', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => gyan_one_to_ten_array(),
				'default' => '5',
			]
		);

		$this->add_control(
			'breakpoint2_items',
			[
				'label' => esc_html__( 'Break Point 2 Items (1100px)', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => gyan_one_to_ten_array(),
				'default' => '4',
			]
		);

		$this->add_control(
			'breakpoint3_items',
			[
				'label' => esc_html__( 'Break Point 3 Items (1024px)', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => gyan_one_to_ten_array(),
				'default' => '3',
			]
		);

		$this->add_control(
			'breakpoint4_items',
			[
				'label' => esc_html__( 'Break Point 4 Items (900px)', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => gyan_one_to_ten_array(),
				'default' => '2',
			]
		);

		$this->add_control(
			'breakpoint5_items',
			[
				'label' => esc_html__( 'Break Point 5 Items (700px)', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => gyan_one_to_ten_array(),
				'default' => '1',
			]
		);

		$this->add_control(
			'breakpoint6_items',
			[
				'label' => esc_html__( 'Break Point 6 Items (400px)', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => gyan_one_to_ten_array(),
				'default' => '1',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'box_style',
			[
				'label' => esc_html__( 'Image Box', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'image_padding',
			[
				'label' => esc_html__( 'Image Padding', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'tablet_default' => [
					'top' => '15',
					'right' => '35',
					'bottom' => '15',
					'left' => '35',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-image-item-inner a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'box_padding',
			[
				'label' => esc_html__( 'Box Padding', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .gyan-image-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'box_radius',
			[
				'label' => esc_html__( 'Radius', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .gyan-image-item-inner img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'box_tabs' );

		$this->start_controls_tab(
			'box_normal',
			[
				'label' => esc_html__( 'Normal', 'gyan-elements' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'box_bg',
				'label' => esc_html__( 'Background', 'gyan-elements' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .gyan-image-item-inner',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'box_border',
				'selector' => '{{WRAPPER}} .gyan-image-item-inner',
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'selector' => '{{WRAPPER}} .gyan-image-item-inner',
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'box_hover',
			[
				'label' => esc_html__( 'Hover', 'gyan-elements' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'box_hover_bg',
				'label' => esc_html__( 'Background', 'gyan-elements' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .gyan-image-item-inner:hover',
			]
		);
		$this->add_control(
			'hover_box_border',
			[
				'label' => esc_html__( 'Border Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1085e4',
				'selectors' => [
					'{{WRAPPER}} .gyan-image-item-inner:hover' => 'border-color: {{VALUE}}'
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'hover_box_shadow',
				'selector' => '{{WRAPPER}} .gyan-image-item-inner:hover',
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	protected function render() {
		$data = $this->get_settings_for_display();
		$data_rtl = is_rtl() ? 'true' : 'false';
		?>
		<div class="gyan-image-carousel owl-carousel <?php if ( 'yes' == $data['gray_to_color'] ) { echo 'gyan-image-carousel-g2c'; } ?>" data-autoplay="<?php echo esc_attr( $data['autoplay'] ); ?>" data-pause="<?php echo esc_attr( $data['pause'] ); ?>" data-mouse-drag="<?php echo esc_attr( $data['mouse_drag'] ); ?>" data-touch-drag="<?php echo esc_attr( $data['touch_drag'] ); ?>" data-loop="<?php echo esc_attr( $data['loop'] ); ?>" data-speed="<?php echo esc_attr( $data['speed'] ); ?>" data-delay="<?php echo esc_attr( $data['delay'] ); ?>" data-margin="<?php echo esc_attr( $data['item_margin'] ); ?>" data-breakpoint1-items="<?php echo esc_attr( $data['breakpoint1_items'] ); ?>" data-breakpoint2-items="<?php echo esc_attr( $data['breakpoint2_items'] ); ?>" data-breakpoint3-items="<?php echo esc_attr( $data['breakpoint3_items'] ); ?>" data-breakpoint4-items="<?php echo esc_attr( $data['breakpoint4_items'] ); ?>" data-breakpoint5-items="<?php echo esc_attr( $data['breakpoint5_items'] ); ?>" data-breakpoint6-items="<?php echo esc_attr( $data['breakpoint6_items'] ); ?>" data-rtl="<?php echo $data_rtl; ?>">
			<?php foreach ($data['images'] as $image):
						if ( $image['c_image']['url'] ):
							// responsive image
							$imageTagHtml = wp_get_attachment_image( $image['c_image']['id'], 'full', "", ["alt" => esc_attr( $image['title'] )]); ?>
							<div class="gyan-image-item">
								<div class="gyan-image-item-inner">
									<a href="<?php echo esc_url( $image['link']['url'] ); ?>" <?php
									if ( 'on' == $image['link']['is_external'] ):
										?> target="_blank" <?php
									endif; ?><?php if ( 'on' == $image['link']['nofollow'] ):
										?>rel="nofollow" <?php
										endif; ?>>
										<?php echo $imageTagHtml; ?>
									</a>
								</div>
							</div>
							<?php
						endif;
					endforeach; ?>
		</div>
		<?php
	}

	protected function _content_template() {}
}