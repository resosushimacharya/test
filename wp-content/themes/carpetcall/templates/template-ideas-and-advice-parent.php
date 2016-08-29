<?php 
/*
**Template Name: Ideas and Advice inner page
**
*/ get_header();
/**
  * Template tag for breadcrumbs.
  *
  * @param string $before  What to show before the breadcrum
  * @param string $after   What to show after the breadcrumb.
  * @param bool   $display Whether to display the breadcrumb (true) or return it (false).
  * @return string
  */
 $term_id_sub =  get_queried_object()->term_id;
 $term_name = get_queried_object()->name;
 global $post;
?>
 <div class="cbg_blk clearfix">
 <div class="container">
<div class="inerblock_serc">
					
 <div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
    <?php if(function_exists('bcn_display'))
    {
        bcn_display();
    }?>

</div>

<!-- <h1><a href="<?php echo get_permalink($post->post_parent);?>"><span class="ab_arrow"><i class="fa fa-angle-left" aria-hidden="true"></i></span><?php echo get_the_title();?>  </a></h1> -->
<h1>
<span class="ab_arrow">
            <a href="<?php echo get_permalink($post->post_parent);?>">
              <i class="fa fa-angle-left" aria-hidden="true"></i>            
              <b><?php  echo get_the_title($post->post_parent);;?></b>
            </a>
          </span><?php echo get_the_title();?>
          </h1>
</div>
</div>
</div>


 <div class="container clearfix">
	<div class="inerblock_sec">
		<div class="col-md-3 desktop no-pl">
       <ul class="guide_list_cbg">
            
<?php 


$roottitle = ' ';
$url = site_url();
$url = explode('/',$url);

if(strcasecmp($url[2],'localhost')==0)
{
 if($post->ID=='1690'){
 	$roottitle ="GUIDE";
 }
 if($post->ID=='1711'){
 	$roottitle ="CARE";
 }
 if($post->ID=='1725'){
 	$roottitle ="FAQ";
 }
}
else{
if($post->ID=='26696'){
 	$roottitle ="GUIDE";
 }
 if($post->ID=='26709'){
 	$roottitle ="CARE";
 }
 if($post->ID=='26721'){
 	$roottitle ="FAQ";
 }
}
$args = array(
    'post_type'      => 'page',
    'posts_per_page' => -1,
    'post_parent'    => $post->ID,
    'order'          => 'ASC',
    'orderby'        => 'menu_order'
 );


$parent = new WP_Query( $args );

while($parent->have_posts()){
    $parent->the_post();
    
     echo '<li><a href="'.get_the_permalink($post->ID).'">' . get_the_title($post->ID) .' '.$roottitle.' ' .'<i class="fa fa-caret-right" aria-hidden="true"></i></a></li>';
}
wp_reset_query();
 ?>
</ul>
            <div class="clearfix"></div>
		</div>
		<div class="col-md-9">
			<div class="cbg_content">
             <?php while(have_posts()){
             	the_post();
             	?>
           
             
             		<?php the_content();?>
             	
            <?php  }
            wp_reset_query();?>


             </div>
		</div>
</div>
</div>


<div class="container mobile cc-mobile-blk clearfix">
<div class="col-md-3 no-pl">
<div class="meromm">
			<?php get_sidebar('guide');?>
            </div>
      </div>      
</div>





    <script>
        jQuery(document).ready(function($) {
    $('ul.guide_list_cbg li a[href^="#"]').bind('click.smoothscroll',function (e) {
        e.preventDefault();
        var target = this.hash,
        $target = $(target);

        $('html, body').stop().animate( {
            'scrollTop': $target.offset().top - 185
        }, 900, 'swing', function () {
            window.location.hash = target;
        } );
    } );
} );

    </script>
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
<!-- dsahfl -->
