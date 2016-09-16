<?php
/* Template Name: ideas and advice*/
get_header();
global $post;

/* ideas and advice child id declaration */
$url = site_url();
$url =explode('/',$url);

if(strcasecmp($url[2],'localhost')==0){
  $bgID = 1690;
  $proID = 1711; 
  $faqID = 1725;
}
else{
  $bgID = 26696;
  $proID = 26709; 
  $faqID = 26721;
}

$feat_image = cc_custom_get_feat_img($post->ID,'medium');
//$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );


?>
<div class="body-wrapper">
<div class="ia-block clearfix">
<div class="container">
        <div class="col-md-6 no-pl cc-ia-content">
        <h4><?php the_title();?></h4>
        <h1><?php the_title();?> </h1>
        <p><?php echo $post->post_content;?> </p>
        </div>
        <div class="col-md-6 ia-img">
         <div class="cc-ia-banner" style="background-image: url(<?php echo $feat_image ;?>);">  
         </div>
        </div>
</div>
</div><!-- uppper section end here -->


<div class="gpf-block clearfix">
<div class="container">
<div class="row cc-ia-item-cover">
<?php
$iadata = get_field('ideas_and_advice_page_fields');

function order_of_ideas_and_advice_function($a, $b) {
    return $a['order_of_ideas_and_advice'] - $b['order_of_ideas_and_advice'];
}
usort($iadata, 'order_of_ideas_and_advice_function');
/*do_action('pr',$iadata);*/
foreach($iadata as $iad){?>
    <?php if(strcasecmp($iad['category'],'More')==0):?>
  <div class="col-md-6 cc-ia-item cc-ia-more">
    <div class="all-items-blk">
    <h3><?php echo $iad['title'];?></h3>
    <?php echo $iad['description'];?>
        </div>
  </div>
    <?php 
    /**
    *reading the category
    *relating with our category such as guide,faq and product care  
    *it must include in else section(exlusion of More category)
    */
    $descats=get_terms(array('slug'=>$iad['category'],'taxonomy'=>'product_cat'));
    
    ?><?php elseif(strcasecmp($iad['category'],'Buying Guides')==0):?>
       <div class="col-md-6 cc-ia-item">
       <div class="all-items-blk">
    <a href="<?php echo get_the_permalink($bgID);?>"><h3><?php echo $iad['title'];?></h3></a>
    <p><?php echo $iad['description'];?></p>
      <ul class="cat_list"><?php  $args = array(
    'post_type'      => 'page',
    'posts_per_page' => -1,
    'post_parent'    => $bgID,
    'order'          => 'ASC',
    'orderby'        => 'menu_order'
 );


$parent = new WP_Query( $args );
while($parent->have_posts()){
    $parent->the_post();
    
     echo '<li><i class="fa fa-caret-right" aria-hidden="true"></i> &nbsp;<a href="'.get_the_permalink($post->ID).'">' . get_the_title($post->ID). '</a></li>';
}
wp_reset_query();?>
</ul><div class="clearfix"></div>
</div>
</div>
    <?php elseif(strcasecmp($iad['category'],'Product Care')==0):
      $tax = 'product_care';

   
    $res_tax=strtolower($tax);
     $tax_terms = get_terms($res_tax);?>
     <div class="col-md-6 cc-ia-item">
     <div class="all-items-blk">
    <a href="<?php echo get_the_permalink($proID);?>"><h3><?php echo $iad['title'];?></h3></a>
    <p><?php echo $iad['description'];?></p>

            <ul class="cat_list">
            <?php  $args = array(
    'post_type'      => 'page',
    'posts_per_page' => -1,
    'post_parent'    => $proID,
    'order'          => 'ASC',
    'orderby'        => 'menu_order'
 );


$parent = new WP_Query( $args );
while($parent->have_posts()){
    $parent->the_post();
    
     echo '<li><i class="fa fa-caret-right" aria-hidden="true"></i> &nbsp;<a href="'.get_the_permalink($post->ID).'">' . get_the_title($post->ID). '</a></li>';
}
wp_reset_query();?>
            </ul>
  </div>
    </div>
     <?php 
    
    else:
   
    $tax = explode("'",$iad['category']);

   
    $res_tax=strtolower($tax[0]);
     $tax_terms = get_terms($res_tax);

    
    ?>
   
    <div class="col-md-6 cc-ia-item">
    <div class="all-items-blk">
    <a href="<?php echo get_the_permalink($faqID);?>"><h3><?php echo $iad['title'];?></h3></a>
    <p><?php echo $iad['description'];?></p>
      
            
            
            <ul class="cat_list">
            <?php
                          
            
            $args = array(
    'post_type'      => 'page',
    'posts_per_page' => -1,
    'post_parent'    => $faqID,
    'order'          => 'ASC',
    'orderby'        => 'menu_order'
 );


$parent = new WP_Query( $args );
while($parent->have_posts()){
    $parent->the_post();
    
     echo '<li><i class="fa fa-caret-right" aria-hidden="true"></i> &nbsp;<a href="'.get_the_permalink($post->ID).'">' . get_the_title($post->ID). '</a></li>';
}
wp_reset_query();
        ?>
            </ul>
            
            </div>
  </div>
<?php 
endif;
}
 ?>

</div>
</div>
</div>
</div>


<script>
  $(".cc-ia-more ul li ").append('<i class="fa fa-caret-right" aria-hidden="true"></i>');
</script>
<div class="inerblock_sec_a">

    <div class="container clearfix you_may_link_cntr">
  
        <h3 style="text-align:center">YOU MAY ALSO LIKE</h3>
<div class="you_may_like-content">
       <?php


                    

                    
                    //$reqTempTerms=get_terms('product_cat');
          //do_action('pr',$accessories_term);
          $accessories_term = get_term_by('slug','accessories','product_cat');
                    $reqTempTerms = get_terms( array(
                'taxonomy' => 'product_cat',
                'hide_empty' => true,
                'exclude' =>$accessories_term->term_id
                )
               );
                 
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
                    
                    
                    //$feat_image = wp_get_attachment_url( get_post_thumbnail_id($filloop->post->ID) );
          $feat_image = cc_custom_get_feat_img($filloop->post->ID,'medium');

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
                        echo '<h6> FROM $'.$price.'</h6>';
                        
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
<?php 
get_footer();
?>