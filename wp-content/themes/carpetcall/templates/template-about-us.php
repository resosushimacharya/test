<?php
/*
    Template Name: About Us Pages
*/
get_header();

/*
    * local and staging may have different IDs
    * get About Us page ID
    * need to show left navigation for About Us
*/
$url = site_url();
$url = explode('/',$url);
if( strcasecmp($url[2],'localhost')==0 ) { 
    $aboutID    = 317;
    $children   = array( 2314 , 2307 );
}
else { 
    $aboutID =317;
    $children   = array( 33774 , 33763 );
}

/*
    * code for : breadcrumb
        * find ancestors ( for sub pages )
        * if ancestors exist , build breadcrumb
        * else show single-level breadcrumb
*/
$id = get_the_id();
$ancestors = get_post_ancestors( $id );
//print_r( $ancestors );
//exit;
// reverse array to maintain correct ancestor order
$ancestors = array_reverse ( $ancestors );
$size      = count( $ancestors );

?>


<div class="child-innerpg">
    <div class="container clearfix">
        <div class="inerblock_serc_child about-page">
            <div class="cc-breadcrumb">
                <?php 
                    if( !empty( $ancestors ) ) {
                        for( $i=0; $i<=$size; $i++ ) {
                            $class = ( $i == 0 ) ? 'cc-bread-root' : 'cc-bread-parent';

                            if( $i == $size ) $class = 'cc-bread-current';

                            if( $i>0 ) echo ' > ' ;
                ?>
                    <span class="<?php echo $class; ?>">
                        <?php if ( $i == $size ) { echo get_the_title(); } 
                              else { 
                        ?>
                            <a href="<?php echo get_the_permalink( $ancestors[$i] );?>"><?php echo get_the_title( $ancestors[$i] );?> </a>
                        <?php } #end-else ?>
                    </span>
                <?php

                        } #end-for
                    } else {
                ?>                        
                    <span class="cc-bread-current"><?php the_title(); ?></span>
                <?php } #end-else ?>
            </div><!-- end .cc-breadcrumb -->
            <h1><?php the_title(); ?></h1>
        </div><!-- end .innerblock_serc_child -->
    </div><!-- end .container.clearfix -->
</div><!-- end .child-innerpg -->

<div class="faq-cont-blka">
    <div class="container clearfix">
        <div class="inerblock_sec">
            <div class="col-md-3 no-pl">
            <?php
                // show top-level navigation for About Us page
                if( $size == 1 || $aboutID == $id) {
            ?>
                <div class="meromm">
                    <ul class="guide_list_cbg">
                        <?php
                            $ancestor_id = (!empty( $ancestors )) ? $ancestors[0] : $id;
                            $all_about_pages = array(
                                'child_of'      => $ancestor_id,
                                #'include'      => $children,
                                'depth'         => 1,
                                'sort_column'   => 'menu_order',
                                'link_after'    => '<i class="fa fa-caret-right" aria-hidden="true"></i>',
                                'title_li'      => ''
                            );
                            wp_list_pages( $all_about_pages );
                        ?>                        
                    </ul><!-- end .guide_list_cbg -->
                </div><!-- end .meromm -->
            <?php } #end-if 

                // show inner-page navigation
                else {
            ?>
                <div class="meromm">
                    <ul class="guide_list_cbg">
                        <?php
                            $ancestor_id = (!empty( $ancestors )) ? $ancestors[$size-1] : $id;
                            $all_about_pages = array(
                                'child_of'  => $ancestor_id ,
                                'depth'     => 1,
                                'link_after'=> '<i class="fa fa-caret-right" aria-hidden="true"></i>',
                                'title_li'  => ''
                            );
                            wp_list_pages( $all_about_pages );
                        ?>                        
                    </ul><!-- end .guide_list_cbg -->
                </div><!-- end .meromm -->
            <?php } #end-if ?>
                <div class="clearfix"></div>
            </div><!-- end .col-md-3.no-pl -->

            <div class="col-md-9">
                <div class="cbg_content">
                <?php the_content();  ?>
                <?php if($size==1){

$args = array(
    'post_type'      => 'page',
    'posts_per_page' => -1,
    'post_parent'    => $id,
    'order'          => 'ASC',
    'orderby'        => 'menu_order'
 );
$loop = new WP_Query($args);


    while($loop->have_posts()){
        $loop->the_post();
        echo '<div class="cc-about-lat-wrapper">';
        echo  '<h2 class="sub_page_title">'.get_the_title().'</h2>';
        echo '<p>'.get_the_excerpt().'</p>';
        echo  '<div class="">';
        echo '<a class="btn-employment" href="'.get_permalink().'">Read More</a>';
        echo '</div>';
        echo '</div>';
    }
}
    ?>
                </div><!-- end .cbg_content -->
            </div><!-- end .col-md-9 -->

        </div><!--end .innerblock_sec -->
    </div><!-- end .container.clearfix -->
</div><!-- end .faq-cont-blka -->
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
   <!-- step three end here -->
   <?php  // echo do_shortcode('[best_selling_products per_page="3" columns="12" ]');?>
   
<?php get_footer(); ?>