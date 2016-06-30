<?php 
function contact_action(){
$data=$_POST['form_data'];
  /* if ( !wp_verify_nonce( $data['wp-nonce'], "user_review_nonce")) {
      exit("No naughty business please");
   }*/
   $err_message=array();
   
   if (isset($data["g-recaptcha-response"])) {
   		
	   // your secret key
		$secret = "6LdfuCMTAAAAADtG2SjSrybHzqJobEAoJk5880oD";
		// empty response
		$response = null;
		// check secret key
		$reCaptcha = new ReCaptcha($secret);
		$response = $reCaptcha->verifyResponse(
			$_SERVER["REMOTE_ADDR"],
			$data["g-recaptcha-response"]
		);
		
		if ($response != null && $response->success) {
		//if (1) {
			
				   if($data['first_name']==""  && $data['last_name']=="" && $data['email_address']=="" ){
					   $message['error']="Please Fill Form properly";

				   }else{
				   
				   $user_email=	sanitize_email($data['send_email_address']);
				   	ob_start();
					?>
                    Firstname:<?php echo sanitize_text_field($data['first_name']); ?><br>
                    Lastname:<?php echo sanitize_text_field($data['last_name']);?><br>
                    Email:<?php echo sanitize_email($data['email_address']); ?><br>
                    
                    Notes:<br>
					<?php 
							$email_message = ob_get_contents();
							ob_end_clean();	
							$user_email =get_option('admin_email');
							$headers[]  = 'From: Carpetcall ';
							//$headers[]  = 'Cc: nabin.maharjan@agileitsolutios.net'; // note you can just use a simple email address
							$email_subject = "Contact Us";
							
							$sendmail = wp_mail($user_email, $email_subject, $email_message,$headers);
							$message['success']="Your message has been sent";
							}
			} else {
			  if($response->errorCodes=="missing-input-secret"){
				  $error="The secret parameter is missing.";
			  }else if($response->errorCodes=="invalid-input-secret"){
				  $error="The secret parameter is invalid or malformed.";
			  }else if($response->errorCodes=="missing-input-response"){
				  $error="The response parameter is missing.";
			  }else if($response->errorCodes=="invalid-input-response"){
				  $error="The response parameter is invalid or malformed.";
			  }else if($response->errorCodes=="missing-input"){
				  $error="Please Fill Captcha";
			  }
		  }
		  $message['captcha_error']=$error;
}
   echo json_encode($message); die;


} 
add_action('wp_ajax_contact_action', 'contact_action');
add_action('wp_ajax_nopriv_contact_action', 'contact_action');


