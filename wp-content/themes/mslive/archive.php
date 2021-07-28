<?php
get_header();

$swm_blog_page_layout = swm_get_option( 'swm_blog_page_layout', 'layout-sidebar-right' );

$swm_blog_sidebar = 'blog-sidebar';
$swm_archive_pages_sidebar = swm_get_option('swm_archives_sidebar',$swm_blog_sidebar);

if ( !is_active_sidebar($swm_archive_pages_sidebar) ) {
	$swm_blog_page_layout = 'layout-full-width';
}
?>
	<div class="swm-container swm-<?php echo esc_attr($swm_blog_page_layout); ?> swm-post-sidebar-page" >
		<div class="swm-column swm-custom-two-third">
			<?php get_template_part('loop', 'post'); ?>
			<div class="clear"></div>
		</div>

	<?php get_sidebar(); 	?>

	</div>	<?php

get_footer();

?>