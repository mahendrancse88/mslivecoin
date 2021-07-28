<?php
global $post;
$output = '';

$swm_get_related_posts_numbers = intval(swm_get_option('swm_single_related_posts_number','2' ));

$swm_get_related = swm_get_related_posts($post->ID, $swm_get_related_posts_numbers);

if ( $swm_get_related->have_posts() ) {  ?>

	<div class="swm-related-posts-wrap swm-content-wrap swm-single-related-posts-<?php echo intval(swm_get_option('swm_single_related_posts_column','2' )); ?>">
		<div class="swm-related-posts swm_content_border">
			<h5 class="swm-single-pg-titles"><span><?php echo esc_html__('Related Posts', 'bizix'); ?></span></h5>
			<ul>
				<?php
				while($swm_get_related->have_posts()): $swm_get_related->the_post();
					if (has_post_thumbnail()): ?>
						<li>
							<?php if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) { ?>
								<div class="swm_related_post_img">
									<a href="<?php echo get_permalink(); ?>"><?php echo get_the_post_thumbnail($post->ID, 'swm_image_size_related_posts' ); ?></a>
								</div>
							<?php } ?>
							<div class="swm-related-post-text">
								<span class="swm-related-link swm-heading-text"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>
								<span class="swm-related-date"> <?php echo get_the_date(); ?></span>
							</div>
						</li>
						<?php
					endif;
				endwhile; ?>
			</ul>
			<div class="clear"></div>
		</div>
	</div>

<?php } ?>

<?php wp_reset_postdata(); ?>