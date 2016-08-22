
<?php get_header( 'shop' );?>
<?php
 $search_query = esc_html( get_search_query( false ) );
$perpage_var = 10;
$args = array(
				'post_type'			=> 'product',
				'posts_per_page'	=> -1,
				's'					=>$search_query,
			);
$found_prod = new WP_Query($args);
?>
<div class="contaniner clearfix category-hard-flooring">
  <div class="inerblock_seC_mrugss">
    <div class="container">
      <div class="tophead_sec col-md-12 no-lr">
      
      <div class="rugm-blk col-md-6 no-pl">
          <p> <span class="cc-cat-title-count"> <span class="post_count"><?php echo $found_prod->post_count;?></span> <?php _e('results for ','carpetcall');?>"<?php echo $search_query?>" </span> <span class="cc-count-clear"><a href="javascript:void(0)">CLEAR ALL</a></span> </p>
        </div>
        <div class="col-md-6 no-pr">
          <div class="pull-right cc-product-sort">
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
      
      <div class="cc-cat-pro-section-left col-md-3 no-lr">
        <?php //get_sidebar('pro-subcategory');?>
        <?php get_sidebar('cc-search');?>
      </div>
      
      <div class="col-md-9 cc-cat-pro-section-right">

        <div id="category_slider_block_wrapper">
        <?php 
			$args = array('s'=>$search_query,'perpage'=>$perpage_var);
			$search_result = cc_custom_search($args);
			echo $search_result['html'];
		?>
        </div>
        <div class="woo-added"></div>
        <input type="button" name="cc_load_more" id ="cc_load_more" callto="cc_custom_search" value="load more" />
        <input type="hidden" name="perpage_var" id="perpage_var" value="<?php echo $perpage_var;?>">
        <input type="hidden" name="ajax_offset" id="ajax_offset" value="<?php echo ($ret['offset'])?$ret['offset']:0?>">
        <input type="hidden" name="ajax_sort_by" id="ajax_sort_by" value="price">
        <input type="hidden" name="ajax_sort_order" id="ajax_sort_order" value="ASC">
        <input type="hidden" name="search_query" id="search_query" value="<?php echo $search_query?>">
        <input type="hidden" name="selected_price_ranges" id="selected_price_ranges" value="">
        <input type="hidden" name="selected_shop_range" id="selected_shop_range" value="">
      </div>
      <?php 
		
		
		?>
    </div>
  </div>
</div>
<?php get_footer();?>