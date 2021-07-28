<?php get_header();
$swm_get_page_post_layout_type = swm_page_post_layout_type();

$swm_meta_get_all_sidebar_list = 'blog-sidebar';
$swm_meta_get_all_sidebar_list = get_post_meta( swm_get_queried_object_id(), 'swm_meta_all_sidebar_list', true );

if ( !is_active_sidebar($swm_meta_get_all_sidebar_list) ) {
	$swm_get_page_post_layout_type = 'layout-full-width';
}
?>
	<div class="swm-container swm-<?php echo $swm_get_page_post_layout_type; ?> swm-post-sidebar-page">
		<div class="clear"></div>
		<div class="swm-column swm-custom-two-third">
			<div class="swm_page_container <?php echo swm_get_option('swm_page_content_style','page_style_box'); ?>">

				<?php
				if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

					<div class="swm_page_content">

					<?php
					the_content();

					echo swm_content_pagination_menu();	?>

					<?php
					/* ----------------------------------------------------------------------------------
							Page Comments
					---------------------------------------------------------------------------------- */

					if (swm_get_option('swm_portfolio_comments_on','off') == 'on') {
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

	<?php
get_footer();