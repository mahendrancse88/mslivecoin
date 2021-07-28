<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Gyan_Menu_List extends Widget_Base {

	public function get_name()          { return 'gyan_menu_list'; }
	public function get_title()         { return esc_html__( 'Menu List', 'gyan-elements' ); }
	public function get_icon()          { return 'gyan-el-icon eicon-editor-list-ul'; }
	public function get_categories()    { return ['gyan-basic-addons']; }
	public function get_keywords()      { return [ 'gyan menu', 'gyan menu list','heading','navigation' ]; }
	public function get_style_depends() { return ['gyan-menu-list']; }

	protected function register_controls() {

		$this->start_controls_section(
			'menu_list_settings',
			[
				'label' => esc_html__( 'Menu List', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'menu_list_select',
			[
				'label' => esc_html__( 'Select Menu', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => gyan_wp_menu_names_list(),
			]
		);

		$this->add_control(
			'menu_list_style',
			[
				'label' => esc_html__( 'Display Style', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'vertical',
				'options'     => [
						'horizontal'   => esc_html__( 'Horizontal', 'gyan-elements' ),
						'vertical'  => esc_html__( 'Vertical', 'gyan-elements' )
					],
				'prefix_class' => 'gyan-menu-list-',
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'  => 'tab_link_typography',
                'label' => esc_html__( 'Typography', 'gyan-elements' ),
                'fields_options' => [
                    'typography' => [
                        'default' =>'custom',
                    ],
                    'font_size'   => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '17',
                        ],
                    ],
                    'line_height'   => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '30',
                        ],
                    ],
                    'font_weight' => [
                        'default' => '700',
                    ],
                ],
                'selector' => '{{WRAPPER}} ul.gyan-menu-list-item li a',
            ]
        );

		$this->add_control(
			'tab_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ul.gyan-menu-list-item li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tab_padding',
			[
				'label'      => esc_html__( 'Padding', 'gyan-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ul.gyan-menu-list-item li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tab_margin',
			[
				'label'       => esc_html__( 'Margin', 'gyan-elements' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => [ 'px', '%' ],
				'placeholder' => [
					'top'    => '',
					'right'  => '',
					'bottom' => '',
					'left'   => '',
				],
				'selectors'   => [
					'{{WRAPPER}} ul.gyan-menu-list-item li' => 'margin-top: {{TOP}}{{UNIT}}; margin-left: {{LEFT}}{{UNIT}}; margin-right: {{RIGHT}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
				],
			]
		);

		// on - hover

		$this->start_controls_tabs( 'tabs_style' );

        $this->start_controls_tab(
            'tab_normal_styling',
            [
                'label' => esc_html__( 'Normal', 'gyan-elements' ),
            ]
        );

		$this->add_control(
			'tab_text',
			[
				'label'     => esc_html__( 'Tab Text Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#032e42',
				'selectors' => [
					'{{WRAPPER}} ul.gyan-menu-list-item li a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
		    Group_Control_Background::get_type(),
		    [
		        'name' => 'tabs_bg',
		        'label' => esc_html__( 'Tabs Background', 'gyan-elements' ),
		        'types' => [ 'classic', 'gradient' ],
				'fields_options' => [
					'background' => [
						'default' =>'classic',
					],
					'color' => [
						'default' => '#ffffff',
					],
				],
		        'selector' => '{{WRAPPER}} ul.gyan-menu-list-item li a',
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'table_icon_border',
		        'fields_options' => [
		            'border' => [
		                'default' => 'solid',
		            ],
		            'color' => [
		                'default' => '#e6e6e6',
		            ],
		            'width' => [
		                'default' => [
		                    'top' => '2',
		                    'right' => '2',
		                    'bottom' => '2',
		                    'left' => '2',
		                    'isLinked' => true,
		                ]
		            ],
		        ],
		        'selector' => '{{WRAPPER}} ul.gyan-menu-list-item li a',
		    ]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'tabs_shadow',
				'selector' => '{{WRAPPER}} ul.gyan-menu-list-item li a',
			]
		);


		//hover

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_hover',
            [
                'label' => esc_html__( 'Hover', 'gyan-elements' ),
            ]
        );

		$this->add_control(
			'tab_text_hover',
			[
				'label'     => esc_html__( 'Tab Text Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} ul.gyan-menu-list-item li:hover a,
					{{WRAPPER}} ul.gyan-menu-list-item li.swm-m-active a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
		    Group_Control_Background::get_type(),
		    [
		        'name' => 'tabs_bg_hover',
		        'label' => esc_html__( 'Tabs Background', 'gyan-elements' ),
		        'types' => [ 'classic', 'gradient' ],
				'fields_options' => [
					'background' => [
						'default' =>'classic',
					],
					'color' => [
						'default' => '#d83030',
					],
				],
		        'selector' => '{{WRAPPER}} ul.gyan-menu-list-item li:hover a,
		        {{WRAPPER}} ul.gyan-menu-list-item li.swm-m-active a',
		    ]
		);

		$this->add_control(
			'tab_hover_border',
			[
				'label'     => esc_html__( 'Tabs Border Color', 'gyan-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#d83030',
				'selectors' => [
					'{{WRAPPER}} ul.gyan-menu-list-item li:hover a,
					{{WRAPPER}} ul.gyan-menu-list-item li.swm-m-active a' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'tabs_shadow_hover',
				'selector' => '{{WRAPPER}} ul.gyan-menu-list-item li:hover a,
				{{WRAPPER}} ul.gyan-menu-list-item li.swm-m-active a',
			]
		);

		$this->end_controls_tab();


		$this->end_controls_section();

	}


	protected function render() {

		$settings = $this->get_settings_for_display();

		$menu_list_items = $settings['menu_list_select'];

		if ( $menu_list_items != '' ) {

		    echo '<div class="gyan-menu-list">';

		    $nav_menu = ! empty( $settings['menu_list_select'] ) ? wp_get_nav_menu_object( $settings['menu_list_select'] ) : false;
		    if ( ! $nav_menu ) {
		        return;
		    }

		    $nav_menu_args = array(
				'fallback_cb' => '',
				'menu_class'  => 'gyan-menu-list-item gyan-ease-transition',
				'menu'        => $nav_menu,
				'depth'       => 1,
				'echo'        => false,
		    );

		    echo wp_nav_menu( $nav_menu_args );
		    echo '</div>';

		}

	}

	protected function _content_template() {}

}