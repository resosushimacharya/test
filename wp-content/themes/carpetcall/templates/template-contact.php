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
<?php
 if(function_exists('bcn_display'))
 {
    bcn_display();
 }
 ?>

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
<div class="col-md-6 ia-imgg">
<div class="cc-ia-banner-a" style="background-image: url(<?php echo $feat_image ;?>);"></div>
</div>

</div>
</div>
</div>
<div class="container clearfix">
<div class="inerblock_sec-bb cc-form-wrapper ">

<div class="clearfix"></div>
  <div class="contact_form_cntr col-md-12">
        <form action="" method="post" id="contact_form" role="form">
            <div class="contact_block_cntr">
                <div class="col-sm-12 form-group cc-enquiry-section">
                  <h3> Enquiry Type</h3>
                </div>
                
                <div class="col-sm-12 query-rlblk no-lr">
                
                <div class="form-group col-sm-6">
                  What does your query relate to?
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
                
                </div>
                
                <div class="details-us">
                  
                <h3>YOUR  DETAILS</h3>
                    
                </div>
                
                <div class="fl-blk">
                <div class="form-group col-sm-6"> <label for="first_name">First Name</label>
                    <input type="text" name="first_name" class="form-control" value="" size="40"  id="first_name"  placeholder="E.G. JOHN">
                    <div class="error_label"></div> 
                </div>
               
                <div class="form-group col-sm-6"><label for="first_name">Last Name </label>
                    <input type="text" name="last_name" class="form-control" value="" size="40" id="last_name"  placeholder="E.G. SMITH ">
                    <div class="error_label"></div>
                </div>
                
                </div>
                
                <div class="mero-blkk">
              <div class="form-group col-sm-12"><label for="email_address">Email</label>
                     <input type="email" name="email_address" class="form-control" value="" size="40"  id="email_address" placeholder="E.G. JOHN.SMITH@EMAIL.COM">
                      <div class="error_label"></div>
              </div>
                </div>
                
                <div class="tel-blk">
              <div class="form-group col-sm-6">
                <label for="mobile_phone_no">Phone</label>
                    <input type="tel" name="mobile_phone_no" class="form-control"  value="" size="40" id="mobile_phone_no" placeholder="E.G. 02 1234 5678">
                    <div class="error_label"></div>
                </div>
                </div>
                
                
                <div class="cc-state-form-section" id="cc-state-form-section">
                <div class="form-group col-sm-12">
                <h3>SELECT A STATE</h3>
                 <div class="form-group col-sm-4">

                  <select class="selectpicker col-md-6 form-control"  name="cc_state_type_only" id="cc-state-type-only">
                    <option class="col-md-12" value="default">STATE</option>
                      
                     <?php  get_template_part('templates/contact/content', 'contact-state');
                     ?>
                 </select>
                     <div class="error_label"></div>
                </div>
                </div>
                </div>
                
                <div class="cc-store-form-section" id="cc-store-form-section">
                <div class="form-group col-sm-12">
                  
                    <h3>SELECT A STORE</h3>
                    <p> Choose a store that is close to you so we can best respond to your query.</p>
                

                </div>
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
                 <div class="form-group col-sm-12 ">
                  
                    <h3>Message</h3>
                </div></div>
                
                <div class="form-group col-sm-12  contact-msg-cntr">
                
                 <textarea class="form-control" rows="5" id="cc_message" name="cc_message" placeholder="ENTER YOUR MESSAGE HERE"></textarea>
                  <div class="error_label"></div>
                </div>
                 <div class="form-group col-sm-12 contact-captcha-cntr">
             <script src='https://www.google.com/recaptcha/api.js'></script>
                      <div class="g-recaptcha" data-callback="recaptchaCallback" data-sitekey="6LdfuCMTAAAAAGhFRMwboqar9gIW_yfmWVjT7OMj"></div>
                      <input type="hidden" value="" id="check_captcha" name="check_captcha">
                      <div class="error_label"></div>
                   </div>
                <div class="form-group col-sm-12 contact-submit-cntr">
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
.success_message_wrapper{display:none;}

select#cc-state-type , select#cc-store-name,select#cc-state-type-only{
  text-transform:uppercase !important;
}
#cc-state-form-section{
  display:none;
}

/* .cc-store-form-section{
  display:block;
} */
</style>

<?php 
get_footer();

?>
<script>

function recaptchaCallback(){
   jQuery('#check_captcha').val('1');
	jQuery('.g-recaptcha').siblings('.error_label').html('');
}

 jQuery(document).on('click','.close_box',function(){
  var that=this;
    $(this).parent().fadeTo(300,0,function(){
          $(that).parent().hide();
          $(that).parent().fadeTo(300,1);
           $(that).parent().hide();
    });
});
 


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
            $('#cc-state-form-section').show();
          }
          if(salesEnquiry===$res){
            $('#cc-state-form-section').hide();
            
            $('#cc-store-form-section').show();
            
          }
          

            /*$(".add_to_cart_button").attr('data-quantity',$stoq);*/
          });

     });  

</script>


<script type="text/javascript">
jQuery.validator.setDefaults({ 
ignore: ":hidden:not(.chosen, #send_email_address,#check_captcha)",
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
		 jQuery('#check_captcha').val('');
         
         jQuery('#cc_message').val('');
          jQuery('#cc_message').attr("placeholder", "ENTER YOUR MESSAGE HERE");
         jQuery('#cc-state-type-only').val('default');
         $('.success_message').parent().show();
         jQuery('.success_message').html(response.success).show();
        
         grecaptcha.reset();
            }else{
                if(typeof(response.captcha_error) != "undefined" && response.captcha_error !== null){
          grecaptcha.reset();
            $('.error_message').parent().hide(); 
         $('.success_message').parent().hide();
         $('.success_message').parent().show();
         
          jQuery('.error_message').html(response.captcha_error).show();
        }else if(typeof(response.error) != "undefined" && response.error !== null){
            grecaptcha.reset();
             $('.error_message').parent().hide(); 
         $('.success_message').parent().hide();
           $('.error_message').parent().show();
          jQuery('.error_message').html(response.error).show();
          
        }
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
      check_captcha : "required"     
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
      check_captcha :"Please  select captcha.",        
  },
  errorPlacement: function(error, element){
    var err_cntr=element.parent("div").find(".error_label");
      err_cntr.show(); 
      error.appendTo(err_cntr);
  }
  
  
  });



</script>
