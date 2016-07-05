<?php 
function cc_map_autolocate_func(){
 	if (!session_id()){
	    session_start();
	}
	if(isset($_SESSION['use_curr_loc'])){		
			$_SESSION['use_curr_loc']="1";
	}
	
}
add_action('wp_ajax_cc_map_autolocate_func', 'cc_map_autolocate_func');
add_action('wp_ajax_nopriv_cc_map_autolocate_func', 'cc_map_autolocate_func');
add_action( 'wp_enqueue_scripts', 'map_autolocate' );
function map_autolocate(){
	/*wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js', '',true);
		wp_enqueue_script('jquery');*/
	wp_register_script('cc-map-autolocate', get_template_directory_uri(). '/js/wpsl.autolocate.js', '',true);

wp_enqueue_script('cc-map-autolocate');
wp_localize_script( 'cc-map-autolocate', 'cc_map_autolocate', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}


