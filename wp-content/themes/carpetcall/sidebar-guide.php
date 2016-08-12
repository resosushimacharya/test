<ul class="guide_list_cbg">
            
<?php 


$roottitle = ' ';
$url = site_url();
$url = explode('/',$url);

if(strcasecmp($url[2],'localhost')==0)
{
 if($post->ID=='1690'){
 	$roottitle ="GUIDE";
 }
 if($post->ID=='1711'){
 	$roottitle ="CARE";
 }
 if($post->ID=='1725'){
 	$roottitle ="FAQ";
 }
}
else{
if($post->ID=='26696'){
 	$roottitle ="GUIDE";
 }
 if($post->ID=='26709'){
 	$roottitle ="CARE";
 }
 if($post->ID=='26721'){
 	$roottitle ="FAQ";
 }
}
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
    
     echo '<li><a href="'.get_the_permalink($post->ID).'">' . get_the_title($post->ID) .' '.$roottitle.' ' .'<i class="fa fa-caret-right" aria-hidden="true"></i></a></li>';
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
<?php 
if($post->ID!=1725){
?>
<!-- here comes certain contains in future if neaded..  -->
<?php }?>
