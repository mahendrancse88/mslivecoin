<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Gyan_Mailchimp_Subscribe extends Widget_Base {

	public function get_name()           { return 'gyan_mc_subscribe'; }
	public function get_title()          { return esc_html__( 'MailChimp', 'gyan-elements' ); }
	public function get_icon()           { return 'gyan-el-icon eicon-mailchimp'; }
	public function get_categories()     { return [ 'gyan-advanced-addons' ]; }
	public function get_keywords()       { return [ 'gyan form', 'gyan subscribe form', 'gyan mailchimp', 'gyan email','newsletter' ]; }
	public function get_style_depends()  { return ['gyan-mailchimp-subscribe' ]; }
	public function get_script_depends() { return ['gyan-widgets']; }

	protected function register_controls() {

		$this->start_controls_section(
			'fields_content',
			[
				'label' => esc_html__( 'Fields', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'api_url',
			[
				'label' => '<a target="_blank" href="admin.php?page=gyan-addons-settings#gyan-addons-api-settings">Click Here</a> to change API key.',
				'type' => Controls_Manager::RAW_HTML,
				'separator' => 'after',
			]
		);
		$this->add_control(
			'email_placeholder',
			[
				'label' => esc_html__( 'Email placeholder text', 'gyan-elements' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter placeholder text', 'gyan-elements' ),
				'default' => 'Enter Email',
			]
		);
		$this->add_control(
			'fname',
			[
				'label' => esc_html__( 'First Name', 'gyan-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'separator' => 'before'
			]
		);
		$this->add_control(
			'fname_placeholder',
			[
				'label' => esc_html__( 'First name placeholder text', 'gyan-elements' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter placeholder text', 'gyan-elements' ),
				'condition' => [
					'fname!' => '',
				],
				'default' => 'Enter First Name',
			]
		);
		$this->add_control(
			'lname',
			[
				'label' => esc_html__( 'Last Name', 'gyan-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'separator' => 'before'
			]
		);
		$this->add_control(
			'lname_placeholder',
			[
				'label' => esc_html__( 'Last name placeholder text', 'gyan-elements' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter placeholder text', 'gyan-elements' ),
				'condition' => [
					'lname!' => '',
				],
				'default' => 'Enter Last Name',
			]
		);
		$this->add_control(
			'phone',
			[
				'label' => esc_html__( 'Phone Number', 'gyan-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'separator' => 'before'
			]
		);
		$this->add_control(
			'phone_placeholder',
			[
				'label' => esc_html__( 'Phone placeholder text', 'gyan-elements' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter placeholder text', 'gyan-elements' ),
				'condition' => [
					'phone!' => '',
				],
				'default' => 'Enter Phone Number',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'btn_content',
			[
				'label' => esc_html__( 'Submit Button', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		Gyan_Common_Data::button_content($this, '.gyan-subs-btn', 'Subscribe', 'btn', false);

        $this->add_control(
            'btn_fullwidth',
            [
                'label'                 => esc_html__( 'Full Width Button', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'no',
                'label_on'              => esc_html__( 'Yes', 'gyan-elements' ),
                'label_off'             => esc_html__( 'No', 'gyan-elements' ),
                'return_value'          => 'yes',
				'frontend_available'    => true,
            ]
        );
		$this->end_controls_section();

		$this->start_controls_section(
			'form_style',
			[
				'label' => esc_html__( 'Fields', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
		    'form_max_width',
		    [
		        'label'                 => esc_html__( 'Form Max Width', 'gyan-elements' ),
		        'type'                  => Controls_Manager::SLIDER,
		        'range'                 => [
		            'px'        => [
		                'min'   => 0,
		                'max'   => 2000,
		                'step'  => 1,
		            ],
		        ],
		        'size_units'            => [ 'px', '%' ],
		        'selectors'             => [
		            '{{WRAPPER}} .gyan-form .gyan-subs-form' => 'max-width: {{SIZE}}{{UNIT}}',
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'form_align',
		    [
		        'label'                 => esc_html__( 'Form Align', 'gyan-elements' ),
		        'type'                  => Controls_Manager::CHOOSE,
		        'options'               => [
		            'left' 	=> [
		                'title' 	=> esc_html__( 'Left', 'gyan-elements' ),
		                'icon' 		=> 'fa fa-align-left',
		            ],
		            'center' 		=> [
		                'title' 	=> esc_html__( 'Center', 'gyan-elements' ),
		                'icon' 		=> 'fa fa-align-center',
		            ],
		            'right' 		=> [
		                'title' 	=> esc_html__( 'Right', 'gyan-elements' ),
		                'icon' 		=> 'fa fa-align-right',
		            ],
		        ],
		        'default'               => 'left',
		    ]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'fields_style',
			[
				'label' => esc_html__( 'Fields', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'display',
			[
				'label' => esc_html__( 'Display', 'gyan-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'inline-block' => esc_html__( 'Inline', 'gyan-elements' ),
					'block' => esc_html__( 'Block', 'gyan-elements' ),
				],
				'default' => 'inline-block',
			]
		);

		$this->add_responsive_control(
		    'fields_align',
		    [
		        'label'                 => esc_html__( 'Text Align', 'gyan-elements' ),
		        'type'                  => Controls_Manager::CHOOSE,
		        'options'               => [
		            'left' 	=> [
		                'title' 	=> esc_html__( 'Left', 'gyan-elements' ),
		                'icon' 		=> 'fa fa-align-left',
		            ],
		            'center' 		=> [
		                'title' 	=> esc_html__( 'Center', 'gyan-elements' ),
		                'icon' 		=> 'fa fa-align-center',
		            ],
		            'right' 		=> [
		                'title' 	=> esc_html__( 'Right', 'gyan-elements' ),
		                'icon' 		=> 'fa fa-align-right',
		            ],
		        ],
		        'default'               => 'left',
		    ]
		);

		Gyan_Common_Data::input_fields_style( $this );
		$this->add_responsive_control(
			'fields_radius',
			[
				'label' => esc_html__( 'Radius', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .gyan-input-field' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'fields_padding',
			[
				'label' => esc_html__( 'Padding', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '10',
					'right' => '12',
					'bottom' => '10',
					'left' => '12',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-input-field' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'fields_margin',
			[
				'label' => esc_html__( 'Margin', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '20',
					'left' => '0',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-input-field' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_control(
			'error_message_col',
			[
				'label' => esc_html__( 'Error Message Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#676767',
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .gyan-subs-error' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'processing_message_col',
			[
				'label' => esc_html__( 'Processing Text Color', 'gyan-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#676767',
				'selectors' => [
					'{{WRAPPER}} .gyan-subs-process' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'fname_style',
			[
				'label' => esc_html__( 'First Name', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'fname!' => '',
				],
			]
		);
		Gyan_Common_Data::input_style( $this, '.gyan-input-fname', 'fname' );
		$this->end_controls_section();


		$this->start_controls_section(
			'lname_style',
			[
				'label' => esc_html__( 'Last Name', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'lname!' => '',
				],
			]
		);
		Gyan_Common_Data::input_style( $this, '.gyan-input-lname', 'lname' );
		$this->end_controls_section();


		$this->start_controls_section(
			'email_style',
			[
				'label' => esc_html__( 'Email', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		Gyan_Common_Data::input_style( $this, '.gyan-input-email' );
		$this->end_controls_section();


		$this->start_controls_section(
			'phone_style',
			[
				'label' => esc_html__( 'Phone', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'phone!' => '',
				],
			]
		);
		Gyan_Common_Data::input_style( $this, '.gyan-input-phone', 'phone' );
		$this->end_controls_section();


		$this->start_controls_section(
			'btn_style',
			[
				'label' => esc_html__( 'Submit Button', 'gyan-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'btn_icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'gyan-elements' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .gyan-subs-btn i,
					{{WRAPPER}} .gyan-subs-btn svg' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		Gyan_Common_Data::button_style( $this, '.gyan-subs-btn' );

		$this->add_responsive_control(
			'btn_width',
			[
				'label' => esc_html__( 'Width', 'gyan-elements' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range' => [
					'px' => [
						'max' => 1000,
					],
					'em' => [
						'max' => 50,
					],
				],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .gyan-subs-btn' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'btn_radius',
			[
				'label' => esc_html__( 'Radius', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .gyan-subs-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'btn_padding',
			[
				'label' => esc_html__( 'Padding', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'desktop_default' => [
					'top' => '13',
					'right' => '25',
					'bottom' => '13',
					'left' => '25',
					'isLinked' => false,
				],
				'mobile_default' => [
					'top' => '10',
					'right' => '15',
					'bottom' => '10',
					'left' => '15',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .gyan-subs-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'btn_margin',
			[
				'label' => esc_html__( 'Margin', 'gyan-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .gyan-subs-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'condition' => [
					'display!' => 'inline-block',
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .gyan-subs-form' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}


	protected function render() {
		$data = $this->get_settings_for_display();
		$display_class = ('block' == $data['display']) ? 'gyan-input-block' : '';

		$btn_icon_html = '';
		$btn_text = '';

		ob_start();
    	Icons_Manager::render_icon( $data['btn_icon'], [ 'aria-hidden' => 'true' ] );
		$btn_icon = ob_get_clean();

		$btn_v_align = ( '' == $data['btn_text'] ) ? 'gyan-subs-btn-icon-valign' : '';

		if ( '' != $btn_icon ) {
			$btn_icon_html = '<span class="gyan-subs-btn-icon ' . $btn_v_align . ' gyan-icon-' . $data['btn_icon_align'] . '">' . $btn_icon . '</span>';
		}

		if ( '' != $data['btn_text'] ) {
			$btn_text = '<span class="gyan-subs-btn-text">' . $data['btn_text'] . '</span>';
		}

		if ( $data['btn_icon_align'] == 'left' ) {
			$btn_final_content = $btn_icon_html.$btn_text;
		} else {
			$btn_final_content = $btn_text.$btn_icon_html;
		}

		?>
		<div class="gyan-form">
			<form class="gyan-subs-form gyan-subs-form-align-<?php echo $data['form_align']; ?> gyan-subs-fields-align-<?php echo $data['fields_align']; ?>"
			data-uid="<?php echo esc_attr( $this->get_id() ); ?>">
				<div class="gyan-subs-input">
					<?php if ( $data['fname'] ): ?>
						<input class="gyan-input-field gyan-input-fname <?php echo esc_attr( $display_class ); ?>" type="text" placeholder="<?php echo esc_attr( $data['fname_placeholder'] ); ?>"><?php
					endif;

					if ( $data['lname'] ):
						?><input class="gyan-input-field gyan-input-lname <?php echo esc_attr( $display_class ); ?>" type="text" placeholder="<?php echo esc_attr( $data['lname_placeholder'] ); ?>"><?php
					endif;

					?><input class="gyan-input-field gyan-input-email <?php echo esc_attr( $display_class ); ?>" type="email" placeholder="<?php echo esc_attr( $data['email_placeholder'] ); ?>"><?php

					if ( $data['phone'] ):
						?><input class="gyan-input-field gyan-input-phone <?php echo esc_attr( $display_class ); ?>" type="tel" placeholder="<?php echo esc_attr( $data['phone_placeholder'] ); ?>"><?php
					endif;

					?><button type="submit" class="gyan-button gyan-subs-btn gyan-ease-transition gyan-btn-fullwidth-<?php echo esc_attr( $data['btn_fullwidth'] ); ?>"><?php echo $btn_final_content; ?></button>
				</div>
				<p class="gyan-subs-success"></p>
				<p class="gyan-subs-error"></p>
				<p class="gyan-subs-process"><?php echo esc_html__( 'Processing...', 'gyan-elements' ); ?></p>

				<?php wp_nonce_field( 'gyan_mc_subscribe', 'gyan_mc_subscribe_nonce'.$this->get_id() ); ?>
			</form>
		</div>
		<div class="clear"></div>
		<?php
	}

	protected function _content_template() {}

}