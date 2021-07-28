<div class="gyan-services-all-content">
	<div class="gyan-services-image">
		<?php echo $image_html; ?>
	</div>
	<div class="gyan-services-title-section gyan-ease-transition">
		<?php echo $title_section_icon_html; ?>
		<?php echo $title_section_title_html; ?>
	</div>
	<?php if ( 'yes' == $settings['show_overlay'] ) : ?>
		<div class="gyan-services-overlay gyan-ease-transition">
			<?php echo $overlay_icon_html; ?>
			<?php
			if ( 'yes' == $settings['show_overlay_title'] ) {
				echo $overlay_title_html;
			}
			?>
			<?php echo $line_separator_html; ?>
			<?php echo $description_html; ?>
			<?php echo $overlay_button_html ?>
		</div>
	<?php endif; ?>
</div>