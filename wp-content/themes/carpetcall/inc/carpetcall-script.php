<?php 
function header_script() {
	
wp_enqueue_style('bootstrap',get_template_directory_uri().'/css/bootstrap.min.css');
wp_enqueue_style('font-awesome',get_template_directory_uri().'/css/font-awesome.min.css');

wp_enqueue_style('slick',get_template_directory_uri().'/css/slick.css');
wp_enqueue_style('myslick',get_template_directory_uri().'/css/slick-theme.css');
wp_enqueue_style('lightbox',get_template_directory_uri().'/css/jquery.lightbox.min.css');
wp_enqueue_style('responsive-tabs',get_template_directory_uri().'/css/responsive-tabs.css');
wp_enqueue_style('tabstyle',get_template_directory_uri().'/css/tabstyle.css');

if(is_home()){
wp_enqueue_style('map-store-style',get_template_directory_uri().'/css/map-store-style.css');}
if(is_page_template('templates/find-a-store.php')){
wp_enqueue_style('main-store-map-style',get_template_directory_uri().'/css/main-store-map-style.css');
}
wp_enqueue_style('main',get_template_directory_uri().'/css/carpetcall-style.css');
wp_enqueue_style('responsive_main',get_template_directory_uri().'/css/responsive.css');
/*wp_enqueue_style('responsive-design',get_template_directory_uri().'/css/responsive-design.css');*/
}
add_action( 'wp_enqueue_scripts', 'header_script' );
	

function carpetcall_scripts() {
	 wp_enqueue_script( 'jquery-min', 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js', array(), false, false);
	 wp_register_script( 'bootstrap-slider-js','https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.1.3/bootstrap-slider.min.js','','',false);
	wp_register_style( 'bootstrap-slider-css','https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.1.3/css/bootstrap-slider.min.css');
	wp_enqueue_script( 'bootstrap-slider-js');
	wp_enqueue_style( 'bootstrap-slider-css');
	if(is_page_template('page-calculator.php' ) || get_post_type()=='product'){
		wp_enqueue_script( 'product-calculator', get_template_directory_uri().'/js/product-calculator.js', array('jquery'), false, false);
	}
wp_enqueue_script( 'jquery-sub', 'https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js', array(), false, false);
wp_enqueue_script( 'modernizer', get_template_directory_uri().'/js/modernizr.custom.79639.js', array(), false, false);



wp_enqueue_script( 'lightbox-script', get_template_directory_uri().'/js/jquery.lightbox.min.js', array(), false, false);
wp_enqueue_script( 'auda', get_template_directory_uri().'/js/slick.js', array(), false, false);
wp_enqueue_script( 'responsiveTabs', get_template_directory_uri().'/js/jquery.responsiveTabs.min.js', array(), false, false);
wp_enqueue_script( 'bootstrap-script', get_template_directory_uri().'/js/bootstrap.min.js', array(), false, true);
wp_enqueue_script( 'validator-script', get_template_directory_uri().'/js/jquery.validate.min.js', array(), false, true);

wp_enqueue_script( 'trouble-script', get_template_directory_uri().'/js/trouble.cc.map.js', array('wpsl-js'), false, false);
wp_enqueue_script( 'my-script', get_template_directory_uri().'/js/script.js', array('jquery'), false, false);

      if(get_post_type()=='product')
      {
	wp_enqueue_script( 'jquery-accordion', get_template_directory_uri().'/js/accordion.product.js', array(), false, false);
}
}

add_action( 'wp_enqueue_scripts', 'carpetcall_scripts' );



    