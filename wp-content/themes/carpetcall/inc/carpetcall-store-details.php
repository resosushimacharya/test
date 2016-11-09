<?php 
function email_address()
{
	$storeName = sanitize_text_field($_POST['store']);
	$stateemailpair = array();
	wp_reset_query();
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
	$args = array(
					'post_type' =>'wpsl_stores',
					'posts_per_page'=>'-1'
					
				);
	$loop = new WP_Query($args);
	if($loop->have_posts())
	{
		while($loop->have_posts())
		{
			$loop->the_post();
		/*
		**check  whether the email address is present or not
		***es then  set as it is as reciever email address
		****then filter the state form wpsl_state
		***** set the email address as of state head office email address
		*/
			if(strcasecmp(get_the_title(),$storeName)==0)
			{
					
				$res = get_post_meta($loop->post->ID);
				
				
				if(!$res['wpsl_email'][0])
				{
					//This line is to return head office email if selected store don't have email.
					$html = '';
			    	//$html.=$stateemailpair[$res['wpsl_state'][0]];

				}
				else
				{
					$html.=$res['wpsl_email'][0];
				}
				
				break;
			}
		
		}
		wp_reset_query();
	}
	echo $html;
	die();
}
add_action('wp_ajax_email_address', 'email_address');
add_action('wp_ajax_nopriv_email_address', 'email_address');
add_action( 'wp_enqueue_scripts', 'email_address_scripts' );
function email_address_scripts()
{
	wp_register_script('email_address-autocomplete', get_template_directory_uri(). '/js/email.address.autocomplete.js', '',true);
	wp_enqueue_script('email_address-autocomplete');
	wp_localize_script( 'email_address-autocomplete', 'wp_email_address_autocomplete', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
function email_address_state(){
	$stateName =  $_POST['staterel'];
	$stateName = strtoupper($stateName);
	$stateemailpairs = array();
	wp_reset_query();
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


			if(!$res['wpsl_email'][0])
			{
			$stateemailpairs[$res['wpsl_state'][0]]  = get_option('admin_email');
			}
			else
			{
			$stateemailpairs[$res['wpsl_state'][0]] = $res['wpsl_email'][0];
			}
		
		
		
		}
		wp_reset_query();
		
	}
    
   $html.=$stateemailpairs[$stateName];
     if($html==""){
     	$html.=get_option('admin_email');
     }
   echo '';
   //echo $html;
   die;
}
add_action('wp_ajax_email_address_state', 'email_address_state');
add_action('wp_ajax_nopriv_email_address_state', 'email_address_state');
add_action( 'wp_enqueue_scripts', 'email_address_state_scripts' );
function email_address_state_scripts()
{
	wp_register_script('email_address-state-autocomplete', get_template_directory_uri(). '/js/email.address.autocomplete.js', '',true);
	wp_enqueue_script('email_address-state-autocomplete');
	wp_localize_script( 'email_address-state-autocomplete', 'wp_email_address_state_autocomplete', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
