
    <div class="cc-product-sub-category-list">
    <?php 
    /**
    *shpw the sub-category list of the  product category
    */
    $term_id =  get_queried_object()->term_id;
   
    $prosubcats=get_terms(array('child'=>$term_id,'taxonomy'=>'product_cat'));?>
    
    <ul class="cc-pro-sub-cat-ul guide_list_cbg">
    
    <h3>Categories</h3>
    
    <?php 
    foreach($prosubcats as $psc)
    {
        $exclude_cat=get_terms(array('parent'=>$psc->term_id,'taxonomy'=>'product_cat'));

        if($psc->parent!=0 &&  count($exclude_cat)!=0){
        echo '<li><a href="'.get_category_link($psc->term_id).'">'.$psc->name.'<i class="fa fa-caret-right" aria-hidden="true"></i></a></li>';}
       
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
         Colour</a><a href="javascript:void(0);" class="pull-right">CLEAR</a>
        
      </h4>
    </div>
    <div id="collapse_color" class="panel-collapse collapse in">
      <div class="panel-body">
        <ul class="cc-color-var-item">
        
        <li id="cc-color-tick-id-<?php echo $c; ?>">
        <a href="javascript:void(0);" class="swatch" style="background:url('<?php echo get_template_directory_uri().'/images/purple.jpg';?>');" id="purple">
        <img src="<?php echo get_template_directory_uri().'/images/swatch_checked.png';?>" class="cc-tick-display" /></a>
        <label for="colour_purple">Purple</label>

        </li>
          <li>
        <a href="javascript:void(0);" class="swatch" style="background:url('<?php echo get_template_directory_uri().'/images/red.jpg';?>');" id="red"> <img src="<?php echo get_template_directory_uri().'/images/swatch_checked.png';?>" class="cc-tick-display" /></a>
      <label for="colour_red">Red</label>

        </li>
        
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
      
      
         <form role="form">
    <div class="checkbox">
      <input type="checkbox" value=""><label>$0 - $200</label>
    </div>
    <div class="checkbox">
      <input type="checkbox" value=""><label>$201 - $400</label>
    </div>
    <div class="checkbox">
      <input type="checkbox" value=""><label>$401 - $600</label>
    </div>
    <div class="checkbox">
      <input type="checkbox" value=""><label>$601 - $800</label>
    </div>
    <div class="checkbox">
      <input type="checkbox" value=""><label>$801 - $1000</label>
    </div>
     <div class="checkbox">
      <input type="checkbox" value=""><label>$1000+</label>
    </div>
  </form>

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
      <input type="checkbox" value=""><label>Set Length Runners</label>
    </div>
    <div class="checkbox">
      <input type="checkbox" value=""><label>Small</label>
    </div>
     <div class="checkbox">
     <input type="checkbox" value=""><label>Medium</label>
    </div>
    <div class="checkbox">
      <input type="checkbox" value=""><label>Large</label>
    </div>
   
    <div class="checkbox">
      <input type="checkbox" value=""><label>Very Large</label>
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
                $(this).find('img.cc-tick-display').toggle();
            });

         });
   

</script>