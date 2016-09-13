
<?php get_header( 'shop' );?>
<div class="child-innerpg">
    <div class="container clearfix">
        <div class="inerblock_serc_child about-page cc-search-allprd">
            <div class="cc-breadcrumb">
              <span class="cc-bread-current">Searching Carpetcall Website</span>
            </div><!-- end .cc-breadcrumb -->
            <h1>Search Results</h1>
            <div class="search_header clearfix">
				<div itemscope itemtype="http://schema.org/WebSite">
                            <link itemprop="url" href="<?php echo site_url()?>"/>
                            <form itemprop="potentialAction" itemscope itemtype="http://schema.org/SearchAction" >
                                  <meta itemprop="target" content="<?php echo site_url()?>?q={<?php echo get_search_query()?>}"/>
                              <div class="input-group"><input itemprop="query-input" type="text" name="s" placeholder="TYPE TO SEARCH" class="form-control" value="<?php echo get_search_query()?>"/>
                              <span class="input-group-btn">
    <button type="submit" class="btn btn-default cc_search_button" id="searchsubmit" value="">
      <svg xmlns="http://www.w3.org/2000/svg" width="626" height="626" viewBox="0 0 626 626" fill="#808080"><path d="M234.502 468.998C105.024 469.033-.248 364.54.162 234.145.572 103.867 104.737.123 234.957.16 365.233.194 469.347 105.7 469.03 235.294c-.316 129.3-105.033 233.77-234.528 233.703zM58.722 235.14c.39 97.628 79.406 175.614 175.932 175.53 97.425-.083 176.05-79.147 176.148-175.985.098-96.948-79.577-176.324-176.626-175.965-97.164.36-175.857 79.485-175.455 176.42zm323.766 229.716c33.232-21.7 60.585-48.976 83.233-83.725 2.076 2.764 3.414 5.066 5.23 6.89 45.408 45.505 90.928 90.897 136.274 136.462 14.354 14.424 21.37 31.882 17.53 52.252-4.316 22.89-17.586 38.725-40.127 45.99-22.942 7.392-42.994 1.375-59.6-15.042-47.256-46.715-94.08-93.866-141.07-140.852-.344-.345-.593-.788-1.468-1.972z"></path></svg>
    </button>
    </span></div>
                            </form>
                        </div>
						<?php // get_search_form();?>
			</div>
        </div><!-- end .innerblock_serc_child -->
    </div><!-- end .container.clearfix -->
</div>




<?php
$search_query = esc_html( get_search_query( false ) );
$perpage_var = 9;
$args = array(
				'post_type'			=> 'product',
				'posts_per_page'	=> -1,
				's'				=> $search_query,
				'meta_query' => array(
									array(
										'key' => '_stock_status',
										'value' => 'instock'
									)
        						)
			);
$found_prod = new WP_Query($args);
?>


<div class="contaniner clearfix category-hard-flooring">
  <div class="inerblock_seC_mrugss">
    <div class="container">
      <div class="tophead_sec col-md-12 no-lr">
      <div class="rugm-blk col-md-6 no-pl">
          <p> <span class="cc-cat-title-count"> <span class="post_count"><?php echo $found_prod->post_count;?></span> <?php _e('results for ','carpetcall');?>"<?php echo $search_query?>" </span> <span class="cc-count-clear"><a href="javascript:void(0)">CLEAR ALL</a></span> </p>
          <span class="open-product-sidebar">
            +
          </span>
        </div>
        <div class="col-md-6 no-pr">
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
              <span class="cc-cat-title-count"> <span class="post_count"><?php echo $found_prod->post_count;?></span> <?php _e('results for ','carpetcall');?>"<?php echo $search_query?>" </span> <span class="cc-count-clear"><a href="javascript:void(0)">CLEAR ALL</a></span> </span>
            </div>
          </div>
        </div>
        <?php //get_sidebar('pro-subcategory');?>
        <?php get_sidebar('cc-search');?>
      </div>
      
      <div class="col-md-9 cc-cat-pro-section-right">

        <div id="category_slider_block_wrapper" class="search_sidebar search_list_wrapper">
        <?php 
			$args = array('s'=>$search_query,'perpage'=>$perpage_var);
			$search_result = cc_custom_search($args);
			//do_action('pr',$search_result);
			echo $search_result['html'];
		?>
        </div>
        <div class="woo-added"></div>
        <input type="button" name="cc_load_more" id ="cc_load_more" callto="cc_custom_search" value="load more" <?php echo ($search_result['found_prod'] < $perpage_var)?'style="display:none"':'' ?>  />
        <input type="hidden" name="perpage_var" id="perpage_var" value="<?php echo $perpage_var;?>">
        <input type="hidden" name="ajax_offset" id="ajax_offset" value="<?php echo ($search_result['offset'])?$search_result['offset']:0?>">
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