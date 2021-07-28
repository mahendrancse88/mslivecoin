
/* Content Color ------------------------------------------ */

.swm-site-content a {
	color:<?php echo sanitize_hex_color($swm_content_link_color); ?>;
}

<?php if ( $swm_content_color ) { ?>
	.swm-site-content,
	.swm-content-color,
	.swm-content-color a,
	.swm-related-link a { color:<?php echo sanitize_hex_color($swm_content_color); ?> }
<?php } ?>

.swm-site-content a:hover,
ul.swm-search-list li h4 a:hover,
.swm-content-color a:hover,
.swm-related-link a:hover {
	color:<?php echo sanitize_hex_color($swm_content_link_hover_color); ?>;
}

/* Primary Skin ------------------------------------------ */

a.swm-button span:hover,
button.swm-button:hover,
.swm-site-content a.button:hover,
.swm-site-content a.button.button-alt,
.swm-site-content a.button.button-alt:hover,
.swm-sidepanel .tagcloud a,
.sidebar .tagcloud a,
.sidebar .tagcloud a:hover,
.sidebar a.swm-button-hover-white,
a.swm-button:hover,
.swm-post-single-tags a:hover,
blockquote:before,
a.comment-reply-link:hover,
.sidebar #wp-calendar caption,
.swm-sidepanel #wp-calendar caption,
ul.swm-post-author-icon li:hover a,
.swm-pagination .page-numbers.current,
.swm-pagination-menu>span,
.swm-pagination-menu>a:hover,
.swm-next-prev-pagination a:hover,
.swm-pagination a.page-numbers:hover,
span.post-page-numbers.current,
.swm-pagination-menu a:hover,
.swm-site-content a.post-page-numbers:hover,
.gyan-pagination-menu>a:hover,
.gyan-next-prev-pagination a:hover,
.gyan-pagination .page-numbers.current,
.gyan-pagination-menu>span,
.gyan-pagination a.page-numbers:hover,
.gyan-pagination-menu a:hover,
.wp-block-pullquote::before,
.wp-block-button a,
.is-style-outline .wp-block-button__link:hover,
.wp-block-file a.wp-block-file__button,
.footer #wp-calendar caption {
	background:<?php echo sanitize_hex_color($swm_skin_color); ?>;
	color:<?php echo sanitize_hex_color($swm_skin_text_color); ?>;  }

.swm-primary-skin-col,
.sidebar .gyan-posts-slider-widget .owl-next,
.sidebar .gyan-posts-slider-widget .owl-prev,
.sidebar .gyan-posts-slider-widget-meta-cat a,
.is-style-outline .wp-block-button__link,
.has-drop-cap:not(:focus)::first-letter,
.swm-site-content table tr th a,
#commentform p.logged-in-as a,
a.swm-pp-link-title span.swm-heading-text:hover,
.comment-form-author:before,.comment-form-email:before,.comment-form-comment:before,
.swm-post-meta i,
a.swm-pp-link-title span:hover { color:<?php echo sanitize_hex_color($swm_skin_color); ?>; }

.swm-post-date-line:before,
.swm-mobi-nav-close   {
	background:<?php echo sanitize_hex_color($swm_skin_color); ?>;
}

.swm-next-prev-box:hover a .swm-pp-arrow i { color:<?php echo sanitize_hex_color($swm_skin_text_color); ?>; }

.swm-mobi-nav-close:before,
.swm-mobi-nav-close:after { background:<?php echo sanitize_hex_color($swm_skin_text_color); ?>; }

input[type=text]:focus,
input[type="password"]:focus,
input[type="email"]:focus,
input[type="number"]:focus,
input[type="url"]:focus,
input[type="tel"]:focus,
input[type="search"]:focus,
textarea:focus,
.comment-form textarea:focus,
.post-password-form input[type=password]:focus,
#commentform input[type="text"]:focus,
input[type="password"]:focus,
#commentform textarea:focus,
.widget_search .swm-search-form input[type="text"]:focus,
ul.swm-post-author-icon li:hover a,
.swm-post-single-tags a:hover,
.sidebar .gyan-posts-slider-widget .owl-dot.active,
.swm-sidepanel .gyan-posts-slider-widget .owl-dot.active,
.sticky .swm-post-content-block,
blockquote,
.swm-site-content blockquote,
.is-style-outline .wp-block-button__link,
.is-style-outline .wp-block-button__link:hover { border-color:<?php echo sanitize_hex_color($swm_skin_color); ?>; }

/* Secondary Skin ------------------------------------------ */

a.swm-button span,
button.swm-button,
.swm-site-content a.button,
.swm-site-content a.button.button-alt2,
.swm-site-content a.button.button-alt2:hover,
button.button,
.swm-next-prev-box:hover .swm-pp-arrow,
a.swm-button,
.swm-post-meta-date,
.sidebar table#wp-calendar thead th,
.swm-sidepanel #wp-calendar thead,
.swm-sidepanel .tagcloud a:hover,
.sidebar .tagcloud a:hover,
.wp-block-pullquote.is-style-solid-color:not(.has-background-color),
.wp-block-button a:hover,
.wp-block-file a.wp-block-file__button:hover {
	background:<?php echo sanitize_hex_color($swm_secondary_skin_color); ?>;
	color:<?php echo sanitize_hex_color($swm_secondary_skin_text_color); ?>;
}

.swm-pp-view-all a i,
.comment-date i,
.swm-site-content h5 a:hover,
.swm-search-page-readmore a:hover,
.sidebar .widget_search .swm-search-form button.swm-search-button,
.swm-sidepanel .widget_search .swm-search-form button.swm-search-button,
.swm-next-prev-box a .swm-pp-arrow i,
.swm-pp-arrow i,
.swm-pp-link-title i.fa,
a.comment-edit-link,
.sidebar a.swm-button-hover-white:hover,
.sidebar .gyan-posts-slider-widget .owl-next:hover,
.sidebar .gyan-posts-slider-widget .owl-prev:hover,
.sidebar .gyan-posts-slider-widget-meta-cat a:hover,
#commentform p.logged-in-as a:hover {
	color:<?php echo sanitize_hex_color($swm_secondary_skin_color); ?>;
}

<?php if ( is_single() || is_author() ) { ?>
	.swm-pp-view-all a span:hover,
<?php } ?>
.gyan-recent-post-style-two .gyan-recent-post-meta ul li:after,
blockquote:after {
	background:<?php echo sanitize_hex_color($swm_secondary_skin_color); ?>;
}

.sidebar a.swm-button-hover-white:hover {
	background:<?php echo sanitize_hex_color($swm_skin_text_color); ?>;
}

<?php if ( is_single() || is_author() ) { ?>
	.swm-about-author-left,
	.swm-about-author-left a,
	.swm-about-author-left a:hover,
	.swm-pp-view-all a span:hover i,
<?php } ?>
.swm-secondary-skin-text {
	color:<?php echo sanitize_hex_color($swm_secondary_skin_text_color); ?>;
}

/* Highlight ------------------------------------------ */

::selection{background:<?php echo sanitize_hex_color($swm_highlight_bg); ?>; color:<?php echo sanitize_hex_color($swm_highlight_color); ?>;}
::-moz-selection{background:<?php echo sanitize_hex_color($swm_highlight_bg); ?>; color:<?php echo sanitize_hex_color($swm_highlight_color); ?>;}

/* Button ------------------------------------------ */

button,
html input[type="button"],
input[type=button],
input[type="reset"],
input[type="submit"],
a.button,
button.button,
.button,
.gyan-button,
a.gyan-button,
input.gyan-button,
button.gyan-button,
input.gyan-button[type="submit"],
a.swm-button {
background:<?php echo sanitize_hex_color($swm_skin_color); ?>;
	color:<?php echo sanitize_hex_color($swm_skin_text_color); ?>;  }

.swm-site-content button:hover,
html input[type="button"]:hover,
input[type=button]:hover,
input[type="reset"]:hover,
input[type="submit"]:hover,
a.button:hover,
button.button:hover,
.button:hover,
.gyan-button:hover,
a.gyan-button:hover,
input.gyan-button:hover,
button.gyan-button:hover,
input.gyan-button[type="submit"]:hover,
a.swm-button:hover {
background:<?php echo sanitize_hex_color($swm_secondary_skin_color); ?>;
	color:<?php echo sanitize_hex_color($swm_secondary_skin_text_color); ?>;  }
