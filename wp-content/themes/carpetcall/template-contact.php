<?php
/*
**Template Name: Contact Us Page
*/?>
<?php 
get_header();
?>
<div class="cbg_blk cc-clearance-blk clearfix">
 <div class="container ">
<div class="inerblock_contblk cc-wrapper-whole">
<div class="col-md-6">					
 <div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
<?php if(function_exists('bcn_display')){
        bcn_display();
    }?>

</div>

<?php 
 	while(have_posts()){
     	the_post();
        $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
?>  
 	<h3><?php echo get_the_title();?></h3>
    <?php         
	the_content();?>
             	
<?php
	 }
     wp_reset_query();
?>
</div>
<div class="cc-contact-side col-md-6">
<img src="<?php echo $feat_image ;?>" class="img-responsive">
</div>

</div>
</div>
</div>
<div class="container clearfix">
<div class="inerblock_sec cc-form-wrapper ">

<div class="clearfix"></div>
  <div class="contact_form_cntr col-md-12">
        <form action="" method="post" id="contact_form" role="form">
            <div class="contact_block_cntr">
                <div class="form-group cc-enquiry-section  col-sm-12">
                	<h3> Enquiry Type</h3>
                </div>
                <div class="form-group col-sm-6">
                	What Does your query relate to?
                </div>
                <div class="form-group col-sm-6">
                	<select class="selectpicker col-md-6" name="cc_enquiry_type" id="cc-enquiry-type">
            
                       <option class="col-md-12" value="sales enquiry">
                         Sales Enquiry
                       </option>
                       <option class="col-md-12" value="Service Enquiry">
                         Service Enquiry
                       </option>
      
                     </select>
                </div>
                <div class="form-group col-sm-6"> <label for="first_name">First Name</label>
                    <input type="text" name="first_name" class="form-control" value="" size="40"  id="first_name"  placeholder="First name *">
                    <div class="error_label"></div> 
                </div>
               

                
                <div class="form-group col-sm-6"><label for="first_name">Last Name </label>
                    <input type="text" name="last_name" class="form-control" value="" size="40" id="last_name"  placeholder="Last name *">
                    <div class="error_label"></div>
                </div>
	            <div class="form-group col-sm-12"><label for="email_address">Email</label>
	                   <input type="email" name="email_address" class="form-control" value="" size="40"  id="email_address" placeholder="Your email *">
	                    <div class="error_label"></div>
	            </div>
	            <div class="form-group col-sm-6">
	            	<label for="mobile_phone_no">Phone</label>
                    <input type="tel" name="mobile_phone_no" class="form-control"  value="" size="40" id="mobile_phone_no" placeholder="Mobile no. *">
                    <div class="error_label"></div>
                </div>
                <div class="cc-store-form-section" id="cc-store-form-section">
                <div class="form-group col-sm-12">
                	
                		<h3>SELECT A STORE</h3>
                		<p> Choose a store that is close to you so we can best respond to your query.</p>
                

                </div>
                <div class="form-group col-sm-4">

                <label for="cc-state-type">STATE*</label>
                	<select class="selectpicker col-md-6 form-control"  name="cc_state_type" id="cc-state-type">
                	<option class="col-md-12" value="default">Please Select</option>
                      <?php  get_template_part('content', 'contact-state');
                     ?>

                     </select>
                     <div class="error_label"></div>
                </div>
                <div class="form-group col-sm-8">
              
                     <label for="cc-store-name">STORE*</label>
                	<select class="selectpicker col-md-6 form-control" name="cc_store_name" id="cc-store-name">
                     <option class="col-md-12" value="default">Please Select</option>

                         <?php  get_template_part('content', 'contact-store');
                     ?>

                     </select>
                     <div class="error_label"></div>
                </div>
                
                </div>
                <?php 
                $myemail = "";
if(isset($_GET['id'])){

  $contactstoID = $_GET['id'];

    $field = get_post_meta($contactstoID);
    
    if(isset($field['wpsl_email'][0])){
      $myemail = $field['wpsl_email'][0];
    }
  }
?>
                <input type="hidden" value="<?php echo $myemail;?>" class="btn-dn" id="send_email_address" name="send_email_address">
                 <div class="form-group col-sm-12">
                	
                		<h3>Message</h3>
                	
                

                </div>
                <div class="form-group col-sm-12">
                
                 <textarea class="form-control" rows="5" id="cc_message" name="cc_message">ENTER YOUR MESSAGE HERE</textarea>
                </div>
                 <div class="form-group col-sm-12">
					   <script src='https://www.google.com/recaptcha/api.js'></script>
                      <div class="g-recaptcha" data-sitekey="6LdfuCMTAAAAAGhFRMwboqar9gIW_yfmWVjT7OMj"></div>
                   </div>
                <div class="form-group col-sm-12">
                 <input type="submit" value="Submit" class="btn-dn" id="cc_contact_submit">
                </div> 
                  <div class="form-group col-sm-12 success_message">

                  </div>

            </div>

        </form>
    </div>
 </div>   
</div>
<style type="text/css">
.cc-wrapper-blk{
background:#f0f2f1 !important;
}
.cc-wrapper-whole h3{
	text-decoration:none !important;
	border:none;

}
.cc-contact-side{
	
}
.cc-form-wrapper{
	padding:5px;
}
select#cc-state-type , select#cc-store-name{
	text-transform:uppercase !important;
}

/* .cc-store-form-section{
	display:block;
} */
</style>
<script>
$ = jQuery.noConflict();

$(document).ready(function() {

       $(document).on('change','#cc-enquiry-type',function(){
       		$res = $('#cc-enquiry-type').val(); 
       		$res = $res.toUpperCase();    
       		
       		var salesEnquiry = "sales enquiry";
       		salesEnquiry = salesEnquiry.toUpperCase();
       		var serviceEnquiry = "Service Enquiry";
       		serviceEnquiry = serviceEnquiry.toUpperCase();
       		
       		if(serviceEnquiry===$res){
       			
       			$('#cc-store-form-section').hide();
       		}
       		if(salesEnquiry===$res){
       			
       			
       			$('#cc-store-form-section').show();
       		}
       		

       	    /*$(".add_to_cart_button").attr('data-quantity',$stoq);*/
       	  });

	 	 });	

</script>
<?php 
get_footer();

?>
<script type="text/javascript">
jQuery.validator.setDefaults({ 
ignore: ":hidden:not(.chosen, #send_email_address)",
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
			   jQuery('#cc-state-type').val('dafault');
			   jQuery('#cc-store-name').val('deafault');
			   jQuery('#cc_message').val('');
			   jQuery('.success_message').html(response.success).show();
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

	$.validator.addMethod("valueNotEquals", function(value, element, arg){
  			 return arg != value;
 }, "Value must not equal arg.");



	jQuery("#contact_form").validate({
	rules: {
			first_name: "required",
			last_name: "required",
			email_address: {
				required: true,
				email: true
			},
			
			cc_state_type: { 
								valueNotEquals: "default" 
							},
			cc_store_name: { 
								valueNotEquals: "default" 
							},
							
			
			information:"required",
			product_code : "required",
			mobile_phone_no : "required",
			faulty_items :{
						  number: true,
						  required: true,
						}
	},
	messages: {
			first_name: "Please enter your first name.",
			last_name: "Please enter you last name.",
			email_address: "Please enter valid email address.",
			c_email_address: "Email and conform email does not match.",
			information: " Please enter your message.",
			product_code : "Please select product properly. Product code is empty ",
			mobile_phone_no : " Please enter mobile number.", 
			faulty_items : "Please enter numeric value.",
			cc_state_type:{ valueNotEquals: "Please select a state!" },
			cc_store_name: { 
								valueNotEquals: "Please select a store!" 
							}
	},
	errorPlacement: function(error, element){
		var err_cntr=element.parent("div").find(".error_label");
			err_cntr.show(); 
			error.appendTo(err_cntr);
	}
	
	
	});



</script>