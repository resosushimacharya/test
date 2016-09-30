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
<div class="col-md-12">
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
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_carpets_blinds_price', 10 );
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_carpets_blinds_title', 10 );
			

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
      <?php
	 if(has_term('awnings','product_cat',get_the_ID()) || has_term('blinds','product_cat',get_the_ID()) || has_term('shutters','product_cat',get_the_ID())){
		 $tel_html = '<a href="tel:+611300614797">CALL 1300 614 797</a>';
		$contact_title_label = get_field('footer_contact_title_label',89);
		 }else{
			 
                             $telephone_link =  get_field('telephone_link', '89',false); 
                             $x = preg_replace('/\s+/', '', $telephone_link);
                             $x = preg_replace( '/^[0]{1}/', '', $x );
                             $i = 1;
                             $x = '+61'.$x;   
			$tel_html = '<a href="tel:'.$x.'">CALL'. $telephone_link.'</a>';
			$contact_title_label = get_field('footer_contact_title_label',89);
			 }
	  
	  
	  ?>
      <div class="carpet_blinds_single_right">
                 <h3 class="calspl calspll"><?php echo $tel_html?></h3>
                <h4 class="bcwfsp"><?php echo $contact_title_label;?> </h4>
                
                <div class="againlt">
                    <ul>

                        <?php $booklink=get_field('contactlink',89);?>
                        <?php
                            foreach($booklink as $singlelink){

                                 echo '<li> ' . $singlelink['ask_an_expert'] . '</li>';
                            }
                        ?>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                
      
      
      <?php $pro = get_post_meta($post->ID);
      global $post;
       ?>
      <div class="cc-product-enquiry col-md-12">
      	<button type="button" class="btn btn-default col-md-12" data-toggle="modal" data-target="#myModal2">ENQUIRE NOW</button>
      </div>
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
                        $coden    ='Carpet Code   ';
                        $productn ='Product    ';
                        $resprodim = $resproLength.'cm'.' '.$resproWidth.' '.'cm'.' '.$resproHeight;
                        $resproSize ='Size      : '.$resprodim;
                        $resproCode ='Carpet Code  : '.$resproSKU;
                        $resproProduct ='Product   : '.$reserve; 
                        
                        
                        


                 ?>
                 <h3 class="cc-sen-head" >Product Information</h3>
                 <ul>
                        <li><span class="cc-sen-title"><?php echo $productn;?></span>: <span class="cc-sen-val"><?php echo $reserve;?></span></li>


                       <?php /*?> <li><span class="cc-sen-title"><?php echo $coden ;?></span>: <span class="cc-sen-val"><?php echo $resproSKU; ?></span></li>

                        <li><span class="cc-sen-title" ><?php echo $sizen ;?></span>: <span class="cc-sen-val"><?php echo $resprodim; ?></span></li><?php */?>
                  </ul>
                   
                 </div>
                 </div></div>
                  <div class="form-group col-sm-8">
                 <div class="cc-product-page-info">
                 <?php  
                      
                        
                        echo '<input type="hidden" value="'.$resproProduct.'" name="product_page_cat"/>';
                        echo '<input type="hidden" value="'.$resproCode.'" name="product_page_code"/>';
                        echo '<input type="hidden" value="'.$resproSize.'" name="product_page_size"/>';
                        echo '<input type="hidden" value="carpets" name="cc_contact_type"/>';
                        


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

                
                <div class="form-group col-sm-12 contact-msg-cntr">
                
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
 
</div>
      <div class="clearfix"></div>
      
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
		remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products',20);

    ?>
    <div class="desktop desktop-tabs">
  		<?php do_action( 'woocommerce_after_single_product_summary' ); ?>
    </div>
    <?php 
		  add_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products',20);
    

		//woocommerce_output_product_data_tabs();
		
		// as per design , this section appears in [] page
		
	?>
  <div class="mobile mobile-tabs">
  <?php    
      get_template_part('templates/contents/content','tab-woocommerce-carpet');
    
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
    
    
<style>
  #cc-enquiry-type{display:none;}
  .success_message_wrapper{display:none;}
</style>

</div>