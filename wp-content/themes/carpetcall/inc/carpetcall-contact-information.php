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
                   
                   $user_email= sanitize_email($data['send_email_address']);
                 
                    ob_start();
                    ?>
                    Firstname:<?php echo sanitize_text_field($data['first_name']); ?><br>
                    Lastname:<?php echo sanitize_text_field($data['last_name']);?><br>
                    Email:<?php echo sanitize_email($data['email_address']); ?><br>
                    
                    Notes:<br>
                    <?php 
                            $email_message = ob_get_contents();
                            ob_end_clean(); 
                            if(!sanitize_email($data['send_email_address'])){
                            
                            $user_email =get_option('admin_email');
                             }
                            $headers[]  = 'From: Carpetcall ';
                            //$headers[]  = 'Cc: nabin.maharjan@agileitsolutios.net'; // note you can just use a simple email address
                            $email_subject = "Contact Us";
                            
                            $sent_mail= wp_mail($user_email, $email_subject, $email_message,$headers);
                            
                            $message['sent_mail']=$sent_mail;
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
   
   
 
   $y = '1787';
   $x = '<%=id %>';
   
    $listing_template = '<%=id %>';
    
     
   
   

    $listing_template = '<li data-store-id="<%= id %>" class="col-md-4">' . "\r\n";
    $listing_template .= "\t\t" . '<div>' . "\r\n";
   
    $listing_template .= "\t\t\t" . '<p><%= thumb %>' . "\r\n";
    $listing_template .= "\t\t\t\t" .'<span class="cc-store-icon-label"><img src ="'.get_template_directory_uri().'/images/blue.png"/>'.wpsl_store_header_template( 'listing' ).'</span><div class="clearfix"></div>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<span class="wpsl-street"><%= address %></span>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<% if ( address2 ) { %>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<span class="wpsl-street"><%= address2 %></span>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<% } %>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<span>' . wpsl_address_format_placeholders() . '</span>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<span class="wpsl-country"><%= country %></span>' . "\r\n";
   $listing_template .= "\t\t\t\t" . '<% if ( phone ) { %>' . "\r\n";
                $listing_template .= "\t\t\t\t" . '<span><strong>' .'P' .'</strong>: <%= formatPhoneNumber( phone ) %></span><br/>' . "\r\n";
                $listing_template .= "\t\t\t\t" . '<% } %>' . "\r\n";
                $listing_template .= "\t\t\t\t" . '<% if ( fax ) { %>' . "\r\n";
                $listing_template .= "\t\t\t\t" . '<span><strong>' .'F' .'</strong>: <%= fax %></span>' . "\r\n";
                $listing_template .= "\t\t\t\t" . '<% } %>' . "\r\n";
               $listing_template .='<div class="fcnt-or fcnt-orr clearfix"><a href="<%= permalink %>">View Store Page</a></div>';
                $listing_template .='<div class="fcnt-or fcnt-orr fcnt-orr-map clearfix"><a href="http://localhost/carpetcall/contact-us/?id=<%= id %>" class="cc-contact-link  ">Contact Store</a></div>';
    $listing_template .= "\t\t\t" . '</p>' . "\r\n";
     
 
    

   /* $listing_template .= "\t\t\t" . '<% if ( point_list ) { %>' . "\r\n";
    $listing_template .= "\t\t\t" . '<p><%= point_list %></p>' . "\r\n";
    $listing_template .= "\t\t\t" . '<% } %>' . "\r\n";*/
     // Check if the 'appointment_url' contains data before including it.

   /* $listing_template .= "\t\t\t" . '<% if ( appointment_url ) { %>' . "\r\n";
    $listing_template .= "\t\t\t" . '<p><a href="<%= appointment_url %>">' . __( 'Make an Appointment', 'wpsl' ) . '</a></p>' . "\r\n";
    $listing_template .= "\t\t\t" . '<% } %>' . "\r\n";*/
    
    $listing_template .= "\t\t" . '</div>' . "\r\n";
    
 if ( !$wpsl_settings['hide_distance'] ) {
        $listing_template .= "\t\t" . '<%= distance %> ' . esc_html( $wpsl_settings['distance_unit'] ) . '' . "\r\n";
    }
 /*   $listing_template .= "\t\t" . '<%= createDirectionUrl() %>' . "\r\n";*/
   
    $listing_template .= "\t" . '</li>' . "\r\n";

   

    return $listing_template;
}
/*add_action( 'wpsl_store_search','cc_store_search',10,1 );
function cc_store_search($){
|| id!=26783 ||id!=26797|| id!=26793 || id!=26789 || id!=26791 id!=26789 || id!=26785 || id!=26787 ||  


}*/
function custom_listing_templates_server() {
    

    global $wpsl_settings;
   
   
 
   $y = '1787';
   $x = '<%=id %>';
   
    $listing_template = '<%=id %>';
  

    $listing_template = '<% if (  id!=26801 ) { %>' .
    '<% if (  id!=26783 ) { %>'.
        '<% if (  id!=26797 ) { %>'.
            '<% if (  id!=26793 ) { %>'.
                '<% if (  id!=26789 ) { %>'.
                    '<% if (  id!=26791 ) { %>'.
                        
                            '<% if (  id!=26785 ) { %>'.
                                '<% if (  id!=26787 ) { %><li data-store-id="<%= id %>" class="col-md-4">' . "\r\n";
    $listing_template .= "\t\t" . '<div>' . "\r\n";
   
    $listing_template .= "\t\t\t" . '<p><%= thumb %>' . "\r\n";
    $listing_template .= "\t\t\t\t" .'<span class="cc-store-icon-label"><img src ="'.get_template_directory_uri().'/images/blue.png"/>'.wpsl_store_header_template( 'listing' ).'</span><div class="clearfix"></div>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<span class="wpsl-street"><%= address %></span>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<% if ( address2 ) { %>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<span class="wpsl-street"><%= address2 %></span>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<% } %>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<span>' . wpsl_address_format_placeholders() . '</span>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<span class="wpsl-country"><%= country %></span>' . "\r\n";
   $listing_template .= "\t\t\t\t" . '<% if ( phone ) { %>' . "\r\n";
                $listing_template .= "\t\t\t\t" . '<span><strong>' .'P' .'</strong>: <%= formatPhoneNumber( phone ) %></span><br/>' . "\r\n";
                $listing_template .= "\t\t\t\t" . '<% } %>' . "\r\n";
                $listing_template .= "\t\t\t\t" . '<% if ( fax ) { %>' . "\r\n";
                $listing_template .= "\t\t\t\t" . '<span><strong>' .'F' .'</strong>: <%= fax %></span>' . "\r\n";
                $listing_template .= "\t\t\t\t" . '<% } %>' . "\r\n";
               $listing_template .='<div class="fcnt-or fcnt-orr clearfix"><a href="<%= permalink %>">View Store Page</a></div>';
                $listing_template .='<div class="fcnt-or fcnt-orr fcnt-orr-map clearfix"><a href="http://staging.carpetcall.com.au/contact-us/?id=<%= id %>" class="cc-contact-link  ">Contact Store</a></div>';
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
    /*$listing_template .= "\t\t" . '<%= createDirectionUrl() %>' . "\r\n";*/
   
    $listing_template .= "\t" . '</li>' . "\r\n";

    $listing_template .= "\t\t\t\t" . '<% } %><% } %><% } %><% } %><% } %><% } %><% } %><% } %>' . "\r\n";


    return $listing_template;
}
//add_filter('wpsl_store_header_template','filter_store_count');
