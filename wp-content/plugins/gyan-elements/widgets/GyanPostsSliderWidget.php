<?php
if ( !class_exists( 'GyanPostsSlider' ) ) {
	class GyanPostsSlider extends WP_Widget {
	    function __construct() {
			$widget_ops = array('description' => esc_html__('Display posts slider', 'gyan-elements'));
			parent::__construct('gyan_posts_slider_wid',$name = esc_html__('Custom - Posts Slider', 'gyan-elements'),$widget_ops);
	    }

	  	/* Displays the Widget in the front-end */
	    function widget($args, $instance){
			extract($args);
			$title         = apply_filters('widget_title', !empty($instance['title']) ? $instance['title'] : esc_html__('Popular Posts', 'gyan-elements') );
			$no_title_char = !empty($instance['no_title_char']) ? $instance['no_title_char'] : '70' ;
			$no_of_posts   = !empty($instance['no_of_posts']) ? $instance['no_of_posts'] : '4' ;
			$add_category  = !empty($instance['add_category']) ? $instance['add_category'] : '' ;

			$data_rtl = is_rtl() ? 'true' : 'false';

			echo '<div class="gyan-posts-slider-widget-wrap">';
			echo $before_widget;
			echo $before_title . $title . $after_title;
			echo '<div class="gyan-posts-slider-widget owl-carousel" data-rtl="' . $data_rtl . '">';
			$cnt = 0;

			if($add_category != ""){
				$get_posts_list = new WP_Query('cat='.$add_category.'&posts_per_page='.intval($no_of_posts).'&orderby=date&order=DESC');
			}else{
				$get_posts_list = new WP_Query('posts_per_page='.intval($no_of_posts).'&orderby=date&order=DESC');
			}

			while($get_posts_list->have_posts()): $get_posts_list->the_post();

				if ( has_post_thumbnail() ) {

					$format = get_post_format();

					if($cnt < $no_of_posts){ ?>
						<div class="gyan-posts-slider-widget-item">
							<a href="<?php echo get_permalink(); ?>" title="<?php echo esc_attr(strip_tags(get_the_title())); ?>" class="gyan-recent-posts-tiny-img">
								<?php the_post_thumbnail('swm_image_size_post_grid'); ?>
							</a>

							<div class="gyan-posts-slider-widget-content">

								<div class="gyan-posts-slider-widget-meta"><span><?php echo get_the_date(); ?></span> / <span class="gyan-posts-slider-widget-meta-cat"><?php

									$swm_meta_cats = get_the_category();
									$swm_meta_cat_list = array();

									if($swm_meta_cats){
										foreach($swm_meta_cats as $category) {
											$swm_meta_cat_list[] = '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( esc_html__( 'View all posts in %s', 'bizix' ), $category->name ) ) . '" >'.esc_html($category->cat_name).'</a>';
										}
									 	echo implode(', ', $swm_meta_cat_list);
									}
								?></span></div>
								<div class="gyan-posts-slider-widget-title swm-heading-font"><a href="<?php echo get_permalink(); ?>"><?php echo esc_attr(strip_tags(substr(get_the_title(),0,$no_title_char) )  ); ?></a></div>
							</div>

							<div class="clear"></div>
						</div>
						<?php
						$cnt++;
					}

				}

			endwhile;
			wp_reset_postdata();

			echo '</ul>';
			echo '</div>';
			echo '<div class="clear"></div>';
			echo $after_widget;
			echo '</div>';
		}

	  	/*Saves the settings. */
	    function update($new_instance, $old_instance){
			$instance                  = $old_instance;
			$instance['title']         = stripslashes($new_instance['title']);
			$instance['no_title_char'] = stripslashes($new_instance['no_title_char']);
			$instance['no_of_posts']   = stripslashes($new_instance['no_of_posts']);
			$instance['add_category']  = stripslashes($new_instance['add_category']);

			return $instance;
		}

	    function form($instance){
			//Defaults
			$instance = wp_parse_args( (array) $instance, array(
				'title'         => esc_html__('Recent Posts', 'gyan-elements'),
				'no_title_char' =>'70',
				'no_of_posts'   =>'4',
				'add_category'  =>'' ) );

			echo '<p><label for="' . $this->get_field_id('title') . '">' . esc_html__('Widget Title:', 'gyan-elements') . '</label><input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . esc_attr($instance['title']) . '" /></p>';

			echo '<p><label for="' . $this->get_field_id('no_title_char') . '">' . esc_html__('Title Text Characters Limit:', 'gyan-elements') . '</label><input class="widefat" id="' . $this->get_field_id('no_title_char') . '" name="' . $this->get_field_name('no_title_char') . '" type="text" value="' . intval($instance['no_title_char']) . '" /></p>';

			echo '<p><label for="' . $this->get_field_id('no_of_posts') . '">' . esc_html__('Number of Posts to Display:', 'gyan-elements') . '</label><input class="widefat" id="' . $this->get_field_id('no_of_posts') . '" name="' . $this->get_field_name('no_of_posts') . '" type="text" value="' . intval($instance['no_of_posts']) . '" /></p>';

			echo '<p><label for="' . $this->get_field_id('add_category') . '">' . esc_html__('Display Specific Categories:', 'gyan-elements') . '</label><input class="widefat" id="' . $this->get_field_id('add_category') . '" name="' . $this->get_field_name('add_category') . '" type="text" value="' . esc_attr($instance['add_category']) . '" /><br /><small>' . esc_html__('If you want to display specific category(ies) recent posts only, then add Category IDs with comma seperated (e.g. 1,2,3) or Leave it blank for default.', 'gyan-elements') . '</small></p>';

		}
	}
}

register_widget('GyanPostsSlider');