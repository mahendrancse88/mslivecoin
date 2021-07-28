<?php
/*
Template Name: Blank Page
Template Post Type: portfolio, page, post
*/
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> data-boxed-margin="<?php echo intval(swm_get_option( 'swm_boxed_layout_margin_top_bottom', 40 )); ?>">
	<?php wp_body_open(); ?>

	<?php if ( swm_get_option('swm_page_preloader_on','off' ) == 'on' ) { ?>

		<div class="swm-site-loader">
			<div class="swm-loader-holder">
				<div class="swm-loader"></div>
			</div>
		</div>

	<?php } ?>

	<div class="swm-containers-holder blank-pg-wrap">
		<div class="swm-site-content swm-css-transition blank-pg-holder ">
	<?php
			if ( have_posts() ) while ( have_posts() ) : the_post();
				$swm_get_the_content = get_the_content();

				if ($swm_get_the_content == '') {
					?> &nbsp; <?php
				} else {
					the_content();
				}

				echo swm_content_pagination_menu();

			endwhile;
			?>

			<div class="clear"></div>

		</div> <!-- .swm-main-container -->

	</div> <!-- .swm-containers-holder -->

	<?php wp_footer(); ?>
</body>
</html>