<ul class="guide_list_cbg">
            
<?php 
$args = array(
    'post_type'      => 'page',
    'posts_per_page' => -1,
    'post_parent'    => $post->ID,
    'order'          => 'ASC',
    'orderby'        => 'menu_order'
 );


$parent = new WP_Query( $args );
while($parent->have_posts()){
    $parent->the_post();
    
     echo '<li><a href="'.get_the_permalink($post->ID).'">' . get_the_title($post->ID). '<i class="fa fa-caret-right" aria-hidden="true"></i></a></li>';
}
wp_reset_query();
 ?>
</ul>
<?php

/**
 *relate the category guide term to prodcut term
 */

$sourcecat = get_queried_object();
$cat_link  = 'halt';
if (get_term_by('slug', $sourcecat->slug, 'product_cat')) {
    $destinationcat = get_term_by('slug', $sourcecat->slug, 'product_cat');
    $cat_link       = get_category_link($destinationcat->term_id);
}
?>
<div class="nowspe nowsppe"><a href="<?php
echo (strcasecmp($cat_link, 'halt') != 0) ? $cat_link : 'javascript:void(0)';
?>"> SHOP NOW </a></div>

