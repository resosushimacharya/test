<?php
/*
**Template Name: Ideas and Advice child page
**
*/
 get_header();
?>
<div class="child-innerpg">
<div class="container clearfix">
<div class="inerblock_serc_child">
<?php
//$parent_title = get_the_title($post->post_parent);
/*echo $parent_title;*/
?>
<?php if(empty( $post->post_parent)): ?>
<?php 
if(have_posts()):

    while(have_posts()):
      the_post();

       the_title();

       the_content();

    endwhile;


	else:
		echo "not found";


	endif;

?>
<?php else: ?>
	<?php get_template_part('templates/contents/content','second');?>
<?php endif;?>	
</div>
</div>
</div>
<div class="clearfix"></div>
   <div class="inerblock_sec_a">

    <div class="container clearfix you_may_link_cntr">
  
        <h3 style="text-align:center">YOU MAY ALSO LIKE</h3>
<div class="you_may_like-content">
       <?php


                    

                    
                    $reqTempTerms=get_terms('product_cat');
                   
                 
                    $i=1;
                    foreach($reqTempTerms as $cat){
                        //echo $cat->parent;
                        if($cat->parent==0){
                            $args = array(
       'hide_empty'         => 0,
       'orderby'            => 'id',
       'show_count'         => 0,
       'use_desc_for_title' => 0,
       'child_of'           => $cat->term_id
      );
      $terms = get_terms( 'product_cat', $args );
      
                      
                            
                       
                    shuffle($terms);
                        
                     $err = true;
                    foreach($terms as $term){

                            if($err){

                           
                 
                   
                            
                            $has_sub_cat=get_terms(array('parent'=>$term->term_id,'taxonomy'=>'product_cat'));
                            
                                if(count($has_sub_cat)==0){
                    
                                      
                                  
                                            
                                    $filargs = array(
                                                    'post_type'=>'product',
                                                    'posts_per_page'=>'1',
                                                    'meta_key'=>'_sale_price',
                                                    'orderby' => 'meta_value_num',
                                                     'order'     => 'ASC',
                                                    'tax_query' => array(
                                                                        array(
                                                                            'taxonomy' => 'product_cat',
                                                                            'field'    => 'term_id',
                                                                            'terms'    => $term->term_id,
                                                                        ),
                                                                    ),
                                                                
                                                    );
                                     
                                $filloop = new WP_Query($filargs);
                                 //do_action('pr',$filloop);
                                $hold = 1;

                                if($filloop->have_posts()){
                                   $i++;
                                   if($i>1){
                                    $err =false;
                                   }
                                    while($filloop->have_posts()):
                                        $filloop->the_post();

                                            
                                            $woo=get_post_meta($filloop->post->ID);
                    
                    $price=$woo['_regular_price'][0];
                    
                    
                    $feat_image = wp_get_attachment_url( get_post_thumbnail_id($filloop->post->ID) );


                                    ?> <div class="col-md-4">
                        <div class="pro_secone">
                        <a href="<?php the_permalink();?>" class="cc-product-item-image-link"><div class="img_cntr" style="background-image:url('<?php echo $feat_image; ?>');"></div></a>
                  
                    <!--img src="<?php echo $feat_image; ?>" alt="<?php the_title();?>" class="img-responsive"/-->
                    <div class="mero_itemss">
                            <div class="proabtxt">
                     <a href="<?php the_permalink();?>" class="cc-product-item-title-link"><h4>
                    <?php echo $term->name;?>
                    </h4></a><?php 

                    $reqTempTerms=get_the_terms($filloop->post->ID,'product_cat');
                    

                    

                    
                    if(!empty($price)){
                        echo '<h6> FROM A$'.$price.'</h6>';
                        
                        }?></div>
                    <div class="clearfix"></div>
                           
                      </div>
                      </div></a>
                      </div>
                                <?php endwhile;?>
                            <?php 
                            wp_reset_query(); 
                           
                        }
                          
                          }
                            
                                }
                                else{
                                    break;
                                }
                     
                    }
                }
                    
                    }
                  
 ?></div>
                             
</div>
<div class="clearfix"></div>
                    
                    
    </div>
 <script>
        jQuery(document).ready(function($) {
    $('ul.guide_list_cbg li a[href^="#"]').bind('click.smoothscroll',function (e) {
        e.preventDefault();
        var target = this.hash,
        $target = $(target);

        $('html, body').stop().animate( {
            'scrollTop': $target.offset().top - 190
        }, 900, 'swing', function () {
            window.location.hash = target;
        });
    });
});</script>
 <?php get_footer();?>