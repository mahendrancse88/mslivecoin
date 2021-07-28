<?php

ob_start();

get_header(); ?>
	<div class="swm-container">
		<div class="swm-error-page-content">
			<div class="swm-error-page-image">
				<?php echo '<img src="' . get_template_directory_uri().'/images/404-error.jpg' . '" />'; ?>
			</div>
			<?php
			$swm_error_page_content = '
			<h2 class="swm-error-page-title swm-tertiary-skin-col swm-heading-text">' . esc_html__( 'Oops! Page is not available.', 'bizix' ) . '</h2>
			<p class="swm-error-page-subtitle">'.esc_html__( 'The page you are looking for was moved, removed, renamed or never existed.', 'bizix' ).'</p>';

			$swm_error_page_button = '<p class="swm-error-page-button"><a href="' . esc_url(home_url( '/' )) . '" class="swm-button">' . esc_html__( 'Back to Home', 'bizix' ) . '<i class="fas fa-long-arrow-alt-right"></i></a></p>';

			echo apply_filters( 'swm_error_page_content', $swm_error_page_content );
			echo apply_filters( 'swm_error_page_button', $swm_error_page_button );
			?>
		</div>
	</div>
<?php get_footer(); ?>