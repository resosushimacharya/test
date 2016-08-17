<?php
/* Template Name: Shop Our Range Template
*/
get_header();
?>
<?php while(have_posts()){
	the_post();?>
<div class="body-wrapper">
<div class="ia-block clearfix">
<div class="container">
        <div class="col-md-6 no-pl cc-ia-content">
        <h1><?php the_title();?> </h1>
        <p><?php echo $post->post_content;?> </p>
        </div>
        <?php
		$feat_image = has_post_thumbnail()?get_the_post_thumbnail_url(get_the_ID(),'full'):get_template_directory_uri().'/images/placeholder.png';
		?>
        <div class="col-md-6 ia-img">
         <div class="cc-ia-banner" style="background-image: url(<?php echo $feat_image ;?>);">	
         </div>
        </div>
</div>
</div><!-- uppper section end here -->



		<div class="gpf-block clearfix">
        <div class="container">
		<?php 
        $top_lvl_cats = array('rugs','hard-flooring','carpets','blinds');
        foreach($top_lvl_cats as $top_cat){
            $term = get_term_by('slug',$top_cat,'product_cat');
            if($term){?>
                  <div class="col-md-6 cc-ia-item">
  <div class="all-items-blk"> <a href="<?php echo get_term_link($term->term_id)?>">
      <h3><?php echo $term->name?></h3>
    </a>
      <p><?php echo (get_term_meta($term->term_id,'cat_top_description',true))?get_term_meta($term->term_id,'cat_top_description',true):''?></p>
    <?php
						  $term_childs = get_terms('product_cat',array(
						  												'parent'=>$term->term_id,
																		)
																	);
						  if($term_childs){?>
      <?php
						  shuffle($term_childs);
						  $child_cats = array_slice($term_childs,0,4);
						  //var_dump($child_cats);
						  foreach($child_cats as $cat){?>
      <ul class="cat_list">
        <li><i class="fa fa-caret-right" aria-hidden="true"></i> &nbsp;<a href="<?php echo get_term_link($cat->term_id)?>"><?php echo $cat->name?></a></li>
      </ul>
      <div class="clearfix"></div>
      <?php  }?>
      <?php
							  }
						  ?>
    
    <div class="clearfix"></div>
    <div class="read_more"><a href="<?php echo get_term_link($term->term_id) ?>"><?php _e('View All','carpetcall')?></a></div>
  </div>
</div>
                <?php }?>
                
            <?php } ?>

                  </div>
                </div>
                
        <div class="inerblock_sec_a">
    <div class="container clearfix you_may_link_cntr">
        <h3 style="text-align:center">Popular Products</h3>
<div class="you_may_like-content">
	<div class="col-md-4">
                  		<div class="pro_secone">
                  		<a href="http://localhost/carpetcall/product/ber-1622-65-120/" class="cc-product-item-image-link"><div class="img_cntr" style="background-image:url('http://localhost/carpetcall/wp-content/uploads/2016/06/BER_1622_65_V.jpg');"></div></a>
                  
                    <!--img src="http://localhost/carpetcall/wp-content/uploads/2016/06/BER_1622_65_V.jpg" alt="BER.1622.65.120" class="img-responsive"/-->
                    <div class="mero_itemss">
                      		<div class="proabtxt">
					 <a href="http://localhost/carpetcall/product/ber-1622-65-120/" class="cc-product-item-title-link"><h4>
					BERLIN					</h4></a><h6> FROM A$195</h6></div>
					<div class="clearfix"></div>
                           
                      </div>
                      </div>
                      </div><div class="col-md-4">
                  		<div class="pro_secone">
                  		<a href="http://localhost/carpetcall/product/ber-1622-65-120/" class="cc-product-item-image-link"><div class="img_cntr" style="background-image:url('http://localhost/carpetcall/wp-content/uploads/2016/06/BER_1622_65_V.jpg');"></div></a>
                  
                    <!--img src="http://localhost/carpetcall/wp-content/uploads/2016/06/BER_1622_65_V.jpg" alt="BER.1622.65.120" class="img-responsive"/-->
                    <div class="mero_itemss">
                      		<div class="proabtxt">
					 <a href="http://localhost/carpetcall/product/ber-1622-65-120/" class="cc-product-item-title-link"><h4>
					BERLIN					</h4></a><h6> FROM A$195</h6></div>
					<div class="clearfix"></div>
                           
                      </div>
                      </div>
                      </div>
</div>
               
    </div>
    </div>        
        


</div>
<?php }
get_footer();
?>