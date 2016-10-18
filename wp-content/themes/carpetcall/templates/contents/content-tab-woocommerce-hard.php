




<?php $prourl = site_url();
      $prourl =explode('/',$prourl);
      if(strcasecmp($prourl[2], 'localhost')==0){
      	$profaqid = '1725';
      }
      else{
      	$profaqid = '26721';

      }
      ?>
      

     
			
<?php
global $post;
$listcat=get_the_terms($post->ID,'product_cat');



foreach($listcat as $cat){
	if($cat->parent==0){
		//echo "that's the correct answer";
		$root = $cat->slug;
		$rootname = $cat->name;
		if(strcasecmp($root,'hard-flooring')==0){
		$root =	'hard-floor';
		}
	}
	else{
		//echo "that's the bullshit answer";
	}
}
$args = array(
    'post_type'      => 'page',
    'posts_per_page' => -1,
    'post_parent'    => $profaqid,
    'order'          => 'ASC',
    'orderby'        => 'menu_order',
    'name' => $root

 );


$parent = new WP_Query( $args );
while($parent->have_posts()){
    $parent->the_post();
    $faqid =$post->ID;

}
wp_reset_query();

$list = get_field('buying_guide_archive',$faqid );

?>



			 <div class="panel-group single-produc-acc-cntr" id="single-product-acc">
		 <!-- accessories section start -->
          <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#single-product-acc" href="#collapseAccessories"> Accessories
                        </a>
                    </h4>
                </div>
                <?php  global $product;
    $current_loaded_product = $product;
    $accessory_term_obj = get_term_by('slug','accessories','product_cat');
    $acc_cats = get_terms(
                    'product_cat',
                    array(
                        'parent' => $accessory_term_obj->term_id,
                        'hide_empty'=>false,
                    )
                );?>
                <?php if(!empty($acc_cats)){?>
    
             <div class="panel-collapse collapse accessories_select_mobile_cntr" id="collapseAccessories">

                    <div class="access_active_type_cntr">
                        <div class="access_tab_active">
                            <span class="access_active_text"></span>
                        </div>
                     <ul class="nav nav-tabs accessories_inner_tab_select" role="tablist">  
                        
                      
     <?php
     $count = 1;
        foreach($acc_cats as $acc_cat){?>
                 
                 <li role="presentation" class="<?php echo ($count==1)?"active":"" ;?>"><a href="#cc_mob_acc_drop_<?php echo $count ; ?>" aria-controls="<?php echo $acc_cat->name;?>" role="tab" data-toggle="tab"><?php echo $acc_cat->name;?></a></li>
          <?php
          
          $count++;  } 

      } ?>
      </ul> 
      </div>
       <div class="tab-content">
        <?php if(!empty($acc_cats)){?>
        <?php
     $count = 1;
        foreach($acc_cats as $acc_cat){?>
       <div role="tabpanel" class="tab-pane tab-accessories-first <?php echo ($count==1)?"active":"" ;?>" id="cc_mob_acc_drop_<?php echo $count ; ?>">
                                
                                    <?php
                                        $acc_products = get_posts(
                                                            array(
                                                                'posts_per_page' => -1,
                                                                'post_type' => 'product',
                                                                'tax_query' => array(
                                                                    array(
                                                                        'taxonomy' => 'product_cat',
                                                                        'field' => 'term_id',
                                                                        'terms' => $acc_cat->term_id,
                                                                    )
                                                                )
                                                            )
                                                        );
                                    //do_action('pr',$acc_products);
                                    global $post;
                                    $parent = $post;
                                    if(!empty($acc_products)){
                                        wp_reset_postdata();
                                        foreach($acc_products as $acc_product){
                                            global $post,$product;
                                            $product  = wc_get_product($acc_product->ID);
                                            $post = get_post($acc_product);
                                            setup_postdata($post);
                                            if(has_post_thumbnail($acc_product->ID)){
                                                            $acc_feat_img = get_the_post_thumbnail_url($acc_product->ID,'thumbnail');
                                                        }else{
                                                            $acc_feat_img = get_template_directory_uri().'/images/placeholder.png';
                                                            }?>
                                            
                            <div class="acc_list_item col-md-3 <?php echo $acc_cat->slug?>">
                                <div class="accessories_innner_wrap">
                                    <div class="acc_info_wrap" data-toggle="modal" data-target="#accinfo_<?php echo get_the_ID()?>_<?php echo $acc_cat->slug;?>">
                                        <div class="acc_thumb" style="background-image:url(<?php echo $acc_feat_img;?>)"></div>
                                        <h3 class="acc_title_n_cat">
                                             <span class="acc_title"><a href="javascript:void(0)"><?php _e($acc_product->post_title,'carpetcall');?></a></span> 
                                            <span class="acc_subcat">
                                            <?php 
                                            $categories = get_the_terms($acc_product->ID, 'product_cat' ); 
                                            // wrapper to hide any errors from top level categories or products without category
                                            if ( $categories ) : 
                                                // loop through each cat
                                                foreach($categories as $category) :
                                                
                                                  // get the children (if any) of the current cat
                                                  $children = get_categories( array ('taxonomy' => 'product_cat', 'parent' => $category->term_id ));
                                                  if ( count($children) == 0 ) {
                                                      // if no children, then echo the category name.
                                                      echo '<a href="javascript:void(0)">'.$category->name.'</a>';
                                                      break;
                                                  }
                                                endforeach;
                                            
                                            endif;
                                            
                                            ?>
                                            
                                            </span>
                                        </h3>
                                   
                                        <span class="acc_price small_price">
                                            <?php echo $product->get_price_html();?>
                                        </span>
                                    </div>
                                    <div class="acc_qnty">
                                        <?php 
                                        if($acc_cat->slug == 'underlay'){
                                        $tpm_ratio = get_field('tpm_ratio',get_the_ID())?get_field('tpm_ratio',get_the_ID()):1; 
                                        $rec_qty = ceil(get_field('size_m2',$current_loaded_product->id)/(get_field('tpm_ratio',get_the_ID())?get_field('tpm_ratio',get_the_ID()):1));
                                        
                                        }else{
                                            $rec_qty='';}?>
                                            <div class="rec_qty_wrap"><span class="acc_qty_lbl"><?php echo ($rec_qty=='')?'':'Rec'?> Qty: </span> 
                                                <span class="acc_rec_qty" tpm_ratio="<?php echo $tpm_ratio?>"><?php echo $rec_qty?></span>
                                            </div>
                                            <?php
                                                echo woocommerce_quantity_input( array( 'min_value' => 0, 'max_value' => $product->backorders_allowed() ? '' : max(100,$product->get_stock_quantity())) );
                                        ?>
                                    </div>
                                    <?php $x=do_shortcode('[add_to_cart_url id="'.$acc_product->ID.'"]');?>
                                   <div class="access-add-to-cart-btn">
                                    <a link="<?php echo get_permalink($acc_product->ID)?>" href="<?php echo $x ;?>" data-quantity="0" data-product_id="<?php echo $acc_product->ID;?>" class="button product_type_simple col-md-12 add_to_cart_button ajax_add_to_cart acc_add_to_cart" >ADD TO CART
                                    </a>
                                    </div>
                                    
                                    <div class="modal fade" tabindex="-1" role="dialog" id="accinfo_<?php echo get_the_ID()?>_<?php echo $acc_cat->slug;?>">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <span aria-hidden="true" class="close" data-dismiss="modal">&times;</span>
                                                    <h4 class="modal-title"><?php the_title()?></h4>
                                                </div>
                                                <div class="modal-body">
                                                    <?php the_content();?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
               




                
              
                            
                            <?php 
                            wp_reset_postdata();
                            }?>
                                 
                            <?php
                        }
                    
                    
                    ?>
                    
                            
                            
                   
                    </div>





        <?php
          
          $count++;  } 

      } ?>
       </div>
      </div>

               </div>

		 <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#single-product-acc" href="#deatials_mobile"> Details
                        </a>
                    </h4>
                </div>
                <div id="deatials_mobile" class="panel-collapse collapse ">
                    <div class="panel-body"> 
                    <?php  	 echo '<h2 class="detail-heading-item">Overview</h2>';
							$d1 = get_field('description_1',$post->ID);
							$d2 = get_field('description_2',$post->ID);
							$d3 = get_field('description_3',$post->ID);
							$d4 = get_field('description_4',$post->ID);
							$yarn=get_field('yarn_type',$post->ID);
							$length= get_post_meta( $post->ID, '_length', TRUE );
							$width= get_post_meta( $post->ID, '_width', TRUE );
							$height= get_post_meta( $post->ID, '_height', TRUE );
							$weight= get_post_meta( $post->ID, '_weight', TRUE );
							if(!empty($d1)){
							echo '<p>'.$d1.'</p>';
							}
							if(!empty($d2)){
							echo '<p>'.$d2.'</p>';
							}
							if(!empty($d3)){
							echo '<p>'.$d3.'</p>';
							}
							if(!empty($d4)){
							echo '<p>'.$d4.'</p>';
							}
							echo '<h3 class="detail-heading-item-spec">SPECIFICATIONS</h3>';?>
							<ul class="specific-list">
							<?php if(!empty($yarn)){?>
							<li><span>Yarn Type : </span><?php echo $yarn; ?></li><?php }?>
							<?php if(!empty($length) && !empty($width) && !empty($height)) {?>
							<li><span>Size : </span><?php echo $length.'cm x '.$width." ".$height;?> 
							</li>
							<?php }?>
							<?php if(!empty($weight)){?>
							<li><span>Weight : </span><?php echo $weight." kg"; ?> </li>
							<?php }?>
							</ul>
					</div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#single-product-acc" href="#collapseOne"> Specifications
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse ">
                    <div class="panel-body">  

                   <?php   wp_reset_postdata();
    global $post,$product;
    echo '<h3 class="detail-heading-item-spec">Product Specifications</h3>';?>
    <table class="product_specifications_table">
        <tr>
            <td class="spec_label"><?php _e('Country of Origin Manufacture','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('country_of_origin_manufacture')?></td>
        </tr>
        <tr>
            <td class="spec_label"><?php _e('Colour','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('species__colour_decore')?></td>
        </tr>
        <tr>
            <td class="spec_label"><?php _e('Price per pack','carptecall')?></td>
            <td class="specs_value"><?php echo $product->get_price();?></td>
        </tr>
        <tr>
            <td class="spec_label"><?php _e('Boards per pack','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('boards_per_pack')?></td>
        </tr>
        <tr>
            <td class="spec_label"><?php _e('Coverage per pack','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('size_m2')?></td>
        </tr>
        <tr>
            <td class="spec_label"><?php _e('Product - Length','carptecall')?></td>
            <td class="specs_value"><?php echo get_post_meta( $post->ID, '_length', TRUE );?></td>
        </tr>
        <tr>
            <td class="spec_label"><?php _e('Product - Width','carptecall')?></td>
            <td class="specs_value"><?php echo $width= get_post_meta( $post->ID, '_width', TRUE );?></td>
        </tr>
        <tr>
            <td class="spec_label"><?php _e('Product - Thickness Veneer','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('product_thickness_veneer')?></td>
        </tr>
        <tr>
            <td class="spec_label"><?php _e('Product - Thickness Total','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('pack_thickness')?></td>
        </tr>
        <tr>
            <td class="spec_label"><?php _e('Pack - Length','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('pack_length')?></td>
        </tr>
        <tr>
            <td class="spec_label"><?php _e('Pack - Width','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('pack_width')?></td>
        </tr>
        <tr>
            <td class="spec_label"><?php _e('Pack - Weight','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('pack_weight')?></td>
        </tr>
        <tr>
            <td class="spec_label"><?php _e('Underlay Options','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('underlay_options')?></td>
        </tr>
        <tr>
            <td class="spec_label"><?php _e('Board Type','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('board_type')?></td>
        </tr>
        <tr>
            <td class="spec_label"><?php _e('Supplier','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('supplier')?></td>
        </tr>
        <tr>
            <td class="spec_label"><?php _e('Installation options','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('installation_options')?></td>
        </tr>
        <tr>
            <td class="spec_label"><?php _e('Underlay Options','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('species_colour_decore')?></td>
        </tr>
        <tr>
            <td class="spec_label"><?php _e('Glue Options','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('glue_options')?></td>
        </tr>
        <tr>
            <td class="spec_label"><?php _e('Scotia Options','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('scotia_options')?></td>
        </tr>
        <tr>
            <td class="spec_label"><?php _e('Accessories','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('accessories')?></td>
        </tr>
        <tr>
            <td class="spec_label"><?php _e('Edge Type','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('edge_type')?></td>
        </tr>
        <tr>
            <td class="spec_label"><?php _e('Joint System','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('joint_system')?></td>
        </tr>
        <tr>
            <td class="spec_label"><?php _e('Surface Finish','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('surface_finish')?></td>
        </tr>
        <tr>
            <td class="spec_label"><?php _e('Janka Rating','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('janka_rating')?></td>
        </tr>
        <tr>
            <td class="spec_label"><?php _e('Structural Warranty','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('structural_warranty')?></td>
        </tr>
        <tr>
            <td class="spec_label"><?php _e('Wear Layer Warranty','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('wear_layer_warranty')?></td>
        </tr>
        <tr>
            <td class="spec_label"><?php _e('Construction Style','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('construction_style')?></td>
        </tr>
        <tr>
            <td class="spec_label"><?php _e('Recommended Use','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('species__colour_decore')?></td>
        </tr>
        <tr>
            <td class="spec_label"><?php _e('Recommended Areas of Use','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('recommended_use')?></td>
        </tr>
        <tr>
            <td class="spec_label"><?php _e('Standards - Coating','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('coating')?></td>
        </tr>
        <tr>
            <td class="spec_label"><?php _e('Standards - AC Rating','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('ac_rating')?></td>
        </tr>
        <tr>
            <td class="spec_label"><?php _e('Standards - Core Type','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('core_type')?></td>
        </tr>
        <tr>
            <td class="spec_label"><?php _e('Standards - Anti Slip Test','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('anti_slip_test')?></td>
        </tr>
        <tr>
            <td class="spec_label"><?php _e('Standards - Base','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('base')?></td>
        </tr>
        <tr>
            <td class="spec_label"><?php _e('ISO Certification','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('iso_certification')?></td>
        </tr>
        <tr>
            <td class="spec_label"><?php _e('Trim Options','carptecall')?></td>
            <td class="specs_value"><?php echo get_field('trim_options')?></td>
        </tr>
        <tr>
            <td class="spec_label"><?php _e('Instructional Video','carptecall')?></td>
            <td class="specs_value">
            <?php 
            if(get_field('instructional_video')){
                echo get_field('instructional_video');
                //echo wp_video_shortcode(array('src'=> get_field('instructional_video')));
            }?>
            
            </td>
        </tr>
    </table>

                    </div>
                </div>
            </div>
           <!-- guide section start -->

        <?php global $post;
    $installation_guide = get_field('installation_options');
    $maintainance_guide = get_field('care_instructions');
    ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#single-product-acc" href="#collapseThree">GUIDES
                        </a>
                    </h4>
                </div>
                <div id="collapseThree" class="panel-collapse collapse">
                    <div class="panel-body">
                        
                           
                            <div class="panel-group" id="accordionguide">
                         
                    
                    
                    
                                <div class="panel">
                                    <div class="panel-heading">
                                    <a data-toggle="collapse" data-parent="#accordionguide" href="#collapse_mobile_guide_1"> <?php _e('INSTALLATION GUIDE','carpetcall');?>
                                    </a>
                                    </div>
                                    <div id="collapse_mobile_guide_1" class="panel-collapse collapse">
                                        <div class="panel-body"><?php echo $installation_guide;?></div></div>
                                    </div>
                                </div>
                               
                                  <div class="panel">
                                    <div class="panel-heading">
                                    <a data-toggle="collapse" data-parent="#accordionguide" href="#collapse_mobile_guide_2"> <?php _e('MAINTAINANCE GUIDE','carpetcall');?>
                                    </a>
                                    </div>
                                    <div id="collapse_mobile_guide_2" class="panel-collapse collapse">
                                        <div class="panel-body"><?php echo $maintainance_guide;?></div></div>
                                    </div>
                                </div>
                            
                            </div>
                        
                    </div>
             
           <!-- guide section start -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#single-product-acc" href="#collapseTwo">FAQ'S
                        </a>
                    </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse">
                    <div class="panel-body">
                        
                           
                            <div class="panel-group" id="accordion21">
                             <?php
					
					 $faqcounter = 1;
					 ?>
					
					 <?php 
					 if($list){ 
					foreach($list as $listitem){
					

					
					
					?>
                                <div class="panel">
                                    <div class="panel-heading">
                                    <a data-toggle="collapse" data-parent="#accordion21" href="#collapse_mobile_<?php echo $faqcounter ;?>"><?php echo $listitem['title'];?>
                                    </a>
                                    </div>
                                    <div id="collapse_mobile_<?php echo $faqcounter ;?>" class="panel-collapse collapse">
                                        <div class="panel-body"><?php echo $listitem['description']; ?></div>
                                    </div>
                                </div>
                               
                            <?php 
                              $faqcounter++;
                            }
                            } ?>
                            
                            </div>
                        
                    </div>
                </div>
            </div>
                  <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#single-product-acc" href="#return_mobile"> Return Policy 
                        </a>
                    </h4>
                </div>
                <div id="return_mobile" class="panel-collapse collapse ">
                    <div class="panel-body"> 

                     <?php 
										global $post;
										
										$term = '';
										$reqTempTerms=get_the_terms($post->ID,'product_cat');
										if($reqTempTerms){
												foreach($reqTempTerms as $cat){
													if($cat->parent==0){
														$term = $cat;
														break;
														}
													}
											if($term !=''){
											$retinfo = get_term_meta($cat->term_id,'cat_return_policy',true);
											echo '<p class="returns_text">'.$retinfo.'</p>';
											}
										}
										
										/*
										$url = site_url();
										$url =explode('/',$url);

										if(strcasecmp($url[2],'localhost')==0){
										  $retID = 31856;
										 

										}
										else{
										  $retID = 33274;
										}
										$retinfo = get_field('return_policy',$retID);
										echo '<p class="returns_text">'.$retinfo.'</p>';
										*/

										?>

					</div>
                </div>
            </div>

        </div>
