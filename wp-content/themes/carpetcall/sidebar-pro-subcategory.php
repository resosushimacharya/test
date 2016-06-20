<div class="row">
    <div class="cc-product-sub-category-list">
    <?php 
    /**
    *shpw the sub-category list of the  product category
    */
    $term_id =  get_queried_object()->term_id;
   
    $prosubcats=get_terms(array('child'=>$term_id,'taxonomy'=>'product_cat'));?>
    <h3>Categories</h3>
    <ul class="cc-pro-sub-cat-ul">
    <?php 
    foreach($prosubcats as $psc)
    {
        $exclude_cat=get_terms(array('parent'=>$psc->term_id,'taxonomy'=>'product_cat'));

        if($psc->parent!=0 &&  count($exclude_cat)!=0){
        echo '<li><a href="'.get_category_link($psc->term_id).'">'.$psc->name.'<i class="fa fa-caret-right" aria-hidden="true"></i></a></li>';}
       
       } ?>
    </ul>
    
   
    </div>
</div>