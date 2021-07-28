<?php
$swm_post_date_on     = swm_get_option('swm_date_on','on');
$swm_post_author_name = swm_get_option('swm_author_name_on','on');
$swm_post_cats        = swm_get_option('swm_cats_on','off');
$swm_post_views       = swm_get_option('swm_views_on','on');
$swm_post_likes       = swm_get_option('swm_likes_on','on');
$swm_post_comments    = swm_get_option('swm_comments_on','on');
$swm_excerpt_on       = swm_get_option('swm_excerpt_on','on');
$swm_get_post_format  = get_post_format() ? get_post_format() : 'standard';
?>
<div class="swm-post-content <?php
if ($swm_post_date_on == 'off' ) { echo ' swm-post-date-off'; }
?>">
	<?php get_template_part('parts/posts/post-formats/' . $swm_get_post_format); ?>

	<div class="swm-post-content-block">

		<div class="swm-post-title-section">

				<?php
				$swm_meta_cats = get_the_category();
				$swm_meta_cat_list = array(); ?>

				<?php if ( $swm_post_date_on == 'on' || $swm_post_author_name == 'on' || $swm_post_likes == 'on' || $swm_post_comments == 'on' || $swm_post_views == 'on' || $swm_post_cats == 'on' ) : ?>

					<div class="swm-post-meta">
						<ul>
							<?php if ( $swm_post_date_on == 'on' ) { ?>
								<li class="swm-post-date">
									<span class="swm-postmeta-text"><i class="far fa-clock-o"></i><?php echo get_the_date(); ?></span>
									<span class="swm-post-date-line"></span>
									<div class="clear"></div>
								</li>
							<?php } ?>

							<?php if ( $swm_post_author_name == 'on' ) { ?>
								<li>
									<span class="swm-postmeta-text"><i class="far fa-user"></i><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) )); ?>"><?php echo esc_html(get_the_author()); ?></a></span>
								</li>
							<?php } ?>

							<?php if ( $swm_post_comments == 'on' ) { ?>
								<li>
									<span class="swm-postmeta-text swm-post-comment"><i class="far fa-comments"></i><a href="<?php echo esc_url(get_comments_link()); ?>"><?php echo swm_get_comments_number(); ?></a></span>
								</li>
							<?php } ?>

							<?php if ( $swm_post_views == 'on' && GYAN_ELEMENTS_IS_ACTIVE ) { ?>
								<li>
									<span class="swm-postmeta-text swm-post-view"><i class="far fa-eye"></i><?php
										echo gyan_get_post_views(get_the_ID());
										echo esc_html__( ' Views', 'bizix' ); ?></span>
								</li>
							<?php } ?>

							<?php if ( $swm_post_likes == 'on' && GYAN_ELEMENTS_IS_ACTIVE ) { ?>
								<li class="swm-post-like">
									<?php echo gyan_love();
									echo esc_html__( ' Likes', 'bizix' );?>
								</li>
							<?php } ?>

							<?php if ( $swm_post_cats == 'on' ) { ?>
								<li>
									<i class="far fa-folder-open"></i><?php
									if($swm_meta_cats){
										foreach($swm_meta_cats as $category) {
											$swm_meta_cat_list[] = '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( esc_html__( 'View all posts in %s', 'bizix' ), $category->name ) ) . '" >'.esc_html($category->cat_name).'</a>';
										}
									 	echo implode(', ', $swm_meta_cat_list);
									} ?>
								</li>
							<?php } ?>
						</ul>
						<div class="clear"></div>
					</div>
				<?php endif; ?>

				<div class="swm-post-title-content">

					<?php
					if ( get_the_title() ) {
						echo '<div class="swm-post-title"><h2><a href="' . esc_url( get_permalink() ) . '" >' . wp_kses( get_the_title(),swm_kses_allowed_text() ) . '</a></h2>';
					}

					if ( $swm_excerpt_on == 'on' ) : ?>

						<div class="swm-post-list-excerpt">
							<?php
							if ( $swm_excerpt_on == 'on' ) { ?>

								<div class="swm-post-summary">
									<div class="swm-post-summary-text"> <?php

										if ( swm_get_option('swm_excerpt_on','on') == 'on' ) {
											if ( swm_get_option('swm_excerpt_length','50') != 0 ) {
												echo get_the_excerpt();
											}
										}

									?><div class="clear"></div>
								</div>
						</div>
						<div class="clear"></div> <?php

					} ?>
				</div>

			<?php endif; ?>

				</div>

				<?php
				$swm_post_button_text = swm_get_option('swm_post_button_text','Read More');
				$swm_post_button_text = swm_translate_theme_mod( 'swm_post_button_text', $swm_post_button_text );

				if ( swm_get_option('swm_post_button_text','Read More') != '' ) { ?>
					<div class="swm-post-button"><a class="swm-button" href="<?php echo esc_url( get_permalink() ); ?>" ><?php echo wp_kses( $swm_post_button_text,swm_kses_allowed_text() ); ?></a></div>
				<?php } ?>

		</div>

		<div class="clear"></div>

	</div>	<!-- .swm-post-content-block -->

</div> <!-- .swm-post-content -->

<div class="clear"></div>