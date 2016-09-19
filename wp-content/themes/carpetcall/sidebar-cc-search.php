
    <div class="cc-product-sub-category-list">
    <?php 
    /**
    *shpw the sub-category list of the  product category
    */

	$product_cats = get_terms( 'product_cat', array( 'parent' => 0 ) );
	?>
  <?php /*?><div class="cc-size-var-sec">
         <div class="panel-group cc-price-var" id="accordion-size">
      <div class="panel panel-default">    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-price" href="#collapse_size">
          <span class="pull-left glyphicon glyphicon-chevron-up"></span>
         Shop Our Range</a>
        
      </h4>
    </div>
    <div id="collapse_shop_range" class="panel-collapse collapse in">
      <div class="panel-body">
        <div class="cc-shop-range-select">
         <form role="form">
   <?php foreach($product_cats as $term){?>
	   <div class="checkbox">
      <input type="checkbox" class="shop_range" value="<?php echo $term->term_id?>"><label><?php _e($term->name,'carpetcall')?></label>
    </div>
	   <?php }?>
    
  </form>
        </div>
      </div>
    </div>
    </div>
    </div>
    </div><?php */?>
   <h3> Refine By </h3> 
    
  <div class="clearfix"></div>
  <div class="cc-size-var-sec">
         <div class="panel-group cc-price-var" id="accordion-size">
      
      <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-size" href="#collapse_shop_range">
          <span class="pull-left glyphicon glyphicon-chevron-up"></span>
         SHOP OUR RANGE</a>
        
      </h4>
    </div>
    <div id="collapse_shop_range" class="panel-collapse collapse in">
      <div class="panel-body">
        <div class="cc-price-var-items">
      
      <form role="form">
   <?php foreach($product_cats as $term){?>
	   <div class="checkbox">
      <input type="checkbox" class="shop_range" value="<?php echo $term->term_id?>"><label><?php _e($term->name,'carpetcall')?></label>
    </div>
	   <?php }?>
    
  </form>
         

        </div>
      </div>
     
    </div>
  </div>
  </div>
    </div>
    <div class="clearfix"></div>
  <div class="cc-price-var-sec">
         <div class="panel-group cc-price-var" id="accordion-price">
      
      <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-price" href="#collapse_price">
          <span class="pull-left glyphicon glyphicon-chevron-up"></span>
         PRICE</a>
        
      </h4>
    </div>
    <div id="collapse_price" class="panel-collapse collapse in">
      <div class="panel-body">
        <div class="cc-price-var-items">
      <?php
		
		$args_min = array(
							'post_type'=>'product',
							'posts_per_page'	=>1,
							'meta_key'		=>'_regular_price',
							'orderby'		=>'meta_value_num',
							'order'			=>'ASC'
						);
		$args_max = array(
							'post_type'=>'product',
							'posts_per_page'	=>1,
							'meta_key'		=>'_regular_price',
							'orderby'		=>'meta_value_num',
							'order'			=>'DESC'
						);
		wp_reset_postdata();
		$min_prod = get_posts($args_min);
		$max_prod = get_posts($args_max);
		$min_price_prod = new WC_Product($min_prod[0]->ID);
		$max_price_prod = new WC_Product($max_prod[0]->ID); 
		$max = $max_price_prod->get_regular_price();
		$min = ($min_price_prod->get_regular_price() > 0)?$min_price_prod->get_regular_price():0;
		?>
        
      <div class="range_slider"><b>$ <span class="price_from"><?php echo $min?></span> </b><input id="price_range_filter" type="text" data-slider-min="<?php echo $min?>" data-slider-max="<?php echo $max?>" data-slider-step="1" data-slider-value="[<?php echo $min?>,<?php echo $max?>]"/><b> $<span class="price_to"><?php echo $max?></span></b></div> 
        </div>
      </div>
     
    </div>
  </div>
  </div>
    </div>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
