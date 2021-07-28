<?php
if ( post_password_required() ) { ?>
	<div id="comments" class="swm_comments swm-content-wrap">
		<p class="swm-nocomments">
			<?php echo esc_html__( 'This post is password protected. Enter the password to view comments.', 'bizix' ); ?>
		</p>
	</div>
	<?php
	return;
} ?>

<!-- Blog Responses Start -->

<?php if ( have_comments() ) : ?>

		<div class="swm-content-wrap">
			<div id="comments" class="swm_comments">

				<h5 class="swm-single-pg-titles"><span><?php comments_number(esc_html__( 'No Comments', 'bizix' ), esc_html__( 'One Comment', 'bizix' ), esc_html__( '% Comments', 'bizix' ) );?></span></h5>
				<?php
				/* -----------------------------
					Comments Listing
				----------------------------- */ ?>

				<section id="comment-wrap">
					<ol class="commentlist">
						<?php wp_list_comments( array( 'callback' => 'swm_comment_listing' ) );	?>
					</ol>
					<div class="clear"></div>
				</section>

				<?php
				/* -----------------------------
					Comments Pagination
				----------------------------- */ ?>

				<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>

					<div class="swm-pagination swm-comments-pagination">
						<?php paginate_comments_links(array('prev_text' => '<i class="fas fa-chevron-left"></i>', 'next_text' => '<i class="fas fa-chevron-right"></i>')); ?>
						<div class="clear"></div>
					</div>

				<?php endif; ?>

			</div><!-- #comments -->

		</div>
	<?php
	else : // this is displayed if there are no comments so far

		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
			<div id="comments"  class="swm_border_box swm-content-wrap">
				<p class="swm-nocomments">
					<?php echo esc_html__( 'Comments are closed.', 'bizix' ); ?>
				</p>
			</div>
			<?php
		endif;

	endif; ?>
<!-- Blog Responses End -->

<div class="clear"></div>

<?php

/* ----------------------------------------------------------------------------------
	Comments Form
---------------------------------------------------------------------------------- */ ?>


<?php if ( comments_open() ) : ?>

		<?php
		comment_form( array(
			'label_submit' => esc_html__( 'Post Comment', 'bizix' ),
			'title_reply' => '<span>' . esc_html__( 'Leave a Comment', 'bizix' ) . '</span>',
			'cancel_reply_link' => esc_html__( 'Cancel Comment' , 'bizix' ),
			'title_reply_to' => '<span>' . esc_html__( 'Leave a Comment' , 'bizix' ) . '</span>'
			)
		);
		?>

<?php endif;?>
<div class="clear"></div>
