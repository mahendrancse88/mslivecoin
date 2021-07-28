<?php get_header(); $swm_blog_page_layout = swm_get_option( 'swm_blog_page_layout', 'layout-sidebar-right' );
	if (!is_active_sidebar('search-sidebar') ) {
		$swm_blog_page_layout = 'layout-full-width';
	}
?>
	<div class="swm-container swm-<?php echo esc_attr($swm_blog_page_layout); ?> swm-post-sidebar-page" >

		<div class="swm-column swm-custom-two-third">
			<div class="swm_page_container <?php echo swm_get_option('swm_page_content_style','page_style_box'); ?>">
				<div class="swm_page_content">

					<?php
						global $wp_query;
						$swm_search_term = trim(get_search_query());
						$swm_search_result = '';
						$swm_no_search_result = '';
						$swm_get_search_query = '<span class="swm-search-p-query-text swm-primary-skin-col">'.esc_html( get_search_query() ).'</span>';

						$swm_search_result = $wp_query->found_posts;

					if (have_posts()) :
						 ?>

						<h2 class="swm-search-pg-subtitle <?php echo $swm_no_search_result; ?>"><?php
							echo intval($swm_search_result) . ' ' .sprintf( esc_html__( '- Search Results For %1$s','bizix' ), $swm_get_search_query ); ?>
						</h2>

						<div class="search_pg_box <?php
							if ( $swm_search_result == 1 ) {
								echo 'swm_search_result_one';
							}
							?>">

							<ul class="swm-search-list">

								<?php while (have_posts()) : the_post(); ?>
								<li>

									<?php if( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) {	 ?>
										<div class="swm-search-featured-img"><a href="<?php esc_url( the_permalink() ); ?>" title="<?php esc_attr( the_title() ); ?>"><?php echo get_the_post_thumbnail(get_the_ID(), 'thumbnail' ); ?></a></div>
									<?php } ?>

									<div class="swm-search-page-text">
										<h5><a href="<?php esc_url( the_permalink() ); ?>" title="<?php esc_attr( the_title() ); ?>"><?php esc_html(the_title()); ?></a></h5>

										<div class="swm-search-meta">
								            <ul>
												<li class="swm-search-author"><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) )); ?>"><?php echo esc_html(get_the_author()); ?></a></li>
												<li class="swm-search-date"><?php echo get_the_date(); ?></li>
												<li class="swm-search-comment"><a href="<?php echo esc_url(get_comments_link()); ?>"><?php swm_get_comments_number(); ?></a></li>
											</ul>
								        </div>

										<?php
										$swm_old_content = '';

										if (has_excerpt()) {
										    $swm_old_content = get_the_excerpt();
										} else {
											ob_start();
											the_content();
											$swm_old_content = ob_get_clean();
										}

										$swm_new_content = wp_strip_all_tags($swm_old_content);
										if ( $swm_new_content ) { ?>
											<div class="swm-search-excerpt"><?php
												echo substr($swm_new_content,0,250).'...'; ?>
											</div><?php
										}
										?>


									</div>

									<div class="clear"></div>
								</li>

									<?php

								endwhile;

								?>
							</ul>
							<div class="clear"></div>

						</div>
						<div class="clear"></div>
					<?php

					else: ?>
						<div class="swm-page-box-content swm-search-page-no-result-text">

							<h2 class="swm-search-pg-subtitle <?php echo $swm_no_search_result; ?>"><?php
								echo intval($swm_search_result) . ' ' .sprintf( esc_html__( '- Search Results For %1$s','bizix' ), $swm_get_search_query ); ?>
							</h2>

							<?php get_search_form(); ?>

							<p><?php
								echo esc_html__( "If you're not happy with the results, please do another search.","bizix" ) ?>
							</p>

							</div><?php

					endif;

					wp_reset_postdata();

					if ( $swm_search_term != '' ) {
						swm_standard_pagination($wp_query->max_num_pages);
					}

					?>
					<?php wp_reset_postdata(); ?>

					<div class="clear"></div>
				</div>
			</div>
		</div>

		<?php
		if (is_active_sidebar('search-sidebar') ) {
			get_sidebar();
		}
		?>

	</div>	<?php

get_footer();

?>