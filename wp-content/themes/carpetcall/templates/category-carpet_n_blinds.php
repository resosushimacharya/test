<?php
	$appafter = '';
 	$perpage_var = 4;
	$current_cat = get_term_by('slug',get_query_var('product_cat'),'product_cat');
	$ancestors = get_ancestors( $current_cat->term_id, 'product_cat' );
	$depth = count($ancestors) ; 
	?>
<div class="contaniner clearfix category-hard-flooring">
  <div class="inerblock_seC_mrugss">
    <div class="container-fluid mmrugm">
     <div class="cc-rugsall-catgr clearfix">
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
             } ?>
          <?php echo single_cat_title('',false).' '.$appafter;?>
          <?php 

?>
        </h3>
      </div>
      </div>
    </div>
    <div class="container">
      <div class="tophead_sec col-md-12 no-lr clearfix">
	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) {
	?>
      </div>
      
      <div class="cc-cat-pro-section-left col-md-3 no-lr">
        <?php //get_sidebar('pro-subcategory');?>
        <?php get_sidebar('carpet_blinds');?>
      </div>
      
      <div class="col-md-9 cc-cat-pro-section-right">
        <div id="category_slider_block_wrapper">
		<?php 
		$term_id =  get_queried_object()->term_id;
		$prosubcats=get_term_children($term_id,'product_cat');
		$taxonomy = 'product_cat';
		foreach($prosubcats as $psc)
		{
			$term = get_term_by( 'id', $psc, $taxonomy );
			if($term->parent == $term_id && $term->count >0){
			$patterns = get_field('product_slider_photos',$term);
			if(!empty($patterns)){
				$count = 0;
				foreach($patterns as $pattern){
					$count++;
					if($count == 1){?>
						<div class="row cc-cat-sub-title-price-cover">
                        <div class="col-md-6 cc-cat-sub-title">
                        <h3><?php echo $term->name?></h3><br/>
                        </div>
                        </div>
						
						<?php }else{
							
							}
					}
				}
			
			
			}
		   } 		
		
		
		
		
		
			
			
		?>
        </div>
        <div class="woo-added"></div>
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
