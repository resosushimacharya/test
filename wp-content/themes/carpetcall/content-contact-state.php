<?php 
/* quering the store locator data
*/
$slug = 'nsw';
$terms = get_terms('wpsl_store_category');
do_action('pr', $terms);

wp_reset_query();
 function sortByName($a, $b){
    return strcmp($a->slug,$b->slug);
}

usort($terms, 'sortByName');



foreach($terms as $term){
	echo '<option class="col-md-12" value="'.$term->slug.'">'.
		 $term->slug.'</option>';
}
?>