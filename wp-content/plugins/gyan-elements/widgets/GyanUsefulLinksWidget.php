<?php
if ( !class_exists( 'GyanUsefulLinks' ) ) {
    class GyanUsefulLinks extends WP_Widget {
        function __construct() {
            $widget_ops = array('description' => esc_html__('Display links with 2 column', 'gyan-elements'));
            parent::__construct('gyan_useful_links_wid',$name = esc_html__('Custom - Useful Links', 'gyan-elements'),$widget_ops);
        }

        /* Displays the Widget in the front-end */
        function widget($args, $instance){
            extract($args);
            $title = apply_filters('widget_title', !empty($instance['title']) ? $instance['title'] : esc_html__('Recent Posts', 'gyan-elements') );
            $footer_menu = ! empty( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';
            $mobile_one_column = !empty( $instance['mobile_one_column'] ) ? '1' : '0';

            echo $before_widget;
            echo $before_title . $title . $after_title;

            if ( $footer_menu != '' ) {

                $get_mobile_one_column =  ( $mobile_one_column == 1 ) ? 'gyan-useful-res-mobile-1col' : '';

                echo '<div class="gyan_useful_links_widget ' . $get_mobile_one_column . '">';

                $footer_menu_items = wp_get_nav_menu_items( $footer_menu );
                $nav_menu = ! empty( $instance['nav_menu'] ) ? wp_get_nav_menu_object( $instance['nav_menu'] ) : false;
                if ( ! $nav_menu ) {
                    return;
                }

                $nav_menu_args = array(
                    'fallback_cb' => '',
                    'menu_class' => '',
                    'menu'        => $nav_menu,
                    'echo' => false,
                );

                echo wp_nav_menu( apply_filters( 'widget_nav_menu_args', $nav_menu_args, $footer_menu, $args, $instance ) );
                echo '</div>';

            }

            echo '<div class="clear"></div>';
            echo $after_widget;
        }

        /*Saves the settings. */
        function update($new_instance, $old_instance){
            $instance = $old_instance;
            $instance['title'] = stripslashes($new_instance['title']);
            $instance['nav_menu'] = (int) $new_instance['nav_menu'];
            $instance['mobile_one_column'] = $new_instance['mobile_one_column'] ? 1 : 0;

            return $instance;
        }

        function form($instance){
            //Defaults
            $instance = wp_parse_args( (array) $instance, array('title'=>esc_html__('Useful Links','gyan-elements'),'nav_menu'=>'none','mobile_one_column'=>0 ) );

            $instance = wp_parse_args( (array) $instance, array(

            ) );
            $footer_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';
            $get_wp_menus_name = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
            ?>

            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e('Widget Title:', 'gyan-elements') ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" style="width:95%;" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('nav_menu'); ?>"><?php echo esc_html('Select Menu:','__yoga-site-shortcodes__'); ?></label>
                <select id="<?php echo $this->get_field_id('nav_menu'); ?>" name="<?php echo $this->get_field_name('nav_menu'); ?>">
                   <option value="none" <?php if ( $instance['nav_menu'] == 'none') { echo 'selected="selected"'; } ?>><?php echo esc_html__('-- Select Menu --', '__yoga-site-shortcodes__'); ?></option>
                    <?php
                        foreach ( $get_wp_menus_name as $menu_name ) { ?>
                            <option value="<?php echo $menu_name->term_id; ?>" <?php if ( $instance['nav_menu'] == $menu_name->term_id) { echo 'selected="selected"'; } ?>><?php echo $menu_name->name ?></option><?php
                        }
                    ?>
                </select>
            </p>
            <p>
                <input class="checkbox" type="checkbox" <?php checked($instance['mobile_one_column'], true) ?> id="<?php echo $this->get_field_id('mobile_one_column'); ?>" name="<?php echo $this->get_field_name('mobile_one_column'); ?>" />
                <label for="<?php echo $this->get_field_id('mobile_one_column'); ?>"><?php esc_html_e('Display Links with 1 Column in Mobile Vertical Position', 'gyan-elements') ?></label>
            </p>
            <?php
        }
    }
}

register_widget('GyanUsefulLinks');