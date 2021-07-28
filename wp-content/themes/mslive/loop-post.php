<div class="swm-posts-list">
	<div id="swm-item-entries" class="swm-row">
		<?php

			while ( have_posts() ) : the_post();

				$swm_get_post_format = get_post_format() ? get_post_format() : 'standard';
				$swm_post_classes 	 = array();
				$swm_post_classes[]  = 'post-entry swm-blog-post';

				if (is_sticky()) { $swm_post_classes[] = 'post-sticky'; }

				?>
				<article class="<?php echo implode(" ", get_post_class($swm_post_classes)); ?>" >
					<div class="swm-column-gap">
						<div>
							<?php get_template_part('parts/posts/post-list'); ?>
						</div>
					</div>
					<div class="clear"></div>
				</article>

			<?php endwhile; ?>

		<div class="clear"></div>
	</div>
	<div class="clear"></div>

	<?php echo swm_pagination('standard'); ?>
	<?php wp_reset_postdata(); ?>

</div>