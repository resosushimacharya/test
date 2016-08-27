<?php 
$url = site_url();
$url =explode('/',$url);

if(strcasecmp($url[2],'localhost')==0){
  $locsermapID = '1770';
}
else{
  $locsermapID ='26771'; }


 ?><?php 
global $wpsl_settings, $wpsl;
global $post;
$categoryName ='';
$categoryCount = '';
$categoryDisdplay ='';
$cat = get_queried_object();

if($cat->taxonomy){
    
    $categoryName = $cat->name;
    $categoryCount = $cat->count; 
    if($categoryCount>1){
        $categoryStore = 'STORES';
    }
    else{
        $categoryStore = 'STORE';
    }
   $categoryDisdplay ='<div class="cc-store-cat-page-heading">SHOWING '.$cat->count.' '.$categoryStore.'  IN '.$categoryName.' </div>' ;
}

$output         = $this->get_custom_css(); 
$autoload_class = ( !$wpsl_settings['autoload'] ) ? 'class="wpsl-not-loaded"' : '';

$output .= '<div id="wpsl-wrap" class="wpsl-store-below store-finder-page-form">' . "\r\n";
$output .= "\t" . '<div class="wpsl-search wpsl-clearfix ' . $this->get_css_classes() . '">' . "\r\n";
$output .= "\t\t" . '<div id="wpsl-search-wrap"  class="store-finder-form-cntr">' . "\r\n";
$output .= "\t\t\t" . '<form autocomplete="off" method="post" class="clearfix">' . "\r\n";
$output .= "\t\t\t" . '<div class="wpsl-input">' . "\r\n";


$output .= "\t\t\t\t" .'<input type="hidden" name="cc-control-map"  value="cc-control-map" />';
$res = get_queried_object();
$res = get_object_vars($res);

if(isset($_POST["wpsl-search-input"])){
$output .= "\t\t\t\t" . '<input id="wpsl-search-input" type="text" value="" name="wpsl-search-input" placeholder="'.$_POST["wpsl-search-input"] .'" aria-required="true" />' . "\r\n";
}
else if(array_key_exists('taxonomy',$res)){
   $output .= "\t\t\t\t" . '<input id="wpsl-search-input" type="text" value="" name="wpsl-search-input" placeholder="" aria-required="true" />' . "\r\n"; 
}
else{
    $output .= "\t\t\t\t" . '<input id="wpsl-search-input" type="text" value="" name="wpsl-search-input" placeholder="SUBURB OR POSTCODE" aria-required="true" onkeyup="mymapwpsl(event);"/>' . "\r\n";
}
$output .= "\t\t\t" . '</div>' . "\r\n";

if ( $wpsl_settings['radius_dropdown'] || $wpsl_settings['results_dropdown']  ) {
    $output .= "\t\t\t" . '<div class="wpsl-select-wrap">' . "\r\n";

    if ( $wpsl_settings['radius_dropdown'] ) {
        $output .= "\t\t\t\t" . '<div id="wpsl-radius">' . "\r\n";
        $output .= "\t\t\t\t\t" . '<label for="wpsl-radius-dropdown">' . esc_html( $wpsl->i18n->get_translation( 'radius_label', __( 'Search radius', 'wpsl' ) ) ) . '</label>' . "\r\n";
        $output .= "\t\t\t\t\t" . '<select id="wpsl-radius-dropdown" class="wpsl-dropdown" name="wpsl-radius">' . "\r\n";
        $output .= "\t\t\t\t\t\t" . $this->get_dropdown_list( 'search_radius' ) . "\r\n";
        $output .= "\t\t\t\t\t" . '</select>' . "\r\n";
        $output .= "\t\t\t\t" . '</div>' . "\r\n";
    }

    if ( $wpsl_settings['results_dropdown'] ) {
        $output .= "\t\t\t\t" . '<div id="wpsl-results">' . "\r\n";
        $output .= "\t\t\t\t\t" . '<label for="wpsl-results-dropdown">' . esc_html( $wpsl->i18n->get_translation( 'results_label', __( 'Results', 'wpsl' ) ) ) . '</label>' . "\r\n";
        $output .= "\t\t\t\t\t" . '<select id="wpsl-results-dropdown" class="wpsl-dropdown" name="wpsl-results">' . "\r\n";
        $output .= "\t\t\t\t\t\t" . $this->get_dropdown_list( 'max_results' ) . "\r\n";
        $output .= "\t\t\t\t\t" . '</select>' . "\r\n";
        $output .= "\t\t\t\t" . '</div>' . "\r\n";
    }
  
    $output .= "\t\t\t" . '</div>' . "\r\n";
}

if ( $wpsl_settings['category_filter'] ) {
    $output .= $this->create_category_filter();
}
 
$output .= "\t\t\t\t" . '<div class="wpsl-search-btn-wrap check_wpsl">
<input id="wpsl-search-btn" type="submit"  value=""></div>' . "\r\n";

$output .= "\t\t" . '</form> <span> OR </span>' . "\r\n";


$output .="\t\t\t\t" . '<div id="wpsl-auto-locate">' . "\r\n";



    $output .= "\t\t\t\t\t" .'<div class="wpsl-search-btn-wrap">
    <form method="post" name="locform">
    <input type="hidden" id="cc_cuurent_location_name" value="hello" name="cc-cuurent-location-name"/>
    <input type="hidden" name="cc-current-location-store" value="cc-current-location-store"/><input type="button" value="Use Current Location "  onclick="showcurrentlocation();" class="cc-map-control-finder" id="cc_control_map"/>

    </form></div> '. "\r\n"; 

    $output .= "\t\t\t\t" . '</div>' . "\r\n";
$output .= "\t\t" . '</div>' . "\r\n";

$output .= "\t" . '</div>' . "\r\n";
 if($post->ID!=$locsermapID || isset($_POST["cc-current-location-store"]) || isset($_POST["wpsl-search-input"]) || isset($_POST["store-unique-key"]) ){
    if ( $wpsl_settings['reset_map'] ) { 
        $output .= "\t" . '<div class="wpsl-gmap-wrap">' . "\r\n";
        $output .= "\t\t" . '<div id="wpsl-gmap" class="wpsl-gmap-canvas"></div>' . "\r\n";
        $output .= "\t" . '</div>' . "\r\n";
    } else {
        $output .= "\t" . '<div id="wpsl-gmap" class="wpsl-gmap-canvas"></div>' . "\r\n";
    }
}
if($post->ID!=$locsermapID || isset($_POST["cc-current-location-store"]) || isset($_POST["wpsl-search-input"]) || isset($_POST["store-unique-key"]) ){

$output .= "\t" . '<div id="wpsl-result-list">'. "\r\n";
$output .= "\t\t" . '<div id="wpsl-stores" '. $autoload_class .'>' . "\r\n";  
$output .= "\t\t\t" . '<ul class="map-result-not-found test"></ul>' . "\r\n";
$output .= "\t\t" . '</div>' . "\r\n";
$output .= "\t\t" . '<div id="wpsl-direction-details">' . "\r\n";
$output .= "\t\t\t" . '<ul></ul>' . "\r\n";
$output .= "\t\t" . '</div>' . "\r\n";
$output .= "\t" . '</div>' . "\r\n";
}
if ( $wpsl_settings['show_credits'] ) { 
    $output .= "\t" . '<div class="wpsl-provided-by">'. sprintf( __( "Search provided by %sWP Store Locator%s", "wpsl" ), "<a target='_blank' href='https://wpstorelocator.co'>", "</a>" ) .'</div>' . "\r\n";
}

$output .= '</div>' . "\r\n";

return $output;
?>
