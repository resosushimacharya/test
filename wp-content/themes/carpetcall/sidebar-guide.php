<ul class="guide_list_cbg">
            
					<?php
                            $tax = 'guide'; 
						$tax_terms = get_terms($tax);
						
						foreach($tax_terms as $tax_term)
						{
						echo '<li><a href="'.get_term_link($tax_term).'">'.$tax_term->name.'<i class="fa fa-caret-right" aria-hidden="true"></i></li></a>';
						}

				?>
</ul>
<?php  

    /**
    *relate the category guide term to prodcut term
    */
   
    $sourcecat = get_queried_object();
    $cat_link = 'halt';
    if(get_term_by('slug',$sourcecat->slug,'product_cat')){
    $destinationcat=get_term_by('slug',$sourcecat->slug,'product_cat'); 
    $cat_link = get_category_link($destinationcat->term_id);
    }
     ?>
<div class="nowspe nowsppe"><a href="<?php echo (strcasecmp($cat_link,'halt')!=0)?$cat_link:'#'; ?>"> SHOP NOW </a></div>