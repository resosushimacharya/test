<?php 
echo "hello";
/* quering the store locator data
*/
$slug = 'nsw';
$terms = get_terms('wpsl_store_category');
//do_action('pr', $terms);
wp_reset_query();
foreach($terms as $term){
	echo '<option class="col-md-12" value="'.$term->slug.'">'.
		 $term->slug.'</option>';
}
?>