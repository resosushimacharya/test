<?php 
if ( ! is_admin() ) {
    include ABSPATH . 'wp-admin/includes/template.php';
}
/*=============Temporary code to show total sales of products starts===============*/
add_filter( 'manage_edit-product_columns', 'cc_sales_count_coloumn',11);
function cc_sales_count_coloumn($columns)
{
   //add columns
    $columns['sales_count'] = __( 'Total Sales','carpetcall');
   return $columns;
}

add_action( 'manage_product_posts_custom_column' , 'cc_show_sales_count', 10, 2 );
function cc_show_sales_count( $column, $post_id )
{
	if($column == 'sales_count'){
		echo get_post_meta($post_id,'total_sales',true);
		}	
	
}

add_filter( 'manage_edit-product_sortable_columns', 'cc_sales_count_sortable' );
function cc_sales_count_sortable( $columns ) {
    $columns['sales_count'] = 'sales_count';
 
    //To make a column 'un-sortable' remove it from the array
    //unset($columns['date']);
 
    return $columns;
}
add_action( 'pre_get_posts', 'cc_custom_orderby_total_sales' );
function cc_custom_orderby_total_sales( $query ) {
    if( ! is_admin() )
        return;
 
    $orderby = $query->get( 'orderby');
 
    if( 'sales_count' == $orderby ) {
        $query->set('meta_key','total_sales');
        $query->set('orderby','meta_value_num');
    }
}
/*=============Temporary code to show total sales of products ends===============*/
add_action('init','cc_create_table_for_sales_record');
function cc_create_table_for_sales_record(){
	global $wpdb;
	$table_name = $wpdb->prefix.'cc_sales_records';
	$charset_collate = $wpdb->get_charset_collate();
	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		sku tinytext NOT NULL,
		sales_count bigint(20) NOT NULL default '0',
		UNIQUE KEY id (id)
	) $charset_collate;";
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}
include_once(get_template_directory().'/inc/order-reports-cron.php');
add_filter( 'woocommerce_return_to_shop_redirect', 'return_to_shop_link' );
function return_to_shop_link() {
	$shop_page = get_page_by_title('Shop our range');
	return get_permalink($shop_page->ID);
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
//add_filter('term_link','return_parent_catlink_if_lastchild',10,3);
function return_parent_catlink_if_lastchild($link,$term_obj,$taxonomy){
	global $wpdb;
	$catid = $term_obj->term_id;
	$ancestors = get_ancestors( $term_obj->term_id, 'product_cat' );
	$depth = count($ancestors) ;
	$last_cat_depth = 2;
	$top_cat = cc_smart_category_top_parent_id($term_obj->term_id,'product_cat');
	if($top_cat){
		$top_cat_obj = get_term_by('id',$top_cat,'product_cat');
		$top_cat_slug = $top_cat_obj->slug;
		if($top_cat_slug == 'rugs'){
			$last_cat_depth = 2;
		}else if($top_cat_slug == 'hard-flooring'){
			$last_cat_depth = 2;
		}else if(($top_cat_slug == 'carpets') || ($top_cat_slug == 'awnings') || ($top_cat_slug == 'shutters') || ($top_cat_slug == 'blinds')){
			$last_cat_depth = 1;
		}
	}
	if($depth >= $last_cat_depth && $term_obj->count > 0){
		$args = array(
		'post_type'             => 'product',
		'post_status'           => 'publish',
		'ignore_sticky_posts'   => 1,
		'posts_per_page'        => '1',
		//'orderby'				=>'rand',
		'meta_query'            => array(
			array(
				'key'           => '_visibility',
				'value'         => array('catalog', 'visible'),
				'compare'       => 'IN'
			)
		),
		'tax_query'             => array(
			array(
				'taxonomy'      => 'product_cat',
				'field' => 'term_id', //This is optional, as it defaults to 'term_id'
				'terms'         => $catid,
				'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
			)
		)
	);
	$product = new WP_Query($args);
	if($product->post_count > 0){
		$key_word=$product->post->post_name;
		if(!strpos($link,$key_word)){
			$link.=$key_word;
		}
		//$link = get_permalink($product->post->ID);
		}
	}
	return $link;
	}

/*
* Hook to get the color code from the product title and save that code as color meta data in product's metadata.
*
* Run only once when we need to update the old existing products
*/
//add_action('wp_head','set_colour_metadata');
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
//add_action('wp_head','set_sizes_metadata');
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
function show_category_slider_block($args=array()){
	ob_start();
	$defaults = array(
		'cat_id' =>0,
		'offset'=>0,
		'perpage'=>1,
		'sort_by'	=>'price',
		'sort_order'=>'ASC',
		'depth'=>0,
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
			$args['price'] = sanitize_text_field($_POST['price']);
		}
	}
	extract($args);
	global $wp_query;
	$product_found = 0;
	$current_cat = get_term( $cat_id, 'product_cat');
	if(is_last_cat($cat_id)){
		$cat_arr = array($cat_id);
		}else{
		$cat_arr = generate_catids_array($cat_id,$depth);
		}
	$found_cat = 0;
	
	//$cat_arr_popular = generate_catids_array_popular($cat_id,$depth);
	if(!empty($cat_arr)){
		$cat_slice = array();
		$cat_slice_arr =  array_slice($cat_arr,$offset,$perpage);
		$offset = $offset+$perpage;
		foreach($cat_slice_arr as $catid){
			$cat_slice[] = get_term_by('id',$catid,'product_cat');
		}
		
		if(!empty($cat_slice)){
			foreach($cat_slice as &$discat){
				?>
			<div class="cat-single-products">
			
			<?php 
			$filargs = array(
							'post_type'=>'product',
							'posts_per_page'=>-1,
							'post_stauts' =>'publish',
							'meta_query'=>array(
										array(
											'key'	=>'_stock_status',
											'value'	=>'instock',
										),
									),
							'tax_query' => array(
												array(
													'taxonomy' => 'product_cat',
													'field'    => 'term_id',
													'terms'    => $discat->term_id,
												),
											),
						);
			if($sort_by == 'price'){
				$filargs['meta_key'] = '_price';
			}elseif($sort_by == 'popular'){
				$filargs['meta_key'] = 'total_sales';
			}
			$filargs['orderby'] = 'meta_value_num';
			$filargs['order'] = $sort_order;
			$color_meta_query = '';
			$size_meta_query = '';
			if($color !='' && !empty($color)){
				$color_arr = array();
				$color_arr_names = array();
				foreach($color as $color_name){
					if(get_field($color_name.'_colours','options')){
						$available_colors = get_field($color_name.'_colours','options');
						if(!empty($available_colors)){
							foreach($available_colors as $color_codes){
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
			//do_action('pr',$color_arr);
			if($size !='' && !empty($size)){
				$size_arr = array();
				foreach($size as $size_name){
					if(get_field($size_name,'options')){
						$available_sizes = get_field($size_name,'options');
						if(!empty($available_sizes)){
							foreach($available_sizes as $size_codes){
								$size_arr[] = $size_codes['code'];
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
			if($price !='' ){
				$range_arr = explode(',',$price);
				$filargs['meta_query'][] = array(
												'key' => '_price', 
												'value' => $range_arr,
												'type'	=>	'NUMERIC',
												'compare' => 'BETWEEN'
											);
			}
			if($color_meta_query !=''){
				$filargs['meta_query'][]=$color_meta_query;
			}
			if($size_meta_query !=''){
				$filargs['meta_query'][]=$size_meta_query;
			}
			wp_reset_postdata();
			$pch = 1;
			
			$all_products = array();
			$grp_prods = array();
			$all_products = get_posts($filargs);
			$product_found += count($all_products);
			if(count($all_products) > 0 && !empty($all_products)){
				//do_action('pr',$all_products);
				foreach ($all_products as $product)
				{ 
				$_product = new WC_Product($product->ID);
					if($_product->is_in_stock()){
						$title = $product->post_title;
						$grp_code_arr = explode('.',$title);
						$grp_code_unique = $grp_code_arr[1].'.'.$grp_code_arr[2];
						$grp_prods[$product->ID] = $grp_code_unique;
					}else{
						$product_found--;
						}
				}
				
				wp_reset_postdata();
				$product_ids = array();
				$filloop = '';
				if(!empty($grp_prods)){
					$product_ids = array_keys(array_unique($grp_prods));
				}
				if(!empty($product_ids)){
					$found_cat ++;
					$grp_prod_args = array(
										'post_type'	=>'product',
										'post_status'	=>'publish',
										'posts_per_page'	=>-1,
										'post__in' => $product_ids,
									);	
				if($sort_by == 'price'){
					$grp_prod_args['meta_key'] = '_price';
				}elseif($sort_by == 'popular'){
					$grp_prod_args['meta_key'] = 'total_sales';
				}
				$grp_prod_args['orderby'] = 'meta_value_num';
				$grp_prod_args['order'] = $sort_order;
				$filloop = new WP_Query($grp_prod_args);
			}else{
				$filloop = '';
				$offset++;
				}
			}else{
					$offset++;
					if($offset < count($cat_arr) && $found_cats < $perpage ){
						$next_cat = array_slice($cat_arr,$offset,1);
						$next_cat =  get_term_by('id',$next_cat[0],'product_cat');
						$cat_slice[] = $next_cat;
					}else{
							$filloop = '';
					}
			}
			$hold = 1;
			if($filloop !='' && $filloop->post_count > 0 && count($all_products) > 0){
				$banner_prods = array();
				$slider_prods = array();
				$first_prod_id = $filloop->post->ID;
				$current_cat = get_term_by('id',$discat->parent,'product_cat');
				?>
				<div class="row cc-cat-sub-title-price-cover">
					<div class="col-md-6 cc-cat-sub-title">
					<h4><?php _e($current_cat->name,'carpetcall')?></h4>
					<?php echo '<h3>'.$discat->name.'</h3><br/>';?>
				</div>
                <?php $res = get_post_meta($first_prod_id,'_sale_price',true);?>
                	<div class="col-md-6 cc-cat-sub-price">From <span>$<?php echo round($res)?></span></div>
                </div> 
                <div class="row cc-cat-sub-carousal-a">
                	<div class="cat_slider">
					<?php
                    while($filloop->have_posts()){
                        $post = $filloop->the_post();
                        $banner_image = cc_get_banner_img(get_the_ID());
                        if($banner_image){
                            $banner_prods[get_the_ID()] = $banner_image;
                        }
                        $slider_prods[get_the_ID()] = cc_custom_get_feat_img(get_the_ID(),'large');
                    }?>
                    <?php if(!empty($banner_prods)){
                        foreach($banner_prods as $postid=>$feat_image){
							//unset($slider_prods[$postid()]);
							?>
                            <a href="<?php echo get_permalink($postid);?>">
                                <div class="cat_slider_item ">
                                <div class="cat_slider_item_image" style="background-image:url(<?php echo $feat_image;?>)"></div>
                                </div>
                                </a>
                            <?php }
                        }else{
                            $slider_prods_five = array_slice($slider_prods,0,5,true);
                            foreach($slider_prods_five as $postid=>$feat_image){?>
                                <a href="<?php echo get_permalink($postid);?>">
                                <div class="cat_slider_item ">
                                <div class="cat_slider_item_image" style="background-image:url(<?php echo $feat_image;?>)"></div>
                                </div>
                                </a>
                                <?php }
                            ?>
                            
                        <?php }?>
                    </div>
                
                 <div class=" cc-cat-sub-group-item">
                 	<?php foreach($slider_prods as $postid=>$imgurl){
						$feat_image  = cc_custom_get_feat_img($postid,'small','V');?>
						<div class=" cc-other-term-pro">
                        <div class="cc-img-wrapper">
                            <div class="cat-item-group-image" style="background-image:url(<?php echo $feat_image;?>)">
                                <a href ="<?php echo get_permalink($postid);?>" class="cc-pro-view">VIEW</a> 
                            </div>
                        </div>
                    </div>
					<?php }?>
                 </div>   
			</div>
			<?php }
			?>
			</div>
			<?php 
			}		
		}else{
		$html = '';
		$offset = 0;
		$product_found = 0;
		}
	}
	$html = ob_get_contents();
	ob_end_clean();
	$ret['html'] = $html;
	$ret['offset'] = $offset;
	$ret['found_prod'] = $product_found;
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	echo json_encode($ret);
	die;
	}else{
	return $ret;
	}
}

add_action('wp_ajax_loadmore_hf','loadmore_hf');
add_action('wp_ajax_nopriv_loadmore_hf','loadmore_hf');
function loadmore_hf($args){
	ob_start();
	$defaults = array(
		'cat_id' =>0,
		'offset'=>0,
		'perpage'=>-1,
		'sort_by'	=>'price',
		'sort_order'=>'ASC',
		'depth'=>0,
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
		if(isset($_POST['price']) && ($_POST['price'] !='')){
		$args['price'] = sanitize_text_field($_POST['price']);
		}
	}
	extract($args);
	global $wp_query;
	$found_count = 0;
	$found_cat = 0;
	$current_cat = get_term( $cat_id, 'product_cat');
	if(is_last_cat($cat_id)){
		$cat_arr = array($cat_id);
		}else{
		$cat_arr = generate_catids_array($cat_id,$depth);
		}
		
	
	//$cat_arr = generate_catids_array($cat_id,$depth);
	if(!empty($cat_arr)){
		$cat_slice = array();
		$cat_slice_arr =  array_slice($cat_arr,$offset,$perpage);
		$offset = $offset+$perpage;
		foreach($cat_slice_arr as $catid){
			$cat_slice[] = get_term_by('id',$catid,'product_cat');
		}
		if(!empty($cat_slice)){
			foreach($cat_slice as &$discat){
				?>
				<div class="cat-single-products">
				<?php 
				$filargs = array(
					'post_type'=>'product',
					'posts_per_page'=>-1,
					'post_stauts' =>'publish',
					'meta_query'=>array(
										array(
											'key'	=>'_stock_status',
											'value'	=>'instock',
										),
									),
					'tax_query' => array(
										array(
											'taxonomy' => 'product_cat',
											'field'    => 'term_id',
											'terms'    => $discat->term_id,
										),
									),
				);
				if($sort_by == 'price'){
					$filargs['meta_key'] = '_regular_price';
				}elseif($sort_by == 'popular'){
					$filargs['meta_key'] = 'total_sales';
				}
				$filargs['orderby'] = 'meta_value_num';
				$filargs['order'] = $sort_order;
				if($price !='' ){
					$range_arr = explode(',',$price);
					$filargs['meta_query'][] = array(
													'key' => '_regular_price', 
													'value' => $range_arr,
													'type'	=>	'NUMERIC',
													'compare' => 'BETWEEN'
												);
				}
				wp_reset_postdata();
				$pch = 1;
				$filloop = get_posts($filargs);
				$banner_prods = array();
				$slider_prods = array();
				foreach($filloop as $key=>$post){
					$_product = new WC_Product($post->ID);
					if(!$_product->is_in_stock()){
						unset($filloop[$key]);
						}else{
						 $banner_image = cc_get_banner_img($post->ID);
                        if($banner_image){
                            $banner_prods[$post->ID] = $banner_image;
                        }
                        $slider_prods[$post->ID] = cc_custom_get_feat_img($post->ID,'large');	
							}
					}
				if(count($filloop) == 0){
					$offset++;
					if($offset < count($cat_arr)){
						$next_cat = array_slice($cat_arr,$offset,1);
						$next_cat =  get_term_by('id',$next_cat[0],'product_cat');
						$cat_slice[] = $next_cat;
						}else{
							$filloop = '';
						}
				}
				?>
				<?php 
				reset($filloop);
				if($filloop !='' && count($filloop) > 0){
					$found_count += count($filloop);
					$current_cat = get_term_by('id',$discat->parent,'product_cat');
					$first_prod_id = $filloop[0]->ID;
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
                    
                    <?php $res = get_post_meta($first_prod_id,'_regular_price',true);?>
                	<div class="col-md-6 cc-cat-sub-price">From <span>$<?php echo round($res)?></span></div>
                </div>
               		<div class="row cc-cat-sub-carousal-a">
                	<div class="cat_slider">
                    <?php if(!empty($banner_prods)){
                        foreach($banner_prods as $postid=>$feat_image){
							//unset($slider_prods[$postid()]);
							?>
                            <a href="<?php echo get_permalink($postid);?>">
                                <div class="cat_slider_item ">
                                <div class="cat_slider_item_image" style="background-image:url(<?php echo $feat_image;?>)"></div>
                                </div>
                                </a>
                            <?php }
                        }else{
                            $slider_prods_five = array_slice($slider_prods,0,5,true);
                            foreach($slider_prods_five as $postid=>$feat_image){?>
                                <a href="<?php echo get_permalink($postid);?>">
                                <div class="cat_slider_item ">
                                <div class="cat_slider_item_image" style="background-image:url(<?php echo $feat_image;?>)"></div>
                                </div>
                                </a>
                                <?php }
                            ?>
                            
                        <?php }?>
                    </div>
                
                 <div class=" cc-cat-sub-group-item">
                 	<?php foreach($slider_prods as $postid=>$imgurl){
						$feat_image  = cc_custom_get_feat_img($postid,'small','V');?>
						<div class=" cc-other-term-pro">
                        <div class="cc-img-wrapper">
                            <div class="cat-item-group-image" style="background-image:url(<?php echo $feat_image;?>)">
                                <a href ="<?php echo get_permalink($postid);?>" class="cc-pro-view">VIEW</a> 
                            </div>
                        </div>
                    </div>
					<?php }?>
                 </div>   
			</div>
                
                
					<?php
					/*
					if(!empty($filloop)){
						$slidercounter = 1;
						foreach($filloop as $post){
						$_product = new WC_Product($post->ID);
						if($_product->is_in_stock()){
						$feat_image = cc_custom_get_feat_img($post->ID,'large');
						
							if($pch==1){
								$res = get_post_meta($post->ID ,'_regular_price',true);
								echo '<div class="col-md-6 cc-cat-sub-price">From <span>$'.round($res).'</span></div></div> <div class="row cc-cat-sub-carousal-a">';
								$pch++;
							}
							if($slidercounter<=5){
								if($slidercounter==1){
									echo '<div class="cat_slider">';
								}
								?><a href="<?php echo get_permalink($post->ID);?>">
								<div class="cat_slider_item ">
								<div class="cat_slider_item_image" style="background-image:url(<?php echo $feat_image ;?>)"></div>
								</div></a>
								<?php 
								if($slidercounter==5 || $slidercounter==count($filloop)){
									echo '</div>';
								}
								$slidercounter++;
							}
						}
						}
						wp_reset_query();
					}
					if(!empty($filloop)){?>
                        <div class=" cc-cat-sub-group-item">
                        <?php 
                        $slidercounter = 1;
                        foreach($filloop as $post){
						$_product = new WC_Product($post->ID);
						if($_product->is_in_stock()){
						$feat_image = cc_custom_get_feat_img($post->ID,'small','V');
						
							?>
							<div class=" cc-other-term-pro">
							<div class="cc-img-wrapper">
							<div class="cat-item-group-image" style="background-image:url(<?php echo $feat_image;?>)">
							<a href ="<?php echo get_permalink($post->ID);?>" class="cc-pro-view">VIEW</a> </div>
							</div>
							</div>
                        <?php 
						}
					}
                        wp_reset_query(); ?>
                        </div>
					<?php }
					*/
					?>
				<!--	</div> -->
				<?php }
				?>
				</div>
			<?php 
			}
		}else{
			$html = '';
			$offset = 0;
			$found_count = 0;
		}
	}
	$html = ob_get_contents();
	ob_end_clean();
	$ret['html'] = $html;
	$ret['offset'] = $offset;
	$ret['found_prod'] = $found_count;
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		echo json_encode($ret);
		die;
	}else{
		return $ret;
	}
}

function load_more_carpet_blinds($args){
	ob_start();
	$defaults = array(
		'cat_id' =>0,
		'depth'=>0,
	);
	$args = wp_parse_args( $args, $defaults);
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		if(isset($_POST['cat_id'])){
		$args['cat_id'] = sanitize_text_field($_POST['cat_id']);
		}
	}
	extract($args);
	global $wp_query;
	
	$current_cat = get_term( $cat_id, 'product_cat');
	if(is_last_cat($cat_id)){
		$cat_arr = array($cat_id);
		}else{
		$cat_arr = generate_catids_array($cat_id,$depth);
		}
		
		
	//$cat_arr = generate_catids_array($cat_id,1);
	$cat_slice = array();
	if(!empty($cat_arr)){
		foreach($cat_arr as $catid){
			$cat_slice[] = get_term_by('id',$catid,'product_cat');
		}
		if(!empty($cat_slice)){
			foreach($cat_slice as &$discat){
				?>
				<div class="cat-single-products">
				<?php 
				$filargs = array(
					'post_type'=>'product',
					'posts_per_page'=>-1,
					'post_stauts' =>'publish',
					'meta_query'=>array(
										array(
											'key'	=>'_stock_status',
											'value'	=>'instock',
										),
									),
					'tax_query' => array(
										array(
											'taxonomy' => 'product_cat',
											'field'    => 'term_id',
											'terms'    => $discat->term_id,
										),
									),
				);

				wp_reset_postdata();
				$pch = 1;
				$filloop = get_posts($filargs);
				if(count($filloop) == 0){
					$filloop = '';
					}
				?>
				<?php 
				if($filloop !='' && count($filloop) > 0){
					$current_cat = get_term_by('id',$discat->parent,'product_cat');
					?>
					<div class="row cc-cat-sub-title-price-cover">
                        <div class="col-md-6 cc-cat-sub-title">
                        	<h3><?php echo $discat->name?></h3>
                        </div>
                    </div>
                    <div class="row cc-cat-sub-carousal-a">
					<?php
					
					if(!empty($filloop)){
						foreach($filloop as $post){
							$_product = new WC_Product($post->ID);
							if($_product->is_in_stock()){
							$product = new WC_Product($post->ID);
							$attachment_ids = $product->get_gallery_attachment_ids();
					//do_action('pr',$attachment_ids);
							foreach( $attachment_ids as $attachment_id ) 
							{
								$image_link = wp_get_attachment_url( $attachment_id );
								$feat_image_obj = wp_get_attachment_image_src($attachment_id,'full');
								$feat_image = $feat_image_obj[0];
								break;
								?>
							
							<?php
							}
						//$feat_image = cc_custom_get_feat_img($post->ID,'large');
							?>
                            <div class="carpets_top_img">
                                         <a href="<?php echo get_permalink($post->ID);?>">
                                            <div class="cat_slider_items">
                                                <div class="cat_slider_item_image" style="background-image:url(<?php echo $feat_image ;?>)"></div>
                                            </div>
                                        </a>
                                    </div>
							<?php break;
						}
					}
						wp_reset_query();
					}
					if(!empty($filloop)){?>
                     <div class="cc-cat-sub-group-item">
						<?php 
                        $slidercounter = 1;
                        foreach($filloop as $post){
						$_product = new WC_Product($post->ID);
						if($_product->is_in_stock()){	
							$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID),'thumbnail' );
							$proGal = get_post_meta($post->ID, '_product_image_gallery', TRUE );
							$proGalId = explode(',',$proGal);
						$reqProImageId = '';
							foreach($proGalId as $imgid){
								$proImageName = wp_get_attachment_url($imgid);
								$feat_image = wp_get_attachment_image_src($imgid,'thumbnail');
									if($feat_image){
										$feat_image = $feat_image[0];
									}
								if($feat_image =='' || !$feat_image){
									$feat_image = get_template_directory_uri().'/images/placeholder.png';
								}
								?>
								<div class=" cc-other-term-pro">
									<div class="cc-img-wrapper">
										<div class="cat-item-group-image" style="background-image:url(<?php echo $feat_image;?>)">
											<a href ="<?php echo get_permalink($post->ID);?>" class="cc-pro-view">VIEW</a> 
										</div>
									</div>
								</div>
								<?php
							}
						}
					}
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
		}else{
			$html = '';
			$offset = 0;
			$found_count = 0;
		}
	}
	$html = ob_get_contents();
	ob_end_clean();
	$ret['html'] = $html;
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		echo json_encode($ret);
		die;
	}else{
		return $ret;
	}
	
	}	
	

add_action('wp_ajax_cc_custom_search','cc_custom_search');
add_action('wp_ajax_nopriv_cc_custom_search','cc_custom_search');
function cc_custom_search($args){
	ob_start();
	$defaults = array(
		'offset'=>0,
		'sort_by'	=>'price',
		'perpage'=>-1,
		'sort_order'=>'ASC',
		'price'	=>'',
		'shop_range'	=>'',
		's'				=>'',
	);
	$args = wp_parse_args( $args, $defaults);
	
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		if(isset($_POST['offset'])){
		$args['offset'] = sanitize_text_field($_POST['offset']);
		}
		if(isset($_POST['s'])){
		$args['s'] = sanitize_text_field($_POST['s']);
		}
		if(isset($_POST['sort_by'])){
		$args['sort_by'] = sanitize_text_field($_POST['sort_by']);
		}
		if(isset($_POST['sort_order'])){
		$args['sort_order'] = sanitize_text_field($_POST['sort_order']);
		}
		if(isset($_POST['price']) && ($_POST['price'] !='')){
		$args['price'] = sanitize_text_field($_POST['price']);
		}
		if(isset($_POST['perpage'])){
		$args['perpage'] = sanitize_text_field($_POST['perpage']);
		}
		if(isset($_POST['shop_range']) && ($_POST['shop_range'] !='')){
		$args['shop_range'] = sanitize_text_field($_POST['shop_range']);
		}
		  set_query_var('s',$args['s']);
		  set_query_var('search',$args['s']);
		  set_query_var('price',$args['price']);
		  set_query_var('category_filter',$args['shop_range']);
}
	
	extract($args);
	global $wp_query;
	$found_count = 0;
	
	
	
	$meta_query=$meta_query_status=$meta_query_price=array();
	$meta_query_status=array(
						array(
											'key'	=>'_stock_status',
											'value'	=>'instock',
										),
					);
	if($price !='' ){
			$range_arr = explode(',',$price);
			$meta_query_price=array(
										array(
											'key' => '_price', 
											'value' => $range_arr,
											'type'	=>	'NUMERIC',
											'compare' => 'BETWEEN'
										)
			
							);							
				}				
					
	
	$meta_query=array_merge($meta_query_status,$meta_query_price);
	$filargs = array(
					'post_type'=>'product',
					'offset'	=> $offset,
					'post_stauts' =>'publish',
					'posts_per_page'=>-1,//$perpage,
					's'				=>$s,
					'meta_query'=>$meta_query,
					'tax_query'	=>array(
									array(
										'taxonomy' => 'product_cat',
										'terms' => array('accessories'),
										'field' => 'slug',
										'include_children' => true,
										'operator' => 'NOT IN',
									)
								)
								
				);
				
		if($shop_range !='' ){
					$shop_range_arr = explode(',',$shop_range);
					$filargs['tax_query'][] =
													array(
														'taxonomy' => 'product_cat',
														'field' => 'id',
														'terms' => $shop_range_arr,
														'include_children' => true,
														'operator' => 'IN'
													 
												);
												
				}
				
				if($sort_by == 'price'){
					$filargs['meta_key'] = '_regular_price';
				}elseif($sort_by == 'popular'){
					$filargs['meta_key'] = 'total_sales';
				}
				$filargs['orderby'] = 'meta_value_num';
				$filargs['order'] = $sort_order;
				
							
				
				wp_reset_postdata();
				//$prod_count_init = new WP_Query($filargs);
				
				$found_count = 0;//($prod_count_init->post_count  > 0)?$prod_count_init->post_count:0;	
				//$filargs['posts_per_page']=$perpage;
				//$filargs['offset']=$offset;
				
				$filloop = new WP_Query($filargs);
				global $wpdb;
				//do_action('pr',$wpdb->queries);
				//do_action('pr',$filloop->post_count);
				
				
				if($filloop->have_posts()){
					while($filloop->have_posts()){
						$filloop->the_post();
						//do_action('pr',get_post_meta(get_the_ID(),'description_1',true));
						$woo=get_post_meta(get_the_ID());
						$_product = new WC_Product(get_the_ID());
						//do_action('pr',$_product->id);
						
						if($_product->is_in_stock() && !has_term('accessories','product_cat',get_the_ID())){
							//do_action('pr',$_product->stock.' '.$_product->get_formatted_name());
							$found_count++;
							$feat_image = cc_custom_get_feat_img(get_the_ID(),'medium');
							$price = $woo['_price'][0];
							/*if(has_term('rugs','product_cat',get_the_ID())){
								$price=round($woo['_sale_price'][0]);
								}else{
									$price=round($woo['_regular_price'][0]);
									}
									*/
							?>
                            
                            <div class="search_prod_wrapper col-md-4 clearfix">
                            <div class="search_result_inner_wrap">
                                <a href="<?php echo get_permalink(get_the_ID()) ?>">
                                        <div class="img_cntr_home" style="background-image:url('<?php echo $feat_image?>');"></div>
                                        </a>
                                <div class="sublk_prom">
                                        <div class="ptxt">
                                <h3>
                                <a href="<?php echo get_permalink(get_the_ID()) ?>"><?php echo get_the_title()?></a>
                                
                                </h3>
                               
                                <?php
                                $reqTempTerms=get_the_terms(get_the_ID(),'product_cat');
                                
            
                                if(!empty($reqTempTerms)){
                                    foreach($reqTempTerms as $reqTerm){ 
                                        echo '<h4>'.$reqTerm->name.'</h4>';
                                      }
                                }
                                
                                if(!empty($price)){
                                    echo '<h5> $'.$price.'</h5>';
                                }?>
                                
                                </div>
                                <div class="clearfix"></div>
                                       <div class="nowsp nowspp"><a href="<?php echo get_the_permalink(get_the_ID())?>"> SHOP NOW </a></div><div class="clearfix"></div> 
                                  </div>
                            </div>
                      </div>
                      
							<?php }
						
						?>
						
						<?php
                        }
			$html = ob_get_clean();
				}else{
					$ret['html'] = '';
					$ret['offset'] = 0;
					$ret['found_prod'] = 0;
						}
	
	$ret['html'] = $html;
	$ret['offset'] = $offset+$perpage;
	$ret['found_prod'] = $found_count;
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
$cat_return_policy = get_term_meta($tag->term_id,'cat_return_policy',true) ;
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
<tr class="form-field">
  <th scope="row" valign="top"><label for="cat_return_policy">
      <?php _e('Cateogry Returns Policy'); ?>
    </label></th>
  <td>
  <textarea rows="10" name="cat_return_policy" id="cat_return_policy" style="width:60%;"><?php echo $cat_return_policy ? $cat_return_policy : ''; ?></textarea>
  
    <br />
    <span class="description">
    <?php _e('Returns Policy for this Category'); ?>
    </span>
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
		$exist = get_term_meta($term_id,'cat_top_description');
		if($exist){
			update_term_meta($term_id, 'cat_top_description', $_POST['cat_top_description']);
			}else{
				add_term_meta($term_id, 'cat_top_description', $_POST['cat_top_description']);
				}
    }
    if ( isset( $_POST['cat_return_policy'] ) ) {
		$exist = get_term_meta($term_id,'cat_return_policy');
		if($exist){
			update_term_meta($term_id, 'cat_return_policy', $_POST['cat_return_policy']);
			}else{
				add_term_meta($term_id, 'cat_return_policy', $_POST['cat_return_policy']);
				}
    }
}
	
if ( ! function_exists( 'woocommerce_template_single_hardflooring_price' ) ) {

	/**
	 * Output the product title.
	 *
	 * @subpackage	Product
	 */
	function woocommerce_template_single_hardflooring_price() {
		wc_get_template( 'single-product/hardflooring/price.php' );
	}
}
if ( ! function_exists( 'woocommerce_template_single_hardflooring_metainfo' ) ) {

	/**
	 * Output the product title.
	 *
	 * @subpackage	Product
	 */
	function woocommerce_template_single_hardflooring_metainfo() {
		wc_get_template( 'single-product/hardflooring/metainfo.php' );
	}
}
if ( ! function_exists( 'woocommerce_template_single_hardflooring_title' ) ) {

	/**
	 * Output the product title.
	 *
	 * @subpackage	Product
	 */
	function woocommerce_template_single_hardflooring_title() {
		wc_get_template( 'single-product/hardflooring/title.php' );
	}
}


if ( ! function_exists( 'woocommerce_template_single_carpets_blinds_price' ) ) {

	/**
	 * Output the product title.
	 *
	 * @subpackage	Product
	 */
	function woocommerce_template_single_carpets_blinds_price() {
		wc_get_template( 'single-product/carpets_blinds/price.php' );
	}
}
if ( ! function_exists( 'woocommerce_template_single_carpets_blinds_title' ) ) {

	/**
	 * Output the product title.
	 *
	 * @subpackage	Product
	 */
	function woocommerce_template_single_carpets_blinds_title() {
		wc_get_template( 'single-product/carpets_blinds/title.php' );
	}
}



function generate_catids_array($top_lvl_cat,$depth){

	//$transient = 'category_'.$top_lvl_cat.'_transient';
	//if ( false === ( get_transient( $transient ) ) ) {
	
	
	$cat_arr = array();
	$second_lvl_cats = get_terms(array('parent'=>$top_lvl_cat,'taxonomy'=>'product_cat','hide_empty'=>true));
		
		
	$top_cat = cc_smart_category_top_parent_id($top_lvl_cat,'product_cat');
	if($top_cat){
		$top_cat_obj = get_term_by('id',$top_cat,'product_cat');
		$top_cat_slug = $top_cat_obj->slug;
		if($top_cat_slug == 'rugs' || $top_cat_slug == 'hard-flooring'){
			
			
			foreach($second_lvl_cats as $cat_parents){
			if($depth==0){
				$third_lvl_cats = get_terms(array('parent'=>$cat_parents->term_id,'taxonomy'=>'product_cat','hide_empty'=>true));
				foreach($third_lvl_cats as $cat){
					$cat_arr[] = $cat->term_id;
				}
			}else{
				$cat_arr[] = $cat_parents->term_id;
				}
	}
			
			
		}else if(($top_cat_slug == 'carpets') || ($top_cat_slug == 'awnings') || ($top_cat_slug == 'shutters') || ($top_cat_slug == 'blinds')){
			foreach($second_lvl_cats as $cat_parents){
				$cat_arr[] = $cat_parents->term_id;
			}
		}
	}
	
	
		
	return $cat_arr;
	
	//return get_transient($transient);
}

//add_action('edited_product_cat','delete_product_cat_transient');
//add_action('delete_product_cat','delete_product_cat_transient');
function delete_product_cat_transient($term_id,$taxonomy){
	if('product_cat' == $taxonomy){
		$parent  = get_term_by( 'id', $term_id, $taxonomy);
		while ($parent->parent != '0'){
			$transient = 'category_'.$parent->term_id.'_transient';
			delete_transient( $transient ); 
			$term_id = $parent->parent;
			$parent  = get_term_by( 'id', $term_id, $taxonomy);
		}
		$transient = 'category_'.$parent->term_id.'_transient';
		delete_transient( $transient ); 
		}
	}

add_action('cc_checkout_delivery_custom_block','cc_delivery_options_cart');
function cc_delivery_options_cart(){
	global $woocommerce;
	$has_rugs = false;
	$has_hard_flooring = false;
	$items = $woocommerce->cart->get_cart();
	 foreach($items as $item => $values) { ?>
        <?php  
		$_product = $values['data']->post;
		if(has_term('rugs','product_cat',$_product)){
			$has_rugs = true;
			}
		if(has_term('hard-flooring','product_cat',$_product)){
			$has_hard_flooring= true;
			}
		 ?>
  <?php }?>
  <p>Please select the preferred delivery option below. Hard-Flooring proudctus are only availiable through pick-up at our head offices warehouse locations.</p>
	<?php 
	if($has_rugs && $has_hard_flooring){
		wc_get_template( 'delivery/both.php' );
		
	}elseif($has_rugs){
		wc_get_template( 'delivery/rugs.php' );
		
	}elseif($has_hard_flooring){
		wc_get_template( 'delivery/hardflooring.php' );
		
	}
}

add_action('wp_ajax_get_nearby_stores','get_nearby_stores');
add_action('wp_ajax_nopriv_get_nearby_stores','get_nearby_stores');
function get_nearby_stores($args)
{
  global $wpdb;
  $store_type = ''; 
  $lat = $long = ''; 
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	  if(isset($_POST['latitude'])){ 
	  		$lat=$_POST['latitude'];
		}
	   if(isset($_POST['longitude'])){
		   $long=$_POST['longitude'];
		}
	  if(isset($_POST['address'])){
		  $address = str_replace(' ','+',$_POST['address']);
		  }
	  if(isset($_POST['store_type'])){
		  $store_type = $_POST['store_type'];
		  }
	}else{
	  $lat=isset($args['latitude'])?$args['latitude']:'';
	  $long=isset($args['longitude'])?$args['longitude']:'';
	  $address = isset($args['address'])?str_replace(' ','+',$args['address']):'';
	  if(isset($args['store_type'])){
		  $store_type = $args['store_type'];
		  }
	}
if($lat==''|| $long == '' && $address !=''){
		$geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$address.'&sensor=false');
        $output= json_decode($geocode);
		if(!empty($output->results)){
			$lat = $output->results[0]->geometry->location->lat;
			$long = $output->results[0]->geometry->location->lng;
		}else{
			$geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address=Sydney+Australia&sensor=false');
			 $output= json_decode($geocode);
			$lat = $output->results[0]->geometry->location->lat;
			$long = $output->results[0]->geometry->location->lng;
			}
	}
	$a=array();
     $myArrays= array();
  	$backarg=array('post_type'=>'wpsl_stores',
    'posts_per_page'=>'-1'
    );
if($store_type!=''){
	$meta_query = array(
						array(
							'key'=>'store_type',
							'value'=>$store_type,
							)
						);
	$backarg['meta_query'] = $meta_query;
	}
  $loop= new WP_Query($backarg);
  while($loop->have_posts()){
  $loop->the_post();?>
    <?php 
   $loc = get_post_meta(get_the_ID());
    $latitude2=$loc['wpsl_lat'][0];
      $longitude2=$loc['wpsl_lng'][0];
	 
  ?>
        <?php if(!empty($lat)){?>
       <?php 
        $latlongloc = getDistanceBetweenPointsNew($lat, $long, $latitude2, $longitude2,'Km');
        $myArrays[get_the_ID()]=array('address'=>$loc['wpsl_address'][0],'city'=>$loc['wpsl_city'][0],'state'=>$loc['wpsl_state'][0],'zip'=>$loc['wpsl_zip'][0],'distance'=>$latlongloc,'title'=>get_the_title(),'id'=>get_the_ID()); ?>
        <?php }
}
wp_reset_query();
function sortByOrder($a, $b) {
    return $a['distance'] - $b['distance'];
}
usort($myArrays, 'sortByOrder');
$slice = array_slice($myArrays,0,5);
ob_start();
$store_ids = array();
foreach($slice as $store){
			$store_ids[] = $store['id'];
			}
              $args = array(
                'post_type' => 'wpsl_stores',
                'posts_per_page'=>-1,
				'post_status'	=>'publish',
                'post__in' => $store_ids,
              );
              $loop = new WP_Query($args);
              if($loop->have_posts()){
				  $count = 0;
                while($loop->have_posts() && $count < 5){
					$count++;
                  $loop->the_post();
				  $getinfo  = get_post_meta(get_the_ID());
                  $lat = $getinfo['wpsl_lat'];
                  $long = $getinfo['wpsl_lng'];
                  $stoLatLong=array($lat,$long);
                  $add = $getinfo['wpsl_address'][0];
                  $title = get_the_title();
                  $sll[] = array($title,$add,$stoLatLong);
                 
                  $phone = '-';
                  $fax = '-';
                  $zip ='';
                  $state = '';
                  $city = '';
                  $direction = '';
                  $country  = '';
                  if(array_key_exists('wpsl_phone',$getinfo)){
                  $phone = $getinfo['wpsl_phone'][0];
                  $x=  $phone;
                  $x = preg_replace('/\s+/', '', $x);
                  $x = '+61'.$x;  
                  $phone = '<a class="phone" href="tel:'.$x.'">'.$phone.' </a>';
                  }
                  if(array_key_exists('wpsl_fax',$getinfo)){
                  $fax = $getinfo['wpsl_fax'][0];
                  }
                  if(array_key_exists('wpsl_city',$getinfo)){
                  $city  = $getinfo['wpsl_city'][0];
                  }
                  if(array_key_exists('wpsl_state',$getinfo)){
                  $state = $getinfo['wpsl_state'][0];
                  }
                  if(array_key_exists('wpsl_zip',$getinfo)){
                  $zip = $getinfo['wpsl_zip'][0];
                  }  
                 if(array_key_exists('wpsl_address',$getinfo)){
                  $add= $getinfo['wpsl_address'][0];
                 } 
    
				 ?>
                <div class="pickup_location_list">
                <?php
				woocommerce_form_field("pickup_store_id", array(
											'type'              => 'radio',
											'required'			=> true,
											'custom_attributes'	=>array('required'=>'required'),
											'options'           => array( get_the_ID() => '<h3>'.get_the_title().'</h3>
            <p class="address">'.$add .' '. $city.' '.$state.' '.$zip.'</p>' ),
										), '' );
			?>
<?php /*?>       		<input type="radio" name="pickup_store_id" value="<?php echo get_the_ID()?>">
            <h3><?php the_title();?></h3>
            <p class="address"><?php echo  $add .' '. $city.' '.$state.' '.$zip;?></p>
<?php */?>       </div>
                <?php
                }
                 wp_reset_query();
                }

$html = ob_get_clean();

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	echo json_encode($html);die;
	}else{
		return $html;
		}
}

add_action('wp_enqueue_scripts','add_prettyphoto_for_custom_rugs');
function add_prettyphoto_for_custom_rugs(){
	if(is_page('custom-rugs')){
		wp_enqueue_style('prettyphoto-css',plugins_url().'/woocommerce/assets/css/prettyPhoto.css');
		wp_enqueue_script('prettyphoto-js',plugins_url().'/woocommerce/assets/js/prettyPhoto/jquery.prettyPhoto.min.js','','',true);
	}
}

add_action('wp_enqueue_scripts','overwrite_add_to_cart_js');
function overwrite_add_to_cart_js(){
wp_deregister_script('wc-add-to-cart');
wp_register_script('wc-add-to-cart', get_template_directory_uri(). '/js/add-to-cart-custom.js' , array( 'jquery' ), WC_VERSION, TRUE);
wp_enqueue_script('wc-add-to-cart');

}
/*
Function to save the selected store for delivery during checkout in our order meta table
*/
add_action('woocommerce_checkout_update_order_meta','save_delivery_option_cc');
function save_delivery_option_cc($order_id){
	global $woocommerce;
	$shipping_method = '';
	
	if(isset($_POST['payment_method']) && $_POST['payment_method'] == 'securepay'){
		$card_no_first = (substr($_POST['cardno'],0,1));
		switch($card_no_first){
			case '3':
			$card_type = 'Americal Express';
			break;
			case '4':
			$card_type = 'Visa';
			break;
			case '5':
			$card_type = 'MasterCard';
			break;
			default:
			$card_type = '';
			}
		
			update_post_meta($order_id,'securepay_first_name',$_POST['first_name']);
			update_post_meta($order_id,'securepay_last_name',$_POST['last_name']);
			update_post_meta($order_id,'securepay_cctype',$card_type);
			update_post_meta($order_id,'securepay_cardno',$_POST['cardno']);
			update_post_meta($order_id,'securepay_cardcvv',$_POST['cardcvv']);
			update_post_meta($order_id,'securepay_expmonth',$_POST['expmonth']);
			update_post_meta($order_id,'securepay_expyear',$_POST['expyear']);
		}else{
			delete_post_meta($order_id,'securepay_first_name');
			delete_post_meta($order_id,'securepay_last_name');
			delete_post_meta($order_id,'securepay_cardno');
			delete_post_meta($order_id,'securepay_expmonth');
			delete_post_meta($order_id,'securepay_expyear');
			delete_post_meta($order_id,'securepay_cardcvv');
		}
		if(!empty($_POST['cc_shipping_method'])){
			$shipping_method = $_POST['cc_shipping_method'];
		}else if(!empty(WC()->session->post_data['cc_shipping_method'])){
			$shipping_method = WC()->session->post_data['cc_shipping_method'];
		} 


	if(!empty($_POST['shipping_first_name'])){
		$first_name = $_POST['shipping_first_name'];
		}else if(!empty(WC()->session->post_data['shipping_first_name'])){
			$first_name = WC()->session->post_data['shipping_first_name'];
		}
	if(!empty($_POST['billing_first_name'])){
		$first_name = $_POST['billing_first_name'];
		}else if(!empty(WC()->session->post_data['billing_first_name'])){
			$first_name = WC()->session->post_data['billing_first_name'];
		}
	if(!empty($_POST['shipping_last_name'])){
		$last_name = $_POST['shipping_last_name'];
		}else if(!empty(WC()->session->post_data['shipping_last_name'])){
			$last_name = WC()->session->post_data['shipping_last_name'];
		}
	if(!empty($_POST['billing_last_name'])){
		$last_name = $_POST['billing_last_name'];
		}else if(!empty(WC()->session->post_data['billing_last_name'])){
			$last_name = WC()->session->post_data['billing_last_name'];
		}
	//WC()->session->paypal_express_checkout = array();
	//WC()->session->paypal_express_checkout['shipping_details'][0]['last_name'] = $last_name;
	//do_action('pr',WC()->session->paypal_express_checkout['shipping_details']);
	//echo 'one';die;
	$pickup_store_id = '';
		if(!empty($_POST['pickup_store_id'])){
			$pickup_store_id = $_POST['pickup_store_id'];
		}else if(!empty(WC()->session->post_data['pickup_store_id'])){
			$pickup_store_id = WC()->session->post_data['pickup_store_id'];
		} 
		
	$atl = '';
		if(!empty($_POST['atl'])){
			$atl = $_POST['atl'];
		}else if(!empty(WC()->session->post_data['atl'])){
			$atl = WC()->session->post_data['atl'];
		} 

	if($atl=='on'){
		update_post_meta( $order_id, 'atl', 1);
		//cc_notify_selected_store($order_id);
		}else{
			update_post_meta( $order_id, 'atl', 0);
			}
	if($pickup_store_id){
		update_post_meta( $order_id, 'pickup_store_id', $pickup_store_id);
		//cc_notify_selected_store($order_id);
		}
	if($shipping_method){
		if($pickup_store_id){
			$store = get_post($pickup_store_id);
			$store_title = $store->post_title;
			}
		$shipping_arr = array(	'local_delivery'=>'Local Delivery',
								'store_pickup'=>(isset($store_title))?'Pickup From '.$store_title:'Pickup From Head Offices',
								'pickup_n_deliver'=>(isset($store_title))?'Pickup From '.$store_title:'Pickup Hard Flooring and Deliver Rugs'
								);
		update_post_meta( $order_id, 'cc_shipping_method', $shipping_arr[$shipping_method]);
		update_post_meta( $order_id, '_shipping_method',$shipping_arr[$shipping_method]);
		update_post_meta( $order_id, '_shipping_method_title',$shipping_arr[$shipping_method]);
		//cc_notify_selected_store($order_id);
		}
		update_post_meta( $order_id, 'cc_order_date', strtotime("now"));
	}


/*

*Fix to stop paypal express to overwrite the shipping address by the address of cardholder during chekcout

*Save the PayerId in oreder meta during payment via paypal express checkout.

*/
add_action( 'woocommerce_payment_complete', 'cc_save_shipping_address_forcefully', 10, 1 ); 
function cc_save_shipping_address_forcefully($order_id){
	global $woocommerce;
	$payer_id = $_REQUEST['PayerID'];
	update_post_meta($order_id,'payer_id',$payer_id);
	if(!empty($_POST['shipping_first_name'])){
		$first_name = $_POST['shipping_first_name'];
		}else if(!empty(WC()->session->post_data['shipping_first_name'])){
			$first_name = WC()->session->post_data['shipping_first_name'];
		}
	if(!empty($_POST['billing_first_name'])){
		$first_name = $_POST['billing_first_name'];
		}else if(!empty(WC()->session->post_data['billing_first_name'])){
			$first_name = WC()->session->post_data['billing_first_name'];
		}
		
	update_post_meta($order_id,'_shipping_first_name',$first_name);
	
	if(!empty($_POST['shipping_last_name'])){
		$last_name = $_POST['shipping_last_name'];
		}else if(!empty(WC()->session->post_data['shipping_last_name'])){
			$last_name = WC()->session->post_data['shipping_last_name'];
		}
	if(!empty($_POST['billing_last_name'])){
		$last_name = $_POST['billing_last_name'];
		}else if(!empty(WC()->session->post_data['billing_last_name'])){
			$last_name = WC()->session->post_data['billing_last_name'];
		}
	update_post_meta($order_id,'_shipping_last_name',$last_name);
	
	if(!empty($_POST['shipping_company'])){
		$company = $_POST['shipping_company'];
		}else if(!empty(WC()->session->post_data['shipping_company'])){
			$company = WC()->session->post_data['shipping_company'];
		}
	update_post_meta($order_id,'_shipping_company',$company);
	
	if(!empty($_POST['shipping_phone'])){
		$phone = $_POST['shipping_phone'];
		}else if(!empty(WC()->session->post_data['shipping_phone'])){
			$phone = WC()->session->post_data['shipping_phone'];
		}
	update_post_meta($order_id,'_shipping_phone',$phone);
	
	if(!empty($_POST['shipping_address_1'])){
		$address1 = $_POST['shipping_address_1'];
		}else if(!empty(WC()->session->post_data['shipping_address_1'])){
			$address1 = WC()->session->post_data['shipping_address_1'];
		}
	update_post_meta($order_id,'_shipping_address_1',$address1);
	
	if(!empty($_POST['shipping_address_2'])){
		$address2 = $_POST['shipping_address_2'];
		}else if(!empty(WC()->session->post_data['shipping_address_2'])){
			$address2 = WC()->session->post_data['shipping_address_2'];
		}
	update_post_meta($order_id,'_shipping_address_2',$address2);
	
	if(!empty($_POST['shipping_city'])){
		$city = $_POST['shipping_city'];
		}else if(!empty(WC()->session->post_data['shipping_city'])){
			$city = WC()->session->post_data['shipping_city'];
		}
	update_post_meta($order_id,'_shipping_city',$city);
	
	if(!empty($_POST['shipping_country'])){
		$country = $_POST['shipping_country'];
		}else if(!empty(WC()->session->post_data['shipping_country'])){
			$country = WC()->session->post_data['shipping_country'];
		}
	update_post_meta($order_id,'_shipping_country',$country);
	
	if(!empty($_POST['shipping_state'])){
		$state = $_POST['shipping_state'];
		}else if(!empty(WC()->session->post_data['shipping_state'])){
			$state = WC()->session->post_data['shipping_state'];
		}
	update_post_meta($order_id,'_shipping_state',$state);
	}
/*
Function to send the notification email to respective store email address when order is generated
*/
add_action( 'woocommerce_payment_complete', 'cc_notify_selected_store', 10, 1 ); 
function cc_notify_selected_store($order_id){
	global $woocommerce;
	$order = new WC_Order( $order_id );
	ob_start();
wc_get_template( 'emails/email-header.php',array('email_heading'=>'New Order Received'));
wc_get_template( 'order/order-details.php', array('order_id'=>$order_id));
?>
<div class="shipping_info col-md-6">
<h3> Shipping Address </h3>
<?php echo $order->get_formatted_shipping_address();?>
</div>

<?php
wc_get_template( 'emails/email-footer.php');

$selected_store = get_post_meta($order_id,'pickup_store_id',true);
if($selected_store){
	$to = get_post_meta($selected_store,'wpsl_email',true);
	if($to =='' || !$to){
		$to = get_option('admin_email');
		}
	$message = ob_get_clean();
	if($to){
	(wc_mail( $to, 'New Order Received', $message, $headers = "Content-Type: text/htmlrn", $attachments = "" ));
	}
}

//do_action('pr',$message);
}

function cc_custom_proudcts_url( $url, $post, $leavename=false ) {
	$temp_url = $url;
	if ( $post->post_type == 'product' ) {
		if(has_term('carpets','product_cat',$post->ID) ||  has_term('awnings','product_cat',$post->ID) || 
		has_term('blinds','product_cat',$post->ID) || has_term('shutters','product_cat',$post->ID) ||  has_term('rugs','product_cat',$post->ID) ||  has_term('hard-flooring','product_cat',$post->ID)
		){
		$terms = wc_get_product_terms( $post->ID, 'product_cat', array( 'orderby' => 'parent', 'order' => 'DESC' ) ) ;
		//do_action('pr',$terms);
		
		$temp_url = site_url().'/shop-our-range';
		$url_parts = array();
		if($terms){
			foreach($terms as $term){
				$url_parts[]=$term->slug;
				}
		$url_parts = array_reverse($url_parts);
		foreach($url_parts as $part){
			$temp_url.='/'.$part;
			}
		$temp_url.='/'.$post->post_name;
			}
		
		}
		
		
		/*
		if(is_single()){
		$temp_url = site_url().'/shop-our-range';
		$url_parts = array();
		if($terms){
			foreach($terms as $term){
				$url_parts[]=$term->slug;
				}
		$url_parts = array_reverse($url_parts);
		foreach($url_parts as $part){
			$temp_url.='/'.$part;
			}
		$temp_url.='/'.$post->post_name;
			}
		}else{
		if($terms){
			foreach($terms as $term){
				$has_child = get_term_children($term->term_id, 'product_cat');
				if(sizeof($has_child)==0){
					$temp_url = get_term_link($term,'product_cat');
					break;
					}
				}
			}
			}
			
			
			*/
	}
	return $temp_url;
}
/*function cc_custom_proudcts_url( $url, $post, $leavename=false ) {
	if ( $post->post_type == 'product' ) {
		$terms = wc_get_product_terms( $post->ID, 'product_cat', array( 'orderby' => 'parent', 'order' => 'DESC' ) ) ;
		if($terms){
			foreach($terms as $term){
				$has_child = get_term_children($term->term_id, 'product_cat');
				if(sizeof($has_child)==0){
					$url = get_term_link($term,'product_cat');
					break;
					}
				}
			}
	}
	return $url;
}

*/
add_filter( 'post_type_link', 'cc_custom_proudcts_url', 10, 3 );	

add_filter( 'rewrite_rules_array', function( $rules )
{
    $new_rules = array(
	    'shop-our-range/carpets/([^/]*?)/([^/]*?)/?$' => 'index.php?product=$matches[2]',
	    'shop-our-range/shutters/([^/]*?)/([^/]*?)/?$' => 'index.php?product=$matches[2]',
	    'shop-our-range/awnings/([^/]*?)/([^/]*?)/?$' => 'index.php?product=$matches[2]',
	    'shop-our-range/blinds/([^/]*?)/([^/]*?)/?$' => 'index.php?product=$matches[2]',
        'shop-our-range/([^/]*?)/?$' => 'index.php?product_cat=$matches[1]',
		'shop-our-range/([^/]*?)/([^/]*?)?$' => 'index.php?product_cat=$matches[2]',
		'shop-our-range/([^/]*?)/([^/]*?)/([^/]*?)?$' => 'index.php?product_cat=$matches[3]',

		 'shop-our-range/([^/]*?)/page/([0-9]{1,})/?$' => 'index.php?product_cat=$matches[1]&paged=$matches[2]',
		  'shop-our-range/([^/]*?)/([^/]*?)/page/([0-9]{1,})/?$' => 'index.php?product_cat=$matches[2]&paged=$matches[3]',
		  'shop-our-range/([^/]*?)/([^/]*?)/([^/]*?)/page/([0-9]{1,})/?$' => 'index.php?product_cat=$matches[3]&paged=$matches[4]',
		   
		 
		
    );
    return $new_rules + $rules;
} );




add_action( 'woocommerce_add_order_item_meta', 'cc_save_item_sku_order_itemmeta', 10, 3 );
function cc_save_item_sku_order_itemmeta( $item_id, $values, $cart_item_key ) {
		global $wpdb;
        $item_sku  =  get_post_meta( $values[ 'product_id' ], '_sku', true );
        wc_add_order_item_meta( $item_id, 'sku', $item_sku , false );
		
$sales_record_table = $wpdb->prefix.'cc_sales_records';
$exist =  $wpdb->get_row( "SELECT * FROM $wpdb->cc_sales_records WHERE sku =".$item_sku );
if($item_sku){
	if($exist){
	$wpdb->update(
					$wpdb->cc_sales_records,
					array(
						'sales_count'=>$exist->sales_count + 1
					),
					array(
						'sku'=>$item_sku
					),
					array(
					'%d'
					)
				);
	}else{
		$wpdb->insert( 
					$wpdb->prefix.'cc_sales_records', 
					array(
						'id'=>'', 
						'sku' =>$item_sku, 
						'sales_count' => 1 
					), 
					array( 
						'%d',
						'%s', 
						'%d' 
					) 
				);
		
		}
}
}

/*
* Function to reutun the images from the upload folder for the given product and given size
*/
function cc_custom_get_feat_img($post_id,$size='small',$pattern='L'){
	$feat_image = '';
	$pattern = strtoupper($pattern);
	if(has_term('hard-flooring','product_cat',$post_id) || has_term('rugs','product_cat',$post_id)){
							if(has_term('hard-flooring','product_cat',$post_id)){
							$sku = get_post_meta($post_id,'_sku',true);
							
							$image_names = array(
											strtoupper($sku).'_'.$pattern.'jpg',
											strtoupper($sku).'_L.jpg',
											strtoupper($sku).'_V.jpg',
											strtoupper($sku).'_S.jpg',
										);
										
							}
						if(has_term('rugs','product_cat',$post_id)){
							
							$sku = explode('.',get_post_meta($post_id,'_sku',true));
							$image_names = array(
											strtoupper($sku[0].'_'.$sku[1].'_'.$sku[2]).'_'.$pattern.'.jpg',
											strtoupper($sku[0].'_'.$sku[1].'_'.$sku[2]).'_L.jpg',
											strtoupper($sku[0].'_'.$sku[1].'_'.$sku[2]).'_V.jpg',
											strtoupper($sku[0].'_'.$sku[1].'_'.$sku[2]).'_S.jpg',
										);
	
							}
							foreach($image_names as $imgname){
								$img_path =  WP_CONTENT_DIR.'/uploads/images/'.$size.'/'.$imgname;
								if(file_exists($img_path)){
								$feat_image = content_url('uploads/images/'.$size.'/'.$imgname);
								break;
							}
						}
							}
							else{
								if($size == 'small'){
									$size = 'thumbnail';
									}elseif($size=='large'){
										$size = 'full';
										}
								if(has_term('carpets','product_cat',$post_id) ||  has_term('awnings','product_cat',$post->ID) ||  has_term('blinds','product_cat',$post->ID) || has_term('shutters','product_cat',$post->ID) ){
									global $woocommerce;
									$product = new WC_Product($post_id);
									$attachment_ids = $product->get_gallery_attachment_ids();
									//do_action('pr',$attachment_ids);
									if(!empty($attachment_ids)){
										//echo '<div class="test" style="display:none">'.$attachment_ids[0].'</div>';
										//$image_link = wp_get_attachment_url( $attachment_ids[0] );
										$feat_image = wp_get_attachment_image_src($attachment_ids[0],$size);
										}
									
								}else{
								$feat_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size ); 
								}
								if(!$feat_image){
									$feat_image = get_template_directory_uri().'/images/placeholder.png';
									}else{
										$feat_image = $feat_image[0];
										}
								}
								
		if($feat_image == '' || !$feat_image){
			$feat_image = get_template_directory_uri().'/images/placeholder.png';
		}
	return $feat_image;
	}
function cc_get_banner_img($post_id){
	$feat_image = '';
	if(has_term('rugs','product_cat',$post_id)){
		$sku = explode('.',get_post_meta($post_id,'_sku',true));
		$image_name = strtoupper($sku[0].'_'.$sku[1].'_'.$sku[2]).'_LB.jpg';
		$img_path =  WP_CONTENT_DIR.'/uploads/images/banner/'.$image_name;
		if(file_exists($img_path)){
			$feat_image = content_url('uploads/images/banner/'.$image_name);
		}
	}
	else if(has_term('hard-flooring','product_cat',$post_id)){
		$sku = get_post_meta($post_id,'_sku',true);
		$image_name = strtoupper($sku).'_LB.jpg';
		$img_path =  WP_CONTENT_DIR.'/uploads/images/banner/'.$image_name;
		if(file_exists($img_path)){
			$feat_image = content_url('uploads/images/banner/'.$image_name);
		}
	}
	return $feat_image;
}



function is_last_cat($cat_id){
	$current_cat = get_term( $cat_id, 'product_cat');
	$children = get_categories( array ('taxonomy' => 'product_cat', 'hide_empty'=>false, 'parent' => $current_cat->term_id ));
	if ( count($children) == 0 ) {
		return true;
		}else{
			return false;
			}
	}
	
	

/*
/* Filter to change the placeholder and labels for shipping and billing address fields
*/
add_filter( 'woocommerce_billing_fields' , 'cc_billing_fields_customize' );
function cc_billing_fields_customize($fields){
	 $fields['billing_first_name']['placeholder'] = 'EG. JOHN';
     $fields['billing_last_name']['placeholder'] = 'EG. SMITH';
     $fields['billing_company']['placeholder'] = 'EG. CARPET CALL';
     $fields['billing_email']['placeholder'] = 'EG. JOHN@GMAIL.COM';
     $fields['billing_phone']['placeholder'] = 'EG. 02 1234 5678';
     $fields['billing_address_1']['placeholder'] = '';
     $fields['billing_address_1']['label'] = 'Address Line 1';
     $fields['billing_address_2']['placeholder'] = '';
     $fields['billing_address_2']['label'] = 'Address Line 2';
     $fields['billing_city']['placeholder'] = '';
     $fields['billing_city']['label'] = 'Suburb/City';
     $fields['billing_state']['required'] = false;
	

	//do_action('pr',$fields);
	return $fields;
	}

add_filter( 'woocommerce_shipping_fields' , 'cc_shipping_fields_customize' );
function cc_shipping_fields_customize( $fields ) {


     $fields['shipping_first_name']['placeholder'] = 'EG. JOHN';
     $fields['shipping_last_name']['placeholder'] = 'EG. SMITH';
     $fields['shipping_company']['placeholder'] = 'EG. CARPET CALL';
    // $fields['shipping_email']['placeholder'] = 'EG. JOHN@GMAIL.COM';
    // $fields['shipping_phone']['placeholder'] = 'EG. 02 1234 5678';
     $fields['shipping_address_1']['placeholder'] = '';
     $fields['shipping_address_1']['label'] = 'Address Line 1';
     $fields['shipping_address_2']['placeholder'] = '';
     $fields['shipping_address_2']['label'] = 'Address Line 2';
     $fields['shipping_city']['placeholder'] = '';
     $fields['shipping_city']['label'] = 'Suburb/City';
     $fields['shipping_postcode']['placeholder'] = '';
     $fields['shipping_state']['required'] = false;
     return $fields;
}

add_filter( 'woocommerce_get_price_excluding_tax', 'round_price_product', 10, 1 );
add_filter( 'woocommerce_get_price_including_tax', 'round_price_product', 10, 1 );
add_filter( 'woocommerce_tax_round', 'round_price_product', 10, 1);
add_filter( 'woocommerce_get_price', 'round_price_product', 10, 1);

function round_price_product( $price ){
    return round( $price );
}

function cc_smart_category_top_parent_id ($catid) {
    while ($catid > 0) {
        $cat = get_term_by('id',$catid,'product_cat'); 
		//do_action('pr',$cat);// get the object for the catid
        $catid = $cat->parent; // assign parent ID (if exists) to $catid
          // the while loop will continue whilst there is a $catid
          // when there is no longer a parent $catid will be NULL so we can assign our $catParent
        $catParent = $cat->term_id;
    }
    return $catParent;
}
/*
Change the From Wrodpress to Carpetcall in emails to Admin for all enquiry emails
*/
function cc_filter_wp_mail_from_name($from_name){
return "Carpetcall";
}
add_filter("wp_mail_from_name", "cc_filter_wp_mail_from_name");

function cc_get_banner_image($post_id){
	$feat_image = '';
	if(has_term('rugs','product_cat',$post_id)){
		$sku = explode('.',get_post_meta($post_id,'_sku',true));
		$image_name= strtoupper($sku[0].'_'.$sku[1].'_'.$sku[2]).'_LB.jpg';
		
		$img_path =  WP_CONTENT_DIR.'/uploads/images/large/'.$image_name;
		if(file_exists($img_path)){
			$feat_image = content_url('uploads/images/large/'.$image_name);
		}
	}
	return $feat_image;
}

function show_most_popular_products(){
	$args = array(
					'post_type'=>'product',
					'post_status'=>'publish',
					'posts_per_page'=>3,
					'meta_key' => 'total_sales',
					'orderby' =>'meta_value_num',
					'tax_query'             => array(
													array(
														'taxonomy'      => 'product_cat',
														'field' => 'slug', 
														'terms'         => array('rugs','hard-flooring','carpets'),
														'operator'      => 'IN'
													)
												),
					'meta_query'=>array(
										array(
											'key'	=>'_stock_status',
											'value'	=>'instock',
										),
									),
				
				
					);
	$popular_products = get_posts($args);
	$output = '';
	if(count($popular_products) > 0 ){
		ob_start();?>
        <div class="inerblock_sec_a">
            <div class="container clearfix you_may_link_cntr">
            <h3 style="text-align:center">YOU MAY ALSO LIKE</h3>
            <div class="you_may_like-content">
            <?php
			foreach($popular_products as $product){
				$terms = get_the_terms($product->ID,'product_cat');
				$last_cat ='';
				if($terms){
					foreach($terms as $term){
						if(is_last_cat($term->term_id)){
							$last_cat = $term;
							break;
							}
						}
					}
				$_product = new WC_Product($product->ID);
				if($_product->is_in_stock()){
					$price = $_product->get_price();
					$feat_image = cc_custom_get_feat_img($product->ID,'medium');
					?>
                    <div class="col-md-4">
                      <div class="pro_secone"> 
                        <a href="<?php echo get_permalink($product->ID)?>" class="cc-product-item-image-link">
                            <div class="img_cntr" style="background-image:url('<?php echo $feat_image?>');"></div>
                        </a> 
                        <div class="mero_itemss">
                          <div class="proabtxt"> 
                            <a href="<?php echo get_permalink($product->ID)?>" class="cc-product-item-title-link"><h4> <?php echo $last_cat->name?></h4></a>
                            <?php if($price){?><h6> FROM $<?php echo number_format(esc_attr( round($_product->get_price()) ),2,'.',''); ?></h6><?php } ?>
                          </div>
                          <div class="clearfix"></div>
                        </div>
                      </div>
                    </div>
                <?php
                }
			}
            ?>
            </div>
            <div class="clearfix"></div>
            
            </div>
        </div>

		<?php 
		$output = ob_get_clean();
		}
	if($output)return $output;
	}

function atom_search_where($where){
  global $wpdb;
    
  $price=get_query_var('price');
  $category_filter=get_query_var('category_filter');

  if (is_search() || get_search_query()!=''){	  
    $where .= " OR (t.name LIKE '%".get_search_query()."%' AND {$wpdb->posts}.post_status = 'publish' AND {$wpdb->posts}.post_type = 'product')";
	//$where .=" AND t.term_id NOT IN({$acc_term_list}) ";
 
	if(!empty($price)){
		$price_=explode(',', $price);
		$where.=" AND ( {$wpdb->postmeta}.meta_key = '_price' AND CAST({$wpdb->postmeta}.meta_value AS SIGNED) BETWEEN '".$price_[0]."' AND '".$price_[1]."' )";
	}
	if(!empty( $category_filter)){
		$where.=" AND tr.term_taxonomy_id IN (select term_id from {$wpdb->term_taxonomy} where {$wpdb->term_taxonomy}.parent in (".$category_filter.") )";
	}
	
	 }
  return $where;
  
}

function atom_search_join($join){
  global $wpdb;

 // var_dump(get_search_query());
  if (is_search() || get_search_query()!=''){
    $join .= "LEFT JOIN {$wpdb->term_relationships} tr ON {$wpdb->posts}.ID = tr.object_id INNER JOIN {$wpdb->term_taxonomy} tt ON tt.term_taxonomy_id=tr.term_taxonomy_id INNER JOIN {$wpdb->terms} t ON t.term_id = tt.term_id";
  
  }
  return $join;
}

function atom_search_groupby($groupby){
  global $wpdb;

  // we need to group on post ID
  $groupby_id = "{$wpdb->posts}.ID";
  if(!is_search() || strpos($groupby, $groupby_id) !== false) return $groupby;

  // groupby was empty, use ours
  if(!strlen(trim($groupby))) return $groupby_id;

  // wasn't empty, append ours
  return $groupby.", ".$groupby_id;
}

	//add_filter('posts_where','atom_search_where');
	//add_filter('posts_join', 'atom_search_join');
	//add_filter('posts_groupby', 'atom_search_groupby');


//add_rewrite_rule('^shop-our-range/([^/]*)/([^/]*)/([^/]*)/([^/]*)?','index.php?&product=$matches[4]','top');

//global $woocommerce;
//$order_id = 3305;
//$shipping = '';
//$order = new WC_Order( $order_id );
//$order->add_shipping($shipping);
