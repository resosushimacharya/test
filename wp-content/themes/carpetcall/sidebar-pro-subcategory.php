
    <div class="cc-product-sub-category-list">
    <?php 
    /**
    *shpw the sub-category list of the  product category
    */
    $term_id =  get_queried_object()->term_id;
   
    $prosubcats=get_term_children($term_id,'product_cat');
	$taxonomy = 'product_cat';
	//$prosubcats=get_term_children($term_id,'product_cat');
	//do_action('pr',$prosubcats)
	?>
    
    <ul class="cc-pro-sub-cat-ul guide_list_cbg">
    
    <h3>Categories</h3>
    
   <?php 
    foreach($prosubcats as $psc)
    {
		$term = get_term_by( 'id', $psc, $taxonomy );
		if($term->parent == $term_id){
		 echo '<li><a href="'.get_term_link($term,$taxonomy).'">'.$term->name.'<i class="fa fa-caret-right" aria-hidden="true"></i></a></li>';
		}
       } ?>
    </ul>
    
   
    </div><div class="clearfix"></div>





<div class="cc-color-var-section">
<h3>Refine by</h3>
   <div class="panel-group cc-color-var" id="accordion-color">
      
      <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-colr" href="#collapse_color">
          <span class="pull-left glyphicon glyphicon-chevron-up"></span>
         Colour</a><a href="javascript:void(0);" class="pull-right clear_color_selection">CLEAR</a>
        
      </h4>
    </div>
    <div id="collapse_color" class="panel-collapse collapse in">
      <div class="panel-body">
        <ul class="cc-color-var-item">
        <?php 
		$colors = array(
						'4'=>'purple',
						'5'=>'red',
						'8'=>'yellow',
						'10'=>'blue',
						'20'=>'green',
						//'40'=>'ivory',
						//'44'=>'cream',
						'63'=>'white',
						'45'=>'beige',
						'54'=>'brown',
						'55'=>'grey',
						'50'=>'pink',
						'28'=>'orange',
						'65'=>'black',
					);
		
		foreach($colors as $key=>$color){
			if(file_exists(get_template_directory().'/images/'.$color.'.jpg')){
			?>
			<li>
    <a href="javascript:void(0);" class="swatch" style="background:url('<?php echo get_template_directory_uri().'/images/'.$color.'.jpg';?>');" id="<?php echo $color?>"> 
        <img src="<?php echo get_template_directory_uri().'/images/swatch_checked.png';?>" class="cc-tick-display" />
        </a>
      <label for="colour_red"><?php echo ucfirst($color) ?></label>
        </li>
			<?php
			}
		}?>
        <li>
    <a href="javascript:void(0);" class="swatch" style="background:url('<?php echo get_template_directory_uri().'/images/multiple.jpg';?>');" id="multi"> 
        <img src="<?php echo get_template_directory_uri().'/images/swatch_checked.png';?>" class="cc-tick-display" />
        </a>
      <label for="colour_multi"><?php _e('Multiple') ?></label>
        </li>
        
<?php /*?>        
        <li id="cc-color-tick-id-<?php echo $c; ?>">
        <a href="javascript:void(0);" class="swatch" style="background:url('<?php echo get_template_directory_uri().'/images/purple.jpg';?>');" id="purple">
        <img src="<?php echo get_template_directory_uri().'/images/swatch_checked.png';?>" class="cc-tick-display" /></a>
        <label for="colour_purple">Purple</label>
        </li>
        
          <li>
        <a href="javascript:void(0);" class="swatch" style="background:url('<?php echo get_template_directory_uri().'/images/red.jpg';?>');" id="red"> <img src="<?php echo get_template_directory_uri().'/images/swatch_checked.png';?>" class="cc-tick-display" /></a>
      <label for="colour_red">Red</label>
        </li>
        
         <li id="cc-color-tick-id-<?php echo $c; ?>">
        <a href="javascript:void(0);" class="swatch" style="background:url('<?php echo get_template_directory_uri().'/images/yellow.jpg';?>');" id="purple">
        <img src="<?php echo get_template_directory_uri().'/images/swatch_checked.png';?>" class="cc-tick-display" /></a>
        <label for="colour_purple">Yellow</label>
        </li>
        
          <li>
        <a href="javascript:void(0);" class="swatch" style="background:url('<?php echo get_template_directory_uri().'/images/blue-a.jpg';?>');" id="red"> <img src="<?php echo get_template_directory_uri().'/images/swatch_checked.png';?>" class="cc-tick-display" /></a>
      <label for="colour_red">Blue</label>
        </li>
        
         <li id="cc-color-tick-id-<?php echo $c; ?>">
        <a href="javascript:void(0);" class="swatch" style="background:url('<?php echo get_template_directory_uri().'/images/green.jpg';?>');" id="purple">
        <img src="<?php echo get_template_directory_uri().'/images/swatch_checked.png';?>" class="cc-tick-display" /></a>
        <label for="colour_purple">Green</label>
        </li>
        
          <li>
        <a href="javascript:void(0);" class="swatch" style="background:url('<?php echo get_template_directory_uri().'/images/white.jpg';?>');" id="red"> <img src="<?php echo get_template_directory_uri().'/images/swatch_checked.png';?>" class="cc-tick-display" /></a>
      <label for="colour_red">White</label>
        </li>
        
         <li id="cc-color-tick-id-<?php echo $c; ?>">
        <a href="javascript:void(0);" class="swatch" style="background:url('<?php echo get_template_directory_uri().'/images/beige.jpg';?>');" id="purple">
        <img src="<?php echo get_template_directory_uri().'/images/swatch_checked.png';?>" class="cc-tick-display" /></a>
        <label for="colour_purple">Beige</label>
        </li>
        
          <li>
        <a href="javascript:void(0);" class="swatch" style="background:url('<?php echo get_template_directory_uri().'/images/brown.jpg';?>');" id="red"> <img src="<?php echo get_template_directory_uri().'/images/swatch_checked.png';?>" class="cc-tick-display" /></a>
      <label for="colour_red">Brown</label>
        </li>
        
        <li id="cc-color-tick-id-<?php echo $c; ?>">
        <a href="javascript:void(0);" class="swatch" style="background:url('<?php echo get_template_directory_uri().'/images/grey.jpg';?>');" id="purple">
        <img src="<?php echo get_template_directory_uri().'/images/swatch_checked.png';?>" class="cc-tick-display" /></a>
        <label for="colour_purple">Grey</label>
        </li>
        
          <li>
        <a href="javascript:void(0);" class="swatch" style="background:url('<?php echo get_template_directory_uri().'/images/pink.jpg';?>');" id="red"> <img src="<?php echo get_template_directory_uri().'/images/swatch_checked.png';?>" class="cc-tick-display" /></a>
      <label for="colour_red">Pink</label>
        </li>
        
         <li id="cc-color-tick-id-<?php echo $c; ?>">
        <a href="javascript:void(0);" class="swatch" style="background:url('<?php echo get_template_directory_uri().'/images/orange.jpg';?>');" id="purple">
        <img src="<?php echo get_template_directory_uri().'/images/swatch_checked.png';?>" class="cc-tick-display" /></a>
        <label for="colour_purple">Orange</label>
        </li>
        
          <li>
        <a href="javascript:void(0);" class="swatch" style="background:url('<?php echo get_template_directory_uri().'/images/black.jpg';?>');" id="red"> <img src="<?php echo get_template_directory_uri().'/images/swatch_checked.png';?>" class="cc-tick-display" /></a>
      <label for="colour_red">Black</label>
        </li>
        
         <li id="cc-color-tick-id-<?php echo $c; ?>">
        <a href="javascript:void(0);" class="swatch" style="background:url('<?php echo get_template_directory_uri().'/images/multiple.jpg';?>');" id="purple">
        <img src="<?php echo get_template_directory_uri().'/images/swatch_checked.png';?>" class="cc-tick-display" /></a>
        <label for="colour_purple">Multiple</label>
        </li>
        
<?php */?>        
        </ul>
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
							'tax_query'	=>array(
									 array(
										'taxonomy' => 'product_cat',
										'field' => 'id',
										'terms' => $term_id,
										'include_children' => true,
										'operator' => 'IN'
										),
								),
							'meta_key'		=>'_regular_price',
							'orderby'		=>'meta_value_num',
							'order'			=>'ASC'
						);
		$args_max = array(
							'post_type'=>'product',
							'posts_per_page'	=>1,
							'tax_query'	=>array(
									 array(
										'taxonomy' => 'product_cat',
										'field' => 'id',
										'terms' => $term_id,
										'include_children' => true,
										'operator' => 'IN'
										),
								),
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
		$min = $min_price_prod->get_regular_price();
		?>
        
      <div class="range_slider"><b>A$ <span class="price_from"><?php echo $min?></span> </b><input id="price_range_filter" type="text" data-slider-min="<?php echo $min?>" data-slider-max="<?php echo $max?>" data-slider-step="1" data-slider-value="[<?php echo $min?>,<?php echo $max?>]"/><b>A$ <span class="price_to"><?php echo $max?></span></b></div> 
      
         <?php /*?><form role="form">
    <div class="checkbox">
      <input type="checkbox" class="price_range" value="0-200"><label>$0 - $200</label>
    </div>
    <div class="checkbox">
      <input type="checkbox" class="price_range" value="201-400"><label>$201 - $400</label>
    </div>
    <div class="checkbox">
      <input type="checkbox" class="price_range" value="401-600"><label>$401 - $600</label>
    </div>
    <div class="checkbox">
      <input type="checkbox" class="price_range" value="601-800"><label>$601 - $800</label>
    </div>
    <div class="checkbox">
      <input type="checkbox" class="price_range" value="801-1000"><label>$801 - $1000</label>
    </div>
     <div class="checkbox">
      <input type="checkbox" class="price_range" value="1000-999999"><label>$1000+</label>
    </div>
  </form><?php */?>

        </div>
      </div>
     
    </div>
  </div>
  </div>
    </div>
    <div class="clearfix"></div>
  <div class="cc-size-var-sec">
         <div class="panel-group cc-price-var" id="accordion-size">
      
      <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-price" href="#collapse_size">
          <span class="pull-left glyphicon glyphicon-chevron-up"></span>
         SIZE</a>
        
      </h4>
    </div>
    <div id="collapse_size" class="panel-collapse collapse in">
      <div class="panel-body">
        <div class="cc-price-var-items">
      
      
         <form role="form">
    <div class="checkbox">
      <input type="checkbox" class="size_option" value="set_length_runners"><label>Set Length Runners</label>
    </div>
    <div class="checkbox">
      <input type="checkbox" class="size_option" value="small"><label>Small</label>
    </div>
     <div class="checkbox">
     <input type="checkbox" class="size_option" value="medium"><label>Medium</label>
    </div>
    <div class="checkbox">
      <input type="checkbox" class="size_option" value="large"><label>Large</label>
    </div>
   
    <div class="checkbox">
      <input type="checkbox" class="size_option" value="very_large"><label>Very Large</label>
    </div>
     
  </form>

        </div>
      </div>
     
    </div>
  </div>
  </div>
    </div>

</div>

<script>

     $(document).ready(function() {

       $(document).on("click",'.swatch',function(){
                //$(this).find('img.cc-tick-display').toggle();
            });

         });
   

</script>