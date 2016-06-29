<?php 
echo "hello";
/* quering the store locator data
*/
$terms = get_terms('wpsl_store_category');
do_action('pr', $terms);
wp_reset_query();
$slug = 'nsw';
wp_reset_query();
$args = array(
				'post_type' =>'wpsl_stores',
				 'posts_per_page'=>'-1',
				/* 'tax_query' => array(
										array(
												'taxonomy' => 'wpsl_store_category',
												'field'    => 'slug',
												'terms'    => $slug,
											)
										)*/
				 );
$loop = new WP_Query($args);
if($loop->have_posts()){
	while($loop->have_posts()){
		$loop->the_post();
		echo '<option class="col-md-12" value="'.get_the_title().'">'.
		 get_the_title().'</option>';

	}

}
else
{
	echo "No Store has been submitted yet";
}

?>
