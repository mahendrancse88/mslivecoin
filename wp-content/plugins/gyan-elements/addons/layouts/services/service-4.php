<div class="gyan-services-front" style="background-image:url(<?php echo esc_url($imgBgUrl); ?>);">
	<div class="gyan-services-title-section"><?php echo $title_section_icon_html; ?><?php echo $title_section_title_html; ?></div>
</div>

<?php if ( 'yes' == $settings['show_overlay'] ) : ?>
	<div class="gyan-services-back" style="background-image:url(<?php echo esc_url($imgBgUrl); ?>);">
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
	</div>
<?php endif; ?>
