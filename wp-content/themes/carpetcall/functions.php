<?php
/**
* @package carpetcall
* @subpackage carpetcall
*/
show_admin_bar(true);

/*
  * register multiple ACF pages
  * Option pages :
    + Labeling
    + Front-Page Sections
    + Miscellaneous
*/
    /*
      * global variable for store listing counter
      * used on file: inc/carpetcall-contact-information.php
    */

//add_filter('wpseo_canonical','__return_false');
function capetcall_custom_canonical_rule() {
	global $post;
	if ( get_post_type( $post->ID ) == 'product' ) {
		$categories = get_the_terms($post->ID, 'product_cat' ); 
		foreach($categories as $category) {
			$args = array(
						'taxonomy' => 'product_cat', 
						'hide_empty'=>true, 
						'parent' => $category->term_id
					);
			$children = get_categories($args);
			if ( count($children) == 0 ) {
			return  get_term_link($category->term_id,"product_cat");
			}
		}
		//return site_url( '/design/' . $post->post_name );
	}else{
		return get_post_meta($post->ID,'_yoast_wpseo_canonical',true);
		}
}
add_filter( 'wpseo_canonical', 'capetcall_custom_canonical_rule' );

	
add_action( 'wp_enqueue_scripts', 'wooocommerce_scripts' );
function wooocommerce_scripts(){
	wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js', '',true);
		wp_enqueue_script('jquery');
		
		wp_register_script( 'bootstrap-slider-js','https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.1.3/bootstrap-slider.min.js',array('jquery'),'',true);
	wp_register_style( 'bootstrap-slider-css','https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.1.3/css/bootstrap-slider.min.css');
	wp_enqueue_script( 'bootstrap-slider-js');
	wp_enqueue_style( 'bootstrap-slider-css');

	wp_register_script('woo-load-autocomplete', get_template_directory_uri(). '/js/woocommerce.load.js', array('jquery'),'',true);

wp_enqueue_script('woo-load-autocomplete');
wp_localize_script( 'woo-load-autocomplete', 'woo_load_autocomplete', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
  include_once TEMPLATEPATH."/inc/recaptchalib.php";
  $url = site_url();
  $url = explode('/',$url);




  include_once TEMPLATEPATH."/inc/carpetcall-cron-import.php";

  include_once TEMPLATEPATH."/function-yamu.php";
  //require_once('function-yamu.php');
  acf_add_options_sub_page('Labeling');
  acf_add_options_sub_page('Front-Page Sections');
  acf_add_options_sub_page('Miscellaneous');
  acf_add_options_sub_page('Enquiry Email Settings');
#update_option('siteurl',"http://localhost/carpetcall");
#update_option('home',"http://localhost/carpetcall");
add_action('pr','inspect_carpetcall',10,1);
function inspect_carpetcall($arg)
{
echo '<pre>';
       print_r($arg);
  echo '</pre>';
}
add_action('init','ses_set');
function ses_set(){
 if (!session_id()){
          session_start();

      }
}


add_action('wp_head','destroy_autoLoc');
function destroy_autoLoc(){
  global $post;
 
  $saveID =1;

  $urls = explode('/',site_url());
  if($urls[2]=="localhost"){
    $saveID = 1770;
  }
  else{
    $saveID = 26771 ;
  }
 
 
  if(isset($_POST["cc-current-location-store"])){
    $_SESSION['testing'] = time(); 
     $_SESSION['cc_loc_name']  = $_POST['cc-cuurent-location-name'];
       
     $_SESSION['use_curr_loc']="1";?>
      <?php

  }
else{
  $_SESSION['use_curr_loc']=0;
}

   add_filter('cc_current_location_filter','cc_current_location_func',10,1);
   function cc_current_location_func($val){
 if(isset($_SESSION['cc_loc_name'])){
  $res = $_SESSION['cc_loc_name'];

    return $res;
  }
  else{
    $res = "";
    return $res;
   }
  }

 
 
$curr_loc=$_SESSION['use_curr_loc'];
$autoCurrentLoc=array('curr_loc'=>$curr_loc,'check'=>'123');

 wp_localize_script( 'trouble-script', 'autoCurrentLoc',$autoCurrentLoc );

}



function check(){
$args = array(
  'supports' => array(
      'title',
      'editor',
      
      
      'thumbnail',
    
      // 'permalink',
'excerpt' ,
    
      'revisions',
    
      'page-attributes',
      'post-formats',
      'tag',
      'category'
      
    ) ,
'taxonomies'          => array(  'post_tag' ),
'hierarchical' => true,
    'public' => true,
    /*'show_ui' => true,
    'show_in_menu' => true,
    'show_in_nav_menus' => true,
    'show_in_admin_bar' => true,
    'menu_position' => 5,
    
    'can_export' => true,
    'has_archive' => true,
    'exclude_from_search' => true,
    'publicly_queryable' => true,
    'capability_type' => 'post',
    'query_var' => true,*/
    'rewrite'            => array( 'slug' => 'find-a-store')
  );

register_post_type('wpsl_stores', $args);
/*flush_rewrite_rules();*/}
//add_action('init','check');
/*add_post_type_support('post', array('page-attributes')) ;*/
function change_post_object_label() {
    global $wp_post_types;
  $labels = &$wp_post_types['wpsl_stores']->labels;
  
   $labels->parent_item_colon = 'parent Page:' ; 
    
    $labels->name = "Store Locator";
    $labels->singular_name = "Store";
    $labels->add_new = "Add New";
    $labels->add_new_item = "Add New Store";
    $labels->edit_item = "Edit Store";
    $labels->new_item = "New Store";
    $labels->view_item = "View Store";
    $labels->search_items = "Search Stores";
    $labels->not_found = "No stores found.";
    $labels->not_found_in_trash = "No stores found in Trash.";
    $labels->parent_item_colon = "parent Store:";
    $labels->all_items = "All Stores";
    $labels->archives= "Store Archives";
    $labels->insert_into_item = "Insert into store";
    $labels->uploaded_to_this_item ="Uploaded to this store";
    $labels->featured_image ="Featured Image";
    $labels->set_featured_image ="Set featured image";
    $labels->remove_featured_image ="Remove featured image";
    $labels->use_featured_image = "Use as featured image";
    $labels->filter_items_list = "Filter stores list";
    $labels->items_list_navigation ="Stores list navigation";
    $labels->items_list ="Stores list";
    $labels->menu_name ="Stores";
    $labels->name_admin_bar ="wpsl_stores";
      $labels->parent_item_colon = "parent Store:";
}
//add_action( 'init', 'change_post_object_label', 999 );



include_once TEMPLATEPATH."/inc/carpetcall-script.php";
remove_filter ('acf_the_content', 'wpautop');
add_theme_support( 'post-thumbnails' );
function register_my_menus() {
  global $wp_taxonomies;
$store_categories = $wp_taxonomies['wpsl_store_category']->labels;
$store_categories->name = 'Store State';
$store_categories->singular_name = 'Store State';
$store_categories->search_items = 'Search Store State';
$store_categories->all_items = 'All Store States';
$store_categories->parent_item = 'Parent Store State';
$store_categories->parent_item_colon = 'Parent Store State';
$store_categories->edit_item = 'Edit Store State';
$store_categories->view_item = 'View State';
$store_categories->update_item = 'Update Store State';
$store_categories->add_new_item = 'Add New Store State';
$store_categories->new_item_name = 'New Store State Name';
$store_categories->not_found = 'No states found.';
$store_categories->no_terms = 'No states';
$store_categories->items_list_navigation = 'States list navigation';
$store_categories->items_list = 'States list';
$store_categories->menu_name = 'Store States';
$store_categories->name_admin_bar = 'Store State';
$store_categories->archives = 'All Store States';
register_nav_menus(
array(
'header-menu' => __( 'Header Menu' ),
'front-menu' => __( 'Front Menu' ),
'footer-menu' => __( 'Footer Menu' ),
'footer-mobile-menu' => __( 'Footer Mobile Menu' )
)
);
}

add_action( 'init', 'register_my_menus' );
add_action( 'init', 'my_add_excerpts_to_pages' );
function my_add_excerpts_to_pages() {
     add_post_type_support( 'page', 'excerpt' );
}
add_filter('pre_get_posts', 'query_post_type');
function query_post_type($query) {
  if(is_category() || is_tag()) {
    $post_type = get_query_var('post_type');
  if($post_type)
      $post_type = $post_type;
  else
      $post_type = array('post','articles','nav_menu_item');
    $query->set('post_type','wpsl_stores');
  return $query;
    }
}
function carpet_search_form( $form ) {
  $serch_tt=get_search_query();
   if(empty($serch_tt)){
    $mysearch="TYPE TO SEARCH";
   }
   else $mysearch=get_search_query();
   $form = '<form role="search" method="get" id="" class="" action="' . home_url( '/' ) . '" >
   <div class="input-group">
    <input type="text" class="form-control" aria-label="Product" placeholder="' . $mysearch. '" name="s" id="s" />
    <span class="input-group-btn">
    <button type="submit" class="btn btn-default cc_search_button" id="searchsubmit" value="" />
      <svg xmlns="http://www.w3.org/2000/svg" width="626" height="626" viewBox="0 0 626 626" fill="#808080"><path d="M234.502 468.998C105.024 469.033-.248 364.54.162 234.145.572 103.867 104.737.123 234.957.16 365.233.194 469.347 105.7 469.03 235.294c-.316 129.3-105.033 233.77-234.528 233.703zM58.722 235.14c.39 97.628 79.406 175.614 175.932 175.53 97.425-.083 176.05-79.147 176.148-175.985.098-96.948-79.577-176.324-176.626-175.965-97.164.36-175.857 79.485-175.455 176.42zm323.766 229.716c33.232-21.7 60.585-48.976 83.233-83.725 2.076 2.764 3.414 5.066 5.23 6.89 45.408 45.505 90.928 90.897 136.274 136.462 14.354 14.424 21.37 31.882 17.53 52.252-4.316 22.89-17.586 38.725-40.127 45.99-22.942 7.392-42.994 1.375-59.6-15.042-47.256-46.715-94.08-93.866-141.07-140.852-.344-.345-.593-.788-1.468-1.972z"/></svg>
    </button>
    </span></div>
    </form>';
 return $form;
}
add_filter( 'get_search_form', 'carpet_search_form' );
include_once TEMPLATEPATH."/inc/carpetcall-custom-type.php";
include_once TEMPLATEPATH."/inc/faqhandler.php";
function pr($x){
  echo '<pre>'.$x.'</pre>';
}
include_once TEMPLATEPATH."/inc/carpetcall-customizer.php";
include_once TEMPLATEPATH."/inc/carpetcall-woocommerce.php";
/*include_once TEMPLATEPATH."/inc/backcsv.php";*/
/* shoping cart section */
function filter_search($query) {
  if( !is_admin() ) { 
    if ($query->is_search) {
    $query->set('post_type', array('product','post'));
    }
    return $query;
  }
}
add_filter('pre_get_posts', 'filter_search');

add_action('init','include_files');
function include_files(){
  include_once TEMPLATEPATH."/inc/carpetcall-walker.php";
  include_once TEMPLATEPATH."/inc/carpetcall-storefinder.php";
  include_once TEMPLATEPATH."/inc/contact-store-autocomplete.php";
  include_once TEMPLATEPATH."/inc/carpetcall-store-details.php";
  include_once TEMPLATEPATH."/inc/carpetcall-contact-information.php";
  include_once TEMPLATEPATH."/inc/carpetcall-map-control.php";
  }



/*
  * filtering WP Store Locator
  * removing fields 'address2' and 'state' from Location
  * removing fields 'email' and 'url' from Additional Information
*/
add_filter( 'wpsl_meta_box_fields', 'custom_meta_box_fields' );
function custom_meta_box_fields( $meta_fields ) {
    // check for compatibility - delete if only exists ; may need to change code on plugin upgrade
    // don't show fields not in use
  if( isset( $meta_fields['Location']['address2'] ))
      unset($meta_fields['Location']['address2']);

    /*if( isset( $meta_fields['Additional Information']['email'] ) ) 
      unset($meta_fields['Additional Information']['email']);*/
      
    if( isset( $meta_fields['Additional Information']['url'] ) ) 
      unset($meta_fields['Additional Information']['url']);  
    return $meta_fields;
}
/*
  * customizing WP Store Locator
  * load custom template
  * remove State column from Store listing
  * convert State category checkboxes to radio
  * on selecting State category , populate State field
*/
// load custom Store Locator template
add_filter( 'wpsl_templates', 'custom_templates' );

function custom_templates( $templates ) {

    /**
     * The 'id' is for internal use and must be unique ( since 2.0 ).
     * The 'name' is used in the template dropdown on the settings page.
     * The 'path' points to the location of the custom template,
     * in this case the folder of your active theme.
     */
    $templates[] = array (
        'id'   => 'custom',
        'name' => 'Custom template',
        'path' => get_stylesheet_directory() . '/' . 'templates/custom-wpsl-template.php',
    );

    return $templates;
}
// remove State column from listing to avoid duplicate entries
function aits_wpsl_columns_filter( $columns ) {
  unset( $columns['state'] );
  return $columns;
}
#add_filter( 'manage_edit-wpsl_stores_columns', 'aits_wpsl_columns_filter', 10, 1 );
/*
  * include customizer file : change category checkboxes to radio
  * code reference : https://goo.gl/ZgIzk8
*/
include_once TEMPLATEPATH . "/inc/carpetcall-tax-radiometabox.php";
include_once  TEMPLATEPATH . "/inc/woocommerce-load.php";
// include script in admin to set State value
add_action( 'admin_enqueue_scripts', 'aits_wpsl_admin_script', 11 );

function aits_wpsl_admin_script() {
    global $post_type;
   
    if( 'wpsl_stores' == $post_type )
    wp_enqueue_script( 'aits-wpsl-admin-script', get_stylesheet_directory_uri() . '/js/admin.js' );}
  
function carpetcall_procare(){
        if(!is_post_type_archive('buying-guides')){
          
   if(get_queried_object()!=null){ 
   
      if((strcasecmp(get_queried_object()->taxonomy,'product_care')==0)){
      wp_enqueue_script( 'jquery-accordion', get_template_directory_uri().'/js/accordion.product.js', array(), false, false);
    }
  }
wp_reset_query();
}
}
add_action( 'wp_enqueue_scripts', 'carpetcall_procare');



add_filter('post_type_link', 'events_permalink_structure', 10, 4);
function events_permalink_structure($post_link, $post, $leavename, $sample)
{
    if ( false !== strpos( $post_link, '%wpsl_store_category%' ) ) {
        $event_type_term = get_the_terms( $post->ID, 'wpsl_store_category' );
        $post_link = str_replace( '%wpsl_store_category%', array_pop( $event_type_term )->slug, $post_link );
    }
    return $post_link;
}

// flush_rewrite_rules( true);
add_rewrite_rule('^find-a-store/([^/]*)/([^/]*)/?','index.php?&wpsl_stores=$matches[2]','top');
add_filter( 'wp_title', 'wpdocs_hack_wp_title_for_home' );
 
/**
 * Customize the title for the home page, if one is not set.
 *
 * @param string $title The original title.
 * @return string The title to use.
 */
function wpdocs_hack_wp_title_for_home( $title )
{
  if ( empty( $title ) && ( is_home() || is_front_page() ) ) {
    $title = get_bloginfo('title'). ' | ' . get_bloginfo( 'description' );
  }
  
  if(strpos($title, 'Store State') !== false){
    $title =   str_replace('Store State', "", $title);
  }
  return $title;
}

//add_action('wp_footer','footer_caller');
  function footer_caller(){
    add_filter( 'wpsl_geolocation_timeout', 'custom_admin_js_settings',999 );
  }
  
function getLatLong($address){
     if(!empty($address)){
       //Formatted address
          $formattedAddr = str_replace(' ','+',$address);
         //Send request and receive json data by address
          $geocodeFromAddr = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false'); 
         $output = json_decode($geocodeFromAddr);
         //Get latitude and longitute from json data

         $data['latitude']  = $output->results[0]->geometry->location->lat; 
         $data['longitude'] = $output->results[0]->geometry->location->lng;
         //Return latitude and longitude of the given address
         if(!empty($data)){
             return $data;
         }else{
              return false;
         }
     }else{
          return false;   
      }
 }
  if(isset($_POST["wpsl-search-input"]) ){
   /* var_dump($_POST );*/
   $latlong = getLatLong($_POST["wpsl-search-input"]);
  
   ?>
    <script> var startLatlng  = "<?php echo $latlong['latitude'].",".$latlong['longitude'] ;?>"</script>
  <?php
  }
   function sortByName($a, $b){
    return strcmp($a->slug,$b->slug);
}

  

  
   
  function wpse27856_set_content_type(){
    return "text/html";
}
add_filter( 'wp_mail_content_type','wpse27856_set_content_type' );
// Enable sortable dates column

add_filter( 'manage_edit-enquiries_columns', 'hide_cpt_columns_so_14257172' );

function hide_cpt_columns_so_14257172( $columns )
{
    // Change categories for your custom taxonomy
    unset($columns['date']);
    unset($columns['tags']);
    return $columns;
}
// to remove the automatic P insertion 
add_action('init','cc_remove_tag');
function cc_remove_tag(){
remove_filter('acf_the_content', 'wpautop');
}



add_filter( 'wpsl_admin_marker_dir', 'custom_admin_marker_dir' );

function custom_admin_marker_dir() {

    $admin_marker_dir = get_stylesheet_directory() . '/images/markers/';
    
    return $admin_marker_dir;
}
define( 'WPSL_MARKER_URI', dirname( get_bloginfo( 'stylesheet_url') ) . '/images/markers/' );


// Add action to hook into the approp
add_filter( 'woocommerce_placeholder_img_src', 'growdev_custom_woocommerce_placeholder', 10 );
/**
 * Function to return new placeholder image URL.
 */
function growdev_custom_woocommerce_placeholder( $image_url ) {
  $image_url = get_template_directory_uri().'/images/placeholder.png';  // change this to the URL to your custom placeholder
  return $image_url;
}
add_filter( 'wpsl_store_data', 'custom_result_sort' );

function custom_result_sort( $store_meta ) {

    
    $custom_sort = array();
    
    foreach ( $store_meta as $key => $row ) {
        $custom_sort[$key] = $row['store'];
    }

    array_multisort( $custom_sort, SORT_ASC, SORT_REGULAR, $store_meta );
    
    return $store_meta;
}