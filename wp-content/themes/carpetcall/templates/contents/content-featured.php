<?php
$tax = 'product_cat';
 ?><?php
						$tax_terms = get_terms($tax);

					 $args=array(
					'post_type' => 'product',
					'post_status' => 'publish',
					'posts_per_page' => -1,
					'ignore_sticky_posts'=> 1,
					'tax_query' 	=>array(
										array(
											'taxonomy'=>'product_cat',
											'field'	=>'slug',
											'terms'		=>array('rugs','hard-flooring','carpets'),
											'include_children'=>true,
											'operator'	=>'IN'
										)
									)
					);
					//echo $tax_term->slug;
					$my_query = null;
					$my_query = new WP_Query($args);
					while ($my_query->have_posts()) : $my_query->the_post();
					$woo=get_post_meta($post->ID);
					$price=$woo['_regular_price'][0];
					
				
					$feat_image = cc_custom_get_feat_img(get_the_ID(),'medium');
						
								
								//$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
				
				//$feat_image = get_template_directory_uri().'/images/placeholder.png';
				
					/*if(!empty(unserialize($woo['_product_attributes'][0])))
				$prounits=unserialize($woo['_product_attributes'][0]);*/

				if(isset($prounits['size']['value'])){
					$prounit=$prounits['size']['value'];
				}
               ?>
                     <?php  if(($woo['_featured'][0]=='yes') && (strcasecmp($woo['_stock_status'][0],'instock')==0)){ ?>
                   <div class="pro_for"><a href="<?php echo the_permalink(); ?>" >
                  <?php if($feat_image!=''){?>
                  <div class="img_cntr_home" style="background-image:url('<?php echo $feat_image; ?>');"></div>
                  <?php }
                  else{ ?>
                  <div class="img_cntr cc-featured_no_image" style="background-image:url('http://staging.carpetcall.com.au/wp-content/plugins/woocommerce/assets/images/placeholder.png');"></div>
                  <?php }?>
                  </a>
                    <div class="sublk_prom">
                      		<div class="ptxt">
					<h3><a href="<?php echo the_permalink(); ?>" ><?php
					the_title();?></a></h3><?php 

					$reqTempTerms=get_the_terms($post->ID,'product_cat');
					

					if(!empty($reqTempTerms)){
						foreach($reqTempTerms as $reqTerm){ 
						  if($reqTerm->term_id!=20)
						  { 
						  	echo '<h4>'.$reqTerm->name.'</h4>';
					 	
					 }
						  	
						  }
					}
						  

					
					if(!empty($price)){
						echo '<h5> $'.$price;?>
						<?php /*if(!empty($prounit)){
 	echo '/'.$prounit;
 }*/
						echo '</h5>';
					}?></div>
					<div class="clearfix"></div>
                           <div class="nowsp nowspp"><a href="<?php echo the_permalink(); ?>" > SHOP NOW </a></div><div class="clearfix"></div> 
                      </div><div class="clearfix"></div>
                      </div>
                      <?php }?>
					
               <?php

					endwhile;
					wp_reset_query();
					?>
					