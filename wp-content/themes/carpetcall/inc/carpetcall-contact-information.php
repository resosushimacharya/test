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
                     
                    
                     $flag = 0 ;
                     /*if(strlen($data['first_name'])==0){
                      echo strlen($data['first_name']);

                     }*/$terms = get_terms('wpsl_store_category');
                     $state_error=false;
                     $conenq = 1;
                     if(strcasecmp(sanitize_text_field($data['cc_enquiry_type']),'sales enquiry')==0){
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
                    $store_name_error=false;

                     $args =array('post_type'=>'wpsl_stores','posts_per_page'=>'-1');
                     $loop = new WP_Query($args);
                     while($loop->have_posts()):
                            $loop->the_post();
                          if(strcasecmp(get_the_title(),$data['cc_store_name'])==0){
                          $flag=1;
                         
                          break;
                        
                       }

                      endwhile;
                      wp_reset_query();
                         if($flag==0){
                        $store_name_error=true;
                     }
                    
                   }
                   else
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
                     $phono = sanitize_text_field($data['mobile_phone_no']);
                      $messagecheck = sanitize_text_field($data['cc_message'] );

                     
                     $emailcheck =sanitize_email($data['email_address']);
                    if($data['first_name']==""){
                      $message['error'] ='Error:Empty Firstname!';
                    }elseif(strlen($data['first_name'])>32){
                      $message['error'] ='Error:First name exceeds the length(32)!';
                    }elseif($data['last_name']==""){
                      $message['error'] ='Error:Empty Last name!';
                    }elseif(strlen($data['last_name'])>32){
                      $message['error'] ='Error:Last name exceeds the length(32)';
                    }elseif(filter_var($emailcheck, FILTER_VALIDATE_EMAIL) === false){
                     $message['error'] ='Email Format is Invalid!';
                    }elseif(!ctype_digit($phono)){
                      $message['error'] ='Phone number must be number!';
                    }elseif(strlen($phono)!=10){
                     $message['error'] = 'phone length must be of 10!';
                   }
                    elseif(str_word_count($messagecheck)>100){
                      $message['error'] ='Message words count exceeds(100)!';
                    }elseif($state_error){
                        $message['error'] ="You haven't choosen the state  correctly yet!";
                    }elseif($store_name_error){
                      $message['error'] ="You haven't choosen the store  correctly yet!";
                    }
                   else{

                  
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
                    ob_start();
                    ?>
                    Dear Admin,
                    <br><br>
                    We have an enquiry with the following information -<br><br>

                    <b>Enquiry Type</b> : <?php echo $hold_enquiry_type;?> <br>
                    <b>First Name</b>   : <?php echo sanitize_text_field(ucfirst($data['first_name'])); ?><br>
                    <b>Last Name</b>    : <?php echo sanitize_text_field(ucfirst($data['last_name']));?><br>
                    <b>Email</b>        : <?php echo sanitize_email($data['email_address']); ?><br>
                    <b>Phone</b>        : <?php echo sanitize_text_field($data['mobile_phone_no']); ?><br>
                    
                    <?php echo $hold;?><br>
                    <b>Message</b>      :<br> <?php echo sanitize_text_field($data['cc_message'] ); ?>
                   
                 
                    
                   
                    <?php 
                            $email_message = ob_get_contents();
                            ob_end_clean(); 
                            function get_administrator_email(){
                               $blogusers = get_users('role=Administrator');
          
                               $i=1;
                                 foreach ($blogusers as $user) {
                                  if($i==1){
                                              
                                             return $user->data->user_email;
                                             $i++;}
                                                     }  
                                                 }
                           $adminEmailAdd = get_administrator_email();   

                            
                            if(sanitize_email($data['send_email_address'])==''){

                            
                            $user_email =$adminEmailAdd;
                             }
                            $headers[]  = 'From: Carpetcall ';
                            //$headers[]  = 'Cc: nabin.maharjan@agileitsolutios.net'; // note you can just use a simple email address
                            $email_subject = "Contact Us";

                          //  var_dump($user_email);var_dump($email_subject);var_dump($email_message);var_dump($headers);
                          //  die;
                            if(isset($data['product_page_cat'])){

                              $netMessage = $data['product_page_cat'].'<br>'.$data['product_page_code'].'<br>'.$data['product_page_size'].'<br><br>Thanks .';
                              $email_message = $email_message.'<br>'.$netMessage; 
                            }
                            else{
                              $email_message .='<br><br>Thanks .' ;
                            }
                            $sent_mail= wp_mail($user_email, $email_subject, $email_message);
                            if(!$sent_mail){
                               $sent_mail= mail($user_email, $email_subject, $email_message);
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
                           
                            update_post_meta($user_id,'enquiry_type',ucwords($hold_enquiry_type));
                            update_post_meta($user_id,'phone',$data['mobile_phone_no']);
                            update_post_meta($user_id,'admin_email',$user_email);
                            
                                                   
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
    global $post;
   
 
     $x ='';
    $site_url = site_url();  
    $getinfo =get_post_meta($post->ID);
    if(array_key_exists('wpsl_phone',$getinfo)){
   $phone = $getinfo['wpsl_phone'][0];
   $x=  $phone;
   $x = preg_replace('/\s+/', '', $x);
   $x = '+61'.$x;
} 
      
    
   

    $listing_template = '<li data-store-id="<%= id %>" class="col-md-4">' . "\r\n";
    $listing_template .= "\t\t" . '<div class="cc-cat-store-section">' . "\r\n";
   
    $listing_template .= "\t\t\t" . '<p><%= thumb %>' . "\r\n";
    $listing_template .= "\t\t\t\t" .'<div class="cc-cat-store-item"><span class="cc-store-icon-label"><img src ="'.get_template_directory_uri().'/images/markers/location.png"/>'.wpsl_store_header_template( 'listing' ).'</span><div class="clearfix"></div>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<div class="cc-store-map-last-cover clearfix"><span class="wpsl-street"><%= address %></span>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<% if ( address2 ) { %>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<span class="wpsl-street"><%= address2 %></span>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<% } %>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<span>' . wpsl_address_format_placeholders() . '</span>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<span class="wpsl-country"><%= country %></span></div>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<% if ( phone ) { %>' . "\r\n";
            $listing_template .= "\t\t\t\t" . '<span class="cc-cat-store-item-phone"><strong>' .'P:' .'</strong><a href="tel:'.$x .'"> <%= formatPhoneNumber( phone ) %></a></span>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<% } else { %>' . "\r\n";
            $listing_template .= "\t\t\t\t" . '<span class="cc-cat-store-item-phone"><strong>' .'P: ' . '</strong> -</span>' . "\r\n";
            $listing_template .= "\t\t\t\t" . '<% } %>';
    $listing_template .= "\t\t\t\t" . '<% if ( fax ) { %>' . "\r\n";
                $listing_template .= "\t\t\t\t" . '<span class="cc-cat-store-item-fax"><strong>' .'F:' .'</strong> <%= fax %></span>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<% } else { %>' . "\r\n";
                  $listing_template .= "\t\t\t\t" . '<span class="cc-cat-store-item-fax"><strong>' .'F: ' . '</strong> -</span>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<% } %>';
               $listing_template .='</div><div class="cc-cats-vsp cc-cats-vsp-a clearfix"><a href="<%= permalink %>">View Store Page</a></div>';
                $listing_template .='<div class="cc-cats-or cc-cas-orr cc-cats-orr-map clearfix"><a href="'.$site_url.'/contact-us/?id=<%= id %>" class="cc-contact-link  ">Contact Store</a></div>';
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
     $getinfo =get_post_meta($post->ID);
      $x ='';
    if(array_key_exists('wpsl_phone',$getinfo)){
   $phone = $getinfo['wpsl_phone'][0];
   $x=  get_post_meta($post->ID,'wpsl_phone',true);
   $x = preg_replace('/\s+/', '', $x);
   $x = '+61'.$x;  
}  
   
 
   $y = '1787';
   
   
    $listing_template = '<%=id %>';
     $site_url = site_url();

    $listing_template = '<% if (  id!=26801 ) { %>' .
    '<% if (  id!=26783 ) { %>'.
        '<% if (  id!=26797 ) { %>'.
            '<% if (  id!=26793 ) { %>'.
                '<% if (  id!=26789 ) { %>'.
                    '<% if (  id!=26791 ) { %>'.
                        
                            '<% if (  id!=26785 ) { %>'.
                                '<% if (  id!=26787 ) { %><li data-store-id="<%= id %>" class="col-md-4">' . "\r\n";
    $listing_template .= "\t\t" . '<div class="cc-cat-store-section">' . "\r\n";
   
    $listing_template .= "\t\t\t" . '<p><%= thumb %>' . "\r\n";
    $listing_template .= "\t\t\t\t" .'<div class="cc-cat-store-item clearfix"><span class="cc-store-icon-label"><img src ="'.get_template_directory_uri().'/images/markers/location.png"/>'.wpsl_store_header_template( 'listing' ).'</span><div class="clearfix"></div>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<div class="cc-store-map-last-cover"><span class="wpsl-street"><%= address %></span>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<% if ( address2 ) { %>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<span class="wpsl-street"><%= address2 %></span>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<% } %>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<span>' . wpsl_address_format_placeholders() . '</span>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<span class="wpsl-country"><%= country %></span></div>' . "\r\n";
  $listing_template .= "\t\t\t\t" . '<% if ( phone ) { %>' . "\r\n";
            $listing_template .= "\t\t\t\t" . '<span class="cc-cat-store-item-phone"><strong>' .'P:' .'</strong><a href="tel:'.$x .'"><%= formatPhoneNumber( phone ) %></a></span>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<% } else { %>' . "\r\n";
            $listing_template .= "\t\t\t\t" . '<span class="cc-cat-store-item-phone"><strong>' .'P: ' . '</strong> -</span>' . "\r\n";
            $listing_template .= "\t\t\t\t" . '<% } %>';
    $listing_template .= "\t\t\t\t" . '<% if ( fax ) { %>' . "\r\n";
                $listing_template .= "\t\t\t\t" . '<span class="cc-cat-store-item-fax"><strong>' .'F:' .'</strong> <%= fax %></span>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<% } else { %>' . "\r\n";
                  $listing_template .= "\t\t\t\t" . '<span class="cc-cat-store-item-fax"><strong>' .'F: ' . '</strong> -</span>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<% } %>';
               $listing_template .='</div><div class="cc-cats-vsp cc-cats-vsp-a  clearfix"><a href="<%= permalink %>">View Store Page</a></div>';
                $listing_template .='<div class="cc-cats-or cc-cas-orr cc-cats-orr-map clearfix"><a href="'. $site_url.'/contact-us/?id=<%= id %>" class="cc-contact-link  ">Contact Store</a></div>';
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

        $phonesec = '<strong>' .'P:' .'</strong>'.$phone;
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
        $info_window_template .= "\t\t" . '<% if ( phone ) { %>' . "\r\n";
         $info_window_template .= "\t\t\t\t" . '<span class="cc-cat-store-item-phone"><strong>' .'P:' .'</strong><a href="tel:'.$x.'"> <%= formatPhoneNumber( phone ) %></a></span>' . "\r\n";
        $info_window_template .= "\t\t" . '<% } else { %>' . "\r\n";
        $info_window_template .= "\t\t\t\t" . '<span><strong>' .'P: ' . '</strong> -</span>' . "\r\n";
      $info_window_template .= "\t\t\t\t" . '<% } %>';
        $info_window_template .= "\t\t" . '<% if ( fax ) { %>' . "\r\n";
        $info_window_template .= "\t\t" . '<span><strong>' . esc_html( $wpsl->i18n->get_translation( 'fax_label', __( 'F', 'wpsl' ) ) ) . '</strong>: <%= fax %></span>' . "\r\n";
        
        $info_window_template .= "\t\t" . '<% } else { %>' . "\r\n";
        $info_window_template .= "\t\t\t\t" . '<span><strong>' .'F: ' . '</strong> -</span>' . "\r\n";
        $info_window_template .= "\t\t\t\t" . '<% } %>';
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
        $fax = '-';


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

        $phonesec = '<strong>' .'P:' .'</strong>'.$phone;
        $faxsec = '<strong>F:</strong> '.$fax; 



        $cpt_info_window_template = '<div class="wpsl-info-window">' . "\r\n";
        $cpt_info_window_template .= "\t\t" . '<p class="wpsl-no-margin">' . "\r\n";
        $cpt_info_window_template .= "\t\t\t" .  wpsl_store_header_template( 'wpsl_map' ) . "\r\n";
        $cpt_info_window_template .= "\t\t\t" . '<span><%= address %></span>' . "\r\n";
        $cpt_info_window_template .= "\t\t\t" . '<% if ( address2 ) { %>' . "\r\n";
        $cpt_info_window_template .= "\t\t\t" . '<span><%= address2 %></span>' . "\r\n";
        $cpt_info_window_template .= "\t\t\t" . '<% } %>' . "\r\n";
        $cpt_info_window_template .= "\t\t\t" . '<span>' . wpsl_address_format_placeholders() . '</span>' . "\r\n"; 
        $cpt_info_window_template .= "\t\t\t\t" . '<span class="cc-cat-store-item-phone">'.$phonesec.'</span>' . "\r\n";
        $cpt_info_window_template .= "\t\t\t\t" . '<span class="cc-cat-store-item-fax">'.$faxsec .'</span>' . "\r\n";
        $cpt_info_window_template .= "\t\t" . '</p>' . "\r\n";
        $cpt_info_window_template .= "\t" . '</div>';

        return $cpt_info_window_template;
      }
