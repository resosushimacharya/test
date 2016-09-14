<?php
	$appafter = '';
 	$perpage_var = 4;
	$current_cat = get_term_by('slug',get_query_var('product_cat'),'product_cat');
	$is_last_lvl =  false;
	$current_cat_child = get_term_children($current_cat->term_id, 'product_cat');
	if(sizeof($current_cat_child)==0){
		$is_last_lvl = true;
		}
	$ancestors = get_ancestors( $current_cat->term_id, 'product_cat' );
	$depth = count($ancestors) ; 
	?>
<div class="contaniner clearfix category-hard-flooring">
  <div class="inerblock_seC_mrugss">
    <div class="container-fluid mmrugm <?php echo ($depth==0)?'main_cat_head':'sub_cat_head' ?>">
    <?php
	$url = '';
	$cat_thumb_id = get_woocommerce_term_meta($current_cat->term_id, 'thumbnail_id', true);
	if($cat_thumb_id){
		$url = wp_get_attachment_url($cat_thumb_id);
		}else{
			$url = get_template_directory_uri().'/images/rugs-all.jpg';
			}

	?>
     <div class="cc-rugsall-catgr clearfix" style=" <?php echo ($depth == 0)?'background-image:url('. $url:''?>">
      <div class="container">
      
        <?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>
        <h3>
          <?php if($depth > 0){
          //var_dump($depth);
              $cat_parent = get_term_by('id',$current_cat->parent,'product_cat');
            ?>
          <span class="ab_arrow">
            <a href="<?php echo get_term_link($cat_parent->term_id,'product_cat')?>">
              <i class="fa fa-angle-left" aria-hidden="true"></i>            
              <b><?php echo ($depth ==1)?'All '. $cat_parent->name:'Back' ?></b>
            </a>
          </span>
          <?php } ?>
          <?php echo single_cat_title('',false).' '.$appafter;?>
          <?php 
	/*
while(have_posts()):
  the_post();
the_title();
endwhile;
*/
?>
        </h3>
        <?php 
if(get_term_meta($current_cat->term_id,'cat_top_description',true) && $depth == 0){
	?>
        <p class="category_description"><?php echo get_term_meta($current_cat->term_id,'cat_top_description',true)?></p>
        <?php }?>
      </div>
      </div>
    </div>
    <div class="container">
      <div class="tophead_sec col-md-12 no-lr clearfix">
        <?php $term_id =  get_queried_object()->term_id;
$currentcat = get_queried_object();
 
?>
<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) {
	$args = array(
		'cat_id' =>$current_cat->term_id,
		'offset'=>0,
		'perpage'=>$perpage_var,
		'sort_by'	=>'price',
		'sort_order'=>'ASC',
		'depth'	=>$depth,
		'child_cat_count'=>1
	);
	$ret = loadmore_hf($args);
	 ?>
             <div class="rugm-blk col-md-6 no-pl">
          <p> <span class="mobile cc-cat-title-count">  <?php /* <span class="post_count"><?php echo $ret['found_prod'];// $currentcat->count;?></span> <?php echo single_cat_title('',false).' '.$appafter;?> Products */ ?> Filters</span> 
            <span class="cc-count-clear"><a href="javascript:void(0)">CLEAR ALL</a></span> 
            </p>
           <span class="open-product-sidebar">
            +
          </span>
        </div>
        <div class="col-md-6 no-pr clearfix cat-sort-by-cntr">
          <div class="cc-product-sort">
            <ul>
              <li class="sort_key"> <span class="cc-count-label">Sort by:</span></li>
              <li class="sort_key"> <a href="javascript:void(0)" sort="popular">Popularity</a> </li>
              <li class="sort_key cc-count-active"> <a href="javascript:void(0)" sort="price_low">$</a> </li>
              <li class="sort_key"> <a href="javascript:void(0)" sort="price_high">$$$</a> </li>
            </ul>
            <?php //do_action( 'woocommerce_before_shop_loop' ); ?>
          </div>
        </div>
      </div>
      
      <div class="cc-cat-pro-section-left col-md-3 no-lr" id="product-side-filter">
      <div class="filter-top-mobile">
          <div class="filter-go-back">
            <div class="go-back-text">
              <span class="fa fa-angle-left"></span>
              <span class="back-text">Back</span>
            </div>
          </div>
          <div class="mobile-filter-sec">
            <div class="filter-back-btn">
              <span class="cc-cat-title-count"> <span class="post_count"><?php echo $currentcat->count;?></span> <?php echo single_cat_title('',false).' '.$appafter;?> Products </span> <span class="cc-count-clear"><a href="javascript:void(0)">CLEAR ALL</a></span>
            </div>
          </div>
        </div>
        <?php //get_sidebar('pro-subcategory');?>
        <?php get_sidebar('hard-flooring');?>

        <div class="mobile-apply-btn">
          <a href="#">Apply</a>
        </div>
      </div>
      
      <div class="col-md-9 cc-cat-pro-section-right">
        
        <div id="category_slider_block_wrapper">
        <?php 
			echo $ret['html'];
		?>
        </div>
        <div class="woo-added"></div>
       <?php
	   //if(!is_last_cat($current_cat->term_id)){?>
       
		 <input type="button" name="cc_load_more" id ="cc_load_more" callto="loadmore_hf" value="load more" first="<?php echo (($depth==0) && $ret['offset'] > $perpage_var)?'yes':'no'?>" <?php echo ($ret['found_prod'] < $perpage_var || !($is_last_lvl))?'':'style="display:none" disabled'?>/>
		
		<?php //}
	   
	   ?>
       
        <input type="hidden" name="perpage_var" id="perpage_var" value="<?php echo $perpage_var;?>">
        <input type="hidden" name="ajax_cat_id" id="ajax_cat_id" value="<?php echo $current_cat->term_id?>">
        <input type="hidden" name="ajax_offset" id="ajax_offset" value="<?php echo ($ret['offset'])?$ret['offset']:0?>">
        <input type="hidden" name="ajax_sort_by" id="ajax_sort_by" value="price">
        <input type="hidden" name="ajax_sort_order" id="ajax_sort_order" value="ASC">
        <input type="hidden" name="cat_depth" id="cat_depth" value="<?php echo $depth ?>">
        <input type="hidden" name="child_cat_count" id="child_cat_count" value="<?php echo ($ret['child_cat_count'])?$ret['child_cat_count']:1?>">
        <input type="hidden" name="selected_colors" id="selected_colors" value="">
        <input type="hidden" name="selected_sizes" id="selected_sizes" value="">
        <input type="hidden" name="selected_price_ranges" id="selected_price_ranges" value="">
      </div>
      <?php 
		
		} 
		?>
    </div>
  </div>
</div>
<?php get_template_part('templates/template','like');?>

<?php 
if(get_field('product_category_description',$current_cat)){
	?>
	<div class="cc_background_image">
  <div class="container clearfix cc-cat-sub-desc-sec"> 
  <?php echo  apply_filters('the_content', get_field('product_category_description',$current_cat));?> 
  </div>
</div>
	<?php }?>
