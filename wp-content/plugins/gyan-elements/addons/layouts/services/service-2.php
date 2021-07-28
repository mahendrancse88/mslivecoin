<div class="gyan-services-all-content">
	<div class="gyan-services-image">
		<?php echo $image_html; ?>
	</div>
	<?php if ( 'yes' == $settings['show_overlay'] ) : ?>
		<div class="gyan-services-overlay gyan-ease-transition">
			<?php echo $description_html; ?>
			<?php echo $overlay_button_html ?>
		</div>
	<?php endif; ?>
</div>
<div class="gyan-services-title-section gyan-ease-transition">
	<?php echo $title_section_icon_html; ?>
	<?php echo $title_section_title_html; ?>
</div>