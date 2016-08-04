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
    require_once('recaptchalib.php');
	require_once('function-yamu.php');
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
if($post){
  $urls = explode('/',site_url());
  if($urls[2]=="localhost"){
    $saveID = 1770;
  }
  else{
    $saveID = 26771 ;
  }

  if($post->ID==$saveID && isset($_POST["cc-current-location-store"])){
    
  
       
     $_SESSION['use_curr_loc']="1";


  }
  else{
 
      $_SESSION['use_curr_loc']="0";
  }

$curr_loc=$_SESSION['use_curr_loc'];
$autoCurrentLoc=array('curr_loc'=>$curr_loc,'check'=>'123');

 wp_localize_script( 'trouble-script', 'autoCurrentLoc',$autoCurrentLoc );
}
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

add_action('wp_footer','footer_caller');
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