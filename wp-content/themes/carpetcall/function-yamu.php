<?php 
if ( ! is_admin() ) {
    include ABSPATH . 'wp-admin/includes/template.php';
}

/*
* Hook to remove add new product from admin bar menu
*/
function remove_wp_logo( $wp_admin_bar ) {
	$wp_admin_bar->remove_menu( 'new-product' );
}
//add_action( 'admin_bar_menu', 'remove_wp_logo', 999 );

/*
* Function to hide the edit link in products listing page.
*/
function remove_product_row_actions( $actions, $post )
{
  global $current_screen;
    if( $current_screen->post_type != 'product' ) return $actions;
    unset( $actions['edit'] );
   	unset( $actions['inline hide-if-no-js'] );
   // $actions['inline hide-if-no-js'] .= __( 'Quick&nbsp;Edit' );
    return $actions;
}
//add_filter( 'post_row_actions', 'remove_product_row_actions', 10, 2 );


//add_action( 'admin_footer-edit.php', 'wpse65613_remove_a' );
function wpse65613_remove_a() {
	global $current_screen;
if( $current_screen->post_type != 'product' ) return $actions;
	?>
	<script type="text/javascript">
		jQuery('table.wp-list-table a.row-title').contents().unwrap();
	</script>
	<?php
}


/*
* Function to hide/remve the add new product button form product edit screen
*/
function cc_product_remove_add_button( $hook ) {
    $screen = get_current_screen();
    if ( $hook == 'post.php' && $screen->post_type != 'product' ) {
        return;
    }
    echo '<style type="text/css">
    h1 .page-title-action{ display:none; }
    </style>'; 
}
//add_action( 'admin_enqueue_scripts', 'cc_product_remove_add_button' );

/*
*Function to remove the Add new Product Menu from Products Main menu 
*To hide Add New Product buttom form products listing pgae
*/
function cc_disable_add_product() {
// Hide sidebar link
global $submenu;
unset($submenu['edit.php?post_type=product'][10]);
// Hide link on listing page
if (isset($_GET['post_type']) && $_GET['post_type'] == 'product') {
    echo '<style type="text/css">
    h1 .page-title-action{ display:none; }
    </style>';
}
}
//add_action('admin_menu', 'cc_disable_add_product');


/*
* Function to disable links in product category links if depth is 2 or more
*/
add_filter('term_link','testing',10,3);
function testing($link,$term_obj,$taxonomy){
	global $wpdb;
	$catid = $term_obj->term_id;
	$ancestors = get_ancestors( $term_obj->term_id, 'product_cat' );
	$depth = count($ancestors) ;
			
	if($depth >=2){
		$link = '';
		}
	return $link;
	}

/*
* Hook to get the color code from the product title and save that code as color meta data in product's metadata.
*
* Run only once when we need to update the old existing products
*/
add_action('wp_head','set_colour_metadata');
function set_colour_metadata(){
	$args = array( 'post_type' => 'product', 'posts_per_page' => -1,);
	$products = get_posts($args);
	foreach($products as $product){
		$title = explode('.',$product->post_title);
		$colour_code = $title[2];
		update_post_meta($product->ID, 'color', $colour_code); 
		}
	}
/*
* Hook to get the size code from the product title and save that code as size_code meta data in product's metadata.
*
* Run only once when we need to update the old existing products
*/
add_action('wp_head','set_sizes_metadata');
function set_sizes_metadata(){
	$args = array( 'post_type' => 'product', 'posts_per_page' => -1,);
	$products = get_posts($args);
	foreach($products as $product){
		$title = explode('.',$product->post_title);
		$colour_code = $title[3];
		update_post_meta($product->ID, 'size_code', $colour_code); 
		}
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

ob_start();
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
		if(isset($_POST['size']) && ($_POST['size'] !='')){
			$args['size'] = explode(',',sanitize_text_field($_POST['size']));
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
	if(!empty($discats_org)){
	if($depth == 0 ){
		if(count($discats_org) > $child_cat_count){
			
		$discats_temp = array_slice($discats_org, $child_cat_count-1, 1);
		$discats=get_terms(array('parent'=>$discats_temp[0]->term_id,'taxonomy'=>'product_cat'));
		$discats = array_slice($discats,$offset,$perpage);
		if(!empty($discats)){
		if($perpage > count($discats)){
			$offset = min($perpage - count($discats),count($discats));
			$child_cat_count++;
			$discats_temp = array_slice($discats_org, $child_cat_count-1, 1);
			$discats_next = get_terms(array('parent'=>$discats_temp[0]->term_id,'taxonomy'=>'product_cat'));
			$discats_next = array_slice($discats_next,0,$offset);
			if($offset == count($discats)){
				$offset = 0;
				$child_cat_count++;
				}
			foreach($discats_next as $cat_next){
				array_push($discats,$cat_next);
				}
			}else{
				$offset = $perpage+$offset;
				}
		$cats_slice = $discats;
			}else{
				$cats_slice = '';
				}
		//$current_cat = $discats_temp[0];
		
		//array_slice($discats, $offset, $perpage);
		
		
			}else{
				$cats_slice = '';
				}
		
		}else{
			if($child_cat_count == 1){
			$cats_slice = array_slice($discats_org, $offset, $perpage);
			//do_action('pr',$cats_slice);
			$offset = $offset+$perpage;
			}else{
				$cats_slice = '';
				}
		}
		}else{
			$ret['html'] = '';
			$ret['child_cat_count'] = $child_cat_count+1;
			$ret['offset'] = 0;
			}
	if(empty($cats_slice)){
		$ret['html'] = '';
		$ret['child_cat_count'] = $child_cat_count+1;
		$ret['offset'] = 0;
		//No more products found
		}else{
	$loopcounter = 0;
	//do_action('pr',$cats_slice); 
	foreach($cats_slice as $discat){
	?>

<div>
  <?php 
	$filargs = array(
	'post_type'=>'product',
	'posts_per_page'=>-1,
	'post_stauts' =>'publish',
	'tax_query' => array(
		array(
			'taxonomy' => 'product_cat',
			'field'    => 'term_id',
			'terms'    => $discat->term_id,
			),
		),
/*	'meta_query' => array(
		'relation' => 'OR',
		array(
                'key' => '_stock_status',
                'value' => 'instock'
            ),
	),
*/	);

	if($sort_by == 'price'){
		$filargs['meta_key'] = '_sale_price';
	}elseif($sort_by == 'popular'){
		$filargs['meta_key'] = 'total_sales';
		}
	$filargs['orderby'] = 'meta_value_num';
	$filargs['order'] = $sort_order;
	
	$color_meta_query = '';
	$size_meta_query = '';
	$price_range_query = '';
	
	if($color !='' && !empty($color)){
		$color_arr = array();
		$color_arr_names = array();
		foreach($color as $color_name){
			if(get_field($color_name.'_colours','options')){
				$available_colors = get_field($color_name.'_colours','options');
				if(!empty($available_colors)){
					//do_action('pr',$available_colors);
					foreach($available_colors as $color_codes){
						//do_action('pr',$color_codes);
						$color_arr[] = $color_codes['colour_code'];
						$color_arr_names[] = $color_codes['colour_name'];
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
	
	if($size !='' && !empty($size)){
		
		$size_arr = array();
		//$size_arr_names = array();
		foreach($size as $size_name){
		
		//do_action('pr',get_field($size_name,'options'));
		
			if(get_field($size_name,'options')){
				$available_sizes = get_field($size_name,'options');
				
				if(!empty($available_sizes)){
					//do_action('pr',$available_colors);
					foreach($available_sizes as $size_codes){
						
						$size_arr[] = $size_codes['code'];
						//$color_arr_names[] = $color_codes['colour_name'];
						}
					}
				}
			}
		$size_meta_query = array(
									 'key' => 'size_code', 
									 'value' => $size_arr,
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
	if($size_meta_query !=''){
		$filargs['meta_query'][]=$size_meta_query;
		}
	if($price_range_query !=''){
		foreach($price_range_query as $range_query){
			$filargs['meta_query'][]=$range_query;
			}
		
		}

	wp_reset_postdata();
	$pch = 1;
	
	$all_products = new WP_Query($filargs);
	if($all_products->post_count > 0){
		$grp_prods = array();
		while($all_products->have_posts())
		{ 
		 $all_products->the_post();
		if(get_post_meta(get_the_ID(),'_stock_status',true) =='instock'){
			$title = get_the_title();
			$grp_code_arr = explode('.',$title);
			$grp_prods[get_the_ID()] = $grp_code_arr[1];
			}
		}
	wp_reset_postdata();
	$product_ids = array_keys(array_unique($grp_prods));	
	$grp_prod_args = array(
		'post_type'	=>'product',
   		 'post__in' => $product_ids,
		);	
		
	if($sort_by == 'price'){
		$grp_prod_args['meta_key'] = '_sale_price';
	}elseif($sort_by == 'popular'){
		$grp_prod_args['meta_key'] = 'total_sales';
		}
	$grp_prod_args['orderby'] = 'meta_value_num';
	$grp_prod_args['order'] = $sort_order;
	
		
	if($sort_by == 'price'){
		$grp_prod_args['meta_key'] = '_sale_price';
	}elseif($sort_by == 'popular'){
		$grp_prod_args['meta_key'] = 'total_sales';
		}
	$grp_prod_args['orderby'] = 'meta_value_num';
	$grp_prod_args['order'] = $sort_order;
		
			
	$filloop = new WP_Query($grp_prod_args);
		}else{
			$filloop = '';
			}
	$hold = 1;
	?>
  <?php 
	if($filloop !='' && $filloop->post_count > 0){
		$current_cat = get_term_by('id',$discat->parent,'product_cat');
		?>
  <div class="row cc-cat-sub-title-price-cover">
    <div class="col-md-6 cc-cat-sub-title">
      <h4>
        <?php _e($current_cat->name,'carpetcall')?>
      </h4>
      <?php
	echo '<h3>'.$discat->name.'</h3><br/>';
	?>
    </div>
    <?php
		
	if($filloop->have_posts()){
	$slidercounter = 1;
	while($filloop->have_posts()){
	$post = $filloop->the_post();
	
	$feat_image = wp_get_attachment_url( get_post_thumbnail_id($filloop->post->ID) );
	$proGal = get_post_meta($filloop->post->ID, '_product_image_gallery', TRUE );
	$proGalId = explode(',',$proGal);
	$reqProImageId = '';
	foreach($proGalId as $imgid){
		$proImageName = wp_get_attachment_url($imgid);
		if(preg_match("/\_V/i", $proImageName)){
			$feat_image = wp_get_attachment_url($imgid);
			}
		}
	if($feat_image ==''){
		$feat_image = 'http://staging.carpetcall.com.au/wp-content/plugins/woocommerce/assets/images/placeholder.png';
		}
	
	if($pch==1){
	$res = get_post_meta($filloop->post->ID ,'_sale_price',true);
	echo '<div class="col-md-6 cc-cat-sub-price">From <span>A$'.$res.'</span></div></div> <div class="row cc-cat-sub-carousal-a">';
	
	$pch++;
	
	}
	if($slidercounter<=5){
	if($slidercounter==1){
	echo '<div class="cat_slider">';
	
	}
	?>
    <div class="cat_slider_item ">
      <div class="cat_slider_item_image" style="background-image:url(<?php echo $feat_image ;?>)"></div>
    </div>
    <?php 
	if($slidercounter==5 || $slidercounter==$filloop->post_count){
	echo '</div>';
	}
	$slidercounter++;
	
	}
	}
	wp_reset_query();
	}

	if($filloop->have_posts()){?>
    <div class=" cc-cat-sub-group-item">
      <?php 
	$slidercounter = 1;
	while($filloop->have_posts()):
	$filloop->the_post();
	//$feat_image = wp_get_attachment_url( get_post_thumbnail_id($filloop->post->ID) );
	$feat_image = wp_get_attachment_url( get_post_thumbnail_id($filloop->post->ID) );
	$proGal = get_post_meta($filloop->post->ID, '_product_image_gallery', TRUE );
	$proGalId = explode(',',$proGal);
	$reqProImageId = '';
	foreach($proGalId as $imgid){
		$proImageName = wp_get_attachment_url($imgid);
		if(preg_match("/\_V/i", $proImageName)){
			$feat_image = wp_get_attachment_url($imgid);
			}
		}
		
	if($feat_image ==''){
		$feat_image = 'http://staging.carpetcall.com.au/wp-content/plugins/woocommerce/assets/images/placeholder.png';
		}
	/*var_dump($filloop->post->ID);*/
	
	
	
	?>
      <div class=" cc-other-term-pro">
        <div class="cc-img-wrapper">
          <div class="cat-item-group-image" style="background-image:url(<?php echo $feat_image;?>)">
            <?php
	
	
	$woo=get_post_meta($filloop->post->ID);
	/*
	echo '<h3>'.$discat->name.'</h3>';
	echo "<h5>FROM A$".$woo['_sale_price'][0].'</h5>';*/
	
	
	?>
            <a href ="<?php the_permalink();?>" class="cc-pro-view">VIEW</a> </div>
        </div>
      </div>
      <?php endwhile;?>
      <?php 
	wp_reset_query(); ?>
    </div>
    <?php }
		?>
  </div>
  <?php }
	
	
	?>
</div>
<?php 
	}
		$html = ob_get_contents();
		ob_end_clean();
		$ret['html'] = $html;
		$ret['child_cat_count'] = $child_cat_count;
		$ret['offset'] = $offset;
		//do_action('pr',$ret);
	}
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
  <th scope="row" valign="top"><label for="cat_top_description">
      <?php _e('Cateogry Top Description'); ?>
    </label></th>
  <td><textarea rows="10" name="cat_top_description" id="cat_top_description" style="width:60%;"><?php echo $cat_top_description ? $cat_top_description : ''; ?></textarea>
    <br />
    <span class="description">
    <?php _e('Description that appears below title in top level categories'); ?>
    </span></td>
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

add_action('wp_ajax_cc_load_product_ajax','cc_load_product_ajax');
add_action('wp_ajax_nopriv_cc_load_product_ajax','cc_load_product_ajax');
function cc_load_product_ajax(){
	global $post, $product, $woocommerce;
	$url = sanitize_text_field($_POST['posturl']);
	$postid = url_to_postid($url);
	//echo $postid;die;
	$product = $post = get_post($postid);
	//do_action('pr',$product);
	setup_postdata($postid);
	ob_start();
	
	wc_get_template_part( 'content', 'single-rugs-product' );
	$html =ob_get_clean();
	wp_reset_postdata();
	echo json_encode($html);die;
	
	
	}