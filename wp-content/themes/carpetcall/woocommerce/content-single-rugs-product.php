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
</div></div>
<?php 

/* 
	* added section to wrap the container
	* wrapper open start 
*/
?>
<div class="container">
<div class="col-md-12 no-lr product-content-wrapper">

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
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 5 );
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 10 );
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
      <div class="cc-select-design-pro-all col-md-12">
      <?php 

       $strsizes= array();
       global $post;
       $pro_cur_id = $post->ID;
       
           $reqTempTerms=get_the_terms($post->ID,'product_cat');

   
            if($reqTempTerms){
            	
           foreach($reqTempTerms as $cat){
           	$has_sub_cat=get_terms(array('parent'=>$cat->term_id,'taxonomy'=>'product_cat'));
           	 
              if(count($has_sub_cat)==0){
						$current_post_term_id = $cat->term_id;
						wp_reset_query();
						$args = array('post_type'=>'product','posts_per_page'=>'-1',
                          /*'meta_key'=>'_sale_price',
                          'orderby' => 'meta_value_num',
                           'order'     => 'ASC',*/

							 'tax_query' => array(
        array(
          'taxonomy' => 'product_cat',
        'terms' => $cat->slug,
        'field' => 'slug',
        'compare' => 'IN'
      )
      ));

						$loop = new WP_Query($args);
						$i=0;
          $starter = 1;
          $titlepro = array();
						while($loop->have_posts())
						{  $loop->the_post();
							   
								$stockcheck = get_post_meta($loop->post->ID);
                $titlepro[$post->ID] = $stockcheck['_sku'][0];

							?>
						<?php 
					}
					wp_reset_query();

}     	
                   }
               }
              //do_action('pr',$titlepro);
                  $secondVar = '';
                 $fsecondVar = '';
                
     
     $proGroup = array();
        foreach($titlepro as $key => $value){

            preg_match('/([A-Z]*)\.([0-9]*)\.([0-9]*)\.([0-9]*)/',$value,$match);
              
             $proGroup[] = array($value,$match[2],$key);
             
           if($secondVar!=$match[2]){
            
             $uniqueId = $key;

             $secondVar = $match[2];
             $resList[$uniqueId][]=$key;
             
            }
         else{
          $resList[$uniqueId][]=$key;

            }

  
}

$stoKey = array();
$xyz = array();
foreach($proGroup as $pgg){
  
   $xyz[] =$pgg[1];
  if(in_array($pgg[1],$stoKey)){

  }
  else
  {
     $stoKey[] =$pgg[1];
  }
   

  
}


$filterproGroup = array();

foreach($proGroup as $item ){
  foreach($stoKey as $myval){
    if($myval == $item[1] ){
      $filterproGroup[$myval][$item[2]] = $item[0];

    }
  }
}


global $post;
foreach($filterproGroup as $bundle){
  $i=1;  $displayCounter = 1 ; 
  foreach($bundle as $key => $value){
      $proGal = get_post_meta( $key, '_product_image_gallery', TRUE );
        $proGalId = explode(',',$proGal);
        $flag= 0;
      
        foreach($proGalId as $pgi):
            
            $proImageName =  wp_get_attachment_url($pgi);
             
            if(preg_match("/\_V/i", $proImageName) && $displayCounter==1)
            {
                $reqProImageId = $pgi;
               
                $flag=1;
               
                 $stockcheck = get_post_meta($post->ID);
                if(strcasecmp($stockcheck['_stock_status'][0],'instock')==0){
                  ?>
                <div class="select-design-product-image <?php echo (array_key_exists($post->ID,$bundle))?'pro-active':null;?>">
                         <?php   

              
              //echo '<br>';$post->ID;?>
              
              <a href="<?php echo get_the_permalink($key)?>" class="select_design">
              <?php if($flag==1){
                     $proImageName =  wp_get_attachment_image_src($reqProImageId,'thumbnail');
					 if($proImageName){
						 $proImageName = $proImageName[0];
						 }
                     ?>
                      <span class="mobile"><?php echo $post->post_name;?></span><img name="<?php echo $post->post_name?>" class="cc-product_no_image" src="<?php echo $proImageName ;?>"/>
                     <?php 
                } 
                else{
                  ?>
                <span class="mobile"><?php echo $post->post_name;?></span><img name="<?php echo $post->post_name?>" class="cc-product_no_image" src="<?php echo get_template_directory_uri();?>/plugins/woocommerce/assets/images/placeholder.png"/>
              <?php } ?>
              
              
              </a>
              </div> 
                <?php 

            }

            $displayCounter++;
          }
          elseif($displayCounter==1){ ?>  <div class="select-design-product-image <?php echo (array_key_exists($post->ID,$bundle))?'pro-active':null;?>">
                         
              
              <a name="<?php echo $post->post_name?>" href="<?php echo get_the_permalink($key)?>" class="select_design">
             
            
                
                <span class="mobile"><?php echo $post->post_name;?></span><img name="<?php echo $post->post_name?>" class="cc-product_no_image" src="<?php echo site_url()."/wp-content/plugins/woocommerce/assets/images/placeholder.png";?>"/>
           
              
              
              </a>
              </div>
          <?php
          $displayCounter++;
          }

        endforeach;


    if($key == $post->ID){
            $res =apply_filters('woocommerce_product_bundle',$bundle);
        
           }

    
    }
  

}

foreach($resList as $mainId){
  global $post;
  
     
     
     
                $displayCounter = 1 ; 
    
    foreach($mainId as $val){

           if($post->ID == $val){
          
           // $res =apply_filters('woocommerce_product_bundle',$mainId);
          
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
      <select class="selectpicker col-md-10" name="cc-size" id="cc-size">
      <?php foreach($res as $ss):?>
      
       <option <?php echo ($ss[2]==$post->ID?'selected="selected"':'');?> class="col-md-12 size_select" value="<?php echo $ss[1];?>"><?php echo $ss[0];?></option>
     
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
      	<button type="button" class="btn btn-default col-md-12" data-toggle="modal" data-target="#myModal2">ENQUIRE NOW</button>
      </div>
      <div class="cc-product-ship-free-section col-md-12">
      <div class="cc-product-ship col-md-6"><span>SHIPPING<i class="fa fa-info-circle" aria-hidden="true"></i></span></div><div class="cc-product-free col-md-6"> FREE DELIVERY</div>
      </div>
      <div class="cc-product-pick-location-section col-md-12">
      <div class="cc-product-pick col-md-6">
      <div class="btn btn-default col-md-12" >PICK UP</div>
      </div>
      <div class="cc-product-location col-md-6">
      <button type="button" class="btn btn-default col-md-12" data-toggle="modal" data-target="#myModal">PICK UP LOCATION</button>       </div>
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
                        $coden    ='Rug Code   ';
                        $productn ='Product    ';
                        $resprodim = $resproLength.'cm'.' '.$resproWidth.' '.'cm'.' '.$resproHeight;
                        $resproSize ='Size      : '.$resprodim;
                        $resproCode ='Rug Code  : '.$resproSKU;
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
                  <div class="form-group col-sm-4">
                 <div class="cc-product-page-info">
                 <?php  
                      
                        
                        echo '<input type="hidden" value="'.$resproProduct.'" name="product_page_cat"/>';
                        echo '<input type="hidden" value="'.$resproCode.'" name="product_page_code"/>';
                        echo '<input type="hidden" value="'.$resproSize.'" name="product_page_size"/>';
                        


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
		

            </div><div class="clearfix"></div>            
      </div>
      
    </div>

  </div>
 
</div><!-- query end here -->

<!-- modal1 PICK UP -->


<!-- PICK UP LOCATIONS -->
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
            		<form class="form-inline">
                    
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
            <div class="cc-pul-headoff">
            	<?php
              $args = array(
                'post_type' => 'wpsl_stores',
                'posts_per_page'=>'3',
                //'orderby' => 'rand'

                     
              );
              $loop = new WP_Query($args);
              if($loop->have_posts()):
                while($loop->have_posts()):
                  $loop->the_post();
                 $temp = get_post_meta($loop->post->ID);
                 ?>
                  <div class="col-md-4 pul-sec-cc">
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
            </div><div class="clearfix"></div>
            
      </div>
      
    </div>

  </div>
</div>
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
  if(!wp_is_mobile()){
		do_action( 'woocommerce_after_single_product_summary' );}
		add_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products',20);




		//woocommerce_output_product_data_tabs();
		
		// as per design , this section appears in [] page
		
	?>
  <?php
    if(wp_is_mobile()){ get_template_part('templates/contents/content','tab-woocommerce');}?>

	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->
<?php /* added section to wrap the container
wrapper close start */?>

</div></div>
<?php /* before-wrapper close end*/?>
<?php do_action( 'woocommerce_after_single_product' ); ?>

 <div class="inerblock_sec_a">

    <div class="container clearfix you_may_link_cntr">
    <?php 
    foreach($reqTempTerms as $cat){
          $has_sub_cat=get_terms(array('parent'=>$cat->term_id,'taxonomy'=>'product_cat'));
         
          if(count($has_sub_cat)==0){
            $docatname = $cat->slug;
          }
        }
     //echo do_shortcode('[best_selling_products per_page="6" columns="12" category="'.$docatname.'"]');
    ?>
        <h3 style="text-align:center">YOU MAY ALSO LIKE</h3>
<div class="you_may_like-content">
		<?php               wp_reset_query();




                    global $post;

                    
					$reqTempTerms=get_the_terms($post->ID,'product_cat');
					
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
                      
                            
						}
					}
					shuffle($terms);
                        $i=1;

					foreach($terms as $term){

                
                 
						if($current_post_term_id!=$term->term_id){
                   
							
							$has_sub_cat=get_terms(array('parent'=>$term->term_id,'taxonomy'=>'product_cat'));
                
								if(count($has_sub_cat)==0){
                    
                                      
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
									if($i<=3){
									$i++;

                     				}
                     				else{
                     					break;
                     				}
									while($filloop->have_posts()):
										$filloop->the_post();

											/*var_dump($filloop->post->ID);*/
											$woo=get_post_meta($post->ID);
					
					$price=$woo['_regular_price'][0];
					
					
					$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );


									?> <div class="col-md-4">
                  		<div class="pro_secone">
                  		<a href="<?php the_permalink();?>" class="cc-product-item-image-link"><div class="img_cntr" style="background-image:url('<?php echo $feat_image; ?>');"></div></a>
                  
                    <!--img src="<?php echo $feat_image; ?>" alt="<?php the_title();?>" class="img-responsive"/-->
                    <div class="mero_itemss">
                      		<div class="proabtxt">
					 <a href="<?php the_permalink();?>" class="cc-product-item-title-link"><h4>
					<?php echo $term->name;?>
					</h4></a><?php 

					$reqTempTerms=get_the_terms($post->ID,'product_cat');
					

					

					
					if(!empty($price)){
						echo '<h6> FROM A$'.$price.'</h6>';
						
						}?></div>
					<div class="clearfix"></div>
                           
                      </div>
                      </div></a>
                      </div>
								<?php endwhile;?>
                     		<?php 
                     		wp_reset_query(); }
                     		
							
								}
						}
					}
 ?></div>
<div class="clearfix"></div>
					
                    
    </div>
    </div><!-- step three end here -->

<script>
$("document").ready(function(){
    $(".woocommerce-main-image").removeAttr("data-rel");
});
</script>
<style>
  #cc-enquiry-type{display:none;}
  .success_message_wrapper{display:none;}
</style>

</div>