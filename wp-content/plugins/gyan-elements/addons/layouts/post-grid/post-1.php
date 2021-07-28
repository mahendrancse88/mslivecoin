<?php

$post_grid_metas = '';

if ( $gyan_show_metas == 'yes' ) :
    $post_grid_metas .= '<div class="gyan-post-grid-meta gyan-ease-transition">
        <ul>';
            if ( $gyan_post_author_name == 'yes' ) {
                $post_grid_metas .= '<li><span class="gyan-postmeta-icon"><i class="fas fa-user"></i></span><span class="gyan-postmeta-text"><a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) )) . '">' . esc_html(get_the_author()) . '</a></span></li>';
            }

            if ( $gyan_post_likes == 'yes' ) {
                $post_grid_metas .= '<li>' . gyan_love() . '</li>';
            }

            if ( $gyan_post_views == 'yes' ) {
                $post_grid_metas .= '<li><span class="gyan-postmeta-icon"><i class="fas fa-eye"></i></span><span class="gyan-postmeta-text">' . gyan_get_post_views(get_the_ID()) . '</span></li>';
            }

            if ( $gyan_post_comments == 'yes' ) {
                $post_grid_metas .= '<li><span class="gyan-postmeta-icon"><i class="fas fa-comment-dots"></i></span><span class="gyan-postmeta-text"><a href="' . esc_url(get_comments_link()) . '">' . get_comments_number() . '</a></span></li>';
            }
        $post_grid_metas .= '</ul>
    </div>
    <div class="clear"></div>';
endif; ?>

<div class="gyan-post-grid-item gyan-grid-item-wrap <?php echo esc_attr( $get_pf_cats_list ); ?>">
    <div class="gyan-post-grid-item-inner gyan-grid-item">

        <div class="gyan-post-grid-item-holder gyan-ease-transition <?php
            if ($gyan_post_date_on == 'no' ) { echo ' gyan-post-date-off'; }
            ?>">

            <?php  if ( $post_thumbnail_id && $gyan_post_image_on == 'yes' ): ?>

                <div class="gyan-post-image">

                    <div class="gyan-post-grid-format"><a href="<?php echo esc_url( $get_permalink ); ?>" class="gyan-post-grid-image gyan-ease-transition"><?php echo $post_image; ?></a><?php echo $post_grid_metas; ?>
                    </div>
                </div>

            <?php endif; ?>

            <div class="gyan-post-content-block gyan-ease-transition">
                <div class="gyan-post-title-section">

                        <div class="gyan-post-grid-content">

                            <div class="gyan-post-title">
                                <h2><a href="<?php echo esc_url( $get_permalink ); ?>"><?php echo gyan_short_text($gyan_get_the_title,intval($data['title_length'])); ?>
                                </a></h2>
                            </div>

                            <?php if ( $gyan_post_cats == 'yes' ) : ?>

                                <div class="gyan-post-grid-category"><?php
                                echo esc_html__( 'Posted In ', 'gyan-elements' );

                                $gyan_post_all_cats = get_the_category();
                                $gyan_post_cat_list = array();

                                    if($gyan_post_all_cats){
                                        foreach($gyan_post_all_cats as $category) {
                                            $gyan_post_cat_list[] = '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( esc_html__( 'View all posts in %s', 'gyan-elements' ), $category->name ) ) . '" >'.esc_html($category->cat_name).'</a>';
                                        }
                                        echo implode(', ', $gyan_post_cat_list);
                                    } ?>
                                </div>

                            <?php endif; ?>

                            <?php

                            if ( $data['show_excerpt'] == 'yes' ) : ?>

                                <div class="gyan-post-list-excerpt">
                                    <?php echo gyan_short_text($get_the_excerpt,intval($data['excerpt_length'])); ?>
                                </div>

                            <?php endif; ?>

                            <div class="gyan-post-grid-c-button gyan-ease-transition">
                                <a href="<?php echo esc_url( $get_permalink ); ?>"><span></span></a>
                            </div>

                            <?php if ( $gyan_post_date_on == 'yes' ) { ?>
                                <div class="gyan-post-grid-date">
                                    <span><?php echo get_the_date($post_date); ?></span>
                                </div>
                            <?php } ?>

                            <div class="clear"></div>

                        </div>

                </div>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>

    </div> <!-- gyan-post-grid-item-inner -->
</div> <!-- gyan-post-grid-item -->

<div class="clear"></div>