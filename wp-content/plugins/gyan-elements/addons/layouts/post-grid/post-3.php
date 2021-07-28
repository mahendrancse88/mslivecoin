<?php

$post_grid_metas = '';

if ( $gyan_show_metas == 'yes' ) :
    $post_grid_metas .= '<div class="gyan-post-grid-metas gyan-ease-transition gyan-post-grid-separator-' . $metas_item_separator_type . ' ">';

            if ( $gyan_post_cats == 'yes' && $category_location == 'before_metas_section' ) {

                $gyan_post_all_cats = get_the_category();
                $gyan_post_cat_list = array();

                    if($gyan_post_all_cats){

                        $post_grid_metas .= '<span class="gyan-post-grid-category gyan-post-grid-category-before-metas">' . $meta_category_word;

                        foreach($gyan_post_all_cats as $category) {
                            $gyan_post_cat_list[] = '<span class="gyan-post-grid-category-item"><a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( esc_html__( 'View all posts in %s', 'gyan-elements' ), $category->name ) ) . '" >'.esc_html($category->cat_name).'</a></span>';
                        }

                        $post_grid_metas .= implode('', $gyan_post_cat_list);
                        $post_grid_metas .= '</span>';
                    }

            }

            if ( $gyan_post_cats == 'yes' && $category_location == 'before_metas' ) {

                $gyan_post_all_cats = get_the_category();
                $gyan_post_cat_list = array();

                    if($gyan_post_all_cats){
                        foreach($gyan_post_all_cats as $category) {
                            $gyan_post_cat_list[] = '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( esc_html__( 'View all posts in %s', 'gyan-elements' ), $category->name ) ) . '" >'.esc_html($category->cat_name).'</a>';
                        }

                        $post_grid_metas .= '<span class="gyan-grid-metas-item"><span class="gyan-postmetas-icon"><i class="fas fa-folder-open"></i></span><span class="gyan-postmeta-text">' . $meta_category_word . implode(', ', $gyan_post_cat_list) . '</span>' . $metas_item_separator_html . '</span>';
                    }

            }

            if ( $gyan_post_metas_date_on == 'yes' ) {
                $post_grid_metas .= '<span class="gyan-grid-metas-item"><span class="gyan-postmetas-icon"><i class="fas fa-clock"></i></span><span class="gyan-postmeta-text">' . $meta_date_word . get_the_date($post_date) . '</span>' . $metas_item_separator_html . '</span>';
            }

            if ( $gyan_post_author_name == 'yes' ) {
                $post_grid_metas .= '<span class="gyan-grid-metas-item"><span class="gyan-postmetas-icon"><i class="fas fa-user"></i></span><span class="gyan-postmeta-text">' . $meta_author_word . '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) )) . '">' . esc_html(get_the_author()) . '</a></span>' . $metas_item_separator_html . '</span>';
            }

            if ( $gyan_post_likes == 'yes' ) {
                $post_grid_metas .= '<span class="gyan-grid-metas-item">' . gyan_love() . $meta_likes_word . $metas_item_separator_html . '</span>';
            }

            if ( $gyan_post_views == 'yes' ) {
                $post_grid_metas .= '<span class="gyan-grid-metas-item"><span class="gyan-postmetas-icon"><i class="fas fa-eye"></i></span><span class="gyan-postmeta-text">' . gyan_get_post_views(get_the_ID()) . $meta_views_word . '</span>' . $metas_item_separator_html . '</span>';
            }

            if ( $gyan_post_comments == 'yes' ) {
                $post_grid_metas .= '<span class="gyan-grid-metas-item"><span class="gyan-postmetas-icon"><i class="fas fa-comment-dots"></i></span><span class="gyan-postmeta-text"><a href="' . esc_url(get_comments_link()) . '">' . get_comments_number() . $meta_comments_word . '</a></span>' . $metas_item_separator_html . '</span>';
            }

            if ( $gyan_post_cats == 'yes' && $category_location == 'after_metas' ) {

                $gyan_post_all_cats = get_the_category();
                $gyan_post_cat_list = array();

                    if($gyan_post_all_cats){
                        foreach($gyan_post_all_cats as $category) {
                            $gyan_post_cat_list[] = '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( esc_html__( 'View all posts in %s', 'gyan-elements' ), $category->name ) ) . '" >'.esc_html($category->cat_name).'</a>';
                        }

                        $post_grid_metas .= '<span class="gyan-grid-metas-item"><span class="gyan-postmetas-icon"><i class="fas fa-folder-open"></i></span><span class="gyan-postmeta-text">' . $meta_category_word . implode(', ', $gyan_post_cat_list) . '</span></span>';
                    }

            }

        $post_grid_metas .= '</div>
    <div class="clear"></div>';
endif; ?>

<div class="gyan-post-grid-item gyan-grid-item-wrap <?php echo esc_attr( $get_pf_cats_list ); ?>">
    <div class="gyan-post-grid-item-inner gyan-grid-item">

        <div class="gyan-post-grid-item-holder gyan-ease-transition">

            <?php  if ( $post_thumbnail_id && $gyan_post_image_on == 'yes' ): ?>

                <div class="gyan-post-image">
                    <div class="gyan-post-grid-format"><a href="<?php echo esc_url( $get_permalink ); ?>" class="gyan-post-grid-image gyan-post-grid-image-effect-<?php echo $data['image_hover_effect']; ?>"><?php echo $post_image; ?></a><?php
                            if ( $gyan_post_cats == 'yes' && $category_location == 'inside_post_img' ) {
                                ?><div class="gyan-post-grid-img-cat gyan-position-<?php echo $data['cat_origin']; ?>"><?php
                                include GYAN_ADDONS_DIR.'layouts/post-grid/category-button.php';
                                ?></div><?php
                            }
                        ?>
                    </div>
                </div>

            <?php endif; ?>

            <div class="gyan-post-content-block gyan-ease-transition">
                <div class="gyan-post-title-section">
                    <?php
                        if ( $metas_location == 'above_content' ) {
                            echo $post_grid_metas;
                        }
                    ?>
                        <div class="gyan-post-grid-content">

                            <?php
                            if ( $gyan_post_cats == 'yes' && $category_location == 'above_title' ) {
                            include GYAN_ADDONS_DIR.'layouts/post-grid/category-' . $data['category_style'] . '.php';
                            }
                            ?>

                            <div class="gyan-post-title">
                                <h2><a href="<?php echo esc_url( $get_permalink ); ?>" ><?php echo gyan_short_text($gyan_get_the_title,intval($data['title_length'])); ?>
                                </a></h2>
                            </div>

                            <?php
                            if ( $metas_location == 'below_title' ) {
                                echo $post_grid_metas;
                            }
                            ?>

                            <?php if ( $gyan_post_cats == 'yes' && $category_location == 'below_title' ) {
                                include GYAN_ADDONS_DIR.'layouts/post-grid/category-' . $data['category_style'] . '.php';
                            }

                            if ( $data['show_excerpt'] == 'yes' ) : ?>

                                <div class="gyan-post-list-excerpt">
                                    <?php echo gyan_short_text($get_the_excerpt,intval($data['excerpt_length'])); ?>
                                </div>

                            <?php endif; ?>

                            <div class="clear"></div>

                        </div>
                        <?php echo $overlay_button_html ?>

                        <?php
                            if ( $metas_location == 'below_content' ) {
                                echo $post_grid_metas;
                            }
                        ?>
                        <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div><div class="clear"></div>

    </div> <!-- gyan-post-grid-item-inner --><div class="clear"></div>
</div> <!-- gyan-post-grid-item -->

<div class="clear"></div>