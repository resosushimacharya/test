<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
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
/* Template Name : check */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?> 
<?php 
/*to blog the out of stock product display
*/
global $post;
$rootcheck = get_post_meta($post->ID);
 if(strcasecmp($rootcheck['_stock_status'][0],'instock')==0){ 
 	?>
<div class="contaniner clearfix">
	<div class="inerblock-sec-prod-a">
		<div class="container">
			<div class="col-md-12 no-pl">
	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>
			</div>
            
            <?php 
			$prod_terms = get_the_terms( $post->ID, 'product_cat' );
			foreach ($prod_terms as $prod_term) {
				$ancestors = get_ancestors( $prod_term->term_id, 'product_cat' );
				$depth = count($ancestors) ; 
				if($depth == 1){
					$back_term = $prod_term;
					?>
                    <span class="ab_arrow">
            <a href="<?php echo get_term_link($prod_term->term_id,'product_cat')?>">
              <i class="fa fa-angle-left" aria-hidden="true"></i>Back            
            </a>
          </span>
					<?php
                    break;
					}
				
				}


			?>
            
		</div>
		<?php while ( have_posts() ) : the_post(); ?>
                <?php  
                   $reqTempTerms=get_the_terms($post->ID,'product_cat');
                   
                 
                if($reqTempTerms){
                   foreach($reqTempTerms as $cat){
                   	  
                   		if($cat->parent==0){
                   			
                   			if(strcasecmp($cat->slug, 'rugs')==0){
								$top_cat_slug = 'rugs';
                   				wc_get_template_part( 'content', 'single-rugs-product' );
                   			}
                   		
                   	
                   			if(strcasecmp($cat->slug, 'hard-flooring')==0){
								$top_cat_slug = 'hard-flooring';
                   				wc_get_template_part( 'content', 'single-hard-flooring-product' );
                   			}
                   			
							if(strcasecmp($cat->slug, 'carpets')==0){
								$top_cat_slug = 'carpets';
                   				wc_get_template_part( 'content', 'single-carpets-product' );
                   			}
                   		
                   		}
                   	}
               	}
                 ?>
			

		<?php endwhile; // end of the loop. ?>

	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		//do_action( 'woocommerce_after_main_content' );
	?>

	<?php
		/**
		 * woocommerce_sidebar hook.
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		//do_action( 'woocommerce_sidebar' );
	?>
</div></div>
<?php } //end of blockage
else{ ?>
	<div class="contaniner clearfix">
	<div class="inerblock-sec-prod-a">
		<div class="container">
			<div class="col-md-12 no-pl">
		The product is out of stock.
	</div>
	</div>
	</div>
	<?php 
}
?>

<?php get_footer( 'shop' ); ?>
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



</script>


