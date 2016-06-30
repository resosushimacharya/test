<?php
/**
* @package carpetcall
* @subpackage carpetcall
*/
//show_admin_bar(false );
/*
  * register multiple ACF pages
  * Option pages :
    + Labeling
    + Front-Page Sections
    + Miscellaneous
*/
  acf_add_options_sub_page('Labeling');
  acf_add_options_sub_page('Front-Page Sections');
  acf_add_options_sub_page('Miscellaneous');
#update_option('siteurl',"http://localhost/carpetcall");
#update_option('home',"http://localhost/carpetcall");
add_action('pr','inspect_carpetcall',10,1);
function inspect_carpetcall($arg)
{
echo '<pre>';
       print_r($arg);
  echo '</pre>';
}
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
'footer-menu' => __( 'Footer Menu' )
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
    <button type="submit" class="btn btn-default" id="searchsubmit" value="" />
  <img src="'.get_template_directory_uri().'/images/magnify.png" alt="icon" width="22" height="22"/> 
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
if ($query->is_search) {
$query->set('post_type', array('backgrounds','product','workflows','visualiser','post'));
}
return $query;
}
add_filter('pre_get_posts', 'filter_search');
include_once TEMPLATEPATH."/inc/carpetcall-walker.php";
include_once TEMPLATEPATH."/inc/carpetcall-storefinder.php";
include_once TEMPLATEPATH."/inc/contact-store-autocomplete.php";
include_once TEMPLATEPATH."/inc/carpetcall-store-details.php";
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
  * remove State column from Store listing
  * convert State category checkboxes to radio
  * on selecting State category , populate State field
*/
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
?>
