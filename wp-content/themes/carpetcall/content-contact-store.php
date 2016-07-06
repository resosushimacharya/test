<?php 
echo "hello";
/* quering the store locator data
*/


if(isset($_GET['id'])){
	$contactstoID = $_GET['id'];
	$field = get_post_meta($contactstoID);    
    $cstate = $field['wpsl_state'][0];

	$terms = get_terms('wpsl_store_category');
	do_action('pr', $terms);
	wp_reset_query();
	$slug = strtolower( $cstate);
	wp_reset_query();
	$args = array(
					'post_type' =>'wpsl_stores',
					 'posts_per_page'=>'-1',
					'tax_query' => array(
											array(
													'taxonomy' => 'wpsl_store_category',
													'field'    => 'slug',
													'terms'    => $slug,
													'orderby' => 'title',
	                                                'order' => 'ASC'
												)
											),

					 );
	$loop = new WP_Query($args);
	 

	if($loop->have_posts()){
		while($loop->have_posts()){
			$loop->the_post();
			$sel = "";

			if($post->ID==$contactstoID){
				$sel = "selected";

			}
			echo '<option class="col-md-12" value="'.get_the_title().'" '.$sel.'>'.
			 get_the_title().'</option>';

		}

	}
	else
	{
		echo "No Store has been submitted yet";
	}
}

?>
