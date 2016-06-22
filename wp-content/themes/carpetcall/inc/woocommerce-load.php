<?php 
/**
*To load the next category terms
*recieve offset value to control the category term 
*cc_count
*/
function woo_load(){
	
 $cc_count = $_POST['cc_count'];
     $cc_term_id   = '328';
    global $wp_query;
     $counter  = 1;
  

    $descats=get_terms(array('parent'=>$cc_term_id,'taxonomy'=>'product_cat'));

    do_action('pr',$descats);
    foreach($descats as $descat){
    	if($counter>=2){
    		$filargs = array(
						'post_type'=>'product',
						'posts_per_page'=>'10',
						'meta_key'=>'_sale_price',
						'orderby' => 'meta_value_num',
						 'order'     => 'ASC',
						'tax_query' => array(
											array(
												'taxonomy' => 'product_cat',
												'field'    => 'term_id',
												'terms'    => $descat->term_id,
											),
										),
									
					 );
	     	$loop = new WP_Query($filargs);
	    	if($loop->have_posts()){
	    		echo $descat->name;
	     	while($loop->have_posts()){
	     		$loop->the_post();
	     		
	     		}
	     	}

			 else{
			 	echo "sorry no post found";
			}
	    }
	    $counter++;
     	
    } 
     

    
  echo "hello";
die();

} 
// function woo_load(){
// 	add_action('init','woocommerce_load');
// }

add_action('wp_ajax_woo_load', 'woo_load');
add_action('wp_ajax_nopriv_woo_load', 'woo_load');


add_action( 'wp_enqueue_scripts', 'wooocommerce_scripts' );
function wooocommerce_scripts(){
	wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js', '',true);
		wp_enqueue_script('jquery');
	wp_register_script('woo-load-autocomplete', get_template_directory_uri(). '/js/woocommerce.load.js', '',true);

wp_enqueue_script('woo-load-autocomplete');
wp_localize_script( 'woo-load-autocomplete', 'woo_load_autocomplete', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

}