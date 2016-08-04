<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>
 <?php 
	$current_cat = get_term_by('slug',get_query_var('product_cat'),'product_cat');
	$ancestors = get_ancestors( $current_cat->term_id, 'product_cat' );
	$depth = count($ancestors) ; 
	if($depth == 2 ){
		//We will only have template for depth level 0 and 1, third level category won't be listed here
		return ;
		}
	?>
    

<div class="contaniner clearfix">	<div class="inerblock_seC_mrugss">
<div class="container-fluid mmrugm"><div class="container">
<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>
	<h3>
    <?php if($depth > 0){?>
    <span class="ab_arrow"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
    <?php } ?>
    
	<?php echo single_cat_title('',false).' '.$appafter;?>
	<?php 
	/*
while(have_posts()):
  the_post();
the_title();
endwhile;
*/
?>
</h3>
<?php 
if(get_term_meta($current_cat->term_id,'cat_top_description',true) && $depth == 0){
	?>
	<p class="category_description"><?php echo get_term_meta($current_cat->term_id,'cat_top_description',true)?></p>
	<?php }?>
    </div></div>
    
    
    
<div class="container">

       
    
<div class="tophead_sec col-md-12 no-lr">
<?php $term_id =  get_queried_object()->term_id;
$currentcat = get_queried_object();
 
?>
<div class="rugm-blk col-md-6 no-pl">
	<p>
		<span class="cc-cat-title-count">
			<?php echo $currentcat->count;?>
			<?php echo single_cat_title('',false).' '.$appafter;?>
			Products 
		</span>
		<span class="cc-count-clear"><a href="javascript:void(0)">CLEAR ALL</a></span>
	</p>
	
</div>

<div class="col-md-6 no-pr">
<div class="pull-right cc-product-sort">
	<?php do_action( 'woocommerce_before_shop_loop' ); ?>
	 </div>
</div>
</div>


<div class="cc-cat-pro-section-left col-md-3 no-lr">

<?php get_sidebar('pro-subcategory');?>


</div>
<div class="col-md-9 cc-cat-pro-section-right">
	

<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) {
	$args = array(
		'cat_id' =>$current_cat->term_id,
		'offset'=>0,
		'perpage'=>4,
		'sort_by'	=>'price',
		'sort_order'=>'ASC',
		'depth'	=>$depth,
		'child_cat_count'=>1
	);
	 ?>
<div id="category_slider_block_wrapper">
	<?php $ret = show_category_slider_block($args);
	echo $ret['html'];
	?>
</div>
			
			
			<?php 
			/*
			 global $wp_query;
			 $term_id_sub =  get_queried_object()->term_id;
			 $term_name = get_queried_object()->name;
			 $discats=get_terms(array('parent'=>$term_id,'taxonomy'=>'product_cat'));
                        
				$loopcounter = 0;?> <?php 
                            foreach($discats as $discat){
                            	if($loopcounter==2){
                            		break;
                            	}
                            	$loopcounter++;
                            	?>
                          <div class="row cc-cat-sub-title-price-cover">
                            		<div class="col-md-6 cc-cat-sub-title"><h4><?php woocommerce_page_title();?></h4>
                            		<?php
                            	echo '<h3>'.$discat->name.'</h3><br/>';
                            	 ?>
                            	</div>
                            
                            	
                            	<?php 

									$filargs = array(
													'post_type'=>'product',
													'posts_per_page'=>'10',
													'meta_key'=>'_sale_price',
													'orderby' => 'meta_value_num',
													'order'     => 'ASC',
													'tax_query' => array(
																		array(
																			'taxonomy' => 'product_cat',
																			'field'    => 'term_id',
																			'terms'    => $discat->term_id,
																		),
																	),
																
													);
									 wp_reset_postdata();
									 $pch = 1;
								$filloop = new WP_Query($filargs);
									$hold = 1;
                                    ?>
                                       <?php 

								if($filloop->have_posts()){
									$slidercounter = 1;
									while($filloop->have_posts()):
										$filloop->the_post();
 										 $feat_image = wp_get_attachment_url( get_post_thumbnail_id($filloop->post->ID) );
											

                                          if($pch==1){
                                             $res = get_post_meta($post->ID ,'_sale_price',true);
                                             echo '<div class="col-md-6 cc-cat-sub-price">From <span>A$'.$res.'</span></div></div> <div class="row cc-cat-sub-carousal-a">';

                                             $pch++;
                                             
                                          }
                                          if($slidercounter<=5){
                                          	if($slidercounter==1){
                                          		echo '<div class="cat_slider">';

                                          	}
                                          ?> <div class="cat_slider_item ">
                                          	<div class="cat_slider_item_image" style="background-image:url(<?php echo $feat_image ;?>)"></div>
                                          </div>
                                             <?php 
                                             if($slidercounter==5){
                                             	echo '</div>';
                                             }
                                                $slidercounter++;

                                          }
                                          endwhile;
                                          wp_reset_query();
                                      }
                                      
									?>
									<div class=" cc-cat-sub-group-item">
                                    <?php 

								if($filloop->have_posts()){
									$slidercounter = 1;
									while($filloop->have_posts()):
										$filloop->the_post();
 										 $feat_image = wp_get_attachment_url( get_post_thumbnail_id($filloop->post->ID) );
											

                                        

									?><div class=" cc-other-term-pro">
									<div class="cc-img-wrapper"><div class="cat-item-group-image" style="background-image:url(<?php echo $feat_image;?>)">
									
										<?php
										
										
										$woo=get_post_meta($filloop->post->ID);
//										
//										echo '<h3>'.$discat->name.'</h3>';
//										echo "<h5>FROM A$".$woo['_sale_price'][0].'</h5>';


										?>
										<a href ="<?php the_permalink();?>" class="cc-pro-view">VIEW</a>
										</div>
										</div></div>


								<?php endwhile;?>
                     		<?php 
                     		wp_reset_query(); }?>
                     		</div><!--end of cc-cat-sub-group-item-->
                     		
                     		</div>
                     		<?php 
                     	}
						
						*/
			  ?>
              
		<div class="woo-added"></div>
		<input type="button" name="cc_load_more" id ="cc_load_more" value="load more"/>
		<input type="hidden" name="ajax_cat_id" id="ajax_cat_id" value="<?php echo $current_cat->term_id?>">
		<input type="hidden" name="ajax_offset" id="ajax_offset" value="<?php echo ($ret['offset'])?$ret['offset']:0?>">
		<input type="hidden" name="ajax_sort_by" id="ajax_sort_by" value="price">
		<input type="hidden" name="ajax_sort_order" id="ajax_sort_order" value="ASC">
		<input type="hidden" name="cat_depth" id="cat_depth" value="<?php echo $depth ?>">
        <input type="hidden" name="child_cat_count" id="child_cat_count" value="<?php echo ($ret['child_cat_count'])?$ret['child_cat_count']:1?>">
        <input type="hidden" name="selected_colors" id="selected_colors" value="">
        <input type="hidden" name="selected_sizes" id="selected_sizes" value="">
        <input type="hidden" name="selected_price_ranges" id="selected_price_ranges" value="">
</div>
		<?php 
		
		} 
		?>
		</div></div></div>

	<div class="inerblock_sec_a">

    <div class="container clearfix you_may_link_cntr">
        <h3 class="cc-idea-ad-title" style="text-align:center">IDEAS & ADVICE</h3>
<?php 
$prourl = site_url();
$prourl =explode('/',$prourl);
if(strcasecmp($prourl[2], 'localhost')==0){
$profaqid = '1700';
$probuyid ='1827';
$procareid ='1719';
}
else{
$profaqid = '26729';
$probuyid ='26701';
$procareid ='26713';
}
?>


                   <?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id($profaqid) );?>
                   
					<div class="you_may_like-content">
				 <div class="col-md-4">
                  		<div class="pro_secone_a">
                  		      <a href="<?php echo get_the_permalink($probuyid);?>"> <div class="img_cntr_a" style="background-image:url('<?php echo $feat_image; ?>');"></div></a>
                  
                    
                               <div class="mero_itemss">
                      		       <div class="proabtxt">
                      		       
					                  <a href="<?php echo get_the_permalink($probuyid);?>">  <h4>BUYING GUIDE</h4><span><?php echo get_the_title($probuyid) ;?>
					                  </span></a>
					
                                   </div> <div class="clearfix"></div>
                                 
                                </div> <div class="clearfix"></div>
                             </div>

                 </div>
                 
                 
                    <?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id($probuyid) );?>
                    
                   <div class="col-md-4">
                  		<div class="pro_secone_a">
                  		       <a href="<?php echo get_the_permalink($profaqid);?>"><div class="img_cntr_a" style="background-image:url('<?php echo $feat_image; ?>');"></div></a>
                  
                    
                               <div class="mero_itemss">
                      		       <div class="proabtxt">
                      		         
					                  <a href="<?php echo get_the_permalink($profaqid);?>"><h4>FAQ'S</h4><span><?php echo get_the_title($profaqid) ;?></span></a>
					
                                   </div><div class="clearfix"></div>
                                 
                        </div><div class="clearfix"></div>
                        
                         </div>
                 </div>
                <?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id($procareid) );?>
                
                 <div class="col-md-4">
                  		<div class="pro_secone_a">
                  		     <a href=" <?php echo get_the_permalink($procareid);?>"> <div class="img_cntr_a" style="background-image:url('<?php echo $feat_image; ?>');"></div></a>
                  
                    
                               <div class="mero_itemss">
                      		       <div class="proabtxt">
                      		         
					                  <a href="<?php echo get_the_permalink($profaqid);?>"><h4>PRODUCT CARE</h4><span><?php echo get_the_title($profaqid) ;?></span></a>
					
                                   </div><div class="clearfix"></div>
                                 
                        </div><div class="clearfix"></div>
                        
                         </div>
                 </div>
                </div><div class="clearfix"></div> 
                 
					
                    
    </div>
    </div>
    <div class="cc_background_image">

    <div class="container clearfix cc-cat-sub-desc-sec">
   <?php echo get_field('product_category_description',$current_cat);?>
<!--    <h3 style="">Modern Rugs</h3>
    <p>
   Transform your tired looking home or commercial space into a contemporary retreat with a stunning, high quality rug from Carpet Call’s modern rugs range. From vibrant floral patterns that will really make a statement, to simple neutral shades that will blend seamlessly with your existing décor, it couldn’t be any simpler for you to update your living or working space with one of our designer modern rugs.
</p>
     <p>
    Our beautiful rug collections are added to and updated frequently, so make sure you check back often for our large range of contemporary carpet rugs at fantastic prices. Our modern rugs are available both in-store and online for your convenience, with free shipping Australia wide.
    </p>
     <p>
    Find a Carpet Call store near you, or buy rugs online today! For more information about choosing and buying the perfect new rug for your home, check out our detailed Rugs Buying Guide or get in touch with one of our dedicated flooring specialists.
    </p>
-->    
    </div>
    </div>

<style>

</style>
<?php get_footer();?>
