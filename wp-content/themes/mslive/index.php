<?php
get_header();
$swm_blog_page_layout = swm_get_option( 'swm_blog_page_layout', 'layout-sidebar-right' );
$swm_sticky_sidebar_on = (swm_get_option('swm_sticky_sidebar_on','on') == 'on') ? 'swm-sticky-sidebar' : '';

$swm_blog_sidebar = 'blog-sidebar';
$swm_archive_pages_sidebar = swm_get_option('swm_archives_sidebar',$swm_blog_sidebar);

if ( !is_active_sidebar($swm_archive_pages_sidebar) ) {
	$swm_blog_page_layout = 'layout-full-width';
}
?>
	<div class="swm-container swm-<?php echo $swm_blog_page_layout; ?> swm-post-sidebar-page" >
		<div class="swm-column swm-custom-two-third">
			<?php get_template_part('loop', 'post'); ?>
			<div class="clear"></div>
		</div>
	<?php
	if ( $swm_blog_page_layout != 'layout-full-width' && $swm_blog_page_layout != 'layout-full-screen' ) { ?>

		<aside class="swm-column sidebar swm-css-transition <?php echo $swm_sticky_sidebar_on; ?>" id="sidebar">
			<div class="theiaStickySidebar">
				<?php
				if ( is_active_sidebar('blog-sidebar') ) {
					dynamic_sidebar('blog-sidebar');
				}
				?>
				<div class="clear"></div>
			</div>
		</aside>
		<?php
	}
	?>
	</div>	<?php

get_footer();