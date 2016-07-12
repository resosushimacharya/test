<?php 
function header_script() {
	
wp_enqueue_style('bootstrap',get_template_directory_uri().'/css/bootstrap.min.css');
wp_enqueue_style('font-awesome',get_template_directory_uri().'/css/font-awesome.min.css');

wp_enqueue_style('slick',get_template_directory_uri().'/css/slick.css');
wp_enqueue_style('myslick',get_template_directory_uri().'/css/slick-theme.css');
wp_enqueue_style('lightbox',get_template_directory_uri().'/css/jquery.lightbox.min.css');
wp_enqueue_style('responsive-tabs',get_template_directory_uri().'/css/responsive-tabs.css');
wp_enqueue_style('tabstyle',get_template_directory_uri().'/css/tabstyle.css');
wp_enqueue_style('menustyless',get_template_directory_uri().'/css/menustyles.css');
wp_enqueue_style('main',get_template_directory_uri().'/css/carpetcall-style.css');
if(is_home()){
wp_enqueue_style('map-store-style',get_template_directory_uri().'/css/map-store-style.css');}
if(is_page_template('templates/find-a-store.php')){
wp_enqueue_style('main-store-map-style',get_template_directory_uri().'/css/main-store-map-style.css');
}

}
add_action( 'wp_enqueue_scripts', 'header_script' );
	



function carpetcall_scripts() {
	if(is_page_template('page-calculator.php' )){
		wp_enqueue_script( 'product-calculator', get_template_directory_uri().'/js/product-calculator.js', array(), false, false);
	}
 wp_enqueue_script( 'jquery-sub', get_template_directory_uri().'/js/jquery-2.1.4.js', array(), false, false);
wp_enqueue_script( 'modernizer', get_template_directory_uri().'/js/modernizr.custom.79639.js', array(), false, false);

wp_enqueue_script( 'my-script', get_template_directory_uri().'/js/script.js', array(), false, false);
wp_enqueue_script( 'lightbox-script', get_template_directory_uri().'/js/jquery.lightbox.min.js', array(), false, false);
wp_enqueue_script( 'auda', get_template_directory_uri().'/js/slick.js', array(), false, false);
wp_enqueue_script( 'responsiveTabs', get_template_directory_uri().'/js/jquery.responsiveTabs.min.js', array(), false, false);
wp_enqueue_script( 'bootstrap-script', get_template_directory_uri().'/js/bootstrap.min.js', array(), false, true);
wp_enqueue_script( 'validator-script', get_template_directory_uri().'/js/jquery.validate.min.js', array(), false, true);

wp_enqueue_script( 'trouble-script', get_template_directory_uri().'/js/trouble.cc.map.js', array('wpsl-js'), false, false);


if (!session_id()){
	    session_start();
	}
	if(isset($_SESSION['use_curr_loc'])){
		$curr_loc=$_SESSION['use_curr_loc'];
	}else{
		$curr_loc=0;
	}
$autoCurrentLoc=array('curr_loc'=>$curr_loc);

 wp_localize_script( 'trouble-script', 'autoCurrentLoc',$autoCurrentLoc );
	if((strcasecmp(get_post_type(),'product')==0)){
		 wp_enqueue_script( 'jquery-accordion', get_template_directory_uri().'/js/accordion.product.js', array(), false, false);
	}
}

add_action( 'wp_enqueue_scripts', 'carpetcall_scripts' );



    