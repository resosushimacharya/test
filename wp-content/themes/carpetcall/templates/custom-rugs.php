<?php
/*
Template Name: Custom Rugs Tempalate
*/
?>
<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
get_header('shop');

global $post;
//wp_enqueue_script( 'prettyPhoto' );
//wp_enqueue_script( 'prettyPhoto-init' );


?>

<div class="contaniner clearfix woocommerce woocommerce-page single single-product">
  <div class="inerblock-sec-prod-a">
    <div class="container">
      <div class="col-md-12 no-pl">
       
        <?php do_action( 'woocommerce_before_main_content' );?>
        
      </div>
      <span class="ab_arrow mobile"> <a href="<?php echo site_url().'/shop-our-range/rugs'?>"> <i class="fa fa-angle-left" aria-hidden="true"></i><b>BACK</b> </a> </span> 
      </div>
      
      
    <div class="product_single_container">
  <div class="container">
    <div class="col-md-12">
      <?php
	 //do_action( 'woocommerce_before_single_product' );

	
?>
    </div>
  </div>
  <div class="container">
    <div class="col-md-12 no-lr product-content-wrapper">
      <div itemscope itemtype="http://schema.org/Product" id="product-<?php get_the_ID(); ?>" <?php post_class('product type-product'); ?>>
        <?php 
		
		//do_action( 'woocommerce_before_single_product_summary' )
		?>
        <div class="images">
<h4 class="cc-category-show"><?php the_title()?></h4>
    <?php
	$images = get_field('gallery_images',get_the_ID());
	if($images){
		$feat_image_arr = $images[0]['gallery_image'];
		?>
		<div class="main-image-wrapper">
                <a href="<?php echo $feat_image_arr['url']?>" 
                itemprop="image" 
                class="woocommerce-main-image zoom" 
                title="<?php echo get_the_title();?>">
                <img 
                src="<?php echo $feat_image_arr['url']?>" 
                class="attachment-full size-full wp-post-image" alt="<?php echo strtoupper( get_the_title() )?>" 
                title="<?php echo strtoupper( get_the_title() )?>" 
                srcset="<?php echo $feat_image_arr['url']?>" 
                sizes="(max-width: 560px) 100vw, 560px">
                </a>
                <div class="main-image-over-wrapper">
                <img src="<?php echo get_template_directory_uri()?>/images/magnify1.png" 
                class="main-image-over">
                </div>
                </div>
		<?php
        }
	
	?>
                
                
                
                
                
	
   
    <div class="cc_custom_gal_thumb thumbnails columns-3">
    
    <?php
		if(wp_is_mobile()){
			echo '<div class="product_single_thumb_slider">';
			}
	
	?>
    <?php
	foreach($images as $image){
		$feat_image_arr = $image['gallery_image'];?>
		<div>
        <a href="<?php echo $feat_image_arr['url']?>" class="single-product-thumb-img">
        	<img src="<?php echo wp_get_attachment_thumb_url($feat_image_arr['id'])?>">
        </a></div>
		<?php }
	?>
    	
    <?php
		if(wp_is_mobile()){
			echo '</div>';
			}
	
	?>
    </div>
    
		<div class="mod-social clearfix">
		<div class="cc-share-title">SHARE: </div>
		<a href="http://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink(get_the_ID());?>" target="_blank">
          <i class="fa fa-2x fa-facebook-square" aria-hidden="true"></i>
         </a>
         <a href="https://twitter.com/share?url=<?php echo get_the_permalink(get_the_ID());?> " target="_blank">      
         <i class="fa fa-2x  fa-twitter" aria-hidden="true"></i>
         </a>
<a href="#" onclick="window.open('https://www.pinterest.com/pin/create/bookmarklet/?url=<?php echo get_permalink(get_the_ID()); ?>')">
          <i class="fa fa-2x fa-pinterest" aria-hidden="true"></i>
           </a>
         </div>
</div>
        <div class="summary entry-summary">
          <div class="carpet_blinds_single_right">
            <h3 class="calspl calspll">
              <?php 
                             $telephone_link =  get_field('telephone_link', '89',false); 
                             $x = preg_replace('/\s+/', '', $telephone_link);
                             $x = preg_replace( '/^[0]{1}/', '', $x );
                             $i = 1;
                             $x = '+61'.$x;   
                          ?>
              <a href="tel:<?php echo $x; ?>"><?php echo __( 'CALL ', 'carpetcall' ) . $telephone_link;?></a> </h3>
            <h4 class="bcwfsp"><?php echo get_field('footer_contact_title_label',89);?> </h4>
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
                            <option class="col-md-12" value="sales enquiry"> Sales Enquiry </option>
                            <option class="col-md-12" value="Service Enquiry"> Service Enquiry </option>
                          </select>
                          <div class="flsm-blk">
                            <div class="form-group col-sm-6">
                              <label for="first_name">First Name</label>
                              <input type="text" name="first_name" class="form-control" value="" size="40"  id="first_name"  placeholder="E.G. JOHN">
                              <div class="error_label"></div>
                            </div>
                            <div class="form-group col-sm-6">
                              <label for="first_name">Last Name </label>
                              <input type="text" name="last_name" class="form-control" value="" size="40" id="last_name"  placeholder="E.G. SMITH ">
                              <div class="error_label"></div>
                            </div>
                          </div>
                          <div class="meroi-blka">
                            <div class="form-group col-sm-12">
                              <label for="email_address">Email</label>
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
                            </div>
                          </div>
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
                            <div class="success_message"></div>
                            <div class="close_box">X</div>
                          </div>
                          <div class="form-group col-sm-12 success_message_wrapper ">
                            <div class="error_message"></div>
                            <div class="close_box">X</div>
                          </div>
                        </div>
                      </form>
                      <script>
        
 
  function recaptchaCallbackone(){
   jQuery('#check_captcha_one').val('1');

};
</script> 
                    </div>
                    <div class="clearfix"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="woocommerce-tabs wc-tabs-wrapper">
  <ul class="tabs wc-tabs">
    <li class="additional_information_tab active"> <a href="#tab-additional_information">DETAILS</a> </li>
  </ul>
  <div class="panel entry-content wc-tab" id="tab-additional_information" style="display: block;">
	<?php echo apply_filters('the_content',get_the_content())?>
  </div>
</div>
        
        <meta itemprop="url" content="<?php the_permalink(); ?>" />
      </div>
      
    </div>
  </div>
 
  <?php do_action( 'woocommerce_after_single_product' ); ?>
  
  <style>
  #cc-enquiry-type{display:none;}
  .success_message_wrapper{display:none;}
</style>
</div>
    
    
    
    </div>
</div>
<?php
get_footer('shop');?>
<script type="text/javascript">
$ = jQuery.noConflict();

  function recaptchaCallbackone(response){
	 jQuery('#check_captcha_one').val('1');
	  	  
	$('.g-recaptcha').siblings('.error_label').html('');
}



 $(document).on('click','.close_box',function(){
  var that=this;
    $(this).parent().fadeTo(300,0,function(){
          $(that).parent().hide();
          $(that).parent().fadeTo(300,1);
           $(that).parent().hide();
    });
});
jQuery.validator.setDefaults({ 
ignore: ":hidden:not(.chosen, #send_email_address,#check_captcha_one)",
 submitHandler: function() {
     var form_data= jQuery("#contact_form").serializeArray();
      var json = {};

    jQuery.each(form_data, function() {
      json[this.name] = this.value || '';
    });
    
  jQuery.ajax({
         type : "post",
         dataType : "json",
         url : "<?php echo admin_url( 'admin-ajax.php' ); ?>",
         data : {
           action: "contact_action",
           form_data : json
          },
         success: function(response) {
           if(typeof(response.success) != "undefined" && response.success !== null) {
               //jQuery("#vote_counter").html(response.vote_count)
         jQuery('#first_name').val('');
         jQuery('#last_name').val('');
         jQuery('#email_address').val('');
         jQuery('#mobile_phone_no').val('');
         jQuery('#cc-state-type').val('default');
         jQuery('#cc-store-name').val('default');
         
         jQuery('#cc_message').val('');
          jQuery('#cc_message').attr("placeholder", "ENTER YOUR MESSAGE HERE");
         jQuery('#cc-state-type-only').val('default');
         $('.error_message').parent().hide();
         $('.success_message').parent().show();
         jQuery('.success_message').html(response.success).show();
         jQuery('#check_captcha_one').val('');
         grecaptcha.reset();
            }else{
                if(typeof(response.captcha_error) != "undefined" && response.captcha_error !== null){
          grecaptcha.reset();
            $('.success_message').parent().hide();
           $('.error_message').parent().show();
           $('#recaptcha-anchor-label').html('Captcha Error')
          jQuery('.error_message').html(response.captcha_error).show();
        }else if(typeof(response.error) != "undefined" && response.error !== null){
            grecaptcha.reset();
           $('.error_message').parent().show();
          jQuery('.error_message').html(response.error).show();
          
        }
        jQuery('#check_captcha_one').val('');
            }
         }
      }) 
}
}) 
  $.validator.addMethod("phoneValidation",function(value,element){
      
      str= value;
       value =value.replace(/[a-z\+\-\/\=]/gi, '');
       realLength = str.length;
       tempLength =  value.length;
      
      if(realLength==tempLength){
        return true;
      }
      else{
        return false;
      }
     
     
     
      

  },'please enter valid phone number');
   $.validator.addMethod("default",function(value,element){
      
      
      
      if(value.toLowerCase()==="default"){
        return false;
      }
      else{
        return true;
      }
     
     
     
      

  },'please select');
  function getWordCount(wordString) {
      var words = wordString.split(" ");
      words = words.filter(function(words) { 
        return words.length > 0
      }).length;
      return words;
}

//add the custom validation method
    jQuery.validator.addMethod("wordCount",
       function(value, element, params) {
          var count = getWordCount(value);
          if(count >= params[0]) {
             return false;
          }
          else{
            return true;
          }
       },
      "A minimum of {0} words is required here."
    );

//call the validator


 $.validator.addMethod("texareaValidate",function(value,element){
      
     
      
      if(value.trim()===""){
        return false;

      }
      else{
        return true;
      }
     
     
     
      

  },'please select');

  
  $.validator.addMethod("valueNotEquals", function(value, element, arg){

         return arg != value;
 }, "Value must not equal arg.");



  jQuery("#contact_form").validate({
  rules: {
      
      /*first_name: "required",*/
      first_name:{
        required:true,
        maxlength:32
      },

      last_name:{
        required:true,
        maxlength:32
      },
      cc_message:{

       
        required:true,
        wordCount: ['50']
      },
      email_address: {
        required: true,
        email: true
      },
      
    cc_state_type: { 
      default:true

                
              },
      cc_store_name: { 
                default: true,

              },
      cc_state_type_only: {
        default: true,
      },

              
      
      information:"required",
      
      mobile_phone_no :{
             phoneValidation:true,
             required: true,
             maxlength:10,
             minlength:10
              
      
     /* required:true*/}
      ,
      faulty_items :{
              number: true,
              required: true,
            },
      check_captcha_one: "required"     
  },
  messages: {
     first_name:{required: "Please enter your first name.",
      maxlength:"Please enter at most 32 characters."
    },
       last_name:{
        required:"Please enter your last name.",
        maxlength:"Please enter at most 32 characters."
      } ,
       email_address:{required:"Please enter your email address.",
      email:"Please enter valid email address."


    },
      
      information: " Please enter your message.",
       mobile_phone_no: {
            required :"Please enter your phone number.",
            phoneValidation: "Please enter valid phone number.",
          },

      
       cc_message:{  required:"Please enter your message.",
                    wordCount:"Please enter at most 50 words."
                 
    },
      cc_state_type:{ default: "Please select a state." },
      cc_state_type_only:{ default: "Please select a state." },
      cc_store_name: { 
                default: "Please select a store." 
              },
      check_captcha_one :"Please  select captcha.",        
  },
  errorPlacement: function(error, element){
    var err_cntr=element.parent("div").find(".error_label");
      err_cntr.show(); 
      error.appendTo(err_cntr);
  }
  
  
  });

jQuery(document).ready(function(e) {
    jQuery("a.zoom").prettyPhoto({
		hook: 'data-rel',
		social_tools: false,
		theme: 'pp_woocommerce',
		horizontal_padding: 20,
		opacity: 0.8,
		deeplinking: false
	});
	jQuery("a[data-rel^='prettyPhoto']").prettyPhoto({
		hook: 'data-rel',
		social_tools: false,
		theme: 'pp_woocommerce',
		horizontal_padding: 20,
		opacity: 0.8,
		deeplinking: false
	});
	jQuery('.product_single_thumb_slider').slick({
	  dots: true,
	  infinite: true,
	  speed: 300,
	  slidesToShow: 1,
	  adaptiveHeight: true
	});
});

</script>