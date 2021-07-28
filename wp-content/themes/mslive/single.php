<?php get_header();

$swm_get_page_post_layout_type = swm_page_post_layout_type();
$swm_meta_get_all_sidebar_list = 'blog-sidebar';
$swm_meta_get_all_sidebar_list = get_post_meta( swm_get_queried_object_id(), 'swm_meta_all_sidebar_list', true );

if ( !is_active_sidebar($swm_meta_get_all_sidebar_list) ) {
	$swm_get_page_post_layout_type = 'layout-full-width';
}
?>
	<div class="swm-container swm-<?php echo $swm_get_page_post_layout_type; ?> swm-post-sidebar-page" >
		<div class="swm-column swm-custom-two-third">
			<section>
				<div id="swm-item-entries" class="swm-row">

					<?php
					if (have_posts()) :
						while (have_posts()) : the_post();

							$swm_get_post_format = get_post_format() ? get_post_format() : 'standard';
							$swm_post_single_classes = array();

							$swm_post_single_classes[] = 'post-entry swm-blog-post';

							if (is_sticky()) { $swm_post_single_classes[] = 'post-sticky'; }

							if ( has_post_thumbnail() || $swm_get_post_format == 'video' || $swm_get_post_format == 'audio' ) {
								$swm_post_has_thumb = '';
							} else {
								$swm_post_has_thumb = 'swm_pf_no_thumb';
							}
							?>
							<article class="<?php echo implode(" ", get_post_class($swm_post_single_classes)); ?>" >
								<div class="swm-column-gap">
									<div class="<?php echo $swm_post_has_thumb; ?>">
										<?php get_template_part('parts/posts/post-single'); ?>
									</div>
								</div>
								<div class="clear"></div>

							</article>

							<?php

						endwhile;
					endif; ?>

				</div>
			</section>

			<?php
			$swm_post_tags = swm_get_option('swm_single_tags_on','on');

			if ( $swm_post_tags == 'on' && get_the_tag_list() != '' ) { ?>

				<h5 class="swm-single-tag-title"><span><?php echo esc_html__('Tags:', 'bizix'); ?></span></h5>

				<div class="swm-post-single-tags swm-post-cat-tag-block left">
					<?php echo ucwords(get_the_tag_list()); ?>
				</div>
				<div class="clear"></div>

			<?php }

			if ( $swm_post_tags == 'on' && get_the_tag_list() != '' && swm_get_option('swm_single_pagination_on','on') == 'on' ) { ?>
				<div class="swm-tags-pagination-border"></div>
			<?php
			}

			if ( swm_get_option('swm_single_pagination_on','on') == 'on' ) {

				// pagination
				$swm_view_all_url = swm_get_option( 'swm_blog_page_url' );
				$swm_prev_post = get_previous_post();
				$swm_next_post = get_next_post();

				$swm_prev_post_link    = !empty(get_previous_post()) ? get_permalink( $swm_prev_post->ID ) : '';
				$swm_prev_single_title = !empty(get_previous_post()) ? get_the_title( $swm_prev_post->ID ) : '';
				$swm_next_post_link    = !empty(get_next_post()) ? get_permalink( $swm_next_post->ID ) : '';
				$swm_next_single_title = !empty(get_next_post()) ? get_the_title( $swm_next_post->ID ) : '';

				$swm_prev_post_thumb = !empty(get_previous_post()) ? get_the_post_thumbnail_url( $swm_prev_post->ID,'swm_image_size_post_tiny' ) : '';
				$swm_next_post_thumb = !empty(get_next_post()) ? get_the_post_thumbnail_url( $swm_next_post->ID,'swm_image_size_post_tiny' ) : '';

				echo swm_post_single_next_prev_pagination($swm_prev_post_link,$swm_next_post_link,$swm_prev_post_thumb,$swm_next_post_thumb,$swm_prev_single_title,$swm_next_single_title,$swm_view_all_url);
			}

			if ( swm_get_option('swm_single_authorbox_on','off') == 'off' && swm_get_option('swm_single_pagination_on','on') == 'on' ) { ?>
				<div class="swm-tags-pagination-border swm-tags-pagination-border-bot"></div>
			<?php
			}

			if ( swm_get_option('swm_single_authorbox_on','off') == 'on' ) {
				get_template_part('parts/posts/post-author');
			}
			?>

			<div class="swm-single-section">
				<?php

				wp_reset_postdata();

				if ( swm_get_option('swm_single_related_posts_on','on') == 'on' ) {
					get_template_part( 'parts/related-posts');
				}
				if ( swm_get_option('swm_single_comments_section_on','on') == 'on' ) {
					comments_template('', true);
				}

				wp_reset_postdata();
				?>
			</div>

			<div class="clear"></div>
		</div>

		<?php get_sidebar(); ?>

	</div>

<?php get_footer(); ?>