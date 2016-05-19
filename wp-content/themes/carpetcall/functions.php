<?php
/**
* @package carpetcall
* @subpackage carpetcall
*/
//show_admin_bar(false );

update_option('siteurl',"http://localhost/carpetcall");
update_option('home',"http://localhost/carpetcall");

include_once TEMPLATEPATH."/inc/carpetcall-script.php";
//include_once TEMPLATEPATH."/inc/carpetcall-search.php";
add_theme_support( 'post-thumbnails' );
function register_my_menus() {
register_nav_menus(
array(
'header-menu' => __( 'Header Menu' ),
'front-menu' => __( 'Front Menu' ),
'footer-menu' => __( 'Footer Menu' )
)
);
}
add_action( 'init', 'register_my_menus' );
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

/*<form>
                <div class="input-group">
  <input type="text" class="form-control" aria-label="Product" placeholder="TYPE TO SEARCH" >
  <span class="input-group-addon"><i class="fa fa-search fa-2x" aria-hidden="true"></i></span>
</div>
</form>*/

function carpet_search_form( $form ) {
	 if(empty(get_search_query())){
	 	$mysearch="search for";
	 }
	 else $mysearch=get_search_query();

    $form = '<form role="search" method="get" id="" class="" action="' . home_url( '/' ) . '" >
   
    <div class="input-group">
    <input type="text" class="form-control" aria-label="Product" placeholder="' . $mysearch. '" name="s" id="s" />
    <span class="input-group-btn">
    <button type="submit" class="btn btn-default" id="searchsubmit" value="" /><i class="fa fa-search" aria-hidden="true"></i>
    </button>
    </span>

    </div>
    </form>';
 
    return $form;
}
add_filter( 'get_search_form', 'carpet_search_form' );
include_once TEMPLATEPATH."/inc/carpetcall-custom-type.php";

include_once TEMPLATEPATH."/inc/faqhandler.php";
	
function pr($x){
	echo '<pre>'.$x.'</pre>';
}
include_once TEMPLATEPATH."/inc/carpetcall_customizer.php";
include_once TEMPLATEPATH."/inc/carpetcall_woocommerce.php";
/* shoping cart section */
function filter_search($query) {
if ($query->is_search) {
$query->set('post_type', array('backgrounds','product','workflows','visualiser','post'));
};
return $query;
};
add_filter('pre_get_posts', 'filter_search');
add_action('pr','inspect_carpetcall',10,1);
function inspect_carpetcall($arg)
{
echo '<pre>';
       print_r($arg);
	echo '</pre>';
}
include_once TEMPLATEPATH."/inc/carpetcall_walker.php";
include_once TEMPLATEPATH."/inc/carpetcall_storefinder.php";
	