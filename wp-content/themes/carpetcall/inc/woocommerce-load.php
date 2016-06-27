<?php 
/**
*To load the next category terms
*recieve offset value to control the category term 
*cc_count
*/
function woo_load(){
echo '<div class="row">';
 $cc_count = $_POST['count'];
 $catname = $_POST['catname'];
 $cc_term_id = $_POST['catid'];
     
 
     
    global $wp_query;
     $counter  = 1;
  

    $descats=get_terms(array('parent'=>$cc_term_id,'taxonomy'=>'product_cat'));
    

    foreach($descats as $descat){
    	if($counter>=2){?>
    		 <div class="row ">
                            		<div class="col-md-6"><h3><?php echo  $catname;?></h3><br />
                            		<?php
                            	echo '<h3>'.$descat->name.'</h3><br/>';
                            	echo $term_id; ?>
                            	</div>
                            
                            	
                            	<?php 
                                    wp_reset_query();
									$filarg = array(
													'post_type'=>'product',
													'posts_per_page'=>'10',
													'meta_key'=>'_sale_price',
													'orderby' => 'meta_value_num',
													 'order'     => 'ASC',
													'tax_query' => array(
																		array(
																			'taxonomy' => 'product_cat',
																			'field'    => 'term_id',
																			'terms'    => $descat->term_id,
																		),
																	),
																
													);
									 wp_reset_postdata();
									 $pch = 1;
								$loop = new WP_Query($filarg);
									$hold = 1;
                                    
								if($loop->have_posts()){
									while($loop->have_posts()):
										$loop->the_post();

 										 $feat_image = wp_get_attachment_url( get_post_thumbnail_id($loop->post->ID) );
											
                                          ?>
                                          <?php  
                                          if($pch==1){
                                             //$res = get_post_meta($loop->$post->ID ,'_sale_price',true);
                                             $woo=get_post_meta($loop->post->ID);
                                            

                                             echo '<div class="col-md-6">From A$'.$woo['_sale_price'][0].'</div></div> <div class="row">';

                                             $pch++;
                                          }

									?><div class="col-md-4 cc-other-term-pro">
									<div class="cc-img-wrapper">
									<img src="<?php echo $feat_image;?>"/>
								
										<a href ="<?php the_permalink();?>" class="cc-pro-view">VIEW</a>
										</div>
										</div>


								<?php endwhile;?>
                     		<?php 
                     		wp_reset_query(); }?>
                     		
                     		</div><?php 
	    
     	
    }
    $counter++; }
     echo '</div>';

    
 
die();

} 
add_action('wp_ajax_woo_load', 'woo_load');
add_action('wp_ajax_nopriv_woo_load', 'woo_load');


add_action( 'wp_enqueue_scripts', 'wooocommerce_scripts' );
function wooocommerce_scripts(){
	wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js', '',true);
		wp_enqueue_script('jquery');
	wp_register_script('woo-load-autocomplete', get_template_directory_uri(). '/js/woocommerce.load.js', '',true);

wp_enqueue_script('woo-load-autocomplete');
wp_localize_script( 'woo-load-autocomplete', 'woo_load_autocomplete', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}