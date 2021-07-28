<?php
$swm_about_author_description = wp_kses( get_the_author_meta('description'),swm_kses_allowed_text() );

if ( $swm_about_author_description != '' ) {

	$swm_about_author_box = swm_get_option('swm_single_about_author',1);

	if (isset($_COOKIE["pixel_ratio"])) {
	 		$swm_pixel_ratio = $_COOKIE["pixel_ratio"];
		$swm_avatar_size = $swm_pixel_ratio > 1 ? '296' : '148';
	} else {
	    $swm_avatar_size = '148';
	}

	if ( $swm_about_author_box != 1 && $swm_about_author_description == '' && is_single() ) { return; }

	$swm_post_author_url = get_the_author_meta('user_url');
	$swm_author_subtitle = get_the_author_meta('author-subtitle');
	?>

	<div class="swm-about-author-box">
		<span class="swm-about-author-left-bg"></span>
			<div class="swm-about-author">

				<div class="swm-about-author-left-wrap">
					<a class="swm-about-author-box-img" href="<?php echo esc_url( get_author_posts_url(get_the_author_meta( 'ID' ) ) ); ?>">
						<?php echo get_avatar(get_the_author_meta('email'),$swm_avatar_size); ?>
					</a>
				</div>

				<div class="swm-about-author-biotext">
					<div class="swm-about-author-title-subtitle" >
						<a class="swm-about-author-name swm-heading-text" href="<?php echo esc_url( get_author_posts_url(get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html__( 'About', 'bizix' );?> <?php echo get_the_author(); ?></a>
						<span><?php echo esc_html($swm_author_subtitle); ?></span>
					</div>
					<p><?php echo wp_kses( get_the_author_meta('description'),swm_kses_allowed_text() );?></p> <?php

					if ( $swm_post_author_url != '' ) { ?>

						<p><strong><?php echo esc_html__( 'Website', 'bizix' );?>:</strong> <a href="<?php echo esc_url($swm_post_author_url); ?>"><?php echo esc_url($swm_post_author_url); ?></a></p>

					<?php } ?>

					<div class="clear"></div>

					<ul class="swm-post-author-icon"><?php

						$swm_get_author_contact = '';
						$author_contacts = array('facebook-f','twitter','google-plus','pinterest','linkedin-in','instagram','tumblr','delicious','vimeo-square','youtube-play');

						foreach ($author_contacts as $author_contact ) {
							if ( get_the_author_meta($author_contact) ) { ?>
								<li><a href="<?php echo esc_url( get_the_author_meta($author_contact) );?>" target="_blank" ><i class="fab fa-<?php echo esc_attr($author_contact);?>"></i></a></li><?php
							}
						}
						?>
					</ul>
					<div class="clear"></div>

				</div>
				<div class="clear"></div>

			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
<?php }