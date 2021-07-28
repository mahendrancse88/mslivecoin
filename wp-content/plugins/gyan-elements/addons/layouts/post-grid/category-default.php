<div class="gyan-post-grid-category"><?php

if ( $data['grid_style'] == '3') {
	echo $meta_date_word;
} else {
	echo esc_html__( 'Posted In ', 'gyan-elements' );
}

$gyan_post_all_cats = get_the_category();
$gyan_post_cat_list = array();

    if($gyan_post_all_cats){
        foreach($gyan_post_all_cats as $category) {
            $gyan_post_cat_list[] = '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( esc_html__( 'View all posts in %s', 'gyan-elements' ), $category->name ) ) . '" >'.esc_html($category->cat_name).'</a>';
        }
        echo implode(', ', $gyan_post_cat_list);
    } ?>
</div>