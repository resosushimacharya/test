<?php function email_address(){

$storeName = sanitize_text_field($_POST['store']);

wp_reset_query();

$args = array(
				'post_type' =>'wpsl_stores',
				 'posts_per_page'=>'-1'
				);
$loop = new WP_Query($args);
$html = '';
if($loop->have_posts()){
	while($loop->have_posts()){
		$loop->the_post();
		if(strcasecmp(get_the_title(),$storeName)==0){
		/*$res = get_post_meta($post->ID ,'w',true);*/	
	   $res = get_post_meta($loop->post->ID);
	   
	   do_action($res);
	   $html .= $res['wpsl_email'][0];
	   break;
	}
	   

	}

}
echo $html;
die();
}
add_action('wp_ajax_email_address', 'email_address');
add_action('wp_ajax_nopriv_email_address', 'email_address');


add_action( 'wp_enqueue_scripts', 'email_address_scripts' );
function email_address_scripts(){
	/*wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js', '',true);
		wp_enqueue_script('jquery');*/
	wp_register_script('email_address-autocomplete', get_template_directory_uri(). '/js/email.address.autocomplete.js', '',true);

wp_enqueue_script('email_address-autocomplete');
wp_localize_script( 'email_address-autocomplete', 'wp_email_address_autocomplete', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}