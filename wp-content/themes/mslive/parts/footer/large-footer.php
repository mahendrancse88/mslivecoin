<div class="swm-container">
	<?php
	if ( is_active_sidebar('swm-footer-1') || is_active_sidebar('swm-footer-2') || is_active_sidebar('swm-footer-3') || is_active_sidebar('swm-footer-4') || is_active_sidebar('swm-footer-5') ) {
        ?>
		<div class="swm-large-footer <?php echo swm_get_option( 'swm_widget_footer_column','col-4' ); ?>">

			<?php get_template_part('parts/footer/' . swm_get_option( 'swm_widget_footer_column','col-4' )); ?>

			<div class="clear"></div>
		</div>
       <?php
	}
	?>
	<div class="clear"></div>
</div>
<div class="clear"></div>