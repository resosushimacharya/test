<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php
	/**
	 * woocommerce_before_single_product hook.
	 *
	 * @hooked wc_print_notices - 10
	 */
	?><div class="container">
<div class="col-md-12">
<?php 
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>
</div></div>
<?php 

/* 
	* added section to wrap the container
	* wrapper open start 
*/
?>
<div class="container">
<div class="col-md-12">

<?php /*before-wrapper open  end */  ?>
<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
		/**
		 * woocommerce_before_single_product_summary hook.
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		
		do_action( 'woocommerce_before_single_product_summary' );?>
		
		
	
	<div class="summary entry-summary">

		<?php
			/**
			 * woocommerce_single_product_summary hook.
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 */
			do_action('cc_woocommerce_single_product_summary');
			do_action( 'woocommerce_single_product_summary' );
            do_action('cc_woocommerce_single_product_summary_remove');
    //do_action('cc_after_select_design_start');

             //do_action( 'woocommerce_single_product_summary' );
			// remove action woocommerce_single_product_summary
			// add action cc_woocommerce_single_product_summary
			// insert woocommerce_output_related_products();
			
			
		
		?>
     <?php 
      /**
       *Select a design section 
       *here we show the related products image and links
      */ ?>
      <div class="cc-related-product-design-section">

      <h3>SELECT A DESIGN</h3>
      <div class="col-md-12">
      <?php 
       $strsizes= array();
           $reqTempTerms=get_the_terms($post->ID,'product_cat');

   
            if($reqTempTerms){
            	
           foreach($reqTempTerms as $cat){
           	$has_sub_cat=get_terms(array('parent'=>$cat->term_id,'taxonomy'=>'product_cat'));
           	
              if(count($has_sub_cat)==0){
						$current_post_term_id = $cat->term_id;
						wp_reset_query();
						$args = array('post_type'=>'product','posts_per_pages'=>'4',
							'taxonomy'=>'product_cat','term'=>$cat->slug);
						$loop = new WP_Query($args);
						$i=0;
						while($loop->have_posts())
						{?><div class="col-md-3">
                         <?php   $loop->the_post();
							
							//echo '<br>';$post->ID;?>
							<a href="<?php the_permalink()?>">
							<?php the_post_thumbnail( );?>
							</a>
							</div>
						<?php 
						$productsize = get_post_meta($post->ID);
						
                         $length= get_post_meta( $post->ID, '_length', TRUE );
	                     $width= get_post_meta( $post->ID, '_width', TRUE );
	                     $height= get_post_meta( $post->ID, '_height', TRUE );
	                     $price = get_post_meta($post->ID,'_sale_price',TRUE);
	                     $productsize   = $length.'CM X '. $length.'CM - $'.$price;  
	                     $strsizes[$i] =array($productsize,get_the_permalink(),$post->ID);
	                      $i++;
					}
					wp_reset_query();

}     	
                   
                   
                   
                   }
               }
              
                 ?>
                 </div>
      </div>
      <?php $pro = get_post_meta($post->ID);
      global $post;
      
       ?>
      <?php if(strcasecmp($pro['_stock_status'][0],'instock')!=0){?><div>
      <h3> OUT OF STOCK</h3>
      <?php do_action('cc_after_select_design_start');  do_action( 'woocommerce_single_product_summary' ); ?>
      </div><?php }?>
      <div class="cc-size-quantity-section">
      <div class="cc-size-section col-md-12">
      <h3>AVAILABLE SIZES</h3>
      <select class="selectpicker col-md-10" name="cc-size" id="cc-size" onchange="location = this.value;" >
      <?php foreach($strsizes as $ss):?>
      
       <option <?php echo ($ss[2]==$post->ID?'selected="selected"':'');?> class="col-md-12" value="<?php echo $ss[1];?>"><?php echo $ss[0];?></option>
     
     <?php  endforeach ;?>
   


</select>



      </div>
      <div class="cc-quantiy-section col-md-12">
      <h3>QUANTITY</h3>

      	<?php do_action('cc_size_quantity');
      	 
      	 $x=do_shortcode('[add_to_cart_url id="'.$post->ID.'"]');
      	 ?>
      	 <?php  do_action( 'cc_custom_quantiy' );?>
      	 <div class="cc-quantiy-section-inner">
      	 <a href="<?php echo $x ;?>" data-quantity="1" data-product_id="<?php echo $post->ID;?>" data-product_sku="<?php
      	  echo $pro['_sku'][0] ; ?>" class="button product_type_simple add_to_cart_button ajax_add_to_cart col-md-12" id="store-count-quantity" >ADD TO CART</a>
      	  </div>
      	  </div>
      </div>
      <div class="clearfix"></div>
     
      <div class="cc-product-enquiry col-md-12">
      	<button type="button" class="btn btn-default col-md-12"> Enquiry NOW</button>
      </div>
      <div class="cc-product-ship-free-section col-md-12">
      <div class="col-md-6">SHIPPING</div><div class="col-md-6"> FREE DELIVERY</div>
      </div>
      <div class="cc-product-pick-location-section col-md-12">
      <div class="col-md-6">PICK UP</div><div class="col-md-6"><button type="button" class="btn btn-default col-md-12"> PICK UP LOCATION</button></div>
      </div>
	</div><!-- .summary -->

	<?php
		/**
		 * woocommerce_after_single_product_summary hook.
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
		//woocommerce_output_product_data_tabs();
		
		// as per design , this section appears in [] page
		
	?>

	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->
<?php /* added section to wrap the container
wrapper close start */?>

</div></div>
<?php /* before-wrapper close end*/?>
<?php do_action( 'woocommerce_after_single_product' ); ?>
<div class="container clearfix">
<div class="inerblock_serc">
<div class="col-md-12"><h3 style="text-align:center">YOU MAY ALSO LIKE</h3></div>
<div class="col-md-12">
<?php               wp_reset_query();




                    global $post;

                    
					$reqTempTerms=get_the_terms($post->ID,'product_cat');
					//do_action('pr',$reqTempTerms);
					foreach($reqTempTerms as $cat){
						//echo $cat->parent;
						if($cat->parent==0){
							$args = array(
       'hide_empty'         => 0,
       'orderby'            => 'id',
       'show_count'         => 0,
       'use_desc_for_title' => 0,
       'child_of'           => $cat->term_id
      );
      $terms = get_terms( 'product_cat', $args );
                           // do_action('pr',$terms);
                            
						}
					}
					shuffle($terms);
                        $i=1;
					foreach($terms as $term){


						if($current_post_term_id!=$term->term_id){
							
							$has_sub_cat=get_terms(array('parent'=>$term->term_id,'taxonomy'=>'product_cat'));
								if(count($has_sub_cat)==0){
                                        if($i<=3){
									//do_action('pr',$term);
                                        	
									$filargs = array(
													'post_type'=>'product',
													'posts_per_page'=>'1',
													'meta_key'=>'_sale_price',
													'orderby' => 'meta_value_num',
													 'order'     => 'ASC',
													'tax_query' => array(
																		array(
																			'taxonomy' => 'product_cat',
																			'field'    => 'term_id',
																			'terms'    => $term->term_id,
																		),
																	),
																
													);
									 wp_reset_postdata();
								$filloop = new WP_Query($filargs);
								 //do_action('pr',$filloop);
								$hold = 1;
								if($filloop->have_posts()){
									while($filloop->have_posts()):
										$filloop->the_post();

											/*var_dump($filloop->post->ID);*/


									?><div class="col-md-4 cc-other-term-pro">
										<?php the_post_thumbnail();
										
										
										$woo=get_post_meta($filloop->post->ID);
										//do_action('pr',$woo);
					                     // echo $post->ID;
										echo '<h3>'.$term->name.'</h3>';
										echo "<h5>FROM A$".$woo['_sale_price'][0].'</h5>';


										?>
										</div>


								<?php endwhile;?>
                     		<?php 
                     		wp_reset_query(); }
                     		
							$i++;
                     				}
								}


							
                    

						}


					}
			

 ?>



</div>

<div class="col-md-12">


<?php
$tax = 'product_cat';


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
                   <div class="col-md-4">
                  
                  		<div class="img_cntr" style="background-image:url('<?php echo $feat_image; ?>');"></div>
                  
                    <!--img src="<?php echo $feat_image; ?>" alt="<?php the_title();?>" class="img-responsive"/-->
                    <div class="sublk_prom">
                      		<div class="ptxt">
					<h3><?php
					the_title();?></h3><?php 

					

					

					
					if(!empty($price)){
						echo '<h5> FROM A$'.$price.'</h5>';
						
						}?></div>
					<div class="clearfix"></div>
                           
                      </div>
                      </div>
                      <?php }?>
					
               <?php

					endwhile;
					wp_reset_query();
					?><div class="clearfix"></div>
					</div></div>
					</div>
