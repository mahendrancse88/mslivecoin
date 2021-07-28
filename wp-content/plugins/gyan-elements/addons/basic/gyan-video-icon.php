<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Control_Media;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Gyan_Video_Icon extends Widget_Base {

	public function get_name()           { return 'gyan_video_icon'; }
	public function get_title()          { return esc_html__( 'Video Icon', 'gyan-elements' ); }
	public function get_icon()           { return 'gyan-el-icon eicon-play'; }
	public function get_categories()     { return ['gyan-basic-addons']; }
	public function get_keywords()       { return ['video', 'youtube', 'vimeo','icon']; }
    public function get_style_depends()  { return ['gyan-icon','gyan-flex','gyan-position','magnific-popup','gyan-video-icon']; }
	public function get_script_depends() { return ['gyan-widgets','magnific-popup' ]; }

	protected function register_controls() {

		$this->start_controls_section(
			'section_video',
			[
				'label' => esc_html__( 'Video Icon', 'gyan-elements' ),
			]
		);

			$this->add_control(
			    'video_url',
			    [
			        'label' => esc_html__('YouTube/Vimeo Video URL', 'gyan-elements'),
			        'type' => Controls_Manager::TEXT,
			        'default' => 'https://www.youtube.com/watch?v=5DDwj97-h3c',
			        'label_block' => true,
			    ]
			);

			$this->add_control(
				'video_icon_type',
	            [
					'label'       => esc_html__( 'Icon Type', 'gyan-elements' ),
	                'type'        => Controls_Manager::CHOOSE,
	                'label_block' => false,
	                'options'     => [
	                    'icon' => [
	                        'title' => esc_html__( 'Icon', 'gyan-elements' ),
	                        'icon'  => 'fa fa-star',
	                    ],
	                    'image' => [
	                        'title' => esc_html__( 'Image', 'gyan-elements' ),
	                        'icon'  => 'fa fa-picture-o',
	                    ],
	                ],
	                'default'       => 'icon',
				]
			);

			$this->add_control(
			    'video_play_icon',
			    [
					'label' => esc_html__( 'Play Icon', 'gyan-elements' ),
					'type'  => Controls_Manager::ICONS,
			        'default' => [
			            'value' => 'fas fa-play',
			            'library' => 'fa-solid',
			        ],
			        'condition'     => [
                    'video_icon_type' => 'icon',
                ],
			    ]
			);

			$this->add_control(
				'video_play_icon_image',
	            [
					'label'       => esc_html__( 'Image', 'gyan-elements' ),
					'label_block' => true,
					'type'        => Controls_Manager::MEDIA,
	                'dynamic'     => [
	                    'active'  => true,
	                ],
			        'default'     => [
	                    'url' => Utils::get_placeholder_image_src(),
	                 ],
			        'condition'   => [
	                    'video_icon_type' => 'image',
	                ],
				]
			);

			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'                  => 'icon_image_size',
	                'label'                 => esc_html__( 'Icon Image Size', 'gyan-elements' ),
	                'default'               => 'full',
				]
			);

			$this->add_control(
				'pulse_animation',
				[
					'label' => esc_html__( 'Pulse Animation', 'gyan-elements' ),
					'type' => Controls_Manager::SWITCHER,
					'default' => 'yes',
				]
			);

			$this->add_control(
				'title',
				[
					'label' => esc_html__( 'Title', 'gyan-elements' ),
					'label_block' => true,
					'type' => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'Enter Title', 'gyan-elements' ),
					'default' => 'Sample Title Text',
					'separator' => 'before',
				]
			);

			$this->add_control(
	            'image',
	            [
					'label' => esc_html__( 'Image', 'gyan-elements' ),
					'type'  => Controls_Manager::MEDIA,
					'separator' => 'before',
	                'default'   => [
	                    'url' => GYAN_PLUGIN_URL .'addons/images/portfolio1.jpg',
	                ],
	            ]
	        );

	        $this->add_group_control(
	            Group_Control_Image_Size::get_type(),
	            [
					'name'    => 'image_size',
					'label'   => esc_html__( 'Image Size', 'gyan-elements' ),
					'default' => 'full',
	            ]
	        );

		$this->end_controls_section();

		$this->start_controls_section(
		    'icon_styling',
		    [
		        'label' => esc_html__( 'Icon', 'gyan-elements' ),
		        'tab' => Controls_Manager::TAB_STYLE,
		    ]
		);

			$this->add_control(
			    'video_origin',
			    [
			        'label'   => esc_html__( 'Video Icon Position', 'gyan-elements' ),
			        'type'    => Controls_Manager::SELECT,
			        'default' => 'center',
			        'options' => gyan_position(),
			    ]
			);

			$this->add_responsive_control(
			    'video_icons_size',
			    [
			        'label' => esc_html__( 'Icon Size', 'gyan-elements' ),
			        'type' => Controls_Manager::SLIDER,
			        'size_units' => [ 'px', 'em', '%' ],
			        'range' => [
			            'px' => [
			                'min'  => 1,
			                'max'  => 500,
			            ],
			        ],
			        'default' => [
			            'size' => '20',
			        ],
			        'selectors' => [
			            '{{WRAPPER}} .gyan-video-icon-element i,{{WRAPPER}} .gyan-video-icon-element svg' => 'font-size: {{SIZE}}{{UNIT}};',
			        ],
			    ]
			);

			$this->add_responsive_control(
			    'video_width',
			    [
			        'label' => esc_html__( 'Icon Box Width', 'gyan-elements' ),
			        'type'  => Controls_Manager::SLIDER,
			        'size_units' => [ 'px', 'em', '%' ],
			        'range' => [
			            'px' => [
			                'min'  => 1,
			                'max'  => 500,
			            ],
			        ],
			        'default'    => [
			                'size' => 60,
			                'unit' => 'px',
			            ],
			        'selectors' => [
			            '{{WRAPPER}} .gyan-video-icon-element,{{WRAPPER}} a.gyan-video-icon-element:before' => 'width: {{SIZE}}{{UNIT}};',
			        ],
			    ]
			);

			$this->add_responsive_control(
			    'video_height',
			    [
			        'label' => esc_html__( 'Icon Box Height', 'gyan-elements' ),
			        'type'  => Controls_Manager::SLIDER,
			        'size_units' => [ 'px', 'em', '%' ],
			        'range' => [
			            'px' => [
			                'min'  => 1,
			                'max'  => 500,
			            ],
			        ],
			        'default'    => [
			                'size' => 60,
			                'unit' => 'px',
			            ],
			        'selectors' => [
			            '{{WRAPPER}} .gyan-video-icon-element,{{WRAPPER}} a.gyan-video-icon-element:before' => 'height: {{SIZE}}{{UNIT}};',
			            '{{WRAPPER}} .gyan-video-icon-element i' => 'line-height: {{SIZE}}{{UNIT}};',
			            '{{WRAPPER}} .gyan-video-icon-element svg' => 'height: {{SIZE}}{{UNIT}};',
			        ],
			    ]
			);

			$this->add_control(
			    'video_border_radius',
			    [
					'label'      => esc_html__( 'Border Radius', 'gyan-elements' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'default'    => [
						'top'    => '100',
						'bottom' => '100',
						'left'   => '100',
						'right'  => '100',
						'unit'   => '%',
					],
					'selectors'  => [
			            '{{WRAPPER}} .gyan-video-icon-element' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			        ],
			    ]
			);

			$this->add_responsive_control(
			    'video_margin',
			    [
			        'label' => esc_html__( 'Video Margin', 'gyan-elements' ),
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
			            '{{WRAPPER}} .gyan-video-icon-element' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			        ],
			    ]
			);

			$this->start_controls_tabs( 'video_style' );

				$this->start_controls_tab(
				    'tab_video_normal',
				    [
				        'label' => esc_html__( 'Normal', 'gyan-elements' ),
				    ]
				);

					$this->add_control(
					    'video_color',
					    [
					        'label' => esc_html__( 'Icon Color', 'gyan-elements' ),
					        'type' => Controls_Manager::COLOR,
					        'default' => '#464db1',
					        'selectors' => [
					            '{{WRAPPER}} a.gyan-video-icon-element i' => 'color: {{VALUE}};',
					            '{{WRAPPER}} a.gyan-video-icon-element svg' => 'fill: {{VALUE}};',
					        ],
					    ]
					);

					$this->add_group_control(
					    Group_Control_Background::get_type(),
					    [
					        'name' => 'video_background',
					        'label' => esc_html__( 'Background', 'gyan-elements' ),
					        'types' => [ 'classic', 'gradient' ],
					        'fields_options' => [
					        	'background' => [
					        		'default' =>'classic',
					        	],
					        	'color' => [
					        		'default' => '#ffffff',
					        	],
					        ],
					        'selector' => '{{WRAPPER}} .gyan-video-icon-element',
					    ]
					);

					$this->add_group_control(
					    Group_Control_Border::get_type(),
					    [
					        'name' => 'video_border',
					        'selector' => '{{WRAPPER}} .gyan-video-icon-element',
					    ]
					);

					$this->add_control(
					    'pulse_animation_bg',
					    [
					        'label' => esc_html__( 'Pulse Animation Color', 'gyan-elements' ),
					        'type' => Controls_Manager::COLOR,
					        'default' => '#ffffff',
					        'condition' => [
								'pulse_animation' => 'yes',
							],
					        'selectors' => [
					            '{{WRAPPER}} a.gyan-video-icon-element:before' => 'background: {{VALUE}};',
					        ],
					    ]
					);

					$this->add_group_control(
					    Group_Control_Box_Shadow::get_type(),
					    [
							'name'     => 'video_box_shadow',
							'label' => esc_html__( 'Icon Box - Box Shadow', 'gyan-elements' ),
							'selector' => '{{WRAPPER}} .gyan-video-icon-element',
					    ]
					);

					$this->end_controls_tab();

					$this->start_controls_tab(
					    'tab_video_hover',
					    [
					        'label' => esc_html__( 'Hover', 'gyan-elements' ),
					    ]
					);

					$this->add_control(
					    'video_hover_color',
					    [
					        'label' => esc_html__( 'Icon Color', 'gyan-elements' ),
					        'type' => Controls_Manager::COLOR,
					        'selectors' => [
					            '{{WRAPPER}} .gyan-video-icon-element:hover i' => 'color: {{VALUE}};',
					            '{{WRAPPER}} .gyan-video-icon-element:hover svg' => 'fill: {{VALUE}};',
					        ],
					    ]
					);

					 $this->add_group_control(
					    Group_Control_Background::get_type(),
					    [
					        'name' => 'video_hover_background',
					        'label' => esc_html__( 'Background', 'gyan-elements' ),
					        'types' => [ 'classic', 'gradient' ],
					        'selector' => '{{WRAPPER}} .gyan-video-icon-element:hover'
					    ]
					);

					 $this->add_control(
					     'border_color_hover',
					     [
					         'label' => esc_html__( 'Border Color Color', 'gyan-elements' ),
					         'type' => Controls_Manager::COLOR,
					         'selectors' => [
					             '{{WRAPPER}} gyan-video-icon-element:hover' => 'border-color: {{VALUE}};',
					         ],
					     ]
					 );

					 $this->add_control(
					    'pulse_animation_bg_hover',
					    [
					        'label' => esc_html__( 'Pulse Animation Color', 'gyan-elements' ),
					        'type' => Controls_Manager::COLOR,
					        'condition' => [
								'pulse_animation' => 'yes',
							],
					        'selectors' => [
					            '{{WRAPPER}} a.gyan-video-icon-element:hover:before' => 'background: {{VALUE}};',
					        ],
					    ]
					);

					 $this->add_group_control(
					    Group_Control_Box_Shadow::get_type(),
					    [
							'name'     => 'video_hover_box_shadow',
							'label' => esc_html__( 'Icon Box - Box Shadow', 'gyan-elements' ),
							'selector' => '{{WRAPPER}} .gyan-video-icon-element:hover',
					    ]
					);

				$this->end_controls_tab();
			$this->end_controls_tabs();
		$this->end_controls_section();

			$this->start_controls_section(
			    'title_styling',
			    [
			        'label' => esc_html__( 'Title', 'gyan-elements' ),
			        'tab' => Controls_Manager::TAB_STYLE,
			    ]
			);

				$this->add_control(
					'title_position',
					[
						'label'   => esc_html__( 'Title Text Position', 'gyan-elements' ),
						'type'    => Controls_Manager::SELECT,
						'options' => [
							'after'   => esc_html__( 'After Icon', 'gyan-elements' ),
							'before'   => esc_html__( 'Before Icon', 'gyan-elements' ),
							'above'   => esc_html__( 'Above Icon', 'gyan-elements' ),
							'below'   => esc_html__( 'Below Icon', 'gyan-elements' ),
						],
						'default' => 'below',
					]
				);

				$this->add_control(
					'title_tag',
					[
						'label' => esc_html__( 'Select Tag', 'gyan-elements' ),
						'type' => Controls_Manager::SELECT,
						'options' => [
							'h1' => 'H1',
							'h2' => 'H2',
							'h3' => 'H3',
							'h4' => 'H4',
							'h5' => 'H5',
							'h6' => 'H6',
							'div' => 'div',
						],
						'default' => 'h3',
					]
				);

				$this->add_control(
					'title_color',
					[
						'label' => esc_html__( 'Text Color', 'gyan-elements' ),
						'type' => Controls_Manager::COLOR,
						'default' => '#ffffff',
						'selectors' => [
							'{{WRAPPER}} .gyan-video-icon-title' => 'color: {{VALUE}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'name' => 'title_typography',
						'selector' => '{{WRAPPER}} .gyan-video-icon-title',
					]
				);
				$this->add_group_control(
					Group_Control_Text_Shadow::get_type(),
					[
						'name' => 'title_shadow',
						'selector' => '{{WRAPPER}} .gyan-video-icon-title',
					]
				);

				$this->add_responsive_control(
				    'title_margin',
				    [
				        'label' => esc_html__( 'Title Margin', 'gyan-elements' ),
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
				            '{{WRAPPER}} .gyan-video-icon-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				        ],
				    ]
				);

			$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<div class="gyan-video-icon-holder">
			<div class="gyan-position-<?php echo $settings['video_origin']; ?> gyan-vi-pulse-<?php echo $settings['pulse_animation']; ?> gyan-flex gyan-vi-title-<?php echo $settings['title_position']; ?>">
				<div>
					<a class="gyan-video-icon-element gyan-icon gyan-video-lightbox gyan-ease-transition" href="<?php echo esc_url($settings['video_url']); ?>" ><?php

					if ( $settings['video_icon_type'] == 'icon' || $settings['video_icon_type'] == 'image' ) :

                        if ( $settings['video_icon_type'] == 'icon' ) {

                        	Icons_Manager::render_icon( $settings['video_play_icon'], [ 'aria-hidden' => 'true' ] );

                        } else {

		                     // responsive image
		                     if (  $settings['icon_image_size_size'] == 'full' ) {
		                         $imageTagHtml = wp_get_attachment_image( $settings['video_play_icon_image']['id'], 'full');
		                     } else {
		                         $imgUrl = Group_Control_Image_Size::get_attachment_image_src( $settings['video_play_icon_image']['id'], 'icon_image_size', $settings );
		                         if ( ! $imgUrl ) {
		                             $imgUrl = $item['video_play_icon_image']['url'];
		                         }
		                         $imageTagHtml = '<img src="'.esc_url($imgUrl).'" alt="" />';
		                     }

        							echo $imageTagHtml;

                        }

					endif;

					?>
					</a>
				</div>
				<?php if ( $settings['title'] ): ?>
					<?php printf( '<div><%1$s class="gyan-video-icon-title">%2$s</%1$s></div>', $settings['title_tag'], $settings['title'] ); ?>
				<?php endif; ?>
			</div>
			<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'image_size', 'image' ); ?>
		</div>
		<?php
	}

	protected function _content_template() {}

}