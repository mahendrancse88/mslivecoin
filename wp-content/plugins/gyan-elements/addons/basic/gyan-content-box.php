<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Frontend;
use Elementor\Icons_Manager;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Gyan_Content_Box extends Widget_Base {

	public function get_name()          { return 'gyan_content_box'; }
	public function get_title()         { return esc_html__( 'Content Box', 'gyan-elements' ); }
	public function get_icon()          { return 'gyan-el-icon eicon-info-box'; }
	public function get_categories()    { return ['gyan-basic-addons']; }
	public function get_keywords()      { return [ 'gyan content box', 'gyan icon box', 'gyan image box', 'gyan box' ]; }
	public function get_style_depends() { return ['gyan-icon','gyan-content-box']; }

	protected function register_controls() {
		// Start Box Content
		// =====================
		$this->start_controls_section(
			'box_content',
			[
				'label' => esc_html__( 'Box', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'save_templates',
			[
				'label' => esc_html__( 'Use Save Templates', 'gyan-elements' ),
				'type' => Controls_Manager::SWITCHER,
			]
		);
		$this->add_control(
			'template',
			[
				'label' => esc_html__( 'Choose Template', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => gyan_get_page_templates(),
				'condition' => [
					'save_templates!' => '',
				],
				'description' => esc_html__('NOTE: Don\'t try to edit after insertion template. If you need to change the style or layout then you try to change the main template then save and then insert', 'gyan-elements'),
			]
		);
		$this->add_control(
			'ribbon_title',
			[
				'label' => esc_html__( 'Ribbon Title', 'gyan-elements' ),
				'type' => Controls_Manager::TEXT,
			]
		);
		$this->add_control(
			'ribbon_position',
			[
				'label' => esc_html__( 'Ribbon Position', 'gyan-elements' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'gyan-ribbon-left' => [
						'title' => esc_html__( 'Left', 'gyan-elements' ),
						'icon' => 'eicon-h-align-left',
					],
					'gyan-ribbon-right' => [
						'title' => esc_html__( 'Right', 'gyan-elements' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'condition' => [
					'ribbon_title!' => '',
				],
				'default' => 'gyan-ribbon-right',
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
		 			'save_templates' => '',
		 		],
			]
		);


		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'gyan-elements' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter Title', 'gyan-elements' ),
				'description' => esc_html__( 'You can use HTML.', 'gyan-elements' ),
				'default' => 'Apps Development',
				'condition' => [
					'save_templates' => '',
				],
			]
		);
		$this->add_control(
			'desc',
			[
				'label' => esc_html__( 'Description', 'gyan-elements' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter Description', 'gyan-elements' ),
				'description' => esc_html__( 'You can use HTML.', 'gyan-elements' ),
				'default' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloribus, autem amet. Labore eos cum at, et illo ducimus.',
				'condition' => [
					'save_templates' => '',
				],
			]
		);

		$this->end_controls_section();
		// End Box Content
		// =====================


		// Start Box Style
		// =====================
		$this->start_controls_section(
			'box_style',
			[
				'label' => esc_html__( 'Box', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'effects',
			[
				'label' => esc_html__( 'Effects', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'gyan-content-box-move' => esc_html__( 'Move', 'gyan-elements' ),
					'gyan-content-box-zoom' => esc_html__( 'Zoom', 'gyan-elements' ),
					'' => esc_html__( 'None', 'gyan-elements' ),
				],
				'default' => 'gyan-content-box-zoom',
			]
		);
		$this->add_control(
			'scale',
			[
				'label' => esc_html__( 'Scale', 'gyan-elements' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'step' => 0.1,
						'min' => 0.1,
						'max' => 5,
					],
				],
				'default' => [
					'size' => '1.1',
				],
				'condition' => [
					'effects' => 'gyan-content-box-zoom',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-content-box.gyan-content-box-zoom:hover' => 'transform: scale({{SIZE}});',
				],
			]
		);
		$this->add_control(
			'translateY',
			[
				'label' => esc_html__( 'Vertical', 'gyan-elements' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'step' => 1,
						'min' => -100,
						'max' => 100,
					],
				],
				'default' => [
					'size' => '-10',
				],
				'condition' => [
					'effects' => 'gyan-content-box-move',
				],
			]
		);
		$this->add_control(
			'translateX',
			[
				'label' => esc_html__( 'Horizontal', 'gyan-elements' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'step' => 1,
						'min' => -100,
						'max' => 100,
					],
				],
				'default' => [
					'size' => '0',
				],
				'condition' => [
					'effects' => 'gyan-content-box-move',
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

		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#d83030',
				'condition' => [
					'save_templates' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-content-box .gyan-content-box-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .gyan-content-box .gyan-content-box-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'icon_border',
				'condition' => [
					'save_templates' => '',
				],
				'selector' => '{{WRAPPER}} .gyan-content-box .gyan-content-box-icon',
			]
		);
		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#032e42',
				'condition' => [
					'save_templates' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-content-box .gyan-content-box-title' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'desc_color',
			[
				'label' => esc_html__( 'Description Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#676767',
				'condition' => [
					'save_templates' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-content-box .gyan-content-box-desc' => 'color: {{VALUE}};',
				],
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
						'default' => '#fff',
					],
				],
				'selector' => '{{WRAPPER}} .gyan-content-box',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'box_border',
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'color' => [
						'default' => '#eee',
					],
					'width' => [
						'default' => [
							'top' => '1',
							'right' => '1',
							'bottom' => '1',
							'left' => '1',
							'isLinked' => true,
						]
					],
				],
				'selector' => '{{WRAPPER}} .gyan-content-box',
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'selector' => '{{WRAPPER}} .gyan-content-box',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'box_hover',
			[
				'label' => esc_html__( 'Hover', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'icon_hover_color',
			[
				'label' => esc_html__( 'Icon Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'save_templates' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-content-box:hover .gyan-content-box-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .gyan-content-box:hover .gyan-content-box-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'icon_hover_border',
			[
				'label' => esc_html__( 'Icon Border Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'save_templates' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-content-box:hover .gyan-content-box-icon' => 'border-color: {{VALUE}}'
				],
			]
		);
		$this->add_control(
			'title_hover_color',
			[
				'label' => esc_html__( 'Title Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'save_templates' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-content-box:hover .gyan-content-box-title' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'desc_hover_color',
			[
				'label' => esc_html__( 'Description Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'save_templates' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-content-box:hover .gyan-content-box-desc' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'hover_background',
				'label' => esc_html__( 'Background', 'gyan-elements' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .gyan-content-box:hover',
			]
		);
		$this->add_control(
			'box_hover_border',
			[
				'label' => esc_html__( 'Box Border Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-content-box:hover' => 'border-color: {{VALUE}}'
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_hover_shadow',
				'fields_options' => [
					'box_shadow_type' => [
						'default' =>'yes'
					],
					'box_shadow' => [
						'default' => [
							'horizontal' => '0',
							'vertical' => '10',
							'blur' => '10',
							'color' => 'rgba(0,0,0,0.1)'
						]
					]
				],
				'selector' => '{{WRAPPER}} .gyan-content-box:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'box_radius',
			[
				'label' => esc_html__( 'Radius', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '4',
					'right' => '4',
					'bottom' => '4',
					'left' => '4',
					'isLinked' => true,
				],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .gyan-content-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'box_padding',
			[
				'label' => esc_html__( 'Padding', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '30',
					'right' => '30',
					'bottom' => '30',
					'left' => '30',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-content-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .gyan-content-box' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
		// End Box Style
		// =====================


		// Start Icon Style
		// =====================
		$this->start_controls_section(
			'icon_style',
			[
				'label' => esc_html__( 'Icon', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'save_templates' => '',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Size', 'gyan-elements' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 200,
					],
				],
				'default'=> [
					'size' => '38',
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-content-box .gyan-content-box-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'icon_radius',
			[
				'label' => esc_html__( 'Radius', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .gyan-content-box .gyan-content-box-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'icon_padding',
			[
				'label' => esc_html__( 'Padding', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '15',
					'right' => '20',
					'bottom' => '15',
					'left' => '20',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-content-box .gyan-content-box-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
		// End Icon Style
		// =====================


		// Start Title Style
		// =====================
		$this->start_controls_section(
			'title_style',
			[
				'label' => esc_html__( 'Title', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'save_templates' => '',
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
							'size' => '24',
						],
					],
					'transform'   => [
						'default' => [
							'size' => 'uppercase',
						],
					],
				],
				'selector' => '{{WRAPPER}} .gyan-content-box .gyan-content-box-title',
			]
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_shadow',
				'selector' => '{{WRAPPER}} .gyan-content-box .gyan-content-box-title',
			]
		);
		$this->add_responsive_control(
			'title_margin',
			[
				'label' => esc_html__( 'Margin', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .gyan-content-box .gyan-content-box-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
		// End Title Style
		// =====================


		// Start Desc Style
		// =====================
		$this->start_controls_section(
			'desc_style',
			[
				'label' => esc_html__( 'Description', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'save_templates' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'desc_typography',
				'selector' => '{{WRAPPER}} .gyan-content-box .gyan-content-box-desc',
			]
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'desc_shadow',
				'selector' => '{{WRAPPER}} .gyan-content-box .gyan-content-box-desc',
			]
		);

		$this->end_controls_section();
		// End Desc Style
		// =====================


		// Start Ribbon Style
		// =====================
		$this->start_controls_section(
			'ribbon_style',
			[
				'label' => esc_html__( 'Ribbon', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'ribbon_title!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'ribbon_typography',
				'fields_options' => [
					'typography' => [
						'default' =>'custom',
					],
					'font_size'   => [
						'default' => [
							'size' => '16',
						],
					],
				],
				'selector' => '{{WRAPPER}} .gyan-ribbon-right, {{WRAPPER}} .gyan-ribbon-left',
			]
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'ribbon_shadow',
				'selector' => '{{WRAPPER}} .gyan-ribbon-right, {{WRAPPER}} .gyan-ribbon-left',
			]
		);
		$this->add_control(
			'ribbon_color',
			[
				'label' => esc_html__( 'Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#f8f8f8',
				'selectors' => [
					'{{WRAPPER}} .gyan-ribbon-right, {{WRAPPER}} .gyan-ribbon-left' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'ribbon_bg',
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
				'selector' => '{{WRAPPER}} .gyan-ribbon-right, {{WRAPPER}} .gyan-ribbon-left',
			]
		);

		$this->end_controls_section();
		// End Ribbon Style
		// =====================
	}


	protected function render() {
		$data = $this->get_settings_for_display();

		if ( 'gyan-content-box-move' == $data['effects'] ):
			?>
			<style type="text/css">
				[data-id="<?php echo $this->get_id(); ?>"] .gyan-content-box:hover{
					transform: translate(<?php echo esc_html( $data['translateX']['size'].'px' ); ?>, <?php echo esc_html( $data['translateY']['size'].'px' ); ?>);
				}
			</style>
		<?php endif; ?>

		<div class="gyan-content-box <?php echo esc_attr( $data['effects'] ); ?>" style="">
			<?php if ( $data['ribbon_title'] && $data['ribbon_position'] ): ?>
				<div class="<?php echo esc_attr( $data['ribbon_position'] ); ?>">
					<?php echo esc_html( $data['ribbon_title'] ); ?>
				</div>
			<?php endif; ?>

			<?php
				if ( 'yes' == $data['save_templates'] && $data['template'] ) :
					$frontend = new Frontend;
					echo $frontend->get_builder_content( $data['template'], true );
				else:
					?>
					<?php if ( $data['icon'] ): ?>
						<div class="gyan-content-box-icon gyan-icon gyan-ease-transition">
							<?php Icons_Manager::render_icon( $data['icon'], [ 'aria-hidden' => 'true' ] ); ?>
						</div>
					<?php endif; ?>

					<div class="gyan-content-box-content">
						<?php if ( $data['title'] ): ?>
							<?php printf( '<h3 class="gyan-content-box-title gyan-ease-transition">%1$s</h3>', $data['title'] ); ?>
						<?php endif; ?>

						<?php if ( $data['desc'] ): ?>
							<?php printf( '<div class="gyan-content-box-desc gyan-ease-transition">%1$s</div>', $data['desc'] ); ?>
						<?php endif; ?>
					</div>
			<?php endif; ?>
		</div><!-- .gyan-content-box -->
		<?php
	}

	protected function _content_template() {}

}