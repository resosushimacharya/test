<?php 


function contact_action(){
	$data=$_POST['form_data'];
	$message=array();
	if (isset($data["g-recaptcha-response"])) {
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
			$flag = 0 ;
			$state_error=false;
			$store_name_error=false;
			$conenq = 1;
			$terms = get_terms('wpsl_store_category');
			if($data['cc_state_type_only'] && $data['cc_contact_type'] == 'custom_rugs' ){
				$flag=0;
				$state_error=false;
				$store_name_error=false;
				foreach($terms as $term){
					$selected="";
					if(strcasecmp($term->slug,$data['cc_state_type_only'])==0){
						$flag=1;
					}
				}
				if($flag==0){
				$state_error=true;
				}
				}else{
			if($data['cc_contact_type'] != 'service'){
				$conenq =0;
				foreach($terms as $term){
					$selected="";
					if(strcasecmp($term->slug,$data['cc_state_type'])==0){
						$flag=1;
						break;
					}
				}
				if($flag==0){
					$state_error=true;
				}
				$flag=0;
				$args =array('post_type'=>'wpsl_stores','posts_per_page'=>'-1');
				$loop = new WP_Query($args);
				while($loop->have_posts()){
					$loop->the_post();
					if(strcasecmp(get_the_title(),$data['cc_store_name'])==0){
						$flag=1;
						break;
					}
				}
				wp_reset_query();
				if($flag==0){
					$store_name_error=true;
				}
			}else
			{
				$flag=0;
				$state_error=false;
				$store_name_error=false;
				foreach($terms as $term){
					$selected="";
					if(strcasecmp($term->slug,$data['cc_state_type_only'])==0){
						$flag=1;
					}
				}
				if($flag==0){
				$state_error=true;
				}
			}
				}
			$first_name =sanitize_text_field($data['first_name']);
			$last_name =sanitize_text_field($data['last_name']);
			$emailcheck =sanitize_email($data['email_address']);
			$phono = sanitize_text_field($data['mobile_phone_no']);
			$messagecheck = sanitize_text_field($data['cc_message'] );
			
			if($data['first_name']==""){
				$message['error'] ='Error:Empty Firstname!';
			}elseif(strlen($data['first_name'])>50){
				$message['error'] ='Error:First name exceeds the length(50)!';
			}elseif($data['last_name']==""){
				$message['error'] ='Error:Empty Last name!';
			}elseif(strlen($data['last_name'])>50){
				$message['error'] ='Error:Last name exceeds the length(50)';
			}elseif(filter_var($emailcheck, FILTER_VALIDATE_EMAIL) === false){
				$message['error'] ='Email Format is Invalid!';
			}elseif(!ctype_digit($phono)){
				$message['error'] ='Phone number must be number!';
			}elseif(strlen($phono)!=10){
				$message['error'] = 'phone length must be of 10!';
			}
			elseif(str_word_count($messagecheck)>50){
				$message['error'] ='Message words count exceeds(50)!';
			}elseif($state_error){
				$message['error'] ="You haven't choosen the state  correctly yet!";
			}elseif($store_name_error){
				$message['error'] ="You haven't choosen the store  correctly yet!";
			}else{
				$user_email= sanitize_email($data['send_email_address']);
				if(strcasecmp(sanitize_text_field($data['cc_enquiry_type']),'sales enquiry')==0){
					$hold = '<b>State</b>       :'.strtoupper($data['cc_state_type']).'<br>'.'<b>Store</b>        :'.ucwords($data['cc_store_name']).'<br>';
				}
				else
				{
					$hold = "<b>State</b>       :".strtoupper($data['cc_state_type_only']).'<br>';
				}
				if(isset($data['product_page_cat'])){
					$hold_enquiry_type =  "Product Enquiry";     
				}
				else{
					$hold_enquiry_type =  sanitize_text_field(ucfirst($data['cc_enquiry_type'] ));
				}
				
				$date_time = current_time('d/m/Y, g:i a');
				$email_title = '';
				$cc_enq_type = sanitize_text_field($data['cc_contact_type']);
				switch ($cc_enq_type){
					case 'sales':
					$email_header = 'Sales Enquiry';
					break;
					case 'service':
					$email_header = 'Service Enquiry';
					break;
					case 'custom_rugs':
					$email_header = 'Custom Rugs Enquiry';
					break;
					case 'rugs':
					$email_header = 'Rugs Product Enquiry';
					break;
					case 'hardflooring':
					$email_header = 'Hard-Flooring Product Enquiry';
					break;
					case 'carpets':
					$email_header = 'Carpets Product Enquiry';
					break;
					default:
					$email_header = 'Carpetcall Enquiry';
				}
				ob_start();
				include get_template_directory().'/templates/emails/header.php';
				include get_template_directory().'/templates/emails/content/user.php';
				include get_template_directory().'/templates/emails/footer.php';
				$body_user = ob_get_contents();
				ob_end_clean(); 
				
				function get_administrator_email(){
					$blogusers = get_users('role=Administrator');
					$i=1;
					foreach ($blogusers as $user) {
						if($i==1){
							return $user->data->user_email;
							$i++;
						}
					}  
				}
				$adminEmailAdd = get_administrator_email();   
				if(sanitize_email($data['send_email_address'])==''){
					$user_email =$adminEmailAdd;
				}
				
				
				
				$headers = array();
				$headers[]  = 'MIME-Version: 1.0' . "\r\n";
				$headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				
				// Additional headers
				$headers[] = 'To: '.$first_name.' '.$last_name.' < '.$emailcheck.' >' . "\r\n";
				$headers[] = 'From: Carpetcall < '.get_option("admin_email").' >' . "\r\n";
				//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
				//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";
				$email_subject = $email_header;
				$sent_mail= wp_mail($emailcheck, $email_subject, $body_user,$headers);
				if(!$sent_mail){
					$sent_mail= mail($emailcheck, $email_subject, $body_user,$headers);
				}
				
				if(isset($data['product_page_cat'])){
					$netMessage = $data['product_page_cat'].'<br>'.$data['product_page_code'].'<br>'.$data['product_page_size'].'<br>';
					$messagecheck = $netMessage.'<br>'.$messagecheck;
				}
				else{
					$messagecheck = $messagecheck;
				}
				$namesave=ucfirst($data['first_name']).' '.ucfirst($data['last_name']);
				$message_post = array(
				'post_title'    => wp_strip_all_tags($namesave),
				'post_content'  => $messagecheck,
				'post_status'   => 'publish',
				'post_author'   => $post->post_author,
				'post_type' => 'enquiries'
				);
				
				$user_id=wp_insert_post( $message_post );
				update_post_meta($user_id,'email',$data['email_address']);
				update_post_meta($user_id,'enquiry_type',ucwords($email_header));
				update_post_meta($user_id,'phone',$data['mobile_phone_no']);
				update_post_meta($user_id,'admin_email',$user_email[0]);
				
				// do_action('manage_enquiries_posts_custom_column','names',$email_subject,$user_id);
				$time =   esc_attr( get_the_date('F j, Y',$user_id)).' at '.esc_attr(get_the_time('g:i a',$user_id));
				update_post_meta($user_id,'enquiry_date_contact',$time );
				
				if($conenq==0){
					update_post_meta($user_id,'state',strtoupper($data['cc_state_type']));
					update_post_meta($user_id,'store',ucwords(strtolower($data['cc_store_name'])));
				}
				else{
					update_post_meta($user_id,'state',strtoupper($data['cc_state_type_only']));
				}
				
				
				
				$message['sent_mail']=$sent_mail;
				$textmessage=get_field('success_message_content',89);
				$message['success']=$textmessage;
				$date_time =  $date_time = current_time('d/m/Y, g:i a');
				
				
				
				
				if($cc_enq_type == 'sales'){
					ob_start();
					include get_template_directory().'/templates/emails/header.php';
					include get_template_directory().'/templates/emails/content/admin-sales.php';
					include get_template_directory().'/templates/emails/footer.php';
					$body_admin = ob_get_clean();	
				}if($cc_enq_type == 'service'){
					ob_start();
					include get_template_directory().'/templates/emails/header.php';
					include get_template_directory().'/templates/emails/content/admin-service.php';
					include get_template_directory().'/templates/emails/footer.php';
					$body_admin = ob_get_clean();	
				}elseif($cc_enq_type == 'rugs'){
					ob_start();
					include get_template_directory().'/templates/emails/header.php';
					include get_template_directory().'/templates/emails/content/admin-rugs.php';
					include get_template_directory().'/templates/emails/footer.php';
					$body_admin = ob_get_clean();	
						
				}elseif($cc_enq_type == 'hardflooring'){
					ob_start();
					include get_template_directory().'/templates/emails/header.php';
					include get_template_directory().'/templates/emails/content/admin-hardflooring.php';
					include get_template_directory().'/templates/emails/footer.php';
					$body_admin = ob_get_clean();	
						
				}elseif($cc_enq_type == 'carpets'){
					ob_start();
					include get_template_directory().'/templates/emails/header.php';
					include get_template_directory().'/templates/emails/content/admin-carpets.php';
					include get_template_directory().'/templates/emails/footer.php';
					$body_admin = ob_get_clean();	
						
				}elseif($cc_enq_type == 'custom_rugs'){
					ob_start();
					include get_template_directory().'/templates/emails/header.php';
					include get_template_directory().'/templates/emails/content/admin-custom_rugs.php';
					include get_template_directory().'/templates/emails/footer.php';
					$body_admin = ob_get_clean();	
				}
				$emails_settings = get_field($cc_enq_type.'_emails_settings','options');
				$bcc_emails = '';
				$cc_emails = '';
				$to = array();
				$to[] = $user_email;
				if(!empty($emails_settings)){
					foreach($emails_settings as $emails){
						if($emails[$cc_enq_type.'_state'] == $data['cc_state_type'] || $emails[$cc_enq_type.'_state'] =='all' ){
							if($emails[$cc_enq_type.'_bcc_emails']){
								$bcc_emails .=$emails[$cc_enq_type.'_bcc_emails'].', ';
							}
							if(is_email($emails[$cc_enq_type.'_to_emails'])){
								if($user_email != $emails[$cc_enq_type.'_to_emails'] && !in_array($emails[$cc_enq_type.'_to_emails'],$to)){
									$to[]=$emails[$cc_enq_type.'_to_emails'];
								}
							}
							if($emails[$cc_enq_type.'_cc_emails']){
								if($user_email != $emails[$cc_enq_type.'_cc_emails']){
									$cc_emails.=$emails[$cc_enq_type.'_cc_emails'].', ';
								}
							}
						}
					}
				}
				
				$headers = array();
				$headers[]  = 'MIME-Version: 1.0' . "\r\n";
				$headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				
				// Additional headers
				$headers[] = 'To: Admin <admin@carpetcall.com.au>' . "\r\n";
				$headers[] = 'From: Carpetcall < admin@carpetcall.com.au >' . "\r\n";
				$headers[] = 'Cc: '.$cc_emails. "\r\n";
				$headers[] = 'Bcc: '.$bcc_emails. "\r\n";
				$email_subject = $email_header;
				$to = array('yamuaryal@gmail.com');
				$sent_mail= wp_mail($to, $email_subject, $body_admin,$headers);
				if(!$sent_mail){
					$sent_mail= mail(explode(', ',$to), $email_subject, $body_admin,explode(' ',$headers));
				}
			}
			//error_log('Admin Mail: user_email '.print_r($to, true).' email subject '.$email_subject.' email header '.print_r($headers,true).' body '.$body_admin.'mail log'.$sent_mail);
		}else
		{
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
add_filter( 'wpsl_meta_box_fields', 'customize_module' );

function customize_module( $meta_fields ) {
    
    $meta_fields[__( 'Additional Information', 'wpsl' )] = array(
        'phone' => array(
            'label' => __( 'Tel', 'wpsl' )
        ),
        'fax' => array(
            'label' => __( 'Fax', 'wpsl' )
        ),
        'email' => array(
            'label' => __( 'Email', 'wpsl' )
        ),
        'url' => array(
            'label' => __( 'Url', 'wpsl' )
        ),
        'point_list' => array(
            'label' => __( 'Ponit List', 'wpsl' )
        )
    );

    return $meta_fields;
}
/*to select the local data or server data
*/

$url = site_url();
$url =explode('/',$url);

if(strcasecmp($url[2],'localhost')==0){
 add_filter( 'wpsl_listing_template', 'custom_listing_templates' );
}
else{
  
add_filter( 'wpsl_listing_template', 'custom_listing_templates_server');
}


 
/*add_filter( 'wpsl_listing_template', 'custom_listing_templates' );*/
add_filter( 'wpsl_meta_box_fields', 'custom_meta_box_appointment' );

function custom_meta_box_appointment( $meta_fields ) {
    
    $meta_fields[__( 'Appointment', 'wpsl' )] = array(
        'appointment_url' => array(
            'label' => __( 'Appointment', 'wpsl' )
        )
    );


    return $meta_fields;
}
add_filter( 'wpsl_frontend_meta_fields', 'custom_frontend_meta_appointment' );

function custom_frontend_meta_appointment( $store_fields ) {

    $store_fields['wpsl_appointment_url'] = array( 
        'name' => 'appointment_url',
        'type' => 'url'
    );

    return $store_fields;
}

function custom_listing_templates() {
    
    global $wpsl_settings;
      global $post;
     
  $site_url = site_url();
  $cat = get_queried_object();

if($cat->taxonomy){
    
    $categoryName = $cat->name;
    $categoryCount = $cat->count; 
    if($categoryCount>1){
        $categoryStore = 'STORES';
    }
    else{
        $categoryStore = 'STORE';
    }
   $categoryDisdplay ='<div class="cc-store-cat-page-heading">SHOWING '.$cat->count.' '.$categoryStore.'  IN '.$categoryName.' </div>' ;
}
     

    $site_url = site_url();  
          
    $listing_template = '<li data-store-id="<%= id %>" class="col-xs-6 col-sm-4">' . "\r\n";
    $listing_template .= "\t\t" . '<div class="cc-cat-store-section">' . "\r\n";
   
    $listing_template .= "\t\t\t" . '<p><%= thumb %>' . "\r\n";
    $listing_template .= "\t\t\t\t" .'<div class="cc-cat-store-item"><span class="cc-store-icon-label"><img src ="'.get_template_directory_uri().'/images/markers/location.png"/>'.wpsl_store_header_template( 'listing' ).'</span><div class="clearfix"></div>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<div class="cc-store-map-last-cover clearfix"><span class="wpsl-street"><%= address %></span>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<% if ( address2 ) { %>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<span class="wpsl-street"><%= address2 %></span>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<% } %>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<span>' . wpsl_address_format_placeholders() . '</span>' . "\r\n";
    
  
               $listing_template .='</div>'. "\r\n";
                    $listing_template .= "\t\t\t\t" . '<div class="cc-phone-fax-wrapper"><% if ( phone ) { %><% tel = phone.replace(" ", "") %>' . "\r\n";
            $listing_template .= "\t\t\t\t" . '<span class="cc-cat-store-item-phone"><strong>' .'P: ' .'</strong><a href="tel:+61' . '<%= (tel.replace( /\s+/g,"" )).replace( "0", "" ) %>' . '"> <%= phone %></a></span>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<% }  %>' . "\r\n";
           
    $listing_template .= "\t\t\t\t" . '<% if ( fax ) { %>' . "\r\n";
                $listing_template .= "\t\t\t\t" . '<span class="cc-cat-store-item-fax"><strong>' .'F: ' .'</strong> <%= fax %></span>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<% } %>' . "\r\n";
    
            $listing_template .= "\t\t" . '</div>' . "\r\n";
               $listing_template .='<div class="cc-last-con-vis-wrapper"><div class="cc-cats-vsp cc-cats-vsp-a clearfix"><a href="<%= permalink %>">View Store Page</a></div>';
                $listing_template .='<div class="cc-cats-or cc-cas-orr cc-cats-orr-map clearfix"><a href="'.$site_url.'/contact-us/?id=<%= id %>" class="cc-contact-link  ">Contact Store</a></div></div>';
    $listing_template .= "\t\t\t" . '</p>' . "\r\n";
     
 
    

   /* $listing_template .= "\t\t\t" . '<% if ( point_list ) { %>' . "\r\n";
    $listing_template .= "\t\t\t" . '<p><%= point_list %></p>' . "\r\n";
    $listing_template .= "\t\t\t" . '<% } %>' . "\r\n";*/
     // Check if the 'appointment_url' contains data before including it.

   /* $listing_template .= "\t\t\t" . '<% if ( appointment_url ) { %>' . "\r\n";
    $listing_template .= "\t\t\t" . '<p><a href="<%= appointment_url %>">' . __( 'Make an Appointment', 'wpsl' ) . '</a></p>' . "\r\n";
    $listing_template .= "\t\t\t" . '<% } %>' . "\r\n";*/
    
    $listing_template .= "\t\t" . '</div>' . "\r\n";
    
 // if ( !$wpsl_settings['hide_distance'] ) {
 //        $listing_template .= "\t\t" . '<%= distance %> ' . esc_html( $wpsl_settings['distance_unit'] ) . '' . "\r\n";
 //    }
  $listing_template .= "\t\t" . '<div id="cc-custom-dir-wrap"><%= [createDirectionUrl() ]%></div>' . "\r\n";
   
    $listing_template .= "\t" . '</li>' . "\r\n";

   

    return $listing_template;
}
/*add_action( 'wpsl_store_search','cc_store_search',10,1 );
function cc_store_search($){
|| id!=26783 ||id!=26797|| id!=26793 || id!=26789 || id!=26791 id!=26789 || id!=26785 || id!=26787 ||  


}*/
function custom_listing_templates_server() {
  global $wpsl_settings;
  global $post;
     
  $site_url = site_url();
  $cat = get_queried_object();

if($cat->taxonomy){
    
    $categoryName = $cat->name;
    $categoryCount = $cat->count; 
    if($categoryCount>1){
        $categoryStore = 'STORES';
    }
    else{
        $categoryStore = 'STORE';
    }
   $categoryDisdplay ='<div class="cc-store-cat-page-heading">SHOWING '.$cat->count.' '.$categoryStore.'  IN '.$categoryName.' </div>' ;
}
    
    $listing_template = '<% if (  id!=26801 ) { %>' .
    '<% if (  id!=26783 ) { %>'.
        '<% if (  id!=26797 ) { %>'.
            '<% if (  id!=26793 ) { %>'.
                '<% if (  id!=26789 ) { %>'.
                    '<% if (  id!=26791 ) { %>'.
                        
                            '<% if (  id!=26785 ) { %>'.
                                '<% if (  id!=26787 ) { %><li data-store-id="<%= id %>" class="col-xs-6 col-sm-4">' . "\r\n";
    $listing_template .= "\t\t" . '<div class="cc-cat-store-section">' . "\r\n";
   
    $listing_template .= "\t\t\t" . '<p><%= thumb %>' . "\r\n";
    $listing_template .= "\t\t\t\t" .'<div class="cc-cat-store-item clearfix"><span class="cc-store-icon-label"><img src ="'.get_template_directory_uri().'/images/markers/location.png"/>'.wpsl_store_header_template( 'listing' ).'</span><div class="clearfix"></div>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<div class="cc-store-map-last-cover"><span class="wpsl-street"><%= address %></span>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<% if ( address2 ) { %>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<span class="wpsl-street"><%= address2 %></span>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<% } %>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<span>' . wpsl_address_format_placeholders() . '</span>' . "\r\n";
    
 
               $listing_template .='</div>'. "\r\n";
                $listing_template .= "\t\t\t\t" . '<div class="cc-phone-fax-wrapper"><% if ( phone ) { %><% tel = phone.replace(" ", "") %>' . "\r\n";
            $listing_template .= "\t\t\t\t" . '<span class="cc-cat-store-item-phone"><strong>' .'P: ' .'</strong><a href="tel:+61' . '<%= (tel.replace( /\s+/g,"" )).replace( "0", "" ) %>' . '"> <%= phone %></a></span>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<% }  %>' . "\r\n";
           
    $listing_template .= "\t\t\t\t" . '<% if ( fax ) { %>' . "\r\n";
                $listing_template .= "\t\t\t\t" . '<span class="cc-cat-store-item-fax"><strong>' .'F: ' .'</strong> <%= fax %></span>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<% } %>' . "\r\n";
    
            $listing_template .= "\t\t" . '</div>' . "\r\n";
            $listing_template .=  "\t\t" .' <div class="cc-last-con-vis-wrapper"><div class="cc-cats-vsp cc-cats-vsp-a  clearfix"><a href="<%= permalink %>">View Store Page</a></div>';
                $listing_template .='<div class="cc-cats-or cc-cas-orr cc-cats-orr-map clearfix"><a href="'. $site_url.'/contact-us/?id=<%= id %>" class="cc-contact-link  ">Contact Store</a></div></div>';
    $listing_template .= "\t\t\t" . '</p>' . "\r\n";
     
 
    

   /* $listing_template .= "\t\t\t" . '<% if ( point_list ) { %>' . "\r\n";
    $listing_template .= "\t\t\t" . '<p><%= point_list %></p>' . "\r\n";
    $listing_template .= "\t\t\t" . '<% } %>' . "\r\n";*/
     // Check if the 'appointment_url' contains data before including it.

   /* $listing_template .= "\t\t\t" . '<% if ( appointment_url ) { %>' . "\r\n";
    $listing_template .= "\t\t\t" . '<p><a href="<%= appointment_url %>">' . __( 'Make an Appointment', 'wpsl' ) . '</a></p>' . "\r\n";
    $listing_template .= "\t\t\t" . '<% } %>' . "\r\n";*/
    
    $listing_template .= "\t\t" . '</div>' . "\r\n";
    
   /*if ( !$wpsl_settings['hide_distance'] ) {
        $listing_template .= "\t\t" . '<%= distance %> ' . esc_html( $wpsl_settings['distance_unit'] ) . '' . "\r\n";
    }*/
   $listing_template .= "\t\t" . '<div id="cc-custom-dir-wrap"><%= createDirectionUrl() %></div>' . "\r\n";
   
    $listing_template .= "\t" . '</li>' . "\r\n";

    $listing_template .= "\t\t\t\t" . '<% } %><% } %><% } %><% } %><% } %><% } %><% } %><% } %>' . "\r\n";


    return $listing_template;
}
//add_filter('wpsl_store_header_template','filter_store_count');
  add_filter('manage_edit-enquiries_columns', 'my_columns');

function my_columns($columns) {
   /*$columns['name'] = __('Name');*/
     
    
    $columns['email'] =  __('Email Address');
    $columns['phone'] = __('Phone Number');
    $columns['enquirytype'] = __('Enquiry Type');
   
    $columns['adminemail'] = __("Admin Email");
     $columns['enquirydate'] = __("Enquiry Date");
 
    return $columns;
}
add_action('manage_enquiries_posts_custom_column', 'manage_gallery_columns', 10, 2);
 
function manage_gallery_columns($column_name, $xyz) {
    global $wpdb;
    
     $x= get_post_meta($xyz);
      /*do_action('pr', $x);
      die;*/
    switch ($column_name) {
   /* case 'name':
        echo $x['name'][0];
            break;*/

     case 'email':
        echo $x['email'][0];
            break;
    case 'phone':
        echo $x['phone'][0];
            break;
     case 'enquirytype':
        echo $x['enquiry_type'][0];
            break; 
        
      case 'adminemail' :
        echo $x['admin_email'][0] ;   
        break;   
        case 'enquirydate' :
        echo $x['enquiry_date_contact'][0] ;  
        break; 
                           
    default:
        break;
    } // end switch

} 
add_filter('manage_posts_columns', 'thumbnail_column');
function thumbnail_column($columns) {
  $new = array();
  foreach($columns as $key => $title) {
    if ($key=='author') // Put the Thumbnail column before the Author column
      $new['thumbnail'] = 'Thumbnail';
    $new[$key] = $title;
  }
  return $new;
}
function carpetcall_sort_column( $wp_query ) {
  if (is_admin()) {

    // Get the post type from the query
    $post_type = $wp_query->query['post_type'];

    if ( $post_type == 'enquiries') {

      $wp_query->set('orderby', 'date');

      $wp_query->set('order', 'DESC');
    }
  }
}
add_filter('pre_get_posts', 'carpetcall_sort_column');
add_filter( 'wpsl_info_window_template', 'custom_more_info_template' ,10);

function custom_more_info_template() {
    
    global $wpsl;
   

        global $post;
        $getinfo  = get_post_meta($post->ID);
        $phone = ' -';
        $fax = '-';
        $x = ' ';

if(array_key_exists('wpsl_phone',$getinfo)){
        $phone = $getinfo['wpsl_phone'][0];$phone = $getinfo['wpsl_phone'][0];
        $x=  $phone;
        $x = preg_replace('/\s+/', '', $x);
        $x = '+61'.$x;  
        $phone = ' <a class="phone" href="tel:'.$x.'">'.$phone.' </a>';
}
if(array_key_exists('wpsl_fax',$getinfo)){
        $fax = $getinfo['wpsl_fax'][0];
}

        $phonesec = '<strong>' .'P: ' .'</strong>'.$phone;
        $faxsec = '<strong>F:</strong> '.$fax; 



   $info_window_template = '<div data-store-id="<%= id %>" class="wpsl-info-window">' . "\r\n";
        $info_window_template .= "\t\t" . '<p>' . "\r\n";
        $info_window_template .= "\t\t\t" .  wpsl_store_header_template() . "\r\n";  // Check which header format we use
        $info_window_template .= "\t\t\t" . '<span><%= address %></span>' . "\r\n";
        $info_window_template .= "\t\t\t" . '<% if ( address2 ) { %>' . "\r\n";
        $info_window_template .= "\t\t\t" . '<span><%= address2 %></span>' . "\r\n";
        $info_window_template .= "\t\t\t" . '<% } %>' . "\r\n";
        $info_window_template .= "\t\t\t" . '<span>' . wpsl_address_format_placeholders() . '</span>' . "\r\n"; // Use the correct address format
        $info_window_template .= "\t\t" . '</p>' . "\r\n";
        $info_window_template .= "\t\t" . '<% if ( phone ) { %><% tel = phone.replace(" ", "") %>' . "\r\n";
            $info_window_template .= "\t\t\t\t" . '<span class="cc-cat-store-item-phone"><strong>' .'P: ' .'</strong><a href="tel:+61' . '<%= (tel.replace( /\s+/g,"" )).replace( "0", "" ) %>' . '"><%= phone %></a></span>' . "\r\n";
    $info_window_template .= "\t\t\t\t" . '<% } %>' . "\r\n";
        $info_window_template .= "\t\t" . '<% if ( fax ) { %>' . "\r\n";
        $info_window_template .= "\t\t" . '<span><strong>' . esc_html( $wpsl->i18n->get_translation( 'fax_label', __( 'F', 'wpsl' ) ) ) . '</strong>: <%= fax %></span>' . "\r\n";
        
        $info_window_template .= "\t\t" . '<% }  %>' . "\r\n";
      
        /*$info_window_template .= "\t\t" . '<% if ( email ) { %>' . "\r\n";
        $info_window_template .= "\t\t\r\n";
        $info_window_template .= "\t\t" . '<% } %>' . "\r\n";*/
        /*$info_window_template .= "\t\t" . '<%= createInfoWindowActions( id ) %>' . "\r\n";*/
        $info_window_template .= "\t" . '</div>';

       return $info_window_template ;
      }
/* 
*single store display plugin extension


*/
add_filter('wpsl_cpt_info_window_template','custom_wpsl_cpt_info_window_template',10);
function custom_wpsl_cpt_info_window_template(){

        global $post;
        $getinfo  = get_post_meta($post->ID);
        $phone = ' -';
        $phoneCon = false;
        $faxCon = false;
        $fax = '-';


if(array_key_exists('wpsl_phone',$getinfo)){
	
        $phone = $getinfo['wpsl_phone'][0];
        if($phone  == ' '){
		$phoneCon = false;
	
	}
  else{
    $phoneCon = true;
  }
        $phone = $getinfo['wpsl_phone'][0];
        $x=  $phone;
        $x = preg_replace('/\s+/', '', $x);
        $x = '+61'.$x;  
        $phone = ' <a class="phone" href="tel:'.$x.'">'.$phone.' </a>';
     
 

}
if(array_key_exists('wpsl_fax',$getinfo)){
        $fax = $getinfo['wpsl_fax'][0];
        	if($fax  == ' '){
		$faxCon = false;
		//break;
	}
	 else{
    $faxCon  = true;
  }
}

        $phonesec = '<strong>' .'P: ' .'</strong>'.$phone;
        $faxsec = '<strong>F:</strong> '.$fax; 



        $cpt_info_window_template = '<div class="wpsl-info-window">' . "\r\n";
        $cpt_info_window_template .= "\t\t" . '<p class="wpsl-no-margin">' . "\r\n";
        $cpt_info_window_template .= "\t\t\t" .  wpsl_store_header_template( 'wpsl_map' ) . "\r\n";
        $cpt_info_window_template .= "\t\t\t" . '<span><%= address %></span>' . "\r\n";
        $cpt_info_window_template .= "\t\t\t" . '<% if ( address2 ) { %>' . "\r\n";
        $cpt_info_window_template .= "\t\t\t" . '<span><%= address2 %></span>' . "\r\n";
        $cpt_info_window_template .= "\t\t\t" . '<% } %>' . "\r\n";

        $cpt_info_window_template .= "\t\t\t" . '<span>' . wpsl_address_format_placeholders() . '</span>' . "\r\n"; 
            if($phoneCon){
        $cpt_info_window_template .= "\t\t\t\t" . '<span class="cc-cat-store-item-phone">'.$phonesec.'</span>' . "\r\n";
    }
     if($faxCon){
        $cpt_info_window_template .= "\t\t\t\t" . '<span class="cc-cat-store-item-fax">'.$faxsec .'</span>' . "\r\n";
    }
        $cpt_info_window_template .= "\t\t" . '</p>' . "\r\n";
        $cpt_info_window_template .= "\t" . '</div>';

        return $cpt_info_window_template;
      }