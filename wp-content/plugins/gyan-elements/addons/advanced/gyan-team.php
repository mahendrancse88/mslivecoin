<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;
use Elementor\Plugin;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Gyan_Team extends Widget_Base {

	public function get_name()       { return 'gyan_team'; }
	public function get_title()      { return esc_html__( 'Team', 'gyan-elements' ); }
	public function get_icon()       { return 'gyan-el-icon eicon-person'; }
	public function get_categories() { return ['gyan-advanced-addons']; }
	public function get_keywords()   { return ['team member','team','member','person','staff' ]; }
    public function get_style_depends() {return [ 'gyan-icon','gyan-grid','gyan-team' ]; }
    public function get_script_depends() { return [ 'gyan-widgets','imagesLoaded', 'isotope','gyan-element-resize' ]; }

	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Team', 'gyan-elements' ),
			]
		);

        $repeater = new Repeater();

		$repeater->add_control(
			'person_image',
			[
				'label'     => esc_html__( 'Person Image', 'gyan-elements' ),
				'type'      => Controls_Manager::MEDIA
			]
		);

		$repeater->add_control(
			'person_name',
			[
				'label' => esc_html__( 'Person Name', 'gyan-elements' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__('Enter Name', 'gyan-elements'),
				'default' => 'William James',
			]
		);

		$repeater->add_control(
			'person_position',
			[
				'label' => esc_html__( 'Person Position', 'gyan-elements' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__('Enter Position', 'gyan-elements'),
				'default' => 'CEO & Founder',
			]
		);

        $repeater->add_control(
            'person_single_link',
            [
                'label'    => esc_html__( 'Person Single Page Link', 'gyan-elements' ),
                'type'     => Controls_Manager::URL,
                'default'  => [
                    'url'         => '#',
                    'is_external' => '',
                ],
                'dynamic'  => [
                    'active' => true,
                ],
                'selector' => '',
            ]
        );

        $repeater->add_control(
            'social_icons_on',
            [
                'label'        => esc_html__( 'Social Icons', 'gyan-elements' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'label_on'     => esc_html__( 'Yes', 'gyan-elements' ),
                'label_off'    => esc_html__( 'No', 'gyan-elements' ),
                'return_value' => 'yes',
                'separator' => 'before',
            ]
        );

        $repeater->add_control(
            'social_icon1',
            [
                'label' => esc_html__( 'Social Media Icon #1', 'gyan-elements' ),
                'type'  => Controls_Manager::ICONS,
                'separator' => 'before',
                'condition' => [
                    'social_icons_on' => 'yes',
                ],
                'default' => [
                    'value' => 'fab fa-twitter',
                    'library' => 'fa-brands',
                ]
            ]
        );

        $repeater->add_control(
            'social_icon1_link',
            [
                'label' => esc_html__( 'Social Media Icon #1  Link', 'gyan-elements' ),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'social_icons_on' => 'yes',
                ],
                'default' => '#',
            ]
        );

         $repeater->add_control(
            'social_icon2',
            [
                'label' => esc_html__( 'Social Media Icon #2', 'gyan-elements' ),
                'type'  => Controls_Manager::ICONS,
                'separator' => 'before',
                'condition' => [
                    'social_icons_on' => 'yes',
                ],
                'default' => [
                    'value' => 'fab fa-facebook-f',
                    'library' => 'fa-brands',
                ]
            ]
        );

        $repeater->add_control(
            'social_icon2_link',
            [
                'label' => esc_html__( 'Social Media Icon #2  Link', 'gyan-elements' ),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'social_icons_on' => 'yes',
                ],
                'default' => '#',
            ]
        );

         $repeater->add_control(
            'social_icon3',
            [
                'label' => esc_html__( 'Social Media Icon #3', 'gyan-elements' ),
                'type'  => Controls_Manager::ICONS,
                'separator' => 'before',
                'condition' => [
                    'social_icons_on' => 'yes',
                ],
                'default' => [
                    'value' => 'fab fa-linkedin-in',
                    'library' => 'fa-brands',
                ]
            ]
        );

        $repeater->add_control(
            'social_icon3_link',
            [
                'label' => esc_html__( 'Social Media Icon #3  Link', 'gyan-elements' ),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'social_icons_on' => 'yes',
                ],
                'default' => '#',
            ]
        );

         $repeater->add_control(
            'social_icon4',
            [
                'label' => esc_html__( 'Social Media Icon #4', 'gyan-elements' ),
                'type'  => Controls_Manager::ICONS,
                'separator' => 'before',
                'condition' => [
                    'social_icons_on' => 'yes',
                ],
                'default' => [
                    'value' => 'fab fa-instagram',
                    'library' => 'fa-brands',
                ]
            ]
        );

        $repeater->add_control(
            'social_icon4_link',
            [
                'label' => esc_html__( 'Social Media Icon #4  Link', 'gyan-elements' ),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'social_icons_on' => 'yes',
                ],
                'default' => '#',
            ]
        );

        $this->add_control(
            'team_member_details',
            [
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{person_name}}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'person_general_style',
            [
				'label' => esc_html__( 'General', 'gyan-elements' ),
				'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label'                 => esc_html__( 'Columns', 'gyan-elements' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => '3',
                'tablet_default'        => '2',
                'mobile_default'        => '1',
                'options'               => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                ],
                'prefix_class'          => 'elementor-grid%s-',
                'frontend_available'    => true
            ]
        );

        $this->add_control(
            'layout',
            [
                'label' => esc_html__( 'Layout', 'gyan-elements' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'grid' => esc_html__( 'Grid', 'gyan-elements' ),
                    'masonry' => esc_html__( 'Masonry', 'gyan-elements' )
                ],
                'default' => 'grid',
            ]
        );

        $this->add_responsive_control(
            'column_gap',
            [
                'label'     => esc_html__( 'Columns Gap', 'gyan-elements' ),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 30,
                ],
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-team-item.gyan-grid-item-wrap' => 'padding-right: calc( {{SIZE}}{{UNIT}}/2 ); padding-left: calc( {{SIZE}}{{UNIT}}/2 );',
                    '{{WRAPPER}} .gyan-team-grid.gyan-elementor-grid' => 'margin-left: calc( -{{SIZE}}{{UNIT}}/2 ); margin-right: calc( -{{SIZE}}{{UNIT}}/2 );',
                ],
            ]
        );

        $this->add_responsive_control(
            'row_gap',
            [
                'label'     => esc_html__( 'Rows Gap', 'gyan-elements' ),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 30,
                ],
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-elementor-grid .gyan-team-item-inner.gyan-grid-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'    => 'person_image_size',
                'label'   => esc_html__( 'Image Size', 'gyan-elements' ),
                'default' => 'full'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'person_name_style',
            [
                'label' => esc_html__( 'Content Section', 'gyan-elements' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'person_name_style_heading',
            [
                'label'                 => esc_html__( 'Person Name', 'gyan-elements' ),
                'type'                  => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'team_name_typography',
                'fields_options' => [
                    'typography' => [
                        'default' =>'custom',
                    ],
                    'font_size'   => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '19',
                        ],
                    ]
                ],
                'selector' => '{{WRAPPER}} .gyan-team-name-tag',
            ]
        );

        $this->add_responsive_control(
            'name_position_gap',
            [
                'label'     => esc_html__( 'Name and Position Gap', 'gyan-elements' ),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => -1,
                ],
                'range'     => [
                    'px' => [
                        'min' => -30,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-team-name-tag' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

		$this->add_control(
			'member_name_col',
			[
				'label' => esc_html__( 'Person Name Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#032e42',
				'selectors' => [
					'{{WRAPPER}} .gyan-team-name,{{WRAPPER}} .gyan-team-name a' => 'color: {{VALUE}}'
				]
			]
		);

		$this->add_control(
			'member_name_col_hover',
			[
				'label' => esc_html__( 'Person Name Text Hover Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#d83030',
				'selectors' => [
					'{{WRAPPER}} .gyan-team-name a:hover' => 'color: {{VALUE}}'
				]
			]
		);

        $this->add_control(
            'member_name_html_tag',
            [
                'label'   => esc_html__( 'Name Text HTML Tag', 'gyan-elements' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'h6',
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

		$this->add_control(
            'position_style_heading',
            [
                'label'                 => esc_html__( 'Person Position', 'gyan-elements' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'team_position_typography',
                'fields_options' => [
                    'typography' => [
                        'default' =>'custom',
                    ],
                    'font_size'   => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '13',
                        ],
                    ]
                ],
                'selector' => '{{WRAPPER}} .gyan-team-position',
            ]
        );

		$this->add_control(
			'member_position_col',
			[
				'label' => esc_html__( 'Person Position Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#676767',
				'selectors' => [
					'{{WRAPPER}} .gyan-team-position' => 'color: {{VALUE}}'
				]
			]
		);



        $this->add_control(
            'content_style_heading',
            [
                'label'                 => esc_html__( 'Content', 'gyan-elements' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'content_bg',
                'types' => [ 'classic', 'gradient' ],
                'fields_options' => [
                    'background' => [
                        'default' =>'classic',
                    ],
                    'color' => [
                        'default' => '#ffffff',
                    ],
                ],
                'selector' => '{{WRAPPER}} .gyan-team-content',
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__( 'Content Padding', 'gyan-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .gyan-team-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'content_shadow',
                'label' => esc_html__( 'Box Shadow', 'gyan-elements' ),
                'fields_options' => [
                    'box_shadow_type' => [
                        'default' =>'yes'
                    ],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => '0',
                            'vertical' => '0',
                            'blur' => '46',
                            'color' => 'rgba(0,0,0,0.1)'
                        ]
                    ]
                ],
                'selector' => '{{WRAPPER}} .gyan-team-content',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'content_shadow_hover',
                'label' => esc_html__( 'Hover Box Shadow', 'gyan-elements' ),
                'fields_options' => [
                    'box_shadow_type' => [
                        'default' =>'yes'
                    ],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => '0',
                            'vertical' => '0',
                            'blur' => '46',
                            'color' => 'rgba(0,0,0,0.2)'
                        ]
                    ]
                ],
                'selector' => '{{WRAPPER}} .gyan-team-item:hover .gyan-team-content',
            ]
        );

		$this->end_controls_section();

        $this->start_controls_section(
            'social_icons_style',
            [
				'label' => esc_html__( 'Social Icons', 'gyan-elements' ),
				'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
			'social_icon_col',
			[
				'label' => esc_html__( 'Social Icon Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .gyan-team-social ul li i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .gyan-team-social ul li svg' => 'fill: {{VALUE}}'
				]
			]
		);

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'social_icon_bg',
                'types' => [ 'classic', 'gradient' ],
                'fields_options' => [
                    'background' => [
                        'default' =>'classic',
                    ],
                    'color' => [
                        'default' => 'rgba(0,0,0,0.7)',
                    ],
                ],
                'selector' => '{{WRAPPER}} .gyan-team-social ul',
            ]
        );

        $this->add_control(
            'title_heading',
            [
                'label'     => esc_html__( 'Share Icon', 'gyan-elements' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'share_icon_col',
            [
                'label' => esc_html__( 'Share Icon Color', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .gyan-team-share-icon span i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .gyan-team-share-icon span svg' => 'fill: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'share_icon_border_col',
            [
                'label' => esc_html__( 'Share Icon Border Color', 'gyan-elements' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .gyan-team-share-icon span' => 'border-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'share_icon_bg',
                'types' => [ 'classic', 'gradient' ],
                'fields_options' => [
                    'background' => [
                        'default' =>'classic',
                    ],
                    'color' => [
                        'default' => '#d83030',
                    ],
                ],
                'selector' => '{{WRAPPER}} .gyan-team-share-icon span',
            ]
        );

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();
        $i = 1;
        $data_rtl = is_rtl() ? 'true' : 'false';
		?>

         <div class="gyan-team <?php echo esc_attr( 'gyan-team-'.$this->get_id() ); ?>" data-layout="<?php echo esc_attr( $settings['layout'] ); ?>" data-rtl="<?php echo $data_rtl; ?>">
            <div class="gyan-team-grid gyan-elementor-grid">

            <?php foreach ( $settings['team_member_details'] as $index => $item ) :

                $team_link_key = 'team_link_' . $i;

                if ( !empty( $item['person_single_link']['url'] ) ) {

                    $this->add_render_attribute( $team_link_key, 'href', esc_url($item['person_single_link']['url']) );
                    $this->add_render_attribute( $team_link_key, 'class', 'gyan-team-link' );

                    if ( $item['person_single_link']['is_external'] ) {
                        $this->add_render_attribute( $team_link_key, 'target', '_blank' );
                    }
                    if ( $item['person_single_link']['nofollow'] ) {
                        $this->add_render_attribute( $team_link_key, 'rel', 'nofollow' );
                    }

                    $icon_link = $this->get_render_attribute_string( $team_link_key );
                    $title_link = $this->get_render_attribute_string( $team_link_key );

                    $this->add_render_attribute( $team_link_key, 'class', 'gyan-team-img-link' );

                    $image_link = $this->get_render_attribute_string( $team_link_key );
                }

                // responsive image
                if (  $settings['person_image_size_size'] == 'full' ) {
                    $imageTagHtml = wp_get_attachment_image( $item['person_image']['id'], 'full');
                } else {
                    $imgUrl = Group_Control_Image_Size::get_attachment_image_src( $item['person_image']['id'], 'person_image_size', $settings );
                    if ( ! $imgUrl ) {
                        $imgUrl = $item['person_image']['url'];
                    }
                    $imageTagHtml = '<img src="'.esc_url($imgUrl).'" alt="" />';
                }

                ?>

        		<div class="gyan-team-item gyan-grid-item-wrap">
                    <div class="gyan-team-item-inner gyan-grid-item">

            			<div class="gyan-team-image">
            				<?php if ( ! empty( $item['person_single_link']['url'] ) ) { echo '<a ' . $image_link . '></a>'; }

                            echo $imageTagHtml;

            				if ( 'yes' == $item['social_icons_on'] ) :

                                $social_icon_one = '';
                                $social_icon_two = '';
                                $social_icon_three = '';
                                $social_icon_four = '';

                                if ( '' != $item['social_icon1'] ) {
                                    ob_start();
                                    Icons_Manager::render_icon( $item['social_icon1'], [ 'aria-hidden' => 'true' ] );
                                    $social_icon_one = ob_get_clean();
                                }
                                if ( '' != $item['social_icon2'] ) {
                                    ob_start();
                                    Icons_Manager::render_icon( $item['social_icon2'], [ 'aria-hidden' => 'true' ] );
                                    $social_icon_two = ob_get_clean();
                                }
                                if ( '' != $item['social_icon3'] ) {
                                    ob_start();
                                    Icons_Manager::render_icon( $item['social_icon3'], [ 'aria-hidden' => 'true' ] );
                                    $social_icon_three = ob_get_clean();
                                }
                                if ( '' != $item['social_icon4'] ) {
                                    ob_start();
                                    Icons_Manager::render_icon( $item['social_icon4'], [ 'aria-hidden' => 'true' ] );
                                    $social_icon_four = ob_get_clean();
                                }
                                ?>

                                <div class="gyan-team-social">
                					<ul class="gyan-ease-transition">
                                        <?php if ( '' != $social_icon_one ) { ?>
                                            <li><a href="<?php echo esc_url($item['social_icon1_link']); ?>" class="gyan-icon" target="_blank"><?php echo $social_icon_one; ?></a></li>
                                        <?php } ?>
                                        <?php if ( '' != $social_icon_two ) { ?>
                                            <li><a href="<?php echo esc_url($item['social_icon2_link']); ?>" class="gyan-icon" target="_blank"><?php echo $social_icon_two; ?></a></li>
                                        <?php } ?>
                                        <?php if ( '' != $social_icon_three ) { ?>
                                            <li><a href="<?php echo esc_url($item['social_icon3_link']); ?>" class="gyan-icon" target="_blank"><?php echo $social_icon_three; ?></a></li>
                                        <?php } ?>
                                        <?php if ( '' != $social_icon_four ) { ?>
                                            <li><a href="<?php echo esc_url($item['social_icon4_link']); ?>" class="gyan-icon" target="_blank"><?php echo $social_icon_four; ?></a></li>
                                        <?php } ?>
                					</ul>
                				</div>

                            <?php endif; ?>
                        </div>

                        <?php if ( 'yes' == $item['social_icons_on'] ) { ?>
                            <div class="gyan-team-share-icon"><span><i class="fas fa-share-alt"></i></span></div>
                        <?php } ?>

                        <div class="gyan-team-content gyan-ease-transition">
            				<div class="gyan-team-name"><<?php echo $settings['member_name_html_tag']; ?>  class="gyan-team-name-tag"><?php if ( ! empty( $item['person_single_link']['url'] ) ) { echo '<a ' . $title_link . '>'; } ?><?php echo $item['person_name']; ?><?php if ( ! empty( $item['person_single_link']['url'] ) ) { echo '</a>'; } ?></<?php echo $settings['member_name_html_tag'];?>></div>
            				<div class="gyan-team-position"><?php echo $item['person_position']; ?></div>
            			</div>
        		  </div>
                </div>

            <?php $i++;
            endforeach; ?>
            <div class="clear"></div>
            </div>
        </div>
        <div class="clear"></div>

		<?php
        if ( Plugin::instance()->editor->is_edit_mode() ) {
            $this->render_editor_script();
        }
    }

    protected function render_editor_script() {
        ?>
        <script type="text/javascript">
        jQuery( document ).ready(function( $ ) {
            var gyanPFClass = '.gyan-team-'+'<?php echo $this->get_id(); ?>',
                $this = $(gyanPFClass),
                $isoGrid = $this.children('.gyan-team-grid'),
                is_rtl = $this.data('rtl') ? false : true,
                layout = $this.data('layout');

            $this.imagesLoaded( function() {
                if ( 'masonry' == layout ) {
                    var $grid = $isoGrid.isotope({
                        itemSelector: '.gyan-team-item',
                        percentPosition: true,
                        originLeft: is_rtl,
                        masonry: {
                            columnWidth: '.gyan-team-item',
                        }
                    });
                } else{
                    var $grid = $isoGrid.isotope({
                        itemSelector: '.gyan-team-item',
                        layoutMode: 'fitRows',
                        originLeft: is_rtl
                    });

                }

                $this.find('.gyan-team-item').resize( function() {
                    $grid.isotope( 'layout' );
                });

            });

        });
        </script>
        <?php
    }
}