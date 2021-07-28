<?php
$swm_page_post_layout_type = swm_page_post_layout_type();

if ( $swm_page_post_layout_type == 'layout-full-width' ) { return; }
if ( $swm_page_post_layout_type == 'layout-full-screen' ) { return; }
$swm_sticky_sidebar_on = (swm_get_option('swm_sticky_sidebar_on','on') == 'on') ? 'swm-sticky-sidebar' : '';
?>
<aside class="swm-column sidebar swm-css-transition <?php echo $swm_sticky_sidebar_on; ?>" id="sidebar">
	<div class="theiaStickySidebar">
		<?php
			$swm_blog_sidebar = 'blog-sidebar';
			$swm_archive_pages_sidebar = swm_get_option('swm_archives_sidebar',$swm_blog_sidebar);

			$swm_meta_get_all_sidebar_list = 'blog-sidebar';
			$swm_meta_get_all_sidebar_list = get_post_meta( swm_get_queried_object_id(), 'swm_meta_all_sidebar_list', true );

			$swm_search_sidebar = 'search-sidebar';

			if ( is_archive() && is_active_sidebar($swm_archive_pages_sidebar) ){
				dynamic_sidebar($swm_archive_pages_sidebar);
			} elseif ( is_search() && is_active_sidebar($swm_search_sidebar) ){
				dynamic_sidebar($swm_search_sidebar);
			} else {
				dynamic_sidebar($swm_meta_get_all_sidebar_list);
			}
		?>
		<div class="clear"></div>
	</div>
</aside>