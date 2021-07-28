<?php
/* **************************************************************************************
  Custom Controls
************************************************************************************** */

function swm_add_customizer_custom_controls( $wp_customize ) {

    class swm_Customize_Control_Textarea extends WP_Customize_Control {
        public $type = 'textarea';
        public function render_content() {
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <textarea <?php $this->link(); ?> rows="10" style="width: 98%;"><?php echo esc_textarea( $this->value() ); ?></textarea>
                </label>
            <?php
        }
    }

    class swm_Customize_Control_Multiple_Select extends WP_Customize_Control {

        public $type = 'multiple-select';

        public function render_content() {

        if ( empty( $this->choices ) ) {
            return;
        }
        ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <select <?php $this->link(); ?> multiple="multiple" style="height: 100%;">
                    <?php
                        foreach ( $this->choices as $value => $label ) {
                            $selected = ( in_array( $value, $this->value() ) ) ? selected( 1, 1, false ) : '';
                            echo '<option value="' . esc_attr( $value ) . '"' . esc_attr($selected) . '>' . esc_html( $label ) . '</option>';
                        }
                    ?>
                </select>
            </label>
        <?php }
    }

    class swm_Customize_Slider_Control extends WP_Customize_Control {
        public $type = 'slider';

        public function render_content() { ?>
            <div class="swm-customizer-slider-control">
                <label>
                    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                </label>
                <div class="left">
                    <input type="range" name="points" min="<?php echo esc_attr($this->choices['min']); ?>" max="<?php echo esc_attr($this->choices['max']); ?>" step="<?php echo esc_attr($this->choices['step']); ?>" <?php $this->link(); ?>>
                </div>
                <div class="right">
                    <input class="swm_customizer_slider_value" name="<?php echo esc_attr( $this->id ); ?>" type="number" <?php $this->link(); ?> value="<?php echo floatval( $this->value() ); ?>" />
                    <div class="swm_customizer_slider"></div>
                </div>
                <div class="clear"></div>
            </div>
        <?php
        }
    }

    class swm_Customize_Category_Control extends WP_Customize_Control {
        public function render_content() {
            $dropdown = wp_dropdown_categories(
                array(
                    'name'              => '_customize-dropdown-categories-' . esc_attr( $this->id ),
                    'echo'              => 0,
                    'show_option_none'  => esc_html__( '-- Select --','bizix' ),
                    'option_none_value' => '0',
                    'selected'          => esc_attr( $this->value() ),
                )
            );

            // Hackily add in the data link parameter.
            $dropdown = str_replace( '<select', '<select ' . esc_attr($this->get_link()), $dropdown );

            printf( '<label class="customize-control-select"><span class="customize-control-title">%s</span> %s</label>',$this->label,$dropdown );
        }
    }

    class swm_Customize_Radio_Image_Control extends WP_Customize_Control {

        public $type = 'radio-image';

        public function render_content() {

            if ( empty( $this->choices ) ) {
                return;
            }

            $name = '_customize-radio-'.$this->id;

            ?>
            <span class="customize-control-title">
                <?php echo esc_html( $this->label ); ?>
            </span>
            <div id="input_<?php echo esc_attr( $this->id ); ?>" class="image">
                <?php foreach ( $this->choices as $value => $label ) : ?>

                    <input class="image-select" type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $this->id ).esc_attr( $value ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?>>
                        <label for="<?php echo esc_attr( $this->id ).esc_attr( $value ); ?>">
                            <img src="<?php echo esc_url( $label ); ?>" rel="tooltip" class="<?php echo esc_attr( $this->id ).'_'.esc_attr( $value ); ?>">
                        </label>
                    </input>

                <?php endforeach; ?>
            </div>
            <script>jQuery(document).ready(function(jQuery) { jQuery( '#input_<?php echo esc_attr( $this->id ); ?>' ).buttonset(); });</script>
            <?php
        }

    }

    class swm_Customize_Radio_Switch_Control extends WP_Customize_Control {

        public $type = 'radio-switch';

        public function render_content() {

            $name = '_customize-radio-'.$this->id;
            ?>

            <div id="input_<?php echo esc_attr( $this->id ); ?>" class="image swm-image-switch">

                <div class="swm-image-switch-block">
                    <input class="image-select" type="radio" value="on" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $this->id ).'-on'; ?>" <?php $this->link(); checked( $this->value(), 'on' ); ?>>
                        <label for="<?php echo esc_attr( $this->id ).'-on'; ?>">
                           <p rel="tooltip" title="On" class="mode-on"></p>
                        </label>
                    </input>

                     <input class="image-select" type="radio" value="off" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $this->id ).'-off'; ?>" <?php $this->link(); checked( $this->value(), 'off' ); ?>>
                        <label for="<?php echo esc_attr( $this->id ).'-off'; ?>">
                            <p rel="tooltip" title="Off" class="mode-off"></p>
                        </label>
                    </input>
                </div>

                <div class="swm-image-switch-title">
                    <span><?php echo esc_html( $this->label ); ?></span>
                </div>

            </div>
            <script>jQuery(document).ready(function(jQuery) { jQuery( '#input_<?php echo esc_attr( $this->id ); ?>' ).buttonset(); });</script>
            <?php
        }

    }

    class swm_Customize_Buttontab_Control extends WP_Customize_Control {
        public $type = 'buttontab';

        public function enqueue() {
            wp_enqueue_script( 'jquery-ui-button' );
        }

        protected function render() {
            $id    = 'customize-control-' . str_replace( '[', '-', str_replace( ']', '', esc_attr( $this->id ) ) );
            $class = 'customize-control customize-control-buttonset ';

            ?><li id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?>">
                <?php $this->render_content(); ?>
            </li><?php
        }

        protected function render_content() {
            if ( empty( $this->choices ) ) {
                return;
            }

            $name = '_customize-radio-' . esc_attr( $this->id );
            $swm_button_count = 1;
            ?>
            <div id="input_<?php echo esc_attr( $this->id ); ?>" class="swm-control-buttonset">

                <?php if ( ! empty( $this->label ) ) : ?>
                    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <?php endif; ?>

                <div class="swm-buttonset">
                    <?php
                        foreach ( $this->choices as $value => $label ) : ?>
                            <input type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $this->id . $value ); ?>" <?php $this->link(); checked( $this->value(), esc_attr( $value ) ); ?> />
                            <label for="<?php echo esc_attr( $this->id ) . $value; ?>" class="bt_count<?php echo esc_attr($swm_button_count); ?>">
                                <?php echo esc_html( $label ); ?>
                            </label>
                            <?php
                            $swm_button_count++;

                        endforeach;
                    ?>
                    <div class="clear"></div>
                </div>

            </div>
        <?php
        }
    }

    class swm_Customize_RevSlider_Control extends WP_Customize_Control {

        public function render_content() {

            $swm_revslider_results = '';

            if (class_exists('RevSlider')) {
                $swm_revslider_theslider     = new RevSlider();
                $swm_revslider_arrSliders = $swm_revslider_theslider->getArrSliders();
                $arrA     = array();
                $arrT     = array();
                foreach($swm_revslider_arrSliders as $slider){
                    $arrA[]     = $slider->getAlias();
                    $arrT[]     = $slider->getTitle();
                }
                if($arrA && $arrT){
                    $swm_revslider_results = array_combine($arrA, $arrT);
                }

            }

            if(!empty($swm_revslider_results)) { ?>
                    <label>
                        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                        <select name="<?php echo esc_attr($this->id); ?>" id="<?php echo esc_attr($this->id); ?>" <?php $this->link(); ?>>
                        <option value="none">Select</option>
                        <?php
                            foreach ( $swm_revslider_results as $rev_alias => $rev_title ) {
                                echo '<option value="' . esc_attr( $rev_alias ) . '"' . selected( esc_attr( $this->value() ), $rev_alias, false ) . '>' . esc_html( $rev_title ) . '</option>';
                            }
                            ?>
                        </select>
                    </label>
                <?php
            } else { ?>
                <p><?php echo esc_html__('Note: Please create revolution slider to view list of all revolution slider(s) name from WordPress Admin > Revolution Slider','bizix'); ?></p>
            <?php }
        }
    }

    class swm_Customize_Sidebar_Control extends WP_Customize_Control {

        private $posts = false;

        public function __construct($manager, $id, $args = array(), $options = array()) {
            $postargs = wp_parse_args($options, array('numberposts' => '100'));
            $this->posts = get_posts($postargs);

            parent::__construct( $manager, $id, $args );
        }

        public function render_content() {

            global $post;
            $post_id = $post;
            if (is_object($post_id)) {
                $post_id = $post_id->ID;
            }
            $swm_selected_sidebar = get_post_meta($post_id, 'sbg_selected_sidebar', true);
            if(!is_array($swm_selected_sidebar)){
                $tmp = $swm_selected_sidebar;
                $swm_selected_sidebar = array();
                $swm_selected_sidebar[0] = $tmp;
            }
            $swm_selected_sidebar_replacement = get_post_meta($post_id, 'sbg_selected_sidebar_replacement', true);
            if(!is_array($swm_selected_sidebar_replacement)){
                $tmp = $swm_selected_sidebar_replacement;
                $swm_selected_sidebar_replacement = array();
                $swm_selected_sidebar_replacement[0] = $tmp;
            }

            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span> <?php
               global $wp_registered_sidebars;
               ?>

                    <select name="sidebar_generator" style="display: none;" >
                        <option value="0"<?php if($swm_selected_sidebar == ''){ echo " selected";} ?>>WP Default Sidebar</option>
                    <?php
                    $sidebars = $wp_registered_sidebars;
                    if(is_array($sidebars) && !empty($sidebars)){
                        foreach($sidebars as $sidebar){
                            if($swm_selected_sidebar == $sidebar['id']){
                                echo "<option value='{$sidebar['id']}' selected>{$sidebar['name']}</option>\n";
                            }else{
                                echo "<option value='{$sidebar['id']}'>{$sidebar['name']}</option>\n";
                            }
                        }
                    }
                    ?>
                    </select>
                    <select id="sidebar_generator_replacement" <?php $this->link(); ?> >

                    <?php
                    $swm_sidebar_replacements = $wp_registered_sidebars;
                    if(is_array($swm_sidebar_replacements) && !empty($swm_sidebar_replacements)){
                        foreach($swm_sidebar_replacements as $sidebar){
                            if($swm_selected_sidebar_replacement == $sidebar['id']){
                                echo "<option value='{$sidebar['id']}' selected>{$sidebar['name']}</option>\n";
                            }else{
                                echo "<option value='{$sidebar['id']}'>{$sidebar['name']}</option>\n";
                            }
                        }
                    }
                    ?>
                    </select>

            </label>
                <?php
        }
    }

}

add_action( 'customize_register', 'swm_add_customizer_custom_controls' );