		<div class="clear"></div>
	</div> <!-- .swm-main-container -->
	<?php
	if ( swm_customizer_metabox_onoff('swm_widget_footer_on','swm_meta_widget_footer_on','on','default') == 'on' || swm_customizer_metabox_onoff('swm_contact_footer_on','swm_meta_contact_footer_on','off','default') == 'on' || swm_customizer_metabox_onoff('swm_small_footer_on','swm_meta_small_footer_on','on','default') == 'on' ) {
		?>
		<footer class="footer swm-css-transition" id="footer">
				<?php if ( swm_customizer_metabox_onoff('swm_widget_footer_on','swm_meta_widget_footer_on','on','default') == 'on' ) {
					get_template_part('parts/footer/large-footer');
				}

				if ( swm_customizer_metabox_onoff('swm_contact_footer_on','swm_meta_contact_footer_on','off','default') == 'on' ) {
					get_template_part('parts/footer/contact-footer');
				}

				if ( swm_customizer_metabox_onoff('swm_small_footer_on','swm_meta_small_footer_on','on','default') == 'on' ) {
					 get_template_part('parts/footer/small-footer');
				}
				?>
		</footer>

		<?php
	} ?>

		</div><!-- #wrap -->
	</div><!-- #outer-wrap -->

	<?php
	if ( swm_get_option( 'swm_bottom_go_top_scroll_btn_on','off' ) == 'on') {
		echo '<a class="swm-go-top-scroll-btn"><i class="fas fa-angle-up"></i></a>';
	}

	if ( is_single() && comments_open() ) { wp_enqueue_script( 'comment-reply' ); }
	wp_footer();
	?>
</div>  <!-- end #swm-page -->
</body>
</html>