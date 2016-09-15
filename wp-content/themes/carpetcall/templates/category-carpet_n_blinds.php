<?php
	$appafter = '';
 	$perpage_var = 4;
	$current_cat = get_term_by('slug',get_query_var('product_cat'),'product_cat');
	$ancestors = get_ancestors( $current_cat->term_id, 'product_cat' );
	$depth = count($ancestors) ; 
	?>
<div class="contaniner clearfix category-hard-flooring cat-main-carpets">
  <div class="inerblock_seC_mrugss">
    <div class="container-fluid mmrugm sub_cat_head">
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

?>
        </h3>
      </div>
      </div>
    </div>
    <div class="container cateogry-carpets-main-cntr">
      
      <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) {
        ?>

      <div class="tophead_sec col-md-12 no-lr clearfix">

	<div class="mobile carpets-cat-dropdown">        
       <?php if(wp_is_mobile()){
		   get_sidebar('carpet_blinds');
	   }?>
      </div>
        
      
      <div class="cc-cat-pro-section-left col-md-3 no-lr">        
        <?php get_sidebar('carpet_blinds');?>
      </div>
      
      <div class="col-md-9 cc-cat-pro-section-right">
        <div id="category_slider_block_wrapper">
      		<?php 
      		$term_id =  get_queried_object()->term_id;
      		$ret = load_more_carpet_blinds(array('cat_id'=>$term_id,'depth'=>$depth));
      		echo $ret['html'];
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
