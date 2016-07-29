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
		</div>
		<?php while ( have_posts() ) : the_post(); ?>
                <?php  
                   $reqTempTerms=get_the_terms($post->ID,'product_cat');
                   
                 
                if($reqTempTerms){
                   foreach($reqTempTerms as $cat){
                   	  
                   		if($cat->parent==0){
                   			
                   			if(strcasecmp($cat->slug, 'rugs')==0){
                   				wc_get_template_part( 'content', 'single-rugs-product' );
                   			}
                   		
                   	
                   			if(strcasecmp($cat->slug, 'hard-flooring')==0){
                   				wc_get_template_part( 'content', 'single-hard-flooring-product' );
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
			   jQuery('.success_message').html(response.success).show(0).delay(10000).hide(0);;
        
			   grecaptcha.reset();
            }else{
              	if(typeof(response.captcha_error) != "undefined" && response.captcha_error !== null){
					grecaptcha.reset();
					jQuery('.error_message').html(response.captcha_error).show();
				}else if(typeof(response.error) != "undefined" && response.error !== null){
					jQuery('.error_message').html(response.error).show();
					
				}
            }
         }
      }) 
}
}) 
  $.validator.addMethod("phoneValidation",function(value,element){
      
      str= value;
       value =value.replace(/[a-z]/gi, '');
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
      
			first_name: "required",
			last_name: "required",
      cc_message:{

        texareaValidate:true
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
             required: true
      
     /* required:true*/}
      ,
			faulty_items :{
						  number: true,
						  required: true,
						},
      check_captcha_one : "required"     
	},
	messages: {
			first_name: "Please enter your first name!",
			last_name: "Please enter your last name!",
			email_address: "Please enter valid email address!",
			
			information: " Please enter your message!",
			 mobile_phone_no: {
            required :"Please enter your phone number!",
            phoneValidation: "Please enter valid phone number!",
          },

			
			cc_message: " Please enter your message!",
			cc_state_type:{ default: "Please select a state!" },
      cc_state_type_only:{ default: "Please select a state!" },
			cc_store_name: { 
								default: "Please select a store!" 
							},
      check_captcha_one :"Please  select captcha!",        
	},
	errorPlacement: function(error, element){
		var err_cntr=element.parent("div").find(".error_label");
			err_cntr.show(); 
			error.appendTo(err_cntr);
	}
	
	
	});



</script>