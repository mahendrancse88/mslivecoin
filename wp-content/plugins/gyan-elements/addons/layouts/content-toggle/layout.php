<?php
// Wrapper.
if ( 'yes' === $settings['heading_layout'] ) {
	$this->add_render_attribute(
		'ctoggle_wrapper',
		'class',
		[
			'gyan-ctoggle-desktop-stack-yes',
			'gyan-ctoggle-wrapper',
		]
	);
} else {
	$this->add_render_attribute(
		'ctoggle_wrapper',
		'class',
		[
			'gyan-ctoggle-desktop-stack-no',
			'gyan-ctoggle-wrapper',
		]
	);
}
// Toggle Headings.
$this->add_render_attribute( 'gyan_content_toggle', 'class', 'gyan-ctoggle' );

// Toggle Headings inner.
$this->add_render_attribute( 'sec_1', 'class', 'gyan-sec-1' );
$this->add_render_attribute( 'sec_2', 'class', 'gyan-sec-2' );

// Inline Editing Heading 1.
$this->add_inline_editing_attributes( 'ctoggle_section_heading_1', 'basic' );
$this->add_render_attribute( 'ctoggle_section_heading_1', 'class', 'gyan-ctoggle-head-1' );

// Inline Editing Heading 2.
$this->add_inline_editing_attributes( 'ctoggle_section_heading_2', 'basic' );
$this->add_render_attribute( 'ctoggle_section_heading_2', 'class', 'gyan-ctoggle-head-2' );
$this->add_render_attribute( 'main_btn', 'class', 'gyan-main-btn' );
$this->add_render_attribute( 'main_btn', 'data-switch-type', $settings['ctoggle_select_switch'] );

// Toggle Sections.
$this->add_render_attribute( 'content_toggle_sections', 'class', 'gyan-ctoggle-sections' );
if ( 'content' === $settings['ctoggle_select_section_1'] ) {
	$this->add_render_attribute( 'ctoggle_section_1', 'class', 'gyan-ctoggle-content-1' );
}
if ( 'content' === $settings['ctoggle_select_section_2'] ) {
	$this->add_render_attribute( 'ctoggle_section_2', 'class', 'gyan-ctoggle-content-2' );
}
if ( 'on' === $settings['ctoggle_default_switch'] ) {
	$this->add_render_attribute( 'ctoggle_section_1', 'style', 'display: none;' );
} else {
	$this->add_render_attribute( 'ctoggle_section_2', 'style', 'display: none;' );
}
$this->add_render_attribute( 'ctoggle_section_1', 'class', 'gyan-ctoggle-section-1' );
$this->add_render_attribute( 'ctoggle_section_2', 'class', 'gyan-ctoggle-section-2' );

// Toggle Switch - Round 1.
$this->add_render_attribute( 'ctoggle_switch_label', 'class', 'gyan-ctoggle-switch-label' );
$this->add_render_attribute(
	'ctoggle_switch_round_1',
	'class',
	[
		'gyan-ctoggle-switch',
		'gyan-switch-round-1',
		'elementor-clickable',
	]
);
$this->add_render_attribute( 'ctoggle_switch_round_1', 'type', 'checkbox' );
$this->add_render_attribute(
	'ctoggle_span_round_1',
	'class',
	[
		'gyan-ctoggle-slider',
		'gyan-ctoggle-round',
		'elementor-clickable',
	]
);
// Toggle Switch - Round 2.
$this->add_render_attribute( 'ctoggle_div_round_2', 'class', 'gyan-content-toggle' );
$this->add_render_attribute(
	'ctoggle_input_round_2',
	'class',
	[
		'gyan-switch-round-2',
		'elementor-clickable',
	]
);
$this->add_render_attribute( 'ctoggle_input_round_2', 'type', 'checkbox' );
$this->add_render_attribute( 'ctoggle_input_round_2', 'name', 'group1' );
$this->add_render_attribute( 'ctoggle_input_round_2', 'id', 'toggle_' . $node_id );
$this->add_render_attribute( 'ctoggle_label_round_2', 'for', 'toggle_' . $node_id );
$this->add_render_attribute( 'ctoggle_label_round_2', 'class', 'elementor-clickable' );

// Toggle Switch - Rectangle.
$this->add_render_attribute( 'ctoggle_label_rect', 'class', 'gyan-ctoggle-switch-label' );
$this->add_render_attribute(
	'ctoggle_input_rect',
	'class',
	[
		'gyan-ctoggle-switch',
		'gyan-switch-rectangle',
		'elementor-clickable',
	]
);
$this->add_render_attribute( 'ctoggle_input_rect', 'type', 'checkbox' );
$this->add_render_attribute( 'ctoggle_span_rect', 'class', 'gyan-ctoggle-slider' );
$this->add_render_attribute( 'ctoggle_span_rect', 'class', 'elementor-clickable' );

?>

<div <?php echo $this->get_render_attribute_string( 'ctoggle_wrapper' ); ?>>
	<div <?php echo $this->get_render_attribute_string( 'gyan_content_toggle' ); ?>>
		<div <?php echo $this->get_render_attribute_string( 'sec_1' ); ?>>
			<<?php echo $settings['ctoggle_header_size']; ?> <?php echo $this->get_render_attribute_string( 'ctoggle_section_heading_1' ); ?> data-elementor-inline-editing-toolbar="basic"><?php echo $this->get_settings_for_display( 'ctoggle_section_heading_1' ); ?></<?php echo $settings['ctoggle_header_size']; ?>>
		</div>
		<div <?php echo $this->get_render_attribute_string( 'main_btn' ); ?>>

			<?php $switch_html = ''; ?>
			<?php $is_checked = ( 'on' === $settings['ctoggle_default_switch'] ) ? 'checked' : ''; ?>
			<?php
			switch ( $settings['ctoggle_select_switch'] ) {
				case 'round_1':
					$switch_html = '<label ' . $this->get_render_attribute_string( 'ctoggle_switch_label' ) . '><input ' . $this->get_render_attribute_string( 'ctoggle_switch_round_1' ) . ' ' . $is_checked . '><span ' . $this->get_render_attribute_string( 'ctoggle_span_round_1' ) . '></span></label>';
					break;

				case 'round_2':
					$switch_html = '<div ' . $this->get_render_attribute_string( 'ctoggle_div_round_2' ) . '><input ' . $this->get_render_attribute_string( 'ctoggle_input_round_2' ) . ' ' . $is_checked . '><label ' . $this->get_render_attribute_string( 'ctoggle_label_round_2' ) . '></label></div>';
					break;

				case 'rectangle':
					$switch_html = '<label ' . $this->get_render_attribute_string( 'ctoggle_label_rect' ) . '><input ' . $this->get_render_attribute_string( 'ctoggle_input_rect' ) . ' ' . $is_checked . '><span ' . $this->get_render_attribute_string( 'ctoggle_span_rect' ) . '></span></label>';
					break;
				default:
					break;
			}
			?>
			<?php echo $switch_html; ?>

		</div>
		<div <?php echo $this->get_render_attribute_string( 'sec_2' ); ?>>
			<<?php echo $settings['ctoggle_header_size']; ?> <?php echo $this->get_render_attribute_string( 'ctoggle_section_heading_2' ); ?> data-elementor-inline-editing-toolbar="basic"><?php echo $this->get_settings_for_display( 'ctoggle_section_heading_2' ); ?></<?php echo $settings['ctoggle_header_size']; ?>>
		</div>
	</div>
	<div <?php echo $this->get_render_attribute_string( 'content_toggle_sections' ); ?>>
		<div <?php echo $this->get_render_attribute_string( 'ctoggle_section_1' ); ?>>
			<?php echo do_shortcode( $this->get_modal_content( $settings, $node_id, 'ctoggle_select_section_1' ) ); ?>
		</div>
		<div <?php echo $this->get_render_attribute_string( 'ctoggle_section_2' ); ?>>
			<?php echo do_shortcode( $this->get_modal_content( $settings, $node_id, 'ctoggle_select_section_2' ) ); ?>
		</div>
	</div>
</div>