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

$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );


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
         <div class="cc-ia-banner">
          <img src="<?php echo $feat_image;?>" class="img-responsive">


      
         	
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
    <div class="more-blk-b">
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
    <h3><?php echo $iad['title'];?></h3>
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
    
     echo '<li><i class="fa fa-caret-right" aria-hidden="true"></i> &nbsp; <a href="'.get_the_permalink($post->ID).'">' . get_the_title($post->ID). '</a></li>';
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
		<h3><?php echo $iad['title'];?></h3>
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
    <div class="fq-blk-a">
		<h3><?php echo $iad['title'];?></h3>
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
  <div class="inerblock_sec_a">

    <div class="container clearfix you_may_link_cntr">
        <h3 style="text-align:center">YOU MAY ALSO LIKE</h3>



<?php
$tax = 'product_cat';
 ?><?php
            $tax_terms = get_terms($tax);

           $args=array(
          'post_type' => 'product',
          
          'post_status' => 'publish',
          'posts_per_page' => 3,
          'ignore_sticky_posts'=> 1
          );
          //echo $tax_term->slug;
          $my_query = null;
          $my_query = new WP_Query($args);
          while ($my_query->have_posts()) : $my_query->the_post();
          $woo=get_post_meta($post->ID);
          
          $price=$woo['_regular_price'][0];
          
          
          $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
          
          /*if(!empty(unserialize($woo['_product_attributes'][0])))
        $prounits=unserialize($woo['_product_attributes'][0]);*/
        
        if(isset($prounits['size']['value'])){
          $prounit=$prounits['size']['value'];
        }
               ?>
                    
                   <div class="col-md-4">
                      <div class="pro_secone">
                      <div class="img_cntr" style="background-image:url('<?php echo $feat_image; ?>');"></div>
                  
                    <!--img src="<?php echo $feat_image; ?>" alt="<?php the_title();?>" class="img-responsive"/-->
                    <div class="mero_itemss">
                          <div class="proabtxt">
          <h4><?php
          the_title();?></h4><?php 

          $reqTempTerms=get_the_terms($post->ID,'product_cat');
          

          

          
          if(!empty($price)){
            echo '<h5> FROM A$'.$price.'</h5>';
            
            }?></div>
          <div class="clearfix"></div>
                           
                      </div>
                      </div>
                      </div>
                      
          
               <?php

          endwhile;
          wp_reset_query();
          ?><div class="clearfix"></div>
          
                    
    </div>
    </div>
<style>
.body-wrapper{
		margin:145px 0 38px 0;
}
ul.cat_list { margin:0 0 29px 0; padding:0;}
ul.cat_list li {list-style:none; display:block;}
ul.cat_list li .fa { color:#c32327;}
ul.cat_list li a {font:normal 16px/24px 'proxima_nova_rgregular', sans-serif; color:#15489f; text-decoration:none;}
ul.cat_list li a:hover {color:#000;}

.cc-ia-more ul { margin:0 0 29px 0; padding:0;}
.cc-ia-more ul li {list-style:none; display:block;}
.cc-ia-more ul li .fa { color:#c32327; margin-right:12px; margin-top:3px;}
.cc-ia-more ul li a {font:normal 16px/24px 'proxima_nova_rgregular', sans-serif; color:#15489f; text-decoration:none;}
.cc-ia-more ul li a:hover {color:#000;}

.cc-ia-item ul{
	list-style:none;
	display:block;
}
.cc-ia-more ul,.cc-ia-more ul li{
	text-decoration:none;
}

.cc-ia-more ul li i{
	float:left;
}


</style>
<script>
  $(".cc-ia-more ul li ").append('<i class="fa fa-caret-right" aria-hidden="true"></i>');
</script>

<?php 
get_footer();
?>