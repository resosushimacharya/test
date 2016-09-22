<div class="product_single_container">
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
	?>
    <div class="container">
<div class="col-md-12 no-lr cc-checkout-woerrors">
<?php 
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>
</div>
</div>
<?php 

/* 
	* added section to wrap the container
	* wrapper open start 
*/
?>
<div class="container">
<div class="col-md-12 no-lr product-content-wrapper">


<?php
global $post;
global $product;
$product = wc_get_product($post->ID);

$reqTempTerms=get_the_terms($post->ID,'product_cat');
if($reqTempTerms){
	foreach($reqTempTerms as $cat){
		$has_sub_cat=get_terms(array('parent'=>$cat->term_id,'taxonomy'=>'product_cat'));
		if(count($has_sub_cat)==0){
			global $current_post_term_id;
			$current_post_term_id = $cat->term_id;
		}
	}
}
						
						



?>
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
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_hardflooring_price', 10 );
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_hardflooring_title', 10 );
			

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
      <div class="select-design-wrapper">
      <div class="mobile select-dropdown-wrap">
          <div class="selected-product-img">
            
          </div>
          <div class="selected-product-name">
            <span></span>
          </div>
          <div class="select-product-droparrow">
            
          </div>
        </div>
      <div class="cc-select-design-pro-all col-md-12">
      <?php
	 // global $post;
	  //$curr_post = the_post();
	  $second_lvl_cat = get_term_by('id',$current_post_term_id,'product_cat');
	/*  
	$terms = wp_get_post_terms( $post->ID, 'product_cat' );
  foreach ( $terms as $term ){
	 $children = get_term_children($term->term_id, 'product_cat'); 
	if(($term->term_id!="" && sizeof($children)==0)) {
		$cats_array[] = $term->parent;
	}
  }
  */
  $query_args = array( 'posts_per_page' => -1, 'no_found_rows' => 1, 'order_by'=>'title', 'post_status' => 'publish', 'post_type' => 'product', 'tax_query' => array( 
    array(
      'taxonomy' => 'product_cat',
      'field' => 'id',
      'terms' => $second_lvl_cat->term_id
    )));

  $related_prods = get_posts($query_args);
  if(!empty($related_prods)){
	  foreach($related_prods as $relprod){
		  //global $product;
		 // do_action('pr',$relprod);
		  //do_action('pr',get_permalink('55730'));
		//  do_action('pr',$relprod->ID.'->'.get_permalink($relprod->ID));
		  $stockcheck = get_post_meta($relprod->ID);
         if(strcasecmp($stockcheck['_stock_status'][0],'instock')==0){ 
		
		
		$imgflag = false;
		$feat_image = cc_custom_get_feat_img($relprod->ID,'small','V');
		
		/*$feat_image = get_template_directory_uri().'/images/placeholder.png';
		$sku = get_post_meta($relprod->ID,'_sku',true);
		$image_names = array(
												strtoupper($sku).'_L.jpg',
												strtoupper($sku).'_V.jpg',
												strtoupper($sku).'_S.jpg',
							);
							
		foreach($image_names as $imgname){
			$img_path =  WP_CONTENT_DIR.'/uploads/images/small/'.$imgname;
			if(file_exists($img_path)){
				$feat_image = content_url('uploads/images/small/'.$imgname);
				$imgflag = true;
				break;
			}
		}
		*/
						
						
		/*
		 $proGal = get_post_meta($relprod->ID, '_product_image_gallery', TRUE );
         $proGalId = explode(',',$proGal);
		 foreach($proGalId as $pgi){
			  $proImageName =  has_post_thumbnail($relprod->ID)?wp_get_attachment_url($pgi):get_template_directory_uri().'/images/placeholder.png';
				if(preg_match("/\_V/i", $proImageName))
				{
					$reqProImageId = $pgi;
					$proImageName =  wp_get_attachment_image_src($pgi,'thumbnail');
					if($proImageName){
						$proImageName = $proImageName[0];
						}
					break;
				}
			 
			 }
			 
			 */?>
             
             
		  <div class="select-design-product-image <?php echo  ($relprod->ID == $post->ID)?'pro-active':null?>"> 
            <a href="<?php echo get_the_permalink($relprod->ID)?>" class="select_design">
            <img class="cc-product_no_image" src="<?php echo $feat_image?>"> 
            <span class="selected-pro-name" style=""><?php echo $relprod->post_name;?></span>
            </a> 
        </div>
		  <?php }
		wp_reset_postdata();  
		  }
	  }
	  		wp_reset_postdata();  
	  		wp_reset_query();  

/*

  $related_prods = new WP_Query($query_args);
  if ( $related_prods->have_posts() ) {
		while ( $related_prods->have_posts() ) {
		$related_prods->the_post();
		global $post;
		setup_postdata($post);
		 $stockcheck = get_post_meta($post->ID);
         if(strcasecmp($stockcheck['_stock_status'][0],'instock')==0){ 
		 $proGal = get_post_meta( get_the_ID(), '_product_image_gallery', TRUE );
         $proGalId = explode(',',$proGal);
		 foreach($proGalId as $pgi){
			  $proImageName =  has_post_thumbnail()?wp_get_attachment_url($pgi):get_template_directory_uri().'/images/placeholder.png';
				if(preg_match("/\_V/i", $proImageName))
				{
					$reqProImageId = $pgi;
					$proImageName =  wp_get_attachment_image_src($pgi,'thumbnail');
					if($proImageName){
						$proImageName = $proImageName[0];
						}
					break;
				}
			 
			 }
		?>
        <div class="select-design-product-image <?php echo  (get_the_ID() == $curr_post->ID)?'pro-active':null?>"> 
            <a href="<?php echo get_permalink(get_the_ID())?>" class="select_design"> 
                <span class="mobile"><?php echo $post->post_name;?></span><img class="cc-product_no_image" src="<?php echo $proImageName?>"> 
            </a> 
        </div>
        <?php
		 }
		}
		//wp_reset_postdata();
  }// Reset Post Data
  
  */
wp_reset_postdata();

	?>
	
	

                 
                 
                 
                 
                 </div>
                 </div>
      </div>
      <?php $pro = get_post_meta($post->ID);
      global $post;
       ?>
      <div class="cc-size-quantity-section">
      
      <div class="cc-quantiy-section col-md-12">
      <h3>QUANTITY (PACK) </h3>
      	<?php 
      	 $x=do_shortcode('[add_to_cart_url id="'.$post->ID.'"]');
      	 ?>
      	 <?php  do_action( 'cc_custom_quantiy' );?>
         <?php if(strcasecmp($pro['_stock_status'][0],'instock')!=0){?><div>
      <h3> OUT OF STOCK</h3>
      <?php do_action('cc_after_select_design_start');  do_action( 'woocommerce_single_product_summary' ); ?>
      </div><?php }else{?>
      <div class="stock_info_wrap clearfix">
      <h3>In Stock  <span class="cc-po">- Pickup Only</span></h3>
      </div>
		  <?php		  
		  }?>
         <input type="hidden" name="sizem2" id="sizem2" value="<?php echo get_field('size_m2',get_the_ID())?>">
        <?php  if(get_field('size_m2',get_the_ID())){?>
			<div class="total_coverage">
         <h3><?php _e('Total Coverage: ','carpetcall');?> <span class="coverage_value"><?php echo get_field('size_m2',get_the_ID())?></span> <span class="coverage_unit"><?php _e('SQM','carpetcall')?></span></h3>
         
         </div>
			<?php }?>
            <div class="sq_mtr_calc_wrap">
         	<i><?php _e('Not sure how much you need?','carpetcall');?></i>
         <div class="cc-sq-mtr-calc-wrap">

        <button type="button" class="btn btn-default col-md-12" data-toggle="modal" data-target="#myModalcalc"><span class="fa fa-calc"></span><span class="sq_mtr_text"><?php _e('SQUARE METER CALCULATOR','carpetcall')?></span></button>
       
    </div>
     <div class="cc-smc-underline"></div>     
         </div>
      	 <div class="cc-quantiy-section-inner">
      	 <a href="<?php echo $x ;?>" data-quantity="1" data-product_id="<?php echo $post->ID;?>" data-product_sku="<?php
      	  echo $pro['_sku'][0] ; ?>" class="button product_type_simple add_to_cart_button ajax_add_to_cart col-md-12" id="store-count-quantity" >ADD TO CART</a>

      	  </div>
          
      	  </div>
      </div>
      <div class="clearfix"></div>
     
      <div class="cc-product-enquiry col-md-12">
      	<button type="button" class="btn btn-default col-md-12" data-toggle="modal" data-target="#myModal2">ENQUIRE NOW</button>
      </div>
      <div class="cc-product-ship-free-section col-md-12">
      <div class="cc-product-ship col-md-6"><span>SHIPPING</span><i class="fa fa-info-circle mobile" aria-hidden="true"></i></div><div class="cc-product-free col-md-6 not_available"> Not available</div>
      </div>
      <div class="cc-product-pick-location-section col-md-12">
      <div class="cc-product-pick col-md-6">
      <div class="btn btn-default col-md-12" ><span class="pickup-free-tag">Free</span> PICKUP</div>
      </div>
      <div class="cc-product-location col-md-6">
      <button type="button" class="btn btn-default col-md-12" data-toggle="modal" data-target="#myModal1">PICK UP LOCATIONS</button>
      </div>
      <!-- Trigger the modal with a button -->
      
<!-- Enquiry Now -->
<div id="myModal2" class="modal fade querynow" role="dialog">

  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-a-title">ENQUIRE NOW</h4>
      </div>
      <div class="modal-body">
			<div class="review-form">
            <form action="" method="post" id="contact_form" role="form">
            <div class="contact_block_cntr">
            
                <div class="yd-title"> 	
                <h3>YOUR  DETAILS</h3> 		
                </div>
                <select class="selectpicker col-md-6 valid" name="cc_enquiry_type" id="cc-enquiry-type" aria-invalid="false">
            
                       <option class="col-md-12" value="sales enquiry">
                         Sales Enquiry
                       </option>
                       <option class="col-md-12" value="Service Enquiry">
                         Service Enquiry
                       </option>
      
                     </select>
                <div class="flsm-blk">
                <div class="form-group col-sm-6"> <label for="first_name">First Name</label>
                    <input type="text" name="first_name" class="form-control" value="" size="40"  id="first_name"  placeholder="E.G. JOHN">
                    <div class="error_label"></div> 
                </div>
               
                <div class="form-group col-sm-6"><label for="first_name">Last Name </label>
                    <input type="text" name="last_name" class="form-control" value="" size="40" id="last_name"  placeholder="E.G. SMITH ">
                    <div class="error_label"></div>
                </div>
                
                </div>
                
                <div class="meroi-blka">
	            <div class="form-group col-sm-12"><label for="email_address">Email</label>
	                   <input type="email" name="email_address" class="form-control" value="" size="40"  id="email_address" placeholder="E.G. JOHN.SMITH@EMAIL.COM">
	                    <div class="error_label"></div>
	            </div>
                </div>
                
                <div class="tela-blkb">
	            <div class="form-group col-sm-6">
	            	<label for="mobile_phone_no">Phone</label>
                    <input type="tel" name="mobile_phone_no" class="form-control"  value="" size="40" id="mobile_phone_no" placeholder="E.G. 0212345678">
                    <div class="error_label"></div>
                </div>
                </div>
                
                
                
                
                <div class="cc-store-form-section" id="cc-store-form-section">
                <div class="form-group col-sm-12">	
                		<h3>SELECT A STORE</h3>
                		<p> Choose a store that is close to you so we can best respond to your query.</p>
                </div>
                
                <div class="provision-section col-sm-12 clearfix">
                <div class="form-group col-sm-4">

                	<select class="selectpicker col-md-6 form-control"  name="cc_state_type" id="cc-state-type">
                	<option class="col-md-12" value="default">STATE</option>
                      <?php  get_template_part('templates/contact/content', 'contact-state');
                     ?>

                     </select>
                     <div class="error_label"></div>
                </div>
                
                <div class="form-group col-sm-8">
              
                	<select class="selectpicker col-md-6 form-control" name="cc_store_name" id="cc-store-name">
                     <option class="col-md-12" value="default">Select a Store</option>

                         <?php  get_template_part('templates/contact/content', 'contact-store');
                     ?>

                     </select>
                     <div class="error_label"></div>
                </div>

                </div>
                  <div class="provision-section col-sm-12 clearfix">
                <div class="form-group col-sm-8">
                 <div class="cc-product-page-info-dis">
                 <?php  
                        global $post;
                        $reqTempTerms=get_the_terms($post->ID,'product_cat');


                        if($reqTempTerms){

                        foreach($reqTempTerms as $cat){
                        $has_sub_cat=get_terms(array('parent'=>$cat->term_id,'taxonomy'=>'product_cat'));

                        if(count($has_sub_cat)==0){
                          $reserve = $cat->name ;

                        }
                        }
                        }

                         
                        $resproHeight= get_post_meta($post->ID,'_height',true);
                        $resproLength = get_post_meta( $post->ID,'_length', true);
                        $resproWidth = get_post_meta( $post->ID,'_width', true);
                        $resproSKU   = get_post_meta($post->ID,'_sku',true);
                        $sizen    ='Size       ';
                        $coden    ='Hard Flooring Code   ';
                        $productn ='Product    ';
                        $resprodim = $resproLength.'cm'.' '.$resproWidth.' '.'cm'.' '.$resproHeight;
                        $resproSize ='Size      : '.$resprodim;
                        $resproCode ='Hard Flooring Code  : '.$resproSKU;
                        $resproProduct ='Product   : '.$reserve; 
                        
                        
                        


                 ?>
                 <h3 class="cc-sen-head" >Product Information</h3>
                 <ul>
                        <li><span class="cc-sen-title"><?php echo $productn;?></span>: <span class="cc-sen-val"><?php echo $reserve;?></span></li>


                        <li><span class="cc-sen-title"><?php echo $coden ;?></span>: <span class="cc-sen-val"><?php echo $resproSKU; ?></span></li>

                        <li><span class="cc-sen-title" ><?php echo $sizen ;?></span>: <span class="cc-sen-val"><?php echo $resprodim; ?></span></li>
                  </ul>
                   
                 </div>
                 </div></div>
                  <div class="form-group col-sm-8">
                 <div class="cc-product-page-info">
                 <?php  
                       
                        
                        echo '<input type="hidden" value="'.$resproProduct.'" name="product_page_cat"/>';
                        echo '<input type="hidden" value="'.$resproCode.'" name="product_page_code"/>';
                        echo '<input type="hidden" value="'.$resproSize.'" name="product_page_size"/>';
                         echo '<input type="hidden" value="hardflooring" name="cc_contact_type"/>';


                 ?>
                   
                 </div>
                 </div>
                
                </div>
                
                
                <?php 
                  $myemail = "";
                  if(isset($_GET['id']))
                  {

                      $contactstoID = $_GET['id'];

                      $field = get_post_meta($contactstoID);
                    
                  if(isset($field['wpsl_email'][0]))
                  {
                      $myemail = $field['wpsl_email'][0];
                  }
                  else
                  {
                      $stateemailpair = array();


                      $args = array(
                                      'post_type' =>'wpsl_stores',
                                      'posts_per_page'=>'-1',
                                      'meta_query' => array(
                                                              array(
                                                                  'key' => 'store_type',
                                                                  'value' => 'head_office'
                                                                  
                                                              )
                                                            )
                                    );
                      $loop = new WP_Query($args);
                      $html = '';
                      if($loop->have_posts())
                      {
                          while($loop->have_posts())
                          {
                              $loop->the_post();
                                    /* 
                                    **state head office  state and 
                                    ***email address pair 
                                    
                                    */
                                    
                              $res = get_post_meta($loop->post->ID);
                                     
                              if(!isset($res['wpsl_email'][0]))
                              {
                                  $stateemailpair[$res['wpsl_state'][0]]  = get_option('admin_email');
                              }   
                              else
                              {
                                  $stateemailpair[$res['wpsl_state'][0]] = $res['wpsl_email'][0];
                              }   
                               
                          
                             

                          }
                          wp_reset_query();


                      }
                   
                      $myemail =$stateemailpair[$field['wpsl_state'][0]];
                  }
                }
              ?>
                <input type="hidden" value="<?php echo $myemail;?>" class="btn-dn" id="send_email_address" name="send_email_address">
                
                <div class="ur-msg-title">
                 <div class="form-group col-sm-12">
                	
                		<h3>Message</h3>
                </div></div>

                
                <div class="form-group col-sm-12">
                
                 <textarea class="form-control" rows="5" id="cc_message" name="cc_message" placeholder="ENTER YOUR MESSAGE HERE"></textarea>
                  <div class="error_label"></div>
                </div>
                 <div class="form-group col-sm-12">
					   <script src='https://www.google.com/recaptcha/api.js'></script>
                      <div class="g-recaptcha" data-callback="recaptchaCallbackone" data-sitekey="6LdfuCMTAAAAAGhFRMwboqar9gIW_yfmWVjT7OMj"></div>
                       <input type="hidden" value="" id="check_captcha_one" name="check_captcha_one">
                      <div class="error_label"></div>
                   </div>
                <div class="form-group col-sm-12">
                 <input type="submit" value="Submit" class="btn-dn" id="cc_contact_submit">
                </div> 
                  <div class="form-group col-sm-12 success_message_wrapper ">
                     
                     <div class="success_message"></div><div class="close_box">X</div>

                  </div>
                   <div class="form-group col-sm-12 success_message_wrapper ">
                     
                     <div class="error_message"></div><div class="close_box">X</div>

                  </div>


            </div>

        </form> 
		<script>
        
 
  function recaptchaCallbackone(){
   jQuery('#check_captcha_one').val('1');

};
</script>

            </div><div class="clearfix"></div>            
      </div>
      
    </div>

  </div>
 
</div><!-- query end here -->

<!-- modal1 PICK UP -->


<!-- PICK UP LOCATIONS -->
<?php get_template_part( 'templates/head', 'office' );?>
<?php get_template_part('templates/square','meter-calculator'); ?>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">PICK UP LOCATIONS</h4>
      </div>
      <div class="modal-body">
        	<h2 class="fyns-blk"> FIND YOUR NEAREST STORE </h2>
            
            <div class="frm-blk clearfix">
            		<form class="form-inline" id="pickup_location_form">
                    
                    <div class="input-group">
                      <input type="text"  placeholder="SUBURB OR POSTCODE" id="edit_dialog_keyword" name="edit_dialog_keyword" type="text" class="form-control controls"  onkeyup="customDialog(event);">
                      <span class="input-group-btn">
                        <button class="btn btn-default" type="button" onclick="rs='';autocomplet_dialog();" id="check_control_dialog"><img src="<?php echo get_template_directory_uri().'/images/icon2.jpg';?>" style="float:right; margin-top:-5px;"></button>
                      </span>
                    </div>
                         
                         <span class="midlt"> OR </span>
                         
                          <button type="button" class="btn btn-default" onclick="showlocationdialog();rs='';" >USE CURRENT LOCATION</button>
                        </form>
            </div>
            <!-- <div id="dialog_list_id_s"></div> -->
            
            <div class="nearstore " id="dialog_list_id_s"> 
            <div class="col-md-12">
            	<?php
              $args = array(
                'post_type' => 'wpsl_stores',
                'posts_per_page'=>'3',
                'orderby' => 'rand'

                     
              );
              $loop = new WP_Query($args);
              if($loop->have_posts()):
                while($loop->have_posts()):
                  $loop->the_post();
                 $temp = get_post_meta($loop->post->ID);
                 ?>
                  <div class="col-md-4 no-lr">
                    <div class="str-one">
                      <h4><?php 
                      
                      echo get_the_title();?> </h4>
                      <?php if(!empty($temp['wpsl_address'][0])){ ?>
                        <p><?php echo $temp['wpsl_address'][0] ;?></p>
                        <?php } ?>
                        <?php 
                        $citystate ="" ;
                        if(!empty($temp['wpsl_city'][0])){
                          $citystate.=  $temp['wpsl_city'][0]." ";
                        }
                        if(!empty($temp['wpsl_state'][0])){
                          $citystate.=  $temp['wpsl_state'][0];
                        }
                        ?>
                        <p><?php echo $citystate ;?></p>
                        <?php
                         if(!empty($temp['wpsl_zip'][0])){ 
                          ?>
                        <p><?php echo $temp['wpsl_zip'][0]; ?></p>
                        <?php } ?>
                   
                    </div><div class="clearfix"></div>
                    </div>
                 <?php  
                 endwhile; 
                 wp_reset_query();
                endif;
              ?>
                
              </div> <div class="clearfix"></div> 
            </div>
            <div class="clearfix"></div>
            
      </div>
      
    </div>

  </div>
</div>



      </div>
      <div class="clearfix"></div>
      <div class="hf_product_details">
		<h3><?php _e('Details','carpetcall')?></h3>
        <table>
        	<tr class="odd">
            	<td><?php _e('Colour: ','carpetcall')?></td>
            	<td><?php _e((get_field('species__colour_decore',get_the_ID()))?get_field('species__colour_decore',get_the_ID()):'N/A','carpetcall')?></td>
            </tr>
        	<tr class="even">
            	<td><?php _e('Boards Per Pack: ','carpetcall')?></td>
            	<td><?php _e(get_field('boards_per_pack',get_the_ID())?get_field('boards_per_pack',get_the_ID()):'N/A','carpetcall')?></td>
            </tr>
        	<tr class="odd">
            	<td><?php _e('Coverage Per Pack: ','carpetcall')?></td>
            	<td><?php _e(get_field('size_m2',get_the_ID())?get_field('size_m2',get_the_ID()).'sqm/pack':'N/A','carpetcall')?></td>
            </tr>
        </table>
      </div>
      <div class="recommended_acc_static">
      <span><?php _e('Required Accessories to complete flooring:','carpetcall')?></span>
      	<img src="<?php echo get_template_directory_uri()?>/images/underlay_rec.jpg">
        <span class="cc-rec-acc-underlay"><?php _e('UNDERLAY','carpetcall')?></span>
      </div>
      
      <?php
	  /* 
	   $args = array('post_type' => 'product',
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
				'posts_per_page'=>-1,
                'field' => 'slug',
                'terms' => 'underlay',
            ),
        ),
     );
	 $loop = new WP_Query($args);
     if($loop->have_posts()) {?>
 		<div class="hf_req_accessories">
        <span><?php _e('Required Accessories to complete flooring','carpetcall')?></span>
       <?php 
	    while($loop->have_posts()) : $loop->the_post(); 
			if(has_post_thumbnail()){
						echo get_the_post_thumbnail(get_the_ID(),array('100',100));
						}
			echo '<span>'.the_title().'</span>';
        endwhile;
		wp_reset_postdata();
     ?>
     </div>
     <?php }
	 
	 */
	 
	 
	 /* if(get_field('accessories',get_the_ID())){?>
		  <div class="hf_req_accessories">
		<span><?php _e('Required Accessories to complete flooring','carpetcall')?></span>
        <?php 
		$accessories = get_field('accessories',get_the_ID());
		if(!empty($accessories)){
			foreach($accessories as $acc){
				if(has_post_thumbnail($acc)){
					echo get_the_post_thumbnail($acc,array('100',100));
					}
				echo '<span>'.get_the_title($acc).'</span>';
				}
			}
		
		?>
        
      </div>
		  <?php }*/
	  
	  ?>
	</div><!-- .summary -->

	<?php
		/**
		 * woocommerce_after_single_product_summary hook.
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products',20);
		?>
      <div class="desktop desktop-tabs">
       <?php
        do_action( 'woocommerce_after_single_product_summary' );
        ?>
      </div>
    <?php
		add_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products',20);

		//woocommerce_output_product_data_tabs();
		
		// as per design , this section appears in [] page
		
	?>

  <div class="mobile mobile-tabs">
   <?php
    get_template_part('templates/contents/content','tab-woocommerce-hard');
  ?>
  </div>

	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->
<?php /* added section to wrap the container
wrapper close start */?>

</div></div>
<?php /* before-wrapper close end*/?>
<?php do_action( 'woocommerce_after_single_product' ); ?>
<?php echo show_most_popular_products();?>  
    
  <?php //cc_notify_selected_store(35523);?>  
<style>
  #cc-enquiry-type{display:none;}
  .success_message_wrapper{display:none;}
</style>

</div>