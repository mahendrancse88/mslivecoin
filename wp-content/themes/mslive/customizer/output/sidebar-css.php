
<?php if ( $swm_sidebar_text_col = swm_get_option( 'swm_sidebar_text_col' ) ) { ?>

	.sidebar,
	.widget-search .swm-search-form button.swm-search-button,
	.sidebar .widget_product_search #swm_product_search_form button.swm-search-button,
	#widget_search_form input[type="text"],
	.sidebar .gyan_recent_posts_tiny_title a,
	.sidebar select, .swm-sidepanel select,
	.widget_search .swm-search-form input[type="text"],
	.swm-about-author, .swm-about-author a { color:<?php echo sanitize_hex_color($swm_sidebar_text_col); ?>; }

<?php } ?>

.swm-site-content .sidebar .swm-sidebar-ttl h3 span,
.swm-site-content .swm-archives-content h4,
.swm-about-author-title-subtitle a {
	<?php if ( swm_get_option( 'swm_sidebar_title_color' ) ) { ?>
		color:<?php echo sanitize_hex_color($swm_sidebar_title_color); ?>;
	<?php } ?>
	font-size: <?php echo intval(swm_get_option( 'swm_sidebar_title_size', 19 )); ?>px;
	letter-spacing: <?php echo intval(swm_get_option( 'swm_sidebar_title_letter_space', 0 )); ?>px;
	text-transform: <?php echo swm_get_option( 'swm_sidebar_title_transform', 'none' ); ?>;
}
<?php if ( swm_get_option( 'swm_sidebar_title_color' ) ) { ?>
	.sidebar .gyan-posts-slider-widget-title a { color:#032e42; }
<?php } ?>

<?php if ( $swm_sidebar_link = swm_get_option( 'swm_sidebar_link',"#676767" ) ) { ?>
	.sidebar .recent_posts_slider a,
	.sidebar a,.sidebar .tp_recent_tweets .twitter_time { color:<?php echo sanitize_hex_color($swm_sidebar_link);?>;  }
<?php } ?>

<?php if ( $swm_sidebar_link_hover = swm_get_option( 'swm_sidebar_link_hover' ) ) { ?>
	.sidebar ul li a:hover,
	.sidebar a:hover { color:<?php echo sanitize_hex_color($swm_sidebar_link_hover); ?>; }
<?php } ?>

<?php if ( $swm_sidebar_text_size = swm_get_option( 'swm_sidebar_text_size' ) ) { ?>
	.sidebar,
	.sidebar p,
	.sidebar ul li,
	.sidebar ul li a,
	.sidebar .tagcloud a { font-size: <?php echo intval($swm_sidebar_text_size); ?>px; }
<?php } ?>

<?php if ( $swm_sidebar_title_border_color = swm_get_option( 'swm_sidebar_title_border_color' ) ) { ?>
	.sidebar .swm-sidebar-ttl h3 span:before,
	.sidebar .swm-sidebar-ttl h3 span:after { background:<?php echo sanitize_hex_color($swm_sidebar_title_border_color); ?>; }
<?php } ?>

<?php if ( $swm_sidebar_widget_box_bg = swm_get_option( 'swm_sidebar_widget_box_bg' ) ) { ?>
	.sidebar .swm-sidebar-widget-box,
	.single .swm-about-author { background:<?php echo sanitize_hex_color($swm_sidebar_widget_box_bg); ?>; }
<?php } ?>

<?php

if ( $swm_sidebar_border_color = swm_get_option( 'swm_sidebar_border_color' ) ) { ?>

	.sidebar .swm-list-widgets ul li,
	.sidebar .widget-search .swm-search-form #s,
	.sidebar .widget_rss ul li,
	.sidebar .widget_meta ul li,
	.sidebar .widget_pages ul li,
	.sidebar .widget_archive ul li,
	.sidebar .widget_recent_comments ul li,
	.sidebar .widget_recent_entries ul li,
	.sidebar .widget-nav-menu ul li,
	.sidebar .input-text,
	.sidebar input[type="text"],
	.sidebar input[type="password"],
	.sidebar input[type="email"],
	.sidebar input[type="number"],
	.sidebar input[type="url"],
	.sidebar input[type="tel"],
	.sidebar input[type="search"],
	.sidebar textarea,
	.sidebar select,
	.sidebar #wp-calendar thead th,
	.sidebar #wp-calendar caption,
	.sidebar #wp-calendar tbody td,
	.sidebar #wp-calendar tbody td:hover,
	.sidebar input[type="text"]:focus,
	.sidebar input[type="password"]:focus,
	.sidebar input[type="email"]:focus,
	.sidebar input[type="number"]:focus,
	.sidebar input[type="url"]:focus,
	.sidebar input[type="tel"]:focus,
	.sidebar input[type="search"]:focus,
	.sidebar textarea:focus,
	.sidebar .widget-search .swm-search-form #s:focus,
	.sidebar .gyan-recent-posts-large-title,
	.sidebar .gyan-recent-posts-tiny ul li,
	ul.swm-post-author-icon li a {  border-color: <?php echo sanitize_hex_color($swm_sidebar_border_color);?>;}

<?php } ?>