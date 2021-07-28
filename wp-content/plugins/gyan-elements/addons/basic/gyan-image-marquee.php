<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Gyan_Image_Marquee extends Widget_Base {

	public function get_name()       { return 'gyan_image_marquee'; }
	public function get_title()      { return esc_html__( 'Image Marquee', 'gyan-elements' ); }
	public function get_icon()       { return 'gyan-el-icon eicon-image'; }
	public function get_categories() { return ['gyan-basic-addons']; }
	public function get_keywords()   { return ['image marquee','marquee','image','scroll' ]; }
	public function get_style_depends()  { return ['gyan-image-marquee']; }
	public function get_script_depends() {
		return [ 'gyan-widgets', 'limarquee' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Image Marquee', 'gyan-elements' ),
			]
		);

		$this->add_control(
			'image',
			[
				'label'     => esc_html__( 'Image', 'gyan-elements' ),
				'type'      => Controls_Manager::MEDIA
			]
		);

        $this->add_control(
            'direction',
            [
                'label'                 => esc_html__( 'Direction', 'gyan-elements' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => 'left',
                'options'               => [
					'left'  => esc_html__( 'Left', 'gyan-elements' ),
					'right' => esc_html__( 'Right', 'gyan-elements' ),
					'up'    => esc_html__( 'Up', 'gyan-elements' ),
					'down'  => esc_html__( 'Down', 'gyan-elements' ),
                ]
            ]
        );

        $this->add_control(
            'height',
            [
                'label'                 => esc_html__( 'Height', 'gyan-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px'        => [
                        'min'   => 50,
                        'max'   => 1000,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px' ],
				'default'               => [
					'size' => 400,
					'unit' => 'px',
				],
                'condition'             => [
                    'direction'   => array('up','down'),
                ],
                'selectors'             => [
                    '{{WRAPPER}} .gyan-image-marquee' => 'height: {{SIZE}}px',
                ],
            ]
        );

        $this->add_control(
            'hover_on',
            [
                'label'                 => esc_html__( 'Hover Stop', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'no',
                'label_on'              => esc_html__( 'Yes', 'gyan-elements' ),
                'label_off'             => esc_html__( 'No', 'gyan-elements' ),
                'return_value'          => 'yes',
            ]
        );

        $this->add_control(
            'drag_on',
            [
                'label'                 => esc_html__( 'Drag Image', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'no',
                'label_on'              => esc_html__( 'Yes', 'gyan-elements' ),
                'label_off'             => esc_html__( 'No', 'gyan-elements' ),
                'condition'             => [
                    'hover_on'   => 'yes',
                ],
                'return_value'          => 'yes',
            ]
        );

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		?>
		<ul class="gyan-image-marquee" data-hover="<?php echo $settings['hover_on']; ?>" data-drag="<?php echo $settings['drag_on']; ?>" data-direction="<?php echo $settings['direction']; ?>"><li>
	            <?php
                    if ( ! empty( $settings['image']['url'] ) ) {
                        echo wp_get_attachment_image( $settings['image']['id'], 'full');
                    }
                ?>
	        </li><li>
	            <?php
                    if ( ! empty( $settings['image']['url'] ) ) {
                        echo wp_get_attachment_image( $settings['image']['id'], 'full');
                    }
                ?>
	        </li></ul>
		<?php
	}
}