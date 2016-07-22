<?php
$tax = 'product_cat';
 ?><?php
						$tax_terms = get_terms($tax);

					 $args=array(
					'post_type' => 'product',
					
					'post_status' => 'publish',
					'posts_per_page' => -1,
					'ignore_sticky_posts'=> 1
					);
					//echo $tax_term->slug;
					$my_query = null;
					$my_query = new WP_Query($args);
					while ($my_query->have_posts()) : $my_query->the_post();
					$woo=get_post_meta($post->ID);
					
					$price=$woo['_regular_price'][0];
					
				
					$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
				
				
					/*if(!empty(unserialize($woo['_product_attributes'][0])))
				$prounits=unserialize($woo['_product_attributes'][0]);*/

				if(isset($prounits['size']['value'])){
					$prounit=$prounits['size']['value'];
				}
               ?>
                     <?php  if($woo['_featured'][0]=='yes'){ ?>
                   <div class="pro_for">
                  <?php if($feat_image!=''){?>
                  <div class="img_cntr" style="background-image:url('<?php echo $feat_image; ?>');"></div>
                  <?php }
                  else{ ?>
                  <div class="img_cntr cc-featured_no_image" style="background-image:url('http://staging.carpetcall.com.au/wp-content/plugins/woocommerce/assets/images/placeholder.png');"></div>
                  <?php }?>
                    <!--img src="<?php echo $feat_image; ?>" alt="<?php the_title();?>" class="img-responsive"/-->
                    <div class="sublk_prom">
                      		<div class="ptxt">
					<h3><?php
					the_title();?></h3><?php 

					$reqTempTerms=get_the_terms($post->ID,'product_cat');
					

					foreach($reqTempTerms as $reqTerm){ 
						  if($reqTerm->term_id!=20)
						  { 
						  	echo '<h4>'.$reqTerm->name;?><?php 
 
						  	echo '</h4>';
					 	
					 }
						  	
						  }
						  

					
					if(!empty($price)){
						echo '<h5>A'.$price;?>
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
					