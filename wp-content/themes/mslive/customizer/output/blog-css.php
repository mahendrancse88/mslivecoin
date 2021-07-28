<?php if ( $swm_content_color ) { ?>
	.swm-post-meta,
	.swm-post-meta ul li a,
	.swm-post-meta ul li a:hover,
	a.swm-pp-link-title span,
	.swm-post-single-tags a { color:<?php echo sanitize_hex_color($swm_content_color); ?>; }
<?php } ?>

.swm-post-title h2,.swm-post-title h2 a,.swm-post-title h1 {

	<?php if ( $swm_post_title_color ) { ?>
		color:<?php echo sanitize_hex_color($swm_post_title_color); ?>;
	<?php } ?>

	letter-spacing:<?php echo floatval(swm_get_option( 'swm_post_title_letter_space', 0 )); ?>px;
	text-transform:<?php echo swm_get_option( 'swm_post_title_transform', 'none' ); ?>;
}

<?php if ( $swm_post_title_hover_color = swm_get_option( 'swm_post_title_hover_color' ) ) { ?>
	.swm-post-title h2 a:hover,
	.swm-post-meta ul li a:hover { color:<?php echo sanitize_hex_color($swm_post_title_hover_color); ?>; }
<?php } ?>

<?php
	$swm_post_title_size = swm_get_option( 'swm_post_title_size' );
	$swm_post_title_lineheight = swm_get_option( 'swm_post_title_lineheight' );

	if ( $swm_post_title_size || $swm_post_title_lineheight ) : ?>

	@media only screen and (min-width: 768px) {
		#swm-item-entries .swm-post-title h2,
		#swm-item-entries .swm-post-title h2 a,
		#swm-item-entries .swm-post-title h1 {

			<?php if ( $swm_post_title_size ) { ?>
				font-size:<?php echo floatval($swm_post_title_size); ?>px;
			<?php } ?>

			<?php if ( $swm_post_title_lineheight ) { ?>
				line-height:<?php echo floatval($swm_post_title_lineheight); ?>px;
			<?php } ?>
		}

	}

<?php endif; ?>

<?php if ( $swm_post_single_section_ttl_col ) { ?>
	.swm-about-author .swm-single-pg-titles a,
	a.swm-pp-link-title span.swm-heading-text,
	a.swm-about-author-name,
	.swm-related-link a,
	.comment-author a,
	.comment-author { color:<?php echo sanitize_hex_color($swm_post_single_section_ttl_col); ?>; }
<?php } ?>

h5.swm-single-pg-titles,
#comments h5.swm-single-pg-titles,
#respond h3.comment-reply-title {

	<?php if ( $swm_post_single_section_ttl_col ) { ?>
		color:<?php echo sanitize_hex_color($swm_post_single_section_ttl_col); ?>;
	<?php } ?>

	font-size:<?php echo floatval(swm_get_option( 'swm_post_single_section_ttl_size', 25 )); ?>px;
	letter-spacing:<?php echo floatval(swm_get_option( 'swm_post_single_section_ttl_letter_space', 0 )); ?>px;
	text-transform:<?php echo swm_get_option( 'swm_post_single_section_ttl_transform', 'none' ); ?>;
	line-height:<?php echo floatval(swm_get_option( 'swm_post_single_section_ttl_lineheight', 44 )); ?>px;
}

<?php if ( is_single() ) : ?>

	.swm-post-title h1  {
		letter-spacing:<?php echo floatval(swm_get_option( 'swm_single_post_title_letter_space', 0 )); ?>px;
		text-transform:<?php echo swm_get_option( 'swm_single_post_title_transform', 'none' ); ?>;
	}
	@media only screen and (min-width: 768px) {
		#swm-item-entries .swm-post-title h1 {
		font-size:<?php echo floatval(swm_get_option( 'swm_single_post_title_size',  30 )); ?>px;
		line-height:<?php echo floatval(swm_get_option( 'swm_single_post_title_lineheight', 40 )); ?>px; }
	}

	<?php if ( $swm_content_color ) { ?>
		#commentform input:not([type=submit]),
		#commentform textarea {  color:<?php echo sanitize_hex_color($swm_content_color); ?>; }
		#commentform input::placeholder,
		#commentform textarea::placeholder {color: <?php echo sanitize_hex_color($swm_content_color); ?>; }
		#commentform input:not([type=submit])::-webkit-input-placeholder  {color:<?php echo sanitize_hex_color($swm_content_color); ?>; }
		#commentform input:not([type=submit])::-moz-placeholder  {color:<?php echo sanitize_hex_color($swm_content_color); ?>; }
		#commentform input:not([type=submit])::-ms-placeholder  {color:<?php echo sanitize_hex_color($swm_content_color); ?>; }
		#commentform input:not([type=submit])::placeholder  {color:<?php echo sanitize_hex_color($swm_content_color); ?>; }
	<?php } ?>

<?php endif; ?>