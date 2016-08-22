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
							if(preg_match("/\_V/i", $proImageName)){
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
							if(preg_match("/\_V/i", $proImageName)){
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
				<div>
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
								if(preg_match("/\_V/i", $proImageName)){
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
								if(preg_match("/\_V/i", $proImageName)){
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
                            <div class="search_thumb" style="background-position: center center; background-size: cover; min-height: 150px; background-image:url(<?php echo (has_post_thumbnail())?the_post_thumbnail_url('thumbnail'):get_template_directory_uri().'/images/placeholder.png'?>)"></div>
                            <div class="search_title">
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
                        </div>
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