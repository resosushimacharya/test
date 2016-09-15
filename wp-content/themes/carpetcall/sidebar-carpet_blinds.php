<?php $term_id =  get_queried_object()->term_id;
if(!is_last_cat($term_id)){?>

    <div class="cc-product-sub-category-list">
    <?php 
    /**
    *shpw the sub-category list of the  product category
    */
   
    $prosubcats=get_term_children($term_id,'product_cat');
	
	$taxonomy = 'product_cat';
	//$prosubcats=get_terms(array('child'=>$term_id,'taxonomy'=>'product_cat'));
	?>
    

    <ul class="cc-pro-sub-cat-ul guide_list_cbg">
    
    <h3>Categories</h3>
    
    <?php 
    foreach($prosubcats as $psc)
    {
		$term = get_term_by( 'id', $psc, $taxonomy );
		if($term->parent == $term_id && $term->count >0){
		 echo '<li><a href="'.get_term_link($term,$taxonomy).'">'.$term->name.'<i class="fa fa-caret-right" aria-hidden="true"></i></a></li>';
		}
       } ?>
       
       
       
    </ul>
    
   
    </div><div class="clearfix"></div>
<?php } else{?>
		<div class="room_visualizer_tile">
        	<h3 class="room_visualiser_title"><?php _e('Checkout our room visualiser','carpetcall')?></h3>
            <p class="room_visualiser_desc"><?php _e('Explore our entire range of carpets, rugs, flooring + more!','carpetcall')?></p>
            <img class="room_visualiser_image" src="<?php get_template_directory_uri()?>/images/sidebar-room-visualiser.png">
            <a class="read_more" target="_blank" href="http://roomvisualiser.carpetcall.com.au/"><?php _e('Explore Now','carpetcall')?></a>
        </div>
	<?php }?>






