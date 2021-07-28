<?php
if ( !class_exists( 'GyanRecentPosts' ) ) {
	class GyanRecentPosts extends WP_Widget {
	    function __construct() {
			$widget_ops = array('description' => esc_html__('Display latest blog posts', 'gyan-elements'));
			parent::__construct('gyan_recent_posts_wid',$name = esc_html__('Custom - Recent Posts', 'gyan-elements'),$widget_ops);
	    }

	  	/* Displays the Widget in the front-end */
	    function widget($args, $instance){
			extract($args);
			$title = apply_filters('widget_title', !empty($instance['title']) ? $instance['title'] : esc_html__('Recent Posts', 'gyan-elements') );
			$no_title_char = !empty($instance['no_title_char']) ? $instance['no_title_char'] : '40' ;
			$no_of_posts = !empty($instance['no_of_posts']) ? $instance['no_of_posts'] : '4' ;
			$add_category = !empty($instance['add_category']) ? $instance['add_category'] : '' ;
			$custom_date = !empty($instance['custom_date']) ? $instance['custom_date'] : 'M j, Y' ;
			$post_list_style = isset($instance['post_list_style']) ? $instance['post_list_style'] : 'rcp_default' ;

			echo $before_widget;
			echo $before_title . $title . $after_title;
			echo '<div class="gyan-recent-posts-tiny gyan_' . $post_list_style . '">';
			echo '<ul>';

			$cnt = 0;

			if($add_category != ""){
				$recentposts = new WP_Query('cat='.$add_category.'&posts_per_page='.intval($no_of_posts).'&orderby=date&order=DESC');
			}else{
				$recentposts = new WP_Query('posts_per_page='.intval($no_of_posts).'&orderby=date&order=DESC');
			}

			while($recentposts->have_posts()): $recentposts->the_post();

			$gyan_rp_widget_date = get_the_date($custom_date);
   //  		$gyan_rp_widget_date = apply_filters( 'gyan_recent_posts_widget_date', $gyan_rp_widget_date );

			if($cnt < $no_of_posts){
			?>
				<li>
					<?php

					if ( $post_list_style != 'rcp_chevron' ) :

						$format = get_post_format();
						$rcp_icon = '';

						switch ( $format ) {

							case 'link': $rcp_icon = 'link';
								break;
							case 'aside': $rcp_icon = 'pencil-alt';
								break;
							case 'image': $rcp_icon = 'camera';
								break;
							case 'gallery': $rcp_icon = 'th-large';
								break;
							case 'video': $rcp_icon = 'video-camera';
								break;
							case 'audio': $rcp_icon = 'volume-up';
								break;
							case 'chat': $rcp_icon = 'comments';
								break;
							case 'quote': $rcp_icon = 'quote-left';
								break;
							default: $rcp_icon = 'file-alt';
								break;
						}

						if ( has_post_thumbnail() ) { ?>
							<a href="<?php echo get_permalink(); ?>" title="<?php echo esc_attr(strip_tags(get_the_title())); ?>" class="gyan-recent-posts-tiny-img">
								<?php the_post_thumbnail('swm_image_size_post_tiny_alt'); ?>
							</a>
							<?php
						} else { ?>
							<a href="<?php echo get_permalink(); ?>" title="<?php echo esc_attr(strip_tags(get_the_title())); ?>" class="gyan-recent-posts-tiny-icon">
							<i class="fas fa-<?php echo $rcp_icon; ?>"></i>
						</a>
							<?php
						}
					endif;
					 ?>

					<div class="gyan-recent-posts-tiny-content">
						<div class="gyan-recent-posts-tiny-title"><a href="<?php echo get_permalink(); ?>"><?php echo esc_attr(strip_tags(substr(get_the_title(),0,$no_title_char) )  ); ?></a></div>
						<p><span><i class="fas fa-clock"></i><?php echo esc_html($gyan_rp_widget_date); ?></span></p>
					</div>

					<div class="clear"></div>
				</li>

				<?php

				$cnt++;
			}

			endwhile;
			wp_reset_postdata();

			echo '</ul>';
			echo '</div>';
			echo '<div class="clear"></div>';
			echo $after_widget;
		}

	  	/*Saves the settings. */
	    function update($new_instance, $old_instance){
			$instance                    = $old_instance;
			$instance['title']           = stripslashes($new_instance['title']);
			$instance['no_title_char']   = stripslashes($new_instance['no_title_char']);
			$instance['no_of_posts']     = stripslashes($new_instance['no_of_posts']);
			$instance['add_category']    = stripslashes($new_instance['add_category']);
			$instance['custom_date']     = stripslashes($new_instance['custom_date']);
			$instance['post_list_style'] = $new_instance['post_list_style'];

			return $instance;
		}

	    function form($instance){
			//Defaults
			$instance = wp_parse_args( (array) $instance, array('title'=>esc_html__('Recent Posts','gyan-elements'),'no_title_char'=>'40','no_of_posts'=>'4','add_category'=>'','custom_date'=>'M j, Y','post_list_style'=>'rcp_default' ) );

			$reference_page = esc_html__('Date Format Reference', 'gyan-elements');

			echo '<p><label for="' . $this->get_field_id('title') . '">' . esc_html__('Widget Title:', 'gyan-elements') . '</label><input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . esc_attr($instance['title']) . '" /></p>';

			echo '<p><label for="' . $this->get_field_id('no_title_char') . '">' . esc_html__('Title Text Characters Limit:', 'gyan-elements') . '</label><input class="widefat" id="' . $this->get_field_id('no_title_char') . '" name="' . $this->get_field_name('no_title_char') . '" type="text" value="' . intval($instance['no_title_char']) . '" /></p>';

			echo '<p><label for="' . $this->get_field_id('no_of_posts') . '">' . esc_html__('Number of Posts to Display:', 'gyan-elements') . '</label><input class="widefat" id="' . $this->get_field_id('no_of_posts') . '" name="' . $this->get_field_name('no_of_posts') . '" type="text" value="' . intval($instance['no_of_posts']) . '" /></p>';

			echo '<p><label for="' . $this->get_field_id('add_category') . '">' . esc_html__('Display Specific Categories:', 'gyan-elements') . '</label><input class="widefat" id="' . $this->get_field_id('add_category') . '" name="' . $this->get_field_name('add_category') . '" type="text" value="' . esc_attr($instance['add_category']) . '" /><br /><small>' . esc_html__('If you want to display specific category(ies) recent posts only, then add Category IDs with comma seperated (e.g. 1,2,3) or Leave it blank for default.', 'gyan-elements') . '</small></p>';

			echo '<p><label for="' . $this->get_field_id('custom_date') . '">' . esc_html__('Date Display Format:', 'gyan-elements') . '</label><input class="widefat" id="' . $this->get_field_id('custom_date') . '" name="' . $this->get_field_name('custom_date') . '" type="text" value="' . esc_html($instance['custom_date']) . '" /><br /><small>' . esc_html__('Display custom date format.', 'gyan-elements') . ' e.g. "M j, Y" <a href="https://wordpress.org/support/article/formatting-date-and-time/#format-string-examples" target="_blank">' . $reference_page . '</a></small></p>';
			?>
			<p>
                <label for="<?php echo $this->get_field_id('post_list_style'); ?>"><?php echo esc_html__('Posts List Display Style:', 'gyan-elements'); ?></label>
                <select id="<?php echo $this->get_field_id('post_list_style'); ?>" name="<?php echo $this->get_field_name('post_list_style'); ?>" class="widefat" style="width:100%;">
                    <option value="rcp_default" <?php if ( $instance['post_list_style'] == 'rcp_default') { echo 'selected="selected"'; } ?>><?php echo esc_html__('Default Style', 'gyan-elements'); ?></option>
                    <option value="rcp_chevron" <?php if ( $instance['post_list_style'] == 'rcp_chevron') { echo 'selected="selected"'; } ?>><?php echo esc_html__('Chevron Icon Style', 'gyan-elements'); ?></option>
                </select>
            </p>
            <?php
		}
	}
}

register_widget('GyanRecentPosts');