<div class="gyan-portfolio-img-holder">
    <?php if ( 'yes' === $data['show_overlay'] ) :

        echo $imageTagHtml;
        ?>

        <div class="gyan-portfolio-overlay gyan-overlay gyan-flex">

            <?php if ( 'yes' === $data['show_zoom_icon'] || 'yes' === $data['show_link_icon'] ) : ?>

                <div class="gyan-portfolio-hover-icons gyan-flex gyan-ease-transition"><?php

                    if ( 'yes' === $data['show_zoom_icon'] && '' != $click_action ) {
                        ?><a <?php echo $this->get_render_attribute_string( 'grid-media-' . $index ); ?> ><span class="gyan-icon"><?php echo $zoom_icon;?></span></a><?php
                    }

                    if ( 'yes' === $data['show_link_icon'] ) {
                        ?><a href="<?php echo esc_url( $get_permalink ); ?>" class="gyan-portfolio-link-icon gyan-ease-transition gyan-flex"><span class="gyan-icon"><?php echo $link_icon;?></span></a><?php
                    }

                ?></div>

            <?php endif; ?>


        </div>

     <?php endif; ?>

</div>
<div class="clear"></div>

<?php if ( 'yes' === $data['show_title'] || 'yes' === $data['show_category'] || 'yes' === $data['show_excerpt']  ) :
        ?>

<div class="gyan-portfolio-all-content gyan-ease-transition">

        <div class="gyan-portfolio-content gyan-ease-transition<?php
        if ( 'yes' != $data['show_title'] && 'yes' != $data['show_category'] && 'yes' != $data['show_excerpt'] ) {
            echo ' gyan-no-pf-content';
        }
        ?>">

            <?php if ( 'yes' === $data['show_title'] ) { ?>
                 <div class="gyan-portfolio-title">
                    <<?php echo $settings['title_html_tag']; ?>  class="gyan-portfolio-title-tag">
                    <?php if ( 'yes' === $data['link_title'] ) {  ?>
                        <a href="<?php echo esc_url( $get_permalink ); ?>" class="gyan-portfolio-title-link">
                    <?php } ?>

                    <?php echo $gyan_get_the_title; ?>

                    <?php if ( 'yes' === $data['link_title'] ) {  ?>
                        </a>
                    <?php } ?>
                    </<?php echo $settings['title_html_tag'];?>>
                </div>
            <?php } ?>

            <?php if ( 'yes' === $data['show_category'] ) {

                $terms = get_the_terms( get_the_ID(), 'portfolio_category' );
                $get_portfolio_cat = array();

                if ( !empty( $terms ) ) {
                    foreach ($terms as $term) {
                        $get_portfolio_cat[] = $term->name;
                    }
                }

                $portfolio_item_cat = (!empty($get_portfolio_cat)) ? implode(", ",$get_portfolio_cat) : '';

                if ( !empty( $terms ) ) {
                    echo '<div class="gyan-portfolio-category">' . $portfolio_item_cat . '</div>';
                }

            }
            ?>

            <?php if ( 'yes' === $data['show_excerpt'] && $get_the_excerpt != '' ) { ?>
                 <div class="gyan-portfolio-excerpt"><?php echo gyan_short_text($get_the_excerpt,intval($data['excerpt_length'])); ?></div>
            <?php } ?>

        </div>
</div>

<?php endif; ?>