<?php get_header();

$swm_get_page_post_layout_type = swm_page_post_layout_type();
?>
	<div class="swm-container swm-<?php echo $swm_get_page_post_layout_type; ?> swm-post-sidebar-page">
		<div class="swm-column swm-custom-two-third">
			<div class="swm_page_container <?php echo swm_get_option('swm_page_content_style','page_style_box'); ?>">

				<?php
				if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

					<div class="swm_page_content">

						<?php
						the_content();

						echo swm_content_pagination_menu();

						if (swm_get_option('swm_page_comments_on','on') == 'on') {
							comments_template('', true);
						}
						?>

						<div class="clear"></div>
					</div>

				<?php endwhile; ?>

			</div>
			<div class="clear"></div>

		</div>

		<?php get_sidebar(); ?>

		<div class="clear"></div>
	</div>

<?php get_footer(); ?>