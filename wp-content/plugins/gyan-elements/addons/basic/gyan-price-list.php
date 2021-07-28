<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Gyan_Price_List extends Widget_Base {

	public function get_name()           { return 'gyan_price_list'; }
	public function get_title()          { return esc_html__( 'Price List', 'gyan-elements' ); }
	public function get_icon()           { return 'gyan-el-icon eicon-price-list'; }
	public function get_categories()     { return ['gyan-basic-addons']; }
	public function get_keywords()       { return [ 'gyan price list', 'price', 'lsit', 'rate', 'cost', 'value' ]; }
	public function get_style_depends()  { return ['gyan-grid','gyan-flex','gyan-price-list']; }

	protected function register_controls() {
		$this->start_controls_section(
			'section_content_list',
			[
				'label' => esc_html__( 'List', 'gyan-elements' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
		    'price',
		    [
				'label'   => esc_html__( 'Price', 'gyan-elements' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [ 'active' => true ],
		    ]
		);

		$repeater->add_control(
		    'title',
		    [
				'label'       => esc_html__( 'Title', 'gyan-elements' ),
				'default'     => esc_html__( 'List Item Title Text', 'gyan-elements' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => 'true',
				'dynamic'     => [ 'active' => true ],
		    ]
		);

		$repeater->add_control(
		    'item_description',
		    [
				'label'   => esc_html__( 'Description', 'gyan-elements' ),
				'type'    => Controls_Manager::TEXTAREA,
				'dynamic' => [ 'active' => true ],
		    ]
		);

		$repeater->add_control(
		    'image',
		    [
				'label'   => esc_html__( 'Image', 'gyan-elements' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [],
				'dynamic' => [ 'active' => true ],
		    ]
		);

		$repeater->add_control(
		    'link',
		    [
				'label'   => esc_html__( 'Link', 'gyan-elements' ),
				'type'    => Controls_Manager::URL,
				'default' => [ 'url' => '#' ],
				'dynamic' => [ 'active' => true ],
		    ]
		);

		$this->add_control(
			'price_list',
			[
				'label'  => esc_html__( 'List Items', 'gyan-elements' ),
				'type'   => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title' => esc_html__( 'List Item One Title Text', 'gyan-elements' ),
						'price' => '$20',
						'link'  => [ 'url' => '#' ],
					],
					[
						'title' => esc_html__( 'List Item Two Title Text', 'gyan-elements' ),
						'price' => '$9',
						'link'  => [ 'url' => '#' ],
					],
					[
						'title' => esc_html__( 'List Item Three Title Text', 'gyan-elements' ),
						'price' => '$32',
						'link'  => [ 'url' => '#' ],
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);
		$this->end_controls_section();

        $this->start_controls_section(
            'section_style_item_style',
            [
                'label'      => esc_html__( 'Item Style', 'gyan-elements' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            ]
        );

        $this->add_control(
            'row_gap',
            [
                'label' => esc_html__( 'Rows Gap', 'gyan-elements' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                    'em' => [
                        'max' => 5,
                        'step' => 0.1,
                    ],
                ],
                'size_units' => [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-price-list li:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'vertical_align',
            [
                'label'       => esc_html__( 'Vertical Align', 'gyan-elements' ),
                'type'        => Controls_Manager::SELECT,
                'description' => 'When you will take image then you understand its function',
                'options'     => [
                    'middle' => esc_html__( 'Middle', 'gyan-elements' ),
                    'top'    => esc_html__( 'Top', 'gyan-elements' ),
                    'bottom' => esc_html__( 'Bottom', 'gyan-elements' ),
                ],
                'default' => 'middle',
                'separator' => 'after',
            ]
        );


        $this->add_control(
            'heading__title',
            [
                'label' => esc_html__( 'Title', 'gyan-elements' ),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label'     => esc_html__( 'Color', 'gyan-elements' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#032e42',
                'selectors' => [
                    '{{WRAPPER}} .gyan-price-list .gyan-price-list-price' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .gyan-price-list .gyan-price-list-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'heading_typography',
                'label'    => esc_html__( 'Typography', 'gyan-elements' ),
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .gyan-price-list-header',
            ]
        );

        $this->add_control(
            'heading_item_description',
            [
                'label'     => esc_html__( 'Description', 'gyan-elements' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label'     => esc_html__( 'Color', 'gyan-elements' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gyan-price-list-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'description_typography',
                'label'    => esc_html__( 'Typography', 'gyan-elements' ),
                'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .gyan-price-list-description',
            ]
        );

        $this->add_control(
            'heading_separator',
            [
                'label'     => esc_html__( 'Separator', 'gyan-elements' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'separator_style',
            [
                'label'   => esc_html__( 'Style', 'gyan-elements' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'solid'  => esc_html__( 'Solid', 'gyan-elements' ),
                    'dotted' => esc_html__( 'Dotted', 'gyan-elements' ),
                    'dashed' => esc_html__( 'Dashed', 'gyan-elements' ),
                    'double' => esc_html__( 'Double', 'gyan-elements' ),
                    'none'   => esc_html__( 'None', 'gyan-elements' ),
                ],
                'default'   => 'dashed',
                'selectors' => [
                    '{{WRAPPER}} .gyan-price-list-separator' => 'border-bottom-style: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'separator_weight',
            [
                'label' => esc_html__( 'Weight', 'gyan-elements' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 10,
                    ],
                ],
                'condition' => [
                    'separator_style!' => 'none',
                ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-price-list-separator' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
                ],
                'default' => [
                    'size' => 1,
                ],
            ]
        );

        $this->add_control(
            'separator_color',
            [
                'label'     => esc_html__( 'Color', 'gyan-elements' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gyan-price-list-separator' => 'border-bottom-color: {{VALUE}};',
                ],
                'condition' => [
                    'separator_style!' => 'none',
                ],
            ]
        );

        $this->add_control(
            'separator_spacing',
            [
                'label' => esc_html__( 'Spacing', 'gyan-elements' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 40,
                    ],
                ],
                'condition' => [
                    'separator_style!' => 'none',
                ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-price-list-separator' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

		$this->start_controls_section(
			'section_style_image_style',
			[
				'label'      => esc_html__( 'Image Style', 'gyan-elements' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_control(
			'image_size',
			[
				'label' => esc_html__( 'Image Size', 'gyan-elements' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 250,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-price-list-image' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
				],
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gyan-price-list-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'image_spacing',
			[
				'label' => esc_html__( 'Spacing', 'gyan-elements' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'body.rtl {{WRAPPER}} .gyan-price-list-image'                               => 'padding-left: calc({{SIZE}}{{UNIT}}/2);',
					'body.rtl {{WRAPPER}} .gyan-price-list-image + .gyan-price-list-text'       => 'padding-right: calc({{SIZE}}{{UNIT}}/2);',
					'body:not(.rtl) {{WRAPPER}} .gyan-price-list-image'                         => 'padding-right: calc({{SIZE}}{{UNIT}}/2);',
					'body:not(.rtl) {{WRAPPER}} .gyan-price-list-image + .gyan-price-list-text' => 'padding-left: calc({{SIZE}}{{UNIT}}/2);',
				],
				'default' => [
					'size' => 20,
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_price',
			[
				'label'      => esc_html__( 'Price', 'gyan-elements' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_control(
			'price_color',
			[
				'label'     => esc_html__( 'Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .gyan-price-list .gyan-price-list-price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'price_hover_color',
			[
				'label'     => esc_html__( 'Hover Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gyan-price-list li:hover .gyan-price-list-price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'price_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#d83030',
				'selectors' => [
					'{{WRAPPER}} .gyan-price-list .gyan-price-list-price' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'border',
				'label'       => esc_html__( 'Border', 'gyan-elements' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .gyan-price-list .gyan-price-list-price',
			]
		);

		$this->add_control(
			'price_border_radius',
			[
				'label'   => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 50,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-price-list .gyan-price-list-price' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'price_width',
			[
				'label'   => esc_html__( 'Width', 'gyan-elements' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 50,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-price-list .gyan-price-list-price' => 'width: {{SIZE}}{{UNIT}}; text-align: center;',
				],
			]
		);

		$this->add_control(
			'price_height',
			[
				'label' => esc_html__( 'Height', 'gyan-elements' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-price-list .gyan-price-list-price' => 'height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}}; vertical-align: middle;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'price_box_shadow',
				'selector' => '{{WRAPPER}} .gyan-price-list .gyan-price-list-price',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'price_typography',
				'label'    => esc_html__( 'Typography', 'gyan-elements' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .gyan-price-list .gyan-price-list-price',
			]
		);

		$this->end_controls_section();
	}

	private function render_image( $item, $settings ) {
		$imageTagHtml = wp_get_attachment_image( $item['image']['id'], 'full',"", ["alt" => $item['title']]);
		return $imageTagHtml;
	}

	private function render_item_header( $item ) {
		$settings      = $this->get_settings_for_display();
		$url           = $item['link']['url'];
		$item_id       = $item['_id'];
		$gyan_has_image = $item['image']['url'] ? 'gyan-has-image ' : '';

        if ( $url ) {
            $unique_link_id = 'item-link-' . $item_id;

            $this->add_render_attribute( $unique_link_id, 'class', 'gyan-grid gyan-flex-'. esc_attr($settings['vertical_align']) );
            $this->add_render_attribute( $unique_link_id, 'class', esc_attr($gyan_has_image) );


            $target = $item['link']['is_external'] ? '_blank' : '_self';

            $this->add_render_attribute( $unique_link_id, 'onclick', "window.open('" . $url . "', '$target')" );

			return '<li class="gyan-price-list-item"><div ' . $this->get_render_attribute_string( $unique_link_id ) . 'gyan-grid>';
		} else {
			return '<li class="gyan-price-list-item gyan-grid gyan-grid-small '.esc_attr($gyan_has_image).'gyan-flex-'. esc_attr($settings['vertical_align']) .'" gyan-grid>';
		}
	}

	private function render_item_footer( $item ) {
		if ( $item['link']['url'] ) {
			return '</div></li>';
		} else {
			return '</li>';
		}
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		?>
		<ul class="gyan-price-list">

		<?php foreach ( $settings['price_list'] as $item ) :
			echo $this->render_item_header( $item );

			if ( ! empty( $item['image']['url'] ) ) : ?>
				<div class="gyan-price-list-image">
					<?php echo $this->render_image( $item, $settings ); ?>
				</div>
			<?php endif; ?>

			<div class="gyan-price-list-text">
				<div>
					<div class="gyan-price-list-header gyan-grid gyan-grid-small gyan-flex-middle" gyan-grid>
						<span class="gyan-price-list-title"><?php echo esc_html($item['title']); ?></span>

						<?php if ( 'none' != $settings['separator_style'] ) : ?>
							<span class="gyan-price-list-separator"></span>
						<?php endif; ?>

					</div>

                    <?php if ( $item['item_description'] ) : ?>
                        <p class="gyan-price-list-description"><?php echo $this->parse_text_editor($item['item_description']); ?></p>
                    <?php endif; ?>
				</div>
			</div>
			<div class="gyan-flex-inline">
				<span class="gyan-price-list-price"><?php echo esc_html($item['price']); ?></span>
			</div>

			<?php echo $this->render_item_footer( $item ); ?>

		<?php endforeach; ?>

		</ul>
		<?php
	}

	protected function _content_template() {}
}