<?php 
if ( ! is_admin() ) {
    include ABSPATH . 'wp-admin/includes/template.php';
}
/*
/* Function to get the depth of the category to know whether if it's top level or chid category.
*/
function get_category_depth($catid){
	global $wpdb;
	if($catid == '') {
                global $cat;
                $catid = $cat;
            }
            $depth = $wpdb->get_var("SELECT parent FROM $wpdb->term_taxonomy WHERE term_id = '".$catid."'");
            return get_depth($catid, $depth, $i);
	
	}

/*
/* Function to show block with slider in category page and also used for ajax load more
*/
add_action('wp_ajax_show_category_slider_block','show_category_slider_block');
add_action('wp_ajax_nopriv_show_category_slider_block','show_category_slider_block');
function show_category_slider_block($args){
	$defaults = array(
		'cat_id' =>0,
		'offset'=>0,
		'perpage'=>1,
		'sort_by'	=>'price',
		'sort_order'=>'DESC',
		'depth'=>0,
		'child_cat_count' =>1,
		'color'	=>'',
		'size'	=>'',
		'price'	=>'',
	);
$args = wp_parse_args( $args, $defaults);
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		if(isset($_POST['cat_id'])){
			$args['cat_id'] = sanitize_text_field($_POST['cat_id']);
		}
		if(isset($_POST['offset'])){
			$args['offset'] = sanitize_text_field($_POST['offset']);
		}
		if(isset($_POST['perpage'])){
			$args['perpage'] = sanitize_text_field($_POST['perpage']);
		}
		if(isset($_POST['sort_by'])){
			$args['sort_by'] = sanitize_text_field($_POST['sort_by']);
		}
		if(isset($_POST['sort_order'])){
			$args['sort_order'] = sanitize_text_field($_POST['sort_order']);
		}
		if(isset($_POST['depth'])){
			$args['depth'] = sanitize_text_field($_POST['depth']);
		}
		if(isset($_POST['color']) && ($_POST['color'] !='')){
			$args['color'] = explode(',',sanitize_text_field($_POST['color']));
		}
		if(isset($_POST['size'])){
			//$args['size'] = explode(',',sanitize_text_field($_POST['size']));
		}
		if(isset($_POST['price']) && ($_POST['price'] !='')){
			$args['price'] = explode(',',sanitize_text_field($_POST['price']));
		}
		if(isset($_POST['child_cat_count']) && ($_POST['child_cat_count'] !='')){
			$args['child_cat_count'] = sanitize_text_field($_POST['child_cat_count']);
		}
	}
	extract($args);
	global $wp_query;
	$current_cat = get_term( $cat_id, 'product_cat');
	//$term_id_sub =  get_queried_object()->term_id;
	//$term_name = get_queried_object()->name;
	$discats_org = get_terms(array('parent'=>$cat_id,'taxonomy'=>'product_cat'));
	
	
	if($depth == 0 ){
		$discats_temp = array_slice($discats_org, $child_cat_count-1, 1);
		$discats=get_terms(array('parent'=>$discats_temp[0]->term_id,'taxonomy'=>'product_cat'));
		$discats = array_slice($discats,$offset,$perpage);
		if($perpage > count($discats)){
			$offset = $perpage - count($discats);
			$child_cat_count++;
			$discats_temp = array_slice($discats_org, $child_cat_count-1, 1);
			$discats_next = get_terms(array('parent'=>$discats_temp[0]->term_id,'taxonomy'=>'product_cat'));
			$discats_next = array_slice($discats_next,0,$offset);
			foreach($discats_next as $cat_next){
				array_push($discats,$cat_next);
				}
			}else{
				$offset = $perpage+$offset;
				}
		
		
		//$current_cat = $discats_temp[0];
		
		$cats_slice = $discats;//array_slice($discats, $offset, $perpage);
		
		}else{
			$cats_slice = array_slice($discats_org, $offset, $perpage);
		}
	if(empty($cats_slice)){
		$ret['html'] = '';
		$ret['child_cat_count'] = $child_cat_count+1;
		$ret['offset'] = 0;
		//No more products found
		}
	$loopcounter = 0;?> 
    
    
    
    
    
    
    
    
    
	<?php
	do_action('pr',$cats_slice); 
	ob_start();
	foreach($cats_slice as $discat){
		
	?>
	
	<?php 
	$filargs = array(
	'post_type'=>'product',
	'posts_per_page'=>'10',
	'tax_query' => array(
		array(
			'taxonomy' => 'product_cat',
			'field'    => 'term_id',
			'terms'    => $discat->term_id,
			),
		),
	'meta_query' => array(
		'relation' => 'OR'
		),
	);
	
	if($sort_by == 'price'){
		$filargs['meta_key'] = '_sale_price';
	}elseif($sort_by == 'popular'){
		$filargs['meta_key'] = 'total_sales';
		}
	$filargs['orderby'] = 'meta_value_num';
	$filargs['order'] = $sort_order;
	
	$color_meta_query = '';
	$price_range_query = '';
	if($color !='' && !empty($color)){
		$color_arr = array();
		$color_arr_names = array();
		foreach($color as $color_name){
			if(get_field($color_name.'_colours','options')){
				$available_colors = get_field($color_name.'_colours','options');
				if(!empty($available_colors)){
					foreach($available_colors as $color_codes){
						$color_arr[] = $color_codes['colour_code'];
						//$color_arr_names[] = $color_codes['colour_name'];
						}
					}
				}
			}
		$color_meta_query = array(
									 'key' => 'color', 
									 'value' => $color_arr,
									 'compare' => 'IN',
									  );
									  
	}
	if($price !='' && !empty($price)){
		//$price_range_query = array( 'relation' => 'OR' );
		foreach($price as $range){
			$range_arr = explode('-',$range);
			$price_range_query[] = array(
										 'key' => '_sale_price', 
										 'value' => $range_arr,
										 'type'	=>	'NUMERIC',
										 'compare' => 'BETWEEN'
										  );
		}
	}
	if($color_meta_query !=''){
		$filargs['meta_query'][]=$color_meta_query;
		}
	if($price_range_query !=''){
		foreach($price_range_query as $range_query){
			$filargs['meta_query'][]=$range_query;
			}
		
		}
	wp_reset_postdata();
	$pch = 1;
	//do_action('pr',$filargs);
	$filloop = new WP_Query($filargs);
	$hold = 1;
	?>
	<?php 
	if($filloop->post_count > 0){
		$current_cat = get_term_by('id',$discat->parent,'product_cat');
		ob_start()?>
        	<div class="row cc-cat-sub-title-price-cover">
	<div class="col-md-6 cc-cat-sub-title"><h4><?php _e($current_cat->name,'carpetcall')?></h4>
	<?php
	echo '<h3>'.$discat->name.'</h3><br/>';
	?>
	</div>
	

        <?php
		
	if($filloop->have_posts()){
	$slidercounter = 1;
	while($filloop->have_posts()):
	$post = $filloop->the_post();
	
	$feat_image = wp_get_attachment_url( get_post_thumbnail_id($filloop->post->ID) );
	
	if($pch==1){
	$res = get_post_meta($filloop->post->ID ,'_sale_price',true);
	echo '<div class="col-md-6 cc-cat-sub-price">From <span>A$'.$res.'</span></div></div> <div class="row cc-cat-sub-carousal-a">';
	
	$pch++;
	
	}
	if($slidercounter<=5){
	if($slidercounter==1){
	echo '<div class="cat_slider">';
	
	}
	?> <div class="cat_slider_item ">
	<div class="cat_slider_item_image" style="background-image:url(<?php echo $feat_image ;?>)"></div>
	</div>
	<?php 
	if($slidercounter==5){
	echo '</div>';
	}
	$slidercounter++;
	
	}
	endwhile;
	wp_reset_query();
	}

	if($filloop->have_posts()){?>
		<div class=" cc-cat-sub-group-item">
		<?php 
	$slidercounter = 1;
	while($filloop->have_posts()):
	$filloop->the_post();
	$feat_image = wp_get_attachment_url( get_post_thumbnail_id($filloop->post->ID) );
	/*var_dump($filloop->post->ID);*/
	
	
	
	?><div class=" cc-other-term-pro">
	<div class="cc-img-wrapper"><div class="cat-item-group-image" style="background-image:url(<?php echo $feat_image;?>)">
	
	<?php
	
	
	$woo=get_post_meta($filloop->post->ID);
	/*
	echo '<h3>'.$discat->name.'</h3>';
	echo "<h5>FROM A$".$woo['_sale_price'][0].'</h5>';*/
	
	
	?>
	<a href ="<?php the_permalink();?>" class="cc-pro-view">VIEW</a>
	</div>
	</div></div>
	
	
	<?php endwhile;?>
	<?php 
	wp_reset_query(); ?>
		</div>
	<?php }
		?>
        </div>
		<?php }
	
	
	?>
	<?php 
	}
		$html = ob_get_clean();
		$ret['html'] = $html;
		$ret['child_cat_count'] = $child_cat_count;
		$ret['offset'] = $offset;
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		echo json_encode($ret);
		die;
	}else{
		return $ret;
		}
}

/*
/*Function to add the category description text field to rugs category and other top level product categories
*/
add_action('product_cat_edit_form_fields','add_top_lvl_cat_description_field');
function add_top_lvl_cat_description_field($tag){
global $wpdb;
$parent = $wpdb->get_var("SELECT parent FROM $wpdb->term_taxonomy WHERE term_id = '".$tag->term_id."'");
if($parent=='0'){
$cat_top_description =get_term_meta($tag->term_id,'cat_top_description',true) ;
?>	
<tr class="form-field">
<th scope="row" valign="top"><label for="cat_top_description"><?php _e('Cateogry Top Description'); ?></label></th>
<td>
        <textarea rows="10" name="cat_top_description" id="cat_top_description" style="width:60%;"><?php echo $cat_top_description ? $cat_top_description : ''; ?></textarea><br />
        <span class="description"><?php _e('Description that appears below title in top level categories'); ?></span>
    </td>
</tr>
<?php	
}
return $tag;	  
}
/*
/*Function to save the category description text field to rugs category and other top level product categories
*/
add_action( 'edited_product_cat', 'saveCategoryFields', 10, 1 );
function saveCategoryFields($term_id) {
    if ( isset( $_POST['cat_top_description'] ) ) {
		$exist = get_term_meta($term_id,'cat_top_description',true);
		if($exist){
			update_term_meta($term_id, 'cat_top_description', $_POST['cat_top_description'],$exist);
			}else{
				add_term_meta($term_id, 'cat_top_description', $_POST['cat_top_description'], true);
				}
    }
}
