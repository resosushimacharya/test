<?php 
if ( ! is_admin() ) {
    include ABSPATH . 'wp-admin/includes/template.php';
}

add_filter( 'woocommerce_return_to_shop_redirect', 'return_to_shop_link' );
function return_to_shop_link() {
     $rugs_term = get_term_by('slug','rugs','product_cat');
	 return get_term_link($rugs_term->term_id,'product_cat');
	 
	  // change to the link you want
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
add_filter('term_link','return_parent_catlink_if_lastchild',10,3);
function return_parent_catlink_if_lastchild($link,$term_obj,$taxonomy){
	global $wpdb;
	$catid = $term_obj->term_id;
	$ancestors = get_ancestors( $term_obj->term_id, 'product_cat' );
	$depth = count($ancestors) ;
	if($depth >=2){
		//$link = '';
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
			$args['price'] = sanitize_text_field($_POST['price']);
		}
		if(isset($_POST['child_cat_count']) && ($_POST['child_cat_count'] !='')){
			$args['child_cat_count'] = sanitize_text_field($_POST['child_cat_count']);
		}
	}
	extract($args);
	global $wp_query;
	$product_found = 0;
	$current_cat = get_term( $cat_id, 'product_cat');
	$cat_arr = generate_catids_array($cat_id,$depth);
	if(!empty($cat_arr)){
		$cat_slice = array();
		$cat_slice_arr =  array_slice($cat_arr,$offset,$perpage);
		$offset = $offset+$perpage;
		foreach($cat_slice_arr as $catid){
			$cat_slice[] = get_term_by('id',$catid,'product_cat');
		}
		if(!empty($cat_slice)){
			foreach($cat_slice as &$discat){?>
			<div class="cat-single-products">
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
						);
			if($sort_by == 'price'){
				$filargs['meta_key'] = '_regular_price';
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
												'key' => '_regular_price', 
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
			$all_products = new WP_Query($filargs);
			$product_found += $all_products->post_count;
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
					$grp_prod_args['meta_key'] = '_regular_price';
				}elseif($sort_by == 'popular'){
					$grp_prod_args['meta_key'] = 'total_sales';
				}
				$grp_prod_args['orderby'] = 'meta_value_num';
				$grp_prod_args['order'] = $sort_order;
				$filloop = new WP_Query($grp_prod_args);
			}else{
					$offset++;
					if($offset < count($cat_arr)){
						$next_cat = array_slice($cat_arr,$offset,1);
						$next_cat =  get_term_by('id',$next_cat[0],'product_cat');
						$cat_slice[] = $next_cat;
					}else{
							$filloop = '';
					}
			}
			$hold = 1;
			if($filloop !='' && $filloop->post_count > 0){
				$current_cat = get_term_by('id',$discat->parent,'product_cat');
				?>
				<div class="row cc-cat-sub-title-price-cover">
				<div class="col-md-6 cc-cat-sub-title">
				<h4><?php _e($current_cat->name,'carpetcall')?></h4>
				<?php echo '<h3>'.$discat->name.'</h3><br/>'; ?>
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
							if(preg_match("/\_L/i", $proImageName)){
								$feat_image = wp_get_attachment_image_src($imgid,'full');
								if($feat_image){
									$feat_image = $feat_image[0];
								}
							}
						}
						if($feat_image ==''){
							$feat_image = 'http://staging.carpetcall.com.au/wp-content/plugins/woocommerce/assets/images/placeholder.png';
						}
						if($pch==1){
							$res = get_post_meta($filloop->post->ID ,'_regular_price',true);
							echo '<div class="col-md-6 cc-cat-sub-price">From <span>A$'.$res.'</span></div></div> <div class="row cc-cat-sub-carousal-a">';
						$pch++;
						}
						if($slidercounter<=5){
							if($slidercounter==1){
								echo '<div class="cat_slider">';
							}
							?>
							<div class="cat_slider_item ">
							<div class="cat_slider_item_image" style="background-image:url(<?php echo $feat_image;?>)"></div>
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
                    while($filloop->have_posts()){
						$filloop->the_post();
						$feat_image = wp_get_attachment_url( get_post_thumbnail_id($filloop->post->ID),'thumbnail');
						$proGal = get_post_meta($filloop->post->ID, '_product_image_gallery', TRUE );
						$proGalId = explode(',',$proGal);
						$reqProImageId = '';
						foreach($proGalId as $imgid){
							$proImageName = wp_get_attachment_url($imgid);
							if(preg_match("/\_L/i", $proImageName)){
								$feat_image = wp_get_attachment_image_src($imgid,'thumbnail');
								if($feat_image){
									$feat_image = $feat_image[0];
								}
							}
						}
						if($feat_image ==''){
							$feat_image = 'http://staging.carpetcall.com.au/wp-content/plugins/woocommerce/assets/images/placeholder.png';
						}
						?>
						<div class=" cc-other-term-pro">
						<div class="cc-img-wrapper">
						<div class="cat-item-group-image" style="background-image:url(<?php echo $feat_image;?>)">
						<a href ="<?php the_permalink();?>" class="cc-pro-view">VIEW</a> </div>
						</div>
						</div>
                    <?php }?>
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
		if(isset($_POST['price']) && ($_POST['price'] !='')){
		$args['price'] = sanitize_text_field($_POST['price']);
		}
		if(isset($_POST['child_cat_count']) && ($_POST['child_cat_count'] !='')){
		$args['child_cat_count'] = sanitize_text_field($_POST['child_cat_count']);
		}
	}
	extract($args);
	global $wp_query;
	$found_count = 0;
	$current_cat = get_term( $cat_id, 'product_cat');
	$cat_arr = generate_catids_array($cat_id,$depth);
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
				$filloop = new WP_Query($filargs);
				if($filloop->post_count==0){
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
				if($filloop !='' && $filloop->post_count > 0){
					$found_count += $filloop->post_count;
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
							$feat_image = wp_get_attachment_url( get_post_thumbnail_id($filloop->post->ID),'full' );
							$proGal = get_post_meta($filloop->post->ID, '_product_image_gallery', TRUE );
							$proGalId = explode(',',$proGal);
							$reqProImageId = '';
							foreach($proGalId as $imgid){
								$proImageName = wp_get_attachment_url($imgid);
								if(preg_match("/\_L/i", $proImageName)){
									$feat_image = wp_get_attachment_image_src($imgid,'full');
									if($feat_image){
										$feat_image = $feat_image[0];
									}
								}
							}
							if($feat_image ==''){
								$feat_image = 'http://staging.carpetcall.com.au/wp-content/plugins/woocommerce/assets/images/placeholder.png';
							}
							
							if($pch==1){
								$res = get_post_meta($filloop->post->ID ,'_regular_price',true);
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
                        while($filloop->have_posts()){
							$filloop->the_post();
							$feat_image = wp_get_attachment_url( get_post_thumbnail_id($filloop->post->ID),'thumbnail' );
							$proGal = get_post_meta($filloop->post->ID, '_product_image_gallery', TRUE );
							$proGalId = explode(',',$proGal);
							$reqProImageId = '';
							foreach($proGalId as $imgid){
								$proImageName = wp_get_attachment_url($imgid);
								if(preg_match("/\_L/i", $proImageName)){
									$feat_image = wp_get_attachment_image_src($imgid,'thumbnail');
									if($feat_image){
										$feat_image = $feat_image[0];
									}
								}
							}
							if($feat_image ==''){
								$feat_image = 'http://staging.carpetcall.com.au/wp-content/plugins/woocommerce/assets/images/placeholder.png';
							}
							?>
							<div class=" cc-other-term-pro">
							<div class="cc-img-wrapper">
							<div class="cat-item-group-image" style="background-image:url(<?php echo $feat_image;?>)">
							<a href ="<?php the_permalink();?>" class="cc-pro-view">VIEW</a> </div>
							</div>
							</div>
                        <?php 
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
	$ret['offset'] = $offset;
	$ret['found_prod'] = $found_count;
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
		'sort_order'=>'DESC',
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
	}
	extract($args);
	global $wp_query;
	$found_count = 0;
	$filargs = array(
					'post_type'=>'product',
					'post_stauts' =>'publish',
					'posts_per_page'=>-1,
					's'				=>$s,
					'meta_query'=>array(
										array(
											'key'	=>'_stock_status',
											'value'	=>'instock',
										),
									),
				);
				
				
		if($shop_range !='' ){
					$shop_range_arr = explode(',',$shop_range);
					$filargs['tax_query'] = array(
													array(
														'taxonomy' => 'product_cat',
														'field' => 'id',
														'terms' => $shop_range_arr,
														'include_children' => true,
														'operator' => 'IN'
													  )
												);
				}
				
				
				
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
				$prod_count_init = new WP_Query($filargs);
				$found_count = ($prod_count_init->post_count  > 0)?$prod_count_init->post_count:0;	
				//$filargs['posts_per_page']=$perpage;
				//$filargs['offset']=$offset;
				$filloop = new WP_Query($filargs);
				if($filloop->have_posts()){
					while($filloop->have_posts()){
						$filloop->the_post();?>
						<div class="search_prod_wrapper col-md-4">
                            	<?php
								//$imgurl = (has_post_thumbnail())?the_post_thumbnail_url('thumbnail'):get_template_directory_uri().'/images/placeholder.png';
								 ?>
                                 
<div class="cc-search-inner-wrap">                            <div class="search_thumb" style="background-image:url(<?php echo (has_post_thumbnail())?the_post_thumbnail_url('thumbnail'):get_template_directory_uri().'/images/placeholder.png'?>)"></div>
<div class="cc-search-tps">                            <div class="search_title">
								<?php 
                                    $categories = get_the_terms(get_the_ID(), 'product_cat' ); 
                                    if ( $categories ) : 
                                        foreach($categories as $category) :
                                          $children = get_categories( array ('taxonomy' => 'product_cat', 'parent' => $category->term_id ));
                                          if ( count($children) == 0 ) {
											  ?>
                                              <span class="parent_cat">
                                              
											  <?php 
											  $temp_parent = get_term_by('id',$category->parent,'product_cat'); 
											  if($temp_parent){?>
												  <a href="<?php echo get_term_link($temp_parent->term_id,"product_cat")?>"><?php echo $temp_parent->name?></a>
												  <?php }
											  ?>
                                              
                                              </span>
                                              
                                              <span class="cat_third">
                                              <a href="<?php echo get_term_link($category->term_id,"product_cat")?>"><?php echo $category->name?></a>
                                              </span>
                                            
                                             <?php break;
                                          }
                                        endforeach;
                                    endif;
                                    ?>
                                    
                            </div>
                            <div class="search_price">
                            	<?php
								$product = wc_get_product( get_the_ID() );
								if(get_field('size_m2',get_the_ID())){?>
									<div class="cc-price-control">

									<h3><span class="cc-sale-price-title">A$<?php echo $product->get_regular_price().'/SQM'?></span> </h3>
                                   </div>
									<?php }else{
										echo  $product->get_price_html();
										}
								?>
                            </div>
                            <div class="search_shop_now">
                            	<div class="read_more">
                                <a href="<?php echo get_term_link($temp_parent->term_id,"product_cat")?>">Shop Now</a>
                                </div>
                            </div>
</div></div>                        </div>
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
	$transient = 'category_'.$top_lvl_cat.'_transient';
	if ( false === ( get_transient( $transient ) ) ) {
		$cat_arr = array();
		$second_lvl_cats = get_terms(array('parent'=>$top_lvl_cat,'taxonomy'=>'product_cat','hide_empty'=>false));
		foreach($second_lvl_cats as $cat_parents){
			if($depth==0){
				$third_lvl_cats = get_terms(array('parent'=>$cat_parents->term_id,'taxonomy'=>'product_cat'));
				foreach($third_lvl_cats as $cat){
					$cat_arr[] = $cat->term_id;
				}
			}else{
				$cat_arr[] = $cat_parents->term_id;
				}
	
			}
	  set_transient( $transient, $cat_arr, 12 * HOUR_IN_SECONDS );
	}
	return get_transient($transient);
}

add_action('edited_product_cat','delete_product_cat_transient');
add_action('delete_product_cat','delete_product_cat_transient');
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
  <h3>Delivery Options</h3>
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
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	  $lat=$_POST['latitude'];
	  $long=$_POST['longitude'];
	  if(isset($_POST['address'])){
		  $address = str_replace(' ','+',$_POST['address']);
		  }
	}else{
	  $lat=$args['latitude'];
	  $long=$args['longitude'];
	  $address = str_replace(' ','+',$args['address']);
	}
if($lat==''|| $long == '' && $address !=''){
	$geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$address.'&sensor=false');
        $output= json_decode($geocode);
        $lat = $output->results[0]->geometry->location->lat;
        $long = $output->results[0]->geometry->location->lng;
	}

	$a=array();
     $myArrays= array();
  	$backarg=array('post_type'=>'wpsl_stores',
    'posts_per_page'=>'-1'
    );


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
                'post__in' => $store_ids,
              );
              $loop = new WP_Query($args);
              if($loop->have_posts()){
                while($loop->have_posts()){
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
       		<input type="radio" name="pickup_store_id" value="<?php echo get_the_ID()?>">
            <h3><?php the_title();?></h3>
            <p class="address"><?php echo  $add .' '. $city.' '.$state.' '.$zip;?></p>
       </div>
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
	if(!empty($_POST['pickup_store_id'])){
		update_post_meta( $order_id, 'pickup_store_id', $_POST['pickup_store_id']);
		//cc_notify_selected_store($order_id);
		}
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
		
	$url.='?product='.$post->post_title;
	}
	return $url;
}
add_filter( 'post_type_link', 'cc_custom_proudcts_url', 10, 3 );	
