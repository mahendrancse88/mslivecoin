<?php
if ( !class_exists( 'GyanCompanyInfoWidget' ) ) {
    class GyanCompanyInfoWidget extends WP_Widget {

        function __construct() {
            $widget_ops = array( 'classname' => 'widget_social', 'description' => esc_html__( "Logo, Intro and Social icons", 'gyan-elements' ) );
            parent::__construct('gyan_social', esc_html__('Custom - Company Information', 'gyan-elements'), $widget_ops);
            add_action('admin_enqueue_scripts', array($this, 'upload_scripts'));
        }

        public function upload_scripts() {
            $gyan_min_js = get_option('swm_enable_minify_gyan_elements_js',true) ? '-min.js' : '.js';
            wp_enqueue_script( 'gyan-custom-widgets', GYAN_PLUGIN_URL . 'widgets/custom-widgets' . $gyan_min_js, array( 'jquery', ),GYAN_ELEMENTS_VERSION, TRUE );
        }

        function widget( $args, $instance ) {
            extract( $args );

            $title             = apply_filters('widget_title', empty( $instance['title'] ) ? '' : $instance['title']);
            $logo_image        = !empty($instance['logo_image']) ? $instance['logo_image'] : '' ;
            $logo_image_retina = !empty($instance['logo_image_retina']) ? $instance['logo_image_retina'] : '' ;
            $logo_width        = empty( $instance['logo_width'] ) ? '' : intval($instance['logo_width']);
            $logo_height        = empty( $instance['logo_height'] ) ? '' : intval($instance['logo_height']);
            $desc_text         = empty( $instance['desc_text'] ) ? '' : $instance['desc_text'];

            $new_window_open   = !empty( $instance['new_window_open'] ) ? '1' : '0';
            $no_bg_color       = !empty( $instance['no_bg_color'] ) ? '1' : '0';
            $icons_col         = !empty ($instance['icons_col']) ? esc_html($instance['icons_col']) : '';
            $iconsize          = isset($instance['iconsize']) ? $instance['iconsize'] : 'ic-medium' ;
            $iconstyle         = isset($instance['iconstyle']) ? $instance['iconstyle'] : 'ic-round' ;

            $nos = array( "one","two","three","four","five","six","seven","eight","nine","ten" );
            $target = '_self';

            if (isset($_COOKIE["pixel_ratio"]) && $logo_image_retina) {
                $swm_pixel_ratio = $_COOKIE["pixel_ratio"];
                $final_logo_image = $swm_pixel_ratio > 1 ? $logo_image_retina : $logo_image;
            } else {
                $final_logo_image = $logo_image;
            }

            for ( $i = 0; $i<10; $i++ ) {
                $iconname      = 'icon'.$nos[$i].'_name';
                $iconurl       = 'icon'.$nos[$i].'_url';
                $iconbg        = 'icon'.$nos[$i].'_bg';
                $icon_name[$i] = !empty($instance[$iconname]) ? esc_html($instance[$iconname]) : '' ;
                $icon_url[$i]  = !empty($instance[$iconurl]) ? esc_html($instance[$iconurl]) : '' ;
                $icon_bg[$i]   = !empty($instance[$iconbg]) ? esc_html($instance[$iconbg]) : '';
            }

            echo '<div class="gyan_custom_social_widget">';
            echo $before_widget;
            if ( $title != '' ) {
                echo $before_title . wp_kses($title,gyan_kses_allowed_text()) . $after_title;
            }

            if ($new_window_open == 1) {
                $target = 'target="_blank"';
            }

            if ( $final_logo_image != '' ) {
                echo '<div><img class="gyan-wid-logo-img" width="' . $logo_width . '" height="' . $logo_height . '" style="max-width:' . $logo_width . 'px" src="'.esc_url($final_logo_image).'" alt="" /></div>';
            }

            if ( $desc_text != '' ) {
                echo '<p>'.wp_kses($desc_text,gyan_kses_allowed_textarea()).'</p>';
            }
            ?>
            <div class="gyan-sm-wid-icons <?php if ( $no_bg_color == 1 ) { echo 'gyan-sm-wid-i-no-bg';} ?>">
                <ul>
                    <?php
                    for ( $i = 0; $i<10; $i++ ) {

                        $icon_bg_col = ($no_bg_color == 0) ? 'background-color:'.esc_attr($icon_bg[$i]).';' : '';

                       if ( $icon_name[$i] != '' ) {
                            echo '<li class="'.esc_attr($iconsize).' '.esc_attr($iconstyle).'"><a href="'.esc_url($icon_url[$i]).'" '.esc_html($target).' style="color:'.esc_attr($icons_col).';' . $icon_bg_col . '"><i class="fab fa-'.esc_attr($icon_name[$i]).'"></i></a></li>';
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="clear"></div>
            <?php

            echo $after_widget;
            echo '</div>';
        }

        function update( $new_instance, $old_instance ) {

            $instance = $old_instance;
            $instance['title'] = wp_kses($new_instance['title'],gyan_kses_allowed_text());

            if ( current_user_can('unfiltered_html') ) {
                $instance['desc_text'] =  $new_instance['desc_text'];
            } else {
                $instance['desc_text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['desc_text']) ) );
            }

            $instance['logo_image'] = stripslashes($new_instance['logo_image']);
            $instance['logo_image_retina'] = stripslashes($new_instance['logo_image_retina']);

            $instance['logo_width'] = stripslashes($new_instance['logo_width']);
            $instance['logo_height'] = stripslashes($new_instance['logo_height']);

            $instance['new_window_open'] = $new_instance['new_window_open'] ? 1 : 0;
            $instance['no_bg_color'] = $new_instance['no_bg_color'] ? 1 : 0;
            $instance['icons_col']=$new_instance['icons_col'];
            $instance['iconsize'] = $new_instance['iconsize'];
            $instance['iconstyle'] = $new_instance['iconstyle'];


            $nos = array( "one","two","three","four","five","six","seven","eight","nine","ten" );

            for ( $i = 0; $i<10; $i++ ) {
                $iconname            = 'icon'.$nos[$i].'_name';
                $iconurl             = 'icon'.$nos[$i].'_url';
                $iconbg              = 'icon'.$nos[$i].'_bg';
                $instance[$iconname] =  $new_instance[$iconname];
                $instance[$iconurl]  =  $new_instance[$iconurl];
                $instance[$iconbg]   =  $new_instance[$iconbg];
            }

            return $instance;
        }

        function form( $instance ) {
            //Defaults
            $instance = wp_parse_args( (array) $instance, array( 'title' => 'Follow Us','logo_image' => '','logo_image_retina' => '','logo_width' => '','logo_height' => '', 'desc_text' => '', 'icons_col'=>'#ffffff', 'iconsize'=>'ic-medium', 'iconstyle'=>'ic-round', 'iconone_bg'=>'#0e97d1', 'icontwo_bg'=>'#1b4195', 'iconthree_bg'=>'#b41a32', 'iconfour_bg'=>'#4da9cd', 'iconfive_bg'=>'#c61118', 'iconsix_bg'=>'#ff6fa3', 'iconseven_bg'=>'#dd332c', 'iconeight_bg'=>'#0f72aa', 'iconnine_bg'=>'#3284c2', 'iconten_bg'=>'#83a637', 'iconone_name' => 'twitter', 'icontwo_name' => 'facebook-f', 'iconthree_name' => 'instagram', 'iconfour_name' => 'vimeo-v', 'iconfive_name' => 'pinterest-p', 'iconsix_name' => 'dribbble', 'iconseven_name' => 'youtube', 'iconeight_name' => 'linkedin-in', 'iconnine_name' => 'digg', 'iconten_name' => 'forumbee', 'iconone_url' => '#', 'icontwo_url' => '#', 'iconthree_url' => '#', 'iconfour_url' => '#', 'iconfive_url' => '#', 'iconsix_url' => '#', 'iconseven_url' => '#', 'iconeight_url' => '#', 'iconnine_url' => '#', 'iconten_url' => '#', 'new_window_open' => 1,'no_bg_color' => 0 ));

            ?>
            <script type="text/javascript">
                //<![CDATA[
                    jQuery(document).ready(function() {jQuery('#widgets-right .gyan-social-wid-color-pick').wpColorPicker(); });
                //]]>
            </script>
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo esc_html__('Widget Title:', 'gyan-elements') ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" style="width:95%;" />
            </p>

            <hr />

            <div>
                <label for="<?php echo $this->get_field_name( 'logo_image' ); ?>"><?php echo esc_html__('Standard - Logo Image:','gyan-elements'); ?></label><br><br>
                <div class='image-preview'><img src="<?php echo esc_attr( $instance['logo_image'] ); ?>" style="max-width:100px;height:auto;margin:20px 0;" /></div>
                <input class="widefat image-upload-value" id="<?php echo $this->get_field_id( 'logo_image' ); ?>" name="<?php echo $this->get_field_name( 'logo_image' ); ?>" type="hidden" value="<?php echo esc_attr( $instance['logo_image'] ); ?>" />
                <button class="image-upload-button button button-primary"><?php echo esc_html__('Add Image','gyan-elements'); ?></button>
                <input type='button' id='$name-remove' class='button image-upload-button-remove' value='Remove' />
            </div>

            <br><hr><br>
            <div>
                <label for="<?php echo $this->get_field_name( 'logo_image_retina' ); ?>"><?php echo esc_html__('Retina - Logo Image:','gyan-elements'); ?></label><br><br>
                <div class='image-preview'><img src="<?php echo esc_attr( $instance['logo_image_retina'] ); ?>" style="max-width:100px;height:auto;margin:20px 0;" /></div>
                <input class="widefat image-upload-value" id="<?php echo $this->get_field_id( 'logo_image_retina' ); ?>" name="<?php echo $this->get_field_name( 'logo_image_retina' ); ?>" type="hidden" value="<?php echo esc_attr( $instance['logo_image_retina'] ); ?>" />
                <button class="image-upload-button button button-primary"><?php echo esc_html__('Add Image','gyan-elements'); ?></button>
                <input type='button' id='$name-remove' class='button image-upload-button-remove' value='Remove' />
                <br><br>
                <small><?php echo esc_html__('Retina logo size should be double of standard logo. For example standard logo size is 100x50 then retina logo size should be 200x100. If you do not want to add retina logo then use standard logo in retina logo upload section. This is useful for HD devics like iPad, iPhone, Smartphones for sharp display.','gyan-elements'); ?></small>
            </div>

            <br><hr>

            <p>
                <label for="<?php echo $this->get_field_id( 'logo_width' ); ?>"><?php echo esc_html__('Standard Logo Width', 'gyan-elements') ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'logo_width' ); ?>" name="<?php echo $this->get_field_name( 'logo_width' ); ?>" value="<?php echo esc_attr( $instance['logo_width'] ); ?>" style="width:95%;" /><br/>
                <small><?php echo esc_html__('Enter "Standard" logo width in pixels e.g. 150px, 200px.','gyan-elements'); ?></small>
            </p>

            <p>
                <label for="<?php echo $this->get_field_id( 'logo_height' ); ?>"><?php echo esc_html__('Standard Logo Height', 'gyan-elements') ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'logo_height' ); ?>" name="<?php echo $this->get_field_name( 'logo_height' ); ?>" value="<?php echo esc_attr( $instance['logo_height'] ); ?>" style="width:95%;" /><br/>
                <small><?php echo esc_html__('Enter "Standard" logo height in numbers e.g. 50, 100. Used for image height attribute tag.','gyan-elements'); ?></small>
            </p>

            <hr />

            <p><label for="<?php echo $this->get_field_id('desc_text'); ?>"><?php echo esc_html__('Description:', 'gyan-elements'); ?></label><br />
            <textarea  class="widefat" rows="10" cols="20" id="<?php echo $this->get_field_id('desc_text'); ?>" name="<?php echo $this->get_field_name('desc_text'); ?>"><?php echo esc_textarea($instance['desc_text']); ?></textarea><small><?php echo esc_html__('Small widget summery text or leave it blank.', 'gyan-elements'); ?></small></p>
            <p>
                <input class="checkbox" type="checkbox" <?php checked($instance['new_window_open'], true) ?> id="<?php echo $this->get_field_id('new_window_open'); ?>" name="<?php echo $this->get_field_name('new_window_open'); ?>" />
                <label for="<?php echo $this->get_field_id('new_window_open'); ?>"><?php esc_html_e('Open social media website in new window', 'gyan-elements') ?></label>
            </p>

            <p><strong><?php esc_html_e('Icon Names Page:', 'gyan-elements') ?></strong> <a href="https://fortawesome.com/sets/font-awesome-5-brands" target="_blank">Font Awesome</a><br /></p>

            <hr />
            <p>
                <label for="<?php echo $this->get_field_id('icons_col'); ?>"><?php echo esc_html__('Icons Color', 'gyan-elements'); ?></label><br>
                <input class="widefat gyan-social-wid-color-pick" id="<?php echo $this->get_field_id('icons_col'); ?>" name="<?php echo $this->get_field_name('icons_col'); ?>" type="text" value="<?php echo esc_attr( $instance['icons_col'] ); ?>" />
            </p>
            <p>
                <input class="checkbox" type="checkbox" <?php checked($instance['no_bg_color'], true) ?> id="<?php echo $this->get_field_id('no_bg_color'); ?>" name="<?php echo $this->get_field_name('no_bg_color'); ?>" />
                <label for="<?php echo $this->get_field_id('no_bg_color'); ?>"><?php echo esc_html__('Show Icons without Background Color', 'gyan-elements') ?></label>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('iconsize'); ?>"><?php echo esc_html__('Icon Size:', 'gyan-elements'); ?></label>
                <select id="<?php echo $this->get_field_id('iconsize'); ?>" name="<?php echo $this->get_field_name('iconsize'); ?>" class="widefat" style="width:100%;">
                    <option value="ic-small" <?php if ( $instance['iconsize'] == 'ic-small') { echo 'selected="selected"'; } ?>><?php echo esc_html__('Small', 'gyan-elements'); ?></option>
                    <option value="ic-medium" <?php if ( $instance['iconsize'] == 'ic-medium') { echo 'selected="selected"'; } ?>><?php echo esc_html__('Medium', 'gyan-elements'); ?></option>
                    <option value="ic-large" <?php if ( $instance['iconsize'] == 'ic-large') { echo 'selected="selected"'; } ?>><?php echo esc_html__('Large', 'gyan-elements'); ?></option>
                    <option value="ic-xlarge" <?php if ( $instance['iconsize'] == 'ic-xlarge') { echo 'selected="selected"'; } ?>><?php echo esc_html__('X Large', 'gyan-elements'); ?></option>
                </select>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('iconstyle'); ?>"><?php echo esc_html__('Icon Style:', 'gyan-elements'); ?></label>
                <select id="<?php echo $this->get_field_id('iconstyle'); ?>" name="<?php echo $this->get_field_name('iconstyle'); ?>" class="widefat" style="width:100%;">
                    <option value="ic_square" <?php if ( $instance['iconstyle'] == 'ic_square') { echo 'selected="selected"'; } ?>><?php echo esc_html__('Square', 'gyan-elements'); ?></option>
                    <option value="ic-round" <?php if ( $instance['iconstyle'] == 'ic-round') { echo 'selected="selected"'; } ?>><?php echo esc_html__('Rounded', 'gyan-elements'); ?></option>
                    <option value="ic-circle" <?php if ( $instance['iconstyle'] == 'ic-circle') { echo 'selected="selected"'; } ?>><?php echo esc_html__('Circle', 'gyan-elements'); ?></option>
                </select>
            </p>
            <hr />

           <?php
            $nos = array( "one","two","three","four","five","six","seven","eight","nine","ten" );

            for ( $i = 0; $i<10; $i++ ) {

                $iconname = 'icon'.$nos[$i].'_name';
                $iconurl  = 'icon'.$nos[$i].'_url';
                $iconbg   = 'icon'.$nos[$i].'_bg';
                ?>
                <p>
                    <label for="<?php echo $this->get_field_id( $iconname ); ?>"><?php printf(esc_html('Icon %s : Name, URL and Background Color', 'gyan-elements'),$i+1) ?></label>
                    <input type="text" id="<?php echo $this->get_field_id( $iconname ); ?>" name="<?php echo $this->get_field_name( $iconname ); ?>" value="<?php echo esc_attr( $instance[$iconname] ); ?>" style="width:95%;" />
                    <input type="text" id="<?php echo $this->get_field_id( $iconurl ); ?>" name="<?php echo $this->get_field_name( $iconurl ); ?>" value="<?php echo esc_attr( $instance[$iconurl] ); ?>" style="width:95%;" />
                    <input class="widefat gyan-social-wid-color-pick" id="<?php echo $this->get_field_id($iconbg); ?>" name="<?php echo $this->get_field_name($iconbg); ?>" type="text" value="<?php echo esc_attr( $instance[$iconbg] ); ?>" />
                </p>

                <?php
            }

        }

    }
}

register_widget('GyanCompanyInfoWidget');