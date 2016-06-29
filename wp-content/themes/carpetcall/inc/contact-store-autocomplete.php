<?php 
function contact_store_control(){
$terms = get_terms('wpsl_store_category');
wp_reset_query();
$slug = sanitize_text_field($_POST['state']);
wp_reset_query();
$args = array(
				'post_type' =>'wpsl_stores',
				 'posts_per_page'=>'-1',
				'tax_query' => array(
										array(
												'taxonomy' => 'wpsl_store_category',
												'field'    => 'slug',
												'terms'    => $slug,
											)
										)
				 );
$loop = new WP_Query($args);
$html = "";
if($loop->have_posts()){
	while($loop->have_posts()){
		$loop->the_post();
		$html .=  '<option class="col-md-12" value="'.get_the_title().'">'.
		 get_the_title().'</option>';

	}

}
echo $html;
die();

} 
add_action('wp_ajax_contact_store_control', 'contact_store_control');
add_action('wp_ajax_nopriv_contact_store_control', 'contact_store_control');


add_action( 'wp_enqueue_scripts', 'contact_store_scripts' );
function contact_store_scripts(){
	/*wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js', '',true);
		wp_enqueue_script('jquery');*/
	wp_register_script('contact_store-autocomplete', get_template_directory_uri(). '/js/contact.store.autocomplete.js', '',true);

wp_enqueue_script('contact_store-autocomplete');
wp_localize_script( 'contact_store-autocomplete', 'wp_contact_store_autocomplete', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}