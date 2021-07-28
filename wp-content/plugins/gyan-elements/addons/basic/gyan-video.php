<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Modules\DynamicTags\Module as TagsModule;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Control_Media;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Gyan_Video extends Widget_Base {

	public function get_name()           { return 'gyan_video'; }
	public function get_title()          { return esc_html__( 'video', 'gyan-elements' ); }
	public function get_icon()           { return 'gyan-el-icon eicon-youtube'; }
	public function get_categories()     { return ['gyan-basic-addons']; }
	public function get_keywords()       { return ['video', 'youtube', 'vimeo']; }
	public function get_style_depends()  { return ['gyan-icon','gyan-video']; }
	public function get_script_depends() { return ['gyan-video-subscribe', 'gyan-widgets' ]; }

	protected function register_controls() {
		$this->register_video_content();
		$this->register_overlay_content();
		$this->register_video_icon_style();
		$this->register_video_subscribe_bar();
	}

	protected function register_video_content() {

		$this->start_controls_section(
			'section_video',
			[
				'label' => esc_html__( 'Video', 'gyan-elements' ),
			]
		);

			$this->add_control(
				'video_type',
				[
					'label'   => esc_html__( 'Video Type', 'gyan-elements' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'youtube',
					'options' => [
						'youtube' => esc_html__( 'YouTube', 'gyan-elements' ),
						'vimeo'   => esc_html__( 'Vimeo', 'gyan-elements' ),
					],
				]
			);

			$default_youtube = apply_filters( 'gyan_video_default_youtube_link', 'https://www.youtube.com/watch?v=1MMPlZuvEPs' );

			$default_vimeo = apply_filters( 'gyan_video_default_vimeo_link', 'https://vimeo.com/13017242' );

			$this->add_control(
				'youtube_link',
				[
					'label'       => esc_html__( 'Link', 'gyan-elements' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active'     => true,
						'categories' => [
							TagsModule::POST_META_CATEGORY,
							TagsModule::URL_CATEGORY,
						],
					],
					'default'     => $default_youtube,
					'label_block' => true,
					'condition'   => [
						'video_type' => 'youtube',
					],
				]
			);
			$this->add_control(
				'youtube_link_doc',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf( __( '<b>Note:</b>Please add standard URL of YouTube video. Share URL will not work. Below are valid and invalid URL examples.</br></br><b>Valid:</b>&nbsp;https://www.youtube.com/watch?v=1MMPlZuvEPs</br><b>Invalid:</b>&nbsp;https://youtu.be/1MMPlZuvEPs', 'gyan-elements' ) ),
					'content_classes' => 'gyan-editor-doc',
					'condition'       => [
						'video_type' => 'youtube',
					],
					'separator'       => 'none',
				]
			);

			$this->add_control(
				'vimeo_link',
				[
					'label'       => esc_html__( 'Link', 'gyan-elements' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active'     => true,
						'categories' => [
							TagsModule::POST_META_CATEGORY,
							TagsModule::URL_CATEGORY,
						],
					],
					'default'     => $default_vimeo,
					'label_block' => true,
					'condition'   => [
						'video_type' => 'vimeo',
					],
				]
			);
			$this->add_control(
				'vimeo_link_doc',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf( __( '<b>Note:</b> Make sure you add the actual URL of the video and not the categorized URL.</br></br><b>Valid:</b>&nbsp;https://vimeo.com/13017242</br><b>Invalid:</b>&nbsp;https://vimeo.com/channels/staffpicks/13017242', 'gyan-elements' ) ),
					'content_classes' => 'gyan-editor-doc',
					'condition'       => [
						'video_type' => 'vimeo',
					],
					'separator'       => 'none',
				]
			);

			$this->add_control(
				'start',
				[
					'label'       => esc_html__( 'Video Start Time', 'gyan-elements' ),
					'type'        => Controls_Manager::NUMBER,
					'description' => esc_html__( 'Specify a start time (in seconds)', 'gyan-elements' ),
					'condition'   => [
						'video_type' => [ 'youtube', 'vimeo' ],
					],
				]
			);

			$this->add_control(
				'end',
				[
					'label'       => esc_html__( 'Video End Time', 'gyan-elements' ),
					'type'        => Controls_Manager::NUMBER,
					'description' => esc_html__( 'Specify an end time (in seconds)', 'gyan-elements' ),
					'condition'   => [
						'video_type' => 'youtube',
					],
				]
			);

			$this->add_control(
				'aspect_ratio',
				[
					'label'        => esc_html__( 'Aspect Ratio', 'gyan-elements' ),
					'type'         => Controls_Manager::SELECT,
					'options'      => [
						'16_9' => '16:9',
						'4_3'  => '4:3',
						'3_2'  => '3:2',
					],
					'default'      => '16_9',
					'prefix_class' => 'gyan-aspect-ratio-',
				]
			);

			$this->add_control(
				'heading_youtube',
				[
					'label'     => esc_html__( 'Video Options', 'gyan-elements' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			// YouTube.
			$this->add_control(
				'yt_autoplay',
				[
					'label'     => esc_html__( 'Autoplay', 'gyan-elements' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => [
						'video_type' => 'youtube',
					],
				]
			);

			$this->add_control(
				'yt_rel',
				[
					'label'     => esc_html__( 'Related Videos From', 'gyan-elements' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'no',
					'options'   => [
						'no'  => esc_html__( 'Current Video Channel', 'gyan-elements' ),
						'yes' => esc_html__( 'Any Random Video', 'gyan-elements' ),
					],
					'condition' => [
						'video_type' => 'youtube',
					],
				]
			);

			$this->add_control(
				'yt_controls',
				[
					'label'     => esc_html__( 'Player Control', 'gyan-elements' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_off' => esc_html__( 'Hide', 'gyan-elements' ),
					'label_on'  => esc_html__( 'Show', 'gyan-elements' ),
					'default'   => 'yes',
					'condition' => [
						'video_type' => 'youtube',
					],
				]
			);

			$this->add_control(
				'yt_mute',
				[
					'label'     => esc_html__( 'Mute', 'gyan-elements' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => [
						'video_type' => 'youtube',
					],
				]
			);

			$this->add_control(
				'yt_modestbranding',
				[
					'label'       => esc_html__( 'Modest Branding', 'gyan-elements' ),
					'description' => esc_html__( 'Turn on to hide YouTube logo from YouTube video player.', 'gyan-elements' ),
					'type'        => Controls_Manager::SWITCHER,
					'condition'   => [
						'video_type'  => 'youtube',
						'yt_controls' => 'yes',
					],
				]
			);

			$this->add_control(
				'yt_privacy',
				[
					'label'       => esc_html__( 'Privacy Mode', 'gyan-elements' ),
					'type'        => Controls_Manager::SWITCHER,
					'description' => esc_html__( 'When enabled, YouTube won\'t store information about visitors to on your site unless visitors interact with the video.', 'gyan-elements' ),
					'condition'   => [
						'video_type' => 'youtube',
					],
				]
			);

			// Vimeo.
			$this->add_control(
				'vimeo_autoplay',
				[
					'label'     => esc_html__( 'Autoplay', 'gyan-elements' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => [
						'video_type' => 'vimeo',
					],
				]
			);

			$this->add_control(
				'vimeo_loop',
				[
					'label'     => esc_html__( 'Loop', 'gyan-elements' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => [
						'video_type' => 'vimeo',
					],
				]
			);

			$this->add_control(
				'vimeo_muted',
				[
					'label'     => esc_html__( 'Mute', 'gyan-elements' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => [
						'video_type' => 'vimeo',
					],
				]
			);

			$this->add_control(
				'vimeo_title',
				[
					'label'     => esc_html__( 'Intro Title', 'gyan-elements' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_off' => esc_html__( 'Hide', 'gyan-elements' ),
					'label_on'  => esc_html__( 'Show', 'gyan-elements' ),
					'default'   => 'yes',
					'condition' => [
						'video_type' => 'vimeo',
					],
				]
			);

			$this->add_control(
				'vimeo_portrait',
				[
					'label'     => esc_html__( 'Intro Portrait', 'gyan-elements' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_off' => esc_html__( 'Hide', 'gyan-elements' ),
					'label_on'  => esc_html__( 'Show', 'gyan-elements' ),
					'default'   => 'yes',
					'condition' => [
						'video_type' => 'vimeo',
					],
				]
			);

			$this->add_control(
				'vimeo_byline',
				[
					'label'     => esc_html__( 'Intro Byline', 'gyan-elements' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_off' => esc_html__( 'Hide', 'gyan-elements' ),
					'label_on'  => esc_html__( 'Show', 'gyan-elements' ),
					'default'   => 'yes',
					'condition' => [
						'video_type' => 'vimeo',
					],
				]
			);

			$this->add_control(
				'vimeo_color',
				[
					'label'     => esc_html__( 'Controls Color', 'gyan-elements' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .gyan-video-vimeo-title a'  => 'color: {{VALUE}}',
						'{{WRAPPER}} .gyan-video-vimeo-byline,
						{{WRAPPER}} .gyan-video-vimeo-byline a' => 'color: {{VALUE}}',
						'{{WRAPPER}} .gyan-video-vimeo-title a:hover' => 'color: {{VALUE}}',
						'{{WRAPPER}} .gyan-video-vimeo-byline a:hover' => 'color: {{VALUE}}',
						'{{WRAPPER}} .gyan-video-vimeo-title a:focus' => 'color: {{VALUE}}',
						'{{WRAPPER}} .gyan-video-vimeo-byline a:focus' => 'color: {{VALUE}}',
					],
					'condition' => [
						'video_type' => 'vimeo',
					],
				]
			);

			$this->add_control(
				'video_double_click',
				[
					'label'        => esc_html__( 'Enable Double Click on Mobile', 'gyan-elements' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_off'    => esc_html__( 'No', 'gyan-elements' ),
					'label_on'     => esc_html__( 'Yes', 'gyan-elements' ),
					'default'      => 'no',
					'return_value' => 'yes',
				]
			);



			$this->add_control(
				'video_double_click_doc',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => esc_html__( 'Turn on this option if you are not able to see custom thumbnail or overlay color on Mobile.', 'gyan-elements' ),
					'content_classes' => 'gyan-editor-doc',
				]
			);


		$this->end_controls_section();
	}

	protected function register_overlay_content() {

		$this->start_controls_section(
			'section_image_overlay',
			[
				'label' => esc_html__( 'Thumbnail & Overlay', 'gyan-elements' ),
			]
		);

			$this->add_control(
				'yt_thumbnail_size',
				[
					'label'     => esc_html__( 'Thumbnail Size', 'gyan-elements' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						'maxresdefault' => esc_html__( 'Maximum Resolution', 'gyan-elements' ),
						'hqdefault'     => esc_html__( 'High Quality', 'gyan-elements' ),
						'mqdefault'     => esc_html__( 'Medium Quality', 'gyan-elements' ),
						'sddefault'     => esc_html__( 'Standard Quality', 'gyan-elements' ),
					],
					'default'   => 'maxresdefault',
					'condition' => [
						'video_type' => 'youtube',
					],
				]
			);

			$this->add_control(
				'show_image_overlay',
				[
					'label'        => esc_html__( 'Custom Thumbnail', 'gyan-elements' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_off'    => esc_html__( 'No', 'gyan-elements' ),
					'label_on'     => esc_html__( 'Yes', 'gyan-elements' ),
					'default'      => 'no',
					'return_value' => 'yes',
				]
			);

			$this->add_control(
				'image_overlay',
				[
					'label'     => esc_html__( 'Select Image', 'gyan-elements' ),
					'type'      => Controls_Manager::MEDIA,
					'default'   => [
						'url' => GYAN_PLUGIN_URL .'addons/images/choose-img.jpg',
					],
					'dynamic'   => [
						'active' => true,
					],
					'condition' => [
						'show_image_overlay' => 'yes',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'      => 'image_overlay',
					'default'   => 'full',
					'separator' => 'none',
					'condition' => [
						'show_image_overlay' => 'yes',
					],
				]
			);

			$this->add_control(
				'image_overlay_color',
				[
					'label'     => esc_html__( 'Overlay Color', 'gyan-elements' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .gyan-video-container:before' => 'background: {{VALUE}}',
					],
				]
			);

		$this->end_controls_section();
	}

	protected function register_video_icon_style() {

		$this->start_controls_section(
			'section_play_icon',
			[
				'label' => esc_html__( 'Play Button', 'gyan-elements' ),
			]
		);

			$this->add_control(
				'play_source',
				[
					'label'   => esc_html__( 'Image/Icon', 'gyan-elements' ),
					'type'    => Controls_Manager::CHOOSE,
					'options' => [
						'default' => [
							'title' => esc_html__( 'Default', 'gyan-elements' ),
							'icon'  => 'fa fa-youtube-play',
						],
						'img'     => [
							'title' => esc_html__( 'Image', 'gyan-elements' ),
							'icon'  => 'fa fa-picture-o',
						],
						'icon'    => [
							'title' => esc_html__( 'Icon', 'gyan-elements' ),
							'icon'  => 'fa fa-info-circle',
						],
					],
					'default' => 'icon',
				]
			);

			$this->add_control(
				'play_img',
				[
					'label'     => esc_html__( 'Select Image', 'gyan-elements' ),
					'type'      => Controls_Manager::MEDIA,
					'default'   => [
						'url' => GYAN_PLUGIN_URL .'addons/images/choose-img.jpg',
					],
					'condition' => [
						'play_source' => 'img',
					],
				]
			);

			$this->add_control(
				'play_icon',
				[
					'label' => esc_html__( 'Icon', 'elementor' ),
					'type' => Controls_Manager::ICONS,
					'default' => [
						'value' => 'fas fa-play-circle',
						'library' => 'fa-solid',
					],
					'condition' => [
						'play_source' => 'icon',
					],
				]
			);

			$this->add_responsive_control(
				'play_icon_size',
				[
					'label'     => esc_html__( 'Size', 'gyan-elements' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 10,
							'max' => 700,
						],
					],
					'default'   => [
						'size' => 72,
						'unit' => 'px',
					],
					'selectors' => [
						'{{WRAPPER}} .gyan-video-play-icon.gyan-icon' => 'font-size: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .gyan-video-play-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .gyan-video-play-icon > img' => 'width: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .gyan-video-play-icon.gyan-video__vimeo-play' => 'width: auto; height: auto;',
						'{{WRAPPER}} .gyan-video-vimeo-icon-bg' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'hover_animation_img',
				[
					'label'     => esc_html__( 'Hover Animation', 'gyan-elements' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => '',
					'options'   => [
						''                => esc_html__( 'None', 'gyan-elements' ),
						'grow'            => esc_html__( 'Grow', 'gyan-elements' ),
						'float'           => esc_html__( 'Float', 'gyan-elements' ),
						'sink'            => esc_html__( 'Sink', 'gyan-elements' ),
						'wobble-vertical' => esc_html__( 'Wobble Vertical', 'gyan-elements' ),
					],
					'condition' => [
						'play_source' => 'img',
					],
				]
			);

			$this->start_controls_tabs( 'tabs_style' );

				$this->start_controls_tab(
					'tab_normal',
					[
						'label'     => esc_html__( 'Normal', 'gyan-elements' ),
						'condition' => [
							'play_icon!'  => '',
							'play_source' => 'icon',
						],
					]
				);

					$this->add_control(
						'play_icon_color',
						[
							'label'     => esc_html__( 'Color', 'gyan-elements' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .gyan-video-play-icon' => 'color: {{VALUE}}',
								'{{WRAPPER}} .gyan-video-play-icon svg' => 'fill: {{VALUE}}',
							],
							'condition' => [
								'play_icon!'  => '',
								'play_source' => 'icon',
							],
						]
					);

					$this->add_group_control(
						Group_Control_Text_Shadow::get_type(),
						[
							'name'      => 'play_icon_text_shadow',
							'selector'  => '{{WRAPPER}} .gyan-video-play-icon',
							'condition' => [
								'play_icon!'  => '',
								'play_source' => 'icon',
							],
						]
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_hover',
					[
						'label'     => esc_html__( 'Hover', 'gyan-elements' ),
						'condition' => [
							'play_icon!'  => '',
							'play_source' => 'icon',
						],
					]
				);

					$this->add_control(
						'play_icon_hover_color',
						[
							'label'     => esc_html__( 'Color', 'gyan-elements' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .gyan-video-container:hover .gyan-video-play-icon' => 'color: {{VALUE}}',
								'{{WRAPPER}} .gyan-video-container:hover .gyan-video-play-icon svg' => 'fill: {{VALUE}}',

							],
							'condition' => [
								'play_icon!'  => '',
								'play_source' => 'icon',
							],
						]
					);

					$this->add_group_control(
						Group_Control_Text_Shadow::get_type(),
						[
							'name'      => 'play_icon_hover_text_shadow',
							'selector'  => '{{WRAPPER}} .gyan-video-container:hover .gyan-video-play-icon',
							'condition' => [
								'play_icon!'  => '',
								'play_source' => 'icon',
							],
						]
					);

					$this->add_control(
						'hover_animation',
						[
							'label'     => esc_html__( 'Hover Animation', 'gyan-elements' ),
							'type'      => Controls_Manager::SELECT,
							'default'   => '',
							'options'   => [
								''                => esc_html__( 'None', 'gyan-elements' ),
								'grow'            => esc_html__( 'Grow', 'gyan-elements' ),
								'float'           => esc_html__( 'Float', 'gyan-elements' ),
								'sink'            => esc_html__( 'Sink', 'gyan-elements' ),
								'wobble-vertical' => esc_html__( 'Wobble Vertical', 'gyan-elements' ),
							],
							'condition' => [
								'play_icon!'  => '',
								'play_source' => 'icon',
							],
						]
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_control(
				'default_play_icon_color',
				[
					'label'     => esc_html__( 'Background Color', 'gyan-elements' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .gyan-video-youtube-icon-bg, {{WRAPPER}} .gyan-video-vimeo-icon-bg' => 'fill: {{VALUE}}',
					],
					'condition' => [
						'play_source' => 'default',
					],
				]
			);

			$this->add_control(
				'default_play_icon_hover_color',
				[
					'label'     => esc_html__( 'Hover Background Color', 'gyan-elements' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .gyan-video-container:hover .gyan-video-play-icon .gyan-video-youtube-icon-bg, {{WRAPPER}} .gyan-video-container:hover .gyan-video-play-icon .gyan-video-vimeo-icon-bg' => 'fill: {{VALUE}}',
					],
					'condition' => [
						'play_source' => 'default',
					],
				]
			);

			$this->add_control(
				'default_hover_animation',
				[
					'label'     => esc_html__( 'Hover Animation', 'gyan-elements' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => '',
					'options'   => [
						''                => esc_html__( 'None', 'gyan-elements' ),
						'grow'            => esc_html__( 'Grow', 'gyan-elements' ),
						'float'           => esc_html__( 'Float', 'gyan-elements' ),
						'sink'            => esc_html__( 'Sink', 'gyan-elements' ),
						'wobble-vertical' => esc_html__( 'Wobble Vertical', 'gyan-elements' ),
					],
					'condition' => [
						'play_source' => 'default',
					],
				]
			);

		$this->end_controls_section();
	}

	protected function register_video_subscribe_bar() {

		$this->start_controls_section(
			'section_subscribe_bar',
			[
				'label'     => esc_html__( 'YouTube Subscribe Bar', 'gyan-elements' ),
				'condition' => [
					'video_type' => 'youtube',
				],
			]
		);

			$this->add_control(
				'subscribe_bar',
				[
					'label'     => esc_html__( 'Enable Subscribe Bar', 'gyan-elements' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_off' => esc_html__( 'No', 'gyan-elements' ),
					'label_on'  => esc_html__( 'Yes', 'gyan-elements' ),
					'default'   => 'no',
					'condition' => [
						'video_type' => 'youtube',
					],
				]
			);

			$this->add_control(
				'subscribe_bar_select',
				[
					'label'     => esc_html__( 'Select', 'gyan-elements' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						'channel_name' => esc_html__( 'Use Channel Name', 'gyan-elements' ),
						'channel_id'   => esc_html__( 'Use Channel ID', 'gyan-elements' ),
					],
					'default'   => 'channel_id',
					'condition' => [
						'video_type'    => 'youtube',
						'subscribe_bar' => 'yes',
					],
				]
			);

			$this->add_control(
				'subscribe_bar_channel_name',
				[
					'label'       => esc_html__( 'YouTube Channel Name', 'gyan-elements' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => 'Softwebmedia',
					'label_block' => true,
					'condition'   => [
						'video_type'           => 'youtube',
						'subscribe_bar'        => 'yes',
						'subscribe_bar_select' => 'channel_name',
					],
				]
			);

			$this->add_control(
				'subscribe_bar_channel_id',
				[
					'label'       => esc_html__( 'YouTube Channel ID', 'gyan-elements' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => 'UCaT0xMWf69ow3DGXqFfPqlg',
					'label_block' => true,
					'condition'   => [
						'video_type'           => 'youtube',
						'subscribe_bar'        => 'yes',
						'subscribe_bar_select' => 'channel_id',
					],
				]
			);



			$this->add_control(
				'subscribe_channel_id_doc',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => esc_html__( 'If your YouTube channel has custom URL then you can use channel name otherwise we suggest to enter channel ID.', 'gyan-elements' ),
					'content_classes' => 'gyan-editor-doc',
					'condition'       => [
						'video_type'           => 'youtube',
						'subscribe_bar'        => 'yes',
						'subscribe_bar_select' => 'channel_name',
					],
				]
			);

			$this->add_control(
				'subscribe_channel_name_doc',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf( __( '%1$s Click Here %2$s to find your YouTube Channel ID.', 'gyan-elements' ), '<a href="https://www.youtube.com/results?search_query=how+to+find+channel+youtube+channel+id+english&sp=EgIIBQ%253D%253D" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'gyan-editor-doc',
					'condition'       => [
						'video_type'           => 'youtube',
						'subscribe_bar'        => 'yes',
						'subscribe_bar_select' => 'channel_id',
					],
				]
			);


			$this->add_control(
				'subscribe_bar_channel_text',
				[
					'label'       => esc_html__( 'Subscribe to Channel Text', 'gyan-elements' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => 'Subscribe to our YouTube Channel',
					'label_block' => true,
					'condition'   => [
						'video_type'    => 'youtube',
						'subscribe_bar' => 'yes',
					],
				]
			);

			$this->add_control(
				'subscribe_count',
				[
					'label'     => esc_html__( 'Show Subscribers Count', 'gyan-elements' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_off' => esc_html__( 'No', 'gyan-elements' ),
					'label_on'  => esc_html__( 'Yes', 'gyan-elements' ),
					'default'   => 'yes',
					'condition' => [
						'video_type'    => 'youtube',
						'subscribe_bar' => 'yes',
					],
				]
			);

			$this->add_control(
				'subscribe_bar_color',
				[
					'label'     => esc_html__( 'Text Color', 'gyan-elements' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#ffffff',
					'selectors' => [
						'{{WRAPPER}} .gyan-video-subscribe-bar-prefix' => 'color: {{VALUE}}',
					],
					'condition' => [
						'video_type'    => 'youtube',
						'subscribe_bar' => 'yes',
					],
				]
			);

			$this->add_control(
				'subscribe_bar_bgcolor',
				[
					'label'     => esc_html__( 'Background Color', 'gyan-elements' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#1b1b1b',
					'selectors' => [
						'{{WRAPPER}} .gyan-video-subscribe-bar' => 'background-color: {{VALUE}}',
					],
					'condition' => [
						'video_type'    => 'youtube',
						'subscribe_bar' => 'yes',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'subscribe_bar_typography',
					'scheme'    => Scheme_Typography::TYPOGRAPHY_3,
					'selector'  => '{{WRAPPER}} .gyan-video-subscribe-bar-prefix',
					'condition' => [
						'video_type'    => 'youtube',
						'subscribe_bar' => 'yes',
					],
				]
			);

			$this->add_responsive_control(
				'subscribe_bar_padding',
				[
					'label'      => esc_html__( 'Padding', 'gyan-elements' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .gyan-video-subscribe-bar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'video_type'    => 'youtube',
						'subscribe_bar' => 'yes',
					],
				]
			);

			$this->add_control(
				'subscribe_bar_responsive',
				[
					'label'        => esc_html__( 'Stack on', 'gyan-elements' ),
					'description'  => esc_html__( 'Choose a breakpoint where the subscribe bar content will stack.', 'gyan-elements' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => 'none',
					'options'      => [
						'none'    => esc_html__( 'None', 'gyan-elements' ),
						'desktop' => esc_html__( 'Desktop', 'gyan-elements' ),
						'tablet'  => esc_html__( 'Tablet', 'gyan-elements' ),
						'mobile'  => esc_html__( 'Mobile', 'gyan-elements' ),
					],
					'condition'    => [
						'video_type'    => 'youtube',
						'subscribe_bar' => 'yes',
					],
					'prefix_class' => 'gyan-subscribe-responsive-',
					'separator'    => 'before',
				]
			);

			if ( is_rtl() ) {

				$this->add_responsive_control(
					'subscribe_bar_spacing',
					[
						'label'      => esc_html__( 'Spacing', 'gyan-elements' ),
						'type'       => Controls_Manager::SLIDER,
						'size_units' => [ 'px' ],
						'range'      => [
							'px' => [
								'min' => 0,
								'max' => 50,
							],
						],
						'selectors'  => [
							'{{WRAPPER}} .gyan-video-subscribe-bar-prefix ' => 'margin-left: {{SIZE}}{{UNIT}};',
							'{{WRAPPER}}.gyan-subscribe-responsive-desktop .gyan-video-subscribe-bar-prefix ' => 'margin-bottom: {{SIZE}}{{UNIT}}; margin-left: 0px;',
							'(tablet){{WRAPPER}}.gyan-subscribe-responsive-tablet .gyan-video-subscribe-bar-prefix ' => 'margin-bottom: {{SIZE}}{{UNIT}}; margin-left: 0px;',
							'(mobile){{WRAPPER}}.gyan-subscribe-responsive-mobile .gyan-video-subscribe-bar-prefix ' => 'margin-bottom: {{SIZE}}{{UNIT}}; margin-left: 0px;',
						],
						'condition'  => [
							'video_type'    => 'youtube',
							'subscribe_bar' => 'yes',
						],
					]
				);

			} else {

				$this->add_responsive_control(
					'subscribe_bar_spacing',
					[
						'label'      => esc_html__( 'Spacing', 'gyan-elements' ),
						'type'       => Controls_Manager::SLIDER,
						'size_units' => [ 'px' ],
						'range'      => [
							'px' => [
								'min' => 0,
								'max' => 50,
							],
						],
						'selectors'  => [
							'{{WRAPPER}} .gyan-video-subscribe-bar-prefix ' => 'margin-right: {{SIZE}}{{UNIT}};',
							'{{WRAPPER}}.gyan-subscribe-responsive-desktop .gyan-video-subscribe-bar-prefix ' => 'margin-bottom: {{SIZE}}{{UNIT}}; margin-right: 0px;',
							'(tablet){{WRAPPER}}.gyan-subscribe-responsive-tablet .gyan-video-subscribe-bar-prefix ' => 'margin-bottom: {{SIZE}}{{UNIT}}; margin-right: 0px;',
							'(mobile){{WRAPPER}}.gyan-subscribe-responsive-mobile .gyan-video-subscribe-bar-prefix ' => 'margin-bottom: {{SIZE}}{{UNIT}}; margin-right: 0px;',
						],
						'condition'  => [
							'video_type'    => 'youtube',
							'subscribe_bar' => 'yes',
						],
					]
				);

			}





		$this->end_controls_section();
	}

	protected function get_video_thumb( $id ) {

		if ( '' == $id ) {
			return '';
		}

		$settings = $this->get_settings_for_display();
		$thumb    = '';

		if ( 'yes' == $settings['show_image_overlay'] ) {

			$thumb = Group_Control_Image_Size::get_attachment_image_src( $settings['image_overlay']['id'], 'image_overlay', $settings );

		} else {

			if ( 'youtube' == $settings['video_type'] ) {

				$thumb = 'https://i.ytimg.com/vi/' . $id . '/' . apply_filters( 'gyan_video_youtube_image_quality', $settings['yt_thumbnail_size'] ) . '.jpg';
			} else {
				// @codingStandardsIgnoreStart
				$vimeo = unserialize( @file_get_contents( "https://vimeo.com/api/v2/video/$id.php" ) );
				// @codingStandardsIgnoreEnd
				$thumb = str_replace( '_640', '_840', $vimeo[0]['thumbnail_large'] );
			}
		}

		return $thumb;
	}

	protected function get_video_id() {

		$settings = $this->get_settings_for_display();
		$id       = '';
		$url      = $settings[ $settings['video_type'] . '_link' ];

		if ( 'youtube' == $settings['video_type'] ) {

			if ( preg_match( '/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches ) ) {
				$id = $matches[1];
			}
		} elseif ( 'vimeo' == $settings['video_type'] ) {

			$id = preg_replace( '/[^\/]+[^0-9]|(\/)/', '', rtrim( $url, '/' ) );
		}

		return $id;
	}

	protected function get_url( $params, $id ) {

		$settings = $this->get_settings_for_display();
		$url      = '';

		if ( 'vimeo' == $settings['video_type'] ) {

			$url = 'https://player.vimeo.com/video/';
		} else {

			$cookie = '';

			if ( 'yes' == $settings['yt_privacy'] ) {
				$cookie = '-nocookie';
			}
			$url = 'https://www.youtube' . $cookie . '.com/embed/';
		}

		$url = add_query_arg( $params, $url . $id );

		$url .= ( empty( $params ) ) ? '?' : '&';

		$url .= 'autoplay=1';

		if ( 'vimeo' == $settings['video_type'] && '' != $settings['start'] ) {

			$time = date( 'H\hi\ms\s', $settings['start'] );
			$url .= '#t=' . $time;
		}

		$url = apply_filters( 'gyan_video_url_filter', $url, $id );

		return $url;
	}

	function get_header_wrap( $id ) {

		$settings = $this->get_settings_for_display();

		if ( 'vimeo' != $settings['video_type'] ) {
			return;
		}

		// @codingStandardsIgnoreStart
		$vimeo = unserialize( @file_get_contents( "https://vimeo.com/api/v2/video/$id.php" ) );
		// @codingStandardsIgnoreEnd
		if (
			'yes' == $settings['vimeo_portrait'] ||
			'yes' == $settings['vimeo_title'] ||
			'yes' == $settings['vimeo_byline']
		) { ?>
		<div class="gyan-video-vimeo-wrap">
			<?php if ( 'yes' == $settings['vimeo_portrait'] ) { ?>
			<div class="gyan-video-vimeo-portrait">
				<a href="<?php $vimeo[0]['user_url']; ?>"><img src="<?php echo $vimeo[0]['user_portrait_huge']; ?>" alt=""></a>
			</div>
			<?php } ?>
			<?php
			if (
				'yes' == $settings['vimeo_title'] ||
				'yes' == $settings['vimeo_byline']
			) {
				?>
			<div class="gyan-video-vimeo-headers">
				<?php if ( 'yes' == $settings['vimeo_title'] ) { ?>
				<div class="gyan-video-vimeo-title">
					<a href="<?php $settings['vimeo_link']; ?>"><?php echo $vimeo[0]['title']; ?></a>
				</div>
				<?php } ?>
				<?php if ( 'yes' == $settings['vimeo_byline'] ) { ?>
				<div class="gyan-video-vimeo-byline">
					<?php echo esc_html__( 'from ', 'gyan-elements' ); ?> <a href="<?php $settings['vimeo_link']; ?>"><?php echo $vimeo[0]['user_name']; ?></a>
				</div>
				<?php } ?>
			</div>
			<?php } ?>
		</div>
		<?php } ?>
		<?php
	}

	protected function get_video_embed() {

		$settings       = $this->get_settings_for_display();
		$is_editor      = \Elementor\Plugin::instance()->editor->is_edit_mode();
		$id             = $this->get_video_id();
		$embed_param    = $this->get_embed_params();
		$src            = $this->get_url( $embed_param, $id );

		if ( 'yes' == $settings['video_double_click'] ) {
			$device = 'false';
		} else {
			$device = ( false !== ( stripos( $_SERVER['HTTP_USER_AGENT'], 'iPhone' ) ) ? 'true' : 'false' );
		}

		if ( 'youtube' == $settings['video_type'] ) {
			$autoplay = ( 'yes' == $settings['yt_autoplay'] ) ? '1' : '0';
		} else {
			$autoplay = ( 'yes' == $settings['vimeo_autoplay'] ) ? '1' : '0';
		}

		$this->add_render_attribute( 'video-outer', 'class', 'gyan-video-container' );

		$this->add_render_attribute( 'video-outer', 'data-autoplay', $autoplay );
		$this->add_render_attribute( 'video-outer', 'data-device', $device );

		$this->add_render_attribute( 'video-wrapper', 'class', 'gyan-video__play' );
		$this->add_render_attribute( 'video-wrapper', 'data-src', $src );

		$this->add_render_attribute( 'video-thumb', 'class', 'gyan-video__thumb' );
		$this->add_render_attribute( 'video-thumb', 'src', $this->get_video_thumb( $id ) );

		$this->add_render_attribute( 'video-play', 'class', 'gyan-video-play-icon gyan-icon gyan-ease-transition' );

		if ( 'default' == $settings['play_source'] ) {
			if ( 'youtube' == $settings['video_type'] ) {

				$html = '<svg height="100%" version="1.1" viewBox="0 0 68 48" width="100%"><path class="gyan-video-youtube-icon-bg" d="m .66,37.62 c 0,0 .66,4.70 2.70,6.77 2.58,2.71 5.98,2.63 7.49,2.91 5.43,.52 23.10,.68 23.12,.68 .00,-1.3e-5 14.29,-0.02 23.81,-0.71 1.32,-0.15 4.22,-0.17 6.81,-2.89 2.03,-2.07 2.70,-6.77 2.70,-6.77 0,0 .67,-5.52 .67,-11.04 l 0,-5.17 c 0,-5.52 -0.67,-11.04 -0.67,-11.04 0,0 -0.66,-4.70 -2.70,-6.77 C 62.03,.86 59.13,.84 57.80,.69 48.28,0 34.00,0 34.00,0 33.97,0 19.69,0 10.18,.69 8.85,.84 5.95,.86 3.36,3.58 1.32,5.65 .66,10.35 .66,10.35 c 0,0 -0.55,4.50 -0.66,9.45 l 0,8.36 c .10,4.94 .66,9.45 .66,9.45 z" fill="#1f1f1e"></path><path d="m 26.96,13.67 18.37,9.62 -18.37,9.55 -0.00,-19.17 z" fill="#fff"></path><path d="M 45.02,23.46 45.32,23.28 26.96,13.67 43.32,24.34 45.02,23.46 z" fill="#ccc"></path></svg>';

			} elseif ( 'vimeo' == $settings['video_type'] ) {

				$this->add_render_attribute( 'video-play', 'class', 'gyan-video__vimeo-play' );

				$html = '<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="gyan-video-vimeo-icon-bg" x="0px" y="0px" width="100%" height="100%" viewBox="0 14.375 95 66.25" enable-background="new 0 14.375 95 66.25" xml:space="preserve" fill="rgba(23,34,35,.75)"><path d="M12.5,14.375c-6.903,0-12.5,5.597-12.5,12.5v41.25c0,6.902,5.597,12.5,12.5,12.5h70c6.903,0,12.5-5.598,12.5-12.5v-41.25 c0-6.903-5.597-12.5-12.5-12.5H12.5z"/><polygon fill="#FFFFFF" points="39.992,64.299 39.992,30.701 62.075,47.5 "/></svg>';
			}
		} elseif ( 'icon' == $settings['play_source'] ) {

			ob_start();
       		Icons_Manager::render_icon( $settings['play_icon'], [ 'aria-hidden' => 'true' ] );
        	$html = ob_get_contents();
			ob_end_clean();

		} else {
			$html = '<img src="' . $settings['play_img']['url'] . '" alt="' . Control_Media::get_image_alt( $settings['play_img'] ) . '" />';
		}

		if ( 'img' == $settings['play_source'] ) {
			$this->add_render_attribute( 'video-play', 'class', 'gyan-animation-' . $settings['hover_animation_img'] );
		} elseif ( 'default' == $settings['play_source'] ) {
			$this->add_render_attribute( 'video-play', 'class', 'gyan-animation-' . $settings['default_hover_animation'] );
		} else {
			$this->add_render_attribute( 'video-play', 'class', 'gyan-animation-' . $settings['hover_animation'] );
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'video-outer' ); ?>>
			<?php $this->get_header_wrap( $id ); ?>
			<div class="gyan-video-holder">
				<div <?php echo $this->get_render_attribute_string( 'video-wrapper' ); ?>>
					<img <?php echo $this->get_render_attribute_string( 'video-thumb' ); ?> />
					<div <?php echo $this->get_render_attribute_string( 'video-play' ); ?>>
						<?php echo $html; ?>
					</div>
				</div>
			</div>
		</div>
		<?php
		if ( 'youtube' == $settings['video_type'] && 'yes' == $settings['subscribe_bar'] ) {
			$channel_name     = ( '' != $settings['subscribe_bar_channel_name'] ) ? $settings['subscribe_bar_channel_name'] : '';
			$channel_id       = ( '' != $settings['subscribe_bar_channel_id'] ) ? $settings['subscribe_bar_channel_id'] : '';
			$youtube_text     = ( '' != $settings['subscribe_bar_channel_text'] ) ? $settings['subscribe_bar_channel_text'] : '';
			$subscriber_count = ( 'yes' == $settings['subscribe_count'] ) ? 'default' : 'hidden';
			?>
			<div class="gyan-video-subscribe-bar">
				<div class="gyan-video-subscribe-bar-prefix"><?php echo $youtube_text; ?></div>
				<div class="gyan-video-subscribe-bar-content">
					<?php if ( false !== $is_editor ) { ?>
						<script src="https://apis.google.com/js/platform.js"></script>
					<?php } ?>
					<?php if ( 'channel_name' == $settings['subscribe_bar_select'] ) { ?>
						<div class="g-ytsubscribe" data-channel="<?php echo $channel_name; ?>" data-count="<?php echo $subscriber_count; ?>"></div>
					<?php } elseif ( 'channel_id' == $settings['subscribe_bar_select'] ) { ?>
						<div class="g-ytsubscribe" data-channelid="<?php echo $channel_id; ?>" data-count="<?php echo $subscriber_count; ?>"></div>
					<?php } ?>
				</div>
			</div>
			<?php
		}
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		if ( '' == $settings['youtube_link'] && 'youtube' == $settings['video_type'] ) { return ''; }
		if ( '' == $settings['vimeo_link'] && 'vimeo' == $settings['video_type'] ) 	 { return ''; }

		$this->get_video_embed();
	}

	public function render_plain_content() {
		$settings = $this->get_settings_for_display();
		$url      = 'youtube' === $settings['video_type'] ? $settings['youtube_link'] : $settings['vimeo_link'];

		echo esc_url( $url );
	}

	public function get_embed_params() {

		$settings = $this->get_settings_for_display();
		$params = [];

		if ( 'youtube' === $settings['video_type'] ) {
			$youtube_options = [ 'autoplay', 'rel', 'controls', 'mute', 'modestbranding' ];

			foreach ( $youtube_options as $option ) {

				if ( 'autoplay' == $option ) {
					if ( 'yes' === $settings['yt_autoplay'] ) {
						$params[ $option ] = '1';
					}
					continue;
				}

				$value             = ( 'yes' === $settings[ 'yt_' . $option ] ) ? '1' : '0';
				$params[ $option ] = $value;
				$params['start']   = $settings['start'];
				$params['end']     = $settings['end'];
			}
		}

		if ( 'vimeo' === $settings['video_type'] ) {
			$vimeo_options = [ 'autoplay', 'loop', 'title', 'portrait', 'byline', 'muted' ];

			foreach ( $vimeo_options as $option ) {

				if ( 'autoplay' == $option ) {
					if ( 'yes' === $settings['vimeo_autoplay'] ) {
						$params[ $option ] = '1';
					}
					continue;
				}

				$value             = ( 'yes' === $settings[ 'vimeo_' . $option ] ) ? '1' : '0';
				$params[ $option ] = $value;
			}

			$params['color']     = str_replace( '#', '', $settings['vimeo_color'] );
			$params['autopause'] = '0';
		}

		return $params;
	}
}