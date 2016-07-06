<?php 
/* quering the store locator data
*/
$slug = 'nsw';
$terms = get_terms('wpsl_store_category');
//do_action('pr', $terms);

wp_reset_query();
 function sortByName($a, $b){
    return strcmp($a->slug,$b->slug);
}

usort($terms, 'sortByName');

/*GET THE state of the store from other page
*/

if(isset($_GET['id'])){
	$contactstoID = $_GET['id'];

    $field = get_post_meta($contactstoID);
    
    $cstate = $field['wpsl_state'][0];
    $ctitle  = get_the_title($contactstoID);

}

foreach($terms as $term){
	$selected="";
	if(isset($_GET['id'])){
	if(strcasecmp($term->slug,$cstate)==0){
		$selected="selected";
	}
}
	echo '<option class="col-md-12" value="'.$term->slug.'" '.$selected.'>'.
		 $term->slug.'</option>';
}
?>